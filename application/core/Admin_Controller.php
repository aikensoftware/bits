<?php
class Admin_Controller extends CI_Controller
{
    public function __construct()
    {
	
        parent::__construct();
		header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		require_once APPPATH . 'libraries/PHPMailer/PHPMailerAutoload.php';
		
		$this->cekLogin();
			
    }
	
	private function cekLogin() {
        
        $ss = $this->session->userdata('ista_logged');
        
        if(!$ss['ista_adminid']){
            redirect('login');
        }
    }
	
	public function cekLoginStatus($form = "admin",$isRedirect = false){
		$status = false; 
	
        if($this->getStatus() === false){
            $status =  false;
        }
		else
		{
			if($form == "admin" && $this->getStatus() == "1")
				$status =  true;
			else if ($form == "user" && $this->getStatus() == "2")
				$status =  true;
		}
		if($status)
		{
			return $status;
		}
		else
		{
			if($isRedirect)
			{
				redirect('dashboard');
			}
			else
				return $status;
		}	
    }
	
	public function getLoginName()
	{
		return $this->session->userdata('ista_name');
	}
	
	public function getLoginID()
	{
		return $this->session->userdata('ista_nim');
	}		
}