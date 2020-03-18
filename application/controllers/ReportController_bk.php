<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportController extends MY_Controller {
	
	public function actionItems(){
        $data['title']      =   'Action Items';
        $site               =   $this->session->userdata('site');
        $user_group 	    =   $this->session->userdata('u_group');
        $sqlQuery           =   'SELECT  `s_name` ,`s_id` FROM `sites` WHERE `s_id` IN ('.$site.')';
        $data['sites']      =   $this->db->query($sqlQuery)->result();
        $sqlQuery           =   'SELECT  `g_name` ,`g_id` FROM `groups` WHERE `g_id` IN ('.$user_group.')';
        $data['groups']     =   $this->db->query($sqlQuery)->result();
        $todate             =   $this->input->post('todate') ? $this->input->post('todate') : date('Y-m-d');
        $fromdate 		    =   $this->input->post('fromdate') ?  $this->input->post('fromdate') : date('Y-m-d',strtotime(date('Y-m-01')));
        $sitePost 		    =   $this->input->post('site') ? $this->input->post('site') : '';
        $groupPost 		    =   $this->input->post('groups') ? $this->input->post('groups') : '';
        $data['fromdate']   =   $fromdate;
        $data['todate']     =   $todate;
        $data['sitePost']   =   $sitePost;
        $data['groupPost']  =   $groupPost;
        //if(strtotime($todate) < strtotime($fromdate)){
            $tempaltes   =  $this->getTemplateName($sitePost,$groupPost);
            $content = '';
            $content .='<div class="table-section mt-24"><div class="card"><div class="card-content">';
            $content .= '<h4 class="card-title">Failed Attributes</h4>';
            $content .= '<table class=" data_table stripe hover" id="escalation_data" style="width:100%"><thead><tr>
                <th>Template Name</th><th>Unique ID</th><th>Attribute Name</th><th>Status</th><th>Comment</th>';
            $content .= ($this->emp_group != 'manager')?"<th>Update Status</th>":"";
            $content .= '</tr></thead><tbody>';
            $attr_name_data = '';
            foreach ($tempaltes as $key => $t_value) {
                $attr_name_data .="SELECT t_att_name,t_att_id,'$t_value->tn' AS TableName,'$t_value->template_name' AS TemplateName,'$t_value->tmp_unique_id' as tmp_unique_id  FROM  template WHERE t_unique_id = '$t_value->tmp_unique_id' AND t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
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
                $attNumber = explode('_',$att_value->t_att_id)[0]; 
                $attFail   = $attNumber .'_fail';
                $tableNmae  = strtolower($att_value->TableName);
                $failed_sql .="SELECT t1.unique_id, '$attributeName' as attributeName,'$templateName' as templateName,'$att_value->t_att_id' as t_att_id,'$TableName' as TableName,(select status from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id' LIMIT 1) as status,(select att_comment from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id' LIMIT 1) as att_comment FROM $tableNmae t1
                        WHERE t1.$attFail ='yes' AND DATE(submit_time) >= '$fromdate' and DATE(submit_time) <= '$todate' UNION ALL "; 
            }
            $failed_ovelall_words = explode( "UNION ALL", $failed_sql);
            array_splice( $failed_ovelall_words, -1 );
            $failed_overall_qa_total_sql = implode( "UNION ALL", $failed_ovelall_words );
            $failed_overall_total_qa_sql ="SELECT * FROM ($failed_overall_qa_total_sql)t ORDER BY attributeName ASC";  
            $failed_overall_query = $this->db->query($failed_overall_total_qa_sql);
            $failed_overall_result = $failed_overall_query->result();
            foreach($failed_overall_result as $f_key => $f_value) {
                $burl = site_url()."/template/".$f_value->TableName.'/view/'.$f_value->unique_id;
                $status = $f_value->status;
                $cmt    = $f_value->att_comment;
                $status =   (($status  == '1') ? 'Inprogress' : (($status == '2') ? 'Closed' : 'Pending'));
                $cmt =      (!empty($cmt) ? $cmt : 'NA');
                $content .='<tr  role="row">
                                <td>'.$f_value->templateName.'</td>
                                <td> <a href="'.$burl.'" target="_blank">'.$f_value->unique_id.'</a></td>
                                <td>'.$f_value->attributeName.'</td>
                                <td id="'.$f_value->unique_id.$f_value->t_att_id.'">'.$status.'</td>
                                <td id="cmt'.$f_value->unique_id.$f_value->t_att_id.'">'.$cmt.'</td>';
                $content .= ($this->emp_group != 'manager')?'<td><a class="notify_btn modal-trigger open_modal active" href="#alert_choose_modal" onclick="findata(`'.$f_value->unique_id.'` , `'.$f_value->unique_id.'`,`'.$f_value->t_att_id.'`)">Update</a></td>':"";    
                                    
                $content .='</tr>';
            } 
            $content.='</tbody></table></div></div></div>';
            $data['content'] = $content;
             
        $this->load->view('other/action_items_view',$data);
    }
    
    public function alertSubmit(){
        $status = $this->input->post('status');
        $att_comment =  $this->input->post('att_comment');
        $unique_id =  $this->input->post('unique_id');
        $tmp_unique_id =  $this->input->post('tmp_unique_id');
        $att_id =  $this->input->post('att_id');
        $data = [
            'status'=>$status,
            'att_comment'=>$att_comment,
            'unique_id'=> $unique_id,
            'tmp_unique_id'=> $tmp_unique_id,
            'att_id'=> $att_id
        ];
        $countData =  $this->itemCount('action_status','status',['unique_id'=>$unique_id,'tmp_unique_id'=>$tmp_unique_id,'att_id'=>$att_id]);
        if($countData == 0){
            $this->common->insert_data($data,'action_status');
        } else {
            $this->common->update_data('action_status',$data,['unique_id'=>$unique_id,'tmp_unique_id'=>$tmp_unique_id,'att_id'=>$att_id]);
        }
        
        echo postRequestResponse('Status Update Successfully!'); 
    }
    
    public function getTemplateName($siteID , $groupID){
    	$user_id 		= 	$this->session->userdata['user_id'];
		$site 			= 	$this->session->userdata('site');
		$user_group 	= 	$this->session->userdata('u_group'); 
		$site           =   $siteID ? implode(',',$siteID) : $site;	
		$user_group 	=   $groupID ? implode(',' , $groupID) : $user_group; 
		$sql = "SELECT td.tb_name as tn,group_id,site_id,td.tmp_unique_id,td.temp_status as status, DATE_FORMAT(td.created_date,'%Y-%m-%d') as cd,
				(select GROUP_CONCAT(DISTINCT g_name ) from groups where find_in_set(g_id,td.group_id)) as g,
				(select GROUP_CONCAT(DISTINCT s_name ) from sites where find_in_set(s_id,td.site_id))as s,td.tmp_name as template_name
				FROM template_details AS td
				where 
				td.temp_status = '1'
				AND
				group_id in ($user_group)
				OR
				site_id in ($site)";
		$day_wise_query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        
    	return $day_wise_query->result();
    }

    public function itemCount($table,$select,$where){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function AuditSummary(){
        // $data['title']      =   'Audit Summary Report';
        // $site               =   $this->session->userdata('site');
        // $user_group         =   $this->session->userdata('u_group');
        // $sqlQuery           =   'SELECT  `s_name` ,`s_id` FROM `sites` WHERE `s_id` IN ('.$site.')';
        // $data['sites']      =   $this->db->query($sqlQuery)->result();
        // $sqlQuery           =   'SELECT  `g_name` ,`g_id` FROM `groups` WHERE `g_id` IN ('.$user_group.')';
        // $data['groups']     =   $this->db->query($sqlQuery)->result();
        // $fromdate           =   (!empty($this->input->post('fromdate')) ?  $this->input->post('fromdate') : date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) )));
        // $todate             =   (!empty($this->input->post('todate')) ? $this->input->post('todate') : date('Y-m-d'));
        // $sitePost           =   $this->input->post('site') ? $this->input->post('site') : '';
        // $groupPost          =   $this->input->post('groups') ? $this->input->post('groups') : '';
        // $data['fromdate']   =   $fromdate;
        // $data['todate']     =   $todate;
        // $data['sitePost']   =   $sitePost;
        // $data['groupPost']  =   $groupPost;
        // $tempaltes          =  $this->getTemplateName($sitePost,$groupPost);
        // $all_audit_sql      = "";
        // foreach($tempaltes as $tkey => $tvalue) {
        //     $templateName       = $tvalue->tn;
        //     $templateGroupId    = $tvalue->group_id;
        //     $templateSiteId     = $tvalue->site_id;
        //     $templateUniqueId   = $tvalue->tmp_unique_id;
        //     $templateSiteName   = $tvalue->g;
        //     $templateGroupName  = $tvalue->s;
        //     $all_audit_sql .="SELECT unique_id as audit_id,'$templateName' as TemplateName,(select GROUP_CONCAT(DISTINCT s_name ) from sites where find_in_set(s_id,site_id)) as audit_sites,evaluator_name as auditor_name,total_score as auditor_score,status,DATE_FORMAT(submit_time, '%d-%b-%y') as audit_date FROM  $templateName WHERE  DATE(submit_time) >= '$fromdate' AND DATE(submit_time) <= '$todate' UNION ALL ";
        // }
        // $ovelall_words = explode( "UNION ALL", $all_audit_sql);
        // array_splice( $ovelall_words, -1 );
        // $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );        
        // $overall_total_qa_sql ="SELECT *  FROM ($overall_qa_total_sql)t ORDER BY STR_TO_DATE(audit_date, '%d-%M-%y') ASC";  
        // $overall_query = $this->db->query($overall_total_qa_sql);
        // $data['content'] = $overall_query->result();
        $data = $this->report();
        $this->load->view('other/audit_summary_report',$data);
    }    
    public function AuditDetails(){
        $data = $this->report();        
        $this->load->view('other/audit_details_report',$data);
    }

    public function report(){
        $data['title']        = 'Audit Details Report';
        $site               =   $this->session->userdata('site');
        $user_group         =   $this->session->userdata('u_group');
        $sqlQuery           =   'SELECT  `s_name` ,`s_id` FROM `sites` WHERE `s_id` IN ('.$site.')';
        $data['sites']      =   $this->db->query($sqlQuery)->result();
        $sqlQuery           =   'SELECT  `g_name` ,`g_id` FROM `groups` WHERE `g_id` IN ('.$user_group.')';
        $data['groups']     =   $this->db->query($sqlQuery)->result();
        $fromdate           =   (!empty($this->input->post('fromdate')) ?  $this->input->post('fromdate') : date('Y-m-d',strtotime(date('Y-m-01'))));
        $todate             =   (!empty($this->input->post('todate')) ? $this->input->post('todate') : date('Y-m-d'));
        $sitePost           =   $this->input->post('site') ? $this->input->post('site') : '';
        $groupPost          =   $this->input->post('groups') ? $this->input->post('groups') : '';
        $data['fromdate']   =   $fromdate;
        $data['todate']     =   $todate;
        $data['sitePost']   =   $sitePost;
        $data['groupPost']  =   $groupPost;
        $template_details     =  $this->getTemplateName($sitePost,$groupPost);
        if(!empty($template_details)){
            $failed_item_attr_sql = '';
            foreach ($template_details as $tkey => $tvalue) {
                $templateName       = $tvalue->tn;
                $newtemplateName    = str_replace('tb_temp_','',$templateName);
                $formName           = $tvalue->template_name;
                $templateGroupId    = $tvalue->group_id;
                $templateSiteId     = $tvalue->site_id;
                $templateUniqueId   = $tvalue->tmp_unique_id;
                $templateSiteName   = $tvalue->g;
                $templateGroupName  = $tvalue->s;
                $failed_item_attr_sql .="SELECT t_att_id,'$templateName' as TableName,'$formName' as template_name FROM  template  WHERE  t_unique_id = '$newtemplateName' and t_cat_id != 'cat1' AND (t_option_type = 'select' OR t_option_type = 'checkbox') UNION ALL ";
            }
            $failed = explode( "UNION ALL", $failed_item_attr_sql);
            array_splice( $failed, -1 );
            $failed_sql = implode( "UNION ALL", $failed );
            if(!empty($failed_sql)){
                $failed_q ="SELECT * FROM ($failed_sql)t"; 
                $failed_query = $this->db->query($failed_q);
                $failed_result = $failed_query->result_array();
                $failed_attr_arr = [];
                foreach ($failed_result as $key => $value) {
                    $att_id = explode("_", $value['t_att_id']);
                    $failed_id = $att_id[0].'_fail';
                    if (array_key_exists($value['TableName'],$failed_attr_arr)){
                        $failed_attr_arr[$value['TableName']][] = ['fail'=>$failed_id,'template_name'=>$value['template_name']];
                        //$failed_attr_arr[$value['TableName']][] = $failed_id;
                    }
                    else{
                    $failed_attr_arr[$value['TableName']][] = ['fail'=>$failed_id,'template_name'=>$value['template_name']];
                    //$failed_attr_arr[$value['TableName']][] = $failed_id;
                    }
                }
                $failed_item_sql = '';
                foreach ($failed_attr_arr as $key => $value) {
                    $template_name = array_unique(array_column($value, 'template_name'))[0];
                    $failed_item_sql .="SELECT unique_id as audit_id,tmp_unique_id,'$key' as TemplateName,'$template_name' as template_name,
                    (select GROUP_CONCAT(DISTINCT s_name ) 
                    FROM 
                        sites 
                    WHERE 
                        find_in_set(s_id,site_id)) AS audit_sites,
                        evaluator_name AS auditor_name,
                        total_score AS auditor_score,
                        status,
                        DATE_FORMAT(submit_time, '%d-%b-%y') AS audit_date,
                        feedback_com AS auditor_comment";
                    $failed_item_sql .=",(";
                    foreach ($value as $key1 => $value1) {
                        $failed_item_sql .= " CASE WHEN ".$value1['fail']." = 'yes' THEN 1 ELSE 0 END + ";
                    }
                    $failed_item_sql = rtrim($failed_item_sql,' +');
                    $failed_item_sql .= " ) as total_failed,";
                    $unique_id = $temp = str_replace('tb_temp_','',$key);
                    $failed_item_sql .= "(select count(t_att_id) from template where t_unique_id = '$unique_id' AND t_cat_id != 'cat1') as total_attribute FROM  $key WHERE  DATE(submit_time) >= '$fromdate' AND DATE(submit_time) <= '$todate' UNION ALL ";
                }
                $failed_item = explode( "UNION ALL", $failed_item_sql);
                array_splice( $failed_item, -1 );
                $failed_sql = implode( "UNION ALL", $failed_item );
                if(!empty($failed_sql)){
                    $failed_item_q ="SELECT *,round(((total_failed/total_attribute)*100),2) AS faild_per FROM ($failed_sql)t ORDER BY STR_TO_DATE(audit_date, '%d-%M-%y') ASC"; 
                    $failed_item_query = $this->db->query($failed_item_q);
                    $failed_item_result = $failed_item_query->result();
                }
            }
        // print_r($failed_item_result);die;
        }
        // echo $this->db->last_query();die;
        $data['content'] = (!empty($failed_item_result)?$failed_item_result:[]);
        return $data;
    }
//please write above	
}
