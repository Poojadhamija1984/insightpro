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
    
    function getform($form_name,$action,$unique_id,$tableName)
	{
		//echo "form_code = ".$form_code."<br> version = ".$version."<br> unique_id = ".$unique_id."<br> tableName = ".$tableName."<br> submitTable = ".$submitTable."<br> action = ".$action."<br>";
		$data="";
		if($action=='fill' || $action=='audit')
		{
			$disabled="";
			$readonly="";
		}else{
			$disabled="disabled";
			$readonly="readonly";
		}
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
		$res=$this->db->get();
		$result=$res->result_array();
		//echo $this->db->last_query();
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
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
			$categories=$this->get_distinct_category($form_name);
			$cat_count=1;
			foreach($categories as $category)
			{
				$data.='<div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">';
					$data.='<div class="panel">';
							$data.='<a class="panel-heading collapsed" role="tab" id="heading'.$cat_count.'" data-toggle="collapse" data-parent="#accordion'.$cat_count.'" href="#collapse'.$cat_count.'" aria-expanded="true" aria-controls="collapse'.$cat_count.'">';
							if($action=='fill')
							{
								$data.='<h4 class="panel-title">'.$category['category'].' <input name="'.$category['cat_id'].'" id="'.$category['cat_id'].'" type="text" value="" readonly  class="form-control text-center cat_input"></h4>';
							}
							else{
								$data.='<h4 class="panel-title">'.$category['category'].' <input name="'.$category['cat_id'].'" id="'.$category['cat_id'].'" type="text" value="'.${$category['cat_id']}.'" readonly  class="form-control text-center cat_input"></h4>';
							}
							$data.='</a>';
							$data.='<div id="collapse'.$cat_count.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$cat_count.'">';
							$attributes=$this->get_attributes($form_name,$category['category']);
							$attr_count=1;
							foreach($attributes as $attribute)
							{
								if($attr_count==1)
								{
								$data.='<div class="panel-body">';
								$data.='<table class="table table-striped">';
								$data.='<thead>';
								$data.='<tr>';
								$data.='<th width="55%">Attribute Name</th>';
								$data.='<th width="15%">Rating</th>';
								$data.='<th width="20%">Comment</th>';								
								$data.='<th width="10%">Score</th>';
								$data.='</tr>';
								$data.='</thead>';
								$data.='<tbody>';
								}
								$data.='<tr>';
								$data.='<td>'.$attribute['attribute'].'</td>';
								
								$data.='<td><select '.$disabled.' class="form-control clsForPreFatal" name="'.$attribute['attr_id'].'" id="'.$attribute['attr_id'].'" onchange="setscore(`'.$attribute['attr_id'].'`,$(this).find(`option:selected`).attr(`score`),this.value,`'.$category['cat_id'].'`)" required>';
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
									$data.='<option '.$selected.' score="'.$score.'" forPreFatalScore="'.$PreFatalScore.'"  value="'.trim($rating).'">'.trim($rating).'</option>';
								}
								$data.='</td>';
								$attr=substr($attribute['attr_id'],0,5);
								$attr_com=$attr.'_com';
								$attr_score=$attr.'_score';
								if($action=='fill')
								{
									$data.='<td><textarea '.$readonly.'  style="height:34px;resize:none;" id="'.$attr_com.'" name="'.$attr_com.'" class="form-control"></textarea></td>';								
									$data.='<td><input readonly type="text"  name="'.$attr_score.'" id="'.$attr_score.'" value="" class="form-control text-center '.$category['cat_id'].' forTotalScore"</td>';									
								}
								else
								{
									$data.='<td><textarea '.$readonly.'  style="height:34px;resize:none;" id="'.$attr_com.'" name="'.$attr_com.'" class="form-control">'.${$attr_com}.'</textarea></td>';								
									$data.='<td><input readonly type="text"  name="'.$attr_score.'" id="'.$attr_score.'" value="'.${$attr_score}.'" class="form-control text-center '.$category['cat_id'].' forTotalScore"</td>';
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
							
							$data.='</div>';
							/* End Collapse */
                    $data.='</div>';
					/* End panel */
				$data.='</div>';
				/* End Accordian */
			$cat_count++;	
			} 
			// echo '<pre>';
			// print_r($formData);
            // echo "<pre>";
            
			// if($this->session->userdata['usertype'] == 'Professional')
			// {
			// 	$data.= '<h4 class="panel-heading">Feedback</h4>';
			// 	$data.= '<td><textarea style="margin-left:1%;"  id="feedback" name="feedback" class="form-control" placeholder="Feedback Not Provided" required>'.(($formData['feedback']!="")?$formData['feedback']:"").'</textarea></td>';
			// 	$data.= '<input type="hidden" id="feedback_by" name="feedback_by" value="'.$this->session->userdata['empid'].'">';
			// 	$data.= '<input type="hidden" id="feedback_at" name="feedback_at" value="'.date('Y-m-d H:i:s').'">';
			// 	$data.='</br>';
			// }
			
		}
		return $data;
	}
        
    function getform1($form_name,$action,$unique_id,$tableName)
	{
		//echo "form_code = ".$form_code."<br> version = ".$version."<br> unique_id = ".$unique_id."<br> tableName = ".$tableName."<br> submitTable = ".$submitTable."<br> action = ".$action."<br>";
		$data="";
		if($action=='fill' || $action=='audit')
		{
			$disabled="";
			$readonly="";
		}else{
			$disabled="disabled";
			$readonly="readonly";
		}
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
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
			$categories=$this->get_distinct_category($form_name);
			$cat_count=1;
			foreach($categories as $category)
			{
             $data .= '<li>';
             
             $data .= '</li>';
			$cat_count++;	
			} 
			
			
		}
		return $data;
	}
		


    function showTableFields($tableName)
	{
		$fields=array();
		$fields = $this->db->list_fields($tableName);
		return $fields;
	}

	
	function get_distinct_category($form_name)
	{	
		$this->db->distinct();
		$this->db->select('category,cat_id');
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
		$res=$this->db->get();
		$result=$res->result_array();
		return $result;
	}
    
    
    function get_attributes($form_name,$category="")
	{
		$this->db->from("forms");
		//$this->db->where('client_id',$this->session->userdata['client_id']);
		$this->db->where("form_name",$form_name);
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
	

 
	
//please write above....	
}
?>