<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit_model extends CI_Model
{
    protected $table = 'visits';

    public function __construct()
    {
        parent::__construct();
    }

    // Get all visits
    public function get_all()
    {
        $query = $this->db->order_by('visit_date', 'DESC')->get($this->table);
        return $query->result_array();
    }

    // Get single visit by ID
    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }

    // Get all visits for a specific member (Used in "View Member Details" screen)
    public function get_by_member_id($member_id)
    {
        $this->db->where('member_id', $member_id);
        $this->db->order_by('visit_date', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    // Get visits with Member & Staff details joined (For visit logs / reports)
    public function get_visits_detailed($limit = null, $offset = null)
    {
        $this->db->select('v.*, m.first_name, m.last_name, m.card_number, m.card_type, u.name as logged_by');
        $this->db->from('visits v');
        $this->db->join('members m', 'm.id = v.member_id', 'left');
        $this->db->join('users u', 'u.id = v.created_by', 'left');
        $this->db->order_by('v.visit_date', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    // Get quick summary/stats for a member (Total Visits, Total PAX, Average APC)
    public function get_member_summary($member_id)
    {
        $this->db->select('
            COUNT(id) as total_visits,
            COALESCE(SUM(no_of_pax), 0) as total_pax,
            COALESCE(AVG(apc), 0.00) as avg_apc
        ');
        $this->db->where('member_id', $member_id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Insert visit
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update visit
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete single visit
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Delete all visits for a specific member
    public function delete_by_member_id($member_id)
    {
        $this->db->where('member_id', $member_id);
        return $this->db->delete($this->table);
    }
}