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
                            <h3 class="page-title"><?=$title;?></h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="<?php echo site_url().'/client_user'; ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><span><?=$title;?></span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->

                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Add User Information</h4>
                            <form class="form col">
                                <div class="row mb-0">
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_01" name="name" type="text">
                                        <label for="field_01"  class="">Name</label>
                                        <span class="field_error"><?php echo (!empty(form_error('name')) ?  form_error('name'):'' );?></span>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_02" name="empid" type="text">
                                        <label for="field_02" class="">Employee ID</label>
                                        <span class="field_error"><?php echo (!empty(form_error('empid')) ?  form_error('empid'):'' );?></span>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <select id="usertype" name="usertype">
                                        <option value="" disabled selected>Select</option>
                                            <?php
                                             foreach ($user_type as $each_type) {
                                                echo '<option value="'.$each_type['usertype_id'].'">'.$each_type['usertype_name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="usertype" class="">User Type</label>
                                        <span class="field_error"><?php echo (!empty(form_error('usertype')) ?  form_error('usertype'):'' );?></span>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_04" name="user_email" type="text">
                                        <label for="field_04" class="">Email ID</label>
                                        <span class="field_error"><?php echo (!empty(form_error('user_email')) ?  form_error('user_email'):'' );?></span>
                                    </div>
                                    
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_06" name="name" type="text" class="datepicker">
                                        <label for="field_06" class="">Date of Joining</label>
                                        <span class="field_error"><?php echo (!empty(form_error('name')) ?  form_error('name'):'' );?></span>
                                    </div>

                                    <div class="input-field col l4 m6 s12 div_analyst">
                                        <select id="sup_name" name="sup_name">
                                        <option value="" disabled selected>Select</option>
                                            <?php
                                             foreach ($sup_name as $each_sup_name) {
                                                echo '<option value="'.$each_sup_name['empid'].'">'.$each_sup_name['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="sup_name" class="">Supervisor Name</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12 div_analyst">
                                        <input id="sup_id" name="sup_id" type="text" placeholder="" readonly>
                                        <label for="sup_id" class="">Supervisor ID</label>
                                     </div>


                                     <div class="input-field col l4 m6 s12 div_professional">
                                        <select id="lob" name="lob">
                                        <option value="" disabled selected>Select</option>
                                            <?php
                                             foreach ($lob as $each_lob) {
                                                echo '<option value="'.$each_lob['lob'].'">'.$each_lob['lob'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="lob" class="">LOB</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12 div_professional">
                                        <select id="campaign" name="campaign">
                                        <option value="" disabled selected>Select</option>
                                            <?php
                                             foreach ($campaign as $each_campaign) {
                                                echo '<option value="'.$each_campaign['campaign'].'">'.$each_campaign['campaign'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="campaign" class="">Campaign</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12 div_professional">
                                        <select id="vendor" name="vendor">
                                        <option value="" disabled selected>Select</option>
                                            <?php
                                             foreach ($vendor as $each_vendor) {
                                                echo '<option value="'.$each_vendor['vendor'].'">'.$each_vendor['vendor'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="vendor" class="">Vendor</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12 div_professional">
                                        <select id="location" name="location">
                                        <option value="" disabled selected>Select</option>
                                            <?php
                                             foreach ($location as $each_location) {
                                                echo '<option value="'.$each_location['location'].'">'.$each_location['location'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="location" class="">Location</label>
                                    </div>
                                    

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
                            </form>
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
                                        <th>User Name</th>
                                        <th>User Type</th>
                                        <th>Email ID</th>
                                        <th class="center">Status</th>
                                        <th class="center">Set Permission</th>
                                        <th class="center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>abc</td>
                                        <td>admin</td>
                                        <td>admin@mattsenkumar.com</td>
                                        <td class="center"><span class="status active badge green darken-1">Active</span></td>
                                        <td class="center"><a class="permission_btn" href="permission_page.html">Set Permission</a></td>
                                        <td class="center">
                                            <a href="edit_user_registration.html">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="custom_switch switch active">
                                                <span class="lever"></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- TABLE SECTION END -->
                
                <!-- FOOTER SECTION START -->
                <?php $this->load->view('common/footer_view')  ?>
                <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        <script>
        $(document).ready(function(){
            $('.div_analyst,.div_professional').hide();
            $('#usertype').change(function(){
                if($(this).val() == 4)
                {
                    $('.div_analyst').show();
                     $('.div_professional').hide();
                }
                else if($(this).val() == 6)
                {
                    $('.div_professional').show();
                     $('.div_analyst').hide();
                }
                else{
                    $('.div_analyst,.div_professional').hide();
                }
            });
            $('#sup_name').change(function(){
                $('#sup_id').val($(this).val());
            });

        });
        </script>
    </body>
</html>
