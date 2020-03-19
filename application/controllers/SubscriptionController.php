<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriptionController extends MY_Controller {
	public function index(){
		
		
		$data['title'] = 'Payment';
		$data['cinfo']	=	$this->clientData[0]; // client info
		$client_db = $this->load->database('db3', TRUE);
		$client_db->select ('*');
		$client_db->from ('subscription_details');
		$query = $client_db->get();
		$data['pinfo'] = $query->result_array();
  	
		$this->load->view('subscription/subscription',$data);
	}
	
}