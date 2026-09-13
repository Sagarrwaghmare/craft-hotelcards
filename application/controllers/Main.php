
<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        // Route Guard: Require login for all dashboard access
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please log in to access the system.');
            redirect('auth');
        }
    }

    private function _require_admin()
    {
        $role = strtolower(trim((string)$this->session->userdata('access')));
        if ($role !== 'admin') {
            $this->session->set_flashdata('error', 'Access denied: You do not have administrator permissions.');
            redirect('main');
            exit;
        }
    }

    public function view($member_id)
    {
        $this->load->model('Member_model');
        $this->load->model('Visit_model');

        $data['member']  = $this->Member_model->get_by_id($member_id);
        $data['visits']  = $this->Visit_model->get_by_member_id($member_id);
        $data['summary'] = $this->Visit_model->get_member_summary($member_id);

        if (empty($data['member'])) {
            show_404();
        }

        redirect('main/member_details/' . $member_id);
    }

    public function index($page_view = null, $data = [])
    {
        $this->members();
    }

    public function add_user()
    {
        $this->_require_admin();

        $data['title']       = 'Add User';
        $data['active_menu'] = 'add_user';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);

        if (file_exists(APPPATH . 'views/pages/add.php')) {
            $this->load->view('pages/add', $data);
        } else {
            $this->load->view('templates/add', $data);
        }

        $this->load->view('templates/footer', $data);
    }

    public function save_user()
    {
        $this->_require_admin();

        $this->load->model('User_model');

        $name       = trim((string)$this->input->post('name', TRUE));
        $username   = trim((string)$this->input->post('username', TRUE));
        $email      = trim((string)$this->input->post('email', TRUE));
        $contact_no = trim((string)$this->input->post('contact_no', TRUE));
        $password   = $this->input->post('password', TRUE);
        $access     = ucfirst(strtolower(trim((string)$this->input->post('access', TRUE))));

        if (empty($name) || empty($username) || empty($email) || empty($password) || empty($access)) {
            $this->session->set_flashdata('error', 'Please fill in all mandatory fields.');
            redirect('main/add_user');
            return;
        }

        if (!in_array($access, ['Admin', 'Editor', 'Viewer'])) {
            $access = 'Viewer';
        }

        if ($this->User_model->get_by_username($username)) {
            $this->session->set_flashdata('error', "Username '{$username}' is already taken.");
            redirect('main/add_user');
            return;
        }

        if ($this->User_model->get_by_email($email)) {
            $this->session->set_flashdata('error', "Email '{$email}' is already registered.");
            redirect('main/add_user');
            return;
        }

        $user_data = [
            'name'          => $name,
            'username'      => $username,
            'email'         => $email,
            'contact_no'    => !empty($contact_no) ? $contact_no : null,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'access'        => $access
        ];

        $new_user_id = $this->User_model->add($user_data);

        if ($new_user_id) {
            $this->session->set_flashdata('success', "User '{$name}' created successfully!");
            redirect('main/users');
        } else {
            $this->session->set_flashdata('error', 'Database error: Failed to create user.');
            redirect('main/add_user');
        }
    }

    public function add_member($id = null)
    {
        $this->load->model('Member_model');

        $data['title']       = $id ? 'Edit Member' : 'Add Member';
        $data['active_menu'] = 'add_member';
        $data['member']      = $id ? $this->Member_model->get_by_id($id) : null;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/add_member', $data);
        $this->load->view('templates/footer', $data);
    }

    public function save_member($id = null)
    {
        $role = strtolower(trim((string)$this->session->userdata('access')));
        if ($role === 'viewer') {
            $this->session->set_flashdata('error', 'Viewers cannot add or modify members.');
            redirect('main/members_list');
            return;
        }

        $this->load->model('Member_model');

        $card_type   = $this->input->post('card_type', TRUE);
        $card_prefix = $this->input->post('card_prefix', TRUE);
        $card_year   = $this->input->post('card_year', TRUE) ?: date('Y');
        $card_suffix = trim((string)$this->input->post('card_suffix', TRUE));

        $full_card_number = "{$card_prefix}-{$card_year}-{$card_suffix}";

        $existing = $this->Member_model->get_by_card_number($full_card_number);
        if ($existing && (!$id || $existing['id'] != $id)) {
            $this->session->set_flashdata('error', "Card Number '{$full_card_number}' is already registered to another member.");
            redirect('main/add_member' . ($id ? '/' . $id : ''));
            return;
        }

        $dob         = $this->input->post('dob', TRUE);
        $marital     = $this->input->post('marital_status', TRUE);
        $anniversary = ($marital === 'Married') ? $this->input->post('anniversary', TRUE) : null;

        $member_data = [
            'card_number'    => $full_card_number,
            'card_type'      => $card_type,
            'first_name'     => trim((string)$this->input->post('first_name', TRUE)),
            'last_name'      => trim((string)$this->input->post('last_name', TRUE)),
            'company_name'   => trim((string)$this->input->post('company_name', TRUE)) ?: null,
            'designation'    => trim((string)$this->input->post('designation', TRUE)) ?: null,
            'contact_no'     => trim((string)$this->input->post('contact_no', TRUE)) ?: null,
            'email'          => trim((string)$this->input->post('email', TRUE)) ?: null,
            'address'        => trim((string)$this->input->post('address', TRUE)) ?: null,
            'dob'            => !empty($dob) ? $dob : null,
            'marital_status' => !empty($marital) ? $marital : 'Single',
            'anniversary'    => !empty($anniversary) ? $anniversary : null,
            'notes'          => trim((string)$this->input->post('notes', TRUE)) ?: null,
        ];

        if ($id) {
            $this->Member_model->update($id, $member_data);
            $this->session->set_flashdata('success', 'Member details updated successfully!');
            redirect('main/member_details/' . $id);
        } else {
            $new_id = $this->Member_model->add($member_data);
            if ($new_id) {
                $this->session->set_flashdata('success', 'New member registered successfully!');
                redirect('main/member_details/' . $new_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to register member.');
                redirect('main/add_member');
            }
        }
    }

    public function bulk_update_members()
    {
        $role = strtolower(trim((string)$this->session->userdata('access')));
        if ($role === 'viewer') {
            $this->session->set_flashdata('error', 'Viewers cannot modify member records.');
            redirect('main/members_list');
            return;
        }

        $this->load->model('Member_model');

        $ids_string = $this->input->post('bulk_member_ids', TRUE);
        $ids = array_filter(array_map('intval', explode(',', $ids_string)));

        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No members were selected for bulk update.');
            redirect('main/members_list');
            return;
        }

        $update_data = [];

        $card_type = $this->input->post('bulk_card_type', TRUE);
        if (!empty($card_type) && in_array($card_type, ['Gold', 'Platinum'])) {
            $update_data['card_type'] = $card_type;
        }

        $company_name = trim((string)$this->input->post('bulk_company_name', TRUE));
        if ($this->input->post('apply_company', TRUE) === '1') {
            $update_data['company_name'] = !empty($company_name) ? $company_name : null;
        }

        $designation = trim((string)$this->input->post('bulk_designation', TRUE));
        if ($this->input->post('apply_designation', TRUE) === '1') {
            $update_data['designation'] = !empty($designation) ? $designation : null;
        }

        $marital_status = $this->input->post('bulk_marital_status', TRUE);
        if (!empty($marital_status) && in_array($marital_status, ['Single', 'Married', 'Divorced', 'Widowed', 'Other'])) {
            $update_data['marital_status'] = $marital_status;
        }

        $notes = trim((string)$this->input->post('bulk_notes', TRUE));
        if ($this->input->post('apply_notes', TRUE) === '1') {
            $update_data['notes'] = !empty($notes) ? $notes : null;
        }

        if (empty($update_data)) {
            $this->session->set_flashdata('error', 'No change options were selected for the bulk update.');
            redirect('main/members_list');
            return;
        }

        $this->Member_model->update_batch_fields($ids, $update_data);
        $this->session->set_flashdata('success', count($ids) . ' member(s) updated successfully.');

        redirect('main/members_list');
    }

    public function delete_members()
    {
        $this->_require_admin();

        $this->load->model('Member_model');

        $selected_ids = $this->input->post('selected_members');

        if (!empty($selected_ids) && is_array($selected_ids)) {
            $sanitized_ids = array_map('intval', $selected_ids);
            $deleted = $this->Member_model->delete_batch_ids($sanitized_ids);

            if ($deleted) {
                $this->session->set_flashdata('success', count($sanitized_ids) . ' member(s) deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete selected members.');
            }
        } else {
            $this->session->set_flashdata('error', 'No members were selected for deletion.');
        }

        redirect('main/members_list');
    }

    public function members()
    {
        $this->load->model('Member_model');

        $data['title']          = 'Membership & Events Overview';
        $data['active_menu']    = 'members';
        $data['gold_count']     = $this->Member_model->count_by_type('Gold');
        $data['platinum_count'] = $this->Member_model->count_by_type('Platinum');
        $data['events']         = $this->Member_model->get_upcoming_events(50); // Fetch top upcoming events

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/display_members', $data);
        $this->load->view('templates/footer', $data);
    }

    public function members_list()
    {
        $this->load->model('Member_model');

        $data['title']       = 'Members Directory';
        $data['active_menu'] = 'members_list';

        $filters = [
            'search'     => trim((string)$this->input->get('search', TRUE)),
            'type'       => trim((string)$this->input->get('type', TRUE)),
            'dob_from'   => trim((string)$this->input->get('dob_from', TRUE)),
            'dob_to'     => trim((string)$this->input->get('dob_to', TRUE)),
            'anniv_from' => trim((string)$this->input->get('anniv_from', TRUE)),
            'anniv_to'   => trim((string)$this->input->get('anniv_to', TRUE)),
        ];

        $total_rows   = $this->Member_model->count_filtered_members($filters);

        // Default pagination: 10 rows per page
        $per_page     = 10;
        $current_page = max(1, (int)$this->input->get('page'));
        $offset       = ($current_page - 1) * $per_page;

        $data['members']      = $this->Member_model->get_filtered_members($filters, $per_page, $offset);
        $data['total_count']  = $total_rows;
        $data['current_page'] = $current_page;
        $data['per_page']     = $per_page;
        $data['total_pages']  = max(1, ceil($total_rows / $per_page));
        $data['filters']      = $filters;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/members_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function export_members_csv()
    {
        $this->load->model('Member_model');

        $filters = [
            'search'     => trim((string)$this->input->get('search', TRUE)),
            'type'       => trim((string)$this->input->get('type', TRUE)),
            'dob_from'   => trim((string)$this->input->get('dob_from', TRUE)),
            'dob_to'     => trim((string)$this->input->get('dob_to', TRUE)),
            'anniv_from' => trim((string)$this->input->get('anniv_from', TRUE)),
            'anniv_to'   => trim((string)$this->input->get('anniv_to', TRUE)),
        ];

        $members = $this->Member_model->get_filtered_members($filters);

        $filename = 'members_export_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        fputcsv($output, [
            'Sr.No',
            'Card Number',
            'Card Type',
            'First Name',
            'Last Name',
            'Company',
            'Designation',
            'Contact No',
            'Email',
            'Address',
            'DOB',
            'Anniversary',
            'Marital Status',
            'Created At'
        ]);

        $sr = 1;
        foreach ($members as $m) {
            fputcsv($output, [
                $sr++,
                $m['card_number'],
                $m['card_type'],
                $m['first_name'],
                $m['last_name'],
                $m['company_name'] ?? '',
                $m['designation'] ?? '',
                $m['contact_no'] ?? '',
                $m['email'] ?? '',
                $m['address'] ?? '',
                !empty($m['dob']) ? date('d-M-Y', strtotime($m['dob'])) : '',
                !empty($m['anniversary']) ? date('d-M-Y', strtotime($m['anniversary'])) : '',
                $m['marital_status'] ?? '',
                $m['created_at'] ?? ''
            ]);
        }

        fclose($output);
        exit;
    }

    // User Management (10 records per page)
    public function users()
    {
        $this->_require_admin();

        $this->load->model('User_model');

        $data['title']       = 'User Management';
        $data['active_menu'] = 'users';

        $total_rows   = $this->User_model->count_all();
        $per_page     = 10; // Default: 10 users per page
        $current_page = max(1, (int)$this->input->get('page'));
        $offset       = ($current_page - 1) * $per_page;

        $data['users']        = $this->User_model->get_paginated($per_page, $offset);
        $data['total_count']  = $total_rows;
        $data['current_page'] = $current_page;
        $data['per_page']     = $per_page;
        $data['total_pages']  = max(1, ceil($total_rows / $per_page));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/users_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update_user()
    {
        $this->_require_admin();

        $this->load->model('User_model');

        $user_id = (int)$this->input->post('user_id', TRUE);
        if (empty($user_id)) {
            $this->session->set_flashdata('error', 'Invalid user ID.');
            redirect('main/users');
        }

        $email    = trim((string)$this->input->post('email', TRUE));
        $username = trim((string)$this->input->post('username', TRUE));

        $existingEmail = $this->User_model->get_by_email($email);
        if ($existingEmail && $existingEmail['id'] != $user_id) {
            $this->session->set_flashdata('error', "Email '{$email}' is already in use by another user.");
            redirect('main/users');
        }

        $existingUsername = $this->User_model->get_by_username($username);
        if ($existingUsername && $existingUsername['id'] != $user_id) {
            $this->session->set_flashdata('error', "Username '{$username}' is already taken.");
            redirect('main/users');
        }

        $update_data = [
            'name'       => trim((string)$this->input->post('name', TRUE)),
            'email'      => $email,
            'username'   => $username,
            'contact_no' => trim((string)$this->input->post('contact_no', TRUE)) ?: null,
            'access'     => ucfirst(strtolower(trim((string)$this->input->post('access', TRUE)))),
        ];

        $password = $this->input->post('password', TRUE);
        if (!empty($password)) {
            $update_data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->User_model->update($user_id, $update_data);
        $this->session->set_flashdata('success', "User '{$update_data['name']}' updated successfully!");

        redirect('main/users');
    }

    public function delete_users()
    {
        $this->_require_admin();

        $this->load->model('User_model');

        $selected_ids = $this->input->post('selected_users');

        if (!empty($selected_ids) && is_array($selected_ids)) {
            $sanitized_ids = array_map('intval', $selected_ids);
            $deleted = $this->User_model->delete_batch_ids($sanitized_ids);

            if ($deleted) {
                $this->session->set_flashdata('success', count($sanitized_ids) . ' user(s) removed successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete selected users.');
            }
        } else {
            $this->session->set_flashdata('error', 'No users were selected for deletion.');
        }

        redirect('main/users');
    }

    // Member Details (With 10 visits per page pagination)
    public function member_details($member_id = null)
    {
        if (empty($member_id)) {
            redirect('main/members_list');
        }

        $this->load->model('Member_model');
        $this->load->model('Visit_model');

        $data['title']       = 'Member Details';
        $data['active_menu'] = 'members_list';

        $data['member']      = $this->Member_model->get_by_id($member_id);
        if (empty($data['member'])) {
            show_404();
        }

        // Paginate visits: 10 records per page
        $v_per_page   = 10;
        $v_page       = max(1, (int)$this->input->get('vpage'));
        $v_offset     = ($v_page - 1) * $v_per_page;
        $total_visits = $this->Visit_model->count_by_member_id($member_id);

        $data['visits']         = $this->Visit_model->get_by_member_id($member_id, $v_per_page, $v_offset);
        $data['total_visits']   = $total_visits;
        $data['v_current_page'] = $v_page;
        $data['v_per_page']     = $v_per_page;
        $data['v_total_pages']  = max(1, ceil($total_visits / $v_per_page));
        $data['summary']        = $this->Visit_model->get_member_summary($member_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/member_details', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add_visit()
    {
        $role = strtolower(trim((string)$this->session->userdata('access')));
        if ($role === 'viewer') {
            $this->session->set_flashdata('error', 'Viewers cannot add visits.');
            redirect('main/members_list');
            return;
        }

        $member_id  = (int)$this->input->post('member_id', TRUE);
        $visit_date = $this->input->post('visit_date', TRUE);
        $raw_pax    = (int)($this->input->post('no_of_pax', TRUE) ?: $this->input->post('pax', TRUE));
        $raw_apc    = (float)$this->input->post('apc', TRUE);

        if (empty($member_id) || empty($visit_date)) {
            $this->session->set_flashdata('error', 'Visit date and member are required.');
            redirect('main/members_list');
        }

        $pax = max(1, min(25, $raw_pax));
        $apc = max(0.00, $raw_apc);

        $this->load->model('Visit_model');

        $logged_user_id = $this->session->userdata('user_id') ?? null;

        $visit_data = [
            'member_id'  => $member_id,
            'visit_date' => $visit_date,
            'no_of_pax'  => $pax,
            'apc'        => number_format($apc, 2, '.', ''),
            'created_by' => $logged_user_id,
        ];

        $inserted = $this->Visit_model->add($visit_data);

        if ($inserted) {
            $this->session->set_flashdata('success', 'Visit details added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to save visit details.');
        }

        redirect('main/member_details/' . $member_id);
    }

    public function profile()
    {
        $this->load->model('User_model');

        $data['title']       = 'My Profile';
        $data['active_menu'] = 'profile';

        $current_id = (int)$this->session->userdata('user_id');
        $db_user    = $current_id ? $this->User_model->get_by_id($current_id) : null;

        $data['user'] = $db_user ?: [
            'id'         => $current_id,
            'name'       => $this->session->userdata('name') ?? 'User',
            'email'      => $this->session->userdata('email') ?? '',
            'contact_no' => $this->session->userdata('contact_no') ?? '',
            'username'   => $this->session->userdata('username') ?? '',
            'access'     => $this->session->userdata('access') ?? 'Viewer'
        ];

        $data['is_admin'] = (strtolower($data['user']['access']) === 'admin');

        if (!isset($data['user']['password'])) {
            $data['user']['password'] = '••••••••••••';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/profile', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update_profile()
    {
        $this->load->model('User_model');

        $user_id    = (int)$this->session->userdata('user_id');
        $name       = trim((string)$this->input->post('name', TRUE));
        $email      = trim((string)$this->input->post('email', TRUE));
        $contact_no = trim((string)$this->input->post('contact_no', TRUE));

        if (empty($name) || empty($email)) {
            $this->session->set_flashdata('error', 'Name and Email are required.');
            redirect('main/profile');
            return;
        }

        $existing = $this->User_model->get_by_email($email);
        if ($existing && (int)$existing['id'] !== $user_id) {
            $this->session->set_flashdata('error', "Email '{$email}' is already in use by another account.");
            redirect('main/profile');
            return;
        }

        $update_data = [
            'name'       => $name,
            'email'      => $email,
            'contact_no' => !empty($contact_no) ? $contact_no : null
        ];

        $this->User_model->update($user_id, $update_data);

        $this->session->set_userdata([
            'name'       => $name,
            'email'      => $email,
            'contact_no' => $contact_no
        ]);

        $this->session->set_flashdata('success', 'Profile updated successfully!');
        redirect('main/profile');
    }
}
