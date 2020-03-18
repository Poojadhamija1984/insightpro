<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('subscription_lang', 'subscription');
    }

    public function index() {
        $data['title'] = 'Add Agent';
        $clname = 'add_agent';
        $data['client_hierarchy'] = $this->common->getAllData('hierarchy');
        $this->load->view('agent/addAgent', $data);
    }

    public function agentHierarchy() {
        $data['title'] = "Agent Hierarchy";
        $data['lob'] = $this->common->getDistinctWhere('hierarchy', 'lob', ['client_id' => $this->client_id]);
        $this->load->view('agent/hierarchy', $data);
    }

    public function agentHierarchyDetails($type, $data) {
        $data = urldecode($data);
        if (strtolower($type) == "lob") {
            $lob = $this->common->getDistinctWhere('hierarchy', 'campaign', ['lob' => $data, 'client_id' => $this->client_id]);
            $opt = '';
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->campaign}'>{$value->campaign}</option>";
            }
            echo $opt;
        }
        if (strtolower($type) == "campaign") {
            $lob = $this->common->getDistinctWhere('hierarchy', 'vendor', ['campaign' => $data, 'client_id' => $this->client_id]);
            $opt = '';
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->vendor}'>{$value->vendor}</option>";
            }
            echo $opt;
        }
        if (strtolower($type) == "vendor") {
            $lob = $this->common->getDistinctWhere('hierarchy', 'location', ['vendor' => $data, 'client_id' => $this->client_id]);
            $opt = '';
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->location}'>{$value->location}</option>";
            }
            echo $opt;
        }
    }

    public function lobData($id) {
        $id = urldecode($id);
        $lob = $this->common->getWhereSelectAll('hierarchy', ['hierarchy_id', 'vendor', 'location', 'campaign'], ['lob' => $id]);
        
        $div = '';
        foreach ($lob as $key => $value) {
            $div .= "<div class='row lob_choose_row'><div class='lob_choose_option'>";
            $div .= "<label><input type='radio' name='lob_h_data' class='browser-default' value='{$value->hierarchy_id}'><span></span></label>";
            $div .= "</div>";
            
            $div .= "<div class='input-field col s4'>";
            $div .= "<input class='lob_data' type='text' name='campaign' value='{$value->campaign}' readonly><label for='Campaign'>Campaign</label>";
            $div .= "</div>";
            
            $div .= "<div class='input-field col s4'>";
            $div .= "<input class='lob_data' type='text'  name='vendor' value='{$value->vendor}' readonly><label for='Vendor'>Vendor</label>";
            $div .= "</div>";
            
            $div .= "<div class='input-field col s4'>";
            $div .= "<input class='lob_data' type='text' name='location' value='{$value->location}' readonly><label for='Location'>Location</label>";
            $div .= "</div></div>";
        }
        echo $div;
    }

    public function getSupervisor($id) {
        $id = urldecode($id);
        $opt = '';
        
        if ($id == "client") {
            $lob = $this->common->getWhereSelectAll('user', ['name', 'empid'], ['status' => '1', 'usertype' => 3, 'is_admin' => '3']);
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->empid}'>{$value->name}</option>";
            }
        } else if ($id == "ops") {
            $lob = $this->common->getWhereSelectAll('user', ['name', 'empid'], ['status' => '1', 'usertype' => 3, 'is_admin' => '2']);
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->empid}'>{$value->name}</option>";
            }
        } else {
            $opt .= "<option value=''>No data Found</option>";
        }
        echo $opt;
    }

    public function getSupervisorDetails($id) {
        $id = urldecode($id);
        $lob = $this->common->getWhereSelectAll('user', ['name as employee_id', 'user_email as supervisor_email'], ['empid' => $id]);
        if (!empty($lob))
            echo json_encode($lob);
        else
            echo json_encode(['employee_id' => '', 'supervisor_email' => '']);
    }

    public function EditAgent($id) {
        $data['title'] = 'Edit Agent';
        $clname = 'add_agent';
        $data['client_hierarchy'] = $this->common->getAllData('hierarchy');
        $data['agent_data'] = $this->common->getWhere('agent', ['agent_id' => $id]);
        // echo "<pre>";print_r($data);die;
        $this->load->view('agent/addAgent', $data);
    }

    public function deleteAgent() {
        $agentId = $this->input->post('id');
        if (!empty($agentId)) {
            $this->db->where_in('agent_id', $agentId);
            $this->db->delete('agent');
        }
        echo json_encode(['massage' => 'Agent Delete Successfully']);
    }

    public function updateStatus() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $reasult = $this->common->update_data('user', ['status' => $status], ['user_id' => $id]);
        $csrfTokenName = $this->security->get_csrf_token_name();
        $csrfHash = $this->security->get_csrf_hash();
        $data = [
            'csrfTokenName' => $csrfTokenName,
            'csrfHash' => $csrfHash,
            'data' => (($reasult != "not updated") ? 'Success' : 'Try Again')
        ];
        echo json_encode($data);
        die;
    }

    public function invalid() {
        $data['title'] = 'Invalid Agent';
        $clname = 'hierarchy_management';
        $data['agentInfo'] = $this->import->agentList('0');
        $this->load->view('agent/invalidagent', $data);
    }

    public function roster() {
        $data['title'] = 'Upload Roster ';
        $clname = 'hierarchy_management';
        $data['agentInfo'] = $this->import->agentList('1');
        $this->load->view('agent/agent_roster_upload', $data);
    }

    public function addAgent() {
        $client_id = $this->client_id;
        $this->form_validation->set_rules('agent_id', 'Agent Id', 'required|trim');
        $this->form_validation->set_rules('agent_name', 'Agent Name', 'required|trim');
        //$this->form_validation->set_rules('campaign', 'Campaign', 'required|trim');
        $this->form_validation->set_rules('lob', 'Lob', 'required|trim');
        //$this->form_validation->set_rules('vendor', 'Vendor', 'required|trim');
        $this->form_validation->set_rules('location', 'Location', 'required|trim');
        $this->form_validation->set_rules('agent_doj', 'Agent DOJ', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            if (form_error('agent_id')) {
                $this->session->set_flashdata('agent_id', 'Please Enter Agent Id');
            }
            if (form_error('agent_name')) {
                $this->session->set_flashdata('agent_name', 'Please Enter Agent Name');
            }
            /* if (form_error('campaign')) {
              $this->session->set_flashdata('campaign','Please Enter Campaign');
              }
              if (form_error('vendor')) {
              $this->session->set_flashdata('vendor','Please Enter Vendor');
              } */
            if (form_error('lob')) {
                $this->session->set_flashdata('lob', 'Please Enter Lob');
            }
            if (form_error('location')) {
                $this->session->set_flashdata('location', 'Please Enter Location');
            }
            if (form_error('agent_doj')) {
                $this->session->set_flashdata('agent_doj', 'Please Enter Agent DOJ');
            }
        } else {
            $agent_id = $this->input->post('agent_id');
            $agent_name = $this->input->post('agent_name');
            //$campaign 		= 	$this->input->post('campaign');
            $lob = $this->input->post('lob');
            //$vendor 		= 	$this->input->post('vendor');
            $location = $this->input->post('location');
            $agent_doj = $this->input->post('agent_doj');
            $supervisor = $this->input->post('supervisor');
            $supervisor_id = $this->input->post('supervisor_id');
            $manager = $this->input->post('manager');
            $manager_id = $this->input->post('manager_id');
            $agent_status = $this->input->post('agent_status');
            $agent_invalid_status = $this->input->post('agent_invalid_status');
            $data = [
                'client_id' => $client_id,
                'agent_id' => $agent_id,
                'agent_name' => $agent_name,
                'lob' => $lob,
                //'vendor' 					=>	$vendor,
                'location' => $location,
                //'companion' 				=>	$campaign,
                'doj' => date('Y-m-d', strtotime($agent_doj)),
                'first_level_reporting_id' => $supervisor_id,
                'first_level_reporting' => $supervisor,
                'second_level_reporting_id' => $manager_id,
                'second_level_reporting' => $manager,
                'agent_status' => ((strtolower($agent_status) == "active") ? '1' : '0'),
                'agent_created_date' => date('Y-m-d H:i:s'),
                'agent_updated_date' => date('Y-m-d H:i:s'),
                'agent_valid' => $agent_invalid_status,
            ];
            $ad = $this->common->getWhere('agent', ['client_id' => $client_id]);
            if ((int) $this->subscriptionAgent > count($ad) && !is_infinite($this->subscriptionAgent)) {
                $sql1 = $this->common->getWhere('agent', ['agent_id' => $agent_id, 'client_id' => $client_id]);
                if (count($sql1) > 0) {
                    $this->common->update_data('agent', $data, ['agent_id' => $agent_id, 'client_id' => $client_id]);
                } else {
                    $this->common->insert_data($data, 'agent');
                }
                //echo $this->db->last_query();die;
                $this->session->set_flashdata('message', 'Agent Inserted Successfully!');
            } else if (is_infinite($this->subscriptionAgent)) {
                $sql1 = $this->common->getWhere('agent', ['agent_id' => $agent_id, 'client_id' => $client_id]);
                if (count($sql1) > 0) {
                    $this->common->update_data('agent', $data, ['agent_id' => $agent_id, 'client_id' => $client_id]);
                } else {
                    $this->common->insert_data($data, 'agent');
                }
                //echo $this->db->last_query();die;
                $this->session->set_flashdata('message', 'Agent Inserted Successfully!');
            } else {
                $this->session->set_flashdata('error', $this->lang->line('agent_error'));
            }
        }
        redirect('add_agent');
    }

    public function import() {
        $this->load->library('excel');
        $client_id = $this->client_id;
        if ($this->input->post('importfile') && $_FILES['userfile']['name'] != '') {
            $path = 'assets/upload/agent_roster/';
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                die;
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = [
                'agent_id',
                'agent_name',
                'lob',
                //'vendor',
                'location',
                // 'campaign',
                'doj',
                'first_level_reporting_id',
                'first_level_reporting',
                'second_level_reporting_id',
                'second_level_reporting',
                'agent_status'
            ];
            $makeArray = [
                'agent_id' => 'agent_id',
                'agent_name' => 'agent_name',
                'lob' => 'lob',
                // 'vendor'					=> 'vendor',
                'location' => 'location',
                //'campaign'					=> 'campaign',
                'doj' => 'doj',
                'first_level_reporting_id' => 'first_level_reporting_id',
                'first_level_reporting' => 'first_level_reporting',
                'second_level_reporting_id' => 'second_level_reporting_id',
                'second_level_reporting' => 'second_level_reporting',
                'agent_status' => 'agent_status'
            ];
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else {
                        
                    }
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);
            // print_r($data);die;
            $agentInvalidCount = 0;
            if (empty($data)) {
                $flag = 1;
            }

            $ad = $this->common->getWhere('agent', ['client_id' => $client_id]);

            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $addresses = array();
                    $agent_id = $SheetDataKey['agent_id'];
                    $agent_name = $SheetDataKey['agent_name'];
                    $lob = $SheetDataKey['lob'];
                    //$vendor 					= 	$SheetDataKey['vendor'];
                    $location = $SheetDataKey['location'];
                    //$campaign 					= 	$SheetDataKey['campaign'];
                    $doj = $SheetDataKey['doj'];
                    $first_level_reporting_id = $SheetDataKey['first_level_reporting_id'];
                    $first_level_reporting = $SheetDataKey['first_level_reporting'];
                    $second_level_reporting_id = $SheetDataKey['second_level_reporting_id'];
                    $second_level_reporting = $SheetDataKey['second_level_reporting'];
                    $status = $SheetDataKey['agent_status'];

                    $agent_id = filter_var(trim($allDataInSheet[$i][$agent_id]), FILTER_SANITIZE_STRING);
                    $agent_name = filter_var(trim($allDataInSheet[$i][$agent_name]), FILTER_SANITIZE_STRING);
                    $lob = filter_var(trim($allDataInSheet[$i][$lob]), FILTER_SANITIZE_STRING);
                    //$vendor 					= 	filter_var(trim($allDataInSheet[$i][$vendor]), FILTER_SANITIZE_STRING);
                    $location = filter_var(trim($allDataInSheet[$i][$location]), FILTER_SANITIZE_STRING);
                    //$campaign 				= 	filter_var(trim($allDataInSheet[$i][$campaign]), FILTER_SANITIZE_STRING);
                    $doj = filter_var(trim($allDataInSheet[$i][$doj]), FILTER_SANITIZE_STRING);
                    $first_level_reporting_id = filter_var(trim($allDataInSheet[$i][$first_level_reporting_id]), FILTER_SANITIZE_STRING);
                    $first_level_reporting = filter_var(trim($allDataInSheet[$i][$first_level_reporting]), FILTER_SANITIZE_STRING);
                    $second_level_reporting_id = filter_var(trim($allDataInSheet[$i][$second_level_reporting_id]), FILTER_SANITIZE_STRING);
                    $second_level_reporting = filter_var(trim($allDataInSheet[$i][$second_level_reporting]), FILTER_SANITIZE_STRING);
                    $status = filter_var(trim($allDataInSheet[$i][$status]), FILTER_SANITIZE_STRING);


                    //$d['h'] = $this->common->getWhere('hierarchy',['lob'=>$lob,'campaign'=>$campaign,'vendor'=>$vendor,'location'=>$location,'client_id'=>$client_id]);
                    //echo $this->db->last_query();
                    //if(!empty($d['h'])){
                    //	$agent_valid = '1';
                    //}
                    //else{
                    //    	$agentInvalidCount++;
                    //    	$agent_valid = '0';
                    // }
                    if ((int) $this->subscriptionAgent >= count($ad) && !is_infinite($this->subscriptionAgent)) {
                        $sql1 = $this->common->getWhere('agent', ['agent_id' => $agent_id, 'client_id' => $client_id]);
                        if (count($sql1) > 0) {
                            $updateData = [
                                'client_id' => $client_id,
                                'agent_id' => $agent_id,
                                'agent_name' => $agent_name,
                                'lob' => $lob,
                                //'vendor' 					=>	$vendor,
                                'location' => $location,
                                //'companion' 				=>	$campaign,
                                'doj' => date('Y-m-d', strtotime(str_replace('-', '/', $doj))),
                                'first_level_reporting_id' => $first_level_reporting_id,
                                'first_level_reporting' => $first_level_reporting,
                                'second_level_reporting_id' => $second_level_reporting_id,
                                'second_level_reporting' => $second_level_reporting,
                                'agent_status' => ((strtolower($status) == "active") ? '1' : '0'),
                                'agent_created_date' => date('Y-m-d H:i:s'),
                                'agent_updated_date' => date('Y-m-d H:i:s'),
                                'agent_valid' => '1',
                            ];
                            $this->common->update_data('agent', $updateData, ['agent_id' => $agent_id, 'client_id' => $client_id]);
                        } else {
                            $insertData = [
                                'client_id' => $client_id,
                                'agent_id' => $agent_id,
                                'agent_name' => $agent_name,
                                'lob' => $lob,
                                //'vendor' 					=>	$vendor,
                                'location' => $location,
                                //'companion' 				=>	$campaign,
                                'doj' => date('Y-m-d', strtotime(str_replace('-', '/', $doj))),
                                'first_level_reporting_id' => $first_level_reporting_id,
                                'first_level_reporting' => $first_level_reporting,
                                'second_level_reporting_id' => $second_level_reporting_id,
                                'second_level_reporting' => $second_level_reporting,
                                'agent_status' => ((strtolower($status) == "active") ? '1' : '0'),
                                'agent_created_date' => date('Y-m-d H:i:s'),
                                'agent_updated_date' => date('Y-m-d H:i:s'),
                                'agent_valid' => '1', //$agent_valid,
                            ];
                            $this->common->insert_data($insertData, 'agent');
                        }
                        $this->session->set_flashdata('message', 'Agent Added Successfully!');
                    } else if (is_infinite($this->subscriptionAgent)) {
                        $sql1 = $this->common->getWhere('agent', ['agent_id' => $agent_id, 'client_id' => $client_id]);
                        if (count($sql1) > 0) {
                            $updateData = [
                                'client_id' => $client_id,
                                'agent_id' => $agent_id,
                                'agent_name' => $agent_name,
                                'lob' => $lob,
                                //'vendor' 					=>	$vendor,
                                'location' => $location,
                                //'companion' 				=>	$campaign,
                                'doj' => date('Y-m-d', strtotime(str_replace('-', '/', $doj))),
                                'first_level_reporting_id' => $first_level_reporting_id,
                                'first_level_reporting' => $first_level_reporting,
                                'second_level_reporting_id' => $second_level_reporting_id,
                                'second_level_reporting' => $second_level_reporting,
                                'agent_status' => ((strtolower($status) == "active") ? '1' : '0'),
                                'agent_created_date' => date('Y-m-d H:i:s'),
                                'agent_updated_date' => date('Y-m-d H:i:s'),
                                'agent_valid' => '1',
                            ];
                            $this->common->update_data('agent', $updateData, ['agent_id' => $agent_id, 'client_id' => $client_id]);
                        } else {
                            $insertData = [
                                'client_id' => $client_id,
                                'agent_id' => $agent_id,
                                'agent_name' => $agent_name,
                                'lob' => $lob,
                                //'vendor' 					=>	$vendor,
                                'location' => $location,
                                //'companion' 				=>	$campaign,
                                'doj' => date('Y-m-d', strtotime(str_replace('-', '/', $doj))),
                                'first_level_reporting_id' => $first_level_reporting_id,
                                'first_level_reporting' => $first_level_reporting,
                                'second_level_reporting_id' => $second_level_reporting_id,
                                'second_level_reporting' => $second_level_reporting,
                                'agent_status' => ((strtolower($status) == "active") ? '1' : '0'),
                                'agent_created_date' => date('Y-m-d H:i:s'),
                                'agent_updated_date' => date('Y-m-d H:i:s'),
                                'agent_valid' => '1', //$agent_valid,
                            ];
                            $this->common->insert_data($insertData, 'agent');
                        }
                        //echo $this->db->last_query();die;
                        $this->session->set_flashdata('message', 'Agent Added Successfully!');
                    } else {
                        $this->session->set_flashdata('error', $this->lang->line('agent_error'));
                    }


                    /*
                      $sql1 = $this->common->getWhere('agent',['agent_id'=>$agent_id,'client_id'=>$client_id]);
                      if(!empty($sql1)){
                      $updateData[] 	= 	[
                      'client_id'					=>	$client_id,
                      'agent_id' 					=>	$agent_id,
                      'agent_name' 				=>	$agent_name,
                      'lob'						=>	$lob,
                      //'vendor' 					=>	$vendor,
                      'location'				=>	$location,
                      //'companion' 				=>	$campaign,
                      'doj' 						=>	date('Y-m-d', strtotime(str_replace('-','/', $doj))),
                      'first_level_reporting_id' 	=>  $first_level_reporting_id,
                      'first_level_reporting' 	=>	$first_level_reporting,
                      'second_level_reporting_id' =>	$second_level_reporting_id,
                      'second_level_reporting' 	=>	$second_level_reporting,
                      'agent_status' 				=> 	((strtolower($status) == "active")?'1':'0'),
                      'agent_created_date' 		=> 	date('Y-m-d H:i:s'),
                      'agent_updated_date' 		=> 	date('Y-m-d H:i:s'),
                      'agent_valid' 				=> 	'1',
                      ];
                      }
                      else{
                      //$this->common->insert_data($fetchData);
                      $insertData[] 	= 	[
                      'client_id'					=>	$client_id,
                      'agent_id' 					=>	$agent_id,
                      'agent_name' 				=>	$agent_name,
                      'lob'						=>	$lob,
                      //'vendor' 					=>	$vendor,
                      'location'				=>	$location,
                      //'companion' 				=>	$campaign,
                      'doj' 						=>	date('Y-m-d', strtotime(str_replace('-','/', $doj))),
                      'first_level_reporting_id' 	=>  $first_level_reporting_id,
                      'first_level_reporting' 	=>	$first_level_reporting,
                      'second_level_reporting_id' =>	$second_level_reporting_id,
                      'second_level_reporting' 	=>	$second_level_reporting,
                      'agent_status' 				=> 	((strtolower($status) == "active")?'1':'0'),
                      'agent_created_date' 		=> 	date('Y-m-d H:i:s'),
                      'agent_updated_date' 		=> 	date('Y-m-d H:i:s'),
                      'agent_valid' 				=> 	'1',//$agent_valid,
                      ];
                      }
                      }
                      if(!empty($insertData))
                      $this->import->insertData($insertData);
                      if(!empty($updateData))
                      $this->import->updateData($updateData);
                      //echo $this->db->last_query();
                      //$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Data Uploaded successfully with '.$agentInvalidCount.' Invalid Agent </div>');
                      $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Data Uploaded successfully </div>'); */
                }
                unlink($inputFileName);
                redirect('agent_roster_upload', 'refresh');
            } else {
                $this->session->set_flashdata('error', '<div class="alert alert-success text-center">Please Upload correct file</div>');
                // echo "Please import correct file";
                redirect('agent_roster_upload', 'refresh');
            }
        }
        $this->session->set_flashdata('error', '<div class="alert alert-success text-center">Please Upload file</div>');
        redirect('agent_roster_upload', 'refresh');
        //$this->load->view('import/display', $data);
    }

    public function Team() {
        if ($this->emp_group == "admin") {
            $data['title'] = "Team";
            $lob = $this->common->getSelectAll('hierarchy', 'lob');
            $opt = '';
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->lob}'>{$value->lob}</option>";
            }
            $data['lob'] = $opt;
            $data['team'] = $this->common->getWhereSelectAll('user', ['user_id', 'name', 'empid', 'usertype', 'sup_id', 'sup_name', 'lob', 'is_admin', 'status'], ['client_id' => $this->client_id, 'is_admin !=' => 1]);
            
            $this->load->view('agent/team', $data);
        } else {
            $data['title'] = "Access Denied";
            $this->load->view('permission_denied', $data);
        }
    }
    
    public function TeamAjax() {
        if ($this->emp_group == "admin") {
            $lob = $this->common->getSelectAll('hierarchy', 'lob');
            $opt = '';
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->lob}'>{$value->lob}</option>";
            }
            $data['lob'] = $opt;
            $data['team'] = $this->common->getWhereSelectAll('user', ['user_id', 'name', 'empid', 'usertype', 'sup_id', 'sup_name', 'lob', 'is_admin', 'status'], ['client_id' => $this->client_id, 'is_admin !=' => 1]);
            $this->load->view('agent/team_ajax', $data);
        } else {
            $data['title'] = "Access Denied";
            $this->load->view('permission_denied', $data);
        }
    }

    public function inActiveTeam() {
        if ($this->emp_group == "admin") {
            $data['title'] = "InActive Employee";
            $data['team'] = $this->common->getWhereSelectAll('user', ['user_id', 'name', 'empid', 'usertype', 'sup_id', 'sup_name', 'lob', 'is_admin', 'status'], ['client_id' => $this->client_id, 'is_admin !=' => 1, 'status' => '0']);
            $this->load->view('agent/inactiveteam', $data);
        } else {
            $data['title'] = "Access Denied";
            $this->load->view('permission_denied', $data);
        }
    }

    public function TeamRoster() {
        if ($this->emp_group == "admin") {
            $data['title'] = "Team";
            $lob = $this->common->getSelectAll('hierarchy', 'lob');
            $opt = '';
            foreach ($lob as $key => $value) {
                $opt .= "<option value='{$value->lob}'>{$value->lob}</ooption>";
            }
            $data['lob'] = $opt;
            $data['team'] = $this->common->getWhereSelectAll('user', ['user_id', 'name', 'empid', 'usertype', 'sup_id', 'sup_name', 'lob', 'is_admin', 'status'], ['client_id' => $this->client_id, 'is_admin !=' => 1]);
            $this->load->view('agent/team_roster', $data);
        } else {
            $data['title'] = "Access Denied";
            $this->load->view('permission_denied', $data);
        }
    }

    public function addTeam() {
        $post_data = $this->input->post();
        $client_id = $this->client_id;
        $this->form_validation->set_rules('user_group', 'User Group', 'required|trim');
        $this->form_validation->set_rules('user_type', 'User Type', 'required|trim');
        $this->form_validation->set_rules('lob[]', 'LOB', 'required|min_length[1]|trim');

        if (isset($post_data['user_type']) && isset($post_data['user_group'])) {
            if ($post_data['user_group'] == 'client' && $post_data['user_type'] == 'agent') {
                $this->form_validation->set_rules('lob_h_data', 'LOB Hierarchy', 'required');
            }
            if ($post_data['user_type'] != "supervisor") {
                $this->form_validation->set_rules('supervisor_id', 'Supervisor ID', 'required|trim');
                $this->form_validation->set_rules('supervisor_name', 'Supervisor Name', 'required|trim');
            }
        }

        $this->form_validation->set_rules('user_name', 'User Name', 'required|trim');
        $this->form_validation->set_rules('user_id', 'User Id', 'required|trim|is_unique[user.empid]');
        $this->form_validation->set_rules('user_email', 'User Email', 'valid_email|required|trim|is_unique[user.user_email]');
        $this->form_validation->set_rules('user_doj', 'User DOJ', 'required|trim|callback_date_check');
        if ($this->form_validation->run() == FALSE) {
            $ajax_response = array("status" => "failure", "message" => array_values($this->form_validation->error_array())[0]);
        } else {
            
            if (strtotime(date("Y-m-d")) < strtotime($post_data['user_doj'])) {
                $ajax_response = array("status" => "failure", "message" => "User Doj can't be greater than current date.");
            }else{
                $user_group     = (($post_data['user_group'] == "client") ? 3 : 2); // 2 => ops ,3=>client
                $user_type      = (($post_data['user_type'] == "agent") ? 2 : 3); // 2 => agent ,3=>Supervisor
                $lob            = implode('|||', $post_data['lob']);
                $lob_h_data     = ((!empty($post_data['lob_h_data'])) ? $post_data['lob_h_data'] : NULL); // if user_group is client and user_type is agent 
                $supervisor     = ((!empty($post_data['supervisor_id'])) ? $post_data['supervisor_id'] : NULL); // if user_type not supervisor 
                $sup_name       = ((!empty($post_data['supervisor_name'])) ? $post_data['supervisor_name'] : '');
                $sup_email      = ((!empty($post_data['supervisor_email'])) ? $post_data['supervisor_email'] : '');
                $user_name      = $post_data['user_name'];
                $user_id        = $post_data['user_id'];
                $user_email     = $post_data['user_email'];
                $user_doj       = date('Y-m-d', strtotime($post_data['user_doj']));

                $data = [
                    'client_id'         => $this->client_id,
                    'name'              => $user_name,
                    'empid'             => $user_id,
                    'usertype'          => $user_type,
                    'user_email'        => $user_email,
                    'doj'               => $user_doj,
                    'sup_id'            => $supervisor,
                    'sup_name'          => $sup_name,
                    'sup_email'         => $sup_email,
                    'lob'               => $lob,
                    'lob_hierarchy_id'  => $lob_h_data,
                    'user_password'     => password_hash($this->config->item('default_password'), PASSWORD_BCRYPT, ['cost' => $this->config->item('cost')]),
                    'is_admin'          => $user_group,
                    'status'            => '1',
                    'user_created_date' => date('Y-m-d H:i:s'),
                    'is_first_login'    => '1'
                ];

                $ad = $this->common->getWhere('user', ['client_id' => $client_id, 'usertype !=' => 1]);
                if ((int) $this->subscriptionAgent >= count($ad) && !is_infinite($this->subscriptionAgent)) {
                    $this->common->insert_data($data, 'user');

                    //SENDING EMAIL TO NEWLY REGISTERED USER
                    $body = $this->load->view('email_template/team_creation', $data, true);
                    $mail = send_email($user_email, 'Login Credentials', $body);

                    //SUCCESS MESSAGE
                    $ajax_response = array("status" => "success", "message" => "User Added Successfully!");
                }
                else if (is_infinite($this->subscriptionAgent)) {
                    $this->common->insert_data($data, 'user');

                    //SENDING EMAIL TO NEWLY REGISTERED USER
                    $body = $this->load->view('email_template/team_creation', $data, true);
                    $mail = send_email($user_email, 'Login Credentials', $body);

                    //SUCCESS MESSAGE
                    $ajax_response = array("status" => "success", "message" => "User Added Successfully!");
                }
                else {
                    $ajax_response = array("status" => "failure", "message" => $this->lang->line('agent_error'));
                }
            }
        }
        echo postRequestResponse($ajax_response);
    }

    public function importTeamCSV() {
        $this->form_validation->set_rules('emp_group', 'Employee Group', 'required|trim');
        $this->form_validation->set_rules('emp_type', 'Employee Type', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            if (form_error('emp_group')) {
                $this->session->set_flashdata('emp_group', form_error('emp_group'));
            }
            if (form_error('emp_type')) {
                $this->session->set_flashdata('emp_type', form_error('emp_type'));
            }
        } else {
            $emp_group = $this->input->post('emp_group');
            $emp_type = $this->input->post('emp_type');
            $this->load->library('excel');
            $client_id = $this->client_id;
            if ($_FILES['userfile']['name'] != '') {
                $path = 'assets/upload/agent_roster/';
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'xlsx|xls';
                $config['remove_spaces'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userfile')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                }
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' . $e->getMessage());
                }
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $arrayCount = count($allDataInSheet);
                $flag = 0;
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $arrayCount = count($allDataInSheet);
                $flag = 0;
                $createArray = [
                    'employee_id',
                    'employee_name',
                    'employee_email',
                    'doj',
                    'lob',
                    'campaign',
                    'vendor',
                    'location',
                    'supervisior_id',
                    'supervisior_name'
                ];
                $makeArray = [
                    'employee_id' => 'employee_id',
                    'employee_name' => 'employee_name',
                    'employee_email' => 'employee_email',
                    'doj' => 'doj',
                    'lob' => 'lob',
                    'campaign' => 'campaign',
                    'vendor' => 'vendor',
                    'location' => 'location',
                    'supervisior_id' => 'supervisior_id',
                    'supervisior_name' => 'supervisior_name'
                ];
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            //$value = preg_replace('/\s+/', '', $value);
                            $SheetDataKey[trim($value)] = $key;
                        }
                    }
                }
                $data = array_diff_key($makeArray, $SheetDataKey);
                $agentInvalidCount = 0;
                if (empty($data)) {
                    $flag = 1;
                }

                // $ad = $this->common->getWhere('agent',['client_id'=>$client_id]);
                $ad = $this->common->getWhere('user', ['client_id' => $client_id, 'usertype !=' => 1]);
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $addresses = array();
                        $employee_id = $SheetDataKey['employee_id'];
                        $employee_name = $SheetDataKey['employee_name'];
                        $employee_email = $SheetDataKey['employee_email'];
                        $doj = $SheetDataKey['doj'];
                        $lob = $SheetDataKey['lob'];
                        $campaign = $SheetDataKey['campaign'];
                        $vendor = $SheetDataKey['vendor'];
                        $location = $SheetDataKey['location'];
                        $supervisior_id = $SheetDataKey['supervisior_id'];
                        $supervisior_name = $SheetDataKey['supervisior_name'];

                        $employee_id = filter_var(trim($allDataInSheet[$i][$employee_id]), FILTER_SANITIZE_STRING);
                        $employee_name = filter_var(trim($allDataInSheet[$i][$employee_name]), FILTER_SANITIZE_STRING);
                        $employee_email = filter_var(trim($allDataInSheet[$i][$employee_email]), FILTER_SANITIZE_EMAIL);
                        $doj = filter_var(trim($allDataInSheet[$i][$doj]), FILTER_SANITIZE_STRING);
                        $lob = explode(',', filter_var(trim($allDataInSheet[$i][$lob]), FILTER_SANITIZE_STRING));
                        $campaign = filter_var(trim($allDataInSheet[$i][$campaign]), FILTER_SANITIZE_STRING);
                        $vendor = filter_var(trim($allDataInSheet[$i][$vendor]), FILTER_SANITIZE_STRING);
                        $location = filter_var(trim($allDataInSheet[$i][$location]), FILTER_SANITIZE_STRING);
                        $supervisior_id = filter_var(trim($allDataInSheet[$i][$supervisior_id]), FILTER_SANITIZE_STRING);
                        $supervisior_name = filter_var(trim($allDataInSheet[$i][$supervisior_name]), FILTER_SANITIZE_STRING);

                        $agentInvalidCount = 0;
                        $lob_hierarchy_id = '';


                        $emp_data = [];
                        $d['u'] = $this->common->getDistinctWhereSelect('user', 'user_id', ['empid' => $supervisior_id, 'name' => $supervisior_name]);
                        // condition if employee ops or client and employee type agent requried fields
                        // requried => lob ,valid(supervisior_id,supervisior_name) 
                        if ($emp_group == 'client' && $emp_type == 'agent' && !empty($supervisior_id) && !empty($supervisior_name) && !empty($campaign) && !empty($vendor) && !empty($location) && !empty($d['u'])) {
                            $d['h'] = $this->common->getDistinctWhereSelect('hierarchy', 'hierarchy_id', ['lob' => implode(',', $lob), 'campaign' => $campaign, 'vendor' => $vendor, 'location' => $location, 'client_id' => $client_id]);
                            if (!empty($d['h'])) {
                                $lob_hierarchy_id = $d['h'][0]['hierarchy_id'];
                                $emp_data = [
                                    'client_id' => $client_id,
                                    'empid' => $employee_id,
                                    'name' => $employee_name,
                                    'user_email' => $employee_email,
                                    'lob' => implode('|||', $lob),
                                    'location' => $location,
                                    'doj' => date('Y-m-d', strtotime(str_replace('-', '/', $doj))),
                                    'sup_id' => $supervisior_id,
                                    'sup_name' => $supervisior_name,
                                    'user_created_date' => date('Y-m-d H:i:s'),
                                    'user_updated_date' => date('Y-m-d H:i:s'),
                                    'lob_hierarchy_id' => $lob_hierarchy_id,
                                    'usertype' => (($emp_type == "agent") ? 2 : 3),
                                    'is_admin' => (($emp_group == "client") ? '3' : '2')
                                ];
                            }
                        }
                        // condition if employee ops or client and employee type SUPERVISIOR requried fields
                        // requried => lob
                        else if (($emp_group == 'client' || $emp_group == 'ops') && $emp_type == 'supervisior' && !empty($lob)) {
                            $supervisior_id = '';
                            $supervisior_name = '';
                            $emp_data = [
                                'client_id' => $client_id,
                                'empid' => $employee_id,
                                'name' => $employee_name,
                                'user_email' => $employee_email,
                                'lob' => implode('|||', $lob),
                                'location' => $location,
                                'doj' => date('Y-m-d', strtotime(str_replace('-', '/', $doj))),
                                'sup_id' => $supervisior_id,
                                'sup_name' => $supervisior_name,
                                'user_created_date' => date('Y-m-d H:i:s'),
                                'user_updated_date' => date('Y-m-d H:i:s'),
                                'lob_hierarchy_id' => '',
                                'usertype' => (($emp_type == "agent") ? 2 : 3),
                                'is_admin' => (($emp_group == "client") ? '3' : '2'),
                                'status' => '1'
                            ];
                        }
                        // condition if employee client and employee type AGENT requried fields
                        // requried => lob(must be single i.e not comma seperated),campaign,vender,location,valid(supervisior_id,supervisior_name)						
                        else if (($emp_group == 'client' || $emp_group == 'ops') && $emp_type == 'agent' && !empty($lob) && !empty($supervisior_id) && !empty($supervisior_name && !empty($d['u']))) {
                            $d['h'] = $this->common->getWhereInWhereSelectAll('hierarchy', 'hierarchy_id', ['campaign' => $campaign, 'vendor' => $vendor, 'location' => $location, 'client_id' => $client_id], 'lob', $lob);
                            $emp_data = [
                                'client_id' => $client_id,
                                'empid' => $employee_id,
                                'name' => $employee_name,
                                'user_email' => $employee_email,
                                'lob' => implode('|||', $lob),
                                'location' => $location,
                                'doj' => date('Y-m-d', strtotime(str_replace('-', '/', $doj))),
                                'sup_id' => $supervisior_id,
                                'sup_name' => $supervisior_name,
                                'user_created_date' => date('Y-m-d H:i:s'),
                                'user_updated_date' => date('Y-m-d H:i:s'),
                                'lob_hierarchy_id' => '',
                                'usertype' => (($emp_type == "agent") ? 2 : 3),
                                'is_admin' => (($emp_group == "client") ? '3' : '2')
                            ];
                            $agentInvalidCount++;
                        } else {
                            $emp_data = [];
                        }
                        if ((int) $this->subscriptionAgent >= count($ad) && !is_infinite($this->subscriptionAgent)) {
                            $sql1 = $this->common->getWhere('user', ['empid' => $employee_id, 'client_id' => $client_id, 'user_email' => $employee_email]);
                            //print_r($sql1);
                            if (count($sql1) > 0) {
                                if (!empty($emp_data)) {
                                    $status = (((int) $sql1[0]->status == 1) ? '1' : '0');
                                    $emp_data['status'] = $sql1[0]->status;
                                    $updateData = $emp_data;
                                    $this->common->update_data('user', $updateData, ['empid' => $employee_id, 'client_id' => $client_id]);
                                }
                            } else {
                                if (!empty($emp_data)) {
                                    $emp_data['status'] = '1';
                                    $emp_data['user_password'] = password_hash($this->config->item('default_password'), PASSWORD_BCRYPT, ['cost' => $this->config->item('cost')]);
                                    $emp_data['is_first_login'] = '1';
                                    $insertData = $emp_data;
                                    $this->common->insert_data($insertData, 'user');
                                    // $data['user_email'=>$employee_email];
                                    // $body = $this->load->view('email_template/team_creation',$data,true);
                                    // send_email($employee_email,'Login Credentials',$body);
                                }
                            }
                            $this->session->set_flashdata('message', 'Agent Added Successfully!');
                        } else if (is_infinite($this->subscriptionAgent)) {
                            $sql1 = $this->common->getWhere('user', ['empid' => $employee_id, 'client_id' => $client_id]);
                            if (count($sql1) > 0) {
                                if (!empty($emp_data)) {
                                    $emp_data['status'] = $sql1[0]->status;
                                    $updateData = $emp_data;
                                    $this->common->update_data('user', $updateData, ['empid' => $employee_id, 'client_id' => $client_id]);
                                }
                            } else {
                                if (!empty($emp_data)) {
                                    $emp_data['status'] = '1';
                                    $emp_data['user_password'] = password_hash($this->config->item('default_password'), PASSWORD_BCRYPT, ['cost' => $this->config->item('cost')]);
                                    $emp_data['is_first_login'] = '1';
                                    $insertData = $emp_data;
                                    $this->common->insert_data($insertData, 'user');
                                    // $data['user_email'=>$employee_email];
                                    // $body = $this->load->view('email_template/team_creation',$data,true);
                                    // send_email($employee_email,'Login Credentials',$body);
                                }
                            }
                            //echo $this->db->last_query();die;
                            $this->session->set_flashdata('message', 'Agent Added Successfully!');
                        } else {
                            $this->session->set_flashdata('error', $this->lang->line('agent_error'));
                        }
                    }
                    unlink($inputFileName);
                    //die;
                    redirect('team', 'refresh');
                } else {
                    $this->session->set_flashdata('error', '<div class="alert alert-success text-center">Please Upload correct file</div>');
                    // echo "Please import correct file";
                    redirect('team', 'refresh');
                }
            }
        }
    }

    public function editTeam($id) {
        $data['user_id'] = $id;
        $id = decode($id);
        
        //GETTING DETAILS OF USER
        $data['team'] = $this->common->getWhereSelectAll('user', ['name', 'empid', 'usertype', 'lob_hierarchy_id', 'sup_id', 'sup_name', 'lob', 'is_admin', 'user_email', 'doj'], ['client_id' => $this->client_id, 'is_admin !=' => 1, 'user_id' => $id]);
        if (!empty($data['team'])) {
            
            // ALL LOB LIST
            $data['all_lob'] = $this->common->getSelectAll('hierarchy', 'lob');
            
            //(FOR AGENT) SUPERVISOR ID, NAME, EMAIL
            $data['sup_id'] = (!empty($data['team'][0]->sup_id) ? $data['team'][0]->sup_id : '');
            $data['sup_name'] = (!empty($data['team'][0]->sup_name) ? $data['team'][0]->sup_name : '');
            
            if (!empty($data['sup_id'])) {
                $sup_data = $this->common->getWhereSelectAll('user', ['user_email'], ['empid' => $data['team'][0]->sup_id]);
                $data['sup_email'] = (!empty($sup_data[0]->user_email) ? $sup_data[0]->user_email : '');
            }
            
            //ALL SUPERVISOR LIST
            $sup_opt = '';
            if ($data['team'][0]->is_admin == 3) {
                // FOR CLIENT
                $sup_drpdwn = $this->common->getWhereSelectAll('user', ['name', 'empid'], ['status' => '1', 'usertype' => 3, 'is_admin' => '3']);
                foreach ($sup_drpdwn as $key => $value) {
                    $sup_opt .= "<option value='{$value->empid}'" . (($data['sup_id'] == $value->empid) ? 'selected' : '') . " >{$value->name}</option>";
                }
            } else if ($data['team'][0]->is_admin == 2) {
                // FOR OPS
                $sup_drpdwn = $this->common->getWhereSelectAll('user', ['name', 'empid'], ['status' => '1', 'usertype' => 3, 'is_admin' => '2']);
                foreach ($sup_drpdwn as $key => $value) {
                    $sup_opt .= "<option value='{$value->empid} " . (($data['sup_id'] == $value->empid) ? 'selected' : '') . "'>{$value->name}</option>";
                }
            } else {
                $sup_opt .= "<option value=''>No data Found</option>";
            }
            $data['supervisor_data'] = $sup_opt;
            
            //GETTING THE DETAILS OF CLIENT >> AGENT (CAMPAIGN, VENDOR, LOCATION)
            $div = '';
            $data['hierarchy_id'] = (!empty($data['team'][0]->lob_hierarchy_id) ? $data['team'][0]->lob_hierarchy_id : '');
            if (!empty($data['hierarchy_id'])) {
                $lob = $this->common->getWhereSelectAll('hierarchy', ['hierarchy_id', 'vendor', 'location', 'campaign'], ['lob' => $data['team'][0]->lob]);
                
                foreach ($lob as $key => $value) {
                    $div .= "<div class='row lob_choose_row'><div class='lob_choose_option'>";
                    $div .= "<label><input type='radio' name='lob_h_data' class='browser-default' " . (($data['hierarchy_id'] == $value->hierarchy_id) ? 'checked' : '') . " value='{$value->hierarchy_id}'><span></span></label>";
                    $div .= "</div>";

                    $div .= "<div class='input-field col s4'>";
                    $div .= "<input class='lob_data' type='text' name='campaign' value='{$value->campaign}' readonly><label for='Campaign'>Campaign</label>";
                    $div .= "</div>";

                    $div .= "<div class='input-field col s4'>";
                    $div .= "<input class='lob_data' type='text'  name='vendor' value='{$value->vendor}' readonly><label for='Vendor'>Vendor</label>";
                    $div .= "</div>";

                    $div .= "<div class='input-field col s4'>";
                    $div .= "<input class='lob_data' type='text' name='location' value='{$value->location}' readonly><label for='Location'>Location</label>";
                    $div .= "</div></div>";
                }
            }
            $data['lob_hierarchy_data'] = $div;
            $data['empty'] = false;
        } else {
            $data['empty'] = true;
        }
        $this->load->view('agent/edit_team', $data);
    }

    public function updateTeam() {
        $post_data = $this->input->post();
        
        $this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
        $this->form_validation->set_rules('user_group', 'User Group', 'required|trim');
        $this->form_validation->set_rules('user_type', 'User Type', 'required|trim');
        $this->form_validation->set_rules('lob[]', 'LOB', 'required|trim');
        
        if (isset($post_data['user_type']) && isset($post_data['user_group'])) {
            if ($post_data['user_group'] == 'client' && $post_data['user_type'] == 'agent') {
                $this->form_validation->set_rules('lob_h_data', 'LOB Hierarchy', 'required');
            }
            if ($post_data['user_type'] != "supervisor") {
                $this->form_validation->set_rules('supervisor_id', 'Supervisor ID', 'required|trim');
                $this->form_validation->set_rules('supervisor_name', 'Supervisor Name', 'required|trim');
            }
        }
        $this->form_validation->set_rules('user_name', 'User Name', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $ajax_response = array("status" => "failure", "message" => array_values($this->form_validation->error_array())[0]);
        } else {     
            $lob         = implode('|||', $post_data['lob']);
            $lob_h_data  = ((!empty($post_data['lob_h_data'])) ? $post_data['lob_h_data'] : NULL); // if user_group is client and user_type is agent 
            $supervisor  = ((!empty($post_data['supervisor_id'])) ? $post_data['supervisor_id'] : NULL); // if user_type not supervisor 
            $sup_name    = ((!empty($post_data['supervisor_name'])) ? $post_data['supervisor_name'] : '');
            $sup_email   = ((!empty($post_data['supervisor_email'])) ? $post_data['supervisor_email'] : '');
            $user_name   = $post_data['user_name'];
            
            $data = [
                'name'              => $user_name,
                'sup_id'            => $supervisor,
                'sup_name'          => $sup_name,
                'sup_email'         => $sup_email,
                'lob'               => $lob,
                'lob_hierarchy_id'  => $lob_h_data,
                'user_updated_date' => date('Y-m-d H:i:s'),
            ];

            $this->common->update_data('user', ['lob' => ''], ['user_id' => decode($post_data['user_id'])]);
            $this->common->update_data('user', $data, ['user_id' => decode($post_data['user_id'])]);
            $ajax_response = array("status" => "success", "message" => "Team updated Successfully!");
        }
        echo postRequestResponse($ajax_response);
    }

    public function getUserFormDetails() {
        $lob_data = urldecode($this->input->post('userid'));
        $lob_data = explode(',', $lob_data);
        $forms_details = $this->common->getWhereInSelectAll('forms_details', ['form_name', 'form_version', 'form_status', 'lob', 'channels'], 'lob', $lob_data);
        
        $csrfTokenName = $this->security->get_csrf_token_name();
        $csrfHash = $this->security->get_csrf_hash();
        $data = [
            'csrfTokenName' => $csrfTokenName,
            'csrfHash' => $csrfHash,
            'data' => $forms_details
        ];
        echo json_encode($data);
    }
    
    public function getUserDetails() {
        
        $user_id = decode($this->input->post('userId'));
        $arr1 = $this->common->getDistinctWhereSelectRow('user',['name', 'empid', 'usertype', 'user_email', 'doj', 'sup_id', 'sup_name', 'lob', 'lob_hierarchy_id', 'profile_img', 'is_admin'],['user_id' => $user_id]);
        
        $hierarchy_id = $arr1->lob_hierarchy_id;
        if(!empty($hierarchy_id)) {
            $arr2 = $this->common->getDistinctWhereSelectRow('hierarchy',['campaign', 'vendor', 'location'],['hierarchy_id' => $hierarchy_id]);
        }

        $user_group = ($arr1->is_admin == 2)?'Ops':'Client';
        $user_type = ($arr1->usertype == 2)?'Agent':'Supervisor';
        $lob = ltrim(implode(', ',explode('|||',$arr1->lob)),', ');
        $doj = date('d-M-Y', strtotime($arr1->doj));
        
        $html = "
        <tr>
            <th>User Group</th>
            <td>{$user_group}</td>
        </tr>
        
        <tr>
            <th>User Type</th>
            <td>{$user_type}</td>
        </tr>
        
        <tr>
            <th>LOB</th>
            <td>{$lob}</td>
        </tr>";
        
        if($user_type == 'Agent') {
            $html.="
            <tr>
                <th>Supervisor ID</th>
                <td>{$arr1->sup_id}</td>
            </tr>
            
            <tr>
                <th>Supervisor Name</th>
                <td>{$arr1->sup_name}</td>
            </tr>";
        }
        
        if($user_group == 'Client' && $user_type == 'Agent') {
            $html.="<tr><th>Campaign</th><td>{$arr2->campaign}</td></tr>
            <tr><th>Vendor</th><td>{$arr2->vendor}</td></tr>
            <tr><th>Location</th><td>{$arr2->location}</td></tr>";
        }
            
        $html.="<tr><th>Name</th><td>{$arr1->name}</td></tr>
        <tr><th>User ID</th><td>{$arr1->empid}</td></tr>
        <tr><th>User Email</th><td>{$arr1->user_email}</td></tr>
        <tr><th>DOJ</th><td>{$doj}</td></tr>";
        
        echo postRequestResponse($html);
    }

    public function isSupervisor() {
        $data = $this->common->getWhereSelectAll('user', 'user_id', ['usertype' => '3', 'status' => '1']);
        echo postRequestResponse(count($data));
    }
    
    public function date_check($str){
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $str)) {
            $this->form_validation->set_message('date_check', 'The %s field must be yyyy/mm/dd');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
