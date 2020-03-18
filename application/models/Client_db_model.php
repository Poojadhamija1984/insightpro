<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Client_db_model extends CI_Model {
 
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
 
	
	public function create_database_client($client_id){
		$query = $this->db->get_where('client',array('client_id'=>$client_id));
		$client_info = $query->row_array();
		// Create DB name for client db
		//$client_db_name = strtolower(substr(trim($client_info['client_company']),0,4).'_'.trim(($client_info['client_id'])));
		$client_db_name = strtolower(trim($client_info['client_username']));
		$this->load->dbforge();
		//$client_db_name ='MYYYY_dbBBB_NAME';
		$this->db->query("DROP DATABASE IF EXISTS ".$client_db_name);
		if ($this->dbforge->create_database($client_db_name, TRUE))
		{
			// Update client db name in client master table
			// $data['client_db_name'] = $client_db_name;
			// $this->db->where('client_id',$client_id);
			// $this->db->update('client', $data);

			// insert client db name in session
			$arraydata = array(
				'client_db_name'  => $client_db_name
			);
			$this->session->set_userdata($arraydata);
			return true;
		}
		else {
			return false;
		}
	}

	public function create_tbl_client($table_name,$industry_type){
		// $mastertable = 'client';
		// $tablename = 'client111';
		$new_db_name =  $this->session->userdata('client_db_name');
		if($industry_type == "BPO")
			$old_db_name = $this->db->database;
		else{
			$other_master_db = $this->load->database('db_others', TRUE);
			$old_db_name = $other_master_db->database;
		}
		if($table_name == 'subscription' || $table_name == 'subscription_details' || $table_name == 'template_pre' || $table_name == 'template_details_pre')
		{
			return true;
		}
		else {	
			$this->db->query("DROP TABLE IF EXISTS ".$new_db_name.$table_name);
			return $this->db->query("CREATE TABLE $new_db_name.$table_name LIKE $old_db_name.$table_name");
		}
	}
	
	public function getall_table_master_db($industry_type){
		if($industry_type == "BPO")
			return $tables = $this->db->list_tables();
		else{
			$other_master_db = $this->load->database('db_others', TRUE);
			return $tables = $other_master_db->list_tables();
		}
	}
	public function insert_client_info($client_id){
		$query = $this->db->get_where('client',array('client_id'=>$client_id));
		$client_info = $query->row_array();
		$client_db = $this->load->database('db2', TRUE);
		$client_db->insert('client',$client_info);
		if($client_db->insert_id()){
			$user_table_data = array(
				'client_id'  	=> $client_info['client_id'],
				'name'  		=> $client_info['client_first_name'].' '.$client_info['client_last_name'],
				'usertype'  	=> '1',
				'user_email'  	=> $client_info['client_email'],
				'user_password' => $client_info['client_password'],
				'is_admin'  	=> '1',
				'status'  		=> '1',
			);
			$client_db->insert('user',$user_table_data);
			if($client_info['industry_type'] != "BPO"){
				$form_matadata_table_data = [
					[
						'client_id'  	=> $client_info['client_id'],
						'label_name'  	=> 'Unique ID',
						'field_name'  	=> 'unique_id',
						'created_date'  	=> date('Y-m-d')
					],
					[
						'client_id'  	=> $client_info['client_id'],
						'label_name'  	=> 'Auditor Name',
						'field_name'  	=> 'evaluator_name',
						'created_date'  	=> date('Y-m-d')
					],
					[
						'client_id'  	=> $client_info['client_id'],
						'label_name'  	=> 'Total Score',
						'field_name'  	=> 'total_score',
						'created_date'  	=> date('Y-m-d')
					]
				];
				$client_db->insert_batch('form_matadata',$form_matadata_table_data);
			}		
			return $client_db->insert_id(); 
		}
		else {
			return false;
		}
	}

	public function getall_user_type($client_id){
		$this->db->select('usertype_id,usertype_name');
		$query = $this->db->get_where('user_type',array('client_id'=>$client_id));
		return $query->result_array();
	}
	
	public function get_supname($client_id,$usertype_id){
		$this->db->select("empid,name");
		$this->db->from("user");
		$this->db->where('usertype',$usertype_id);
		$this->db->where('client_id',$client_id);
		$this->db->group_by('empid,name');
		$result = $this->db->get();
		return $result->result_array();
	}

	

}
?>
