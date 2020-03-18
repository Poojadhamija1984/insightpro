<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Users_model extends CI_Model {
 
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
 
	public function getAllUsers(){
		$query = $this->db->get('client');
		return $query->result(); 
	}
 
	public function insert_data($user,$table_name){
		//$this->db->insert('client', $user);
		$this->db->insert($table_name, $user);
		return $this->db->insert_id(); 
	}
 
	public function getUser($table_name,$data){
		$query = $this->db->get_where($table_name,$data);
		return $query->row_array();
	}
 
	public function update_data($data,$col_name,$col_val,$tabel){
		$this->db->where($col_name,$col_val);
		return $this->db->update($tabel, $data);
		// echo $this->db->last_query();exit;
	}
	public function switch_db($client_database_name){
		$this->db->close();
		///		/// for aws server /////////////////////////////////////////////////////////////
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = $client_database_name;
		$config['dbdriver'] = 'mysqli';
		$config['dbprefix'] = '';
		$config['pconnect'] = FALSE;
		$config['db_debug'] = (ENVIRONMENT !== 'production');
		$config['failover'] = array();
		$config['save_queries'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';
		$config['swap_pre'] = '';
		$config['encrypt'] = FALSE;
		$config['compress'] = FALSE;
		$config['stricton'] = FALSE;
		return	$this->load->database($config);

		///		/// for localhost ///////// /////////////////////////////////////////////////////////

		// $config['hostname'] = "localhost";
		// $config['username'] = "root";
		// $config['password'] = "";
		// $config['database'] = $client_database_name;
		// $config['dbdriver'] = 'mysqli';
		// $config['dbprefix'] = '';
		// $config['pconnect'] = FALSE;
		// $config['db_debug'] = (ENVIRONMENT !== 'production');
		// $config['failover'] = array();
		// $config['save_queries'] = TRUE;
		// $config['cache_on'] = FALSE;
		// $config['cachedir'] = '';
		// $config['char_set'] = 'utf8';
		// $config['dbcollat'] = 'utf8_general_ci';
		// $config['swap_pre'] = '';
		// $config['encrypt'] = FALSE;
		// $config['compress'] = FALSE;
		// $config['stricton'] = FALSE;
		// return	$this->load->database($config);
	}

	public function getWhereSelectAll($table,$select,$where=null){
        $this->db->select($select);
        $this->db->from($table);
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result();
    } 
 
}
?>