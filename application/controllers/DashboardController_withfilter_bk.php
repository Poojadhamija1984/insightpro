<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends MY_Controller {	
	public function index(){
		if(($this->emp_group == "client" || $this->emp_group == "ops") && $this->emp_type == "supervisor"){
            $where = [];
            $data = [];
            $supervisor_id =   $this->session->userdata('empid');
            $till_date["date(submit_time) >="]  =   date('Y-m-d',strtotime(date('Y-m-01')));
            $till_date["date(submit_time) <="]  =   date('Y-m-d');
            $pre_date["date(submit_time) >="]   =   date('Y-m-d', strtotime('-1 month'));
            $pre_date["date(submit_time) <="]   =   date('Y-m-d', strtotime('last day of last month'));
            $emp_condition_field                =   (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
            $dashboard_filter_details           =   $this->common->getWhere('dashboard',['sup_id'=>$supervisor_id]);
            $lob =  explode('|||', $this->session->userdata('lob'));
            $filter_sql = '';
            if(!empty($dashboard_filter_details)){
                $lob = explode(',', $dashboard_filter_details[0]->lob);
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
            if($this->input->post()){
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
                        $filter_sql .=  "AND FIND_IN_SET(campaign,$campaign_implode)";
                    }
                    if(!empty($vendor)){
                        $vendor_implode = "'".$vendor."'";
                        $filter_sql .=  "AND FIND_IN_SET(vendor,$vendor_implode)";
                    }
                    if(!empty($location)){
                        $location_implode = "'".$location."'";
                        $filter_sql .=  "AND FIND_IN_SET(location,$location_implode)";
                    }
                    if(!empty($agents)){
                        $agents_implode = "'".$agents."'";
                        $filter_sql .=  "AND FIND_IN_SET($emp_condition_field,$agents_implode)";
                    }
                    $data = $this->getOverAllQAScore($this->input->post('lob'),$till_date,$pre_date,$filter_sql);
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
                    $data = $this->getOverAllQAScore($lob,$till_date,$pre_date,$filter_sql);
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
                $supervisor_id = $this->session->userdata('empid');
                $data = $this->getOverAllQAScore($lob,$till_date,$pre_date,$filter_sql);
                $data['totilldate']     = date('Y-m-d',strtotime(date('Y-m-01')));
                $data['fromtilldate']   = date('Y-m-d');
                $data['currentLob']     = $lob[0];
                $data['allLob']         = $lob;
                $data['dashboard_filter_details']   =   json_encode((!empty($dashboard_filter_details))?$dashboard_filter_details:[]);
                $data['date_range'] = 'CurrentMonth';
                $data['daterangeto']= '';
                $data['daterangefr']= '';
            }
            $data['campaign'] = $this->common->getWhereInSelectAll('hierarchy','distinct(campaign)','lob',explode('|||', $this->session->userdata('lob')));
            // echo $this->db->last_query();die;
            $data['vendor'] = $this->common->getWhereInSelectAll('hierarchy','distinct(vendor)','lob',explode('|||', $this->session->userdata('lob')));
            $data['location'] = $this->common->getWhereInSelectAll('hierarchy','distinct(location)','lob',explode('|||', $this->session->userdata('lob')));
            $data['agent'] = $this->common->getWhereInSelectAll('user',['empid','name'],'sup_id',$this->session->userdata('empid'));
            // print_r($data);die;
            $this->load->view('dashboard_new',$data);
        }
        else if($this->emp_type == "agent"){
            $supervisor_id         =   $this->session->userdata('sup_id');
            $getsupervisorDetails  =   $this->common->getWhereSelectAll('user','name',['empid'=>$supervisor_id]);
            $this->db->select('h.campaign, h.vendor,h.location,u.lob_hierarchy_id,u.lob');
            $this->db->from('user u');
            $this->db->join('hierarchy h', 'h.hierarchy_id = u.lob_hierarchy_id');
            $this->db->where('empid',$this->session->userdata('empid'));
            $getAgentDetails =   $this->db->get();
            $ad = $getAgentDetails->result();
            $till_date["date(submit_time) >="] = date('Y-m-d',strtotime(date('Y-m-01')));
            $till_date["date(submit_time) <="] = date('Y-m-d');
            $pre_date["date(submit_time) >="] = date('Y-m-d', strtotime('-1 month'));
            $pre_date["date(submit_time) <="] = date('Y-m-d', strtotime('last day of last month'));
            $lob =  explode('|||', $this->session->userdata('lob'));
            $data = $this->getagentEvalution($lob,$till_date);
            $data['tilldate']       =   date('Y-m-d',strtotime(date('Y-m-01')))." To ".date('Y-m-d');
            $data['currentLob']     =   $lob[0];
            $data['sup_name']       =   $getsupervisorDetails[0]->name;
            $data['agentlob']       =   implode(',',explode('|||', $ad[0]->lob));
            $data['agentCmp']       =   $ad[0]->campaign;
            $data['agentvendor']    =   $ad[0]->vendor;
            $data['agentlocation']  =   $ad[0]->location;
            // print_r($data);die;
            $this->load->view('customer_dashboard',$data);
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
        $overall_total_qa_sql ="SELECT AVG(t.total_score) AS avg_score,sum(t.total_score) AS overall_total_score,count(t.total_score) as count FROM ($overall_qa_total_sql)t";  
        $overall_query = $this->db->query($overall_total_qa_sql);
        $overall_result = $overall_query->result_array();

        $agent_ovelall_words = explode( "UNION ALL", $overall_agent_qa_sql);
        array_splice( $agent_ovelall_words, -1 );
        $agent_overall_qa_total_sql = implode( "UNION ALL", $agent_ovelall_words );
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
        for($i=0;$i<($total_days+1);$i++) {
            $sd = date("Y-m-d", strtotime("+$i day", strtotime($date_to)));
            $gd = date("d-M", strtotime("+$i day", strtotime($date_to)));
            $day_wise_sql = '';
            foreach ($form_name as $lkey => $lvalue) {
                $day_wise_sql .="SELECT total_score FROM  $lvalue->form_name WHERE DATE(submit_time) = '".$sd."' UNION ALL ";
            }   
            $words = explode( "UNION ALL", $day_wise_sql );
            array_splice( $words, -1 );
            $day_wise_sql = implode( "UNION ALL", $words );
            $day_wise_total_sql ="SELECT AVG(t.total_score) AS avg_score,count(t.total_score) as count
                FROM ($day_wise_sql)t";  
            $day_wise_query = $this->db->query($day_wise_total_sql);
            $day_wise_result = $day_wise_query->result_array();
            $date_wise_data[] = [
                'avg'=>round($day_wise_result[0]['avg_score'],2),
                'total_evulation'=>round($day_wise_result[0]['avg_score'],2),
                'year'=>$gd
            ];
            $result['day_wise'] = (!empty($date_wise_data)?$date_wise_data:[]);
        }
         // print_r($result);die;
        return $result;        
    }

    public function getLatLang($location){
        $getloc = json_decode(file_get_contents("https://api.opencagedata.com/geocode/v1/json?q=$$location&key=a056df4a24f540fbaa53aaa6ab3bf153"));
        return $getloc->results[0]->geometry;
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
        //print_r($attr);
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
                $range[$date->format('F')] = ['to'=>$date->format('Y-m-01'),'form'=>$date->format('Y-m-t')];
            else
                $range[$date->format('F')] = ['to'=>$date->format('Y-m-01'),'form'=>date('Y-m-d')];
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
        return $this->common->getWhereInSelectAll('forms_details',['form_name','pass_rate'],'lob',$lob);
    }

    public function getFormPassRate($lob){
        return $this->common->getWhereInSelectAll('forms_details',['form_name','pass_rate'],'lob',$lob);
    }

    public function getCatName($form_name){
        return $this->common->getWhereInSelectAll('forms',['category','cat_id'],'form_name',$form_name);
    }

    public function getsupervisorAgent($sup_id){
        //return $this->common->getDistinctWhere('user',['empid','lob'],['sup_id'=>$sup_id]);
        return $this->common->getDistinctWhere('user',['empid'],['sup_id'=>$sup_id]);
    }
    
    public function formData($formName,$between){
        //return $this->common->getWhereSelectAll($formName,['count(total_score) as count','ROUND(avg(total_score), 2) as avg','evaluator_name'],$between);       
        return $this->common->getWhereSelectAll($formName,['count(total_score) as count','sum(total_score) as avg','evaluator_name'],$between);       
    }

    public function formPassRateData($formName,$where){
        return $this->common->getWhereSelectAll($formName,['count(total_score) as count','ROUND(avg(total_score), 2) as avg','evaluator_name'],$where);       
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
        $filter_sql = '';
        //$lob =  explode('|||', $this->session->userdata('lob'));
        $lob        =  $this->input->post('lob');
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
        $data = $this->getArrtibuteRank($emp_condition_field,$till_date,$lob,$filter_sql);
        $data['currentLob']     = $lob;
        echo postRequestResponse($data);die;
    }
    public function catFilter(){
        $supervisor_id             =   $this->session->userdata('empid');
        $emp_condition_field        =   (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $dashboard_filter_details   =   $this->common->getWhere('dashboard',['sup_id'=>$supervisor_id]);
        $filter_sql = '';
        //$lob =  explode('|||', $this->session->userdata('lob'));
        $lob        =  $this->input->post('lob');
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
        $data['attribute'] = $this->getAttribute($lob,$till_date,$filter_sql);
        $data['category'] = $this->getCategoryData($lob,$till_date,$filter_sql);
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

    public function printData($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

//please write above	
}
