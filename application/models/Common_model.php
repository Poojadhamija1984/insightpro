<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Common_model extends CI_Model {
    
    // get employee list
    public function checkAction($table,$con="")
    {
     $this->db->select('*');
     $this->db->from($table);
     $this->db->where($con);
     $query = $this->db->get();
     $result = $query->num_rows();
     return ($result > 0) ? FALSE :TRUE;

    }
    public function getWhere($table,$where) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    public function insert_data($data,$table_name){
		$this->db->insert($table_name, $data);
		return $this->db->insert_id(); 
	}
	public function update_data($table,$data,$where) {
        $this->db->where($where);
        $rsult = $this->db->update($table, $data);
        $afftectedRows=$this->db->affected_rows();
        if($afftectedRows)
        {
           return 'data has successfully been updated';
        }
        else {
            return 'not updated';
        }
    }
    public function delete_data($table,$where) {
        $this->db->delete($table, $where);
        return 'data has successfully deleted';
    }
    
    public function drop_table($table) {
        //$this->db->delete($table);
        $this->load->dbforge();
        $this->dbforge->drop_table($table,TRUE);
       // echo $this->db->last_query();die;
        //return 'data has successfully deleted';
    }

    public function getAllData($table){
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_batch_data($table,$data){
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }
    

    public function getWhereSelect($table,$select,$where,$limit=null, $start=null) {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        $row =  $query->result_array();
        foreach ($row as $key => $value) {
            return $value[$select];
        }
    }
    public function getWhereSelectLimit($table,$select,$where,$limit=null, $start=null) {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }
    public function getSelectAll($table,$select){
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        $query = $this->db->get();
        
        return $query->result();
    }
    public function getWhereSelectAll($table,$select,$where=null){
        $this->db->select($select);
        $this->db->from($table);
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result();
    } 
    public function getWhereInSelectAll($table,$select,$whereColumn,$whereData){
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where_in($whereColumn,$whereData);
        $query = $this->db->get();
        return $query->result();
    }
    public function getWhereInWhereSelectAll($table,$select,$where,$whereColumn,$whereData){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->where_in($whereColumn,$whereData);
        $query = $this->db->get();
        return $query->result();
    } 
    
     public function getDistinctWhere($table,$select,$where) {
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    // Rajesh ///////////////////////////////////////////////////////////////////////////
    public function delete_data_response($table,$where) {
        $response = $this->db->delete($table, $where);
        return $response ;
    }
    
    public function drop_table_response($table) {
        //$this->db->delete($table);
        $this->load->dbforge();
        $response = $this->dbforge->drop_table($table,TRUE);
        return $response ;
       // echo $this->db->last_query();die;
        //return 'data has successfully deleted';
    }

    public function update_data_info($table,$data,$where) {
        $this->db->where($where);
        return $rsult = $this->db->update($table, $data);
    }
    
    public function getDistinctWhereSelect($table,$select,$where=null) {
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        if($where){
            $this->db->where($where); 
        }
       
        $query = $this->db->get();
       // echo $this->db->last_query();die;
      return  $result =  $query->result_array();
    }
    public function getDistinctWhereSelectOtherdb($otherDbName,$table,$select,$where=null) {
        $other_db = $this->load->database($otherDbName, TRUE);
        $other_db->distinct();
        $other_db->select($select);
        $other_db->from($table);
        if($where){
            $other_db->where($where); 
        }
       
        $query = $other_db->get();
        return $query->result_array();
    }

    public function getDistinctLikeSelectOtherdb($otherDbName,$table,$select,$where=null) {
        $other_db = $this->load->database($otherDbName, TRUE);
        $other_db->distinct();
        $other_db->select($select);
        $other_db->from($table);
        if($where){
            $other_db->like($where);
        }
       
        $query = $other_db->get();
        return $query->result_array();
    }

    public function getDistinctWhereSelectRow($table,$select,$where=null) {
        // it return a single row as object not array always access by arrow
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        if($where){
            $this->db->where($where); 
        }
       
        $query = $this->db->get();
       // echo $this->db->last_query();die;
      return  $result =  $query->row();
    }
    public function getDistinctWhereSelectCount($table,$select,$where=null) {
        // it return a single row as object not array always access by arrow
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        if($where){
            $this->db->where($where); 
        }
       
        $query = $this->db->get();
       // echo $this->db->last_query();die;
      return  $result =  $query->num_rows();
    }
    //public function aaaaaa($table,$select,$whereinColumnNname,$wherein,$distinct=null){
    public function getDistinctWhereINSelect($table,$select,$whereinColumnNname,$wherein,$distinct=null){
       // $this->db->distinct($distinct);
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where_in($whereinColumnNname,$wherein);
        if($distinct){
            $this->db->group_by($distinct);
        }
        //$this->db->having('lob','CareTouch');
        //$this->db->distinct();
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getDistinctWhereSelectOderby($table,$select,$where,$odercolumn,$order) {
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        $this->db->order_by($odercolumn,$order);
        $this->db->where($where); 
        $query = $this->db->get();
       // echo $this->db->last_query();die;
      return  $result =  $query->result_array();
    }
    public function getDistinctWhereSelectOderbyLimt($table,$select,$where,$odercolumn,$order,$limit,$limit_ofset=0) {
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        $this->db->order_by($odercolumn,$order);
        $this->db->where($where); 
        $this->db->limit($limit, $limit_ofset);
        $query = $this->db->get();
       // echo $this->db->last_query();die;
      return  $result =  $query->result_array();
    }
    // return max value of an column
    public function getMaxWhere($table,$maxColumName,$where) {
        $this->db->select_max($maxColumName);
        $this->db->where($where);
        $this->db->from($table);
        $query = $this->db->get();
       // echo $this->db->last_query();die;
       //return  $result =  ($query->row_array())[$maxColumName];
      return  $result =  ($query->row_array());
    }

    public function getWhereSelectAllFromTo($table,$select,$where,$datetype,$fromdate,$todate){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->where("date($datetype) >=", date('Y-m-d', strtotime($fromdate)));
        $this->db->where("date($datetype) <=", date('Y-m-d', strtotime($todate)));
       // $this->db->where($datetype.' BETWEEN "'. date('Y-m-d', strtotime($fromdate)). '" and "'. date('Y-m-d', strtotime($todate)).'"');
        $query = $this->db->get();
        return $query->result();
    } 
    public function getWhereSelectAllFromToArray($table,$distinct,$select,$where,$datetype,$fromdate,$todate){
        $this->db->select($select);
        $this->db->from($table);
        if($where){
            $this->db->where($where);
        }
        $this->db->where("date($datetype) >=", date('Y-m-d', strtotime($fromdate)));
        $this->db->where("date($datetype) <=", date('Y-m-d', strtotime($todate)));
       // $this->db->where($datetype.' BETWEEN "'. date('Y-m-d', strtotime($fromdate)). '" and "'. date('Y-m-d', strtotime($todate)).'"');
        $this->db->group_by($distinct);
        $query = $this->db->get();
        return $query->result_array();
    } 
    
   public function getWhereSelectDistinctCount($table,$select,$where,$distinct=null){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        if($distinct){
            $this->db->group_by($distinct);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
  

   public function getSelectDistinctCount($table,$select,$distinct=null){
        $this->db->select($select);
        $this->db->from($table);
        if($distinct){
            $this->db->group_by($distinct);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
//    public function getSelectDistinct($table,$select,$where_in,$distinct=null){
//         $this->db->select($select);
//         $this->db->from($table);
        
//         if($distinct){
//             $this->db->group_by($distinct);
//         }
//         $this->db->having($where_in);
//         $query = $this->db->get();
//         return $query->result_array();
//     }
    
    public function getWhereSelectAllToArray($table,$select,$where=null){
        $this->db->select($select);
        $this->db->from($table);
        if($where){
        $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result_array();
    } 

    public function getAllSelectData($table,$select){
        $this->db->select($select);
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getFindInSet($table,$select,$colValue,$colField){
        $this->db->select($select);
        $this->db->from($table);
        // $where = "FIND_IN_SET('".$colValue."', ".$colField.")";
        $where = "FIND_IN_SET(".$colValue.", ".$colField.")";
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
   
    public function getWhereSelectRowArray($table,$where){
        $query = $this->db->select('*')->from($table)->where($where)->get();
        return $query->row_array();
    }

    function showTableFields($tableName)
	{
		$fields=array();
		$fields = $this->db->list_fields($tableName);
		return $fields;
	}
    public function getAllWhere($table,$where) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    

    //dump
    // public function getWhereSelectAlll($table,$select,$where){
    //     $this->db->select($select);
    //     $this->db->from($table);
    //     $this->db->where($where);
    //     $query = $this->db->get();
    //     return $query;
    // } 


    public function dynamicSelect($dynamicDB, $where) {
        $dynamicDB = $this->load->database($dynamicDB, TRUE);
        $dynamicDB->select('*');
        $dynamicDB->where($where);
        $dynamicDB->from('user');
        $query = $dynamicDB->get();
        return $query->result();
    }
    public function dynamicUpdate($dynamicDB, $data,$where) {
        $dynamicDB = $this->load->database($dynamicDB, TRUE);
        $dynamicDB->where($where);
        $rsult = $dynamicDB->update('user', $data);
        return $rsult;
    }
    // jai..........
    public function site_group_wise($table,$user_id=0,$formId="",$dateRange="",$dateRange_other="",$sg="", $type="",$sd="",$ed="")
    {
        if($dateRange_other=="Today")
        {
        $till_date = $this->dateRange($dateRange_other);
        $start_date = $till_date["date(submit_time) >="];
        $end_date   = $till_date["date(submit_time) <="]; 
        $this->db->select('count(tmp_unique_id) as total_evulation,avg(total_score) as total_evulation_avg,DATE_FORMAT(submit_time, "%d-%b-%y") as day');
       }else if($dateRange_other=="Custom")
       {
           
        $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sd));
        $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($ed));
        $start_date = $till_date["date(submit_time) >="];
        $end_date   = $till_date["date(submit_time) <="]; 
        $this->db->select('count(tmp_unique_id) as total_evulation,avg(total_score) as total_evulation_avg,DATE_FORMAT(submit_time, "%d-%b-%y") as day');
        }else
        {
        $till_date = $this->daterange_week($dateRange_other);
        $start_date = $till_date["date(submit_time) >="];
        $end_date   = $till_date["date(submit_time) <="]; 
        $this->db->select('count(tmp_unique_id) as total_evulation,avg(total_score) as total_evulation_avg,MONTHNAME(submit_time) as day, EXTRACT(YEAR FROM submit_time) as yr');
        }
        
        $this->db->from($table);
        $this->db->where('evaluator_id',$user_id);
        $this->db->where('tmp_unique_id',$formId);
        $this->db->where('DATE(submit_time) >=',$start_date);
        $this->db->where('DATE(submit_time) <=',$end_date);
        $this->db->group_by('day');
        $sgwhere = ""; 
        if($type=="site")
        {
        $s                   =  implode('|', explode(',',$sg));
        $sgwhere             =  'site_id REGEXP "(^|,)'.$s.'(,|$)"';

        }else if($type=='group')
        {
        $g                      =  implode('|', explode(',',$sg));
        $sgwhere             =  'group_id REGEXP "(^|,)'.$g.'(,|$)"';
        }
        $this->db->where($sgwhere);
        
       //$this->db->group_by(array("tmp_unique_id", "DATE(submit_time)")); 
        $query = $this->db->get();
        return $query->result_array();
        
    }
     public function getTemplateDetails($site = null,$group = null){
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
            $sql  =   "SELECT td.tb_name as tn,group_id,site_id,td.tmp_unique_id,td.temp_status as status, DATE_FORMAT(td.created_date,'%Y-%m-%d') as cd,
            (select GROUP_CONCAT(DISTINCT g_name ) from groups where find_in_set(g_id,td.group_id)) as g,
            (select GROUP_CONCAT(DISTINCT s_name ) from sites where find_in_set(s_id,td.site_id))as s,td.tmp_name as template_name
            FROM template_details AS td WHERE $where AND tmp_unique_id = '$form_id' ";
            $query  =   $this->db->query($sql);
            $result = $query->result();
        }
    }else{
        if(!empty($where)){
            $sql =   "SELECT td.tb_name as tn,group_id,site_id,td.tmp_unique_id,td.temp_status as status,td.tat_time ,DATE_FORMAT(td.created_date,'%Y-%m-%d') as cd,
            (select GROUP_CONCAT(DISTINCT g_name ) from groups where find_in_set(g_id,td.group_id)) as g,
            (select GROUP_CONCAT(DISTINCT s_name ) from sites where find_in_set(s_id,td.site_id))as s,td.tmp_name as template_name
            FROM template_details AS td WHERE $where";
            $query =   $this->db->query($sql);
            $result = $query->result();
        }
    }
        // echo $this->db->last_query();
        // print_r($result);die;
        return $result;
        // print_r($result);die;
    }
    public function getWhereSelect_auditor($table,$user_id=0,$formId="",$dateRange="",$dateRange_other="",$site="",$group="",$sd="",$ed="")
    {
        if($dateRange_other=='Custom')
        {
        $till_date["date(submit_time) >="] = date('Y-m-d',strtotime($sd));
        $till_date["date(submit_time) <="] = date('Y-m-d',strtotime($ed));
        }else{
        $till_date = $this->dateRange($dateRange_other);
       }
        
        $start_date = $till_date["date(submit_time) >="];
        $end_date   = $till_date["date(submit_time) <="];
        $s                      =  implode('|', explode(',',$site));
        $site_where             =  'site_id REGEXP "(^|,)'.$s.'(,|$)"'; 
        $g                      =  implode('|', explode(',',$group));
        $group_where            =  'group_id REGEXP "(^|,)'.$g.'(,|$)"';
        $this->db->select('count(tmp_unique_id) as total_evulation,avg(total_score) as total_evulation_avg');
        $this->db->from($table);
        $this->db->where('evaluator_id',$user_id);
        $this->db->where('tmp_unique_id',$formId);
        $this->db->where('DATE(submit_time) >=',$start_date);
        $this->db->where('DATE(submit_time) <=',$end_date);
        $this->db->where($site_where);
        $this->db->where($group_where);
        //$this->db->group_by(array("tmp_unique_id", "DATE(submit_time)")); 
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getAuditscore($table,$user_id=0,$formId="",$dateRange="",$dateRange_other="",$site="",$group="",$sd="",$ed="")
    {
        
        $all_audit_sql = '';
        if($dateRange_other=='Today')
        {
        $till_date = $this->daterange($dateRange_other);
        $start_date = $till_date["date(submit_time) >="];
        $end_date   = $till_date["date(submit_time) <="];
        }else{
            $start_date = date('Y-m-d',strtotime($sd));
            $end_date = date('Y-m-d',strtotime($ed));
        }
        if($dateRange_other=="Custom" || $dateRange_other=="Today")
        {
        
        $all_audit_sql ="SELECT unique_id,total_score,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $table  WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' and evaluator_id = $user_id UNION ALL ";
        $ovelall_words = explode( "UNION ALL", $all_audit_sql);
        array_splice( $ovelall_words, -1 );
        $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
        $overall_total_qa_sql ="SELECT t.mtd as day,count(unique_id) as count , ROUND(avg(total_score)) as tscore  FROM ($overall_qa_total_sql)t GROUP BY mtd ORDER BY STR_TO_DATE(day, '%d-%M-%y') ASC";  
        $overall_query = $this->db->query($overall_total_qa_sql); 
        }
        else{
            $till_date = $this->daterange_week($dateRange_other);
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="];
            if($dateRange=='Monthly')
            {
            $all_audit_sql ="SELECT count(unique_id) as count,ROUND(avg(total_score)) as tscore,MONTHNAME(submit_time) as day, EXTRACT(YEAR FROM submit_time) as yr,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $table  WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' and evaluator_id = $user_id ";
            }else{
            $all_audit_sql ="SELECT count(unique_id) as count,ROUND(avg(total_score)) as tscore,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $table  WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' and evaluator_id = $user_id";  
            }
            $overall_query = $this->db->query($all_audit_sql);
        }
        $day_wise_audit = $overall_query->result_array();
        return  $day_wise_audit;
    }
    // for reviewer 
    public function getAllAuditCount($table,$s_date="",$e_date="",$time_filter_type="",$time_filter="")
    {
        if($time_filter_type=='Daily')
        {
        $start_date = date('Y-m-d',strtotime($s_date));
        $end_date = date('Y-m-d',strtotime($e_date));
        $all_audit_sql ="SELECT unique_id,total_score,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $table  WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
        $ovelall_words = explode( "UNION ALL", $all_audit_sql);
        array_splice( $ovelall_words, -1 );
        $overall_qa_total_sql = implode( "UNION ALL", $ovelall_words );
        $overall_total_qa_sql ="SELECT t.mtd as day,count(unique_id) as count , ROUND(avg(total_score)) as tscore  FROM ($overall_qa_total_sql)t GROUP BY mtd ORDER BY STR_TO_DATE(day, '%d-%M-%y') ASC";  
        $overall_query = $this->db->query($overall_total_qa_sql); 
        }else 
        {
            $till_date = $this->daterange_week($time_filter);
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="];
            if($time_filter_type=='Monthly')
            {
            $all_audit_sql ="SELECT count(unique_id) as count,ROUND(avg(total_score)) as tscore,MONTHNAME(submit_time) as day, EXTRACT(YEAR FROM submit_time) as yr,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $table  WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' ";
            }else{
            $all_audit_sql ="SELECT count(unique_id) as count,ROUND(avg(total_score)) as tscore,DATE_FORMAT(submit_time, '%d-%b-%y') as mtd FROM  $table  WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date'";  
            }
            $overall_query = $this->db->query($all_audit_sql);
        }
        $day_wise_audit = $overall_query->result_array();
        return  $day_wise_audit;
    }
    public function getCardsData($table,$s_date="",$e_date="",$time_filter_type="",$time_filter="")
    {
        $top_auditor_sql = '';
        if($time_filter_type=='Daily')
            {
                $start_date = date('Y-m-d',strtotime($s_date));
                $end_date = date('Y-m-d',strtotime($e_date));
            $top_auditor_sql .="SELECT count(audit_sr_no) as total,sum(total_score) as ts FROM  $table WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
            }else{
                $till_date = $this->daterange(implode("_",$time_filter));
                $start_date = $till_date["date(submit_time) >="];
                $end_date   = $till_date["date(submit_time) <="];
               
                $top_auditor_sql .="SELECT count(audit_sr_no) as total,sum(total_score) as ts FROM  $table WHERE  DATE(submit_time) >= '$start_date' AND DATE(submit_time) <= '$end_date' UNION ALL ";
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
            return $data;

    }
    public function fetchReviews($table,$sd="",$ed="",$time_filter_type="",$time_filter="")
    {
        if($time_filter_type=="Daily")
        {
        $start_date = date('Y-m-d',strtotime($sd));
        $end_date = date('Y-m-d',strtotime($ed));
        }else{
            $till_date = $this->daterange(implode("_",$time_filter));
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="]; 
        }
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('DATE(submit_time) >=',$start_date);
        $this->db->where('DATE(submit_time) <=',$end_date);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getBreackdownData($template_details,$template_option_response,$sd,$ed,$time_filter_type="",$time_filter=""){

        if($time_filter_type=="Daily")
        {
        $start_date = date('Y-m-d',strtotime($sd));
        $end_date = date('Y-m-d',strtotime($ed));
        }else{
            $till_date = $this->daterange($time_filter);
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="]; 
        }
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
    public function faildAttributeResponse($table,$sd,$ed,$time_filter_type="",$time_filter=""){
        // failed item
        // echo "<pre>";
        //print_r($template_details);die;
        if($time_filter_type=="Daily")
        {
        $start_date = date('Y-m-d',strtotime($sd));
        $end_date = date('Y-m-d',strtotime($ed));
        }else{
            $till_date = $this->daterange($time_filter);
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="]; 
        }
        
        $failed_item_attr_sql   =   '';
        $data                   =   [];
        $top                   =   [];
        $total_question        =   [];
        $template_details = $this->common->getAllWhere('template_details',['tb_name'=>$table]);
        foreach ($template_details as $lkey => $lvalue) {
            $table_n =$lvalue['tb_name'];
            $temp_name = $lvalue['tmp_name'];
            $btableName = str_replace('tb_temp_','',$lvalue['tb_name']);
            //$failed_item_attr_sql .="SELECT t_att_id,'$lvalue->tb_name' as TableName,'$lvalue->tmp_name' as template_name,t_att_name FROM  template  WHERE  t_name = '$btableName' and t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
            $failed_item_attr_sql .="SELECT t_att_id,'$table_n' as TableName,'$temp_name' as template_name,t_att_name FROM  template  WHERE  t_unique_id = '$btableName' and t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
            $total_question[$lvalue['tmp_name']] = $this->common->getWhereSelectAll('template',['count(t_id) as total_question'],['t_cat_id !=' => 'cat1','t_name' =>$temp_name]);
            
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
            
            $data['top'][] = [];
            $data['bottom'][] = [];
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
    public function actionItemCharts($table,$sd="",$ed="",$time_filter_type="",$time_filter=""){
        if($time_filter_type=="Daily")
        {
        $start_date = date('Y-m-d',strtotime($sd));
        $end_date = date('Y-m-d',strtotime($ed));
        }else{
            $till_date = $this->daterange_week($time_filter);
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="]; 
        }
        $attr_name_data = '';
        $template_details = $this->common->getAllWhere('template_details',['tb_name'=>$table]);
        foreach ($template_details as $key => $t_value) {
            $table_n =$t_value['tb_name'];
            $temp_name = $t_value['tmp_name'];
            $tmp_unique_id = str_replace("tb_temp_", "",$table_n);
            $attr_name_data .="SELECT t_att_name,t_att_id,'$table_n' AS TableName,'$temp_name' AS TemplateName,'$tmp_unique_id' as tmp_unique_id  FROM  template WHERE t_unique_id = '$tmp_unique_id' AND t_cat_id != 'cat1' AND t_option_type = 'select' UNION ALL ";
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
            if($time_filter_type=="Daily" || $time_filter_type=="Weekly")
        {
            $failed_sql .="SELECT t1.unique_id, '$attributeName' as attributeName,'$templateName' as templateName,DATE_FORMAT(submit_time, '%d-%b-%y') as day,EXTRACT(YEAR FROM submit_time) as yr,'$att_value->t_att_id' as t_att_id,'$TableName' as TableName,(select status from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as status,(select att_comment from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as att_comment FROM $tableNmae t1
            WHERE t1.$attFail ='yes' AND DATE(submit_time) >= '$start_date' and DATE(submit_time) <= '$end_date' UNION ALL "; 
        }else
        $failed_sql .="SELECT t1.unique_id, '$attributeName' as attributeName,'$templateName' as templateName,MONTHNAME(submit_time) as day, EXTRACT(YEAR FROM submit_time) as yr,'$att_value->t_att_id' as t_att_id,'$TableName' as TableName,(select status from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as status,(select att_comment from action_status where unique_id = t1.unique_id and att_id ='$att_value->t_att_id') as att_comment FROM $tableNmae t1
            WHERE t1.$attFail ='yes' AND DATE(submit_time) >= '$start_date' and DATE(submit_time) <= '$end_date'  UNION ALL "; 
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
        $yr =0;
        $day =0;
        if(!empty($failed_overall_result)){
            //var_dump($failed_overall_result);die();
            foreach($failed_overall_result as $f_key => $f_value) {
                $status =   $f_value->status;
                $cmt    =   $f_value->att_comment;
                $status =   (($status  == '1') ? 'Overdue' : (($status == '2') ? 'Closed' : 'Pending'));
                $day =  $f_value->day;
                $yr  =  $f_value->yr;
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
            
            $data[] = [
                'status'=>  'Overdue',
                'avg'   =>  (($inprogressCount > 0)?round((($inprogressCount/count($failed_overall_result))*100),2):0).'%' ,
                'color'=>'#4ba33b',
                'day'=>$day,
                'yr'=>$yr 
            ];
            $data[] = [
                'status'=>'Pending',
                'avg'   =>  (($pendingCount > 0)?round((($pendingCount/count($failed_overall_result))*100),2):0).'%' ,
                'color'=>'#db5383',
                'day'=>$day,
                'yr'=>$yr
            ];
            $data[] = [
                'status'=>'Closed',
                'avg'   =>  (($closedCount > 0)?round((($closedCount/count($failed_overall_result))*100),2):0).'%' ,
                'color'=>'#63b3d3',
                'day'=>$day,
                'yr'=>$yr
            ];
        }
        }
        else{
            $data[] = ['status'=>'Overdue','avg'=>$inprogressCount,'color'=>'#4ba33b','day'=>$day,'yr'=>$yr];
            $data[] = ['status'=>'Pending','avg'=>$pendingCount,'color'=>'#db5383','day'=>$day,'yr'=>$yr];
            $data[] = ['status'=>'Closed','avg'=>$closedCount,'color'=>'#63b3d3','day'=>$day,'yr'=>$yr];
        }
        
        // print_r($data);die;
        return $data;
    }
    // category avg fetch
    public function CategoryAvg($table,$cat="",$sd="",$ed="",$time_filter_type="",$time_filter="")
    {
        if($time_filter_type=="Daily")
        {
        $start_date = date('Y-m-d',strtotime($sd));
        $end_date = date('Y-m-d',strtotime($ed));
        }else{
            $till_date = $this->daterange($time_filter);
            $start_date = $till_date["date(submit_time) >="];
            $end_date   = $till_date["date(submit_time) <="]; 
            
        }
      $this->db->select("avg($cat) as cat_avg_count");
      $this->db->from($table);
      $this->db->where('date(submit_time) >=',$start_date);
      $this->db->where('date(submit_time) <=',$end_date);
      $query=$this->db->get();
      return $query->result_array();
    }



    // end
    //common function
     public function fetchcommon($table,$where="",$distinct="")
     {
         
         $this->db->select('*');
         $this->db->from($table);
         if(!empty($where))
         {
             $this->db->where($where);
         }
         if(!empty($distinct))
         {
             $this->db->distinct($distinct);
         }
         $query=$this->db->get();
         return $query->result_array();
         

     }
    //end
    public function daterange_week($datType)
    {
        
        $today = date('Y-m-d');
        if($datType =="1_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-6 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="2_Weeks" ){
            $oneday_next = date('Y-m-d', strtotime('-6 day', strtotime($today)));
            $oneday = date('Y-m-d', strtotime('-13 day', strtotime($today)));
            
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $oneday_next;
        }
        if($datType =="3_Weeks" ){
            $oneday_next = date('Y-m-d', strtotime('-13 day', strtotime($today)));
            $oneday = date('Y-m-d', strtotime('-20 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $oneday_next;
            
        }
        if($datType =="4_Weeks" ){
            $oneday_next = date('Y-m-d', strtotime('-20 day', strtotime($today)));
            $oneday = date('Y-m-d', strtotime('-27 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $oneday_next;
        }
        if($datType =="1_Months" ){
            
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-1 month'));
            $where["date(submit_time) <="] = date('Y-m-d');
        }
        if($datType =="2_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-2 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-1 month'));
        }
       
        if($datType =="3_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-3 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-2 month'));
        }
        if($datType =="4_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-4 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-3 month'));
        }
        if($datType =="5_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-5 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-4 month'));
        }
        if($datType =="6_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-6 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-5 month'));
        }
        if($datType =="7_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-7 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-6 month'));
        }
        if($datType =="8_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-8 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-7 month'));
        }
        if($datType =="9_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-9 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-8 month'));
        }
        if($datType =="10_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-10 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-9 month'));
        }
        if($datType =="11_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-11 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-10 month'));
        }
        if($datType =="12_Months" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('-12 month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('-11 month'));
        }
        return $where;
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
        if($datType =="1_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-7 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="2_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-14 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="3_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-21 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="4_Weeks" ){
            $oneday = date('Y-m-d', strtotime('-28 day', strtotime($today)));
            $where["date(submit_time) >="] = $oneday;
            $where["date(submit_time) <="] = $today;
        }
        if($datType =="PreviousMonth" ){
            $where["date(submit_time) >="] = date('Y-m-d', strtotime('first day of last month'));
            $where["date(submit_time) <="] = date('Y-m-d', strtotime('last day of last month'));
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
   
}
 
?>