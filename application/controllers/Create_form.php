<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_form extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->lang->load('subscription_lang','subscription');
	}

	public function index() {
	    $data['title']  = 'Form Upload';
		//get page ID
		$clname = 'create_form';
        $data['form_name'] = $this->common->getDistinctWhereSelect('forms_details','form_name',['client_id'=>$this->client_id]);
        $data['lob'] = $this->common->getDistinctWhereSelect('hierarchy','lob',['client_id'=>$this->client_id]);
        $data['channels'] = channels();
        $data['form_data'] =  $this->common->getAllData('forms_details');
		$this->load->view('admin/create_form_view' , $data);
	}
    
	public function forms_list() {
        if($this->emp_group == "ops" && $this->emp_type == "supervisor"){
    	    // $data['title']  = 'Form List';
    		// //get page ID
    		// $clname = 'create_form';
            // $data['form_name'] = $this->common->getDistinctWhereSelect('forms_details','form_name',['client_id'=>$this->client_id]);
            // $data['lob'] = $this->common->getDistinctWhereSelect('hierarchy','lob',['client_id'=>$this->client_id]);
            // $data['channels'] = channels();
            $data['form_data'] =  $this->common->getAllData('forms_details');
           // $this->print_result($data['form_data'] );
    		$this->load->view('admin/forms_list_view' , $data);
        }
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);   
        }
	}
    
	public function formVersion() {
       $form_name = $this->input->post('form_name');
        $reasult_lob =$this->common->getDistinctWhereSelect('forms_details','lob',['client_id'=>$this->client_id,'form_name'=>$form_name]);
        $reasult_version = $this->common->getMaxWhere('forms_details','form_version',array('form_name' => $form_name, 'client_id' =>$this->client_id));
        
        $csrfTokenName = $this->security->get_csrf_token_name();
        $csrfHash = $this->security->get_csrf_hash();
        $data = [
                    'csrfTokenName'=>$csrfTokenName,
                    'csrfHash'=>$csrfHash,
                    'data'=>['lob'=>$reasult_lob,'version'=>$reasult_version]
                ];
        echo json_encode($data);
    }
	
    // import excel data
    public function import() {
         // echo $form_version =  ltrim(rtrim($this->input->post('form_version'),'.0'),'v');
        $data['title']  = 'Create Form';
        $this->form_validation->set_rules('form_name', 'Form Name', 'required|trim');
        $this->form_validation->set_rules('form_version', 'Form Version', 'required|trim');
        $this->form_validation->set_rules('form_attributes', 'Attributes', 'required|trim|numeric|greater_than[10]|less_than[30]|max_length[30]');
        if ($this->form_validation->run() == FALSE) { 
            // echo "error";die();
             $this->load->view('admin/create_form_view' , $data);
        } 
        else {
       
            $this->load->library('excel');
            if ($this->input->post('importfile') && $_FILES['userfile']['name'] != '') {
                if(!is_dir('./assets/upload/agent_roster')){
                    mkdir('./assets/upload/agent_roster',0777, TRUE);
                    // chmod("$folderPath", 0777);
                }
                $path = 'assets/upload/agent_roster/';
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'xlsx|xls';
                $config['remove_spaces'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userfile')) {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
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

                if($arrayCount-1 != $this->input->post('form_attributes')){
                    $this->session->set_flashdata('error', '<div class="alert alert-success text-center">Attributes number diffrent from details</div>');
                    redirect('create_form', 'refresh');
                }

                $flag = 0;
                $createArray =  [
                                'category',
                                'attribute', 
                                'rating',
                                'weightage',
                                'scorable'
                                ];
                                

                $makeArray = [
                            'category' => 'category', 
                            'attribute' => 'attribute', 
                            'rating' => 'rating',
                            'weightage' => 'weightage',
                            'scorable' => 'scorable'
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
            
                if (empty($data)) {
                    $flag = 1;
                }
                if ($flag == 1) {
                    $weightage_cal = 0;
                    $flag_check_cat = ''; $catcount = 0;
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $addresses = array();
                        $category = $SheetDataKey['category'];
                        //$cat_id = $SheetDataKey['cat_id'];
                        $attribute = $SheetDataKey['attribute'];
                        //$attr_id = $SheetDataKey['attr_id'];
                        $rating = $SheetDataKey['rating'];
                        $weightage = $SheetDataKey['weightage'];
                        $scorable = $SheetDataKey['scorable'];
                        $category = filter_var(trim($allDataInSheet[$i][$category]), FILTER_SANITIZE_STRING);
                        //$cat_id = filter_var(trim($allDataInSheet[$i][$cat_id]), FILTER_SANITIZE_STRING);
                        $attribute = filter_var(trim($allDataInSheet[$i][$attribute]), FILTER_SANITIZE_STRING);
                        //$attr_id = filter_var(trim($allDataInSheet[$i][$attr_id]), FILTER_SANITIZE_STRING);
                        $rating = filter_var(trim($allDataInSheet[$i][$rating]), FILTER_SANITIZE_STRING);
                        $weightage= filter_var(trim($allDataInSheet[$i][$weightage]), FILTER_SANITIZE_STRING);
                        $scorable = filter_var(trim($allDataInSheet[$i][$scorable]), FILTER_SANITIZE_STRING);
                        
                        if($flag_check_cat != $category)
                        {
                            ++$catcount;
                            $flag_check_cat = $category;
                        }
                    
                        $att_name = '';  $i<=10?$att_name = '0'.($i-1):$att_name = ($i-1);
                        //prepare data for forms table.... 
                        $fetchData[] = [
                                        'client_id' => $this->session->userdata('client_id') ? $this->session->userdata('client_id') : '8',
                                        'form_name' => strtolower($this->input->post('form_name')),
                                        'form_version' => ltrim(rtrim($this->input->post('form_version'),'.0'),'v'),
                                        'lob' => $this->input->post('lob'), 
                                        'channels' => $this->input->post('channels'), 
                                        'category' => $category, 
                                        'cat_id' => 'cat'.$catcount, 
                                        'cat_id' => 'cat'.$catcount, 
                                        'attribute' => $attribute, 
                                        'attr_id' => 'att'.$att_name.'_sel', 
                                        'rating' => $rating,
                                        'weightage' => $weightage,
                                        'scorable' => $scorable,
                                        ];
                        $weightage_cal  += $weightage ;
                        
                    }   
                    
                    
                    /// prepare data for form_details table
                    $formsdataarray = [
                        'form_name' => strtolower($this->input->post('form_name')), //form_name
                        'form_attributes' => $this->input->post('form_attributes'), // total no of form attributes
                        'form_version' => ltrim(rtrim($this->input->post('form_version'),'.0'),'v'), // form version
                        'lob' => $this->input->post('lob'),
                        'channels' => $this->input->post('channels'),
                        'pass_rate' => $this->input->post('pass_rate'),
                        'form_weightage' => $weightage_cal,
                        'client_id' => $this->session->userdata('client_id') ? $this->session->userdata('client_id') : '8',
                        'tb_name' => strtolower($this->input->post('form_name'))
                    ];

                    /// prepare array for No of cat  colums in form table Rajesh
                    $fields = array();
                    $fields_for_escalation = array();
                    $cat_colums = array();
                    for($i=1;$i<=10;$i++){
                        $cat_colums['cat'.$i] = array('type' => 'VARCHAR', 'constraint' => '100');
                    }   
                    /// prepare array for No of  attributes  colums in form table Rajesh
                    for($i=1;$i<=30;$i++){
                        $att_name = '';  $i<10?$att_name = '0'.$i:$att_name = $i;
                        $fields['att'.$att_name.'_score'] = array('type' => 'VARCHAR', 'constraint' => '100');
                        $fields['att'.$att_name.'_sel'] = array('type' => 'VARCHAR','constraint' => '100');
                        $fields['att'.$att_name.'_com'] = array('type' =>'text');
                        $fields_for_escalation['att'.$att_name.'_com'] = array('type' =>'text');
                    }
                    /// create dynamic  tables for Forms, ATA, Calibratin  escalation
                    if($formsdataarray['form_version'] == 1)
                    {
                        /// create dynamic  tables for Forms 
                        $this->db->query('CREATE TABLE '.$formsdataarray['tb_name'].' LIKE sample_form');
                        $this->load->dbforge();
                        $this->dbforge->add_column($formsdataarray['tb_name'],$fields);
                        $this->dbforge->add_column($formsdataarray['tb_name'],$cat_colums);
                        /// create dynamic  tables for  Calibratin 
                        $this->db->query('CREATE TABLE calibration_'.$formsdataarray['tb_name'].' LIKE sample_form');
                        $this->dbforge->add_column('calibration_'.$formsdataarray['tb_name'],$fields);
                        $this->dbforge->add_column('calibration_'.$formsdataarray['tb_name'],$cat_colums);
                        $calibration_colums['calibration_by'] = array('type' => 'VARCHAR', 'constraint' => '255');
                        $calibration_colums['emp_group'] = array('type' => 'VARCHAR', 'constraint' => '255');
                        $calibration_colums['emp_type'] = array('type' => 'VARCHAR', 'constraint' => '255');
                        $calibration_colums['calibration_date'] = array('type' => 'date');
                        $calibration_colums['calibration_time'] = array('type' => 'time');
                        $calibration_colums['calibration_status'] =array('type' => 'enum', 'constraint' => ['0','1'],'default' => '0');
                        //$calibration_colums['calibration_status'] =array('type' => 'enum', 'constraint' => '0,1','default' => '0');
                        $this->dbforge->add_column('calibration_'.$formsdataarray['tb_name'],$calibration_colums);
                        /// create dynamic  tables for  ATA
                        $this->db->query('CREATE TABLE ata_'.$formsdataarray['tb_name'].' LIKE sample_form');
                        $this->dbforge->add_column('ata_'.$formsdataarray['tb_name'],$fields);
                        $this->dbforge->add_column('ata_'.$formsdataarray['tb_name'],$cat_colums);
                        $ata_colums['ata_by'] = array('type' => 'VARCHAR', 'constraint' => '255');
                        $ata_colums['emp_group'] = array('type' => 'VARCHAR', 'constraint' => '255');
                        $ata_colums['ata_date'] = array('type' => 'datetime');
                        $ata_colums['ata_status'] =array('type' => 'enum', 'constraint' => ['0','1'],'default' => '0');
                        $this->dbforge->add_column('ata_'.$formsdataarray['tb_name'],$ata_colums);
                        /// create dynamic  tables for  ESCALATION

                        $this->db->query('CREATE TABLE escalation_'.$formsdataarray['tb_name'].' LIKE sample_escalation_form');
                        $this->dbforge->add_column('escalation_'.$formsdataarray['tb_name'],$fields_for_escalation);
                        $this->dbforge->add_column('escalation_'.$formsdataarray['tb_name'],$cat_colums);
                        $escalation_colums['escalation_by'] = array('type' => 'VARCHAR', 'constraint' => '255');
                        $escalation_colums['escalation_date'] = array('type' => 'datetime');
                        $escalation_colums['escalation_status'] =array('type' => 'enum', 'constraint' => ['0','1'],'default' => '0');
                        $this->dbforge->add_column('escalation_'.$formsdataarray['tb_name'],$escalation_colums);
                    }
                    $this->db->insert("forms_details",$formsdataarray);
                    $this->db->insert_batch("forms",$fetchData);	
                     $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Form Uploaded successfully');
                     unlink($inputFileName);
                    redirect('forms-list', 'refresh');
                } else {
                    $this->session->set_flashdata('error', '<div class="alert alert-success text-center">Please Upload correct file</div>');
                redirect('create_form', 'refresh');
                }
            }
            $this->session->set_flashdata('error', '<div class="alert alert-danger text-center">Something Went Wrong file not uploaded.</div>');
            redirect('create_form', 'refresh');
        }
    }

    public function changeFormStatus() {
        $client_id = $this->session->userdata('client_id');
        $form_id = $this->input->post('form_id');
        $data['form_status'] = $this->input->post('form_status');
        $reasult =$this->common->update_data('forms_details',$data,['form_id'=>$form_id,'client_id'=>$client_id]);
        $csrfTokenName = $this->security->get_csrf_token_name();
        $csrfHash = $this->security->get_csrf_hash();
        $data = [
                    'csrfTokenName'=>$csrfTokenName,
                    'csrfHash'=>$csrfHash,
                    'data'=>(($reasult !="not updated")?'Success':'Try Again')                           
                ];
        echo json_encode($data);
       // $this->common->update_data('role',['status'=>$status],['id'=>$id]);
    }

    public function form_details() {
        $client_id = $this->session->userdata('client_id');
        $form_name = $this->input->post('form_name');
        if($form_name == 'add_new_form')
        {
            $reasult_lob_formdetails =$this->common->getDistinctWhereSelect('forms_details','lob',['client_id'=>$this->client_id]);
            $reasult_lob_fhierarchy =$this->common->getDistinctWhereSelect('hierarchy','lob',['client_id'=>$this->client_id]);
            $reasult_lob = [];
            $reasult_version = 1;
            foreach ($reasult_lob_fhierarchy as $key => $value) {
                if(!in_array($value['lob'], array_column($reasult_lob_formdetails, 'lob'))) { // search value in the array
                    //echo "NOT FOUND";
                    $reasult_lob[]['lob'] = $value['lob'];
                }
            }
        }
        else {     
            $reasult_lob =$this->common->getDistinctWhereSelect('forms_details','lob',['client_id'=>$this->client_id,'form_name'=>$form_name]);
            $reasult_version =$this->common->getDistinctWhereSelect('forms_details','form_version',['client_id'=>$this->client_id,'form_name'=>$form_name]);
        }
       // 'data'=>['lob'=>$reasult_lob,'version'=>$reasult_version]
      echo postRequestResponse(['lob'=>$reasult_lob,'version'=>$reasult_version]);
    }

    public function get_details() {
        $client_id = $this->session->userdata('client_id');
        $post_column_name  = $this->input->post('post_column_name');
        $post_column_value = $this->input->post('post_column_value');
        $get_detail_column_name = $this->input->post('get_detail_column_name');
            
        $reasult_post_column = $this->common->getDistinctWhereSelect('forms_details',$get_detail_column_name,['client_id'=>$this->client_id,$post_column_name=>$post_column_value]);
        $reasult_version     = $this->common->getDistinctWhereSelect('forms_details','form_version',['client_id'=>$this->client_id,$post_column_name=>$post_column_value]);
        
       // 'data'=>['lob'=>$reasult_lob,'version'=>$reasult_version]
      echo postRequestResponse(['get_column_name'=>$reasult_post_column,'version'=>$reasult_version]);
    }
    
    public function form_versions() {
        $client_id = $this->session->userdata('client_id');
        $post_column_name  = $this->input->post('post_column_name');
        $post_column_value = $this->input->post('post_column_value');
        if($post_column_value == 'All' || $post_column_value == '')  
        {
            $post_column_value = '';
            $form_name[0]['form_name'] = '';
            $reasult_version = '';
            $reasult_channel = '';
        }
        else {
            $form_name        = $this->common->getDistinctWhereSelect('forms_details','form_name',[$post_column_name=>$post_column_value]);
            if(!empty($form_name[0]['form_name']))
            {
                $reasult_version  = $this->common->getDistinctWhereSelectOderby('forms_details','form_version',['form_name'=>($form_name[0]['form_name'])],'form_version','DESC');
                $reasult_channel  = $this->common->getDistinctWhereSelectOderby('forms_details','channels',['form_name'=>($form_name[0]['form_name'])],'form_version','DESC');
               $form_nameshow = ucwords($form_name[0]['form_name']);
            }
            else {
                $reasult_version  = [];
                $reasult_channel  = [];
                $form_nameshow = '';
            }
                
        } 
        
        echo postRequestResponse(['form_name'=>$form_nameshow,'version'=>$reasult_version,'channels'=>$reasult_channel]);
    }
    
    public function get_category() {
        $lob  = $this->input->post('lob');
        $form_version = $this->input->post('form_version');
        
            $form_name        = $this->common->getDistinctWhereSelect('forms_details','form_name',['lob'=>$lob,'form_version'=>$form_version]);
            $category = [];
            if(!empty($form_name[0]['form_name'])){
                $category        = $this->common->getDistinctWhereSelect('forms','category',['form_name'=>$form_name[0]['form_name'] ,'lob'=>$lob,'form_version'=>$form_version]);
            }
        echo postRequestResponse(['category'=>$category]);
    }
    
    public function get_attributes() {
        $lob  = $this->input->post('lob');
        $form_version = $this->input->post('form_version');
        $form_category  = $this->input->post('form_category');
        
            $form_name        = $this->common->getDistinctWhereSelect('forms_details','form_name',['lob'=>$lob,'form_version'=>$form_version]);
            $attribute =[];
            if(!empty($form_name[0]['form_name'])){
                $attribute        = $this->common->getDistinctWhereSelect('forms',['attr_id','attribute'],['form_name'=>$form_name[0]['form_name'] ,'lob'=>$lob,'form_version'=>$form_version,'category'=>$form_category]);
            }
        echo postRequestResponse(['attribute'=>$attribute]);
    }

    public function unique_form_check() {
        $flagform_name_ubique =  $this->common->getWhereSelectDistinctCount('forms_details','form_name',['form_name'=>$this->input->post('form_name')]); 
        if (((int)$flagform_name_ubique) >= 1) { 
            echo postRequestResponse('error');
        }
        else{
            echo postRequestResponse('success');
        }
    }

    public function subscriptionEvaFormVersion_count_check() {

        $evaForm_count =  $this->common->getSelectAll('forms_details',['COUNT(DISTINCT form_name) AS form_name' , 'COUNT(form_version) AS form_version'],'form_name');
            
        $form_name_check = (!empty((int)$evaForm_count[0]->form_name))?(int)$evaForm_count[0]->form_name:0;
        $form_version_check = (!empty((int)$evaForm_count[0]->form_version))?(int)$evaForm_count[0]->form_version:0;
        if(((int)$this->subscriptionEvaFormVersion > $form_version_check) && !is_infinite($this->subscriptionEvaForm) && !is_infinite($this->subscriptionEvaFormVersion)){
            echo postRequestResponse('success');
        }
        else if(((int)$this->subscriptionEvaFormVersion > $form_version_check) && is_infinite($this->subscriptionEvaForm) && !is_infinite($this->subscriptionEvaFormVersion)){
            echo postRequestResponse('success');
        }
        else if(is_infinite($this->subscriptionEvaFormVersion) && is_infinite($this->subscriptionEvaForm)){
            echo postRequestResponse('success');
        }
        else {
                echo postRequestResponse($this->lang->line('version_error'));
        }
    }

    public function edit_form($form_name,$form_version,$form_unique_id) {
        if($this->emp_group == "ops" && $this->emp_type == "supervisor"){
    	    $data['title']  = 'Form Edit';
            $data['current_form_version']    = $form_version;
            $data['channels']                = channels();
            $data['last_form_version']       = $this->common->getDistinctWhereSelectOderbyLimt('forms_details',['form_version'],['client_id'=>$this->client_id,'form_name'=>$form_name],'form_version','DESC',1);
            $data['form_unique_id']          = $form_unique_id;
            $data['form_info']               =  $this->common->getDistinctWhereSelect('forms_details','*',['form_name'=>$form_name,'form_version'=>$form_version]);
            $data['form_data']               =  $this->common->getDistinctWhereSelect('forms',['category','attribute','rating','rating_attr_name','weightage','scorable','kpi_metrics'],['form_name'=>$form_name,'form_version'=>$form_version]);
            $this->load->view('admin/forms_edit_view' , $data);
        }
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);   
        }
    }

    //public function delete_form($form_name,$form_version)
    public function delete_form($form_unique_id) {
        if($this->emp_group == "ops" && $this->emp_type == "supervisor"){

            $result_form_info = $this->common->getDistinctWhereSelect('forms_details',['form_version','form_name'],['form_unique_id'=>$form_unique_id]);
            if(!empty($result_form_info[0]['form_name']) && $result_form_info[0]['form_name'] == null || $result_form_info[0]['form_name'] == '')
            {
                $this->common->delete_data('forms_details',['form_unique_id'=>$form_unique_id]);
                $this->session->set_flashdata('success', 'Form has been deleted  ....');
                redirect('forms-list', 'refresh');
            }


            $form_name = $result_form_info[0]['form_name'];
            $form_version = $result_form_info[0]['form_version'];
            $result_count_info = $this->common->getWhereSelectDistinctCount('forms_details','form_version',['form_name'=>$form_name],$distinct=null);
            //echo $form_name;
            //echo $this->db->last_query();
            //$this->print_result($result_count_info);
            //die;
            //$this->common->getWhereSelectDistinctCount('forms_details','form_name',['form_name'=>$this->input->post('form_name')]);
            if($result_count_info == 1)
            {
                $this->common->delete_data('forms_details',['form_name'=>$form_name,'form_version'=>$form_version]);
                $this->common->delete_data('forms',['form_name'=>$form_name,'form_version'=>$form_version]);
                $this->common->drop_table($form_name);
                $this->common->drop_table('ata_'.$form_name);
                $this->common->drop_table('calibration_'.$form_name);
                $this->common->drop_table('escalation_'.$form_name);
                //echo $form_version;
            }
            else {
                $this->common->delete_data('forms_details',['form_name'=>$form_name,'form_version'=>$form_version]);
                $this->common->delete_data('forms',['form_name'=>$form_name,'form_version'=>$form_version]);

                $this->common->delete_data($form_name,['form_version'=>$form_version]);
                $this->common->delete_data('ata_'.$form_name,['form_version'=>$form_version]);
                $this->common->delete_data('calibration_'.$form_name,['form_version'=>$form_version]);
                $this->common->delete_data('escalation_'.$form_name,['form_version'=>$form_version]);
            }
            $this->session->set_flashdata('success', 'Form has been deleted  ....');
            redirect('forms-list', 'refresh');
        }
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);   
        }
    }

    public function form_update() {
        //echo "jiii";die;
        $post_data = $this->input->post();

        $result_rating_attr_name_details = $this->common->getWhereSelectAll('forms_details',['rating_attr','rating_attr_name'],['form_unique_id'=> $post_data['form_unique_id']]);
        $rating_attr_details = [];
        if(!empty($result_rating_attr_name_details[0]->rating_attr) && !empty($result_rating_attr_name_details[0]->rating_attr_name))
        {
            $rating_attr_details =  array_combine(explode('|',$result_rating_attr_name_details[0]->rating_attr) , explode('|',$result_rating_attr_name_details[0]->rating_attr_name));
        }
        else {
            $result_rating_attr_name_details = $this->common->getWhereSelectAll('forms_details',['rating_attr','rating_attr_name'],['form_name'=> $post_data['form_name'],'form_version'=>$post_data['old_form_version']]);
            $rating_attr_details =  array_combine(explode('|',$result_rating_attr_name_details[0]->rating_attr) , explode('|',$result_rating_attr_name_details[0]->rating_attr_name));
        }

        $old_form_version = $post_data['old_form_version'];
        unset($post_data['old_form_version']);
        $form_details_data  = [];
        $forms_data         = [];
        $form_details_data['client_id']         = $this->client_id;
        $form_details_data['form_name']         = strtolower($post_data['form_name']);
        $form_details_data['form_version']      = ltrim(rtrim(strtolower($post_data['form_version']),'.0'),'v');
        $form_details_data['form_attributes']   = $post_data['form_attributes'];
        $form_details_data['tb_name']           = strtolower($post_data['form_name']);
        $form_details_data['form_status']       = '1';
        $form_details_data['lob']               = $post_data['lob'];
        $form_details_data['channels']          = $post_data['channels'];
        $form_details_data['pass_rate']         = $post_data['pass_rate'];
        $form_details_data['form_weightage']    = 0;

        unset($post_data['form_name'],$post_data['form_version'],$post_data['form_attributes'],$post_data['lob'],$post_data['channels'],$post_data['pass_rate']);
       
        $data = []; $catindx = 1;
        
        
        foreach($post_data  as $column_name_key => $post_data_value){
            if($column_name_key == 'category'){
                foreach($post_data_value  as $cat_id_key => $cat_id_value) {
                    //$this->print_result(!empty($post_data['kpi_metrics'][$cat_id_key])?$post_data['kpi_metrics'][$cat_id_key]:"RRR");
                    $indx = 0;  $rate_flag = 0;
                    foreach($cat_id_value  as  $cell_data){
                        $data['cat'.$catindx]['cat_'.$indx]  = $cell_data;  
                        $data['cat'.$catindx]['att_'.$indx]  = $post_data['attribute'][$cat_id_key][$indx]; 
                        //$data['cat'.$catindx]['rat_'.$indx]  = implode("|",array_shift($post_data['rating'][$cat_id_key]));  
                        $data['cat'.$catindx]['rat_'.$indx]  = !empty($post_data['rating'][$cat_id_key][$indx]) ? implode("|",$post_data['rating'][$cat_id_key][$indx]) :null;      
                        
                        if(!empty($post_data['rating'][$cat_id_key][$indx])){
                            $data['cat'.$catindx]['ran_'.$indx] = '';   /// rcm for rating_attr_name
                            foreach($post_data['rating'][$cat_id_key][$indx] as $rat_value){
                                $data['cat'.$catindx]['ran_'.$indx] .= !empty($rating_attr_details[$rat_value])?$rating_attr_details[$rat_value].'|':$rat_value.'|';
                            }
                        }
                        
                        // echo '<pre>';
                        // print_r($post_data['rating'][$cat_id_key][$indx]);die;
                        $data['cat'.$catindx]['kpi_'.$indx]  = !empty($post_data['kpi_metrics'][$cat_id_key][$indx]) ? implode("|",$post_data['kpi_metrics'][$cat_id_key][$indx]) :null;  
                        //$data['cat'.$catindx]['kpi_'.$indx]  = implode("|",array_shift($post_data['kpi_metrics'][$cat_id_key]));  
                        //$data['cat'.$catindx]['kpi_'.$indx]  = implode("|",array_shift($post_data['kpi_metrics'][$cat_id_key]));  
                        $data['cat'.$catindx]['wei_'.$indx]  = !empty($post_data['weightage'][$cat_id_key][$indx]) ? $post_data['weightage'][$cat_id_key][$indx] :'';  
                        $data['cat'.$catindx]['sco_'.$indx]  = $post_data['scorable'][$cat_id_key][$indx]; 
                        //$form_details_data['form_weightage'] += $post_data['weightage'][$cat_id_key][$indx];
                        $form_details_data['form_weightage'] += (!empty($post_data['weightage'][$cat_id_key][$indx])) ? $post_data['weightage'][$cat_id_key][$indx] :0;  
                        $indx++ ; 
                    }
                    $catindx++;
                }
            }
        }

        // echo '<pre>';
        // print_r($data);die;
        
        $old_attr_count =  $this->common->getWhereSelectDistinctCount('forms','attr_id',['form_name'=>$form_details_data['form_name'],'form_version'=>$old_form_version],'attr_id');
        $old_cat_count =   $this->common->getWhereSelectDistinctCount('forms','cat_id',['form_name'=>$form_details_data['form_name'],'form_version'=>$old_form_version],'cat_id');
        
        $flag_aat_id = 1;
        $flag_cat_id = 0;
         /// prepare array for No of cat  colums in form table Rajesh
        $fields = array();
        $fields_for_escalation = array();
        $cat_colums = array();
        foreach($data as $cat_id=>$each_cat_data) {
            $flag_cat_id++;
            foreach($each_cat_data as $key=>$value){
                if(substr($key, 0, 3) == 'cat'){
                    $forms_data[$flag_aat_id]['client_id']           = $this->client_id;
                    $forms_data[$flag_aat_id]['category']            = $value;
                    $forms_data[$flag_aat_id]['cat_id']              = $cat_id;

                    $forms_data[$flag_aat_id]['attribute']           = $each_cat_data['att'.substr($key,3)];
                    $forms_data[$flag_aat_id]['attr_id']             = $flag_aat_id < 10 ? 'att0'.$flag_aat_id.'_sel' : 'att'.$flag_aat_id.'_sel';
                    
                    $forms_data[$flag_aat_id]['rating']              = $each_cat_data['rat'.substr($key,3)];
                     $forms_data[$flag_aat_id]['rating_attr_name']   = rtrim($each_cat_data['ran'.substr($key,3)],'|');
                    $forms_data[$flag_aat_id]['weightage']           = $each_cat_data['wei'.substr($key,3)];
                    $forms_data[$flag_aat_id]['scorable']            = $each_cat_data['sco'.substr($key,3)];
                    $forms_data[$flag_aat_id]['kpi_metrics']         = $each_cat_data['kpi'.substr($key,3)];

                    $forms_data[$flag_aat_id]['form_name']           = strtolower($this->input->post('form_name'));
                    $forms_data[$flag_aat_id]['form_version']        = ltrim(rtrim(strtolower($this->input->post('form_version')),'.0'),'v');
                    $forms_data[$flag_aat_id]['lob']                 = $this->input->post('lob');
                    $forms_data[$flag_aat_id]['channels']            = $this->input->post('channels');
                    
                    
                    $flag_aat_id++;
                }
            }
        }
      
        $this->load->dbforge();
        if($old_attr_count < ($flag_aat_id-1))
        {
            while($old_attr_count < ($flag_aat_id-1))
            {
                $att_name = '';  ($old_attr_count + 1) < 10?$att_name = '0'.($old_attr_count + 1):$att_name = ($old_attr_count + 1);

                $list_fields = $this->db->list_fields(strtolower($this->input->post('form_name')));
                if((array_search('att'.$att_name.'_score',$list_fields)) == false){
                    $fields['att'.$att_name.'_score'] = array('type' => 'VARCHAR', 'constraint' => '100');
                    $fields['att'.$att_name.'_sel'] = array('type' => 'VARCHAR','constraint' => '100');
                    $fields['att'.$att_name.'_com'] = array('type' =>'text');
                    $fields_for_escalation['att'.$att_name.'_com'] = array('type' =>'text');
                }
                $old_attr_count++;
            }
            ///////////////////////////////////////////////// IMPPPPPPPPPPP
            if(!empty($fields)){
                $this->dbforge->add_column(strtolower($this->input->post('form_name')),$fields);
                $this->dbforge->add_column('calibration_'.strtolower($this->input->post('form_name')),$fields);
                $this->dbforge->add_column('ata_'.strtolower($this->input->post('form_name')),$fields);
                $this->dbforge->add_column('escalation_'.strtolower($this->input->post('form_name')),$fields_for_escalation);
            }
        }
        ///////////////////////////////////////////////// IMPPPPPPPPPPP
        if($old_cat_count < $flag_cat_id)
        {
            while($old_cat_count < $flag_cat_id){
                $list_fields = $this->db->list_fields(strtolower($this->input->post('form_name')));
                //if( array_search('cat'.($old_cat_count + 1),$list_fields)){
                if((array_search('cat'.($old_cat_count + 1),$list_fields)) == false){
                    $cat_colums['cat'.($old_cat_count + 1)] = array('type' => 'VARCHAR', 'constraint' => '100');
                }
                $old_cat_count++;
            }
            if(!empty($cat_colums)){
                $this->dbforge->add_column(strtolower($this->input->post('form_name')),$cat_colums);
                $this->dbforge->add_column('calibration_'.strtolower($this->input->post('form_name')),$cat_colums);
                $this->dbforge->add_column('ata_'.strtolower($this->input->post('form_name')),$cat_colums);
                $this->dbforge->add_column('escalation_'.strtolower($this->input->post('form_name')),$cat_colums);
            }
        }
      
        if($old_form_version == $form_details_data['form_version'])
        {
            $status_flag = 0;
            foreach($forms_data as $each_forms_data){
                $response = $this->common->update_data_info('forms',$each_forms_data,['form_name'=>$form_details_data['form_name'],'form_version'=>$form_details_data['form_version'],'attr_id'=>$each_forms_data['attr_id']]);
                if(!($response)){
                    $status_flag++;
                }
            }
            if($status_flag > 0){
                $this->session->set_flashdata('error', 'Form is not created try again ....');
                redirect('forms-edit/'.$form_details_data['form_name'].'/'.$form_details_data['form_version'], 'refresh');
            }
            else {
                $this->session->set_flashdata('success', 'Form updated successfully  ....');
                //redirect('forms-edit/'.$form_details_data['form_name'].'/'.$form_details_data['form_version'], 'refresh');
               redirect('forms-list', 'refresh');
            }
        }
        else{
            // $this->print_result($form_details_data);
            // echo "UUUUUUUUUUUU";die;
            $response_forms_details_check = $this->common->getWhereSelectDistinctCount('forms_details','form_unique_id',['form_unique_id'=> $post_data['form_unique_id']],$distinct=null);
            
            if($response_forms_details_check == 1)
            {
                $response_forms_details = $this->common->update_data_info('forms_details',$form_details_data,['form_unique_id'=> $post_data['form_unique_id']]);
            }
            else {
                $old_forms_details_rating_attr_name = $this->common->getDistinctWhereSelect('forms_details',['rating_attr_name'],['form_name'=>$form_details_data['form_name'],'form_version'=>$old_form_version]);//////
                //$this->print_result($old_forms_details_rating_attr_name[0]['rating_attr_name']);die;
                $form_details_data['form_unique_id']      = $post_data['form_unique_id'];
                $form_details_data['rating_attr']      = 'YES|NO|FATAL|NA';
                $form_details_data['rating_attr_name'] = (!empty($old_forms_details_rating_attr_name[0]['rating_attr_name']) ? $old_forms_details_rating_attr_name[0]['rating_attr_name'] : 'YES|NO|FATAL|NA');
                //$old_form_version;
                //$this->print_result($form_details_data);die;
                $response_forms_details = $this->common->insert_data($form_details_data,'forms_details');//////////////////
            }
            // $this->print_result($response_forms_details);
            // echo "UUUUUUUUUUUU";die;
            //$response_forms_details = $this->common->insert_data($form_details_data,'forms_details');//////////////////
            $response               = $this->common->insert_batch_data('forms',$forms_data);
            if(!($response) && !($response_forms_details)){
                $response = $this->common->delete_data('forms',['form_name'=>$form_details_data['form_name'],'form_version'=>$form_details_data['form_version']]);
                $response = $this->common->delete_data('forms_details',['form_unique_id'=> $post_data['form_unique_id']]);
                $this->session->set_flashdata('error', 'Form is not create try again ....');
                redirect('forms-edit/'.$form_details_data['form_name'].'/'.$old_form_version, 'refresh');
            }
            else {
                $this->session->set_flashdata('success', 'Form created successfully  ....');
               /// redirect('forms-edit/'.$form_details_data['form_name'].'/'.$form_details_data['form_version'], 'refresh');
                redirect('forms-list', 'refresh');
            }
        }
    }
   
    public function create_Uiform_index($form_unique_id) {
        if($this->emp_group == "ops" && $this->emp_type == "supervisor") {
           // $this->session->set_flashdata('success', 'Please Customize Form Rating First....');
            $reasultunique_form_info =$this->common->getWhereSelectAll('forms_details',['form_name','lob','channels','pass_rate','form_version','form_attributes'],['form_unique_id'=> $form_unique_id]);
            //$this->print_result($reasultunique_form_info[0]);die;
            $data['form_unique_id'] = $form_unique_id;
            $data['form_unique_id_data'] = !empty($reasultunique_form_info[0])? $reasultunique_form_info[0] : [];
            //$this->print_result($data['form_unique_id_data'] );die;
            //$data['rating_attr_details'] = $this->common->getAllSelectData('rating_details',['rating_attr','rating_attr_name']);
            $result_rating_attr_name_details = $this->common->getWhereSelectAll('forms_details',['rating_attr','rating_attr_name'],['form_unique_id'=> $form_unique_id]);
            $data['rating_attr_details'] = [];
            if(!empty($result_rating_attr_name_details[0]->rating_attr) && !empty($result_rating_attr_name_details[0]->rating_attr_name))
            {
                $data['rating_attr_details'] =  array_combine(explode('|',$result_rating_attr_name_details[0]->rating_attr) , explode('|',$result_rating_attr_name_details[0]->rating_attr_name));
            }
            //$this->print_result($data['rating_attr_details']);die;
           // $data['rating_attr_details'] = explode('|',$result_rating_attr_details);
            // $data['result_rating_attr_details'] = !empty($result_rating_attr_name_details[0]->rating_attr)? explode('|',$result_rating_attr_name_details[0]->rating_attr) : [];
            // $data['result_rating_attr_name_details'] = !empty($result_rating_attr_name_details[0]->rating_attr_name)? explode('|',$result_rating_attr_name_details[0]->rating_attr_name) : [];
            
            $evaForm_count =  $this->common->getSelectAll('forms_details',['COUNT(DISTINCT form_name) AS form_name' , 'COUNT(form_version) AS form_version'],'form_name');
            $form_name_check = (!empty((int)$evaForm_count[0]->form_name))?(int)$evaForm_count[0]->form_name:0;
            $form_version_check = (!empty((int)$evaForm_count[0]->form_version))?(int)$evaForm_count[0]->form_version:0;
            // echo $subscriptionEvaForm_count;die;
            if(((int)$this->subscriptionEvaForm > $form_name_check) && ((int)$this->subscriptionEvaFormVersion > $form_version_check) && !is_infinite($this->subscriptionEvaForm) && !is_infinite($this->subscriptionEvaFormVersion)){           
               // $data['title']  = 'Form Edit';
                $data['channels'] = channels();
                $reasult_lob_formdetails =$this->common->getDistinctWhereSelect('forms_details','lob',['client_id'=>$this->client_id]);
                $reasult_lob_fhierarchy =$this->common->getDistinctWhereSelect('hierarchy','lob',['client_id'=>$this->client_id]);
                $data['lob'] = [];
                $reasult_version = 1;
                foreach ($reasult_lob_fhierarchy as $key => $value) {
                    if(!in_array($value['lob'], array_column($reasult_lob_formdetails, 'lob'))) { // search value in the array
                        $data['lob'][] = $value['lob'];
                    }
                }
                $this->load->view('admin/create_Ui_form_view' , $data);
            }
            else if(((int)$this->subscriptionEvaFormVersion > $form_version_check) && is_infinite($this->subscriptionEvaForm) && !is_infinite($this->subscriptionEvaFormVersion)){
                $data['title']  = 'Form Edit';
                $data['channels'] = channels();
                $reasult_lob_formdetails =$this->common->getDistinctWhereSelect('forms_details','lob',['client_id'=>$this->client_id]);
                $reasult_lob_fhierarchy =$this->common->getDistinctWhereSelect('hierarchy','lob',['client_id'=>$this->client_id]);
                $data['lob'] = [];
                $reasult_version = 1;
                foreach ($reasult_lob_fhierarchy as $key => $value) {
                    if(!in_array($value['lob'], array_column($reasult_lob_formdetails, 'lob'))) { // search value in the array
                        $data['lob'][] = $value['lob'];
                    }
                }
                $this->load->view('admin/create_Ui_form_view' , $data);
            }
            else if(is_infinite($this->subscriptionEvaFormVersion) && is_infinite($this->subscriptionEvaForm)){
                $data['title']  = 'Form Edit';
                $data['channels'] = channels();
                $reasult_lob_formdetails =$this->common->getDistinctWhereSelect('forms_details','lob',['client_id'=>$this->client_id]);
                $reasult_lob_fhierarchy =$this->common->getDistinctWhereSelect('hierarchy','lob',['client_id'=>$this->client_id]);
                $data['lob'] = [];
                $reasult_version = 1;
                foreach ($reasult_lob_fhierarchy as $key => $value) {
                    if(!in_array($value['lob'], array_column($reasult_lob_formdetails, 'lob'))) { // search value in the array
                        $data['lob'][] = $value['lob'];
                    }
                }
                $this->load->view('admin/create_Ui_form_view' , $data);
            }            
            else{
                $this->session->set_flashdata('error',$this->lang->line('form_error'));
                redirect('forms-list', 'refresh');
            }
        }
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);   
        }
    }

    public function create_Uiform() {
        // echo "jiii";
        // die;
        $post_data = $this->input->post();
        //$this->print_result($post_data);die; form_unique_id

        $result_rating_attr_name_details = $this->common->getWhereSelectAll('forms_details',['rating_attr','rating_attr_name'],['form_unique_id'=> $post_data['form_unique_id']]);
        $rating_attr_details = [];
        if(!empty($result_rating_attr_name_details[0]->rating_attr) && !empty($result_rating_attr_name_details[0]->rating_attr_name))
        {
            $rating_attr_details =  array_combine(explode('|',$result_rating_attr_name_details[0]->rating_attr) , explode('|',$result_rating_attr_name_details[0]->rating_attr_name));
        }
       // $this->print_result($rating_attr_details);die;

        $flagform_name_ubique =  $this->common->getWhereSelectDistinctCount('forms_details','form_name',['form_unique_id'=> $post_data['form_unique_id']]);
        
        if (((int)$flagform_name_ubique) > 1) { 
            // $this->load->view('register', $this->data);
            $this->session->set_flashdata('error', $this->lang->line('UniqueFormName_error'));
            redirect('create-form', 'refresh');  
		}
        else
        {
            $form_details_data  = [];
            $forms_data         = [];
            $form_details_data['client_id']         = $this->client_id;
            $form_details_data['form_unique_id']    = $post_data['form_unique_id'];
            $form_details_data['form_name']         = strtolower($post_data['form_name']);
            $form_details_data['form_version']      = ltrim(rtrim(strtolower($post_data['form_version']),'.0'),'v');
            $form_details_data['form_attributes']   = $post_data['form_attributes'];
            $form_details_data['tb_name']           = strtolower($post_data['form_name']);
            $form_details_data['form_status']       = '1';
            $form_details_data['lob']               = $post_data['lob'];
            $form_details_data['channels']          = $post_data['channels'];
            $form_details_data['pass_rate']         = $post_data['pass_rate'];
            $form_details_data['form_weightage']    = 0;

            unset($post_data['form_name'],$post_data['form_version'],$post_data['form_attributes'],$post_data['lob'],$post_data['channels'],$post_data['pass_rate']);
        
            $data = []; $catindx = 1;
            foreach($post_data  as $column_name_key => $post_data_value){
                if($column_name_key == 'category'){
                    foreach($post_data_value  as $cat_id_key => $cat_id_value) {
                        $indx = 0;  $rate_flag = 0;
                        foreach($cat_id_value  as  $cell_data){
                            
                            $data['cat'.$catindx]['cat_'.$indx]  = $cell_data;  
                            $data['cat'.$catindx]['att_'.$indx]  = $post_data['attribute'][$cat_id_key][$indx]; 
                            //$data['cat'.$catindx]['rat_'.$indx]  = implode("|",array_shift($post_data['rating'][$cat_id_key]));  
                            $data['cat'.$catindx]['rat_'.$indx]  = !empty($post_data['rating'][$cat_id_key][$indx]) ? implode("|",$post_data['rating'][$cat_id_key][$indx]) :null;    
                            
                            if(!empty($post_data['rating'][$cat_id_key][$indx])){
                                $data['cat'.$catindx]['ran_'.$indx] = '';   /// rcm for rating_attr_name
                                foreach($post_data['rating'][$cat_id_key][$indx] as $rat_value){
                                   $data['cat'.$catindx]['ran_'.$indx] .= !empty($rating_attr_details[$rat_value])?$rating_attr_details[$rat_value].'|':$rat_value.'|';
                                }
                            }
                          //$this->print_result($data['cat'.$catindx]['rat_name_'.$indx]);

                            $data['cat'.$catindx]['kpi_'.$indx]  = !empty($post_data['kpi_metrics'][$cat_id_key][$indx]) ? implode("|",$post_data['kpi_metrics'][$cat_id_key][$indx]) :null;  
                            //$data['cat'.$catindx]['wei_'.$indx]  = $post_data['weightage'][$cat_id_key][$indx]; 
                            $data['cat'.$catindx]['wei_'.$indx]  = !empty($post_data['weightage'][$cat_id_key][$indx]) ? $post_data['weightage'][$cat_id_key][$indx] :'';  
                            $data['cat'.$catindx]['sco_'.$indx]  = $post_data['scorable'][$cat_id_key][$indx]; 
                            //$form_details_data['form_weightage'] += $post_data['weightage'][$cat_id_key][$indx];
                            $form_details_data['form_weightage'] += !empty($post_data['weightage'][$cat_id_key][$indx]) ? $post_data['weightage'][$cat_id_key][$indx] :0;  
                            $indx++ ; 
                        }
                        $catindx++;
                    }
                }
            }
            
            // $this->print_result($data);
            // die;
            $flag_aat_id = 1;
            /// prepare array for No of cat  colums in form table Rajesh
            $fields = array();
            $fields_for_escalation = array();
            $cat_colums = array();

            foreach($data as $cat_id=>$each_cat_data) {
                foreach($each_cat_data as $key=>$value){
                    if(substr($key, 0, 3) == 'cat'){
                        $forms_data[$flag_aat_id]['client_id']          = $this->client_id;
                        $forms_data[$flag_aat_id]['category']           = $value;
                        $forms_data[$flag_aat_id]['cat_id']             = $cat_id;

                        $forms_data[$flag_aat_id]['attribute']          = $each_cat_data['att'.substr($key,3)];
                        $forms_data[$flag_aat_id]['attr_id']            = $flag_aat_id < 10 ? 'att0'.$flag_aat_id.'_sel' : 'att'.$flag_aat_id.'_sel';
                        
                        $forms_data[$flag_aat_id]['rating']             = $each_cat_data['rat'.substr($key,3)];
                        $forms_data[$flag_aat_id]['rating_attr_name']   = rtrim($each_cat_data['ran'.substr($key,3)],'|');
                        $forms_data[$flag_aat_id]['weightage']          = $each_cat_data['wei'.substr($key,3)];
                        $forms_data[$flag_aat_id]['scorable']           = $each_cat_data['sco'.substr($key,3)];
                        $forms_data[$flag_aat_id]['kpi_metrics']        = $each_cat_data['kpi'.substr($key,3)];

                        $forms_data[$flag_aat_id]['form_name']          = strtolower($this->input->post('form_name'));
                        $forms_data[$flag_aat_id]['form_version']       = ltrim(rtrim(strtolower($this->input->post('form_version')),'.0'),'v');
                        $forms_data[$flag_aat_id]['lob']                = $this->input->post('lob');
                        $forms_data[$flag_aat_id]['channels']           = $this->input->post('channels');
                        
                        /////////////////////////////////////////////// For dynamic table creation
                        $cat_colums[$cat_id] = array('type' => 'VARCHAR', 'constraint' => '100');
                        $att_name = '';  $flag_aat_id<10?$att_name = '0'.$flag_aat_id:$att_name = $flag_aat_id;
                        $fields['att'.$att_name.'_score'] = array('type' => 'VARCHAR', 'constraint' => '100');
                        $fields['att'.$att_name.'_sel'] = array('type' => 'VARCHAR','constraint' => '100');
                        $fields['att'.$att_name.'_com'] = array('type' =>'text');
                        $fields_for_escalation['att'.$att_name.'_com'] = array('type' =>'text');
                        /////////////////////////////////////////////////
                        $flag_aat_id++;
                    }
                }
            }
            // $this->print_result($forms_data);
            // die;
            //$evaForm_count =  $this->common->getSelectDistinctCount('forms_details','form_name','form_name');
            $evaForm_count =  $this->common->getSelectAll('forms_details',['COUNT(DISTINCT form_name) AS form_name' , 'COUNT(form_version) AS form_version'],'form_name');
            $form_name_check = (!empty((int)$evaForm_count[0]->form_name))?(int)$evaForm_count[0]->form_name:0;
            $form_version_check = (!empty((int)$evaForm_count[0]->form_version))?(int)$evaForm_count[0]->form_version:0;
            // echo $subscriptionEvaForm_count;die;
           // if(((int)$this->subscriptionEvaForm > $form_name_check) || ((int)$this->subscriptionEvaFormVersion > $form_version_check) && !is_infinite($this->subscriptionEvaForm)){
                
                //***************************************** */
                $this->db->query('CREATE TABLE '.strtolower($this->input->post('form_name')).' LIKE sample_form');
                $this->load->dbforge();
                $this->dbforge->add_column(strtolower($this->input->post('form_name')),$fields);
                $this->dbforge->add_column(strtolower($this->input->post('form_name')),$cat_colums);
                /// create dynamic  tables for  Calibratin 
                $this->db->query('CREATE TABLE calibration_'.strtolower($this->input->post('form_name')).' LIKE sample_form');
                $this->dbforge->add_column('calibration_'.strtolower($this->input->post('form_name')),$fields);
                $this->dbforge->add_column('calibration_'.strtolower($this->input->post('form_name')),$cat_colums);
                $calibration_colums['calibration_by'] = array('type' => 'VARCHAR', 'constraint' => '255');
                $calibration_colums['emp_group'] = array('type' => 'VARCHAR', 'constraint' => '255');
                $calibration_colums['emp_type'] = array('type' => 'VARCHAR', 'constraint' => '255');
                $calibration_colums['calibration_date'] = array('type' => 'date');
                $calibration_colums['calibration_time'] = array('type' => 'time');
                $calibration_colums['calibration_status'] =array('type' => 'enum', 'constraint' => ['0','1'],'default' => '0');
                //$calibration_colums['calibration_status'] =array('type' => 'enum', 'constraint' => '0,1','default' => '0');
                $this->dbforge->add_column('calibration_'.strtolower($this->input->post('form_name')),$calibration_colums);
                /// create dynamic  tables for  ATA
                $this->db->query('CREATE TABLE ata_'.strtolower($this->input->post('form_name')).' LIKE sample_form');
                $this->dbforge->add_column('ata_'.strtolower($this->input->post('form_name')),$fields);
                $this->dbforge->add_column('ata_'.strtolower($this->input->post('form_name')),$cat_colums);
                $ata_colums['ata_by'] = array('type' => 'VARCHAR', 'constraint' => '255');
                $ata_colums['emp_group'] = array('type' => 'VARCHAR', 'constraint' => '255');
                $ata_colums['ata_date'] = array('type' => 'datetime');
                $ata_colums['ata_status'] =array('type' => 'enum', 'constraint' => ['0','1'],'default' => '0');
                $this->dbforge->add_column('ata_'.strtolower($this->input->post('form_name')),$ata_colums);
                /// create dynamic  tables for  ESCALATION
                
                $this->db->query('CREATE TABLE escalation_'.strtolower($this->input->post('form_name')).' LIKE sample_escalation_form');
                $this->dbforge->add_column('escalation_'.strtolower($this->input->post('form_name')),$fields_for_escalation);
                $this->dbforge->add_column('escalation_'.strtolower($this->input->post('form_name')),$cat_colums);
                $escalation_colums['escalation_by'] = array('type' => 'VARCHAR', 'constraint' => '255');
                $escalation_colums['escalation_date'] = array('type' => 'datetime');
                $escalation_colums['escalation_status'] =array('type' => 'enum', 'constraint' => ['0','1'],'default' => '0');
                $this->dbforge->add_column('escalation_'.strtolower($this->input->post('form_name')),$escalation_colums);
                /////////////////////////////////////////////////
                // Data Insert Code in forms and forms_details table
                //$response_forms_details = $this->common->insert_data($form_details_data,'forms_details');//////
                //$check_forms_details = $this->common->getWhereSelectDistinctCount('forms_details','form_name',['form_name'=>$form_details_data['form_name'],'form_version'=>$form_details_data['form_version']]);//////
                $check_forms_details =  $this->common->getWhereSelectDistinctCount('forms_details','form_unique_id',['form_unique_id'=>$this->input->post('form_unique_id')]);//////
                //echo $check_forms_details;die;
                if($check_forms_details > 0)
                {
                    $response_forms_details = $this->common->update_data_info('forms_details',$form_details_data,['form_name'=>$form_details_data['form_name'],'form_version'=>$form_details_data['form_version']]);//////
                }
                else {
                    $form_details_data['rating_attr']      = 'YES|NO|FATAL|NA';
                    $form_details_data['rating_attr_name'] = 'YES|NO|FATAL|NA';
                    $response_forms_details = $this->common->insert_data($form_details_data,'forms_details');//////
                }
                //$response_forms_details = $this->common->insert_data($form_details_data,'forms_details');//////
                $response               = $this->common->insert_batch_data('forms',$forms_data);
                
                if(!($response) && !($response_forms_details)){
                    $response = $this->common->delete_data('forms',['form_name'=>$form_details_data['form_name'],'form_version'=>$form_details_data['form_version']]);
                    $response = $this->common->delete_data('forms_details',['form_name'=>$form_details_data['form_name'],'form_version'=>$form_details_data['form_version']]);
                    $this->session->set_flashdata('error', 'Form is not create try again ....');
                    redirect('create-form', 'refresh');
                }
                else {
                    $this->session->set_flashdata('success', 'Form created successfully  ....');
                    redirect('forms-list', 'refresh');
                }
                
                //***************************************** */
            // }
            // else{
            //     $this->session->set_flashdata('error',$this->lang->line('form_error'));
            //     redirect('create-form', 'refresh');
            // }
        }
    }
    
    public function custom_rating_insert() {
        //echo '<pre>';
        //print_r($this->input->post());
       $post_rating_attr_info = $this->input->post('rating_attr');
       
        $rating_data = [];
        $rating_attr = ['YES','NO','FATAL','NA',];
        //$rating_attr = '';
        $rating_attr_name = '';
       foreach($post_rating_attr_info as $key => $value)
       {
           $rating_attr_name .= !empty($value)?$value.'|':$rating_attr[$key].$value.'|';
       }
        $rating_attr = implode('|',$rating_attr);
        $rating_attr_name = rtrim($rating_attr_name,'|');
      
        $responseCount  = $this->common->getWhereSelectDistinctCount('forms_details','form_unique_id',['form_unique_id'=>$this->input->post('form_unique_id')]);
        
        $response = false;
        if($responseCount > 0)
        {
            $update_data['form_name']        = $this->input->post('form_name_rating');
            $update_data['lob']              = $this->input->post('lob_rating');
            $update_data['channels']         = $this->input->post('channel_rating');
            $update_data['pass_rate']        = $this->input->post('passrate_rating');
            $update_data['rating_attr']      = $rating_attr;
            $update_data['rating_attr_name'] = $rating_attr_name;
            $response  = $this->common->update_data_info('forms_details',$update_data,['form_unique_id'=>$this->input->post('form_unique_id')]);
        }
        else {
            $insert_data['form_unique_id']   = $this->input->post('form_unique_id');
            $insert_data['form_name']        = $this->input->post('form_name_rating');
            $insert_data['lob']              = $this->input->post('lob_rating');
            $insert_data['channels']         = $this->input->post('channel_rating');
            $insert_data['pass_rate']        = $this->input->post('passrate_rating');
            $insert_data['rating_attr']      = $rating_attr;
            $insert_data['rating_attr_name'] = $rating_attr_name;
            $response  = $this->common->insert_data($insert_data,'forms_details'); 
        }

        if($response){
            $res['status'] = "success";
            //$this->session->set_flashdata('success', 'Rating customized successfully  ....');
        }
        else {
            $res['status'] = "error";
            //$this->session->set_flashdata('error', 'Rating not customize try again  ....');
        }
        $res['rating_attr_name']=$rating_attr_name;
        echo postRequestResponse($res);
        
        // if($response){
        //     $this->session->set_flashdata('success', 'Rating customized successfully  ....');
        // }
        // else {
        //     $this->session->set_flashdata('error', 'Rating not customize try again  ....');
        // }
        // redirect('create-form/'.$this->input->post('form_unique_id'), 'refresh');
    }
    
    public function custom_rating_form_edit() {
        // echo '<pre>';
        // print_r($this->input->post());die;
       $post_rating_attr_info = $this->input->post('rating_attr');
       
        $rating_data = [];
        $rating_attr = ['YES','NO','FATAL','NA',];
        //$rating_attr = '';
        $rating_attr_name = '';
       foreach($post_rating_attr_info as $key => $value)
       {
           $rating_attr_name .= !empty($value)?$value.'|':$rating_attr[$key].$value.'|';
       }
        $rating_attr = implode('|',$rating_attr);
        $rating_attr_name = rtrim($rating_attr_name,'|');
      
        $responseCount  = $this->common->getWhereSelectDistinctCount('forms_details','form_unique_id',['form_unique_id'=>$this->input->post('form_unique_id'),'form_version'=>$this->input->post('form_version_reating')]);
        //$responseCount  = $this->common->getWhereSelectDistinctCount('rating_details','form_name',['form_name'=>$this->input->post('form_name_rating'),'form_version'=>$this->input->post('form_version_rating')]);
        //$responseCount  = $this->common->getSelectDistinctCount('rating_details','rating_attr');
        //echo $this->db->last_query();
        // echo $responseCount;die;
       $response = false;
        if($responseCount > 0)
        {
            $update_data['rating_attr']      = $rating_attr;
            $update_data['rating_attr_name'] = $rating_attr_name;
            $response  = $this->common->update_data_info('forms_details',$update_data,['form_unique_id'=>$this->input->post('form_unique_id')]);
        }
        else {
            $reasult_formdetails =$this->common->getDistinctWhereSelect('forms_details',['form_name','lob','channels'],['form_unique_id'=>$this->input->post('form_unique_id')]);
           // $this->print_result($reasult_formdetails);die;
            $insert_data['form_unique_id']   = $this->input->post('form_unique_id');
            // $insert_data['form_name']        = $reasult_formdetails[0]['form_name'];
            // $insert_data['lob']              = $reasult_formdetails[0]['lob'];
            // $insert_data['channels']         = $reasult_formdetails[0]['channels'];
            // $insert_data['form_version']         = $this->input->post('form_version_reating');
            
            $insert_data['rating_attr']      = $rating_attr;
            $insert_data['rating_attr_name'] = $rating_attr_name;
            $response  = $this->common->insert_data($insert_data,'forms_details'); 
        }
        //echo postRequestResponse($response);die;
        if($response){
            $res['status'] = "success";
            //$this->session->set_flashdata('success', 'Rating customized successfully  ....');
        }
        else {
            $res['status'] = "error";
            //$this->session->set_flashdata('error', 'Rating not customize try again  ....');
        }
        $res['rating_attr_name']=$rating_attr_name;
        echo postRequestResponse($res);
        //redirect('forms-edit/'.$this->input->post('form_unique_id'), 'refresh');
    }
    
    public function print_result($request) {
        echo '<pre>';
        print_r($request);
        echo '</pre>';
        echo '<br>';
       // die;
    }
}


