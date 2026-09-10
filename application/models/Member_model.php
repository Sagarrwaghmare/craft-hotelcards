<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member_model extends CI_Model
{
    protected $table = 'members';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $query = $this->db->order_by('id', 'DESC')->get($this->table);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }

    public function get_by_card_number($card_number)
    {
        $query = $this->db->get_where($this->table, array('card_number' => $card_number));
        return $query->row_array();
    }

    // Count members by card type (Gold, Platinum, Silver)
    public function count_by_type($type)
    {
        return $this->db->where('card_type', $type)->count_all_results($this->table);
    }

    // Fetch upcoming birthdays and anniversaries starting from today
    public function get_upcoming_events($limit = 20)
    {
        $this->db->where('dob IS NOT NULL', null, false);
        $this->db->or_where('anniversary IS NOT NULL', null, false);
        $members = $this->db->get($this->table)->result_array();

        $events = [];
        $today = new DateTime('today');
        $currentYear = (int)$today->format('Y');

        foreach ($members as $m) {
            $fullName = trim($m['first_name'] . ' ' . $m['last_name']);

            // 1. Process Birthday
            if (!empty($m['dob']) && $m['dob'] !== '0000-00-00') {
                $dob = new DateTime($m['dob']);
                $eventDate = new DateTime("{$currentYear}-{$dob->format('m-d')}");
                if ($eventDate < $today) {
                    $eventDate->modify('+1 year');
                }

                $diff = $today->diff($eventDate)->days;

                $events[] = [
                    'member_id'   => $m['id'],
                    'name'        => $fullName,
                    'type'        => $m['card_type'],
                    'event'       => 'Birthday',
                    'sort_date'   => $eventDate->format('Y-m-d'),
                    'date'        => $eventDate->format('d-M-Y'),
                    'days_left'   => $diff,
                    'contact_no'  => $m['contact_no'] ?? ''
                ];
            }

            // 2. Process Anniversary
            if (!empty($m['anniversary']) && $m['anniversary'] !== '0000-00-00') {
                $anni = new DateTime($m['anniversary']);
                $eventDate = new DateTime("{$currentYear}-{$anni->format('m-d')}");
                if ($eventDate < $today) {
                    $eventDate->modify('+1 year');
                }

                $diff = $today->diff($eventDate)->days;

                $events[] = [
                    'member_id'   => $m['id'],
                    'name'        => $fullName,
                    'type'        => $m['card_type'],
                    'event'       => 'Anniversary',
                    'sort_date'   => $eventDate->format('Y-m-d'),
                    'date'        => $eventDate->format('d-M-Y'),
                    'days_left'   => $diff,
                    'contact_no'  => $m['contact_no'] ?? ''
                ];
            }
        }

        usort($events, function ($a, $b) {
            return strcmp($a['sort_date'], $b['sort_date']);
        });

        return array_slice($events, 0, $limit);
    }

    // Apply filters helper for search, type, and date ranges
    private function _apply_filters($filters = [])
    {
        if (!empty($filters['search'])) {
            $keyword = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('first_name', $keyword);
            $this->db->or_like('last_name', $keyword);
            $this->db->or_like('card_number', $keyword);
            $this->db->or_like('contact_no', $keyword);
            $this->db->or_like("CONCAT(first_name, ' ', last_name)", $keyword);
            $this->db->group_end();
        }

        if (!empty($filters['type'])) {
            $this->db->where('card_type', $filters['type']);
        }

        if (!empty($filters['dob_from'])) {
            $this->db->where('dob >=', $filters['dob_from']);
        }

        if (!empty($filters['dob_to'])) {
            $this->db->where('dob <=', $filters['dob_to']);
        }

        if (!empty($filters['anniv_from'])) {
            $this->db->where('anniversary >=', $filters['anniv_from']);
        }

        if (!empty($filters['anniv_to'])) {
            $this->db->where('anniversary <=', $filters['anniv_to']);
        }
    }

    public function get_filtered_members($filters = [], $limit = null, $offset = null)
    {
        $this->_apply_filters($filters);
        $this->db->order_by('id', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function count_filtered_members($filters = [])
    {
        $this->_apply_filters($filters);
        return $this->db->count_all_results($this->table);
    }

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

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }
}
