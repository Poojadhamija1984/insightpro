<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxdata extends MY_Controller {	
	public function __construct(){
		parent::__construct();
		$this->lang->load('subscription_lang','subscription');
	}
   public function statusChangeAccordingTat()
   {
                $g = $this->session->userdata('u_group');
                $s=$this->session->userdata('site');
                $template =  $this->common->getTemplateDetails($s,$g);
                $attr_name_data = '';
                // print_r($template);die;
                foreach ($template as $key => $t_value) {
                    $attr_name_data .="SELECT t_att_name,t_att_id,'$t_value->tn' AS TableName,'$t_value->template_name' AS TemplateName,'$t_value->tat_time' as tat_time,'$t_value->tmp_unique_id' as tmp_unique_id  FROM  template WHERE t_unique_id = '$t_value->tmp_unique_id' AND t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
                } 
                $ovelall_words = explode( "UNION ALL", $attr_name_data);
                array_splice( $ovelall_words, -1 );
                $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
                $overall_total_qa_sql ="SELECT * FROM ($overall_qa_total_sql)t";  
                $overall_query = $this->db->query($overall_total_qa_sql);
                $overall_result = $overall_query->result();
                $failed_sql = '';
                foreach ($overall_result as $key => $att_value) {
                    $attributeName = str_replace("'", "`",$att_value->t_att_name);
                    $templateName  = str_replace("'", "`",$att_value->TemplateName);
                    $TableName  = str_replace("'", "`",$att_value->tmp_unique_id);
                    $tat_time  = $att_value->tat_time;
                    $attNumber = explode('_',$att_value->t_att_id)[0]; 
                    $attFail   = $attNumber .'_fail';
                    $attCom   = $attNumber .'_com';
                    $tableNmae  = strtolower($att_value->TableName);
                    $failed_sql .="SELECT t1.unique_id,t1.submit_time,'$tat_time' as tat_time ,t1.$attCom as overall_com ,'$attributeName' as attributeName,'$templateName' as templateName,'$att_value->t_att_id' as t_att_id,'$TableName' as TableName  FROM $tableNmae t1
                        WHERE t1.$attFail ='yes'  UNION ALL "; 
                }
                $failed_ovelall_words = explode( "UNION ALL", $failed_sql);
                array_splice( $failed_ovelall_words, -1 );
                $failed_overall_qa_total_sql = implode( "UNION ALL", $failed_ovelall_words );
                $failed_overall_total_qa_sql ="SELECT * FROM ($failed_overall_qa_total_sql)t ORDER BY attributeName ASC";  
                $failed_overall_query = $this->db->query($failed_overall_total_qa_sql);
                $failed_overall_result = $failed_overall_query->result();
                
                foreach($failed_overall_result as $f_key => $f_value) {
                    $data = array(
                            'unique_id'=>$f_value->unique_id,
                            'tmp_unique_id'=>$f_value->unique_id,
                            'att_id'=>$f_value->t_att_id,
                            'status'=>'1',
                            'att_comment'=>'Overdue According to Tattime'
                    );
                    $today = date("Y-m-d h:i:sa");
                    $date1 =  $f_value->submit_time;
                    $date2 = $today;
                    $timestamp1 = strtotime($date1);
                    $timestamp2 = strtotime($date2);
                    $hour_diff = abs($timestamp2 - $timestamp1)/(60*60);
                   
                    if($hour_diff >=$tat_time)
                        {
                            
                    if($this->common->checkAction('action_status',['unique_id'=>$f_value->unique_id,'att_id'=>$f_value->t_att_id])===TRUE)
                    {
                       
                        $this->common->insert_data($data,'action_status');
                        $data = ["success"=>"success"];

                    }else{
                        $data = ["success"=>"noupdate check action"];
                    }
                }else {
                    $data = ["success"=>"noupdate tat"];

                }
                }
                 
       echo postRequestResponse($data);die;
   }
   public function closedStatus()
   {
       $unique_id = $this->input->post('unique_id');
       $att_id    = $this->input->post('att_id');
       $data   = $this->common->getAllWhere('action_status',['unique_id'=>$unique_id,'att_id'=>$att_id]);
    //    $result = array('reviewer_commit'=>$data['att_comment']);
       echo postRequestResponse($data);die;

   }
    
}
