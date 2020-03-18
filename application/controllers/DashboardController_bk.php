<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends MY_Controller {
	
	public function index(){
		if(($this->emp_group == "client" || $this->emp_group == "ops") && $this->emp_type == "supervisor"){
            $post = $this->input->post();
            $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
            $supervisor_id = $this->session->userdata('empid'); 
            if($post){
                $from_date      =   date('Y-m-d',strtotime ($post['audit_from']));
                $to_date        =   date('Y-m-d',strtotime ($post['audit_to']));
                $date_column    =   $post['date_column'];
                $sup_lob        =   $post['lob'];
                $campaign       =   $post['campaign'];
                $vendor         =   $post['vendor'];
                $location       =   $post['location'];
                $agents         =   $post['agents'];
                $where["date($date_column) >="] = $from_date;
                $where["date($date_column) <="] = $to_date;
                if($campaign){
                    $where['campaign']  =  $campaign;
                }
                if($vendor){
                    $where['vendor']    = $vendor;
                }
                if($location){
                    $where['location']  = $location;
                }
            }
            else{
                $agents         =   null;
                $from_date      =   date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));
                $to_date        =   date('Y-m-d');
                $sup_lob        =   explode('|||', $this->session->userdata('lob'))[0];
                // $between        =   "CAST(submit_time as DATE) BETWEEN {$from_date} AND {$to_date}";
                $where["date(submit_time) >="] = $from_date;
                $where["date(submit_time) <="] = $to_date;
        	}
            $data['title']      =   "Title";
            $data['qa']         =   $this->getOverallQAScore($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents);
            $data['sqa']        =   $this->getSectionWiseQAScore($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents);
            $data['affs']       =   $this->getAutoFailFatalScore($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents);
            $data['pr']         =   $this->getPassRate($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents);
            $data['esc']        =   $this->getEscalation($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents);
            $data['feed']       =   $this->getFeedback($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents);
            $data['rank']       =   $this->getArrtibuteRank($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents);
            if($post){
                echo postRequestResponse($data);die;
            }
            else{
                // $this->printData($data['rank']);die;
        	   $this->load->view('dashboard',$data);
            }
        }
        else{
        	$data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);
        }
    }

    public function getOverallQAScore($supervisor_id,$emp_condition_field,$between,$sup_lob,$agents=null){
        $data = [];
        if(!empty($agents)){
            $form_name = $this->getFormName($sup_lob);
            foreach ($form_name as $key1 => $value1) {
                $between[$emp_condition_field] = $agents;
                $total_data = $this->formData($value1->form_name,$between);
                foreach ($total_data as $key2 => $value2) {
                    if(!empty($value2->avg))
                        $data[] = $value2;
                }                
            }
        }else{
            $sup_agent  = $this->getsupervisorAgent($supervisor_id);
            foreach ($sup_agent as $key => $value) {
                $agent_lob = explode('|||', $value->lob);
                $form_name = $this->getFormName($agent_lob);
                foreach ($form_name as $key1 => $value1) {
                    $between[$emp_condition_field] = $value->empid;
                    $total_data = $this->formData($value1->form_name,$between);
                    foreach ($total_data as $key2 => $value2) {
                        if(!empty($value2->avg))
                            $data[] = $value2;
                    }                
                }
            }
        }
        //print_r($data);die;
        $col  = 'avg';
        $sort = array();
        foreach ($data as $i => $obj) {
            $sort[$i] = $obj->{$col};
        }
        array_multisort($sort, SORT_DESC, $data);
        return $data;
        //$this->printData($data);die;
        
        // $this->load->view('dashboard',$data);
    }

    public function getSectionWiseQAScore($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents=null){
        $data = [];
        $attribute = $this->common->getDistinctWhere('forms',['category'],['lob'=>$sup_lob]);
        if(!empty($attribute)){
            $form_name = $this->getFormName($sup_lob);
            foreach ($form_name as $key1 => $value1) {
                $cat_name = $this->getCatName($value1->form_name);
                if(!empty($cat_name)){
                    $user_evaluator_id = '';
                    foreach ($cat_name as $key2 => $value2) {
                        if(!empty($agents))
                            $where[$emp_condition_field] = $agents;
                        $section_data = $this->sectionData($value1->form_name,"avg({$value2->cat_id}) as cat_avg",$where);
                        // echo $this->db->last_query();die;
                        $data[] = [
                            'avg'=>sprintf('%0.2f', $section_data[0]->cat_avg),
                            'name'=>$value2->category,
                        ];
                    }
                }
            }
        }
        return $data;
        if(!empty($agents)){
            $form_name = $this->getFormName($sup_lob);
            foreach ($form_name as $key1 => $value1) {
                $cat_name = $this->getCatName($value1->form_name);
                if(!empty($cat_name)){
                    $user_evaluator_id = '';
                    foreach ($cat_name as $key2 => $value2) {
                        $where[$emp_condition_field] = $agents;
                        $section_data = $this->sectionData($value1->form_name,"avg({$value2->cat_id}) as cat_avg",$where);
                        $data[] = [
                            'avg'=>sprintf('%0.2f', $section_data[0]->cat_avg),
                            'name'=>$value2->category,
                        ];
                    }
                }
            }
        }
        else{
            $sup_agent      = $this->getsupervisorAgent($supervisor_id);
            $form_name = $this->getFormName($sup_lob);
            foreach ($form_name as $key1 => $value1) {
                $cat_name = $this->getCatName($value1->form_name);
                if(!empty($cat_name)){
                    $user_evaluator_id = '';
                    foreach ($cat_name as $key2 => $value2) {
                        $section_data = $this->sectionData($value1->form_name,"avg({$value2->cat_id}) as cat_avg",$where);
                        $data[] = [
                            'avg'=>sprintf('%0.2f', $section_data[0]->cat_avg),
                            'name'=>$value2->category,
                        ];
                    }
                }
            }
        }
        return $data;
    }
    public function getArrtibuteQAScore(){
        $data = [];
        $post = $this->input->post();
        $from_date      =   date('Y-m-d',strtotime ($post['audit_from']));
        $to_date        =   date('Y-m-d',strtotime ($post['audit_to']));
        $date_column    =   $post['date_column'];
        $sup_lob        =   $post['lob'];
        $campaign       =   $post['campaign'];
        $vendor         =   $post['vendor'];
        $location       =   $post['location'];
        $agents         =   $post['agents'];
        $where["date($date_column) >="] = $from_date;
        $where["date($date_column) <="] = $to_date;
        if(!empty($agents)){
            $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
            $where[$emp_condition_field] = $agents;
        }
        if($campaign){
            $where['campaign']  =  $campaign;
        }
        if($vendor){
            $where['vendor']    = $vendor;
        }
        if($location){
            $where['location']  = $location;
        }
        $getFormName = $this->getFormName($sup_lob);
        $formname = $getFormName[0]->form_name;
        $attribute = $this->common->getDistinctWhere('forms',['attribute','attr_id','weightage'],['category'=>$post['cat'],'lob'=>$sup_lob,'form_name'=>$formname]);
        foreach ($attribute as $key => $value) {
            $attr = explode("_", $value->attr_id);
            $attr_scote = $attr[0]."_score";
            $attr[$value->attr_id] = $this->common->getWhereSelectAll($formname,[
                'count(unique_id) as total_evulation',
                'count(case when (\'NA\' = '.$value->attr_id.' ) then 1 else null end) as na',
                'count(case when (\'YES\' = '.$value->attr_id.' ) then 1 else null end) as yes',
            ],$where);
            $total_evulation    = (int)$attr[$value->attr_id][0]->total_evulation;
            $total_na           = (int)$attr[$value->attr_id][0]->na;
            $total_yes          = (int)$attr[$value->attr_id][0]->yes;
            $attr_weightage     = (int)$value->weightage;
            if($total_evulation > 0)
                $final_score        = sprintf('%0.2f',((($total_yes - $total_na)*$attr_weightage)/(($total_evulation -$total_na )* $attr_weightage)*100));
            else
                $final_score  = sprintf('%0.2f',0);
            $data[] = ['avg' => $final_score,'name' => $value->attribute];
        }
        echo postRequestResponse($data);die;
    }
    public function getAutoFailFatalScore($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents=null){
        $data = [];
        if(!empty($agents)){
            $where[$emp_condition_field] = $agents;
        }
        $where['lob']           =   $sup_lob;
        $where['total_score']   =   0;
            $sup_agent      = $this->getsupervisorAgent($supervisor_id);
            $form_name = $this->getFormName($sup_lob);
            foreach ($form_name as $key1 => $value1) {
                $total_score_zero_count = $this->formDataTotalScoreisZero($value1->form_name,'count(total_score) as count',$where);
                $total_evulation_count  = $this->formDataTotalScoreisZero($value1->form_name,'count(unique_id) as unique_id',$where);
                if($total_evulation_count[0]->unique_id > 0){
                    $data = [
                        [
                            'category'  =>  'score',
                            'score'     =>  sprintf('%0.2f', (($total_score_zero_count[0]->count/$total_evulation_count[0]->unique_id)*100)),
                            'color'     =>  "#aa3690"
                        ],
                        [
                            'category'  =>  'Evalution',
                            'score'     =>  $total_evulation_count[0]->unique_id,
                            'color'     =>  "#ed6250"
                        ]
                    ];
                }
            }
        return $data;        
    }
    public function getPassRate($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents=null){
        $where['lob']   =   $sup_lob;
        $form_pass_rate = $this->getFormPassRate([$sup_lob]);
        $fn = $form_pass_rate[0]->form_name;
        $pr = $form_pass_rate[0]->pass_rate;
        $select =['count(unique_id) as total_evulation','count(case when (total_score > '.$pr.' ) then 1 else null end) as pass_rate'];
        $pass = $this->common->getWhereSelectAll($fn,$select,$where);
        // echo $this->db->last_query();die;
        $data = [
                    
                    [
                        'category'  =>  'Pass Rate',
                        'score'     =>  sprintf('%0.2f',($pass[0]->pass_rate/$pass[0]->total_evulation)*100),
                        'color'     =>  "#aa3690"
                    ],
                    [
                        'category'  =>  'Total Evulation',
                        'score'     =>  $pass[0]->total_evulation,
                        'color'     =>  "#ed6250"
                    ]
                ];
        return $data;
    }
    public function getEscalation($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents=null){
        $where['lob']   =   $sup_lob;
        $data = [];
        if(!empty($agents))
            $where[$emp_condition_field] = $agents;
        $form_pass_rate = $this->getFormPassRate([$sup_lob]);
        $fn = $form_pass_rate[0]->form_name;
        $select =['count(unique_id) as total_evulation','count(case when (esc_phase_id = 3 ) then 1 else null end) as pass_rate'];
        $pass = $this->common->getWhereSelectAll($fn,$select,$where);
        if($pass[0]->total_evulation > 0){
            $data = [
                        
                        [
                            'category'  =>  'Pass Rate',
                            'score'     =>  sprintf('%0.2f',($pass[0]->pass_rate/$pass[0]->total_evulation)*100),
                            'color'     =>  "#aa3690"
                        ],
                        [
                            'category'  =>  'Total Evulation',
                            'score'     =>  $pass[0]->total_evulation,
                            'color'     =>  "#ed6250"
                        ]
                    ];
        }
        return $data;
    }
    public function getArrtibuteRank($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents=null){
        $data = [];
        if(!empty($agents))
            $where[$emp_condition_field] = $agents;
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
                    WHEN att01_sel = "YES" 
                    THEN att01_score 
                    ELSE 0 
                END) AS sum_yes',
                'SUM(CASE 
                    WHEN att01_sel = "NA" 
                    THEN att01_score 
                    ELSE 0 
                END) AS sum_na'
            ],$where);
            $total_evulation    = (int)$attr[$value->attr_id][0]->total_evulation;
            $total_na           = (int)$attr[$value->attr_id][0]->sum_na;
            $total_yes          = (int)$attr[$value->attr_id][0]->sum_yes;
            $attr_weightage     = (int)$value->weightage;
            if($total_evulation > 0)
                $final_score    = sprintf('%0.2f',((($total_yes - $total_na))/(($total_evulation *$attr_weightage)-$total_na )*100));
            else
                $final_score  = sprintf('%0.2f',0);
            $data[] = ['avg' => $final_score,'name' => $value->attribute];
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
        return $data1['rank'];
    }
    public function getFeedback($supervisor_id,$emp_condition_field,$where,$sup_lob,$agents=null){
        $data = [];
        $where['lob']   =   $sup_lob;
        if(!empty($agents))
            $where[$emp_condition_field] = $agents;
        $form_pass_rate = $this->getFormPassRate([$sup_lob]);
        $fn = $form_pass_rate[0]->form_name;
        $select =['count(unique_id) as total_evulation','count(case when (feedback_com != "" ) then 1 else null end) as pass_rate'];
        $pass = $this->common->getWhereSelectAll($fn,$select,$where);
        //echo $this->db->last_query();die;
        if($pass[0]->total_evulation > 0){
            $data = [
                        
                        [
                            'category'  =>  'Pass Rate',
                            'score'     =>  sprintf('%0.2f',($pass[0]->pass_rate/$pass[0]->total_evulation)*100),
                            'color'     =>  "#aa3690"
                        ],
                        [
                            'category'  =>  'Total Evulation',
                            'score'     =>  $pass[0]->total_evulation,
                            'color'     =>  "#ed6250"
                        ]
                    ];
        }
        return $data;
    }

    public function getFormName($lob){
        return $this->common->getWhereInSelectAll('forms_details','form_name','lob',$lob);
    }
    public function getFormPassRate($lob){
        return $this->common->getWhereInSelectAll('forms_details',['form_name','pass_rate'],'lob',$lob);
    }
    public function getCatName($form_name){
        return $this->common->getWhereInSelectAll('forms',['category','cat_id'],'form_name',$form_name);
    }
    public function getsupervisorAgent($sup_id){
        return $this->common->getDistinctWhere('user',['empid','lob'],['sup_id'=>$sup_id]);
    }
    public function formData($formName,$between){
        return $this->common->getWhereSelectAll($formName,['count(total_score) as count','ROUND(avg(total_score), 2) as avg','evaluator_name'],$between);       
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

    public function printData($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

//please write above	
}
