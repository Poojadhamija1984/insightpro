<?php
class Forms_model extends CI_Model
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
     
    function getform($form_name,$action,$unique_id,$tableName,$version)
	{
	
		$data="";
		if($action=='fill' || $action=='audit' || $action=='callibrate' || $action =='ata' || ($action=='escalate' && $this->session->userdata('emp_group')=='2'))
		{
			$disabled="";
			$readonly="";
		}else{
			$disabled="disabled";
			$readonly="readonly";
		}
		
		//callibaration date name for select data from callibartion table
       if($action == 'callibrate_view'){
		$tableName = 'calibration_'.$tableName;
	   }
		 
		//Count attribue and category exit or not....
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
		$this->db->where("form_version",$version);
		$res=$this->db->get();
		$result=$res->result_array();
		$num_rows=$res->num_rows();

		if($num_rows>0)
		{
			$formData=$this->getFormData($unique_id,$tableName);
            $tableFields=$this->showTableFields($tableName);
             $arr_length = sizeof($tableFields);
			// Make dynamic variable 
			for($i = 0; $i < $arr_length; $i++) {
				if(!empty($formData))
				{
				  ${$tableFields[$i]}=isset($formData[$tableFields[$i]])?$formData[$tableFields[$i]]:"";
				}else{
				  ${$tableFields[$i]}="";
				}
			}
			$data="";
			$categories=$this->get_distinct_category($form_name,$version);
			$cat_count=1;
			foreach($categories as $category)
			{
			$data.= '<div class="card accordion_card mt-12">
			 			<div class="card-content p-0">
							<div class="card_header d-flex justify-content-between align-items-center">';
							if($action=='fill') {
								$data.= '<h4 class="card-title m-0">'.$category['category'].'</h4>
								<div class="counter">
									<span class="counter_text">Score</span>
									<input type="text" id="'.$category['cat_id'].'" name="'.$category['cat_id'].'" class="browser-default counter_value cat_input" value="" readonly>
								</div>
							</div>';
							} else {
								$data.= '<h4 class="card-title m-0">'.$category['category'].'</h4>
								<div class="counter">
									<span class="counter_text">Score</span>
									<input type="text" id="'.$category['cat_id'].'" name="'.$category['cat_id'].'" class="browser-default counter_value cat_input" value="'.${$category['cat_id']}.'" placeholder="" readonly>
								</div>
							</div>';
							}
				
             $attributes=$this->get_attributes($form_name,$version,$category['category']);
             $attr_count=1;
             foreach($attributes as $attribute)
			 {
                if($attr_count==1)
                {
                    $data.='<div class="card-body">';
                    $data.='<table class="striped highlight">';
                    $data.='<thead>';
                    $data.='<tr>';
                    $data.='<th class="tbl_attr">Attribute Name</th>';
                    $data.='<th>Rating</th>';
                    $data.='<th>Comment</th>';								
					$data.='<th class="tbl_score">Score</th>';
					if($action == 'escalate') {
						//find Agent comment....
						 $agentCMT = $this->checkRecords('escalation_'.$tableName,$unique_id,3,2);
						 //find superviosr comment....
						 $supCMT = $this->checkRecords('escalation_'.$tableName,$unique_id,3,3);
						 if($agentCMT>0){
							$data.='<th>Agent </th>';
						 }
					     if($supCMT > 0) {
							$data.='<th>Supervisor </th>';	
						 }
							
					}	
                    $data.='</tr>';
                    $data.='</thead>';
                    $data.='<tbody>';
				}
				   $kpiArray = explode("|" , $attribute['kpi_metrics']);
				   $kpi = "";
				   foreach($kpiArray as $kpiValue){
					($kpiValue == 1) ? $kpi .= 'CAST' : '';
					($kpiValue == 2) ? $kpi .= ' Resolution' : '';
					($kpiValue == 3) ? $kpi .= ' Sales' : '';
					($kpiValue == 4) ? $kpi .= ' Retention' : '';
				} 
                    $data.='<tr>';
                    $data.='<td class="tbl_attr"><span class="tbl_attr_text">'.$attribute['attribute'].'</span><span class="badge attr_badge">'.$kpi.'</span></td>';

                    $data.='<td><select '.$disabled.' class="clsForPreFatal" name="'.$attribute['attr_id'].'" id="'.$attribute['attr_id'].'" onchange="setscore(`'.$attribute['attr_id'].'`,$(this).find(`option:selected`).attr(`score`),this.value,`'.$category['cat_id'].'`)" required>';
                    $data.='<option  value="">Select</option>';
                    $ratings=explode("|",$attribute['rating']);
                    foreach($ratings as $rating)
                    {
                    if($action=='fill')
                    {
                        $selected="";
                    }
                    else
                    {
                        if($rating==${$attribute['attr_id']})
                        {
                            $selected="selected";
                        }else{
                            $selected="";
                        }
                    }
                    $PreFatalScore=$this->PreFatalScore(trim($rating),$attribute['weightage']);
                    $score=$this->checkValue(trim($rating),$attribute['weightage']);
                    // To scorable condition
                     if($attribute['scorable']=='yes'){
                     	$score = 'score='."$score"; 
                     	$PreFatalScore='forPreFatalScore='."$PreFatalScore";
                     }else {
                     	$score = ''; 
                     	$PreFatalScore= '';
                     }
                    ////end
                    $data.='<option '.$selected.' '.$score.'  '.$PreFatalScore.' value="'.trim($rating).'">'.trim($rating).'</option>';
                    }
                    $data.='</td>';
                    $attr=substr($attribute['attr_id'],0,5);
                    $attr_com=$attr.'_com';
                    $attr_score=$attr.'_score';
                    if($action=='fill')
                    {
                    $data.='<td><textarea '.$readonly.'   id="'.$attr_com.'" name="'.$attr_com.'" class="materialize-textarea"></textarea></td>';

                    $data.='<td class="tbl_score">';
                    ///if attribute is scorable then visible
                    if($attribute['scorable']=='yes'){
                    $data.='<input readonly type="text"  name="'.$attr_score.'" id="'.$attr_score.'" value="" class="'.$category['cat_id'].' forTotalScore">';
                    }
                    $data.= '</td>';									
                    }
                    else
                    {
                    $data.='<td><textarea '.$readonly.'   id="'.$attr_com.'" name="'.$attr_com.'" class="materialize-textarea">'.${$attr_com}.'</textarea></td>';								
                    $data.='<td class="tbl_score">';
                    //if attribure is scorable then visible
                    if($attribute['scorable']=='yes'){
                    $data.='<input readonly type="text"  name="'.$attr_score.'" id="'.$attr_score.'" value="'.${$attr_score}.'" class="'.$category['cat_id'].' forTotalScore">';
                    }
                    $data.='</td>';
					}
					if($action == 'escalate') {
						 if($agentCMT > 0) {
						 $data.='<td><textarea '.$readonly.'  class="materialize-textarea">'.$agentCMT[$attr_com].'</textarea></td>';
						 }
						 if($supCMT > 0) {
						$data.='<td><textarea '.$readonly.'  class="materialize-textarea">'.$supCMT[$attr_com].'</textarea></td>';
						 }
					}
                    $data.='</tr>';	

                
                if($attr_count==count($attributes))
                {
                $data.='</tbody>';
                $data.='</table>';
                }
               $data.='</div>';
                 /* End Panel Body */
            $attr_count++;
             }
			//  $data .= '</li>';
			 $data.= '</div>
				</div>';
			$cat_count++;	
			} 
			
			
		}
		return $data;
	}
		
