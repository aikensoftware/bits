<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public function index()
	{
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DASHBOARD',
						   '_templateView_' => $this->parser->parse('dashboard', $data, TRUE),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'PROFIL',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;
	}

	
	public function add($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$judul = 'TAMBAH DATA KTP';
		$form_manage = $this->ktp_model->display_form_ktp($id);

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
						   '_templateView_' => $this->ktp_model->display_form_ktp($id),
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
	public function in()
	{
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):

			$datax = array('url' => base_url(),
						   'title' => 'WARGA BARU PINDAHAN',
						   '_templateView_' => $this->ktp_model->display_form_ktp('pindahan'),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'WARGA BARU PINDAHAN',
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
		$rs=$this->ktp_model->get_penduduk($id);

		$this->db->delete('data', array('id' => $id));		
		$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dihapus.!');
		
		redirect('main/show');
	}

	public function remove()
	{
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$this->db->delete('data', array('id' => $chk[$x]));
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Dihapus.!');
		else:
			$this->session->set_flashdata('dashboard_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect($_SERVER['HTTP_REFERER']);
	}

	
	public function save()
	{

		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();
		$data['nik'] = $post['nik'];
		$data['nama_lengkap'] = $post['nama'];
		$data['tempat_lahir'] = $post['tpt_lahir'];
		$data['no_kk'] = $post['no_kk'];
		$data['jenis_kel'] = $post['jk'];
		$data['agama'] = $post['agama'];
		$data['pendidikan'] = $post['pendidikan'];
		$data['pekerjaan'] = $post['kerja'];

		$var = $post['tgl_lahir'];
		$tgl_lahir = str_replace('/', '-', $var); //ganti slash biar nggak dianggap mm/dd
		$data['tgl_lahir'] = date('Y-m-d', strtotime($tgl_lahir));

		$data['alamat'] = $post['alamat'];
		//$data['rt_rw'] = $post['rtrw'];
		$data['rt_rw'] = $ss['ss_rt']."/".RW;
		
		$data['kel_desa'] = $post['desa'];
		$data['kec'] = $post['kec'];
		$data['status_kawin'] = $post['status_kawin'];
		$data['statusdikeluarga'] = $post['status_hubungan'];
		$data['kewarganegaraan'] = $post['kewarganegaraan'];

		$data['no_paspor'] = $post['no_paspor'];
		$data['no_kita'] = $post['no_kita'];
		$data['nama_ayah'] = $post['nama_ayah'];
		$data['nama_ibu'] = $post['nama_ibu'];


		$data['kota_pembuat'] = $post['kota'];

		$var = $post['tgl_buat'];
		$tgl_buat = str_replace('/', '-', $var); //ganti slash biar nggak dianggap mm/dd
		$data['tgl_buat'] = date('Y-m-d', strtotime($tgl_buat));

		$data['masa_berlaku'] = date("Ymd");

		if(!empty($post['mutasi'])){
			$data['mutasi']='2';
		}

		if(!empty($_FILES['foto']['name']))
		{
			$path = $_FILES['foto']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
						 
			$data['foto'] = date("Ymdhis")."_PHOTO".".".$ext;
			
			$folder = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/photo/".$post['nik'];
				
			if(!file_exists($folder))
				mkdir($folder,0777,true);
					
			move_uploaded_file($_FILES['foto']['tmp_name'], $folder.'/'.$data['foto']);						
		}

		if(!empty($_FILES['ttd']['name']))
		{
			$path = $_FILES['ttd']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
						 
			$data['tanda_tangan'] = date("Ymdhis")."_TTD".".".$ext;
			
			$folder = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/ttd/".$post['nik'];
				
			if(!file_exists($folder))
				mkdir($folder,0777,true);
					
			move_uploaded_file($_FILES['ttd']['tmp_name'], $folder.'/'.$data['tanda_tangan']);						
		}

		 $id=$post['id'];
		 if(empty($id)){
			$this->db->insert('data', $data);
		 } else {
		 	$this->db->update('data', $data, array('id' => $post['id']));
		 }

		redirect('main/show');
	}
	

	public function savemutasi()
	{

		$ss = $this->session->userdata('ista_logged');
		$post = $this->input->post();

		$var = $post['tgl_buat'];
		$tgl_buat = str_replace('/', '-', $var); //ganti slash biar nggak dianggap mm/dd
		$data['waktu_update'] = date('Y-m-d', strtotime($tgl_buat));

		$data['mutasi']=$post['mutasi'];
		$data['ket_mutasi']=$post['ket'];
		$data['aktif']=2;
	 	$this->db->update('data', $data, array('id' => $post['id']));

		redirect('main/mutasi');
	}
	

	public function show($id="")
	{

	
		$ss = $this->session->userdata('ista_logged');
		if(!empty($id) && $id='nonaktif'){
			$display=$this->ktp_model->display_master_ktpnonaktif();
		}else{
			$display=$this->ktp_model->display_master_ktp();
		}
		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA KTP',
						   '_templateView_' => $display,
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'LINK FILE',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;	
	}

	public function mutasi($id="")
	{
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):

			if(!empty($id)){
				$display=$this->ktp_model->display_form_editById($id);
			} else {
				$display=$this->ktp_model->display_data_mutasi();
			}
			$datax = array('url' => base_url(),
						   'title' => 'Ubah Profil',
						   '_templateView_' => $display,
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

}
