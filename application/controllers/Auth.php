<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    // Default view: Shows the login page
    public function index()
    {
        // If already logged in, redirect straight to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('main');
        }

        $data['title'] = 'Software Login';
        $this->load->view('auth/login', $data);
    }

    // Handles form submission (POST)
    public function authenticate()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        // TODO: Replace with your actual database check using User_model
        if (!empty($username) && !empty($password)) {
            // Set session on success
            $this->session->set_userdata([
                'username'  => $username,
                'logged_in' => TRUE
            ]);
            redirect('main');
        } else {
            $this->session->set_flashdata('error', 'Please provide both username and password.');
            redirect('auth');
        }
    }

    // Logout action
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}