/*
**Get calibaration report..........
*/
    function getreport($form_name,$unique_id,$tableName,$version,$action)
	{
		 $data="";
		 $disabled="disabled";
		 $readonly="readonly";
		//Count attribue and category exit or not....
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
		$this->db->where("form_version",$version);
		$res=$this->db->get();
		$result=$res->result_array();
		$num_rows=$res->num_rows();

		if($num_rows>0)
		{
			$formData=$this->getFormData($unique_id,$tableName);
            $tableFields=$this->showTableFields($tableName);
             $arr_length = sizeof($tableFields);
			// Make dynamic variable 
			for($i = 0; $i < $arr_length; $i++) {
				if(!empty($formData))
				{
				  ${$tableFields[$i]}=isset($formData[$tableFields[$i]])?$formData[$tableFields[$i]]:"";
				}else{
				  ${$tableFields[$i]}="";
				}
			}
			//For calibration data
			if($action == 'callibrate_view'){
			$OpsRecords = $this->checkRecords('calibration_'.$tableName,$unique_id,2,3);
			$clientRecords = $this->checkRecords('calibration_'.$tableName,$unique_id,3,3);
			}
	        //for ATA data
			if($action == 'ata_view'){
		       $AgentRecords = $this->getATAdata($tableName,['unique_id'=>$unique_id]);
			   $ATARecords = $this->getATAdata('ata_'.$tableName,['unique_id'=>$unique_id]);
			}

			$categories=$this->get_distinct_category($form_name,$version);
			$cat_count=1;
			foreach($categories as $category)
			{
			$data.= '<div class="card accordion_card reports mt-12">
			 			<div class="card-content p-0">
							<div class="card_header d-flex justify-content-between align-items-center">';
			$data.= '</div>';
							
				        
             $attributes=$this->get_attributes($form_name,$version,$category['category']);
             $attr_count=1;
             foreach($attributes as $attribute)
			 {
                if($attr_count==1)
                {
                    $data.='<div class="card-body">';
                    $data.='<table class="striped highlight">';
					$data.='<thead>';
					$data.='<tr class="heading_row">';
					$data.='<th class="tbl_attr"><h4 class="card-title m-0">'.$category['category'].'</h4></th>';

					if($action == 'callibrate_view'){
					if($OpsRecords){  	
					$data.='<th colspan="3">
								<div class="counter">
									<span class="counter_text">Ops Score</span>
									<input type="text" class="browser-default counter_value cat_input" value="'.$OpsRecords[$category['cat_id']].'" placeholder="" readonly="">
								</div>
							</th>';
						}
					if($clientRecords){	
					$data.='<th colspan="3">
								<div class="counter">
									<span class="counter_text">Client Score</span>
									<input type="text" class="browser-default counter_value cat_input" value="'.$clientRecords[$category['cat_id']].'" placeholder="" readonly="">
								</div>
							</th>';
						}
                     }

                     if($action == 'ata_view'){ 
                      if($AgentRecords){
                     	$data.='<th colspan="3">
								<div class="counter">
									<span class="counter_text">Agent Score</span>
									<input type="text" class="browser-default counter_value cat_input" value="'.$AgentRecords[$category['cat_id']].'" placeholder="" readonly="">
								</div>
							</th>';
						}
					if($ATARecords){		
					$data.='<th colspan="3">
								<div class="counter">
									<span class="counter_text">ATA SCORE</span>
									<input type="text" class="browser-default counter_value cat_input" value="'.$ATARecords[$category['cat_id']].'" placeholder="" readonly="">
								</div>
							</th>';
						}
                     } 

					$data.='</tr>';
                    $data.='<tr>';
					$data.='<th class="tbl_attr">Attribute Name</th>';
                  /***********for calibration table heading***************/	
					if($action == 'callibrate_view'){
						///ops records
						if($OpsRecords){
							$data.='<th>Ops Rating</th>';
							$data.='<th>Comment</th>';								
							$data.='<th class="tbl_score">Score</th>';
						}
						
						if($clientRecords){
						//client records
						$data.='<th>Client Rating</th>';
						$data.='<th>Comment</th>';								
						$data.='<th class="tbl_score">Score</th>';
					  }
					} //end
					
                    /*************For ATA table heading *********************************/			
						if($action == 'ata_view'){
							///ops records
							if($AgentRecords){
								$data.='<th>Agent Rating</th>';
								$data.='<th>Comment</th>';								
								$data.='<th class="tbl_score">Score</th>';
							}
							
							if($ATARecords){
							//client records
							$data.='<th>ATA Rating</th>';
							$data.='<th>Comment</th>';								
							$data.='<th class="tbl_score">Score</th>';
						  }
						} //end
                    $data.='</tr>';
                    $data.='</thead>';
                    $data.='<tbody>';
					
					
				}
				   $attr=substr($attribute['attr_id'],0,5);
                    $data.='<tr>';
                    $data.='<td class="tbl_attr">'.$attribute['attribute'].'</td>';
					$attr_sel = $attr.'_sel';
					$attr_com=$attr.'_com';
					$attr_score=$attr.'_score';

                   /********for calibration  rows ***************/					
                    if($action == 'callibrate_view') {
						 //ops records
						 if($OpsRecords){
						$data.='<td><input readonly type="text"  value="'.$OpsRecords[$attr_sel].'"></td>';
							$data.='<td><textarea '.$readonly.'    class="materialize-textarea">'.$OpsRecords[$attr_com].'</textarea></td>';	

							$data.='<td class="tbl_score">';
					         //To attribute scorable 
							if($attribute['scorable']=='yes'){
								$data.='<input readonly type="text"  value="'.$OpsRecords[$attr_score].'">';
							}
							$data .= '</td>';
							 }
							//client records..
							if($clientRecords){
					      $data.='<td><input readonly type="text"  value="'.$clientRecords[$attr_sel].'"></td>';
							$data.='<td><textarea '.$readonly.' class="materialize-textarea">'.$clientRecords[$attr_com].'</textarea></td>';	

						   $data .='<td class="tbl_score">';
						   //To attribute scorable..
						   if($attribute['scorable']=='yes'){
						   $data .='<input readonly type="text"   value="'.$clientRecords[$attr_score].'">';
					     	}
						  $data  .='</td>';
							}
					}
                   

                     /***********for ATA rows******************/
					if($action == 'ata_view'){
						//ops records
						if($AgentRecords){
							$data.='<td ><input readonly type="text"  value="'.$AgentRecords[$attr_sel].'""</td>';
							$data.='<td><textarea '.$readonly.'    class="materialize-textarea">'.$AgentRecords[$attr_com].'</textarea></td>';								
							$data.='<td class="tbl_score">';
							/// To scorable attribute only
							if($attribute['scorable']=='yes'){
							$data.='<input readonly type="text"  value="'.$AgentRecords[$attr_score].'">';
						    }
							$data.='</td>';
							 }
							//client records..
							if($ATARecords){
							$data.='<td><input readonly type="text"  value="'.$ATARecords[$attr_sel].'""</td>';
							$data.='<td><textarea '.$readonly.'    class="materialize-textarea">'.$ATARecords[$attr_com].'</textarea></td>';								
							$data.='<td class="tbl_score">';
                            /// To Scorable attribute only
                            if($attribute['scorable']=='yes'){
							 $data.='<input readonly type="text"   value="'.$ATARecords[$attr_score].'">';
						     }
							$data.='</td>';
							}
					}
                    $data.='</tr>';	

                
                if($attr_count==count($attributes))
                {
                $data.='</tbody>';
                $data.='</table>';
                }
               $data.='</div>';
                 /* End Panel Body */
            $attr_count++;
             }
			//  $data .= '</li>';
			 $data.= '</div>
				</div>';
			$cat_count++;	
			} 
			
			
		}
		return $data;
	}
		
