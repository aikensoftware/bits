<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hubungan extends CI_Controller {
	
	public function add($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$judul = 'TAMBAH DATA STATUS HUB KELUARGA';
		$form_manage = $this->ktp_model->display_form_hubungan($id);

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
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):

			$datax = array('url' => base_url(),
						   'title' => 'Ubah Profil',
						   '_templateView_' => $this->ktp_model->display_form_hubungan($id),
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
		$rs=$this->ktp_model->get_status_hubungan($id);

		$this->db->delete('status_hubungan', array('id_hubungan' => $id));		
		$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dihapus.!');
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function remove()
	{
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$this->db->delete('status_hubungan', array('id_hubungan' => $chk[$x]));
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Dihapus.!');
		else:
			$this->session->set_flashdata('admin_login_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect($_SERVER['HTTP_REFERER']);
	}

	
	public function save()
	{
		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		$data['nama_hubungan'] = $post['nama'];

		 $id=$post['id'];
		 if(empty($id)){
			$this->db->insert('status_hubungan', $data);
		 } else {
		 	$this->db->update('status_hubungan', $data, array('id_hubungan' => $post['id']));
		 }

		redirect('hubungan');
		}
	
	public function index()
	{
	
	$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA hubungan',
						   '_templateView_' => $this->ktp_model->display_master_hubungan(),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA hubungan',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}

}
