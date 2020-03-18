<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
		parent::__construct();
		$this->load->model('client_db_model');
		$this->load->model('users_model');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('common_model','common');
	}

	public function index()
	{
		$subdomin = explode('//',explode('.',site_url())[0])[1];
		echo $check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
		echo '<br>';
		echo $subdomin = explode('//',explode('.',site_url())[0])[1];
		echo '<br>';
		echo 'post_max_size = ';
		var_dump(ini_get('post_max_size'));

		echo '<br>';
		echo 'upload_max_filesize = ';
		var_dump(ini_get('upload_max_filesize'));

		// ini_set('upload_max_filesize', '10M');
		// ini_set('post_max_size', '10M');
		// ini_set('max_input_time', 300);
		// ini_set('max_execution_time', 300);

		// echo '<br>';
		// echo 'post_max_size = ';
		// var_dump(ini_get('post_max_size'));


		// $client_id = $this->session->userdata('client_id');
		// $this->client_db_model->insert_client_info($client_id);


		// echo '<br>';
		// echo base_url();
		// echo '<br>';
		// echo site_url();
		// echo '<pre>';
		// //print_r(explode('.',site_url())[0]);
		// print_r(explode('//',explode('.',site_url())[0])[1]);
		// echo '<br>';
		// echo explode('//',explode('.',site_url())[0])[1];
		// echo '<br>';
		// print_r(explode('.',site_url()));
		// echo '<br>';
		// print_r(explode('//',site_url(),2)[0]);


		// db switch code .......................
// 		echo $this->db->database;
// 		$data = $this->users_model->getAllUsers();
// 		echo '<pre>';
// 		print_r($data);
// 		echo '</pre>';
// 		echo '|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
// 		$this->load->database();
// 		//mattsenkumar
		
		
// 		$this->db->close();
// 		$current_database = "mattsenkumar";
//       	$this->db->database = $current_database;
// 		$this->db->close();
// 		$config['hostname'] = "insightspro.c1rgayqealwe.ap-south-1.rds.amazonaws.com";
// 		$config['username'] = "root";
// 		$config['password'] = "root2019";
// 		$config['database'] = $current_database;
// 		$config['dbdriver'] = 'mysqli';
// 		$config['dbprefix'] = '';
// 		$config['pconnect'] = FALSE;
// 		$config['db_debug'] = (ENVIRONMENT !== 'production');
// 		$config['failover'] = array();
// 		$config['save_queries'] = TRUE;
// 		$config['cache_on'] = FALSE;
// 		$config['cachedir'] = '';
// 		$config['char_set'] = 'utf8';
// 		$config['dbcollat'] = 'utf8_general_ci';
// 		$config['swap_pre'] = '';
// 		$config['encrypt'] = FALSE;
// 		$config['compress'] = FALSE;
// 		$config['stricton'] = FALSE;
// 		$this->load->database($config);
// 		echo '<br>';
// 		echo $this->db->database;


// 		echo '<br>';
// 		echo '<br>';
// 		echo '<br>';
// 		$this->load->database();
// 		$data = $this->users_model->getAllUsers();
// 		echo '<pre>';
// 		print_r($data);
// 		echo '</pre>';




		// echo '<br>';
		// echo base_url();
		//  echo '<br>';
		// echo site_url();
		//  echo '<pre>';
		//  print_r(explode('/',site_url()));
		// print_r(explode('//',site_url(),2)[0]);


		//  $client_id = $this->session->userdata('client_id');
	
		// if($this->client_db_model->create_database_client($client_id))
		// {
		// 	echo "db created <br>";
		// }
		// else {
		// 	echo "db NOT   created <br>";
		// }

		// $get_all_tables = $this->client_db_model->getall_table_master_db();
		// foreach ($get_all_tables as $table)
		// {
		// //echo $table.'<br>';
		// 	if($this->client_db_model->create_tbl_client($table))
		// 	{
		// 		echo "<br> TBL created  ".$table;
		// 	}
		// 	else {
		// 		echo "<br> TBL NOT   created ".$table;
		// 	}
		// }

		// $this->client_db_model->insert_client_info($client_id);
	}

	// public function index()
	// {
	// 	$data['users'] = $this->users_model->getAllUsers();
	// 	echo '<pre>';
	// 	print_r($data['users']);
	// 	echo '</pre>';
	// 	$this->load->view('welcome_message');
	// }
}
