<?php
class Hierarchy_management_model extends CI_Model {
      /*
     *Purpose : Constructor function 
     */
    
    function __construct() {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
    }
	
	function insert_hierarchy($data) {
		$this->db->insert('hierarchy', $data);
		return true;
    }
	
	function update_hierarchy($id,$data) {
		$this->db->where('id',$id);
		$this->db->update('hierarchy',$data);
		return $this->db->affected_rows();
	}
	
	function get_allhierarchyDetails() {
		$this->db->from("hierarchy");
        $this->db->order_by('lob', 'ASC');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function get_hierarchyDetails($id) {
		$this->db->from("hierarchy");
		$this->db->where('id',$id);
		$result = $this->db->get();
		return $result->row_array();
	}
	
	function get_lob() {
		$this->db->select("lob");
		$this->db->from("hierarchy");
		$this->db->group_by('lob');
		$result = $this->db->get(); 
		return $result->result_array();
    }
	
	function get_campaign() {
		$this->db->select("campaign");
		$this->db->from("hierarchy");
		$this->db->group_by('campaign');
		$result = $this->db->get();
		return $result->result_array();
    }
	
	function get_vendor() { 
		$this->db->select("vendor");
		$this->db->from("hierarchy");
		$this->db->group_by('vendor');
		$result = $this->db->get();
		//$data[''] = 'Select Vendor';
		return $result->result_array();
   	}

   	function get_location() {
		$this->db->select("location");
		$this->db->from("hierarchy");
		$this->db->group_by('location');
		$result = $this->db->get();
		return $result->result_array();
   	}
   
	function get_form_name($frm_type) {
		$this->db->select("form_name");
		$this->db->from("forms_details");
		$this->db->where('form_type',$frm_type);
		$this->db->group_by('form_name');
		$result = $this->db->get();
		return $result->result_array();
   	}
    
    public function getLobUser($table,$col,$val) {
        $where = "$col REGEXP '^$val;|$val'";
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
}
?>
