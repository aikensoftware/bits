<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Tag_pelanggan List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Kode</th>
		<th>Nama</th>
		<th>Alamat</th>
		<th>Telp</th>
		<th>Id Layanan</th>
		<th>Id Patner</th>
		<th>In Pajak</th>
		<th>Tanggal Pasang</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($tag_pelanggan_data as $tag_pelanggan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tag_pelanggan->kode ?></td>
		      <td><?php echo $tag_pelanggan->nama ?></td>
		      <td><?php echo $tag_pelanggan->alamat ?></td>
		      <td><?php echo $tag_pelanggan->telp ?></td>
		      <td><?php echo $tag_pelanggan->id_layanan ?></td>
		      <td><?php echo $tag_pelanggan->id_patner ?></td>
		      <td><?php echo $tag_pelanggan->in_pajak ?></td>
		      <td><?php echo $tag_pelanggan->tanggal_pasang ?></td>
		      <td><?php echo $tag_pelanggan->status ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>