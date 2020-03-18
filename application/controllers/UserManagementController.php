<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserManagementController extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$result = $this->common->update_data_info('client',['mokup_steps'=>'5'],['client_id'=>$this->session->userdata('client_id')]);
		$day_wise_total_sql ="select
    							u.user_id,u.name,u.user_email,is_admin as admin,(CASE WHEN u.is_admin = '1' THEN 'Admin' WHEN u.is_admin = '2' THEN 'Auditor' WHEN u.is_admin = '3' THEN 'Reviewer' WHEN u.is_admin = '4' THEN 'Manager' END) AS is_admin,(CASE WHEN u.status = '1' THEN 'Active' ELSE 'Inactive' END) AS status,
    							group_concat(DISTINCT c.g_name) as g,group_concat(DISTINCT s.s_name) as s
								from
    								user u
    							join groups c on find_in_set(c.g_id, u.u_group)
    							join sites s on find_in_set(s.s_id, u.site)
    							group by u.user_id";
		$day_wise_query = $this->db->query($day_wise_total_sql);
		//echo $this->db->last_query();
		//die;
        $day_wise_result = $day_wise_query->result();

        $site_sql = "SELECT g.g_name,g.g_id,group_concat(DISTINCT c.s_name) AS s
        				FROM
    					groups g
    					JOIN sites c ON find_in_set(c.s_id, g.g_site_id)
    					where g.g_name != 'Default Group1'
						group by g.g_id
						

					";
        $site_sql_query = $this->db->query($site_sql);
        $data['group'] = $site_sql_query->result();
		$data['users'] = $day_wise_result;
	//	print_r($data['users']);
		//die;
		$data['site'] = $this->common->getWhereSelectAll('sites',['s_name','s_id',"(CASE WHEN s_status = '1' THEN 'Active' ELSE 'Inactive' END)as s_status"],['s_created_by '=>$this->client_id,'s_name !='=>'Default Site' ]);
		$this->load->view('other/user_managment',$data);
	}

	public function getSites(){
		$data['site'] = $this->common->getWhereSelectAll('sites',['s_name as site_name','s_id as id'],['s_created_by '=>$this->client_id,'s_status'=>'1' ]);	
		echo postRequestResponse($data['site']);die;
	}
	public function groupBySite(){
		$post 	= $this->input->post();
		$new_user_site='';
		if(!empty($post['new_user_site'])){
			$new_user_site = implode(",",$post['new_user_site']);
		}
			$g_by_site = "SELECT * FROM groups WHERE g_site_id IN ($new_user_site)";
			$g_by_site_query = $this->db->query($g_by_site);
			$data['groups'] = $g_by_site_query->result();
			if(!empty($data['groups'])){
				echo postRequestResponse($data['groups']);die;
			}else{
				$data = ['status'=>'nodata'];
				echo postRequestResponse($data);die;
			}
			
	}
	public function getGroup(){
		$where = "";
		if($this->input->post('filter')){
			if($this->input->post('sites'))
			{
			$s   =  implode('|', explode(',',implode(',',$this->input->post('sites'))));
            $where  .=  'g_site_id REGEXP "(^|,)'.$s.'(,|$)"';
			}else{
				$s   =  implode('|', explode(',',$this->session->userdata('site')));
            $where  .=  'g_site_id REGEXP "(^|,)'.$s.'(,|$)"';
			}
			$g_site_sql = "SELECT g_id as value,g_name as name FROM groups WHERE $where";
        	$g_site_sql_query = $this->db->query($g_site_sql);
			$data['groups'] = $g_site_sql_query->result();
		}
		else{
			$data['groups'] = $this->common->getWhereSelectAll('groups',['g_name as group_name','g_id as value'],['g_created_by '=>$this->client_id]);
		}
		echo postRequestResponse($data['groups']);die;
	}
	public function getGroupBySite(){

	}	
	public function users($type,$id){
		//echo "test user";
		//die;
		if($type == "view" && $id){
			$user_sql ="select
    						u.user_id,u.name,u.user_email,(CASE WHEN u.is_admin = '1' THEN 'Admin' WHEN u.is_admin = '2' THEN 'Auditor' WHEN '3' THEN 'Reviewer' END) AS is_admin,(CASE WHEN u.status = '1' THEN 'Active' ELSE 'Inactive' END) AS status,u.profile_img,
    						group_concat(DISTINCT c.g_name) as g,group_concat(DISTINCT s.s_name) as s
							from
    							user u
    						join groups c on find_in_set(c.g_id, u.u_group)
    						join sites s on find_in_set(s.s_id, u.site)
    						where u.user_id = ".$id."
    						group by u.user_id
						";
        	$day_wise_query = $this->db->query($user_sql);
			$day_wise_result = $day_wise_query->result();
			
			$data['users'] = (!empty($day_wise_result)?$day_wise_result[0]:[]);
			
			$this->load->view('other/view_users',$data);
		}
		else{
			if($type == "edit" && $id){
				$user = $this->common->getWhereSelectAll('user',['name','site','u_group as group','user_email as email','is_admin as role','status'],['user_id'=>$id]);
				$data['user'] = ((!empty($user)?$user[0]:''));
			}
			$data['group'] = $this->common->getWhereSelectAll('groups',['g_name','g_id'],['g_created_by '=>$this->client_id ]);
			$data['site'] = $this->common->getWhereSelectAll('sites',['s_name','s_id',"(CASE WHEN s_status = '1' THEN 'Active' ELSE 'Inactive' END)as s_status"],['s_created_by '=>$this->client_id ]);
			// $this->load->view('other/users',$data);
			/*echo "<pre>";
			print_r($data['site']);
			die;
			*/
			echo postRequestResponse($data);die;
		}
	}
	public function addGroup(){
		$post = $this->input->post();
		$group = $post['add_group'];
		//$sites = implode(',',$post['sites']);
		$sites = $post['sites'];

		if(isset($post['add']) && $post['add']){
			$site_details = $this->common->getWhereSelectAll('groups',['g_name'],['g_created_by '=>$this->client_id,'g_name'=>$group,'g_site_id'=>$sites]);
			if(empty($site_details)){
				$data = ['g_created_by'=>$this->client_id,'g_name'=>$group,'g_site_id'=>$sites,'g_created_date'=>date('Y-m-d')];
				$last_id = $this->common->insert_data($data,'groups');
				$data = ['status'=>'success','id'=>$last_id];
			}else{
				$data = ['status'=>'error','id'=>''];
			}
		}
		echo postRequestResponse($data);die;		
	}
	public function addSite(){
		$post = $this->input->post();
		$site = $post['add_site'];
		if(isset($post['add']) && $post['add']){
			$site_details = $this->common->getWhereSelectAll('sites',['s_name'],['s_created_by '=>$this->client_id,'s_name'=>$site]);
			if(empty($site_details)){
				$data = ['s_created_by'=>$this->client_id,'s_name'=>$site,'s_created_date'=>date('Y-m-d')];
				$last_id = $this->common->insert_data($data,'sites');
				$data = ['status'=>'success','id'=>$last_id];
			}else{
				$data = ['status'=>'error','id'=>''];
			}
		}
		echo postRequestResponse($data);die;
	}
	public function deleteSite(){
		$post 	= $this->input->post();
		$id 	= $post['did'];
		$gdata = $this->common->getFindInSet('groups','g_id',$id,'g_site_id');
		//echo "query--".$this->db->last_query();
		//die;
		if(!empty($gdata)){
			$data = ['status'=>'error','msg'=>'Sorry you can\'t delete. This site associated with group'];
		}else{
			$this->common->delete_data('sites',['s_id'=>$id]);
			$data = ['status'=>'success','msg'=>'Site delete Successfully'];
			
		}
		echo postRequestResponse($data);die;
	}

	public function editSite(){
		
		$post 	= $this->input->post();
		$site_id 	= $post['edit_site_id'];
		$site_name 	= $post['edit_site_val'];
		
		$data = array(
			's_name'=>$site_name
		);
		$where = array(
			's_id'=>$site_id
		);
		$gdata = $this->common->update_data('sites',$data,$where);
		if($gdata=='not updated'){
			$data = ['status'=>'error','msg'=>'Sorry you can\'t Edit'];
		}else{
			$data = ['status'=>'success','msg'=>'Site has been Updated Successfully'];
		}
		echo postRequestResponse($data);die;
		
	}
	// edit group

	public function editGroup(){
		$post 	= $this->input->post();
		$g_id 	= $post['edit_group_id'];
		$g_name 	= $post['edit_group_val'];
		
		$data = array(
			'g_name'=>$g_name
		);
		$where = array(
			'g_id'=>$g_id
		);
		$gdata = $this->common->update_data('groups',$data,$where);
		if($gdata=='not updated'){
			$data = ['status'=>'error','msg'=>'Sorry you can\'t Edit'];
		}else{
			$data = ['status'=>'success','msg'=>'Group Updated Successfully'];
		}
		echo postRequestResponse($data);die;
		
	}
	
	public function deleteGroup(){
		$post = $this->input->post();
		$id = $post['did'];
		$gdata = $this->common->getFindInSet('user','user_id',$id,'u_group');
		if(!empty($gdata)){
			$data = ['status'=>'error','msg'=>'Sorry you can\'t delete. This group associated with user'];
		}else{
			$g_sitedata = $this->common->getFindInSet('groups','g_site_id',$id,'g_id');
			
			if($g_sitedata){
				$s_id = $g_sitedata[0]['g_site_id'];
				$this->common->delete_data('sites',['s_id'=>$s_id]);

			}
			$this->common->delete_data('groups',['g_id'=>$id]);
			$data = ['status'=>'success','msg'=>'Group delete Successfully'];
			
		}
		echo postRequestResponse($data);die;
	}
	public function addUser(){
		
		$post 	= 	$this->input->post();
		
		$name 	= 	$post['name'];
		$email 	= 	$post['email'];
		if(!empty($post['group'])){
			$group 	= 	implode(',',$post['group']);
			//$group 	= 	$post['group'];
			$g_site_sql = "SELECT group_concat(DISTINCT g_site_id) AS s 
						FROM groups  
						WHERE 
						find_in_set(g_id,'$group')
					";
        	$g_site_sql_query = $this->db->query($g_site_sql);
        	$res = $g_site_sql_query->result();
        	$g_site_data = (!empty($res)?$res[0]->s:[]);
        	$site = implode(',',array_unique(explode(',', $g_site_data)));
        }
        // echo postRequestResponse($site);die;
		

		$site 	= 	implode(',',$post['site']);
		//$site 	= 	$post['site'];
		$role 	= 	$post['role'];
		$method	=	$post['method'];
		$id		=	isset($post['id'])?$post['id']:'';
		$data 	= 	[
						'client_id' 			=>	$this->client_id,
						'name' 					=>	$name,
						'user_email'			=>	$email,
						'usertype'				=>	$role,
						'is_admin'				=>	$role,
						'u_group'				=>	(!empty($group)?$group:'1'),
						'site'					=>	(!empty($site)?$site:'1'),
						'user_created_date'		=>	date('Y-m-d'),
						'user_updated_date'		=>	date('Y-m-d'),
						'client_reset_pwd'		=>	0,
						'is_first_login'		=>	1,
					];
	
		if($method == "add"){
			$user_vali = $this->common->getWhereSelectAll('user',['user_email'],['user_email '=>$email]);
			if(!empty($user_vali)){
				$this->session->set_flashdata('error','Email already exist');
				$successData = ['massage'=>'Email already exist'];
				echo postRequestResponse($successData);die;
			}
			$data['user_password'] = password_hash($this->config->item('default_password'), PASSWORD_BCRYPT, ['cost' =>$this->config->item('cost')]);
			$data['status']	=	1;
			// print_r($data);die;
			$last_id = $this->common->insert_data($data,'user');
			$body = $this->load->view('email_template/team_creation',$data,true);
			$mail = send_email($email,'Login Credentials',$body);
			$this->session->set_flashdata('message','User Added Successfully!');
			$successData = ['name' => $name,'user_email' =>	$email,'role'=>	$role,'u_group'=>(!empty($group)?$group:''),'site'=>(!empty($site)?$site:''),'massage'=>'User Added Successfully','id'=>encode($last_id)];
			echo postRequestResponse($successData);die;	
			//redirect("user-management/users");
		}
		else{
			
			unset($data['user_email']);
			//print_r($data);
			//die;
			$last_id = $this->common->update_data('user',$data,['user_id'=>$id]);
			$this->session->set_flashdata('message','User Update Successfully!');
			// redirect("user-management/users/edit/$id");
			$successData = ['name' => $name,'user_email' =>	$email,'role'=>	$role,'u_group'=>$group,'site'=>	$site,'massage'=>'User Update Successfully','id'=>$id];
			echo postRequestResponse($successData);die;	
		}
	}
	public function deleteUser(){
		$post 	= 	$this->input->post();
		$last_id = $this->common->update_data('user',['status'=>$post['status']],['user_id'=>decode($post['id'])]);
		$data = ['status'=>'success'];
		echo postRequestResponse($data);die;		
	}

	public function userBulkUpload(){
		ini_set('memory_limit', '-1');
		$this->load->library('excel');
    	$client_id = $this->client_id;
    	$emp_data = [];
    	if ($_FILES) {
          	$path 						= 	'assets/upload/userBulkUpload/';
            $config['upload_path'] 		= 	$path;
            $config['allowed_types'] 	= 	'xlsx|xls|csv';
            $config['remove_spaces'] 	= 	TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
            	echo postRequestResponse($this->upload->display_errors());die;
               	// $error = array('error' => $this->upload->display_errors());
               	// print_r($error);die;
            } else {
               	$data = array('upload_data' => $this->upload->data());
            }
            if (!empty($data['upload_data']['file_name'])) {
               	$import_xls_file = $data['upload_data']['file_name'];
            } else {
               	$import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
               	$inputFileType 	= PHPExcel_IOFactory::identify($inputFileName);
               	$objReader 		= PHPExcel_IOFactory::createReader($inputFileType);
               	$objPHPExcel 	= $objReader->load($inputFileName);
            } catch (Exception $e) {
               	die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME). '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray 	= ['Name','Email','Password','Role','Site','Group'];
            $makeArray 	= [
        					'Name'		=> 'Name',
        					'Email'		=> 'Email',
        					'Password'	=> 'Password',
        					'Role'		=> 'Role',
        					'Site'		=> 'Site',
        					'Group'		=> 'Group'
						];            	
	        $SheetDataKey = array();
	        foreach ($allDataInSheet as $dataInSheet) {
	            foreach ($dataInSheet as $key => $value) {
	                if (in_array(trim($value), $createArray)) {
	                    $value = preg_replace('/\s+/', '', $value);
	                    $SheetDataKey[trim($value)] = $key;
	                } else {
	                }
	            }
	        }
	        $data = array_diff_key($makeArray, $SheetDataKey);
	        $agentInvalidCount = 0;
	        if (empty($data)) {
	            $flag = 1;
	        }
			if ($flag == 1) {
	            for ($i = 2; $i <= $arrayCount; $i++) {
	                $addresses 				= 	array();
	                $Name 					= 	$SheetDataKey['Name'];
	                $Email 					= 	$SheetDataKey['Email'];
	                $Password 				= 	$SheetDataKey['Password'];
	                $Role 					= 	$SheetDataKey['Role'];
	                $Site 					= 	$SheetDataKey['Site'];
	                $Group 					= 	$SheetDataKey['Group'];
	            
	                $Name 					= 	filter_var(trim($allDataInSheet[$i][$Name]), FILTER_SANITIZE_STRING);
	                $Email 					= 	filter_var(trim($allDataInSheet[$i][$Email]), FILTER_SANITIZE_EMAIL);
	                $Password 				= 	$allDataInSheet[$i][$Password];
	                $Role 					= 	strtolower(filter_var(trim($allDataInSheet[$i][$Role]), FILTER_SANITIZE_STRING));
	                $Site 					= 	filter_var(trim($allDataInSheet[$i][$Site]), FILTER_SANITIZE_STRING);
	                $Group 					= 	filter_var(trim($allDataInSheet[$i][$Group]), FILTER_SANITIZE_STRING);
	                $Role 					=  	($Role  == 'admin') ? '1' : (($Role == 'auditor') ? '2' : (($Role == 'reviewer') ? '3':'4'));
	                $user_details 			=	$this->common->getWhereSelectAll('user','user_id',['user_email'=>$Email]);
	                if(empty($user_details)){
	                	$site_id 				= 	$this->siteDetails($Site);
	                	$group_id 				=	$this->geropDetails($site_id,$Group);
	                	$emp_data[] = [
	                					'client_id'			=>	$this->client_id,
    									'name'				=>	$Name,
    									'user_email' 		=>	$Email,
										'user_password' 	=>	$this->getPassword($Password),
										'usertype'			=>	$Role,
										'is_admin'			=>	$Role,
										'site'				=>	$site_id,
										'u_group' 			=>	$group_id,
										'status'			=>	'1',
										'user_created_date'	=>	date('Y-m-d'),
										'user_updated_date'	=>	date('Y-m-d'),
										'is_first_login'	=>	'1'
        							];
        			}
	                @unlink($inputFileName);
	            }
	            if(!empty($emp_data)){
	            	$insert_batch_data_id = $this->common->insert_batch_data('user',$emp_data);
	            	$msg = 'User added Successfully!';
	            }
	            else{
	            	$msg = 'User added Successfully!';
	            }
	            //redirect('agent_roster_upload', 'refresh');
	        }
            else {
            	//$this->session->set_flashdata('error', '<div class="alert alert-success text-center">Please Upload correct file</div>');
                $msg = "Please upload correct file";
                //redirect('agent_roster_upload', 'refresh');
            }

            echo postRequestResponse($msg);
        }
	}



	public function getPassword($pwd){
		if(!empty($pwd))
			return password_hash($pwd, PASSWORD_BCRYPT, ['cost' =>$this->config->item('cost')]);
		else
			return password_hash($this->config->item('default_password'), PASSWORD_BCRYPT, ['cost' =>$this->config->item('cost')]);
	}

	public function siteDetails($Site){
		if(!empty($Site)){
			$Site = explode(',', $Site);
			$last_id = '';
			foreach ($Site as $key => $value) {
				$sites_data = $this->common->getWhereSelectAll('sites',['s_id'],['s_name'=>$value]);
				$last_id .= (!empty($sites_data)?$sites_data[0]->s_id.',':null);
				if(empty($sites_data)){
					$data = ['s_created_by'=>$this->client_id,'s_name'=>$value,'s_created_date'=>date('Y-m-d')];
					$site_inserted_id = $this->common->insert_data($data,'sites');
					$last_id .= $site_inserted_id.',';
				}
			}
			return rtrim($last_id,',');
		}
		else{
			return '';
		}
	}

	public function geropDetails($site_id=null,$groups=null){
		if(!empty($site_id) && !empty($groups)){
			$last_id = '';
			$group = explode(',', $groups);
			foreach ($group as $key => $value) {
				$group_sql ="SELECT g_id FROM groups WHERE g_name = '$value' AND g_site_id = '$site_id'";
				$group_query = $this->db->query($group_sql);
            	$group_result = $group_query->result();
            	$last_id .= (!empty($group_result)?$group_result[0]->g_id.',':null);
            	if(empty($group_result)){
            		$data = ['g_created_by'=>$this->client_id,'g_name'=>$value,'g_site_id'=>$site_id,'g_created_date'=>date('Y-m-d')];
					$group_inserted_id = $this->common->insert_data($data,'groups');
					$last_id .= $group_inserted_id.',';
            	}
			}
			return rtrim($last_id,',');
		}
		else{
			return '';
		}
	}
//please write above	
}
