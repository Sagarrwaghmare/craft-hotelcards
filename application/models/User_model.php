<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class User_model extends CI_Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    // Get all users
    public function get_all()
    {
        $query = $this->db->order_by('id', 'DESC')->get($this->table);
        return $query->result_array();
    }

    // Get user by ID
    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array(); // row_array returns a single associative record
    }

    // Get user by Username (useful for login / unique checks)
    public function get_by_username($username)
    {
        $query = $this->db->get_where($this->table, array('username' => $username));
        return $query->row_array();
    }

    // Get user by Email
    public function get_by_email($email)
    {
        $query = $this->db->get_where($this->table, array('email' => $email));
        return $query->row_array();
    }

    // Insert new user (Returns newly generated ID)
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update user
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete user
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Count total users
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }
}
