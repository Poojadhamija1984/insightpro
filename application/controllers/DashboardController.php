<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends MY_Controller {	
	public function index(){
        // echo $this->emp_group;die;
        $common = $this->config->item('common');
        $data['heading'] = $common[0];
		if(($this->emp_group == "client" || $this->emp_group == "ops") && $this->emp_type == "supervisor"){
            $data                               =   [];
            $where                              =   [];
            $frmData                            =   [];
            $supervisor_id                     =   $this->session->userdata('empid');
            $lob                                =   explode('|||', $this->session->userdata('lob'));
            $till_date["date(submit_time) >="]  =   date('Y-m-d',strtotime(date('Y-m-01')));
            $till_date["date(submit_time) <="]  =   date('Y-m-d');
            $pre_date["date(submit_time) >="]   =   date('Y-m-d', strtotime('-1 month'));
            $pre_date["date(submit_time) <="]   =   date('Y-m-d', strtotime('last day of last month'));
            $emp_condition_field                =   (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
            $form_name                          =   $this->getFormName($lob);
           
            if(!empty($form_name)){
                foreach ($form_name as $key => $value) {
                    $frmData[$value->lob] = ['form_name'=>$value->form_name,'pass_rate'=>$value->pass_rate];
                }
                $filter_sql = '';
                $dashboard_filter_details           =   $this->common->getWhere('dashboard',['sup_id'=>$supervisor_id]);
                
                if(!empty($dashboard_filter_details)){
                    $lob = explode(',', $dashboard_filter_details[0]->lob);
                    if(!empty($dashboard_filter_details[0]->campaign)){
                        $campaign_implode = "'".$dashboard_filter_details[0]->campaign."'";
                        $filter_sql .=  " AND FIND_IN_SET(campaign,$campaign_implode)";
                    }
                    if(!empty($dashboard_filter_details[0]->vendor)){
                        $vendor_implode = "'".$dashboard_filter_details[0]->vendor."'";
                        $filter_sql .=  " AND FIND_IN_SET(vendor,$vendor_implode)";
                    }
                    if(!empty($dashboard_filter_details[0]->location)){
                        $location_implode = "'".$dashboard_filter_details[0]->location."'";
                        $filter_sql .=  " AND FIND_IN_SET(location,$location_implode)";
                    }
                    if(!empty($dashboard_filter_details[0]->agent)){
                        $agents_implode = "'".$dashboard_filter_details[0]->agent."'";
                        $filter_sql .=  " AND FIND_IN_SET($emp_condition_field,$agents_implode)";
                    }
                }
            }   
            if($this->input->post()){
                // var_dump('jai');die();
                //print_r($this->input->post());
                if(!empty($this->input->post('lob'))){
                    $lob = $this->input->post('lob');
                    $filter_sql     = '';
                    $filter_lob     = implode(',',$this->input->post('lob'));
                    $campaign       = ((!empty($this->input->post('campaign')))?implode(',',$this->input->post('campaign')):'');
                    $vendor         = ((!empty($this->input->post('vendor')))?implode(',',$this->input->post('vendor')):'');
                    $location       = ((!empty($this->input->post('location')))?implode(',',$this->input->post('location')):'');
                    $agents         = ((!empty($this->input->post('agents')))?implode(',',$this->input->post('agents')):'');
                    $filter_data    = ['lob'=>$filter_lob,'campaign'=>$campaign,'vendor'=>$vendor,'location'=>$location,'agent'=>$agents,'sup_id'=>$supervisor_id];
                    // print_r($filter_data);die;
                    if(!empty($dashboard_filter_details)){
                        $this->common->update_data('dashboard',$filter_data,['sup_id'=>$supervisor_id]);
                    }
                    else{
                        $this->common->insert_data($filter_data,'dashboard');
                    }
                    if(!empty($campaign)){
                        $campaign_implode = "'".$campaign."'";
                        $filter_sql .=  " AND FIND_IN_SET(campaign,$campaign_implode)";
                    }
                    if(!empty($vendor)){
                        $vendor_implode = "'".$vendor."'";
                        $filter_sql .=  " AND FIND_IN_SET(vendor,$vendor_implode)";
                    }
                    if(!empty($location)){
                        $location_implode = "'".$location."'";
                        $filter_sql .=  " AND FIND_IN_SET(location,$location_implode)";
                    }
                    if(!empty($agents)){
                        $agents_implode = "'".$agents."'";
                        $filter_sql .=  " AND FIND_IN_SET($emp_condition_field,$agents_implode)";
                    }
                    $lob_new_data = [];
                    foreach ($lob as $lob_value) {
                        $key = array_search($lob_value, array_column($form_name, 'lob'));
                        $lob_new_data[] = $form_name[$key];
                    }
                    $frmData = (!empty($lob_new_data)?$lob_new_data:$form_name);
                    //$data = $this->getOverAllQAScore($this->input->post('lob'),$till_date,$pre_date,$filter_sql);
                    $data['overallqadata']              =   $this->totalOverAllEvulation($frmData,$till_date,$pre_date,$filter_sql);
                    // print_r($data['overallqadata']);die;
                    $total_overall_evulation = $data['overallqadata']['total_overall_evulation'];
                    if($total_overall_evulation > 0){
                        $data['feedbackEscalationFatal']    =   $this->feedbackEscalationFatal($frmData,$till_date,$filter_sql);
                        $data['AgentWise']                  =   $this->AgentWise($frmData,$till_date,$filter_sql);
                        $data['kpi']                        =   $this->kpi($frmData,$till_date,$filter_sql);
                        $data['arrtibute']                  =   $this->arrtibuteData($emp_condition_field,$frmData,$till_date,$filter_sql);
                        $data['category']                   =   $this->categoryData($emp_condition_field,$frmData,$till_date,$filter_sql);
                        $data['escalationRate']             =   $this->escalationRate($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                        $data['autoFail']                   =   $this->autoFail($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                        $data['passRate']                   =   $this->passRate($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                    }else{
                        $data['feedbackEscalationFatal']    =   [];
                        $data['AgentWise']                  =   [];
                        $data['kpi']                        =   [];
                        $data['arrtibute']                  =   [];
                        $data['category']                   =   [];
                        $data['escalationRate']             =   [];
                        $data['autoFail']                   =   [];
                        $data['passRate']                   =   [];
                    }
                    $data['totilldate']     = date('Y-m-d',strtotime(date('Y-m-01')));
                    $data['fromtilldate']   = date('Y-m-d');
                    $data['currentLob']     = $this->input->post('lob')[0];
                    $data['allLob']         = $this->input->post('lob');
                    $data['result']         = true;
                    $data['dashboard_filter_details']   =   json_encode([['lob'=>$filter_lob,'campaign'=>$campaign,'vendor'=>$vendor,'location'=>$location,'agent'=>$agents,'sup_id'=>$supervisor_id]]);
                    $data['date_range'] = 'CurrentMonth';
                    $data['daterangeto']= '';
                    $data['daterangefr']= '';
                    // print_r($data);die;
                }
                else{
                    $date_range = $this->input->post('date_range');
                    if($date_range != "Custom"){
                        $dateWhere = $this->dateRange($date_range);
                        $sdate = $dateWhere["date(submit_time) >="];
                        $edate = $dateWhere["date(submit_time) <="];
                        $till_date["date(submit_time) >="] = $sdate;
                        $till_date["date(submit_time) <="] = $edate;
                        $pre_date["date(submit_time) >="] = date('Y-m-01', strtotime('-1 months', strtotime($sdate)));
                        $pre_date["date(submit_time) <="] = date('Y-m-t', strtotime('-1 months', strtotime($edate)));
                    }
                    else{
                        $sdate = $this->input->post('filter_start_date');
                        $edate = $this->input->post('filter_end_date');
                        $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sdate));
                        $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($edate));
                        $pre_date["date(submit_time) >="] = date('Y-m-01', strtotime('-1 months', strtotime($sdate)));
                        $pre_date["date(submit_time) <="] = date('Y-m-t', strtotime('-1 months', strtotime($sdate)));
                    }
                    
                    $lob_new_data = [];
                    foreach ($lob as $lob_value) {
                        $key = array_search($lob_value, array_column($form_name, 'lob'));
                        $lob_new_data[] = $form_name[$key];
                    }
                    $lob_new_data = array_map("unserialize", array_unique(array_map("serialize", $lob_new_data)));
                    $frmData = (!empty($lob_new_data)?$lob_new_data:$form_name);
                    // print_r($frmData);die;
                    $data['overallqadata']              =   $this->totalOverAllEvulation($frmData,$till_date,$pre_date,$filter_sql);
                    // print_r($data['overallqadata']);die;
                    $total_overall_evulation = $data['overallqadata']['total_overall_evulation'];
                    if($total_overall_evulation > 0){
                        $data['feedbackEscalationFatal']    =   $this->feedbackEscalationFatal($frmData,$till_date,$filter_sql);
                        $data['AgentWise']                  =   $this->AgentWise($frmData,$till_date,$filter_sql);
                        $data['kpi']                        =   $this->kpi($frmData,$till_date,$filter_sql);
                        $data['arrtibute']                  =   $this->arrtibuteData($emp_condition_field,$frmData,$till_date,$filter_sql);
                        $data['category']                   =   $this->categoryData($emp_condition_field,$frmData,$till_date,$filter_sql);
                        $data['escalationRate']             =   $this->escalationRate($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                        $data['autoFail']                   =   $this->autoFail($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                        $data['passRate']                   =   $this->passRate($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                    }else{
                        $data['feedbackEscalationFatal']    =   [];
                        $data['AgentWise']                  =   [];
                        $data['kpi']                        =   [];
                        $data['arrtibute']                  =   [];
                        $data['category']                   =   [];
                        $data['escalationRate']             =   [];
                        $data['autoFail']                   =   [];
                        $data['passRate']                   =   [];
                    }
                    $data['totilldate']     = date('Y-m-d',strtotime($sdate));
                    $data['fromtilldate']   = date($edate);
                    $data['currentLob']     = $lob[0];
                    $data['allLob']         = $lob;
                    $data['result']         = true;
                    $data['dashboard_filter_details']   =   json_encode((!empty($dashboard_filter_details))?$dashboard_filter_details:[]);
                    $data['date_range'] = $date_range;
                    $data['daterangeto']= (($date_range == "Custom")?$sdate:'');
                    $data['daterangefr']= (($date_range == "Custom")?$edate:'');
                    // print_r($data);die;
                    //$this->load->view('dashboard_new',$data);
                }
            }
            else{
                $lob_new_data = [];
                if(!empty($form_name)){
                    foreach ($lob as $lob_value) {
                        $key = array_search($lob_value, array_column($form_name, 'lob'));
                        $lob_new_data[] = $form_name[$key];
                    }
                    $frmData = (!empty($lob_new_data)?$lob_new_data:$form_name);
                    $data['overallqadata']              =   $this->totalOverAllEvulation($frmData,$till_date,$pre_date,$filter_sql);
                    $total_overall_evulation            =   $data['overallqadata']['total_overall_evulation'];
                    $data['feedbackEscalationFatal']    =   $this->feedbackEscalationFatal($frmData,$till_date,$filter_sql);
                    $data['AgentWise']                  =   $this->AgentWise($frmData,$till_date,$filter_sql);
                    $data['kpi']                        =   $this->kpi($frmData,$till_date,$filter_sql);
                    $data['arrtibute']                  =   $this->arrtibuteData($emp_condition_field,$frmData,$till_date,$filter_sql);
                    $data['category']                   =   $this->categoryData($emp_condition_field,$frmData,$till_date,$filter_sql);
                    $data['escalationRate']             =   $this->escalationRate($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                    $data['autoFail']                   =   $this->autoFail($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);
                    $data['passRate']                   =   $this->passRate($frmData,$till_date,$pre_date,$filter_sql,$total_overall_evulation);

                    // echo json_encode($data);
                    // print_r($data['kpi']);
                    // die;
                    //$data = $this->getOverAllQAScore($lob,$till_date,$pre_date,$filter_sql);
                    $data['totilldate']     = date('Y-m-d',strtotime(date('Y-m-01')));
                    $data['fromtilldate']   = date('Y-m-d');
                    $data['currentLob']     = $lob[0];
                    $data['allLob']         = $lob;
                    $data['dashboard_filter_details']   =   json_encode((!empty($dashboard_filter_details))?$dashboard_filter_details:[]);
                    $data['date_range'] = 'CurrentMonth';
                    $data['daterangeto']= '';
                    $data['daterangefr']= '';
                }
            }
            $data['campaign'] = $this->common->getWhereInSelectAll('hierarchy','distinct(campaign)','lob',explode('|||', $this->session->userdata('lob')));
            // echo $this->db->last_query();die;
            $data['vendor'] = $this->common->getWhereInSelectAll('hierarchy','distinct(vendor)','lob',explode('|||', $this->session->userdata('lob')));
            $data['location'] = $this->common->getWhereInSelectAll('hierarchy','distinct(location)','lob',explode('|||', $this->session->userdata('lob')));
            $data['agent'] = $this->common->getWhereInSelectAll('user',['empid','name'],'sup_id',$this->session->userdata('empid'));
            if(empty($data['overallqadata'])){
                $lobData = [];
                foreach ($lob as $key => $value) {
                    $lobData['lobwise'][] = ['lob'=>$value,'avg_score'=>0];
                }     
                $data['overallqadata'] = $lobData;
            }
            // print_r($data['overallqadata']);die;
            $this->load->view('dashboard_opt',$data);
        }
        else if($this->emp_type == "agent"){
            if($this->emp_group == 'client'){
                $supervisor_id         =   $this->session->userdata('sup_id');
                $getsupervisorDetails  =   $this->common->getWhereSelectAll('user','name',['empid'=>$supervisor_id]);
                $this->db->select('h.campaign, h.vendor,h.location,u.lob_hierarchy_id,u.lob');
                $this->db->from('user u');
                $this->db->join('hierarchy h', 'h.hierarchy_id = u.lob_hierarchy_id');
                $this->db->where('empid',$this->session->userdata('empid'));
                $getAgentDetails =   $this->db->get();
                $ad = $getAgentDetails->result();                
                $till_date["date(submit_time) >="]  = date('Y-m-d',strtotime(date('Y-m-01')));
                $till_date["date(submit_time) <="]  = date('Y-m-d');
                $pre_date["date(submit_time) >="]   = date('Y-m-d', strtotime('-1 month'));
                $pre_date["date(submit_time) <="]   = date('Y-m-d', strtotime('last day of last month'));
                $lob  =  explode('|||', $this->session->userdata('lob'));
                $data =  $this->getagentEvalution($lob,$till_date);
                $data['tilldate']       =   date('Y-m-d',strtotime(date('Y-m-01')))." To ".date('Y-m-d');
                $data['currentLob']     =   $lob[0];
                $data['sup_name']       =   $getsupervisorDetails[0]->name;
                $data['agentlob']       =   implode(',',explode('|||', $ad[0]->lob));
                $data['agentCmp']       =   $ad[0]->campaign;
                $data['agentvendor']    =   $ad[0]->vendor;
                $data['agentlocation']  =   $ad[0]->location;
            }
            else{
                // print_r($this->session->userdata());die;
                $till_date["date(submit_time) >="]  = date('Y-m-d',strtotime(date('Y-m-01')));
                $till_date["date(submit_time) <="]  = date('Y-m-d');
                $lob  =  explode('|||', $this->session->userdata('lob'));
                $empid  = $this->session->userdata('empid');
                $data =  $this->getagentEvalution($lob,$till_date);
                $data['tilldate']       =   date('Y-m-d',strtotime(date('Y-m-01')))." To ".date('Y-m-d');
                $data['currentLob']     =   $lob[0];
                $getsupervisorDetails  =   $this->common->getWhereSelectAll('user','name',['empid'=>$this->session->userdata('sup_id')]);
                // print_r($getsupervisorDetails);die;
                $data['sup_name']       =   $getsupervisorDetails[0]->name;
                $data['agentlob']       =   implode(',',$lob);
                $data['agentCmp']       =   $this->session->userdata('campaign');
                $data['agentvendor']    =   $this->session->userdata('vendor');
                $data['agentlocation']  =   $this->session->userdata('location');
                //print_r($data);die;
            }
            $this->load->view('customer_dashboard',$data);
        }
        else if($this->emp_group == "auditor"){
            $site               =   $this->session->userdata('site');
            $group              =   $this->session->userdata('u_group');
            $start_date         =   date('Y-m-d',strtotime(date('Y-m-01')));
            $end_date           =   date('Y-m-d');
            $site_data          =   $this->common->getFindInSet('sites', ['group_concat(s_name) as sites'],'s_id',"'".$site."'");
            $group_data         =   $this->common->getFindInSet('groups',['group_concat(g_name) as groups'],'g_id',"'".$group."'");
            $data['title']      =   'Dashboard';
            $data['sites']      =   (!empty($site_data)?$site_data[0]['sites']:'');
            $data['groups']     =   (!empty($group_data)?$group_data[0]['groups']:'');
            $data['role']       =   ucfirst($this->emp_group);
            $template_details   =   $this->getTemplateDetails($site,$group);
            $data['form_details']= $template_details;
            if(!empty($template_details))
                $data['head']   =   $this->getAuditorData($template_details,$start_date,$end_date);
            else
                $data['head']   = [];
            // print_r($data);die;
            $this->load->view('other/dashboard/auditor',$data);
        }
        else if($this->emp_group == "reviewer" || $this->emp_group == 'manager'){
            $site               =   $this->session->userdata('site');
            $group              =   $this->session->userdata('u_group');
            $start_date         =   date('Y-m-d',strtotime(date('Y-m-01')));
            $end_date           =   date('Y-m-d');
            $data['title']      =   'Dashboard';
            $data['sites']      =   $this->common->getFindInSet('sites', ['s_name','s_id'],'s_id',"'".$site."'");
            $data['groups']     =   $this->common->getFindInSet('groups',['g_name','g_id'],'g_id',"'".$group."'");
            $template_details   =   $this->getTemplateDetails($site,$group);
            if(!empty($template_details)){
                //print_r($template_details);die;
                $data['templates']  =   $template_details;
                $data['all_audit']  =   $this->getAllAuditCount($template_details,$start_date,$end_date);
                $data['auditor']    =   $this->topAuditorResponse($template_details,$start_date,$end_date);
                $data['head']       =   $this->getCardsData($template_details,$start_date,$end_date);
                $data['actionitems']=   $this->actionItemCharts($template_details,$start_date,$end_date);
                $template_response_details = [];
                $data['response_template'] = [];
                foreach ($template_details as $key => $value) {
                    $data['response_template'] = $value->tb_name;
                    $btableName = str_replace('tb_temp_','',$value->tb_name);
                    // $data['response_template'] = $value->tb_name;
                    //$overall_total_qa_sql ="SELECT t_option_value as opt_text,GROUP_CONCAT(t_att_id) as opt_value FROM template WHERE t_name='$btableName' AND t_option_type = 'select' GROUP BY t_option_value";  
                    $overall_total_qa_sql ="SELECT t_option_value as opt_text,GROUP_CONCAT(t_att_id) as opt_value FROM template WHERE t_unique_id='$btableName' AND t_option_type = 'select' GROUP BY t_option_value";  
                    $overall_query = $this->db->query($overall_total_qa_sql);
                    $template_response_details = $overall_query->result();
                    //echo $this->db->last_query();
                    //$template_response_details = $this->common->getWhereSelectAll('template',['t_option_value as opt_text','t_att_id as opt_value'],['t_name'=>$value->tb_name,'t_option_type' => 'select']);
                    break;
                }
                //print_r($template_response_details);die;
                //$template_response_details = (!empty($template_response_details)?$template_response_details[0]:[]);
                $data['response_option'] = $template_response_details;
                $data['template_response_details'] = (!empty($template_response_details)?$template_response_details[0]:[]);;
                $opt[] = (!empty($data['response_option'])?$data['response_option'][0]:[]);
                $data['breakdown']  =   $this->getBreackdownData($data['response_template'],$opt,$start_date,$end_date);
                // echo "<pre>";
                // print_r($data['response_template']);
                // print_r($opt);
                // die;
                //if($this->emp_group == 'manager'){
                    $data['failed'] = $this->faildAttributeResponse($template_details,$start_date,$end_date);
                //}
                // print_r($template_response_details);die;
                // print_r($data);die;
            }
            // echo "<pre>";print_r($data);die;
            $this->load->view('other/dashboard/reviewer',$data);
        }        
        else{
        	$data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);
        }
    }
    public function getagentEvalution($lob,$till_date){
        $form_name      =   $this->getFormName($lob);
        $agentId        =   $this->session->userdata('empid');
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $diff           =   date_diff(date_create($date_to),date_create($date_form));
        $total_days     =   abs($diff->format("%R%a"));
        $overall_qa_sql =   '';
        $overall_agent_qa_sql = '';
        $lob_implode = "'".implode(',',$lob)."'";
        $result = [];
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $lob_data = "FIND_IN_SET(lob,$lob_implode)";
        foreach ($form_name as $lkey => $lvalue) {
            $overall_qa_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' AND $lob_data UNION ALL ";
            $overall_agent_qa_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' AND $lob_data AND $emp_condition_field ='$agentId'  UNION ALL ";
        }
        $ovelall_words = explode( "UNION ALL", $overall_qa_sql);
        array_splice( $ovelall_words, -1 );
        $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
        if(!empty($overall_qa_total_sql)){
            $overall_total_qa_sql ="SELECT AVG(t.total_score) AS avg_score,sum(t.total_score) AS overall_total_score,count(t.total_score) as count FROM ($overall_qa_total_sql)t";  
            $overall_query = $this->db->query($overall_total_qa_sql);
            $overall_result = $overall_query->result_array();
            $agent_ovelall_words = explode( "UNION ALL", $overall_agent_qa_sql);
            array_splice( $agent_ovelall_words, -1 );
            $agent_overall_qa_total_sql = implode( "UNION ALL", $agent_ovelall_words );
            if(!empty($agent_overall_qa_total_sql)){
                $agent_overall_total_qa_sql ="SELECT avg(t.total_score) AS agent_total_score,count(t.total_score) as count FROM ($agent_overall_qa_total_sql)t";  
                $agent_overall_query = $this->db->query($agent_overall_total_qa_sql);
                $agent_overall_result = $agent_overall_query->result_array();
                if($overall_result[0]['count'] > 0 && $agent_overall_result[0]['agent_total_score'] > 0)
                    $agent_evalution = round($agent_overall_result[0]['agent_total_score'],2);
                else
                    $agent_evalution = 0;        
                $result = [
                    'avg'=>round($overall_result[0]['avg_score'],2),
                    'total_evulation'=>$agent_overall_result[0]['count'],
                    'agent_total_evalution_avg'=>$agent_evalution
                ];
            }


            $day_wise_sql = '';
            foreach ($form_name as $lkey => $lvalue) {
                $day_wise_sql .="SELECT total_score,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $lvalue->form_name WHERE  DATE(submit_time) >= '$date_to' AND DATE(submit_time) <= '$date_form' UNION ALL ";
            }
            $ovelall_words = explode( "UNION ALL", $day_wise_sql);
            array_splice( $ovelall_words, -1 );
            $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
            if(!empty($overall_qa_total_sql)){
                $overall_total_qa_sql ="SELECT t.mtd as year,AVG(t.total_score) AS avg,count(t.total_score) as total_evulation FROM ($overall_qa_total_sql)t GROUP BY mtd ORDER BY STR_TO_DATE(year, '%d-%M-%y') ASC";  
                $overall_query = $this->db->query($overall_total_qa_sql);
                $date_wise_data = $overall_query->result_array();
                $result['day_wise'] = (!empty($date_wise_data)?$date_wise_data:[]);
            }
        }


        // for($i=0;$i<($total_days+1);$i++) {
        //     $sd = date("Y-m-d", strtotime("+$i day", strtotime($date_to)));
        //     $gd = date("d-M", strtotime("+$i day", strtotime($date_to)));
        //     $day_wise_sql = '';
        //     foreach ($form_name as $lkey => $lvalue) {
        //         $day_wise_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) = '".$sd."' UNION ALL ";
        //     }   
        //     $words = explode( "UNION ALL", $day_wise_sql );
        //     array_splice( $words, -1 );
        //     $day_wise_sql = implode( "UNION ALL", $words );
        //     $day_wise_total_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count
        //         FROM ($day_wise_sql)t";  
        //     $day_wise_query = $this->db->query($day_wise_total_sql);
        //     $day_wise_result = $day_wise_query->result_array();
        //     $date_wise_data[] = [
        //         'avg'=>round($day_wise_result[0]['avg_score'],2),
        //         'total_evulation'=>round($day_wise_result[0]['avg_score'],2),
        //         'year'=>$gd
        //     ];
        //     $result['day_wise'] = (!empty($date_wise_data)?$date_wise_data:[]);
        // }
        // print_r($result['day_wise']);die;
        return $result;        
    }
    public function getLatLang($location){
        $getloc = json_decode(file_get_contents("https://api.opencagedata.com/geocode/v1/json?q=$$location&key=a056df4a24f540fbaa53aaa6ab3bf153"));
        return $getloc->results[0]->geometry;
    }
    public function totalOverAllEvulation($frm,$till_date,$pre_date,$filter_sql){
        // print_r($frm);die;
        $overall_qa_sql     =   '';
        $pre_overall_qa_sql =   '';
        $date_to            =   $till_date['date(submit_time) >='];
        $date_form          =   $till_date['date(submit_time) <='];
        $pre_date_to        =   $pre_date['date(submit_time) >='];
        $pre_date_form      =   $pre_date['date(submit_time) <='];
        foreach ($frm as $lkey => $lvalue) {
            $overall_qa_sql .="SELECT total_score,lob FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' $filter_sql  UNION ALL ";
            $pre_overall_qa_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$pre_date_form' $filter_sql  UNION ALL ";
        }
        // die;
        $ovelall_words = explode( "UNION ALL", $overall_qa_sql);
        array_splice( $ovelall_words, -1 );
        $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
        // $overall_total_qa_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($overall_qa_total_sql)t";
        $overall_total_qa_sql ="SELECT lob,round(SUM(t.total_score),2) AS sum_score,round(avg(t.total_score),2) AS avg_score,count(t.total_score) as count FROM ($overall_qa_total_sql)t GROUP BY lob";  
        $overall_query = $this->db->query($overall_total_qa_sql);
        $overall_result = $overall_query->result();
        $result['lobwise'] = $overall_result;
        $total_overall_score = 0;
        $total_evalution_count = 0;
        if(!empty($overall_result)){
            foreach ($overall_result as $key => $value) {
                $total_overall_score    = $total_overall_score + $value->sum_score;
                $total_evalution_count  = $total_evalution_count + $value->count;            
            }
        }
        if($total_evalution_count > 0){
            $result['avg']  =  round((($total_overall_score/$total_evalution_count)),2);
            $result['total_overall_evulation'] = $total_evalution_count;
            // pre overall evalution
                $pre_total_data_sql_words = explode( "UNION ALL", $pre_overall_qa_sql);
                array_splice( $pre_total_data_sql_words, -1 );
                $pre_total_data_sql = implode( "UNION ALL", $pre_total_data_sql_words );
                $pre_sql ="SELECT round(AVG(t.total_score),2) AS avg_score,count(t.total_score) as count FROM ($pre_total_data_sql)t";  
                $query = $this->db->query($pre_sql);
                $pre_result1 = $query->result_array();
                if($pre_result1[0]['count'] > 0){
                    $result['pre_total_overall_evulation'] = (!empty($pre_result1)?$pre_result1[0]['count']:0);            
                    $pre_overallData = ['avg'=>$pre_result1[0]['avg_score']];
                    $last_month_avg = (!empty($result['avg'])?$result['avg']:0) - $pre_overallData['avg'];
                    if($last_month_avg > 0)
                        $result['pre_overall'] = ['pe'=>[abs($last_month_avg)]];
                    else if($last_month_avg < 0)
                        $result['pre_overall'] = ['ne'=>[abs($last_month_avg)]];
                    else
                        $result['pre_overall'] = ['eq'=>[abs($last_month_avg)]];
                }
                else{
                    $result['pre_overall'] = ['eq'=>0];
                }
            // pre overall evalution
        }
        else{
            $result['avg']  =  $total_overall_score;
            $result['total_overall_evulation'] = $total_evalution_count;
            $result['pre_overall'] = ['eq'=>0];
        }
        return $result;
    }
    public function feedbackEscalationFatal($frm,$till_date,$filter_sql){
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $tfef_sql = '';
        foreach ($frm as $lkey => $lvalue) {
            $tfef_sql .="SELECT if(total_score = 0,1,null) as fatel,if(feedback_com != '',feedback_com,null) as feedback,if(esc_phase_id =3,esc_phase_id,null) as esc_phase_id,total_score, unique_id as unique_id,DATE_FORMAT(submit_time, '%d-%M-%y') as mtd FROM  $lvalue->form_name WHERE  DATE(submit_time) >= '$date_to' AND DATE(submit_time) <= '$date_form' $filter_sql UNION ALL ";
        }   
        $words = explode( "UNION ALL", $tfef_sql);
        array_splice( $words, -1 );
        $day_wise_sql = implode( "UNION ALL", $words );
        $day_wise_total_sql ="SELECT t.mtd as day,total_score,round(avg(t.total_score),2) as avg_total_evalution,count(t.unique_id) as total_evulation,count(esc_phase_id) as esc_count,round((count(esc_phase_id)/count(t.unique_id)*100),2) as escavg,round((count(feedback)/count(t.unique_id)*100),2) as feedbackavg,round((count(fatel)/count(t.unique_id)*100),2) as fatelavg FROM($day_wise_sql)t GROUP BY mtd ORDER BY STR_TO_DATE(day, '%d-%M-%y') ASC";  
        $day_wise_query = $this->db->query($day_wise_total_sql);
        $day_wise_result = $day_wise_query->result_array();
        // echo $this->db->last_query();die;
        return (!empty($day_wise_result)?$day_wise_result:[]);
    }

    public function AgentWise($frm,$till_date,$filter_sql){
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $tfef_sql = '';
        foreach ($frm as $lkey => $lvalue) {
            $tfef_sql .="SELECT if(total_score = 0,1,null) as fatal, unique_id as unique_id, evaluator_name, evaluator_id as evalID FROM  $lvalue->form_name WHERE  DATE(submit_time) >= '$date_to' AND DATE(submit_time) <= '$date_form' $filter_sql UNION ALL ";
        }   
        $words = explode( "UNION ALL", $tfef_sql);
        array_splice( $words, -1 );
        $day_wise_sql = implode( "UNION ALL", $words );
        $day_wise_total_sql ="SELECT t.evaluator_name as day,count(t.unique_id) as evalavg ,count(fatal) as fatalavg FROM($day_wise_sql)t GROUP BY evalID ORDER BY STR_TO_DATE(day, '%d-%M-%y') ASC";  
        $day_wise_query = $this->db->query($day_wise_total_sql);
        $day_wise_result = $day_wise_query->result_array();
        // echo $this->db->last_query();die;
        return (!empty($day_wise_result)?$day_wise_result:[]);
    }
    public function sortByOrder($a, $b) {
        return strtotime($a['day']) - strtotime($b['day']);
    }
    public function kpi($frm,$till_date,$filter_sql){
        // $date_to    =   date('Y-m-d',strtotime($till_date['date(submit_time) >=']));
        $date_to  =   date('Y-m-t', strtotime('-3 months', strtotime($till_date['date(submit_time) <='])));
        // $date_form  = date('Y-m-t', strtotime('+2 months', strtotime($till_date['date(submit_time) <='])));
        $date_form  = date('Y-m-t', strtotime($till_date['date(submit_time) <=']));
        $count = 1;
        $monthrange         =   $this->getDateMonthRange($date_to,$date_form);
        $kpi_result_data    =   [];
        $kpiMetricsArr      =   [];
        $kpiMetricsSql      =   [];
        $kpi_result         =   [];
        $sql                =   '';
        $kpiSql             =   '';
        $kpi_forms_name     =   [];
        $data = [];
        $kpiMetricsSql = [];
        $lobData = "'".implode(",", array_column($frm,'lob'))."'";
        $kpi_metrics_sql =" SELECT attr_id,kpi_metrics,form_name FROM forms where FIND_IN_SET(lob,$lobData) and kpi_metrics != ''";  
        $kpi_query = $this->db->query($kpi_metrics_sql);
        $kpi_metrics_res = $kpi_query->result();
        foreach ($monthrange as $key => $value) {
            $month_name = date('MY',strtotime($key));
            $kpiMetricsSql[$month_name]=[];
            $month_start = $value['to'];
            $month_end = $value['form'];
            // Over all Evalution
                $overall_qa_sql = '';
                foreach ($frm as $lkey => $lvalue) {
                    $overall_qa_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$month_start' and DATE(submit_time) <= '$month_end' $filter_sql UNION ALL ";
                }   
                $ovelall_words = explode( "UNION ALL", $overall_qa_sql);
                array_splice( $ovelall_words, -1 );
                $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
                $overall_total_qa_sql ="SELECT count(t.total_score) as count FROM ($overall_qa_total_sql)t";
                $overall_query = $this->db->query($overall_total_qa_sql);
                $overall_result[$month_name] = $overall_query->result_array();
                $evolution[$month_name]= $overall_result[$month_name][0]['count'];
            // End Over all Evalution

            foreach ($kpi_metrics_res as $key => $value) {
                if($value->kpi_metrics != "(NULL)"){
                    $km = explode('|', $value->kpi_metrics);
                    $attrSql = '';
                    foreach ($km as $key1 => $value1) {
                        switch ($value1) {
                            case '1':
                                $kpi = 'CSAT';
                                break;
                            case '2':
                                $kpi = 'Resolution';
                                break;
                            case '3':
                                $kpi = 'Sales';
                                break;                    
                            default:
                                $kpi = 'Retention';
                                break;
                        }
                        if($this->array_key_exists_recursive($kpi, $kpiMetricsSql[$month_name])){
                            $kpiMetricsSql[$month_name][$kpi] = $kpiMetricsSql[$month_name][$kpi]."AND $value->attr_id = 'YES'";
                            $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                            $attr_coloumn[$kpi] = $value->attr_id;
                            $kpi_forms_name[] = $value->form_name;
                        }
                        else{
                            $kpiMetricsArr[$value->attr_id] = $value1;
                            $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                            $attr_coloumn[$kpi] = $value->attr_id;
                            $kpi_forms_name[] = $value->form_name;
                            $kpiMetricsSql[$month_name][$kpi] = "$value->attr_id = 'YES' $filter_sql AND DATE(submit_time) >= '$month_start' and DATE(submit_time) <= '$month_end'";
                        }
                    }
                }
            }
        }

        $form_name = array_unique($kpi_forms_name);
        $count = 0;
        foreach ($kpiMetricsSql as $key2 => $value2) {
            $count++;
            foreach ($value2 as $key3 => $value3) {
                $kpiSql = '';
                foreach ($form_name as $lkey => $lvalue) {
                    $attr = "unique_id";
                    if ($this->db->field_exists($attr_coloumn[$key3], $lvalue)){
                        $kpiSql .="SELECT $attr as total_score FROM  $lvalue WHERE $value3 UNION ALL ";
                    }
                }
                $kpiwords = explode( "UNION ALL", $kpiSql );
                array_splice( $kpiwords, -1 );
                $kpiSql = implode( "UNION ALL", $kpiwords );
                if(!empty($kpiSql)){
                    $kpi_wise_total_sql =" SELECT count(t.total_score) as count FROM ($kpiSql)t";  
                    $kpi_query = $this->db->query($kpi_wise_total_sql);
                    $kpi_res = $kpi_query->result_array();
                    // echo $this->db->last_query()."<br><br><br>";die;
                    if($this->array_key_exists_recursive($key3, $kpi_result)){
                        $kpi_result[$key2][$key3] = $kpi_res[0]['count'];
                    }
                    else{
                        $kpi_result[$key2][$key3] = $kpi_res[0]['count'];
                    }
                }
                $month = date('M`y',strtotime($key2));
                if($evolution[$key2] > 0 && $kpi_result[$key2] > 0){                    
                    $kpi_result_data[$key3][] = ['month'=>$month,'avg'=>round((($kpi_result[$key2][$key3]/$evolution[$key2])*100),2)];
                }
                else
                    $kpi_result_data[$key3][] = ['month'=>$month,'avg'=>0];
            }
        }
        // print_r($kpi_result_data);die;
        foreach ($kpi_result_data as $key22 => $value22) {           
            $data['kpi'][$key22] = ['month'=>$value22[$count-1]['month'],'avg'=>$value22[$count-1]['avg']];
        }
        
        $callback = function(&$array) { array_pop($array); };
        array_walk($kpi_result_data, $callback);
        $data['year_kpi'] = $kpi_result_data;
        // print_r($data);die;
        return $data;
    }
    public function arrtibuteData($emp_condition_field,$frm,$till_date,$filter_sql){
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        // $filter_sql =  substr(strstr($filter_sql," "), 1);
        if(!empty($filter_sql))
            $where[$filter_sql] = null;
        $data = [];
        $dataFatal = [];
        $formname = $frm[0]->form_name;
        
        $attribute = $this->common->getDistinctWhere('forms',['attribute','attr_id','weightage'],['lob'=>$frm[0]->lob, 'scorable'=>'yes','form_name'=>$formname]);
        $overall_qa_sql = 'SELECT count(unique_id) as total_evulation, ';
        $count = 0;
        $attr_arr=[];
        foreach ($attribute as $key => $value) {
            $attr = explode("_", $value->attr_id);
            $attr_scote = $attr[0]."_score";
            $attr_arr[$attr[0]] =['arrt_name'=>$value->attribute,'weightage'=>$value->weightage,$attr[0]=>$value->attr_id];
            $count++;
            $overall_qa_sql .=" COUNT(case when ('NA' = '.$value->attr_id.' ) then 1 else null end) as na_$attr[0],
                                COUNT(case when ('YES' = '.$value->attr_id.' ) then 1 else null end) as yes_$attr[0],
                                COUNT(case when ('FATAL' = '.$value->attr_id.' ) then 1 else null end) as fatal_$attr[0],
                                SUM(CASE WHEN $value->attr_id = 'YES' THEN $attr_scote ELSE 0 END) AS sum_yes_$attr[0],
                                SUM(CASE WHEN $value->attr_id = 'NA'  THEN $attr_scote ELSE 0 END) AS sum_na_$attr[0],
                                SUM(CASE WHEN $value->attr_id = 'FATAL'  THEN 1 ELSE 0 END) AS sum_fatal_$attr[0],
                                ";
        }
        $overall_qa_sql = substr(trim($overall_qa_sql), 0, -1);
        $overall_qa_sql .= " FROM  $formname WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' $filter_sql";

        //echo($overall_qa_sql);


        $overall_query = $this->db->query($overall_qa_sql);
        $overall_result = $overall_query->result();
        //  echo '<pre>';
        // print_r($overall_result);

        $total_evulation    = $overall_result[0]->total_evulation;
        foreach ($attr_arr as $attr_key => $attr_value) {
            // print_r($attr_value);die;
            $na     = "na_".$attr_key;
            $yes    = "yes_".$attr_key;
            $fatal    = "fatal_".$attr_key;
            $sumna  = "sum_na_".$attr_key;
            $sumyes = "sum_yes_".$attr_key;
            $sumfatal = "sum_fatal_".$attr_key;

            $attr_arr[$attr_key][$na]= $overall_result[0]->$na;
            $attr_arr[$attr_key][$yes]= $overall_result[0]->$yes;
            $attr_arr[$attr_key][$yes]= $overall_result[0]->$fatal;
            $attr_arr[$attr_key][$sumna]= $overall_result[0]->$sumna;
            $attr_arr[$attr_key][$sumyes]= $overall_result[0]->$sumyes;
            $attr_arr[$attr_key][$sumfatal]= $overall_result[0]->$sumfatal;
            

            $total_na           = (int)$attr_arr[$attr_key][$sumna];//0
            $total_yes          = (int)$attr_arr[$attr_key][$sumyes];//2
            $total_fatal          = (int)$attr_arr[$attr_key][$sumfatal];//2
            $attr_weightage     = (int)$attr_value['weightage'];//2


            // echo $total_yes . '  '.$attr_key;

            // echo '<br><br>';

            ///candition for overall attribute scores 
            if($total_evulation > 0){
                if((($total_evulation * $attr_weightage)-$total_na ) > 0)
                    $final_score    = ((($total_yes - $total_na))/(($total_evulation *$attr_weightage)-$total_na )*100);
                else
                    $final_score = 0;
            }
            else
                $final_score  = 0;
            $data[] = ['avg' => sprintf('%0.2f',$final_score),'name' => str_replace("'", "'", $attr_value['arrt_name']),'full'=>100];
            // $data[] = ['avg' => round($final_score,2),'name' => str_replace("'", "'", $value->attribute),'full'=>100];

            if($total_evulation > 0){
                if($total_fatal > 0)
                    $final_fatal    = (($total_fatal / $total_evulation)*100);
                else
                    $final_fatal = 0;
            }
            else
                $final_fatal  = 0;
             if($total_fatal > 0)  {
                $dataFatal[] = ['avg' => sprintf('%0.2f',$final_fatal),'name' => str_replace("'", "'", $attr_value['arrt_name']),'full'=>100];
             } 
            
            
        }
       
        //$result['lobwise'] = $overall_result;
        $col  = 'avg';
        $sort1 = array();
        foreach($data as $j => $obj1 ){
            $sort1[$j] =  $obj1[$col];
        }
        array_multisort($sort1, SORT_DESC, $data);
        $data1['attribute']=$data;
        //set attribute fatal data  for fatal charts 
        $sort1 = array();
        foreach($dataFatal as $j => $obj1 ){
            $sort1[$j] =  $obj1[$col];
        }
        array_multisort($sort1, SORT_ASC , $dataFatal);
        $data1['attributeFatal']=$dataFatal;
       ///end fatal data 
     
        $sort = array();
        foreach ($data as $i => $obj) {
            $sort[$i] = $obj[$col];
        }
        array_multisort($sort, SORT_DESC, $data);
        $data1['top'] = array_slice($data, 0, 10, true);
        array_multisort($sort, SORT_ASC, $data);
        $data1['bottom'] = array_slice($data, 0, 10, true);
        return $data1;
    }
    public function categoryData($emp_condition_field,$frm,$till_date,$filter_sql){
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        // echo $filter_sql =  substr(strstr($filter_sql," "), 1);die;
        //$getFormName = $this->getFormName($lob);
        $data=[];
        if(!empty($frm)){
            $formname = $frm[0]->form_name;
            $attribute = $this->common->getDistinctWhere('forms',['GROUP_CONCAT(distinct(category)) as cat_name ','GROUP_CONCAT(distinct(cat_id)) as cat_id'],['lob'=>$frm[0]->lob,'form_name'=>$formname]);
            // print_r($attribute);die;
            if(!empty($attribute)){
                $cat = "avg(" .implode ( "), avg(", explode(',', $attribute[0]->cat_id) ). ")";
                $overall_qa_sql ="SELECT $cat FROM  $formname WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' $filter_sql";
                $overall_query = $this->db->query($overall_qa_sql);
                $overall_result = $overall_query->result_array();
                // print_r($overall_result);die;
                foreach (explode(',',$attribute[0]->cat_name) as $key => $value) {
                    //if(!empty(($overall_result[0][$key])))
                        $data[] = ['avg' => sprintf('%0.2f',array_values($overall_result[0])[$key]),'name' => $value,'full'=>100];
                }
            }
            else{
                $data=['avg' => 0,'name' =>'','full'=>100];
            }
        }
        else{
            $data=['avg' => 0,'name' =>'','full'=>100];
        }

        $col  = 'avg';
        $sort1 = array();
        foreach($data as $j => $obj1 ){
            $sort1[$j] =  $obj1[$col];
        }
        // sorting array in desending order
        array_multisort($sort1, SORT_DESC, $data);

        return $data;
        //print_r($attr);
    }
    public function escalationRate($frm,$till_date,$pre_date,$filter_sql,$total_overall_evulation){
        $date_wise_data = [];
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $pre_date_to    =   $pre_date['date(submit_time) >='];
        $pre_date_form  =   $pre_date['date(submit_time) <='];
        $esc_day_wise_result    = [];
        $fatel_wise_result      = [];
        $feedback_wise_result   = [];
        $escSql = '';
        $fatelSql = '';
        $feedbackSql = '';
        $total_eva_sql = '';
        $preescSql = '';
        foreach ($frm as $lkey => $lvalue) {
            $escSql .="SELECT total_score FROM  $lvalue->form_name WHERE esc_phase_id = 3 AND DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' $filter_sql UNION ALL ";
            $preescSql .="SELECT total_score FROM  $lvalue->form_name WHERE esc_phase_id = 3 AND DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$pre_date_form' $filter_sql UNION ALL ";
        }            
        $esc_words      = explode( "UNION ALL", $escSql);
        array_splice( $esc_words, -1 );
        $esc_day_wise_sql       = implode( "UNION ALL", $esc_words );
        $esc_total_sql          = "SELECT AVG(t.total_score) AS esc_avg_score,count(t.total_score) as esc_count FROM ($esc_day_wise_sql)t";
        $esc_day_wise_query     = $this->db->query($esc_total_sql);
        $esc_day_wise_result    = $esc_day_wise_query->result_array();

        $date_wise_data = [
            'escavg'=>(!empty($esc_day_wise_result[0]['esc_count'])?round((($esc_day_wise_result[0]['esc_count']/$total_overall_evulation)*100),2):0),
        ];

        $pre_esc_words      = explode( "UNION ALL", $preescSql);
        array_splice( $pre_esc_words, -1 );
        $pre_esc_day_wise_sql       = implode( "UNION ALL", $pre_esc_words );
        $pre_esc_total_sql          = "SELECT AVG(t.total_score) AS esc_avg_score,count(t.total_score) as esc_count FROM ($pre_esc_day_wise_sql)t";
        $pre_esc_day_wise_query     = $this->db->query($pre_esc_total_sql);
        $pre_esc_day_wise_result    = $pre_esc_day_wise_query->result_array();
        //print_r($pre_esc_day_wise_result);die;
        if($esc_day_wise_result[0]['esc_count'] > 0){
            $pre_pass_rate_data = [
                'avg'=>round((($pre_esc_day_wise_result[0]['esc_count']/$esc_day_wise_result[0]['esc_count'])*100),2)
            ];
            $last_month_avg = (!empty($date_wise_data['escavg'])?$date_wise_data['escavg']:0) - $pre_pass_rate_data['avg'];
            if($last_month_avg > 0)
                $result['pre_esc_rate'] = ['pe'=>[abs($last_month_avg)]];
            else if($last_month_avg < 0)
                $result['pre_esc_rate'] = ['ne'=>[abs($last_month_avg)]];
            else
                $result['pre_esc_rate'] = ['eq'=>[abs($last_month_avg)]];
        }
        else{
            $result['pre_esc_rate'] = ['eq'=>0];
        }
        $result['esc_rate_count'] = (!empty($date_wise_data)?$date_wise_data:[]);
        return $result;
    }
    public function autoFail($frm,$till_date,$pre_date,$filter_sql,$total_overall_evulation){
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $pre_date_to    =   $pre_date['date(submit_time) >='];
        $pre_date_form  =   $pre_date['date(submit_time) <='];
        // Fatal data 
        $fatal_sql = '';
        $pre_fatal_sql = '';
        foreach ($frm as $lkey => $lvalue) {
            $fatal_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' AND total_score = 0 $filter_sql UNION ALL ";
            $pre_fatal_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$ pre_date_form' AND total_score = 0 $filter_sql UNION ALL ";
        }   
        $fatal_sql_words = explode( "UNION ALL", $fatal_sql);
        array_splice( $fatal_sql_words, -1 );
        $fatal_sql = implode( "UNION ALL", $fatal_sql_words );
        $sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($fatal_sql)t";  
        $query = $this->db->query($sql);
        $result1 = $query->result_array();
        if($result1[0]['count'] > 0)
            $pass_rate = ['avg'=>round((($result1[0]['count']/$total_overall_evulation)*100),2),'total_evulation'=>$result1[0]['count']];
        else
            $pass_rate = ['avg'=>0,'total_evulation'=>$result1[0]['count']];
        $result['fatal'] = (!empty($pass_rate)?$pass_rate:0);
        // End Fatal data

        // Pre Fatel 
        $pre_fatal_sql_words = explode( "UNION ALL", $pre_fatal_sql);
        array_splice( $pre_fatal_sql_words, -1 );
        $pre_total_data_sql = implode( "UNION ALL", $pre_fatal_sql_words );
        $pre_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($pre_total_data_sql)t";  
        $query = $this->db->query($pre_sql);
        $pre_result1 = $query->result_array();
        if($pre_result1[0]['count'] > 0)
            $pre_pass_rate = ['avg'=>round((($pre_result1[0]['count']/$result['pre_total_overall_evulation'])*100),2),'total_evulation'=>$pre_result1[0]['count']];
        else
            $pre_pass_rate = ['avg'=>0,'total_evulation'=>$pre_result1[0]['count']];
        $pre_pass_rate_last_month_avg = ($result['fatal']['avg'] - $pre_pass_rate['avg']);
        if($pre_pass_rate_last_month_avg > 0)
            $result['pre_fatal'] = ['pe'=>[abs($pre_pass_rate_last_month_avg)]];
        else if($pre_pass_rate_last_month_avg < 0)
            $result['pre_fatal'] = ['ne'=>[abs($pre_pass_rate_last_month_avg)]];
        else
            $result['pre_fatal'] = ['eq'=>[abs($pre_pass_rate_last_month_avg)]];
        // End Pre Fatel
        return $result;
    }
    public function passRate($frm,$till_date,$pre_date,$filter_sql,$total_overall_evulation){
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $pre_date_to    =   $pre_date['date(submit_time) >='];
        $pre_date_form  =   $pre_date['date(submit_time) <='];
        // pass rate
        $pass_rate_sql = '';
        $pre_pass_rate_sql = '';
        foreach ($frm as $lkey => $lvalue) {
            $pass_rate_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' AND total_score > $lvalue->pass_rate $filter_sql  UNION ALL ";
            $pre_pass_rate_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$pre_date_form' AND total_score > $lvalue->pass_rate $filter_sql  UNION ALL ";
        }   
        $pass_rate_sql_words = explode( "UNION ALL", $pass_rate_sql);
        array_splice( $pass_rate_sql_words, -1 );
        $pass_rate_sql = implode( "UNION ALL", $pass_rate_sql_words );
        $sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count
                FROM ($pass_rate_sql)t";
        $query = $this->db->query($sql);
        $result1 = $query->result_array();
        if($result1[0]['count'] > 0){
            $pass_rate = ['avg'=>round(((round($result1[0]['count'],2)/$total_overall_evulation)*100),2),'total_evulation'=>$result1[0]['count']];
            $result['pass_rate'] = (!empty($pass_rate)?$pass_rate:0);
        }
        else{
            $result['pass_rate'] = [];
        }
        // End pass rate

        // pre pass rate 
        $pre_pass_rate_sql_words = explode( "UNION ALL", $pre_pass_rate_sql);
        array_splice( $pre_pass_rate_sql_words, -1 );
        $pre_total_data_sql = implode( "UNION ALL", $pre_pass_rate_sql_words );
        $pre_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($pre_total_data_sql)t"; 
        $query = $this->db->query($pre_sql);
        $pre_result1 = $query->result_array();
        if($pre_result1[0]['count'] > 0 && $result1[0]['count'] > 0){
            $pre_pass_rate_data = [
                'avg'=>round((($pre_result1[0]['count']/$result1[0]['count'])*100),2)
            ];
            $last_month_avg = (!empty($pass_rate['avg'])?$pass_rate['avg']:0) - $pre_pass_rate_data['avg'];
            if($last_month_avg > 0)
                $result['pre_pass_rate'] = ['pe'=>[abs($last_month_avg)]];
            else if($last_month_avg < 0)
                $result['pre_pass_rate'] = ['ne'=>[abs($last_month_avg)]];
            else
                $result['pre_pass_rate'] = ['eq'=>[abs($last_month_avg)]];
        }
        else{
            $result['pre_pass_rate'] = ['eq'=>0];
        }
        // End Pre pass rate
        return $result;
    }
    public function getOverAllQAScore($lob,$till_date,$pre_date,$filter_sql){
        $lob = ((gettype($lob) == "string")?(array)$lob:$lob);
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $pre_date_to    =   $pre_date['date(submit_time) >='];
        $pre_date_form  =   $pre_date['date(submit_time) <='];
        $diff           =   date_diff(date_create($date_to),date_create($date_form));
        $total_days     =   abs($diff->format("%R%a"));     
        $form_name      =   $this->getFormName($lob);
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $result         =   [];
        $overallData    =   [];
        if(!empty($form_name)){
            // Day wise data
                // for($i=1;$i<=($total_days+1);$i++) {
                //     $day_wise_sql = '';
                //     foreach ($form_name as $lkey => $lvalue) {
                //         $day_wise_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) = '".date("Y-m-$i")."' UNION ALL ";
                //     }   
                //     $words = explode( "UNION ALL", $day_wise_sql );
                //     array_splice( $words, -1 );
                //     $day_wise_sql = implode( "UNION ALL", $words );
                //     $day_wise_total_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count
                //         FROM ($day_wise_sql)t";  
                //     $day_wise_query = $this->db->query($day_wise_total_sql);
                //     $day_wise_result = $day_wise_query->result_array();
                //     $date_wise_data[] = [
                //         'avg'=>round($day_wise_result[0]['avg_score'],2),
                //         'total_evulation'=>$day_wise_result[0]['count'],
                //         'year'=>date("{$i}/M")
                //     ];
                //     $result['day_wise'] = (!empty($date_wise_data)?$date_wise_data:[]);
                // }
            // End Day wise data
            
            // Overall QA DATA 
                $overall_qa_sql = '';
                $lob_implode = "'".implode(',',$lob)."'";
                foreach ($form_name as $lkey => $lvalue) {
                    $overall_qa_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' $filter_sql  UNION ALL ";
                }   
                $ovelall_words = explode( "UNION ALL", $overall_qa_sql);
                array_splice( $ovelall_words, -1 );
                $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
                $overall_total_qa_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($overall_qa_total_sql)t";  
                $overall_query = $this->db->query($overall_total_qa_sql);
                $overall_result = $overall_query->result_array();
                // echo $this->db->last_query();die;
                if(($overall_result[0]['count']) > 0){
                    $overallData   = ['avg'=>round($overall_result[0]['avg_score'],2),'total_evulation'=>(100-round($overall_result[0]['avg_score'],2))];
                    $overallData1  = [
                                        [
                                            'avg'=>round($overall_result[0]['avg_score'],2),
                                            'name'=>'Avg'
                                        ],
                                        [
                                            'avg'=>(100-round($overall_result[0]['avg_score'],2)),
                                            'name'=>"Total Evaluation"
                                        ],
                                    ];                    
                    $result['overall_qa'] = (!empty($overallData1)?$overallData1:[]);
                    $result['total_overall_evulation'] = (!empty($overallData)?$overall_result[0]['count']:0);
                }
                else{
                    $result['overall_qa'] = [];
                    $result['total_overall_evulation'] = (!empty($overallData)?$overall_result[0]['count']:0);
                }
            // End Overall QA DATA
            $result['overallqalobwise'] = $this->overallQALobWise($lob,$till_date,$filter_sql);
            $result['attribute'] = $this->getAttribute($lob[0],$till_date,$filter_sql);
            $result['category'] = $this->getCategoryData($lob[0],$till_date,$filter_sql);
            // $this->printData($result['category']);die;
            // Pre date Overall QA DATA
                $pre_overall_qa_sql = '';
                foreach ($form_name as $lkey => $lvalue) {
                    $pre_overall_qa_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$pre_date_form' $filter_sql  UNION ALL ";
                }
                $pre_total_data_sql_words = explode( "UNION ALL", $pre_overall_qa_sql);
                array_splice( $pre_total_data_sql_words, -1 );
                $pre_total_data_sql = implode( "UNION ALL", $pre_total_data_sql_words );
                $pre_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($pre_total_data_sql)t";  
                $query = $this->db->query($pre_sql);
                $pre_result1 = $query->result_array();
                if($pre_result1[0]['count'] > 0){
                    $result['pre_total_overall_evulation'] = (!empty($pre_result1)?$pre_result1[0]['count']:[]);
                    $pre_overallData = ['avg'=>round($pre_result1[0]['avg_score'],2),'total_evulation'=>(100-round($pre_result1[0]['avg_score'],2))];
                    $last_month_avg = (!empty($overallData['avg'])?$overallData['avg']:0) - $pre_overallData['avg'];
                    if($last_month_avg > 0)
                        $result['pre_overall'] = ['pe'=>[abs($last_month_avg)]];
                    else if($last_month_avg < 0)
                        $result['pre_overall'] = ['ne'=>[abs($last_month_avg)]];
                    else
                        $result['pre_overall'] = ['eq'=>[abs($last_month_avg)]];
                }
                else{
                    $result['pre_overall'] = ['eq'=>0];   
                }
            // End Pre date Overall QA DATA
            
            // pass rate
                $pass_rate_sql = '';
                foreach ($form_name as $lkey => $lvalue) {
                    $pass_rate_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' AND total_score > $lvalue->pass_rate $filter_sql  UNION ALL ";
                }   
                $pass_rate_sql_words = explode( "UNION ALL", $pass_rate_sql);
                array_splice( $pass_rate_sql_words, -1 );
                $pass_rate_sql = implode( "UNION ALL", $pass_rate_sql_words );
                $sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count
                        FROM ($pass_rate_sql)t";
                $query = $this->db->query($sql);
                $result1 = $query->result_array();
                if($result1[0]['count'] > 0){
                    $pass_rate = ['avg'=>round(((round($result1[0]['count'],2)/$result['total_overall_evulation'])*100),2),'total_evulation'=>$result1[0]['count']];
                    $result['pass_rate'] = (!empty($pass_rate)?$pass_rate:0);
                }
                else{
                    $result['pass_rate'] = [];
                }
            // End pass rate

            // pre pass rate 
                $pre_pass_rate_sql = '';
                foreach ($form_name as $lkey => $lvalue) {
                    $pre_pass_rate_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$pre_date_form' AND total_score > $lvalue->pass_rate $filter_sql  UNION ALL ";
                }
                $pre_pass_rate_sql_words = explode( "UNION ALL", $pre_pass_rate_sql);
                array_splice( $pre_pass_rate_sql_words, -1 );
                $pre_total_data_sql = implode( "UNION ALL", $pre_pass_rate_sql_words );
                $pre_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($pre_total_data_sql)t"; 
                $query = $this->db->query($pre_sql);
                $pre_result1 = $query->result_array();
                if($pre_result1[0]['count'] > 0){
                    $pre_pass_rate_data = [
                        'avg'=>round((($pre_result1[0]['count']/$result['pre_total_overall_evulation'])*100),2)
                    ];
                    $last_month_avg = (!empty($pass_rate['avg'])?$pass_rate['avg']:0) - $pre_pass_rate_data['avg'];
                    if($last_month_avg > 0)
                        $result['pre_pass_rate'] = ['pe'=>[abs($last_month_avg)]];
                    else if($last_month_avg < 0)
                        $result['pre_pass_rate'] = ['ne'=>[abs($last_month_avg)]];
                    else
                        $result['pre_pass_rate'] = ['eq'=>[abs($last_month_avg)]];
                }
                else{
                    $result['pre_pass_rate'] = ['eq'=>0];
                }
            // End Pre pass rate

            // Fatal data 
                $fatal_sql = '';
                foreach ($form_name as $lkey => $lvalue) {
                    $fatal_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' AND total_score = 0 $filter_sql UNION ALL ";
                }   
                $fatal_sql_words = explode( "UNION ALL", $fatal_sql);

                array_splice( $fatal_sql_words, -1 );

                $fatal_sql = implode( "UNION ALL", $fatal_sql_words );
                $sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count
                        FROM ($fatal_sql)t";  
                $query = $this->db->query($sql);
                $result1 = $query->result_array();
                if($result1[0]['count'] > 0)
                    $pass_rate = ['avg'=>round((($result1[0]['count']/$result['total_overall_evulation'])*100),2),'total_evulation'=>$result1[0]['count']];
                else
                    $pass_rate = ['avg'=>0,'total_evulation'=>$result1[0]['count']];
                $result['fatal'] = (!empty($pass_rate)?$pass_rate:0);
            // End Fatal data

            // Pre Fatel 
                $pre_fatal_sql = '';
                foreach ($form_name as $lkey => $lvalue) {
                    $pre_fatal_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$pre_date_form' AND total_score = 0 $filter_sql UNION ALL ";
                }
                $pre_fatal_sql_words = explode( "UNION ALL", $pre_fatal_sql);
                array_splice( $pre_fatal_sql_words, -1 );
                $pre_total_data_sql = implode( "UNION ALL", $pre_fatal_sql_words );
                $pre_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($pre_total_data_sql)t";  
                $query = $this->db->query($pre_sql);
                $pre_result1 = $query->result_array();
                if($pre_result1[0]['count'] > 0)
                    $pre_pass_rate = ['avg'=>round((($pre_result1[0]['count']/$result['pre_total_overall_evulation'])*100),2),'total_evulation'=>$pre_result1[0]['count']];
                else
                    $pre_pass_rate = ['avg'=>0,'total_evulation'=>$pre_result1[0]['count']];
                $pre_pass_rate_last_month_avg = ($result['fatal']['avg'] - $pre_pass_rate['avg']);
                if($pre_pass_rate_last_month_avg > 0)
                    $result['pre_fatal'] = ['pe'=>[abs($pre_pass_rate_last_month_avg)]];
                else if($pre_pass_rate_last_month_avg < 0)
                    $result['pre_fatal'] = ['ne'=>[abs($pre_pass_rate_last_month_avg)]];
                else
                    $result['pre_fatal'] = ['eq'=>[abs($pre_pass_rate_last_month_avg)]];
            // End Pre Fatel

            // Attribute Rank
                $rank = $this->getArrtibuteRank($emp_condition_field,$till_date,$lob[0],$filter_sql);
                if(!empty($rank))
                    $result['rank'] = $rank;
                else
                    $result['rank']= [];
            // End Attribute Rank
                // echo $result['total_overall_evulation'];die;
            $result['kpi'] = $this->kpiMetrics($result['total_overall_evulation'],$lob,$till_date,$filter_sql);
            $result['fef'] = $this->fatalEscFeedback($result['total_overall_evulation'],$lob,$till_date,$filter_sql);
            $result['EscRate'] = $this->EscRate($result['total_overall_evulation'],$lob,$till_date,$pre_date);
            $result['kpiYear'] = $this->kpiMetricsYear($lob,$till_date,$filter_sql);
            //$result['awte'] = $this->agentWiseEvaloution($lob,$form_name,$emp_condition_field,$till_date);
        }
        else{
            $result['day_wise']         = [];
            $result['overall_qa']       = [];
            $result['pre_overall']      = [];
            $result['pre_pass_rate']    = ['eq'=>0];
            $result['fatal']            = ['eq'=>0];
            $result['pre_fatal']        = ['eq'=>0];
            $result['fef']              = [];
            $result['kpi']              = [];
        }
        // echo "<pre>";
        // $this->printData($result);die;
        return $result;
    }
    public function overallQALobWise($lob,$till_date,$filter_sql){
        $filter_sql =  substr(strstr($filter_sql," "), 1);
        $lob = ((gettype($lob) == "string")?(array)$lob:$lob);
        $res = [];
        foreach ($lob as $key => $value) {
            $fn = $this->common->getWhereSelectAll('forms_details',['distinct(form_name)'],['lob'=>$value]);
            if(!empty($fn)){
                foreach ($fn as $key1 => $value1) {
                    $till_date['lob'] = $value;
                    $till_date[$filter_sql] = null;
                    $f_data = $this->common->getWhereSelectAll($value1,['avg(total_score) as count'],$till_date);
                    // print_r($f_data);
                    // echo $this->db->last_query();die;
                    $res[] = ['lob'=>$value,'avg'=>(!empty($f_data[0]->count)?$f_data[0]->count:0)];
                }
            }
            else{
                $res[] = ['lob'=>$value,'avg'=>0];
            }
            
        }
        return $res;
    }
    public function getAttribute($lob,$till_date,$filter_sql){
        $filter_sql =  substr(strstr($filter_sql," "), 1);
        $res = [];
        $attr_form_name =   '';
        $attr = [];
        $getFormName = $this->getFormName($lob);
        if(!empty($getFormName)){
            $formname = $getFormName[0]->form_name;
            $attribute = $this->common->getDistinctWhere('forms',['attribute','attr_id','weightage'],['lob'=>$lob,'form_name'=>$formname]);
            foreach ($attribute as $key => $value) {
                $attr = explode("_", $value->attr_id);
                $attr_scote = $attr[0]."_score";
                $till_date[$filter_sql] = null;
                $attr[$value->attr_id] = $this->common->getWhereSelectAll($formname,[
                    'count(unique_id) as total_evulation',
                    'count(case when (\'NA\' = '.$value->attr_id.' ) then 1 else null end) as na',
                    'count(case when (\'YES\' = '.$value->attr_id.' ) then 1 else null end) as yes',
                    'SUM(CASE 
                        WHEN '.$value->attr_id.' = "YES" 
                        THEN '.$attr_scote.' 
                        ELSE 0 
                    END) AS sum_yes',
                    'SUM(CASE 
                        WHEN '.$value->attr_id.' = "NA" 
                        THEN '.$attr_scote.' 
                        ELSE 0 
                    END) AS sum_na'
                ],$till_date);
                $total_evulation    = (int)$attr[$value->attr_id][0]->total_evulation;//1
                $total_na           = (int)$attr[$value->attr_id][0]->sum_na;//0
                $total_yes          = (int)$attr[$value->attr_id][0]->sum_yes;//2
                $attr_weightage     = (int)$value->weightage;//2
                if($total_evulation > 0){
                    if((($total_evulation *$attr_weightage)-$total_na ) > 0)
                        $final_score    = ((($total_yes - $total_na))/(($total_evulation *$attr_weightage)-$total_na )*100);
                    else
                        $final_score = 0;
                }
                else
                    $final_score  = 0;
                $data[] = ['avg' => sprintf('%0.2f',$final_score),'name' => str_replace("'", "'", $value->attribute),'full'=>100];
            }
        }
        else{
            $data = ['avg' => 0,'name' => '','full'=>100];
        }
        return $data;
    }
    public function getCategoryData($lob,$till_date,$filter_sql){
        $filter_sql =  substr(strstr($filter_sql," "), 1);
        $getFormName = $this->getFormName($lob);
        if(!empty($getFormName)){
            $formname = $getFormName[0]->form_name;
            $attribute = $this->common->getDistinctWhere('forms',['category','cat_id'],['lob'=>$lob,'form_name'=>$formname]);
            foreach ($attribute as $key => $value) {
                $till_date[$filter_sql] = null;
                $attr[$value->category] = $this->common->getWhereSelectAll($formname,['avg('.$value->cat_id.')as avg'],$till_date);
                // echo $this->db->last_query();die;
                $final_score = ((!empty($attr[$value->category][0]->avg))?$attr[$value->category][0]->avg:0);
                $data[] = ['avg' => sprintf('%0.2f',$final_score),'name' => $value->category,'full'=>100];
            }
        }
        else{
            $data=['avg' => 0,'name' =>'','full'=>100];
        }
        return $data;
    }
    public function kpiMetrics($total_overall_evulation,$lob,$till_date,$filter_sql){
        $date_to            =   $till_date['date(submit_time) >='];
        $date_form          =   $till_date['date(submit_time) <='];
        $kpi_result_data    =   [];
        $kpiMetricsArr      =   [];
        $kpiMetricsSql      =   [];
        $kpi_result         =   [];
        $sql                =   '';
        $kpiSql             =   '';
        $kpi_forms_name     =   [];
        //$where['kpi_metrics !='] = null; 
        //$where["FIND_IN_SET(lob,"."'".implode(',',$lob)."'".") != "] = null; 
        // $kpi_metrics = $this->common->getWhereSelectAll('forms',['attr_id','kpi_metrics','form_name'],['kpi_metrics is NOT NULL'=>NULL,false]);
        $lobData = "'".implode(",", $lob)."'";
        $kpi_metrics_sql =" SELECT attr_id,kpi_metrics,form_name FROM forms where FIND_IN_SET(lob,$lobData) and kpi_metrics != ''";  
        $kpi_query = $this->db->query($kpi_metrics_sql);
        $kpi_metrics_res = $kpi_query->result();
        // print_r($kpi_metrics_res);die;
        // $form_name      =   $this->getFormName($lob);
        foreach ($kpi_metrics_res as $key => $value) {
            if($value->kpi_metrics != "(NULL)"){
                $km = explode('|', $value->kpi_metrics);
                $attrSql = '';
                foreach ($km as $key1 => $value1) {
                    switch ($value1) {
                        case '1':
                            $kpi = 'CSAT';
                            break;
                        case '2':
                            $kpi = 'Resolution';
                            break;
                        case '3':
                            $kpi = 'Sales';
                            break;                    
                        default:
                            $kpi = 'Retention';
                            break;
                    }
                    if($this->array_key_exists_recursive($kpi, $kpiMetricsSql)){
                        $kpiMetricsSql[$kpi] = $kpiMetricsSql[$kpi]."AND $value->attr_id = 'YES'";
                        $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                        $attr_coloumn[$kpi] = $value->attr_id;
                        $kpi_forms_name[] = $value->form_name;
                    }
                    else{
                        $kpiMetricsArr[$value->attr_id] = $value1;
                        $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                        $attr_coloumn[$kpi] = $value->attr_id;
                        $kpi_forms_name[] = $value->form_name;
                        $kpiMetricsSql[$kpi] = "$value->attr_id = 'YES' $filter_sql AND DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form'";
                    }
                }
            }
        }
        $form_name = array_unique($kpi_forms_name);
        foreach ($form_name as $lkey => $lvalue) {
            if ($this->db->field_exists($value->attr_id, $lvalue)){
                $attrSql .="SELECT $value->attr_id as total_count FROM  $lvalue WHERE $value->attr_id = 'YES' UNION ALL ";
            }
        }
        if(!empty($attrSql)){
            $kpiwords = explode( "UNION ALL", $attrSql );
            array_splice( $kpiwords, -1 );
            $kpiSql = implode( "UNION ALL", $kpiwords );
            if(!empty($kpiSql)){
                $kpi_wise_total_sql =" SELECT count(t.total_count) as count FROM ($kpiSql)t";  
                $kpi_query = $this->db->query($kpi_wise_total_sql);
                $kpi_res = $kpi_query->result_array();
            }
        }
        
        foreach ($kpiMetricsSql as $key2 => $value2) {
            $kpiSql = '';
            foreach ($form_name as $lkey => $lvalue) {
                $attr = "unique_id";//$attr_score[$key2];
                if ($this->db->field_exists($attr_coloumn[$key2], $lvalue)){
                    $kpiSql .="SELECT $attr as total_score FROM  $lvalue WHERE $value2 UNION ALL ";
                }
            }
            $kpiwords = explode( "UNION ALL", $kpiSql );
            array_splice( $kpiwords, -1 );
            $kpiSql = implode( "UNION ALL", $kpiwords );
            if(!empty($kpiSql)){
                $kpi_wise_total_sql =" SELECT count(t.total_score) as count FROM ($kpiSql)t";  
                $kpi_query = $this->db->query($kpi_wise_total_sql);
                $kpi_res = $kpi_query->result_array();
                if($this->array_key_exists_recursive($key2, $kpi_result)){
                    $kpi_result[$key2] = $kpi_res[0]['count'];
                }
                else{
                    $kpi_result[$key2] = $kpi_res[0]['count'];
                }
            }
            if($total_overall_evulation > 0 && $kpi_result[$key2] > 0)
                $kpi_result_data[$key2] = round((($kpi_result[$key2]/$total_overall_evulation)*100),2);
            else
                $kpi_result_data[$key2] = 0;
        }
        // $this->printData($kpi_result);
        // $this->printData($kpi_result_data);
        //    die;
        return $kpi_result_data;
    }
    public function kpiMetricsYear($lob,$till_date,$filter_sql){
        $date_to            =   date('Y-m-d',strtotime(date('Y-01-01')));
        // $date_form          =   date('Y-m-d');
        $date_form = date('Y-m-t', strtotime('-1 months', strtotime($till_date['date(submit_time) <='])));
        //$date_form          =   $till_date['date(submit_time) <='];
        $monthrange         =   $this->getDateMonthRange($date_to,$date_form);
        $kpi_result_data    =   [];
        $kpiMetricsArr      =   [];
        $kpiMetricsSql      =   [];
        $kpi_result         =   [];
        $sql                =   '';
        $kpiSql             =   '';
        $kpi_forms_name     =   [];
        $data = [];
        $lob_form_name      =   $this->getFormName($lob);
        $lobData = "'".implode(",", $lob)."'";
        $kpi_metrics_sql =" SELECT attr_id,kpi_metrics,form_name FROM forms where FIND_IN_SET(lob,$lobData) and kpi_metrics != ''";  
        $kpi_query = $this->db->query($kpi_metrics_sql);
        $kpi_metrics_res = $kpi_query->result();
        
        // echo $this->db->last_query();
        // print_r($kpi_metrics);die;
        foreach ($monthrange as $key => $value) {
            $month_name = date('M',strtotime($key));
            $kpiMetricsSql[$month_name]=[];
            $month_start = $value['to'];
            $month_end = $value['form'];
            
            // Over all Evalution
                $overall_qa_sql = '';
                foreach ($lob_form_name as $lkey => $lvalue) {
                    $overall_qa_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$month_start' and DATE(submit_time) <= '$month_end' UNION ALL ";
                }   
                $ovelall_words = explode( "UNION ALL", $overall_qa_sql);
                array_splice( $ovelall_words, -1 );
                $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
                $overall_total_qa_sql ="SELECT count(t.total_score) as count FROM ($overall_qa_total_sql)t";
                $overall_query = $this->db->query($overall_total_qa_sql);
                $overall_result[$month_name] = $overall_query->result_array();
                //echo $this->db->last_query();
                
                $evolution[$month_name]= $overall_result[$month_name][0]['count'];
                // print_r($evolution);
            // End Over all Evalution

            foreach ($kpi_metrics_res as $key => $value) {
                if($value->kpi_metrics != "(NULL)"){
                    $km = explode('|', $value->kpi_metrics);
                    $attrSql = '';
                    foreach ($km as $key1 => $value1) {
                        switch ($value1) {
                            case '1':
                                $kpi = 'CSAT';
                                break;
                            case '2':
                                $kpi = 'Resolution';
                                break;
                            case '3':
                                $kpi = 'Sales';
                                break;                    
                            default:
                                $kpi = 'Retention';
                                break;
                        }
                        if($this->array_key_exists_recursive($kpi, $kpiMetricsSql[$month_name])){
                            $kpiMetricsSql[$month_name][$kpi] = $kpiMetricsSql[$month_name][$kpi]."AND $value->attr_id = 'YES'";
                            $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                            $attr_coloumn[$kpi] = $value->attr_id;
                            $kpi_forms_name[] = $value->form_name;
                        }
                        else{
                            $kpiMetricsArr[$value->attr_id] = $value1;
                            $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                            $attr_coloumn[$kpi] = $value->attr_id;
                            $kpi_forms_name[] = $value->form_name;
                            $kpiMetricsSql[$month_name][$kpi] = "$value->attr_id = 'YES' $filter_sql AND DATE(submit_time) >= '$month_start' and DATE(submit_time) <= '$month_end'";
                        }
                    }
                }
            }
            // print_r($kpiMetricsSql);
            $form_name = array_unique($kpi_forms_name);
            foreach ($kpiMetricsSql as $key2 => $value2) {
                foreach ($value2 as $key3 => $value3) {
                    // print_r($value3);
                    $kpiSql = '';
                    foreach ($form_name as $lkey => $lvalue) {
                        $attr = "unique_id";//$attr_score[$key2];
                        if ($this->db->field_exists($attr_coloumn[$key3], $lvalue)){
                            $kpiSql .="SELECT $attr as total_score FROM  $lvalue WHERE $value3 UNION ALL ";
                        }
                    }
                    $kpiwords = explode( "UNION ALL", $kpiSql );
                    array_splice( $kpiwords, -1 );
                    $kpiSql = implode( "UNION ALL", $kpiwords );
                    if(!empty($kpiSql)){
                        $kpi_wise_total_sql =" SELECT count(t.total_score) as count FROM ($kpiSql)t";  
                        $kpi_query = $this->db->query($kpi_wise_total_sql);
                        $kpi_res = $kpi_query->result_array();
                        if($this->array_key_exists_recursive($key3, $kpi_result)){
                            $kpi_result[$month_name][$key3] = $kpi_res[0]['count'];
                        }
                        else{
                            $kpi_result[$month_name][$key3] = $kpi_res[0]['count'];
                        }
                    }
                    if($evolution[$month_name] > 0 && $kpi_result[$key2] > 0)
                        $kpi_result_data[$key3][$month_name] = ['month'=>$month_name,'avg'=>round((($kpi_result[$month_name][$key3]/$evolution[$month_name])*100),2)];
                    else
                        $kpi_result_data[$key3][$month_name] = ['month'=>$month_name,'avg'=>0];
                }
            }
            // print_r($kpi_result_data);
            foreach ($kpi_result_data as $key22 => $value22) {
                $data[$key22][] = ['month'=>$value22[$month_name]['month'],'avg'=>$value22[$month_name]['avg']];
            }
        }
        
        // die;
        // $this->printData($kpi_result);
        // $this->printData($kpiMetricsSql);die;
        // $this->printData($kpi_result_data);die;
        // $this->printData($data);die;
        //die;
        // return $kpi_result_data;
        return $data;
    }
    public function getDateMonthRange($date_to,$date_form){
        $startdate  =     new DateTime($date_to); 
        $enddate    =     new DateTime($date_form);
        $year       =      $startdate->format('Y');
        $start_month =     (int)$startdate->format('m');
        $end_month   =     (int)$enddate->format('m');
        $range = [];
        for ( $i=$start_month; $i<=$end_month; $i++) {
            $date = new DateTime($year.'-'.$i);
            if($i != $end_month)
                $range[$date->format('FY')] = ['to'=>$date->format('Y-m-01'),'form'=>$date->format('Y-m-t')];
            else
                $range[$date->format('FY')] = ['to'=>$date->format('Y-m-01'),'form'=>date('Y-m-d')];
        }
        return $range;
    }
    public function agentWiseEvaloution($lob,$form_name,$emp_condition_field,$till_date){
        $agentEva   =   [];
        $date_to    =   $till_date['date(submit_time) >='];
        $date_form  =   $till_date['date(submit_time) <='];
        $sup_id     =   $this->session->userdata('empid');
        $sup_agent  =   $this->common->getWhereSelectAll('user',['empid','location'],['sup_id'=>$sup_id,'is_admin'=>3,'usertype'=>2]);
        $agent_eva_sql = '';
        // echo $this->db->last_query();die;
        // if(!empty($sup_agent)){
            //foreach ($sup_agent as $key => $value) {                
                foreach ($form_name as $lkey => $lvalue) {
                    $agent_eva_sql .="SELECT count(unique_id) as unique_id,location FROM  $lvalue->form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' GROUP BY location UNION ALL ";
                }
                $agent_eva_sql_words = explode( "UNION ALL", $agent_eva_sql);
                array_splice( $agent_eva_sql_words, -1 );
                $agent_eva_sql = implode( "UNION ALL", $agent_eva_sql_words );
                $sql ="SELECT t.unique_id as count,location FROM ($agent_eva_sql)t";  
                $query = $this->db->query($sql);
                $result1 = $query->result_array();
                if(!empty($result1)){
                    foreach ($result1 as $key => $value) {
                        $location =$value['location'];
                        // $till_date[$emp_condition_field] = $value->empid;
                        $loc = $this->getLatLang($location);
                        $lat = $loc->lat;
                        $lng = $loc->lng;
                        $agent_eva_sql = '';
                        $agentEva[]=[
                            'title'=>$location,
                            'latitude'=>$lat,
                            'longitude'=>$lng,
                            'total_evalution'=>$value['count'],
                        ];
                    }
                    
                }
            //}
        // }
        // else{
        //     $agentEva[]=[
        //             'title'=>'',
        //             'latitude'=>'',
        //             'longitude'=>'',
        //             'total_evalution'=>'',
        //         ];
        // }
                // print_r($agentEva);die;
        return $agentEva;
    }
    public function fatalEscFeedback($total_overall_evulation,$lob,$till_date,$filter_sql){
        $date_to        =   $till_date['date(submit_time) >='];
        $date_form      =   $till_date['date(submit_time) <='];
        $diff           =   date_diff(date_create($date_to),date_create($date_form));
        $total_days     =   abs($diff->format("%R%a"));
        $form_name      =   $this->getFormName($lob);
        $esc_day_wise_result    = [];
        $fatel_wise_result      = [];
        $feedback_wise_result   = [];
        for($i=0;$i<($total_days+1);$i++) {
            $sd = date("Y-m-d", strtotime("+$i day", strtotime($date_to)));
            $gd = date("d-M", strtotime("+$i day", strtotime($date_to)));
            $day_wise_sql = '';
            $escSql = '';
            $fatelSql = '';
            $feedbackSql = '';
            $total_eva_sql = '';
            foreach ($form_name as $lkey => $lvalue) {
                $day_wise_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) = '".$sd."' $filter_sql UNION ALL ";

                $escSql .="SELECT total_score FROM  $lvalue->form_name WHERE esc_phase_id = 3 AND DATE(submit_time) = '".$sd."' $filter_sql UNION ALL ";

                $fatelSql .="SELECT total_score FROM  $lvalue->form_name WHERE total_score = 0 AND DATE(submit_time) = '".$sd."' $filter_sql UNION ALL ";

                $feedbackSql .="SELECT total_score FROM  $lvalue->form_name WHERE feedback_com != '' AND DATE(submit_time) = '".$sd."' $filter_sql UNION ALL ";
                
                $total_eva_sql .="SELECT unique_id as total_score FROM  $lvalue->form_name WHERE DATE(submit_time) = '".$sd."' $filter_sql UNION ALL ";
            }   
            
            $words = explode( "UNION ALL", $day_wise_sql );
            array_splice( $words, -1 );
            $day_wise_sql = implode( "UNION ALL", $words );
            $day_wise_total_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count FROM ($day_wise_sql)t";  
            $day_wise_query = $this->db->query($day_wise_total_sql);
            $day_wise_result = $day_wise_query->result_array();
            
            $esc_words      = explode( "UNION ALL", $escSql);
            array_splice( $esc_words, -1 );
            $esc_day_wise_sql       = implode( "UNION ALL", $esc_words );
            $esc_total_sql          = "SELECT AVG(t.total_score) AS esc_avg_score,count(t.total_score) as esc_count FROM ($esc_day_wise_sql)t";
            $esc_day_wise_query         = $this->db->query($esc_total_sql);
            $esc_day_wise_result      = $esc_day_wise_query->result_array();
            // echo $this->db->last_query();
            // print_r($esc_day_wise_result);die;
            
            $fatel_words    = explode( "UNION ALL", $fatelSql);
            array_splice( $fatel_words, -1 );
            $fatel_day_wise_sql     = implode( "UNION ALL", $fatel_words );
            $fatel_total_sql        = "SELECT AVG(t.total_score) AS fatel_avg_score,count(t.total_score) as fatel_count FROM ($fatel_day_wise_sql)t";
            $fatel_day_wise_query       = $this->db->query($fatel_total_sql);
            $fatel_day_wise_result    = $fatel_day_wise_query->result_array();
            // echo $this->db->last_query();
            
            $feedback_words = explode( "UNION ALL", $feedbackSql);
            array_splice( $feedback_words, -1 );
            $feedback_day_wise_sql = implode( "UNION ALL", $feedback_words );
            $feedback_total_sql    = "SELECT AVG(t.total_score) AS feed_avg_score,count(t.total_score) as feed_count FROM ($feedback_day_wise_sql)t";
            $feedback_day_wise_query    = $this->db->query($feedback_total_sql);
            $feedback_day_wise_result = $feedback_day_wise_query->result_array();

            $total_eva_words = explode( "UNION ALL", $total_eva_sql);
            array_splice( $total_eva_words, -1 );
            $total_eva_sql = implode( "UNION ALL", $total_eva_words );
            $total_eva_sql = "SELECT count(t.total_score) as tot_eva_count FROM ($total_eva_sql)t";
            $total_eva_query    = $this->db->query($total_eva_sql);
            $total_eva_result = $total_eva_query->result_array();
            // print_r($total_eva_result);die;

            $date_wise_data[] = [
                'escavg'=>(!empty($esc_day_wise_result[0]['esc_count'])?round((($esc_day_wise_result[0]['esc_count']/$total_eva_result[0]['tot_eva_count'])*100),2):0),
                'fatelavg'=>(!empty($fatel_day_wise_result[0]['fatel_count'])?round((($fatel_day_wise_result[0]['fatel_count']/$total_eva_result[0]['tot_eva_count'])*100),2):0),
                'feedbackavg'=>(!empty($feedback_day_wise_result[0]['feed_count'])?round((($feedback_day_wise_result[0]['feed_count']/$total_eva_result[0]['tot_eva_count'])*100),2):0),
                'total_evulation'=>$day_wise_result[0]['count'],
                'day'=>$gd
            ];
            $result['day_wise'] = (!empty($date_wise_data)?$date_wise_data:[]);
        }
        // print_r($date_wise_data);die;
        return $date_wise_data;
    }
    public function EscRate($total_overall_evulation,$lob,$till_date,$pre_date){
        $date_wise_data = [];
        if($total_overall_evulation > 0){
            $date_to        =   $till_date['date(submit_time) >='];
            $date_form      =   $till_date['date(submit_time) <='];
            $pre_date_to    =   $pre_date['date(submit_time) >='];
            $pre_date_form  =   $pre_date['date(submit_time) <='];
            $diff           =   date_diff(date_create($date_to),date_create($date_form));
            $total_days     =   abs($diff->format("%R%a"));
            $form_name      =   $this->getFormName($lob);
            $esc_day_wise_result    = [];
            $fatel_wise_result      = [];
            $feedback_wise_result   = [];
            $escSql = '';
            $fatelSql = '';
            $feedbackSql = '';
            $total_eva_sql = '';
            $preescSql = '';
            foreach ($form_name as $lkey => $lvalue) {
                $escSql .="SELECT total_score FROM  $lvalue->form_name WHERE esc_phase_id = 3 AND DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' UNION ALL ";
                $preescSql .="SELECT total_score FROM  $lvalue->form_name WHERE esc_phase_id = 3 AND DATE(submit_time) >= '$pre_date_to' and DATE(submit_time) <= '$pre_date_form' UNION ALL ";
            }            
            $esc_words      = explode( "UNION ALL", $escSql);
            array_splice( $esc_words, -1 );
            $esc_day_wise_sql       = implode( "UNION ALL", $esc_words );
            $esc_total_sql          = "SELECT AVG(t.total_score) AS esc_avg_score,count(t.total_score) as esc_count FROM ($esc_day_wise_sql)t";
            $esc_day_wise_query         = $this->db->query($esc_total_sql);
            $esc_day_wise_result      = $esc_day_wise_query->result_array();

            $date_wise_data = [
                'escavg'=>(!empty($esc_day_wise_result[0]['esc_count'])?round((($esc_day_wise_result[0]['esc_count']/$total_overall_evulation)*100),2):0),
            ];

            $pre_esc_words      = explode( "UNION ALL", $preescSql);
            array_splice( $pre_esc_words, -1 );
            $pre_esc_day_wise_sql       = implode( "UNION ALL", $pre_esc_words );
            $pre_esc_total_sql          = "SELECT AVG(t.total_score) AS esc_avg_score,count(t.total_score) as esc_count FROM ($pre_esc_day_wise_sql)t";
            $pre_esc_day_wise_query         = $this->db->query($pre_esc_total_sql);
            $pre_esc_day_wise_result      = $pre_esc_day_wise_query->result_array();
            //print_r($pre_esc_day_wise_result);die;
            if($esc_day_wise_result[0]['esc_count'] > 0){
                $pre_pass_rate_data = [
                    'avg'=>round((($pre_esc_day_wise_result[0]['esc_count']/$esc_day_wise_result[0]['esc_count'])*100),2)
                ];
                $last_month_avg = (!empty($date_wise_data['escavg'])?$date_wise_data['escavg']:0) - $pre_pass_rate_data['avg'];
                if($last_month_avg > 0)
                    $result['pre_esc_rate'] = ['pe'=>[abs($last_month_avg)]];
                else if($last_month_avg < 0)
                    $result['pre_esc_rate'] = ['ne'=>[abs($last_month_avg)]];
                else
                    $result['pre_esc_rate'] = ['eq'=>[abs($last_month_avg)]];
            }
            else{
                $result['pre_esc_rate'] = ['eq'=>0];
            }
        }
        $result['esc_rate_count'] = (!empty($date_wise_data)?$date_wise_data:[]);
        // print_r($result);die;
        return $result;
    }
    public function array_key_exists_recursive($key, $array) {
        if (array_key_exists($key, $array)) {
            return true;
        }
        foreach($array as $k => $value) {
            if (is_array($value) && $this->array_key_exists_recursive($key, $value)) {
                return true;
            }
        }
        return false;            
    }
    public function dateRange($datType){
        $today = date('Y-m-d');
        // jai set date Range
        if($datType =="1_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-6 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="2_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-13 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="3_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-20 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="4_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-27 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="1_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-1 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="2_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-2 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
       
        if($datType =="3_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-3 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="4_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-4 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="5_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-5 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="6_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-6 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="7_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-7 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="8_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-8 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="9_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-9 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="10_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-10 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="11_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-4 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="12_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-12 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        // end date range jai
        if($datType =="OneDay" ){
            $oneday = date('Y-m-d', strtotime('-1 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="Today" ){
            $where["date(submit_time) >="] = $today;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="OneWeek" ){
            $oneday = date('Y-m-d', strtotime('-7 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="TwoWeeks" ){
            $oneday = date('Y-m-d', strtotime('-14 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="PreviousMonth" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('first day of last month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('last day of last month'));
        }
        if($datType =="OneMonth" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('last month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="CurrentMonth" ){
            $where["date(submit_time) >="] = date('Y-m-d',strtotime(date('Y-m-01')));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="QuartertoDate" ){
            $where["date(submit_time) >="] = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-2 month")), 1, date("Y", strtotime("-1 month"))));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="YearDate" ){
            $where["date(submit_time) >="] = date('Y-m-d',strtotime(date('Y-01-01')));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="OneYear" ){
            $where["date(submit_time) >="] = date("Y-m-d",strtotime("-1 year"));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        return $where;
    }
    public function getArrtibuteRank($emp_condition_field,$where,$sup_lob,$filter_sql){
        $filter_sql =  substr(strstr($filter_sql," "), 1);
        if(!empty($filter_sql))
            $where[$filter_sql] = null;
        $data = [];
        $getFormName = $this->getFormName($sup_lob);
        $formname = $getFormName[0]->form_name;
        $attribute = $this->common->getDistinctWhere('forms',['attribute','attr_id','weightage'],['lob'=>$sup_lob,'form_name'=>$formname]);
        foreach ($attribute as $key => $value) {
            $attr = explode("_", $value->attr_id);
            $attr_scote = $attr[0]."_score";
            $attr[$value->attr_id] = $this->common->getWhereSelectAll($formname,[
                'count(unique_id) as total_evulation',
                'count(case when (\'NA\' = '.$value->attr_id.' ) then 1 else null end) as na',
                'count(case when (\'YES\' = '.$value->attr_id.' ) then 1 else null end) as yes',
                'SUM(CASE 
                    WHEN '.$value->attr_id.' = "YES" 
                    THEN '.$attr_scote.' 
                    ELSE 0 
                END) AS sum_yes',
                'SUM(CASE 
                    WHEN '.$value->attr_id.' = "NA" 
                    THEN '.$attr_scote.' 
                    ELSE 0 
                END) AS sum_na'
            ],$where);
            // echo $this->db->last_query();die;
            $total_evulation    = (int)$attr[$value->attr_id][0]->total_evulation;//1
            $total_na           = (int)$attr[$value->attr_id][0]->sum_na;//0
            $total_yes          = (int)$attr[$value->attr_id][0]->sum_yes;//2
            $attr_weightage     = (int)$value->weightage;//2
            if($total_evulation > 0){
                if((($total_evulation *$attr_weightage)-$total_na ) > 0)
                    $final_score    = ((($total_yes - $total_na))/(($total_evulation *$attr_weightage)-$total_na )*100);
                else
                    $final_score = 0;
            }
            else
                $final_score  = 0;
            $data[] = ['avg' => sprintf('%0.2f',$final_score),'name' => str_replace("'", "'", $value->attribute)];
            // $data[] = ['avg' => sprintf('%0.2f',$final_score),'name' => $value->attribute];
        }
        $col  = 'avg';
        $sort = array();
        foreach ($data as $i => $obj) {
            $sort[$i] = $obj[$col];
        }
        array_multisort($sort, SORT_DESC, $data);
        $data1['rank']['top'] = array_slice($data, 0, 10, true);
        array_multisort($sort, SORT_ASC, $data);
        $data1['rank']['bottom'] = array_slice($data, 0, 10, true);
        // print_r($data1);die;
        return $data1['rank'];
    }
    public function getFormName($lob){
        return $this->common->getWhereInSelectAll('forms_details',['form_name','pass_rate','lob'],'lob',$lob);
    }
    public function getFormPassRate($lob){
        return $this->common->getWhereInSelectAll('forms_details',['form_name','pass_rate'],'lob',$lob);
    }
    public function getCatName($form_name){
        return $this->common->getWhereInSelectAll('forms',['category','cat_id'],'form_name',$form_name);
    }
    public function getsupervisorAgent($sup_id){
        return $this->common->getDistinctWhere('user',['empid'],['sup_id'=>$sup_id]);
    }    
    public function formData($formName,$between){
        return $this->common->getWhereSelectAll($formName,['count(total_score) as count','sum(total_score) as avg','evaluator_name'],$between);       
    }
    public function formPassRateData($formName,$where){
        return $this->common->getWhereSelectAll($formName,['count(total_score) as count','ROUND(avg(total_score),2) as avg','evaluator_name'],$where);
    }
    public function sectionData($formName,$select,$where){
        return $this->common->getWhereSelectAll($formName,$select,$where);
    }
    public function formDataTotalScoreisZero($formName,$select,$where){
        return $this->common->getWhereSelectAll($formName,$select,$where);
    }
    public function getCategory(){
        $lob =  urldecode($this->input->post('lob'));
        $data['lob'] = $this->common->getDistinctWhere('forms','category',['lob'=>$lob]);
        echo postRequestResponse($data);die;
    }
    public function getLobSearchData(){
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $lob = explode('|||', $this->session->userdata('lob'));
        $search_type = urldecode($this->input->post('search_type'));
        if($search_type == "lob"){
            foreach ($lob as $key => $value) {
                $result['data'][] = ['name' => $value];
            }
        }
        if($search_type == "campaign"){
            $result['data'] = $this->common->getWhereInSelectAll('hierarchy','campaign as name','lob',$lob);
        }
        if($search_type == "vendor"){
            $result['data'] = $this->common->getWhereInSelectAll('hierarchy','vendor as name','lob',$lob);
        }
        if($search_type == "location"){
            $result['data'] = $this->common->getWhereInSelectAll('hierarchy','location as name','lob',$lob);
        }
        if($search_type == "agents"){
            $result['data'] = $this->common->getDistinctWhere('user',['empid as id','name'],['sup_id'=>$this->session->userdata('empid')]);
        }
        if($this->input->post('section')){
            $res = $this->common->getDistinctWhere('hierarchy',['campaign as c','vendor as v','location as l'],['lob'=>urldecode($this->input->post('search_type'))]);
            $result['c']=[];
            $result['v']=[];
            $result['l']=[];
            foreach ($res as $key => $value) {
                if(!array_key_exists($value->c, $result['c'])){
                    $result['c'][$value->c] = ['id'=>$value->c,'name'=>$value->c];
                }
                if(!array_key_exists($value->v, $result['v'])){
                    $result['v'][$value->v] = ['id'=>$value->v,'name'=>$value->v];
                }
                if(!array_key_exists($value->l, $result['l'])){
                    $result['l'][$value->l] = ['id'=>$value->l,'name'=>$value->l];
                }
            }
            $result['e'] = $this->common->getDistinctWhere('user',['empid as id','name'],['sup_id'=>$this->session->userdata('empid')]);
            $result['att'] = $this->common->getDistinctWhere('forms',['category as id','category as name'],['lob'=>urldecode($this->input->post('search_type'))]);

        }
        if($this->input->post('attribute')){
            $result['att'] = $this->common->getDistinctWhere('forms',['attr_id as id','attribute as name'],['lob'=>urldecode($this->input->post('attr_search_type')),'category'=>urldecode($this->input->post('search_type'))]);

        }
        echo postRequestResponse($result);die;
        // echo postRequestResponse($result['data']);die;
    }
    public function chartFilter(){
        $lob =  explode('|||', $this->session->userdata('lob'));
        $dateCondition = $this->input->post('condition');
        if($dateCondition == 'Custom'){
            $sdate = $this->input->post('sdate');
            $edate = $this->input->post('edate');
            $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sdate));
            $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($edate));
        }
        else{
            $till_date = $this->dateRange($dateCondition);
        }
        $data = $this->getagentEvalution($lob,$till_date);
        echo postRequestResponse($data);die;
        $lob = $this->input->post('lob');
        $sdate = $this->input->post('chart_sdate');
        $edate = $this->input->post('chart_edate');
        $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sdate));
        $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($edate));
        $pre_date["date(submit_time) >="] = date('Y-m-01', strtotime('-1 months', strtotime($sdate)));
        $pre_date["date(submit_time) <="] = date('Y-m-t', strtotime('-1 months', strtotime($sdate)));

        $supervisor_id =   $this->session->userdata('empid');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $data = $this->getOverAllQAScore($lob,$till_date,$pre_date);
        $data['tilldate'] = date('Y-m-d',strtotime($sdate))." To ".date($edate);
        $data['currentLob'] = $lob[0];
        $data['result'] = true;
        $this->load->view('dashboard_new',$data);
        //echo postRequestResponse($data);die;
    }
    public function attrFilter(){
        $supervisor_id             =   $this->session->userdata('empid');
        $emp_condition_field        =   (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $dashboard_filter_details   =   $this->common->getWhere('dashboard',['sup_id'=>$supervisor_id]);
        $filter_sql                 =   '';
        $lob                        =   (array)$this->input->post('lob');
        $date_range                 =   $this->input->post('date_range');
        if(!empty($dashboard_filter_details)){
            if(!empty($dashboard_filter_details[0]->campaign)){
                $campaign_implode = "'".$dashboard_filter_details[0]->campaign."'";
                $filter_sql .=  "AND FIND_IN_SET(campaign,$campaign_implode)";
            }
            if(!empty($dashboard_filter_details[0]->vendor)){
                $vendor_implode = "'".$dashboard_filter_details[0]->vendor."'";
                $filter_sql .=  "AND FIND_IN_SET(vendor,$vendor_implode)";
            }
            if(!empty($dashboard_filter_details[0]->location)){
                $location_implode = "'".$dashboard_filter_details[0]->location."'";
                $filter_sql .=  "AND FIND_IN_SET(location,$location_implode)";
            }
            if(!empty($dashboard_filter_details[0]->agent)){
                $agents_implode = "'".$dashboard_filter_details[0]->agent."'";
                $filter_sql .=  "AND FIND_IN_SET($emp_condition_field,$agents_implode)";
            }
        }
        if($date_range != "Custom"){
            $till_date = $this->dateRange($date_range);          
        }
        else{
            $sdate = $this->input->post('filter_start_date');
            $edate = $this->input->post('filter_end_date');
            $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sdate));
            $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($edate));
        }

        $lob_new_data = [];
        $form_name  =   $this->getFormName($lob);
        foreach ($form_name as $key => $value) {
            $frmData[$value->lob] = ['form_name'=>$value->form_name,'pass_rate'=>$value->pass_rate];
        }
        foreach ($lob as $lob_value) {
            $key = array_search($lob_value, array_column($form_name, 'lob'));
            $lob_new_data[] = $form_name[$key];
        }
        $frmData = (!empty($lob_new_data)?$lob_new_data:$form_name);
        // $data = $this->getArrtibuteRank($emp_condition_field,$till_date,$lob,$filter_sql);
        $data = $this->arrtibuteData($emp_condition_field,$frmData,$till_date,$filter_sql);
        $data['currentLob']     = $lob;
        echo postRequestResponse($data);die;
    }
    public function catFilter(){
        $supervisor_id             =   $this->session->userdata('empid');
        $emp_condition_field        =   (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $dashboard_filter_details   =   $this->common->getWhere('dashboard',['sup_id'=>$supervisor_id]);
        $filter_sql = '';
        //$lob =  explode('|||', $this->session->userdata('lob'));
        $lob        =  (array)$this->input->post('lob');
        $date_range = $this->input->post('date_range');
        if(!empty($dashboard_filter_details)){
            // $lob = explode(',', $dashboard_filter_details[0]->lob);
            if(!empty($dashboard_filter_details[0]->campaign)){
                $campaign_implode = "'".$dashboard_filter_details[0]->campaign."'";
                $filter_sql .=  "AND FIND_IN_SET(campaign,$campaign_implode)";
            }
            if(!empty($dashboard_filter_details[0]->vendor)){
                $vendor_implode = "'".$dashboard_filter_details[0]->vendor."'";
                $filter_sql .=  "AND FIND_IN_SET(vendor,$vendor_implode)";
            }
            if(!empty($dashboard_filter_details[0]->location)){
                $location_implode = "'".$dashboard_filter_details[0]->location."'";
                $filter_sql .=  "AND FIND_IN_SET(location,$location_implode)";
            }
            if(!empty($dashboard_filter_details[0]->agent)){
                $agents_implode = "'".$dashboard_filter_details[0]->agent."'";
                $filter_sql .=  "AND FIND_IN_SET($emp_condition_field,$agents_implode)";
            }
        }
        if($date_range != "Custom"){
            $till_date = $this->dateRange($date_range);          
        }
        else{
            $sdate = $this->input->post('filter_start_date');
            $edate = $this->input->post('filter_end_date');
            $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sdate));
            $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($edate));
        }
        $lob_new_data = [];
        $form_name  =   $this->getFormName($lob);
        foreach ($form_name as $key => $value) {
            $frmData[$value->lob] = ['form_name'=>$value->form_name,'pass_rate'=>$value->pass_rate];
        }
        foreach ($lob as $lob_value) {
            $key = array_search($lob_value, array_column($form_name, 'lob'));
            $lob_new_data[] = $form_name[$key];
        }
        $frmData = (!empty($lob_new_data)?$lob_new_data:$form_name);
        // $data['attribute'] = $this->getAttribute($lob,$till_date,$filter_sql);
        $data['category'] = $this->categoryData($emp_condition_field,$frmData,$till_date,$filter_sql);
        $data['currentLob']     = $lob;
        echo postRequestResponse($data);die;
    }
    public function overAll($where,$search_type,$search_result,$coloum_color){
        $coloum_color = (array) $coloum_color;
        // return $coloum_color;
        $resultset = [];
        if($search_type != "lob"){
            $lob =  explode('|||', $this->session->userdata('lob'));
        }
        else{
            $lob = $search_result;
        }
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $form_name = $this->getFormName($lob);
        $count=1;
        $rs = '';
        $res = [];
        foreach ($form_name as $key => $value) {
            $fn = $value->form_name;                
            foreach ($search_result as $key1 => $value1) {
                if($search_type != "agents")
                    $where[$search_type] = $value1;
                else
                    $where[$emp_condition_field] = $value1;
                $avg = $this->formData($fn,$where);
                
                if($avg[0]->count > 0){
                    if(array_key_exists($value1, $res)){
                        $res[$value1] = (float) $res[$value1] + (float) $avg[0]->avg;
                        $res['count'][$value1]  =   (($avg[0]->avg > 0)?(int) $res['count'][$value1] + 1:$res['count'][$value1]);
                        // $resultset[]['color'] = $coloum_color[$key];
                    }
                    else{
                        $res[$value1] = (float) $avg[0]->avg;
                        $res['name'][$value1] = $value1;
                        $res['count'][$value1]  = (($avg[0]->avg > 0)?1:0);
                        $arr[$value1] = ['color' => $coloum_color[$value1],'name'    =>  $value1];
                    }
                }
            }
        }
        foreach ($res['name'] as $key2 => $value2) {
            $resultset[] = [
                'name'  =>  $arr[$value2]['name'],
                'color'  =>  $arr[$value2]['color'],
                'avg'   =>($res[$value2]/$res['count'][$value2])
            ];
        }
        // return $this->printData($resultset);
        return $resultset;
        foreach ($search_result as $key2 => $value2) {
            if($res['count'][$value2] > 0){
                $result[$value2] = ($res[$value2]/$res['count'][$value2]);
                $resultset[] = [
                            'name'  =>$value2,
                            'avg'   =>$result[$value2],
                ];
            }
        }
        return $resultset;
    }
    public function fatel($where,$search_type,$search_result,$coloum_color){
        $coloum_color = (array)$coloum_color;
        if($search_type != "lob")
            $lob =  explode('|||', $this->session->userdata('lob'));
        else
            $lob = $search_result;
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $form_name  = $this->getFormName($lob);
        $res = [];
        foreach ($form_name as $key1 => $value1) {
            foreach ($search_result as $key2 => $value2) {
                if($search_type != "agents")
                    $where[$search_type] = $value2;
                else
                    $where[$emp_condition_field] = $value2;
                $total_score_zero_count = $this->formDataTotalScoreisZero($value1->form_name,'count(case when (total_score = 0) then 1 else null end) as count',$where);

                $total_evulation_count  = $this->formDataTotalScoreisZero($value1->form_name,'count(unique_id) as unique_id',$where);
                if($total_evulation_count[0]->unique_id > 0){
                     if(array_key_exists($value2, $res)){
                        $res[$value2]['zero'] = (float) $res[$value2]['zero'] + (float) $total_score_zero_count[0]->count;
                        $res[$value2]['nonzero'] = (float) $res[$value2]['nonzero'] + (float) $total_evulation_count[0]->unique_id;
                    }
                    else{
                        $res[$value2]['zero'] = (float) $total_score_zero_count[0]->count;
                        $res[$value2]['nonzero'] = (float) $total_evulation_count[0]->unique_id;
                        $res[$value2]['name'] = $value2;
                        $arr[$value2] = ['color' => $coloum_color[$value2],'name'    =>  $value2];
                    }
                }
                
            }    
        }
        foreach ($res as $key2 => $value2) {
            $resultset[] = [
                'name'  =>  $value2['name'],
                'color'  =>  $arr[$value2['name']]['color'],
                'avg'   =>round((($value2['zero']/$value2['nonzero'])*100),2)
            ];
        }
        return $resultset;
        foreach ($res as $key => $value) {
            $result[] = [
                            'name' => $key,
                            'avg' => round((($value['zero']/$value['nonzero'])*100),2)
                        ];
        }
        // print_r($result);
        // print_r($res);
        // die;
        return $result; 
    }
    public function pass($where,$search_type,$search_result,$coloum_color){
        $coloum_color = (array)$coloum_color;
        if($search_type != "lob")
            $lob =  explode('|||', $this->session->userdata('lob'));
        else
            $lob = $search_result;
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');

        $form_name  = $this->getFormName($lob);
        $res = [];
        foreach ($form_name as $key1 => $value1) {
            foreach ($search_result as $key2 => $value2) {
                if($search_type != "agents")
                    $where[$search_type] = $value2;
                else
                    $where[$emp_condition_field] = $value2;
                $select =['count(unique_id) as total_evulation','count(case when (total_score > '.$value1->pass_rate.' ) then 1 else null end) as pass_rate'];
                $pass = $this->common->getWhereSelectAll($value1->form_name,$select,$where);
                // echo $this->db->last_query();
                if(!empty($pass)){
                    if(array_key_exists($value2, $res)){
                        $res[$value2]['total_evulation'] = (float) $res[$value2]['total_evulation'] + (float) $pass[0]->total_evulation;
                        $res[$value2]['pass_rate'] = (float) $res[$value2]['pass_rate'] + (float) $pass[0]->pass_rate;
                    }
                    else{
                        $res[$value2]['total_evulation'] = (float) $pass[0]->total_evulation;
                        $res[$value2]['pass_rate'] = (float) $pass[0]->pass_rate;
                        $res[$value2]['name'] = $value2;
                        $arr[$value2] = ['color' => $coloum_color[$value2],'name'    =>  $value2];
                    }
                }                
            }
        }
        foreach ($res as $key2 => $value2) {
            $resultset[] = [
                'name'  =>  $value2['name'],
                'color'  =>  $arr[$value2['name']]['color'],
                'avg'   =>round((($value2['pass_rate']/$value2['total_evulation'])*100),2)
            ];
        }
        return $resultset;
        // die;
        foreach ($res as $key => $value) {
            $result[] = [
                            'name' => $key,
                            'avg' => round((($value['pass_rate']/$value['total_evulation'])*100),2)
                        ];
        }
        //print_r($result);die;
        // print_r($res);
        // die;
        return $result; 
    }

    // Other Industry Type

    public function getTemplateDetails($site = null,$group = null,$form_id=""){
        $where          = '';
        $result = [];
        if(!empty($site)){
            $s   =  implode('|', explode(',',$site));
            $where  .=  'site_id REGEXP "(^|,)'.$s.'(,|$)"';
        }
        if(!empty($group)){
            $g =  implode('|', explode(',',$group));
            if(!empty($site))
                $where .= " AND";
            $where  .=  ' group_id REGEXP "(^|,)'.$g.'(,|$)"';
        }
        if(!empty($form_id))
        {
        if(!empty($where)){
            $sql                =   "SELECT tmp_unique_id,tmp_name,tb_name,tmp_name FROM template_details WHERE $where AND tmp_unique_id = '$form_id' ";
            $query              =   $this->db->query($sql);
            $result = $query->result();
        }
    }else{
        if(!empty($where)){
            $sql                =   "SELECT tmp_unique_id,tmp_name,tb_name,tmp_name FROM template_details WHERE $where";
            $query              =   $this->db->query($sql);
            $result = $query->result();
        }
    }
        // echo $this->db->last_query();
        // print_r($result);die;
        return $result;
        // print_r($result);die;
    }

    public function getAllAuditCount($template_details,$start_date,$end_date){
        // print_r(template_details);die;
        $all_audit_sql = '';
        foreach ($template_details as $lkey => $lvalue) {
            // $all_audit_sql .="SELECT total_score FROM  $lvalue->tb_name WHERE DATE(submit_time) >= '$start_date' and DATE(submit_time) <= '$end_date' UNION ALL ";
            $all_audit_sql .="SELECT unique_id,total_score,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $lvalue->tb_name WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
        }
        $ovelall_words = explode( "UNION ALL", $all_audit_sql);
        array_splice( $ovelall_words, -1 );
        $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
        
        $overall_total_qa_sql ="SELECT t.mtd as day,count(unique_id) as count FROM ($overall_qa_total_sql)t GROUP BY mtd ORDER BY STR_TO_DATE(day, '%d-%M-%y') ASC";  
        $overall_query = $this->db->query($overall_total_qa_sql);
        $data['count'] = $overall_query->result_array();

        $overall_total_avg_sql ="SELECT t.mtd as day,round(avg(total_score),2) as avg FROM ($overall_qa_total_sql)t GROUP BY mtd ORDER BY STR_TO_DATE(day, '%d-%M-%y') ASC";  
        $overall_avg_query = $this->db->query($overall_total_avg_sql);
        $data['avg'] = $overall_avg_query->result_array();
        return $data;
    }

    public function topAuditorResponse($template_details,$start_date,$end_date){
        $top_auditor_sql = '';
        foreach ($template_details as $lkey => $lvalue) {
            // $top_auditor_sql .="SELECT sum(total_score) as ts,evaluator_name FROM  $lvalue->tb_name WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' GROUP BY evaluator_id UNION ALL ";
            $top_auditor_sql .="SELECT total_score as ts,evaluator_name,evaluator_id FROM  $lvalue->tb_name WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
        }
        $top_auditor = explode( "UNION ALL", $top_auditor_sql);
        array_splice( $top_auditor, -1 );
        $top_sql = implode( "UNION ALL", $top_auditor );
        $overall_total_qa_sql ="SELECT round(avg(ts),2) as ts,evaluator_name FROM ($top_sql)t group by evaluator_id ORDER BY ts desc limit 5"; 
        $overall_query = $this->db->query($overall_total_qa_sql);
        $data['top'] = $overall_query->result_array();
        $overall_bottom_sql ="SELECT round(avg(ts),2) as ts,evaluator_name FROM ($top_sql)t group by evaluator_id ORDER BY ts ASC limit 5"; 
        $overall_bquery = $this->db->query($overall_bottom_sql);
        $data['bottom'] = $overall_bquery->result_array();
        // echo $this->db->last_query();die;
        return $data;
    }

    public function getCardsData($template_details,$start_date,$end_date){
        $top_auditor_sql = '';
        foreach ($template_details as $lkey => $lvalue) {
            $top_auditor_sql .="SELECT count(audit_sr_no) as total,sum(total_score) as ts FROM  $lvalue->tb_name WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
        }
        $top_auditor = explode( "UNION ALL", $top_auditor_sql);
        array_splice( $top_auditor, -1 );
        $top_sql = implode( "UNION ALL", $top_auditor );
        $total ="SELECT sum(total) as total_count,sum(ts) as sum_total_score FROM ($top_sql)t"; 
        $total_query = $this->db->query($total);
        $overall_result = $total_query->result_array();
        if($overall_result[0]['total_count'] > 0 && !empty($overall_result[0]['sum_total_score'])){
            $data['total_count']  = ((!empty($overall_result)?round($overall_result[0]['total_count'],2):0));
            $data['total_avg']  = ((!empty($overall_result)?round($overall_result[0]['sum_total_score']/$overall_result[0]['total_count'],2):0));
        }
        else{
            $data['total_count'] = 0;
            $data['total_avg']   = 0;
        }

        // failed item
        $failed_item_attr_sql = '';
        foreach ($template_details as $lkey => $lvalue) {
            $newtemplateName    = str_replace('tb_temp_','',$lvalue->tb_name);
            //$failed_item_attr_sql .="SELECT t_att_id,'$lvalue->tb_name' as TableName FROM  template  WHERE  t_name = '$lvalue->tb_name' and t_cat_id != 'cat1' AND (t_option_type = 'select' OR t_option_type = 'checkbox') UNION ALL ";
            $failed_item_attr_sql .="SELECT t_att_id,'$lvalue->tb_name' as TableName FROM  template  WHERE  t_unique_id = '$newtemplateName' and t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
        }
        $failed = explode( "UNION ALL", $failed_item_attr_sql);
        array_splice( $failed, -1 );
        $failed_sql = implode( "UNION ALL", $failed );
        $failed_q ="SELECT t_att_id,TableName FROM ($failed_sql)t"; 
        $failed_query = $this->db->query($failed_q);
        $failed_result = $failed_query->result_array();
        // print_r($failed_result);die;
        
        $failed_attr_arr = [];
        foreach ($failed_result as $key => $value) {
            $att_id = explode("_", $value['t_att_id']);
            $failed_id = $att_id[0].'_fail';
            if (array_key_exists($value['TableName'],$failed_attr_arr)){
                $failed_attr_arr[$value['TableName']][] = $failed_id;
            }
            else{
                $failed_attr_arr[$value['TableName']][] = $failed_id;
            }
        }
        $failed_item_sql = '';
        $attr_fail_count = 0;
        foreach ($failed_attr_arr as $key => $value) {

            $failed_item_sql .="SELECT SUM(";
            foreach ($value as $key1 => $value1) {
                $attr_fail_count++;
                $failed_item_sql .= "CASE WHEN $value1 = 'yes' THEN 1 ELSE 0 END + ";
            }
            $failed_item_sql = rtrim($failed_item_sql,' +');
            $failed_item_sql .= " ) as total_failed FROM  $key WHERE DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
        }
        //echo $attr_fail_count;die;
        $failed_item = explode( "UNION ALL", $failed_item_sql);
        array_splice( $failed_item, -1 );
        $failed_sql = implode( "UNION ALL", $failed_item );
        if(!empty($failed_sql)){
            $failed_item_q ="SELECT sum(total_failed) as total_failed FROM ($failed_sql)t"; 
            $failed_item_query = $this->db->query($failed_item_q);
            $failed_item_result = $failed_item_query->result_array();
        }
       // print_r($failed_item_result); die;
        //echo $attr_fail_count; die;
        $data['failed'] = (!empty($failed_item_result)?round((($failed_item_result[0]['total_failed']/$attr_fail_count)),2):0)."%";
        // echo $this->db->last_query();
         // print_r($data);die;
        return $data;        
    }

    public function actionItemCharts($template_details,$start_date,$end_date){
        $attr_name_data = '';
        foreach ($template_details as $key => $t_value) {
            $tmp_unique_id = str_replace("tb_temp_", "",$t_value->tb_name);
            $attr_name_data .="SELECT t_att_name,t_att_id,'$t_value->tb_name' AS TableName,'$t_value->tmp_name' AS TemplateName,'$tmp_unique_id' as tmp_unique_id  FROM  template WHERE t_unique_id = '$tmp_unique_id' AND t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
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
            $failed_sql .="SELECT t1.unique_id, '$attributeName' as attributeName,'$templateName' as templateName,'$att_value->t_att_id' as t_att_id,'$TableName' as TableName,(select status from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as status,(select att_comment from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as att_comment FROM $tableNmae t1
                    WHERE t1.$attFail ='yes' AND DATE(submit_time) >= '$start_date' and DATE(submit_time) <= '$end_date' UNION ALL "; 
        }
        $failed_ovelall_words = explode( "UNION ALL", $failed_sql);
        array_splice( $failed_ovelall_words, -1 );
        $failed_overall_qa_total_sql = implode( "UNION ALL", $failed_ovelall_words );
        $failed_overall_total_qa_sql ="SELECT * FROM ($failed_overall_qa_total_sql)t ORDER BY attributeName ASC";  
        $failed_overall_query = $this->db->query($failed_overall_total_qa_sql);
        $failed_overall_result = $failed_overall_query->result();
        $pendingCount = 0;
        $closedCount = 0;
        $inprogressCount = 0;
        if(!empty($failed_overall_result)){
            foreach($failed_overall_result as $f_key => $f_value) {
                $status =   $f_value->status;
                $cmt    =   $f_value->att_comment;
                $status =   (($status  == '1') ? 'Inprogress' : (($status == '2') ? 'Closed' : 'Pending'));
                $cmt    =   (!empty($cmt) ? $cmt : 'NA');
                switch ($status) {
                    case 'Pending':
                        $pendingCount = $pendingCount + 1;
                        break;
                    case 'Closed':
                        $closedCount = $closedCount + 1;
                        break;
                    
                    default:
                        $inprogressCount = $inprogressCount+1;
                        break;
                }
            }
            $data[] = [
                'status'=>  'In progress',
                'avg'   =>  (($inprogressCount > 0)?round((($inprogressCount/count($failed_overall_result))*100),2):0)."%" ,
                'color'=>'#4ba33b'
            ];
            $data[] = [
                'status'=>'Pending',
                'avg'   =>  (($pendingCount > 0)?round((($pendingCount/count($failed_overall_result))*100),2):0)."%" ,
                'color'=>'#db5383'
            ];
            $data[] = [
                'status'=>'Closed',
                'avg'   =>  (($closedCount > 0)?round((($closedCount/count($failed_overall_result))*100),2):0)."%" ,
                'color'=>'#63b3d3'
            ];
        }
        else{
            $data[] = ['status'=>'In progress','avg'=>$inprogressCount,'color'=>'#4ba33b'];
            $data[] = ['status'=>'Pending','avg'=>$pendingCount,'color'=>'#db5383'];
            $data[] = ['status'=>'Closed','avg'=>$closedCount,'color'=>'#63b3d3'];
        }
        
        // print_r($data);die;
        return $data;
    }

    public function getBreackdownData($template_details,$template_option_response,$start_date,$end_date){
        $template_response_details = [];
        $data = [];
        if(!empty($template_details) && !empty($template_option_response)){
            $total_response = $this->common->getWhereSelectAll($template_details,['count(audit_sr_no) as total_audit'],['DATE(submit_time) >=' => $start_date,'DATE(submit_time) <=' => $end_date]);

            //$total_question = $this->common->getWhereSelectAll('template',['count(t_id) as total_question'],['t_cat_id !=' => 'cat1','t_name' =>$template_details]);
            $btableName = str_replace('tb_temp_','',$template_details);
            $total_question = $this->common->getWhereSelectAll('template',['count(t_id) as total_question'],['t_cat_id !=' => 'cat1','t_unique_id' =>$btableName]);
            $total_audit_response = (!empty($total_response)?$total_response[0]->total_audit:0);
            $total_question = (!empty($total_question)?$total_question[0]->total_question:0);
            $total_question_audit = ($total_audit_response*$total_question);
            if($total_audit_response > 0 && $total_question_audit > 0){
                $opt_sql = '';
                $opt_sql .="SELECT ";
                foreach ($template_option_response as $okey => $ovalue) {
                    $opt_value = explode('|', $ovalue->opt_text);
                    $opt_attribute = explode(',', $ovalue->opt_value);
                    foreach ($opt_value as $key1 => $value1) {
                            //$opt_sql .= 'count(CASE WHEN '.$ovalue->opt_value.' REGEXP "[[:<:]]'.$value1.'[[:>:]]" THEN 1 END) as "'.$value1.'",';
                        $opt_sql .= 'sum(';                                        
                        foreach ($opt_attribute as $akey => $avalue) {
                            $opt_sql .= '(CASE WHEN '.$avalue.' REGEXP "[[:<:]]'.$value1.'[[:>:]]" THEN 1 ELSE 0 END)+';
                        }
                        $opt_sql = rtrim($opt_sql,' +');
                        $opt_sql .= " ) as '$value1' ,";
                    }
                }
                $opt_sql = rtrim($opt_sql,',');
                $opt_sql .= " FROM  $template_details WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date'";
                if(!empty($opt_sql)){
                    $opt_query = $this->db->query($opt_sql);
                    $opt_result = $opt_query->result_array();
                    // echo $this->db->last_query();
                    $opt_result = (!empty($opt_result)?$opt_result[0]:[]);
                    // print_r($opt_result);die;
                    foreach ($opt_result as $key3 => $value3) {                    
                        //$data[] = ['country' => $key3,'litres'=> (($value3/$total_audit_response)*100)];
                        $data[] = ['country' => $key3,'litres'=> (($value3/$total_question_audit)*100)];
                    }
                    
                }
            }
        }
        // echo $this->db->last_query();die;
        // print_r($data);die;
        return $data;
    }
    public function getAuditorData($template_details,$start_date,$end_date){
        $user_id                =   $this->session->userdata('user_id');
        $site                   =   $this->session->userdata('site');
        $group                  =   $this->session->userdata('u_group');
        $total_evulation_sql    =   '';
        $group_sql              =   '';
        $s                      =  implode('|', explode(',',$site));
        $site_where             =  ' And site_id REGEXP "(^|,)'.$s.'(,|$)"'; 
        $g                      =  implode('|', explode(',',$group));
        $group_where            =  ' And group_id REGEXP "(^|,)'.$g.'(,|$)"';
        foreach ($template_details as $lkey => $lvalue) {
            $total_evulation_sql .="SELECT audit_sr_no as total,total_score FROM  $lvalue->tb_name WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' and evaluator_id = $user_id UNION ALL ";
            $group_sql .="SELECT total_score as total,evaluator_name FROM  $lvalue->tb_name WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' $group_where $site_where UNION ALL ";
        }
        $total_evulation = explode( "UNION ALL", $total_evulation_sql);
        array_splice( $total_evulation, -1 );
        $total_evulation_sql_query = implode( "UNION ALL", $total_evulation );
        $total ="SELECT count(total) as total_evulation,round(avg(total_score),2) as evalution_avg FROM ($total_evulation_sql_query)t"; 
        $total_query = $this->db->query($total);
        $overall_evalution_result = $total_query->result_array();
        $data['total_evulation'] = (!empty($overall_evalution_result)?$overall_evalution_result[0]['total_evulation']:0);
        $data['total_evulation_avg'] = (!empty($overall_evalution_result)?$overall_evalution_result[0]['evalution_avg']:0);

        // group & site avg        
        $group_avg = explode( "UNION ALL", $group_sql);
        array_splice( $group_avg, -1 );
        $group_avg_sql_query = implode( "UNION ALL", $group_avg );
        $group_avg_total ="SELECT round(avg(total),2) as total_group_avg FROM ($group_avg_sql_query)t"; 
        $group_avg_total_query = $this->db->query($group_avg_total);
        $group_avg_result = $group_avg_total_query->result_array();
        $data['g_s_avg'] = (!empty($group_avg_result)?$group_avg_result[0]['total_group_avg']:0);
        // group & site avg


        $all_audit_sql = '';
        foreach ($template_details as $lkey => $lvalue) {
            // $all_audit_sql .="SELECT total_score FROM  $lvalue->tb_name WHERE DATE(submit_time) >= '$start_date' and DATE(submit_time) <= '$end_date' UNION ALL ";
            $all_audit_sql .="SELECT unique_id,total_score,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $lvalue->tb_name WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' and evaluator_id = $user_id UNION ALL ";
        }
        $ovelall_words = explode( "UNION ALL", $all_audit_sql);
        array_splice( $ovelall_words, -1 );
        $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
        
        $overall_total_qa_sql ="SELECT t.mtd as day,count(unique_id) as count FROM ($overall_qa_total_sql)t GROUP BY mtd ORDER BY STR_TO_DATE(day, '%d-%M-%y') ASC";  
        $overall_query = $this->db->query($overall_total_qa_sql);
        $data['day_wise_audit'] = $overall_query->result_array();
        // print_r($data);die;
        return $data;
    }

    public function faildAttributeResponse($template_details,$start_date,$end_date){
        // failed item
        // echo "<pre>";
        //print_r($template_details);die;
        
        $failed_item_attr_sql   =   '';
        $data                   =   [];
        $top                   =   [];
        $total_question        =   [];
        foreach ($template_details as $lkey => $lvalue) {
            $btableName = str_replace('tb_temp_','',$lvalue->tb_name);
            //$failed_item_attr_sql .="SELECT t_att_id,'$lvalue->tb_name' as TableName,'$lvalue->tmp_name' as template_name,t_att_name FROM  template  WHERE  t_name = '$btableName' and t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
            $failed_item_attr_sql .="SELECT t_att_id,'$lvalue->tb_name' as TableName,'$lvalue->tmp_name' as template_name,t_att_name FROM  template  WHERE  t_unique_id = '$btableName' and t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
            $total_question[$lvalue->tmp_name] = $this->common->getWhereSelectAll('template',['count(t_id) as total_question'],['t_cat_id !=' => 'cat1','t_name' =>$lvalue->tmp_name]);
            
        }
        $failed = explode( "UNION ALL", $failed_item_attr_sql);
        array_splice( $failed, -1 );
        $failed_sql = implode( "UNION ALL", $failed );
        $failed_q ="SELECT * FROM ($failed_sql)t"; 
        $failed_query = $this->db->query($failed_q);
        $failed_result = $failed_query->result_array();
        // print_r($failed_result);die;
        $failed_attr_arr = [];
        foreach ($failed_result as $key => $value) {
            $att_id = explode("_", $value['t_att_id']);
            $failed_id = $att_id[0].'_fail';
            if (array_key_exists($value['TableName'],$failed_attr_arr)){
                // $failed_attr_arr[$value['TableName']][] = $failed_id;
                $failed_attr_arr[$value['TableName']][] = ['fail'=>$failed_id,'question'=>$value['t_att_name'],'template_name'=>$value['template_name']];
            }
            else{
                // $failed_attr_arr[$value['TableName']][] = $failed_id;
                $failed_attr_arr[$value['TableName']][] = ['fail'=>$failed_id,'question'=>$value['t_att_name'],'template_name'=>$value['template_name']];
            }
        }
        // all data display with attribute
        // print_r($failed_attr_arr);die;
        $failed_item_sql = '';
        foreach ($failed_attr_arr as $key => $value) {
            foreach ($value as $key1 => $value1) {
                $question = str_replace("'", "`", $value1['question']); 
                $failed_item_sql .="SELECT count(unique_id) as total_audit_count,";
                $failed_item_sql .= "SUM(CASE WHEN ".$value1['fail']." = 'yes' THEN 1 ELSE 0 END) as audit_count,'".$value1['fail']."' as attribute,";
                $failed_item_sql .= "'$key' as template_name,'".$question."' as question FROM  $key WHERE DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' GROUP BY question ";
                $top_failed_item_q ="SELECT *,round(((audit_count/total_audit_count)*100),2) as avg_score FROM ($failed_item_sql)t ORDER BY avg_score ASC";
                $top_failed_item_query = $this->db->query($top_failed_item_q);
                $result = $top_failed_item_query->result();
                // echo $this->db->last_query();die;
                // $data['top'][] = ((!empty($result))?$result[0]:[]);
                //if(!empty($result))
                $data[] = ((!empty($result))?$result[0]:[]);
                $failed_item_sql = '';
            }
            break;
        }
        $findData = array_column($data, 'avg_score');
        if(!empty($findData)){
            usort($data, function ($a, $b) {return $a->avg_score < $b->avg_score;});
            $top['top'] = array_slice($data, 0, 5);
        }
        //print_r($top);die;
        //  $col  = 'avg';
        // $sort1 = array();
        // foreach($data as $j => $obj1 ){
        //     $sort1[$j] =  $obj1[$col];
        // }
        // array_multisort($sort1, SORT_DESC, $data);
        // $top = $top['top'];
        // $columns = array_column($top , 'avg_score');
        //  array_multisort($columns, SORT_ASC, $top);
        //$top['top'] = $top;
        return $top;
        //die;
        // 2nd option only templet name display
        //print_r($failed_attr_arr);die;
        $failed_item_sql = '';
        foreach ($failed_attr_arr as $key => $value) {
            $failed_item_sql .="SELECT sum(";
            foreach ($value as $key1 => $value1) {
                // print_r($value1);die;
                $failed_item_sql .= "CASE WHEN ".$value1['fail']." = 'yes' THEN 1 ELSE 0 END + ";
            }
            $failed_item_sql = rtrim($failed_item_sql,' +');
            $failed_item_sql .= " ) as total_failed,count(unique_id) as total_audit_count,'".$value1['template_name']."' as template_name FROM  $key WHERE DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
            // echo $failed_item_sql;die;
        }
        $failed_item = explode( "UNION ALL", $failed_item_sql);
        array_splice( $failed_item, -1 );
        $failed_sql = implode( "UNION ALL", $failed_item );
        if(!empty($failed_sql)){
            $top_failed_item_q ="SELECT * FROM ($failed_sql)t  ORDER BY total_failed DESC limit 5";
            $top_failed_item_query = $this->db->query($top_failed_item_q);
            $top = $top_failed_item_query->result();
            foreach ($top as $tkey => $tvalue) {
                if($tvalue->total_audit_count > 0 && $total_question[$tvalue->template_name][0]->total_question > 0){

                    $data['top'][] = ['template_name'=>trim($tvalue->template_name),'total_audit_count'=>$tvalue->total_audit_count,'total_failed'=>$tvalue->total_failed,'avg_score'=>round(($tvalue->total_failed/($tvalue->total_audit_count*$total_question[$tvalue->template_name][0]->total_question)*100),2)];
                }
                else{
                    $data['top'][] = ['template_name'=>trim($tvalue->template_name),'total_audit_count'=>$tvalue->total_audit_count,'total_failed'=>$tvalue->total_failed,'avg_score'=>0];
                }
            }
            $bottom_failed_item_q ="SELECT *,round(((total_failed/total_audit_count)*100),2) as avg_score FROM ($failed_sql)t  ORDER BY avg_score desc limit 5";
            $bottom_failed_item_query = $this->db->query($bottom_failed_item_q);
            $bottom = $bottom_failed_item_query->result();
            foreach ($bottom as $tkey => $tvalue) {
                if($tvalue->total_audit_count > 0 && $total_question[$tvalue->template_name][0]->total_question > 0){
                    $data['bottom'][] = ['template_name'=>trim($tvalue->template_name),'total_audit_count'=>$tvalue->total_audit_count,'total_failed'=>$tvalue->total_failed,'avg_score'=>round(($tvalue->total_failed/($tvalue->total_audit_count*$total_question[$tvalue->template_name][0]->total_question)*100),2)];
                }
                else{
                    $data['bottom'][] = ['template_name'=>trim($tvalue->template_name),'total_audit_count'=>$tvalue->total_audit_count,'total_failed'=>$tvalue->total_failed,'avg_score'=>0];
                }
            }
        }
        else{
            $data['top'] = [];
            $data['bottom'] = [];
         // echo $this->db->last_query();die;
        }
        // print_r($data);die;
        // echo $this->db->last_query();die;


        // $sort1 = array();
        // foreach($data as $j => $obj1 ){
        //     $sort1[$j] =  $obj1[$col];
        // }
        // // sorting array in desending order
        // array_multisort($sort1, SORT_DESC, $data);
        
        return $data;
    }

    public function actionItemFilter(){
        $s_date             =   (!empty($this->input->post('s_date'))?$this->input->post('s_date'):date('Y-m-d',strtotime(date('Y-m-01'))));
        $e_date             =   (!empty($this->input->post('e_date'))?$this->input->post('e_date'):date('Y-m-d'));
        $templates          =   $this->input->post('templates');
        if(!empty($templates)){
            foreach ($templates as $tkey => $tvalue) {
                $template_details[] = (object)['tmp_name'=>$tvalue,'tb_name'=>$tvalue];    
            }
            $data['actionitems'] = $this->actionItemCharts($template_details,$s_date,$e_date);
            echo postRequestResponse($data);
        }
        else{
            echo postRequestResponse('error');
        }
    }

    public function topFaildAttributeResponseFilter(){
        $s_date             =   (!empty($this->input->post('s_date'))?$this->input->post('s_date'):date('Y-m-d',strtotime(date('Y-m-01'))));
        $e_date             =   (!empty($this->input->post('e_date'))?$this->input->post('e_date'):date('Y-m-d'));
        $templates          =   $this->input->post('templates');
        if(!empty($templates)){
            foreach ($templates as $tkey => $tvalue) {
                $template_details[] = (object)['tmp_name'=>$tvalue,'tb_name'=>$tvalue];    
            }
            $data = $this->faildAttributeResponse($template_details,$s_date,$e_date);
            $data = (!empty($data)?$data:['top'=>[]]);
            echo postRequestResponse($data);
        }
        else{
            echo postRequestResponse('error');
        }
    }
    
    

    public function auditoFilter(){
        
        $site          =   $this->session->userdata('site');
        $group         =   $this->session->userdata('u_group');
        $site_ex = explode(',',$site);
        $group_ex = explode(',',$group);
        $user_id =$this->session->userdata('user_id');
        $formId =$this->input->post('formId');
        $dateRange =$this->input->post('condition');
        $dateRange_other =$this->input->post('condition_other');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        //code by jai dashboard generate by template
        $form_detail =$this->common->getWhereSelectAllToArray('template_details',['tmp_unique_id','tmp_name','tmp_attributes','tb_name','site_id','group_id'],['tmp_unique_id'=>$formId]);
        $data['form_wise_data'] =$this->common->getWhereSelect_auditor($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$dateRange_other,$site,$group,$sdate,$edate);
        $exp_date_range = explode('_',$dateRange_other);
        $weekdata = array();
        $sitedata =array();
        $groupdata =array();
        if($exp_date_range[0]>0)
        {
            $weektype ="";
            if($exp_date_range[1]=='Weeks')
            {
                
                for($i=0;$i<$exp_date_range[0];$i++)
                {
                    if($i==0)
                    {
                     $cond ='1_Weeks';
                     $weektype ="Week1"; 
                   }else if($i==1)
                   {
                    $cond ='2_Weeks';
                    $weektype ="Week2";  
                   }else if($i==2)
                   {
                    $cond ='3_Weeks';
                    $weektype ="Week3";
                   }else if($i==3)
                   {
                    $cond ='4_Weeks'; 
                    $weektype ="Week4";
                   }

                    $data['day_wise_audit'] = $this->common->getAuditscore($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$cond,$site,$group);
                    if(!empty($data['day_wise_audit']))
                    {
                        foreach($data['day_wise_audit'] as $weeks)
                        {
                            
                           $res =['day'=>$weektype,'count'=>$weeks['count'],'tscore'=>$weeks['tscore']];
                           array_push($weekdata,$res);
                        }
                    }
                    if(!empty($site_ex))
                    {
                    foreach($site_ex as $sitee)
                    {
                    $site_Name = $this->common->getWhereSelectAllToArray('sites',['s_name'],['s_id'=>$sitee]);
                    $site_wise_day = $this->common->site_group_wise($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$cond,$sitee,'site');
                    if(!empty($site_wise_day))
                    {
                    foreach($site_wise_day as $site_d)
                    {
                    // $si = ['site_name'=>$site_Name[0]['s_name'],'time_type'=> $weektype,'count'=> $site_d['total_evulation'],'tscore'=> $site_d['total_evulation_avg']];
                    $si = ['date'=> $weektype,'visits'=> $site_d['total_evulation'],'site_group'=>$site_Name[0]['s_name'],'avg_score'=>$site_d['total_evulation_avg']];
                    array_push($sitedata,$si);
                    }
                    }
                    } 
            
                } 
                
                if(!empty($group_ex))
                {
                foreach($group_ex as $groupe)
                {
                $group_Name = $this->common->getWhereSelectAllToArray('groups',['g_name'],['g_id'=>$groupe]);
                $site_wise_day = $this->common->site_group_wise($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$cond,$groupe,'group');
                if(!empty($site_wise_day))
                {
                    foreach($site_wise_day as $group_d)
                    {
                //$gi = ['group_name'=>$group_Name[0]['g_name'],'time_type'=> $weektype,'count'=> $group_d['total_evulation'],'tscore'=> $group_d['total_evulation_avg']];
                $gi = ['date'=> $weektype,'visits'=> $group_d['total_evulation'],'site_group'=>$group_Name[0]['g_name'],'avg_score'=>$group_d['total_evulation_avg']];
                array_push($groupdata,$gi);
                }
            }
                } 
            }     
              
                }
            }else if($exp_date_range[1]=='Months')
            {
                //$month_name=array('Jan','Feb','Mar','Aprl','May','Jun','July','Aug','Sept','Oct',);
                for($i=0;$i<$exp_date_range[0];$i++)
                {
                    $u =$i+1;
                    $weektype = "Month".$u;
                    $cond = $u.'_Months';
                    $data['day_wise_audit'] = $this->common->getAuditscore($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$cond,$site,$group);
                    if(!empty($data['day_wise_audit']))
                    {
                        foreach($data['day_wise_audit'] as $months)
                        {
                            $month_yr =$months['day']."".$months['yr'];
                           $res =['day'=>$month_yr,'count'=>$months['count'],'tscore'=>$months['tscore']];
                           array_push($weekdata,$res);
                        }
                    }
                    if(!empty($site_ex))
                    {
                    foreach($site_ex as $sitee)
                    {
                    $site_Name = $this->common->getWhereSelectAllToArray('sites',['s_name'],['s_id'=>$sitee]);
                    $site_wise_day = $this->common->site_group_wise($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$cond,$sitee,'site');
                    if(!empty($site_wise_day))
                    {
                    foreach($site_wise_day as $site_d)
                    {
                    $month_yr =$site_d['day']."".$site_d['yr'];
                    // $si = ['site_name'=>$site_Name[0]['s_name'],'time_type'=> $month_yr,'count'=> $site_d['total_evulation'],'tscore'=> $site_d['total_evulation_avg']];
                    $si = ['date'=> $month_yr,'visits'=> $site_d['total_evulation'],'site_group'=>$site_Name[0]['s_name'],'avg_score'=>$site_d['total_evulation_avg']];
                    array_push($sitedata,$si);
                    }
                    
                    } 
            
                } 
            }
                // $site_wise_day = $this->common->site_group_wise($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$cond,$site,'site');
                
                if(!empty($group_ex))
                {
                foreach($group_ex as $groupe)
                {
                $group_Name = $this->common->getWhereSelectAllToArray('groups',['g_name'],['g_id'=>$groupe]);
                $site_wise_day = $this->common->site_group_wise($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$cond,$groupe,'group');
                if(!empty($site_wise_day))
                {
                    foreach($site_wise_day as $group_d)
                    {
                        $month_yr =$group_d['day']."".$group_d['yr'];
               // $gi = ['group_name'=>$group_Name[0]['g_name'],'time_type'=> $weektype,'count'=> $group_d['total_evulation'],'tscore'=> $group_d['total_evulation_avg']];
               $gi = ['date'=> $month_yr,'visits'=> $group_d['total_evulation'],'site_group'=>$group_Name[0]['g_name'],'avg_score'=>$group_d['total_evulation_avg']];
                array_push($groupdata,$gi);
                }
                } 
            }
            }     
                }
            }
            $data['day_wise_audit'] =$weekdata;
        }else{
       
        if(!empty($site_ex))
        {
        foreach($site_ex as $sitee)
        {
        $site_Name = $this->common->getWhereSelectAllToArray('sites',['s_name'],['s_id'=>$sitee]);
        $site_wise_day = $this->common->site_group_wise($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$dateRange_other,$sitee,'site',$sdate,$edate);
        if(!empty($site_wise_day))
        {
            foreach($site_wise_day as $site_d)
            {
        // $si = ['site_name'=>$site_Name[0]['s_name'],'time_type'=> $site_d['day'],'count'=> $site_d['total_evulation'],'tscore'=> $site_d['total_evulation_avg']];
        $si = ['date'=> $site_d['day'],'visits'=> $site_d['total_evulation'],'site_group'=>$site_Name[0]['s_name'],'avg_score'=>$site_d['total_evulation_avg']];
        array_push($sitedata,$si);
        }
        } 
    }

    } 
    if(!empty($group_ex))
    {
    foreach($group_ex as $groupe)
    {
    $group_Name = $this->common->getWhereSelectAllToArray('groups',['g_name'],['g_id'=>$groupe]);
    $site_wise_day = $this->common->site_group_wise($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$dateRange_other,$groupe,'group',$sdate,$edate);
    if(!empty($site_wise_day))
    {
        foreach($site_wise_day as $group_d)
        {
   // $gi = ['group_name'=>$group_Name[0]['g_name'],'time_type'=> $group_d['day'],'count'=> $group_d['total_evulation'],'tscore'=> $group_d['total_evulation_avg']];
    $gi = ['date'=> $group_d['day'],'visits'=> $group_d['total_evulation'],'site_group'=>$group_Name[0]['g_name'],'avg_score'=>$group_d['total_evulation_avg']];
    array_push($groupdata,$gi);
    }
}
    } 
}     
        $data['day_wise_audit'] = $this->common->getAuditscore($form_detail[0]["tb_name"],$user_id,$formId,$dateRange,$dateRange_other,$site,$group,$sdate,$edate);
        }
        $data['site_wise_data'] = $sitedata;
        $data['group_wise_data'] = $groupdata;
        if($dateRange_other == "Custom")
        {
            $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sdate));
            $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($edate));
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="];
        }else{
        $till_date = $this->dateRange($dateRange_other);
        $start_date = $till_date["date(submit_time) >="];
        $end_date   = $till_date["date(submit_time) <="];
        }
        $template_details   =   $this->getTemplateDetails($site,$group,$formId);
        $data['failed'] = $this->faildAttributeResponse($template_details,$start_date,$end_date);
        echo postRequestResponse($data);die;
    }


    public function getTemplateSiteGrousWise(){
        $where = '';
        $site          =   $this->session->userdata('site');
        $group         =   $this->session->userdata('u_group');

        if(!empty($this->input->post('sites'))){
            $s   =  implode('|', explode(',',implode(',',$this->input->post('sites'))));
            $where  .=  'site_id REGEXP "(^|,)'.$s.'(,|$)"';
        }else{
            $s   =  implode('|', explode(',',$site));
            $where  .=  'site_id REGEXP "(^|,)'.$s.'(,|$)"';
        }
        if(!empty($this->input->post('groups'))){
            $g =  implode('|', explode(',',implode(',',$this->input->post('groups'))));
                $where .= " AND";
            $where  .=  ' group_id REGEXP "(^|,)'.$g.'(,|$)"';
        }else{
            $g =  implode('|', explode(',',$group));
                $where .= " AND";
            $where  .=  ' group_id REGEXP "(^|,)'.$g.'(,|$)"';
        }
        $day_wise_total_sql ="SELECT tmp_name as name,tb_name as value FROM template_details WHERE $where";
        $day_wise_query = $this->db->query($day_wise_total_sql);
        $day_wise_result = $day_wise_query->result();
        echo postRequestResponse($day_wise_result);die();
        // $gdata = $this->common->getFindInSet('user','user_id',$id,'site');
    }

    public function getTemplateResponse(){
        $temp = $this->input->post('temp');
        $temp = str_replace('tb_temp_','',$temp);
        $overall_total_qa_sql ="SELECT t_option_value as opt_text,GROUP_CONCAT(t_att_id) as opt_value FROM template WHERE t_unique_id='$temp' AND t_option_type = 'select' GROUP BY t_option_value";  
        $overall_query = $this->db->query($overall_total_qa_sql);
        $template_response_details = $overall_query->result();

        //$template_response_details = $this->common->getWhereSelectAll('template',['t_option_value as opt_text','t_att_id as opt_value'],
        //    ['t_unique_id'=>$temp,'t_option_type' => 'select']);
        echo postRequestResponse($template_response_details);die;
    }

    public function getTemplateResponseData(){
        $time_filter_type   =   $this->input->post('rangeValue');
        $time_filter        =   $this->input->post('rangeValue_other');
        $template_details   = $this->input->post('temp_name');
        $attr_value         = $this->input->post('attr_value');
        $attr_name          = str_replace(",", "|", $this->input->post('attr_name'));
        $s_date             = (!empty($this->input->post('s_date'))?$this->input->post('s_date'):date('Y-m-d',strtotime(date('Y-m-01'))));
        $e_date             = (!empty($this->input->post('e_date'))?$this->input->post('e_date'):date('Y-m-d'));
        $template_option_response[] = (object)['opt_text'=>$attr_name,'opt_value'=>$attr_value];
        $data = $this->common->getBreackdownData($template_details,$template_option_response,$s_date,$e_date,$time_filter_type,$time_filter);
        echo postRequestResponse($data);die;
    }

    public function getDashboardFilterData(){
        $time_filter_type   =   $this->input->post('rangeValue');
        $time_filter        =   $this->input->post('rangeValue_other');
        $s_date             =   (!empty($this->input->post('s_date'))?$this->input->post('s_date'):date('Y-m-d',strtotime(date('Y-m-d'))));
        $e_date             =   (!empty($this->input->post('e_date'))?$this->input->post('e_date'):date('Y-m-d'));
        $groups             =   (!empty($this->input->post('groups'))?implode(',', $this->input->post('groups')):$this->session->userdata('u_group'));
        $sites              =   (!empty($this->input->post('sites'))?implode(',', $this->input->post('sites')):$this->session->userdata('site'));
        $templates          =   $this->input->post('templates');
        $responseTemplate   =   $this->input->post('responseTemplate');
        $responseAttrValue  =   $this->input->post('responseAttrValue');
        $responseAttrText   =   str_replace(",", "|", $this->input->post('responseAttrText'));
        $data = [];
        $avg_h = "";
        $count_h = "";
        $avg_h_2 = "";
        $weekdata = array();
        $actionItem = array();
        if(empty($templates)){
            $template_details   =   $this->getTemplateDetails($sites,$groups);
        }
        else{
            
            $template_details[] = (object)['tmp_name'=>$templates,'tb_name'=>$templates];    
        }
        $exp_date_range = explode('_',$time_filter);
        if($exp_date_range[0]>0)
        {
            $weektype ="";
            if($exp_date_range[1]=='Weeks')
            {
                
                for($i=0;$i<$exp_date_range[0];$i++)
                {
                    if($i==0)
                    {
                     $cond ='1_Weeks';
                     $weektype ="Week1"; 
                   }else if($i==1)
                   {
                    $cond ='2_Weeks';
                    $weektype ="Week2";  
                   }else if($i==2)
                   {
                    $cond ='3_Weeks';
                    $weektype ="Week3";
                   }else if($i==3)
                   {
                    $cond ='4_Weeks'; 
                    $weektype ="Week4";
                   }
                
                $all_audit_count  =   $this->common->getAllAuditCount($templates,$s_date,$e_date,$time_filter_type,$cond);
                if(!empty($all_audit_count))
                    {
                        foreach($all_audit_count as $weeks)
                        {
                           $res =['day'=>$weektype,'count'=>$weeks['count'],'tscore'=>$weeks['tscore']];
                           array_push($weekdata,$res);
                        }
                    }
                    $actionitems =   $this->common->actionItemCharts($templates,$s_date,$e_date,$time_filter_type,$cond);
                    if(!empty($actionitems))
                    {
                        foreach($actionitems as $ac)
                        {
                            $ac = ['status'=>$ac['status'],'time'=>$weektype,'avg'=>$ac['avg']];
                            array_push($actionItem,$ac);
                        }
                       
                    }
                }
                $data['actionitems'] =$actionItem;
            }else if($exp_date_range[1]=='Months')
            {
                for($i=0;$i<$exp_date_range[0];$i++)
                {
                    $u =$i+1;
                    $weektype = "Month".$u;
                    $cond = $u.'_Months';
                    $all_audit_count    =   $this->common->getAllAuditCount($templates,$s_date,$e_date,$time_filter_type,$cond);
                   
                    if(!empty($all_audit_count))
                    {
                        foreach($all_audit_count as $months)
                        {
                            $month_yr =$months['day']."".$months['yr'];
                            if(!empty($month_yr))
                            {
                           $res =['day'=>$month_yr,'count'=>$months['count'],'tscore'=>$months['tscore']];
                           array_push($weekdata,$res);
                            }
                        }
                    }
                    $actionitems =   $this->common->actionItemCharts($templates,$s_date,$e_date,$time_filter_type,$cond);
                    if(!empty($actionitems))
                    {
                        foreach($actionitems as $ac)
                        {
                            $month_yr =$ac['day']."".$ac['yr'];
                            if($month_yr!='00')
                            {
                            $ac = ['status'=>$ac['status'],'time'=>$month_yr,'avg'=>$ac['avg']];
                            array_push($actionItem,$ac);
                            }
                        }
                       
                    }
                }
            }
            $data['actionitems'] =$actionItem;
            $data['all_audit'] =$weekdata;
        }else{
            if(!empty($template_details)){
               $data['all_audit']  =   $this->common->getAllAuditCount($templates,$s_date,$e_date,$time_filter_type);
                // $data['auditor']    =   $this->topAuditorResponse($template_details,$s_date,$e_date);
                // $data['actionitems']       =   $this->actionItemCharts($template_details,$s_date,$e_date);
                $actionitems =   $this->common->actionItemCharts($templates,$s_date,$e_date,$time_filter_type);
                    if(!empty($actionitems))
                    {
                        
                        foreach($actionitems as $ac)
                        {
                           if(!empty($ac['day']))
                           {
                            $ac = ['status'=>$ac['status'],'time'=>$ac['day'],'avg'=>$ac['avg']];
                            array_push($actionItem,$ac);
                           }
                        }
                       
                    }
               }
               $data['actionitems'] =$actionItem;
        }
        $data['head']  =   $this->common->getCardsData($templates,$s_date,$e_date,$time_filter_type,$exp_date_range);
        // reviewed data 
        $data['tempdetails'] = $this->common->fetchReviews($templates,$s_date,$e_date,$time_filter_type,$exp_date_range);
                $actionitem =array();
                $actioncount =0;
                if(!empty($data['tempdetails']))
                {
                    foreach($data['tempdetails'] as $fv)
                    {
                        // action Item
                    $ac = $this->common->getWhereSelectDistinctCount('action_status',['unique_id'],['unique_id'=>$fv['unique_id'],'status'=>'2']);
                    $actioncount =$actioncount+$ac;
                        // End action Item
                        
                    }
                }
         // breakdown
         $template_option_response[] = (object)['opt_text'=>$responseAttrText,'opt_value'=>$responseAttrValue];
         $data['breakdown'] = $this->common->getBreackdownData($templates,$template_option_response,$s_date,$e_date,$time_filter_type,$time_filter);
         $data['reviewedcount'] = $actioncount;
         // failed attribute
        $failed = $this->common->faildAttributeResponse($templates,$s_date,$e_date,$time_filter_type,$time_filter);
        $data['failed']=(!empty($failed))?$failed :[];

         // actionItems 
         //$data['actionitems'] =   $this->common->actionItemCharts($templates,$s_date,$e_date,$time_filter_type,$time_filter);
         // category chart data
         $formex = explode('_',$templates);
         $form_unique_Id = $formex[2];
         $cat_arr =array();
         $category_ids = $this->common->getDistinctWhere('template',['t_cat_id','t_cat_name'],['t_cat_id !='=>'cat1','t_unique_id'=>$form_unique_Id]);
         if(!empty($category_ids))
         {
             foreach($category_ids as  $cat_av)
             {
                $cat_avg = $this->common->CategoryAvg($templates,$cat_av->t_cat_id,$s_date,$e_date,$time_filter_type,$time_filter);
               
                $cat_inner = [] ;
                if($cat_avg[0]['cat_avg_count']!=0)
                {
                $cat_inner = ['name'=>$cat_av->t_cat_name,'avg'=>round($cat_avg[0]['cat_avg_count'],2)]; 
                }
                array_push($cat_arr,$cat_inner);
             }
         }
         $data['category'] = $cat_arr;
        if(!empty($data)){
            
            echo postRequestResponse($data);die;
        }
        else{
            echo postRequestResponse('error');die;
        }
    }
    // 

    // End Other Industry Type

    public function printData($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }


    public function resetDashboardFilter(){
        $this->common->delete_data('dashboard',['sup_id'=>$this->session->userdata('empid')]);
        echo postRequestResponse('success');
    }

//please write above	
}
