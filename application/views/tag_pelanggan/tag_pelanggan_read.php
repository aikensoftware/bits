	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h3>
					<strong><i class="fa fa-file"></i> PELANGGAN DETAIL</strong>
				</h3>
			</div>
		</div>
	</div>
			
	<div class="col-md-6 col-sm-6 col-xs-6">
		<table class="table">
			<tr><td>Kode</td><td><?php echo $kode; ?></td></tr>
			<tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
			<tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
			<tr><td>Telp</td><td><?php echo $telp; ?></td></tr>
			<tr><td>Id Layanan</td><td><?php echo $id_layanan; ?></td></tr>
			<tr><td>Id Patner</td><td><?php echo $id_patner; ?></td></tr>
			<tr><td>In Pajak</td><td><?php echo $in_pajak; ?></td></tr>
			<tr><td>Tanggal Pasang</td><td><?php echo $tanggal_pasang; ?></td></tr>
			<tr><td>Status</td><td><?php echo $status; ?></td></tr>
			<tr><td></td><td><a href="<?php echo site_url('pelanggan') ?>" class="btn btn-default">Kembali Ke Data Pelanggan</a></td></tr>
		</table>
	</div>
	
	<div class="col-md-6 col-sm-6 col-xs-6">
		<strong>Log</strong><br/>
		<?php
			if(isset($id_pelanggan) && $id_pelanggan > 0){
				$this->db->where('id_pelanggan',$id_pelanggan);
				$this->db->order_by('id_log','desc');
				$dt_log = $this->db->get('log_update');
				
				if($dt_log->num_rows() > 0){
					foreach($dt_log->result() as $b){
						echo '-'.$b->updated.'::'.$b->keterangan;
						echo '<br/>';
					}
				}
			}
		?>
	</div>
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
       
        <h3 class="page-header"  style="margin-top:0px">Detail Faktur Pelanggan </h3>
		<table class="table">
			<tr>
				<td>No</td>
				<td>Tanggal Tagihan</td>
				<td>No Faktur</td>
				<td style="text-align:right;">Total</td>
				<td style="text-align:right;">Pokok</td>
				<td style="text-align:right;">Pajak</td>
			</tr>
			<?php
			$base = site_url();
				$id_pelanggan = isset($id_pelanggan)?$id_pelanggan:0;
				if($id_pelanggan > 0)
				{
					$dt_tahun = $this->db->query(" SELECT year(tanggal) as tahun FROM `tag_tagihan` where id_pelanggan = $id_pelanggan  group by year(tanggal) order by id_tagihan desc");
					if($dt_tahun->num_rows() > 0)
					{
						echo 'Tahun'.$dt_tahun->num_rows();
						foreach($dt_tahun->result() as $b)
						{
							echo '<tr>
									<th colspan="6">Tahun : '.$b->tahun.'</th>
									</tr>';
							$tahun = $b->tahun;		
							$data_detail = $this->db->query(" SELECT * FROM tag_tagihan where id_pelanggan = $id_pelanggan and year(tanggal) = $tahun ");
							$no = 1;
							$v_total_tagihan= 0;
							$v_pokok 		= 0;
							$v_pajak		= 0;
							
							foreach($data_detail->result() as $det)
							{
								echo '<tr>
										<td>'.$no.'</td>
										<td>'.$det->tanggal.'</td>
										<td><a target="blank" href="'.$base.'/pelanggan/cetak_faktur_ulang/'.$det->id_tagihan.'">'.$det->no_transaksi.'</a></td>
										<td style="text-align:right;">'.$this->umum->format_rupiah($det->total_tagihan).'</td>
										<td style="text-align:right;">'.$this->umum->format_rupiah($det->pokok).'</td>
										<td style="text-align:right;">'.$this->umum->format_rupiah($det->pajak).'</td>
										</tr>';
								$no++;
								$v_total_tagihan += $det->total_tagihan;
								$v_pokok	+= $det->pokok;
								$v_pajak	+= $det->pajak;
							}
							echo '<tr>
									<th colspan="3">Total Tagihan Tahun : '.$b->tahun.'</th>
									<th style="text-align:right;">'.$this->umum->format_rupiah($v_total_tagihan).'</th>
									<th style="text-align:right;">'.$this->umum->format_rupiah($v_pokok).'</th>
									<th style="text-align:right;">'.$this->umum->format_rupiah($v_pajak).'</th>
									</tr>';
							
						}
					}
				}
			?> 
			   
		</table>
		
		
		</div>
	</div>
	<br/><br/><br/><br/><br/>
		