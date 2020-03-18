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
                            <h3 class="page-title">User Registration</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item"><span>User Registration</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->

                <!-- PAGE ERROR -->
                <div class="error_section px-24">
                    <div class="page_error success mb-12">Form Submitted Successfully</div>
                </div>
                <div class="error_section px-24">
                    <div class="page_error failure mb-12">Form Submitted Successfully</div>
                </div>

                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Add User Information</h4>
                            <form class="form col">
                                <div class="row mb-0">
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_01" type="text">
                                        <label for="field_01" class="">Name</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_02" type="text">
                                        <label for="field_02" class="">Employee ID</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <select id="field_03" >
                                            <option value="" disabled selected>Select</option>
                                            <option value="admin">Admin</option>
                                            <option value="administrator">Administrator</option>
                                            <option value="supervisor-analyst">Supervisor Analyst</option>
                                            <option value="analyst">Analyst</option>
                                            <option value="enterprise">Enterprise</option>
                                            <option value="professional">Professional</option>
                                            <option value="authorizer">Authorizer</option>
                                        </select>
                                        <label for="field_03" class="">User Type</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_04" type="text">
                                        <label for="field_04" class="">User Name</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_05" type="email">
                                        <label for="field_05" class="">Email</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_06" type="text" class="datepicker">
                                        <label for="field_06" class="">Date of Joining</label>
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
                <footer><p class="m-0">2019 &copy; All Rights Reserved by <a href="https://www.mattsenkumar.com/" target="_blank">MattsenKumar LLC</a></p></footer>
                <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
                    
    </body>
</html>

<script type="text/javascript">

function nospaces(t){

if(t.value.match(/\s/g)){

alert('Sorry, you are not allowed to enter any spaces');

t.value=t.value.replace(/\s/g,'');

}

}

</script>

 