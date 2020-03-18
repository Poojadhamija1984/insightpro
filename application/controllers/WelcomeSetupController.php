<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WelcomeSetupController extends MY_Controller {
	protected $steps = [];
	public function __construct(){
		parent::__construct();
		$this->steps = $this->common->getDistinctWhereSelectRow('client',['mokup_steps'],['client_id'=>$this->session->userdata('client_id')]);
	}
	public function index(){
			$result = $this->common->update_data_info('client',['mokup_steps'=>'0'],['client_id'=>$this->session->userdata('client_id')]);
			$this->load->view('other/welcome_setup_view');
		
	}
	public function setup_complate(){
		$result = $this->common->update_data_info('client',['mokup_steps'=>'5'],['client_id'=>$this->session->userdata('client_id')]);
		$this->load->view('other/welcome_setup_complate_view');
	}

	public function templates(){
		$result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
	
		$template_details_pre = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_unique_id','industry_type','template_type'],['industry_type'=>$this->session->userdata('industry_type')]);
		// echo '<pre>';
		// print_r($template_details_pre);
		// echo '</pre>';die;
		//echo $this->db->last_query();
		$this->load->view('other/templates_setup_view',compact('template_details_pre'));
	}
	
	
	public function site_setup(){
		$result = $this->common->update_data_info('client',['mokup_steps'=>'3'],['client_id'=>$this->session->userdata('client_id')]);
		$this->load->view('other/site_setup_view');
	}
	
	public function skip_setup($mokup_steps){
		$result = $this->common->update_data_info('client',['mokup_steps'=>$mokup_steps],['client_id'=>$this->session->userdata('client_id')]);
		//$result = $this->common->update_data_info('client',['mokup_steps'=>'5'],['client_id'=>$this->session->userdata('client_id')]);
		landingPage();
		//redirect('user-management');
	}
	
	// public function templates_create(){
	// 	$result = $this->common->update_data_info('client',['mokup_steps'=>'2'],['client_id'=>$this->session->userdata('client_id')]);
	// 	$this->load->view('other/template_create_setup_view');
	// }

	// public function other_form_edit($tmp_unique_id,$pre_temp = null){
	// 	$result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
	// 	//RRRRRRRRRRRRRRRRRRRRR
	// 	//echo $tmp_unique_id;
	// 	if(!empty($pre_temp) && $pre_temp == 'selected')
	// 	{
	// 		//echo "PPPPPper";die;
	// 		$result_template_details_info = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_name'],['tmp_unique_id'=>$tmp_unique_id]);
	// 	}
	// 	else {	
	// 		//echo "NONE per";die;
	// 		$result_template_details_info = $this->common->getDistinctWhereSelect('template_details',['tmp_name'],['tmp_unique_id'=>$tmp_unique_id]);
	// 	}
	// 	// echo $this->db->last_query();
	// 	// $this->print_result($result_template_details_info);die;
	// 	$template_data = [];
	// 	if(!empty($result_template_details_info[0]['tmp_name']))
	// 	{
	// 		$tmp_name = $result_template_details_info[0]['tmp_name'];
	// 		if(!empty($pre_temp)  && $pre_temp == 'selected')
	// 		{
	// 			$result_template_info = $this->common->getDistinctWhereSelectOtherdb('db_others','template_pre','*',['t_unique_id'=>$tmp_unique_id]);
	// 		}
	// 		else {	
	// 			$result_template_info = $this->common->getDistinctWhereSelect('template','*',['t_unique_id'=>$tmp_unique_id]);
	// 		}
			
	// 		//$this->print_result($result_template_info);die;
	// 		$flag = 0;
	// 		foreach($result_template_info as $each_qustion)
	// 		{
	// 			//$this->print_result($each_qustion);
	// 			if(array_key_exists($each_qustion['t_cat_id'],$template_data))
    //             {
	// 				//echo "<br> found ";
	// 				$template_data[$each_qustion['t_cat_id']][] = $each_qustion;
	// 			}
	// 			else {
	// 				//echo "<br> NOT ";
	// 				$template_data[$each_qustion['t_cat_id']][] = $each_qustion;
	// 			}
	// 		}
	// 		//$this->print_result($template_data);
	// 	}
		
	// 	$welcomesetup_other_form = 'yes';
    //   	$this->load->view('other/template_edit_view',compact('template_data','tmp_name','tmp_unique_id','welcomesetup_other_form')); 
	// }

	// public function template_list_others(){
	// 	$result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
	// 	$template_details_pre = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_unique_id','industry_type','template_type'],['industry_type !='=>'']);
	// 	$industry_type_template = [];
	// 	if(!empty($template_details_pre)){
	// 		foreach ($template_details_pre as $key => $value) {
	// 			if(array_key_exists($value['industry_type'],$industry_type_template)){
	// 				$industry_type_template[trim($value['industry_type'])][]=['tmp_unique_id'=>$value['tmp_unique_id'],'template_type'=>$value['template_type']];
	// 			}
	// 			else{
	// 				$industry_type_template[trim($value['industry_type'])][]=['tmp_unique_id'=>$value['tmp_unique_id'],'template_type'=>$value['template_type']];
	// 			}
	// 		}
	// 	}
		
		
    // 	$this->load->view('other/welcomeSetup_templateListOther_view' ,compact('industry_type_template'));
	// 	//////////////////
	// 	// $result = $this->common->update_data_info('client',['mokup_steps'=>'1'],['client_id'=>$this->session->userdata('client_id')]);
	// 	// $this->load->view('other/template_create_setup_view');
	// }
	
	// public function template_edit($tmp_unique_id){
	// 	$result = $this->common->update_data_info('client',['mokup_steps'=>'4'],['client_id'=>$this->session->userdata('client_id')]);
	// 	$tmp_unique_id;
	// 	$result_template_details_info = $this->common->getDistinctWhereSelectOtherdb('db_others','template_details_pre',['tmp_name'],['tmp_unique_id'=>$tmp_unique_id]);
	// 	//$this->print_result($result_template_details_info);die;
	// 	$template_data = [];
	// 	$tmp_name = '';
	// 	if(!empty($result_template_details_info[0]['tmp_name']))
	// 	{
	// 		$tmp_name = (!empty($result_template_details_info[0]['tmp_name']))?$result_template_details_info[0]['tmp_name']:'';
	// 		$result_template_info = $this->common->getDistinctWhereSelectOtherdb('db_others','template_pre','*',['t_unique_id'=>$tmp_unique_id]);
	// 		//$this->print_result($result_template_info);die;
	// 		$flag = 0;
	// 		foreach($result_template_info as $each_qustion)
	// 		{
	// 			//$this->print_result($each_qustion);
	// 			if(array_key_exists($each_qustion['t_cat_id'],$template_data))
    //             {
	// 				//echo "<br> found ";
	// 				$template_data[$each_qustion['t_cat_id']][] = $each_qustion;
	// 			}
	// 			else {
	// 				//echo "<br> NOT ";
	// 				$template_data[$each_qustion['t_cat_id']][] = $each_qustion;
	// 			}
	// 		}
	// 		//$this->print_result($template_data);die;
	// 	}
	// 	else {
	// 		//echo "No Data Found";
	// 	}
	// 	//$this->load->view('other/template_edit_view',compact('template_data','tmp_name','tmp_unique_id'));
	// 	$this->load->view('other/template_select_setup_view',compact('template_data','tmp_name','tmp_unique_id')); 
	// }

	
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
