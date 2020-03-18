<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body>
        <div class="page-wrapper">
            <!-- HEADER SECTION START-->
            <?php $this->load->view('common/header_view') ?>
            <!-- HEADER SECTION END-->
            <!-- SIDEBAR SECTION START -->
            <?php $this->load->view('common/sidebar_view') ?>
            <!-- SIDEBAR SECTION END -->
            <!-- MAIN SECTION START -->
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
                                <h3 class="page-title">Form</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><?=ucfirst($lob)?></li>
                                    <li class="breadcrumb-item">
                                    <?php 
                                    if($action=='ata_view'){
                                        echo 'ATA Report';
                                    }elseif($action == 'callibrate_view'){
                                         echo 'Calibration Report';
                                    }elseif($action == 'ata'){
                                        echo 'ATA';
                                    }elseif($action=='callibrate'){
                                        echo 'Calibration';
                                    }else{
                                        echo '';
                                    }
                                    ?>
                                    </li>
                                    <!-- <li class="breadcrumb-item"><a href="my_bucket.html">My Bucket</a></li>
                                    <li class="breadcrumb-item"><span>Call L1 Meta Data</span></li> -->
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR START -->
                    <?php if($this->session->flashdata('message')){ ?>
                        <div class="error_section">
                            <div class="page_error success mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('error')){ ?>
                        <div class="error_section">
                            <div class="page_error failure mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- PAGE ERROR END -->
                    <!-- FORM SECTION START -->
                    <?php $attributes = array("id" => "form col");
                    echo form_open_multipart("forms/form_submit/".$formName."/".$form_version."/".$action ,$attributes);
                    ?>
                       
                   <!--************************************************Meta Data Include here *******************************************-->    
                  <?php $this->load->view('common/meta_data_view');?>
                <?php if($action == 'callibrate' || $action == 'callibrate_view') { ?>
                 <!--**************************Callibration Date & Time Start here****************************************** -->
                        <div class="form-section mt-24">  
                            <div class="card">
                                <div class="card-content">
                                    <div class="col">
                                        <div class="row mb-0">
                                            <div class="input-field col l3 m6 s12 mb-0">
                                                <input  name="calibration_date" type="text" value="<?=$calibration_date?>"  readonly="true" placeholder="Callibation Date" class="datepicker">
                                                <label for="calibration_date" class="active">Calibration Date</label>
                                            </div>
                                            <div class="input-field col l3 m6 s12 mb-0">
                                                <input  name="calibration_time" type="text" value="<?=$calibration_time?>" readonly="true" placeholder="Callibration Time" class="timepicker">
                                                <label for="calibration_time" class="active">Calibration Time</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                <?php } ?>
                        <!--**********************************Callibration Date and Time Start here  ******************************* -->

                        <!-- ACCORDION SECTION START -->
                        <div class="accordion-section mt-24">
                            <!-- <div class="card accordion_card mt-12">
                                <div class="card-content p-0">
                                    <div class="card_header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">'.$category['category'].'</h4>
                                        <div class="counter">
                                            <span class="counter_text">Score</span>
                                            <input type="text" id="'.$category['cat_id'].'" name="'.$category['cat_id'].'" class="browser-default counter_value cat_input" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div> -->
                            <?php //echo $form; ?>
                            <!-- <ul class="collapsible meta_accordion" data-collapsible="accordion"> -->
                            <?php echo $form_contents; ?>
                            <!-- </ul> -->
                        </div>
                        <div class="form-bottom mt-24">
                            <div class="card">
                                <div class="card-content">

                                <!--************************* Callibration overall Comment start -->
                                <?php if($action == 'callibrate_view') { ?>
                                    <?php if($opsRecords) { ?>
                                    <div class="input-field">
                                        <textarea id="overall_com" name="overall_com" class="materialize-textarea" placeholder="Write here..."><?php echo (!empty($opsRecords['overall_com']) ? $opsRecords['overall_com'] : ''); ?></textarea>
                                        <label for="overall_com">Ops Comment</label>
                                    </div>
                                    <?php } if($clientRecords) { ?>
                                    <div class="input-field">
                                        <textarea id="overall_com" name="overall_com" class="materialize-textarea" placeholder="Write here..."><?php echo (!empty($clientRecords['overall_com']) ? $clientRecords['overall_com'] : ''); ?></textarea>
                                        <label for="overall_com">Client Comment</label>
                                    </div>
                                    <?php }  ?> 
                                 
                                <?php }  else { ?>
                                 <!--************************* QA overall Comment start -->
                                    <div class="input-field">
                                        <textarea id="overall_com" name="overall_com" class="materialize-textarea" placeholder="Write here..."><?php echo (!empty($meta_data['overall_com']) ? $meta_data['overall_com'] : ''); ?></textarea>
                                        <label for="overall_com">Comment</label>
                                    </div>
                                <!--************************* QA overall Comment end-->
                                <?php } ?>

                                <!--************************* ATA overall Comment end-->
                                 <?php if($action == 'ata_view'){ ?>
                                    <div class="input-field">
                                        <textarea  class="materialize-textarea" placeholder="Write here..."><?php echo (!empty($ATARecords['overall_com']) ? $ATARecords['overall_com'] : ''); ?></textarea>
                                        <label for="overall_com">ATA Comment</label>
                                    </div>
                                 <?php } ///ata comment end here.?>
                                 
                                    <!----******************************* Feedback Comment start here ********** --->
                                    <?php if($action == 'feedback' || !empty($meta_data['feedback_com'])) { ?>
                                    <div class="input-field">
                                        <textarea id="feedback_com" name="feedback_com" class="materialize-textarea" placeholder="Write here..."><?php echo (!empty($meta_data['feedback_com']) ? $meta_data['feedback_com'] : ''); ?></textarea>
                                        <label for="feedback_com">Feedback</label>
                                    </div>
                                    <?php } ?>
                                    <!----******************************* Feedback Comment start here ********** --->

                                    <?php  if($action == 'escalate')  { ?>
                                    <!----******************************* Escalation Comment start here ********** --->
                                        <?php if(count($agentESCcmt)> 0 )  { ?>
                                        <div class="input-field">
                                            <textarea id="escalation_comment_1"  class="materialize-textarea" placeholder="Write here..."><?php echo $agentESCcmt[0]->overall_com?></textarea>
                                            <label for="escalation_comment_1">Agent Escalation Comment</label>
                                        </div>
                                        <?php } 
                                        if(count($supESCcmt)> 0 )  {
                                        ?>
                                        <div class="input-field">
                                            <textarea id="escalation_comment_2" class="materialize-textarea" placeholder="Write here..."><?php echo $supESCcmt[0]->overall_com ?></textarea>
                                            <label for="escalation_comment_2">Supervisor Escalation Comment</label>
                                        </div>
                                        <?php } ?>

                                        <div class="input-field">
                                            <textarea id="escalation_comment_3" class="materialize-textarea" placeholder="Write here..."></textarea>
                                            <label for="escalation_comment_3">Comment</label>
                                        </div>
                                        <div class="escalation_decision_btns mb-24">
                                            <span class="escalation_radio accept">
                                                <label>
                                                    <input class="with-gap" name="escalation_decision" value="accept" type="radio" checked />
                                                    <span>Accept</span>
                                                </label>
                                            </span>
                                            <span class="escalation_radio decline">
                                                <label>
                                                    <input class="with-gap" name="escalation_decision" value="decline" type="radio" />
                                                    <span>Decline</span>
                                                </label>
                                            </span>
                                        </div>
                                    <!--******************** Escalation comment end here  *************************-->
                                    <?php } ?>

                                    <!--*********************** Form Submit Button for fill,calibrate,ATA,audit,feedback  *************************-->
                                    <div class="form_btns text-center">
                                       <?php  if($action =='fill' || $action == 'audit' || $action == 'feedback' || $action == 'callibrate' || $action == 'ata')
                                       { ?>
                                        <button type="submit" class="btn cyan waves-effect waves-light">
                                            <span>Submit</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                       <?php } ?>

                                       <!---***************************Escalation Button Start here******************************** -->
                                       <?php   if($action =='escalate' && $countESC==0 &&  $meta_data['status'] !='Approved') { ?>
                                        <button type="button" class="btn cyan waves-effect waves-light"  onclick="show_escType()">
                                            <span>Escalate</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                        <button type="submit" class="btn cyan waves-effect waves-light">
                                            <span>Approved</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                        <?php } ?>
                                       

                                        <?php if($action =='escalate' && ($this->session->userdata('emp_group')=='2' && $countESC==2)) { 
                                            if($meta_data['status']!='Approved') {
                                                ?>

                                                <button type="submit" class="btn cyan waves-effect waves-light">
                                                    <span>Accept & Modify</span>
                                                    <i class="material-icons right">send</i>
                                                </button>
                                        <?php }}  ?>

                                        <!---Escalation accept and modify  button for --->

                                      <!--*********************************************** Escalation Button End here **********************************************-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ACCORDION SECTION END -->
                    <?php echo form_close();?>
                    <!-- FORM SECTION END -->

<!-- ************************************************ESCALATION SECTION START************************************************** -->
                    <?php if($action=='escalate') { ?>
                    <?php $attributes = array("id" => "form col");
                    echo form_open("forms/escalation_submit/".$formName."/".$form_version."/".$meta_data['unique_id'],$attributes);
                    ?>
                    <div class="escalation-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <div class="form-section col">
                                    <div class="row mb-0">
                                        <div class="input-field col s12 m4 l3" style="display:none" id="esc_type">
                                            <select id="esc_type" type="text" name="esc_type" onchange="change_escType(this.value)">
                                                <option value="">Select</option>
                                                <option value="Overall">Overall</option>
                                                <option value="attribute_wise">Attribute Wise</option>
                                                <option value="both">Both</option>
                                            </select>
                                            <label for="input_02">Select Escalation Type</label>
                                        </div>
                                        <div class="input-field col s12 m8 l9"  style="display:none" id="overall_cmt">
                                            <textarea name="overall_com" class="materialize-textarea" name="overall_com" placeholder="Write your comment"></textarea>
                                            <label for="overall_com">Overall Comment</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-section accordion_card mb-24" style="display:none;" id="att_wise">
                                
                                    <table class="striped highlight">
                                        <thead>
                                            <tr>
                                                <th>Attribute Name</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($att_details as $atk => $atv ) { ?>
                                            <tr>
                                                <td><?php echo $atv->attribute;  ?></td>
                                                <td><textarea name="<?php echo str_replace('sel' , 'com', $atv->attr_id); ?>" class="materialize-textarea" placeholder="Write your comment"></textarea></td>
                                            </tr>
                                            <?php }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form_btns text-right" id="btn1" style="display:none">
                                    <button type="submit" class="btn cyan waves-effect waves-light ml-0">
                                        <span>Submit</span>
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                    <!-- ESCALATION SECTION END-->
                    <?php } ?>
 <!--************************************* ESCALATION SECTION END ************************************************************-->

            </main>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
</html>

<script>
$('#agent_id').change(function(){
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
            var agent_id=$('#agent_id').val();
            var res = postAjax('<?php echo site_url()?>/forms/getAgentDetails',{'agent_id':agent_id});
            var data = JSON.parse(res);
            document.getElementById("agent_name").value = (data.name);
            document.getElementById("supervisor").value = (data.sup_name);
            document.getElementById("supervisor_id").value = (data.sup_id);
            document.getElementById("vendor").value = (data.vendor);
            document.getElementById("lob").value = (data.lob);
            document.getElementById("location").value = (data.location);
            document.getElementById("campaign").value = (data.campaign);
           
		
		});



$(document).ready(function(){
var wrap_time=$('#wrap_time').val();
if(wrap_time=="")
{
stopwatch('Start');
}
})

  var sec = 0,min = 0,hour = 0;
 function stopwatch(text){

   sec++;
  if (sec == 60){
    sec = 0;
    min = min + 1;
  }else{
    min = min;
  }
  if (min == 60){
    min = 0;
    hour += 1;
  }
  if (sec<=9){sec = "0" + sec;}

  document.getElementById('wrap_time').value = ((hour<=9) ? "0"+hour : hour) + ":" + ((min<=9) ? "0" + min : min) + ":" + sec;

  SD=window.setTimeout("stopwatch();", 1000);
}



// This function is used to set attribute score and category score and total and Pre fatal Score and PC score on the basis of selected option
function setscore(attr_id,score,value,cat_id)
{
	//console.log("attr_id: "+attr_id+" score: "+score+" value: "+value+" cat_id: "+cat_id+" forPreFatalScore: "+forPreFatalScore);
	
	var attr_score_name=attr_id.substr(0,5)+"_score";
	// if fatal then assign FATAL otherwise score 
	if(value=="FATAL")
	{
		$("#"+attr_score_name).val(value);
     // if value mark NA then set score zero for each attribute value   
	}else if(value=="NA"){
		$("#"+attr_score_name).val(0);
	} else {
        $("#"+attr_score_name).val(score);
    }
	
	var cat_score=0;
	var sum=0;
	var ifAnyFatalEachCat=0;
	var ifAnyFatalOverall=0;
	var PreFatalScore=0;
    var PcScore=0;
        var tot_yes = 0;
        var SumNA = 0;
        var sumYES =0;
	// It will check fatal in each category whose id is provided.
	$("."+cat_id).each(function(){
		// check fatal for attribute then it assign 
		if($(this).val()=="FATAL")
		{
			ifAnyFatalEachCat=1;
			cat_score=0;
			
		}
		
	})
	// it will check FATAl in every attribute with class name
	$(".forTotalScore").each(function(){
		
		// check fatal for attribute then it assign 
		if($(this).val()=="FATAL")
		{
			ifAnyFatalOverall=1;
		}
	})

    $(".forTotalScore").each(function(){
    var per_attr_score=parseFloat($(this).val());
			//check fatal for attribute then it assign 
				if(isNaN(per_attr_score)==true)
				{
					sum+=0;
					//console.log("0");
				}else{
					//console.log("1");
					sum+=per_attr_score;
                } 
});

		$(".forTotalScore").each(function(){
            var id = $(this).attr('id');
          if(this.value !='' && this.value !='FATAL') {
               idd=$(this).attr('id');
			    sel=idd.replace("score", "sel");
			
				sel_val=$('#'+sel).find("option:selected").val();
				yes_val=$('#'+sel).find("option[value='YES']").attr("score");
				d_score=$('#'+sel).find("option[value='NO']").attr("score");
				
				tot_yes=parseFloat(tot_yes)+parseFloat(yes_val);
				
					
				if(sel_val=='NA')
				{
					SumNA=parseFloat(SumNA)+parseFloat(yes_val);
				}
				if(sel_val=='YES' && yes_val!=0)
				{
					 sumYES=parseFloat(sumYES)+parseFloat(yes_val);
					
				}


				if(sel_val=='YES' && yes_val==0)
				{
					sumYES=parseFloat(sumYES)+parseFloat(yes_val);
					tot_yes=parseFloat(tot_yes)+parseFloat(d_score);
					
				}
				if(sel_val=='NO' && d_score!=0)
				{
					sumYES=parseFloat(sumYES)+parseFloat(d_score);
					tot_yes=parseFloat(tot_yes)+parseFloat(d_score);
				}
			
    }  
  sum=((sumYES*100)/(tot_yes-SumNA)).toFixed(2);	  
   PreFatalScore =((sumYES*100)/(tot_yes-SumNA)).toFixed(2);   
})
if(ifAnyFatalOverall==1) {
    $("#pre_fatal_score").val(PreFatalScore);
    sum =0 ;
}



	//console.log(ifAnyFatalEachCat);
	if(ifAnyFatalEachCat==0){
        var tot_yesc = 0;
        var SumNAc = 0;
        var sumYESc =0
		$("."+cat_id).each(function(){
			//console.log($(this).attr('id'));
			var per_attr_score=parseFloat($(this).val());
			// check fatal for attribute then it assign 
			
				if(isNaN(per_attr_score)==false)
				{
					
					//console.log("1");
                 iddc=$(this).attr('id');
			     selc=iddc.replace("score", "sel");
			
				sel_valc=$('#'+selc).find("option:selected").val();
				yes_valc=$('#'+selc).find("option[value='YES']").attr("score");
				d_scorec=$('#'+selc).find("option[value='NO']").attr("score");
				
				tot_yesc=parseFloat(tot_yesc)+parseFloat(yes_valc);
				
					
				if(sel_valc=='NA')
				{
					SumNAc=parseFloat(SumNAc)+parseFloat(yes_valc);
				}
				if(sel_valc=='YES' && yes_valc!=0)
				{
					 sumYESc=parseFloat(sumYESc)+parseFloat(yes_valc);
					
				}


				if(sel_valc=='YES' && yes_valc==0)
				{
					sumYESc=parseFloat(sumYESc)+parseFloat(yes_valc);
					tot_yesc=parseFloat(tot_yesc)+parseFloat(d_scorec);
					
				}
				if(sel_valc=='NO' && d_scorec!=0)
				{
					sumYESc=parseFloat(sumYESc)+parseFloat(d_scorec);
					tot_yesc=parseFloat(tot_yesc)+parseFloat(d_scorec);
				}
					cat_score =((sumYESc*100)/(tot_yesc-SumNAc)).toFixed(2);
				}
			
		
		})
		
	}


	$("#total_score").val(sum);
    if(isNaN(cat_score)==false){
        $("#"+cat_id).val(cat_score);
    } else {
        $("#"+cat_id).val(0);
    }
	
	//console.log(PreFatalScore);
	$("#pre_fatal_score").val(PreFatalScore);
	//$("#pc_score").val(PcScore);	
}


///below are the function for escalation....

//Show escalations type
function show_escType()
{
	$('#esc_type').show();
	
}

function change_escType(val)
{
	if(val == 'Overall')
	{
		$('#overall_cmt').show();
		$('#att_wise').hide();
		$('#btn1').show();
	} else if(val == 'attribute_wise'){
		$('#att_wise').show();
		$('#overall_cmt').hide();
		$('#btn1').show();
	} else if(val == 'both'){
		$('#overall_cmt').show();
		$('#att_wise').show();
		$('#btn1').show();
	} else {
		$('#overall_cmt').hide();
		$('#att_wise').hide();
		$('#btn1').hide();
	}
	
}
$(document).ready(function(){
    $('.timepicker').timepicker({twelveHour:false});
});

</script>