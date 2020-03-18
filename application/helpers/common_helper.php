<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	/// channels type
	function channels($selval=null){
		$channels = ['call'=>'Call','email'=>'Email','chat'=>'Chat','social media'=>'Social Media'];
		//$channels = ['form_qa'=>'QA Form'];
		return $channels ;
	}

	///Get alert type for email notification 

	function getAlertType(){
		$alerType = ['autofailed' => 'AutoFailed', 'escalation' => 'Escalation','calibration'=>'Calibration','KPI' =>'KPI Metrix'];
  		return $alerType; 
	}

	function send_email($to,$subject,$body) {
		$ci = get_instance();
		$ci->load->library('email');
		$config['protocol'] 	= "smtp";
		$config['smtp_host'] 	= $ci->config->item('smtp_host');
		$config['smtp_port'] 	= $ci->config->item('smtp_port');
		$config['smtp_user'] 	= $ci->config->item('smtp_user');
		$config['smtp_pass'] 	= $ci->config->item('smtp_pass');
		$config['charset'] 		= $ci->config->item('charset');
		$config['mailtype'] 	= $ci->config->item('mailtype');
		$config['smtp_crypto'] 	= $ci->config->item('smtp_crypto');
		$config['wordwrap'] 	= $ci->config->item('wordwrap');
		$config['mailtype'] 	= $ci->config->item('mailtype');
		$config['newline'] 		= "\r\n";
		$config['crlf'] 		= "\r\n";
		$ci->email->initialize($config);
		//$ci->email->set_newline("\r\n");
		//$ci->email->set_mailtype("html");
		$ci->email->from($ci->config->item('smtp_user'), 'InsightPro');
		$ci->email->to($to);
		$ci->email->subject($subject);
		$ci->email->message($body);
		if($ci->email->send()){
			return 'success';
		}
		else{
			 return 'false';
			//return $ci->email->print_debugger();
			// return show_error($ci->email->print_debugger());
			//return $ci->email->print_debugger();
		}
	}
	
	// check unauthorised access
	function check_access($pageid,$prp){
		$CI =& get_instance();
		$prp = explode(',' ,$prp);
		if(in_array($pageid,$prp)){
			return true;
		} else {
			return false;
		}
	}

	// Get User type
	function get_user_type($usertypeID,$empGroupID){
		$CI =& get_instance();
		if($CI->industry_type == "bpo") {
		if($usertypeID ==3 && $empGroupID ==3){
			echo "Client Supervisor";
		}
		elseif($usertypeID ==3 && $empGroupID ==2){
			echo "Ops Supervisor";
		}
		elseif ($usertypeID ==2 && $empGroupID ==3){
			echo "Client Agent";
		}
		elseif ($usertypeID ==2 && $empGroupID ==2) {
			echo "Ops Agent";
		}
		else {
			echo "Admin";
		}
     } else{
     	echo ucfirst($CI->emp_group);
     }

  }

	// Get page id by controller and function
	function get_pageID($clname){
		$CI =& get_instance();
		$CI->db->select('id');
		$CI->db->from('page_ids');
		if($CI->session->userdata['client_id']){
			$CI->db->where('client_id' ,$CI->session->userdata['client_id']);
		}
		$CI->db->where('controller_name',$clname);
		$result = $CI->db->get();
		//$CI->db->last_query(); die;
		$row = $result->row_array();
		return $row['page_id'];
	}

	function leftMenu(){
		$CI =& get_instance();
		//$userdetaila = getUserDetailByUserName($CI->session->userdata['mailid'],$CI->config->item('db_encryption_key'));
		//$prp = $userdetaila['page_permission'];
		$CI->db->from('page_ids');
		//$CI->db->where("id IN (".$prp.")",NULL, false);
    	$CI->db->where('status','1');
    	$CI->db->where('id !=','52');
		$CI->db->group_by('page_name');
		$CI->db->order_by('id');
		$result = $CI->db->get();
		return $result->result_array();
		//return $CI->db->last_query(); 
	}

	function countSubmenu($pagename){
		$CI =& get_instance();
		//$userdetaila = getUserDetailByUserName($CI->session->userdata['mailid'],$CI->config->item('db_encryption_key'));
		//$prp = $userdetaila['page_permission'];
		$CI->db->select('subpage_name');
		$CI->db->from('page_ids');
		//$CI->db->where("id IN (".$prp.")",NULL, false);
    	$CI->db->where('status','1');
		$CI->db->where('page_name',$pagename);
		$CI->db->where('subpage_name !=','');
		$result = $CI->db->get();
		return $result->num_rows();
	}
	function getSubmenu($pagename){
		$CI =& get_instance();
		//$userdetaila = getUserDetailByUserName($CI->session->userdata['mailid'],$CI->config->item('db_encryption_key'));
		//$prp = $userdetaila['page_permission'];
		$CI->db->from('page_ids');
		//$CI->db->where("id IN (".$prp.")",NULL, false);
    	$CI->db->where('status','1');
		$CI->db->where('page_name',$pagename);
		$CI->db->where('subpage_name !=','');
		$result = $CI->db->get();
		//echo $CI->db->last_query();
		return $result->result_array();
	}

	function get_lob_from_hierarchy(){
		$CI =& get_instance();
		$CI->db->select("lob");
    	$CI->db->from("hierarchy");
    	if($CI->session->userdata['client_id']){
			$CI->db->where('client_id' ,$CI->session->userdata['client_id']);
		}
		$CI->db->group_by('lob');
		return $result = $CI->db->get()->result_array();
	}

	function get_campaign_form_hierarchy(){
		$CI =& get_instance();
     	$CI->db->distinct();
		$CI->db->select("campaign");
    	$CI->db->from("hierarchy");
    	if($CI->session->userdata['client_id']){
			$CI->db->where('client_id' ,$CI->session->userdata['client_id']);
		}
		//$CI->db->group_by('campaign');
		return $result = $CI->db->get()->result_array();
	}

	function get_vendor_form_hierarchy(){ 
		$CI =& get_instance();
		$CI->db->select("vendor");
    	$CI->db->from("hierarchy");
    	if($CI->session->userdata['client_id']){
			$CI->db->where('client_id' ,$CI->session->userdata['client_id']);
		}
		$CI->db->group_by('vendor');
		return $result = $CI->db->get()->result_array();
	}

	function get_location_from_hierarchy(){
		$CI =& get_instance();
		$CI->db->select("location");
	    $CI->db->from("hierarchy");
	    if($CI->session->userdata['client_id']){
			$CI->db->where('client_id' ,$CI->session->userdata['client_id']);
		}
		$CI->db->group_by('location');
		return $result = $CI->db->get()->result_array();
	}   

	function encrypt($plaintext, $salt){
	    $td = mcrypt_module_open('cast-256', '', 'ecb', '');
	    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	    mcrypt_generic_init($td, $salt, $iv);
	    $encrypted_data = mcrypt_generic($td, $plaintext);
	    mcrypt_generic_deinit($td);
	    mcrypt_module_close($td);
	    $encoded_64 = base64_encode($encrypted_data);
	    return trim($encoded_64);
    }

    function decrypt($crypttext, $salt){
	    $decoded_64=base64_decode($crypttext);
	    $td = mcrypt_module_open('cast-256', '', 'ecb', '');
	    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	    mcrypt_generic_init($td, $salt, $iv);
	    $decrypted_data = mdecrypt_generic($td, $decoded_64);
	    mcrypt_generic_deinit($td);
	    mcrypt_module_close($td);
	    return trim($decrypted_data);
    }

    // creation of client db 
    function ClientDB($client_id,$industry_type){
    	$CI =& get_instance();
		// create dynamic database for client
		if(!$CI->client_db_model->create_database_client($client_id)){
			echo "db NOT   created <br>";
		}
		// clone all master table structure in dynamic client database
		$get_all_tables = $CI->client_db_model->getall_table_master_db($industry_type);
		foreach ($get_all_tables as $table){
			if(!$CI->client_db_model->create_tbl_client($table,$industry_type)){
				echo "<br> TBL NOT   created ".$table; break;
			}
		}
	}

	// function encode($data){
	// 	$CI =& get_instance();
	// 	return str_replace('/', '~*', $CI->encrypt->encode($data,$CI->config->item('encryption_key')));
	// }
	// function decode($data){
	// 	$CI =& get_instance();
	// 	$data = str_replace('~*', '/', $data);
	// 	return $CI->encrypt->decode($data,$CI->config->item('encryption_key'));
	// }
	function encode($data){
		$CI =& get_instance();
		$data = $CI->config->item('encryption_key').$data.$CI->config->item('encryption_key');
		$str=base64_encode($data);
 		return urlencode($str);
	}
	function decode($data){
		$CI =& get_instance();
		$data=base64_decode(urldecode($data));
		return $data = str_replace($CI->config->item('encryption_key'), '', $data);
	}

	function encodePwd($data){
		$CI =& get_instance();
		$data = $CI->config->item('encryption_key').$data.$CI->config->item('encryption_key');
		
		$str=base64_encode($data);
 		return urlencode($str);
	}
	function decodePwd($data){
		$CI =& get_instance();
		$data=base64_decode(urldecode($data));
		return $data = str_replace($CI->config->item('encryption_key'), '', $data);
	}

	function postRequestResponse($result){
		$CI =& get_instance();
		$csrfTokenName = $CI->security->get_csrf_token_name();
        $csrfHash = $CI->security->get_csrf_hash();
		$data = [
                    'csrfTokenName'=>$csrfTokenName,
                    'csrfHash'=>$csrfHash,
                    'data'=>$result
                ];
        return json_encode($data);
	}

	function permissionDenied(){
		$CI =& get_instance();
		return $CI->load->view('permission_denied');
	}

	function profile_mokeup(){
		$CI =& get_instance();
		$industry_type = strtolower($CI->session->userdata('industry_type'));
		if($industry_type != "bpo"){
			$client_steps_info = $CI->common->getDistinctWhereSelectRow('client',['mokup_steps'],['client_id'=>$CI->session->userdata('client_id')]);
			if($client_steps_info->mokup_steps < 5)
			{
				return false;
			}
			else{
				return true;
			}
		}
		else{
				return true;
			}
	}
	function landingPage(){
		$CI =& get_instance();
		$industry_type = strtolower($CI->session->userdata('industry_type'));
		//echo "KKK_".$industry_type;die;
        $CI->emp_group = $CI->session->userdata('emp_group'); // 2 =>ops 3=>client 
		if($industry_type == "bpo"){
			$CI->client_id = $CI->session->userdata('client_id');
        	$CI->emp_type  = $CI->session->userdata('usertype'); //  2=>agent 3=>supervisor 
        	$CI->emp_group = ($CI->emp_group  == '1') ? 'admin' : ( ($CI->emp_group == '2') ? 'ops'   : 'client' ); // ops->evaluator_id
        	$CI->emp_type  = ($CI->emp_type   == '1') ? 'admin':  ( ($CI->emp_type == '2')  ? 'agent' : 'supervisor' );
        	if($CI->session->userdata('is_first_login') != 1){
	        	if($CI->emp_type == "supervisor")
	        		redirect('dashboard');
	        	if($CI->emp_group == 'client' && $CI->emp_type == "agent")
	        		redirect('dashboard');
	        	if($CI->emp_group == 'ops' && $CI->emp_type == "agent"){
	         		redirect('dashboard');
	        		// redirect('audit-history');
	        	}
	        	if($CI->emp_type == "admin")
	        		redirect('hierarchy');
	    	}
	    	else{
		    	redirect('reset-password');
	    	}
	    }
	    else{
	    	// $CI->emp_group =  ($CI->emp_group  == '1') ? 'admin' : ( ($CI->emp_group == '2') ? 'auditor'   : 'reviewer' );
	    	$CI->emp_group =  (($CI->emp_group  == '1') ? 'admin' : (($CI->emp_group == '2') ? 'auditor'   : ($CI->emp_group == '3') ? 'reviewer' :'manager'));
	    	if($CI->emp_group == "admin"){				
				$client_steps_info = $CI->common->getDistinctWhereSelectRow('client',['mokup_steps'],['client_id'=>$CI->session->userdata('client_id')]);
				// print_r($client_steps_info->mokup_steps);die;
				if($client_steps_info->mokup_steps == 0)
				{
					//echo "hello";die;
					redirect('welcome-setup');
				}
				else if($client_steps_info->mokup_steps == 1 || $client_steps_info->mokup_steps == 4)
				{
					
					redirect('welcome-setup/templates');
				}
				else if($client_steps_info->mokup_steps == 2)
				{
					redirect('welcome-setup/template-create');
				}
				else if($client_steps_info->mokup_steps == 3)
				{
					redirect('welcome-setup/site-setup');
				}
				else {
					redirect('user-management');
				}
				// echo '<pre>';
				// print_r($client_steps_info->mokup_steps);
				// echo '</pre>';die;
	    		// redirect('user-management');
	    	}
	    	if($CI->emp_group =="auditor" || $CI->emp_group =="reviewer" || $CI->emp_group =="manager"){
	    		// echo $CI->emp_group;die;
	    		redirect('dashboard');	
	    	}
	    }
	}

	// check for audits has start or not for a table
	// function check_audits($table_name){
	// 	$CI =& get_instance();
    //  	$CI->db->distinct();
	// 	$CI->db->select("campaign");
    // 	$CI->db->from("hierarchy");
    // 	if($CI->session->userdata['client_id']){
	// 		$CI->db->where('client_id' ,$CI->session->userdata['client_id']);
	// 	}
	// 	//$CI->db->group_by('campaign');
	// 	return $result = $CI->db->get()->result_array();
	// }
	function check_audits($table,$select= '*',$distinct=null){
		$CI =& get_instance();
		if ($CI->db->table_exists($table) )
		{
			$CI->db->select($select);
			$CI->db->from($table);
			if($distinct){
				$CI->db->group_by($distinct);
			}
			$query = $CI->db->get();
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
		
	}
?>