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
		$this->db->select('t1.*, t2.nama as nama_layanan,t3.nama as nama_patner, t3.prosen as prosen');
     	$this->db->from('tag_pelanggan as t1');
        if($ss['ss_idagen']>0){
            $this->db->where("t1.id_agen",$ss['ss_idagen']);
        }

        if($ss['ss_idpatner']>0){
            $this->db->where("t1.id_patner",$ss['ss_idpatner']);
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
        $pelanggan=$this->list_pelanggan();
		$msg = $this->session->flashdata('admin_login_msg');

		$dsp ='';



		
		if(!empty($msg)):
		$dsp .= '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					'.$msg.'
				</div>';
		endif;

		$dsp .= '<form method="post" action="'.site_url('pelanggan/printAll').'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-file"></i> SETTING MASTER PELANGGAN</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                        		<div style="display:block; clear:both; margin:0 auto 10px;">
                        			<a href="'.site_url('pelanggan/add').'" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</a>
                        			<button class="btn btn-danger" type="submit" name="btnPrintAll" onclick="return confirm(\'Yakin mau mencetak semua yang dipilih?\')"><i class="fa fa-minus-circle"></i> Cetak Nota yg dipilih</button>
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
												<th style="text-align:center;">Alamat</th>
												<th style="text-align:center;">Telp</th>
												<th style="text-align:center;">Layanan</th>
												<th style="text-align:center;">Abonemen</th>
												<th style="text-align:center;">PPN</th>
												<th style="text-align:center;">Fee</th>
												<th style="text-align:center;">Rekanan</th>
												<th style="text-align:center;">Pajak</th>
												<th style="text-align:center;">Tanggal Pasang</th>
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
							
						$vv_pokok = $b_ini->pokok;
						$vv_pajak = $b_ini->pajak;
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
					<td>'.$l->alamat.'</td>
					<td>'.$l->telp.'</td>
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
					$dsp .= $this->umum->dari_lengkap_ke_garis($l->tanggal_pasang); 
					$dsp .= '</td>
					<td>';
					$dsp .=  $v_status;
					$dsp .= '</td>
					<td>';
					$dsp .=$v_tagihan_bulan_ini;
					$dsp .= '</td>';
					
						
					$dsp .= '
					<td style="text-align:center" width="200px">';
						
					$dsp .= anchor(site_url('tag_pelanggan/read/'.$tag_pelanggan->id_pelanggan),'Read',array('class' => 'btn btn-success btn-xs'));
					$dsp .= '&nbsp;';
					$dsp .= anchor(site_url('tag_pelanggan/update/'.$tag_pelanggan->id_pelanggan),'Update',array('class' => 'btn btn-warning btn-xs')); 
						
					$dsp .= '						
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

/* End of file Tag_pelanggan_model.php */
/* Location: ./application/models/Tag_pelanggan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:28:11 */
/* http://harviacode.com */