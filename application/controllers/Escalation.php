<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escalation extends MY_Controller {
	
	public function index()
	{
	    $data['title'] = 'Escalation';
	    $data['channels'] = 	$this->common->getSelectAll('forms_details','channels');
	    // echo $this->db->last_query();die;
		$this->load->view('agent/escalation_view',$data);
    }
    
    ///Get forms names by chanels......
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
		$from 	   = $this->input->post('fromDate');
		$to 	   = $this->input->post('toDate');
		$lob 	   = $this->input->post('lob');
		$between   = "CAST(submit_time as DATE) BETWEEN {$from} AND {$to}";
		$formName  = $this->common->getDistinctWhereSelect('forms_details','form_name',['lob'=>$lob]);
		$tableName = strtolower($formName[0]['form_name']);
        $empid = $this->session->userdata('empid');    
		if($this->session->userdata('emp_group') == 3 &&  $this->session->userdata('usertype') == 2){
			$res = $this->common->getWhereSelectAll($tableName,['unique_id','total_score','lob','call_id','agent_id','agent_name','issue_type','form_version','status'],['agent_id'=>$empid,$between]);
		}else {
			$res = $this->common->getWhereSelectAll($tableName,['unique_id','total_score','lob','call_id','agent_id','agent_name','issue_type','form_version','status'],['status !=' =>'Pending',$between]);

		}
        $dataArr= [];
		foreach ($res as $key => $value) {
              $action = '<a href="form-view/'.$formName[0]['form_name'].'/'.$value->form_version.'/escalate'.'/'.$value->unique_id.'">'.$value->unique_id.'</a>';

              $dataArr[$key]['unique_id']   = $action;
               $dataArr[$key]['lob']        = $value->lob;
              $dataArr[$key]['call_id']     = $value->call_id;
              $dataArr[$key]['agent_id']    = $value->agent_name."<br>".$value->agent_id;
              $dataArr[$key]['issue_type'] = $value->issue_type;
               $dataArr[$key]['total_score'] = $value->total_score;
              $dataArr[$key]['status']      = $value->status;

		}


		 echo postRequestResponse($dataArr);
	}
//please write above	
}
