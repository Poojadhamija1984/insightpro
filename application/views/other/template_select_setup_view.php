<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body class="setup_body">
        <div class="page-wrapper">
            <!-- HEADER SECTION START-->
            <?php $this->load->view('common/header_view') ?>
            <!-- HEADER SECTION END-->
            <!-- SIDEBAR SECTION START -->
            <?php //$this->load->view('common/sidebar_view') ?>
			<input type="hidden" id="csrf_token" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>">
            <!-- SIDEBAR SECTION END -->
            <!-- MAIN SECTION START -->
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                     <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
								<!-- <h3 class="page-title"><a href="<?= site_url();?>/welcome-setup-skip">Skip</a></h3> -->
                                <h3 class="page-title">Template</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Template Selected</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"><a class="skip_btn" href="<?= site_url();?>/welcome-setup-skip">Skip</a></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                     <!-- PAGE ERROR START -->
                    <div class="log_msg error_section hide">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center">
                                <span id='log_msg'></span>
                            </div>
                        </div>
                    </div>
                    <div class="rrr">
                        
                    </div>
                    <!-- PAGE ERROR END -->

                    <!-- USER PROFILE SECTION START -->
                    <div class="form_accordion mt-24">
						<?php if(!empty($template_data)){?>
                        <form class="form_creation">
							<!-- <div class="form_intro tmp_response">
							</div> -->
							
							<div class="form_intro">
								<label>Template Name</label>
								<input type="hidden" id="tmp_unique_id" value="<?php echo (!empty($tmp_unique_id)?$tmp_unique_id:'');?>">
								<input type="text" name="tmp_name" id="tmp_name" value="<?php echo (!empty($tmp_name)?$tmp_name:'');?>" placeholder="Enter Template Name" required>
								<span class="field_error tmp_name"><?php echo (!empty(form_error('tmp_name')) ?  form_error('tmp_name'):'' );?></span>
							</div>
							
                            <ul class="collapsible form_accordion_list">
								<?php  $flag_count = 0; foreach($template_data as $each_cat_key => $each_cat){$flag_count++;
									//echo "<pre>";
									//print_r($tmp_name);
									//print_r($each_cat_key);
									if($each_cat_key == 'cat1' && (!empty($each_cat))){ 
										// echo "<pre>";
										// print_r($each_cat);
										// echo "</pre>";
										?>
										<li class="form_accordion_item general active">
											<div class="collapsible-header">
												<h3 class="form_title">General information</h3>
											</div>
											<div class="collapsible-body">
												<div class="form_questions_cont">
													<?php foreach($each_cat as $each_question){
														// echo "<pre>";
														// print_r($each_question['t_option_score']);
														// echo "</pre>";?>
														<div class="form_question">
															<div class="col">
																<div class="row mb-0">
																	<div class="col s6 m7 form_question__title">
																		<input type="text" class="question_text" name="" value="<?=$each_question['t_att_name'];?>" placeholder="Question..." data-question-required="<?=$each_question['t_is_required'];?>" required>
																	</div>
																	<div class="col s6 m5 form_question_options">
																		<div class="form_question_ans" data-ans-type="" data-ans-multi-select="<?=$each_question['t_is_multiselect'];?>"></div>
																		<div class="form_ans_options_cont">
																			<div class="col s6 multiselect_opts">
																				<h5>Multiple choice responses</h5>
																				<ul>
																					<?php 
																					if($each_question['t_option_type'] == 'select')
																					{

																						$html_select_opt = '<li class="selected"> <div class="custom_opt" data-ans-type="select">';
																						$t_option_value = explode('|',$each_question['t_option_value']);
																						
																						foreach($t_option_value as $key => $each_select_option_value)
																						{
																							$html_select_opt .='<span class="custom_opt_val" data-value="'.$each_select_option_value.'" >'.$each_select_option_value.'</span>';
																						}
																								
																						$html_select_opt .= '</div> <a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a> </li>';
																						echo $html_select_opt;
																					}
																					?>
																				</ul>
																				<a href="javascript:void(0)" class="btn_new_response">Response</a>
																			</div>
																			<div class="col s6 singleselect_opts">
																				<h5>Other responses</h5>
																				<ul>
																					<li class="<?php echo ($each_question['t_option_type'] == 'text' || $each_question['t_option_type'] == 'textarea') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="text"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span></div></li>
																					<li class="<?php echo ($each_question['t_option_type'] == 'checkbox') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="checkbox"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Checkbox</span></div></li>
																					<li class="<?php echo ($each_question['t_option_type'] == 'date') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="date"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Date/Time</span></div></li>
																				</ul>
																			</div>
																		</div>
																	</div>
																	<div class="col s12 form_question_description">
																		<textarea class="description_text materialize-textarea" placeholder="Question Description...."><?php echo (!empty($each_question['t_ques_description'])?$each_question['t_ques_description']:'');?></textarea>
																	</div>
																	<div class="col s12 form_question_controls">
																		<div class="left_section">
																			<div class="mandatory_opt">
																				<label>
																					<input name="question_mandatory" type="checkbox" class="filled-in question_mandatory" <?php echo $each_question['t_is_required'] === 'yes'? 'checked':'';?>/>
																					<span>Mandatory</span>
																				</label>
																			</div>
																			<div class="selectbox_opt">
																				<label>
																					<input name="multiselect_opt" type="checkbox" class="filled-in multiselect_opt" <?php echo $each_question['t_is_multiselect'] === 'yes'? 'checked':'';?>/>
																					<span>Multiple Select</span>
																				</label>
																			</div>
																			<div class="description_opt">
																				<label>
																					<input name="des_opt" type="checkbox" class="filled-in des_opt" <?php echo (!empty($each_question['t_ques_description'])?'checked':'');?>/>
																					<span>Question Description</span>
																				</label>
																			</div>
																			<div class="textbox_opt">
																				<label>
																					<input name="textarea_opt" type="checkbox" class="filled-in textarea_opt" <?php echo ($each_question['t_option_type'] == 'textarea')? 'checked':'';?>/>
																					<span>Large Text</span>
																				</label>
																			</div>
																		</div>
																		<div class="right_section">
																			<a href="javascritp:void(0)" class="btn_new__section">Add Section</a>
																			<a href="javascritp:void(0)" class="btn_new__field">Add Question</a>
																			<a href="javascritp:void(0)" class="btn_del__field"></a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													<?php }?>
													
												</div>
											</div>
										</li>
									<?php 
										if(count($template_data) == 1) {
											// ONLY CASE WHEN HAVE ONLY GENREL NO OTHER SEC OR QUESTIONS
											echo '<li class="form_accordion_item additional">
													<div class="collapsible-header">
														<h3 class="form_title">Questions</h3>
													</div>
													<div class="collapsible-body">
														<div class="form_questions_cont form_section_cont">
															<div class="form_section dafault">
																<div class="form_questions_cont">
																	<div class="form_question">
																		<div class="col">
																			<div class="row mb-0">
																				<div class="col s6 m7 form_question__title">
																					<input type="text" class="question_text" name="" placeholder="Question..." data-question-required="no" >
																				</div>
																				<div class="col s6 m5 form_question_options">
																					<div class="form_question_ans" data-ans-type="text" data-ans-multi-select="no"></div>
																					<div class="form_ans_options_cont">
																						<div class="col s6 multiselect_opts">
																							<h5>Multiple choice responses</h5>
																							<ul>
																								<li>
																									<div class="custom_opt" data-ans-type="select">
																										<span class="custom_opt_val" data-value="yes" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">yes</span>
																										<span class="custom_opt_val" data-value="no" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">no</span>
																										<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
																									</div>
																									<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																								</li>
																								<li>
																									<div class="custom_opt" data-ans-type="select">
																										<span class="custom_opt_val" data-value="good" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">good</span>
																										<span class="custom_opt_val" data-value="poor" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">poor</span>
																										<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
																									</div>
																									<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																								</li>
																								<li>
																									<div class="custom_opt" data-ans-type="select">
																										<span class="custom_opt_val" data-value="pass" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">pass</span>
																										<span class="custom_opt_val" data-value="fail" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">fail</span>
																										<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
																									</div>
																									<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																								</li>
																							</ul>
																							<a href="javascript:void(0)" class="btn_new_response">Response</a>
																						</div>
																						<div class="col s6 singleselect_opts">
																							<h5>Other responses</h5>
																							<ul>
																								<li class="selected"><div class="custom_opt" data-ans-type="text"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span></div></li>
																								<li><div class="custom_opt" data-ans-type="checkbox"><span data-value="" data-failed="" data-score="0" data-color="" data-bg-color="">Checkbox</span></div></li>
																								<li><div class="custom_opt" data-ans-type="date"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Date/Time</span></div></li>
																							</ul>
																						</div>
																					</div>
																				</div>
																				<div class="col s12 form_question_description">
																					<textarea class="description_text materialize-textarea" placeholder="Question Description...."></textarea>
																				</div>
																				<div class="col s12 form_question_controls">
																					<div class="left_section">
																						<div class="mandatory_opt">
																							<label>
																								<input name="question_mandatory" type="checkbox" class="filled-in question_mandatory"/>
																								<span>Mandatory</span>
																							</label>
																						</div>
																						<div class="selectbox_opt">
																							<label>
																								<input name="multiselect_opt" type="checkbox" class="filled-in multiselect_opt"/>
																								<span>Multiple Select</span>
																							</label>
																						</div>
																						<div class="description_opt">
																							<label>
																								<input name="des_opt" type="checkbox" class="filled-in des_opt" />
																								<span>Question Description</span>
																							</label>
																						</div>
																						<div class="textbox_opt">
																							<label>
																								<input name="textarea_opt" type="checkbox" class="filled-in textarea_opt" />
																								<span>Large Text</span>
																							</label>
																						</div>
																						<div class="kpi_opt">
																							<select multiple>
																								<option value="">Select KPI</option>
																								<option value="CSAT">CSAT</option>
																								<option value="RESO">RESO</option>
																								<option value="SALE">SALE</option>
																								<option value="RETR">RETR</option>
																							</select>
																							<a href="javascript:void(0)" class="btn_new_kpi_opt">Custom KPI for Dashboard</a>
																						</div>
																						<div class="checkbox_opt">
																							<span>Score</span>
																							<input type="number"/>
																						</div>
																					</div>
																					<div class="right_section">
																						<a href="javascritp:void(0)" class="btn_new__section">Add Section</a>
																						<a href="javascritp:void(0)" class="btn_new__field">Add Question</a>
																						<a href="javascritp:void(0)" class="btn_del__field"></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</li>';
										}
									}
									else { if($flag_count == 2) {?>
											<li class="form_accordion_item additional"> <div class="collapsible-header"> <h3 class="form_title">Questions</h3> </div>
											<div class="collapsible-body"> <div class="form_questions_cont form_section_cont">
											<?php } 
											// ONLY CASE WHEN NO FREE QUESTION IN CAT 2 OR NO blank_sec
											if($each_cat_key == 'cat2' && $each_cat[0]['t_cat_name'] != 'blank_sec')
											{
												
												echo '<div class="form_section dafault">
													<div class="form_questions_cont">
														<div class="form_question">
															<div class="col">
																<div class="row mb-0">
																	<div class="col s6 m7 form_question__title">
																		<input type="text" class="question_text" name="" placeholder="Question..." data-question-required="no" >
																	</div>
																	<div class="col s6 m5 form_question_options">
																		<div class="form_question_ans" data-ans-type="text" data-ans-multi-select="no"></div>
																		<div class="form_ans_options_cont">
																			<div class="col s6 multiselect_opts">
																				<h5>Multiple choice responses</h5>
																				<ul>
																					<li>
																						<div class="custom_opt" data-ans-type="select">
																							<span class="custom_opt_val" data-value="yes" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">yes</span>
																							<span class="custom_opt_val" data-value="no" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">no</span>
																							<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
																						</div>
																						<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																					</li>
																					<li>
																						<div class="custom_opt" data-ans-type="select">
																							<span class="custom_opt_val" data-value="good" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">good</span>
																							<span class="custom_opt_val" data-value="poor" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">poor</span>
																							<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
																						</div>
																						<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																					</li>
																					<li>
																						<div class="custom_opt" data-ans-type="select">
																							<span class="custom_opt_val" data-value="pass" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">pass</span>
																							<span class="custom_opt_val" data-value="fail" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">fail</span>
																							<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
																						</div>
																						<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																					</li>
																				</ul>
																				<a href="javascript:void(0)" class="btn_new_response">Response</a>
																			</div>
																			<div class="col s6 singleselect_opts">
																				<h5>Other responses</h5>
																				<ul>
																					<li class="selected"><div class="custom_opt" data-ans-type="text"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span></div></li>
																					<li><div class="custom_opt" data-ans-type="checkbox"><span data-value="" data-failed="" data-score="0" data-color="" data-bg-color="">Checkbox</span></div></li>
																					<li><div class="custom_opt" data-ans-type="date"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Date/Time</span></div></li>
																				</ul>
																			</div>
																		</div>
																	</div>
																	<div class="col s12 form_question_description">
																		<textarea class="description_text materialize-textarea" placeholder="Question Description...."></textarea>
																	</div>
																	<div class="col s12 form_question_controls">
																		<div class="left_section">
																			<div class="mandatory_opt">
																				<label>
																					<input name="question_mandatory" type="checkbox" class="filled-in question_mandatory"/>
																					<span>Mandatory</span>
																				</label>
																			</div>
																			<div class="selectbox_opt">
																				<label>
																					<input name="multiselect_opt" type="checkbox" class="filled-in multiselect_opt"/>
																					<span>Multiple Select</span>
																				</label>
																			</div>
																			<div class="description_opt">
																				<label>
																					<input name="des_opt" type="checkbox" class="filled-in des_opt" />
																					<span>Question Description</span>
																				</label>
																			</div>
																			<div class="textbox_opt">
																				<label>
																					<input name="textarea_opt" type="checkbox" class="filled-in textarea_opt" />
																					<span>Large Text</span>
																				</label>
																			</div>
																			<div class="kpi_opt">
																				<select multiple>
																					<option value="">Select KPI</option>
																					<option value="CSAT">CSAT</option>
																					<option value="RESO">RESO</option>
																					<option value="SALE">SALE</option>
																					<option value="RETR">RETR</option>
																				</select>
																				<a href="javascript:void(0)" class="btn_new_kpi_opt">Custom KPI for Dashboard</a>
																			</div>
																			<div class="checkbox_opt">
																				<span>Score</span>
																				<input type="number"/>
																			</div>
																		</div>
																		<div class="right_section">
																			<a href="javascritp:void(0)" class="btn_new__section">Add Section</a>
																			<a href="javascritp:void(0)" class="btn_new__field">Add Question</a>
																			<a href="javascritp:void(0)" class="btn_del__field"></a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>';
												// echo "<pre>";
												// //print_r($each_cat[0]['t_cat_name']);
												// print_r($each_cat);
												// echo "</pre>";
											}
											// ONLY CASE WHEN FREE QUESTION IN CAT 2 OR  blank_sec
											if($each_cat_key == 'cat2' && $each_cat[0]['t_cat_name'] == 'blank_sec')
												
												{?>	
												<div class="form_section dafault">
													<div class="form_questions_cont">
														<?php foreach($each_cat as $each_question){ ?>
															<div class="form_question">
																<div class="col">
																	<div class="row mb-0">
																		<div class="col s6 m7 form_question__title">
																			<input type="text" class="question_text" value="<?=$each_question['t_att_name'];?>" name="" placeholder="Question..." data-question-required="<?=$each_question['t_is_required'];?>" >
																		</div>
																		<div class="col s6 m5 form_question_options">
																			<div class="form_question_ans" data-ans-type="" data-ans-multi-select="<?=$each_question['t_is_multiselect'];?>"></div>
																			<div class="form_ans_options_cont">
																				<div class="col s6 multiselect_opts">
																					<h5>Multiple choice responses</h5>
																					<ul>
																					<?php 
																					if($each_question['t_option_type'] == 'select') 
																					{ 
																						$t_option_value = explode('|',$each_question['t_option_value']);
																						$t_option_score = explode('|',$each_question['t_option_score']);
																						$t_option_failed = explode('|',$each_question['t_option_failed']);
																						$t_option_color = explode('|',$each_question['t_option_color']);
																						$t_option_bgcolor = explode('|',$each_question['t_option_bgcolor']);
																						//echo $t_option_color[0];
																						$t_option_value_array = ['yes|no|na','good|poor|na','pass|fail|na'];
																						foreach($t_option_value_array as $each_t_option_value_array)
																						{
																							if($each_question['t_option_value'] == $each_t_option_value_array)
																							{ ?>
																								<li class="selected">
																									<div class="custom_opt" data-ans-type="select">
																										<span class="custom_opt_val" data-value="<?php echo $t_option_value[0];?>" data-failed="<?php echo $t_option_failed[0] ;?>" data-score="<?php echo $t_option_score[0] ;?>"  data-color="<?php echo $t_option_color[0];?>" data-bg-color="<?php echo $t_option_bgcolor[0];?>" style="color: <?php echo $t_option_color[0];?>;background-color: <?php echo $t_option_bgcolor[0];?>;"><?php echo $t_option_value[0];?></span>
																										<span class="custom_opt_val" data-value="<?php echo $t_option_value[1];?>"  data-failed="<?php echo $t_option_failed[1] ;?>" data-score="<?php echo $t_option_score[1] ;?>"  data-color="<?php echo $t_option_color[1];?>" data-bg-color="<?php echo $t_option_bgcolor[1];?>" style="color: <?php echo $t_option_color[1];?>;background-color: <?php echo $t_option_bgcolor[1];?>;"><?php echo $t_option_value[1];?></span>
																										<span class="custom_opt_val" data-value="<?php echo $t_option_value[2];?>"  data-failed="<?php echo $t_option_failed[2] ;?>" data-score="<?php echo $t_option_score[2] ;?>"  data-color="<?php echo $t_option_color[2];?>" data-bg-color="<?php echo $t_option_bgcolor[2];?>" style="color: <?php echo $t_option_color[2];?>;background-color: <?php echo $t_option_bgcolor[2];?>;"><?php echo $t_option_value[2];?></span>
																									</div>
																									<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																								</li>
																							<?php }
																							else { $default_option_value = explode('|',$each_t_option_value_array); ?>
																								<li>
																									<div class="custom_opt" data-ans-type="select">
																										<span class="custom_opt_val" data-value="<?php echo $default_option_value[0]?>" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);"><?php echo $default_option_value[0]?></span>
																										<span class="custom_opt_val" data-value="<?php echo $default_option_value[1]?>" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);"><?php echo $default_option_value[1]?></span>
																										<span class="custom_opt_val" data-value="<?php echo $default_option_value[2]?>" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);"><?php echo $default_option_value[2]?></span>
																									</div>
																									<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																								</li>
																							<?php }
																						}

																						if($each_question['t_option_value'] != 'yes|no|na' && $each_question['t_option_value'] != 'good|poor|na' && $each_question['t_option_value'] != 'pass|fail|na' )
																						{
																							$html_select_opt = '<li class="selected"> <div class="custom_opt" data-ans-type="select">';
																							foreach($t_option_value as $key => $each_select_option_value)
																							{
																								$html_select_opt .='<span class="custom_opt_val" data-value="'.$each_select_option_value.'"  data-failed="'. $t_option_failed[$key] .'" data-score="'. $t_option_score[$key].'" data-color="'.(!empty($t_option_color[$key]) ? $t_option_color[$key] : '#81b532').'" data-bg-color="'.(!empty($t_option_bgcolor[$key]) ? $t_option_bgcolor[$key] : 'rgba(129, 181, 50, 0.1)').'" style="color: '.(!empty($t_option_color[$key]) ? $t_option_color[$key] : '#81b532').';background-color:'.(!empty($t_option_bgcolor[$key]) ? $t_option_bgcolor[$key] : 'rgba(129, 181, 50, 0.1)').';">'.$each_select_option_value.'</span>';
																							}		
																							$html_select_opt .= '</div> <a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a> </li>';
																							echo $html_select_opt;
																						}
																					} ?>
																					</ul>
																					<a href="javascript:void(0)" class="btn_new_response">Response</a>
																				</div>
																				<div class="col s6 singleselect_opts">
																					<h5>Other responses</h5>
																					<ul>
																						<li class="<?php echo ($each_question['t_option_type'] == 'text' || $each_question['t_option_type'] == 'textarea') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="text"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span></div></li>
																						<li class="<?php echo ($each_question['t_option_type'] == 'checkbox') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="checkbox"><span data-value="" data-failed="" data-score="<?php echo ($each_question['t_option_type'] == 'checkbox') ? $each_question['t_option_score']:0; ?>" data-color="" data-bg-color="">Checkbox</span></div></li>
																						<li class="<?php echo ($each_question['t_option_type'] == 'date') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="date"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Date/Time</span></div></li>
																					</ul>
																				</div>
																			</div>
																		</div>
																		<div class="col s12 form_question_description">
																			<textarea class="description_text materialize-textarea" placeholder="Question Description...."><?php echo (!empty($each_question['t_ques_description'])?$each_question['t_ques_description']:'');?></textarea>
																		</div>
																		<div class="col s12 form_question_controls">
																			<div class="left_section">
																				<div class="mandatory_opt">
																					<label>
																						<input name="question_mandatory" type="checkbox" class="filled-in question_mandatory" <?php echo $each_question['t_is_required'] === 'yes'? 'checked':'';?>/>
																						<span>Mandatory</span>
																					</label>
																				</div>
																				<div class="selectbox_opt">
																					<label>
																						<input name="multiselect_opt" type="checkbox" class="filled-in multiselect_opt" <?php echo $each_question['t_is_multiselect'] === 'yes'? 'checked':'';?>/>
																						<span>Multiple Select</span>
																					</label>
																				</div>
																				<div class="description_opt">
																					<label>
																						<input name="des_opt" type="checkbox" class="filled-in des_opt" <?php echo (!empty($each_question['t_ques_description'])?'checked':'');?>/>
																						<span>Question Description</span>
																					</label>
																				</div>
																				<div class="textbox_opt">
																					<label>
																						<input name="textarea_opt" type="checkbox" class="filled-in textarea_opt" <?php echo ($each_question['t_option_type'] == 'textarea')? 'checked':'';?> />
																						<span>Large Text</span>
																					</label>
																				</div>
																				<div class="kpi_opt">
																					<select multiple>
																						<option value="">Select KPI</option>
																						<?php 
																						if(!empty($each_question['t_kpi']))
																						{
																							$default_kpi = ['CSAT','RESO','SALE','RETR'];
																							$t_kpi = explode('|',$each_question['t_kpi']);
																							foreach($default_kpi as $each_default_kpi){
																								if (in_array($each_default_kpi, $t_kpi)){
																									echo '<option value="'.$each_default_kpi.'" selected>'.$each_default_kpi.'</option>';
																								}
																								else{
																									echo '<option value="'.$each_default_kpi.'" >'.$each_default_kpi.'</option>';
																								}
																							}
																							foreach($t_kpi as $each_t_kpi){
																								if($each_t_kpi != 'CSAT' && $each_t_kpi != 'RESO' && $each_t_kpi != 'SALE' && $each_t_kpi != 'RETR')
																								{
																									echo '<option value="'.$each_t_kpi.'" selected>'.$each_t_kpi.'</option>';
																								}
																							}

																						}
																						else {
																							echo '<option value="CSAT">CSAT</option>
																							<option value="RESO">RESO</option>
																							<option value="SALE">SALE</option>
																							<option value="RETR">RETR</option>';
																						}
																						?>
																					</select>
																					<a href="javascript:void(0)" class="btn_new_kpi_opt">Custom KPI for Dashboard</a>
																				</div>
																				<div class="checkbox_opt">
																					<span>Score</span>
																					<input type="number" value="<?php echo ($each_question['t_option_type'] == 'checkbox') ? $each_question['t_option_score']:0; ?>"/>
																				</div>
																			</div>
																			<div class="right_section">
																				<a href="javascritp:void(0)" class="btn_new__section">Add Section</a>
																				<a href="javascritp:void(0)" class="btn_new__field">Add Question</a>
																				<a href="javascritp:void(0)" class="btn_del__field"></a>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>
													</div>
												</div>
											<?php } 
											if($each_cat[0]['t_cat_name'] != 'blank_sec')
											// FOR EACH SECTION RATHER THEN BLANK RRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
												{?>
												<div class="form_section">
													<div class="form_section_header d-flex align-items-center justify-content-between">
														<div class="form_section__title">
															<input type="text" class="section_title" value="<?=$each_cat[0]['t_cat_name'];?>" name="" placeholder="Section Title" required/>
														</div>
														<div class="form_section_controls">
															<a href="javascritp:void(0)" class="btn_del__section"></a>
														</div>
													</div>
													<div class="form_questions_cont">
														<?php foreach($each_cat as $each_question){ ?>
															<div class="form_question">
																<div class="col">
																	<div class="row mb-0">
																		<div class="col s6 m7 form_question__title">
																			<input type="text" class="question_text" value="<?=$each_question['t_att_name'];?>" name="" placeholder="Question..." data-question-required="<?=$each_question['t_is_required'];?>" >
																		</div>
																		<div class="col s6 m5 form_question_options">
																			<div class="form_question_ans" data-ans-type="" data-ans-multi-select="<?=$each_question['t_is_multiselect'];?>"></div>
																			<div class="form_ans_options_cont">
																				<div class="col s6 multiselect_opts">
																					<h5>Multiple choice responses</h5>
																					<ul>
																					<?php 
																					if($each_question['t_option_type'] == 'select') 
																					{ 
																						$t_option_value = explode('|',$each_question['t_option_value']);
																						$t_option_score = explode('|',$each_question['t_option_score']);
																						$t_option_failed = explode('|',$each_question['t_option_failed']);
																						$t_option_color = explode('|',$each_question['t_option_color']);
																						$t_option_bgcolor = explode('|',$each_question['t_option_bgcolor']);
																						//echo $t_option_color[0];
																						$t_option_value_array = ['yes|no|na','good|poor|na','pass|fail|na'];
																						foreach($t_option_value_array as $each_t_option_value_array)
																						{
																							if($each_question['t_option_value'] == $each_t_option_value_array)
																							{ ?>
																								<li class="selected">
																									<div class="custom_opt" data-ans-type="select">
																										<span class="custom_opt_val" data-value="<?php echo $t_option_value[0];?>" data-failed="<?php echo $t_option_failed[0] ;?>" data-score="<?php echo $t_option_score[0] ;?>"  data-color="<?php echo $t_option_color[0];?>" data-bg-color="<?php echo $t_option_bgcolor[0];?>" style="color: <?php echo $t_option_color[0];?>;background-color: <?php echo $t_option_bgcolor[0];?>;"><?php echo $t_option_value[0];?></span>
																										<span class="custom_opt_val" data-value="<?php echo $t_option_value[1];?>"  data-failed="<?php echo $t_option_failed[1] ;?>" data-score="<?php echo $t_option_score[1] ;?>"  data-color="<?php echo $t_option_color[1];?>" data-bg-color="<?php echo $t_option_bgcolor[1];?>" style="color: <?php echo $t_option_color[1];?>;background-color: <?php echo $t_option_bgcolor[1];?>;"><?php echo $t_option_value[1];?></span>
																										<span class="custom_opt_val" data-value="<?php echo $t_option_value[2];?>"  data-failed="<?php echo $t_option_failed[2] ;?>" data-score="<?php echo $t_option_score[2] ;?>"  data-color="<?php echo $t_option_color[2];?>" data-bg-color="<?php echo $t_option_bgcolor[2];?>" style="color: <?php echo $t_option_color[2];?>;background-color: <?php echo $t_option_bgcolor[2];?>;"><?php echo $t_option_value[2];?></span>
																									</div>
																									<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																								</li>
																							<?php }
																							else { $default_option_value = explode('|',$each_t_option_value_array); ?>
																								<li>
																									<div class="custom_opt" data-ans-type="select">
																										<span class="custom_opt_val" data-value="<?php echo $default_option_value[0]?>" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);"><?php echo $default_option_value[0]?></span>
																										<span class="custom_opt_val" data-value="<?php echo $default_option_value[1]?>" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);"><?php echo $default_option_value[1]?></span>
																										<span class="custom_opt_val" data-value="<?php echo $default_option_value[2]?>" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);"><?php echo $default_option_value[2]?></span>
																									</div>
																									<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
																								</li>
																							<?php }
																						}

																						if($each_question['t_option_value'] != 'yes|no|na' && $each_question['t_option_value'] != 'good|poor|na' && $each_question['t_option_value'] != 'pass|fail|na' )
																						{
																							$html_select_opt = '<li class="selected"> <div class="custom_opt" data-ans-type="select">';
																							foreach($t_option_value as $key => $each_select_option_value)
																							{
																								$html_select_opt .='<span class="custom_opt_val" data-value="'.$each_select_option_value.'"  data-failed="'. $t_option_failed[$key] .'" data-score="'. $t_option_score[$key].'" data-color="'.(!empty($t_option_color[$key]) ? $t_option_color[$key] : '#81b532').'" data-bg-color="'.(!empty($t_option_bgcolor[$key]) ? $t_option_bgcolor[$key] : 'rgba(129, 181, 50, 0.1)').'" style="color: '.(!empty($t_option_color[$key]) ? $t_option_color[$key] : '#81b532').';background-color:'.(!empty($t_option_bgcolor[$key]) ? $t_option_bgcolor[$key] : 'rgba(129, 181, 50, 0.1)').';">'.$each_select_option_value.'</span>';
																							}		
																							$html_select_opt .= '</div> <a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a> </li>';
																							echo $html_select_opt;
																						}
																					} ?>
																					</ul>
																					<a href="javascript:void(0)" class="btn_new_response">Response</a>
																				</div>
																				<div class="col s6 singleselect_opts">
																					<h5>Other responses</h5>
																					<ul>
																						<li class="<?php echo ($each_question['t_option_type'] == 'text' || $each_question['t_option_type'] == 'textarea') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="text"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span></div></li>
																						<li class="<?php echo ($each_question['t_option_type'] == 'checkbox') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="checkbox"><span data-value="" data-failed="" data-score="<?php echo ($each_question['t_option_type'] == 'checkbox') ? $each_question['t_option_score']:0; ?>" data-color="" data-bg-color="">Checkbox</span></div></li>
																						<li class="<?php echo ($each_question['t_option_type'] == 'date') ? 'selected':''; ?>"><div class="custom_opt" data-ans-type="date"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Date/Time</span></div></li>
																					</ul>
																				</div>
																			</div>
																		</div>
																		<div class="col s12 form_question_description">
																			<textarea class="description_text materialize-textarea" placeholder="Question Description...."><?php echo (!empty($each_question['t_ques_description'])?$each_question['t_ques_description']:'');?></textarea>
																		</div>
																		<div class="col s12 form_question_controls">
																			<div class="left_section">
																				<div class="mandatory_opt">
																					<label>
																						<input name="question_mandatory" type="checkbox" class="filled-in question_mandatory" <?php echo $each_question['t_is_required'] === 'yes'? 'checked':'';?>/>
																						<span>Mandatory</span>
																					</label>
																				</div>
																				<div class="selectbox_opt">
																					<label>
																						<input name="multiselect_opt" type="checkbox" class="filled-in multiselect_opt" <?php echo $each_question['t_is_multiselect'] === 'yes'? 'checked':'';?>/>
																						<span>Multiple Select</span>
																					</label>
																				</div>
																				<div class="description_opt">
																					<label>
																						<input name="des_opt" type="checkbox" class="filled-in des_opt" <?php echo (!empty($each_question['t_ques_description'])?'checked':'');?> />
																						<span>Question Description</span>
																					</label>
																				</div>
																				<div class="textbox_opt">
																					<label>
																						<input name="textarea_opt" type="checkbox" class="filled-in textarea_opt" <?php echo ($each_question['t_option_type'] == 'textarea')? 'checked':'';?> />
																						<span>Large Text</span>
																					</label>
																				</div>
																				<div class="kpi_opt">
																					<select multiple>
																						<option value="">Select KPI</option>
																						<?php 
																						if(!empty($each_question['t_kpi']))
																						{
																							$default_kpi = ['CSAT','RESO','SALE','RETR'];
																							$t_kpi = explode('|',$each_question['t_kpi']);
																							foreach($default_kpi as $each_default_kpi){
																								if (in_array($each_default_kpi, $t_kpi)){
																									echo '<option value="'.$each_default_kpi.'" selected>'.$each_default_kpi.'</option>';
																								}
																								else{
																									echo '<option value="'.$each_default_kpi.'" >'.$each_default_kpi.'</option>';
																								}
																							}
																							foreach($t_kpi as $each_t_kpi){
																								if($each_t_kpi != 'CSAT' && $each_t_kpi != 'RESO' && $each_t_kpi != 'SALE' && $each_t_kpi != 'RETR')
																								{
																									echo '<option value="'.$each_t_kpi.'" selected>'.$each_t_kpi.'</option>';
																								}
																							}

																						}
																						else {
																							echo '<option value="CSAT">CSAT</option>
																							<option value="RESO">RESO</option>
																							<option value="SALE">SALE</option>
																							<option value="RETR">RETR</option>';
																						}
																						?>
																					</select>
																					<a href="javascript:void(0)" class="btn_new_kpi_opt">Custom KPI for Dashboard</a>
																				</div>
																				<div class="checkbox_opt">
																					<span>Score</span>
																					<input type="number" value="<?php echo ($each_question['t_option_type'] == 'checkbox') ? $each_question['t_option_score']:0; ?>"/>
																				</div>
																			</div>
																			<div class="right_section">
																				<a href="javascritp:void(0)" class="btn_new__section">Add Section</a>
																				<a href="javascritp:void(0)" class="btn_new__field">Add Question</a>
																				<a href="javascritp:void(0)" class="btn_del__field"></a>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>
													</div>
												</div>	
												
											<?php }
											// FOR EACH SECTION RATHER THEN BLANK RRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
											?>

												

											<?php if(count($template_data) == $flag_count) {?>
											</div></div></li>
									<?php } }
									//echo "</pre>";
								}?>
                            </ul>
                            <div id="question_sidenav" class="question_sidenav">
                                <a href="javascript:void(0)" class="question_sidenav_close"></a>
                                <div id="form">
                                    <h3>Multiple Choice Responses</h3>
                                    <div class="drag_items_cont"></div>
                                    <a class="btn_new_res_field" href="javascript:void(0)">Response</a>
                                    <div class="right-align mt-3">
                                        <button type="button" class="btn_response_submit response_submit btn cyan waves-effect waves-light" name="">Save &amp; apply</button>
                                    </div>
                                </div>
                            </div>
                            <div class="right-align mt-24">
                                <button type="button" class="btn_form_final_submit btn cyan waves-effect waves-light">
                                    <span>Save</span>
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </form>
						<?php }
						else{
							echo '<h5>No Data Found</h5>';
						}
						?>
						<?php 
							// echo "<pre>";
							// //print_r($tmp_name);
							// print_r($template_data);
							// echo "</pre>";
						?>
                    </div>
                    <!-- USER PROFILE SECTION END -->
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
			var gen_append = "", other_append = "";
			var new_question = `
				<div class="form_question">
					<div class="col">
						<div class="row mb-0">
							<div class="col s6 m7 form_question__title">
								<input type="text" class="question_text" name="" placeholder="Question..." data-question-required="no" required>
							</div>
							<div class="col s6 m5 form_question_options">
								<div class="form_question_ans" data-ans-type="select" data-ans-multi-select="no">
									<span class="custom_opt_val" data-value="good" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">good</span>
									<span class="custom_opt_val" data-value="poor" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">poor</span>
									<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
								</div>
								<div class="form_ans_options_cont">
									<div class="col s6 multiselect_opts">
										<h5>Multiple choice responses</h5>
										<ul>
											<li>
												<div class="custom_opt" data-ans-type="select">
													<span class="custom_opt_val" data-value="yes" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">yes</span>
													<span class="custom_opt_val" data-value="no" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">no</span>
													<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
												</div>
												<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
											</li>
											<li class="selected">
												<div class="custom_opt" data-ans-type="select">
													<span class="custom_opt_val" data-value="good" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">good</span>
													<span class="custom_opt_val" data-value="poor" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">poor</span>
													<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
												</div>
												<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
											</li>
											<li>
												<div class="custom_opt" data-ans-type="select">
													<span class="custom_opt_val" data-value="pass" data-failed="no" data-score="1" data-color="#81b532" data-bg-color="rgba(129, 181, 50, 0.1)" style="color: #81b532;background-color: rgba(129, 181, 50, 0.1);">pass</span>
													<span class="custom_opt_val" data-value="fail" data-failed="no" data-score="0" data-color="#c60022" data-bg-color="rgba(198, 0, 34, 0.1)" style="color: #c60022;background-color: rgba(198, 0, 34, 0.1);">fail</span>
													<span class="custom_opt_val" data-value="na" data-failed="yes" data-score="0" data-color="#707070" data-bg-color="rgba(112, 112, 112, 0.1)" style="color: #707070;background-color: rgba(112, 112, 112, 0.1);">na</span>
												</div>
												<a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>
											</li>
										</ul>
										<a href="javascript:void(0)" class="btn_new_response">Response</a>
									</div>
									<div class="col s6 singleselect_opts">
										<h5>Other responses</h5>
										<ul>
											<li><div class="custom_opt" data-ans-type="text"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span></div></li>
											<li><div class="custom_opt" data-ans-type="checkbox"><span data-value="" data-failed="" data-score="0" data-color="" data-bg-color="">Checkbox</span></div></li>
											<li><div class="custom_opt" data-ans-type="date"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Date/Time</span></div></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col s12 form_question_description">
								<textarea class="description_text materialize-textarea" placeholder="Question Description...."></textarea>
							</div>
							<div class="col s12 form_question_controls">
								<div class="left_section">
									<div class="mandatory_opt">
										<label>
											<input name="question_mandatory" type="checkbox" class="filled-in question_mandatory"/>
											<span>Mandatory</span>
										</label>
									</div>
									<div class="selectbox_opt visible">
										<label>
											<input name="multiselect_opt" type="checkbox" class="filled-in multiselect_opt"/>
											<span>Multiple Select</span>
										</label>
									</div>
									<div class="description_opt">
										<label>
											<input name="des_opt" type="checkbox" class="filled-in des_opt" />
											<span>Question Description</span>
										</label>
									</div>
									<div class="textbox_opt">
										<label>
											<input name="textarea_opt" type="checkbox" class="filled-in textarea_opt"/>
											<span>Large Text</span>
										</label>
									</div>
									<div class="kpi_opt">
										<select multiple>
											<option value="" >Select KPI</option>
											<option value="CSAT">CSAT</option>
											<option value="RESO">RESO</option>
											<option value="SALE">SALE</option>
											<option value="RETR">RETR</option>
										</select>
										<a href="javascript:void(0)" class="btn_new_kpi_opt">Custom KPI for Dashboard</a>
									</div>
									<div class="checkbox_opt">
										<span>Score</span>
										<input type="number"/>
									</div>
								</div>
								<div class="right_section">
									<a href="javascritp:void(0)" class="btn_new__section">Add Section</a>
									<a href="javascritp:void(0)" class="btn_new__field">Add Question</a>
									<a href="javascritp:void(0)" class="btn_del__field"></a>
								</div>
							</div>
						</div>
					</div>
				</div> `;
			var new_question_general = `
				<div class="form_question">
					<div class="col">
						<div class="row mb-0">
							<div class="col s6 m7 form_question__title">
								<input type="text" class="question_text" name="" placeholder="Question..." data-question-required="no" required>
							</div>
							<div class="col s6 m5 form_question_options">
								<div class="form_question_ans" data-ans-type="text" data-ans-multi-select="no">
								<span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span>
								</div>
								<div class="form_ans_options_cont">
									<div class="col s6 multiselect_opts">
										<h5>Multiple choice responses</h5>
										<ul></ul>
										<a href="javascript:void(0)" class="btn_new_response">Response</a>
									</div>
									<div class="col s6 singleselect_opts">
										<h5>Other responses</h5>
										<ul>
											<li class="selected"><div class="custom_opt" data-ans-type="text"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Text/Num Answer</span></div></li>
											<li><div class="custom_opt" data-ans-type="checkbox"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Checkbox</span></div></li>
											<li><div class="custom_opt" data-ans-type="date"><span data-value="" data-failed="" data-score="" data-color="" data-bg-color="">Date/Time</span></div></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col s12 form_question_description">
								<textarea class="description_text materialize-textarea" placeholder="Question Description...."></textarea>
							</div>
							<div class="col s12 form_question_controls">
								<div class="left_section">
									<div class="mandatory_opt">
										<label>
											<input name="question_mandatory" type="checkbox" class="filled-in question_mandatory"/>
											<span>Mandatory</span>
										</label>
									</div>
									<div class="selectbox_opt">
										<label>
											<input name="multiselect_opt" type="checkbox" class="filled-in multiselect_opt"/>
											<span>Multiple Select</span>
										</label>
									</div>
									<div class="description_opt">
										<label>
											<input name="des_opt" type="checkbox" class="filled-in des_opt" />
											<span>Question Description</span>
										</label>
									</div>
									<div class="textbox_opt visible">
										<label>
											<input name="textarea_opt" type="checkbox" class="filled-in textarea_opt"/>
											<span>Large Text</span>
										</label>
									</div>
								</div>
								<div class="right_section">
									<a href="javascritp:void(0)" class="btn_new__section">Add Section</a>
									<a href="javascritp:void(0)" class="btn_new__field">Add Question</a>
									<a href="javascritp:void(0)" class="btn_del__field"></a>
								</div>
							</div>
						</div>
					</div>
				</div> `;
			var new_section = `
				<div class="form_section">
					<div class="form_section_header d-flex align-items-center justify-content-between">
						<div class="form_section__title">
							<input type="text" class="section_title" name="" placeholder="Section Title" data-question-required="no" required/>
						</div>
						<div class="form_section_controls">
							<a href="javascritp:void(0)" class="btn_del__section"></a>
						</div>
					</div>
					<div class="form_questions_cont">`
					+ new_question +
					`</div>
				</div>
			`;
			var new_response_field = ` 
				<div class="drag_item">
					<input class="response_field bordered_field" type="text" name="" required>
					<a class="btn_del_response" href="javascript:void(0)"></a>
					<div class="response_field_controls">
						<div class="response_color">
							<span>Color :</span>
							<label class="response_color_label" for="response_color">
								<input id="response_color" class="response_color_field" type="color" name="" value="#b0b0b0">
							</label>
						</div>
						<label class="response_mark_label">
							<input name="response_field_mark" type="checkbox" class="filled-in response_field_mark" value="yes">
							<span>Mark as Failed</span>
						</label>
						<div class="response_score">
							<span>Score :</span>
							<input name="" type="number" value="0"  min=0 class="response_score_field bordered_field">
						</div>
					</div>
				</div>
				`;
			var new_response_field_general = ` 
				<div class="drag_item">
					<input class="response_field bordered_field" type="text" name="" required>
					<a class="btn_del_response" href="javascript:void(0)"></a>
				</div>
				`;
			var new_kpi_field = ` 
				<div class="drag_item">
					<input class="response_field bordered_field" type="text" name="" required>
					<a class="btn_del_response" href="javascript:void(0)"></a>
				</div>
				`;
			$(document).ready(function(){
				function convertHex(hex,opacity){
					hex = hex.replace('#','');
					r = parseInt(hex.substring(0,2), 16);
					g = parseInt(hex.substring(2,4), 16);
					b = parseInt(hex.substring(4,6), 16);
					result = 'rgba('+r+','+g+','+b+','+opacity/100+')';
					return result;
				} 
				/* unique id generator start */
				function random_id (){}
				random_id.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();
				random_id.prototype.get_id = function() {
				   return this.rand++;
				};
				var new_id = new random_id();
				/* unique id generator end */
				$(document).click( function(event){
					if (!$(event.target).closest(".form_question_ans").length) {
					$(".form_question_ans").removeClass("active").siblings(".form_ans_options_cont").slideUp(200);
					}
				});
				$(document).on("click", ".form_question_ans", function(){
					$(this).closest('.form_accordion_item').siblings('.form_accordion_item').find(".form_question_ans").removeClass("active").siblings(".form_ans_options_cont").slideUp(200);
					$(this).closest('.form_section').siblings('.form_section').find(".form_question_ans").removeClass("active").siblings(".form_ans_options_cont").slideUp(200);
					$(this).closest('.form_question').siblings('.form_question').find(".form_question_ans").removeClass("active").siblings(".form_ans_options_cont").slideUp(200);
					$(this).toggleClass("active");
					$(this).siblings(".form_ans_options_cont").slideToggle(200);
				})
				/*section add/delete start*/
				$(document).on("click", ".btn_new__section", function(){
					$(this).closest(".form_section_cont").append(new_section).find(".kpi_opt select").formSelect();
					$(this).closest(".form_section_cont").find(".form_section:last-child .multiselect_opts ul").append(other_append);
				})
				$(document).on("click", ".btn_del__section", function(){
					$(this).closest(".form_section").remove();
				})
				/*section add/delete end*/
				/*question add/delete start*/
				$(document).on("click", ".btn_new__field", function(){
					if($(this).closest(".form_accordion_item").hasClass("general")) {
						if(gen_append.length > 0) {
							$(this).closest(".form_questions_cont").append(new_question_general);
							$(this).closest(".form_questions_cont").find(".form_question:last-child .multiselect_opts ul").append(gen_append);
						} else {
							$(this).closest(".form_questions_cont").append(new_question_general);
						}
					} else {
						if(other_append.length > 0) {
							$(this).closest(".form_questions_cont").append(new_question).find(".form_question .kpi_opt select").formSelect();
							$(this).closest(".form_questions_cont").find(".form_question:last-child .multiselect_opts ul").append(other_append);
						} else {
							$(this).closest(".form_questions_cont").append(new_question).find(".form_question .kpi_opt select").formSelect();
						}
					}
				})
				$(document).on("click", ".btn_del__field", function(){
					$(this).closest(".form_question").remove();
				})
				/*question add/delete end*/
				/* question sidebar start */
				if($(".question_sidenav").length) {
					$("body").append('<div class="question_sidenav_overlay"></div>')
				} else {
					$(".question_sidenav_overlay").remove();
				}
				function show_sidenav() {
					$(".question_sidenav").addClass("active").find(".drag_items_cont").empty();
					$("body").css({'overflow':'hidden','padding-right':$(window).outerWidth(true) - $(window).innerWidth()+'px'})
					$(".question_sidenav_overlay").css("display", "block");
				}
				function hide_sidenav() {
					$(".question_sidenav").removeClass("active").find("#form").removeClass().find(".drag_items_cont").empty();
					$(".edit_active").removeClass("edit_active");
					$("body").css({'overflow':'initial','padding-right':'initial'})
					$(".question_sidenav_overlay").css("display", "none");
				}
				function ans_opts_hide_show(selector) {
					if($(selector).attr("data-ans-type")=="select"){
						if($(selector).attr("data-ans-multi-select")=="yes"){
							$(selector).closest(".form_question").find(".multiselect_opt").prop("checked",true);
						} else {
							$(selector).closest(".form_question").find(".multiselect_opt").prop("checked",false);
						}
						$(selector).closest(".form_question").find(".checkbox_opt").removeClass("visible");
						$(selector).closest(".form_question").find(".selectbox_opt").addClass("visible")
						$(selector).closest(".form_question").find(".textbox_opt").removeClass("visible").find(".textarea_opt").prop("checked",false);
					} 
					else if($(selector).attr("data-ans-type")=="text" || $(selector).attr("data-ans-type")=="textarea") {
						/*if($(selector).attr("data-ans-type")=="text") {
							$(selector).closest(".form_question").find(".textarea_opt").prop("checked",false);
						} else {
							$(selector).closest(".form_question").find(".textarea_opt").prop("checked",true);
						}*/
						$(selector).closest(".form_question").find(".checkbox_opt").removeClass("visible");
						$(selector).closest(".form_question").find(".textbox_opt").addClass("visible");
						$(selector).closest(".form_question").find(".selectbox_opt").removeClass("visible").find(".multiselect_opt").prop("checked",false);
					} 
					else if ($(selector).attr("data-ans-type")=="checkbox") {
						$(selector).closest(".form_question").find(".checkbox_opt").addClass("visible");
						$(selector).closest(".form_question").find(".selectbox_opt").removeClass("visible").find(".textarea_opt").prop("checked",false);
						$(selector).closest(".form_question").find(".textbox_opt").removeClass("visible").find(".multiselect_opt").prop("checked",false);
					}
					else {
						$(selector).closest(".form_question").find(".selectbox_opt").removeClass("visible").find(".textarea_opt").prop("checked",false);
						$(selector).closest(".form_question").find(".textbox_opt").removeClass("visible").find(".multiselect_opt").prop("checked",false);
					}
				}
				function multiselect_choose_opt(selector) {
					if($(selector).prop("checked")== true) {
						$(selector).closest(".form_question").find(".form_question_ans").attr("data-ans-multi-select","yes");
					} else {
						$(selector).closest(".form_question").find(".form_question_ans").attr("data-ans-multi-select","no");
					}
				}
				function text_choose_opt(selector) {
					if($(selector).prop("checked")== true) {
						$(selector).closest(".form_question").find(".form_question_ans").attr("data-ans-type","textarea");
					} else {
						$(selector).closest(".form_question").find(".form_question_ans").attr("data-ans-type","text");
					}
				}
				function question_des_opt(selector) {
					if($(selector).prop("checked")== true) {
						$(selector).closest(".form_question_controls").siblings(".form_question_description").slideDown(300);
					} else {
						$(selector).closest(".form_question_controls").siblings(".form_question_description").slideUp(300);
					}
				}
				function question_choose_opt(selector) {
					if($(selector).prop("checked")== true) {
						$(selector).closest(".form_question").find(".question_text").attr("data-question-required","yes");
					} else {
						$(selector).closest(".form_question").find(".question_text").attr("data-question-required","no");
					}
				}
				function selected_value(selector) {
					var temp_value, temp_type
					temp_value = $(selector).html();
					temp_type = $(selector).attr("data-ans-type");
					$(selector).closest(".form_ans_options_cont").slideToggle(150).find("li").removeClass("selected");
					$(selector).closest(".form_question_options").find(".form_question_ans").html(temp_value).attr("data-ans-type",temp_type).attr("data-ans-multi-select","no").removeClass("active");
					ans_opts_hide_show($(selector).closest(".form_question_options").find(".form_question_ans"));
					$(selector).closest("li").addClass("selected").removeClass("edit_active");
				}
				if($(".form_question").length) {
					$(".form_question").each(function(){
						var default_ans_val = $(this).find(".form_ans_options_cont li.selected .custom_opt").html();
						var default_ans_type = $(this).find(".form_ans_options_cont li.selected .custom_opt").attr("data-ans-type");
						if(default_ans_type=="text" && $(this).find(".textarea_opt").prop("checked")==true) {
							default_ans_type = "textarea";
						}
						$(this).find(".form_question_ans").html(default_ans_val).attr("data-ans-type",default_ans_type);
						ans_opts_hide_show($(this).find(".form_question_ans"));
						/*multiselect_choose_opt($(this).find(".multiselect_opt"));
						question_choose_opt($(this).find(".question_mandatory"));
						text_choose_opt($(this).find(".textarea_opt"));*/
						question_des_opt($(this).find(".des_opt"));
					})
				}
				$(document).on("click", ".question_sidenav_close", function(){ hide_sidenav() });
				$(document).on("click", ".btn_new_response", function(){
					$(this).closest(".multiselect_opts").addClass("current_opts");
					show_sidenav()
					$(".question_sidenav").find("#form").find("h3").html("Multiple Choice Responses");
					if($(this).closest(".form_accordion_item").hasClass("general")) {
						$(".question_sidenav").find("#form").addClass("new_multi_response general_form").find(".drag_items_cont").append(new_response_field_general);
					} else {
						$(".question_sidenav").find("#form").addClass("new_multi_response").find(".drag_items_cont").append(new_response_field);
					}
				})
				$(document).on("click", ".multiselect_edit", function(){
					var elements_data = 0;
					$(this).closest("li").addClass("edit_active");
					if($(this).closest(".form_accordion_item").hasClass("general")) {
						$(".question_sidenav").find("#form").addClass("edit_multi_response general_form").find("h3").html("Multiple Choice Responses");
						show_sidenav();
						$(this).siblings(".custom_opt").find(".custom_opt_val").each(function(){
							elements_data = {value:$(this).attr("data-value")};
							var new_response_field1 = ` 
								<div class="drag_item">
									<input class="response_field bordered_field" type="text" name="" value="`+ elements_data['value'] +`" required>
									<a class="btn_del_response" href="javascript:void(0)"></a>
								</div>`;
							$(".question_sidenav .drag_items_cont").append(new_response_field1);
						});
					}
					else {
						$(".question_sidenav").find("#form").addClass("edit_multi_response").find("h3").html("Multiple Choice Responses");
						show_sidenav();
						$(this).siblings(".custom_opt").find(".custom_opt_val").each(function(){
							elements_data = {color:$(this).attr("data-color"),value:$(this).attr("data-value"),score:$(this).attr("data-score"),failed:$(this).attr("data-failed")};
							var checked = "";
							if(elements_data['failed']=="yes"){ checked="checked"; }
							var new_response_field1 = ` 
								<div class="drag_item">
									<input class="response_field bordered_field" type="text" name="" value="`+ elements_data['value'] +`" required>
									<a class="btn_del_response" href="javascript:void(0)"></a>
									<div class="response_field_controls">
										<div class="response_color">
											<span>Color :</span>
											<label class="response_color_label" for="response_color" style="background-color: `+ elements_data['color'] +`">
												<input id="response_color" class="response_color_field" type="color" name="" value="`+ elements_data['color'] +`">
											</label>
										</div>
										<label class="response_mark_label">
											<input name="response_field_mark" type="checkbox" class="filled-in response_field_mark" value="yes" `+checked+`>
											<span>Mark as Failed</span>
										</label>
										<div class="response_score">
											<span>Score :</span>
											<input name="" type="number" min=0 value="`+ elements_data['score'] +`" class="response_score_field bordered_field">
										</div>
									</div>
								</div>`;
							$(".question_sidenav .drag_items_cont").append(new_response_field1);
						});
					}
				});
				$(document).on("change", ".response_color_field", function(){
					var current_color = $(this).val();
					$(this).val(current_color);
					$(this).closest(".response_color_label").css("background-color", current_color)
				})
				$(document).on("click", ".btn_new_res_field", function(){
					if($(this).closest("#form").hasClass("kpi_form")) {
						if($(this).siblings(".drag_items_cont").find(".drag_item").length < 5){
							$(this).siblings(".drag_items_cont").append(new_kpi_field);
						}
					} 
					else if($(this).closest("#form").hasClass("general_form")) {
						if($(this).siblings(".drag_items_cont").find(".drag_item").length < 10){
							$(this).siblings(".drag_items_cont").append(new_response_field_general);
						}
					}
					else {
						if($(this).siblings(".drag_items_cont").find(".drag_item").length < 5){
							$(this).siblings(".drag_items_cont").append(new_response_field);
						}
					}
				})
				$(document).on("click", ".btn_del_response", function(){
					$(this).closest(".drag_item").remove();
				})
				$(document).on("click", ".btn_response_submit", function(){ 
					var new_elm,new_response="";
					if($(this).closest("#form").hasClass("kpi_form")) {
						$(".kpi_active").find("select").empty();
						$(".kpi_active").find("select").append("<option value=''>Select KPI</option>");
						$(this).closest(".kpi_form").find(".drag_item").each(function(){
							$(".kpi_active").find("select").append("<option value='"+ $(this).find('.response_field').val() +"'>"+ $(this).find('.response_field').val() +"</option>");
						})
						$(".kpi_active").find("select").formSelect();
						$(".kpi_active").removeClass("kpi_active");

					} 
					else if($(this).closest("#form").hasClass("general_form")) {
						new_response = `<div class="custom_opt" data-ans-type="select">`;
						$(this).closest("#form").find(".drag_item").each(function(){
							$value = $(this).find(".response_field").val();
							new_response += ` <span class="custom_opt_val" data-value="`+ $value +`">`+ $value +`</span>`;
						})
						new_response += `</div> <a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>`;
						if($(this).closest("#form").hasClass("new_multi_response")){
							var new_response2 = '<li>' + new_response + '</li>';
							var new_response1 = '<li class="edit_active">' + new_response + '</li>';
							$(".current_opts ul").append(new_response1);
							$(".current_opts").closest(".form_question").siblings(".form_question").each(function(){
								$(this).find(".multiselect_opts ul").append(new_response2);
							});
							gen_append += new_response2;
						} else {
							$(".edit_active").empty().html(new_response);
						}
						$(".edit_active").closest(".form_ans_options_cont").css("display", "none");
						selected_value(".edit_active .custom_opt");
						$(".multiselect_opts").removeClass("current_opts");
					}
					else {
						new_response = `<div class="custom_opt" data-ans-type="select">`;
						$(this).closest("#form").find(".drag_item").each(function(){
							$value = $(this).find(".response_field").val();
							$color = $(this).find(".response_color_field").val();
							$score = $(this).find(".response_score_field").val();
							if($(this).find(".response_field_mark").is(":checked")) {
								$failed = "yes";
							} else {
								$failed = "no";
							}
							new_response += `<span class="custom_opt_val" data-value="`+ $value +`" data-failed="`+ $failed +`" data-score="`+ $score +`" data-color="`+ $color +`" data-bg-color="`+ convertHex($color,10) +`" style="color: `+ $color +`;background-color: `+ convertHex($color,10) +`;">`+ $value +`</span>`;
						})
						new_response += `</div><a class="multiselect_edit material-icons" href="javascript:void(0)">edit</a>`;
						if($(this).closest("#form").hasClass("new_multi_response")){
							new_response2 = '<li>' + new_response + '</li>';
							new_response1 = '<li class="edit_active">' + new_response + '</li>';
							$(".current_opts ul").append(new_response1);
							$(".current_opts").closest(".form_question").siblings(".form_question").each(function(){
								$(this).find(".multiselect_opts ul").append(new_response2);
							});
							$(".current_opts").closest(".form_section").siblings(".form_section").each(function(){
								$(this).find(".form_question").each(function(){
									$(this).find(".multiselect_opts ul").append(new_response2);
								})
							});
							other_append += new_response2;
						} else {
							$(".edit_active").empty().html(new_response);
						}
						$(".edit_active").closest(".form_ans_options_cont").css("display", "none");
						selected_value(".edit_active .custom_opt");
						$(".multiselect_opts").removeClass("current_opts");
					}
					hide_sidenav();
				})
				/* question sidebar end */
				$(document).on("blur",".form_question_ans", function(){
					ans_opts_hide_show(this);
				})
				$(document).on("change",".question_mandatory", function(){
					question_choose_opt(this);
				})
				$(document).on("change",".multiselect_opt", function(){
					multiselect_choose_opt(this);
				})
				$(document).on("change",".des_opt", function(){
					question_des_opt(this);
				})
				$(document).on("blur",".checkbox_opt input", function(){
					$(this).closest(".form_question").find("[data-ans-type=checkbox] span").attr("data-score", $(this).val());
				})
				$(document).on("change",".textarea_opt", function(){
					text_choose_opt(this);
				})
				$(document).on("click", ".custom_opt", function(){
					selected_value(this);
				})
				$(document).on("click", ".btn_new_kpi_opt", function(){
					var kpi_opts = [], kpi_html;
					$(this).closest(".kpi_opt").addClass("kpi_active").find("select option").each(function(){
						if($(this).val() != "") {
							kpi_html += ` 
								<div class="drag_item">
									<input class="response_field bordered_field" type="text" name="" value="`+ $(this).val() +`" required>
									<a class="btn_del_response" href="javascript:void(0)"></a>
								</div>
							`;
						} else {kpi_html=""}
					})
					show_sidenav();
					$(".question_sidenav").find("#form").addClass("kpi_form").find("h3").html("KPI Multiple Choice Responses");
					$(".question_sidenav").find(".kpi_form .drag_items_cont").html(kpi_html);


				})
				$(document).on("click", ".btn_form_final_submit ", function(){
					if($('#tmp_name').val() === ""){
						alertBox('Please Enter Template Name');
						return false;
					} 
					else{
						var final_data = [], each_question = [];
						final_data.push({
								tmp_name : $('#tmp_name').val()
						});
						final_data.push({
								tmp_unique_id : $('#tmp_unique_id').val()
						});
						each_question.push({
								sec_title : 'General Information'
						});
						$(this).closest(".form_creation").find(".form_accordion_item").each(function(key,value){
							if($(this).hasClass("general")) {
								$(this).find(".form_question").each(function(key,value){
									var ques_text = $(this).find(".question_text").val();
									var ques_required = $(this).find(".question_text").attr("data-question-required");
									var ques_description = $(this).find(".description_text").val();
									var ans_type = $(this).find(".form_question_ans").attr("data-ans-type");
									var ans_multi_sel = $(this).find(".form_question_ans").attr("data-ans-multi-select");
									var ans_kpi_multi_sel = null;
									//alert(ans_kpi_multi_sel);
									
									var ans_value = [];
									$(this).find(".form_question_ans span").each(function(){
										var ans_text = $(this).attr("data-value");
										var ans_failed = null;
										var ans_score = 0;
										var ans_color = null;
										var ans_bg_color = null;
										ans_value.push({
											ans_text: ans_text,
											ans_failed: ans_failed,
											ans_score: ans_score,
											ans_color: ans_color,
											ans_bg_color: ans_bg_color
										})
									});
									//console.log(ans_value);
									each_question.push({
										ques_text: ques_text,
										ques_required: ques_required,
										ques_description: ques_description,
										ans_type: ans_type,
										ans_multi_sel: ans_multi_sel,
										ans_kpi_multi_sel:ans_kpi_multi_sel,
										ans_value: ans_value
									})
									
								})
								//console.log(each_question);
								final_data.push({
									general : each_question
								});
							}
							else {
								var each_secdata_nonGen = [];
								$(this).find(".form_section").each(function(key,value){

									if (typeof ($(this).find(".section_title").val()) === "undefined") {
										//RRRRRRRRRRRRRRRRRR
										var check = $(this).find(".form_question").find(".question_text").val();
										if(check != ''){
											var sec_title = 'blank_sec';
											var Each_Question = [];
											Each_Question.push({
												sec_title: sec_title
											});
											$(this).find(".form_question").each(function(key,value){
												var ques_text = $(this).find(".question_text").val();
												var ques_required = $(this).find(".question_text").attr("data-question-required");
												var ques_description = $(this).find(".description_text").val();
												var ans_type = $(this).find(".form_question_ans").attr("data-ans-type");
												var ans_multi_sel = $(this).find(".form_question_ans").attr("data-ans-multi-select");
												//var ans_checkbox_score = $(this).find(".checkbox_opt input").val();
												var ans_kpi_multi_sel = $(this).find(".kpi_opt select").val();
													ans_kpi_multi_sel = ans_kpi_multi_sel != '' ? ans_kpi_multi_sel : null;
												//console.log(ans_kpi_multi_sel);
												var ans_value = [];
												$(this).find(".form_question_ans span").each(function(){
													var ans_text = $(this).attr("data-value");
													var ans_failed = $(this).attr("data-failed");
													var ans_score = $(this).attr("data-score");
													var ans_color = $(this).attr("data-color");
													var ans_bg_color = $(this).attr("data-bg-color");
													ans_value.push({
														ans_text: ans_text,
														ans_failed: ans_failed,
														ans_score: ans_score,
														ans_color: ans_color,
														ans_bg_color: ans_bg_color
													})
												});
												Each_Question.push({
													ques_text: ques_text,
													ques_required: ques_required,
													ques_description: ques_description,
													ans_type: ans_type,
													ans_multi_sel: ans_multi_sel,
													ans_kpi_multi_sel:ans_kpi_multi_sel,
													ans_value: ans_value
												})
											})
											final_data.push({
												section_name : Each_Question
											});
										}
										//alert(check);
										
									}
									else{
										// each_secdata_nonGen.push({
										// 	sec_title: $(this).find(".section_title").val()
										// });
										var sec_title = $(this).find(".section_title").val();
										var Each_Question = [];
										Each_Question.push({
											sec_title: sec_title
										});
										$(this).find(".form_question").each(function(key,value){
											var ques_text = $(this).find(".question_text").val();
											var ques_required = $(this).find(".question_text").attr("data-question-required");
											var ques_description = $(this).find(".description_text").val();
											var ans_type = $(this).find(".form_question_ans").attr("data-ans-type");
											var ans_multi_sel = $(this).find(".form_question_ans").attr("data-ans-multi-select");
											var ans_kpi_multi_sel = $(this).find(".kpi_opt select").val();
											ans_kpi_multi_sel = ans_kpi_multi_sel != '' ? ans_kpi_multi_sel : null;
											//console.log(ans_kpi_multi_sel);
											var ans_value = [];
											$(this).find(".form_question_ans span").each(function(){
												var ans_text = $(this).attr("data-value");
												var ans_failed = $(this).attr("data-failed");
												var ans_score = $(this).attr("data-score");
												var ans_color = $(this).attr("data-color");
												var ans_bg_color = $(this).attr("data-bg-color");
												ans_value.push({
													ans_text: ans_text,
													ans_failed: ans_failed,
													ans_score: ans_score,
													ans_color: ans_color,
													ans_bg_color: ans_bg_color
												})
											});
											Each_Question.push({
												ques_text: ques_text,
												ques_required: ques_required,
												ques_description: ques_description,
												ans_type: ans_type,
												ans_multi_sel: ans_multi_sel,
												ans_kpi_multi_sel:ans_kpi_multi_sel,
												ans_value: ans_value
											})
										})
										final_data.push({
											section_name : Each_Question
										});
									}
										//RRRRRR
									
								})
								// final_data.push({
								// 	others : each_secdata_nonGen
								// });
							}
						})
						//console.log(final_data);
						//$('.rrr').html(JSON.stringify(final_data));
						var ajaxRes = postAjax('<?php echo site_url();?>/template-update',{'template_data':final_data});
						//var ajaxRes = postAjax('<?php echo site_url();?>/welcome-setup/template-update',{'template_data':final_data});
						//var ajaxRes = 'errorrrrrrrr';
						//$('.rrr').html(JSON.stringify(ajaxRes));
						//console.log(ajaxRes);
						$('.back_top').click();
						$('.log_msg').removeClass('hide');
						if(ajaxRes == 'success')
						{
							//$('.tmp_response').html("hhhhhhh");
							$('.page_error').addClass('success');
							$('.page_error').removeClass('failure');
							$('#log_msg').html('Template Created successfully  ....'); 	
							setTimeout(function(){ location.replace('<?php echo site_url();?>/welcome-setup/site-setup'); }, 1000);
							setTimeout(function(){ $('.log_msg').addClass('hide'); }, 1000);
						}
						else{
							//$('.tmp_response').html("NNNN");
							$('.page_error').removeClass('success');
							$('.page_error').addClass('failure');
							$('#log_msg').html('Template is not Created try again ....'); 	
							setTimeout(function(){ $('.log_msg').addClass('hide'); }, 4000);
						}
						// next closed is for button submit 
					}
				})

				//var tmp_name = $('#tmp_name').val();
				// check temp name in data base
				// var ajaxResCheck_name = postAjax('<?php echo site_url();?>/get-unique-template',{'tmp_name':$('#tmp_name').val()});
				// if(ajaxResCheck_name == 'error'){
				// 	$('.tmp_name').text('The Template Name is already taken');
				// 	$('.btn_form_final_submit').prop('disabled', true);
				// 	setTimeout(function(){ $('.tmp_name').addClass('hide'); }, 5000);
				// }
				// else{
				// 	$('.btn_form_final_submit').prop('disabled', false);
				// 	$('.form_name').text('');
				// }
				$('#tmp_name').blur(function(){
					var tmp_name = $(this).val();
					var ajaxRes = postAjax('<?php echo site_url();?>/get-unique-template',{'tmp_name':tmp_name});
					if(ajaxRes == 'error'){
						$('.tmp_name').text('The Template name is already taken');
						$('.btn_form_final_submit').prop('disabled', true);
					}
					else{
						$('.btn_form_final_submit').prop('disabled', false);
						$('.form_name').text('');
					}
				});
			});

			// function nospaces(t){
			// 	if(t.value.match(/\s/g)){
			// 		alert('Sorry, you are not allowed to enter any spaces');
			// 		t.value=t.value.replace(/\s/g,'');
			// 	}
			// 	var ajaxRes = postAjax('<?php //echo site_url();?>/get-unique-template',{'tmp_name':t.value});
			// 	if(ajaxRes == 'error'){
			// 		$('.tmp_name').text('The Template Name is already taken');
			// 		$('.btn_form_final_submit').prop('disabled', true);
			// 	}
			// 	else{
			// 		$('.btn_form_final_submit').prop('disabled', false);
			// 		$('.form_name').text('');
			// 	}
			// }
			// http://vishalok12.github.io/jquery-dragarrange/
		</script>
    </body>
</html>
