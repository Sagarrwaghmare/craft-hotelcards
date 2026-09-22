<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Comember_model extends CI_Model
{
    protected $table = 'comembers';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        $query = $this->db->order_by('id', 'DESC')->get($this->table);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => (int) $id])->row_array();
    }

    /**
     * Get co-members with pagination support
     */
    public function get_by_member_id($member_id, $limit = null, $offset = null)
    {
        $this->db->where('member_id', (int) $member_id);
        $this->db->order_by('id', 'DESC');
        if ($limit !== null) {
            $this->db->limit((int) $limit, (int) $offset);
        }
        return $this->db->get($this->table)->result_array();
    }

    public function count_by_member($member_id)
    {
        $this->db->where('member_id', (int) $member_id);
        return $this->db->count_all_results($this->table);
    }

    public function insert($data)
    {
        $clean_data = [
            'member_id'    => (int) $data['member_id'],
            'name'         => trim($data['name']),
            'relationship' => $data['relationship'],
            'contact_no'   => !empty($data['contact_no']) ? trim($data['contact_no']) : null,
            'dob'          => !empty($data['dob']) ? $data['dob'] : null,
        ];

        $this->db->insert($this->table, $clean_data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $clean_data = [];

        if (isset($data['name'])) {
            $clean_data['name'] = trim($data['name']);
        }
        if (isset($data['relationship'])) {
            $clean_data['relationship'] = $data['relationship'];
        }
        if (array_key_exists('contact_no', $data)) {
            $clean_data['contact_no'] = !empty($data['contact_no']) ? trim($data['contact_no']) : null;
        }
        if (array_key_exists('dob', $data)) {
            $clean_data['dob'] = !empty($data['dob']) ? $data['dob'] : null;
        }

        if (empty($clean_data)) {
            return false;
        }

        $this->db->where('id', (int) $id);
        return $this->db->update($this->table, $clean_data);
    }

    public function delete($id)
    {
        $this->db->where('id', (int) $id);
        return $this->db->delete($this->table);
    }

    public function delete_batch_ids($ids)
    {
        if (empty($ids)) return false;
        $this->db->where_in('id', $ids);
        return $this->db->delete($this->table);
    }
    public function get_counts_map($member_ids = [])
    {
        $this->db->select('member_id, COUNT(*) as total');
        if (!empty($member_ids)) {
            $this->db->where_in('member_id', array_map('intval', $member_ids));
        }
        $this->db->group_by('member_id');
        $rows = $this->db->get($this->table)->result_array();

        $map = [];
        foreach ($rows as $r) {
            $map[$r['member_id']] = (int)$r['total'];
        }
        return $map;
    }
}
