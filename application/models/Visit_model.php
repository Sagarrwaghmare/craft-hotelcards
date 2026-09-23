<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Visit_model extends CI_Model
{
    protected $table = 'visits';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $query = $this->db->order_by('visit_date', 'DESC')->get($this->table);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }

    // Get paginated visits for a specific member (default: 10 per page)
    public function get_by_member_id($member_id, $limit = null, $offset = null)
    {
        $this->db->where('member_id', $member_id);
        $this->db->order_by('visit_date', 'DESC');
        $this->db->order_by('id', 'DESC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function count_by_member_id($member_id)
    {
        return $this->db->where('member_id', $member_id)->count_all_results($this->table);
    }

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

    /**
     * Member summary with Total Spend (Billing) and True Overall Average APC
     */
    public function get_member_summary($member_id)
    {
        $this->db->select('
            COUNT(id) as total_visits,
            COALESCE(SUM(no_of_pax), 0) as total_pax,
            COALESCE(SUM(apc), 0.00) as total_billing
        ');
        $this->db->where('member_id', (int)$member_id);
        $query = $this->db->get($this->table);
        $summary = $query->row_array();

        $total_pax = (int)($summary['total_pax'] ?? 0);
        $total_billing = (float)($summary['total_billing'] ?? 0.00);

        // Safe division for overall Average APC
        $summary['avg_apc'] = ($total_pax > 0) ? ($total_billing / $total_pax) : 0.00;

        return $summary;
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function delete_by_member_id($member_id)
    {
        $this->db->where('member_id', $member_id);
        return $this->db->delete($this->table);
    }
}
