<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('main');
        }

        $data['title'] = 'Software Login';
        $this->load->view('auth/login', $data);
    }

    public function authenticate()
    {
        $this->load->model('User_model');

        $identifier = trim((string)$this->input->post('username', TRUE));
        $password   = $this->input->post('password', TRUE);

        if (empty($identifier) || empty($password)) {
            $this->session->set_flashdata('error', 'Please enter your username/email and password.');
            redirect('auth');
            return;
        }

        $user = $this->User_model->get_by_identifier($identifier);

        if ($user && !empty($user['password_hash']) && password_verify($password, $user['password_hash'])) {
            $session_data = [
                'user_id'    => (int)$user['id'],
                'name'       => $user['name'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'contact_no' => $user['contact_no'] ?? '',
                'access'     => $user['access'],
                'logged_in'  => TRUE
            ];
            $this->session->set_userdata($session_data);

            redirect('main');
        } else {
            $this->session->set_flashdata('error', 'Invalid username/email or password.');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    // Reset password screen (only accessible when logged in)
    public function reset_password()
    {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please log in first to change your password.');
            redirect('auth');
            return;
        }

        $data['title'] = 'Reset Password';
        $data['user']  = [
            'name'     => $this->session->userdata('name'),
            'username' => $this->session->userdata('username'),
            'email'    => $this->session->userdata('email'),
        ];

        $this->load->view('auth/reset_password', $data);
    }

    // Handles changing password for the currently logged-in user
    public function update_password()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }

        $this->load->model('User_model');

        $user_id          = (int)$this->session->userdata('user_id');
        $old_password     = $this->input->post('old_password', TRUE);
        $new_password     = $this->input->post('new_password', TRUE);
        $confirm_password = $this->input->post('confirm_password', TRUE);

        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
            $this->session->set_flashdata('error', 'All password fields are required.');
            redirect('auth/reset_password');
            return;
        }

        if ($new_password !== $confirm_password) {
            $this->session->set_flashdata('error', 'New password and confirmation do not match.');
            redirect('auth/reset_password');
            return;
        }

        if (strlen($new_password) < 6) {
            $this->session->set_flashdata('error', 'New password must be at least 6 characters long.');
            redirect('auth/reset_password');
            return;
        }

        // Fetch user from DB to verify old password hash
        $user = $this->User_model->get_by_id($user_id);
        if (!$user || !password_verify($old_password, $user['password_hash'])) {
            $this->session->set_flashdata('error', 'Current password entered is incorrect.');
            redirect('auth/reset_password');
            return;
        }

        // Save new hashed password
        $new_hash = password_hash($new_password, PASSWORD_BCRYPT);
        $this->User_model->update($user_id, ['password_hash' => $new_hash]);

        $this->session->set_flashdata('success', 'Your password has been changed successfully!');
        redirect('auth/reset_password');
    }

    // public function setup_admin()
    // {
    //     $this->load->model('User_model');

    //     // Prevent duplicate creation if admin already exists
    //     if ($this->User_model->get_by_username('admin')) {
    //         echo "Admin user already exists!";
    //         return;
    //     }

    //     $admin_data = [
    //         'name'          => 'Super Admin',
    //         'username'      => 'admin',
    //         'email'         => 'admin@hotelcards.local',
    //         'contact_no'    => '+1-555-0100',
    //         'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
    //         'access'        => 'Admin'
    //     ];

    //     $id = $this->User_model->add($admin_data);

    //     if ($id) {
    //         echo "<h2 style='color:green;'>Admin Created Successfully!</h2>";
    //         echo "<p>Username: <b>admin</b></p>";
    //         echo "<p>Password: <b>admin123</b></p>";
    //         echo "<p><a href='" . base_url('auth') . "'>Click here to Log In</a></p>";
    //     } else {
    //         echo "<h2 style='color:red;'>Failed to create admin. Check DB connection.</h2>";
    //     }
    // }
}
