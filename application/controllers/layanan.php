<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layanan extends CI_Controller {
	
	public function add($id = "")
	{
		$this->load->model("layanan_model");
		$ss = $this->session->userdata('ista_logged');
		$judul = 'TAMBAH DATA LAYANAN';
		$form_manage = $this->layanan_model->display_form_layanan($id);

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
						   'title' => 'Ubah Layanan',
						   '_templateView_' => $this->layanan_model->display_form_layanan($id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'Update Layanan',
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

		$this->db->delete('layanan', array('id_layanan' => $id));		
		$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dihapus.!');
		
		redirect('layanan');
	}

	public function remove()
	{
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$this->db->delete('layanan', array('id_layanan' => $chk[$x]));
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Dihapus.!');
		else:
			$this->session->set_flashdata('admin_login_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect('layanan');
	}

	
	public function save()
	{
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		$data['nama'] 	= $post['nama'];
		$data['harga'] 	= $post['harga'];
		$data['ket'] 	= $post['ket'];
		$data['id_agen'] 	= $ss['ss_idagen'];
		$data['id_patner']	= $ss['ss_idpatner'];
		
		 $id=$post['id_layanan'];
		 if(empty($id)){
			$this->db->insert('layanan', $data);
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Ditambah.!');
		
		 } else {
		 	$this->db->update('layanan', $data, array('id_layanan' => $post['id_layanan']));
			$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dirubah.!');
		
		 }

		redirect('layanan');
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
		$this->load->model("layanan_model");
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA BANTUAN',
						   '_templateView_' => $this->layanan_model->display_master_layanan(),
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
