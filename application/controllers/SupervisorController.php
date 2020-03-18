<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SupervisorController extends MY_Controller {
	public function index(){
		$data['title']  = 'Add Agent';
		$clname = 'add_agent';
		$data['client_hierarchy'] = $this->common->getAllData('hierarchy');
		$this->load->view('supervisor/index' , $data);
	}
	
    public function import(){
    	$this->load->library('excel');
    	$client_id = $this->client_id;
    	if ($this->input->post('importfile') && $_FILES['userfile']['name'] != '') {
          		$path 						= 	'assets/upload/agent_roster/';
            	$config['upload_path'] 		= 	$path;
            	$config['allowed_types'] 	= 	'xlsx|xls';
            	$config['remove_spaces'] 	= 	TRUE;
            	$this->load->library('upload', $config);
            	$this->upload->initialize($config);
            	if (!$this->upload->do_upload('userfile')) {
                	$error = array('error' => $this->upload->display_errors());
                	//print_r($error);die;
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
                	die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
            	}
            	$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            
            	$arrayCount = count($allDataInSheet);
            	$flag = 0;
            	$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            
            	$arrayCount = count($allDataInSheet);
            	$flag = 0;
            	$createArray 	= [
            					'agent_id',
            					'agent_name',
            					'lob',
            					'vendor',
            					'location',
            					'campaign',
            					'doj',
            					'first_level_reporting_id',            					
            					'first_level_reporting',
            					'second_level_reporting_id',
            					'second_level_reporting',
            					'agent_status'
            				];
            	$makeArray 	= [
        					'agent_id'					=> 'agent_id',
        					'agent_name'				=> 'agent_name',
        					'lob'						=> 'lob',
        					'vendor'					=> 'vendor',
        					'location'					=> 'location',
        					'campaign'					=> 'campaign',
        					'doj'						=> 'doj',
        					'first_level_reporting_id'	=> 'first_level_reporting_id',
        					'first_level_reporting'		=> 'first_level_reporting',
        					'second_level_reporting_id'	=> 'second_level_reporting_id',
        					'second_level_reporting'	=> 'second_level_reporting',
        					'agent_status'					=> 'agent_status'
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
	                    $addresses 					= 	array();
	                    $agent_id 					= 	$SheetDataKey['agent_id'];
	                    $agent_name 				= 	$SheetDataKey['agent_name'];
	                    $lob 						= 	$SheetDataKey['lob'];
	                    $vendor 					= 	$SheetDataKey['vendor'];
	                    $location 					= 	$SheetDataKey['location'];
	                    $campaign 					= 	$SheetDataKey['campaign'];
	                    $doj 						= 	$SheetDataKey['doj'];
	                    $first_level_reporting_id 	= 	$SheetDataKey['first_level_reporting_id'];
	                    $first_level_reporting 		= 	$SheetDataKey['first_level_reporting'];
	                    $second_level_reporting_id 	= 	$SheetDataKey['second_level_reporting_id'];
	                    $second_level_reporting 	= 	$SheetDataKey['second_level_reporting'];
	                    $status 					= 	$SheetDataKey['agent_status'];
	                    
	                    $agent_id 					= 	filter_var(trim($allDataInSheet[$i][$agent_id]), FILTER_SANITIZE_STRING);
	                    $agent_name 				= 	filter_var(trim($allDataInSheet[$i][$agent_name]), FILTER_SANITIZE_STRING);
	                    $lob 						= 	filter_var(trim($allDataInSheet[$i][$lob]), FILTER_SANITIZE_STRING);
	                    $vendor 					= 	filter_var(trim($allDataInSheet[$i][$vendor]), FILTER_SANITIZE_STRING);
	                    $location 					= 	filter_var(trim($allDataInSheet[$i][$location]), FILTER_SANITIZE_STRING);
	                    $campaign 					= 	filter_var(trim($allDataInSheet[$i][$campaign]), FILTER_SANITIZE_STRING);
	                    $doj 						= 	filter_var(trim($allDataInSheet[$i][$doj]), FILTER_SANITIZE_STRING);
	                    $first_level_reporting_id 	= 	filter_var(trim($allDataInSheet[$i][$first_level_reporting_id]), FILTER_SANITIZE_STRING);
	                    $first_level_reporting 		= 	filter_var(trim($allDataInSheet[$i][$first_level_reporting]), FILTER_SANITIZE_STRING);
	                    $second_level_reporting_id 	= 	filter_var(trim($allDataInSheet[$i][$second_level_reporting_id]), FILTER_SANITIZE_STRING);
	                    $second_level_reporting 	= 	filter_var(trim($allDataInSheet[$i][$second_level_reporting]), FILTER_SANITIZE_STRING);
	                    $status 					= 	filter_var(trim($allDataInSheet[$i][$status]), FILTER_SANITIZE_STRING);
	                    

	                    $d['h'] = $this->common->getWhere('hierarchy',['lob'=>$lob,'campaign'=>$campaign,'vendor'=>$vendor,'location'=>$location,'client_id'=>$client_id]);
	                    //echo $this->db->last_query();
	                    if(!empty($d['h'])){
	                    	$agent_valid = '1';
	                    }
	                    else{
	                    	$agentInvalidCount++;
	                    	$agent_valid = '0';
						}
						$sql1 = $this->common->getWhere('agent',['agent_id'=>$agent_id,'client_id'=>$client_id]);
	                   	if(!empty($sql1)){
	                   		$updateData[] 	= 	[
	                    						'client_id'					=>	$client_id,
	                    						'agent_id' 					=>	$agent_id,
												'agent_name' 				=>	$agent_name,
												'lob'						=>	$lob,										
												'vendor' 					=>	$vendor,
												'location' 					=>	$location,
												'companion' 				=>	$campaign,
												'doj' 						=>	date('Y-m-d', strtotime(str_replace('-','/', $doj))),
												'first_level_reporting_id' 	=>  $first_level_reporting_id, 
												'first_level_reporting' 	=>	$first_level_reporting,
												'second_level_reporting_id' =>	$second_level_reporting_id,
												'second_level_reporting' 	=>	$second_level_reporting,
												'agent_status' 				=> 	((strtolower($status) == "active")?'1':'0'),
												'agent_created_date' 		=> 	date('Y-m-d H:i:s'),
												'agent_updated_date' 		=> 	date('Y-m-d H:i:s'),
												'agent_valid' 				=> 	$agent_valid,
	                    					];
	                   	}else{
	                    	//$this->common->insert_data($fetchData);
	                    	$insertData[] 	= 	[
	                    						'client_id'					=>	$client_id,
	                    						'agent_id' 					=>	$agent_id,
												'agent_name' 				=>	$agent_name,
												'lob'						=>	$lob,										
												'vendor' 					=>	$vendor,
												'location' 					=>	$location,
												'companion' 				=>	$campaign,
												'doj' 						=>	date('Y-m-d', strtotime(str_replace('-','/', $doj))),
												'first_level_reporting_id' 	=>  $first_level_reporting_id, 
												'first_level_reporting' 	=>	$first_level_reporting,
												'second_level_reporting_id' =>	$second_level_reporting_id,
												'second_level_reporting' 	=>	$second_level_reporting,
												'agent_status' 				=> 	((strtolower($status) == "active")?'1':'0'),
												'agent_created_date' 		=> 	date('Y-m-d H:i:s'),
												'agent_updated_date' 		=> 	date('Y-m-d H:i:s'),
												'agent_valid' 				=> 	$agent_valid,
	                    					];
	                   		
	                   	}
	                }
	                if(!empty($insertData))
	                	$this->import->insertData($insertData);
	                if(!empty($updateData))
	                	$this->import->updateData($updateData);
	                //echo $this->db->last_query();
	                $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Data Uploaded successfully with '.$agentInvalidCount.' Invalid Agent </div>');
	                redirect('agent_roster_upload', 'refresh');
	            } 
	            else {
	            	$this->session->set_flashdata('error', '<div class="alert alert-success text-center">Please Upload correct file</div>');
	                // echo "Please import correct file";
	                redirect('agent_roster_upload', 'refresh');
	            }
        }
        $this->session->set_flashdata('error', '<div class="alert alert-success text-center">Please Upload file</div>');
        redirect('agent_roster_upload', 'refresh');
        //$this->load->view('import/display', $data);
    }

    public function myBucket(){
		if(($this->industry_type == "bpo") && ($this->emp_group == 'ops' && $this->emp_type == 'agent')){
	    	$data['title']	=	'mybucket';
    		$user_id = $this->session->userdata['user_id'];
    		$lob_data = explode('|||', $this->session->userdata['lob']);
	    	$data['forms_details'] = $this->common->getWhereInSelectAll('forms_details',['form_name','form_version','form_status','lob','channels'],'lob',$lob_data);
    		$this->load->view('supervisor/mybucket',$data);
		}
		elseif (($this->industry_type != "bpo") && ($this->emp_group == 'auditor')){
			$data['title']	=	'mybucket';
			$config_data = $this->config->item('auditor');
			$data['heading'] =$config_data[0]; 
			$data['temp_details'] = $this->getTemplateName();
			// print_r($data);die;
			// echo $this->db->last_query();
    		$this->load->view('other/mybucket',$data);	
		}
		else{
            $data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);   
	    }   	
    }

    public function myHistory(){
    	if (($this->industry_type != "bpo") && ($this->emp_group == 'auditor' || $this->emp_group == 'reviewer'|| $this->emp_group == 'manager')){
			$data['title'] = 'My History';
			$config_data = $this->config->item('auditor');
			$data['heading'] =$config_data[1]; 
			$site           = $this->session->userdata('site');
			$user_group 	=  $this->session->userdata('u_group');
			//users site data
			$sqlQuery = 'SELECT  `s_name` ,`s_id` FROM `sites` WHERE `s_id` IN ('.$site.')';
			$data['sites'] = $this->db->query($sqlQuery)->result();
            //user groups data
			$sqlQuery = 'SELECT  `g_name` ,`g_id` FROM `groups` WHERE `g_id` IN ('.$user_group.')';
			$data['groups'] = $this->db->query($sqlQuery)->result();

    		$this->load->view('other/my_history',$data);	
		}
		else{
            $data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);   
	    } 
    }

     public function  getTemplateData(){
		
    		$user_id 		= 	$this->session->userdata['user_id'];
    		//$site 			= 	"'" .$this->session->userdata('site'). "'";
    		//$user_group 	= 	"'" .$this->session->userdata('u_group'). "'";
    		$sitePost 		= $this->input->post('site') ? $this->input->post('site') : '';
		    $groupPost 		= $this->input->post('groups') ? $this->input->post('groups') : '';
		    $fromdate       = date('Y-m-d',strtotime($this->input->post('fromdate')));
			$todate         = date('Y-m-d',strtotime($this->input->post('todate')));
			//var_dump($sitePost);die();
    		$historysql = '';
			$temp_name = $this->getTemplateName($sitePost,$groupPost);
			$dataArr= [];
			//print_r($temp_name);die;
			if(!empty($temp_name))
			{
    		foreach ($temp_name as $lkey => $lvalue) {
    			if($this->emp_group == 'auditor'){
    				$historysql .="SELECT count(unique_id) as unique_id,'$lvalue->tn' as TableName,'$lvalue->tmp_name' as tmp_name,'$lvalue->cd' as created_date,'$lvalue->status' as temp_status,avg(total_score) as ts ,TIME_FORMAT(SEC_TO_TIME(avg(hour(audit_counter) * 3600 + (minute(audit_counter) * 60) + second(audit_counter))),'%H:%i') as ac FROM  $lvalue->tn WHERE evaluator_id = $user_id and date(submit_time)>= '$fromdate' and date(submit_time)<= '$todate'   UNION ALL ";
    			} else {
    			    $historysql .="SELECT count(unique_id) as unique_id,'$lvalue->tn' as TableName,'$lvalue->tmp_name' as tmp_name,'$lvalue->cd' as created_date,'$lvalue->status' as temp_status ,avg(total_score) as ts ,TIME_FORMAT(SEC_TO_TIME(avg(hour(audit_counter) * 3600 + (minute(audit_counter) * 60) + second(audit_counter))),'%H:%i') as ac FROM  $lvalue->tn WHERE date(submit_time)>= '$fromdate' and date(submit_time)<= '$todate'  UNION ALL ";
    			}
            	
        	}
			
        	$words = explode( "UNION ALL", $historysql);
        	array_splice( $words, -1 );
        	$day_wise_sql = implode( "UNION ALL", $words );
        	$day_wise_total_sql ="SELECT * FROM($day_wise_sql)t";  
        	$day_wise_query = $this->db->query($day_wise_total_sql);
			$resultData = $day_wise_query->result();
			
			
		
            foreach ($resultData  as $key => $t_value) {
				
				
            	$action = '<a href="javascript:void(0)" onclick="getHdata(`'.strtolower($t_value->TableName).'`)">'.$t_value->unique_id.'</a>';
            	$dataArr[$key]['tmp_name']   = $t_value->tmp_name;
				$dataArr[$key]['total_count']   = $action;
				// change by jai
				$dataArr[$key]['created_date'] =$t_value->created_date;
				$dataArr[$key]['status'] =($t_value->temp_status==1) ? 'Active' : 'Inactive';
				$dataArr[$key]['avg_score']=ROUND($t_value->ts,2);
				$dataArr[$key]['avg_audit_time']= $t_value->ac;
				
			}
			
		}
            echo postRequestResponse($dataArr);
        	// print_r($data);die;
    	
    }




    public function myHistoryData(){
    	$post = $this->input->post();
    	$user_id 	=	$this->session->userdata['user_id'];
    	$table_name = 	$post['did'];
         if($this->emp_group == 'auditor'){
    	$data = $this->common->getWhereSelectAll($table_name,['unique_id','evaluator_name','total_score','submit_time','tmp_unique_id','status','audit_counter'],['evaluator_id'=>$user_id]);
         } else {
         	$data = $this->common->getWhereSelectAll($table_name,['unique_id','evaluator_name','total_score','submit_time','tmp_unique_id','status','audit_counter']);
		 }
		 
    	echo postRequestResponse($data);
    }

    public function getTemplateName($siteID=null , $groupID=null){
    	$user_id 		= 	$this->session->userdata['user_id'];
		//$site 			= 	"'" .$this->session->userdata('site'). "'";
		//$user_group 	= 	"'" .$this->session->userdata('u_group'). "'";
		$site 			= 	$this->session->userdata('site');
		$user_group 	= 	$this->session->userdata('u_group');
        $site           =   $siteID ? implode(',',$siteID) : $site;	
		$user_group 	=   $groupID ? implode(',' , $groupID) : $user_group; 
		/*$sql = "SELECT td.tmp_name as tn,td.temp_status as status, DATE_FORMAT(td.created_date,'%Y-%m-%d') as cd,GROUP_CONCAT(DISTINCT g.g_name) as g,GROUP_CONCAT(DISTINCT s.s_name) as s
				FROM template_details AS td
				JOIN
		  			groups AS g on g.g_id in ($user_group)
				JOIN
					sites AS s on s.s_id in ($site)
				where td.temp_status = '1'";*/
		// $sql = "select tmp_name as tn,temp_status as status, DATE_FORMAT(created_date,'%Y-%m-%d') as cd,(select GROUP_CONCAT(DISTINCT g_name ) from groups where g_id in ($user_group)) as g,(select GROUP_CONCAT(DISTINCT s_name ) from sites where s_id in ($site))as s from template_details where group_id in ($user_group) and site_id in ($site) AND temp_status = '1'";
		$sql = "SELECT td.tb_name as tn,td.tmp_name as tmp_name,group_id,site_id,td.tmp_unique_id,td.temp_status as status, DATE_FORMAT(td.created_date,'%Y-%m-%d') as cd,
				(select GROUP_CONCAT(DISTINCT g_name ) from groups where find_in_set(g_id,td.group_id)) as g,
				(select GROUP_CONCAT(DISTINCT s_name ) from sites where find_in_set(s_id,td.site_id))as s
				FROM template_details AS td
				where 
				td.temp_status = '1'
				AND
				group_id in ($user_group)
				OR
				site_id in ($site)";

		$day_wise_query = $this->db->query($sql);
		
    	return $day_wise_query->result();

    }
}
