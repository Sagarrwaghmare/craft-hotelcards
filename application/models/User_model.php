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

    // Get all users ordered by newest first
    public function get_all()
    {
        $query = $this->db->order_by('id', 'DESC')->get($this->table);
        return $query->result_array();
    }
    // Get paginated users (default: 10 per page)
    public function get_paginated($limit = 10, $offset = 0)
    {
        $query = $this->db->order_by('id', 'DESC')->limit($limit, $offset)->get($this->table);
        return $query->result_array();
    }

    // Get user by ID
    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }

    // Get user by Username (useful for login / unique checks)
    public function get_by_username($username)
    {
        $query = $this->db->get_where($this->table, array('username' => $username));
        return $query->row_array();
    }

    // Get user by Email (useful for login / unique checks)
    public function get_by_email($email)
    {
        $query = $this->db->get_where($this->table, array('email' => $email));
        return $query->row_array();
    }

    // Find user by either username OR email for convenient login
    public function get_by_identifier($identifier)
    {
        $this->db->group_start();
        $this->db->where('username', $identifier);
        $this->db->or_where('email', $identifier);
        $this->db->group_end();
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Insert new user into database
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

    // Delete single user
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Delete multiple users at once
    public function delete_batch_ids($ids)
    {
        if (empty($ids) || !is_array($ids)) {
            return false;
        }
        $this->db->where_in('id', $ids);
        return $this->db->delete($this->table);
    }

    // Count total users
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }
}
