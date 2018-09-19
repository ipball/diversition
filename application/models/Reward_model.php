<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Reward_model extends CI_Model
{
    public function get_all()
    {
        $query = $this->db->from('rewards')->get();
        return $query->result_array();
    }

    public function store($data)
    {
        $this->db->insert('rewards', $data);
    }

    public function update($data)
    {
        $this->db->where(array('code' => $data['code']));
		$this->db->update('rewards', $data);
    } 

    public function delete_all()
    {
        $this->db->delete('rewards', '1=1');
    }

    public function get_by_lotto($lotto)
    {
        $query = $this->db->from('rewards')->where('lotto' , $lotto)->get();
        return $query->result_array();
    }
}
