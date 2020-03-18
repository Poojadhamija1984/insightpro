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
                                <h3 class="page-title">Dashboard</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Form Name</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR -->
                    <div class="error_section mb-12">
                    <?php
                        if($this->session->flashdata('message')){
                            echo $this->session->flashdata('message'); 
                        }
                    ?>
                    </div>
                    <!-- PAGE ERROR END -->

                    <!-- FORM SECTION START -->
                    <div class="form-section template_container mt-24">
                        <form class="">
                            <h4 class="template-title">Template Heading <span><input class="get_marks" type="text" value="50" readonly><sub>/</sub><input class="total_marks" type="text" value="100" readonly></span></h4>
                            <div class="Qsection">
                                <div class="Qsection_header d-flex align-items-center justify-content-between">
                                    <h4>General Information</h4>
                                </div>
                                <div class="Qsection_content">
                                    <div class="Question_single general_Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h5>
                                        <div class="Question_ans">
                                            <select>
                                                <option value="value 1">value 1</option>
                                                <option value="value 2">value 2</option>
                                                <option value="value 3">value 3</option>
                                                <option value="value 4">value 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="Question_single general_Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h5>
                                        <div class="Question_ans">
                                            <select multiple>
                                                <option value="value 1">value 1</option>
                                                <option value="value 2">value 2</option>
                                                <option value="value 3">value 3</option>
                                                <option value="value 4">value 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="Question_single general_Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h5>
                                        <div class="Question_ans">
                                            <input type="text" name="" class="Qans_field" placeholder="Your Answer">
                                        </div>
                                    </div>
                                    <div class="Question_single general_Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h5>
                                        <div class="Question_ans">
                                            <textarea name="" class="Qans_field materialize-textarea" placeholder="Write here"></textarea>
                                        </div>
                                    </div>
                                    <div class="Question_single general_Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h5>
                                        <div class="Question_ans">
                                            <span class="datepicker_span">
                                                <span class="material-icons">date_range</span>
                                                <input type="text" name="" class="Qans_field datepicker" placeholder="YYYY/MM/DD">
                                            </span>
                                            <span class="datepicker_span">
                                                <span class="material-icons">access_time</span>
                                                <input type="text" name="" class="Qans_field timepicker" placeholder="12:00 PM">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="Question_single checkbox_cont">
                                        <label class="ans_custom_checkbox">
                                            <input type="checkbox" class="filled-in" />
                                            <span></span>
                                        </label>
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="Qsection">
                                <div class="Qsection_header d-flex align-items-center justify-content-between">
                                    <h4>Section Heading One</h4>
                                    <div class="section_score">
                                        <input class="get_marks" type="text" value="50" readonly>
                                        <span class="score_seprate">/</span>
                                        <input class="total_marks" type="text" value="100" readonly>
                                    </div>
                                </div>
                                <div class="Qsection_content">
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.<sub>(can choose more than One option)</sub> <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <div class="Question_ans_selects">
                                                <label class="ans_custom_label">
                                                    <input data-score="1" type="checkbox" class="ans_custom_check" checked/>
                                                    <span data-bgcolor="green">Answer 1</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="2" type="checkbox" class="ans_custom_check" />
                                                    <span data-bgcolor="red">Answer 2</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="3" type="checkbox" class="ans_custom_check" />
                                                    <span data-bgcolor="blue">Answer 3</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="4" type="checkbox" class="ans_custom_check" />
                                                    <span data-bgcolor="orange">Answer 4</span>
                                                </label>
                                            </div>
                                        </div>
                                            <div class="Question_ans_btm">
                                                <div class="Question_ans_attachments d-flex justify-content-between">
                                                    <div class="attachment_notes">
                                                        <a href="javascript:void(0)" class="attachment_notes_link">
                                                            <i class="material-icons">menu</i>
                                                            <span>Add Notes</span>
                                                        </a>
                                                        <div class="attachment_textbox">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                                <div class="attachment_textbox_controls">
                                                                    <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                    <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="attachment_images">
                                                        <div class="attachment_images_link">
                                                            <input class="attachment_file" type="file" accept=".jpg, .png, .jpeg" multiple>
                                                            <span>
                                                                <i class="material-icons">camera_alt</i>
                                                                <span>Photos</span>
                                                            </span>
                                                        </div>
                                                        <div class="photo_frame_cont">
                                                            <div class="photo_frame">
                                                                <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                                <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      
                                    </div>

                                       <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <input type="text" name="" class="Qans_field" placeholder="Your Answer">
                                        </div>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


 
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <div class="Question_ans_selects">
                                                <label class="ans_custom_label">
                                                    <input data-score="1" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="green">Answer 1</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="2" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="red">Answer 2</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="3" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="blue">Answer 3</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="4" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="orange">Answer 4</span>
                                                </label>
                                            </div>
                                            <div class="Question_ans_btm">
                                                <div class="Question_ans_attachments d-flex justify-content-between">
                                                    <div class="attachment_notes">
                                                        <a href="javascript:void(0)" class="attachment_notes_link">
                                                            <i class="material-icons">menu</i>
                                                            <span>Add Notes</span>
                                                        </a>
                                                        <div class="attachment_textbox">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                                <div class="attachment_textbox_controls">
                                                                    <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                    <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="attachment_images">
                                                        <div class="attachment_images_link">
                                                            <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                            <span>
                                                                <i class="material-icons">camera_alt</i>
                                                                <span>Photos</span>
                                                            </span>
                                                        </div>
                                                        <div class="photo_frame_cont">
                                                            <div class="photo_frame">
                                                                <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                                <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                 
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <textarea name="" class="Qans_field materialize-textarea" placeholder="Write here"></textarea>
                                        </div>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <span class="datepicker_span">
                                                <span class="material-icons">date_range</span>
                                                <input type="text" name="" class="Qans_field datepicker" placeholder="YYYY/MM/DD">
                                            </span>
                                            <span class="datepicker_span">
                                                <span class="material-icons">access_time</span>
                                                <input type="text" name="" class="Qans_field timepicker" placeholder="12:00 PM">
                                            </span>
                                        </div>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Question_single checkbox_cont">
                                        <label class="ans_custom_checkbox">
                                            <input type="checkbox" class="filled-in" />
                                            <span></span>
                                        </label>
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Qsection">
                                <div class="Qsection_header d-flex align-items-center justify-content-between">
                                    <h4>Section Heading Two</h4>
                                    <div class="section_score">
                                        <input class="get_marks" type="text" value="50" readonly>
                                        <span class="score_seprate">/</span>
                                        <input class="total_marks" type="text" value="100" readonly>
                                    </div>
                                </div>
                                <div class="Qsection_content">
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.<sub>(can choose more than One option)</sub> <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <div class="Question_ans_selects">
                                                <label class="ans_custom_label">
                                                    <input data-score="1" type="checkbox" class="ans_custom_check" />
                                                    <span data-bgcolor="green">Answer 1</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="2" type="checkbox" class="ans_custom_check" />
                                                    <span data-bgcolor="red">Answer 2</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="3" type="checkbox" class="ans_custom_check" />
                                                    <span data-bgcolor="blue">Answer 3</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="4" type="checkbox" class="ans_custom_check" />
                                                    <span data-bgcolor="orange">Answer 4</span>
                                                </label>
                                            </div>
                                            <div class="Question_ans_btm">
                                                <div class="Question_ans_attachments d-flex justify-content-between">
                                                    <div class="attachment_notes">
                                                        <a href="javascript:void(0)" class="attachment_notes_link">
                                                            <i class="material-icons">menu</i>
                                                            <span>Add Notes</span>
                                                        </a>
                                                        <div class="attachment_textbox">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                                <div class="attachment_textbox_controls">
                                                                    <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                    <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="attachment_images">
                                                        <div class="attachment_images_link">
                                                            <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                            <span>
                                                                <i class="material-icons">camera_alt</i>
                                                                <span>Photos</span>
                                                            </span>
                                                        </div>
                                                        <div class="photo_frame_cont">
                                                            <div class="photo_frame">
                                                                <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                                <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <div class="Question_ans_selects">
                                                <label class="ans_custom_label">
                                                    <input data-score="1" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="green">Answer 1</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="2" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="red">Answer 2</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="3" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="blue">Answer 3</span>
                                                </label>
                                                <label class="ans_custom_label">
                                                    <input data-score="4" class="ans_custom_radio" name="group1" type="radio" />
                                                    <span data-bgcolor="orange">Answer 4</span>
                                                </label>
                                            </div>
                                            <div class="Question_ans_btm">
                                                <div class="Question_ans_attachments d-flex justify-content-between">
                                                    <div class="attachment_notes">
                                                        <a href="javascript:void(0)" class="attachment_notes_link">
                                                            <i class="material-icons">menu</i>
                                                            <span>Add Notes</span>
                                                        </a>
                                                        <div class="attachment_textbox">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                                <div class="attachment_textbox_controls">
                                                                    <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                    <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="attachment_images">
                                                        <div class="attachment_images_link">
                                                            <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                            <span>
                                                                <i class="material-icons">camera_alt</i>
                                                                <span>Photos</span>
                                                            </span>
                                                        </div>
                                                        <div class="photo_frame_cont">
                                                            <div class="photo_frame">
                                                                <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                                <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <input type="text" name="" class="Qans_field" placeholder="Your Answer">
                                        </div>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <textarea name="" class="Qans_field materialize-textarea" placeholder="Write here"></textarea>
                                        </div>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Question_single">
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans">
                                            <span class="datepicker_span">
                                                <span class="material-icons">date_range</span>
                                                <input type="text" name="" class="Qans_field datepicker" placeholder="YYYY/MM/DD">
                                            </span>
                                            <span class="datepicker_span">
                                                <span class="material-icons">access_time</span>
                                                <input type="text" name="" class="Qans_field timepicker" placeholder="12:00 PM">
                                            </span>
                                        </div>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Question_single checkbox_cont">
                                        <label class="ans_custom_checkbox">
                                            <input type="checkbox" class="filled-in" />
                                            <span></span>
                                        </label>
                                        <h5 class="Question_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. <a href="javascript:void(0)" class="Question_link material-icons">attach_file</a></h5>
                                        <div class="Question_ans_btm">
                                            <div class="Question_ans_attachments d-flex justify-content-between">
                                                <div class="attachment_notes">
                                                    <a href="javascript:void(0)" class="attachment_notes_link">
                                                        <i class="material-icons">menu</i>
                                                        <span>Add Notes</span>
                                                    </a>
                                                    <div class="attachment_textbox">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <textarea name="notes_text" placeholder="Write note here"></textarea>
                                                            <div class="attachment_textbox_controls">
                                                                <!-- <a href="javascript:void(0)" class="attachment_textbox_edit material-icons">edit</a>  -->
                                                                <a href="javascript:void(0)" class="attachment_textbox_del material-icons">close</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attachment_images">
                                                    <div class="attachment_images_link">
                                                        <input type="file" accept=".jpg, .png, .jpeg" multiple>
                                                        <span>
                                                            <i class="material-icons">camera_alt</i>
                                                            <span>Photos</span>
                                                        </span>
                                                    </div>
                                                    <div class="photo_frame_cont">
                                                        <div class="photo_frame">
                                                            <img src="http://sanjukumar.localhost/InsightsPro_v1/assets/upload/sanjukumar/_1565069280_z4.jpg" alt="avatar">
                                                            <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right-align mt-24">
                                <button type="submit" class="btn cyan waves-effect waves-light">
                                    <span>Submit</span>
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- FORM SECTION END -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        <script>
            $(document).ready(function(){
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
                    var frame_cont = $(this).closest(".attachment_images").find('.photo_frame').length;
                    var len = $(this).get(0).files.length;
                    if(len != 0) {
                        $(this).closest(".attachment_images_link").css("display", "none");
                        $(this).closest(".attachment_images").find('.photo_frame_cont').css("display", "block");
                        for(var i=0;i<len;i++) {
                            $(this).closest(".attachment_images").find('.photo_frame_cont').append(`<div class="photo_frame">
                                <img src="` +URL.createObjectURL(event.target.files[i])+ `" alt="avatar">
                                <a href="javascript:void(0)" class="attachment_img_del flaticon-delete-button"></a>
                            </div>`);
                        }
                        //$(this).closest(".attachment_images").find('.photo_frame_cont').append('<a href="javascript:void(0)" class="files_upload_btn">Upload</a>');
                        $(this).val(null);

                    } else {
                        if(frame_cont != 0) {
                            $(this).closest(".attachment_images").find('.photo_frame_cont').css("display", "block");
                            $(this).closest(".attachment_images_link").css("display", "none");
                        } else {
                            $(this).closest(".attachment_images_link").css("display", "block");
                            $(this).closest(".attachment_images").find('.photo_frame_cont').css("display", "none");
                        }
                        console.log("hello repeate2")
                        
                    }
                });
            })
        </script>
    </body>
</html>