///common function 
	function getATAdata($table,$where)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
        return $query->row_array();
	}

    function showTableFields($tableName)
	{
		$fields=array();
		$fields = $this->db->list_fields($tableName);
		return $fields;
	}

	
	function get_distinct_category($form_name,$version)
	{	
		$this->db->distinct();
		$this->db->select('category,cat_id');
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
		$this->db->where("form_version",$version);
		$res=$this->db->get();
		$result=$res->result_array();
		return $result;
	}
    
    
    function get_attributes($form_name,$version,$category="")
	{
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
		$this->db->where("form_version",$version);
		if($category!="")
		{
			$this->db->where("category",$category);
		}
		$res=$this->db->get();
		$result=$res->result_array();
        return $result;
	}

    function checkValue($value,$score)
	{
		if($value=="YES")
		{
			return $score;
		}else if ($value=="NO")
		{
			return 0;
		}else if ($value=="NA")
		{
			return $score;
		}
		else{
			return $value;
		}
	}

	function PreFatalScore($value,$score)
	{
		if($value=="YES")
		{
			return $score;
		}else if ($value=="NO")
		{
			return 0;
		}else if ($value=="NA")
		{
			return $score;
		}
		else{
			return $score;
		}
	}
	
	
	function getFormData($unique_id,$tableName)
	{
		$this->db->from($tableName);
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("unique_id",$unique_id);
		$res=$this->db->get();
		$result=$res->row_array();
		return $result;
	}
	
	// check form valid and Invalid
	function checkForms($form_name,$version)
	{
		$this->db->from('forms_details');
		$this->db->where('form_name' , $form_name);
		$this->db->where('form_version' , $version);
		$res = $this->db->get();
		$num = $res->num_rows();
		return $num;

	}

	///check escalation exit or not in esclation table by unique ID
	function checkESC($table,$unique_id)
	{
		$table = 'escalation_'.$table;
		$this->db->from($table);
		$this->db->where('unique_id' , $unique_id);
		if($this->session->userdata('emp_group')!=2){
		$this->db->where('escalation_by' , $this->session->userdata['empid']);
		}
		$res = $this->db->get();
		$num = $res->num_rows();
		return $num;
	}

