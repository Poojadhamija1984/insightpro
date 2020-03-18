<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alert extends MY_Controller {

	public function index($id=null){
		
		if($this->emp_group == "admin"){

		        $data['lob'] =  $this->common->getDistinctWhereSelect('hierarchy','lob',['hierarchy_status' => '1']);
               	$editData = $this->common->getWhere('alert',['id'=>$id]);
                $data['editData'] = $editData;
				// get user email and name by lob.
				
                 if($id){
                $where = "FIND_IN_SET('".$editData[0]->lob."', REPLACE(lob,'|||',',')) and usertype='3'"; 
                $data['lobdata'] = $this->common->getWhereSelectAll('user','name, user_email',$where);
                 }
             
                 
		        $data['allData'] = $this->common->getAllData('alert');
		        $data['id'] = $id;
				$data['title'] = 'Alert  Summary';
                $this->form_validation->set_rules('lob','Lob','trim|required');
                if($this->form_validation->run() == false) {
				$this->load->view('admin/alert_view' ,$data);
				}else{

				   if(count($_POST)>0){	
				   $_POST['members'] = implode(',' ,$this->input->post('members'));
				   if($id){
				   		  $inserData = $this->common->update_data('alert',$_POST,['id'=>$id]);
				   } else {
				   		   $inserData = $this->common->insert_data($_POST, 'alert');
				   }
			
					  if($inserData){
					  	$this->session->set_flashdata('message', 'Data submitted Successfully');
						redirect('alert');	
					  } else{
					  	$this->session->set_flashdata('error','Error Occurred');
					  	redirect('alert');
					  }
				   }

				}	
		}
        else{
            $data['title']  =   "Access Denied";
            $this->load->view('permission_denied',$data);   
        }
    }

///

 function change_status(){
 	 $id = $this->input->post('id');
	  $data['status'] = $this->input->post('status');
	  
 	 $reasult =$this->common->update_data('alert',$data,['id'=>$id]);
 	  $csrfTokenName = $this->security->get_csrf_token_name();
      $csrfHash = $this->security->get_csrf_hash();
 	   $data = [
                    'csrfTokenName'=>$csrfTokenName,
                    'csrfHash'=>$csrfHash,
                    'data'=>(($reasult !="not updated")?'Success':'Try Again')                           
                ];
        echo json_encode($data);
 }  

    // 
    function get_members()
    {
    	 $lob  = $this->input->post('lob');
    	  $this->db->select('name, user_email');
    	  $where = "FIND_IN_SET('".$lob."', REPLACE(lob,'|||',',')) and usertype='3'"; 
    	  $this->db->where( $where );
          $data = $this->db->get('user')->result_array();
    	 echo postRequestResponse(['data'=>$data]);
    }
    
   
//please write above	
}
