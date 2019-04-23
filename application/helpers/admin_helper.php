<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	

	function cekLogin(){
		$CI =& get_instance();
        if(!$CI->session->userdata('isLogin1')){
            redirect('login');
        }
    }
	
	function cekLoginStatus($form = "admin",$isRedirect = false){
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
	
	function getStatus()
	{
		$CI =& get_instance();
		return $CI->session->userdata('loginstatus');
	}
	function getLoginName()
	{
		$CI =& get_instance();
		return $CI->session->userdata('name');
	}
	
	function getLoginID()
	{
		$CI =& get_instance();
		return $CI->session->userdata('isLogin1');
	}
