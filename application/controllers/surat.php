<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surat extends CI_Controller {
	
	public function add($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		define('RT', $ss['ss_rt']);
		$judul = 'BUAT SURAT KETERANGAN';
		$form_manage = $this->ktp_model->display_form_surat($id);

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
						   '_templateView_' => $this->ktp_model->display_form_usia($id),
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
		//$rs=$this->ktp_model->get_kerja($id);

		$this->db->delete('kategoryusia', array('id_usia' => $id));		
		$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dihapus.!');
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function remove()
	{
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$this->db->delete('kategoryusia', array('id_usia' => $chk[$x]));
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
		$data['id_data'] = $post['id_data'];

		if($post['jns_warga']==1){
			$rs=$this->ktp_model->get_penduduk($data['id_data']);
			$data['nik']=$rs['nik'];
			$data['nama']=$rs['nama_lengkap'];
			$data['tempat_lahir']=$rs['tempat_lahir'];
			$data['tgl_lahir']=$rs['tgl_lahir'];
			if($rs['nik']==1){
				$data['jenis_kel']= "Laki-laki";
			} else {
				$data['jenis_kel']= "Perempuan";
			}
			$data['status_kawin']= $this->ktp_model->get_status_kawin($rs['status_kawin'])['nama_kawin'];
			$data['agama']=$this->ktp_model->get_agama($rs['agama'])['nama_agama'];
			$data['pekerjaan']=$this->ktp_model->get_kerja($rs['pekerjaan'])['nama_kerja'];
			$data['alamat']=$rs['alamat'];
		} else {
			//$data['id_data']="-";
			$data['nik']=$post['nik'];
			$data['nama']=$post['nama'];
			$data['tempat_lahir']=$post['tempat_lahir'];

			$var = $post['tgl_lahir'];
			$tgl_lahir = str_replace('/', '-', $var); //ganti slash biar nggak dianggap mm/dd
			$data['tgl_lahir'] = date('Y-m-d', strtotime($tgl_lahir));
	

			
			$data['jenis_kel']= $post['jk'];

			$data['status_kawin']= $post['status_kawin'];
			$data['agama']=$post['agama'];
			$data['pekerjaan']=$post['pekerjaan'];
			$data['alamat']=$post['alamat'];

		}

		$data['no_surat'] = $post['no_surat'];
		if($post['keperluan']!="lain"){
			$data['keperluan'] = $post['keperluan'];
		} else {
			$data['keperluan'] = $post['lainnya'];
		}
		$var = $post['tgl_buat'];
		$tgl_buat = str_replace('/', '-', $var); //ganti slash biar nggak dianggap mm/dd
		$data['tgl_surat'] = date('Y-m-d', strtotime($tgl_buat));
		$data['rt']=$ss['ss_rt'];

		

		 $id=$post['id'];
		 if(empty($id)){
			$this->db->insert('surat', $data);
			$id = $this->db->insert_id();
		 } else {
		 	$this->db->update('surat', $data, array('id' => $post['id']));
		 }

		redirect('surat/view/'.$id);
	}
	public function view($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$judul = 'BUAT SURAT KETERANGAN';
		$form_manage = $this->ktp_model->display_surat($id);

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
	
	public function index()
	{
	
	$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA SURAT',
						   '_templateView_' => $this->ktp_model->display_master_surat(),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA SURAT',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}

}
