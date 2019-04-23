<div class="col-md-12 col-sm-12 col-xs-12">
		<?php
		$msg = $this->session->flashdata('admin_login_msg');
		?>
		<?php if(!empty($msg)){ ?>
		<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<?php echo $msg;?>
		</div>
		<?php } ?>
	
        
		<?php
			$ss = $this->session->userdata('ista_logged');
			
			echo  'Selamat Datang '.$ss['ista_adminame'];
			if($ss['ss_idagen'] == 0 && $ss['ss_idpatner'] == 0){
		?>
			<div class="row">
				<div class="col-xs-12 col-lg-12">
					<div class="x_panel">
						<div class="x_title text-center">
							<h3>Total Partner Per Cabang</h3>
						</div>
						<div class="x_content">
							<table class="table">
								<tr>
									<th>No</th>
									<th>Nama Cabang</th>
									<th style="text-align:right;">Total Partner</th>
									<th style="text-align:right;">Total Pelanggan Aktif</th>
									<th style="text-align:right;">Total Pelanggan Non Aktif</th>
								</tr>
							<?php

								$no = 1;
								$rs = $this->db->query("
													SELECT a.nama_admin,a.id_agen , COUNT(b.id_patner) as total_patner 
													FROM tag_admin as a 
													left join tag_patner as b on a.id_agen = b.id_agen 
													where a.id_patner = 0 and a.id_agen > 0 
													group by a.id_agen 
													ORDER BY nama_admin asc
													");
								$sum_patner 	= 0;
								$sum_pel_aktif 	= 0;
								$sum_pel_non 	= 0;
								if($rs->num_rows() >0 ){
									foreach($rs->result() as $b){
										
										$this->db->where("status", 1);
										$this->db->where("id_agen", $b->id_agen);
										$jml_aktif = $this->db->get("pelanggan")->num_rows();
										
										$this->db->where("status", 2);
										$this->db->where("id_agen", $b->id_agen);
										$jml_non = $this->db->get("pelanggan")->num_rows();
										
										$sum_patner 	+= $b->total_patner;
										$sum_pel_aktif 	+= $jml_aktif;
										$sum_pel_non 	+= $jml_non;
										
									?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $b->nama_admin; ?></td>
											<td style="text-align:right;"><?php echo $this->umum->format_rupiah($b->total_patner); ?></td>
											<td style="text-align:right;"><?php echo $this->umum->format_rupiah($jml_aktif); ?></td>
											<td style="text-align:right;"><?php echo $this->umum->format_rupiah($jml_non); ?></td>
										</tr>	
									<?php
									$no++;
									}
								}
							?>
							
								<tr>
									
									<th colspan="2">Total Keseluruhan</th>
									<th style="text-align:right;"><?php echo $this->umum->format_rupiah($sum_patner); ?></th>
									<th style="text-align:right;"><?php echo $this->umum->format_rupiah($sum_pel_aktif); ?></th>
									<th style="text-align:right;"><?php echo $this->umum->format_rupiah($sum_pel_non); ?></th>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			
		<?php
			}
		?>
</div>



