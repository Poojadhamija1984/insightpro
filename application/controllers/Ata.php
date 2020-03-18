<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ata extends MY_Controller {

	public function index(){
		if(($this->emp_group == "client" || $this->emp_group == "ops") && $this->emp_type == "supervisor"){
		
				$data['title']		=	'ATA View';
				$this->load->view('supervisor/ata_view');	
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
        $tableName = 'ata_'.strtolower($formName[0]['form_name']);

        /// Get ATA Data
        $formData =  $this->common->getWhereSelectAllFromToArray($tableName,
        ['unique_id'],['unique_id','emp_group','form_version','total_score'],
        ['lob'=>$lob],'submit_time',$fromDate,$toDate);
       // echo $this->db->last_query();
        foreach($formData as $key => $value){
            $dataArr[$key]['unique_id'] = $value['unique_id'];
            //Get agent score.
            $agentScore = $this->common->getWhereSelectAll(strtolower($formName[0]['form_name']),'total_score',['unique_id'=>$value['unique_id']]);
            $dataArr[$key]['agent_score'] = $agentScore ? $agentScore[0]->total_score.'%'  : '---';
            //ATA Score
            $dataArr[$key]['ata_score'] = $value['total_score'];
            $action = '<a href="form-view/'.$formName[0]['form_name'].'/'.$value['form_version'].'/ata_view'.'/'.$value['unique_id'].'">View ATA</a>';
            $dataArr[$key]['action'] =  $action;
        }
      
       // echo json_encode($data);
       echo postRequestResponse($dataArr);
}
	
//please write above	
}
