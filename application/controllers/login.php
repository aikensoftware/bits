<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{
		header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		
		$datax = array('title' => 'Login',
					   'url' => base_url()
				 );
		
		$this->parser->parse('login', $datax);
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
				$sess_array = array('ista_adminid' 		=> $l->admin_id,
									'ista_adminuname' 	=> $l->username,
									'ista_adminame' 	=> strtoupper($l->nama_admin),
									'ista_adminemail' 	=> $l->email,
									'ista_foto_admin'	=> $l->foto_adminfoto_adminfoto_admin,
									'ss_idagen'			=> $l->id_agen,
									'ss_idpatner'		=> $l->id_patner,
									'ss_rt'				=> $l->rt
						  	  );
				
				$this->session->set_userdata('ista_logged', $sess_array);

				$sess_data['statusAktif']  = 1;
				$this->session->set_userdata($sess_data);
				
			}
			$this->session->set_flashdata('admin_login_msg', 'Selamat Datang');
			redirect('dashboard');
		}
		
		else
		{
			$this->session->set_flashdata('admin_login_msg', 'username atau password salah');
			redirect('login');	
		}
	}
	public function logout()
	{
		// $this->session->unset_userdata('ista_uid');
		// $this->session->unset_userdata('ista_name');
		// $this->session->unset_userdata('ista_nim');
		// $this->session->unset_userdata('ista_hashval');

		$this->session->sess_destroy();
		redirect('login');
	}	
	public function cekLogin()
	{
		if($this->session->userdata('uid'))
			redirect('main');
	}
}

?>
