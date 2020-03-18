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
                <?php 
                    if($this->session->flashdata('message')){
                ?>
                        <div class="alert alert-info text-center">
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                <?php
                    }   
                ?>
                <!-- BREADCRUMB SECTION START -->
                <div class="breadcrumb-section p-24">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Agent Roster Upload</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item"><span>Agent</span></li>
                                <li class="breadcrumb-item"><span>Invalid Agent</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->

               
                <!-- TABLE SECTION START -->
                 <div class="table-section px-24 my-24">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <h4 class="card-title m-0">Agent Information</h4>
                            </div>
                            <table class="data_table stripe hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="tbl_sno"><span id="del"><i class="material-icons">delete</i></span></th>
                                        <th>Agent ID</th>
                                        <th>Agent Name</th>
                                        <th>LOB</th>
                                        <th>Vendor</th>
                                        <th>Location</th>
                                        <th>Campaign</th>
                                        <th class="center">Status</th>
                                        <th class="tbl_action center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(!empty($agentInfo)){
                                            foreach ($agentInfo as $key => $value) {
                                    ?>
                                                <tr>
                                                    <td class="tbl_sno">
                                                        <label>
                                                            <input type="checkbox" name="del_agent[]" value="<?php echo $value['agent_id'];?>"/>
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td><?php echo $value['agent_id']; ?></td>
                                                    <td><?php echo $value['agent_name']; ?></td>
                                                    <td><?php echo $value['lob']; ?></td>
                                                    <td><?php echo $value['vendor']; ?></td>
                                                    <td><?php echo ucfirst($value['location']); ?></td>
                                                    <td><?php echo $value['companion'] ?></td>
                                                    <td class="center">
                                                        <?php if($value['agent_status'] == 1){?>
                                                            <span class="status active badge green darken-1">Active</span>
                                                        <?php } else{?>
                                                            <span class="status active badge red darken-1">Inactive</span>
                                                        <?php }?>
                                                    </td>
                                                    <td class="center tbl_action">
                                                        <a href="<?php echo site_url();?>/edit_agent/<?php echo $value['agent_id'];?>">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                        <?php if($value['agent_status'] == 1){?>
                                                            <button class="custom_switch switch active agentStatus" value="1" agent="<?php echo $value['agent_id'];?>">
                                                                <span class="lever"></span>
                                                            </button>
                                                        <?php } else{?>
                                                                <button class="custom_switch switch agentStatus" value="0" agent="<?php echo $value['agent_id'];?>">
                                                                <span class="lever"></span>
                                                                <span class="lever"></span>
                                                            </button>
                                                        <?php }?>                                                    
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- TABLE SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
            <?php $this->load->view('common/footer_view') ?>
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        <script type="text/javascript">
            $(function(){
                $('.agentStatus').click(function() {
                    var aid = $(this).attr('agent');
                    $(this).val() == "1" ? play_int(aid) : play_pause(aid);
                });
                
                $("#del"). click(function(){
                    var aId = [];
                    $. each($("input[name='del_agent[]']:checked"), function(){
                        aId. push($(this). val());
                    });
                    if(aId.length == 0){
                        alert('Please Select Agent');
                        return false;
                    }else{
                        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                        var dataJson = { [csrfName]: csrfHash, id: aId};
                        $.ajax({
                            url:'<?php echo site_url()?>/delete_agent',
                            type:'POST',
                            data:dataJson,
                            success:function(result){
                                result = JSON.parse(result);
                                alert(result.massage);
                                location.reload();
                            }
                        });
                    }
                });
            });
            function play_int(id) {
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                var dataJson = { [csrfName]: csrfHash, id: id,status: 0};
                $('.agentStatus').val("1");
                $.ajax({
                    url:'<?php echo site_url()?>/updateStatus',
                    type:'POST',
                    data:dataJson,
                    success:function(result){
                        result = JSON.parse(result);
                        if(result.result == "Success"){
                            alert('Agent Inactive SuccessFull');
                           location.reload()
                        }
                        else{
                            alert('Some Error Please Try Again!');
                            location.reload()
                        }

                    }

                })
                // do play
            }
            function play_pause(id) {
                $('.agentStatus').val("0");
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                var dataJson = { [csrfName]: csrfHash, id: id,status: 1};
                $('.agentStatus').val("1");
                $.ajax({
                    url:'<?php echo site_url()?>/updateStatus',
                    type:'POST',
                    data:dataJson,
                    success:function(result){
                        result = JSON.parse(result);
                        if(result.result == "Success"){
                            alert('Agent Active SuccessFull');
                            location.reload()
                        }
                        else{
                            alert('Some Error Please Try Again!');
                            location.reload()
                        }
                    }

                })
                // do pause
            }

        </script>
    </body>
</html>