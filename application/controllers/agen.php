<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agen extends CI_Controller {
	
	public function add($id = "")
	{
		$this->load->model("agen_model");
		$ss = $this->session->userdata('ista_logged');
		$judul = 'TAMBAH DATA PATNER';
		$form_manage = $this->agen_model->display_form_agen($id);

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
		$this->load->model("agen_model");
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):

			$datax = array('url' => base_url(),
						   'title' => 'Ubah Patner',
						   '_templateView_' => $this->agen_model->display_form_agen($id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'Edit Patner',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;
	}
	public function editById($id)
	{
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):

			$datax = array('url' => base_url(),
						   'title' => 'Ubah Profil',
						   '_templateView_' => $this->bantuan_model->display_form_editById($id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'Edit Profil',
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

		$this->db->delete('patner', array('id_patner' => $id));		
		$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dihapus.!');
		
		redirect('agen');
	}

	public function remove()
	{
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$this->db->delete('patner', array('id_patner' => $chk[$x]));
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Dihapus.!');
		else:
			$this->session->set_flashdata('admin_login_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect('agen');
	}

	public function cari_agen()
	{
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		
		$this->session->set_userdata('pilih_agen', $post['pilih_agen']);
		
		redirect('agen');
	}
	
	public function save()
	{
		$ss = $this->session->userdata('ista_logged');
		$id_agen = $ss['ss_idagen'];
		$post = $this->input->post();
		$data['nama'] 	= $post['nama'];
		$data['alamat'] = $post['alamat'];
		$data['telp'] 	= $post['telp'];
		$data['prosen'] = $post['prosen'];
		$data['id_agen'] = $id_agen;
		
		 $id=$post['id_patner'];
		 if(empty($id)){
			$this->db->insert('patner', $data);
			$id_baru = $this->db->insert_id();
			switch (strlen($id_baru)) 
			{    
				case 1 : $kode = "000".$id_baru; 
				break; 			
				case 2 : $kode = "00".$id_baru; 
				break;  
				case 3 : $kode = "0".$id_baru; 
				break;  
				default: $kode = $id_baru;    
			}  
			
			$inisial = 'R';
			if($id_agen == 1){
				// madiun kode R
				$inisial = 'R';
			}else if($id_agen == 2){
				// cirebon kode C
				$inisial = 'C';
			}else if($id_agen == 3){
				// bengkulu kode B
				$inisial = 'B';
			}
			$kode = $inisial.''.$kode;
			$this->db->where('id_patner', $id_baru);
			$this->db->update('patner', array('kode'=> $kode));
			
			## daftar ke tb admin untuk login
			
			$password = 1234567;
			$db_user = array(
								'username' 	=> $kode,
								'password' 	=> md5($password),
								'email'		=> $kode.'@gmail.com',
								'nama_admin'=> $post['nama'],
								'id_patner'	=> $id_baru,
								'id_agen'	=> $id_agen
								);
			$this->db->insert('admin', $db_user);
			
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Ditambah.!');
		
		 } else {
		 	$this->db->update('patner', $data, array('id_patner' => $post['id_patner']));
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dirubah.!');
		
		 }

		redirect('agen');
	}
	public function savewarga()
	{
		$ss = $this->session->userdata('ista_logged');
		$data['id_data']=$this->input->post('id');
		$chk = $this->input->post('bantuan');
		$this->db->delete('bantuan_detail', array('id_data' => $data['id_data']));		
		if(!empty($chk)){
			for($x=0; $x<count($chk); $x++)
			{
				$data['id_bantuan']=$chk[$x];
				// $qry = $this->db->get_where('bantuan_detail', $data);
				// if($qry->num_rows()<1){
				$this->db->insert('bantuan_detail', $data);
				// }
			}
		}
		$this->session->set_flashdata('admin_login_msg', 'Data Bantuan Telah Tersimpan.');

		redirect($_SERVER['HTTP_REFERER']);
	}

	
	public function add1($id)
	{
		$ss = $this->session->userdata('ista_logged');
		$get = $this->input->get();
		$data['id_bantuan'] = $get['idbantuan'];
		$data['id_data'] = $id;

		$this->db->insert('bantuan_detail', $data);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function addAll()
	{
		$data['id_bantuan']=$this->input->post('idbantuan');
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$data['id_data']=$chk[$x];
				$this->db->insert('bantuan_detail', $data);
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Ditambahkan.!');
		else:
			$this->session->set_flashdata('admin_login_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect($_SERVER['HTTP_REFERER']);
	}
	public function del1($id)
	{
		$ss = $this->session->userdata('ista_logged');
		$get = $this->input->get();
		$data['id_bantuan'] = $get['idbantuan'];
		$data['id_data'] = $id;

		$this->db->delete('bantuan_detail', $data);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function dellAll()
	{
		$data['id_bantuan']=$this->input->post('idb');
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$data['id_data']=$chk[$x];
				$this->db->delete('bantuan_detail', $data);
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Dihapus.!');
		else:
			$this->session->set_flashdata('admin_login_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function seting(){
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA BANTUAN',
						   '_templateView_' => $this->bantuan_model->display_master_bantuan(),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA BANTUAN',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}
	
	public function index()
	{
		$this->load->model("agen_model");
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA PATNER',
						   '_templateView_' => $this->agen_model->display_master_agen(),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA PATNER',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}
	public function warga($id)
	{
	
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA KATEGORI',
						   '_templateView_' => $this->bantuan_model->display_warga($id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA KATEGORI',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}
	public function addwarga($id)
	{
	
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA AGAMA',
						   '_templateView_' => $this->bantuan_model->display_wargaToAdd($id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA AGAMA',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}

}
