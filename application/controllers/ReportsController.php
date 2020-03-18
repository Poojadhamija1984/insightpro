<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportsController extends MY_Controller {
	

	public function index()
	{
        $this->load->view('reports/agent_qa_performance_view');
    }
    
    public function agent_qa_performance()
	{
	    $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agents 	    = $this->input->post('agents');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
    
        $addqury_data = [];
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
        
        if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));
            
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$login_user_lob,'form_name');
            
            //$reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob','form_version'],['client_id'=>$this->client_id]);
             //$reasult_form_name =$this->common->getDistinctWhereSelectOderby('forms_details',['form_name','lob','form_version'],['client_id'=>$this->client_id],'form_version','DESC');
        }else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name'],['client_id'=>$this->client_id,'lob'=>$lob]);
            //$reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob','form_version'],['client_id'=>$this->client_id,'lob'=>$lob]);
            $addqury_data['lob']=$lob;
        }
        // echo '<pre>';
        //  print_r($reasult_form_name);die;
        $reasult_agents = array();
        if($agents =='')
        {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['client_id'=>$this->client_id,'sup_id'=>$this->session->userdata('empid'),'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id = "'".$reasult_agents[0]->empid."'";
            
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        else {
            $reasult_agents  = $this->common->getDistinctWhere('user','empid,name,sup_id,sup_name',['client_id'=>$this->client_id,'empid'=>$agents,'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id =  "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        // echo '<pre>';
        // print_r($reasult_agents);die;
        // $reasult_form_audit  = $this->common->getWhereSelectAllFromTo('form_qa',['unique_id','evaluator_id','lob','campaign','location','vendor','agent_name','agent_id','supervisor','total_score','submit_time'],$addqury_data,$date_column,$audit_from,$audit_to);
        // print_r($reasult_form_audit);
        // echo $this->db->last_query();
        // echo '</pre>';die;
       // $this->print_result($reasult_agents);die;
        $table_data=[];
        foreach($reasult_form_name as $key => $eachform_name)
        {
            //$addqury_data['lob']= ($lob != 'all')? $lob: $eachform_name['lob'];
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'unique_id,evaluator_id,evaluator_name,lob,campaign,location,vendor,agent_name,agent_id,supervisor,form_version,total_score,submit_time',$addqury_data,$date_column,$audit_from,$audit_to);
            //echo postRequestResponse( $this->db->last_query());  die;
            //echo  $this->db->last_query();//die;
            foreach($reasult_form_audit as $key => $each_form_audit)
            {
               //if (array_key_exists($each_form_audit->agent_id,$table_data))
               $emp_condition_name     = (($this->emp_group == 'ops')?'evaluator_name':'agent_name');
               if (array_key_exists($each_form_audit->$emp_condition_field,$table_data))
                {
                   $table_data[$each_form_audit->$emp_condition_field]['total_evaluation'] = $table_data[$each_form_audit->$emp_condition_field]['total_evaluation'] + 1;
                   $table_data[$each_form_audit->$emp_condition_field]['totalfatel_count'] = ($each_form_audit->total_score == 0) ? $table_data[$each_form_audit->$emp_condition_field]['totalfatel_count'] + 1:$table_data[$each_form_audit->$emp_condition_field]['totalfatel_count'];
                   $table_data[$each_form_audit->$emp_condition_field]['totalScore_count'] = $table_data[$each_form_audit->$emp_condition_field]['totalScore_count'] + (float)$each_form_audit->total_score;
                   $table_data[$each_form_audit->$emp_condition_field]['qa_score'] = ($table_data[$each_form_audit->$emp_condition_field]['totalScore_count']  >0)?($table_data[$each_form_audit->$emp_condition_field]['totalScore_count'] / $table_data[$each_form_audit->$emp_condition_field]['total_evaluation']):0.0;
                }
                else
                {
                   $table_data[$each_form_audit->$emp_condition_field]['form_version'] = $each_form_audit->form_version;
                   $table_data[$each_form_audit->$emp_condition_field]['$emp_condition_field'] = $each_form_audit->$emp_condition_field;
                   $table_data[$each_form_audit->$emp_condition_field]['agent_id'] = $each_form_audit->$emp_condition_field;
                   $table_data[$each_form_audit->$emp_condition_field]['agent_name'] = $each_form_audit->$emp_condition_name;
                   $table_data[$each_form_audit->$emp_condition_field]['supervisor'] = $each_form_audit->supervisor;
                   $table_data[$each_form_audit->$emp_condition_field]['vendor'] = $each_form_audit->vendor;
                   $table_data[$each_form_audit->$emp_condition_field]['location'] = $each_form_audit->location;
                   $table_data[$each_form_audit->$emp_condition_field]['campaign'] = $each_form_audit->campaign;
                   $table_data[$each_form_audit->$emp_condition_field]['lob'] = $each_form_audit->lob;
                   $table_data[$each_form_audit->$emp_condition_field]['total_evaluation'] = 1;
                   $table_data[$each_form_audit->$emp_condition_field]['totalfatel_count'] = ($each_form_audit->total_score == 0) ? 1:0;
                   $table_data[$each_form_audit->$emp_condition_field]['qa_score'] = ($each_form_audit->total_score >0)?($each_form_audit->total_score / 1):0.0;
                   $table_data[$each_form_audit->$emp_condition_field]['totalScore_count'] = ($each_form_audit->total_score >0)?$each_form_audit->total_score :0.0;
                }
            }
        }
        //$this->print_result($table_data);die;
        usort($table_data, function ($item1, $item2) {
            return $item2['qa_score'] <=> $item1['qa_score'];
        });
        
        echo postRequestResponse($table_data);  
    }

    public function agent_qa_performance_list()
	{
        $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agent_id 	    = $this->input->post('agent_id');
        $agents 	    = $this->input->post('agents');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
    
        if(!empty($agents) && $agents !='null'){
            $addqury_data[$emp_condition_field] = $agents;
        //     if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 2)
        //    {
        //        $addqury_data['evaluator_id'] = $agents;
        //    }
        //    if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 3)
        //    {
        //        $addqury_data['agent_id'] = $agents;
        //    }
        }
        if(!empty($agent_id) && $agent_id !='null'){
            //$addqury_data['agent_id']=$agent_id;
            $addqury_data[$emp_condition_field]=$agent_id;
        }
        if(!empty($lob) && $lob !='null'){
            $addqury_data['lob']=$lob;
        }
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }

        $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob'],['client_id'=>$this->client_id,'lob'=>$lob]);
        $table_data=[];
        $emp_condition_name     = (($this->emp_group == 'ops')?'evaluator_name':'agent_name');
        foreach($reasult_form_name as $key => $eachform_name)
        {
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'unique_id,evaluator_id,evaluator_name,lob,campaign,location,vendor,agent_name,agent_id,supervisor,total_score,submit_time',$addqury_data,$date_column,$audit_from,$audit_to);
            //$data['query'][]= $this->db->last_query();
            foreach($reasult_form_audit as $key => $each_form_audit)
            {
                $table_data[$key]['unique_id'] = $each_form_audit->unique_id;
                $table_data[$key]['agent_id'] = $each_form_audit->$emp_condition_field;
                $table_data[$key]['agent_name'] = $each_form_audit->$emp_condition_name;
                $table_data[$key]['supervisor'] = $each_form_audit->supervisor;
                $table_data[$key]['vendor'] = $each_form_audit->vendor;
                $table_data[$key]['location'] = $each_form_audit->location;
                $table_data[$key]['campaign'] = $each_form_audit->campaign;
                $table_data[$key]['lob'] = $each_form_audit->lob;
                $table_data[$key]['total_score'] = $each_form_audit->total_score;
                $table_data[$key]['form_name'] = $eachform_name['form_name'];
                   
            }
        }
        //echo postRequestResponse($this->db->last_query());die;
        echo postRequestResponse($table_data);
    }

    public function scorecard_performance_index()
	{
        //$data['title']          = 'Reports';
       // $data['title2']         = 'Scorecard-Performance';
       // $data['title2']         = $this->uri->segment(1);
       // $data['channels']       = $this->common->getSelectAll('forms_details','channels');
       // $data['lob']	        = $this->common->getDistinctWhere('hierarchy','lob',['client_id'=>$this->client_id]);
       // $data['channels']       = $this->common->getSelectAll('forms_details','channels');
       // $this->load->view('reports/scorecard_performance_view' , $data);
        $this->load->view('reports/scorecard_performance_view');
    }
    public function scorecard_performance_report()
	{
	    $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $form_version 	= $this->input->post('form_version');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
	    $form_category 	= $this->input->post('form_category');
	    $form_attributes= $this->input->post('form_attributes');
        $agents 	    = $this->input->post('agents');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
    
        if(!empty($campaign)){
            $addqury_data['campaign']=$campaign;
        }
        
        if(!empty($location)){
            $addqury_data['location']=$location;
        }

        $addqury_data2 = [];
        if(!empty($form_category)){
            $addqury_data2['category']= $form_category;
        }
        if(!empty($form_attributes)){
            $addqury_data2['attr_id']= $form_attributes;
        }
       
       // $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob','form_version'],['client_id'=>$this->client_id,'lob'=>$lob]);
        //$reasult_form_name =$this->common->getDistinctWhereSelectOderby('forms_details',['form_name','lob','form_version'],['lob'=>$lob,'form_version'=>$form_version],'form_version','DESC');
        $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob','form_version'],['lob'=>$lob,'form_version'=>$form_version]);
       //echo postRequestResponse($this->db->last_query()); die;
        // $this->db->last_query();
        $reasult_agents = array();
        if($agents =='')
        {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['sup_id'=>$this->session->userdata('empid'),'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id = "'".$reasult_agents[0]->empid."'";
            
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        else {
            $reasult_agents  = $this->common->getDistinctWhere('user','empid,name,sup_id,sup_name',['empid'=>$agents,'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id =  "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        //echo postRequestResponse($this->db->last_query()); die;
        
        $addqury_data2['lob'] = $reasult_form_name[0]['lob'];   
        $addqury_data2['form_name'] = $reasult_form_name[0]['form_name'];   
        $addqury_data2['form_version'] = $reasult_form_name[0]['form_version'];
        $result_forms_info = $this->common->getDistinctWhereSelect('forms',['category','attribute','attr_id','form_name','rating','rating_attr_name'],
        $addqury_data2);
        // echo postRequestResponse($this->db->last_query()); die;
        if(!empty($vendor) && $vendor !='null'){
            //$addqury_data['vendor']=$vendor;
            $result_vendor_location     = $this->common->getDistinctWhereSelect($reasult_form_name[0]['form_name'],['vendor','location'],['lob'=>$reasult_form_name[0]['lob'],'vendor'=>$vendor,'form_version'=>$reasult_form_name[0]['form_version']]);
            //$result_vendor_location     = $this->common->getDistinctWhereSelect($reasult_form_name[0]['form_name'],['vendor','location'],['lob'=>$reasult_form_name[0]['lob'],'form_version'=>$reasult_form_name[0]['form_version'],'vendor'=>$vendor]);
        }
        else{
            $result_vendor_location     = $this->common->getDistinctWhereSelect($reasult_form_name[0]['form_name'],['vendor','location'],['lob'=>$reasult_form_name[0]['lob'],'form_version'=>$reasult_form_name[0]['form_version']]);
            //$result_vendor_location     = $this->common->getDistinctWhereSelect($reasult_form_name[0]['form_name'],['vendor','location'],['lob'=>$reasult_form_name[0]['lob'],'form_version'=>$reasult_form_name[0]['form_version']]);
           // $addqury_data['vendor']=$vendor;
        }   
      
        $table_data = [];$flag_att_heading = 0;$flag_cat = ''; $flag_no_data = 0;
        ////////////////////////////////////////////////////////////NNNNNNNNNNNNNNNNNNNNNNN
        $table ='<div class="lob-category-card">
            <span>LOB</span>
            <span>'.$lob.'</span>
        </div>
        <ul class="attributes-list">';
        $data_target_flag = 1;
        $result_forms_category_info = $this->common->getDistinctWhereSelect('forms',['category'],$addqury_data2);
         foreach($result_forms_category_info as $key => $each_forms_info){
            $table .='<li class="'.($data_target_flag == 1?"active":"").'" title="'.$each_forms_info['category'].'" data-target="data_target_'.$data_target_flag++.'">'.$each_forms_info['category'].'</li>';
         }
        $table .=' <li class="all" title="Process All" data-target="all">All</li>
        </ul>';
       
        $data_target_flag = 1;$flag_cat = '';
        //$first_cat=$each_forms_info[0]['category'];

        $old_cat='';
           
        foreach($result_forms_info as $key => $each_forms_info){
        $rating_attr      = explode('|',$each_forms_info['rating']);
        $rating_attr_name = !empty($each_forms_info['rating_attr_name'])?explode('|',$each_forms_info['rating_attr_name']):explode('|',$each_forms_info['rating']);  
        $att_id = current(explode('_',$each_forms_info['attr_id'])); 
        $cat_new=$each_forms_info['category'];
        if($old_cat!='' && $cat_new!=$old_cat){
            $table.='</ul></div></div>';
        }
        
                                    
        if( $cat_new!=$old_cat){

            $table .='<div class="card attributes-card" style="display:'.($data_target_flag == 1?"block":"none").';" data-ref="data_target_'.$data_target_flag++.'" >
            <div class="card-content">';
            $table .='<h4 class="card-title">'.$each_forms_info['category'].'</h4><ul class="collapsible cat-collapsible">';
                $table .='<li>
                <div class="collapsible-header">'.$each_forms_info['attribute'].'</div>
                <div class="collapsible-body table-section">
                    <table class="attr_dtable stripe hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Vendor</th>
                                <th>Location</th>
                                <th>Total Evaluation</th>
                                <th>Applicability</th>
                                <th>Score</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>';
                        ////////////////////////////////
                        foreach ($result_vendor_location as $key => $each_vendor) {
                            // $this->print_result($each_vendor);
                            $addqury_data['vendor']=$each_vendor['vendor'];
                            $addqury_data['location']=$each_vendor['location'];
                            $addqury_data['form_version']=$reasult_form_name[0]['form_version'];
                            

                            $reasult_total_audit  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count(total_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                            //echo postRequestResponse($this->db->last_query()); die;
                            $addqury_data[$att_id.'_sel !=']='NA';
                            //echo postRequestResponse($this->db->last_query()); die;
                            $reasult_count_audit_not_NA  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count(total_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                            $reasult_sum_audit_weightage_not_NA  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'sum('.$att_id.'_score) as sum',$addqury_data,$date_column,$audit_from,$audit_to);
                            unset($addqury_data[$att_id.'_sel !=']);
                            $addqury_data[$att_id.'_sel']='YES';
                            $reasult_count_audit_yes  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count,'.$att_id.'_score as att_score',$addqury_data,$date_column,$audit_from,$audit_to);
                            //echo postRequestResponse($this->db->last_query()); die;
                            unset($addqury_data[$att_id.'_sel']);
                            $addqury_data[$att_id.'_sel']='NO';
                            $reasult_count_audit_NO  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                            unset($addqury_data[$att_id.'_sel']);

                            $addqury_data[$att_id.'_sel']='FATAL';
                            $reasult_count_audit_FATAL  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                            unset($addqury_data[$att_id.'_sel']);

                            $addqury_data[$att_id.'_sel']='NA';
                            $reasult_count_audit_NA  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                            unset($addqury_data[$att_id.'_sel']);
                            // ((($reasult_sum_audit_weightage_not_NA[0]->sum)/((($reasult_count_audit_yes[0]->count)+($reasult_count_audit_NO[0]->count))*($reasult_count_audit_yes[0]->att_score)))*100)
                            $divideTo = ($reasult_sum_audit_weightage_not_NA[0]->sum) > 0 ? ($reasult_sum_audit_weightage_not_NA[0]->sum) : 1;
                            $divideFrom = ((((int)$reasult_count_audit_yes[0]->count)+((int)$reasult_count_audit_NO[0]->count))*((int)$reasult_count_audit_yes[0]->att_score)) > 0 ? ((((int)$reasult_count_audit_yes[0]->count)+((int)$reasult_count_audit_NO[0]->count))*((int)$reasult_count_audit_yes[0]->att_score)) : 1;
                            $total_score = (double)(($divideTo/$divideFrom)*100);
                            $flag_no_data = $reasult_total_audit[0]->count;
                            $table .='
                            <tr>
                                <td>'.$each_vendor['vendor'].'</td>
                                <td>'.$each_vendor['location'].'</td>
                                <td>'.$reasult_total_audit[0]->count.'</td>
                                <td>'.($reasult_total_audit[0]->count > 0 ? round((($reasult_count_audit_not_NA[0]->count/$reasult_total_audit[0]->count)*100), 2) : 0).'%</td>
                                <td>'.round($total_score, 2).'%</td>
                                <td>';
                                foreach($rating_attr_name as $keys => $each_option)
                                {
                                    if($rating_attr[$keys] == 'YES'){
                                        $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_yes[0]->count).')</span></a>';
                                    }
                                    else if($rating_attr[$keys] == 'NO'){
                                        $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_NO[0]->count).')</span></a>';
                                        
                                    }
                                    else if($rating_attr[$keys] == 'FATAL'){
                                        $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_FATAL[0]->count).')</span></a>';
                                    }
                                    else if($rating_attr[$keys] == 'NA'){
                                        $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_NA[0]->count).')</span></a>';
                                    }
                                    /////////////////////////////////////////////////////////////////
                                }

                             $table .=' </td>
                            </tr>';
                        }
                $table .='</tbody></table></div></li>';
                $old_cat=$cat_new;
            }
            else{
                $table .='<li>
                    <div class="collapsible-header">'.$each_forms_info['attribute'].'</div>
                        <div class="collapsible-body table-section">
                            <table class="attr_dtable stripe hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Location</th>
                                        <th>Total Evaluation</th>
                                        <th>Applicability</th>
                                        <th>Score</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                            <tbody>';
                            ////////////////////////////////
                            foreach ($result_vendor_location as $key => $each_vendor) {
                                // $this->print_result($each_vendor);
                                $addqury_data['vendor']=$each_vendor['vendor'];
                                $addqury_data['location']=$each_vendor['location'];
                                $addqury_data['form_version']=$reasult_form_name[0]['form_version'];
                                

                                $reasult_total_audit  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count(total_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                                //echo postRequestResponse($this->db->last_query()); die;
                                $addqury_data[$att_id.'_sel !=']='NA';
                                //echo postRequestResponse($this->db->last_query()); die;
                                $reasult_count_audit_not_NA  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count(total_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                                $reasult_sum_audit_weightage_not_NA  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'sum('.$att_id.'_score) as sum',$addqury_data,$date_column,$audit_from,$audit_to);
                                unset($addqury_data[$att_id.'_sel !=']);
                                $addqury_data[$att_id.'_sel']='YES';
                                $reasult_count_audit_yes  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count,'.$att_id.'_score as att_score',$addqury_data,$date_column,$audit_from,$audit_to);
                                //echo postRequestResponse($this->db->last_query()); die;
                                unset($addqury_data[$att_id.'_sel']);
                                $addqury_data[$att_id.'_sel']='NO';
                                $reasult_count_audit_NO  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                                unset($addqury_data[$att_id.'_sel']);

                                $addqury_data[$att_id.'_sel']='FATAL';
                                $reasult_count_audit_FATAL  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                                unset($addqury_data[$att_id.'_sel']);

                                $addqury_data[$att_id.'_sel']='NA';
                                $reasult_count_audit_NA  = $this->common->getWhereSelectAllFromTo($reasult_form_name[0]['form_name'],'count('.$att_id.'_score) as count',$addqury_data,$date_column,$audit_from,$audit_to);
                                unset($addqury_data[$att_id.'_sel']);
                                // ((($reasult_sum_audit_weightage_not_NA[0]->sum)/((($reasult_count_audit_yes[0]->count)+($reasult_count_audit_NO[0]->count))*($reasult_count_audit_yes[0]->att_score)))*100)
                                $divideTo = ($reasult_sum_audit_weightage_not_NA[0]->sum) > 0 ? ($reasult_sum_audit_weightage_not_NA[0]->sum) : 1;
                                $divideFrom = ((((int)$reasult_count_audit_yes[0]->count)+((int)$reasult_count_audit_NO[0]->count))*((int)$reasult_count_audit_yes[0]->att_score)) > 0 ? ((((int)$reasult_count_audit_yes[0]->count)+((int)$reasult_count_audit_NO[0]->count))*((int)$reasult_count_audit_yes[0]->att_score)) : 1;
                                $total_score = (double)(($divideTo/$divideFrom)*100);
                                $flag_no_data = $reasult_total_audit[0]->count;
                                $table .='
                                <tr>
                                    <td>'.$each_vendor['vendor'].'</td>
                                    <td>'.$each_vendor['location'].'</td>
                                    <td>'.$reasult_total_audit[0]->count.'</td>
                                    <td>'.($reasult_total_audit[0]->count > 0 ? round((($reasult_count_audit_not_NA[0]->count/$reasult_total_audit[0]->count)*100), 2) : 0).'%</td>
                                    <td>'.round($total_score, 2).'%</td>
                                    <td>';
                                    foreach($rating_attr_name as $keys => $each_option)
                                    {
                                        if($rating_attr[$keys] == 'YES'){
                                            $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_yes[0]->count).')</span></a>';
                                        }
                                        else if($rating_attr[$keys] == 'NO'){
                                            $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_NO[0]->count).')</span></a>';
                                            
                                        }
                                        else if($rating_attr[$keys] == 'FATAL'){
                                            $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_FATAL[0]->count).')</span></a>';
                                        }
                                        else if($rating_attr[$keys] == 'NA'){
                                            $table .='<a href="javascript:void(0)" onclick="data_list(`'.$reasult_form_name[0]['form_name'].'`,`'.$each_forms_info['attr_id'].'`,`'.$rating_attr[$keys].'`,`'.$each_vendor['vendor'].'`,`'.$each_vendor['location'].'`)"><span>'.$each_option.' ('.((int)$reasult_count_audit_NA[0]->count).')</span></a>';
                                        }
                                        /////////////////////////////////////////////////////////////////
                                    }
                                    $table .='</td>
                                </tr>';
                            }
                            ////////////////////////////////
                $table .='</tbody></table></div></li>';
            }
        }     

        ////////////////////////////////////////////////////////////
        if($flag_no_data == 0)
        {
            $table = '<p class="center"> No Data Found </p>';
        }
        // echo $table **************************************************************************************;
        // $this->load->view('reports/scorecard_performance_view' , $data);
        $table .= "<script>
        $(document).ready(function(){
            $('.cat-collapsible').collapsible()
            
        });
        </script>";
        echo postRequestResponse($table);  
    }
    
    public function scorecard_performance_report_list()
	{
        $audit_from 	    = $this->input->post('audit_from');
	    $audit_to 	        = $this->input->post('audit_to');
	    $date_column 	    = $this->input->post('date_column');
	    $lob 	            = $this->input->post('lob');
	    $campaign 	        = $this->input->post('campaign');
	    $vendor 	        = $this->input->post('vendor');
	    $location 	        = $this->input->post('location');
        $agent_id 	        = $this->input->post('agent_id');
        $form_name 	        = $this->input->post('form_name');
        $form_version 	    = $this->input->post('form_version');
        
        // $form_attributes 	= $this->input->post('form_attributes');
        // $form_category 	    = $this->input->post('form_category');

        $attr_name 	        = $this->input->post('attr_name');
        $attr_value 	    = $this->input->post('attr_value');

        $form_attributes 	= $this->input->post('form_attributes');
        $emp_condition_field = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');

        if(!empty($agent_id) && $agent_id !='null'){  $addqury_data['agent_id']=$agent_id;}
        if(!empty($lob) && $lob !='null'){  $addqury_data['lob']=$lob; }
        if(!empty($campaign) && $campaign !='null'){ $addqury_data['campaign']=$campaign;}
        if(!empty($vendor) && $vendor !='null'){ $addqury_data['vendor']=$vendor;}
        if(!empty($location) && $location !='null'){ $addqury_data['location']=$location;}
        if(!empty($form_version) && $form_version !='null'){ $addqury_data['form_version']=$form_version;}
        if(!empty($attr_name) && $attr_name !='null'){ $addqury_data[$attr_name]=$attr_value;}

        $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($form_name,'unique_id,lob,campaign,location,vendor,
        agent_name,agent_id,supervisor,total_score,submit_time',$addqury_data,$date_column,$audit_from,$audit_to);
        //echo postRequestResponse($this->db->last_query());die;
        $table_data=[];
        foreach($reasult_form_audit as $key => $each_form_audit)
        {
            $table_data[$key]['unique_id'] = $each_form_audit->unique_id;
            $table_data[$key]['agent_id'] = $each_form_audit->agent_id;
            $table_data[$key]['agent_name'] = $each_form_audit->agent_name;
            $table_data[$key]['supervisor'] = $each_form_audit->supervisor;
            $table_data[$key]['vendor'] = $each_form_audit->vendor;
            $table_data[$key]['location'] = $each_form_audit->location;
            $table_data[$key]['campaign'] = $each_form_audit->campaign;
            $table_data[$key]['lob'] = $each_form_audit->lob;
            $table_data[$key]['total_score'] = $each_form_audit->total_score;
            $table_data[$key]['form_name'] = $form_name;
            $table_data[$key]['form_version'] = $form_version;
                
        }
        echo postRequestResponse($table_data);
    }

    public function fatal_index()
	{
        //$data['title']          = 'Reports';
        // $data['title2']         = 'Agent QA Performance';
        //$data['title2']         = $this->uri->segment(1);
        // $data['channels']       = $this->common->getSelectAll('forms_details','channels');
        // $data['lob']	        = $this->common->getDistinctWhere('hierarchy','lob',['client_id'=>$this->client_id]);
        // $data['agents']	        = $this->common->getDistinctWhere('user','empid,name',['client_id'=>$this->client_id,'sup_id'=>$this->session->userdata('empid'),'is_admin'=>2,'usertype'=>2,'status'=>'1']);
		//$this->load->view('reports/fatal_report_view.' , $data);
		$this->load->view('reports/fatal_report_view.');
    }

    public function fatal_report()
	{
	    $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agents 	    = $this->input->post('agents');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
    
        
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
       
        if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$login_user_lob,'form_name');
            // $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob','form_version'],['client_id'=>$this->client_id]);
            //$reasult_form_name =$this->common->getDistinctWhereSelectOderby('forms_details',['form_name','lob','form_version'],['client_id'=>$this->client_id],'form_version','DESC');
        }else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name'],['client_id'=>$this->client_id,'lob'=>$lob]);
            $addqury_data['lob']=$lob;
        }
        $reasult_agents = array();
        if($agents =='')
        {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['client_id'=>$this->client_id,'sup_id'=>$this->session->userdata('empid'),'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id = "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        else {
            $reasult_agents  = $this->common->getDistinctWhere('user','empid,name,sup_id,sup_name',['client_id'=>$this->client_id,'empid'=>$agents,'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id =  "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        $table_data=[];
        foreach($reasult_form_name as $key => $eachform_name)
        {
           // $addqury_data['lob']= ($lob != 'all')? $lob: $eachform_name['lob'];
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'unique_id,evaluator_id,lob,campaign,location,vendor,agent_name,agent_id,supervisor,form_version,total_score,submit_time',$addqury_data,$date_column,$audit_from,$audit_to);
            // echo '<pre>';
            // echo $this->db->last_query();
            // print_r($reasult_form_audit);die;
            foreach($reasult_form_audit as $key => $each_form_audit)
            {
               if (array_key_exists($each_form_audit->agent_id,$table_data))
                {
                   $table_data[$each_form_audit->agent_id]['total_evaluation'] = $table_data[$each_form_audit->agent_id]['total_evaluation'] + 1;
                   $table_data[$each_form_audit->agent_id]['totalfatel_count'] = ($each_form_audit->total_score == 0) ? $table_data[$each_form_audit->agent_id]['totalfatel_count'] + 1:$table_data[$each_form_audit->agent_id]['totalfatel_count'];
                   $table_data[$each_form_audit->agent_id]['totalScore_count'] = $table_data[$each_form_audit->agent_id]['totalScore_count'] + (float)$each_form_audit->total_score;
                   $table_data[$each_form_audit->agent_id]['qa_score'] = ($table_data[$each_form_audit->agent_id]['totalScore_count']  >0)?($table_data[$each_form_audit->agent_id]['totalScore_count'] / $table_data[$each_form_audit->agent_id]['total_evaluation']):0.0;
                }
                else
                {
                   $table_data[$each_form_audit->agent_id]['form_version'] = $each_form_audit->form_version;
                   $table_data[$each_form_audit->agent_id]['agent_id'] = $each_form_audit->agent_id;
                   $table_data[$each_form_audit->agent_id]['agent_name'] = $each_form_audit->agent_name;
                   $table_data[$each_form_audit->agent_id]['supervisor'] = $each_form_audit->supervisor;
                   $table_data[$each_form_audit->agent_id]['vendor'] = $each_form_audit->vendor;
                   $table_data[$each_form_audit->agent_id]['location'] = $each_form_audit->location;
                   $table_data[$each_form_audit->agent_id]['campaign'] = $each_form_audit->campaign;
                   $table_data[$each_form_audit->agent_id]['lob'] = $each_form_audit->lob;
                   $table_data[$each_form_audit->agent_id]['total_evaluation'] = 1;
                   $table_data[$each_form_audit->agent_id]['totalfatel_count'] = ($each_form_audit->total_score == 0) ? 1:0;
                   $table_data[$each_form_audit->agent_id]['qa_score'] = ($each_form_audit->total_score >0)?($each_form_audit->total_score / 1):0.0;
                   $table_data[$each_form_audit->agent_id]['totalScore_count'] = ($each_form_audit->total_score >0)?$each_form_audit->total_score :0.0;
                }
            }
        }
        //$this->print_result($table_data);die;
        usort($table_data, function ($item1, $item2) {
            return $item2['qa_score'] <=> $item1['qa_score'];
        });
        
        echo postRequestResponse($table_data);  
    }

    public function autofail_index()
	{
		$this->load->view('reports/autofail_report_view');
    }
    public function autofail_audit_summary()
	{
        //echo "Hiiii";die;
	    $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agents 	    = $this->input->post('agents');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
   
        
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
       
        if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$login_user_lob,'form_name');
        }else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name'],['client_id'=>$this->client_id,'lob'=>$lob]);
            $addqury_data['lob']=$lob;
        }
        
        $reasult_agents = array();
        if($agents =='')
        {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['client_id'=>$this->client_id,'sup_id'=>$this->session->userdata('empid'),'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id = "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        else {
            $reasult_agents  = $this->common->getDistinctWhere('user','empid,name,sup_id,sup_name',['client_id'=>$this->client_id,'empid'=>$agents,'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id =  "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        $table_data=[];
        $table_data['total_audit'] = 0;
        $table_data['total_audit_score_sum'] = 0;
        $table_data['total_autofail'] = 0;
        $table_data['pre_fatal_score_sum'] = 0;
        $table_data['total_fatal_attr'] = 0;
        
        foreach($reasult_form_name as $key => $eachform_name)
        {
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'',$addqury_data,$date_column,$audit_from,$audit_to);
             ///print_r($reasult_form_audit);die;
            foreach($reasult_form_audit as $key => $each_form_audit){
                $table_data['total_audit'] = (int)$table_data['total_audit']+1;
                $table_data['total_audit_score_sum'] = (int)$table_data['total_audit_score_sum'] + (int)$each_form_audit->total_score;
                if($each_form_audit->total_score == 0){
                    $table_data['total_autofail'] = (int)$table_data['total_autofail']+1;
                    $table_data['pre_fatal_score_sum'] = (int)$table_data['pre_fatal_score_sum'] + (int)$each_form_audit->pre_fatal_score;
                    foreach($each_form_audit as $each_attr){
                        if($each_attr == 'FATAL'){
                            $table_data['total_fatal_attr'] = (int)$table_data['total_fatal_attr']+1;
                        }
                    }
                } 
            }
        }
        //echo postRequestResponse($table_data['total_audit_score_sum']);die;
        if($table_data['total_audit']>0){
            $table ='<table class="table hierarchy_table" id="" style="width:100%"><tbody><thead>
                <tr>
                    <th>Calls Evaluated</th>    <th>'.$table_data['total_audit'].'</th>
                    <th>Evaluations Score Average</th>   
                    <th>';
                    $table_data['total_audit'] > 0 ? $result = round(($table_data['total_audit_score_sum']/$table_data['total_audit']),2) : $result = 0; // handel here divied by zero
                    //$result = $table_data['total_audit'];
                    $table .= $result.' % </th>
                </tr>
                <tr>
                    <th>Auto Failed Evaluations</th>    <th>'.$table_data['total_autofail'].'</th>
                    <th>Score Pre Auto Fail </th>
                    <th>';
                    $table_data['total_autofail'] > 0 ? $result = round($table_data['pre_fatal_score_sum']/$table_data['total_autofail'],2) : $result = 0; // handel here divied by zero
                    $table .= $result.' % </th>   
                </tr>
                <tr>
                    <th>Auto Failed Attributes</th> <th>'.($table_data['total_fatal_attr']/2).'</th>
                    <th>Auto Fail Rate</th>
                    <th>';
                    $table_data['total_autofail'] > 0 ? $avg_pre_fatal_score = $table_data['pre_fatal_score_sum']/$table_data['total_autofail'] : $avg_pre_fatal_score =0;
                    $table_data['total_audit']    > 0 ? $avg_total_audit_score = $table_data['total_audit_score_sum']/$table_data['total_audit'] : $avg_total_audit_score =0;
                    $avg_total_audit_score        > 0 ? $result = round(( $avg_pre_fatal_score /$avg_total_audit_score ),2) : $result = 0;
                     
                    //round((($table_data['pre_fatal_score_sum']/$table_data['total_autofail']) / ($table_data['total_audit_score_sum']/$table_data['total_audit'])),2).
                    $table .= $result.' % </th>
                </tr>
            </thead></tbody></table>';
        }
        else{
                $table ='<table class="table hierarchy_table" id="" style="width:100%"><tbody><thead>
                <tr>
                    <th>Calls Evaluated</th>    <th>0</th>
                    <th>Evaluations Score Average</th>   <th>0%</th>
                </tr>
                <tr>
                    <th>Auto Failed Evaluations</th>    <th>0</th>
                    <th>Score Pre Auto Fail </th>   <th>0%</th>
                </tr>
                <tr>
                    <th>Auto Failed Attributes</th> <th>0</th>
                    <th>Auto Fail Rate</th>
                    <th>0 % </th>
                </tr>
            </thead></tbody></table>';

        }
        //echo $table;die;
        echo postRequestResponse($table);  
    }

    public function autofail_attrubutes_summary()
	{
        //echo "hi";die;
	    $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column'); //date column
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agents 	    = !empty($this->input->post('agents'))?$this->input->post('agents'):'';
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
   
        $addqury_data = [];
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
       //$this->printData($this->session->userdata('lob'));die;
        if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));
            //$this->printData($login_user_lob);die;
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name','lob'],'lob',$login_user_lob,'form_name');
            //echo $this->db->last_query();die;
        }else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob'],['lob'=>$lob]);
            $addqury_data['lob']=$lob;
        }
        // echo $this->db->last_query();die;
        $reasult_agents = array();
        if($agents =='')
        {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['sup_id'=>$this->session->userdata('empid'),'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id = "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        else {
            $reasult_agents  = $this->common->getDistinctWhere('user','empid,name,sup_id,sup_name',['empid'=>$agents,'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id =  "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        //echo $this->db->last_query();die;
        $table_data=[];
       $table ='<table class="table hierarchy_table" id="" style="width:100%"><tbody><thead><tr><th>Attribute</th> <th>No of Fails</th><th>Lob</th> </tr>';
      
       foreach($reasult_form_name as $key => $eachform_name)
        {
            //$this->printData($eachform_name);die;
            //echo postRequestResponse($this->db->last_query());die; 
         //echo postRequestResponse($eachform_name);die; 
            $addqury_data['total_score'] = 0;
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'',$addqury_data,$date_column,$audit_from,$audit_to);
            //$this->printData($reasult_form_audit);
           // echo $this->db->last_query();die;
            //echo postRequestResponse($reasult_form_audit);die;
             foreach($reasult_form_audit as $key => $each_form_audit)
             {
                foreach($each_form_audit as $each_attr_key => $each_attr_value)
                {
                    if($each_attr_value == 'FATAL' && explode("_", $each_attr_key)[1] == 'sel'){
                        if (array_key_exists($eachform_name['form_name'],$table_data) && array_key_exists($each_attr_key,$table_data[$eachform_name['form_name']]))
                        {
                            $table_data[$eachform_name['form_name']][$each_attr_key] =  $table_data[$eachform_name['form_name']][$each_attr_key] + 1;
                        }
                        else{
                            $table_data[$eachform_name['form_name']][$each_attr_key] = 1;
                        }
                    }
                }
            }
             //echo postRequestResponse($this->db->last_query());die; 
            //echo postRequestResponse($table_data);die; 
             
            if(!empty($table_data))
            {
                $table_data[$eachform_name['form_name']]['lob']=$eachform_name['lob'];
                arsort($table_data[$eachform_name['form_name']]);
            }
        }
        //echo postRequestResponse($table_data);die;
        if(!empty($table_data)){
            //echo postRequestResponse('dffdfd');die;
            foreach($table_data as $form_name => $form_data)
            { 
                $lob = $form_data['lob'];
                unset($form_data['lob']);
                foreach($form_data as $attr_id => $each_row_data)
                {
                    $result_forms_info = $this->common->getDistinctWhereSelectOderby('forms',['attribute'],['lob'=>$lob,'form_name'=>$form_name,'attr_id'=>$attr_id],'form_version','DESC');
                    $table .='
                    <tr>
                        <td>'.$result_forms_info[0]['attribute'].'</td>
                        <td><a href="javascript:void(0)" onclick="data_list(`'.$audit_from.'`,`'.$audit_to.'`,`'.$date_column.'`,`'.$campaign.'`,`'.$vendor.'`,`'.$location.'`,`'.$lob.'`,`'.$agents.'`,`'.$form_name.'`,`'.$attr_id.'`,`'.$result_forms_info[0]['attribute'].'`)">'.$each_row_data.'</a></td>
                        <td>'.$lob.'</td>
                    </tr>';
                }
            }
        }
        else{
            $table .='
                    <tr>
                        <td colspan="3" align="center"> No Data Found</td>
                    </tr>';
        }
        $table .='</thead></tbody></table>';
       
        //echo postRequestResponse($table_data[$eachform_name['form_name']]['lob']=$eachform_name['lob']);die; 
        echo postRequestResponse($table);  
    }
    public function autofail_report()
	{
	    $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agents 	    = $this->input->post('agents');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
    
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
       
        if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$login_user_lob,'form_name');
        }else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name'],['client_id'=>$this->client_id,'lob'=>$lob]);
            $addqury_data['lob']=$lob;
        }
        $reasult_agents = array();
        if($agents =='')
        {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['client_id'=>$this->client_id,'sup_id'=>$this->session->userdata('empid'),'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id = "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        else {
            $reasult_agents  = $this->common->getDistinctWhere('user','empid,name,sup_id,sup_name',['client_id'=>$this->client_id,'empid'=>$agents,'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id =  "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
        }
        $table_data=[];
        foreach($reasult_form_name as $key => $eachform_name)
        {
            $addqury_data['total_score'] = 0;
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'',$addqury_data,$date_column,$audit_from,$audit_to);
            foreach($reasult_form_audit as $key => $each_form_audit)
            {
               if (array_key_exists($each_form_audit->agent_id,$table_data))
                {
                   $table_data[$each_form_audit->agent_id]['total_evaluation'] = $table_data[$each_form_audit->agent_id]['total_evaluation'] + 1;
                   $table_data[$each_form_audit->agent_id]['totalfatel_count'] = ($each_form_audit->total_score == 0) ? $table_data[$each_form_audit->agent_id]['totalfatel_count'] + 1:$table_data[$each_form_audit->agent_id]['totalfatel_count'];
                   $table_data[$each_form_audit->agent_id]['totalScore_count'] = $table_data[$each_form_audit->agent_id]['totalScore_count'] + (float)$each_form_audit->total_score;
                   $table_data[$each_form_audit->agent_id]['qa_score'] = ($table_data[$each_form_audit->agent_id]['totalScore_count']  >0)?($table_data[$each_form_audit->agent_id]['totalScore_count'] / $table_data[$each_form_audit->agent_id]['total_evaluation']):0.0;
                }
                else
                {
                   $table_data[$each_form_audit->agent_id]['form_version'] = $each_form_audit->form_version;
                   $table_data[$each_form_audit->agent_id]['agent_id'] = $each_form_audit->agent_id;
                   $table_data[$each_form_audit->agent_id]['agent_name'] = $each_form_audit->agent_name;
                   $table_data[$each_form_audit->agent_id]['supervisor'] = $each_form_audit->supervisor;
                   $table_data[$each_form_audit->agent_id]['vendor'] = $each_form_audit->vendor;
                   $table_data[$each_form_audit->agent_id]['location'] = $each_form_audit->location;
                   $table_data[$each_form_audit->agent_id]['campaign'] = $each_form_audit->campaign;
                   $table_data[$each_form_audit->agent_id]['lob'] = $each_form_audit->lob;
                   $table_data[$each_form_audit->agent_id]['total_evaluation'] = 1;
                   $table_data[$each_form_audit->agent_id]['totalfatel_count'] = ($each_form_audit->total_score == 0) ? 1:0;
                   $table_data[$each_form_audit->agent_id]['qa_score'] = ($each_form_audit->total_score >0)?($each_form_audit->total_score / 1):0.0;
                   $table_data[$each_form_audit->agent_id]['totalScore_count'] = ($each_form_audit->total_score >0)?$each_form_audit->total_score :0.0;
                }
            }
            // echo '<pre>';
            // print_r($table_data);die;
        }
        //$this->print_result($table_data);die;
        usort($table_data, function ($item1, $item2) {
            return $item2['qa_score'] <=> $item1['qa_score'];
        });
        
        echo postRequestResponse($table_data);  
    }

    public function autofail_audit_list()
	{
        $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agents 	    = $this->input->post('agents');
        $form_name      = $this->input->post('form_name');
        $attr_id        = $this->input->post('attr_id');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        if(!empty($agents) && $agents !='null'){
            $addqury_data[$emp_condition_field] = $agents;
        }
        if(!empty($lob) && $lob !='null'){
            $addqury_data['lob']=$lob;
        }
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
        if(!empty($attr_id) && $attr_id !='null'){
            $addqury_data[$attr_id]='FATAL';
            $att_com = current(explode('_',$attr_id)).'_com';
        }
        ; 
        $table_data=[];
        $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($form_name,['unique_id','call_id','agent_name','supervisor','campaign','lob','vendor','location','form_version',$att_com],$addqury_data,$date_column,$audit_from,$audit_to);
        //echo postRequestResponse($reasult_form_audit);die;
        foreach($reasult_form_audit as $key => $each_form_audit)
        {
            $table_data[$key]['unique_id'] = $each_form_audit->unique_id;
            $table_data[$key]['call_id'] = $each_form_audit->call_id;
            $table_data[$key]['agent_name'] = $each_form_audit->agent_name;
            $table_data[$key]['supervisor'] = $each_form_audit->supervisor;
            $table_data[$key]['campaign'] = $each_form_audit->campaign;
            $table_data[$key]['lob'] = $each_form_audit->lob;
            $table_data[$key]['vendor'] = $each_form_audit->vendor;
            $table_data[$key]['location'] = $each_form_audit->location;
            $table_data[$key]['comment'] = $each_form_audit->$att_com;
            $table_data[$key]['form_version'] = $each_form_audit->form_version;
            $table_data[$key]['form_name'] = $form_name;
        }
       // echo postRequestResponse($this->db->last_query());
        echo postRequestResponse($table_data);
    }

   
    public function audit_list()
	{
        $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agent_id 	    = $this->input->post('agent_id');
        $agents 	    = $this->input->post('agents');
        $data_list_type = $this->input->post('data_list_type');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
    
        if(!empty($agents) && $agents !='null'){
            $addqury_data[$emp_condition_field] = $agents;
        //     if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 2)
        //    {
        //        $addqury_data['evaluator_id'] = $agents;
        //    }
        //    if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 3)
        //    {
        //        $addqury_data['agent_id'] = $agents;
        //    }
        }
        if(!empty($agent_id) && $agent_id !='null'){
            $addqury_data['agent_id']=$agent_id;
        }
        if(!empty($lob) && $lob !='null'){
            $addqury_data['lob']=$lob;
        }
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
        /// check for fatal audit only
        if(!empty($data_list_type) && $data_list_type !='null'){
            $addqury_data['total_score']= 0 ;
        }

        $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob'],['client_id'=>$this->client_id,'lob'=>$lob]);
        $table_data=[];
        foreach($reasult_form_name as $key => $eachform_name)
        {
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'unique_id,evaluator_id,lob,campaign,location,vendor,agent_name,agent_id,supervisor,total_score,submit_time',$addqury_data,$date_column,$audit_from,$audit_to);
            foreach($reasult_form_audit as $key => $each_form_audit)
            {
                $table_data[$key]['unique_id'] = $each_form_audit->unique_id;
                $table_data[$key]['agent_id'] = $each_form_audit->agent_id;
                $table_data[$key]['agent_name'] = $each_form_audit->agent_name;
                $table_data[$key]['supervisor'] = $each_form_audit->supervisor;
                $table_data[$key]['vendor'] = $each_form_audit->vendor;
                $table_data[$key]['location'] = $each_form_audit->location;
                $table_data[$key]['campaign'] = $each_form_audit->campaign;
                $table_data[$key]['lob'] = $each_form_audit->lob;
                $table_data[$key]['total_score'] = $each_form_audit->total_score;
                $table_data[$key]['form_name'] = $eachform_name['form_name'];
                   
            }
        }
       // echo postRequestResponse($this->db->last_query());
        echo postRequestResponse($table_data);
    }

    public function tag_report_index()
	{
        //$data['title']          = 'Reports';
        // $data['title2']         = 'Agent QA Performance';
        //$data['title2']         = $this->uri->segment(1);
        // $data['channels']       = $this->common->getSelectAll('forms_details','channels');
        // $data['lob']	        = $this->common->getDistinctWhere('hierarchy','lob',['client_id'=>$this->client_id]);
        // $data['agents']	        = $this->common->getDistinctWhere('user','empid,name',['client_id'=>$this->client_id,'sup_id'=>$this->session->userdata('empid'),'is_admin'=>2,'usertype'=>2,'status'=>'1']);
		//$this->load->view('reports/fatal_report_view.' , $data);
		$this->load->view('reports/tag_report_view');
    }

    public function tag_report()
	{
	    $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
        $agents 	    = $this->input->post('agents');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');    
        $where = '';
        $kpi_result = [];
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
            $where .= " campaign = '$campaign' AND";
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
            $where .= " vendor = '$vendor' AND";
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
            $where .= " location = '$location' AND";
        }
       
        if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));            
            $lobData = "'".implode(',',$login_user_lob)."'";
            $where .= " FIND_IN_SET(lob,$lobData) AND";
            $kpiLob[" FIND_IN_SET(lob,$lobData)"]=null;
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$login_user_lob,'form_name');
        }
        else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name'],['client_id'=>$this->client_id,'lob'=>$lob]);
            $addqury_data['lob']=$lob;
            $kpiLob['lob']=$lob;
            $lobData = "'".$lob."'";
            $where .= " FIND_IN_SET(lob,$lobData) AND";
        }
        $reasult_agents = array();
        if($agents =='')
        {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['client_id'=>$this->client_id,'sup_id'=>$this->session->userdata('empid'),'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id = "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
            $where .= " FIND_IN_SET($emp_condition_field,$emp_id) AND";
        }
        else {
            $reasult_agents  = $this->common->getDistinctWhere('user','GROUP_CONCAT(empid) as empid',['client_id'=>$this->client_id,'empid'=>$agents,'is_admin'=>$this->session->userdata('emp_group'),'usertype'=>2,'status'=>'1']);
            $emp_id =  "'".$reasult_agents[0]->empid."'";
            $addqury_data["FIND_IN_SET($emp_condition_field, $emp_id)"] = null;
            $where .= " FIND_IN_SET($emp_condition_field,$emp_id) AND";
        }
        $where .= " DATE($date_column) >= '$audit_from' AND DATE($date_column) <= '$audit_to' "; 
        $overall_qa_sql = '';
        foreach ($reasult_form_name as $lkey => $lvalue) {
            $overall_qa_sql .="SELECT unique_id AS total_score FROM  ".$lvalue['form_name']." WHERE $where  UNION ALL ";
        }
        $ovelall_words = explode( "UNION ALL", $overall_qa_sql);
        array_splice( $ovelall_words, -1 );
        $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
        if(!empty($overall_qa_total_sql)){
            $overall_total_qa_sql ="SELECT count(t.total_score) as count FROM ($overall_qa_total_sql)t";  
            $overall_query = $this->db->query($overall_total_qa_sql);
            $overall_result = $overall_query->result_array();
            // echo postRequestResponse($this->db->last_query());die;
            // echo $where."<pre>";
            // print_r($overall_result[0]['count']);die;
            // $kpiLob =FIND_IN_SET(lob,'CareTouch,Seller Onboarding,Seller Experience')3
            $kpi_result = $this->kpiMetrics($overall_result[0]['count'],$where,$kpiLob);
        }
            
        // $this->print_result($reasult_form_name);
        // $this->print_result($kpi_result);die;
       
        echo postRequestResponse($kpi_result);  
       // echo postRequestResponse($data =$kpi_result);  
    }

    public function tag_audit_list()
	{
        $audit_from 	= $this->input->post('audit_from');
	    $audit_to 	    = $this->input->post('audit_to');
	    $date_column 	= $this->input->post('date_column');
	    $lob 	        = $this->input->post('lob');
	    $campaign 	    = $this->input->post('campaign');
	    $vendor 	    = $this->input->post('vendor');
	    $location 	    = $this->input->post('location');
       // $agent_id 	    = $this->input->post('agent_id');
        $agents 	    = $this->input->post('agents');
        $unique_id 	    = $this->input->post('unique_id');
        $data_list_type = $this->input->post('data_list_type');
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
    
        if(!empty($agents) && $agents !='null'){
            $addqury_data[$emp_condition_field] = $agents;
        //     if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 2)
        //    {
        //        $addqury_data['evaluator_id'] = $agents;
        //    }
        //    if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 3)
        //    {
        //        $addqury_data['agent_id'] = $agents;
        //    }
        }
        if(!empty($unique_id) && $unique_id !='null'){
            $unique_id = decode($unique_id);
             $unique_ids =  "'".$unique_id."'";
            $addqury_data["FIND_IN_SET(unique_id, $unique_ids)"] = null;
           // echo postRequestResponse(decode($unique_id));die;
           // $addqury_data['unique_id']=$unique_id;
        }
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
       

       // $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob'],['client_id'=>$this->client_id,'lob'=>$lob]);
       if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$login_user_lob,'form_name');
        }else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name'],['lob'=>$lob]);
            $addqury_data['lob']=$lob;
        }
        $table_data=[];
        foreach($reasult_form_name as $key => $eachform_name)
        {
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'unique_id,evaluator_id,lob,campaign,location,vendor,agent_name,agent_id,supervisor,total_score,submit_time,form_version',$addqury_data,$date_column,$audit_from,$audit_to);
         
            foreach($reasult_form_audit as $key => $each_form_audit)
            {
                $table_data[$key]['unique_id'] = $each_form_audit->unique_id;
                $table_data[$key]['agent_id'] = $each_form_audit->agent_id;
                $table_data[$key]['agent_name'] = $each_form_audit->agent_name;
                $table_data[$key]['supervisor'] = $each_form_audit->supervisor;
                $table_data[$key]['vendor'] = $each_form_audit->vendor;
                $table_data[$key]['location'] = $each_form_audit->location;
                $table_data[$key]['campaign'] = $each_form_audit->campaign;
                $table_data[$key]['lob'] = $each_form_audit->lob;
                $table_data[$key]['total_score'] = $each_form_audit->total_score;
                $table_data[$key]['form_version'] = $each_form_audit->form_version;
                $table_data[$key]['form_name'] = $eachform_name['form_name'];  
            }
        }
       // echo postRequestResponse($table_data);die;
       // echo postRequestResponse($this->db->last_query());
        echo postRequestResponse($table_data);
    }
    public function tag_audit_list_kpi()
	{
        $post = $this->input->post();
        $date_to 	= $post['audit_from'];
	    $date_form 	    = $post['audit_to'];
	    $date_column 	= $post['date_column'];
	    //$lob 	        = ((!empty($post['lob']) && $post['lob'] != 'null' && $post['lob'] != 'all') ? $post['lob']:(explode('|||',$this->session->userdata('lob'))));
	    $lob 	        = ((!empty($post['lob']) && $post['lob'] != 'null' && $post['lob'] != 'all') ? "'".$post['lob']."'":("'".implode(',',explode('|||',$this->session->userdata('lob')))."'"));
	    $campaign 	    = $post['campaign'];
	    $vendor 	    = $post['vendor'];
	    $location 	    = $post['location'];
        $agents 	    = $post['agents'];
        $emp_condition_field     = (($this->emp_group == 'ops')?'evaluator_id':'agent_id');
        $kpiId = strtolower($post['kpi_name']);
        $kpiId =  ($kpiId  == 'csat') ? '1' : (($kpiId == 'resolution') ? '2' : (($kpiId == 'sales') ? '3':'4'));
        
        // get form name based on LOB
        $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$lob,'form_name');
        // KPI Attribute name
        $kpisql = 'SELECT attribute,attr_id,form_name,form_version,lob FROM forms WHERE kpi_metrics REGEXP "[[:<:]]'.$kpiId.'[[:>:]]" AND FIND_IN_SET(lob,'.$lob.')';
        $kpi_query = $this->db->query($kpisql);
        $kpi_res = $kpi_query->result();
        // KPI Attribute name end

        $overall_qa_sql_yes = '';
        $overall_qa_sql_no = '';
        //foreach ($reasult_form_name as $lkey => $lvalue) {
            
            foreach ($kpi_res as $kpikey => $kpivalue) {
                $form_name      = $kpivalue->form_name;
                $attr_id        = $kpivalue->attr_id;
                $attributeName  = str_replace("'","`",$kpivalue->attribute);
                $form_version   = $kpivalue->form_version;
                $form_version   = $kpivalue->lob;
                $overall_qa_sql_yes .="SELECT count(unique_id) as total_yes,vendor,lob,campaign,location,form_version,'$attributeName' as attributeName,'$form_name' as form_name FROM  $form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' and $attr_id = 'YES' UNION ALL ";        
                $overall_qa_sql_no .="SELECT count(unique_id) as total_no,vendor,lob,campaign,location,form_version,'$attributeName' as attributeName,'$form_name' as form_name FROM  $form_name WHERE DATE(submit_time) >= '$date_to' and DATE(submit_time) <= '$date_form' and $attr_id = 'NO' UNION ALL ";        
            }
            
        //}
        $ovelall_words_yes = explode( "UNION ALL", $overall_qa_sql_yes);
        $ovelall_words_no = explode( "UNION ALL", $overall_qa_sql_no);
        array_splice( $ovelall_words_yes, -1 );
        array_splice( $ovelall_words_no, -1 );
        $overall_qa_total_sql_yes = implode( "UNION ALL", $ovelall_words_yes );
        $overall_qa_total_sql_no = implode( "UNION ALL", $ovelall_words_no );
        if(!empty($overall_qa_total_sql_yes)){
            $overall_total_qa_sql_yes ="SELECT * FROM ($overall_qa_total_sql_yes)t group BY attributeName";  
            $overall_query_yes = $this->db->query($overall_total_qa_sql_yes);
            $overall_result_yes = $overall_query_yes->result();
        }
        if(!empty($overall_qa_total_sql_no)){
            $overall_total_qa_sql_no ="SELECT * FROM ($overall_qa_total_sql_no)t group BY attributeName";  
            $overall_query_no = $this->db->query($overall_total_qa_sql_no);
            $overall_result_no = $overall_query_no->result();
        }
        $data = [];
        $totalPossibleScore = 0;
        foreach ($overall_result_yes as $key => $value) {
            $totalPossibleScore = (int)$value->total_yes+(int)$overall_result_no[$key]->total_no;
            if($value->total_yes > 0 && $totalPossibleScore > 0){
                $Avg = ($value->total_yes/$totalPossibleScore)*100;
            }
            else{
                $Avg = 0;
            }
            $data[] = [
                'attributeName'=>$value->attributeName,
                'campaign'=>$value->campaign,
                'form_name'=>$value->form_name,
                'form_version'=>$value->form_version,
                'lob'=>$value->lob,
                'location'=>$value->location,
                'vendor'=>$value->vendor,
                'avg'=>round($Avg,2)."%"
            ];
            $totalPossibleScore = 0;
        }
        echo postRequestResponse($data);die;
        

        
        echo postRequestResponse(['id'=>decode($unique_id),'res'=>$kpiData]);die;


        // $check[$audit_from] = $audit_from;
        // $check[$audit_to] = $audit_to;
        // $check[$date_column] = $date_column;
        // $check[$lob] = $lob;
        // $check[$campaign] = $campaign;
        // $check[$vendor] = $vendor;
        // $check[$location] = $location;
        // $check[$agents] = $agents;
        // $check[$unique_id] = $unique_id;
        // $check[$data_list_type] = $data_list_type;
        // $check[$emp_condition_field] = $emp_condition_field;
        //echo postRequestResponse(decode($unique_id));die;
       // echo postRequestResponse($check);die;
        if(!empty($agents) && $agents !='null'){
            $addqury_data[$emp_condition_field] = $agents;
        //     if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 2)
        //    {
        //        $addqury_data['evaluator_id'] = $agents;
        //    }
        //    if($this->session->userdata('usertype') == 3 && $this->session->userdata('emp_group') == 3)
        //    {
        //        $addqury_data['agent_id'] = $agents;
        //    }
        }
        if(!empty($unique_id) && $unique_id !='null'){
            $unique_id = decode($unique_id);
             $unique_ids =  "'".$unique_id."'";
            $addqury_data["FIND_IN_SET(unique_id, $unique_ids)"] = null;
            //echo postRequestResponse(decode($unique_id));die;
           // $addqury_data['unique_id']=$unique_id;
        }
        if(!empty($campaign) && $campaign !='null'){
            $addqury_data['campaign']=$campaign;
        }
        if(!empty($vendor) && $vendor !='null'){
            $addqury_data['vendor']=$vendor;
        }
        if(!empty($location) && $location !='null'){
            $addqury_data['location']=$location;
        }
       

       // $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob'],['client_id'=>$this->client_id,'lob'=>$lob]);
       if($lob =='all'){
            $login_user_lob = (explode('|||',$this->session->userdata('lob')));
            $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$login_user_lob,'form_name');
        }else{
            $reasult_form_name =$this->common->getDistinctWhereSelect('forms_details',['form_name'],['lob'=>$lob]);
            $addqury_data['lob']=$lob;
        }
        $table_data=[];
        foreach($reasult_form_name as $key => $eachform_name)
        {
            $reasult_form_audit  = $this->common->getWhereSelectAllFromTo($eachform_name['form_name'],'unique_id,evaluator_id,lob,campaign,location,vendor,agent_name,agent_id,supervisor,total_score,submit_time,form_version',$addqury_data,$date_column,$audit_from,$audit_to);
            
            foreach($reasult_form_audit as $key => $each_form_audit)
            {
                // echo postRequestResponse($each_form_audit);die;
                $table_data[$key]['unique_id'] = $each_form_audit->unique_id;
                $table_data[$key]['agent_id'] = $each_form_audit->agent_id;
                $table_data[$key]['agent_name'] = $each_form_audit->agent_name;
                $table_data[$key]['supervisor'] = $each_form_audit->supervisor;
                $table_data[$key]['vendor'] = $each_form_audit->vendor;
                $table_data[$key]['location'] = $each_form_audit->location;
                $table_data[$key]['campaign'] = $each_form_audit->campaign;
                $table_data[$key]['lob'] = $each_form_audit->lob;
                $table_data[$key]['total_score'] = $each_form_audit->total_score;
                $table_data[$key]['form_version'] = $each_form_audit->form_version;
                $table_data[$key]['form_name'] = $eachform_name['form_name'];  
            }
        }
       // echo postRequestResponse($table_data);die;
       // echo postRequestResponse($this->db->last_query());
        echo postRequestResponse($table_data);
    }
   
    
    public function kpiMetrics($total_overall_evulation,$kpiSql1,$kpiLob){
        $kpi_result_data    =   [];
        $kpiMetricsArr      =   [];
        $sum      =   [];
        $kpiMetricsSql      =   [];
        $kpiMetricsSql1      =   [];
        $kpi_result         =   [];
        $kpi_result1         =   [];
        $sql                =   '';
        $kpiSql             =   '';
        $kpi_forms_name     =   [];
        $kpiLob['kpi_metrics !='] = '';
        $kpi_metrics = $this->common->getWhereSelectAll('forms',['attr_id','kpi_metrics','form_name'],$kpiLob);
        foreach ($kpi_metrics as $key => $value) {
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
                        $kpiMetricsSql1[$kpi]['yes'][] = "SELECT COUNT(unique_id) as sum_of_yes FROM $value->form_name WHERE $value->attr_id = 'YES' AND $kpiSql1";
                        $kpiMetricsSql1[$kpi]['no'][] = "SELECT COUNT(unique_id) as sum_of_no FROM $value->form_name WHERE $value->attr_id = 'NO' AND $kpiSql1";
                        $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                        $attr_coloumn[$kpi] = $value->attr_id;
                        $kpi_forms_name[] = $value->form_name;
                    }
                    else{
                        $kpiMetricsArr[$value->attr_id] = $value1;
                        $attr_score[$kpi] = explode('_', $value->attr_id)[0].'_score';
                        $attr_coloumn[$kpi] = $value->attr_id;
                        $kpi_forms_name[] = $value->form_name;
                        $kpiMetricsSql[$kpi] = "$value->attr_id = 'YES' AND $kpiSql1";
                        $kpiMetricsSql1[$kpi]['yes'][] = "SELECT COUNT(unique_id) as sum_of_yes FROM $value->form_name WHERE $value->attr_id = 'YES' AND $kpiSql1";
                        $kpiMetricsSql1[$kpi]['no'][] = "SELECT COUNT(unique_id) as sum_of_no FROM $value->form_name WHERE $value->attr_id = 'NO' AND $kpiSql1";
                    }
                }
            }
        }
        //return $kpiMetricsSql1;
        // $this->printData($kpiMetricsSql);die;
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
                // if ($this->db->field_exists($attr_coloumn[$key2], $lvalue->form_name)){
                if ($this->db->field_exists($attr_coloumn[$key2], $lvalue)){
                    // $kpiSql .="SELECT $attr as total_score FROM  $lvalue->form_name WHERE $value2 UNION ALL ";
                    $kpiSql .="SELECT $attr as total_score,unique_id  FROM  $lvalue WHERE $value2 UNION ALL ";
                }
            }
            $kpiwords = explode( "UNION ALL", $kpiSql );
            array_splice( $kpiwords, -1 );
            $kpiSql = implode( "UNION ALL", $kpiwords );

            $sum_of_yes = 0;
            $sum_of_no = 0;

            foreach ($kpiMetricsSql1[$key2]['yes'] as $tagkey => $tagvalue) {
                $tag_kpi_query = $this->db->query($tagvalue);
                $tag_kpi_res = $tag_kpi_query->result();
                $kpi_result1[$key2]['sql'][] = $this->db->last_query();
                if(!empty($tag_kpi_res)){
                    $sum[$key2]['yes'] = $sum_of_yes + $tag_kpi_res[0]->sum_of_yes;
                    
                }
                $tag_kpi_query_no = $this->db->query($kpiMetricsSql1[$key2]['no'][$tagkey]);
                if(!empty($tag_kpi_query_no)){
                    $tag_kpi_res_no = $tag_kpi_query_no->result();
                    $sum[$key2]['no'] = $sum_of_no + $tag_kpi_res_no[0]->sum_of_no;
                }
            }
            $tag = ($sum[$key2]['yes']/($sum[$key2]['yes']+$sum[$key2]['no']));

            if(!empty($kpiSql)){
                $kpi_wise_total_sql =" SELECT count(t.total_score) as count,GROUP_CONCAT(unique_id) as unique_id FROM ($kpiSql)t";  
                $kpi_query = $this->db->query($kpi_wise_total_sql);
                $kpi_res = $kpi_query->result_array();
                // echo $this->db->last_query();die;
                if($this->array_key_exists_recursive($key2, $kpi_result)){
                    $kpi_result[$key2] = ['count'=>$kpi_res[0]['count'],'unique_id'=>$kpi_res[0]['unique_id']];
                }
                else{
                    $kpi_result[$key2] = ['count'=>$kpi_res[0]['count'],'unique_id'=>$kpi_res[0]['unique_id']];
                }
            }
           
            if($total_overall_evulation > 0 && $kpi_result[$key2] > 0){
                $kpi_result_data[] = ['unique_id'=>encode($kpi_result[$key2]['unique_id']),'KpiAttrName'=>$key2,'TOTAL_CALL'=>$total_overall_evulation,'TOTAL_KPI_EVALUTION'=>$kpi_result[$key2]['count'],'AVG'=>round((($kpi_result[$key2]['count']/$total_overall_evulation)*100),2),'TagScore'=>round($tag,2)];
            }
            else{
                $kpi_result_data[] = ['unique_id'=>'','KpiAttrName'=>$key2,'TOTAL_CALL'=>0,'TOTAL_KPI_EVALUTION'=>0,'AVG'=>0,'TagScore'=>0];;
            }
        }
        //return $kpi_result1;
        //$this->printData($kpi_result);
        // $this->printData($kpi_result_data);
        //die;
        return $kpi_result_data;
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

    public function printData($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }



    protected function getKPIMatrix($kpiId,$post){

        $lob = ((!empty($post['lob']) && $post['lob'] != 'null') ? $post['lob']:(explode('|||',$this->session->userdata('lob'))));
        return $reasult_form_name =$this->common->getDistinctWhereINSelect('forms_details',['form_name'],'lob',$lob,'form_name');
        return $this->db->last_query();
        $kpisql = 'SELECT attribute,attr_id FROM forms WHERE kpi_metrics REGEXP "[[:<:]]'.$kpiId.'[[:>:]]"';
        $kpi_query = $this->db->query($kpisql);
        return $kpi_res = $kpi_query->result();
    }
    

//please write above	
}
