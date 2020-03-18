<?php
class Create_form_model extends CI_Model
{
    /*
     *Purpose : Constructor function 
     */
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
    }
	
	// Check Agent report valid or Invalid
	function checkvalidAgent($lob,$vendor,$location,$campaign)
    {
     
		$this->db->select("lob,campaign,vendor,location");
		$this->db->from("hierarchy");
		$this->db->where('lob',$lob);
		$this->db->where('vendor',$vendor);
		$this->db->where('location',$location);
		$this->db->where('campaign',$campaign);
		$result = $this->db->get();
		return  $result->num_rows();
	}
	
	/// select from where return row array
	function checkFormname($formname)
	{
		$this->db->select('form_name');
		$this->db->from('forms_details');
		$this->db->where('form_name',$formname);
		$result = $this->db->get();
		return $result->num_rows();	
	}

	function get_form_Name($client_id)
    {
		$this->db->select("form_name");
		$this->db->from("forms_details");
		$this->db->where('client_id', $client_id);
		$result = $this->db->get();
		return $result;	
	}
	function get_formName($form_type)
    {
		$this->db->select("form_name");
		$this->db->from("forms_details");
		$this->db->where('form_type', $form_type);
		$result = $this->db->get();
		//echo $this->db->last_query();
		    $select = '';
			$select.="<option value=''>Select</option>";
			foreach($result->result_array() as $row){
			$select.="<option value='".$row['form_name']."'>".$row['form_name']."</option>";
		   }
			return $select;	
	}
	
	
	function get_formVersion($form_name)
	{
		$this->db->select('form_version');
		$this->db->from('forms_details');
		$this->db->where('form_name' , $form_name);
		$result = $this->db->get();
		 $countversion  = $result->num_rows();
		if($countversion > 0){
			$countversion =  $countversion+1;
			$version = 'v'.$countversion.'.0';
			
		} else {
			$version = 'v1'.'.0';
		}
		
		return $version;
	}
	
	function get_campaign()
    {
	$this->db->select("campaign");
	$this->db->from("hierarchy");
	$this->db->group_by('campaign');
	$result = $this->db->get();
	return $result->result_array();
    }
	
	function get_location()
   {
	$this->db->select("location");
	$this->db->from("hierarchy");
	$this->db->group_by('location');
	$result = $this->db->get();
	return $result->result_array();
   }

   function get_data()
	{
		$this->db->select('*');
		$this->db->from('forms_details');
		return $this->db->get()->result_array();
	}
	
	
//please write above....	
}
?>