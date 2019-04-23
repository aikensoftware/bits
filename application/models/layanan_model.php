<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Layanan_model extends CI_Model
{

    public $table = 'tag_layanan';
    public $id = 'id_layanan';
    public $order = 'DESC';
	
    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
		
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
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

	function list_pelanggan()
	{
        $ss = $this->session->userdata('ista_logged');
		if($ss['ss_idagen'] == 0 && $ss['ss_idpatner'] == 0){
			
		}else{
			$this->db->where('id_agen',$ss['ss_idagen']);	
			$this->db->where('id_patner',$ss['ss_idpatner']);
		}
		$this->db->order_by("nama", 'Asc');
		$qry = $this->db->get('layanan');
        
		return $qry->result();
	}

	public function display_master_layanan()
	{
		$ss = $this->session->userdata('ista_logged');
		//$pekerjaan = $this->list_bantuan();
        $pelanggan=$this->list_pelanggan();
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp ='';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('layanan/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> SETTING MASTER LAYANAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('layanan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
                        			<button class="btn btn-danger" type="submit" name="btnDeleteAll" onclick="return confirm(\'Yakin mau menghapus semua yang dipilih?\')"><i class="fa fa-minus-circle"></i> Hapus yg dicawang</button>
														</div>
														                     	<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th width="2%">
													<input type="checkbox" name="chkAll" id="chkAll" class="form-control">
												</th>
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">NAMA </th>
												<th style="text-align:center;">HARGA </th>
												<th style="text-align:center;">KETERANGAN</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($pelanggan as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_layanan.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama.'</td>
												<td>'.$l->harga.'</td>
												<td>'.$l->ket.'</td>
												<td>
													<a href="'.site_url("layanan/edit/".$l->id_layanan).'" class="btn-sm btn-warning">Edit</a> '.anchor('layanan/delete/'.$l->id_layanan,"Delete",array(
														'class' => "btn-sm btn-danger",
														'onclick' => "return confirm('Yakin mau menghapus data ini?')")).'

												</td>
											</tr>';
										}
										$dsp .= '</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

	function get_layanan($id)
	{		
		$qry = $this->db->get_where('layanan', array('id_layanan' => $id));

		return $qry->row_array();
	}
	
	public function display_form_layanan($id = null)
	{
		$ss = $this->session->userdata('ista_logged');
		
		$rs = $this->get_layanan($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('layanan/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA LAYANAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama </td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama'].'" class="form-control" placeholder="Nama ..." required>
												<input type="hidden" name="id_layanan" id="id_layanan" value="'.$rs['id_layanan'].'">
											</td>
										</tr>
										
										<tr>
											<td width="22%">Harga </td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="harga" id="harga" value="'.$rs['harga'].'" class="form-control" placeholder="Harga ..." required>
												
											</td>
										</tr>
										
										<tr>
											<td width="22%">Keterangan </td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="ket" id="ket" value="'.$rs['ket'].'" class="form-control" placeholder="Keterangan ..." required>
												
											</td>
										</tr>
										

										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("layanan").'" class="btn btn-warning">Batal</a>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

	# data uang jenis #
	
	function list_uang_jenis()
	{
        $ss = $this->session->userdata('ista_logged');
		
		$this->db->where('id_user',$ss['ss_idpatner']);
		
		$this->db->order_by("nama_jenis", 'Asc');
		$qry = $this->db->get('uang_jenis');
        
		return $qry->result();
	}
	
	function get_uang_jenis($id)
	{		
		$qry = $this->db->get_where('uang_jenis', array('id_jenis' => $id));

		return $qry->row_array();
	}
	
	function get_where_uang_jenis($kas)
	{		
		$ss = $this->session->userdata('ista_logged');
		
		$this->db->where('id_user',$ss['ss_idpatner']);
		if($kas > 0){
			$this->db->where('kas',$kas);
		}
		$this->db->order_by("nama_jenis", 'Asc');
		$qry = $this->db->get('uang_jenis');
        
		return $qry->result();
	}
	
	
	public function display_uang_jenis()
	{
		$ss = $this->session->userdata('ista_logged');
		
        $uang_jenis = $this->list_uang_jenis();
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp ='';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('uang_jenis/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> NAMA AKUN </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('uang_jenis/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
                        			<button class="btn btn-danger" type="submit" name="btnDeleteAll" onclick="return confirm(\'Yakin mau menghapus semua yang dipilih?\')"><i class="fa fa-minus-circle"></i> Hapus yg dicawang</button>
														</div>
														                     	<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th width="2%">
													<input type="checkbox" name="chkAll" id="chkAll" class="form-control">
												</th>
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">NAMA AKUN </th>
												<th style="text-align:center;">MASUK / KELUAR</th>
												
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										
										//id_jenis, nama_jenis, kas, id_user
										$no = 1;
										foreach($uang_jenis as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_jenis.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_jenis.'</td>
												<td>'.($l->kas == 1?'Kas Masuk':'Kas Keluar').'</td>
												
												<td>
													<a href="'.site_url("uang_jenis/edit/".$l->id_jenis).'" class="btn-sm btn-warning">Edit</a> '.anchor('uang_jenis/delete/'.$l->id_jenis,"Delete",array(
														'class' => "btn-sm btn-danger",
														'onclick' => "return confirm('Yakin mau menghapus data ini?')")).'

												</td>
											</tr>';
										}
										$dsp .= '</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

	public function display_form_uang_jenis($id = null)
	{
		$ss = $this->session->userdata('ista_logged');
		
		$rs = $this->get_uang_jenis($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('uang_jenis/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA NAMA AKUN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama Akun</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama_jenis" id="nama_jenis" value="'.$rs['nama_jenis'].'" class="form-control" placeholder="Nama ..." required>
												<input type="hidden" name="id_jenis" id="id_jenis" value="'.$rs['id_jenis'].'">
											</td>
										</tr>
										
										<tr>
											<td width="22%">Masuk/Keluar </td>
											<td width="1%">:</td>
											<td>';
												$kas = $rs['kas'];
												
												$dsp .= '<select name="kas" id="kas" class="form-control" required>';
												
												$dsp .= '<option value="1"'.($kas==1 ? ' selected' : '').'>Kas Masuk</option>';
												$dsp .= '<option value="2"'.($kas==2 ? ' selected' : '').'>Kas Keluar</option>';
												
												$dsp .= '</select>
													
											</td>
										</tr>
										
										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("uang_jenis").'" class="btn btn-warning">Batal</a>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

	# data uang masuk #
	
	function list_uang_masuk()
	{
        $ss = $this->session->userdata('ista_logged');
		
		$this->db->select('a.*, b.nama_jenis, month(a.tgl_masuk) as bln, year(a.tgl_masuk) as thn ');
     	$this->db->from('uang_masuk as a');
		$this->db->where('a.id_user',$ss['ss_idpatner']);

		$this->db->join('uang_jenis as b','a.id_jenis = b.id_jenis','LEFT');
		
		$qry = $this->db->get();
		return $qry->result();
	}
	
	function get_uang_masuk($id)
	{		
		$qry = $this->db->get_where('uang_masuk', array('id_masuk' => $id));

		return $qry->row_array();
	}
	
	
	public function display_uang_masuk()
	{
		$ss = $this->session->userdata('ista_logged');
		
        $uang_masuk = $this->list_uang_masuk();
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp ='';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('uang_masuk/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> UANG MASUK </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('uang_masuk/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
                        			
														</div>
														                     	<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th width="2%">
													<input type="checkbox" name="chkAll" id="chkAll" class="form-control">
												</th>
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">Tanggal</th>
												<th style="text-align:center;">Bulan</th>
												<th style="text-align:center;">Nama Akun</th>
												<th style="text-align:center;">Uraian</th>
												<th style="text-align:right;">Jumlah</th>
												
											</tr>
										</thead>
										<tbody>';
										
										//id_masuk, no_masuk, tgl_masuk, ket, jumlah, id_jenis, id_user
										$no = 1;
										foreach($uang_masuk as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_masuk.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->tgl_masuk.'</td>
												<td >'.$l->bln.'-'.$l->thn.'</td>
												<td>'.$l->nama_jenis.'</td>
												<td>'.$l->ket.'</td>
												<td style="text-align:right;">'.$this->umum->format_rupiah($l->jumlah).'</td>
												
											</tr>';
										}
										$dsp .= '</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

	public function display_form_uang_masuk($id = null)
	{
		$ss = $this->session->userdata('ista_logged');
		
		$rs = $this->get_where_uang_jenis(2);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;
		
		$tgl = date('d/m/Y', time());
		
		$dsp .= '<form method="post" action="'.site_url('uang_masuk/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> UANG MASUK </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td>Tanggal</td>
											<td>:</td>
											<td><input type="text" name="tgl_masuk" id="tgl_lahir" value="'.$tgl.'" class="form-control" placeholder="Tanggal Transaksi " required></td>
										</tr>
										
										<tr>
											<td width="22%">Nama Akun </td>
											<td width="1%">:</td>
											<td>';
												$data_jenis = $this->get_where_uang_jenis(1);
												$dsp .= '<select name="id_jenis" id="id_jenis" class="form-control" required>';
												foreach($data_jenis as $p){
													$dsp .= '<option value="'.$p->id_jenis.'">'.$p->nama_jenis.'</option>';
												}
												$dsp .= '</select>
													
											</td>
										</tr>
										
										<tr>
											<td width="22%">Uraian</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="ket" id="ket" value="" class="form-control" placeholder="Uraian ..." required>
												
											</td>
										</tr>
										
										<tr>
											<td width="22%">Jumlah</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="jumlah" id="jumlah" value="" class="form-control" placeholder="Jumlah ..." required>
												
											</td>
										</tr>
										
										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("uang_masuk").'" class="btn btn-warning">Batal</a>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

	# data uang keluar #
	//id_keluar, no_keluar, tgl_keluar, ket, jumlah, id_jenis, id_user
	
	function list_uang_keluar()
	{
        $ss = $this->session->userdata('ista_logged');
				
		$this->db->select('a.*, b.nama_jenis, month(a.tgl_keluar) as bln, year(a.tgl_keluar) as thn ');
     	$this->db->from('uang_keluar as a');
		$this->db->where('a.id_user',$ss['ss_idpatner']);

		$this->db->join('uang_jenis as b','a.id_jenis = b.id_jenis','LEFT');
		
		$qry = $this->db->get();
		return $qry->result();
		
	}
	
	function get_uang_keluar($id)
	{		
		$qry = $this->db->get_where('uang_keluar', array('id_keluar' => $id));

		return $qry->row_array();
	}
	
	
	public function display_uang_keluar()
	{
		$ss = $this->session->userdata('ista_logged');
		
        $uang_keluar = $this->list_uang_keluar();
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp ='';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('uang_keluar/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> UANG KELUAR </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('uang_keluar/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
                        			
														</div>
														                     	<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th width="2%">
													<input type="checkbox" name="chkAll" id="chkAll" class="form-control">
												</th>
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">Tanggal</th>
												<th style="text-align:center;">Bulan</th>
												<th style="text-align:center;">Nama Akun</th>
												<th style="text-align:center;">Uraian</th>
												<th style="text-align:right;">Jumlah</th>
												
											</tr>
										</thead>
										<tbody>';
										
										//id_masuk, no_masuk, tgl_masuk, ket, jumlah, id_jenis, id_user
										$no = 1;
										foreach($uang_keluar as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_masuk.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->tgl_keluar.'</td>
												<td>'.$l->bln.'-'.$l->thn.'</td>
												<td>'.$l->nama_jenis.'</td>
												<td>'.$l->ket.'</td>
												<td style="text-align:right;">'.$this->umum->format_rupiah($l->jumlah).'</td>
												
											</tr>';
										}
										$dsp .= '</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

	public function display_form_uang_keluar($id = null)
	{
		$ss = $this->session->userdata('ista_logged');
		
		$rs = $this->get_where_uang_jenis(2);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;
		
		$tgl = date('d/m/Y', time());
		
		$dsp .= '<form method="post" action="'.site_url('uang_keluar/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> UANG KELUAR </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td>Tanggal</td>
											<td>:</td>
											<td><input type="text" name="tgl_keluar" id="tgl_lahir" value="'.$tgl.'" class="form-control" placeholder="Tanggal Transaksi " required></td>
										</tr>
										
										<tr>
											<td width="22%">Nama Akun </td>
											<td width="1%">:</td>
											<td>';
												$data_jenis = $this->get_where_uang_jenis(2);
												$dsp .= '<select name="id_jenis" id="id_jenis" class="form-control" required>';
												foreach($data_jenis as $p){
													$dsp .= '<option value="'.$p->id_jenis.'">'.$p->nama_jenis.'</option>';
												}
												$dsp .= '</select>
													
											</td>
										</tr>
										
										<tr>
											<td width="22%">Uraian</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="ket" id="ket" value="" class="form-control" placeholder="Uraian ..." required>
												
											</td>
										</tr>
										
										<tr>
											<td width="22%">Jumlah</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="jumlah" id="jumlah" value="" class="form-control" placeholder="Jumlah ..." required>
												
											</td>
										</tr>
										
										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("uang_keluar").'" class="btn btn-warning">Batal</a>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>';

		return $dsp;
	}

}

/* End of file Tag_pelanggan_model.php */
/* Location: ./application/models/Tag_pelanggan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:28:11 */
/* http://harviacode.com */