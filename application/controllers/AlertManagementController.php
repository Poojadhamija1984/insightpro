<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AlertManagementController extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data['title'] 		= 	'Alert Management';
		$data['template'] 	= 	$this->common->getSelectAll('template_details',['tmp_name','tb_name']);
		$data['group'] 		= 	$this->common->getSelectAll('groups',['g_id','g_name']);
		$data['site'] 		= 	$this->common->getSelectAll('sites',['s_id','s_name']);
		$this->load->view('other/alert_management_view',$data);
	}
	public function templateDetails(){
		$temp_name = $this->input->post('temp_name');
		$btableName = str_replace('tb_temp_','',$temp_name);
		//$overall_total_qa_sql ="SELECT t_att_name as question,t_option_value as answer,t_id as id,t_option_type as option_type,t_notify_response as if_answer FROM template WHERE `t_name` = '$temp_name' AND `t_cat_id` != 'cat1' AND `t_option_type` = 'select'";  
		$overall_total_qa_sql ="SELECT t_att_name as question,t_option_value as answer,t_id as id,`t_notify_emails` AS `emails`,t_option_type as option_type,t_notify_response as if_answer,t_notify_status as status FROM template WHERE `t_unique_id` = '$btableName' AND `t_cat_id` != 'cat1' AND `t_option_type` = 'select'";  
        $overall_query = $this->db->query($overall_total_qa_sql);
		$temp_details = $overall_query->result();
		//echo $this->db->last_query(); die;
		
        $html = '';
        foreach ($temp_details as $key => $value) {
			// print_r($value);die;	
			$key = $key+1;
        	$option = "";
        	$if_answer = $value->if_answer;
    		$option .="<select class='question_response'><option value='' selected disabled>Select options</option>";
            $answer  = explode("|", $value->answer);
            foreach ($answer as $akey => $avalue){
            	$selected = ((!empty($if_answer) && $avalue == $if_answer)?' selected':'');
            	$option .="<option value='".$value->id."' $selected>$avalue</option>";
            }
            $option .="</select>";
			$question = $value->question;
			$emails='';
			if($value->emails!=''){
				$emails = $value->emails;
			}

			
        	// $nofifyText = (!empty($if_answer)?'Disable':'Enable');
        	$nofifyText = (!empty($if_answer)?'':'disabled');
        	$modaltext  = (!empty($if_answer)?"<a class='notify_btn modal-trigger open_modal' href='#alert_choose_modal'><i class='material-icons dp48'>people_outline</i></a>":"<a class='notify_btn alerticon' href='#'><i class='material-icons dp48'>people_outline</i></a>");
        	$status = (($value->status == '1')?"<button class='custom_switch switch active notifyStatus' value='1' notifyResponseId='".$value->id."'><span class='lever'></span></button>":"<button class='custom_switch switch notifyStatus' value='0' notifyResponseId='".$value->id."'><span class='lever'></span></button>");
        	$html .= "<div class='CT_row'>
        				<div class='CT_td center'>$key</div>
        				<div class='CT_td'>$question</div>
						<div class='CT_td options_value'>$option</div>
						<div class='CT_td'>
						
								<div class='tooltip'>View Users
								<span class='tooltiptext'>$emails</span>
								</div>
						</div>
        				<div class='CT_td statusSwitch'>$status</div>
        				<div class='CT_td center'>$modaltext</div>
        			</div>";
		}
        echo postRequestResponse($html);die;
	}

	public function userList(){
		$where = '';
		if(!empty($this->input->post('sites'))){
            $sites   =  implode('|', $this->input->post('sites'));
            $where  .=  'site REGEXP "(^|,)'.$sites.'(,|$)"';
        }
        if(!empty($this->input->post('group'))){
            $groups =  implode('|', $this->input->post('group'));
            if(!empty($this->input->post('sites')))
                $where .= " AND";
            $where  .=  ' u_group REGEXP "(^|,)'.$groups.'(,|$)"';
        }
        $day_wise_total_sql ="SELECT name,user_email as email FROM user WHERE $where";
        $day_wise_query = $this->db->query($day_wise_total_sql);
        $day_wise_result = $day_wise_query->result();
        $html = '';
        foreach ($day_wise_result as $key => $value) {
        	$html .= "<div class='col s4 target_list'>
        				<label><input type='checkbox' class='user_email' onchange='check_uncheck()' value='".$value->email."'><span>".$value->email."</span></label></div>";
        }
        // $html .= '</ul>';
        echo postRequestResponse($html);
	}

	public function notifyStatus(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$data = $this->common->update_data('template',['t_notify_status'=>$status],['t_id'=>$id,'t_notify_response !='=>null]);
		echo postRequestResponse($data);
	}

	public function notifyResponse(){
		$custome_emails 	= $this->input->post('custome_emails');
		$msg_body 			= $this->input->post('msg_body');
		$opt_text 			= $this->input->post('opt_text');
		$opt_val 			= $this->input->post('opt_val');
		$site 				= (!empty($this->input->post('site'))?implode(',', $this->input->post('site')):'');
		$group 				= (!empty($this->input->post('group'))?implode(',', $this->input->post('group')):'');
		$user_email 		= $this->input->post('user_email');
		$data = [
			't_notify_status'=>'0',
			't_notify_response'=>$opt_text,
			't_notify_emails'=>$user_email,
			't_notify_site_id'=>$site,
			't_notify_group_id'=>$group,
			't_notify_customs'=>$custome_emails,
			't_notify_emails_body'=>$msg_body
		];
		$this->common->update_data('template',$data,['t_id'=>$opt_val]);
		echo postRequestResponse('Response Update Successfully!');	
	}

	public function notifyResponseDetails(){
		$response_id = $this->input->post('response_id');
		$question_response_txt = $this->input->post('question_response_txt');
		$response_data = $this->common->getWhereSelectAll('template',['t_notify_emails as emails','t_notify_site_id as site','t_notify_group_id as group','t_notify_customs as custome','t_notify_emails_body as email_body'],['t_id'=>$response_id,'t_notify_response'=>$question_response_txt]);
		//echo $this->db->last_query(); die;
		$response_data = (!empty($response_data)?$response_data[0]:'');
		echo postRequestResponse($response_data);	
	}

//please write above	
}
