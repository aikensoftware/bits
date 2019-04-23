<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
	
	public function add($id = "")
	{

		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =25;
		$daftar_hari_boleh[3] =26;
		$daftar_hari_boleh[4] =27;
		$daftar_hari_boleh[5] =28;
		$daftar_hari_boleh[6] =29;
		$daftar_hari_boleh[7] =30;
		$daftar_hari_boleh[8] =31;
		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect(site_url('pelanggan'));
		}

		$ss = $this->session->userdata('ista_logged');
		$judul = 'TAMBAH DATA PELANGGAN';
		$this->load->helper('form');
		$this->load->model('umum');
		$form_manage = $this->load->view('tag_pelanggan/tag_pelanggan_form','',TRUE);

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
						   'title' => 'Ubah Bantuan',
						   '_templateView_' => $this->bantuan_model->display_form_bantuan($id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'Edit Bantuan',
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

		$this->db->delete('bantuan', array('id' => $id));		
		$this->session->set_flashdata('admin_login_msg', 'Data Berhasil Dihapus.!');
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function remove()
	{
		$chk = $this->input->post('chkDetail');


		if(!empty($chk)):

			for($x=0; $x<count($chk); $x++)
			{
				$this->db->delete('bantuan', array('id' => $chk[$x]));
			}
			$this->session->set_flashdata('admin_login_msg', 'Data Terpilih Berhasil Dihapus.!');
		else:
			$this->session->set_flashdata('admin_login_msg', 'Tidak ada Data yang Dipilih.!');
		endif;

		redirect($_SERVER['HTTP_REFERER']);
	}

	
	public function save()
	{
		
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =25;
		$daftar_hari_boleh[3] =26;
		$daftar_hari_boleh[4] =27;
		$daftar_hari_boleh[5] =28;
		$daftar_hari_boleh[6] =29;
		$daftar_hari_boleh[7] =30;
		$daftar_hari_boleh[8] =31;
		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect(site_url('pelanggan'));
		}
		
        // $this->_rules();

        // if ($this->form_validation->run() == FALSE) {
        //     $this->create();
        // } else {
			# tanggal masuk 
			$tanggal_masuk 	= $this->input->post('tanggal_masuk',true);
			$bulan_masuk 	= $this->input->post('bulan_masuk',true);
			$tahun_masuk 	= $this->input->post('tahun_masuk',true);
			$tgl_masuk = $tahun_masuk.'-'.$bulan_masuk.'-'.$tanggal_masuk;
			
			//$acak = $this->umum->acak(40).''.date('Y-m-d');
			
            $data = array(
						'kode' => $this->input->post('kode',TRUE),
						'nama' => $this->input->post('nama',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'telp' => $this->input->post('telp',TRUE),
						'id_layanan' => $this->input->post('id_layanan',TRUE),
						'id_patner' => $this->input->post('id_patner',TRUE),
						'in_pajak' => $this->input->post('in_pajak',TRUE),
						'tanggal_pasang' => $tgl_masuk,
						'status' => $this->input->post('status',TRUE),
						'acak'=>''						
					);

           			 $this->db->insert('pelanggan',$data);
			
					$id_pelanggan = $this->db->insert_id();
					
					switch (strlen($id_pelanggan)) 
					{     
						case 1 : $kode = "000".$id_pelanggan; 
						break;     
						case 2 : $kode = "00".$id_pelanggan; 
						break;  
						case 3 : $kode = "0".$id_pelanggan; 
						break;  
						default: $kode = $id_pelanggan;    
					}  
					
					$kode = 'P'.$kode;
					
			
			if($id_pelanggan >0){
				# proses update
				$up = array('kode' => $kode,'acak' =>'');
				$this->db->where('id_pelanggan', $id_pelanggan);
				$this->db->update('tag_pelanggan',$up);
			}
			
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect('pelanggan');
        //}
		//redirect('pelanggan');
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
		$this->load->model('pelanggan_model');
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			
			$datax = array('url' => base_url(),
						   'title' => 'DATA PELANGGAN',
						   '_templateView_' => $this->pelanggan_model->display_master_pelanggan(),
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
	public function cetak_faktur()
	{
		$bulan_ini = date('m');
		$tahun_ini = date('Y');
		$this->load->model('umum');
		$id_tagihan = $this->uri->segment(3);
		if($id_tagihan > 0){
			$tagihan_bulan_ini = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
												year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
												b.kode, b.nama, b.alamat
												
												from tag_tagihan as a
												left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
												
												where 
												a.id_tagihan 		= $id_tagihan and 
												month(a.tanggal) 	= '$bulan_ini' and 
												year(a.tanggal)		= '$tahun_ini' ");
												
			if($tagihan_bulan_ini->num_rows() >0){
				$b_ini = $tagihan_bulan_ini->row();
				$d['id_tagihan'] 		= $b_ini->id_tagihan;
				$d['bulan_tagihan']		= $this->umum->nama_bulan($b_ini->bulan).' '.$b_ini->tahun;
				$d['nomor_tagihan']		= $b_ini->no_transaksi;
				$d['tanggal_bayar']		= $this->umum->ubah_ke_garis($b_ini->tanggal);
				$d['nama_pelanggan']	= '['.$b_ini->kode.'] '.$b_ini->nama;
				$d['alamat_pelanggan']	= $b_ini->alamat;

				$d['abonemen']			= $b_ini->pokok;
				$d['pajak']				= $b_ini->pajak;
				$d['total']				= $b_ini->pokok + $b_ini->pajak;
				$d['qrcode']			= $b_ini->qrcode;
				
				$this->load->view('tag_pelanggan/print_faktur', $d);
			}else{
				$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
				redirect('tag_pelanggan/cari_data');
			}
			
		}else{
			$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
			redirect('tag_pelanggan/cari_data');
		}
		
	}
	public function printAll()
	{
		$bulan_ini = date('m');
		$tahun_ini = date('Y');
		$pilihan = array();
		$ada = 0;
		$this->load->model('umum');
		// $dt_tagihan = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
		// 									year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
		// 									b.id_pelanggan, b.kode, b.nama, b.alamat
											
		// 									from tag_tagihan as a
		// 									left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
											
		// 									where 
		// 									month(a.tanggal) 	= '$bulan_ini' and 
		// 									year(a.tanggal)		= '$tahun_ini' ");
											
		// foreach($dt_tagihan->result() as $p){
		// 	$nama = "tagihan_in_".$p->id_pelanggan;
		// 	if($this->input->post($nama) > 0){
		// 		$pilihan[] = $p->id_pelanggan;
		// 		$ada = 1;
		// 	}
		// }
		$chk = $this->input->post('chkDetail');
		$v_id_pelanggan = '';
//		if($ada == 1){
			$gabungan = join(',', $chk);
			$v_id_pelanggan = " and b.id_pelanggan in (".$gabungan.")";
//		}
		

		$tagihan_bulan_ini = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
											year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
											b.kode, b.nama, b.alamat
											
											from tag_tagihan as a
											left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
											
											where 
											month(a.tanggal) 	= '$bulan_ini' and 
											year(a.tanggal)		= '$tahun_ini' $v_id_pelanggan
											
											");
											
		if($tagihan_bulan_ini->num_rows() >0){
			$b_ini = $tagihan_bulan_ini->row();
			
			$d['id_tagihan'] 		= $b_ini->id_tagihan;
			$d['data_faktur_all']	= $tagihan_bulan_ini;
			
			$this->load->view('tag_pelanggan/print_faktur', $d);
		}else{
			$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
			redirect('tag_pelanggan/cari_data');
	
		}
		
	}

}
