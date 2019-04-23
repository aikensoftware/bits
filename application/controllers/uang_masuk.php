<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uang_masuk extends CI_Controller {
	
	public function add($id = "")
	{
		$this->load->helper('form');
		$this->load->model("layanan_model");
		$ss = $this->session->userdata('ista_logged');
		$judul = 'TAMBAH UANG MASUK';
		$form_manage = $this->layanan_model->display_form_uang_masuk($id);

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
		
	public function save()
	{
		//id_masuk, no_masuk, tgl_masuk, ket, jumlah, id_jenis, id_user
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		
		$tgl_masuk = $post['tgl_masuk'];
		$pecah = explode(' ',$tgl_masuk);
		//16/04/2019 07:03:22
		$exp = explode('/',$pecah[0]);
		if(count($exp) == 3) {
			$tahun 	= $exp[2];
			$bulan 	= $exp[1];
			$hari 	= $exp[0];
		}
		
		$tgl_masuk = date($tahun.'-'.$bulan.'-'.$hari.' '.'H:i:s', time());
	
		$data['tgl_masuk'] 		= $tgl_masuk;
		$data['ket'] 			= $post['ket'];
		$data['jumlah'] 		= $post['jumlah'];
		$data['id_jenis'] 		= $post['id_jenis'];
		$data['id_user']		= $ss['ss_idpatner'];
		
		 $id=$post['id_masuk'];
		 if(empty($id)){
			$this->db->insert('uang_masuk', $data);
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Ditambah.!');
		
		 } else {
		 	$this->db->update('uang_masuk', $data, array('id_masuk' => $post['id_masuk']));
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dirubah.!');
		
		 }

		redirect('uang_masuk');
	}
	
	public function index()
	{
		$this->load->model("layanan_model");
		$this->load->model("umum");
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA UANG MASUK',
						   '_templateView_' => $this->layanan_model->display_uang_masuk(),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA UANG MASUK',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}
	
}
