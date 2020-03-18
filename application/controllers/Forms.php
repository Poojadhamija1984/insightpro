<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends MY_Controller {	

public function select($formName="",$version="",$action="",$unique_id=""){
	$this->load->model('forms_model');
	$common = $this->config->item('common');
    $data['heading'] = $common[1];
	$formdata = $this->forms_model->getFormdetails($formName, $version);
	$tableName = strtolower($formName); 
	///formMeta Data...
	if($unique_id!=''){
		if($action =='callibrate_view'){
			$callTable = 'calibration_'.$tableName; 
		} else{
			$callTable = $tableName; 
		}
		$data['meta_data'] = $this->forms_model->getFormData($unique_id, $callTable);
		
	}

    $data['agent_deatils'] = $this->common->getWhere('user',['usertype'=> '2','is_admin'=>'3','lob'=>$formdata['lob']]);
    $data['form_version'] = $version;
    $data['formName'] = $formName;
	$data['action'] = $action;
	$data['channels'] = $formdata['channels'];
	$data['lob'] = $formdata['lob'];
     $checkForm = $this->forms_model->checkForms($formName, $version);
     if($checkForm == 0){
        redirect("error_404");
     }
    $data['title'] = $formName; 
	 
	///for escalation.....
	if($action=='escalate'){

	  $data['att_details'] = $this->common->getWhereSelectAll('forms',['attribute','attr_id'],['form_name'=> $formName ,'form_version'=>$version]);
	  $data['countESC'] = $this->forms_model->checkESC($formName, $unique_id);
	  $data['agentESCcmt'] = $this->common->getWhereSelectAll('escalation_'.$formName,['overall_com'],['unique_id'=>$unique_id,'emp_group'=> '3' ,'emp_type'=>'2']); 
	  $data['supESCcmt'] = $this->common->getWhereSelectAll('escalation_'.$formName,['overall_com'],['unique_id'=>$unique_id,'emp_group'=> '3' ,'emp_type'=>'3']); 
	}

	///For callibration.
	if($action =='callibrate' || $action =='callibrate_view'){
    $Calldata = $this->common->getWhereSelectAll('calibration_'.$formName,['calibration_date','calibration_time'],['unique_id'=>$unique_id]); 	
	$data['calibration_date'] = isset($Calldata[0]->calibration_date) ? $Calldata[0]->calibration_date : '';
	$data['calibration_time'] = isset($Calldata[0]->calibration_time) ? $Calldata[0]->calibration_time : '';
	}

   
	if($action=='callibrate_view'){
	//Get Ops supervisor data from calibration table	
	$data['opsRecords'] =$this->forms_model->checkRecords('calibration_'.$tableName,$unique_id,2,3);
	//Get Client Supervisor data from calibration table
	$data['clientRecords'] =$this->forms_model->checkRecords('calibration_'.$tableName,$unique_id,3,3);	
	//Get calibration report done by Ops & client supervisor
	$data['form_contents'] =$this->forms_model->getreport($formName,$unique_id,$tableName,$version,$action);
	$this->load->view('form_view' , $data);	

	}elseif($action=='ata_view'){
	//Get agent data
	$data['agentRecords'] =$this->forms_model->getATAdata($tableName,['unique_id'=>$unique_id]);
	//Get get ata data 
	$data['ATARecords'] =$this->forms_model->getATAdata('ata_'.$tableName,['unique_id'=>$unique_id]);	
	//Get Agent & ATA data 
	$data['form_contents'] =$this->forms_model->getreport($formName,$unique_id,$tableName,$version,$action);
	$this->load->view('form_view' , $data);	

	} else {
		$data['form_contents'] =$this->forms_model->getform($formName,$action,$unique_id,$tableName,$version);
		$this->load->view('form_view' , $data);
	}    

}
///Get agentDetals By aegent ID
public function getAgentDetails(){
	
    $this->load->model('forms_model');
    $agent_id = $this->input->post('agent_id');
	$agent = $this->forms_model->getAgentDetails($agent_id);
	$csrfTokenName = $this->security->get_csrf_token_name();
        $csrfHash = $this->security->get_csrf_hash();
        $data = [
                    'csrfTokenName'=>$csrfTokenName,
                    'csrfHash'=>$csrfHash,
                    'data'=>json_encode($agent)                       
                ];
        echo json_encode($data);
    //print_r (json_encode($agent));
}

function form_submit($formName,$form_version,$action)
{
	
        // Load model....
		$this->load->model('forms_model');
		
		if(count($_POST)>0)
		{
		   	
			$tableName=strtolower($formName);
			$unique_id=$this->input->post('unique_id');
			if($action=="fill" || $action=='callibrate' || $action == 'ata')
			{  
			
				if($_POST['evaluator_name'] == '')
				{
					$_POST['evaluator'] = $this->session->userdata['name'];
					$_POST['evaluator_id'] = $this->session->userdata['empid'];
				}
				
				// echo "<pre>";
				// print_r($_POST);
				// echo "</pre>";EXIT;

				 //Redirect url for form insert mode
				  $redirect = 'form-view/'.strtolower($formName).'/'.$form_version.'/'.$action;

				  ///Calibration required data prepare.
				if($action == 'callibrate'){
					//echo !empty($this->input->post('calibration_date'))?$this->input->post('calibration_date'):date('Y-m-d');
					//echo $this->input->post('calibration_date');
					//die;
					$tableName ='calibration_'.$tableName; 
					$_POST['calibration_date'] = date('Y-m-d' , strtotime($this->input->post('calibration_date')));
					$_POST['calibration_time'] = date('H:i' , strtotime($this->input->post('calibration_time')));
					$_POST['calibration_by'] = $this->session->userdata['empid'];
					$_POST['emp_group'] = $this->session->userdata['emp_group'];
					$_POST['emp_type'] = $this->session->userdata['usertype'];
					$redirect = 'form-view/'.strtolower($formName).'/'.$form_version.'/'.$action.'/'.$unique_id;
				}
				///ATA require data prepare 
				if($action == 'ata'){
					$tableName = 'ata_'.$tableName;
					$_POST['ata_by'] = $this->session->userdata['empid'];
					$_POST['emp_group'] =  $this->session->userdata['emp_group'];
					$_POST['ata_date'] =   date('Y-m-d');
					$redirect = 'form-view/'.strtolower($formName).'/'.$form_version.'/'.'ata_view/'.$unique_id;
				}
				

				$inserData=$this->forms_model->formInsert($tableName,$_POST);
				$sumsg = 'Form submitted Successfully ';
				if($inserData)
				{
					if(!empty($_FILES)){
					$contentUpload_response = $this->contentUpload($_FILES,$this->input->post('unique_id'),$tableName,$inserData);
					if(!empty($contentUpload_response)){
						$contentUpload_response = implode(',',$contentUpload_response);
						$sumsg .= 'Please Upload Valid these files '.$contentUpload_response;
					}
				}
                        $this->session->set_flashdata('message', $sumsg);
						redirect($redirect);	
					
				}else{
					$this->session->set_flashdata('error', 'Error Occurred');
					redirect($redirect);
				}
				
			}else if($action=="audit"  ||  $action == "escalate" || $action == 'feedback')
			{
			
				// for changes the sttus of escalated data...
				 if($action == 'escalate' && $this->session->userdata('emp_group')=='2') {
					$_POST = array("status" =>'Approved') + $_POST;
					$_POST = array("esc_phase_id" =>'3') + $_POST;
                   
				 }
				 
				 if(($action=="audit")  ||  ($action == "escalate" && $this->session->userdata('emp_group')=='2')){
					// Data for OPS supervisor role 
                   $postData = $_POST;
				 } 
				 //Approve status by client agent....
				 if($action =='escalate' && ($this->session->userdata('emp_group')=='3' && $this->session->userdata('usertype')=='2' )) {
					//Data for agent clinet role.....
					$postData = array("status" => 'Approved', "unique_id" => $unique_id);
				 }

				 //Approve status by supervisor  client agent....
				 if($action =='escalate' && ($this->emp_group =='client' && $this->emp_type =='supervisor' )) {
					//Data for agent clinet role.....
					$postData = array("status" => 'Approved', "unique_id" => $unique_id);
				 }

				 ///Feedback by supervisor client

				 if($action == 'feedback'){
				   //Data for agent clinet role.....
					$postData = array(
						"feedback_com" => $this->input->post('feedback_com'),
						"feedback_by" => $this->session->userdata('usertype'),
						"feedback_by" => date("Y-m-d"),
						 "unique_id" => $unique_id);
				 }
				 	

      
				 $updateData=$this->forms_model->formUpdate($tableName,$postData);
                //Redirect url for form insert mode
                $redirect = 'form-view/'.strtolower($formName).'/'.$form_version.'/'.$action.'/'.$unique_id;
				if($updateData)
				{
					$this->session->set_flashdata('message', 'Form updated Successfully');
					redirect($redirect);
				}else{
					$this->session->set_flashdata('msg', 'Error Occurred');
					redirect($redirect);
				}
				
			}else{
				redirect('error_404');
			}
		}else{
			// In case of any error redirect to form
			redirect('error_404');
		}
	}


function escalation_submit($formName,$form_version,$unique_id)
{
        // Load model....
	    $this->load->model('forms_model');
		if(count($_POST)>0)
		{
				 $tableName=strtolower('escalation_'.$formName);
				 $form_tableName=strtolower($formName);
				 $_POST = array("unique_id" =>$unique_id) + $_POST;
				 $_POST = array("emp_type" =>$this->session->userdata['usertype']) + $_POST;
				 $_POST = array("emp_group" =>$this->session->userdata['emp_group']) + $_POST;
				 $_POST = array("escalation_by" =>$this->session->userdata['empid']) + $_POST;   
				 $_POST = array("form_version" =>$form_version) +$_POST;
				 /// prepare data for  form status........
				 $form_data = array('status'=>'Escalated','esc_phase_id' =>'1');
                ///Insert comment in escalation form table....
				$inserData=$this->forms_model->formInsert($tableName,$_POST);
				///update form  status for particular unique ID status ......
				$updatedData = $this->common->update_data($form_tableName,$form_data,['unique_id'=>$unique_id]);
                 /// Mail send here for particular supervisor asociated with uniquue ID.... 

                //Redirect url for form insert mode
                $redirect = 'form-view/'.strtolower($formName).'/'.$form_version.'/escalate'.'/'.$unique_id;
				if($inserData)
				{
                        $this->session->set_flashdata('message', 'Form submitted Successfully');
						redirect($redirect);	
					
				}else{
					$this->session->set_flashdata('error', 'Error Occurred');
					redirect($redirect);
				}
				
			
		}else{
			// In case of any error redirect to form
		}
}

function contentUpload($files,$unique_id,$tableName,$last_insertedId){
	if(!is_dir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent')){
		mkdir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent',0777, TRUE);
		$p = './assets/upload/'.$this->session->userdata('client_db_name').'/formContent';
		shell_exec("sudo chmod -R 7777 $p");
	}

	$folderPath ='./assets/upload/'.$this->session->userdata('client_db_name').'/formContent';
	$config['upload_path']      = $folderPath;
	$config['allowed_types']    = 'gif|jpg|jpeg|png|csv|xls|xlsx|docx|doc|pdf|mp3|mp4|txt|msg|wav';
	$config['max_size']         = 5000;
	
	$this->load->library('upload');
	$res = [];
	$content_files_name = [];
	foreach($files['contant_upload']['name'] as $key => $each_fileName)
	{
		//$this->print_result($value);
		
		//$filename = $files['contant_upload']['name'];
		$filename = $each_fileName;
		$extension1 = explode("." , $filename);
		$extension = end($extension1);
		$file_name = $unique_id.'_'.$key.'.'.$extension;
		
		$config['file_name']        = $file_name;


		$_FILES['file']['name']     = $_FILES['contant_upload']['name'][$key];
		$_FILES['file']['type']     = $_FILES['contant_upload']['type'][$key];
		$_FILES['file']['tmp_name'] = $_FILES['contant_upload']['tmp_name'][$key];
		$_FILES['file']['error']     = $_FILES['contant_upload']['error'][$key];
		$_FILES['file']['size']     = $_FILES['contant_upload']['size'][$key];
		
		$this->upload->initialize($config);
		if (! $this->upload->do_upload('file'))
		{
			// $this->print_result($this->upload->display_errors());die;
			$res[$key] = $each_fileName;
		}
		else {
			$upload_data = $this->upload->data();
			//$res[$key] = "success";
			$content_files_name[] =$file_name;
		} 
	}
	//print_r($content_files_name);die;
	$uploade_data = implode('|',$content_files_name);
	$ud = ['content_upload'=>$uploade_data];
	$inserData=$this->common->update_data_info($tableName,$ud,['audit_sr_no'=>$last_insertedId]);
	//$this->print_result($inserData);
	return $res;
}



// function contentUpload($files,$unique_id){

// 	if(!is_dir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent')){
//         mkdir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent',0777, TRUE);
//     }
// 	$folderPath ='./assets/upload/'.$this->session->userdata('client_db_name').'/formContent';
// 	$filename = $files['contant_upload']['name'];
// 	$extension1 = explode("." , $filename);
// 	$extension = end($extension1);
//     $file_name = $unique_id.'.'.$extension;
//     $config['upload_path']      = $folderPath;
//     $config['allowed_types']    = 'gif|jpg|jpeg|png|xls|csv|xlxs|pdf|docs|mp3|mp4';
//     $config['max_size']         = 5000;
//     $config['file_name']        = $file_name;
// 	$this->load->library('upload', $config);
//     if (! $this->upload->do_upload('contant_upload'))
//     {
// 		$res = "error";
//     }
//     else {
// 		$upload_data = $this->upload->data();
// 		$res = "success";
// 	} 
// 	return $res;
// }
public function print_result($request)
{
	echo '<pre>';
	print_r($request);
	echo '</pre>';
	echo '<br>';
	// die;
}

//please write above.....
}