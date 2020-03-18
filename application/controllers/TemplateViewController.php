<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateViewController extends MY_Controller {

public function select($tmp_id=null,$action=null,$unique_id=null)
{
    $common = $this->config->item('common');
    $data['heading'] = $common[1];
    if($action=='fill' || $action =='edit'){
        $disabled="";
        $readonly="";
    } 
    else {
        $disabled="disabled";
        $readonly="readonly";
    }
   
    $tempDetails = $this->common-> getWhereSelectAllToArray('template_details', 'tmp_name,tb_name,tmp_unique_id,site_id,group_id', ['tmp_unique_id'=>$tmp_id]);
    $tableName  = strtolower($tempDetails[0]['tb_name']);
    $data['formName']        = $tableName;
    $data['action']          = $action;
    $data['tmp_unique_id']   = $tmp_id;
    if(count($tempDetails)>0){      
        $formData=$this->common->getWhereSelectRowArray($tableName,['unique_id'=>$unique_id]);
        $tableFields=$this->common->showTableFields($tableName);
        $arr_length = sizeof($tableFields);
        // Make dynamic variable 
        for($i = 0; $i < $arr_length; $i++) {
            if(!empty($formData)){
                ${$tableFields[$i]}=isset($formData[$tableFields[$i]])?$formData[$tableFields[$i]]:"";
            
            }else{
                ${$tableFields[$i]}="";
            }
        }    
        $content = "";
        $cat_count  = 1;
        $categories = $this->common->getDistinctWhereSelect('template','t_cat_name,t_cat_id',['t_unique_id'=>$tmp_id]);
        if($action == 'fill') {
            $content .= ' <h4 class="template-title">'.$tempDetails[0]['tmp_name'].'<span><input class="get_marks" type="text" id="total_score" name="total_score"  value="0" readonly><sub>/</sub><input class="total_marks" type="text" name="total_score_d" id="total_score_d" value="0" readonly></span></h4>';
            $content.='<input type="hidden" id="unique_id"  name="unique_id"  value="'.uniqid().'">';
            $content.='<input type="hidden" id="tmp_unique_id"  name="tmp_unique_id"  value="'.$tmp_id.'">';
            $content.='<input type="hidden" name="site_id"  value="'.$tempDetails[0]['site_id'].'">';
            $content.='<input type="hidden" name="group_id"  value="'.$tempDetails[0]['group_id'].'">';
        } 
        else {
            $content .= ' <h4 class="template-title">'.$tempDetails[0]['tmp_name'].'<span><input class="get_marks" type="text" id="total_score" name="total_score"  value="'.${'total_score'}.'" readonly><sub>/</sub><input class="total_marks" type="text" name="total_score_d" id="total_score_d"  readonly value="'.${'total_score_d'}.'"></span></h4>';
            $content.='<input type="hidden" id="unique_id"  name="unique_id"  value="'.$unique_id.'">';
            $content.='<input type="hidden" id="tmp_unique_id"  name="tmp_unique_id"  value="'.$tmp_id.'">';
        }
        foreach($categories as $category){
            $content .= '<div class="Qsection">';
            ///category section start here
            $content .= '<div class="Qsection_header d-flex align-items-center justify-content-between">';  
            if($category['t_cat_name'] !='blank_sec'   && $cat_count!=1 ){ 
                $content .= '<h4>'.$category['t_cat_name'].'</h4>';   
                $displayNon = '';
            }
            else{
                $displayNon ='style="display:none"';
            }
            if($action == 'fill'){
                $content .='<div class="section_score"  '.$displayNon.'>
                                <input class="get_marks" id="cat'.$cat_count.'"   type="text" name="cat'.$cat_count.'"  value="0" readonly>
                                    <span class="score_seprate">/</span>
                                    <input id="cat'.$cat_count.'_d"  class="total_marks" type="text" name="cat'.$cat_count.'_d" value="0" readonly>
                                </div>';   
            } 
            else {
                $content .='<div class="section_score"  '.$displayNon.'>
                                <input class="get_marks" id="cat'.$cat_count.'"   type="text" name="cat'.$cat_count.'"  value="'.${$category['t_cat_id']}.'" readonly>
                                    <span class="score_seprate">/</span>
                                    <input id="cat'.$cat_count.'_d"  class="total_marks" type="text" name="cat'.$cat_count.'_d" value="'.${'cat'.$cat_count.'_d'}.'" readonly>
                                </div>';   
            }
            $content .='</div>';   
            //category section end here
            $attributes = $this->common->getAllWhere('template',['t_unique_id'=>$tmp_id, 't_cat_id'=>$category['t_cat_id']]);
            $attr_count=1;
            $content .= '<div class="Qsection_content">'; 
            foreach($attributes as $attribute){
                //$attNumber =substr($attribute['t_att_id'],0,5); 
                $attNumber = explode('_',$attribute['t_att_id'])[0];
                $attCom    =  $attNumber.'_com';
                $attScore    =  $attNumber.'_score';
                $attFile    =  $attNumber.'_file';
                $attImage    = $attNumber.'_image';
                $attFail    =  $attNumber.'_fail';
                //$content.='<input type="hidden" id="'.$attFail.'"  name="'.$attFail.'"  value="no">';
                //For general category question. 
                if($cat_count == 1){
                    $content .= '<div class="Question_single general_Question_single">
                                    <h5 class="Question_text">'. $attribute['t_att_name'];
                                    if(!empty($attribute['t_ques_description'])) {
                                        $content .= '<div class="tooltip_anchor">
                                                        <span class="tooltip_text"><span>'.$attribute['t_ques_description'].'</span></span></div></h5>';
                                    }
                                    else {
                                        $content .= '</h5>'; 
                                    }
                                    $content .= '<input type="hidden" id="'.$attFail.'"  name="'.$attFail.'"  value="no">
                                    <div class="Question_ans">';
                    //for single select option   
                    if($attribute['t_option_type'] == 'select' && $attribute['t_is_multiselect']=='no'){ 
                        if($attribute['t_is_required'] == 'yes'){
                            $required = 'required';
                        }else{
                            $required = '';
                        }     
                        $content .='<select '.$disabled.'  '.$required.' name="'.$attribute['t_att_id'].'" id="'.$attribute['t_att_id'].'">
                                        <option value="">Select</option>';
                                        $optionValue = explode('|', $attribute['t_option_value']);
                                        for($i=0; $i< count($optionValue); $i++){
                                            if($optionValue[$i] == ${$attribute['t_att_id']}){
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            $content.='<option '.$selected.' value="'.$optionValue[$i].'">'.$optionValue[$i].'</option>';
                                        }
                                        $content.='</select>';
                                    }  
                                    //for multiple select option
                                    if($attribute['t_option_type'] == 'select' && $attribute['t_is_multiselect']=='yes'){ 
                                        if($attribute['t_is_required'] == 'yes'){
                                            $required = 'required';
                                        }else{
                                            $required = '';
                                        }       
                                        $content .='<select '.$disabled.' '.$required.' name="'.$attribute['t_att_id'].'[]" multiple>';
                                        $optionValue = explode('|', $attribute['t_option_value']);
                                        for($i=0; $i< count($optionValue); $i++){
                                            if(in_array($optionValue[$i] , explode('|' , ${$attribute['t_att_id']}))){
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            $content .= '<option '.$selected.' value="'.$optionValue[$i].'">'.$optionValue[$i].'</option>';
                                        }
                                        $content.='</select>';
                                    }  

                                //for textbox
                                    if($attribute['t_option_type'] == 'text'){ 
                                        if($attribute['t_is_required'] == 'yes'){
                                            $required = 'required';
                                        }else{
                                            $required = '';
                                        }  
                                        $content .='<input '.$readonly.'  '.$required.' type="text" name="'.$attribute['t_att_id'].'" class="Qans_field" placeholder="Your Answer" value="'.${$attribute['t_att_id']}.'">';
                                    }  
                                    //for textarea
                                    if($attribute['t_option_type'] == 'textarea'){ 
                                        if($attribute['t_is_required'] == 'yes'){
                                            $required = 'required';
                                        }else{
                                            $required = '';
                                        }  
                                        $content .=' <textarea '.$readonly.' '.$required.' name="'.$attribute['t_att_id'].'"  class="Qans_field materialize-textarea" placeholder="Write here">'.${$attribute['t_att_id']}.'</textarea>';
                                    }  

                                 //for date
                                if($attribute['t_option_type'] == 'date'){ 
                                    if($attribute['t_is_required'] == 'yes'){
                                        $required = 'required';
                                     }else{
                                        $required = '';
                                     }  
                                    $content .='<span class="datepicker_span">
                                                <span class="material-icons">date_range</span>
                                                <input '.$disabled.' type="text" '.$required.' name="'.$attribute['t_att_id'].'" class="Qans_field datetimepicker" placeholder="YYYY/MM/DD HH:MM" value="'.${$attribute['t_att_id']}.'">
                                            </span>
                                           <!-- <span class="datepicker_span">
                                                <span class="material-icons">access_time</span>
                                                <input type="text"  '.$required.' class="Qans_field timepicker" placeholder="12:00 PM">
                                            </span>-->';
                                }  
                                //for checkbox
                                if($attribute['t_option_type'] == 'checkbox'){ 
                                    if(${$attribute['t_att_id']}) {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }
                                    if($attribute['t_is_required'] == 'yes'){
                                        $required = 'required';
                                    }else{
                                        $required = '';
                                    }  
                                    $content .=' <label class="ans_custom_checkbox">
                                        <input '.$disabled.' '. $required.' type="checkbox" name="'.$attribute['t_att_id'].'" class="filled-in" '.$checked.' />
                                        <span></span>
                                    </label>';
                                }
                                $content .='</div></div>';
                                //General section end here.                              
                            } 
                            else 
                            {   /// scoring section start here..
                                if($attribute['t_option_type'] == 'checkbox'){
                                    $content .=' <div class="Question_single checkbox_cont">';
                                }
                                else {
                                    $content .=' <div class="Question_single">';
                                }
                                $content .=' <!-- question start-->
                                        <h5 class="Question_text">'.$attribute['t_att_name'];
                                        if(!empty($attribute['t_option_score'])){
                                            $content .='<span class="ques_marks badge blue right"> Score '.current(explode("|", $attribute['t_option_score'])).'</span>';
                                        }
                                        if(!empty($attribute['t_ques_description'])) {
                                            $content .= '<div class="tooltip_anchor">
                                                            <span class="tooltip_text"><span>'.$attribute['t_ques_description'].'</span></span></div>';
                                        }
                                        if($attribute['t_option_type'] == 'select' && $attribute['t_is_multiselect']=='yes'){
                                            $content.= '<sub>(can choose more than One option)</sub>'; 
                                        }
                                        $content .= '<a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <input type="hidden" id="'.$attFail.'"  name="'.$attFail.'"  value="no">
                                        <!-- question ans start-->
                                        <div class="Question_ans">';

                                     //for option multiple selection
                                    if($attribute['t_option_type'] == 'select' && $attribute['t_is_multiselect']=='yes'){
                                        $optionValue = explode('|', $attribute['t_option_value']);
                                        $optionScore = explode('|', $attribute['t_option_score']); 
                                        /// attribute  wise max value 
                                        $maxValue = array_sum($optionScore);
                                        $optionColor = explode('|', $attribute['t_option_color']);
                                        $optionPassFail = explode('|', $attribute['t_option_failed']);
                                        //for single attribute score.
                                        if($action=='fill'){
                                            $content.='<input type="hidden" id="'.$attScore.'" name="'.$attScore.'" class="'.$category['t_cat_id'].' forTotalScore" value="0">';
                                            //set NA Score.     
                                            $content.='<input type="hidden" id="'.$attScore.'NA" class="NA'.$category['t_cat_id'].' NAforTotalScore" value="0">';
                                        }else{                                               
                                            $content.='<input type="hidden" id="'.$attScore.'" name="'.$attScore.'" value="'.${$attScore}.'" class="'.$category['t_cat_id'].' forTotalScore">';
                                            //set NA Score  in edit mode 
                                            if( ${$attribute['t_att_id']} == 'na' ||  ${$attribute['t_att_id']} == 'n/a'){
                                                $naValue = $maxValue;
                                            } else {
                                                $naValue = 0;
                                            }     
                                            $content.='<input type="hidden" id="'.$attScore.'NA" class="NA'.$category['t_cat_id'].' NAforTotalScore" value="'.$naValue.'">';
                                        }
                                     ////required condition ...
                                    if($attribute['t_is_required'] == 'yes'){
                                        $required = 'required';
                                        //$required = '';
                                     }else{
                                        $required = '';
                                     }   
                                    $content .='<!-- Question_ans_selects start--><div class="Question_ans_selects">';     
                                    for($i=0; $i< count($optionValue); $i++){

                                           if(in_array(strtolower($optionValue[$i]) , explode('|' , ${$attribute['t_att_id']}))) {
                                             $checked = 'checked';
                                           } else {
                                            $checked = '';
                                           }

                                            $content.='<label class="ans_custom_label">
                                            <input '.$checked.' '.$required.' '.$disabled.' id="'.$attribute['t_att_id'].$i.'"  onclick="setscore(`'.$attribute['t_att_id'].'`,`'.$category['t_cat_id'].'`,$(this).attr(`score`),$(this).attr(`isFailed`),$(this).attr(`id`),$(this).attr(`selType`),$(this).attr(`value`),$(this).attr(`mscore`))"  score="'.$optionScore[$i].'"  mscore="'.$maxValue.'" isFailed="'.$optionPassFail[$i].'" set_score_'.$attribute['t_att_id'].'="0"   type="checkbox" name="'.$attribute['t_att_id'].'[]" value="'.strtolower($optionValue[$i]).'"  selType="1" '.$category['t_cat_id'].'='.$optionScore[$i].'   class="ans_custom_check" />

                                                    <span data-bgcolor="'.$optionColor[$i].'" >'.$optionValue[$i].'</span>
                                                </label>';
                                            }
                                         $content.='</div>';
                                        }   


                                     /// for option single selection    
                                     if($attribute['t_option_type'] == 'select' && $attribute['t_is_multiselect']=='no'){
                                        $optionValue = explode('|', $attribute['t_option_value']);
                                        $optionScore = explode('|', $attribute['t_option_score']);
                                        ///attribute wise max value
                                        $maxValue = array_sum($optionScore);
                                        $optionColor = explode('|', $attribute['t_option_color']);
                                        $optionPassFail = explode('|', $attribute['t_option_failed']); 

                                         //for single attribute score.
                                        if($action=='fill'){
                                        $content.='<input type="hidden" id="'.$attScore.'" name="'.$attScore.'" class="'.$category['t_cat_id'].' forTotalScore" value="0">';
                                        //Set NA score  
                                        $content.='<input type="hidden" id="'.$attScore.'NA" class="NA'.$category['t_cat_id'].' NAforTotalScore" value="0">';
                                        }else{
                                        $content.='<input type="hidden" id="'.$attScore.'" name="'.$attScore.'" value="'.${$attScore}.'" class="'.$category['t_cat_id'].' forTotalScore" value="0">';
                                        //set NA score in edit mode 
                                        if(${$attribute['t_att_id']} == 'na' || ${$attribute['t_att_id']} == 'n/a'){
                                            $naValue =  $maxValue;
                                        } else {
                                            $naValue = 0; 
                                        }
                                        $content.='<input type="hidden" id="'.$attScore.'NA" class="NA'.$category['t_cat_id'].' NAforTotalScore" value="'.$naValue.'">';
                                       }    

                                        $content .='<div class="Question_ans_selects">';
                                        for( $i=0; $i< count($optionValue); $i++){
                                            if(strtolower($optionValue[$i]) == ${$attribute['t_att_id']}){
                                                $checked = 'checked';
                                            } else{
                                                $checked = '';
                                            }

                                            /// required condition ... 
                                            if($attribute['t_is_required'] == 'yes'){
                                                $required = 'required';
                                             }else{
                                                $required = '';
                                             }       
                                        $content.='<label class="ans_custom_label">
                                                    <input '.$disabled.' '.$required.' '.$checked.' id="'.$attribute['t_att_id'].$i.'"  onclick="setscore(`'.$attribute['t_att_id'].'`,`'.$category['t_cat_id'].'`,$(this).attr(`score`),$(this).attr(`isFailed`),$(this).attr(`id`),$(this).attr(`selType`),$(this).attr(`value`),$(this).attr(`mscore`))" score="'.$optionScore[$i].'" mscore="'.$maxValue.'" isFailed="'.$optionPassFail[$i].'" set_score_'.$attribute['t_att_id'].'="0" class="ans_custom_radio" name="'.$attribute['t_att_id'].'" value="'.strtolower($optionValue[$i]).'"  '.$category['t_cat_id'].'='.$optionScore[$i].'  selType="2" type="radio" />
                                                    <span data-bgcolor="'.$optionColor[$i].'">'.$optionValue[$i].'</span>
                                                </label>';
                                            }
                                        $content.= '</div>';

                                     }    

                                //for checkbox
                                if($attribute['t_option_type'] == 'checkbox'){ 
                                    //for single attribute score.
                                    if($action=='fill'){
                                    $content.='<input type="hidden" id="'.$attScore.'" name="'.$attScore.'" class="'.$category['t_cat_id'].' forTotalScore" value="0">';
                                    }else{
                                    $content.='<input type="hidden" id="'.$attScore.'" name="'.$attScore.'" value="'.${$attScore}.'" class="'.$category['t_cat_id'].' forTotalScore" value="0">';
                                    }   

                                  if(${$attribute['t_att_id']}) {
                                    $checked = 'checked';
                                  } else {
                                    $checked = '';
                                  }
                                $optionScore = $attribute['t_option_score']; 
                                ///required condition 
                                if($attribute['t_is_required'] == 'yes'){
                                    $required = 'required';
                                 }else{
                                    $required = '';
                                 }   
                                //$optionPassFail = explode('|', $attribute['t_option_failed']); 
                                $content .=' <label class="ans_custom_checkbox">
                                        <input '.$disabled.' '.$required.'  id="'.$attribute['t_att_id'].$i.'"  onclick="setscore(`'.$attribute['t_att_id'].'`,`'.$category['t_cat_id'].'`,$(this).attr(`score`),$(this).attr(`isFailed`),$(this).attr(`id`),$(this).attr(`selType`),$(this).attr(`value`))" score="'.$optionScore.'" isFailed="no" set_score_'.$attribute['t_att_id'].'="0"  '.$category['t_cat_id'].'='. $optionScore.'  selType="3" type="checkbox" name="'.$attribute['t_att_id'].'" class="filled-in" '.$checked.' />
                                        <span></span>
                                    </label>';
                                }  



                                //for textbox
                                if($attribute['t_option_type'] == 'text'){ 
                                ///required condition 
                                if($attribute['t_is_required'] == 'yes'){
                                    $required = 'required';
                                 }else{
                                    $required = '';
                                 }    
                                $content .='<input '.$readonly.' '.$required.' type="text" name="'.$attribute['t_att_id'].'" class="Qans_field" placeholder="Your Answer" value="'.${$attribute['t_att_id']}.'">';
                                }  

                                //for textarea
                                if($attribute['t_option_type'] == 'textarea'){ 
                                 ///required condition 
                                if($attribute['t_is_required'] == 'yes'){
                                    $required = 'required';
                                 }else{
                                    $required = '';
                                 } 
                                $content .=' <textarea '.$readonly.' '.$required.' name="'.$attribute['t_att_id'].'"  class="Qans_field materialize-textarea" placeholder="Write here">'.${$attribute['t_att_id']}.'</textarea>';
                                }  

                                 //for date
                                if($attribute['t_option_type'] == 'date'){ 

                                    if($attribute['t_is_required'] == 'yes'){
                                        $required = 'required';
                                     }else{
                                        $required = '';
                                     }  
                                $content .='<span class="datepicker_span">
                                            <span class="material-icons">date_range</span>
                                            <input type="text" '.$required.' name="'.$attribute['t_att_id'].'" class="Qans_field datetimepicker" placeholder="YYYY/MM/DD HH:MM" value="'.${$attribute['t_att_id']}.'">
                                        </span>
                                        <!-- <span class="datepicker_span">
                                            <span class="material-icons">access_time</span>
                                            <input type="text"  '.$required.'  class="Qans_field timepicker" placeholder="12:00 PM">
                                        </span> -->';
                                }  
                              
                              

                              $content .= '</div> <!-- question ans end-->';
                              // Question_ans end
                              if($action == 'fill'){
                                $cmt = '';
                             } else{
                                 $cmt = ${$attCom};
                             }
                              // ans btm start
                                    $content.= '<div class="Question_ans_btm" style="'.((!empty($cmt)?"display:block":"")).'">
                                                    <div class="Question_ans_attachments d-flex justify-content-between">';
                                                    if($attribute['t_option_type']  != 'text' && $attribute['t_option_type']  != 'textarea'){
                                                    ///comment section start here
                                                        $content .= '<div class="attachment_notes">
                                                            <a href="javascript:void(0)" class="attachment_notes_link" style="'.((!empty($cmt)?"display:none":"")).'">
                                                                <i class="material-icons">menu</i>
                                                                <span>Add Notes</span>
                                                            </a>
                                                            <div class="attachment_textbox" style="'.((!empty($cmt)?"display:block":"")).'">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <textarea '.$readonly.' name="'.$attCom.'" placeholder="Write note here">'.$cmt.'</textarea>
                                                                    <div class="attachment_textbox_controls">
                                                                        <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                      ///comment section end here..
                                                    }

                                                        $content.='<div class="attachment_images">
                                                            <div class="attachment_images_link">
                                                                <input type="file" id="'.$attFile.'" file_name="" multiple '.$disabled.'>
                                                                <span>
                                                                    <i class="material-icons">camera_alt</i>
                                                                    <span>Photos</span>
                                                                </span>
                                                            </div>
                                                            <div class="photo_frame_cont" id="'.$attImage.'">';
                                                               //$content.= '<div class="photo_frame">';
                                                                    $attr_files = explode('_',$attribute['t_att_id'])[0].'_file';
                                                                    $file_list = glob('assets/upload/'.$this->session->userdata('client_db_name').'/formContent/'.$tmp_id.'_'.$unique_id.'_'.$attr_files.'_*');
                                                                    foreach ($file_list as $fkey => $fvalue) {
                                                                        $file_name = explode('.',$fvalue);
                                                                        $extension = strtolower(end($file_name));

                                                                        if($extension == "xlsx" || $extension == "xls"){
                                                                            $content.="<a class='photo_frame' href='".base_url().$fvalue."' download><embed src='".base_url()."assets/images/excel_file.png'><span class='preview-text'>Download</span></a>";
                                                                        }
                                                                        else if($extension == "csv"){
                                                                            $content.= "<a class='photo_frame' href='".base_url().$fvalue."' download><embed src='".base_url()."assets/images/csv_file.png'></a>";
                                                                        }
                                                                        else if($extension == "doc" || $extension == "docx"){
                                                                           $content.="<a class='photo_frame' href='".base_url().$fvalue."' download><embed src='".base_url()."assets/images/word_file.png'></a>";
                                                                        }
                                                                        if($extension == "msg"){
                                                                            $content.="<a class='photo_frame' href='".base_url().$fvalue."' download><embed src='".base_url()."assets/images/msg.png'></a>";
                                                                        }
                                                                        else if($extension == "pdf"){
                                                                            $content.="<a data-target='upload_modal' class='photo_frame modal-trigger' href='javascript:void(0)' formate='pdf' attr_src='".base_url().$fvalue."'>
                                                                                            <span class='embed_outer'>
                                                                                                <embed src='".base_url()."assets/images/pdf_file.png'>
                                                                                            </span></a>";
                                                                        }
                                                                        else if($extension == "txt"){
                                                                            $content.= "<a data-target='upload_modal' class='photo_frame modal-trigger' href='javascript:void(0)' formate='pdf' attr_src='".base_url().$fvalue."'>
                                                                                    <span class='embed_outer'>
                                                                                        <embed src='".base_url()."assets/images/txt.png'>
                                                                                    </span></a>";
                                                                        }
                                                                        else if($extension == "mp3"){
                                                                            $content.= "<a data-target='upload_modal' class='photo_frame modal-trigger' href='javascript:void(0)' formate='mp3' attr_src='".base_url().$fvalue."'>
                                                                                    <span class='embed_outer'>
                                                                                        <embed src='".base_url()."assets/images/audio_file.png'>
                                                                                    </span></a>";
                                                                        }
                                                                        else if($extension == "mp4"){
                                                                            $content.= "<a data-target='upload_modal' class='photo_frame modal-trigger' href='javascript:void(0)' formate='mp4' attr_src='".base_url().$fvalue."'>
                                                                                    <span class='embed_outer'>
                                                                                        <embed src='".base_url()."assets/images/video_file.png'>
                                                                                    </span></a>";
                                                                        }
                                                                        else if($extension == "gif" || $extension == "jpeg" || $extension == "png" || $extension == "jpg"){   
                                                                            $content.= "<a  data-target='upload_modal' class='photo_frame modal-trigger con_upload' href='javascript:void(0)' formate='jpg' attr_src='".base_url().$fvalue."'>
                                                                            <span class='embed_outer'><embed class='con_upload_data'  src= '".base_url().$fvalue."'></span></a>";
                                                                                                                                                                            
                                                                           
                                                                        }
                                                                        
                                                                    }
                                                                    //$content.='</div>';
                                                                //die;
                                                                //print_r()
                                                                //////////////////////////////////
                                                                // $img_path = base_url().'/assets/upload/'.$this->session->userdata('client_db_name').'/formContent'.$tmp_id.'_'.$unique_id.'_'.$attribute['t_att_id'];
                                                                // echo base_url();
                                                               '<!--<div class="photo_frame">
                                                                    <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                                    <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                                </div> -->';

                                                           $content.='</div>
                                                        </div>
                                                    </div>
                                                </div>';
                                    // ans btm end

                                  $content.= '</div>'; 
                                  // single questions end

                } 
            
            
            $attr_count++;
            }
            $content .= '</div>';


        
        $content .='</div>';
        $cat_count++; 
        }
        $content .='</div>';

        if($action == 'review'){
            $content .='<div class="Question_single"><div class="input-field">
                                            <textarea id="feedback_com" name="feedback_com" class="materialize-textarea">'.${'feedback_com'}.'</textarea>
                                            <label for="feedback_com" class="">Review Comment</label>
                                        </div></div>';
        }
    
        if($action != 'view'){
            if($this->emp_group != "admin"){
                $content .='<div class="right-align mt-24">
                                        <button type="submit" class="btn cyan waves-effect waves-light">
                                            <span>Submit</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>';
                }   
            }                      
        
    $data['form_content'] =  $content;
    }
        $this->load->view('other/non_bpo_template_view' , $data);
}

public function form_submit($formName,$action,$tmp_unique_id){
    
    $unique_id = $this->input->post('unique_id');
    date_default_timezone_set('Asia/Kolkata');
    if($action=='fill') {
        $_POST['evaluator_name'] = $this->session->userdata['name'];
        $_POST['evaluator_id'] = $this->session->userdata['user_id'];
        $_POST['submit_time']= date('Y-m-d H:i:s');
        // $_POST['audit_timer']=$this->input->post('audit_counter_hour').':'.$this->input->post('audit_counter_minute').':'.$this->input->post('audit_counter_second');
        
        // $img = $_FILES;
        // if(!is_dir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent')){
        //     mkdir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent',0777, TRUE);
        //     $p = './assets/upload/'.$this->session->userdata('client_db_name').'/formContent';
        //     shell_exec("sudo chmod -R 7777 $p");
        // }

        // tem_unq_id+form_unique_id+attr_name_0/1
        // $folderPath ='./assets/upload/'.$this->session->userdata('client_db_name').'/formContent';
        // //$folderPath ='./assets/images';
        // $config['upload_path']      = $folderPath;
        // $config['allowed_types']    = 'gif|jpg|jpeg|png';
        // $config['max_size']         = 50000;
        // $this->load->library('upload');
        // $res = [];
        // foreach ($img as $keys => $value) {
        //     $content_files_name = [];
        //     // check image input select or not  
        //     if($_FILES[$keys]['name'][0]){
        //         foreach($_FILES[$keys]['name'] as $key => $each_fileName){
        //             //$this->print_result($value);
        //             //$filename = $files['contant_upload']['name'];
        //             $filename = $each_fileName;
        //             $extension1 = explode("." , $filename);
        //             $extension = end($extension1);
        //             //given file
        //             $file_name                  =  $unique_id.'_'.$keys.'_'.uniqid().'.'.$extension;        
        //             $config['file_name']        = $file_name;
        //             $_FILES['file']['name']     = $_FILES[$keys]['name'][$key];
        //             $_FILES['file']['type']     = $_FILES[$keys]['type'][$key];
        //             $_FILES['file']['tmp_name'] = $_FILES[$keys]['tmp_name'][$key];
        //             $_FILES['file']['error']    = $_FILES[$keys]['error'][$key];
        //             $_FILES['file']['size']     = $_FILES[$keys]['size'][$key];
        //             $this->upload->initialize($config);
        //             if (!$this->upload->do_upload('file')){
        //               //  print_r($this->upload->display_errors());die;
        //                 //$res[$key] = $each_fileName;
        //             }
        //             else {
        //                 $upload_data = $this->upload->data();
        //                 //$res[$key] = "success";
        //                 $content_files_name[] =$file_name;
        //             }       
        //         } //endForeach     
        //         $uploade_data = implode('|',$content_files_name);
        //         $_POST[$keys]  = $uploade_data;     
        //     }//close checkimages exit or not
        // } /// endForeach
           
        $sqlQuery = $this->getInsQry($_POST,$formName);
        $inserData= $this->db->query($sqlQuery);
        // $notify_emails = $this->sendNofityEmails($this->input->post('tmp_unique_id'));
        $redirect = 'template/'.strtolower($tmp_unique_id).'/'.$action;
        if($inserData){
            $this->session->set_flashdata('msg', 'Data Submitted Successfully');
            redirect($redirect);
        }else{
            $this->session->set_flashdata('msg', 'Error Occurred');
            redirect($redirect);
        }
    }
    else{  ///  below is the update code
        //echo '<pre>';
        $_POST['sup_name'] = $this->session->userdata['name'];
        $_POST['sup_id'] = $this->session->userdata['user_id'];
        $_POST['feedback_date'] = date('Y-m-d H:i:s');         
        $sqlQuery = $this->getUpdQry($_POST,$formName,'where unique_id="'.$unique_id.'"');
        $updateData = $this->db->query($sqlQuery);
        $redirect = 'template/'.strtolower($tmp_unique_id).'/'.$action.'/'.$unique_id;
        if($updateData){
            $this->session->set_flashdata('msg', 'Data Submitted Successfully');
            redirect($redirect);
        }else{
            $this->session->set_flashdata('msg', 'Error Occurred');
            redirect($redirect);
        }    
    } ///close else block
} /// close function block


function getInsQry($arPost,$tbl){
    $fieldlist=$vallist='';
    foreach ($arPost as $key => $value){
        if(is_array($value)){
            $value = implode('|' , $value); 
        }
        //$value = (empty($value)) ? 'blank' : $value;
        $value = str_replace("'", "\'", $value);
        $fieldlist.=$key.',';
        $vallist.='\''.$value.'\',';
    }
    $fieldlist=substr($fieldlist, 0, -1);
    $vallist=substr($vallist, 0, -1);
    $sql="INSERT INTO $tbl ($fieldlist) VALUES ($vallist)";
    return $sql;  
}
function getUpdQry($arPost,$tbl,$cond){
    $strUpdFlds='';
    foreach ($arPost as $key => $value){
        if(is_array($value)){
            $value = implode(',' , $value); 
        }
        //$value = (empty($value)) ? 'blank' : $value;
        $value = str_replace("'", "\'", $value);
        $strUpdFlds.="$key='$value',";
    }
    $strUpdFlds=substr($strUpdFlds, 0, -1);
    $sql="Update $tbl set $strUpdFlds $cond";
    return $sql;
}

function sendNofityEmails($tmp_unique_id){
    $email_id = '';
    $temp_notify_details = $this->common->getWhereSelectAll('template',['t_att_id','t_is_multiselect','t_option_value','t_notify_response','t_notify_emails','t_notify_emails_body'],['t_notify_status'=>'1','t_option_type'=>'select','t_unique_id'=>$tmp_unique_id]);
    // print_r($temp_notify_details);
    if(!empty($temp_notify_details)){
        foreach ($temp_notify_details as $key => $value) {
            $t_att_id  = $value->t_att_id;
            $t_option_value = explode('|', $value->t_option_value);
            $t_notify_response = $value->t_notify_response;
            $t_notify_emails = explode(',', $value->t_notify_emails);
            $t_notify_emails_body = $value->t_notify_emails_body;
            $attr_data = (array)$_POST[$t_att_id];
            $body = $t_notify_emails_body;
            foreach($attr_data as $akey => $avalue) {
                if($avalue == $t_notify_response){
                    foreach ($t_notify_emails as $ekey => $evalue) {
                        $mail = send_email($evalue,'Notify Response',$body);
                        if($mail != "success"){
                            $email_id .= $evalue;
                        }
                    }
                }
            }
        }
    }
    return $email_id;
}

function attrFileUpload(){
    $this->load->library('upload');
    if(!is_dir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent')){
        mkdir('./assets/upload/'.$this->session->userdata('client_db_name').'/formContent',0777, TRUE);
        $p = './assets/upload/'.$this->session->userdata('client_db_name').'/formContent';
        shell_exec("sudo chmod -R 7777 $p");
    }
    $folderPath ='./assets/upload/'.$this->session->userdata('client_db_name').'/formContent';
	$config['upload_path']      = $folderPath;
	$config['allowed_types']    = 'gif|jpg|jpeg|png|csv|xls|xlsx|docx|doc|pdf|mp3|mp4|txt|msg';
    $config['max_size']         = 5000;
    $count = 0;
	foreach($_FILES as $key => $each_fileName){
    	foreach($each_fileName['name'] as $nkey => $neach_fileName){
            $extension1 = explode("." , $neach_fileName);
            $extension = end($extension1);
            $file_name = $this->input->post('tmp_unique_id').'_'.$this->input->post('unique_id').'_'.$this->input->post('attr_id').'_'.$count.'.'.$extension;        	
            $count++;
            $config['file_name']        = $file_name;
            $_FILES['file']['name']     = $each_fileName['name'][$nkey];
            $_FILES['file']['type']     =$each_fileName['type'][$nkey];
            $_FILES['file']['tmp_name'] =$each_fileName['tmp_name'][$nkey];
            $_FILES['file']['error']    =$each_fileName['error'][$nkey];
            $_FILES['file']['size']     =$each_fileName['size'][$nkey];
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('file')){
                // $this->print_result($this->upload->display_errors());die;
            }
            else {
                $upload_data = $this->upload->data();
            } 
        }
    }
    echo postRequestResponse('success');
}


public function detAttrFileUpload($id){
    $folderPath ='./assets/upload/'.$this->session->userdata('client_db_name').'/formContent/'.$id;
    unlink($folderPath);
}



//please write above    
}