
<style type="text/css">
td {
  border-collapse: collapse;
  border: 0px black solid;
}
tr:nth-of-type(5) td:nth-of-type(1) {
  visibility: hidden;
}

.rotate {
	/* FF3.5+ */
	-moz-transform: rotate(-90.0deg);
	/* Opera 10.5 */
	-o-transform: rotate(-90.0deg);
	/* Saf3.1+, Chrome */
	-webkit-transform: rotate(-90.0deg);
	/* IE6,IE7 */
	filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
	/* IE8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
	/* Standard */
	transform: rotate(-90.0deg);
}
</style>
<table border="1">
<tr>
	<td class="rotate">
		<small>Toko Mulyani</small>
	</td>
	<td>
		
	Celana Rok Metalica <br >

	<img src="<?php echo site_url();?>/itemku/bikin_barcode/<?php echo $kode;?>"><br>
	B00023<br>
	Rp. 450.000,-
</td>
</tr>
</table>