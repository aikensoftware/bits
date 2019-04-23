<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
	
	public function coba()
	{
		///	username, password, email, nama_admin, id_patner, id_agen
		$password = '21232f297a57a5a743894a0e4a801fc3';
		
		$rs = $this->db->get("patner");
		foreach($rs->result() as $n){
			$data =array(
						'username' 	=> $n->kode,
						'password'	=> $password,
						'email'		=> $n->kode.'@biznet.net',
						'nama_admin'=> $n->nama,
						'id_patner'	=> $n->id_patner,
						'id_agen'	=> $n->id_agen
								
						);
			//$this->db->insert('admin', $data);
		}
	}
	
	public function add($id = "")
	{

		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =21;
		$daftar_hari_boleh[3] =22;
		$daftar_hari_boleh[4] =23;
		$daftar_hari_boleh[5] =24;
		$daftar_hari_boleh[6] =25;
		$daftar_hari_boleh[7] =26;
		$daftar_hari_boleh[8] =27;
		$daftar_hari_boleh[9] =28;
		$daftar_hari_boleh[10] =29;
		$daftar_hari_boleh[11] =30;
		$daftar_hari_boleh[12] =31;
		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('admin_login_msg', 'Tidak boleh diakses ');
            redirect('pelanggan');
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
		$daftar_hari_boleh[2] =21;
		$daftar_hari_boleh[3] =22;
		$daftar_hari_boleh[4] =23;
		$daftar_hari_boleh[5] =24;
		$daftar_hari_boleh[6] =25;
		$daftar_hari_boleh[7] =26;
		$daftar_hari_boleh[8] =27;
		$daftar_hari_boleh[9] =28;
		$daftar_hari_boleh[10] =29;
		$daftar_hari_boleh[11] =30;
		$daftar_hari_boleh[12] =31;
		
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
	public function create_qrcode()
	{
		# kode update jika qrcode kosong
		$this->load->model('umum');
		$cari_data = $this->db->query("select * from tag_tagihan where qrcode ='' ");
		if($cari_data->num_rows() >0){
			$ada = 0;
			foreach($cari_data->result() as $b){
				
				$acak = $this->umum->acak_qrcode(10);
				
				$id_tagihan = $b->id_tagihan;
				//$up = array('qrcode' => $acak );
				//$this->db->where('id_tagihan', $id_tagihan);
				//$this->db->update('tag_tagihan', $up);
				$ada = 1;
				$updateArray[] = array(
					'id_tagihan'	=> $id_tagihan,
					'qrcode' 		=> $acak
				);
			}
			if($ada == 1){
				$this->db->update_batch('tag_tagihan',$updateArray, 'id_tagihan'); 
			}
			
			$this->session->set_flashdata('message', 'Sukses membuat QR code');
            redirect('pelanggan');
		}else{
			$this->session->set_flashdata('message', 'GAGAL membuat QR code');
            redirect('pelanggan');
		}
		
	}
    public function update_action() 
    {
    	$this->load->model('pelanggan_model');
		$this->load->model('layanan_model');
		
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =21;
		$daftar_hari_boleh[3] =22;
		$daftar_hari_boleh[4] =23;
		$daftar_hari_boleh[5] =24;
		$daftar_hari_boleh[6] =25;
		$daftar_hari_boleh[7] =26;
		$daftar_hari_boleh[8] =27;
		$daftar_hari_boleh[9] =28;
		$daftar_hari_boleh[10] =29;
		$daftar_hari_boleh[11] =30;
		$daftar_hari_boleh[12] =31;

		
		$hari_ini = date('j');
		
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect('pelanggan');
		}
		
        //$this->_rules();

        //if ($this->form_validation->run() == FALSE) {
          //  $this->update($this->input->post('id_pelanggan', TRUE));
        //} else {
			# tanggal masuk 
			$tanggal_masuk 	= $this->input->post('tanggal_masuk',true);
			$bulan_masuk 	= $this->input->post('bulan_masuk',true);
			$tahun_masuk 	= $this->input->post('tahun_masuk',true);
			$tgl_masuk = $tahun_masuk.'-'.$bulan_masuk.'-'.$tanggal_masuk;
			
			//cek perubahan layanan atau tidak
			$idpel=$this->input->post('id_pelanggan', TRUE);
			$this->db->select("id_layanan,status");
			$this->db->from("pelanggan");
			$this->db->where("id_pelanggan", $idpel);
			
			//$sql="select * from `tag_pelanggan` where id_pelanggan='$idpel'";
			$q = $this->db->get();
			if($q->num_rows()>0){
				$qry=$q->row();
				
					if($qry->id_layanan != $this->input->post('id_layanan',TRUE)){
						$lama = $this->layanan_model->get_by_id($qry->id_layanan);
						$ket_lama = $lama->nama.'|'.$lama->harga;
						
						$baru = $this->layanan_model->get_by_id($this->input->post('id_layanan',TRUE));
						$ket_baru = $baru->nama.'|'.$baru->harga;
						
						$datalog = array(
							'id_pelanggan' => $this->input->post('id_pelanggan', TRUE),
							'keterangan' => $qry->id_pelanggan.' Telah update layanan dari ['.$qry->id_layanan.'] '.$ket_lama.' ke :['.$this->input->post('id_layanan',TRUE).']'.$ket_baru 
						);
						$this->db->insert('log_update',$datalog);
					}
				
				//cek perubahan status atau tidak
				if($qry->status != $this->input->post('status',TRUE)){
					
					$v_status_lama = 'NonAktif';
					if($qry->status == 1){
						$v_status_lama = 'Aktif';
					}
					
					
					$v_status_baru= 'NonAktif';
					if($this->input->post('status',TRUE) == 1){
						$v_status_baru = 'Aktif';
					}
					
					$datalog = array(
						'id_pelanggan' => $this->input->post('id_pelanggan', TRUE),
						'keterangan' =>'Telah update status['.$qry->status.'] '.$v_status_lama.' menjadi : ['.$this->input->post('status',TRUE).'] '.$v_status_baru 
					);
					$this->db->insert('log_update',$datalog);

				}
			}
            $data = array(
				
				'nama' => $this->input->post('nama',TRUE),
				'alamat' => $this->input->post('alamat',TRUE),
				'telp' => $this->input->post('telp',TRUE),
				'id_layanan' => $this->input->post('id_layanan',TRUE),
				'id_patner' => $this->input->post('id_patner',TRUE),
				'in_pajak' => $this->input->post('in_pajak',TRUE),
				'tanggal_pasang' => $tgl_masuk,
				'status' => $this->input->post('status',TRUE),
				);

            $this->pelanggan_model->update($this->input->post('id_pelanggan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect('pelanggan');
        //}
    }

    public function update($id) 
    {
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		$this->load->helper('form');
		$this->load->model('umum');
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =21;
		$daftar_hari_boleh[3] =22;
		$daftar_hari_boleh[4] =23;
		$daftar_hari_boleh[5] =24;
		$daftar_hari_boleh[6] =25;
		$daftar_hari_boleh[7] =26;
		$daftar_hari_boleh[8] =27;
		$daftar_hari_boleh[9] =28;
		$daftar_hari_boleh[10] =29;
		$daftar_hari_boleh[11] =30;
		$daftar_hari_boleh[12] =31;

		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('admin_login_msg', 'Tidak boleh diakses ');
            redirect('pelanggan');
		}
		$this->load->model('pelanggan_model');
        $row = $this->pelanggan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pelanggan/update_action'),
				'id_pelanggan' => set_value('id_pelanggan', $row->id_pelanggan),
				'kode' => set_value('kode', $row->kode),
				'nama' => set_value('nama', $row->nama),
				'alamat' => set_value('alamat', $row->alamat),
				'telp' => set_value('telp', $row->telp),
				'id_layanan' => set_value('id_layanan', $row->id_layanan),
				'id_patner' => set_value('id_patner', $row->id_patner),
				'in_pajak' => set_value('in_pajak', $row->in_pajak),
				'tanggal_pasang' => set_value('tanggal_pasang', $row->tanggal_pasang),
				'status' => set_value('status', $row->status),
				);

			$exp = explode('-',$row->tanggal_pasang);
			if(count($exp) == 3) {
				$data['tanggal_masuk'] = $exp[2];
				$data['bulan_masuk'] = $exp[1];
				$data['tahun_masuk'] = $exp[0];
			}
			
			
            $string=$this->load->view('tag_pelanggan/tag_pelanggan_form', $data,TRUE);
			$datax = array('url' => base_url(),
						   'title' => 'UPDATE DATA PELANGGAN',
						   '_templateView_' => $string,
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA PELANGGAN',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

			
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect('pelanggan');
        }
    }

    public function read($id) 
    {
    	$this->load->model('pelanggan_model');
		$this->load->model('umum');
		
		$row_dua = $this->pelanggan_model->get_by_id_read($id);
        if ($row_dua) {
			foreach($row_dua as $row){
				$t_pajak = 0;
				$v_pajak = 'Exclude';
				if($row->in_pajak == 1){
					$v_pajak = 'Include';
					$t_pajak = 1;
				}
				
				$v_status = '<span class="label label-default">NonAktif</span>';
				if($row->status == 1){
					$v_status = '<span class="label label-success">Aktif</span>';
				}
				
				$data = array(
								'id_pelanggan' => $row->id_pelanggan,
								'kode' => $row->kode,
								'nama' => $row->nama,
								'alamat' => $row->alamat,
								'telp' => $row->telp,
								'id_layanan' => $row->nama_layanan,
								'id_patner' => $row->nama_patner,
								'in_pajak' => $v_pajak,
								'tanggal_pasang' => $row->tanggal_pasang,
								'status' => $v_status,
								);
			}
	        $string =$this->load->view('tag_pelanggan/tag_pelanggan_read', $data,TRUE);
			$datax = array('url' => base_url(),
						   'title' => 'DATA PELANGGAN',
						   '_templateView_' => $string,
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   'judul' => 'DATA PELANGGAN',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect('pelanggan');
        }
    }

	public function expo_excel()
	{
		$this->load->model('umum');
		$bulan = $this->input->post('bulan_beli',true);
		$tahun = $this->input->post('tahun_beli',true);
		$id_patner = $this->input->post('id_patner',true);
		$v_patner = '';
		if($id_patner <> 100000){
			$v_patner = " and b.id_patner = $id_patner ";
		}
		
		$ss = $this->session->userdata('ista_logged');
		$v_id_agen= "";
		if($ss['ss_idagen']==0){
		}else{
			$v_id_agen = " and c.id_agen = ".$ss['ss_idagen'];
		}
		$d['data'] = $this->db->query("select a.no_transaksi, a.pokok, a.pajak, b.nama as nama_pelanggan, 
								c.nama as nama_patner, month(a.tanggal ) as bulan_tagihan
									
								from tag_tagihan as a
								left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
								left join tag_patner 	as c on b.id_patner = c.id_patner
								
								where month(a.tanggal) = $bulan and year(a.tanggal) = $tahun  
								$v_id_agen
								$v_patner
								order by a.id_tagihan asc ");
								
		$this->load->view('tag_pelanggan/expo',$d);
	}
	

	public function simpan_faktur()
	{
		$ss = $this->session->userdata('ista_logged');
		if($ss['ss_idagen'] == 0 && $ss['ss_idpatner'] == 0){
			// boleh masuk
			
		}else{
			$this->session->set_flashdata('admin_login_msg', 'Tidak boleh akses');
			redirect('pelanggan');
		   
		}
	
		# cek bulan ini_get
		$bulan_ini = date('m');
		$tahun_ini = date('Y');
		
		$dt_cek = $this->db->query("select * from tag_tagihan where month(tanggal) = $bulan_ini and year(tanggal) = $tahun_ini ");
		if($dt_cek->num_rows() > 0)
		{
			$this->session->set_flashdata('message', 'Bulan ini sudah dibuat tagihan.');
			//redirect('tag_pelanggan/cari_data');
		}
		
		
		$dt_nomor_akhir = $this->db->query("select id_tagihan from tag_tagihan order by id_tagihan desc LIMIT 1");
		if($dt_nomor_akhir->num_rows() >0){
			$r = $dt_nomor_akhir->row();
			$awal=$r->id_tagihan+1;
		}else{
			$awal=0;
		}
		
		//$awal = $this->input->post('nomor_faktur_awal',true);
		if($awal > 0){
			$dt_layanan = $this->db->query("select * from tag_layanan ");
			if($dt_layanan->num_rows() >0){
				foreach($dt_layanan->result() as $b){
					$jenis[$b->id_layanan] = $b->harga;
				}
			}
			
			$dt_pelanggan = $this->db->query("
												SELECT * 
												FROM `tag_pelanggan`
												where id_pelanggan not in (SELECT b.id_pelanggan
												from tag_tagihan as a
												right join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
												where  month(tanggal) = $bulan_ini and year(tanggal) = $tahun_ini
												group by a.id_pelanggan) and status = 1
											");
			$jml_aktif = $dt_pelanggan->num_rows();
			$nomor = 'BITS';			
			if($jml_aktif > 0){
				$in = array();
				foreach($dt_pelanggan->result() as $p){
					/*
						rumuse lek include ppn ya
						 Pokok 	: 100/110x100.000 = 90.909
						 PPN 	: 90.909x10/100 = 9.909
						 Total 	: 90.909+9.909 = 99.999

						rumuse lek exclude ppn
						 Pokok	: 100.000
						 PPN	: 100.000x10/100 =10.000
						 Total	: 100.000+10.000 = 110.000
						 
					*/
					$harga = $jenis[$p->id_layanan];
					$pokok = 0;
					$pajak = 0;
					$prosen_pajak = 10;
					
					$in_pajak = $p->in_pajak;
					
					if($in_pajak == 1){
						$pokok = (100/110)* $harga;
						$pajak = ($prosen_pajak/100) * $pokok;
					}else{
						$pokok = $harga;
						$pajak = ($prosen_pajak/100) * $harga;
					}
					
					//tanggal, periode, no_transaksi, id_pelanggan, 
					//total_tagihan, pajak, status, user_buat
					# update utk kode barang pada brg_nama
					
						
					switch (strlen($awal)) 
					{     
						case 1 : $kode = "000".$awal; 
						break;     
						case 2 : $kode = "00".$awal; 
						break;  
						case 3 : $kode = "0".$awal; 
						break;
						default: $kode = $awal;    
					}  
							
					$v_no_transaksi = $nomor.''.$kode;
					
					$in[] = array(
								'no_transaksi'	=> $v_no_transaksi,
								'id_pelanggan'	=> $p->id_pelanggan,
								'total_tagihan'	=> $harga,
								'pokok'			=> $pokok,
								'pajak'			=> $pajak,
								'periode'       => '',
								'status'		=> 0,
								'qrcode'		=> '',
								'tanggal'		=> date('Y-m-d H:i:s', time()),
								'user_buat'		=> $this->session->userdata('DX_user_id')
								);
					$awal++;
					
				}
				$this->db->insert_batch('tag_tagihan', $in); 
			}
			$this->session->set_flashdata('message', '<strong>Sukses !</strong> Bulan ini sudah dibuat tagihan.');
			redirect('pelanggan');
		}else{
			$this->session->set_flashdata('message', 'Nomor Faktur Awal Tidak Boleh Kosong');
			redirect('pelanggan');
		}
	}

	public function rstfilter()
	{
		$sess_data['kode']  	= '';
		$sess_data['nama']		= '';
		$sess_data['alamat']	= '';
		$sess_data['id_patner']	= '';
		$sess_data['limit']		= '';
		$sess_data['statusAktif']	= '';
		
		$this->session->set_userdata($sess_data);
		
		redirect('pelanggan');

	}
	public function proses_cari_rekanan()
	{
		
		$json = [];
		if($this->input->get("q") <> ''){
			$kata = $this->input->get("q");
			$query = $this->db->query("select
								id_patner as id, 
								kode, 
								nama, 
								alamat
								from tag_patner 
								where nama like '%$kata%' or kode like '%$kata%' 
								");
			$json = $query->result();
		}
		echo json_encode($json);
		
	}
	
	public function index()
	{

		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			$this->load->model('pelanggan_model');
					
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

	public function create_tagihan()
	{
		$this->load->helper('form');
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):
			$this->load->model('pelanggan_model');
					
			$datax = array('url' => base_url(),
						   'title' => 'BUAT FAKTUR TAGIHAN',
						   '_templateView_' => $this->pelanggan_model->display_form_createfaktur(),
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
				redirect('pelanggan');
			}
			
		}else{
			$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
			redirect('pelanggan');
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
