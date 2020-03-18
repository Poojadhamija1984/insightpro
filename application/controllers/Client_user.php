<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_user extends MY_Controller {
	
	public function index()
	{
		$data['title'] = 'User Registration';
		//get page ID
		 $clname = 'client_user';
		 //$data['pageid']= get_pageID($clname);
		 if($this->client_id)
		 {
			$data['user_type'] = $this->client_db_model->getall_user_type($this->session->userdata('client_id'));
			$usertype_id = '';
			foreach($data['user_type']  as $each_type)
			{
				if($each_type['usertype_name'] == 'Supervisor Analyst') {
					$usertype_id = $each_type['usertype_id']; 
				}
			}
			$data['sup_name'] = $this->client_db_model->get_supname($this->session->userdata('client_id'),$usertype_id);
			$data['lob'] = get_lob_from_hierarchy();
			$data['campaign'] = get_campaign_form_hierarchy();
			$data['vendor'] = get_vendor_form_hierarchy();
			$data['location'] = get_location_from_hierarchy();
		 }
		 if($this->input->post()){
			$this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('empid', 'Emp ID', 'trim|required');
			$this->form_validation->set_rules('usertype', 'User Type', 'trim|required');
			$this->form_validation->set_rules('user_email', 'Username', 'required|is_unique[user.username]');
			$this->form_validation->set_rules('doj', 'D.O.J', 'required');
		 }
		 else {
			 $this->load->view('admin/client_user_view' , $data);
		 }
	}
//please write above	
}
