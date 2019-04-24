<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIM-BITSNET</title>
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/images/gambar.png')?>">
	<!-- Bootstrap -->
  
    <link href="{url}assets/template/default/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{url}assets/template/default/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{url}assets/template/default/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Datatables -->
    <link href="{url}assets/template/default/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{url}assets/template/default/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="{url}assets/template/default/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="{url}assets/template/default/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="{url}assets/template/default/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="{url}assets/css/dropzone.min.css" rel="stylesheet">
    <!-- CK Editor -->
    <!-- <script src="{url}assets/template/plugins/cekeditor/ckeditor.js"></script> -->
    <!-- Dropzone -->
    <!-- <script src="{url}assets/template/default/vendors/dropzone/dist/dropzone.js"></script>   -->



    <!-- Custom Theme Style -->
    <link href="{url}assets/template/default/build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{url}assets/template/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="{url}assets/template/plugins/cekeditor/skins/moono/editor.css" type="text/css">
  </head>

  <body class="nav-md" id="{bid}">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
				<a class="site_title"><img src="{url}assets/images/logo.png" style="width:120px; height:60px;" />
					<span style="position:relative; top:-6px; margin-left:6px;">
					<h6 style="position:relative; top:-27px; left:47px;"></h6></span> 
				</a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_info">
                    
                    <h2>{names}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            {_sidebarMenu_}
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            {_menuFooter_}
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        {_topNavigation_}
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
			{_templateView_}
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
			<div>
				<div style="float:left; padding-right:2px;">
					Sistem Informasi Bitsnet &copy; 2018. Version 1.0.0 | 
				</div>
				<div style="float:right;">
					Rendered in <strong>{elapsed_time}</strong> seconds.
				</div>
			</div>
          </div>
          <!--<div class="clearfix"></div>-->
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
	<!--<script src="{url}assets/scripts/jquery-1.7.1.min.js"></script>-->
	<script src="{url}assets/template/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="{url}assets/template/default/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{url}assets/template/default/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="{url}assets/template/default/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- DateJS -->
    <script src="{url}assets/template/default/vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{url}assets/template/plugins/datepicker/bootstrap-datepicker.js"></script>

    <script src="{url}assets/template/default/vendors/moment/min/moment.min.js"></script>
    <script src="{url}assets/template/default/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Datatables -->
    <script src="{url}assets/template/default/vendors/datatables.net/js/jquery.dataTables.js"></script>
    <script src="{url}assets/template/default/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="{url}assets/template/default/build/js/custom.min.js"></script>

	<script type="text/javascript">
		$(function(){

            $('#chkAll').change(function()
            {
                var status = this.checked;
                $('.chk').each(function(){
                    this.checked = status;
                });
            });

            $('#tgl_lahir').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });
            $('#tanggal').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });
            $('#tgl_buat').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });
            $('.selectpicker').selectpicker();
		});

        <?php
        if(isset($extra_script)){
            echo $extra_script;
        }
        ?>
	</script>
  </body>
</html>
