<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hierarchy_management extends MY_Controller {

	public function index() {

        
        
		if($this->emp_group == "admin") {
		    $data['title']  = 'Hierarchy Manage';
            
			$data['hierarchies']= $this->hmm->get_allhierarchyDetails();
			$data['lob']        = $this->hmm->get_lob();
			$data['campaign']   = $this->hmm->get_campaign();
			$data['vendor']     = $this->hmm->get_vendor();
			$data['location']   = $this->hmm->get_location();
			
            if(decode($this->input->post('hdn_save')) == 'save_hierarchy') {
                //LOB VALIDATION
                if($this->input->post('lob') == 'add_new') {
                    $this->form_validation->set_rules('lobtxt','Lob','trim|required');
                } else {
                    $this->form_validation->set_rules('lob','Lob','trim|required');
                }
                
                //CAMPAIGN VALIDATION
                if($this->input->post('campaign') == 'add_new') {
                    $this->form_validation->set_rules('campaigntxt','campaign','trim|required');
                }else {
                    $this->form_validation->set_rules('campaign','campaign','trim|required');
                }
                
                //VENDOR VALIDATION
                if($this->input->post('vendor') == 'add_new') {
                    $this->form_validation->set_rules('vendortxt','vendor','trim|required');
                }else {
                    $this->form_validation->set_rules('vendor','vendor','trim|required');
                }
                
                //LOCATION VALIDATION
                if($this->input->post('location') == 'add_new') {
                    $this->form_validation->set_rules('locationtxt','location','trim|required');
                }else{
                    $this->form_validation->set_rules('location','location','trim|required');
                }
                
                if($this->form_validation->run() == false){
                    $ajax_response = array("status"=>"failure", "message"=> array_values($this->form_validation->error_array())[0]);
                } 
                else {
                    //LOB VALUE
                    $lob = ($this->input->post('lob') == 'add_new')?$this->input->post('lobtxt'):$this->input->post('lob');
                    
                    //CAMPAIGN VALUE
                    $campaign = ($this->input->post('campaign') == 'add_new')?$this->input->post('campaigntxt'):$this->input->post('campaign');
                    
                    //VENDOR VALUE
                    $vendor = ($this->input->post('vendor') == 'add_new')?$this->input->post('vendortxt'):$this->input->post('vendor');
                    
                    //LOCATION VALUE
                    $location = ($this->input->post('location') == 'add_new')?$this->input->post('locationtxt'):$this->input->post('location');
                    

                    //CHECK UNIQUE SET OF HIERARCHY
                    $hierachyCount = $this->common->getWhereSelectDistinctCount('hierarchy','hierarchy_id',['lob'=>$lob,'campaign'=>$campaign,'vendor'=>$vendor,'location'=>$location]);
                    if($hierachyCount==1){
                        $ajax_response = array("status"=>"failure", "message"=>"This hierarchy already exists.");
                    } else {
                        $data_array = array (
                            'lob' => $lob,
                            'campaign' => $campaign,
                            'vendor' => $vendor,
                            'location' => $location,
                            'client_id' => $this->client_id
                        );

                        $insertdata = $this->hmm->insert_hierarchy($data_array);
                        if($insertdata){
                            $ajax_response = array("status"=>"success", "message"=>"Hierarchy Added successfully.");
                        } else {
                            $ajax_response = array("status"=>"failure", "message"=>"Something Went Wrong form not submitted.");
                        }
                    }		
                }
                echo postRequestResponse($ajax_response);
            } else {
                $this->load->view('admin/hierarchy_management_view' , $data);
            }
		}
        else{
        	$data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);	
        }
	}

	public function editHierarchy($id) {
		$data['id']         = $id;
		$id                 = decode($id);
		$data['lob']        = $this->hmm->get_lob();
		$data['campaign']   = $this->hmm->get_campaign();
		$data['vendor']     = $this->hmm->get_vendor();
		$data['location']   = $this->hmm->get_location();
		$data['hierarchy']  = $this->common->getWhere('hierarchy',['hierarchy_id'=>$id]);
		$this->load->view('admin/edit_hierarchy',$data);
	}

	public function updateHierarchyData() {
		$post = $this->input->post();
		$hid = $post['h_id'];
		$this->form_validation->set_rules('lob','Lob','trim|required');
		$this->form_validation->set_rules('campaign','campaign','trim|required');
		$this->form_validation->set_rules('vendor','vendor','trim|required');
		$this->form_validation->set_rules('location','location','trim|required');
		if($this->form_validation->run() == false){
			redirect('editHierarchy/'.$hid);
		} 
		else{
			$lob 		= $post['lob'];
			$campaign 	= $post['campaign'];
			$vendor 	= $post['vendor'];
			$location 	= $post['location'];
			$hid 		= decode($post['h_id']);
			$data_array = array (
				'lob' => $lob,
				'campaign' => $campaign,
				'vendor' => $vendor,
				'location' => $location,
			);
			$this->common->update_data('hierarchy',$data_array,['hierarchy_id'=>$hid]);
			redirect('hierarchy');
		}
	}
    
    public function deleteHierarchy() {
        if($this->emp_group == "admin"){
            $id = decode($this->input->input_stream('deleteId'));
            $chk_hierarchy = $this->common->getWhere('hierarchy',['hierarchy_id'=>$id]);
            
            if(!empty($chk_hierarchy)){
                $chk_user = $this->hmm->getLobUser('user','lob',$chk_hierarchy[0]->lob);
                $chk_form = $this->common->getWhere('forms',['lob'=>$chk_hierarchy[0]->lob]);
                
                if(!empty($chk_user)){
                    $ajax_response = array("status"=>"failure", "message"=>"Useres assigned to this hierarchy. You can't delete this!");   
                }elseif(!empty($chk_form)){
                    $ajax_response = array("status"=>"failure", "message"=>"Forms are created with this hierarchy. You can't delete this!");
                }else{
                    //Delete hierarchy from database
                    $this->common->delete_data('hierarchy',['hierarchy_id'=>$id]);
                    $ajax_response = array("status"=>"success", "message"=>"Data deleted successfully.");
                }
            }
            else{
                $ajax_response = array("status"=>"failure", "message"=>"Hierarchy dosen't exist!");
            }
        }else{
            $ajax_response = array("status"=>"failure", "message"=>"Only admin can delete this hierarchy!");
        }
        echo postRequestResponse($ajax_response);
    }
    
    public function ajax_hierarchy() {
        if($this->emp_group == "admin") {
			$data['hierarchies']= $this->hmm->get_allhierarchyDetails();
			$data['lob']        = $this->hmm->get_lob();
			$data['campaign']   = $this->hmm->get_campaign();
			$data['vendor']     = $this->hmm->get_vendor();
			$data['location']   = $this->hmm->get_location();
            $this->load->view('admin/hierarchy_management_ajax', $data);
		}
        else{
        	$data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);	
        }
    }
	
	public function formType(){
		$frm_type = $this->input->post('type');
		if(!empty($frm_type)){
			$data = $this->hmm->get_form_name($frm_type);
			$opt = "<option value=''>Select</option>";
			foreach ($data as $key => $value) {
				$opt .= "<option value='".$value['form_name']."'>".$value['form_name']."</option>";
			}
			$opt;
		}
		else
			$opt = "<option value=''>Select</option>";
		echo postRequestResponse($opt);
	}
}
