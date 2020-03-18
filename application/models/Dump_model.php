<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dump_model extends CI_Model
{
    /*
     *Purpose : Constructor function 
     */
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
    }
     
   function get_dump($fromdate,$todate,$form_name,$form_version,$lob,$channels)
   {
    $meta_data = $this->common->getDistinctWhereSelect('form_matadata','label_name,field_name');  // for mata data
    $res_attrubutes = $this->common->getDistinctWhereSelect('forms','attribute,attr_id',['client_id'=>$this->client_id,'form_name'=>$form_name,'form_version'=>$form_version]); /// for attributes
    $res_category = $this->common->getDistinctWhereSelect('forms','category,cat_id',['client_id'=>$this->client_id,'form_name'=>$form_name,'form_version'=>$form_version]);     /// for cat
    $meta_data_fields = '';

    foreach($meta_data as $value){
        $meta_data_fields.=$value['field_name']." as '".str_replace("'",'`',$value['label_name'])."',";
    }
    foreach($res_attrubutes as $value){
        $meta_data_fields.=$value['attr_id']." as '".str_replace("'",'`',$value['attribute'])."',";
    }
    foreach($res_category as $value){
        $meta_data_fields.=$value['cat_id']." as '".str_replace("'",'`',$value['category'])."',";
    }
            
    
    $this->db->select($meta_data_fields);
    $this->db->from($form_name);
    $this->db->where("date(submit_time) >=", date('Y-m-d', strtotime($fromdate)));
    $this->db->where("date(submit_time) <=", date('Y-m-d', strtotime($todate)));
    //$this->db->where('submit_time BETWEEN "'. date('Y-m-d', strtotime($fromdate)). '" and "'. date('Y-m-d', strtotime($todate)).'"');
    $this->db->where(['form_version'=>$form_version]);
    $this->db->where(['channels'=>$channels]);
    /// for supervisor client only
    if($this->session->userdata('emp_group') == 3 && $this->session->userdata('usertype') == 3){
       $this->db->where(['supervisor_id'=>$this->session->userdata('empid')]);
    }
    /// for Client Agent only
    if($this->session->userdata('emp_group') == 3 && $this->session->userdata('usertype') == 2){
       $this->db->where(['agent_id'=>$this->session->userdata('empid')]);
    }

    /// for Ops Agent only
    if($this->session->userdata('emp_group') == 2 && $this->session->userdata('usertype') == 2){
       $this->db->where(['evaluator_id'=>$this->session->userdata('empid')]);
    }
    if(!empty($lob)){
       $this->db->where(['lob'=>$lob]);
    }
     return $query = $this->db->get(); 
   }
		
///for non bpo code 
function get_dumpData($fromdate,$todate,$tb_name)
{
    $t_unique_id = substr($tb_name,8);
    // echo "<pre>";
    $meta_data = $this->common->getDistinctWhereSelect('form_matadata','label_name,field_name');  // for mata data
    $res_attrubutes = $this->common->getDistinctWhereSelect('template','t_att_name,t_att_id',['t_unique_id'=>$t_unique_id]); /// for attributes
    // print_r($res_attrubutes);die;
    $res_category = $this->common->getDistinctWhereSelect('template','t_cat_name,t_cat_id',['t_unique_id'=>$t_unique_id,'t_cat_id!='=>'cat1','t_cat_name!='=>'blank_sec']);     /// for cat
    $meta_data_fields = '';
    foreach($meta_data as $value){
        $meta_data_fields.=$value['field_name']." as '".$value['label_name']."',";
    }
    foreach($res_attrubutes as $value){
        $meta_data_fields.=$value['t_att_id']." as '".str_replace("'",'`',$value['t_att_name'])."',";
    }
    foreach($res_category as $value){
        $meta_data_fields.=$value['t_cat_id']." as '".str_replace("'",'`',$value['t_cat_name'])."',";
    }
            
    //$table  = strtolower($form_name);
    $this->db->select($meta_data_fields);
    $this->db->from($tb_name);
    $this->db->where("date(submit_time) >=", date('Y-m-d', strtotime($fromdate)));
    $this->db->where("date(submit_time) <=", date('Y-m-d', strtotime($todate)));
     return $query = $this->db->get(); 
}


//please write above....	
}
?>