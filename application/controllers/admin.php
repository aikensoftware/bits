<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function index()
	{
		header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		
		$datax = array('title' => 'Login',
					   'url' => base_url()
				 );
		
		$this->parser->parse('login2', $datax);
	}

	public function auth()
	{		
		$id = $this->input->post('id');
		$password = $this->input->post('password');
		
		$log = $this->general_model->login_cek_admin($id, $password);
			
		if($log)
		{
			$sess_array = array();
			foreach($log as $l){
				$sess_array = array('ista_adminid' => $l->admin_id,
									'ista_admiuname' => $l->username,
									'ista_adminame' => $l->nama_admin,
									'ista_adminemail' => $l->email
						  	  );

				$this->session->set_userdata('ista_adm_logged', $sess_array);
			}

			redirect('main');
		}
		
		else
		{
			$this->session->set_flashdata('admin_login_msg', 'username atau password salah');
			redirect('admin');	
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('ista_adminid');
		$this->session->unset_userdata('ista_adminame');
		$this->session->unset_userdata('ista_adminpass');

		$this->session->sess_destroy();
		redirect('login');
	}	
	public function cekLogin()
	{
		if($this->session->userdata('uid'))
			redirect('dashboard');
	}
}

?>
