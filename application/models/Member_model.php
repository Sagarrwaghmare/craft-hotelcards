<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model
{
    protected $table = 'members';

    public function __construct()
    {
        parent::__construct();
    }

    // Get all members
    public function get_all()
    {
        $query = $this->db->order_by('id', 'DESC')->get($this->table);
        return $query->result_array();
    }

    // Get member by ID
    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }

    // Get member by Card Number (e.g. barcode scan / search)
    public function get_by_card_number($card_number)
    {
        $query = $this->db->get_where($this->table, array('card_number' => $card_number));
        return $query->row_array();
    }

    // Search members by keyword (Name, Card No, Phone, Email)
    public function search($keyword)
    {
        $this->db->group_start();
        $this->db->like('card_number', $keyword);
        $this->db->or_like('first_name', $keyword);
        $this->db->or_like('last_name', $keyword);
        $this->db->or_like('contact_no', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->group_end();

        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    // Insert new member
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update member
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete member (Note: Will automatically cascade visits if FK is ON DELETE CASCADE)
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Total count of members
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }
}