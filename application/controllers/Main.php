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

        // Extract and clean filters
        $filters = [
            'search'     => trim((string)$this->input->get('search', TRUE)),
            'type'       => trim((string)$this->input->get('type', TRUE)),
            'dob_from'   => trim((string)$this->input->get('dob_from', TRUE)),
            'dob_to'     => trim((string)$this->input->get('dob_to', TRUE)),
            'anniv_from' => trim((string)$this->input->get('anniv_from', TRUE)),
            'anniv_to'   => trim((string)$this->input->get('anniv_to', TRUE)),
        ];

        // Total filtered count
        $total_rows = $this->Member_model->count_filtered_members($filters);
        $per_page   = 15;
        $current_page = max(1, (int)$this->input->get('page'));
        $offset     = ($current_page - 1) * $per_page;

        // Fetch paginated member rows
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

    // Export members matching current active filters to CSV
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

        // CSV Column Headers
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

    public function member_details($member_id = 1)
    {
        $this->load->model('Member_model');
        $this->load->model('Visit_model');

        $data['title']       = 'Member Details';
        $data['active_menu'] = 'members';

        $data['member']      = $this->Member_model->get_by_id($member_id);
        $data['visits']      = $this->Visit_model->get_by_member_id($member_id);
        $data['summary']     = $this->Visit_model->get_member_summary($member_id);

        if (empty($data['member'])) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/member_details', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add_visit()
    {
        $member_id = $this->input->post('member_id', TRUE);
        $visit_data = [
            'member_id'  => $member_id,
            'visit_date' => $this->input->post('visit_date', TRUE),
            'no_of_pax'  => $this->input->post('no_of_pax', TRUE),
            'apc'        => $this->input->post('apc', TRUE),
        ];

        // $this->load->model('Visit_model');
        // $this->Visit_model->insert($visit_data);

        $this->session->set_flashdata('success', 'Visit details added successfully!');
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
