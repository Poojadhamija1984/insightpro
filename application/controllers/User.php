<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User extends CI_Controller {
	public $client_id;
	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('common_model','common');
		$this->data['users'] = $this->users_model->getAllUsers();		
		$this->client_id = $this->session->userdata('client_id');
	}
 
	public function index(){

	
		// $info = parse_url($_SERVER['SERVER_NAME']);
		// $sd = explode('.',$info['path'])[0];
		// if($sd == "insightspro-dev" || $sd == "localhost"){
		// 	$this->load->view('register');
		// }
		// else{
		// 	redirect('login');
		// }

		$subdomin = explode('//',explode('.',site_url())[0])[1];
		$check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
		
		if($check_subdomin >0){
			redirect('login');
		}
		else{
			$this->load->view('register');
		}
		
	}
	
	public function login(){
		
		$subdomin = explode('//',explode('.',site_url())[0])[1];
		$check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
		if($check_subdomin == 0){
			redirect('register');
		}
		if ($this->session->userdata('emp_group')) {
			landingPage();
            //redirect('user-profile','refresh');
            exit;
        }
		if($this->input->post()){
			$this->form_validation->set_message('is_unique', 'The %s is already taken');
			$this->form_validation->set_rules('client_password', 'Password', 'required|trim|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('client_email', 'Email', 'valid_email|required|trim');
			
			if ($this->form_validation->run() == FALSE) { 
				$this->load->view('login', $this->data);
			}
			else{

				
				//get user inputs
				$client_email = $this->input->post('client_email');
				$client_password = $this->input->post('client_password');
				$subdomin = explode('//',explode('.',site_url())[0])[1];
				$client_info = $this->users_model->getUser('client',array('client_username'=>$subdomin));
				print_r($client_info);
				
				echo $client_info['client_last_name'];
				
				echo base64_encode($client_info['client_password']);
				//echo 
				//echo base64_decode($client_info->client_password);
			
				
				
				if($client_info){
					//$this->users_model->switch_db($user_info['client_username']);
					if($this->users_model->switch_db($client_info['client_username'])){
						$user_auth_info = $this->users_model->getUser('user',array('user_email'=>$client_email));
						if($client_email == $user_auth_info['user_email'] && $user_auth_info['status'] == '1'){
							if (password_verify($client_password, $user_auth_info['user_password'])){
								$user_auth_info['client_db_name'] = $subdomin;

								//  log details
								$log_data = [
											'client_id'=>$user_auth_info['client_id'],
											'user_id'=>$user_auth_info['user_id'],
											'user_name'=>$user_auth_info['name'],
											'user_email'=>$user_auth_info['user_email'],
											'login_time'=>date('Y-m-d H:m:i'),
											'domain'=>$subdomin
										];
								$client_db = $this->load->database('db3', TRUE);
   								$client_db->insert('log',$log_data);
   								$last_id = $client_db->insert_id();
								$user_auth_info['log_insert_id'] = $last_id;
								//  log details
								$client_user_info = $this->users_model->getUser('client',array('client_id'=>$user_auth_info['client_id']));
								// echo "<pre>";
								// print_r($client_user_info);die;
								$user_auth_info['emp_group'] = $user_auth_info['is_admin'];
								$user_auth_info['industry_type'] = $client_user_info['industry_type'];
								unset($user_auth_info['is_admin']);
								$this->session->set_userdata($user_auth_info);
								if($user_auth_info['is_first_login'] == 1){
									redirect('reset-password');
								}
								landingPage();
							}
							else {
								$this->session->set_flashdata('error','Wrong User Name Or Password Try Again....');
								redirect('login');
							}
						}
						else {
							$this->session->set_flashdata('error','Wrong User Name Or Password Try Again....');
							redirect('login');
						}
					}
					else {
						$this->session->set_flashdata('error','Somthing Wrong Try Again....');
						redirect('login');
					}
				}
				else {
					$this->session->set_flashdata('error','Wrong User Name Or Password Try Again....');
					redirect('login');
				}
			}
		}
		else {
			$this->load->view('login');
		}
	}
	public function forgot(){
		$subdomin = explode('//',explode('.',site_url())[0])[1];
		$check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
		if($check_subdomin != 0){
			$this->load->view('forgot');
		}
		else{
			show_404();
		}
	}
	public function forgotPassword(){
		$subdomin = explode('//',explode('.',site_url())[0])[1];
		$check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
		if($check_subdomin != 0){
			$this->form_validation->set_rules('email', 'Email', 'valid_email|required|trim|xss_clean');
			if ($this->form_validation->run() == FALSE){ 
         		$this->session->set_flashdata('Email',validation_errors());
				redirect('forgot',301);
			}
			else{
				$email = filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL);
				$dynamicDB = array(
		   			'hostname' 		=> 	$this->config->item('DBhost'),
					'username' 		=> 	$this->config->item('DBuser'),
					'password' 		=> 	$this->config->item('DBpassword'),
		   			'database' 		=> 	strtolower($subdomin),
		   			'dbdriver' 		=> 	'mysqli',
		   			'dbprefix' 		=> 	'',
		   			'pconnect' 		=> 	FALSE,
		   			'db_debug' 		=> 	TRUE,
		   			'cache_on' 		=> 	FALSE,
					'cachedir' 		=> 	'',
					'char_set' 		=> 	'utf8',
					'dbcollat' 		=> 	'utf8_general_ci',
					'swap_pre' 		=> 	'',
					'encrypt' 		=> 	FALSE,
					'compress' 		=> 	FALSE,
					'stricton' 		=> 	FALSE,
					'failover' 		=> 	array(),
					'save_queries' 	=> 	TRUE
		  		);
  				$udata = $this->common->dynamicSelect($dynamicDB,['user_email'=>$this->input->post('email')]);
				if(!empty($udata)){
					$data['name'] 	= $udata[0]->name;
					$data['email'] 	= encode($email);
					$body 			= $this->load->view('email_template/forgot',$data,true);
					$mail 			= send_email($email,"Forgot Password",$body);
					if($mail == "success"){
						$time = date("Y-m-d H:i:s", strtotime("+30 minutes"));
						$update = $this->common->dynamicUpdate($dynamicDB,['client_reset_pwd'=>1,'reset_pwd_time'=>$time],['user_email' => $email]);
						$this->session->set_flashdata('message','Check your email for a link to reset your password');
						redirect('forgot');
					}
					else{
						$this->session->set_flashdata('message', 'Please Enter Valid Email Id');
						redirect('forgot');
			    	}
				}
				else{
					$this->session->set_flashdata('Email','Can\'t find that email.');
					redirect('forgot',301);		
				}
			}
		}
		else{
			show_404();
		}
	}
	//After verified successfull token load page..
	public function complete_registration(){
		
		//$data['plan'] 			= 	$this->common->getAllData('subscription_details');
		$client_db = $this->load->database('db3', TRUE);
		$client_db->select ('*');
		$client_db->from ('subscription_details');
		$query = $client_db->get();
		$data['plan'] = $query->result_array();
		$data['client_data']	=	$this->common->getWhere('client',['client_id'=>$this->client_id]);
		//$data['client_data']	=	$this->common->getWhere('client',['client_id'=>40]);
		 //echo '<pre>';
		// print_r($data['client_data']);die;
		$this->load->view('complete_registration',$data);
	}
	public function registration_success(){
		//$this->load->view('registration_success',compact('email_id'));
		$this->load->view('registration_success');
	}

	public function register(){
		//print_r($this->input->post());die;
		$this->form_validation->set_message('is_unique', 'The %s is already taken');
        $this->form_validation->set_rules('client_first_name', 'First Name', 'required|trim|alpha|max_length[30]');
        $this->form_validation->set_rules('client_last_name', 'Last Name', 'required|trim|alpha|max_length[30]');
		$this->form_validation->set_rules('client_company', 'Company Name', 'required|trim|max_length[30]|is_unique[client.client_company]');
		$this->form_validation->set_rules('client_email', 'Email', 'valid_email|required|trim|is_unique[client.client_email]');
		$this->form_validation->set_rules('industry_type', 'Industry Type', 'required|trim');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() == FALSE) { 
         	$this->load->view('register', $this->data);
		}
		else{
			//get user inputs
			$client_first_name 	 = $this->input->post('client_first_name');
			$client_last_name 	 = $this->input->post('client_last_name');
			$client_company 	 = $this->input->post('client_company');
			$client_email 		 = $this->input->post('client_email');
			$industry_type 		 = $this->input->post('industry_type');
		
			// echo "hello";exit;
 
			//generate simple random code
				$d 			=	date ("d");
				$m 			=	date ("m");
				$y 			=	date ("Y");
				$t 			=	time();
				$dmt 		=	$d+$m+$y+$t;    
				$ran 		= 	rand(0,10000000);
				$set 		= 	substr(str_shuffle($this->config->item('custom_key')), 0, 12);
				$dmtran 	= $dmt.$ran.$set;
				$un 		=  	uniqid();
				$dmtun  	= 	$dmt.$un;
				$token_key 	= 	md5($dmtran.$un);
				// $set 		= substr(str_shuffle($this->config->item('custom_key')), 0, 12);
				// $token_key 	= substr(str_shuffle($set), 0, 12);
 
			//insert user to users table and get id

			$user['client_first_name'] 		= $client_first_name;
			$user['client_last_name'] 		= $client_last_name;
			$user['client_company'] 		= $client_company;
			$user['client_email'] 			= $client_email;
			$user['client_token'] 			= $token_key;
			$user['industry_type'] 			= $industry_type;
			$user['is_completed_status'] 	= 1;
			$user['is_admin'] 				= 0;
			$user['client_status'] 			= 0;
			$user['client_created_date'] 	= date('Y-m-d');
			$user['client_updated_date'] 	= date('Y-m-d');
			$client_id = $this->users_model->insert_data($user,'client');
			$user['client_id']	=	$client_id;

			$subject = "Signup Verification Email";
			$body = $this->load->view('email_template/account_activation',$user,true);
			$mail = send_email($client_email,$subject,$body);
			if($mail == "success"){
				$client_id = $this->common->update_data_info('client',['is_completed_status' => '2'],['client_email'=> $client_email]);
				$this->session->set_flashdata('success','Activation code sent to email');
				redirect('registration-success',301);
			}
			else{
				//$this->session->set_flashdata('message', $this->email->print_debugger());
				//$this->common->delete_data('client',['client_id'=>$client_id]);
				$this->session->set_flashdata('info', 'Enter valid email address.');
				redirect('register',403);
		    }
		}
	}
 
	public function activate(){
		// echo "fffd";die;		
		$client_id 	=  	decode($this->uri->segment(3));
		$client_token 	= 	$this->uri->segment(4);
		//fetch user details
		//$user = $this->users_model->getUser($client_id);
		// print_r($this->session->userdata());die;
		$user = $this->users_model->getUser('client',['client_id'=>$client_id]);
		// $user['client_username'];
		// if(!empty($user['client_username']))
		// {
		// 	echo "HI";
		// }
		// else {
		// 	echo "NOOOOOOOOOOOHI";
		// }
		// echo "<pre>";
		// print_r($user);die;
		//if code matches
		if($user['client_token'] == $client_token && (int)$user['is_completed_status'] != 5){
			//update user active status
			$data['is_admin'] = '1';
			$data['client_status'] = '1';
			$data['is_completed_status'] = '3';
			$query = $this->users_model->update_data($data,'client_token', $client_token,'client'); 
			if($query){
				$arraydata = [
					'client_id'  		=> $user['client_id'],
					'client_first_name' => $user['client_first_name'],
					'client_last_name'  => $user['client_last_name'],
					'client_company'  	=> $user['client_company'],
					'client_email'  	=> $user['client_email']
				];
				$this->session->set_userdata($arraydata);
				$this->session->set_flashdata('message', 'Account Activated Successfully');
				redirect('activation');
			}
			else{
				$this->session->set_flashdata('message', 'Something went wrong in activating account');
			}
		}
		else{
			
			if(!empty($user['client_username']) && (int)$user['is_completed_status'] == 5 && $user['client_status'] == 1){
				$client_url = explode('//',site_url(),2)[0].'//'.$user['client_username'].'.'.explode('//',site_url(),2)[1].'/login';
				redirect($client_url);
			}else {
				$this->session->set_flashdata('message', 'Activation link expired');
			}
		}
		redirect('register');
	}

	
	public function profile(){
		$this->form_validation->set_message('is_unique', 'The %s is already taken');
		$this->form_validation->set_rules('client_username', 'Account Name', 'required|trim|min_length[4]|max_length[30]|alpha_numeric|is_unique[client.client_username]');
		$this->form_validation->set_rules('client_password', 'Password', 'required|trim|min_length[7]|max_length[30]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[client_password]');
		$this->form_validation->set_rules('client_phone_no', 'Contact Number', 'required|trim|max_length[20]|numeric|is_unique[client.client_phone_no]');
		$this->form_validation->set_rules('client_location', 'Location', 'required|trim|min_length[3]|max_length[40]');
		$this->form_validation->set_rules('client_plan', 'Plan', 'required|trim');
		
		if ($this->form_validation->run() == FALSE) { 
			//$this->load->view('complete_registration', $this->data);			
			//$this->load->view('complete_registration', $this->data);
			//$this->complete_registration();
			if (form_error('client_username')) {
                $this->session->set_flashdata('domain','Please Enter Domain Name');
            }
            if (form_error('client_password')) {
                $this->session->set_flashdata('password','Please Enter Password and Atleast 7 digits');
            }
            if (form_error('confirm_password')) {
                $this->session->set_flashdata('confirm_password','Comfirm Password Not Match');
            }
            if (form_error('client_phone_no')) {
                $this->session->set_flashdata('client_phone_no',form_error('client_phone_no'));
            }
            if (form_error('client_location')) {
                $this->session->set_flashdata('location','Please Enter Location');
            }
            if (form_error('client_plan')) {
                $this->session->set_flashdata('client_plan','Please Enter Select Plan');
            }
			//redirect('activation');
			$client_db = $this->load->database('db3', TRUE);
			$client_db->select ('*');
			$client_db->from ('subscription_details');
			$query = $client_db->get();
			$data['plan'] = $query->result_array();
			$data['client_data']	=	$this->common->getWhere('client',['client_id'=>$this->client_id]);
			$this->load->view('complete_registration',$data);
		}
		else{
			$client_id 	= $this->session->userdata('client_id');
			$cpassword 	= $this->input->post('client_password');
			$password = password_hash($cpassword, PASSWORD_BCRYPT, ['cost' =>$this->config->item('cost')]);
			$data['client_username'] 	= strtolower(trim($this->input->post('client_username')));
			$data['client_password'] 	= $password;
			$data['client_phone_no'] 	= $this->input->post('client_phone_no');
			$data['client_location'] 	= $this->input->post('client_location');
			$data['client_plan_type']	= $this->input->post('client_plan');
			if($this->input->post('client_plan') == 1){
				$data['is_completed_status'] = '5';
				$data['client_plan_created_date'] = date('Y-m-d H:i:s');
				$data['client_plan_expierd_date'] = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s", strtotime($data['client_plan_created_date'])) . " +30 days"));;
			}
			//////////////////////////
			$user = $this->users_model->getUser('client',['client_id'=>$client_id]);
			if(!empty($user['client_username']) && (int)$user['is_completed_status'] == 5 && $user['client_status'] == 1){
				$client_url = explode('//',site_url(),2)[0].'//'.$user['client_username'].'.'.explode('//',site_url(),2)[1].'/login';
				redirect($client_url);
			}else {
				$query = $this->users_model->update_data($data,'client_id', $client_id,'client');
			}
			////////////////////////////
			//$query = $this->users_model->update_data($data,'client_id', $client_id,'client');
			if($query){				
				$this->load->model('client_db_model');				
				// restriction
				if((int)$data['client_plan_type'] == 1){
					//$this->ClientDB($client_id);
					ClientDB($client_id,$this->input->post('industry_type'));
					$this->client_db_model->insert_client_info($client_id);
					$this->session->set_flashdata('success', 'Profile has been setup successfully ');
					$client_url = explode('//',site_url(),2)[0].'//'.$data['client_username'].'.'.explode('//',site_url(),2)[1].'/login';
					$this->session->unset_userdata('client_db_name');
					redirect($client_url);
				}
				else{
					$client_id = $this->common->update_data_info('client',['is_completed_status' => '4'],['client_id'=> $client_id]);
					redirect('payment');
				}				
			}
			else{
				$this->session->set_flashdata('error', 'Something went wrong in Profile setup try again...');
				redirect('activation');
			}
		}
	}

	public function logout(){
		//$client_id = $this->session->userdata('client_id');
		//$user_id = $this->session->userdata('user_id');
		//$logout_time = date('Y-m-d H:m:i');
		$client_db = $this->load->database('db3', TRUE);
   		$client_db->where(['client_id'=>$this->session->userdata('client_id'),'user_id'=>$this->session->userdata('user_id'),'log_id'=>$this->session->userdata('log_insert_id')]);
   		$rsult = $client_db->update('log', ['logout_time'=>date('Y-m-d H:m:i')]);
		// $this->session->set_flashdata('success','');
		$user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
		}
		// $this->session->unset_userdata('client_id');
		// $this->session->unset_userdata('name');
		// $this->session->unset_userdata('usertype');
		// $this->session->unset_userdata('user_email');
		// $this->session->sess_destroy();
		// redirect('login');
       redirect('login');	
	}

	// public function ClientDB($client_id){
	// 	// create dynamic db for client
	// 	if(!$this->client_db_model->create_database_client($client_id)){
	// 		echo "db NOT   created <br>";
	// 	}
	// 	// clone all master table in dynamic client db
	// 	$get_all_tables = $this->client_db_model->getall_table_master_db();
	// 	foreach ($get_all_tables as $table){
	// 		if(!$this->client_db_model->create_tbl_client($table)){
	// 			echo "<br> TBL NOT   created ".$table; break;
	// 		}
	// 	}
	// }

	public function resetPassword($email_id){
		$subdomin = explode('//',explode('.',site_url())[0])[1];
		$check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
		if($check_subdomin != 0){
			$email_id = decode($email_id);		
			$this->session->set_userdata(['forgotemail'=>$email_id]);
			$dynamicDB = array(
	   			'hostname' 		=> 	$this->config->item('DBhost'),
				'username' 		=> 	$this->config->item('DBuser'),
				'password' 		=> 	$this->config->item('DBpassword'),
	   			'database' 		=> 	strtolower($subdomin),
	   			'dbdriver' 		=> 	'mysqli',
	   			'dbprefix' 		=> 	'',
	   			'pconnect' 		=> 	FALSE,
	   			'db_debug' 		=> 	TRUE,
	   			'cache_on' 		=> 	FALSE,
				'cachedir' 		=> 	'',
				'char_set' 		=> 	'utf8',
				'dbcollat' 		=> 	'utf8_general_ci',
				'swap_pre' 		=> 	'',
				'encrypt' 		=> 	FALSE,
				'compress' 		=> 	FALSE,
				'stricton' 		=> 	FALSE,
				'failover' 		=> 	array(),
				'save_queries' 	=> 	TRUE
	  		);
			$udata = $this->common->dynamicSelect($dynamicDB,['user_email' => $email_id,'client_reset_pwd'=>1]);
			//$udata =  $this->common->getWhere($table,[$select => $email_id,'client_reset_pwd'=>1]);
			if(!empty($udata)){
				$reset_time = strtotime($udata[0]->reset_pwd_time);
				$current_time = strtotime(date("Y-m-d H:i:s"));
				if($current_time < $reset_time){
					$this->load->view('reset_password');
				}
				else{
					echo "Password Link Expired";
				}
			}else{
				echo "Sorry Invalid Link";
			}		
		}
	}

	public function rPassword(){
        $this->form_validation->set_rules('client_password', 'Password', 'required|trim|min_length[7]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[client_password]|xss_clean');
		if ($this->form_validation->run() == FALSE) { 
         	$this->session->set_flashdata('client_password',form_error('client_password'));
         	$this->session->set_flashdata('confirm_password',form_error('confirm_password'));
         	echo "<script>window.location.reload(history.back());</script>";
		}
		else{
			$subdomin = explode('//',explode('.',site_url())[0])[1];
			$check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
			if($check_subdomin != 0){
				$dynamicDB = array(
		   			'hostname' 		=> 	$this->config->item('DBhost'),
					'username' 		=> 	$this->config->item('DBuser'),
					'password' 		=> 	$this->config->item('DBpassword'),
		   			'database' 		=> 	strtolower($subdomin),
		   			'dbdriver' 		=> 	'mysqli',
		   			'dbprefix' 		=> 	'',
		   			'pconnect' 		=> 	FALSE,
		   			'db_debug' 		=> 	TRUE,
		   			'cache_on' 		=> 	FALSE,
					'cachedir' 		=> 	'',
					'char_set' 		=> 	'utf8',
					'dbcollat' 		=> 	'utf8_general_ci',
					'swap_pre' 		=> 	'',
					'encrypt' 		=> 	FALSE,
					'compress' 		=> 	FALSE,
					'stricton' 		=> 	FALSE,
					'failover' 		=> 	array(),
					'save_queries' 	=> 	TRUE
		  		);
				$cpassword 	= $this->input->post('client_password');
				$password = password_hash($cpassword, PASSWORD_BCRYPT, ['cost' =>$this->config->item('cost')]);
				$udata = $this->common->dynamicSelect($dynamicDB,['user_email' => $this->session->userdata['forgotemail'],'client_reset_pwd'=>1]);
				$body 		= 	$this->load->view('email_template/password_reset','',true);
				$mail 		= 	send_email($this->session->userdata['forgotemail'],"Forgot Password",$body);
				if($mail == "success"){
					$query = $this->common->dynamicUpdate($dynamicDB,['user_password'=>$password,'client_reset_pwd' =>'0','reset_pwd_time'=>'NULL'],['user_email' => $this->session->userdata['forgotemail']]);
					//$query = $this->common->update_data($table,['user_password'=>$password,'client_reset_pwd' =>'0','reset_pwd_time'=>'NULL'],[$select => $this->session->userdata['forgotemail']]);
					// if(!empty($udata)){
					// 	$isAdmin = (int)$udata[0]->is_admin;
					// 	if($isAdmin == 1){
					// 		$client_db = $this->load->database('db3', TRUE);
					// 		$client_db->set('client_password',$password,FALSE);
					// 		$client_db->where('client_email',$this->session->userdata['forgotemail']);
					// 		$client_db->update('client');
					// 	}
					// }
					$this->session->set_flashdata('message','Password Change Successfully');
					redirect('login');
				}
				else{
					$this->session->set_flashdata('message','Some Error Please Try Again....');
					echo "<script>window.location.reload(history.back());</script>";				
		    	}
			}
		}
	}

	public function firstTimeLogin(){
		$this->load->view('change_password');
	}
	public function ChangeLoginPassword(){
		$this->form_validation->set_rules('client_password', 'Password', 'required|trim|min_length[7]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[client_password]|xss_clean');
		if ($this->form_validation->run() == FALSE) { 
         	$this->session->set_flashdata('client_password',form_error('client_password'));
         	$this->session->set_flashdata('confirm_password',form_error('confirm_password'));
         	echo "<script>window.location.reload(history.back());</script>";
		}
		else{
			$cpassword 	= $this->input->post('client_password');
			$password = password_hash($cpassword, PASSWORD_BCRYPT, ['cost' =>$this->config->item('cost')]);
			$query 		= 	$this->common->update_data('user',['user_password'=>$password,'is_first_login'=>2],['user_id' => $this->session->userdata['user_id']]);
			if($query == "data has successfully been updated"){
				$user_auth_info['is_first_login'] = 2;
				$user_auth_info['user_password'] = $password;
				redirect('logout');
				// print_r($user_auth_info);die;
				// landingPage();
			}
			else{
				redirect('reset-password');
			}
		}
	}
}
?>