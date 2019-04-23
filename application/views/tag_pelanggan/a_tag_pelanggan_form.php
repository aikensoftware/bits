
	<?php
		$action=site_url("pelanggan/save");
	?>
        <h3 class="page-header"  style="margin-top:0px">Tag_pelanggan <?php echo $button ?></h3>
        <form action="<?php echo $action; ?>" method="post"><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
	    <div class="form-group">
            <label for="varchar">Kode <?php echo form_error('kode') ?></label>
            <input type="text" class="form-control" name="kode" id="kode" placeholder="Kode" value="<?php echo $kode; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Telp <?php echo form_error('telp') ?></label>
            <input type="text" class="form-control" name="telp" id="telp" placeholder="Telp" value="<?php echo $telp; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Layanan <?php echo form_error('id_layanan') ?></label>
            <!--<input type="text" class="form-control" name="id_layanan" id="id_layanan" placeholder="Id Layanan" value="<?php echo $id_layanan; ?>" />-->
			<?php
				$id_layanan = isset($id_layanan)?$id_layanan:1;
				$options= array();
				$dt_layanan = $this->db->query("select * from tag_layanan order by urutan asc ");
				if(isset($dt_layanan)){
					if($dt_layanan->num_rows()>0){
						foreach($dt_layanan->result() as $s){
							$options[$s->id_layanan] = $s->nama.' Harga '.$this->umum->format_rupiah($s->harga).' / Bulan';
						}
					}
				}
				echo form_dropdown('id_layanan', $options, $id_layanan ,'class="form-control"');
			?>
        </div>
	    <div class="form-group">
            <label for="int">Id Patner <?php echo form_error('id_patner') ?></label>
            <!--<input type="text" class="form-control" name="id_patner" id="id_patner" placeholder="Id Patner" value="<?php echo $id_patner; ?>" />-->
			<?php
				
				# pengecualinan
				$batas = '';
				$ss = $this->session->userdata('ista_logged');
				$id_patner=$ss['ss_idpatner'];
				// $level = $this->session->userdata('DX_role_id');
				// if($level <> 2){
				// 	$id_patner = $this->session->userdata('DX_id_patner');
					$batas = " and id_patner = $id_patner";
				// }else{
				// 	$id_patner = isset($id_patner)?$id_patner:'';
				// }
				
				$options= array();
				$dt_patner = $this->db->query("select * from tag_patner where id_patner > 0 $batas order by nama asc ");
				if(isset($dt_patner)){
					if($dt_patner->num_rows()>0){
						foreach($dt_patner->result() as $s){
							$options[$s->id_patner] = $s->nama.' alamat : '.$s->alamat;
						}
					}
				}
				echo form_dropdown('id_patner', $options, $id_patner ,'class="form-control"');
			?>
        </div>
	    <div class="form-group">
            <label for="int">In Pajak <?php echo form_error('in_pajak') ?></label>
            <!--<input type="text" class="form-control" name="in_pajak" id="in_pajak" placeholder="In Pajak" value="<?php echo $in_pajak; ?>" />-->
			<?php
				$in_pajak = isset($in_pajak)?$in_pajak : 2;
				$options= array();
				$options[1] = 'Include Pajak'; 
				$options[2] = 'Exclude Pajak'; 
				
				echo form_dropdown('in_pajak', $options, $in_pajak,'class="form-control"' ); 
			?>
        </div>
	    <div class="form-group">
            <label for="datetime">Tanggal Pasang <?php echo form_error('tanggal_pasang') ?></label>
            <!--<input type="text" class="form-control" name="tanggal_pasang" id="tanggal_pasang" placeholder="Tanggal Pasang" value="<?php echo $tanggal_pasang; ?>" />-->
			<table>
				<tr>
					<td>
						<?php
						
							$options= array();
							
							$tanggal_masuk = isset($tanggal_masuk)?$tanggal_masuk: date('d') ;
							for ($x = 1; $x < 32; $x++) {
								$options[$x] = $x;
							} 
							echo form_dropdown('tanggal_masuk', $options, $tanggal_masuk,'class="form-control"'); 
						?>
					</td>
					<td>
						<?php
							$options= array();
							
							$bulan_masuk = isset($bulan_masuk)?$bulan_masuk: date('m') ;
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
							echo form_dropdown('bulan_masuk', $options, $bulan_masuk,'class="form-control"'); 
						?>
					</td>
					<td>
						<?php
							$options= array();
							
							$tahun_masuk = isset($tahun_masuk)?$tahun_masuk: date('Y') ;
							for ($x = 1988; $x < date('Y')+1; $x++) {
								$options[$x] = $x;
							} 
							echo form_dropdown('tahun_masuk', $options, $tahun_masuk,'class="form-control"'); 
						?>
					</td>
					
				</tr>
			</table>
        </div>
	    <div class="form-group">
            <label for="int">Status <?php echo form_error('status') ?></label>
            <!--<input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />-->
			<?php
				$status = isset($status)?$status : 2;
				$options= array();
				$options[1] = 'Aktif'; 
				$options[2] = 'Non Aktif'; 
				
				echo form_dropdown('status', $options, $status,'class="form-control"' ); 
			?>
        </div>
	    <input type="hidden" name="id_pelanggan" value="<?php echo $id_pelanggan; ?>" /> 
	    <button type="submit" class="btn btn-primary">SIMPAN</button> 
	    <a href="<?php echo site_url('tag_pelanggan') ?>" class="btn btn-default">Cancel</a>
	</form>

	