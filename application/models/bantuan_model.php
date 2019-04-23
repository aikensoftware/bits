<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bantuan_model extends CI_Model {

	public function __construct()
	{
		//parent:__construct();
	}
	
	function get_detail_bantuan($id)
	{
		$qry = $this->db->get_where('bantuan_detail', array('id' => $id));

		return $qry->row_array();
	}
	function get_bantuan($id)
	{
		$qry = $this->db->get_where('bantuan', array('id' => $id));

		return $qry->row_array();
	}

	function list_bantuan()
	{

		$qry = $this->db->get('bantuan');

		return $qry->result();
	}

	function check_bantuanById($id,$id_data)
	{
		$qry=$this->db->get_where('bantuan_detail',array('id_bantuan'=>$id, 'id_data'=>$id_data));
		$hsl=$qry->num_rows();
		return $hsl;
	}


	function list_detail_bantuan($id)
	{

		$qry = $this->db->get_where('bantuan_detail', array('id_data' => $id));

		return $qry->result();
	}

	public function display_warga($id)
	{
		$ss = $this->session->userdata('ista_logged');

		$rs=$this->get_bantuan($id);
		
		$this->db->select('d.*','b.id as det_id');
		$this->db->from('data d');
		$this->db->join('bantuan_detail b', 'd.id=b.id_data');
		$this->db->where('b.id_bantuan', $id);
		if($ss['ista_adminid']!='1'){
			$this->db->like('rt_rw',$ss['ss_rt'],'after');
		}
		
		$qry = $this->db->get();

		$penduduk= $qry->result();

	
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('bantuan/dellAll').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> '.$rs['nama_bantuan'].' </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('bantuan/addwarga/'.$id).'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Warga</a>
									<button class="btn btn-danger" type="submit" name="btnDeleteAll" onclick="return confirm(\'Yakin mau menghapus semua yang dipilih?\')"><i class="fa fa-minus-circle"></i> Hapus yg dicawang</button>
									<input type="hidden" name="idb" value="'.$id.'">
														</div>
														                     	<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th width="2%">
													<input type="checkbox" name="chkAll" id="chkAll" class="form-control">
												</th>
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">NIK</th>
												<th style="text-align:center;">NAMA</th>
												<th style="text-align:center;">ALAMAT</th>
												<th style="text-align:center;">JNS KELAMIN</th>											
												<th style="text-align:center;">TGL LAHIR</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($penduduk as $l) {
											$utl = url_title($l->nik, "-");
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id.'" class="form-control chk">
												</td>
												<td>'.$no++.'</td>
												<td>'.$l->nik.'</td>
												<td>'.$l->nama_lengkap.'</td>
												<td>'.$l->alamat.'</td>
												<td>'.($l->jenis_kel==1 ? 'Laki-laki' : 'Perempuan').'</td>
												<td style="text-align:center;">'.date("d/m/Y", strtotime($l->tgl_lahir)).'</td>
												<td>
													<a href="'.site_url("bantuan/editById/".$l->id).'" class="btn-sm btn-warning">Kategori lainnya</a> '.anchor('bantuan/del1/'.$l->id.'?idbantuan='.$id,"Hapus bantuan",array(
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

	public function display_wargaToAdd($id)
	{
		$ss = $this->session->userdata('ista_logged');

		$rs=$this->get_bantuan($id);
		
		if(!empty($id))
	

	

		$this->db->select();
		$this->db->from('data');

		$this->db->where("id NOT IN (SELECT id_data FROM tb_bantuan_detail WHERE id_bantuan='".$id."')");
		$this->db->where('aktif',1);
		if($ss['ista_adminid']!='1'){
			$this->db->like('rt_rw',$ss['ss_rt'],'after');
		}
		$qry = $this->db->get();

		$penduduk= $qry->result();

	
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('bantuan/addAll').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i>Pilih warga yang akan ditambahkan '.$rs['nama_bantuan'].' </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
								<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th width="2%">
													<input type="checkbox" name="chkAll" id="chkAll" class="form-control">
												</th>
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">NIK</th>
												<th style="text-align:center;">NAMA</th>
												<th style="text-align:center;">ALAMAT</th>
												<th style="text-align:center;">JNS KELAMIN</th>											
												<th style="text-align:center;">TGL LAHIR</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($penduduk as $l) {
											$utl = url_title($l->nik, "-");
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id.'" class="form-control chk">
												</td>
												<td>'.$no++.'</td>
												<td>'.$l->nik.'</td>
												<td>'.$l->nama_lengkap.'</td>
												<td>'.$l->alamat.'</td>
												<td>'.($l->jenis_kel==1 ? 'Laki-laki' : 'Perempuan').'</td>
												<td style="text-align:center;">'.date("d/m/Y", strtotime($l->tgl_lahir)).'</td>
												<td>
												<a href="'.site_url("bantuan/editById/".$l->id).'" class="btn-sm btn-warning">Kategori lainnya</a> '.anchor('bantuan/add1/'.$l->id.'?idbantuan='.$id,"Tambahkan",array(
														'class' => "btn-sm btn-info",
														'onclick' => "return confirm('Yakin mau menambahkan data ini?')")).'

												</td>
											</tr>';
										}
										$dsp .= '</tbody>
									</table>
								</div>
								<div style="display:block; clear:both; margin:0 auto 10px;">                        			
								<input type="hidden" name="idbantuan" value="'.$id.'" />
								<button class="btn btn-primary" type="submit" name="btnDeleteAll" onclick="return confirm(\'Yakin mau memasukan semua yang dipilih?\')">
									<i class="fa fa-plus-square"></i> Tambahkan yg Terpilih
								</button>
								</div>

							</div>
						</div>
					</div>
				</div>
				</form>';
		return $dsp;
	}
	public function display_form_editById($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->ktp_model->get_penduduk($id);

		$l_bantuan = $this->list_bantuan();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('bantuan/savewarga').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA BANTUAN WARGA</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">NIK</td>
											<td width="1%">:</td>
											<td>'.$rs['nik'].'
												<input type="hidden" name="id" id="id" value="'.$rs['id'].'">
											</td>
										</tr>
										<tr>
											<td>No. KK</td>
											<td>:</td>
											<td>'.$rs['no_kk'].'</td>
										</tr>

										<tr>
											<td>Nama Lengkap</td>
											<td>:</td>
											<td>'.$rs['nama_lengkap'].'</td>
										</tr>
										<tr>
											<td>Tempat Lahir</td>
											<td>:</td>
											<td>'.$rs['tempat_lahir'].'</td>
										</tr>
										<tr>
											<td>Tanggal Lahir</td>
											<td>:</td>
											<td>'.date('d/m/Y',strtotime($rs['tgl_lahir'])).'</td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td>:</td>
											<td>'.$rs['alamat'].'</td>
										</tr>
										<tr>
											<td>Bantuan</td>
											<td>:</td>
											<td>';
												// $dsp .= '<input type="checkbox" name="status_kawin" id="status_kawin" class="form-control" required>';
												// 	$dsp .= '<option value="">&mdash; Status Perkawinan</option>';
												foreach($l_bantuan as $s){
													$dsp .= '<label><input type="checkbox" class="form_controls" name="bantuan[]" value="'.$s->id.'" '.($this->check_bantuanById($s->id,$id)==1 ? 'checked' : '' ).'> '.$s->nama_bantuan.'</label><br>'; 
												}
												
												
												
											$dsp .= '</td>
										</tr>


										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												
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
	public function display_form_bantuan($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_bantuan($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('bantuan/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA BANTUAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama Bantuan</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama_bantuan'].'" class="form-control" placeholder="Nama Bantuan..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id'].'">
											</td>
										</tr>
										<tr>
											<td >Keterangan</td>
											<td >:</td>
											<td>
												<input type="text" name="ket" id="ket" value="'.$rs['keterangan'].'" class="form-control" placeholder="Keterangan..." >

											</td>
										</tr>


										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("bantuan/seting").'" class="btn btn-warning">Batal</a>
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
	public function display_master_bantuan()
	{
		$ss = $this->session->userdata('ista_logged');
		$pekerjaan = $this->list_bantuan();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('bantuan/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> SETTING MASTER BANTUAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('bantuan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">NAMA BANTUAN</th>
												<th style="text-align:center;">KETERANGAN</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($pekerjaan as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_bantuan.'</td>
												<td>'.$l->keterangan.'</td>
												<td>
													<a href="'.site_url("bantuan/edit/".$l->id).'" class="btn-sm btn-warning">Edit</a> '.anchor('bantuan/delete/'.$l->id,"Delete",array(
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


}

?>