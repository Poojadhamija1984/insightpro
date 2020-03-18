<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentController extends MY_Controller {
	
	public function index(){
		$data['title'] = 'Payment';
		$data['cinfo']	=	$this->clientData[0]; // client info
		$data['pinfo']  =   $this->common->getAllData('subscription_details');
		//print_r($data['pinfo']);die;
		$this->load->view('payment/payment',$data);
	}	

	public function invoice(){
		if($this->emp_group == "admin"){
			$data['client_id']		= 	$this->client_id;
			$cpd 					= 	date('d',strtotime($this->clientData[0]->client_plan_created_date));
			$data['pd']				= 	date('Y-m-'.$cpd.''); // payment Date
			$data['lpd'] 			= 	date('Y-m-d',strtotime($data['pd'] . " +30 days")); // last payment date
			$data['cname']			=	$this->clientData[0]->client_first_name.' '.$this->clientData[0]->client_last_name;
			$data['cpno']			=	$this->clientData[0]->client_phone_no;
			$data['cloc']			=	$this->clientData[0]->client_location;
			$data['cemail']			=	$this->clientData[0]->client_email;
			$data['agent']			=	count($this->common->getWhere('agent',['client_id'=>$data['client_id'],'agent_created_date >=' => $data['pd'],'agent_created_date <=' => $data['lpd']]));
			//print_r($data);die;
			$this->load->view('payment/invoice',$data);
		}
		else{
            $data['title']  =   "Access Denied";
        	$this->load->view('permission_denied',$data);   
	    }
	}

	public function paymet($price,$client_id){
		print_r(['price'=>$price,'client id' =>$client_id]);
		//next step 
		// send data to Payment page
		// receve data from success page and create the data base according to payment response
	}
	public function upgradeSubscriptionPlan($planType){
		$decode = decode($planType);
		switch ($decode) {
			case 'small':
				$pt = 1;
				break;
			case 'large':
				$pt = 2;
				break;
			case 'enterprise':
				$pt = 3;
				break;
			case 'free':
				$pt = 0;
				break;		
			default:
				$pt = -1;
				break;			
		}
		$pinfo = $this->getSubscriptionDetails();
		$subDetails = $this->searchArrayKeyVal("sd_type", $pt, $pinfo);
		if ($subDetails !== false) {
			$price = $pinfo[$subDetails]['sd_price'];
			$sd_id = $pinfo[$subDetails]['sd_id'];
			$sd_name = $pinfo[$subDetails]['sd_name'];
		} else {
			echo "Not a valid Plan";die;
		}
		$data = [
					'client_plan_type' 			=> 	$sd_id,
					'transection_id' 			=> 	'transection_id',
					'transection_amount' 		=> 	'transection_amount',
					'transection_date' 			=> 	'transection_date',
					'client_plan_created_date' 	=> 	date('Y-m-d H:i:s'),
					'client_plan_expierd_date' 	=> 	date('Y-m-d H:i:s', strtotime('+30 day', strtotime(date('Y-m-d H:i:s')))),
					'is_completed_status' 		=> '5'
				];
		$updateSub = $this->common->update_data('client',$data,['client_id'=>$this->client_id]);

		$client_db = $this->load->database('db3', TRUE);
		$client_db->where(['client_id'=>$this->client_id]);
        $rsult = $client_db->update('client', $data);
		
		if($updateSub == "data has successfully been updated"){
			header('Refresh:5; url= '. site_url().'/Subscription');
			echo "<p>Subscription Upgrade to $sd_name successfully! <br>Please Wait You will be redirected in <span id='counter'>5</span> second(s).</p>
			<script>
				function countdown() {
    				var i = document.getElementById('counter');
    				if (parseInt(i.innerHTML)<=0) {
        				
    				}
					if (parseInt(i.innerHTML)!=0) {
    					i.innerHTML = parseInt(i.innerHTML)-1;
					}
				}
				setInterval(function(){ countdown(); },1000);
			</script>
			";
		}
		else{
			echo "Some Error Please Try again";
		}
		die;
	}

	public function getSubscriptionDetails(){
		$client_db = $this->load->database('db3', TRUE);
		$client_db->select ('*');
		$client_db->from ('subscription_details');
		$query = $client_db->get();
		return $query->result_array();
	}
	public function sbs_payment()
	{
		$this->load->view('admin/subscrion_payment');
	}

	function searchArrayKeyVal($sKey, $id, $array) {
	   foreach ($array as $key => $val) {
		   if ($val[$sKey] == $id) {
			   return $key;
		   }
	   }
	   return false;
	}
//please write above	
}

