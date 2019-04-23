<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uang_jenis extends CI_Controller {
	
	public function add($id = "")
	{
		$this->load->model("layanan_model");
		$ss = $this->session->userdata('ista_logged');
		$judul = 'TAMBAH NAMA AKUN';
		$form_manage = $this->layanan_model->display_form_uang_jenis($id);

		$datax = array('url' => base_url(),
					   'title' => $judul,
					   '_templateView_' => $form_manage,
					   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
					   '_topNavigation_' => $this->general_model->topNavigation(),
					   '_menuFooter_' => $this->general_model->menuFooter(),
					   'judul' => $judul,
					   'names' => ucwords($ss['ista_adminame']),
					   'uname' => ucwords($ss['ista_adminuname'])
				 );
		
		$this->parser->parse('template', $datax);
	}
	public function edit($id)
	{
		$this->load->model("layanan_model");
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):

			$datax = array('url' => base_url(),
						   'title' => 'Ubah Nama Akun',
						   '_templateView_' => $this->layanan_model->display_form_uang_jenis($id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'Update Nama Akun',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;
	}
	
	public function delete($id)
	{	

		$this->db->delete('uang_jenis', array('id_jenis' => $id));		
		$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dihapus.!');
		
		redirect('uang_jenis');
	}

	public function remove()
	{
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$this->db->delete('uang_jenis', array('id_jenis' => $chk[$x]));
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Dihapus.!');
		else:
			$this->session->set_flashdata('admin_login_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect('uang_jenis');
	}

	
	public function save()
	{
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		$data['nama_jenis'] 	= $post['nama_jenis'];
		$data['kas'] 			= $post['kas'];
		$data['id_user']		= $ss['ss_idpatner'];
		
		 $id=$post['id_jenis'];
		 if(empty($id)){
			$this->db->insert('uang_jenis', $data);
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Ditambah.!');
		
		 } else {
		 	$this->db->update('uang_jenis', $data, array('id_jenis' => $post['id_jenis']));
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dirubah.!');
		
		 }

		redirect('uang_jenis');
	}
	
	public function index()
	{
		$this->load->model("layanan_model");
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA UANG JENIS',
						   '_templateView_' => $this->layanan_model->display_uang_jenis(),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA UANG JENIS',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}
	
}
