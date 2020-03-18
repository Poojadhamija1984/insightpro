<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->lang->load('subscription_lang','subscription');
	}
	
	public function userRole(){
		$data['role'] = $this->common->getAllData('role');
		$this->load->view('admin/add_role',$data);
	}
	public function userRoleData(){
		$roleData = $this->input->post('add_role');
		if(!empty($roleData[0])){
			foreach ($roleData as $key => $value) {
				$checkData = $this->common->getWhere('role',['name'=>$value]);
				if(empty($checkData))
					$data[] = ['name'=>$value,'client_id'=>$this->client_id,'status'=>'1'];
			}
			if(!empty($data)){
				$data = $this->common->insert_batch_data('role',$data);
			}
			$this->session->set_flashdata('success','User Role Added Successfully!');
		}
		else{
			$this->session->set_flashdata('error','Please Enter User Role!');
		}
		redirect('add_role');
	}
	public function userRoleDelete(){
		$id =  $this->input->input_stream('id');
		$data = $this->common->getWhere('user',['usertype'=>$id]);
		if(isset($data)){
			$this->session->set_flashdata('error','You can\'t delete this role because associated with users!');
		}
		else{
			$this->common->delete_data('role',['id'=>$id]);
			$this->session->set_flashdata('success','Role Delete Successfully!');	
		}
		//redirect('add_role');
	}
	public function userRoleUpdate(){
		$id = $this->input->input_stream('id');
		$status = $this->input->input_stream('status');
		$data = $this->common->getWhere('user',['usertype'=>$id]);
		if(isset($data) && $status == 0){
				$this->session->set_flashdata('error','You can\'t Inactive this role because associated with users!');
		}
		else{
			$this->common->update_data('role',['status'=>$status],['id'=>$id]);
			echo $this->db->last_query();
			$this->session->set_flashdata('success','Role '.(($status == 0)?"Inactive":"Active").' Successfully!');	
		}
	}
	
	public function AddUser(){
		$data['role']	=	$this->common->getWhere('role',['client_id'=>$this->client_id,'status'=>'1']);
		$udata = $this->common->getWhere('user',['is_admin !='=>'1']);
		foreach ($udata as $key => $value) {
			$empdata[] = [
				'user_id' 			=> 	$value->user_id,
				'client_id'			=>	$value->client_id,
				'name'				=>	$value->name,
				'empid'				=>	$value->empid,
				'usertype'			=>	$this->common->getWhereSelect('role','name',['id'=>(int)$value->usertype],1,0),
				'user_email'		=>	$value->user_email,
				'doj'				=>	$value->doj,
				'sup_id'			=>	$value->sup_id,
				'sup_name'			=>	$value->sup_name,
				'lob'				=>	$value->lob,
				'campaign'			=>	$value->campaign,
				'vendor'			=>	$value->vendor,
				'location'			=>	$value->location,
				'user_password'		=>	$value->user_password,
				'page_permission'	=>	$value->page_permission,
				'form_permission'	=>	$value->form_permission,
				'is_admin'			=>	$value->is_admin,
				'status'			=>	$value->status,
				'profile_img'		=>	$value->profile_img,
				'user_created_date'	=>	$value->user_created_date,
				'user_updated_date'	=>	$value->user_updated_date,
			];
		}
		$data['emp_info'] = $empdata;

		$this->load->view('admin/add_user',$data);
	}
	public function AddUserData(){
    	$this->form_validation->set_rules('user_name', 'Employee Name', 'required|trim');
    	$this->form_validation->set_rules('empid', 'Employee Id', 'required|trim');
		$this->form_validation->set_rules('role', 'Role', 'required|trim');
    	$this->form_validation->set_rules('email', 'User Email', 'valid_email|required|trim');
    	$this->form_validation->set_rules('doj', 'DOJ', 'required|trim');
    	$this->form_validation->set_rules('password', 'Password', 'required|trim');
    	if ($this->form_validation->run() == FALSE){
    		echo "error";
            if (form_error('user_name')) {
                $this->session->set_flashdata('user_name','Please Enter Employee Name');
            }
            if (form_error('empid')) {
                $this->session->set_flashdata('empid','Please Enter Employee Id');
            }    		
    		if (form_error('role')) {
                $this->session->set_flashdata('role','Please Select User Type');
            }
            if (form_error('email')) {
                $this->session->set_flashdata('email','Please Enter User Email');
            }
            if (form_error('doj')) {
                $this->session->set_flashdata('doj','Please Enter DOJ');
            } 
            if (form_error('password')) {
                $this->session->set_flashdata('password','Please Enter Password');
            }
    	}
    	else{
			$user_name 	= $this->input->post('user_name');
			$role 		= $this->input->post('role');
			$email 		= $this->input->post('email');
			$emp 		= $this->input->post('empid');
			$password 	= $this->input->post('password');
			$doj 		= $this->input->post('doj');
			$userdata = [
				'client_id'			=>	$this->client_id,
				'name'				=>	filter_var(trim($user_name), FILTER_SANITIZE_STRING),
				'empid'				=>	filter_var(trim($emp), FILTER_SANITIZE_STRING),
				'usertype'			=>	filter_var(trim($role), FILTER_VALIDATE_INT),
				'user_email'		=>	filter_var(trim($email), FILTER_SANITIZE_EMAIL),
				'doj'				=>	date('Y-m-d',strtotime($doj)),
				'user_password'		=>	password_hash($password, PASSWORD_BCRYPT, ['cost'=>$this->config->item('cost')]),
				'is_admin'			=>	'0',
				'status'			=>	'1',
				'user_created_date'	=>	date('Y-m-d Y-m-d H:i:s'),
				'user_updated_date'	=>	date('Y-m-d Y-m-d H:i:s')
			];
			//$emailVali = $this->common->getWhere('user',['client_id'=>$this->client_id,'is_admin !=' => '1']);
			$ad = $this->common->getWhere('user',['client_id'=>$this->client_id,'is_admin !=' => '1']);
			$to = "santosh.jaiswal@mattsenkumar.net";
			$subject = "test email helper";
			$body = $this->load->view('email_template/Client_user_registration',$userdata, TRUE);
				
			if((int)$this->subscriptionUser > count($ad) && !is_infinite($this->subscriptionUser)){
				$this->common->insert_data($userdata,'user');	
				send_email($to,$subject,$body);
				$this->session->set_flashdata('success','User Addedd Successfully!');
    		}
    		else if(is_infinite($this->subscriptionUser)){
    			$this->common->insert_data($userdata,'user');
    			send_email($to,$subject,$body);
    			$this->session->set_flashdata('success','User Addedd Successfully!');
    		}
    		else{
    			$this->session->set_flashdata('error',$this->lang->line('user_error'));
    		}
			redirect('add_user');
		}
	}
	public function EditUser($id){
		$data['userData'] = $this->common->getWhere('user',['client_id'=>$this->client_id,'is_admin !=' => '1','user_id'=>$id]);
		$data['role']	=	$this->common->getWhere('role',['client_id'=>$this->client_id,'status'=>'1']);
		$this->load->view('admin/edit_user',$data);
	}
	public function EditUserData(){
		$user_name 	= $this->input->post('user_name');
		$empid 		= $this->input->post('empid');
		$role 		= $this->input->post('role');
		$email 		= $this->input->post('email');
		$doj 		= $this->input->post('doj');
		$user_id 	= $this->input->post('user_id');
		$userdata = [
				'client_id'			=>	$this->client_id,
				'name'				=>	filter_var(trim($user_name), FILTER_SANITIZE_STRING),
				'empid'				=>	filter_var(trim($empid), FILTER_SANITIZE_STRING),
				'usertype'			=>	filter_var(trim($role), FILTER_VALIDATE_INT),
				'user_email'		=>	filter_var(trim($email), FILTER_SANITIZE_EMAIL),
				'doj'				=>	date('Y-m-d',strtotime($doj)),
				'user_updated_date'	=>	date('Y-m-d Y-m-d H:i:s')
			];
		$this->common->update_data('user',$userdata,['user_id'=>$user_id]);
		$this->session->set_flashdata('success','User Updated Successfully!');	
		redirect('add_user');
	}
	
	public function userPermission($id){
		
		$data['title']	=	'User Permission';
		$data['user']	=	$this->common->getWhere('user',['client_id'=>$this->client_id,'is_admin !=' => '1','status'=>'1']);
		$data['id']		=	$id;
		$data['permissions']	=	$this->common->getWhere('page_ids',['controller_name !='=>'#']);
		if($id)
			$data['user_permission']	=	$this->common->getWhereSelect('user','page_permission',['user_id'=>$id]);
		else
			$data['user_permission'] = '';
		$this->load->view('admin/add_permission',$data);
	}
	public function userPermissionData(){
		$user = $this->input->post('add_role');
		$pageid = implode(',', $this->input->post('page'));
		foreach ($user as $key => $value) {
			$this->common->update_data('user',['page_permission'=>$pageid],['user_id'=>$value]);
		}
		$this->session->set_flashdata('success','User Permission Added Successfully!');
		redirect('user_permission');
	}
//please write above	
}
