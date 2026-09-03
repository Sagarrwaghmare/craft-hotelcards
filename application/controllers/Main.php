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

    public function index($page_view = null, $data = [])
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
}
