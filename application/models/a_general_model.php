<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model {

	public function __construct()
	{
		//parent:__construct();
	}
	
	public function sidebarMenu()
	{
		$ss = $this->session->userdata('ista_logged');
		$menu = '<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3 style="background: #172d44; font-size:20px; color:#f7f7f7; padding:5px 5px; text-align:center;">MENU UTAMA</h3>
                <ul class="nav side-menu">
                	<li id="dashboard"><a href="'.site_url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li id="baligh"><a href="'.site_url('pelanggan').'"><i class="fa fa-file-text-o"></i> Data Pelanggan</a></li>                	
					<li id="baligh"><a href="'.site_url('agen').'"><i class="fa fa-file-text-o"></i> Data Patner</a></li>                	

					<li>
                		<a><i class="fa fa-file-text-o"></i> Master Data <span class="fa fa-chevron-down"></span></a>
		                <ul class="nav child_menu">
		                	<li> <a href="'.site_url('layanan').'">Layanan</a></li>
							
		                </ul>
		            </li>
					
                </ul>
              </div>
            </div>';
			
		return $menu;
	}
	
	public function topNavigation()
	{
		$menu = '<div class="top_nav hidden-print">
			  <div class="nav_menu">
				<nav>
				  <div style="width:100%; float:left; margin:0; padding-left:12px; background:#f7c300;">
					</div>
				  <div class="nav toggle">
					<a id="menu_toggle" class="col-sm-1" style="color:#0d2d6c;"><i class="fa fa-bars"></i></a>
				  </div>

				  <ul class="nav navbar-nav navbar-right">

 					<li class="dropdown">
		                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> Profile <span class="caret"></span></a>
		                <ul class="dropdown-menu">
		   					<li>
							  <a href="'.site_url("dashboard/edit_password").'" class="user-profile">
								<i class="glyphicon glyphicon-edit"></i> Ganti Password
							  </a>
							</li>
		   					<li>
							  <a href="'.site_url("login/logout").'" class="user-profile">
								<i class="glyphicon glyphicon-off"></i> Keluar
							  </a>
							</li>

		                </ul>
		            </li>					
				  </ul>

				</nav>
			  </div>
			</div>';
		
		return $menu;
	}

	public function display_dashboard()
	{
		$ss = $this->session->userdata('ista_logged');

		$tgl_masuk =  date("d/m/Y",strtotime($rs['tgl_masuk']));

		if(empty($rs['foto_siswa'])):
			$picture = base_url()."assets/images/no_picture.png";
		else:
			$picture = base_url()."assets/profile/".$ss['ista_adminfoto'];
		endif;

		$dsb = '<form method="post" action="'.site_url("dashboard/save_profile").'" enctype="multipart/form-data">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<table class="table table-condensed">
						<tr>
							<td rowspan="10" width="15%" align="center">
								<img src="'.$picture.'" width="150" height="170" />
								<hr>
								<button type="submit" name="kirim" class="btn btn-primary">Update Profil</button>
							</td>
						</tr>
						<tr>
							<td width="20%" bgcolor="#eeeeee"><strong>Username</strong></td>
							<td><input type="text" name="nim" class="form-control" value="'.$ss['ista_adminuname'].'" readonly /></td>
						</tr>
						<tr>
							<td bgcolor="#eeeeee"><strong>Nama</strong></td>
							<td><input type="text" name="nama" class="form-control" value="'.$ss['ista_adminame'].'" placeholder="Nama..." /></td>
						</tr>
						<tr>
							<td bgcolor="#eeeeee"><strong>Email</strong></td>
							<td><input type="email" name="email" class="form-control" value="'.$ss['ista_adminemail'].'" placeholder="Alamat Email..." /></td>
						</tr>
						<tr>
							<td bgcolor="#eeeeee"><strong>Password Baru</strong></td>
							<td><input type="password" name="password" class="form-control" placeholder="Password..."></td>
						</tr>
					</table>
				</div>
				</form>';

		return $dsb;
	}

	public function display_edit_password()
	{
		$ss = $this->session->userdata('ista_logged');
		
		$dsp = '<form method="post" action="'.site_url("dashboard/save_password").'">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
                           	<h3>
                               	<strong><i class="fa fa-pencil"></i> UBAH PASSWORD</strong>
                            </h3>
                        </div>
                        <div class="x_content">
                        	<div class="row">
                            	<div class="card-box table-responsive">
									<table class="table table-condensed">
										<tr>
											<td>Password Lama</td>
											<td>:</td>
											<td><input type="password" name="old_pass" class="form-control" required="true" placeholder="password lama..."></td>
										</tr>
										<tr>
											<td>Password Baru</td>
											<td>:</td>
										
											<td><input type="password" name="new_pass" id="new_pass" class="form-control" required="true" placeholder="password baru..."></td>
										</tr>
										<tr>
											<td>Ulangi Password Baru</td>
											<td>:</td>
										
											<td><input type="password" name="new_pass1" id="new_pass1" class="form-control" required="true" placeholder="Ulangi password baru..."></td>
										</tr>

										<tr>
											<td colspan="2"></td>
											<td>
												<button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
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

	function login_cek_admin($uid, $password)
	{
		$pass = md5($password);

		$this->db->select('*');

		if(preg_match ('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $uid))
		{
			$this->db->where('email', $uid);
		} else {
			$this->db->where('username', $uid);
		}

		$this->db->where('password', $pass);
		
		$qry = $this->db->get('admin');

		if($qry->num_rows() == 1){
			return $qry->result();
		} else {
			return false;
		}
	}
	
	public function jquery_mobile()
	{
		$jQ = '$("#example_").dataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
					"scrollX": true,
					"scrollCollapse": true,
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": false
                });';
		
		return $jQ;
	}

	public function menuFooter()
	{
		$menu = '<div class="sidebar-footer hidden-small">
              &nbsp;
            </div>';
		
		return $menu;
	}

}

?>