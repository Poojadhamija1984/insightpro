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
                                <h3 class="page-title">Report</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span><?=$title?></span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- FORM SECTION START -->
                   
                   <?php $attributes = array("id" => "form col",'class'=>'formview');
                    echo form_open_multipart("",$attributes);
                    ?>  
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Filters</h4>
                                <div class="row mb-0">
                                    <!-- Start Date  -->
                                    <div class="input-field col s12 m4 l3">
                                        <input id="fromdate" name="fromdate" type="text" class="datepicker"  value="<?php if($fromdate) { echo $fromdate; } else { echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) )); } ?>">
                                        <label for="fromdate" class="">From</label>
                                    </div>
                                    <!-- End Date  -->
                                    <div class="input-field col s12 m4 l3">
                                        <input id="todate" name="todate" type="text" class="datepicker" value="<?php 
                                        if($todate) { echo $todate; }else{ echo date('Y-m-d'); }?>">
                                        <label for="todate" class="">To</label>
                                    </div>
                                    <!-- Site  -->
                                        <div class="input-field col s12 m4 l3">
                                            <select id="site" name="site[]"    multiple class="selectbox"> 
                                                <option value="" disabled>All</option>
                                                <?php
                                                foreach($sites as $key => $site_value){
                                                    if(in_array($site_value->s_id,$sitePost)){
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }        

                                                    echo "<option  ".$selected." value='{$site_value->s_id}'>{$site_value->s_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="lob" class="">Site</label>
                                        </div>
                                     <!-- Template -->
                                      <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="groups" name="groups[]" multiple class="selectbox"> 
                                                <option value="" disabled >All</option>
                                                <?php
                                                foreach($groups as $key => $g_value){
                                                    if(in_array($g_value->g_id, $groupPost)){
                                                    $selected = 'selected';
                                                    } else {
                                                    $selected = '';
                                                    }
                                                   echo "<option ". $selected." value='{$g_value->g_id}'>{$g_value->g_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Groups</label>
                                        </div>
                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="tempaltes" name="tempaltes[]" multiple class="selectbox"> 
                                                <option value="" disabled >All</option>
                                                <?php
                                                foreach($tempaltes as $key => $g_value){
                                                   echo "<option value='{$g_value->tn}'>{$g_value->template_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Templates</label>
                                        </div>
                                    
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="submit" id="submit" class="btn cyan waves-effect waves-light right">
                                            <span>Run Report</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!-- FORM SECTION END -->
                  
                    <!-- TABLE SECTION START -->
                    <?php 
                        echo $content;
                    ?>



                    <!-- TABLE SECTION END -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->


                                <div id="alert_choose_modal" class="modal">
                                    <button type="button" class="users_modal_close modal-close"></button>
                                    <div class="modal-content">
                                        <h4>Update Status</h4>
                                      
                                        <div class="form col">
                                            <div class="row mb-0">
                                                <div class="col s12 m4">
                                                    <select name="status" id="status" required>
                                                        <option value="" >Select Status</option>
                                                         <option value="0" >Pending</option>
                                                          <option value="1" >Overdue</option>
                                                          <option value="2" >Closed</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                               
                                                <div class="col s12 msg_body_area">
                                                    <textarea name="att_comment" id="att_comment" class="materialize-textarea msg_body" placeholder="Add your comment"></textarea>
                                                     <input type="hidden" id="unique_id" name="unique_id">
                                                     <input type="hidden" id="tmp_unique_id" name="tmp_unique_id">
                                                      <input type="hidden" id="att_id" name="att_id">
                                                </div>
                                            <button type="submit" class="modal-close alert_submit_btn">Submit</button>
                                        </div>
                                    </div>
                               
                                </div>
                            </div>
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        
    </body>
</html>
<script type="text/javascript">

    selectedTemplate();
    function selectedTemplate(){
        var temp = '<?php echo json_encode(!empty($postTemplates)?$postTemplates:[]);?>';
        kpiRetention     =   JSON.parse(temp);
        if(kpiRetention.length > 0){
            $.each(kpiRetention, function(key2,val2){
                $('#tempaltes option[value="'+val2+'"]').attr("selected", "selected");
            });
        }
        //console.log('temp',kpiRetention);
    }
    function findata(unique_id , tmp_unique_id , att_id,status){
       $('#unique_id').val(unique_id);
       $('#tmp_unique_id').val(tmp_unique_id);
       $('#att_id').val(att_id);
       if(status=='Closed')
       {
       var base_url = "<?php echo site_url('ajaxdata'); ?>/closedStatus";
       var data = {'unique_id':unique_id,'att_id': att_id}
       var result = postAjax_With_Loder(base_url,data);
      if(result[0]['status']=='2')
      {
        
        $('#att_comment').val(result[0]['att_comment']);
        $(".alert_submit_btn").attr("disabled", true);
      }
       }else{
        $('#att_comment').val("");
        $(".alert_submit_btn").attr("disabled", false);
       }
    }
    $('.alert_submit_btn').click(function(){
        
        var status = $('#status').val();
        var att_comment = $('#att_comment').val();
        var unique_id = $('#unique_id').val();
        var tmp_unique_id = $('#tmp_unique_id').val();
        var att_id = $('#att_id').val();
        var data = {
            'status' : status,
            'att_comment' : att_comment,
            'unique_id' : unique_id,
            'tmp_unique_id' : tmp_unique_id,
            'att_id' : att_id
        }
       if(status !="") 
       {
       var base_url ='<?php echo site_url();?>/alert-submit';
       var response = postAjax_With_Loder(base_url,data);
       var updates = 'updatestatus';
        var updatedSatus = '';
        if(status==1){
            updatedSatus = 'Overdue';
            $('#'+unique_id+att_id+updates).css("background", "red");
        }
        else if(status==2){
            updatedSatus = 'Closed';
            $('#'+unique_id+att_id+updates).css("background", "green");
        }
        else{
            updatedSatus = 'Pending';
            $('#'+unique_id+att_id+updates).css("background", "#ff6e40");
        } 
        var cmt = '';
        if(att_comment){
            cmt = att_comment;
        }
        else {
            cmt = 'NA';
        }
        $('#'+unique_id+att_id+updates).html(updatedSatus);
        $('#cmt'+unique_id+att_id).html(cmt);
        alertBox('Status updated Successfully');
       }else{
        alertBox('Status is Required !');
       }
    });
    
</script>
<!--<script>
$(document).ready(function() {
    // $.fn.dataTable.ext.errMode = 'none';
    var reports_response  = postAjax('<?php echo site_url();?>/escalation/auditData',{'fromDate':$('#fromDate').val(),'toDate':$('#toDate').val(),'lob':$('#lob').val()});
        //console.log(reports_response);
        $('#escalation_data').dataTable({
            "bDestroy": true,
            responsive: true,
            fixedHeader: true,
            scrollX : true,
            //scrollY : '30vh',
            data:reports_response,
                    "columns": [
                        { 'data': 'unique_id' }, 
                        { 'data': 'lob' }, 
                        { 'data': 'call_id' } ,
                        { 'data': 'agent_id' },
                         { 'data': 'issue_type' },
                        { 'data': 'total_score' },
                        { 'data': 'status' }               
                    ]
         });
///oncliclik submit button 
    $('#submit').click(function(e){
        e.preventDefault();
        var reports_response  = postAjax('<?php echo site_url();?>/escalation/auditData',{'fromDate':$('#fromDate').val(),'toDate':$('#toDate').val(),'lob':$('#lob').val()});
       // console.log(reports_response);
        $('#escalation_data').dataTable({
            "bDestroy": true,
            responsive: true,
            fixedHeader: true,
            scrollX : true,
           // scrollY : '30vh',
            data:reports_response,
                    "columns": [
                        { 'data': 'unique_id' },
                        { 'data': 'lob' },  
                        { 'data': 'call_id' } ,
                        { 'data': 'agent_id' },
                        { 'data': 'issue_type' },
                        { 'data': 'total_score' },
                        { 'data': 'status' }               
                    ]
         });
   });

});
</script> -->