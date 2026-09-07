<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the URL helper for base_url() to work in views
        $this->load->helper('url');
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
        echo "<pre>";
        var_dump($data);
    }


    public function index($page_view = null, $data = [])
    {

        echo "MAIN PAGE";
    }

    public function add_user()
    {
        $data['title'] = 'Add User';
        $data['active_menu'] = 'add_user';

        // Load modular views
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/add', $data);

        $this->load->view('templates/footer', $data);
    }


    // 1. Show Add Member Page
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
        $data['title'] = 'Membership & Events Overview';
        $data['active_menu'] = 'members';

        // Counts for the metric cards
        $data['gold_count'] = 42;
        $data['platinum_count'] = 18;

        // Optional: Pass dynamic DB results here later from Member_model
        // $data['events'] = $this->Member_model->get_upcoming_events();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/display_members', $data);
        $this->load->view('templates/footer', $data);
    }
    public function members_list()
    {
        $data['title'] = 'Members Directory';
        $data['active_menu'] = 'members_list';

        // When ready to connect to your Member_model:
        // $this->load->model('Member_model');
        // $data['members'] = $this->Member_model->get_all_members();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/members_list', $data); // Loads this new file
        $this->load->view('templates/footer', $data);
    }
    public function users()
    {
        $data['title'] = 'User Management';
        $data['active_menu'] = 'users';

        // When connected to User_model later:
        // $this->load->model('User_model');
        // $data['users'] = $this->User_model->get_all();

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

        // Fetch from models (falls back to mock data if empty for testing)
        $data['member']      = $this->Member_model->get_by_id($member_id);
        $data['visits']      = $this->Visit_model->get_by_member_id($member_id);
        $data['summary']     = $this->Visit_model->get_member_summary($member_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/member_details', $data);
        $this->load->view('templates/footer', $data);
    }

    // Handles modal submission
    public function add_visit()
    {
        $member_id = $this->input->post('member_id', TRUE);
        $visit_data = [
            'member_id' => $member_id,
            'visit_date' => $this->input->post('visit_date', TRUE),
            'no_of_pax' => $this->input->post('no_of_pax', TRUE),
            'apc'       => $this->input->post('apc', TRUE),
        ];

        // $this->load->model('Visit_model');
        // $this->Visit_model->insert($visit_data);

        $this->session->set_flashdata('success', 'Visit details added successfully!');
        redirect('main/view/' . $member_id);
    }

    public function profile($user_id = null)
    {
        $data['title'] = 'User Profile Management';
        $data['active_menu'] = 'profile';

        // Check if current logged-in user is an Admin (used for showing/hiding admin action buttons)
        $data['is_admin'] = TRUE;

        // Fetch user data (fallback mock data if DB isn't plugged in yet)
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
