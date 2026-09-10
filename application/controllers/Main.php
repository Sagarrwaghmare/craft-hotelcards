<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
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
        $data['title']       = 'Add User';
        $data['active_menu'] = 'add_user';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/add', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add_member()
    {
        $data['title']       = 'Add Member';
        $data['active_menu'] = 'add_member';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/add_member', $data);
        $this->load->view('templates/footer', $data);
    }

    public function members()
    {
        $this->load->model('Member_model');

        $data['title']          = 'Membership & Events Overview';
        $data['active_menu']    = 'members';
        $data['gold_count']     = $this->Member_model->count_by_type('Gold');
        $data['platinum_count'] = $this->Member_model->count_by_type('Platinum');
        $data['events']         = $this->Member_model->get_upcoming_events(25);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/display_members', $data);
        $this->load->view('templates/footer', $data);
    }

    public function members_list()
    {
        $this->load->model('Member_model');
        $this->load->library('pagination');

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
        $per_page     = 15;
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

    public function users()
    {
        $data['title']       = 'User Management';
        $data['active_menu'] = 'users';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/users_list', $data);
        $this->load->view('templates/footer', $data);
    }

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

        $data['visits']      = $this->Visit_model->get_by_member_id($member_id);
        $data['summary']     = $this->Visit_model->get_member_summary($member_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/member_details', $data);
        $this->load->view('templates/footer', $data);
    }

    // Handles modal submission for adding a visit
    public function add_visit()
    {
        $member_id  = (int)$this->input->post('member_id', TRUE);
        $visit_date = $this->input->post('visit_date', TRUE);
        $raw_pax    = (int)($this->input->post('no_of_pax', TRUE) ?: $this->input->post('pax', TRUE));
        $raw_apc    = (float)$this->input->post('apc', TRUE);

        if (empty($member_id) || empty($visit_date)) {
            $this->session->set_flashdata('error', 'Visit date and member are required.');
            redirect('main/members_list');
        }

        // Limit pax between 1 and 25
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
            $this->session->set_flashdata('error', 'Failed to save visit details. Please try again.');
        }

        redirect('main/member_details/' . $member_id);
    }

    public function profile($user_id = null)
    {
        $data['title']       = 'User Profile Management';
        $data['active_menu'] = 'profile';
        $data['is_admin']    = TRUE;

        $data['user'] = [
            'name'       => 'Jane Doe',
            'email'      => 'jane.doe@example.com',
            'contact_no' => '555-0199',
            'username'   => 'janedoe_sys',
            'password'   => 'password123',
            'access'     => 'Admin'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/profile', $data);
        $this->load->view('templates/footer', $data);
    }
}
