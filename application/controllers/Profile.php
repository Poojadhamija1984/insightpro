<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	
	public function index() {
		$data['title'] = 'User Profile';
		$this->load->view('common/user_profile_view',$data);
	}
	
    public function change_password() {
        $this->form_validation->set_rules('cur_pass', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required|trim|min_length[7]|max_length[30]');
		$this->form_validation->set_rules('cnf_pass', 'Confirm Password', 'required|trim|matches[new_pass]');
		
		if ($this->form_validation->run() == FALSE) {
            $ajax_response = array("status" => "failure", "message" => array_values($this->form_validation->error_array())[0]);
		} else{
            $cur_pass   = $this->input->post('cur_pass');
			$new_pass   = password_hash($this->input->post('new_pass'), PASSWORD_BCRYPT, ['cost' =>$this->config->item('cost')]);
            $user_id    = $this->session->userdata('user_id');
            $user_pass  = $this->common->getWhereSelectAll('user', ['user_password'], ['user_id' => $user_id]);
            
            if (!password_verify($cur_pass, $user_pass[0]->user_password)){
                $ajax_response = array("status" => "failure", "message" => "Current Password is Incorrect.");
            } else {
                
                if (password_verify($cur_pass, $new_pass)){
                    $ajax_response = array("status" => "failure", "message" => "New Password and Current Password can't be same.");
                } else {
                    $data['user_password'] = $new_pass;
                    $query = $this->users_model->update_data($data,'user_id', $user_id,'user');
                    if($query){
                        $ajax_response = array("status" => "success", "message" => "Password has been Changed successfully.");
                    } else {
                        $ajax_response = array("status" => "failure", "message" => "Something went wrong in Password Changed try again...");
                    }
                }
            }
		}
        echo postRequestResponse($ajax_response);
	}
	
	public function profile_pic_upload() {
        
        if(!is_dir('./assets/upload/'.$this->session->userdata('client_db_name'))) {
            mkdir('./assets/upload/'.$this->session->userdata('client_db_name'),0777, TRUE);
        }
        
        $folderPath              ='./assets/upload/'.$this->session->userdata('client_db_name');
        $file_name               = $this->session->userdata('empid').'_'.strtotime(date("Y-m-d H:i:s")).'_'.$_FILES['profile_img']['name'];
        $config['upload_path']   = $folderPath;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 1000;
        $config['file_name']     = $file_name;
        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('profile_img')) {
            $ajax_response = array("status" => "failure", "message" => $this->upload->display_errors());
        } else {
            if($this->session->userdata('profile_img')!=''){
                @unlink($this->session->userdata('profile_img'));
            }
            $upload_data = $this->upload->data();
            $user_id = $this->session->userdata('user_id');
            $data['profile_img'] = 'assets/upload/'.$this->session->userdata('client_db_name').'/'.$upload_data['file_name'];
            $query = $this->users_model->update_data($data,'user_id', $user_id,'user');
            if($query) {
                $this->session->set_userdata( array( 'profile_img'  => $data['profile_img']));
                $ajax_response = array("status" => "success", "message" => "Image upload successfully.", "image"=> base_url().'/'.$data['profile_img']);
            } else {
                $ajax_response = array("status" => "failure", "message" => "Something went wrong in image upload try again...");
            }
            echo postRequestResponse($ajax_response);
        }
	}
}
