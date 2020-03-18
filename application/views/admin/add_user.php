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
                                <li class="breadcrumb-item"><span>Add User</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->
                <!-- PAGE ERROR START -->
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
                <!-- PAGE ERROR END -->
                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Add User</h4>
                            <?php  
                                $attributes = array('id' => 'agentFrm','class'=>'form col');
                                echo form_open_multipart('user_data',$attributes);
                            ?>
                                <div class="row mb-0">
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_01" type="text" name="user_name" id="user_name">
                                        <label for="field_01" class="">Name</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_06" type="text" name="empid" id="empid">
                                        <label for="field_06" class="">Employee Id</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <select id="field_03" name="role" id="role">
                                            <option value="" disabled selected>Select</option>
                                            <?php foreach($role as $value){ ?>
                                                <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="field_03" class="">User Type</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_05" type="email" name="email" id="email">
                                        <label for="field_05" class="">Email</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_06" type="text" class="datepicker" name="doj" id="doj">
                                        <label for="field_06" class="">Date of Joining</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_06" type="text" name="password" id="password">
                                        <label for="field_06" class="">Password</label>
                                    </div>
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="submit" class="btn cyan waves-effect waves-light right">
                                            <span>Submit</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
                <!-- FORM SECTION END -->

                <!-- TABLE SECTION START -->
                <div class="table-section px-24 my-24">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h4 class="card-title m-0">User Registration</h4>
                                <div class="card-btns"></div>
                            </div>
                            <table class="csv_table stripe hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Emp Code</th>
                                        <th>Emp Name</th>
                                        <th>Emp Role</th>
                                        <th>Emp Email</th>
                                        <th>Permission</th>
                                        <th class="center">Status</th>
                                        <th class="center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $count= 0;
                                        foreach($emp_info as $value){
                                    ?>
                                            <tr>
                                                <td><?php echo ++$count;?></td>
                                                <td><?php echo $value['empid'];?></td>
                                                <td><?php echo $value['name'];?></td>
                                                <td><?php echo $value['usertype'];?></td>
                                                <td><?php echo $value['user_email'];?></td>
                                                <td><a href="<?php echo site_url();?>/user_permission/<?php echo $value['user_id'];?>">Permission</a></td>
                                                <td class="center">
                                                    <?php 
                                                        if($value['status'] == 1){
                                                            echo "<span class='status active badge green darken-1'>Active</span>";
                                                        }
                                                        else{
                                                            echo "<span class='status active badge red darken-1'>Intive</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="center">
                                                    <a href="<?php echo site_url();?>/Edit-user/<?php echo $value['user_id'];?>">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <?php 
                                                        if($value['status'] == 1){
                                                            echo "<button class='custom_switch switch active'>";
                                                        }
                                                        else{
                                                            echo "<button class='custom_switch switch '>";
                                                    }
                                                    ?>
                                                    
                                                        <span class="lever"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- TABLE SECTION END -->

                <!-- FOOTER SECTION START -->
                <footer><p class="m-0">2019 &copy; All Rights Reserved by <a href="https://www.mattsenkumar.com/" target="_blank">MattsenKumar LLC</a></p></footer>
                <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
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
                })
            })
        </script>
    </body>
</html>
