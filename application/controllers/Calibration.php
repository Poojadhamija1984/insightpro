<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calibration extends MY_Controller {

	public function index(){
		if(($this->emp_group == "client" || $this->emp_group == "ops") && $this->emp_type == "supervisor"){
		
				$data['title']		=	'Callibration View';
				$this->load->view('supervisor/callibration_view');	
		}
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);   
        }
    }
    
    function getlist() 
    {
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('tomDate');
        $lob = $this->input->post('lob');
        $dataArr  = [];
        $formName = $this->common->getDistinctWhereSelect('forms_details','form_name',['lob'=>$lob]);
        $tableName = 'calibration_'.strtolower($formName[0]['form_name']);

        ///get  supervisor wise calibration data from callibration form data.... 
        $formData =  $this->common->getWhereSelectAllFromToArray($tableName,
        ['unique_id'],['unique_id','calibration_date','calibration_time','emp_group','emp_type','form_version','calibration_status','total_score'],
        ['lob'=>$lob],'submit_time',$fromDate,$toDate);
       // echo $this->db->last_query();
        foreach($formData as $key => $value){
            $dataArr[$key]['unique_id'] = $value['unique_id'];
            //Ops Supervisor score.
            $Oscore = $this->common->getWhereSelectAll($tableName,'total_score',['unique_id'=>$value['unique_id'],'emp_group'=>'2']);
            $dataArr[$key]['sup_score'] = $Oscore ? $Oscore[0]->total_score.'%'  : '---';
            //Client supervisor score
            $Cscore = $this->common->getWhereSelectAll($tableName,'total_score',['unique_id'=>$value['unique_id'],'emp_group'=>'3']);
            $dataArr[$key]['client_score'] = $Cscore ? $Cscore[0]->total_score.'%'  : '---';
            
            $dataArr[$key]['date_time'] = $value['calibration_date'] .' '.$value['calibration_time'];

           // $status = ($value['calibration_status']==0) ? 'Open' : 'Closed';
           // $dataArr[] = $status;
           $checkCall= $this->common->getWhereSelectAll($tableName,'total_score',['unique_id'=>$value['unique_id'],'emp_group'=>$this->session->userdata('emp_group')]);
           //check callibration done by partivular user group.

           if( $checkCall){
            $action = '<a href="form-view/'.$formName[0]['form_name'].'/'.$value['form_version'].'/callibrate_view'.'/'.$value['unique_id'].'">View Calibration</a>';
           } else {
         
               $action = '<a href="form-view/'.$formName[0]['form_name'].'/'.$value['form_version'].'/callibrate'.'/'.$value['unique_id'].'">Calibrate</a>';
              
           }
        
    
            $dataArr[$key]['action'] =  $action;
        }
      
        
    
       // echo json_encode($data);
       echo postRequestResponse($dataArr);
}
	
//please write above	
}
