	<script src="<?php echo base_url(); ?>assets/js/auto_comp/jquery.js"></script>
	<link href="<?php echo base_url(); ?>assets/js/auto_comp/select2.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>assets/js/auto_comp/select2.min.js"></script>
	
	
<div class="container">
       
		<div class="row">
			
			<div class="col-md-12">
				<?php
					$daftar_hari_boleh[1] =1;
					$daftar_hari_boleh[2] =21;
					$daftar_hari_boleh[3] =22;
					$daftar_hari_boleh[4] =23;
					$daftar_hari_boleh[5] =24;
					$daftar_hari_boleh[6] =25;
					$daftar_hari_boleh[7] =26;
					$daftar_hari_boleh[8] =27;
					$daftar_hari_boleh[9] =28;
					$daftar_hari_boleh[10] =29;
					$daftar_hari_boleh[11] =30;
					$daftar_hari_boleh[12] =31;
	

					$hari_ini = date('j');
				?>
				<h3 class="page-header">Data pelanggan 
					<?php
						$cek = array_search($hari_ini,$daftar_hari_boleh);
						if($cek > 0){
							?>
								<?php echo anchor(site_url('tag_pelanggan/create'),'Create', 'class="btn btn-primary"'); ?> 
							<?php
						}else{
							echo '<small>Lebih dari tanggal 1 Tidak boleh menambah pelanggan, Faktur sudah dibuat </small>';
						}
					?>
					
				</h3>
			</div>
            <div class="col-md-4">
				
				<div class="form-group">
					<?php echo form_open('tag_pelanggan/cari_data'); ?>
						<table>
							<tr>
								<td style="text-align:right;">Kode :</td>
								<td>
									<input class="form-control" type="text" name="kode" value="<?php echo isset($kode)?$kode:'';?>" placeholder="">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;">Nama  :</td>
								<td>
									<input class="form-control" type="text" name="nama" value="<?php echo isset($nama)?$nama:'';?>" placeholder="">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;">Alamat :</td>
								<td>
									<input class="form-control" type="text" name="alamat" value="<?php echo isset($alamat)?$alamat:'';?>" placeholder="">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;">Rekanan :</td>
								<td>
									<?php echo isset($nama_rekanan)?$nama_rekanan:''; ?>
									<div class="form-group">
										
											<select class="itemName form-control" style="width:200px" id="itemName" name="id_patner" value="<?php echo isset($id_patner)?$id_patner:''; ?>"></select>
											<script type="text/javascript">

												  $('.itemName').select2({
													placeholder: '--- Kode /Nama Rekanan ---',
													ajax: {
													  url: '<?php echo site_url(); ?>/home/proses_cari_rekanan',
													  dataType: 'json',
													  delay: 250,
													  processResults: function (data) {
														return {
															results: $.map(data, function(obj) {
																return { id: obj.id, text: obj.kode+" - "+obj.nama};
															})
														};
													  },
													  cache: true
													}
												  });

											</script>
											
									</div>		
								
									<?php
										$part = $this->session->userdata('DX_id_patner');
										$v_id_patner = '';
										if($part > 0){
											$v_id_patner = " and id_patner = $part ";
										}
										$options= array();
										$options[''] = 'Semua Rekanan';
										$data_patner = $this->db->query("select * from tag_patner where id_patner > 0 $v_id_patner order by nama asc ");
										if(isset($data_patner)){
											if($data_patner->num_rows()>0){
												foreach($data_patner->result() as $s){
													$options[$s->id_patner] = '('.$s->kode.')'.$s->nama.'  '.$s->alamat;
												}
											}
										}
										//echo form_dropdown('id_patner', $options, $id_patner ,'class="form-control"');
									?>
								</td>
							</tr>
							<tr>
								<td style="text-align:right;">Jml.Tampil :</td>
								<td>
									<input class="form-control" type="text" name="limit" value="<?php echo isset($limit)?$limit:$this->config->item('limit_data'); ?>" >
								</td>
							</tr>
							<tr>
								<td style="text-align:right;">Urutan :</td>
								<td>
									<?php
										$sort = isset($sort)?$sort : 2;
										$options= array();
										$options[1] = ' Kode Asc a - z'; 
										$options[2] = ' Kode Desc z - a'; 
										$options[3] = ' Nama  Asc a - z'; 
										$options[4] = ' Nama  Desc z - a'; 
										$options[5] = ' Rekanan Asc a - z'; 
										$options[6] = ' Rekanan Desc z - a'; 
										
										echo form_dropdown('sort', $options, $sort,'class="form-control"' ); 
									?>
								</td>
							</tr>
							<tr>
								<td style="text-align:right;">Status :</td>
								<td>
									<?php
										$id_status = isset($id_status)?$id_status : '';
										$options= array();
										$options[''] = ' Semau Status '; 
										$options[1] = ' Aktif '; 
										$options[2] = ' Non Aktif'; 
									
										echo form_dropdown('id_status', $options, $id_status,'class="form-control"' ); 
									?>
								</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="170px;"></td>
								<td>
									<br/>
									<?php echo form_submit('mysubmit', 'Cari Data !','class="btn btn-primary btn-sm"');?>
									<a href="<?php echo site_url(); ?>/tag_pelanggan" class="btn btn-success btn-sm" >Refresh</a>									
								</td>
							</tr>
						</table>
						<?php echo form_close(); ?>
					</div>
					
			</div>
			<div class="col-md-8">
			
				<?php
					$level = $this->session->userdata('DX_role_id');
					if($level == 2){
				?>
				
						<div class="panel panel-default">
							<div class="panel-heading">Langkah membuat tagihan</div>
							<div class="panel-body">
								
								<?php
									$dt_pelanggan = $this->db->query("select * from tag_pelanggan where status = 1 ");
									$jml_aktif = $dt_pelanggan->num_rows(); 
								?>
								
								<?php 
									$attrib =array('name'=>'frm_kategori','role'=>'form','onSubmit' => "return confirm('Anda yakin akan membuat faktur tagihan ?')");
									echo form_open_multipart('tag_pelanggan/simpan_faktur', $attrib); 
								?>
								<table border="0">
									<tr>
										<td style="text-align:right;">Total Pelanggan Aktif Saat Ini</td>
										<td style="text-align:center;">:&nbsp;</td>
										<td><span class="label label-default"><?php echo $jml_aktif; ?></span></td>
									</tr>
									<tr>
										<td style="text-align:right;">Nomor Faktur Awal</td>
										<td style="text-align:center;">:&nbsp;</td>
										<td>
											<input class="form-control" type="number" name="nomor_faktur_awal" value="<?php echo isset($kode)?$kode:'';?>" placeholder="" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
										<td  style="text-align:right;">
											<br/>
											<input type="submit" value="1) Klik untuk membuat tagihan " class="btn btn-primary btn-sm" >
										
											<a href="<?php echo site_url(); ?>/tag_pelanggan/create_qrcode" class="btn btn-primary btn-sm" onClick="return confirm('Anda yakin membuat QR code ?')" > 2) Klik untuk membuat QR code </a>
										</td>
									</tr>
								</table>
								
								<?php echo form_close(); ?>  
								
								
							</div>
						</div>
						
						<?php
							$dt_nomor_akhir = $this->db->query("select date(tanggal) as tanggal, no_transaksi from tag_tagihan order by id_tagihan desc ");
							if($dt_nomor_akhir->num_rows() >0){
								$r = $dt_nomor_akhir->row();
								echo 'Nomor terakhir :';
								echo '	<h3>
											<span class="label label-warning">'.$r->no_transaksi.'</span>
										</h3>
										';
								echo 'Dibuat pada tanggal : '.$this->umum->ubah_ke_garis($r->tanggal);
							}
						?>
						
						<div class="panel panel-default">
						<div class="panel-heading">Export excel file no tagihan</div>
						<div class="panel-body">
							<form action="<?php echo site_url(); ?>/tag_pelanggan/expo_excel" method="post" accept-charset="utf-8" class="form-inline" onsubmit="return confirm('Anda yakin export ?')">	
							<input type="hidden" name="id_bor" value="1">
							<table>
								<tr>
									<td colspan="3">Tentukan Bulan </td>
								</tr>
								<tr>
									
									<td>
										<?php
											$options= array();
											
											$bulan_beli = isset($bulan_beli)?$bulan_beli: date('m') ;
											for ($x = 1; $x < 13; $x++) {
												$bln = '';
												if($x == 1){
													$bln = 'Jan';
												}else if($x == 2){
													$bln = 'Feb';
												}else if($x == 3){
													$bln = 'Mar';
												}else if($x == 4){
													$bln = 'Apr';
												}else if($x == 5){
													$bln = 'Mei';
												}else if($x == 6){
													$bln = 'Jun';
												}else if($x == 7){
													$bln = 'Jul';
												}else if($x == 8){
													$bln = 'Agu';
												}else if($x == 9){
													$bln = 'Sep';
												}else if($x == 10){
													$bln = 'Okt';
												}else if($x == 11){
													$bln = 'Nop';
												}else if($x == 12){
													$bln = 'Des';
												}
												$options[$x] = $bln;
											} 
											echo form_dropdown('bulan_beli', $options, $bulan_beli,'class="form-control"'); 
										?>
									</td>
									<td>
										<?php
											$options= array();
											
											$tahun_beli = isset($tahun_beli)?$tahun_beli: date('Y') ;
											for ($x = 2000; $x < date('Y')+3; $x++) {
												$options[$x] = $x;
											} 
											echo form_dropdown('tahun_beli', $options, $tahun_beli,'class="form-control"'); 
										?>
									</td>
									<td>
										<?php
											$options= array();
											$options[100000] = 'Semua Patner';
											$id_patner = isset($id_patner)?$id_patner: 100000 ;
											$dt_patner = $this->db->query("select * from tag_patner order by nama asc ");
											if($dt_patner->num_rows() >0){
												foreach($dt_patner->result() as $b){
													$options[$b->id_patner] = $b->nama.'---'.$b->kode;
												}
											} 
											echo form_dropdown('id_patner', $options, $id_patner,'class="form-control"'); 
										?>
									</td>
									<td>
										<button class="btn btn-primary btn-sm" type="submit">Export ke excel </button>
									</td>
								</tr>
							</table>
							<?php	echo form_close(); ?>
							
						</div>
					</div>
						
					<?php } ?>
					
					
					
											
			</div>
		</div>
		
		<form action="<?php echo site_url(); ?>/tag_pelanggan/print_semua" method="post" accept-charset="utf-8" class="form-inline" onsubmit="return confirm('Anda yakin akan print Semua ?')">	
		
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
				<th>Kode</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Telp</th>
				<th>Layanan</th>
				<th>Abonemen</th>
				<th>PPN</th>
				<th>Fee</th>
				<th>Rekanan</th>
				<th>Pajak</th>
				<th>Tanggal Pasang</th>
				<th>Status</th>
				<?php
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
					
					
					echo '<th>'.$v_bulan_ini.'</th>';
				?>
				<th>Pilih</th>
				<th>Action</th>
            </tr><?php
			
			$base = site_url(); 
			$no = isset($tot)?$tot:0; 
			$no_awal = $no+1;
			$level = $this->session->userdata('DX_role_id');
			
			$total_layanan = 0;
			$total_fee = 0;
			$total_ppn = 0;
            foreach ($tag_pelanggan_data as $tag_pelanggan)
            {
				$id_pelanggan = $tag_pelanggan->id_pelanggan;
				
				$nama_patner = '';
				$pecah = explode(' ',$tag_pelanggan->nama_patner);
				$nama_patner = $pecah[0];
		
				$t_pajak = 0;
				$v_pajak = 'Exclude';
				if($tag_pelanggan->in_pajak == 1){
					$v_pajak = 'Include';
					$t_pajak = 1;
				}
				
				$v_status = '<span class="label label-default">NonAktif</span>';
				if($tag_pelanggan->status == 1){
					$v_status = '<span class="label label-success">Aktif</span>';
				}
				
				$v_tagihan_bulan_ini = '';
				$hitung_fee = 0;
				$harga_fee = 0;
				$harga_ppn = 0;
				
				$vv_pokok = 0;
				$vv_pajak = 0;
				
					$tagihan_bulan_ini = $this->db->query("select * from tag_tagihan 
													where id_pelanggan = $id_pelanggan and 
													month(tanggal) 	= $bulan_ini and 
													year(tanggal)	= $tahun_ini ");
					if($tagihan_bulan_ini->num_rows() >0){
						$b_ini = $tagihan_bulan_ini->row();
						if($level == 2){
							$v_tagihan_bulan_ini = '<a href="'.$base.'/tag_pelanggan/cetak_faktur/'.$b_ini->id_tagihan.'">Cetak '.$b_ini->no_transaksi.'</a>';
							
						}
						$vv_pokok = $b_ini->pokok;
						$vv_pajak = $b_ini->pajak;
					}
				$no++;
				
				if($tag_pelanggan->prosen > 0){
					$prosen_fee = $tag_pelanggan->prosen;
					$harga_fee = $vv_pokok ;
					$hitung_fee = ($prosen_fee/100) * $harga_fee;
					$harga_ppn = $vv_pajak;
				}
				
				$total_layanan += $harga_fee;
				$total_fee += $hitung_fee;
				$total_ppn += $harga_ppn;
			
                ?>
                <tr>
					<td width="80px"><?php echo $no; ?></td>
					<td><?php echo $tag_pelanggan->kode; ?></td>
					<td><?php echo $tag_pelanggan->nama; ?></td>
					<td><?php echo $tag_pelanggan->alamat; ?></td>
					<td><?php echo $tag_pelanggan->telp; ?></td>
					<td><?php echo $tag_pelanggan->nama_layanan; ?></td>
					<td style="text-align:right;"><?php echo $this->umum->format_rupiah($harga_fee); ?></td>
					<td style="text-align:right;"><?php echo $this->umum->format_rupiah($harga_ppn); ?></td>
					<td style="text-align:right;"><?php echo $this->umum->format_rupiah($hitung_fee); ?></td>
					<td><?php echo $nama_patner; ?></td>
					<td><?php echo $v_pajak; ?></td>
					<td><?php echo $this->umum->dari_lengkap_ke_garis($tag_pelanggan->tanggal_pasang); ?></td>
					<td><?php echo $v_status; ?></td>
					<td><?php echo $v_tagihan_bulan_ini; ?></td>
					<td>
					<?php 
						$cek_box = '<input type="checkbox" id="id_pelanggan-'.$no.'" name="tagihan_in_'.$tag_pelanggan->id_pelanggan.'" value="1">';
						echo $cek_box;
						
					?>
					</td>
					<td style="text-align:center" width="200px">
						<?php 
						echo anchor(site_url('tag_pelanggan/read/'.$tag_pelanggan->id_pelanggan),'Read',array('class' => 'btn btn-success btn-xs'));
						echo '&nbsp;';
						echo anchor(site_url('tag_pelanggan/update/'.$tag_pelanggan->id_pelanggan),'Update',array('class' => 'btn btn-warning btn-xs')); 
						?>
						
						<?php
							if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete'))
							{
						?>
								<a href="<?php echo site_url('tag_pelanggan/delete/'.$tag_pelanggan->id_pelanggan); ?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-danger btn-xs">Delete</a>
								
								
						<?php 
							}
						?>
						
						<?php
							if($this->session->userdata('DX_role_id') == 2)
							{
						?>
								<a href="<?php echo site_url('tag_pelanggan/detail_faktur/'.$tag_pelanggan->id_pelanggan); ?>" class="btn btn-primary btn-xs">Histori Faktur</a>
						<?php
							}
						?>
					</td>
				</tr>
                <?php
            }
            ?>
			
			<tr>
				<td colspan="6" style="text-align:right;" >
				<td style="text-align:right;" ><?php echo $this->umum->format_rupiah($total_layanan); ?></td>	
				<td style="text-align:right;" ><?php echo $this->umum->format_rupiah($total_ppn); ?></td>	
				<td style="text-align:right;" ><?php echo $this->umum->format_rupiah($total_fee); ?></td>	
				<td colspan="7" style="text-align:right;" >
			</tr>
			<tr>
				<td colspan="14" style="text-align:right;" >
					<label class="checkbox">
						<input type="radio" name="pilih" onClick='for (i=<?php echo $no_awal; ?>;i<=<?php echo $no; ?>;i++){document.getElementById("id_pelanggan-"+i).checked=true;}' > Cek All
					</label>&nbsp;&nbsp;&nbsp;
					<label class="checkbox">
						<input type="radio" name="pilih" onClick='for (i=<?php echo $no_awal; ?>;i<=<?php echo $no; ?>;i++){document.getElementById("id_pelanggan-"+i).checked=false;}' > Uncek All
					</label>
				</td>
				<td colspan="2">
					<input type="submit" class='btn btn-danger' value="Print All">
				</td>
			</tr>
        </table>
		<?php	echo form_close(); ?>
		
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo isset($paginator)?$paginator:''; ?>
            </div>
        </div>
		
		<br/><br/><br/>
    </div>
	