<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateController extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		//welcomesetup_create_form
		$isWelcome = end($this->uri->segments);
		
		//echo $isWelcome."JJJJJJ";die;
		if($isWelcome == 'welcomesetup_create_form'){
			$result = $this->common->update_data_info('client',['mokup_steps'=>'2'],['client_id'=>$this->session->userdata('client_id')]);
			//$this->load->view('other/welcomeSetup_templateListOther_view' ,compact('industry_type_template'));
			$welcomesetup_create_form = 'yes';
      		$this->load->view('other/non_bpo_forms_view',compact('template_data','tmp_name','tmp_unique_id','welcomesetup_create_form')); 
		}
		else {
			//echo "ssssssaaaa";die;
			$this->load->view('other/non_bpo_forms_view');
		}
		//$this->load->view('other/non_bpo_forms_view');
	}

	public function form_preview(){
		$this->load->view('other/non_bpo_forms_preview_view');
	}
	
	public function unique_template_check(){
        $flagform_name_unique =  $this->common->getWhereSelectDistinctCount('template_details','tmp_name',['tmp_name'=>$this->input->post('tmp_name')]); 
        if (((int)$flagform_name_unique) >= 1) { 
            echo postRequestResponse('error');
        }
        else{
            echo postRequestResponse('success');
        }
    }

	public function template_insert(){
		//echo postRequestResponse($this->input->post());die;
		$post_temp_data = $this->input->post('template_data');
		if(!empty($post_temp_data[0]['welcomesetup_create_form'])){

			$welcomesetup_create_form = $post_temp_data[0]['welcomesetup_create_form'];
			array_splice($post_temp_data, 0, 1);
			// unset($post_temp_data[0]['welcomesetup_create_form']);
			// unset($post_temp_data[0]);
			//echo postRequestResponse('AAAAAAAAAAA');die;
		}
		$unique_id 		= uniqid().rand(10,10000000);
		$tat_time = $post_temp_data[0]['tat_time'];
		array_splice($post_temp_data, 0, 1);

		$tmp_name 		= $post_temp_data[0]['tmp_name'];
		$template_data 	= [];
		$template_details_data = [];
		if(!empty($post_temp_data))
		{
			$template_details_data['tmp_unique_id'] = $unique_id;
			$template_details_data['tmp_name'] 		= $post_temp_data[0]['tmp_name'];
			//$template_details_data['tb_name'] 		= strtolower($post_temp_data[0]['tmp_name']);
			$template_details_data['tb_name'] 		= strtolower('tb_temp_'.$unique_id);
			unset($post_temp_data[0]);

			$flag_cat = 0; $flag_aat_id = 0;$flag_total_weightage = 0; $cat_colums = array();$fields = array();
			foreach($post_temp_data as $each_temp_data)
			{
				foreach($each_temp_data as $eachsec_key => $eachsec)
				{
					$flag_cat++;
					$t_cat_name = $eachsec[0]['sec_title'];
					unset($eachsec[0]);
					
					foreach($eachsec as $eachQustion_no => $eachQustionData)
					{
						$flag_aat_id++;
						$att_name = '';  $flag_aat_id < 10?$att_name = '0'.($flag_aat_id):$att_name = ($flag_aat_id);
						$template_data[($flag_aat_id - 1)]['t_unique_id'] 		= $unique_id;
						$template_data[($flag_aat_id - 1)]['t_name'] 			= $tmp_name;
						$template_data[($flag_aat_id - 1)]['t_cat_id'] 			= 'cat'.($flag_cat);
						$template_data[($flag_aat_id - 1)]['t_cat_name'] 		= $t_cat_name;
						$template_data[($flag_aat_id - 1)]['t_ques_description'] = (!empty($eachQustionData['ques_description'])?$eachQustionData['ques_description']:null);
						$template_data[($flag_aat_id - 1)]['t_att_name'] 		= $eachQustionData['ques_text'];
						$template_data[($flag_aat_id - 1)]['t_att_id']   		= 'att'.$att_name.'_sel';
						$template_data[($flag_aat_id - 1)]['t_is_required'] 	= $eachQustionData['ques_required'];
						$template_data[($flag_aat_id - 1)]['t_option_type'] 	= $eachQustionData['ans_type'];
						$template_data[($flag_aat_id - 1)]['t_is_multiselect'] 	= $eachQustionData['ans_multi_sel'];
						$template_data[($flag_aat_id - 1)]['t_kpi'] 			= (!empty($eachQustionData['ans_kpi_multi_sel'])?implode('|',$eachQustionData['ans_kpi_multi_sel']):null);

						/////////////////////////////////////////////// For dynamic table creation makeing array start
                        $cat_colums['cat'.($flag_cat)] 		= array('type' => 'text');
                        $cat_colums['cat'.($flag_cat).'_d'] = array('type' => 'text');
                        $fields['att'.$att_name.'_score'] 	= array('type' => 'text');
                        $fields['att'.$att_name.'_sel'] 	= array('type' => 'text');
                        //$fields['att'.$att_name.'_file'] 	= array('type' => 'text');
                        $fields['att'.$att_name.'_fail'] 	= array('type' => 'text');
                        $fields['att'.$att_name.'_com'] = array('type' =>'text');
                        //$fields['att'.$att_name.'_content'] = array('type' =>'text');
						///////////////////////////////////////////////// For dynamic table creation makeing array end
						
						if($eachQustionData['ans_type'] == 'select'){
							$each_option = []; $flag = 0;
							foreach($eachQustionData['ans_value'] as $each_option_data)
							{
								//echo postRequestResponse($each_option_data);die;
								if($flag == 1){
									$each_option['t_option_value']   .= (!empty($each_option_data['ans_text'])? $each_option_data['ans_text'].'|':null);
									$each_option['t_option_score']   .= (!empty($each_option_data['ans_score'])? $each_option_data['ans_score'].'|':'0|');
									$each_option['t_option_failed']  .= (!empty($each_option_data['ans_failed'])? $each_option_data['ans_failed'].'|':null);
									$each_option['t_option_color']   .= (!empty($each_option_data['ans_color'])? $each_option_data['ans_color'].'|':null);
									$each_option['t_option_bgcolor'] .= (!empty($each_option_data['ans_bg_color'] )? $each_option_data['ans_bg_color'].'|':null);
								}
								else {
									$each_option['t_option_value']   = (!empty($each_option_data['ans_text'])?$each_option_data['ans_text'].'|':null);
									$each_option['t_option_score']   = (!empty($each_option_data['ans_score'])?$each_option_data['ans_score'].'|':'0|');
									$each_option['t_option_failed']  = (!empty($each_option_data['ans_failed'])?$each_option_data['ans_failed'].'|':null);
									$each_option['t_option_color']   = (!empty($each_option_data['ans_color'])?$each_option_data['ans_color'].'|':null);
									$each_option['t_option_bgcolor'] = (!empty($each_option_data['ans_bg_color'])?$each_option_data['ans_bg_color'].'|':null);
									$flag = 1;
								}
								$flag_total_weightage += (!empty($each_option_data['ans_score'])? $each_option_data['ans_score']:0);
								//$flag_total_weightage += $each_option_data['ans_score'];
							}
							//******
							$template_data[($flag_aat_id - 1)]['t_option_value'] 	= (!empty($each_option['t_option_value'])?(rtrim($each_option['t_option_value'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_score'] 	= (!empty($each_option['t_option_score'])?(rtrim($each_option['t_option_score'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_failed']	= (!empty($each_option['t_option_failed'])?(rtrim($each_option['t_option_failed'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_color'] 	= (!empty($each_option['t_option_color'])?(rtrim($each_option['t_option_color'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_bgcolor'] 	= (!empty($each_option['t_option_bgcolor'])?(rtrim($each_option['t_option_bgcolor'],'|')):null);
							
						}
						else if($eachQustionData['ans_type'] == 'textarea' || $eachQustionData['ans_type'] == 'text' || $eachQustionData['ans_type'] == 'date' || $eachQustionData['ans_type'] == 'checkbox'){
							$each_option = []; $flag = 0;
							//echo postRequestResponse($eachQustionData['ans_value']['ans_score']);die;
							foreach($eachQustionData['ans_value'] as $each_option_data)
							{
								$template_data[($flag_aat_id - 1)]['t_option_value'] 	= null;
								$template_data[($flag_aat_id - 1)]['t_option_score'] 	= (!empty($each_option_data['ans_score'])?$each_option_data['ans_score']:0);
								$template_data[($flag_aat_id - 1)]['t_option_failed'] 	= null;
								$template_data[($flag_aat_id - 1)]['t_option_color'] 	= null;
								$template_data[($flag_aat_id - 1)]['t_option_bgcolor'] 	= null;
								
								!empty($each_option_data['ans_score'])? $flag_total_weightage += $each_option_data['ans_score']:$flag_total_weightage += 0;
							}
						}
					}
				}
				$template_details_data['tmp_attributes'] = $flag_aat_id;
				$template_details_data['tmp_weightage']  = $flag_total_weightage;
				$template_details_data['temp_status'] 	 = '1';
				$template_details_data['tat_time']  	 = $tat_time;
			}
			//echo postRequestResponse($template_data);die;
			// insert in table Start
			// $response_template_details = $this->common->insert_data($template_details_data,'template_details');
			// $response_template         = $this->common->insert_batch_data('template',$template_data);

			/////////////////////////////////////////////// For dynamic table creating Start
				$response_table_ctreated = $this->db->query('CREATE TABLE '.strtolower('tb_temp_'.$unique_id).' LIKE sample_template');
				if($response_table_ctreated)
				{
					$this->load->dbforge();
					$this->dbforge->add_column(strtolower('tb_temp_'.$unique_id),$fields);
					$this->dbforge->add_column(strtolower('tb_temp_'.$unique_id),$cat_colums);

					$response_template_details = $this->common->insert_data($template_details_data,'template_details');
					$response_template         = $this->common->insert_batch_data('template',$template_data);
					if(!empty($welcomesetup_create_form))
					{
						$result = $this->common->update_data_info('client',['mokup_steps'=>'2'],['client_id'=>$this->session->userdata('client_id')]);
						echo postRequestResponse('welcomesetup_create_form_success');
					}else{
						echo postRequestResponse('success');
					}
					//echo postRequestResponse('success');
				}
				else {
					echo postRequestResponse('error');
				}
                
				/////////////////////////////////////////////// For dynamic table creating End
			
			// if(!($response_template) && !($response_template_details)){
			// 	$response = $this->common->delete_data('template_details',['tmp_unique_id'=>$unique_id]);
			// 	$response = $this->common->delete_data('template',['t_unique_id'=>$unique_id]);
			// 	$this->session->set_flashdata('error', 'Template is not create try again ....');
			// 	echo postRequestResponse('error');
			// }
			// else {
			// 	/////////////////////////////////////////////// For dynamic table creating Start
			// 	$this->db->query('CREATE TABLE '.strtolower($tmp_name).' LIKE sample_template');
            //     $this->load->dbforge();
            //     $this->dbforge->add_column(strtolower($tmp_name),$fields);
            //     $this->dbforge->add_column(strtolower($tmp_name),$cat_colums);
			// 	/////////////////////////////////////////////// For dynamic table creating End
			// 	echo postRequestResponse('success');
			// }

			//echo postRequestResponse($template_details_data);
			//echo postRequestResponse($flag_total_weightage);
			//echo postRequestResponse($temp_data);
		}
	}

	public function template_list()
	{
		//$result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
	
		//$template_details_pre = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_unique_id','industry_type','template_type'],['industry_type'=>$this->session->userdata('industry_type')]);
		$template_details_pre = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_unique_id','industry_type','template_type'],['industry_type !='=>'']);
		//$this->load->view('other/templates_setup_view',compact('template_details_pre'));

		$template_data =  $this->common->getAllData('template_details');
		$sites = $this->common->getWhereSelectAll('sites',['s_name','s_id'],['s_status'=>'1','s_name !='=>'Default Site','s_name !=' => null]);
		$groups = $this->common->getWhereSelectAll('groups',['g_name','g_id'],['g_name !='=> 'Default Group1']);
		$user_list_sql = 'SELECT name,user_email FROM user WHERE u_group REGEXP "(^|,)1(,|$)"';
		$query =   $this->db->query($user_list_sql);
        $user_list = $query->result_array();
		//$this->print_result($template_data);die;
    	//$this->load->view('other/template_list_view' , $data);
    	$this->load->view('other/template_list_view' ,compact('template_data','sites','groups','template_details_pre','user_list'));
        
	}

	public function template_list_others($iswelcome = null)
	{
		//$result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
		//$template_details_pre = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_unique_id','industry_type','template_type'],['industry_type'=>$this->session->userdata('industry_type')]);
		//$template_details_pre = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_unique_id','industry_type','template_type'],['industry_type !='=>'']);
		$template_details_pre = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_unique_id','industry_type','template_type'],['industry_type !='=>'']);
		$industry_type_template = [];
		if(!empty($template_details_pre)){
			foreach ($template_details_pre as $key => $value) {
				if(array_key_exists($value['industry_type'],$industry_type_template)){
					$industry_type_template[trim($value['industry_type'])][]=['tmp_unique_id'=>$value['tmp_unique_id'],'template_type'=>$value['template_type']];
				}
				else{
					$industry_type_template[trim($value['industry_type'])][]=['tmp_unique_id'=>$value['tmp_unique_id'],'template_type'=>$value['template_type']];
				}
			}
		}
		
		if($iswelcome == 'welcome_other_form'){
			//$this->load->view('other/welcomeSetup_templateListOther_view' ,compact('industry_type_template'));
			$welcomesetup_other_form = 'yes';
			$this->load->view('other/template_list_other_view' ,compact('industry_type_template','welcomesetup_other_form'));
		}
		else {
			$this->load->view('other/template_list_other_view' ,compact('industry_type_template'));
		}
	}

	public function changeTempStatus()
    {
        $tmp_unique_id = $this->input->post('tmp_unique_id');
        $data['temp_status'] = $this->input->post('temp_status');
		$reasult =$this->common->update_data('template_details',$data,['tmp_unique_id'=>$tmp_unique_id]);
		if($reasult) { 
            echo postRequestResponse('Success');
        }
        else{
            echo postRequestResponse('error');
        }
	}
	
    public function delete_template($tmp_unique_id)
    {
       // $tmp_unique_id = $this->input->post('tmp_unique_id');
		$result_temp_info = $this->common->getDistinctWhereSelect('template_details',['tmp_unique_id','tb_name'],['tmp_unique_id'=>$tmp_unique_id]);
		//echo postRequestResponse($result_temp_info[0]['tb_name']);
		if(!empty($result_temp_info[0]['tmp_unique_id']))
		{
			//echo postRequestResponse($result_temp_info);
			$this->common->delete_data('template_details',['tmp_unique_id'=>$result_temp_info[0]['tmp_unique_id']]);
			$this->common->delete_data('template',['t_unique_id'=>$result_temp_info[0]['tmp_unique_id']]);
			$this->common->drop_table($result_temp_info[0]['tb_name']);
			$this->session->set_flashdata('success', 'Template and data has been deleted ....');
            
			//echo postRequestResponse($this->db->last_query());
			//echo postRequestResponse('Success');
		}
		else {
			$this->session->set_flashdata('success', 'Template not deleted try again ....');
			//echo postRequestResponse('error');
		}
		redirect('template-list', 'refresh');
    }
    public function share_template()
    {
		$tmp_unique_id = $this->input->post('tmp_unique_id');
		$role = explode(",",$this->input->post('role'));
		$data['group_id']  = (!empty($this->input->post('group_id'))?$this->input->post('group_id'):1);
		$data['site_id']  = (!empty($this->input->post('site_id'))?$this->input->post('site_id'):1);
		//code by jai
		if(in_array(4,$role) && in_array(3,$role))
		{
		$result = $this->common->update_data_info('template_details',$data,['tmp_unique_id'=>$tmp_unique_id]);
		//echo postRequestResponse($this->input->post());
		if($result)
		{
			echo postRequestResponse('Success');
		}
		else {
			echo postRequestResponse('error');
		}
	}else{
		echo postRequestResponse('Fail_Check_Role');
	}
	}

    public function template_share_list()
    {
		$data = [];
		$sites = (!empty($this->input->post('sites'))?$this->input->post('sites'):'');
		$groups = (!empty($this->input->post('groups'))?$this->input->post('groups'):'');
		if($this->input->post('change')){
			$where = '';
			if(!empty($sites)){
				$site = implode(',',$sites);
				$s = implode('|', explode(',',$site));
				$where .= 'site REGEXP "(^|,)'.$s.'(,|$)"';
			}
			if(!empty($groups)){
				$group = implode(',',$groups);
				$g = implode('|', explode(',',$group));
				if(!empty($site))
					$where .= " AND";
					$where .= ' u_group REGEXP "(^|,)'.$g.'(,|$)"';
			}
			if(!empty($where)){
				$sql = "SELECT name,user_email as email , usertype as role FROM user WHERE $where";
				$query = $this->db->query($sql);
				$data['user'] = $query->result();
			}

		}
		else{	
			$tmp_unique_id = $this->input->post('tmp_unique_id');
			$result_temp_info = $this->common->getDistinctWhereSelect('template_details',['site_id','group_id'],['tmp_unique_id'=>$tmp_unique_id]);
			if(!empty($result_temp_info)){
				$where = '';
				$result_temp_info = $result_temp_info[0];
				$data['share'] = $result_temp_info;
				$site = $result_temp_info['site_id'];
				$group = $result_temp_info['group_id'];
				if(!empty($site)){
					$s = implode('|', explode(',',$site));
					$where .= 'site REGEXP "(^|,)'.$s.'(,|$)"';
				}
				if(!empty($group)){
					$g = implode('|', explode(',',$group));
					if(!empty($site))
						$where .= " AND";
					$where .= ' u_group REGEXP "(^|,)'.$g.'(,|$)"';
				}
				if(!empty($where)){
					$sql = "SELECT name,user_email as email,usertype as role FROM user WHERE $where";
					$query = $this->db->query($sql);
					$data['user'] = $query->result();
				}
			}
		}
		echo postRequestResponse($data);
	}
	
	public function template_edit($tmp_unique_id,$pre_temp = null,$iswelcome = null)
    {
		
		//echo $tmp_unique_id;
		$copy ="";
		if(!empty($pre_temp) && $pre_temp == 'selected')
		{
			//echo "PPPPPper";die;
			$result_template_details_info = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_name'],['tmp_unique_id'=>$tmp_unique_id]);
		}else if(!empty($pre_temp) && $pre_temp == 'copy')
		{
			$copy = $pre_temp;
			$result_template_details_info = $this->common->getDistinctWhereSelect('template_details',['tmp_name'],['tmp_unique_id'=>$tmp_unique_id]);
		}
		else {	
			//echo "NONE per";die;
			$result_template_details_info = $this->common->getDistinctWhereSelect('template_details',['tmp_name'],['tmp_unique_id'=>$tmp_unique_id]);
		}
		// echo $this->db->last_query();
		// $this->print_result($result_template_details_info);die;
		$template_data = [];
		if(!empty($result_template_details_info[0]['tmp_name']))
		{
			$tmp_name = $result_template_details_info[0]['tmp_name'];
			if(!empty($pre_temp)  && $pre_temp == 'selected')
			{
				$result_template_info = $this->common->getDistinctWhereSelectOtherdb('db_others','template_pre','*',['t_unique_id'=>$tmp_unique_id]);
			}else if(!empty($pre_temp)  && $pre_temp == 'copy')
			{
				
				$result_template_info = $this->common->getDistinctWhereSelect('template','*',['t_unique_id'=>$tmp_unique_id]);
			}
			else {	
				$result_template_info = $this->common->getDistinctWhereSelect('template','*',['t_unique_id'=>$tmp_unique_id]);
			}
			
			//$this->print_result($result_template_info);die;
			$flag = 0;
			foreach($result_template_info as $each_qustion)
			{
				//$this->print_result($each_qustion);
				if(array_key_exists($each_qustion['t_cat_id'],$template_data))
                {
					//echo "<br> found ";
					
					$template_data[$each_qustion['t_cat_id']][] = $each_qustion;
				}
				else {
					//echo "<br> NOT ";
					$template_data[$each_qustion['t_cat_id']][] = $each_qustion;
				}
			}
			//$this->print_result($template_data);die();
		}
		if($iswelcome == 'welcome_other_form'){
			$result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
			//$this->load->view('other/welcomeSetup_templateListOther_view' ,compact('industry_type_template'));
			$welcomesetup_other_form = 'yes';
      		$this->load->view('other/template_edit_view',compact('template_data','tmp_name','tmp_unique_id','welcomesetup_other_form')); 
		}
		else {
			
			$this->load->view('other/template_edit_view',compact('template_data','tmp_name','tmp_unique_id','copy'));
		}
      	//$this->load->view('other/template_edit_view',compact('template_data','tmp_name','tmp_unique_id')); 
	}
	public function template_copy()
	{
		$response_msg = [];
		$post_temp_data = $this->input->post('template_data');
		$tat_time = $post_temp_data[0]['tat_time'];
		array_splice($post_temp_data, 0, 1);
		
		//echo postRequestResponse($post_temp_data);die;
		$tmp_name 		= $post_temp_data[0]['tmp_name'];
		$unique_id 		= $post_temp_data[1]['tmp_unique_id'];
		$response_msg[] = $this->pre_template_insert($unique_id,$post_temp_data,$tat_time,'copy');
		
		if(in_array("error", $response_msg))
		{
			echo postRequestResponse('errorrr');
		}
		else
		{
			echo postRequestResponse('success');
		}
	}

	public function template_update(){
		//echo postRequestResponse($this->input->post('template_data'));die;
		
		$response_msg = [];
		$post_temp_data = $this->input->post('template_data');
		if(!empty($post_temp_data[0]['welcomesetup_other_form'])){

			$welcomesetup_other_form = $post_temp_data[0]['welcomesetup_other_form'];
			array_splice($post_temp_data, 0, 1);
			// unset($post_temp_data[0]['welcomesetup_other_form']);
			// unset($post_temp_data[0]);
			//echo postRequestResponse('AAAAAAAAAAA');die;
		}
		$tat_time = $post_temp_data[0]['tat_time'];
		array_splice($post_temp_data, 0, 1);
		
		//echo postRequestResponse($post_temp_data);die;
		$tmp_name 		= $post_temp_data[0]['tmp_name'];
		$unique_id 		= $post_temp_data[1]['tmp_unique_id'];
		//echo postRequestResponse($post_temp_data);die;
		
		//die;
		////////////////////////////////////////////////////
		$result_temp_info = $this->common->getDistinctWhereSelect('template_details',['tmp_unique_id','tb_name'],['tmp_unique_id'=>$unique_id]);
		//echo postRequestResponse($result_temp_info[0]['tb_name']);
		if(!empty($result_temp_info[0]['tmp_unique_id']))
		{
			//echo postRequestResponse($result_temp_info);
			//$template_details_response = $this->common->delete_data_response('template_details',['tmp_unique_id'=>$result_temp_info[0]['tmp_unique_id']]);
			//$template_response = $this->common->delete_data_response('template',['t_unique_id'=>$result_temp_info[0]['tmp_unique_id']]);
			//$drop_table_response = $this->common->drop_table_response($result_temp_info[0]['tb_name']);

			//if($template_details_response && $template_response && $drop_table_response){
				$template_data 	= [];
				$template_details_data = [];
				if(!empty($post_temp_data))
				{
					$template_details_data['tmp_unique_id'] = $unique_id;
					$template_details_data['tmp_name'] 		= $post_temp_data[0]['tmp_name'];
					$template_details_data['tb_name'] 		= strtolower('tb_temp_'.$unique_id);
					$template_details_data['tat_time']  	= $tat_time;
					
					unset($post_temp_data[0]);
					unset($post_temp_data[1]);

					$flag_cat = 0; $flag_aat_id = 0;$flag_total_weightage = 0; $cat_colums = array();$fields = array();
					foreach($post_temp_data as $each_temp_data)
					{
						foreach($each_temp_data as $eachsec_key => $eachsec)
						{
							$flag_cat++;
							$t_cat_name = $eachsec[0]['sec_title'];
							unset($eachsec[0]);							
							foreach($eachsec as $eachQustion_no => $eachQustionData)
							{
								$flag_aat_id++;
								$att_name = '';  $flag_aat_id < 10?$att_name = '0'.($flag_aat_id):$att_name = ($flag_aat_id);
								$template_data[($flag_aat_id - 1)]['t_unique_id'] 		= $unique_id;
								$template_data[($flag_aat_id - 1)]['t_name'] 			= $tmp_name;
								$template_data[($flag_aat_id - 1)]['t_cat_id'] 			= 'cat'.($flag_cat);
								$template_data[($flag_aat_id - 1)]['t_cat_name'] 		= $t_cat_name;
								$template_data[($flag_aat_id - 1)]['t_ques_description'] = (!empty($eachQustionData['ques_description'])?$eachQustionData['ques_description']:null);
								$template_data[($flag_aat_id - 1)]['t_att_name'] 		= $eachQustionData['ques_text'];
								$template_data[($flag_aat_id - 1)]['t_att_id']   		= 'att'.$att_name.'_sel';
								$template_data[($flag_aat_id - 1)]['t_is_required'] 	= $eachQustionData['ques_required'];
								$template_data[($flag_aat_id - 1)]['t_option_type'] 	= $eachQustionData['ans_type'];
								$template_data[($flag_aat_id - 1)]['t_is_multiselect'] 	= $eachQustionData['ans_multi_sel'];
								$template_data[($flag_aat_id - 1)]['t_kpi'] 			= (!empty($eachQustionData['ans_kpi_multi_sel'])?implode('|',$eachQustionData['ans_kpi_multi_sel']):null);

								/////////////////////////////////////////////// For dynamic table creation makeing array start
								$cat_colums['cat'.($flag_cat)] 		= array('type' => 'text');
								$cat_colums['cat'.($flag_cat).'_d'] = array('type' => 'text');
								$fields['att'.$att_name.'_score'] 	= array('type' => 'text');
								$fields['att'.$att_name.'_sel'] 	= array('type' => 'text');
								//$fields['att'.$att_name.'_file'] 	= array('type' => 'text');
								$fields['att'.$att_name.'_fail'] 	= array('type' => 'text');
								$fields['att'.$att_name.'_com'] = array('type' =>'text');
								//$fields['att'.$att_name.'_content'] = array('type' =>'text');
								///////////////////////////////////////////////// For dynamic table creation makeing array end
								//print_r($eachQustionData);die;
								// echo postRequestResponse($eachQustionData);die;
								if($eachQustionData['ans_type'] == 'select'){
									$each_option = []; $flag = 0;
									//echo postRequestResponse($eachQustionData['ans_value']);
									foreach($eachQustionData['ans_value'] as $each_option_data)
									{
										//echo postRequestResponse($each_option_data);die;
										if($flag == 1){
											$each_option['t_option_value']   .= (!empty($each_option_data['ans_text'])? $each_option_data['ans_text'].'|':null);
											$each_option['t_option_score']   .= (!empty($each_option_data['ans_score'])? $each_option_data['ans_score'].'|':'0|');
											$each_option['t_option_failed']  .= (!empty($each_option_data['ans_failed'])? $each_option_data['ans_failed'].'|':null);
											$each_option['t_option_color']   .= (!empty($each_option_data['ans_color'])? $each_option_data['ans_color'].'|':null);
											$each_option['t_option_bgcolor'] .= (!empty($each_option_data['ans_bg_color'] )? $each_option_data['ans_bg_color'].'|':null);
										}
										else {
											$each_option['t_option_value']   = (!empty($each_option_data['ans_text'])?$each_option_data['ans_text'].'|':null);
											$each_option['t_option_score']   = (!empty($each_option_data['ans_score'])?$each_option_data['ans_score'].'|':'0|');
											$each_option['t_option_failed']  = (!empty($each_option_data['ans_failed'])?$each_option_data['ans_failed'].'|':null);
											$each_option['t_option_color']   = (!empty($each_option_data['ans_color'])?$each_option_data['ans_color'].'|':null);
											$each_option['t_option_bgcolor'] = (!empty($each_option_data['ans_bg_color'])?$each_option_data['ans_bg_color'].'|':null);
											$flag = 1;
										}
										//$flag_total_weightage += $each_option_data['ans_score'];
										$flag_total_weightage += (!empty($each_option_data['ans_score'])? $each_option_data['ans_score']:0);
									}
									//******
									$template_data[($flag_aat_id - 1)]['t_option_value'] 	= (!empty($each_option['t_option_value'])?(rtrim($each_option['t_option_value'],'|')):null);
									$template_data[($flag_aat_id - 1)]['t_option_score'] 	= (!empty($each_option['t_option_score'])?(rtrim($each_option['t_option_score'],'|')):null);
									$template_data[($flag_aat_id - 1)]['t_option_failed']	= (!empty($each_option['t_option_failed'])?(rtrim($each_option['t_option_failed'],'|')):null);
									$template_data[($flag_aat_id - 1)]['t_option_color'] 	= (!empty($each_option['t_option_color'])?(rtrim($each_option['t_option_color'],'|')):null);
									$template_data[($flag_aat_id - 1)]['t_option_bgcolor'] 	= (!empty($each_option['t_option_bgcolor'])?(rtrim($each_option['t_option_bgcolor'],'|')):null);
									
								}
								else if($eachQustionData['ans_type'] == 'textarea' || $eachQustionData['ans_type'] == 'text' || $eachQustionData['ans_type'] == 'date' || $eachQustionData['ans_type'] == 'checkbox'){
									$each_option = []; $flag = 0;
									//echo postRequestResponse($eachQustionData['ans_value']['ans_score']);die;
									foreach($eachQustionData['ans_value'] as $each_option_data)
									{
										$template_data[($flag_aat_id - 1)]['t_option_value'] 	= null;
										$template_data[($flag_aat_id - 1)]['t_option_score'] 	= (!empty($each_option_data['ans_score'])?$each_option_data['ans_score']:0);
										$template_data[($flag_aat_id - 1)]['t_option_failed'] 	= null;
										$template_data[($flag_aat_id - 1)]['t_option_color'] 	= null;
										$template_data[($flag_aat_id - 1)]['t_option_bgcolor'] 	= null;
										
										!empty($each_option_data['ans_score'])? $flag_total_weightage += $each_option_data['ans_score']:$flag_total_weightage += 0;
									}
								}
							}
						}
						$template_details_data['tmp_attributes'] = $flag_aat_id;
						$template_details_data['tmp_weightage']  = $flag_total_weightage;
						$template_details_data['temp_status'] 	 = '1';
					}

					//die;
					// echo postRequestResponse($template_data);die;
				
					// drop table start
					$template_details_response = $this->common->delete_data_response('template_details',['tmp_unique_id'=>$result_temp_info[0]['tmp_unique_id']]);
					$template_response = $this->common->delete_data_response('template',['t_unique_id'=>$result_temp_info[0]['tmp_unique_id']]);
					$drop_table_response = $this->common->drop_table_response($result_temp_info[0]['tb_name']);
					// drop table end
					// insert in table Start////////////////////////////////////////////
					$response_table_ctreated = $this->db->query('CREATE TABLE '.strtolower('tb_temp_'.$unique_id).' LIKE sample_template');
					if($response_table_ctreated)
					{
						$this->load->dbforge();
						$this->dbforge->add_column(strtolower('tb_temp_'.$unique_id),$fields);
						$this->dbforge->add_column(strtolower('tb_temp_'.$unique_id),$cat_colums);
						$response_template_details = $this->common->insert_data($template_details_data,'template_details');
						$response_template         = $this->common->insert_batch_data('template',$template_data);
						$response_msg[] = 'success';
						//echo postRequestResponse('success');
					}
					else{
						$response_msg[] = 'error';
						//echo postRequestResponse('error');
					}
					// insert in table end ////////////////////////////////////////////
					
				}
				else{
					$response_msg[] = 'error';
					//echo postRequestResponse('error');
				}
			// }
			// else{
			// 	$response_msg[] = 'error';
			// }
		}else{
			/// insert template 
			//echo postRequestResponse('KKKKKKKKKKKK');die;
			$response_msg[] = $this->pre_template_insert($unique_id,$post_temp_data,$tat_time);
			//$response_msg[] = 'error';
			//echo postRequestResponse('error');
		}
		//echo postRequestResponse($response_msg);die;
		// if(in_array("error", $response_msg))
		// {
		// 	echo postRequestResponse('errorrr');
		// }
		// else
		// {
		// 	echo postRequestResponse('success');
		// }
		if(in_array("error", $response_msg))
		{
			echo postRequestResponse('errorrr');
		}
		else
		{
			if(!empty($welcomesetup_other_form))
			{
				$result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
				echo postRequestResponse('welcomesetup_other_form_success');
			}else{
				echo postRequestResponse('success');
			}
			
		}

		///////////////////////////////////////////////////
	}

	public function pre_template_insert($unique_id,$post_data,$tat_time,$copy=""){
		
		//echo postRequestResponse($tat_time);die;
		$post_temp_data = $post_data;
		$tmp_name 		= $post_temp_data[0]['tmp_name'];
		$template_data 	= [];
		$template_details_data = [];
		//echo postRequestResponse($post_temp_data);die;
		if(!empty($post_temp_data))
		{
			//$template_details_data['tmp_unique_id'] = $unique_id;
			$checkFormcopy ="";
			$new_tmp_unique_id = uniqid().rand(10,10000000);
			$template_details_data['tmp_unique_id'] = $new_tmp_unique_id;
			
			$template_details_data['tb_name'] 		= strtolower('tb_temp_'.$new_tmp_unique_id);
			$template_details_data['tat_time']  	= $tat_time;
			if(!empty($copy))
			{
			$template_details_data['old_form_unique_id']      = $unique_id;
			$checkFormcopy = $this->common->getDistinctWhereSelectCount('template_details',['old_form_unique_id','form_version_no'],['old_form_unique_id'=>$unique_id]);
			$template_details_data['form_version_no'] = ($checkFormcopy +1);
			}else{
				$template_details_data['old_form_unique_id']      = " ";
				$template_details_data['form_version_no'] = "";
			}
			$template_details_data['tmp_name'] 		= (!empty($copy) && $copy=='copy')?$post_temp_data[0]['tmp_name']."_copy_".($checkFormcopy +1):$post_temp_data[0]['tmp_name'];
			unset($post_temp_data[0]);
			unset($post_temp_data[1]);
			//echo postRequestResponse($post_temp_data);die;
			$flag_cat = 0; $flag_aat_id = 0;$flag_total_weightage = 0; $cat_colums = array();$fields = array();
			//echo postRequestResponse('QQQQQ');die;
			foreach($post_temp_data as $each_temp_data)
			{
				foreach($each_temp_data as $eachsec_key => $eachsec)
				{
					$flag_cat++;
					$t_cat_name = $eachsec[0]['sec_title'];
					unset($eachsec[0]);
					
					foreach($eachsec as $eachQustion_no => $eachQustionData)
					{
						
						$flag_aat_id++;
						$att_name = '';  $flag_aat_id < 10?$att_name = '0'.($flag_aat_id):$att_name = ($flag_aat_id);
						$template_data[($flag_aat_id - 1)]['t_unique_id'] 		= $new_tmp_unique_id;
						$template_data[($flag_aat_id - 1)]['t_name'] 			= $tmp_name;
						$template_data[($flag_aat_id - 1)]['t_cat_id'] 			= 'cat'.($flag_cat);
						$template_data[($flag_aat_id - 1)]['t_cat_name'] 		= $t_cat_name;
						$template_data[($flag_aat_id - 1)]['t_ques_description'] = (!empty($eachQustionData['ques_description'])?$eachQustionData['ques_description']:null);
						$template_data[($flag_aat_id - 1)]['t_att_name'] 		= $eachQustionData['ques_text'];
						$template_data[($flag_aat_id - 1)]['t_att_id']   		= 'att'.$att_name.'_sel';
						$template_data[($flag_aat_id - 1)]['t_is_required'] 	= $eachQustionData['ques_required'];
						$template_data[($flag_aat_id - 1)]['t_option_type'] 	= $eachQustionData['ans_type'];
						$template_data[($flag_aat_id - 1)]['t_is_multiselect'] 	= $eachQustionData['ans_multi_sel'];
						$template_data[($flag_aat_id - 1)]['t_kpi'] 			= (!empty($eachQustionData['ans_kpi_multi_sel'])?implode('|',$eachQustionData['ans_kpi_multi_sel']):null);

						/////////////////////////////////////////////// For dynamic table creation makeing array start
                        // $cat_colums['cat'.($flag_cat)] 		= array('type' => 'VARCHAR', 'constraint' => '100');
                        // $cat_colums['cat'.($flag_cat).'_d'] = array('type' => 'VARCHAR', 'constraint' => '100');
                        // $fields['att'.$att_name.'_score'] 	= array('type' => 'VARCHAR', 'constraint' => '100');
                        // $fields['att'.$att_name.'_sel'] 	= array('type' => 'VARCHAR','constraint' => '100');
                        // $fields['att'.$att_name.'_file'] 	= array('type' => 'VARCHAR','constraint' => '100');
                        // $fields['att'.$att_name.'_fail'] 	= array('type' => 'VARCHAR','constraint' => '100');
						// $fields['att'.$att_name.'_com'] 	= array('type' =>'text');
						
						$cat_colums['cat'.($flag_cat)] 		= array('type' => 'text');
						$cat_colums['cat'.($flag_cat).'_d'] = array('type' => 'text');
						$fields['att'.$att_name.'_score'] 	= array('type' => 'text');
						$fields['att'.$att_name.'_sel'] 	= array('type' => 'text');
						//$fields['att'.$att_name.'_file'] 	= array('type' => 'text','constraint' => '200');
						$fields['att'.$att_name.'_fail'] 	= array('type' => 'text');
						$fields['att'.$att_name.'_com'] = array('type' =>'text');
                        //$fields['att'.$att_name.'_content'] = array('type' =>'text');
						///////////////////////////////////////////////// For dynamic table creation makeing array end
						
						if($eachQustionData['ans_type'] == 'select'){
							$each_option = []; $flag = 0;
							foreach($eachQustionData['ans_value'] as $each_option_data)
							{
								//echo postRequestResponse($each_option_data);die;
								if($flag == 1){
									$each_option['t_option_value']   .= (!empty($each_option_data['ans_text'])? $each_option_data['ans_text'].'|':null);
									$each_option['t_option_score']   .= (!empty($each_option_data['ans_score'])? $each_option_data['ans_score'].'|':'0|');
									$each_option['t_option_failed']  .= (!empty($each_option_data['ans_failed'])? $each_option_data['ans_failed'].'|':null);
									$each_option['t_option_color']   .= (!empty($each_option_data['ans_color'])? $each_option_data['ans_color'].'|':null);
									$each_option['t_option_bgcolor'] .= (!empty($each_option_data['ans_bg_color'] )? $each_option_data['ans_bg_color'].'|':null);
								}
								else {
									$each_option['t_option_value']   = (!empty($each_option_data['ans_text'])?$each_option_data['ans_text'].'|':null);
									$each_option['t_option_score']   = (!empty($each_option_data['ans_score'])?$each_option_data['ans_score'].'|':'0|');
									$each_option['t_option_failed']  = (!empty($each_option_data['ans_failed'])?$each_option_data['ans_failed'].'|':null);
									$each_option['t_option_color']   = (!empty($each_option_data['ans_color'])?$each_option_data['ans_color'].'|':null);
									$each_option['t_option_bgcolor'] = (!empty($each_option_data['ans_bg_color'])?$each_option_data['ans_bg_color'].'|':null);
									$flag = 1;
								}
								//$flag_total_weightage += $each_option_data['ans_score'];
								$flag_total_weightage += (!empty($each_option_data['ans_score'])? $each_option_data['ans_score']:0);
							}
							//******
							$template_data[($flag_aat_id - 1)]['t_option_value'] 	= (!empty($each_option['t_option_value'])?(rtrim($each_option['t_option_value'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_score'] 	= (!empty($each_option['t_option_score'])?(rtrim($each_option['t_option_score'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_failed']	= (!empty($each_option['t_option_failed'])?(rtrim($each_option['t_option_failed'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_color'] 	= (!empty($each_option['t_option_color'])?(rtrim($each_option['t_option_color'],'|')):null);
							$template_data[($flag_aat_id - 1)]['t_option_bgcolor'] 	= (!empty($each_option['t_option_bgcolor'])?(rtrim($each_option['t_option_bgcolor'],'|')):null);
							
						}
						else if($eachQustionData['ans_type'] == 'textarea' || $eachQustionData['ans_type'] == 'text' || $eachQustionData['ans_type'] == 'date' || $eachQustionData['ans_type'] == 'checkbox'){
							$each_option = []; $flag = 0;
							//echo postRequestResponse($eachQustionData['ans_value']['ans_score']);die;
							foreach($eachQustionData['ans_value'] as $each_option_data)
							{
								$template_data[($flag_aat_id - 1)]['t_option_value'] 	= null;
								$template_data[($flag_aat_id - 1)]['t_option_score'] 	= (!empty($each_option_data['ans_score'])?$each_option_data['ans_score']:0);
								$template_data[($flag_aat_id - 1)]['t_option_failed'] 	= null;
								$template_data[($flag_aat_id - 1)]['t_option_color'] 	= null;
								$template_data[($flag_aat_id - 1)]['t_option_bgcolor'] 	= null;
								
								!empty($each_option_data['ans_score'])? $flag_total_weightage += $each_option_data['ans_score']:$flag_total_weightage += 0;
							}
						}
					}
				}
				$template_details_data['tmp_attributes'] = $flag_aat_id;
				$template_details_data['tmp_weightage']  = $flag_total_weightage;
				$template_details_data['temp_status'] 	 = '1';
			}
			//echo postRequestResponse($template_data);die;
			// insert in table Start///////////////////////
			$response_table_ctreated = $this->db->query('CREATE TABLE '.strtolower('tb_temp_'.$new_tmp_unique_id).' LIKE sample_template');
			if($response_table_ctreated)
			{
				$this->load->dbforge();
                $this->dbforge->add_column(strtolower('tb_temp_'.$new_tmp_unique_id),$fields);
				$this->dbforge->add_column(strtolower('tb_temp_'.$new_tmp_unique_id),$cat_colums);
				
				$response_template_details = $this->common->insert_data($template_details_data,'template_details');
				$response_template         = $this->common->insert_batch_data('template',$template_data);
				//echo postRequestResponse($template_data);die;
				return 'success';
			}
			else {
				$this->session->set_flashdata('error', 'Template is not create try again ....');
				//echo postRequestResponse('error');
				return 'error';
			}
			// insert in table End/////////////////////////
			//echo postRequestResponse($template_details_data);
			//echo postRequestResponse($flag_total_weightage);
			//echo postRequestResponse($temp_data);
		}
	}
	
	public function custom_kpi()
    {
		if($this->emp_group == "admin"){
			$template_details = $this->common->getSelectAll('template_details',['tmp_unique_id','tmp_name']);
			$custom_kpi_details = $this->common->getSelectAll('custom_kpi',['kpi_id','kpi_name']);
			// echo '<pre>';
            // print_r($custom_kpi_details);
			// echo '</pre>';die;
            $this->load->view('other/custom_kpi_view',compact('template_details','custom_kpi_details'));
        }
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);
        }
        //$this->load->view('other/custom_kpi_view');
	}

	public function attribute_list_kpi()
    {
		if($this->emp_group == "admin"){
			//echo postRequestResponse($this->input->post());die;
			//$data = 
			$attribute_details   =  $this->common->getDistinctWhereSelect('template',['t_unique_id','t_att_name','t_att_id'],['t_unique_id'=>$this->input->post('tmp_unique_id')]); 
			$data['attribute_details']   =  $this->common->getDistinctWhereSelect('template',['t_unique_id','t_att_name','t_att_id'],['t_unique_id'=>$this->input->post('tmp_unique_id')]); 
			$data['custom_kpi_details'] = $this->common->getSelectAll('custom_kpi',['kpi_id','kpi_name']);
			
			echo postRequestResponse($data);
        }
        //$this->load->view('other/custom_kpi_view');
	}
	
	public function kpi_add()
    {
		$kpi_name = $this->input->post('kpi_name');
		if(!empty($kpi_name)){
			$reasult = $this->common->insert_data(['kpi_name'=>$kpi_name],'custom_kpi');
			if($reasult) { 
				echo postRequestResponse($reasult);
			}
			else{
				echo postRequestResponse('error');
			}
		}
		else{
			echo postRequestResponse('error');
		}
	}
	public function kpi_delete()
    {
		$kpi_id = $this->input->post('kpi_id');
		$kpi_name = $this->input->post('kpi_name');
		if(!empty($kpi_name) && !empty($kpi_id)){
			$reasult = $this->common->delete_data('custom_kpi',['kpi_id'=>$kpi_id,'kpi_name'=>$kpi_name]);
			if($reasult) { 
				echo postRequestResponse('Success');
			}
			else{
				echo postRequestResponse('error');
			}
		}
		else{
			echo postRequestResponse('error');
		}
	}
	public function kpi_update()
    {
		$kpi_id = $this->input->post('kpi_id');
		$kpi_name = $this->input->post('kpi_name');
		if(!empty($kpi_name) && !empty($kpi_id)){
			$reasult = $this->common->update_data_info('custom_kpi',['kpi_name'=>$kpi_name],['kpi_id'=>$kpi_id]);
			if($reasult) { 
				echo postRequestResponse('Success');
			}
			else{
				echo postRequestResponse('error');
			}
		}
		else{
			echo postRequestResponse('error');
		}
	}

	public function kpi_save()
    {
		$post_data = $this->input->post('kpi_data');
		//echo postRequestResponse($post_data[0]['all_kpi']);die;
		$all_kpi = rtrim($post_data[0]['all_kpi'],'|');
		$t_unique_id = $post_data[0]['t_unique_id'];
		array_splice($post_data, 0, 1);
		$response_msg =[];
		$results = $this->common->update_data_info('template_details',['kpi_details'=>$all_kpi],['tmp_unique_id'=>$t_unique_id]);
		if($results){
			foreach($post_data as $each_attr_data)
			{
				$kpi_val = (!empty($each_attr_data['t_kpi_val'])?$each_attr_data['t_kpi_val']:null);
				$result = $this->common->update_data_info('template',['t_kpi'=>$kpi_val],['t_att_id'=>$each_attr_data['t_att_id'],'t_unique_id'=>$t_unique_id]);
				if($result){
					$response_msg[] = 'success';
				}
				else {
					$response_msg[] = 'error';
				}
				//$data[$each_attr_data['t_att_id']] = (!empty($each_attr_data['t_kpi_val'])?$each_attr_data['t_kpi_val']:null);
			}
			$response_msg[] = 'success';
		}
		else {
			$response_msg[] = 'error';
		}
		
		 if(in_array("error", $response_msg))
		{
			echo postRequestResponse('error');
		}
		else
		{
			echo postRequestResponse('success');
		}
		//$reasult = $this->common->update_data_info('custom_kpi',['kpi_name'=>$kpi_name],['kpi_id'=>$kpi_id]);
		//echo postRequestResponse($data);die;
		// if(!empty($kpi_name) && !empty($kpi_id)){
		// 	$reasult = $this->common->update_data_info('custom_kpi',['kpi_name'=>$kpi_name],['kpi_id'=>$kpi_id]);
		// 	if($reasult) { 
		// 		echo postRequestResponse('Success');
		// 	}
		// 	else{
		// 		echo postRequestResponse('error');
		// 	}
		// }
		// else{
		// 	echo postRequestResponse('error');
		// }
	}
	public function print_result($request)
    {
        echo '<pre>';
        print_r($request);
        echo '</pre>';
        echo '<br>';
       // die;
    }

//please write above	
}
 