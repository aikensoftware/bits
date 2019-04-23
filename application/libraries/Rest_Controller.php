<?php
class REST_Controller extends CI_Controller
{
    var $vkey = 'fnaifh84659290';
    public function __construct()
    {
        parent::__construct();
		header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
    }

    public function respon($data,$result = true)
    {
		$respon = array();
		if($result)
			$respon = array("message" => "success","result"=> $data);
		else
			$respon = array("message" => "error","result"=> $data);
			
		return json_encode($respon);
    }
	
	public function token_auth($tkey)
    {
		try
		{
			if($this->vkey == $tkey)
				return true;
			else
				return false;
		}
		catch(Exception $e)
		{
			return false;
		}
		
			
		return json_encode($respon);
    }
	
	
}