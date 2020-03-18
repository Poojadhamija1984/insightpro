<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
<body>
	<?php 
        if($this->session->flashdata('message')){
        ?>
            <div class="error_section px-24">
                <div class="page_error success mb-12">
                    <div class="alert alert-info text-center">
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                </div>
            </div>
        <?php
            }   
        ?>
        <?php 
            if($this->session->flashdata('error')){
        ?>
            <div class="error_section px-24">
                <div class="page_error failure mb-12">
                    <div class="alert alert-info text-center">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
    <div class="page-wrapper">
        <?php $this->load->view('common/header_view') ?>
        <?php $this->load->view('common/sidebar_view') ?>
        <main>
            <!-- BREADCRUMB SECTION START -->
            <div class="breadcrumb-section p-24">
                <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                    <div class="breadcrumb-left">
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item"><span>User Management</span></li>
                        </ul>
                    </div>
                    <div class="breadcrumb-right"></div>
                </div>
            </div>
            <!-- BREADCRUMB SECTION END -->
    	   
            <div class="form-section px-24 mb-24">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <?php
                                $attributes = array('id' => 'login_form', 'class' => 'user-login z-depth-4','method'=>'POST');
                                echo form_open(site_url().'/add-user', $attributes); 
                            ?>
    	                        <div class="col">
                                    <div class="input-field col s12 l4 xl3">
                                        <input id="name" name="name" type="text" required oninvalid="InvalidMsg(this,'Please Enter Name','');" oninput="InvalidMsg(this);" value="<?php echo (!empty($user->name)?$user->name:'');?>">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col s12 l4 xl3">
                                        <input id="email" name="email" oninvalid="InvalidMsg(this,'Required email address','please enter a valid email address');" oninput="InvalidMsg(this);"  type="email" required="required" value="<?php echo (!empty($user->user_email)?$user->user_email:'');?>"/>
                                        <label for="email">email</label>
                                    </div>
                                    <?php 
            	                        if($this->uri->segment(3)){
                                            echo "<input type='hidden' name='method' value='edit'>";
                                            echo "<input type='hidden' name='id' value='".$this->uri->segment(4)."'>";
                                        }
                                        else{
                                            echo "<input type='hidden' name='method' value='add'>";
            	                        }
                                    ?>
                                    <div class="input-field col s12 l4 xl3">
                                        <select name="group[]" id="group"  multiple required oninvalid="InvalidMsg(this,'Please Select Group','');" oninput="InvalidMsg(this);">
                                            <option value="" disabled>Select Group</option>
                                            <?php
                                                if(!empty($user->u_group)){
                                                    $ug = explode(',', $user->u_group);
                                                } 
                                                foreach ($group as $key => $value) {                        	
                                                    echo "<option value='$value->g_id' ".(in_array($value->g_id, $ug)?' selected':'').">$value->g_name</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 l4 xl3">
                                        <select name="site[]" id="site" multiple required oninvalid="InvalidMsg(this,'Please Select Site','');" oninput="InvalidMsg(this);">
                                            <option value="" disabled>Select Site</option>
                                            <?php 
                                                if(!empty($user->site)){
                                                    $usite = explode(',', $user->site);
                                                }
                                                foreach ($site as $key => $value) {
                                                   echo "<option value='$value->s_id' ".(in_array($value->s_id, $usite)?' selected':'').">$value->s_name</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 l4 xl3">
                                        <select name="role" id="role" required>
                                            <option value="1" <?php echo (!empty($user->is_admin) && $user->is_admin==1 ?' selected':'');?>>Admin</option>
                                            <option value="2" <?php echo (!empty($user->is_admin) && $user->is_admin==2 ?' selected':'');?>>Auditor</option>
                                            <option value="3" <?php echo (!empty($user->is_admin) && $user->is_admin==3 ?' selected':'');?>is_admin>Reviewer</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn cyan waves-effect waves-light right save_user">Save<i class="material-icons right">send</i></button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    	<?php $this->load->view('common/footer_view') ?>
    </div>
    <?php $this->load->view('common/footer_file_view') ?>
</body>
</html>

<script type="text/javascript">
    function InvalidMsg(textbox,nullMsg,errorMsg) {
    	if (textbox.value == '') {
        	textbox.setCustomValidity(nullMsg);
    	}
    	else if(textbox.validity.typeMismatch){
        	textbox.setCustomValidity(errorMsg);
    	}
    	else {
        	textbox.setCustomValidity('');
    	}
    	return true;
	}
</script>