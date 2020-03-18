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
                <!-- BREADCRUMB SECTION START -->
                <div class="breadcrumb-section p-24">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Admin</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="index.html">User Registration</a></li>
                                <li class="breadcrumb-item"><span>User Permission</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->

                <!-- PAGE ERROR -->
                <?php 
                    if($this->session->flashdata('success')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error success mb-12"><?php echo $this->session->flashdata('success');?></div>
                    </div>
                <?php 
                }
                if($this->session->flashdata('error')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error failure mb-12"><?php echo $this->session->flashdata('error');?></div>
                    </div>
                <?php 
                    }
                ?>

                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">User Permission</h4>
                            <?php  
                            $attributes = array('id' => 'agentFrmaaaa','class'=>'form col');
                                echo form_open_multipart('user_permission_data',$attributes);
                                echo form_close();

                                $attributes = array('id' => 'agentFrm','class'=>'form col');
                                echo form_open_multipart('user_permission_data',$attributes);
                            ?>
                                <div class="row mb-0">
                                    <div class="input-field col l4 m6 s12">
                                        <!-- <input id="field_01" type="text" name="add_role[]"> -->
                                        <?php 
                                            if($id == ''){ 
                                        ?>
                                                <select id="field_01" name="add_role[]" multiple>
                                                    <option>Select</option>
                                                    <?php 
                                                        foreach($user as $val){
                                                    ?>
                                                        <option value="<?php echo $val->user_id; ?>"><?php echo $val->name;?> (<?php echo $val->empid;?>)</option>
                                                    <?php    
                                                        }
                                                    ?>
                                                </select>
                                                <label for="field_01" class="">Add Role</label>                                        
                                        <?php
                                            }
                                            else{
                                        ?>
                                                <input type="hidden" name="add_role[]" value="<?php echo $id;?>">
                                        <?php             
                                            }
                                        ?>
                                        
                                    </div>
                                </div>
                                <div class="table-section mt-24">
                                    <table class="data_table stripe hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Page Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php   
                                                $count = 0;
                                                foreach ($permissions as $key => $value) {
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <label>
                                                                
                                                            <input type="checkbox" name="page[]" <?php if (strpos($user_permission, $value->id) !== false) { echo 'checked';}?>  value="<?php echo $value->id;?>"/>
                                                            <span></span>
                                                        </label>
                                                        </td>
                                                        <td>
                                                            <?php echo $value->subpage_name;?>
                                                        </td>
                                                    </tr>
                                            <?php 
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="submit" class="btn cyan waves-effect waves-light right">
                                            <span>Submit</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                        <!-- <button type="reset" class="btn grey waves-effect waves-light right">
                                            <span>Reset</span>
                                        </button> -->
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
                <!-- FORM SECTION END -->

                <!-- FOOTER SECTION START -->
                <footer><p class="m-0">2019 &copy; All Rights Reserved by <a href="https://www.mattsenkumar.com/" target="_blank">MattsenKumar LLC</a></p></footer>
                <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        <style type="text/css">
            .dataTables_length,.dataTables_filter{
                display: none !important;
            }
        </style>
        <script type="text/javascript">
            $(function(){
                
                
                var count = 1;
                $('#addmore').click(function(){
                    count++;
                    html = "<div class='input-field col l4 m6 s12'>"+
                                "<input id='field_0"+count+"' type='text' name='add_role[]'>"+
                                "<label for='field_0"+count+"' class=''>Add Role</label>"+                                        
                                "</div>";
                    $('#addDiv').append(html);
                });

                $('.del').click(function(){
                    var id = $(this).attr('rid');
                    $.ajax({
                        url:"<?php echo site_url();?>/delete_role",
                        type:'delete',
                        data:{id:id},
                        success:function(res){
                            location.reload();

                        }
                    })
                });

                $('.user_role').click(function() {
                    var aid = $(this).attr('rid');
                    $(this).val() == "1" ? play_int(aid) : play_pause(aid);
                });
            });
            function play_int(id) {
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                var dataJson = { [csrfName]: csrfHash, id: id,status: 0};
                $('.agentStatus').val("1");
                $.ajax({
                    url:'<?php echo site_url()?>/update_role',
                    type:'PUT',
                    data:dataJson,
                    success:function(result){
                           location.reload();
                    }
                })
                // do play
            }
            function play_pause(id) {
                $('.agentStatus').val("0");
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                var dataJson = { [csrfName]: csrfHash, id: "hello", id: id,status: 1};
                $('.agentStatus').val("1");
                $.ajax({
                    url:'<?php echo site_url()?>/update_role',
                    type:'PUT',
                    data:dataJson,
                    success:function(result){
                        location.reload()
                    }

                })
                // do pause
            }
        </script>
    </body>
</html>
