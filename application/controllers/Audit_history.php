<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_history extends MY_Controller {
	
	public function index()
	{
		if(($this->emp_group == "client" || $this->emp_group == "ops")  && $this->emp_type == "agent"){
        	$data['title'] = 'Audit History';
	    	$data['channels'] = 	$this->common->getSelectAll('forms_details','channels');
			$this->load->view('agent/audit_history_view',$data);
        }
        else{
        	$data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);	
        }
	    
	}
	public function getForms(){
		$channels = $this->input->post('channels');
		$forms = 	$this->common->getDistinctWhere('forms_details','form_name',['channels'=>$channels]);
		$opt = '';
		if(!empty($forms)){
			foreach ($forms as $key => $value) {
				$opt .= "<option value='{$value->form_name}'>{$value->form_name}</option>";
			}
		}
		echo postRequestResponse($opt);
	}
	public function auditData(){
		$fromDate    	= $this->input->post('fromDate');
		$toDate 		= $this->input->post('toDate');
	    $lob 		= $this->input->post('lob');
		//$between 		= "CAST(submit_time as DATE) BETWEEN {$from} AND {$to}";
		$formName  = $this->common->getDistinctWhereSelect('forms_details','form_name',['lob'=>$lob]);
		 $dataArray = [];
		/// Do the below stuf if  form available for particular lob.
		if($formName){
	    $tableName = strtolower($formName[0]['form_name']);
        $empid = $this->session->userdata('empid');    
        if($this->session->userdata('emp_group') == 2 &&  $this->session->userdata('usertype') == 2 ){
        $res =  $this->common->getWhereSelectAllFromToArray($tableName,
       ['unique_id'],['unique_id','total_score','lob','call_id','agent_id','form_version','agent_name','agent_id','issue_type'],
        ['evaluator_id'=>$empid],'submit_time',$fromDate,$toDate); 
        } else {
        $res =  $this->common->getWhereSelectAllFromToArray($tableName,
       ['unique_id'],['unique_id','total_score','lob','call_id','agent_id','form_version','agent_name','agent_id','issue_type'],
        ['agent_id'=>$empid],'submit_time',$fromDate,$toDate);
        }
		foreach ($res as $key => $value) {
           $action = '<a  target="_blank" href="form-view/'.$formName[0]['form_name'].'/'.$value['form_version'].'/view'.'/'.$value['unique_id'].'">'.$value['unique_id'].'</a>';
           $dataArray[$key]['unique_id']   = $action;
           $dataArray[$key]['lob']         = $value['lob'];
           $dataArray[$key]['call_id']     = $value['call_id'];
           $dataArray[$key]['agent_id']    = $value['agent_id'].'<br>'. $value['agent_name'];
           $dataArray[$key]['issue_type']  = $value['issue_type'];
           $dataArray[$key]['total_score'] = $value['total_score'];

		}
	}
		echo postRequestResponse($dataArray);	
	}
//please write above	
}
