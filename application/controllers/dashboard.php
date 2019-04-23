<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
	
	public function index()
	{
		$ss = $this->session->userdata('ista_logged');
		$this->load->model("umum");
		$datax = array('url' => base_url(),
					   'title' => 'DASHBOARD',
					   '_templateView_' => $this->parser->parse('dashboard', $data, TRUE),
					   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
					   '_topNavigation_' => $this->general_model->topNavigation(),
					   '_menuFooter_' => $this->general_model->menuFooter(),
					   //'_dashboard_' => $this->general_model->display_dashboard(),
					   'judul' => 'PROFIL',
					   'names' => ucwords($ss['ista_adminame']),
					   'uname' => ucwords($ss['ista_adminuname'])					   
				 );
		
		$this->parser->parse('template', $datax);
		
		/*
		$datax = array('url' => base_url(),
					   'title' => 'DASHBOARD',
					   '_templateView_' => $this->parser->parse('dashboard', $data, TRUE),
					   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
					   '_topNavigation_' => $this->general_model->topNavigation(),
					   '_menuFooter_' => $this->general_model->menuFooter(),
					   '_dashboard_' => $this->general_model->display_dashboard(),
					   'judul' => 'PROFIL',
					   'names' => ucwords($ss['ista_adminame']),
					   'uname' => ucwords($ss['ista_adminuname']),
					   'extra_script' => $this->ktp_model->chart_kategory_usia()
				 );
		
		$this->parser->parse('template', $datax);
		*/
	}

	public function edit($id)
	{
		$ss = $this->session->userdata('ista_logged');

		$datax = array('url' => base_url(),
					   'title' => 'Ubah Profil',
					   '_templateView_' => $this->general_model->display_edit_comments($id),
					   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
					   '_topNavigation_' => $this->general_model->topNavigation(),
					   '_menuFooter_' => $this->general_model->menuFooter(),
					   '_dashboard_' => $this->general_model->display_dashboard(),
					   'judul' => 'Edit Profil',
					   'names' => ucwords($ss['ista_adminame']),
					   'uname' => ucwords($ss['ista_adminuname'])
				 );
		
		$this->parser->parse('template', $datax);
	}

	public function filterusia()
	{
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		if(isset($post['tgl_buat'])){
			$usia=$post['usia'];
			$var = $post['tgl_buat'];
			$tgl_buat = str_replace('/', '-', $var); //ganti slash biar nggak dianggap mm/dd
			$tgl = date('Y-m-d', strtotime($tgl_buat));
		} else {
			$usia=17;
			$tgl=date("Y-m-d");

		}
		$datax = array('url' => base_url(),
					   'title' => 'Ubah Profil',
					   '_templateView_' => $this->ktp_model->form_filter($tgl,$usia),
					   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
					   '_topNavigation_' => $this->general_model->topNavigation(),
					   '_menuFooter_' => $this->general_model->menuFooter(),
					   '_dashboard_' => $this->general_model->display_dashboard(),
					   'judul' => 'Edit Profil',
					   'names' => ucwords($ss['ista_adminame']),
					   'uname' => ucwords($ss['ista_adminuname'])
				 );
		
		$this->parser->parse('template', $datax);
	}

	public function edit_profile()
	{
		$ss = $this->session->userdata('ista_logged');

		$this->load->model("agen_model");
		
		$datax = array('url' => base_url(),
					   'title' => 'Ubah Profil',
					   '_templateView_' => $this->general_model->display_edit_profile(),
					   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
					   '_topNavigation_' => $this->general_model->topNavigation(),
					   '_menuFooter_' => $this->general_model->menuFooter(),
					   '_dashboard_' => $this->general_model->display_dashboard(),
					   'judul' => 'Edit Profil',
					   'names' => ucwords($ss['ista_adminame']),
					   'uname' => ucwords($ss['ista_adminuname'])
				 );
		
		$this->parser->parse('template', $datax);
	}

	public function edit_password()
	{
		$ss = $this->session->userdata('ista_logged');

		$datax = array('url' => base_url(),
					   'title' => 'Ubah Password',
					   '_templateView_' => $this->general_model->display_edit_password(),
					   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
					   '_topNavigation_' => $this->general_model->topNavigation(),
					   '_menuFooter_' => $this->general_model->menuFooter(),
					   '_dashboard_' => $this->general_model->display_dashboard(),
					   'judul' => 'Ubah Password',
					   'names' => ucwords($ss['ista_adminame']),
					   'uname' => ucwords($ss['ista_adminuname']),
					   'extra_script' => 'var password = document.getElementById("new_pass")
										  , confirm_password = document.getElementById("new_pass1");

										function validatePassword(){
										  if(password.value != confirm_password.value) {
										    confirm_password.setCustomValidity("Password tidak sama");
										  } else {
										    confirm_password.setCustomValidity(\'\');
										  }
										}

										password.onchange = validatePassword;
										confirm_password.onkeyup = validatePassword;
					   '
				 );
		
		$this->parser->parse('template', $datax);
	}
	
	public function save_profile()
	{
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		
		// update di tabel login admin
		
		$arr = array(
					'nama_admin' 	=> $post['nama'],
					'email'			=> $post['email']	
					);
		$this->db->where('id_patner', $ss['ss_idpatner']);
		$this->db->update('admin', $arr);
		
		// update di tabel patner
		$arr_dua = array(
					'nama' 		=> $post['nama'],
					'alamat'	=> $post['alamat'],
					'telp'		=> $post['telp'],
					);
		$this->db->where('id_patner', $ss['ss_idpatner']);
		$this->db->update('patner', $arr_dua);
		
		$this->session->set_flashdata('admin_login_msg', 'Profil Telah Berubah');
		redirect('dashboard');
	}
	
	public function save_password()
	{
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		$password = $post['new_pass'];
		
		$arr = array('password' => md5($password));

		$this->db->update('admin', $arr, array('admin_id' => $ss['ista_adminid']));
		$this->session->set_flashdata('admin_login_msg', 'Password Telah Berubah');
		redirect('dashboard');
	}

}