///check escalation comment exit or not in esclation table by user type
function checkRecords($table,$unique_id,$emp_group,$emp_type)
{
	$this->db->from($table);
	$this->db->where('unique_id' , $unique_id);
	$this->db->where('emp_group' , $emp_group);
	$this->db->where('emp_type' , $emp_type);
	$res = $this->db->get();
	$result = $res->row_array();
	return $result;
}


	///Get agent details by ID 
	function getAgentDetails($agent_id){
		
		$this->db->select('u.lob,u.name,u.empid,u.sup_name,u.sup_id,h.vendor,h.location,h.campaign');
		$this->db->from('user u , hierarchy h');
		$this->db->where('u.empid', $agent_id);
		$this->db->where('u.usertype', 2);
		$this->db->where('u.is_admin', 3);
		$where = "(u.lob_hierarchy_id = h.hierarchy_id)";
   	    $this->db->where($where);
		$res = $this->db->get();
		$result = $res->row_array();
		return $result;
	}
// get form by form version and form name
	function getFormdetails($form_name,$version)
	{
		$this->db->select('lob,channels');
		$this->db->from('forms_details');
		$this->db->where('form_name' , $form_name);
		$this->db->where('form_version' , $version);
		$res = $this->db->get();
		$result = $res->row_array();
		return $result;

	}

function formInsert($tableName,$data) 
{
$this->db->insert($tableName,$data);
$insert_id = $this->db->insert_id();

return  $insert_id;
return true;
}

function formUpdate($tableName,$data)
{

$this->db->where('unique_id',$data['unique_id']);
$this->db->update($tableName,$data);
return $this->db->affected_rows();
}

	
 
	
//please write above....	
}
?>