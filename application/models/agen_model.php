<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agen_model extends CI_Model
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
			//$this->db->where('id_patner', $id_patner);
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

	function list_agen()
	{
        $ss = $this->session->userdata('ista_logged');
		if($ss['ss_idagen'] > 0){
			$this->db->where("id_agen", $ss['ss_idagen']);
		}
		# khusus login admin ketika memilih agen
		$pilih_agen = $this->session->userdata('pilih_agen');
		if($ss['ss_idagen'] == 0 && $pilih_agen > 0){
			$this->db->where("id_agen", $pilih_agen);
		}
		$this->db->order_by("nama", 'Asc');
		$qry = $this->db->get('patner');
        
		return $qry->result();
	}

	public function display_master_agen()
	{
		$ss = $this->session->userdata('ista_logged');
		$pilih_agen = $this->session->userdata('pilih_agen');
		
        $pelanggan=$this->list_agen();
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp ='';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		if($ss['ss_idagen'] == 0){
		$dsp .='<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
									<form method="post" action="'.site_url('agen/cari_agen').'" enctype="multipart/form-data">
										<table class="table table-striped">
											
											<tr>
												<td style="text-align:left;">Tentukan Cabang </td>
												<td>:</td>
												<td>';
													$dsp .= '<select name="pilih_agen" id="pilih_agen" class="form-control" required>';
													$dsp .= '<option value="0"'.($pilih_agen==0 ? ' selected' : '').'>&mdash; SEMUA CABANG</option>';
													$dsp .= '<option value="1"'.($pilih_agen==1 ? ' selected' : '').'>CABANG MADIUN</option>';
													$dsp .= '<option value="2"'.($pilih_agen==2 ? ' selected' : '').'>CABANG CIREBON</option>';
													$dsp .= '<option value="3"'.($pilih_agen==3 ? ' selected' : '').'>CABANG BENGKULU</option>';
													
													$dsp .= '</select>
												</td>
												<td>
													<button type="submit" name="kirim" class="btn btn-primary">Terapkan</button>
												</td>
											</tr>
											
										</table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>		
					';
		}
		
		$dsp .= '<form method="post" action="'.site_url('agen/remove').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> SETTING MASTER PATNER '.$ss['ista_adminame'].' </strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">';
									
									if($ss['ss_idagen'] == 0){
										
									}else{
										$dsp .='<a href="'.site_url('agen/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>';
										$dsp .='<button class="btn btn-danger" type="submit" name="btnDeleteAll" onclick="return confirm(\'Yakin mau menghapus semua yang dipilih?\')"><i class="fa fa-minus-circle"></i> Hapus yg dicawang</button>';
									}
								$dsp .='		
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
												<th style="text-align:center;">NAMA </th>
												<th style="text-align:center;">ALAMAT</th>
												<th style="text-align:center;">TELP</th>
												<th style="text-align:center;">PROSEN</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>';
										$no = 1;
										foreach($pelanggan as $l) {
											//id_patner, kode, nama, alamat, telp, prosen, id_agen
											$dsp .= '<tr>
												<td>
													<input type="checkbox" name="chkDetail[]" id="chkDetail" value="'.$l->id_patner.'" class="form-control chk">
												</td>
												<td style="text-align:center;">'.$no++.'</td>
												<td>'.$l->kode.'</td>
												<td>'.$l->nama.'</td>
												<td>'.$l->alamat.'</td>
												<td>'.$l->telp.'</td>
												<td>'.$l->prosen.'</td>
												<td>
													<a href="'.site_url("agen/edit/".$l->id_patner).'" class="btn-sm btn-warning">Edit</a> '.anchor('agen/delete/'.$l->id_patner,"Delete",array(
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

	function get_agen($id)
	{		
		$qry = $this->db->get_where('patner', array('id_patner' => $id));

		return $qry->row_array();
	}
	
	public function display_form_agen($id = null)
	{
		$ss = $this->session->userdata('ista_logged');
		
		$rs = $this->get_agen($id);

		$msg = $this->session->flashdata('admin_login_msg');

		$dsp = '';

		if(!empty($msg)):
		$dsp .= '<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong>'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('agen/save').'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> DATA PATNER</strong>
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
												<input type="hidden" name="id_patner" id="id_patner" value="'.$rs['id_patner'].'">
											</td>
										</tr>
										
										<tr>
											<td width="22%">Alamat </td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="alamat" id="alamat" value="'.$rs['alamat'].'" class="form-control" placeholder="Alamat ..." required>
												
											</td>
										</tr>
										
										<tr>
											<td width="22%">Telp </td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="telp" id="telp" value="'.$rs['telp'].'" class="form-control" placeholder="Telp ..." required>
												
											</td>
										</tr>
										
										<tr>
											<td width="22%">Prosen </td>
											<td width="1%">:</td>
											<td>
												<input type="text" name="prosen" id="prosen" value="'.$rs['prosen'].'" class="form-control" placeholder="Prosen ..." required>
												
											</td>
										</tr>
										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
												<a href="'.site_url("agen").'" class="btn btn-warning">Batal</a>
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