
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <title>Cetak Nota Besar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<style>
		/* table */

		table{
			font-size:14px;
			font-family: "Calibri";
			background-color:#FFF;
			text-align:left;
			}

		.tb{
			font-family: "Calibri";
			margin:0px;
			padding:5px;
			border-bottom:1px solid #CCC;
			}

		th{
			background:#0606fe;
			background-color:red;
			padding:5px;
			color:white;
			}

		td{
			margin:2px;
			padding:2px;
			}

	</style>
	<style type="text/css" media="print">
		.dontprint
		{ display: none; }
		.footer {page-break-after: always;}
	</style>
	</head>
	
	<body onLoad="window.print()">
		<div class="dontprint">
			<a href="<?php echo site_url(); ?>/pelanggan/cetak_faktur/<?php echo isset($id_tagihan)?$id_tagihan:''; ?>/200">
				<input type="button" value="Print Faktur ">
			</a>
			<a href="<?php echo site_url(); ?>/pelanggan" class="btn btn-warning btn-sm" > Kembali Ke Data Pelanggan </a>
		</div>
		
		<?php 

			$jarak_satu = 1;
			if(isset($data_faktur_all) && $data_faktur_all->num_rows() > 0){ 
				foreach($data_faktur_all->result() as $b_ini){
					
					$id_tagihan 		= $b_ini->id_tagihan;
					$bulan_tagihan		= $this->umum->nama_bulan($b_ini->bulan).' '.$b_ini->tahun;
					$nomor_tagihan		= $b_ini->no_transaksi;
					$tanggal_bayar		= $this->umum->ubah_ke_garis($b_ini->tanggal);
					$nama_pelanggan		= '['.$b_ini->kode.'] '.$b_ini->nama;
					$alamat_pelanggan	= $b_ini->alamat;

					$abonemen			= $b_ini->pokok;
					$pajak				= $b_ini->pajak;
					$total				= $b_ini->pokok + $b_ini->pajak;
					$qrcode				= $b_ini->qrcode;
		?>
					<br/><br/><br/><br/>
					<table style="width:100%;" border="0">
						<tr>
							<td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td colspan="12">
								<table width="100%">
									<tr>
										<td >
											<img src="https://bits.net.id/images/site/logo-web-bits-net.png" >
											
										</td>
										<td >
											Bukti Pembayaran Jasa Internet<br/>
											FAKTUR PAJAK<br/>
											<?php
												$dt_usaha = $this->db->query("select * from tag_usaha");
												if($dt_usaha->num_rows() > 0){
													$r = $dt_usaha->row();
													echo $r->nama.' '.$r->alamat.'<br/>';							
												}
											?>
										</td>
										<td>
											<?php
												if(isset($qrcode) && $qrcode <> ''){
													$base = site_url();
													$v_qrcode = $base.'/cek_faktur/valid/'.$qrcode;
													
											?>
												
												<img src='https://chart.googleapis.com/chart?cht=qr&chl=<?php echo $v_qrcode; ?>&chs=120x120&choe=UTF-8&chld=L|2' rel='nofollow' alt='qr code'>
												<a href='http://www.qrcode-generator.de' border='0' style='cursor:default'  rel='nofollow'></a>

											<?php		
												}
											?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td colspan="12"><hr/></td></tr>
						<tr>
							<td colspan="4" style="vertical-align: top;">
								Bulan Tagihan<br/>
								<?php echo isset($bulan_tagihan)?$bulan_tagihan:''; ?>
							</td>
							<td colspan="4" style="vertical-align: top;">
								Nomor Tagihan<br/>
								<?php echo isset($nomor_tagihan)?$nomor_tagihan:''; ?>
							</td>
							<td colspan="4" style="vertical-align: top;">
								Tanggal Bayar<br/>
								<?php echo isset($tanggal_bayar)?$tanggal_bayar:''; ?>
							</td>
						</tr>
						<tr>
							<td colspan="12">
								
								<?php
									echo isset($nama_pelanggan)?$nama_pelanggan:'';
									echo '<br/>';
									echo isset($alamat_pelanggan)?$alamat_pelanggan:'';
								?>
							</td>
						</tr>
						<tr>
							<td colspan="12">
								
								<table >
									<tr>
										<td>Abonemen</td>
										<td style="text-align:right;"><?php echo isset($abonemen)?$this->umum->format_rupiah($abonemen):''; ?></td>
									</tr>
									<tr>
										<td>Pajak</td>
										<td style="text-align:right;"><?php echo isset($pajak)?$this->umum->format_rupiah($pajak):''; ?></td>
									</tr>
									<tr>
										<td>Jumlah Tag.Bulan Ini</td>
										<td style="text-align:right;"><?php echo isset($total)?$this->umum->format_rupiah($total):''; ?></td>
									</tr>
									
								</table><br/>
								Terbilang : <?php echo isset($total)?$this->umum->terbilang($total):'';?>
							<td>
						</tr>
						<tr>
							<td colspan="12" style="text-align:center;">
								
								Terima kasih atas pembayarannya
							</td>
						</tr>
					</table>
					<?php
						if($jarak_satu == 2){
					?>
						<div class="footer"></div>
					<?php
							$jarak_satu =1;
						}else{
							$jarak_satu++;
						}
					?>
		<?php
				}
		?>
		<?php } else { ?>
		<table style="width:100%;" border="0">
			<tr>
				<td></td><td></td><td></td><td></td>
				<td></td><td></td><td></td><td></td>
				<td></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td colspan="12">
					<table width="100%">
						<tr>
							<td >
								<?php
									if(isset($qrcode) && $qrcode <> ''){
										$base = site_url();
										$v_qrcode = $base.'/cek_faktur/valid/'.$qrcode;
										
								?>
									
									<img src='https://chart.googleapis.com/chart?cht=qr&chl=<?php echo $v_qrcode; ?>&chs=120x120&choe=UTF-8&chld=L|2' rel='nofollow' alt='qr code'>
									<a href='http://www.qrcode-generator.de' border='0' style='cursor:default'  rel='nofollow'></a>

								<?php		
									}
								?>
								
							</td>
							<td >
								Bukti Pembayaran Jasa Internet<br/>
								FAKTUR PAJAK<br/>
								<?php
									$dt_usaha = $this->db->query("select * from tag_usaha");
									if($dt_usaha->num_rows() > 0){
										$r = $dt_usaha->row();
										echo $r->nama.' '.$r->alamat.'<br/>';							
									}
								?>
							</td>
						</tr>
					</table>
					
				</td>
			</tr>
			<tr><td colspan="12"><hr/></td></tr>
			<tr>
				<td colspan="4" style="vertical-align: top;">
					Bulan Tagihan<br/>
					<?php echo isset($bulan_tagihan)?$bulan_tagihan:''; ?>
				</td>
				<td colspan="4" style="vertical-align: top;">
					Nomor Tagihan<br/>
					<?php echo isset($nomor_tagihan)?$nomor_tagihan:''; ?>
				</td>
				<td colspan="4" style="vertical-align: top;">
					Tanggal Bayar<br/>
					<?php echo isset($tanggal_bayar)?$tanggal_bayar:''; ?>
				</td>
			</tr>
			<tr>
				<td colspan="12">
					<br/>
					<?php
						echo isset($nama_pelanggan)?$nama_pelanggan:'';
						echo '<br/>';
						echo isset($alamat_pelanggan)?$alamat_pelanggan:'';
					?>
				</td>
			</tr>
			<tr>
				<td colspan="12">
					<table>
						<tr>
							<td>Abonemen</td>
							<td style="text-align:right;"><?php echo isset($abonemen)?$this->umum->format_rupiah($abonemen):''; ?></td>
						</tr>
						<tr>
							<td>Pajak</td>
							<td style="text-align:right;"><?php echo isset($pajak)?$this->umum->format_rupiah($pajak):''; ?></td>
						</tr>
						<tr>
							<td>Jumlah Tag.Bulan Ini</td>
							<td style="text-align:right;"><?php echo isset($total)?$this->umum->format_rupiah($total):''; ?></td>
						</tr>
						
					</table>
					<br/>
					Terbilang : <?php echo isset($total)?$this->umum->terbilang($total):'';?>
				<td>
			</tr>
			<tr>
				<td colspan="12" style="text-align:center;">
					
					Terima kasih atas pembayarannya
				</td>
			</tr>
		</table>

		<?php } ?>	
			
		<br/>
		<div class="dontprint"><a href="<?php echo site_url(); ?>/pelanggan">Kembali ke data pelanggan </a></div>
	</body>
</html>
