<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeamViewController extends MY_Controller {
	public function index(){
		if(($this->emp_group == "client" || $this->emp_group == "ops") && $this->emp_type == "
		"){
			if($this->emp_type == 'supervisor'){
				$sup_id 	= $this->session->userdata('empid');
				$from_date 	= date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));
				$to_date   	= date('Y-m-d');
				$emp_data 	= $this->common->getWhereSelectAll('user',['user_id','name','empid','usertype','lob'],['sup_id'=>$sup_id]);
				$emp_id     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
				$between 	= "CAST(submit_time as DATE) BETWEEN {$from_date} AND {$to_date}";
				if(!empty($emp_data)){
					foreach ($emp_data as $key => $value) {
						$arr = explode('|||', $value->lob);
						$forms_details 	= $this->common->getWhereInSelectAll('forms_details','form_name','lob',$arr);
						$audit_count = 0;
						$data['emp_audit_count'][$value->empid] = $audit_count;
						$emp_data[$key]->form_name = '';
						$emp_data[$key]->to_date = $to_date;
						$emp_data[$key]->form_date = $from_date;
						if(!empty($forms_details)){
							foreach ($forms_details as $key => $value1) {
								$emp_data[$key]->form_name = $value1->form_name;
								$emp_audit_data	= $this->common->getWhereSelectAll($value1->form_name,'COUNT(*) as count',[$emp_id =>$value->empid,'CAST(submit_time as DATE) >='=> $from_date,'CAST(submit_time as DATE) <='=> $to_date]);
								// echo $this->db->last_query();die;
								$audit_count = $audit_count + $emp_audit_data[0]->count;
								$data['emp_audit_count'][$value->empid] = $audit_count;
								// echo'<pre>';
								// echo $this->db->last_query();
								// print_r($emp_audit_data);die;
							}
						}
					}
				}
				//die;
				$data['title']		=	'Team View';
				$data['emp_data'] 	= 	$emp_data;
				// print_r($data);die;
				$this->load->view('supervisor/team_view',$data);
			}
			else{
				$this->load->view('permission_denied');
			}
		}
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);   
        }
	}
	public function employeeAuditData(){
		if($this->input->post('filter')){
			$lob		=	$this->input->post('lob');
			$to_date	=	$this->input->post('to_date');
			$from_date	=	$this->input->post('from_date');
			$sup_id 	= 	$this->session->userdata('empid');
			$emp_data 	= 	$this->common->getWhereSelectAll('user',['user_id','name','empid','usertype','lob'],['sup_id'=>$sup_id]);
			$sup_user_data = [];
			$count=0;
			foreach ($emp_data as $key => $value22) {
				$user_lob = explode('|||', $value22->lob);
				if(in_array($lob,$user_lob)){
					$sup_user_data[] = $value22;
				}
			}
			$emp_id     =   (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
			//$between 	=   "CAST(submit_time as DATE) BETWEEN {$from_date} AND {$to_date}";
			$between 	=   "CAST(submit_time as DATE) BETWEEN {$to_date} AND {$from_date}";
			if(!empty($sup_user_data)){
				foreach ($sup_user_data as $key => $value) {
					$arr = [$lob];//explode('|||', $value->lob);
					$lob_data = implode(',', $arr);
					$forms_details 	= $this->common->getWhereInSelectAll('forms_details','form_name','lob',$arr);
					$audit_count = 0;
					$sup_user_data[$key]->emp_audit_count = $audit_count;
					$sup_user_data[$key]->lob = urlencode($lob);
					$sup_user_data[$key]->form_name = '';
					$sup_user_data[$key]->to_date = $to_date;
					$sup_user_data[$key]->form_date = $from_date;
					if(!empty($forms_details)){
						foreach ($forms_details as $key1 => $value1) {
							$sup_user_data[$key]->form_name = $value1->form_name;
							$emp_audit_data	= $this->common->getWhereSelectAll($value1->form_name,'COUNT(*) as count',[$emp_id =>$value->empid,$between]);
							$audit_count = $audit_count + $emp_audit_data[0]->count;
							$sup_user_data[$key]->emp_audit_count = $audit_count;
						}
					}
				}
			}
			$data['url'] = (($this->emp_group == 'ops')?'audit':'view');
			$data['emp_data'] 	= 	$sup_user_data;
			echo postRequestResponse($data);die;
		}
		else{
			$employee_id 		= $this->input->post('emp_id');
			$lob 				= explode(',',urldecode($this->input->post('lob')));
			$to_date 			= $this->input->post('to_date');
			$from_date 			= $this->input->post('from_date');
			$between1 			= 'CAST(submit_time as DATE) BETWEEN';
			$between2 			= "'$from_date'".' AND '."'$to_date'";
			$emp_id     		= (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
			$forms_details 		= $this->common->getWhereInSelectAll('forms_details','form_name','lob',$lob);
			$emp_audit_data1 	= [];
			$new_array   = [];
			foreach ($forms_details as $key => $value1) {
				//Get all Calibaration data from calibration by user group
				$tableName = 'calibration_'.strtolower($value1->form_name);
				$checkCall = $this->common->getWhereSelectAllToArray($tableName,'unique_id',['emp_group'=>$this->session->userdata('emp_group')]);
				//Make array for calibration data check
				foreach($checkCall as $values)
				{
					$new_array[]=$values['unique_id'];
				}
				//Get all ATA  data
				$getATAData = $this->common->getWhereSelectAllToArray('ata_'.strtolower($value1->form_name),'unique_id');
				//Make array for ATA data check
				$ata_array = [];
				foreach($getATAData as $ataValues){
					$ata_array[]= $ataValues['unique_id'];
				} 
				
				$emp_audit_data	= $this->common->getWhereSelectAll($value1->form_name,['unique_id','total_score','lob','call_id','agent_id','agent_name','issue_type','form_version'],[$emp_id => $employee_id,'CAST(submit_time as DATE) >='=> $from_date,'CAST(submit_time as DATE) <='=> $to_date]);
				// echo $this->db->last_query();die;
				$emp_audit_data1[] =$emp_audit_data; 
				if(!empty($emp_audit_data)){
					foreach ($emp_audit_data as $key1 => $value2) {
						$emp_audit_data1[$key][$key1]->form_name = $value1->form_name;

						///check calibration exist or not for the  user group.
						if(in_array($value2->unique_id,$new_array)){
							$emp_audit_data1[$key][$key1]->callibrate = '<a href="form-view/'.$value1->form_name.'/'.$value2->form_version.'/callibrate_view'.'/'.$value2->unique_id.'">View Calibration</a>';
						} else {
							$emp_audit_data1[$key][$key1]->callibrate =  '<a href="form-view/'.$value1->form_name.'/'.$value2->form_version.'/callibrate'.'/'.$value2->unique_id.'">Calibrate</a>';
							
						}
						//check ATA exist or not for particular uniqure ID
                        if(in_array($value2->unique_id,$ata_array)){
						  $emp_audit_data1[$key][$key1]->ata ='<a href="form-view/'.$value1->form_name.'/'.$value2->form_version.'/ata_view'.'/'.$value2->unique_id.'">View ATA</a>';
						}else{
							$emp_audit_data1[$key][$key1]->ata ='<a href="form-view/'.$value1->form_name.'/'.$value2->form_version.'/ata'.'/'.$value2->unique_id.'">Mark for ATA</a>';
						}
						
						
					}
				}
			}	
			$emp_audit_data2['between'] = $from_date.' To '.$to_date;
			$emp_audit_data2['audit_data'] = $emp_audit_data1;
			$emp_audit_data2['url'] = (($this->emp_group == 'ops')?'audit':'feedback');
			echo postRequestResponse($emp_audit_data2);
		}
	}
//please write above	
}
