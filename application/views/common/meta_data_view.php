
<?php 
    $unique_id=uniqid();
    ?>
<div class="form-section mt-24">  
    <div class="card">
        <div class="card-content">
            <h4 class="card-title"><?=ucfirst($title)?></h4>
            <div class="form col">
                <div class="row mb-0">
                <input type="hidden"  name="form_version" value="<?=$form_version?>">
                    <div class="input-field col l3 m4 s12">
                        <input id="unique_id" name="unique_id" type="text" value="<?php echo (!empty($meta_data['unique_id']) ? $meta_data['unique_id'] : $unique_id); ?>"  readonly="true" placeholder="">
                        <label for="unique_id" class="">Unique ID</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="evaluator_name" name="evaluator_name" type="text" value="<?php echo (!empty($meta_data['evaluator_name']) ? $meta_data['evaluator_name'] : $this->session->userdata('name')); ?>"   readonly="true" placeholder="">
                        <label for="evaluator_name" class="">Evaluator</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="evaluator_id" name="evaluator_id" type="text" value="<?php echo (!empty($meta_data['evaluator_id']) ? $meta_data['evaluator_id'] : $this->session->userdata('empid')); ?>"  readonly="true" placeholder="">
                        <label for="evaluator_id" class="">Evaluator ID</label>
                    </div>
                    
                    <div class="input-field col l3 m4 s12">
                        <select id="agent_id" name="agent_id">
                            <option value="" >Select</option>
                            <?php
                                foreach($agent_deatils as $agent){
                                $selected = '';
                                if(!empty($meta_data['agent_id'])) {
                                    if($meta_data['agent_id'] ==  $agent->empid){
                                        $selected = 'selected';
                                    } else {
                                    $selected = '';
                                    }
                                }
                                echo '<option  '.$selected.' value="'.$agent->empid.'" >'.$agent->empid.'</option>';
                            } 
                            ?>
                        </select>
                        <label for="aggent_id" class="">Agent ID</label>
                    </div>

                    <div class="input-field col l3 m4 s12">
                        <input id="agent_name" name="agent_name" type="text" value="<?php echo (!empty($meta_data['agent_name']) ? $meta_data['agent_name'] : ''); ?>" readonly="true" placeholder="">
                        <label for="agent_name" class="">Agent Name</label>
                    </div>
                    
                    <div class="input-field col l3 m4 s12">
                        <input name="supervisor" id="supervisor" type="text" value="<?php echo (!empty($meta_data['supervisor']) ? $meta_data['supervisor'] : ''); ?>" readonly="true" placeholder="">
                        <label for="supervisor" class="">Supervisor</label>
                    </div>

                    <div class="input-field col l3 m4 s12">
                        <input name="supervisor_id" id="supervisor_id" value="<?php echo (!empty($meta_data['supervisor_id']) ? $meta_data['supervisor_id'] : ''); ?>"  type="text"  readonly="true" placeholder="">
                        <label for="supervisor_id"  class="">Supervisor ID</label>
                    </div>
    
                    <div class="input-field col l3 m4 s12">
                        <input id="vendor" name="vendor" type="text" value="<?php echo (!empty($meta_data['vendor']) ? $meta_data['vendor'] : ''); ?>"   readonly="true" placeholder="">
                        <label for="vendor" class="">Vendor</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="lob" name="lob" type="text" value="<?php echo (!empty($meta_data['lob']) ? $meta_data['lob'] : ''); ?>" readonly="true" placeholder="">
                        <label for="lob" class="">LOB</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="location" name="location" type="text" value="<?php echo (!empty($meta_data['location']) ? $meta_data['location'] : ''); ?>" readonly="true" placeholder="">
                        <label for="location" class="">Location</label>
                    </div>
                    
                    <div class="input-field col l3 m4 s12">
                        <input id="campaign" name="campaign" type="text" value="<?php echo (!empty($meta_data['campaign']) ? $meta_data['campaign'] : ''); ?>" readonly="true" placeholder="">
                        <label for="campaign" class="">Campaign</label>
                    </div>
                    
                    <div class="input-field col l3 m4 s12">
                        <input id="call_date" class="datepicker" name="call_date" value="<?php echo (!empty($meta_data['call_date']) ? $meta_data['call_date'] : ''); ?>" type="text"  readonly="true" placeholder="">
                        <label for="call_date" class="">Call Date </label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <select id="lang" name="lang">
                                <?php
                                $enselected = '';
                                $hinselected = '';
                                if(!empty($meta_data['lang'])){
                                    if($meta_data['lang'] == 'english'){
                                    $enselected = 'selected';
                                    } else {
                                    $enselected = '';
                                    } 
                                    if($meta_data['lang'] == 'hindi'){
                                    $hinselected = 'selected';
                                    } else {
                                    $hinselected = '';
                                    } 
                                    if($meta_data['lang'] == 'punjabi'){
                                        $hinselected = 'selected';
                                        } else {
                                        $hinselected = '';
                                        } 
                                }
                                ?>
                            <option value="" >Select</option>
                            <option <?=$enselected?> value="english">English</option>
                            <option <?=$hinselected?>value="hindi">Hindi</option>
                            <option <?=$hinselected?>value="punjabi">Punjabi</option>
                        </select>
                        <label for="lang" class="">Language</label>
                    </div>

                    <!-- <div class="input-field col l3 m4 s12">
                        <input id="ticket_id" name="ticket_id" type="text" value="<?php echo (!empty($meta_data['ticket_id']) ? $meta_data['ticket_id'] : ''); ?>" placeholder="">
                        <label for="ticket_id" class="">Ticket ID</label>
                    </div> -->

                    <div class="input-field col l3 m4 s12">
                        <input id="call_id" name="call_id" type="text" value="<?php echo (!empty($meta_data['call_id']) ? $meta_data['call_id'] : ''); ?>" placeholder="">
                        <label for="call_id" class="">Call ID</label>
                    </div>

                    <div class="input-field col l3 m4 s12">
                        <input id="channels" name="channels" type="text" value="<?php echo (!empty($meta_data['channels']) ? $meta_data['channels'] : $channels); ?>" readonly="true" placeholder="">
                        <label for="channels" class="">Channels Type</label>
                    </div>

                    <div class="input-field col l3 m4 s12">
                        <input id="issue_type" name="issue_type" type="text" value="<?php echo (!empty($meta_data['issue_type']) ? $meta_data['issue_type'] : ''); ?>" placeholder="">
                        <label for="issue_type" class="">Issue Type</label>
                    </div>
                    <!--- Callibration Section start here  -->
                    <?php if($action == 'callibrate_view')  { ?>
                    
                    <?php if($opsRecords)  { ?>
                    <div class="input-field col l3 m4 s12">
                        <input id="pre_fatal_score" name="pre_fatal_score" type="text"  value="<?php echo (!empty($opsRecords['pre_fatal_score']) ? $opsRecords['pre_fatal_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="pre_fatal_score" class="">Ops Pre Fatal Score</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="total_score" name="total_score" type="text" value="<?php echo (!empty($opsRecords['total_score']) ? $opsRecords['total_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="total_score" class="">Ops Total Score</label>
                    </div>
                    <?php }  if($clientRecords)  { ?>
                    <div class="input-field col l3 m4 s12">
                        <input id="pre_fatal_score" name="pre_fatal_score" type="text"  value="<?php echo (!empty($clientRecords['pre_fatal_score']) ? $clientRecords['pre_fatal_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="pre_fatal_score" class="">Client Pre Fatal Score</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="total_score" name="total_score" type="text" value="<?php echo (!empty($clientRecords['total_score']) ? $clientRecords['total_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="total_score" class="">Client Total Score</label>
                    </div>
                    <?php } ?>
                    <!-- callibration section end here -->
                    <?php }  else { ?>
                        <div class="input-field col l3 m4 s12">
                        <input id="wrap_time" name="wrap_time" type="text" placeholder="Enter Wrap Time" readonly="true"  value="<?php echo (!empty($meta_data['wrap_time']) ? $meta_data['wrap_time'] : ''); ?>" placeholder="">
                        <label for="wrap_time" class="">Wrap Time</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="pre_fatal_score" name="pre_fatal_score" type="text"  value="<?php echo (!empty($meta_data['pre_fatal_score']) ? $meta_data['pre_fatal_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="pre_fatal_score" class="">Pre Fatal Score</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="total_score" name="total_score" type="text" value="<?php echo (!empty($meta_data['total_score']) ? $meta_data['total_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="total_score" class="">Total Score</label>
                    </div>
                    <?php }  ?>
                    <!-- ATA section start here -->
                    <?php if($action=='ata_view') { ?>
                    <div class="input-field col l3 m4 s12">
                        <input id="pre_fatal_score" name="pre_fatal_score" type="text"  value="<?php echo (!empty($ATARecords['pre_fatal_score']) ? $ATARecords['pre_fatal_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="pre_fatal_score" class="">ATA Pre Fatal Score</label>
                    </div>
                    <div class="input-field col l3 m4 s12">
                        <input id="total_score" name="total_score" type="text" value="<?php echo (!empty($ATARecords['total_score']) ? $ATARecords['total_score'] : ''); ?>" readonly="true" placeholder="">
                        <label for="total_score" class="">ATA Total Score</label>
                    </div>
                    <?php } //ata section end here 
                    // echo '<pre>';
                    // print_r($this->emp_group);
                    if(empty($meta_data['content_upload']) && $this->emp_group == 'ops' && $this->emp_type == 'agent'){
                    ?>
                    <!-- Rajesh Sharma code Start -->
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="contant_upload[]" id="contant_upload"  multiple/>
                            </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <?php } ?>
                    <!-- Rajesh Sharma code end -->
                </div>
            </div>
        </div>
    </div>
</div>




<!-- preview section -->
<?php if(!empty($meta_data['content_upload'])){ ?>
<div class="preview-section mt-24">
    <div class="card">
        <div class="card-content">
            <h4 class="card-title">Uploaded Files</h4>
            <div class="files_area">
                <ul>
                    <?php 
                    // echo "<pre>";print_r($meta_data['content_upload']);
                    $content_upload = explode('|',$meta_data['content_upload']);
                    foreach($content_upload as $key => $value){
                        $subdomin = explode('//',explode('.',site_url())[0])[1];
                        $getExc = explode(".",$value);
                        $extencion = strtolower(end($getExc));
                        echo "<li>";                                
                                if($extencion == "xlsx" || $extencion == "xls"){
                                    echo "<a href='".base_url()."assets/upload/$subdomin/formContent/$value' download>
                                    <embed src='".base_url()."assets/images/excel_file.png'><span class='preview-text'>Download</span></a>";
                                }
                                else if($extencion == "csv"){
                                    echo "<a href='".base_url()."assets/upload/$subdomin/formContent/$value' download>
                                    <embed src='".base_url()."assets/images/csv_file.png'><span class='preview-text'>Download</span></a>";
                                }
                                else if($extencion == "doc" || $extencion == "docx"){
                                    echo "<a href='".base_url()."assets/upload/$subdomin/formContent/$value' download>
                                    <embed src='".base_url()."assets/images/word_file.png'><span class='preview-text'>Download</span></a>";
                                }
                                else if($extencion == "msg"){
                                    echo "<a href='".base_url()."assets/upload/$subdomin/formContent/$value' download>
                                    <embed src='".base_url()."assets/images/msg.png'><span class='preview-text'>Download</span></a>";
                                }
                                else if($extencion == "pdf"){
                                    echo "<a data-target='upload_modal' class='modal-trigger' href='javascript:void(0)' formate='pdf' attr_src='".base_url()."assets/upload/$subdomin/formContent/$value'>
                                            <span class='embed_outer'>
                                                <embed src='".base_url()."assets/images/pdf_file.png'>
                                            </span>
                                            <span class='preview-text'>preview</span></a>";
                                }
                                else if($extencion == "txt"){
                                    echo "<a data-target='upload_modal' class='modal-trigger' href='javascript:void(0)' formate='pdf' attr_src='".base_url()."assets/upload/$subdomin/formContent/$value'>
                                            <span class='embed_outer'>
                                                <embed src='".base_url()."assets/images/txt.png'>
                                            </span>
                                            <span class='preview-text'>preview</span></a>";
                                }
                                else if($extencion == "mp3" || $extencion == "wav"){
                                    echo "<a data-target='upload_modal' class='modal-trigger' href='javascript:void(0)' formate='mp3' attr_src='".base_url()."assets/upload/$subdomin/formContent/$value'>
                                            <span class='embed_outer'>
                                                <embed src='".base_url()."assets/images/audio_file.png'>
                                            </span>
                                            <span class='preview-text'>preview</span></a>";
                                }
                                else if($extencion == "mp4"){
                                    echo "<a data-target='upload_modal' class='modal-trigger' href='javascript:void(0)' formate='mp4' attr_src='".base_url()."assets/upload/$subdomin/formContent/$value'>
                                            <span class='embed_outer'>
                                                <embed src='".base_url()."assets/images/video_file.png'>
                                            </span>
                                            <span class='preview-text'>preview</span></a>";
                                }
                                else{
                                    echo "<a  data-target='upload_modal' class='modal-trigger con_upload' href='javascript:void(0)' formate='jpg' attr_src='".base_url()."assets/upload/$subdomin/formContent/$value'>
                                <span class='embed_outer'><embed class='con_upload_data'  src= '".base_url()."assets/upload/$subdomin/formContent/$value'></span><span class='preview-text'>preview</span></a>";
                                }                                
                                echo "</li>";
                        
                        ?>
                        
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <div id="upload_modal" class="upload_modal modal">
        <div class="modal-content">
            <div class="modal-content-inner"></div>
            <a href="javascript:void(0)" class="modal-close"></a>
        </div>
    </div>
</div>
<?php } ?>

<script>
$(document).ready(function(){

     // $(".tbl_attr + td select option:nth-child(2)").prop("selected", true);
    // $(".tbl_attr + td select").formSelect();

    $('.modal-close').click(function(){
        $("#upload_modal").removeClass("img_modal audio_modal video_modal pdf_modal sfile_modal");
        $("#upload_modal").find(".modal-content-inner").html('');
    });
    $(".files_area li a").on("click", function(){
        var formate = $(this).attr('formate');
        var attr_scr = $(this).attr('attr_src');
        var html = '';
        if( formate === "mp3" ||  formate === "wav"){
            html += "<audio controls><source src='"+attr_scr+"' type='audio/ogg'><source src='"+attr_scr+"' type='audio/mpeg'></audio>";
            $("#upload_modal").addClass("audio_modal");
        }
        else if( formate === "mp4"){
            html += "<video width='100%' height='100%' controls><source src='"+attr_scr+"' type='video/mp4'><source src='"+attr_scr+"' type='video/ogg'></video>";
            $("#upload_modal").addClass("video_modal");
        }
        else if( formate === "pdf"){
            html += "<embed class='pdf_file' src='"+attr_scr+"'>";
            $("#upload_modal").addClass("pdf_modal");
        }
        else if( formate === "jpg" || formate === "jpeg" || formate === "png" || formate === "gif"){
            html += "<embed class='img_file' src='"+attr_scr+"'>";
            html += "<a class='download_btn' href='"+attr_scr+"' download><span class='flaticon-download-2'></span></a>";
            $("#upload_modal").addClass("img_modal");
        }
        else{
            html += "<embed src='"+attr_scr+"'>";
            html += "<a class='download_btn' href='"+attr_scr+"' download><span class='flaticon-download-2'></span></a>";
            $("#upload_modal").addClass("sfile_modal");
        }
        // var cur_element = $(this).find(".embed_outer").html();
        $("#upload_modal").find(".modal-content-inner").html(html);
        // console.log(cur_element);
    });

    

    $('#contant_upload').change(function(){
        var fp = $("#contant_upload");
        var lg = fp[0].files.length; // get length
        var items = fp[0].files;
        var fileSize = 0;
        if (lg > 0 && lg < 11) {
            for (var i = 0; i < lg; i++) {
                fileSize = items[i].size; // get file size
				fileName = items[i].name; // get file name
				console.log(fileSize)
				console.log(fileName)
                var  extension = fileName.split(".").pop(-1).toLowerCase();
                var valid_extension = ['gif','jpg','jpeg','png','csv','xls','xlsx','docx','doc','pdf','mp3','mp4','txt','msg','wav'];
                if(valid_extension.indexOf(extension) != -1) {
	                if(fileSize > 5097152) {
                        alert('Each File size must not be more than 5 MB');
                        $('#contant_upload').val('');
                    }					
                }
                else{
                    alert('This '+fileName+'  extension is not allowed');
                    $('#contant_upload').val('');
                }
            }
            
        }
		else{
            $('#contant_upload').val('');
			alert('You cannot upload more then 10 files');
        }
    });
});
</script>
