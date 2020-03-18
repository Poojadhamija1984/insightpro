<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DumpController extends MY_Controller {
	
	public function index()
	{
			
	 if($this->industry_type == "bpo") {
		if(($this->emp_group == "client" || $this->emp_group == "ops") && ($this->emp_type == "agent" || $this->emp_type == "supervisor")){
	       
			//$data['form_name'] = $this->common->getDistinctWhereSelect('forms_details','form_name',['client_id'=>$this->client_id]);
			//$data['channels'] = channels();
			//$data['lob'] = $this->common->getDistinctWhereSelect('forms_details','lob',['client_id'=>$this->client_id]);
			// echo '<pre>';
			// print_r($data['lob']);
			// echo '<pre>';die;
			if($this->input->post())
			{
				
				$this->form_validation->set_rules('fromdate', 'From Date', 'required|trim');
				$this->form_validation->set_rules('todate', 'To Date', 'required|trim');
				//$this->form_validation->set_rules('form_name', 'Form name', 'required|trim');
				$this->form_validation->set_rules('form_version', 'From Version', 'required|trim');
				
				if ($this->form_validation->run() == FALSE) { 
					$this->load->view('dump_view');
				}
				else{
					$fromdate 		= $this->input->post('fromdate');
					$todate 		= $this->input->post('todate');
					$form_name 		= strtolower((explode('_V_' , $this->input->post('form_version')))[0]);
					$form_version 	= (explode('_V_' , $this->input->post('form_version')))[1];
					//$form_version 	= ltrim(rtrim($this->input->post('form_version'),'.0'),'v');
					$lob 			= $this->input->post('lob');
					$channels 		= $this->input->post('channels');
					
					$result = $this->dump_model->get_dump($fromdate,$todate,$form_name,$form_version,$lob,$channels);
					// echo '<pre>';
					// print_r($result);
					// echo '</pre>';die;

					$delimiter = ",";  // pipe delimited 
					$newline = "\r\n";
					$enclosure = '"';
					$this->load->dbutil(); // call db utility library
					$this->load->helper('download'); // call download helper
					$filename = $form_name.'.csv'; // name of csv file to download with data
					force_download($filename, $this->dbutil->csv_from_result($result, $delimiter, $newline, $enclosure)); // download file
					redirect('dump', 'refresh');
					//echo postRequestResponse('test');

				}
				//echo "HIIIIIOO";exit;
			}
			else {
				
				$this->load->view('dump_view');
			}
		}
        else{
        	$data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);	
        }
/*
****************** code end for bpo orgnization 
*/
    } else {
         
    	/// below code start or non bpo orgnization 
       if($this->emp_group == "reviewer"){
       	     $site = $this->session->userdata('site');
                $sqlQuery = 'SELECT  `s_name` ,`s_id` FROM `sites` WHERE `s_id` IN ('.$site.')';
                $data['sites'] = $this->db->query($sqlQuery)->result();
			if($this->input->post())
			{
				$this->form_validation->set_rules('fromdate', 'From Date', 'required|trim');
				$this->form_validation->set_rules('todate', 'To Date', 'required|trim');
				$this->form_validation->set_rules('tepmlates', 'Tepmlates', 'required|trim');
				
				if ($this->form_validation->run() == FALSE) { 
					$this->load->view('other/non_bpo_dump_view',$data);
				}
				else{
					$fromdate 		= $this->input->post('fromdate');
					$todate 		= $this->input->post('todate');
					$tepmlates 		= $this->input->post('tepmlates');
					$result = $this->dump_model->get_dumpData($fromdate,$todate,$tepmlates);
					// echo '<pre>';
					// print_r($result);
					// echo '</pre>';die;

					$delimiter = ",";  // pipe delimited 
					$newline = "\r\n";
					$enclosure = '"';
					$this->load->dbutil(); // call db utility library
					$this->load->helper('download'); // call download helper
					//$filename = $tepmlates.'.csv'; // name of csv file to download with data
					$filename = substr($tepmlates,18).'_'.date('Y-m-d').'.csv';// name of csv file to download with data
					force_download($filename, $this->dbutil->csv_from_result($result, $delimiter, $newline, $enclosure)); // download file
					redirect('dump', 'refresh');
					//echo postRequestResponse('test');

				}
				//echo "HIIIIIOO";exit;
			}
			else {
				
				$this->load->view('other/non_bpo_dump_view',$data);
			}
		}
        else{
        	$data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);	
        }

    } ///end code for non bpo orgnization 
     
		
}
	
 public function get_templates()
    {
        //$client_id = $this->session->userdata('client_id');
        $siteID = $this->input->post('site_id');
        if($siteID == 'All' || $siteID == '')  
        {
            $siteID = '';
            $reasult_version = '';
         
        }
        else {
           
            // $reasult_version  = $this->common->getDistinctWhereSelectOderby('forms_details','form_version',['form_name'=>($form_name[0]['form_name'])],'form_version','DESC');
            $sqlQuery  ="SELECT  tmp_name,tb_name  FROM  template_details   WHERE  FIND_IN_SET(".$siteID.",site_id) and temp_status='1'";
            $reasult_version = $this->db->query($sqlQuery)->result_array();
        }  
        echo postRequestResponse(['tempDetails'=>$reasult_version]);
    }



//please write above	
}
