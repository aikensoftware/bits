<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <title>Cetak Nota Besar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="groges">
    <!-- Bootstrap -->
    <link href="{url}assets/template/default/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{url}assets/template/default/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{url}assets/template/dist/css/AdminLTE.min.css">
	<style>
		/* table */

		table{
			font-size:10px;
			font-family: "Calibri";
			background-color:#FFF;
			text-align:left;
			}
	</style>
<style>
.gb {
  border-bottom-style: dashed;
  border-width: thin;  
}
.jumlah {
	padding: 10px;
	border-style: solid;
	border-width: thin;  	
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
					
					$tahun				=$b_ini->tahun;
					$bulan				=substr('0'.$b_ini->bulan,-2,2);
		?>
		
		
						<br/><br/><br/><br/>
						<table width="100%" >
							<tr>
								<td align="center" colspan="2">
									<img src="https://bits.net.id/images/site/logo-web-bits-net.png" >
									
								</td>
								<td align="center" >
								<h3><strong>PT. BINA INFORMATIKA SOLUSI</strong></h3>
								Jl. Prakarsa Muda Perumahan Linggahara Bedeng Batu<br />
								Kel. Pekiringan Kec. Kesambi - Cirebon Phone:(0231)-247618 Fax: (0231)-8305250<br>
								Email:Finance@bitsnet.co.id
								</td>
								<td align="center">
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
							<tr><td colspan="4"><hr/></td></tr> 			
							<tr>
								<td colspan="4" align="center">
									<h3><u>P E M B A Y A R A N</u><br>No. <?php echo isset($tahun)?$tahun:''; ?>/BITS/PB.<?php echo isset($bulan)?$bulan:''; ?>/<?php echo isset($nomor_tagihan)?$nomor_tagihan:''; ?></h3>
									
								</td>
							</tr> 	
							<tr>
								<td width="25%">
									Telah Terima Dari 
								</td>
								<td >: </td>
								<td colspan="2" class="gb"><?php
													echo isset($nama_pelanggan)?$nama_pelanggan:'';?></td>

							</tr>		
							<tr>
								<td>
									Besarnya Uang 
								</td>
								<td >: </td>
								<td colspan="2" class="gb"><?php echo isset($total)?$this->umum->terbilang($total).' rupiah':'';?></td>
								
							</tr>		
							<tr>
								<td>
									
								</td>
								<td > </td>
								<td colspan="2" class="gb">(Harga sudah termasuk PPn 10%)</td>
								
							</tr>		
							<tr>
								<td>
									Untuk Pembayaran 
								</td>
								<td >: </td>
								<td colspan="2" class="gb">Internet Periode <?php echo isset($bulan_tagihan)?$bulan_tagihan:''; ?> </td>
								
							</tr>		
							<tr>
								<td>
									&nbsp;
								</td>
								<td >&nbsp; </td>
								<td colspan="2" class="gb">&nbsp;</td>
								
							</tr>		
							
							<tr>
								<td  colspan="2" class="jumlah" align="center">
									<strong>
									JUMLAH : &nbsp; Rp <?php echo isset($total)?$this->umum->format_rupiah($total):''; ?>,-
									</strong>
								</td>
								<td >&nbsp; </td>
								<td >&nbsp;</td>
								
							</tr>		
							<tr>
								<td>
									&nbsp;
								</td>
								<td >&nbsp; </td>
								
								<td colspan="2" align="center">Cirebon, <?php echo isset($tanggal)?$tanggal:''; ?> <?php echo isset($bulan_tagihan)?$bulan_tagihan:''; ?><br>
									PT. BINA INFORMATIKA SOLUSI<br/>
									
										<img src="<?php echo base_url(); ?>assets/images/ttd.png" width="150px" height="70px">
										<br/> <strong>( Lusy Anjelita )</strong>		
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
		
		<table width="100%" >
			<tr>
				<td align="center" colspan="2">
					<img src="https://bits.net.id/images/site/logo-web-bits-net.png" >
					
				</td>
				<td align="center" >
				<h3><strong>PT. BINA INFORMATIKA SOLUSI</strong></h3>
				Jl. Prakarsa Muda Perumahan Linggahara Bedeng Batu<br />
				Kel. Pekiringan Kec. Kesambi - Cirebon Phone:(0231)-247618 Fax: (0231)-8305250<br>
				Email:Finance@bitsnet.co.id
				</td>
				<td align="center">
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
			<tr><td colspan="4"><hr/></td></tr> 			
			<tr>
				<td colspan="4" align="center">
					<h3><u>P E M B A Y A R A N</u><br>No. <?php echo isset($tahun)?$tahun:''; ?>/BITS/PB.<?php echo isset($bulan)?$bulan:''; ?>/<?php echo isset($nomor_tagihan)?$nomor_tagihan:''; ?></h3>
					
				</td>
			</tr> 	
			<tr>
				<td width="25%">
					Telah Terima Dari 
				</td>
				<td >: </td>
				<td colspan="2" class="gb"><?php
									echo isset($nama_pelanggan)?$nama_pelanggan:'';?></td>

			</tr>		
			<tr>
				<td>
					Besarnya Uang 
				</td>
				<td >: </td>
				<td colspan="2" class="gb"><?php echo isset($total)?$this->umum->terbilang($total).' rupiah':'';?></td>
				
			</tr>		
			<tr>
				<td>
					
				</td>
				<td > </td>
				<td colspan="2" class="gb">(Harga sudah termasuk PPn 10%)</td>
				
			</tr>		
			<tr>
				<td>
					Untuk Pembayaran 
				</td>
				<td >: </td>
				<td colspan="2" class="gb">Internet Periode <?php echo isset($bulan_tagihan)?$bulan_tagihan:''; ?> </td>
				
			</tr>		
			<tr>
				<td>
					&nbsp;
				</td>
				<td >&nbsp; </td>
				<td colspan="2" class="gb">&nbsp;</td>
				
			</tr>		
			
			<tr>
				<td  colspan="2" class="jumlah" align="center">
					<strong>
					JUMLAH : &nbsp; Rp <?php echo isset($total)?$this->umum->format_rupiah($total):''; ?>,-
					</strong>
				</td>
				<td >&nbsp; </td>
				<td >&nbsp;</td>
				
			</tr>		
			<tr>
				<td>
					&nbsp;
				</td>
				<td >&nbsp; </td>
				
				<td colspan="2" align="center">Cirebon, <?php echo isset($tanggal)?$tanggal:''; ?> <?php echo isset($bulan_tagihan)?$bulan_tagihan:''; ?><br>
					PT. BINA INFORMATIKA SOLUSI<br/>
									
					<img src="<?php echo base_url(); ?>assets/images/ttd.png" width="150px" height="70px">
					<br/> <strong>( Lusy Anjelita )</strong>				
				</td>
			</tr>		

 		</table>
 		
		
		<?php
			}
		?>
 	</body>
 </html>