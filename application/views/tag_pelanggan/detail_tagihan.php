
	<div class="container">
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
					$dt_tahun = $this->db->query("SELECT year(tanggal) as tahun FROM `tag_tagihan` where id_pelanggan = $id_pelanggan  group by year(tanggal) order by id_tagihan desc");
					if($dt_tahun->num_rows() > 0)
					{
						foreach($dt_tahun->result() as $b)
						{
							echo '<tr>
									<th colspan="6">Tahun : '.$b->tahun.'</th>
									</tr>';
							$tahun = $b->tahun;		
							$data_detail = $this->db->query("SELECT * FROM tag_tagihan where id_pelanggan = $id_pelanggan and year(tanggal) = $tahun ");
							$no = 1;
							$v_total_tagihan= 0;
							$v_pokok 		= 0;
							$v_pajak		= 0;
							
							foreach($data_detail->result() as $det)
							{
								echo '<tr>
										<td>'.$no.'</td>
										<td>'.$this->umum->dari_lengkap_ke_garis($det->tanggal).'</td>
										<td><a href="'.$base.'/tag_pelanggan/cetak_faktur_ulang/'.$det->id_tagihan.'">'.$det->no_transaksi.'</a></td>
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
		
	    <a href="<?php echo site_url('tag_pelanggan/cari_data') ?>" class="btn btn-primary">Kembali Ke Pelanggan</a>
	
		<br/><br/><br/>
    </div>
	