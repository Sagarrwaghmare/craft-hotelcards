<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('do_custom_upload')) {
    function do_custom_upload($upload_path = './assets/', $field_name = 'photo', $file_name = "image")
    {
        // Get the CodeIgniter instance
        $CI = &get_instance();

        // Configure the upload library
        $config['upload_path']      = $upload_path;
        $config['allowed_types']    = 'gif|jpg|png|jpeg';
        // $config['max_size']         = 2048; // 2MB
        // $config['max_width']        = 1024;
        // $config['max_height']       = 768;
        // $config['encrypt_name']     = TRUE;
        $config['overwrite'] = TRUE;
        $config['file_name'] = $file_name ;


        // Load the upload library and initialize with the config
        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);


        // Perform the upload
        if (! $CI->upload->do_upload($field_name)) {
            $error = array('error' => $CI->upload->display_errors());
            return $error;
        } else {
            $data = $CI->upload->data();
            return $data;
        }
    }
}





if (! function_exists('delete_image')) {
    function delete_image($file_path, $file_name_with_extension)
    {
        // First, check if a valid filename was provided.
        if (empty($file_name_with_extension)) {
            return FALSE;
        }

        // Construct the full path to the file
        $full_file_path = $file_path . $file_name_with_extension;

        // Check if the file exists and is actually a file (not a directory)
        if (file_exists($full_file_path) && is_file($full_file_path)) {
            // Attempt to delete the file using PHP's unlink() function
            if (unlink($full_file_path)) {
                // File was deleted successfully
                return TRUE;
            } else {
                // Deletion failed (e.g., due to file permissions)
                return FALSE;
            }
        } else {
            // File does not exist at the specified path
            return FALSE;
        }
    }
}