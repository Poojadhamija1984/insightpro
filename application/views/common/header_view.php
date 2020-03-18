<?php //echo $heading; ?>
<header class="page-topbar" id="header">
    <div class="navbar navbar-fixed"> 
        <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-purple-deep-orange gradient-shadow">
            <div class="nav-wrapper">
                <ul class="navbar-list right">     
                    <li>
                        <a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown">
                            <span class="avatar-text"><?=get_user_type($this->session->userdata('usertype'), $this->session->userdata('emp_group'));?></span>
                            <span class="avatar-status avatar-online"><img src="<?php echo isset($this->session->userdata['profile_img'])?base_url().$this->session->userdata['profile_img']:base_url().'assets/images/user_pic.png';?>" alt="avatar"><!--<i></i>--></span>
                        </a>
                    </li>
                       
                </ul>
                <!-- profile-dropdown-->
                <ul class="dropdown-content" id="profile-dropdown">
                    <?php if(profile_mokeup()){?>
                        <li><a class="grey-text text-darken-1" href="<?php echo site_url().'/user-profile'; ?>"><i class="material-icons">person_outline</i> Profile</a></li>
                    <?php } ?>
                    <li><a class="grey-text text-darken-1" href="<?php echo site_url().'/logout'; ?>"><i class="material-icons">keyboard_tab</i> Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>