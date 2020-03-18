<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public $client_id;
	public $subscriptionUser;
	public $subscriptionAgent;
	public $subscriptionEvaForm;
	public $subscriptionEvaFormVersion;
    public $subscriptionLeft;
	public $subscriptionPlanType;
    public $clientData;
    public $emp_group;
    public $emp_type;
    public $industry_type;
	public function __construct(){
		parent::__construct();
        $this->load->library('user_agent');
        if (!$this->session->userdata('emp_group') || !$this->session->userdata('log_insert_id')) {
            redirect('login','refresh');
            exit;
        }
        //echo "<pre>";
        $data['browser'] = $this->agent->browser();
        //$data['browserVersion'] = $this->agent->version();
        $data['platform'] = $this->agent->platform();
        //$data['full_user_agent_string'] = $_SERVER['HTTP_USER_AGENT'];
        $ip =  $this->getUserIpAddr();//$this->input->ip_address();
        
        //echo "</pre>";
        // insert data into log details table
            $client_db = $this->load->database('db3', TRUE);
            $log_details_data = ['log_id'=>$this->session->userdata('log_insert_id'),'module'=>$this->uri->uri_string(),'check_in'=>date('Y-m-d H:i:s')];
            $client_db->insert('log_details',$log_details_data);
        // insert data into log details table
		$this->load->model('common_model','common');
		$this->load->model('users_model');
		$this->load->model('client_db_model');
        $this->load->model('Agent_model', 'import');
		$this->load->model('hierarchy_management_model','hmm');
		$this->load->model('dump_model');
		$this->client_id =  $this->session->userdata('client_id');
        $this->emp_group =  $this->session->userdata('emp_group'); // 2 =>ops 3=>client 
        $this->emp_type  =  $this->session->userdata('usertype'); //  2=>agent 3=>supervisor 
        $this->industry_type = strtolower($this->session->userdata('industry_type'));
        // echo "<pre>";print_r($this->session->userdata());die;
        if(!empty($this->session->userdata('industry_type')) && strtolower($this->session->userdata('industry_type')) != 'bpo'){
            $this->emp_group =  ($this->emp_group  == '1') ? 'admin' : (($this->emp_group == '2') ? 'auditor' : (($this->emp_group == '3') ? 'reviewer':'manager')); // ops->evaluator_id
            // $this->emp_type  =  ($this->emp_type   == '1') ? 'admin':  ( ($this->emp_type == '2')  ? 'agent' : 'supervisor' );
        }else{
            $this->emp_group =  ($this->emp_group  == '1') ? 'admin' : ( ($this->emp_group == '2') ? 'ops'   : 'client' ); // ops->evaluator_id
            $this->emp_type  =  ($this->emp_type   == '1') ? 'admin':  ( ($this->emp_type == '2')  ? 'agent' : 'supervisor' );
        }
  		if(!empty($this->client_id)){
            $data = $this->common->getWhere('client',['client_id'=>$this->client_id]);
  			$logged_user_data = $this->common->getWhere('user',['user_id'=>$this->session->userdata('user_id')]);
            $this->clientData = $data;
            $first_names = array_column($logged_user_data, 'lob');
            if($logged_user_data[0]->is_first_login == 1){
                redirect('reset-password');
            }
  			if(count($data) > 0){
                $this->subscriptionPlanType = $data[0]->client_plan_type;
  				switch ($data[0]->client_plan_type) {
  					case '1':
  							$this->subscriptionUser				=	30;
							$this->subscriptionAgent			=	30;//log(0);
							$this->subscriptionEvaForm			=	15;  						
							$this->subscriptionEvaFormVersion	=	10;  						
  						break;
  					case '2':
  							$this->subscriptionUser				=	15;
							$this->subscriptionAgent			=	log(0);
							$this->subscriptionEvaForm			=	log(0);
							$this->subscriptionEvaFormVersion	=	10;
  						break;
  					case '3':
  							$this->subscriptionUser				=	30;
							$this->subscriptionAgent			=	log(0);
							$this->subscriptionEvaForm			=	log(0);
							$this->subscriptionEvaFormVersion	=	50;
  						break;
  					default:
  							$this->subscriptionUser				=	log(0);
							$this->subscriptionAgent			=	log(0);
							$this->subscriptionEvaForm			=	log(0);
							$this->subscriptionEvaFormVersion	=	log(0);
  						break;
  				}
  			}
  			// echo $this->subscriptionUser;
  			// echo $this->subscriptionAgent;
  			// echo $this->subscriptionEvaForm;
  			// die;
  		}
    }
    

    function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

}
