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
        $sitePost 		    =   $this->input->post('site') ? implode(',',$this->input->post('site')) : $site ;
        $groupPost 		    =   $this->input->post('groups') ? implode(',',$this->input->post('groups')) :$user_group;
        $data['fromdate']   =   $fromdate;
        $data['todate']     =   $todate;
        $data['sitePost']   =   $sitePost;
        $data['groupPost']  =   $groupPost;
        $updatestatus ='updatestatus';
        //if(strtotime($todate) < strtotime($fromdate)){
           $formdata      =  $this->common->getTemplateDetails($site,$user_group);
           $templates = $this->common->getTemplateDetails($sitePost,$groupPost);
            // echo $this->db->last_query();
           
            $template =  !empty($this->input->post('tempaltes')) ? $this->postTemplate($this->input->post('tempaltes')) :  $templates;
            // if($this->input->post()){
                // print_r($template);die;
            // }
            //var_dump($this->postTemplate($this->input->post('tempaltes')));die();
            if(!empty($template)){
                $data['tempaltes'] = $formdata;
                $data['postTemplates'] = (!empty($this->input->post('tempaltes'))?$this->input->post('tempaltes'):'');
                $content = '';
                $content .='<div class="table-section mt-24"><div class="card"><div class="card-content">';
                $content .= '<h4 class="card-title">Action Item</h4>';
                $content .= '<table class=" data_table stripe hover" id="escalation_data" style="width:100%"><thead><tr>
                    <th>Audit Template</th><th>Unique ID</th><th>Action Item</th><th>Auditor Comment</th><th>Reviewer Comment</th>';
                $content .= ($this->emp_group != 'manager')?"<th>Status</th>":"";
                $content .= '</tr></thead><tbody>';
                $attr_name_data = '';
                // print_r($template);die;
                foreach ($template as $key => $t_value) {
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
                    $attCom   = $attNumber .'_com';
                    $tableNmae  = strtolower($att_value->TableName);
                    $failed_sql .="SELECT t1.unique_id,t1.$attCom as overall_com ,'$attributeName' as attributeName,'$templateName' as templateName,'$att_value->t_att_id' as t_att_id,'$TableName' as TableName,(select status from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as status,(select att_comment from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as att_comment FROM $tableNmae t1
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
                    $status =   (($status  == '1') ? 'Overdue' : (($status == '2') ? 'Closed' : 'Pending'));
                    $cmt =      (!empty($cmt) ? $cmt : 'NA');
                    $auditorcmt =      (!empty($f_value->overall_com) ? $f_value->overall_com : '');
                    $content .='<tr  role="row">
                                <td>'.$f_value->templateName.'</td>
                                <td> <a href="'.$burl.'" target="_blank">'.$f_value->unique_id.'</a></td>
                                <td>'.$f_value->attributeName.'</td>
                                <td id="'.$f_value->unique_id.$f_value->t_att_id.'">'.$auditorcmt.'</td>                                
                                <td id="cmt'.$f_value->unique_id.$f_value->t_att_id.'">'.$cmt.'</td>';
                                if($status  == 'Overdue')
                                {
                                    $overdue = 'Overdue';
                                $content .= ($this->emp_group != 'manager')?'<td ><a  class="notify_btn  active" style="background-color: red;" href="javascript:void(0)" id="'.$f_value->unique_id.$f_value->t_att_id.$updatestatus.'" onclick="findata(`'.$f_value->unique_id.'` , `'.$f_value->unique_id.'`,`'.$f_value->t_att_id.'`,`'.$overdue.'`)">'.$status.'</a></td>':"";    
                                }else if($status == 'Closed'){
                                    $closed ='Closed';
                                $content .= ($this->emp_group != 'manager')?'<td><a  class="notify_btn modal-trigger open_modal active"  href="#alert_choose_modal" id="'.$f_value->unique_id.$f_value->t_att_id.$updatestatus.'" onclick="findata(`'.$f_value->unique_id.'` , `'.$f_value->unique_id.'`,`'.$f_value->t_att_id.'`,`'.$closed.'`)">'.$status.'</a></td>':"";  
                                }else if($status == 'Pending'){
                                    $pending ='Pending';
                                $content .= ($this->emp_group != 'manager')?'<td><a  class="notify_btn modal-trigger open_modal active" style="background-color: #ff6e40;" href="#alert_choose_modal" id="'.$f_value->unique_id.$f_value->t_att_id.$updatestatus.'" onclick="findata(`'.$f_value->unique_id.'` , `'.$f_value->unique_id.'`,`'.$f_value->t_att_id.'`,`'.$pending.'`)">'.$status.'</a></td>':"";  
                                }
                    $content .='</tr>';
                } 
                $content.='</tbody></table></div></div></div>';
                $data['content'] = $content;
            }
            else{
                $data['content'] = "No Template Found";
            }
             
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
    
    public function getTemplateName($siteID=null , $groupID=null){
    	$user_id 		= 	$this->session->userdata['user_id'];
		$site 			= 	$this->session->userdata('site');
		$user_group 	= 	$this->session->userdata('u_group'); 
		$site           =   (!empty($siteID) ? implode(',',$siteID) : $site);
        $user_group 	=   (!empty($groupID) ? implode(',' , $groupID) : $user_group);
		$sql = "SELECT td.tb_name as tn,group_id,site_id,td.tmp_unique_id,td.temp_status as status, DATE_FORMAT(td.created_date,'%Y-%m-%d') as cd,
				(select GROUP_CONCAT(DISTINCT g_name ) from groups where find_in_set(g_id,td.group_id)) as g,
				(select GROUP_CONCAT(DISTINCT s_name ) from sites where find_in_set(s_id,td.site_id))as s,td.tmp_name as template_name
				FROM template_details AS td
				where 
				td.temp_status = '1'
				AND
                group_id REGEXP '(^|,)".$user_group."(,|$)'
                AND
                site_id REGEXP '(^|,)".$site."(,|$)'";
		$day_wise_query = $this->db->query($sql);
        //echo $this->db->last_query();die;
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
        $sites     =    $this->session->userdata('site');
        $groups    =    $this->session->userdata('u_group');
        $data      =    $this->report();
        $sitePost  =    $this->input->post('site') ? $this->input->post('site') : '';
        $groupPost =    $this->input->post('groups') ? $this->input->post('groups') : '';
        $where = '';
        if(!empty($sitePost) && !empty($groupPost)){
            $sitePost   =   implode(',', $sitePost);
            $groupPost   =   implode(',', $groupPost);
            $where = 'u_group REGEXP  "[[:<:]]'.$sitePost.'[[:>:]]" AND site REGEXP "[[:<:]]'.$groupPost.'[[:>:]]"';
        }
        else if(!empty($sitePost) && empty($groupPost)){
            $sitePost   =   implode(',', $sitePost);
            $where = 'site REGEXP "[[:<:]]'.$groupPost.'[[:>:]]"';
        }
        else if(empty($sitePost) && !empty($groupPost)){
            $groupPost   =   implode(',', $groupPost);
            $where = 'u_group REGEXP  "[[:<:]]'.$sitePost.'[[:>:]]"';
        }
        else{
            $where = 'u_group REGEXP  "[[:<:]]'.$sites.'[[:>:]]" AND site REGEXP "[[:<:]]'.$groups.'[[:>:]]"';
        }
        $site               =   $this->session->userdata('site');
        $user_group         =   $this->session->userdata('u_group');
        $sql = "SELECT DISTINCT(name) FROM user WHERE $where AND usertype='2'";
        $failed_item_query = $this->db->query($sql);
        $data['user'] = $failed_item_query->result();
        // print_r($data);die;

        $this->load->view('other/audit_summary_report',$data);
    }    
    public function AuditDetails(){
        $data = $this->report();  
        $sites     =    $this->session->userdata('site');
        $groups    =    $this->session->userdata('u_group');
        $data      =    $this->report();
        $sitePost  =    $this->input->post('site') ? $this->input->post('site') : '';
        $groupPost =    $this->input->post('groups') ? $this->input->post('groups') : '';
        $where = '';
        if(!empty($sitePost) && !empty($groupPost)){
            $sitePost   =   implode(',', $sitePost);
            $groupPost   =   implode(',', $groupPost);
            $where = 'u_group REGEXP  "[[:<:]]'.$sitePost.'[[:>:]]" AND site REGEXP "[[:<:]]'.$groupPost.'[[:>:]]"';
        }
        else if(!empty($sitePost) && empty($groupPost)){
            $sitePost   =   implode(',', $sitePost);
            $where = 'site REGEXP "[[:<:]]'.$groupPost.'[[:>:]]"';
        }
        else if(empty($sitePost) && !empty($groupPost)){
            $groupPost   =   implode(',', $groupPost);
            $where = 'u_group REGEXP  "[[:<:]]'.$sitePost.'[[:>:]]"';
        }
        else{
            $where = 'u_group REGEXP  "[[:<:]]'.$sites.'[[:>:]]" AND site REGEXP "[[:<:]]'.$groups.'[[:>:]]"';
        }
        $site               =   $this->session->userdata('site');
        $user_group         =   $this->session->userdata('u_group');
        $sql = "SELECT DISTINCT(name) FROM user WHERE $where AND usertype='2'";
        $failed_item_query = $this->db->query($sql);
        $data['user'] = $failed_item_query->result();      
        $this->load->view('other/audit_details_report',$data);
    }

    public function report(){
        $data['title']      =   'Audit Details Report';
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
        // print_r($sitePost);die;
        // $template_details   =  $this->getTemplateName($sitePost,$groupPost);
        $tempaltes =    $this->getTemplateName($sitePost,$groupPost);
        $template_details  =    !empty($this->input->post('tempaltes')) ? $this->postTemplate($this->input->post('tempaltes')) : $tempaltes;
        $data['tempaltes'] = $tempaltes;
        $users  =    !empty($this->input->post('user')) ? $this->input->post('user') : [];
        $data['users'] = $users;
        $userWhere = '';
        if(!empty($users)){
            $users = implode(",", $users);
            $userWhere .= "AND FIND_IN_SET(evaluator_name,'$users')";
        }
        $data['postTemplates'] = (!empty($this->input->post('tempaltes'))?$this->input->post('tempaltes'):'');
        //print_r($template_details);die;
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
                    $failed_item_sql .= "(select count(t_att_id) from template where t_unique_id = '$unique_id' AND t_cat_id != 'cat1') as total_attribute FROM  $key  WHERE  DATE(submit_time) >= '$fromdate' AND DATE(submit_time) <= '$todate' $userWhere UNION ALL ";
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
        if(!empty($failed_item_result)){
            $totalAudit = count($failed_item_result);
            $data['total_audit'] = $totalAudit;
            $total_score = 0;
            $faild_per = 0;
            foreach ($failed_item_result as $key => $value) {
                $total_score = $total_score + $value->auditor_score;
                $faild_per = $faild_per + $value->faild_per;
            }
            $data['avg'] = round($total_score/$totalAudit,2);
            $data['failed_avg'] = round($faild_per/$totalAudit,2);
        }
        $data['content'] = (!empty($failed_item_result)?$failed_item_result:[]);
        return $data;
    }

    protected function postTemplate($post){
        
        $tem = str_replace("tb_temp_", '', implode(",", $post));
        
        $sql = "SELECT td.tb_name as tn,group_id,site_id,td.tmp_unique_id,td.temp_status as status, DATE_FORMAT(td.created_date,'%Y-%m-%d') as cd,
                (select GROUP_CONCAT(DISTINCT g_name ) from groups where find_in_set(g_id,td.group_id)) as g,
                (select GROUP_CONCAT(DISTINCT s_name ) from sites where find_in_set(s_id,td.site_id))as s,td.tmp_name as template_name
                FROM template_details AS td
                where 
                td.temp_status = '1'
                AND
                FIND_IN_SET(tmp_unique_id,'".$tem."')";
        $day_wise_query = $this->db->query($sql);
        return $day_wise_query->result();
    }

    public function attributeReport(){
        if($this->emp_group == "reviewer" || $this->emp_group == 'manager'){
            $start_date   =   $this->input->post('fromdate') ?  $this->input->post('fromdate') : date('Y-m-d',strtotime(date('Y-m-01')));
            $end_date =   $this->input->post('todate') ? $this->input->post('todate') : date('Y-m-d');
            $data['fromdate']     =   $start_date;
            $data['todate']   =   $end_date;
            $tempaltes      =  $this->getTemplateName();
            $template       =  !empty($this->input->post('tempaltes')) ? $this->postTemplate($this->input->post('tempaltes')) : $tempaltes;        
            $data['tempaltes'] = $tempaltes;
            $data['postTemplates'] = (!empty($this->input->post('tempaltes'))?$this->input->post('tempaltes'):'');
            $data['content'] = '';
            $temp_attr = [];
            $tableName = 'No Data Found';
            foreach ($template as $key => $value) {
                // get template attribute
                $tmpUniqueId    = $value->tmp_unique_id;
                //if('5d7a099a95b2f9046119' == $tmpUniqueId){ // chck data template wise
                    $tableName      = $value->tn;
                    $templateName   = $value->template_name;
                    $total_response = $this->common->getWhereSelectAll($tableName,['count(audit_sr_no) as total_audit','round(avg(total_score),2) as avg'],['DATE(submit_time) >=' => $start_date,'DATE(submit_time) <=' => $end_date]);
                    $temp_attr = $this->common->getWhereSelectAll('template',['t_att_id','t_att_name',"'$tableName' as tableName",'t_option_value'],
                        [
                            't_unique_id'=>$tmpUniqueId,
                            't_cat_id !='=> 'cat1',
                            't_option_type' => 'select'                        
                        ]
                    );
                    //End get template attribute
                    $data['total_audit'] = (!empty($total_response)?$total_response[0]->total_audit:0);
                    $data['avg'] = (!empty($total_response)?$total_response[0]->avg:0);
                    break;
                //} // end if
            }
            $opt_sql = '';
            if(!empty($temp_attr)){
                $failed_attr_arr = [];
                $opt_sql .="SELECT ";
                foreach ($temp_attr as $key => $value) {
                    $attr_name = str_replace("'", "`", $value->t_att_name);
                    $att_id = explode("_", $value->t_att_id);
                    $failed_id = $att_id[0].'_fail';
                    $failed_attr_arr[$value->tableName][] = $failed_id;
                    // attribute response
                    $response = explode('|',$value->t_option_value);
                    foreach ($response as $okey => $ovalue) {
                        $opt_sql .= "sum(";
                        // $opt_sql .= '(CASE WHEN '.$value->t_att_id.' REGEXP "[[:<:]]'.trim($ovalue).'[[:>:]]" THEN 1 ELSE 0 END)+';
                        $opt_sql .= '(CASE WHEN '.$value->t_att_id.' LIKE "%'.trim($ovalue).'%" THEN 1 ELSE 0 END)+';
                        $opt_sql = rtrim($opt_sql,' +');
                        $opt_sql .= " ) as '".$value->t_att_id."___san__to__sh__".$attr_name."___san__to__sh__".trim($ovalue)."',";
                    }
                }
                $opt_sql = rtrim($opt_sql,',');
                $opt_sql .= " FROM  $tableName WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date'";
                // echo $opt_sql;die;
                if(!empty($opt_sql)){
                    $opt_query = $this->db->query($opt_sql);
                    $opt_result = $opt_query->result_array();
                    $opt_result = (!empty($opt_result)?$opt_result[0]:[]);
                    foreach ($opt_result as $key3 => $value3) {


                        //$attr_id = explode("___san__to__attr_sh__", $key3);
                        $attrKey = explode("___san__to__sh__", $key3);
                        //$data1[next($attrKey)][prev($attrKey)][] = [end($attrKey)=>$value3];
                        // $data1[$attrKey[0]][$attrKey[1]][] = [$attrKey[2]=>$value3];
                        $data1[current($attrKey)][next($attrKey)][] = [end($attrKey)=>$value3?$value3:0];
                    }                    
                }
                // echo $this->db->last_query();die;
                // print_r($data1);die;
                $data['attr_data'] = $data1;
                $table = '';
                $table .= '<h4 class="card-title">Attributes Summary</h4>';
                $table .= "<table class='data_table stripe hover' style='width:100%'><thead><tr><th>Attribute Name</th><th>Response</th>";
                $table .= '</tr></thead><tbody>';
                foreach ($data1 as $key => $value) {
                    
                    foreach ($value as $keyname => $keyvalue) {

                    $table .= "<tr><td>$keyname</td><td>";
                        foreach ($keyvalue as $keyname1 => $keyvalue1) {
                            foreach ($keyvalue1 as $key22 => $value22) {
                                // echo $key22;die;            
                                $table .= $key22."-><span class='attr_count' attr='".$key."' attr_value='".$key22."' tb='".$tableName."'>".$value22."</span>&nbsp;&nbsp;";
                            }
                        }
                    }
                    $table .= "</td></tr>";
                }
                $table .= "</tbody></table>";
                    // echo $table;die;
                $data['content'] = $table;
                if(!empty($failed_attr_arr)){
                    $failed_item_sql = '';
                    $attr_fail_count = 0;
                    foreach ($failed_attr_arr as $key => $value) {
                        $failed_item_sql .="SELECT SUM(";
                        foreach ($value as $key1 => $value1) {
                            $attr_fail_count++;
                            $failed_item_sql .= "CASE WHEN $value1 = 'yes' THEN 1 ELSE 0 END + ";
                        }
                        $failed_item_sql = rtrim($failed_item_sql,' +');
                        $failed_item_sql .= " ) as total_failed FROM  $key WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
                    }
                    // echo $failed_item_sql;die;
                    $failed_item = explode( "UNION ALL", $failed_item_sql);
                    array_splice( $failed_item, -1 );
                    $failed_sql = implode( "UNION ALL", $failed_item );
                    if(!empty($failed_sql)){
                        $failed_item_q ="SELECT sum(total_failed) as total_failed FROM ($failed_sql)t"; 
                        $failed_item_query = $this->db->query($failed_item_q);
                        $failed_item_result = $failed_item_query->result_array();
                    }
                    $data['failed_avg'] = (!empty($failed_item_result)?round((($failed_item_result[0]['total_failed']/$attr_fail_count)),2):0)."%";
                    $data['failed_count'] = (!empty($failed_item_result)?$failed_item_result[0]['total_failed']:0);
                }
            }
            // echo "<pre>";
            // if($this->input->post()){
            //     print_r($data);die;
            // }
            $this->load->view('other/attribute_report',$data);
        }
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);
        }
    }

    public function attributeReportDetails(){
        $post = $this->input->post();
        $tableName = $post['tb'];
        $attributeField = $post['attr'];
        $searchCondition = $post['attr_value'];
        $start_date = $post['fromdate'];
        $end_date = $post['todate'];
        
        $total_response = $this->common->getWhereSelectAll($tableName,['unique_id','evaluator_name','tmp_unique_id','total_score','submit_time'],[
            $attributeField =>$searchCondition,
            'DATE(submit_time) >=' => $start_date,'DATE(submit_time) <=' => $end_date
        ]);
        echo postRequestResponse($total_response);
    }
//please write above	
}
