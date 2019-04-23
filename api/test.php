<?php

  include "func_transfer.php"; 

  function get_data_peers($id){ // get data current peers
		$url = "http://kinerja.pu.go.id/lembarkerja/api/index.php";
		$private_key ='ksuebn239jado0302';

		$action = 'peers';	

		$params = array(
			'action' => $action,
			'nip' => $id
		);

		$result = trf_send_request($url, $private_key, $params, $action); 
		
	  return $result; 
	}
	
  function get_data_peers_bydate($id, $tahun=0, $bulan=0){ // get data peers by date
		$url = "http://kinerja.pu.go.id/lembarkerja/api/index.php";
		$private_key ='ksuebn239jado0302';

		$action = 'peers';	

		$params = array(
			'action' => $action,
			'nip' => $id,
			'tahun' => $tahun,
			'bulan' => $bulan
		);

		$result = trf_send_request($url, $private_key, $params, $action); 
		
		return $result; 
	}

  echo "<pre>";
	print_r(get_data_peers('197401151998032001'));
	
	print_r(get_data_peers_bydate('197401151998032001', 2015, 10));
?>