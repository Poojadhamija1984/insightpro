
<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>



    <body class="template_ui">
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
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR -->
                    <div class="error_section mb-12">
                    <?php
                        if($this->session->flashdata('msg')){
                            echo $this->session->flashdata('msg'); 
                        }
                    ?>
                    </div>
                    <!-- PAGE ERROR END -->
                    
                    <!-- FORM SECTION START -->
                    <div class="form-section template_container mt-24">
                    <?php $attributes = array("id" => "form col",'class'=>'formview');
                    echo form_open_multipart("templateViewController/form_submit/".$formName."/".$action."/".$tmp_unique_id ,$attributes);
                    ?>  
                     <?php 
                    if($action=='fill')
                    { ?>
                    <input type="hidden" name="audit_counter" value="" id="counter_hour_<?php echo $tmp_unique_id;?>">
                   
                   <?php } ?>
                    
                    <?php echo $form_content; ?>
                    </form>
                    </div> 

                    <!-- FORM SECTION END -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>

            <div id="upload_modal" class="upload_modal modal">
        <div class="modal-content">
            <div class="modal-content-inner"></div>
            <a href="javascript:void(0)" class="modal-close"></a>
        </div>
    </div>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
 <script src="<?php echo base_url();?>assets/js/materializedatetimepicker.js"></script>
  <script>
  $(document).ready(function () {
    M.AutoInit();
    var DateField = MaterialDateTimePicker.create($('.datetimepicker'))
});
        $(document).ready(function(){
            $('.modal-close').click(function(){
            $("#upload_modal").removeClass("img_modal audio_modal video_modal pdf_modal sfile_modal");
            $("#upload_modal").find(".modal-content-inner").html('');
        });
        $(".photo_frame_cont  a").on("click", function(){
            var formate = $(this).attr('formate');
            var attr_scr = $(this).attr('attr_src');
            var html = '';
            if( formate === "mp3"){
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
        if($(".Question_ans_selects").length) {
            $(".Question_ans_selects").each(function(){
                $(this).find(".ans_custom_radio").each(function(){
                    if($(this).prop("checked")==true) {
                        var bg_color = $(this).siblings("span").attr("data-bgcolor");
                        $(this).siblings("span").css("background-color", bg_color);
                        //$(this).closest(".ans_custom_label").siblings(".ans_custom_label").find("span").css("background-color", "#e8e8e8");
                    }
                })
                $(this).find(".ans_custom_check").each(function(){
                    if($(this).prop("checked")==true) {
                        var bg_color = $(this).siblings("span").attr("data-bgcolor");
                        $(this).siblings("span").css("background-color", bg_color);
                    }
                })
            })  
        }
        $(document).on("click", ".ans_custom_label", function(){
            if($(this).find(".ans_custom_radio").prop("checked")==true) {
                var bg_color = $(this).find("span").attr("data-bgcolor");
                $(this).siblings().find("span").css("background-color", "#e8e8e8");
                $(this).find("span").css("background-color", bg_color);
            } 
            else if($(this).find(".ans_custom_check").prop("checked")==true) {
                var bg_color = $(this).find("span").attr("data-bgcolor");
                $(this).find("span").css("background-color", bg_color);
            }
            else {
                $(this).find("span").css("background-color", "#e8e8e8");
            }
        })
        $('.timepicker').timepicker();
        if($(".Question_ans_attachments").length) {
            $(".Question_ans_attachments").each(function(){
                if($(this).find(".photo_frame").length) {
                    console.log($(this).find(".photo_frame").length)
                    $(this).find(".attachment_images_link").css("display","none");
                    $(this).find(".photo_frame_cont").css("display","block");
                } else {
                    console.log(0)
                    $(this).find(".attachment_images_link").css("display","block");
                    $(this).find(".photo_frame_cont").css("display","none");
                }
            })
        }
        $(".attachment_notes_link").click(function(){
            $(this).css("display","none").siblings(".attachment_textbox").show();
        });
        $(".attachment_textbox_del").click(function(){
            $(this).closest(".attachment_textbox").hide().find("textarea").val("");
            $(this).closest(".attachment_textbox").siblings(".attachment_notes_link").css("display","block");
        });
        $(document).on("click", ".attachment_img_del", function(){
            var filename = $(this).attr('filename')
            $.ajax({
                        url: '<?php echo site_url();?>/del-attr-file/'+filename,
                        async: false,
                        type: 'get',
                        success: function (res) {
                        }
                    });
            if($(this).closest(".photo_frame").is(":only-child")) {
                $(this).closest(".photo_frame_cont").css("display","none");
                $(this).closest(".attachment_images").find(".attachment_images_link").css("display","block");
                $(this).closest(".photo_frame").remove();
            } else {
                $(this).closest(".photo_frame").remove();
            }
        });
        $(document).on("click", ".Question_link", function(){
            $(this).closest(".Question_single").find(".Question_ans_btm").slideToggle(200);
        });
        $(".attachment_images_link input[type=file]").on("change", function(){
            /////////////////////////////////////////
            var fp = $('#'+$(this).attr('id'));
            var lg = fp[0].files.length; // get length
            var items = fp[0].files;
            var fileSize = 0;
            var num_of_files = 3; // no of files allowed
            if (lg > 0 && lg < num_of_files) {
                for (var i = 0; i < lg; i++) {
                    fileSize = items[i].size; // get file size
                    fileName = items[i].name; // get file name
                    var  extension = fileName.split(".").pop(-1).toLowerCase();
                    var valid_extension = ['gif','jpg','jpeg','png','csv','xls','xlsx','docx','doc','pdf','mp3','mp4','txt','msg'];
                    if(valid_extension.indexOf(extension) != -1) {
                        if(fileSize > 5097152) {
                            alertBox('Each File size must not be more than 5 MB');
                            $('#'+$(this).attr('id')).val('');
                            return false;
                        }					
                    }
                    else{
                        alertBox('This '+fileName+'  extension is not allowed');
                        $('#'+$(this).attr('id')).val('');
                        return false;
                    }
                }
                
            }
            else{
                $('#'+$(this).attr('id')).val('');
                alertBox('You cannot upload more then '+(num_of_files-1)+' files');
                return false;
            }
            //////////////////////////////////////
            var file_name       =   $(this).attr('file_name');
            var attr_id         =   $(this).attr('id');
            var unique_id       =   $('#unique_id').val();
            var tmp_unique_id   =   $('#tmp_unique_id').val();
            var file_data       =   $(this).prop('files');
            var temp_file_name = tmp_unique_id+'_'+unique_id+'_'+attr_id;
            var fdata = new FormData();
            $.each(file_data,function(key,val){
                fdata.append('file[]', val);
            });
            
            fdata.append('attr_id', attr_id);
            fdata.append('unique_id', unique_id);
            fdata.append('tmp_unique_id', tmp_unique_id);
            fdata.append('csrf_test_name', $('#csrf_token').val());
            var base_url = '<?php echo site_url();?>/attr-file-upload';
            $.ajax({
                url: base_url,
                async: false,
                type: 'post',
                //enctype: 'multipart/form-data',
                processData : false,
                contentType: false,
                dataType: 'json',
                data: fdata,
                success: function (res) {
                    $('input[name="csrf_test_name"]').val(res.csrfHash);
                    //dataSet = res.data;
                }
            });
            var frame_cont = $(this).closest(".attachment_images").find('.photo_frame').length;
            var len = $(this).get(0).files.length;
            if(len != 0) {
                $(this).closest(".attachment_images_link").css("display", "none");
                $(this).closest(".attachment_images").find('.photo_frame_cont').css("display", "block");
                for(var i=0;i<len;i++) {
                    var content = '';
                    var file_extension = event.target.files[i].name.split(".")[1].toLowerCase();
                    if(file_extension == "xlsx" || file_extension == "xls"){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/excel_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "csv"){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/csv_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "doc" || file_extension == "docx"){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/word_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "xlsx" || file_extension == "xls"){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/excel_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "msg" ){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/msg.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "pdf" ){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/pdf_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "txt" ){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/txt.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "mp3" ){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/audio_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "mp4" ){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/video_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "mp4" ){
                        content +="<div class='photo_frame'><embed src='<?php echo base_url();?>assets/images/video_file.png'><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    else if(file_extension == "gif" || file_extension == "jpeg" || file_extension == "png" || file_extension == "jpg"){
                        content +="<div class='photo_frame'><img src="+URL.createObjectURL(event.target.files[i])+" ><a fileName='"+temp_file_name+'_'+i+'.'+file_extension+"' href='javascript:void(0)' class='attachment_img_del flaticon-delete-button'></a></div>";
                    }
                    $(this).closest(".attachment_images").find('.photo_frame_cont').append(content);
                    content = '';
                }
                //$(this).closest(".attachment_images").find('.photo_frame_cont').append('<a href="javascript:void(0)" class="files_upload_btn">Upload</a>');
                //$(this).val(null);

            } 
            else {
                if(frame_cont != 0) {
                    $(this).closest(".attachment_images").find('.photo_frame_cont').css("display", "block");
                    $(this).closest(".attachment_images_link").css("display", "none");
                } else {
                    $(this).closest(".attachment_images_link").css("display", "block");
                    $(this).closest(".attachment_images").find('.photo_frame_cont').css("display", "none");
                }
                //console.log("hello repeate2")
                
            }
        });
    })
</script>


<script type="text/javascript">
function setscore(att_id,cat_id,score,isFailed,id,selType,att_value,mscore)
{  
     var sumPeratttScore = 0;
     var totalSumAchieve = 0;
     var totalPossSum = 0;
     var catPossSum = 0;
     var catAchieveSum =0;
     var catTotalSum = 0;
     var sum = 0; 
    var att_score_name=att_id.split('_')[0]+"_score";
    // var testname = att_id.split('_')[0];
    //  console.log(testname);

    var perattscore = 'set_score_'+att_id;
    var attFailedName = att_id.split('_')[0] +"_fail";
     //per attribute possible score except na
     var pscore = att_id.split('_')[0]+"_scoreNA";
     var catsumNA = 0; 
     var sumNA = 0; 
     /// if selection type checkbox
    if(selType == 1 || selType == 3){
    if($('#'+id).prop("checked") == true){      
    $('#'+id).attr(perattscore, score);
    $("input["+perattscore+"]").each(function(){
     sumPeratttScore+=parseFloat($(this).attr(perattscore));
    });
    
    /// set NA score per attribute
     if(att_value =='na' || att_value == 'n/a'){
            $('#'+pscore).val(mscore);
         } else {
            $('#'+pscore).val(0);
         }
     if(sumPeratttScore > 0){
        $('#'+pscore).val(0);
     }
     $('#'+att_score_name).val(sumPeratttScore);

    }
    else if($('#'+id).prop("checked") == false){
         sumPeratttScore = 0;
         $('#'+id).attr(perattscore, '0');
        $("input["+perattscore+"]").each(function(){
         sumPeratttScore+=parseFloat($(this).attr(perattscore));
        });
      /// set NA score per attribute
      if(att_value =='na' || att_value == 'n/a'){
        $('#'+pscore).val(0);
      }
      if(sumPeratttScore == 0) {
        $('#'+pscore).val(mscore);
      } else {
        $('#'+pscore).val(0);
      }
          //set each attribute value affer 
          $('#'+att_score_name).val(sumPeratttScore);
      } 

    } 
    else { // if selection type radio box
         $('#'+att_score_name).val(score);
         $('#'+attFailedName).val(isFailed);
         /// set NA score per attribute
         if(att_value =='na' || att_value == 'n/a'){
            $('#'+pscore).val(mscore);
         } else {
            $('#'+pscore).val(0);
         }
          
    }
    
   ///category wise sum of NA score
   $(".NA"+cat_id).each(function(){
            catsumNA += parseFloat($(this).val());      
   });

   /// category wise achieve sum
   $("."+cat_id).each(function(){
         var catPerAttScore = parseFloat($(this).val());
             catAchieveSum += catPerAttScore;
           
   });

   /// category wise possible sum
    $("input["+cat_id+"]").each(function(){
     catPossSum+=parseFloat($(this).attr(cat_id));
    });
    var catScoreD = catPossSum; 
    catPossSum    =     catPossSum - catsumNA;
    catTotalSum = ((catAchieveSum * 100)/catPossSum).toFixed(2); 
    if(catPossSum == 0){
        catTotalSum =0
    }
    $('#'+cat_id).val(catTotalSum);
    $('#'+cat_id+'_d').val(catPossSum);
    // console.log("A value " + catAchieveSum);
    // console.log("P value " + catPossSum);
    // console.log("NA value " + catsumNA);
    // console.log("cat id  " + cat_id);



    ///Sum total achieve 
    $(".forTotalScore").each(function(){
       var per_att_score = parseFloat($(this).val());
                totalSumAchieve+=per_att_score;           
    });

    ///sum  total possible score
    $("input[score]").each(function(){
           totalPossSum+=parseFloat($(this).attr('score'));  
    });
    
    ///All sum of NA 
    $(".NAforTotalScore").each(function(){
        sumNA += parseFloat($(this).val());
    });


     totalSumAchieve = totalSumAchieve;
     totalPossSum    = totalPossSum - sumNA;
     sum = (((totalSumAchieve)*100)/totalPossSum).toFixed(2); 
     if(totalPossSum == 0){
        sum  = 0; 
     }
     $("#total_score").val(sum);
    //$("#total_score_d").val('totalPossSum');
    $("#total_score_d").val('100');
     //console.log(sumNA);
    
}    

///for multi select checkbox validation..
jQuery(document).ready(function($) {
  var requiredCheckboxes = $(':checkbox[required]');
  requiredCheckboxes.on('change', function(e) {
    var checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
    var isChecked = checkboxGroup.is(':checked');
    checkboxGroup.prop('required', !isChecked);
  });
});
</script>
<!-- javascript for timer by jai-->
<script>
jQuery(document).ready(function($) { 
var timer ="";
d = new Date();
d.setHours(00);
d.setMinutes(00);
d.setSeconds(0, 0);
setInterval(function () {
//   document.getElementById("h").innerHTML = d.getHours();
//   document.getElementById("m").innerHTML = d.getMinutes();
//   document.getElementById("s").innerHTML = d.getSeconds();
  $('#counter_hour_<?php echo $tmp_unique_id;?>').val(d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
  d.setTime(d.getTime() + 1000);
}, 1000);


});
</script>
    </body>
</html>
