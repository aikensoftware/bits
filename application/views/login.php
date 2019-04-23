<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIM-BITZNET | LOGIN </title>

    <!-- Bootstrap -->
    <link href="{url}assets/template/default/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{url}assets/template/default/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{url}assets/template/dist/css/AdminLTE.min.css">

    <!-- Custom Theme Style -->
    <link href="{url}assets/template/default/build/css/custom.min.css" rel="stylesheet">
	
	<script src="{url}assets/template/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="{url}assets/template/bootstrap/js/bootstrap.min.js"></script>
  </head>

  <body class="login">
      <div class="login-box">
		<div class="login-logo">
			
		</div>
        <div class="login-box-body">
          <div class="login-logo" style="margin-bottom:5px;">
            <img src="{url}assets/images/logo.png"  /> 
             
          </div>
          <section class="login_content">
  			<?php
				$msg = $this->session->flashdata('admin_login_msg');
				?>
				<?php if(!empty($msg)): ?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>Maaf</strong> <?php echo $msg;?>
				</div>
			<?php endif; ?>
            <form action="<?=site_url('login/auth') ?>" method="post">
              <h1> <strong>L O G I N</strong> </h1>
              <div class="form-group has-feedback">
                <input type="text" name="id" class="form-control has-feedback" placeholder="username atau email..." required="" />
				<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control has-feedback" placeholder="password..." required="" />
				<span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
              </div>
              <div class="col-sm-12">
					<button type="submit" class="btn btn-primary submit">Masuk <i class="fa fa-sign-in"></i></button>
			  </div>
			  <div class="col-sm-12">
				<!--<div class="col-sm-6">
					<a href="">Daftar Baru</a>
				</div>
				<div class="col-sm-6">
					<a href="#" style="margin:0px;">Lupa Password?</a>
				</div>-->
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  <p><strong>Pengembang <i class="fa fa-copyright"></i> 2018</strong> <br>
					<small><strong><?=DESA?>-<?=KECAMATAN?></strong></small>
				  </p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
  </body>
</html>
