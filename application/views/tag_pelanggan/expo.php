
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <title>Cetak data pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	
	</head>
	
	<body>
	<?php
		$nama_file = date('Y-m-d H:i:s').'Cetak_data_pelanggan.xls';
	?>			
	
	<?php
		# judul	
		$content ='<table class="table" border="1">';		
		$content .= '<tr>
						<td>No Faktur</td>
						<td>Nama Pelanggan</td>
						<td>Mitra</td>
						<td>Nilai Langganan</td>
						<td>Bulan Faktur</td>
					</tr>';
	?>
	<?php
	
		$no =1;
		if(isset($data) && $data->num_rows() > 0){
			foreach($data->result() as $b){
				$total = $b->pokok + $b->pajak;
				$content .= '<tr>
								<td>'.$b->no_transaksi.'</td>
								<td>'.$b->nama_pelanggan.'</td>
								<td>'.$b->nama_patner.'</td>
								<td>'.$total.'</td>
								<td>'.$this->umum->nama_bulan($b->bulan_tagihan).'</td>
							</tr>';
			}
			
		}else{
			$content .= '<tr><td>Data masih kosong</td></tr>';
		}
		$content .='</table>';
		 
	?>
	<?php 
	
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=".$nama_file);  
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",true);
		
		echo $content;
	?>
	
	</body>
</html>