<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class permissionController extends MY_Controller {
	public function index(){
		$data['title'] = "Permission Denied";
		$this->load->view('permission_denied',$data);
	}
}
