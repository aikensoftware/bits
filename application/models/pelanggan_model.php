<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan_model extends CI_Model
{

    public $table = 'tag_pelanggan';
    public $id = 'id_pelanggan';
    public $order = 'DESC';
	
    function __construct()
    {
        parent::__construct();
    }
    function partner($id_patner){
		$dt_patner = $this->db->query("select `nama` from tag_patner where id_patner='$id_patner'");
		return $dt_patner->row()->nama;

    }
    function get_firstPartner($id_agen)
    {
    	if($id_agen>0){
    		$this->db->where('id_agen');
    	}
		
		$ss = $this->session->userdata('ista_logged');
		$login_agen = $ss['id_agen'];
		if($login_agen > 0){
			$this->db->where('id_agen', $login_agen);
		}
		
    	$this->db->order_by('id_patner','ASC');
    	$this->db->limit(1);
    	return $this->db->get('tag_patner')->row();
    }
    // get all
    function get_all()
    {
		$id_patner = $this->session->userdata('DX_id_patner');
		if($id_patner > 0){
			$this->db->where('id_patner', $id_patner);
		}
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

	function get_by_id_read($id)
    {
		$ss = $this->session->userdata('ista_logged');
		$this->db->select('t1.*, t2.nama as nama_layanan,t2.harga as harga,t3.nama as nama_patner, t3.prosen as prosen');
     	$this->db->from('tag_pelanggan as t1');
        if($ss['ss_idagen']>0){
            $this->db->where("t1.id_agen",$ss['ss_idagen']);
        }

        if($ss['ss_idpatner']>0){
            $this->db->where("t1.id_patner",$ss['ss_idpatner']);
        }
		$this->db->where($this->id, $id);
		$this->db->join('tag_layanan as t2','t1.id_layanan = t2.id_layanan','LEFT');
		$this->db->join('tag_patner as t3','t1.id_patner = t3.id_patner','LEFT');
		$qry = $this->db->get();
        
		return $qry->result();
	}
	
    // get data by id
    function get_by_id($id)
    {
			
		$id_patner = $this->session->userdata('DX_id_patner');
		if($id_patner > 0){
			$this->db->where('id_patner', $id_patner);
		}
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL,$fil_1 = Null, $kri_1 = Null) {
		$id_patner = $this->session->userdata('DX_id_patner');
		if($id_patner > 0){
			$this->db->where('id_patner', $id_patner);
		}
        $this->db->like('id_pelanggan', $q);
	$this->db->or_like('kode', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('id_layanan', $q);
	$this->db->or_like('id_patner', $q);
	$this->db->or_like('in_pajak', $q);
	$this->db->or_like('tanggal_pasang', $q);
	$this->db->or_like('status', $q);
	
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL,$fil_1 = Null, $kri_1 = Null) {
        $id_patner = $this->session->userdata('DX_id_patner');
		if($id_patner > 0){
			$this->db->where('id_patner', $id_patner);
		}
        $this->db->like('id_pelanggan', $q);
	$this->db->or_like('kode', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('id_layanan', $q);
	$this->db->or_like('id_patner', $q);
	$this->db->or_like('in_pajak', $q);
	$this->db->or_like('tanggal_pasang', $q);
	$this->db->or_like('status', $q);
	
	$this->db->order_by($this->id, $this->order);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

	function list_pelanggan($cKode=NULL,$cNama=NULL,$cAlamat=NULL,$cIdPatner=NULL,$cIdStatus=NULL)
	{
        $ss = $this->session->userdata('ista_logged');
		$this->db->select('t1.*, t2.nama as nama_layanan,t2.harga as harga,t3.nama as nama_patner, t3.prosen as prosen');
     	$this->db->from('tag_pelanggan as t1');
        if($ss['ss_idagen']>0){
            $this->db->where("t1.id_agen",$ss['ss_idagen']);
        }

        if($ss['ss_idpatner']>0){
            $this->db->where("t1.id_patner",$ss['ss_idpatner']);
        }

        if(isset($cKode)){
        	$this->db->where("t1.kode LIKE '%$cKode%'");
        }
        if(isset($cNama)){
        	$this->db->where("t1.nama LIKE '%$cNama%'");
        }
        if(isset($cAlamat)){
        	$this->db->where("t1.alamat LIKE '%$cAlamat%'");
        }
        if(isset($cIdPatner)){
         	$this->db->where("t1.id_patner", $cIdPatner);
        }
        if($cIdStatus == 1 || $cIdStatus==2){
         	$this->db->where("t1.status",$cIdStatus);
        }

        $this->db->join('tag_layanan as t2','t1.id_layanan = t2.id_layanan','LEFT');
		$this->db->join('tag_patner as t3','t1.id_patner = t3.id_patner','LEFT');
		$qry = $this->db->get();
        
		return $qry->result();
	}

	public function display_master_pelanggan()
	{
		$ss = $this->session->userdata('ista_logged');
		$this->load->model('umum');
		$this->load->helper('form');
        
		$msg = $this->session->flashdata('admin_login_msg');

			if($this->input->post("kode",TRUE)=="")
			{
				$kode = $this->session->userdata('kode');
			}else{
				$sess_data['kode']  = $this->input->post('kode',true);
				$this->session->set_userdata($sess_data);
				$kode = $this->session->userdata('kode');
			}
			
			if($this->input->post("nama",TRUE)=="")
			{
				$nama = $this->session->userdata('nama');
			}else{
				$sess_data['nama']  = $this->input->post('nama',true);
				$this->session->set_userdata($sess_data);
				$nama = $this->session->userdata('nama');
			}
			
			if($this->input->post("alamat",TRUE)=="")
			{
				$alamat = $this->session->userdata('alamat');
			}else{
				$sess_data['alamat']  = $this->input->post('alamat',true);
				$this->session->set_userdata($sess_data);
				$alamat = $this->session->userdata('alamat');
			}
			
			
			if($this->input->post("id_status",TRUE)=="")
			{
				$id_status = $this->session->userdata('statusAktif');
			}else{
				$sess_data['statusAktif']  = $this->input->post('id_status',true);
				$this->session->set_userdata($sess_data);
				$id_status = $this->session->userdata('statusAktif');
			}

			if($ss['ss_idpatner']>0){
				$id_patner=$ss['ss_idpatner'];
			}else{
				if($this->input->post("id_patner",TRUE)=="")
				{
					
					$id_patner = $this->session->userdata('id_patner');
					if(isset($id_patner)){
						$ptner=$this->get_firstPartner($ss['id_agen']);
						$id_patner=$ptner->id_patner;						
					}
					
				}else{
					$sess_data['id_patner']  = $this->input->post('id_patner',true);
					$this->session->set_userdata($sess_data);
					$id_patner = $this->session->userdata('id_patner');
				}
			}
		$pelanggan=$this->list_pelanggan($kode,$nama,$alamat,$id_patner,$id_status);
		$dsp ='';
		
		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;        

		$dsp .= '
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> SETTING MASTER PELANGGAN</strong>
                            </h3>
                        </div>';
				$dsp .= $this->display_form_filter($kode,$nama,$alamat,$id_patner,$id_status);
//				$dsp .= $this->display_form_createfaktur();					
				$dsp .= $this->display_form_export();
                $dsp .= '   <div class="x_content">
        					<div class="row">
        					<form method="post" action="'.site_url('pelanggan/printAll').'">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('pelanggan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
                        			<button class="btn btn-danger" type="submit" name="btnPrintAll" onclick="return confirm(\'Yakin mau mencetak semua yang dipilih?\')"><i class="fa fa-print"></i> Cetak Nota yg dipilih</button></br>';

                        			if($id_patner!='100000'){
                        				$dsp .= '
                        			<div class="x_title">
                           			<h3>Data Pelanggan Partner '.$this->partner($id_patner).'</h3>
                           			</div>  ';
                           			}     
                           			$dsp .= '
								</div>
	                     		<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th width="2%">
													<input type="checkbox" name="chkAll" id="chkAll" class="form-control">
												</th>
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">KODE </th>
												<th style="text-align:center;">NAMA</th>
												<th style="text-align:center;">Layanan</th>
												<th style="text-align:center;">Abonemen</th>
												<th style="text-align:center;">PPN</th>
												<th style="text-align:center;">Fee</th>
												<th style="text-align:center;">Rekanan</th>
												<th style="text-align:center;">Pajak</th>
												<th style="text-align:center;">Status</th>';
											
												$bulan_ini = date('m');
												$tahun_ini = date('Y');
												$v_bulan_ini = $this->umum->nama_bulan_pdk($bulan_ini).'-'.$tahun_ini;
												
												$bulan_lalu = date('m') -1;
												$tahun_lalu = date('Y');
												if($bulan_ini == 1){
													$bulan_lalu = 12;
													$tahun_lalu = date('Y')-1;
												}
												$v_bulan_lalu = $this->umum->nama_bulan_pdk($bulan_lalu).'-'.$tahun_lalu;
												
												
											$dsp .= '<th>'.$v_bulan_ini.'</th>
											
											
											<th>Action</th>

											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($pelanggan as $l) {

				$id_pelanggan = $l->id_pelanggan;
				
				$nama_patner = '';
				$pecah = explode(' ',$l->nama_patner);
				$nama_patner = $pecah[0];
		
				$t_pajak = 0;
				$v_pajak = 'Exclude';
				if($l->in_pajak == 1){
					$v_pajak = 'Include';
					$t_pajak = 1;
				}
				
				$v_status = '<span class="label label-default">NonAktif</span>';
				if($l->status == 1){
					$v_status = '<span class="label label-success">Aktif</span>';
				}
				
				$v_tagihan_bulan_ini = '';
				$hitung_fee = 0;
				$harga_fee = 0;
				$harga_ppn = 0;
				
				$vv_pokok = 0;
				$vv_pajak = 0;
				$base = site_url();
				$tagihan_bulan_ini = $this->db->query("select * from tag_tagihan 
												where id_pelanggan = '".$id_pelanggan."' and 
												month(tanggal) 	= $bulan_ini and 
												year(tanggal)	= $tahun_ini ");
				if($tagihan_bulan_ini->num_rows() >0){
					$b_ini = $tagihan_bulan_ini->row();
					$v_tagihan_bulan_ini = '<a href="'.$base.'/pelanggan/cetak_faktur/'.$b_ini->id_tagihan.'">Cetak '.$b_ini->no_transaksi.'</a>';					
				}else{
					$v_tagihan_bulan_ini = '<span class="label label-default">Belum Ada</span>';
				}
				
				$prosen_pajak = 10;

				if($l->in_pajak == 1){
					$vv_pokok = (100/110)* $l->harga;
					$vv_pajak = ($prosen_pajak/100) * $vv_pokok;
				}else{
					$vv_pokok = $l->harga;
					$vv_pajak = ($prosen_pajak/100) * $l->harga;
				}
				

				
				if($l->prosen > 0){
					$prosen_fee = $l->prosen;
					$harga_fee = $vv_pokok ;
					$hitung_fee = ($prosen_fee/100) * $harga_fee;
					$harga_ppn = $vv_pajak;
				}
				
				$total_layanan += $harga_fee;
				$total_fee += $hitung_fee;
				$total_ppn += $harga_ppn;

											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_pelanggan.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
					<td>'.$l->kode.'</td>
					<td>'.$l->nama.'</td>
					<td>'.$l->nama_layanan.'</td>
					<td style="text-align:right;">';
					$dsp .= $this->umum->format_rupiah($harga_fee);
					$dsp .='</td>
					<td style="text-align:right;">';
					$dsp .= $this->umum->format_rupiah($harga_ppn);
					$dsp .= '</td>
					<td style="text-align:right;">';
					$dsp .= $this->umum->format_rupiah($hitung_fee);
					$dsp .= '</td>
					<td>';
					$dsp .= $nama_patner; 
					$dsp .= '</td>
					<td>';
					$dsp .=  $v_pajak;
					$dsp .= '</td>
					<td>';
					$dsp .=  $v_status;
					$dsp .= '</td>
					<td>';
					$dsp .=$v_tagihan_bulan_ini;
					$dsp .= '</td>';
					
						
					$dsp .= '
					<td style="text-align:center" width="200px">';
						
					$dsp .= anchor('pelanggan/read/'.$l->id_pelanggan,'Read',array('class' => 'btn btn-success btn-xs'));
					$dsp .= '&nbsp;';
					$dsp .= anchor('pelanggan/update/'.$l->id_pelanggan,'Update',array('class' => 'btn btn-warning btn-xs')); 
						
					$dsp .= '						
					</td>
									</tr>';
										}
										$dsp .= '</tbody>
									</table>
								</div>
								</form>
							</div>
							<div class="row">
								<div class="col-md-8">
								<h3>
								<span class="label label-warning">
								Total Layanan : '.$this->umum->format_rupiah($total_layanan). '</span>								
								<span class="label label-info">
								Total PPN : '.$this->umum->format_rupiah($total_ppn). '</span>
								<span class="label label-success"> Total Fee : '.$this->umum->format_rupiah($total_fee).'</span>  
								</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				';

		return $dsp;
	}
	public function display_form_export()
	{
		$ss = $this->session->userdata('ista_logged');
		$dsp =  '<div class="col-md-8">
						<div class="panel panel-default">
							<div class="panel-heading">Export excel file no tagihan</div>
							<div class="panel-body">
							<form action="'.site_url().'/pelanggan/expo_excel" method="post" accept-charset="utf-8" class="form-inline" onsubmit="return confirm(\'Anda yakin export ?\')">	
							<input type="hidden" name="id_bor" value="1">
							<table>
								<tr>
									<td colspan="3">Tentukan Bulan </td>
								</tr>
								<tr>
									
									<td>';
										
											$options= array();
											
											$bulan_beli = isset($bulan_beli)?$bulan_beli: date('m') ;
											for ($x = 1; $x < 13; $x++) {
												$bln = '';
												if($x == 1){
													$bln = 'Jan';
												}else if($x == 2){
													$bln = 'Feb';
												}else if($x == 3){
													$bln = 'Mar';
												}else if($x == 4){
													$bln = 'Apr';
												}else if($x == 5){
													$bln = 'Mei';
												}else if($x == 6){
													$bln = 'Jun';
												}else if($x == 7){
													$bln = 'Jul';
												}else if($x == 8){
													$bln = 'Agu';
												}else if($x == 9){
													$bln = 'Sep';
												}else if($x == 10){
													$bln = 'Okt';
												}else if($x == 11){
													$bln = 'Nop';
												}else if($x == 12){
													$bln = 'Des';
												}
												$options[$x] = $bln;
											} 
					$dsp .=form_dropdown('bulan_beli', $options, $bulan_beli,'class="form-control"'); 
										
					$dsp .= '				</td>
									<td>';

											$options= array();
											
											$tahun_beli = isset($tahun_beli)?$tahun_beli: date('Y') ;
											for ($x = 2000; $x < date('Y')+3; $x++) {
												$options[$x] = $x;
											} 
					$dsp .= form_dropdown('tahun_beli', $options, $tahun_beli,'class="form-control"'); 

					$dsp .=	'		</td>
										<td>';
											
											$options= array();
											
											$id_patner = isset($id_patner)?$id_patner: 100000 ;
											//$dt_patner = $this->db->query("select * from tag_patner order by nama asc ");
											if($ss['ss_idagen']==0 && $ss['ss_idpatner'] == 0){
												$dt_patner = $this->db->query("select * from tag_patner order by nama asc ");
												$options[100000] = 'Semua Patner';
											}else if($ss['ss_idpatner']>0){
												$dt_patner = $this->db->query("select * from tag_patner where id_patner='".$ss['ss_idpatner']."' order by nama asc ");						
											}else{
												$dt_patner = $this->db->query("select * from tag_patner where id_agen='".$ss['ss_idagen']."' order by nama asc ");						
												$options[100000] = 'Semua Patner';
											}
											
											if($dt_patner->num_rows() >0){
												foreach($dt_patner->result() as $b){
													$options[$b->id_patner] = $b->nama.'---'.$b->kode;
												}
											} 
					$dsp .=	form_dropdown('id_patner', $options, $id_patner,'class="form-control"'); 
										
					$dsp .=	'			</td>
									<td>
										<button class="btn btn-primary btn-sm" type="submit">Export ke excel </button>
									</td>
								</tr>
							</table>';
					$dsp .=	form_close();
		$dsp .= '			</div>
						</div>
				</div>';	
		return $dsp;	
	}
	public function display_form_createfaktur()
	{
		$dsp =  '<div class="col-md-8">
						<div class="panel panel-default">
							<div class="panel-heading">Langkah membuat tagihan</div>
							<div class="panel-body">';
								
							$dt_nomor_akhir = $this->db->query("select id_tagihan from tag_tagihan order by id_tagihan desc LIMIT 1");
							if($dt_nomor_akhir->num_rows() >0){
								$r = $dt_nomor_akhir->row();
								$notrans_akhir=$r->id_tagihan;
							}else{
								$notrans_akhir='BITS0';
							}
							
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
							
							$dsp .="Nomor ".$kdAwal;
							
											
							$dt_pelanggan = $this->db->query("select * from tag_pelanggan where status = 1 ");
							$jml_aktif = $dt_pelanggan->num_rows(); 


							$attrib =array('name'=>'frm_kategori','role'=>'form','onSubmit' => "return confirm('Anda yakin akan membuat faktur tagihan ?')");
		$dsp .=				 form_open_multipart('pelanggan/simpan_faktur', $attrib); 
								
		$dsp .=	'					<table border="0">
									<tr>
										<td style="text-align:right;">Total Pelanggan Aktif Saat Ini</td>
										<td style="text-align:center;">:&nbsp;</td>
										<td><span class="label label-default">'.$jml_aktif.'</span></td>
									</tr>
									<tr>
										<td style="text-align:right;">Nomor Faktur Awal</td>
										<td style="text-align:center;">:&nbsp;</td>
										<td>
											<input class="form-control" type="number" name="nomor_faktur_awal" value="'.$kdAwal.'" placeholder="" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
										<td  style="text-align:right;">
											<br/>
											<input type="submit" value="1) Klik untuk membuat tagihan " class="btn btn-primary btn-sm" >
										
											<a href="'.site_url().'/pelanggan/create_qrcode" class="btn btn-primary btn-sm" onClick="return confirm(\'Anda yakin membuat QR code ?\')" > 2) Klik untuk membuat QR code </a>
										</td>
									</tr>
								</table>'.
								
								form_close().' 
								
								
							</div>
						</div>
				</div>';
		return $dsp;				

	}
	public function display_form_filter($kode=NULL,$nama=NULL,$alamat=NULL,$id_patner=NULL,$id_status=NULL){
		$ss = $this->session->userdata('ista_logged');
		$dsp =  '<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">Filter Data</div>
					<div class="panel-body">';
		
		$dsp .= '<form method="post" action="'.site_url('pelanggan').'">';
		$dsp .=	'	<table>
							<tr>
								<td style="text-align:right;" width="30%">Kode :</td>
								<td>
									<input class="form-control" type="text" name="kode" value="'.(isset($kode)?$kode:'').'" placeholder="">
								</td>
							</tr>';
		$dsp .='			<tr>
								<td style="text-align:right;">Nama  :</td>
								<td>
									<input class="form-control" type="text" name="nama" value="'.(isset($nama)?$nama:'').'" placeholder="">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;">Alamat :</td>
								<td>
									<input class="form-control" type="text" name="alamat" value="'.(isset($alamat)?$alamat:'').'" placeholder="">
								</td>
							</tr>';
				if($ss['ss_idpatner']==0){
					$options= array();
					$options[100000] = 'Semua Patner ';
					$id_patner = isset($id_patner)?$id_patner: 100000 ;
					
					
					
					if($ss['ss_idagen']==0){
						$dt_patner = $this->db->query("select * from tag_patner order by nama asc ");
					}else{
						$dt_patner = $this->db->query("select * from tag_patner where id_agen='".$ss['ss_idagen']."' order by nama asc ");						
					}
					if($dt_patner->num_rows() >0){
						foreach($dt_patner->result() as $b){
							$options[$b->id_patner] = $b->nama.'---'.$b->kode;
						}
					} 
					$dsp .= '							<tr>
								<td style="text-align:right;">Rekanan :</td>
								<td>';
					$dsp .=	form_dropdown('id_patner', $options, $id_patner,'class="form-control"').'
							</td>
						</tr>'; 
				}
									
				$dsp .=	'					
							
							<tr>
								<td style="text-align:right;">Status :</td>
								<td>';
									
										$id_status = isset($id_status)?$id_status : '';
										$options= array();
										$options[0] = ' Semua Status '; 
										$options[1] = ' Aktif '; 
										$options[2] = ' Non Aktif'; 
									
									$dsp .= form_dropdown('id_status', $options, $id_status,'class="form-control"' ); 
									
		$dsp .='						</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="170px;"></td>
								<td>
									<br/>';
		$dsp .=	 form_submit('mysubmit', 'Cari Data !','class="btn btn-primary btn-sm"');
		$dsp .=	 '					<a href="'. site_url() .'/pelanggan/rstfilter" class="btn btn-success btn-sm" >Refresh</a>									
								</td>
							</tr>
						</table>';
		$dsp .=	'</form>';
		$dsp .= '</div></div></div>';
							 
		return $dsp;			

	}
}

/* End of file Tag_pelanggan_model.php */
/* Location: ./application/models/Tag_pelanggan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:28:11 */
/* http://harviacode.com */