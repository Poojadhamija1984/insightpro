<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Agent_model extends CI_Model {
    
    // save data
    public function insertData($data) {
        $this->db->insert_batch('agent', $data);

    }public function updateData($data) {
        $this->db->update_batch('agent', $data,'agent_id');
    }
    // get employee list
    public function agentList($where) {
        $this->db->select(array('e.agent_id', 'e.agent_name', 'e.lob', 'e.companion', 'e.vendor', 'e.location','e.agent_status'));
        $this->db->from('agent as e');
        $this->db->where('e.agent_valid',$where);
        $query = $this->db->get();
        return $query->result_array();
    }
 
}
 
?>