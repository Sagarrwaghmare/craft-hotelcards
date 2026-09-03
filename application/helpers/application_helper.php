<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('application_isactive')) {
    /**
     * Checks if the application is active using a cached, fault-tolerant approach.
     * Business Logic: If the remote config is missing or deleted, the app is considered ACTIVE.
     *
     * @return bool Returns true if the application is active, false otherwise.
     */
    function application_isactive()
    {
        $CI = &get_instance();
        $CI->load->model("Config_Model");

        // 1. Fetch the last known status from the local database
        $config_data = $CI->Config_Model->get_by_id(1);

        if (empty($config_data)) {
            log_message('error', 'Application status check failed: Config row missing from local DB.');
            return false;
        }

        $app_name = $config_data[0]['appName'];
        $is_active_from_db = (bool)$config_data[0]['isActive'];
        $last_checked_at = $config_data[0]['lastChecked'];

        // 2. If the cache is still valid, return the DB value immediately.
        if (time() < strtotime($last_checked_at)) {
            return $is_active_from_db;
        }

        // 3. Cache has expired, so perform the remote check.
        log_message('info', 'Application status cache expired. Performing remote check.');
        $remote_config_url = "https://sagarrwaghmare.github.io/app-config/status.json";
        
        $response = @file_get_contents($remote_config_url);

        // --- SCENARIO A: NETWORK FAILURE (URL is down or file deleted) ---
        if ($response === false) {
            log_message('error', 'Remote status check failed: URL is unreachable or file deleted. Retrying in 1 hour.');
            // Schedule a retry for 1 hour from now to handle temporary outages.
            $CI->Config_Model->update(1, ["lastChecked" => date('Y-m-d H:i:s', strtotime('+1 hour'))]);
            // IMPORTANT: Return the last known status during a network failure.
            return $is_active_from_db;
        }

        $all_configs = json_decode($response, true);
        
        // --- SCENARIO B: JSON IS INVALID ---
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Remote status check failed: Could not parse JSON. Retrying in 1 hour.');
            $CI->Config_Model->update(1, ["lastChecked" => date('Y-m-d H:i:s', strtotime('+1 hour'))]);
            return $is_active_from_db;
        }

        $indexed_configs = array_column($all_configs, null, 'app');

        // --- SCENARIO C: CONFIG OBJECT IS MISSING (YOUR GOAL) ---
        if (!isset($indexed_configs[$app_name])) {
            log_message('info', "Remote config for '{$app_name}' not found. Assuming ACTIVE status as per business rules.");
            // This is your "payment received" signal. The app becomes active.
            $update_data = [
                "isActive" => true,
                "lastChecked" => date('Y-m-d H:i:s', strtotime('+7 days'))
            ];
            $CI->Config_Model->update(1, $update_data);
            return true; // The app is now active.
        }

        // --- SCENARIO D: CONFIG IS FOUND (NORMAL OPERATION) ---
        $remote_value = $indexed_configs[$app_name];
        $new_status = (bool)$remote_value['active'];
        
        $update_data = [
            "isActive" => $new_status,
            "lastChecked" => date('Y-m-d H:i:s', strtotime('+7 days'))
        ];
        $CI->Config_Model->update(1, $update_data);
        
        return $new_status;
    }
}