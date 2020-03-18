<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_payment extends MY_Controller {
	public function index(){
	//print_r($_POST); die;

		$this->load->view('admin/sub_payment');
		}
		public function success()
		{
			$this->load->view('admin/success');
		}
		public function failure()
		{
			$this->load->view('admin/failure');
		}

}