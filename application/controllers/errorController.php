<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class errorController extends CI_Controller {
	public function __construct() {
    	parent::__construct(); 
 	} 
 	public function error404() { 
    	$this->output->set_status_header('404'); 
    	$this->load->view('err404');//loading in custom error view
 	} 
} 