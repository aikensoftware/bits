<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ktp_model extends CI_Model {

	public function __construct()
	{
		//parent:__construct();
	}
	
	function get_detail_penduduk($nik)
	{
		$qry = $this->db->get_where('data', array('nik' => $nik));

		return $qry->row_array();
	}
	function detail_penduduk($id)
	{
		$qry = $this->db->get_where('data', array('id' => $id));

		return $qry->row_array();
	}

	function list_perkawinan()
	{

		$qry = $this->db->get('status_kawin');

		return $qry->result();
	}
	function list_hubungan()
	{

		$qry = $this->db->get('status_hubungan');

		return $qry->result();
	}

	function list_pekerjaan()
	{

		$qry = $this->db->get('kerja');

		return $qry->result();
	}

	function list_keperluan()
	{

		//$this->db->select('id','keperluan');
		
		$this->db->group_by('keperluan'); 
		$qry = $this->db->get('surat');
		return $qry->result();
	}

	function list_kategory_usia()
	{

		$qry = $this->db->get('kategoryusia');

		return $qry->result();
	}
	function get_kategory_usia($id)
	{		
		$qry = $this->db->get_where('kategoryusia', array('id_usia' => $id));

		return $qry->row_array();
	}

	function get_kerja($id)
	{		
		$qry = $this->db->get_where('kerja', array('id_kerja' => $id));

		return $qry->row_array();
	}

	function list_pendidikan($id = "")
	{

		$qry = $this->db->get('pendidikan');

		return $qry->result();
	}

	function get_pendidikan($id)
	{		
		$qry = $this->db->get_where('pendidikan', array('id_pendidikan' => $id));

		return $qry->row_array();
	}


	function list_agama($id = "")
	{
		if(!empty($id))
			$this->db->where_not_in('id_agama', $id);

		$qry = $this->db->get('agama');

		return $qry->result();
	}

	function list_surat($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		if($ss['ista_adminid']!='1'){
			$this->db->where('rt',$ss['ss_rt']);
		}

		$qry = $this->db->get('surat');

		return $qry->result();
	}

	function get_agama($id)
	{		
		$qry = $this->db->get_where('agama', array('id_agama' => $id));

		return $qry->row_array();
	}
	function get_status_kawin($id)
	{		
		$qry = $this->db->get_where('status_kawin', array('id_kawin' => $id));

		return $qry->row_array();
	}

	function get_status_hubungan($id)
	{		
		$qry = $this->db->get_where('status_hubungan', array('id_hubungan' => $id));

		return $qry->row_array();
	}


	function list_penduduk($aktif="")
	{
		if($aktif=="" || $aktif==1){
			$this->db->where('aktif', 1);
		} else {
			$this->db->where('aktif',2);
		}
		$ss = $this->session->userdata('ista_logged');
		if($ss['ista_adminid']!='1'){
			$this->db->like('rt_rw',$ss['ss_rt'],'after');
		}

		$qry = $this->db->get('data');

		return $qry->result();
	}

	function get_penduduk($id)
	{
		$this->db->select('d.*');
		$this->db->from('data d');
		$this->db->join('agama a', 'd.agama=a.id_agama');
		$this->db->join('kerja k', 'd.pekerjaan=k.id_kerja');
		$this->db->where('d.id', $id);
		
		$qry = $this->db->get();

		return $qry->row_array();
	}




	public function form_filter($tgl,$usia=17)
	{
		$ss = $this->session->userdata('ista_logged');
		if($ss['ista_adminid']=='1'){
			$qry=$this->db->get_where('data', 'TIMESTAMPDIFF(YEAR, `tgl_lahir`, "'.$tgl.'")>='.$usia.' AND `aktif`=1');
		} else {
			$qry=$this->db->get_where('data', 'TIMESTAMPDIFF(YEAR, `tgl_lahir`, "'.$tgl.'")>='.$usia.' AND `aktif`=1 AND `rt_rw` LIKE "'.$ss['ss_rt'].'%"');
		}
		

		$jml=$qry->num_rows();
		$penduduk=$qry->result();
		$dsp = '<form method="post" action="'.site_url("dashboard/filterusia").'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> JUMLAH WARGA BERDASARKAN TANGGAL LAHIR</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-condensed">
										<tr>
											<td width="12%">Usia Minimum </td>
											<td width="1%">:</td>
											<td>
												<input type="number" name="usia" id="usia" value="'.$usia.'" class="form-control" placeholder="Usia yang dicari" required>

											</td>
										</tr>
										<tr>
											<td>Usia pada tanggal</td>
											<td>:</td>
											<td><input type="text" name="tgl_buat" id="tgl_buat" value="'.date('d/m/Y',strtotime($tgl)).'" class="form-control" placeholder="Tanggal Hitung Usia...(dd/mm/yyyy)" required>
											</td>
										</tr>

										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Hitung</button>
												<button type="reset" name="cancel" class="btn btn-warning">Batal</button>
											</td>
										</tr>
									</table>
								</div>
							</div>
                        	<div class="row">
                            	<div class="card-box table-responsive text-center">';
                            	$dsp.='<h3>Jumlah Warga yang berusia '.$usia.' tahun atau lebih pada tanggal '.date('d/m/Y',strtotime($tgl)).' adalah : <strong>'.$jml.'</strong> Orang</h3>';
							$dsp.='</div>
							</div>

						</div>
					</div>
				</div>
			</form>';

			$dsp .= '<form method="post" action="'.site_url('main/remove').'">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
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
												<a href="'.site_url("main/edit/".$l->id).'" class="btn-sm btn-warning">Edit</a> '.anchor('main/delete/'.$l->id,"Delete",array(
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

		return $dsp;
	}

	function get_surat($id)
	{		
		$qry = $this->db->get_where('surat', array('id' => $id));

		return $qry->row_array();
	}

	public function jumlah_surat($bln=""){
		if(empty($bln)){
			$bln=date("m");
		}
		$ss = $this->session->userdata('ista_logged');
		if($ss['ista_adminid']=='1'){

			$qry = $this->db->get_where('surat', 'MONTH(`waktu_update`)='.$bln);
		}else{
			$qry = $this->db->get_where('surat', 'MONTH(`waktu_update`)='.$bln.' AND `rt`="'.$ss['ss_rt'].'"');
		}

		$jml=$qry->num_rows();
		return $jml;
	}


	############################################## MASTER #######################################
	public function display_master_ktp()
	{
		$ss = $this->session->userdata('ista_logged');
		$penduduk = $this->list_penduduk();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('main/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> MASTER KTP</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('main/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">NAMA LENGKAP</th>
												<th style="text-align:center;">NIK</th>
												<th style="text-align:center;">NO.KK</th>												
												<th style="text-align:center;">JNS KELAMIN</th>
												<th style="text-align:center;">AGAMA</th>											
												<th style="text-align:center;">TEMPAT LAHIR</th>
												<th style="text-align:center;">TGL LAHIR</th>
												<th style="text-align:center;">PENDIDIKAN</th>	
												<th style="text-align:center;">PEKERJAAN</th>
												<th style="text-align:center;">STTS. KAWIN</th>												
												<th style="text-align:center;">STTS. DLM KK</th>
												<th style="text-align:center;">KEWARGANEGARAAN</th>											
												<th style="text-align:center;">NO. PASPOR</th>
												<th style="text-align:center;">NO. KITAS/KITAP</th>
												<th style="text-align:center;">AYAH</th>	
												<th style="text-align:center;">IBU</th>

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
												<td>'.$l->nama_lengkap.'</td>
												<td>'.$l->nik.'</td>												
												<td>'.$l->no_kk.'</td>
												<td>'.($l->jenis_kel==1 ? 'Laki-laki' : 'Perempuan').'</td>
												<td>'.$this->get_agama($l->agama)['nama_agama'].'</td>
												<td>'.$l->tempat_lahir.'</td>
												<td style="text-align:center;">'.date("d/m/Y", strtotime($l->tgl_lahir)).'</td>
												<td>'.$this->get_pendidikan($l->pendidikan)['nama_pendidikan'].'</td>
												<td>'.$this->get_kerja($l->pekerjaan)['nama_kerja'].'</td>
												<td>'.$this->get_status_kawin($l->status_kawin)['nama_kawin'].'</td>
												<td>'.$this->get_status_hubungan($l->statusdikeluarga)['nama_hubungan'].'</td>
												<td>'.$l->kewarganegaraan.'</td>
												<td>'.$l->no_paspor.'</td>
												<td>'.$l->no_kita.'</td>
												<td>'.$l->nama_ayah.'</td>
												<td>'.$l->nama_ibu.'</td>
												<td>
													<a href="'.site_url("main/edit/".$l->id).'" class="btn-sm btn-warning">Edit</a> '.anchor('main/delete/'.$l->id,"Delete",array(
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

	public function display_master_ktpnonaktif()
	{
		$ss = $this->session->userdata('ista_logged');
		$penduduk = $this->list_penduduk(2);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('main/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA WARGA NONAKTIF/MUTASI</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('main/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">NIK</th>
												<th style="text-align:center;">NAMA</th>												
												<th style="text-align:center;">JNS MUTASI</th>											
												<th style="text-align:center;">TGL MUTASI</th>
												<th style="text-align:center;">KETERANGAN</th>
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
												<td>'.($l->mutasi==3 ? 'Pindah Tempat' : 'Meninggal').'</td>
												<td style="text-align:center;">'.date("d/m/Y", strtotime($l->waktu_update)).'</td>
												<td>'.$l->ket_mutasi.'</td>
												<td>
													<a href="'.site_url("main/edit/".$l->id).'" class="btn-sm btn-warning">Edit</a> '.anchor('main/delete/'.$l->id,"Delete",array(
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

	public function display_master_pendidikan()
	{
		$ss = $this->session->userdata('ista_logged');
		$pendidikan = $this->list_pendidikan();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('pendidikan/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> MASTER PENDIDIKAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('pendidikan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">PENDIDIKAN</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($pendidikan as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_pendidikan.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_pendidikan.'</td>
												<td>
													<a href="'.site_url("pendidikan/edit/".$l->id_pendidikan).'" class="btn-sm btn-warning">Edit</a> '.anchor('pendidikan/delete/'.$l->id_pendidikan,"Delete",array(
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

	public function display_master_perkawinan()
	{
		$ss = $this->session->userdata('ista_logged');
		$perkawinan = $this->list_perkawinan();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('perkawinan/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> MASTER PERKAWINAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('perkawinan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">STATUS PERKAWINAN</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($perkawinan as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_kawin.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_kawin.'</td>
												<td>
													<a href="'.site_url("perkawinan/edit/".$l->id_kawin).'" class="btn-sm btn-warning">Edit</a> '.anchor('perkawinan/delete/'.$l->id_kawin,"Delete",array(
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
	public function display_master_hubungan()
	{
		$ss = $this->session->userdata('ista_logged');
		$hubungan = $this->list_hubungan();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('hubungan/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> MASTER STATUS HUB. KELUARGA</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('hubungan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">NAMA STATUS</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($hubungan as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_kawin.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_hubungan.'</td>
												<td>
													<a href="'.site_url("hubungan/edit/".$l->id_hubungan).'" class="btn-sm btn-warning">Edit</a> '.anchor('hubungan/delete/'.$l->id_hubungan,"Delete",array(
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

	public function display_master_agama()
	{
		$ss = $this->session->userdata('ista_logged');
		$agama = $this->list_agama();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('agama/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> MASTER AGAMA</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('agama/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">NAMA</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($agama as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_agama.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_agama.'</td>
												<td>
													<a href="'.site_url("agama/edit/".$l->id_agama).'" class="btn-sm btn-warning">Edit</a> '.anchor('agama/delete/'.$l->id_agama,"Delete",array(
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

	public function display_master_pekerjaan()
	{
		$ss = $this->session->userdata('ista_logged');
		$pekerjaan = $this->list_pekerjaan();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('pekerjaan/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> MASTER PEKERJAAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('pekerjaan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">NAMA PEKERJAAN</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($pekerjaan as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_kerja.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_kerja.'</td>
												<td>
													<a href="'.site_url("pekerjaan/edit/".$l->id_kerja).'" class="btn-sm btn-warning">Edit</a> '.anchor('pekerjaan/delete/'.$l->id_kerja,"Delete",array(
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

	public function display_master_kategory()
	{
		$ss = $this->session->userdata('ista_logged');
		$pekerjaan = $this->list_kategory_usia();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('kat/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> MASTER KATEGORI USIA</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('kat/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
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
												<th style="text-align:center;">NAMA KATEGORI</th>
												<th style="text-align:center;">USIA MIN (TH)</th>
												<th style="text-align:center;">USIA MAX (TH)</th>

												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($pekerjaan as $l) {
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_usia.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->nama_usia.'</td>
												<td>'.$l->usia_min.'</td>
												<td>'.$l->usia_max.'</td>
												<td>
													<a href="'.site_url("kat/edit/".$l->id_usia).'" class="btn-sm btn-warning">Edit</a> '.anchor('kat/delete/'.$l->id_usia,"Delete",array(
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
	public function display_data_mutasi()
	{
		$ss = $this->session->userdata('ista_logged');
		$penduduk = $this->list_penduduk();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('main/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> PILIH DATA YANG AKAN DIMUTASI!</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
		                     	<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
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
												<td>'.$no++.'</td>
												<td>'.$l->nik.'</td>
												<td>'.$l->nama_lengkap.'</td>
												<td>'.$l->alamat.'</td>
												<td>'.($l->jenis_kel==1 ? 'Laki-laki' : 'Perempuan').'</td>
												<td style="text-align:center;">'.date("d/m/Y", strtotime($l->tgl_lahir)).'</td>
												<td>
													'.anchor('main/mutasi/'.$l->id,"Pilih",array(
														'class' => "btn-sm btn-warning")).'
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
	public function display_master_surat()
	{
		$ss = $this->session->userdata('ista_logged');
		$surat = $this->list_surat();

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('surat/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA SURAT </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
		                     	<div class="card-box table-responsive">
									<table id="datatable-responsive" class="table table-striped">
										<thead>
											<tr>	
												<th style="text-align:center;">NO</th>
												<th style="text-align:center;">NO.SURAT</th>
												<th style="text-align:center;">NIK</th>
												<th style="text-align:center;">NAMA</th>
												<th style="text-align:center;">KEPERLUAN</th>											
												<th style="text-align:center;">TGL SURAT</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($surat as $l) {
											$dsp .= '<tr>
												<td>'.$no++.'</td>
												<td>'.$l->no_surat.'</td>
												<td>'.$l->nik.'</td>
												<td>'.$l->nama.'</td>
												<td>'.$l->keperluan.'</td>
												<td style="text-align:center;">'.date("d/m/Y", strtotime($l->tgl_surat)).'</td>
												<td>
													'.anchor('surat/view/'.$l->id,"View",array(
														'class' => "btn-sm btn-info")).'
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



	########################################### FORM MASTER ####################################
	public function display_form_ktp($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		if(!empty($id) && $id=='pindahan'){
			$id_type='2';
			$id='';
		} else {
			$rs = $this->get_penduduk($id);
		}
			$l_agama = $this->list_agama();
			$l_pekerjaan =$this->list_pekerjaan();
			$l_perkawinan=$this->list_perkawinan();
			$l_hubungan=$this->list_hubungan();
			$l_pendidikan=$this->list_pendidikan();
			
			if(empty($rs['kel_desa'])){
				$nm_desa=DESA;
			} else {
				$nm_desa=$rs['kel_desa'];
			}

			if(empty($rs['kec'])){
				$nm_kec=KECAMATAN;
			} else {
				$nm_kec=$rs['kec'];
			}

			if(empty($rs['kewarganegaraan'])){
				$nm_kwrgn="Indonesia";
			} else {
				$nm_kwrgn=$rs['kewarganegaraan'];
			}


		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('main/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> FORM DATA WARGA '.(empty($id) ? 'BARU':$rs['nik']).(!empty($id_type) ? ' (Pindahan)':'').'</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">NIK</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nik" id="nik" value="'.$rs['nik'].'" class="form-control" placeholder="NIK..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id'].'">
												<input type="hidden" name="mutasi" id="mutasi" value="'.$id_type.'">
											</td>
										</tr>
										<tr>
											<td>No. KK</td>
											<td>:</td>
											<td><input type="text" name="no_kk" id="no_kk" value="'.$rs['no_kk'].'" class="form-control" placeholder="Nomer KK..." required></td>
										</tr>

										<tr>
											<td>Nama Lengkap</td>
											<td>:</td>
											<td><input type="text" name="nama" id="nama" value="'.$rs['nama_lengkap'].'" class="form-control" placeholder="Nama Lengkap..." required></td>
										</tr>
										<tr>
											<td>Jenis Kelamin</td>
											<td>:</td>
											<td>';
												$dsp .= '<select name="jk" id="jk" class="form-control" required>';
												$dsp .= '<option value="">&mdash; Jenis Kelamin</option>';
												$dsp .= '<option value="1"'.($rs['jenis_kel']==1 ? ' selected' : '').'>Laki-laki</option>';
												$dsp .= '<option value="2"'.($rs['jenis_kel']==2 ? ' selected' : '').'>Perempuan</option>';

												$dsp .= '</select>
											</td>
										</tr>

										<tr>
											<td>Agama</td>
											<td>:</td>
											<td>';
												$dsp .= '<select name="agama" id="agama" class="form-control" required>';
												if(empty($id)){
													$dsp .= '<option value="">&mdash; Pilih Agama</option>';
												}
												foreach($l_agama as $a){
													$dsp .= '<option value="'.$a->id_agama.'"'.($a->id_agama==$rs['agama'] ? ' selected' : '').'>'.$a->nama_agama.'</option>';
												}
												$dsp .= '</select>
											</td>
										</tr>
										<tr>
											<td>Pendidikan</td>
											<td>:</td>
											<td>';
												$dsp .= '<select name="pendidikan" id="pendidikan" class="form-control" required>';
												if(empty($id)){
													$dsp .= '<option value="">&mdash; Pilih pendidikan</option>';
												}
												foreach($l_pendidikan as $a){
													$dsp .= '<option value="'.$a->id_pendidikan.'"'.($a->id_pendidikan==$rs['pendidikan'] ? ' selected' : '').'>'.$a->nama_pendidikan.'</option>';
												}
												$dsp .= '</select>
											</td>
										</tr>

										<tr>
											<td>Pekerjaan</td>
											<td>:</td>
											<td>';
												$dsp .= '<select name="kerja" id="kerja" class="form-control" required>';
												$dsp .= '<option value="">&mdash; Pilih Pekerjaan</option>';
												foreach($l_pekerjaan as $k){
													$dsp .= '<option value="'.$k->id_kerja.'"'.($k->id_kerja==$rs['pekerjaan'] ? ' selected' : '').'>'.$k->nama_kerja.'</option>';
												}

												$dsp .= '</select>';
											$dsp .= '</td>
										</tr>
										<tr>
											<td>Tempat Lahir</td>
											<td>:</td>
											<td><input type="text" name="tpt_lahir" id="tpt_lahir" value="'.$rs['tempat_lahir'].'" class="form-control" placeholder="Tempat Lahir..." required></td>
										</tr>
										<tr>
											<td>Tanggal Lahir</td>
											<td>:</td>
											<td><input type="text" name="tgl_lahir" id="tgl_lahir" value="'.date('d/m/Y',strtotime($rs['tgl_lahir'])).'" class="form-control" placeholder="Tanggal Lahir...(dd/mm/yyyy)" required></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td>:</td>
											<td><textarea name="alamat" id="alamat" class="form-control">'.$rs['alamat'].'</textarea></td>
										</tr>
										<tr>
											<td>Desa/Kelurahan</td>
											<td>:</td>
											<td><input type="text" name="desa" id="desa" value="'.$nm_desa.'" class="form-control" placeholder="Desa/Kelurahan..." required></td>
										</tr>
										<tr>
											<td>Kecamatan</td>
											<td>:</td>
											<td><input type="text" name="kec" id="kec" value="'.$nm_kec.'" class="form-control" placeholder="Kecamatan..." required></td>
										</tr>
										<tr>
											<td>Status Perkawinan</td>
											<td>:</td>
											<td>';
												$dsp .= '<select name="status_kawin" id="status_kawin" class="form-control" required>';
													$dsp .= '<option value="">&mdash; Status Perkawinan</option>';
												foreach($l_perkawinan as $s){
													$dsp .= '<option value="'.$s->id_kawin.'"'.($s->id_kawin==$rs['status_kawin'] ? ' selected' : '').'>'.$s->nama_kawin.'</option>';
												}

												$dsp .= '</select>';
											$dsp .= '</td>
										</tr>
										<tr>
											<td>Status Hubungan dalam Keluarga</td>
											<td>:</td>
											<td>';
												$dsp .= '<select name="status_hubungan" id="status_hubungan" class="form-control" required>';
													$dsp .= '<option value="">&mdash; Status hubungan</option>';
												foreach($l_hubungan as $s){
													$dsp .= '<option value="'.$s->id_hubungan.'"'.($s->id_hubungan==$rs['statusdikeluarga'] ? ' selected' : '').'>'.$s->nama_hubungan.'</option>';
												}

												$dsp .= '</select>';
											$dsp .= '</td>
										</tr>

										<tr>
											<td>Kewarganegaraan</td>
											<td>:</td>
											<td><input type="text" name="kewarganegaraan" id="kewarganegaraan" value="'.$nm_kwrgn.'" class="form-control" placeholder="Kewarganegaraan..." required></td>
										</tr>
										<tr>
											<td>No. Paspor</td>
											<td>:</td>
											<td><input type="text" name="no_paspor" id="no_paspor" value="'.$rs['no_paspor'].'" class="form-control" placeholder="No. Paspor..."></td>
										</tr>
										<tr>
											<td>No. KITAS/KITAP</td>
											<td>:</td>
											<td><input type="text" name="no_kita" id="no_kita" value="'.$rs['no_kita'].'" class="form-control" placeholder="No. KITAS/KITAP..." ></td>
										</tr>
										<tr>
											<td>Nama Ayah</td>
											<td>:</td>
											<td><input type="text" name="nama_ayah" id="nama_ayah" value="'.$rs['nama_ayah'].'" class="form-control" placeholder="nama ayah..." ></td>
										</tr>
										<tr>
											<td>Nama Ibu</td>
											<td>:</td>
											<td><input type="text" name="nama_ibu" id="nama_ibu" value="'.$rs['nama_ibu'].'" class="form-control" placeholder="Nama Ibu..." ></td>
										</tr>

										<tr>
											<td>Dibuat di</td>
											<td>:</td>
											<td><input type="text" name="kota" id="kota" value="'.$rs['kota_pembuat'].'" class="form-control" placeholder="Kota/Kabupaten dibuatnya KTP..." required></td>
										</tr>
										<tr>
											<td>Tanggal Dibuat</td>
											<td>:</td>
											<td><input type="text" name="tgl_buat" id="tgl_buat" value="'.date('d/m/Y',strtotime($rs['tgl_buat'])).'" class="form-control" placeholder="Tanggal dibuatnya KTP...(dd/mm/yyyy)" required>
											</td>
										</tr>
										<tr>
											<td>Foto</td>
											<td>:</td>
											<td>
												';
												if(empty($rs['foto'])){
													$dsp .= 'Belum Ada Foto';
												} else {
													$dsp .= '<img src="'.base_url().'assets/photo/'.$rs['nik'].'/'.$rs['foto'].'" class="thumbnail">';
												}
												$dsp .= '<input type="file" name="foto" class="form-control">
											</td>
										</tr>
										<tr>
											<td>Tanda Tangan</td>
											<td>:</td>
											<td>';
												if(empty($rs['tanda_tangan'])){
													$dsp .= 'Belum Ada ttd';
												} else {
													$dsp .= '<img src="'.base_url().'assets/ttd/'.$rs['nik'].'/'.$rs['tanda_tangan'].'" class="thumbnail">';
												}
												$dsp .= '<input type="file" name="ttd" class="form-control">
											</td>
										</tr>



										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("main/show").'" class="btn btn-warning">Batal</a>
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

	public function display_form_pendidikan($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_pendidikan($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('pendidikan/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA PENDIDIKAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Pendidikan</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama_pendidikan'].'" class="form-control" placeholder="Nama pendidikan..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id_pendidikan'].'">
											</td>
										</tr>


										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("pendidikan").'" class="btn btn-warning">Batal</a>
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
	public function display_form_perkawinan($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_status_kawin($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('perkawinan/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA STATUS PERKAWINAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama Status</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama_kawin'].'" class="form-control" placeholder="Nama Status Perkawinan..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id_kawin'].'">
											</td>
										</tr>


										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("perkawinan").'" class="btn btn-warning">Batal</a>
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
	public function display_form_hubungan($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_status_hubungan($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('hubungan/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA STATUS HUBUNGAN KELUARGA</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama Status</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama_hubungan'].'" class="form-control" placeholder="Nama Status ..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id_hubungan'].'">
											</td>
										</tr>


										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("hubungan").'" class="btn btn-warning">Batal</a>
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


	public function display_form_agama($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_agama($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('agama/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA AGAMA</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama Agama</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama_agama'].'" class="form-control" placeholder="Nama Agama..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id_agama'].'">
											</td>
										</tr>


										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("agama").'" class="btn btn-warning">Batal</a>
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

	public function display_form_kerja($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_kerja($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('pekerjaan/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA PEKERJAAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama Pekerjaan</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama_kerja'].'" class="form-control" placeholder="Nama Pekerjaan..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id_kerja'].'">
											</td>
										</tr>


										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("pekerjaan").'" class="btn btn-warning">Batal</a>
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
	public function display_form_surat($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		if(!empty($id)){
			$rs = $this->get_surat($id);
			$no_surat=$rs['no_surat'];
			$tgl_surat=date('d/m/Y',strtotime($rs['2018-09-15 14:02:06']));
		} else {
			$tgl_surat=date('d/m/Y');

			$jml="000".trim($this->jumlah_surat()+1);

			$blnromawi=array("I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");

			$bln=(int)date("m")-1;
			$no_surat=substr($jml,strlen($jml)-4,4)."/RT".RT." RW".RW."/".$blnromawi[$bln]."/".date("Y");
		}
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('surat/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> SURAT KETERANGAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Tanggal Surat</td>
											<td width="1%">:</td>
											<td><input type="text" class="form-control" name="tgl_buat" id="tgl_buat" value="'.$tgl_surat.'" placeholder="dd/mm/yyyy" required>																								
											</td>
										</tr>
										<tr>
											<td width="22%">No. Surat</td>
											<td width="1%">:</td>
											<td><input type="text" class="form-control" name="no_surat" id="no_surat" value="'.$no_surat.'" placeholder="No. surat" required>												
												<input type="hidden" name="id" id="id" value="'.$rs['id'].'">
											</td>
										</tr>

										<tr>
											<td width="22%">Pilih Warga</td>
											<td width="1%">:</td>
											<td>
												<div class="input-group">
												<label><input type="radio" name="jns_warga" value="1" checked="true" > Warga Dalam </label><br>
												<select name="id_data" class="form-control selectpicker" data-live-search="true">';
												$penduduk=$this->list_penduduk();
												foreach($penduduk as $p){
													$dsp .= '<option value="'.$p->id.'" data-tokens="'.$p->nik.'" >'.$p->nik." |".$p->nama_lengkap. '</option>';
												}
												
												$dsp.='</select></div>
												<div class="input-group">
												<span><label><input type="radio" name="jns_warga" value="2" > Warga Luar (lengkapi kolom dibawah)</label></span>
												</div>
												<p><input type="text" class="form-control" name="nik" id="nik" placeholder="NIK..."></p>
												<p><input type="text" class="form-control" name="nama" id="nama" placeholder="Nama..."></p>
												<p><input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir..."></p>
												<p><input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir (dd/mm/yyyy)..."></p>
												<p>';
												$dsp .= '<select name="jk" id="jk" class="form-control">';
												$dsp .= '<option value="">&mdash; Jenis Kelamin</option>';
												$dsp .= '<option value="1"'.($rs['jenis_kel']=="Laki-laki" ? ' selected' : '').'>Laki-laki</option>';
												$dsp .= '<option value="2"'.($rs['jenis_kel']=="Perempuan" ? ' selected' : '').'>Perempuan</option>';

												$dsp .= '</select>
												</p>
												<p>';
												$l_perkawinan=$this->list_perkawinan();
									
												$dsp .= '<select name="status_kawin" id="status_kawin" class="form-control" >';
													$dsp .= '<option value="">&mdash; Status Perkawinan</option>';
												foreach($l_perkawinan as $s){
													$dsp .= '<option'.($s->nama_kawin==$rs['status_kawin'] ? ' selected' : '').'>'.$s->nama_kawin.'</option>';
												}

												$dsp .= '</select></p>
												<p>';
												$l_agama = $this->list_agama();

												$dsp .= '<select name="agama" id="agama" class="form-control" >';
												if(empty($id)){
													$dsp .= '<option value="">&mdash; Pilih Agama</option>';
												}
												foreach($l_agama as $a){
													$dsp .= '<option'.($a->nama_agama==$rs['agama'] ? ' selected' : '').'>'.$a->nama_agama.'</option>';
												}
												$dsp .= '</select></p>
												<p>';
												$l_pekerjaan =$this->list_pekerjaan();

												$dsp .= '<select name="pekerjaan" id="pekerjaan" class="form-control" >';
												$dsp .= '<option value="">&mdash; Pilih Pekerjaan</option>';
												foreach($l_pekerjaan as $k){
													$dsp .= '<option'.($k->nama_kerja==$rs['pekerjaan'] ? ' selected' : '').'>'.$k->nama_kerja.'</option>';
												}

												$dsp .= '</select></p>
												<p><input type="text" class="form-control" name="alamat" id="tgl_lahir" placeholder="Alamat..."></p>
												
											</td>
										</tr>
										<tr>
											<td width="22%">Keperluan</td>
											<td width="1%">:</td>
											<td>
												<select name="keperluan" class="form-control selectpicker" data-live-search="true" required>';
											$no = 1;
											$keperluan=$this->list_keperluan();
											foreach($keperluan as $l) {
												$dsp .= '<option data-tokens="'.$l->keperluan.'" >'.$l->keperluan. '</option>';
											}
												$dsp .= '<option data-tokens="Lainnya" value="lain" >Lainnya (Isi kolom uraian dibawah)</option>';
											$dsp .= '</select>
												
												
												<br><label for="lainya">Uraian *(isi jika keperluan tdk ada di pilihan</label>
												<textarea class="form-control" name="lainnya" id="lainnya"></textarea>
												
												
											</td>
										</tr>

										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Buat</button>
												<a href="'.$_SERVER['HTTP_REFERER'].'" class="btn btn-warning">Batal</a>
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

	public function display_form_usia($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_kategory_usia($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('kat/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA KATEGORI USIA</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-striped">
										<tr>
											<td width="22%">Nama Level Usia</td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="nama" id="nama" value="'.$rs['nama_usia'].'" class="form-control" placeholder="Nama Usia..." required>
												<input type="hidden" name="id" id="id" value="'.$rs['id_usia'].'">
											</td>
										</tr>

										<tr>
											<td width="22%">Usia Min. (tahun)</td>
											<td width="1%">:</td>
											<td>
												<input type="number" name="min_usia" id="min_usia" value="'.$rs['usia_min'].'" class="form-control" placeholder="Usia Minimum..." required>
											</td>
										</tr>
										<tr>
											<td width="22%">Nama Level Usia</td>
											<td width="1%">:</td>
											<td>
												<input type="number" name="max_usia" id="max_usia" value="'.$rs['usia_max'].'" class="form-control" placeholder="Usia Maximum..." required>
											</td>
										</tr>

										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("kat").'" class="btn btn-warning">Batal</a>
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

	public function jmlh_usia($id,$rt=""){
		$rs=$this->get_kategory_usia($id);
		$ss=$this->session->userdata('ista_logged');
		if($ss['ista_adminid']=='1'){
			$qry = $this->db->get_where('data', 'TIMESTAMPDIFF(YEAR, `tgl_lahir`, CURDATE())>='.$rs['usia_min'].' AND TIMESTAMPDIFF(YEAR, `tgl_lahir`, CURDATE())<='.$rs['usia_max'].' AND `aktif`=1');
		}else{
			$qry = $this->db->get_where('data', 'TIMESTAMPDIFF(YEAR, `tgl_lahir`, CURDATE())>='.$rs['usia_min'].' AND TIMESTAMPDIFF(YEAR, `tgl_lahir`, CURDATE())<='.$rs['usia_max'].' AND `aktif`=1 AND `rt_rw` LIKE"'.$ss['ss_rt'].'%"');

		}
		$jml=$qry->num_rows();
		return $jml;
	}
	public function jmlh_pendidikan($id,$rt=""){
		$ss=$this->session->userdata('ista_logged');
		if($ss['ista_adminid']=='1'){
			$qry = $this->db->get_where('data', '`pendidikan` = '.$id.' AND `aktif`=1');
		} else {
			$qry = $this->db->get_where('data', '`pendidikan` = '.$id.' AND `aktif`=1 AND `rt_rw` LIKE "'.$ss['ss_rt'].'%"');
		}
		$jml=$qry->num_rows();
		return $jml;
	}

	public function jmlh_agama($id){
		$ss=$this->session->userdata('ista_logged');
		if($ss['ista_adminid']=='1'){
			$qry = $this->db->get_where('data', '`agama` = '.$id.' AND `aktif`=1');
		} else {
			$qry = $this->db->get_where('data', '`agama` = '.$id.' AND `aktif`=1 AND `rt_rw` LIKE "'.$ss['ss_rt'].'%"');
		}
		$jml=$qry->num_rows();
		return $jml;
	}
	public function jmlh_kerja($id){
		$ss=$this->session->userdata('ista_logged');
		if($ss['ista_adminid']=='1'){

			$qry = $this->db->get_where('data', '`pekerjaan` = '.$id.' AND `aktif`=1');
		} else {
			$qry = $this->db->get_where('data', '`pekerjaan` = '.$id.' AND `aktif`=1 AND `rt_rw` LIKE "'.$ss['ss_rt'].'%"');
		}	
		$jml=$qry->num_rows();
		return $jml;
	}
	public function jmlh_jk($id){
		$ss=$this->session->userdata('ista_logged');
		if($ss['ista_adminid']=='1'){
			$qry = $this->db->get_where('data', '`jenis_kel` = '.$id.' AND `aktif`=1');
		} else {
			$qry = $this->db->get_where('data', '`jenis_kel` = '.$id.' AND `aktif`=1 AND `rt_rw` LIKE "'.$ss['ss_rt'].'%"');
		}
		$jml=$qry->num_rows();
		return $jml;
	}

	
	public function chart_kategory_usia(){
		
	}
	
	public function chart_kategory_usia_awal(){
		$rs=$this->list_kategory_usia();
		$rs_agama=$this->list_agama();
		$rs_pelanggan = $this->db->get("pelanggan");
		
		$dsp='
		var ctx1 = document.getElementById("chart_usia");
		var ctx2 = document.getElementById("chart_agama");
		var ctx3 = document.getElementById("chart_pekerjaan");
		var ctx4 = document.getElementById("chart_jk");
		var ctx5 = document.getElementById("chart_pendidikan");

        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function() {
            return \'rgba(\' + randomColorFactor() + \',\' + randomColorFactor() + \',\' + randomColorFactor() + \',.9)\';
        };

	    var myChart = new Chart(ctx1, {
	        type: \'doughnut\',
	        data: {
	        labels: [';
	        	$i=1;
				foreach ($rs as $data) {
					$dsp .= '"'.$data->nama_usia.' ('.$data->usia_min.'-'.$data->usia_max.'Thn)"';						

					if($i<count($rs)){
						$dsp .=",";
					}
					$i++;
				}

	        $dsp .='],
	   		datasets: [{
	                label: \'JUMLAH WARGA \',
					data: [';
							$i=1;
							foreach ($rs as $data) {
								$dsp .= $this->jmlh_usia($data->id_usia);								
								if($i<count($rs)){
									$dsp .=",";
								}
								$i++;
							}	
						
					$dsp .= '],
	                backgroundColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
					
					$dsp .= '
					],
	                borderColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
				
						$dsp .= '
	                ],
	                borderWidth: 1
	            }]

			}
		});
	    var chart_pendidikan = new Chart(ctx5, {
	        type: \'doughnut\',
	        data: {
	        labels: [';
				$i=1;
				$rs=$this->list_pendidikan();
				foreach ($rs as $data) {
					$dsp .= '"'.$data->nama_pendidikan.'"';						

					if($i<count($rs)){
						$dsp .=",";
					}
					$i++;
				}

	        $dsp .='],
	   		datasets: [{
	                label: \'JUMLAH WARGA \',
					data: [';
							$i=1;
							foreach ($rs as $data) {
								$dsp .= $this->jmlh_pendidikan($data->id_pendidikan);								
								if($i<count($rs)){
									$dsp .=",";
								}
								$i++;
							}	
						
					$dsp .= '],
	                backgroundColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
					
					$dsp .= '
					],
	                borderColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
				
						$dsp .= '
	                ],
	                borderWidth: 1
	            }]

			}
		});

		var chart_kerja = new Chart(ctx3, {
	        type: \'doughnut\',
	        data: {
	        labels: [';
				$i=1;
				$rs=$this->list_pekerjaan();
				foreach ($rs as $data) {
					$dsp .= '"'.$data->nama_kerja.'"';						

					if($i<count($rs)){
						$dsp .=",";
					}
					$i++;
				}

	        $dsp .='],
	   		datasets: [{
	                label: \'JUMLAH WARGA \',
					data: [';
							$i=1;
							foreach ($rs as $data) {
								$dsp .= $this->jmlh_kerja($data->id_kerja);								
								if($i<count($rs)){
									$dsp .=",";
								}
								$i++;
							}	
						
					$dsp .= '],
	                backgroundColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
					
					$dsp .= '
					],
	                borderColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
				
						$dsp .= '
	                ],
	                borderWidth: 1
	            }]
			},
			options: {
				legend: {
					display: false
				}
			}
		});
	    var chart_jk = new Chart(ctx4, {
	        type: \'doughnut\',
	        data: {
	        labels: ["Laki-laki","Perempuan"],
	   		datasets: [{
	                label: \'JUMLAH WARGA \',
					data: [';
						$dsp .= $this->jmlh_jk(1).",";														
						$dsp .= $this->jmlh_jk(2);														
						$dsp .= '],
	                backgroundColor: [';
						$i=2;
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
					
					$dsp .= '
					],
	                borderColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
				
						$dsp .= '
	                ],
	                borderWidth: 1
	            }]
			},
			options: {
				legend: {
					display: false
				}
			}
		});


	    var chart_a = new Chart(ctx2, {
	        type: \'doughnut\',
	        data: {
	        labels: [';
	        	$i=1;
				foreach ($rs_pelanggan as $data) {
					$dsp .= '"'.$data->id_agen.'"';						

					if($i<count($rs_pelanggan)){
						$dsp .=",";
					}
					$i++;
				}

	        $dsp .='],
	   		datasets: [{
	                label: \'JUMLAH WARGA \',
					data: [';
							$i=1;
							foreach ($rs_pelanggan as $data) {
								$dsp .= $this->jmlh_agama($data->id_agen);								
								if($i<count($rs)){
									$dsp .=",";
								}
								$i++;
							}	
						
					$dsp .= '],
	                backgroundColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
					
					$dsp .= '
					],
	                borderColor: [';
						
						for($c=1;$c<=$i;$c++) {
							$dsp .= 'randomColor()';								
							if($c<$i){
								$dsp .=",";
							}

						}	
				
						$dsp .= '
	                ],
	                borderWidth: 1
	            }]
	        }
	    });'				
		;		

		return $dsp;
	}
	
	
	public function display_form_editById($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		$rs = $this->get_penduduk($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('main/savemutasi').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> FORM KEMATIAN/PINDAH KELUAR</strong>
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
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>

										<tr>
											<td><strong>Tanggal Mutasi</strong></td>
											<td>:</td>
											<td><input type="text" name="tgl_buat" id="tgl_buat" value="'.date('d/m/Y').'" class="form-control" placeholder="Tanggal Mutasi (kejadian)...(dd/mm/yyyy)" required>
											</td>
										</tr>

										<tr>
											<td><strong>Jenis Mutasi</strong></td>
											<td>:</td>
											<td>';
											$dsp .= '<select name="mutasi" id="mutasi" class="form-control" required>';
											$dsp .= '<option value="">&mdash; Jenis Mutasi</option>';
											$dsp .= '<option value="3" selected>Pindah</option>';
											$dsp .= '<option value="4">Meninggal Dunia</option>';

											$dsp .= '</select>
											</td>
										</tr>
										<tr>
											<td><strong>Keterangan</strong></td>
											<td>:</td>
											<td><textarea class="form-control" name="ket"></textarea>
											</td>
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
	public function display_surat($id = "")
	{
		$ss = $this->session->userdata('ista_logged');
		if(!empty($id)){
			$rs = $this->get_surat($id);
			$no_surat=$rs['no_surat'];
			$tgl_surat=date('d/m/Y',strtotime($rs['tgl_surat']));
		} else {
			$tgl_surat=date('d/m/Y');

			$jml="000".trim($this->jumlah_surat()+1);

			$blnromawi=array("I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");

			$bln=(int)date("m")-1;
			$no_surat=substr($jml,strlen($jml)-4,4)."/RT".RT." RW".RW."/".$blnromawi[$bln]."/".date("Y");
		}
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title text-center">
                           	<h4>
							   <strong>KECAMATAN '.strtoupper(KECAMATAN).'</strong>
							</h4>
							<h4><strong>KELURAHAN '.strtoupper(DESA).'</strong></h4>
							<h3><strong>RUKUT TETANGGA '.strtoupper(RT).'/RUKUN WARGA '.strtoupper(RW).'</strong></h3>
						</div>
						
						<div class="x_content">
							<div class="row text-center">
								<h4><strong>SURAT PENGANTAR</strong></h4>								
								<h4><strong>NO : '.$no_surat.'</strong></h4>								
							</div>
							<div class="row">
							&emsp; &emsp; &emsp; &emsp;Yang bertanda tangan di bawah ini Ketua RT.'.RT.' / RW'.RW.' Kelurahan
							'.DESA.' Kecamatan '.KECAMATAN.', Kota Madiun, dengan ini menerangkan bahwa :<br>
							<table>
								<tr>
									<td>Nama</td><td>:</td><td>&emsp;'.$rs['nama'].'</td>
								</tr>
								<tr>
									<td>NIK</td><td>:</td><td>&emsp;'.$rs['nik'].'</td>
								</tr>
								<tr>
									<td>Tempat/Tgl. Lahir &emsp;</td><td>:</td><td>&emsp;'.$rs['tempat_lahir']."/".date("d-m-Y",strtotime($rs['tgl_lahir'])).'</td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td><td>:</td><td>&emsp;'.$rs['jenis_kel'].'</td>
								</tr>
								<tr>
									<td>Status</td><td>:</td><td>&emsp;'.$rs['status_kawin'].'</td>
								</tr>
								<tr>
									<td>Agama</td><td>:</td><td>&emsp;'.$rs['agama'].'</td>
								</tr>
								<tr>
									<td>Pekerjaan</td><td>:</td><td>&emsp;'.$rs['pekerjaan'].'</td>
								</tr>
								<tr>
									<td>Alamat</td><td>:</td><td>&emsp;'.$rs['alamat'].'</td>
								</tr>
								<tr>
									<td>Keperluan</td><td>:</td><td>&emsp;'.$rs['keperluan'].'</td>
								</tr>
							</table>
							&emsp; &emsp; &emsp; &emsp;Demikian Surat Pengantar ini dibuat untuk dipergunakan sebagaimana mestinya.
							</div>
							<div class="row">
								<div class="col-4">&nbsp;</div>
								<div class="col-4">&nbsp;</div>
								<div class="col-4 pull-right">
								<p class="text-center">Madiun, '.date("d-F-Y",strtotime($rs['tgl_surat'])).'
								<br>Ketua RT. '.RT.' / RW. '.RW.'</p>
								</div>
							</div>
							<div class="float-clear"></div>
							<div class="row">
								<div class="col-6">
								<small>CATATAN :Pada waktu pengurusan surat ke Kelurahan, diharap membawa KTP dan KK asli.</small>
								</div>
							</div>
							<div class="float-clear"></div>
							<div class="row text-center">
								<buton class="btn btn-success hidden-print" onclick="window.print();">CETAK</buton>
							</div>

							
						</div>
					</div>
				</div>';

		return $dsp;
	}


}

?>