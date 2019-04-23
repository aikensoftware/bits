<?php

    include "func_transfer.php";
	
		$private_key2 ='ksuebn239jado0302';

		$hasil = trf_get_request($private_key2);
		
		if($hasil===false){
				trf_give_response(false);
		}	else {
			
			define( 'BASEPATH', true );
      include "../application/config/database.php";
      include "database.class.php";
      
      $DB = new Database($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
      
      include "table.m.php";
		
			if ($hasil['action'] == 'peers'){				
						
				if (($hasil['tahun'] > 0) && ($hasil['bulan'] > 0)){		
				                  
          $nip_atasan = table_query('SELECT nip_atasan FROM lkh WHERE nip = "' . $hasil['nip'] . '" AND YEAR(tanggal) = ' . (int)$hasil['tahun'] . ' AND MONTH(tanggal) = ' . (int)$hasil['bulan'] . ' LIMIT 0, 1');		
                    
          $data = table_query('SELECT nip FROM lkh WHERE nip_atasan = "' . $nip_atasan[0]['nip_atasan'] . '" AND YEAR(tanggal) = ' . (int)$hasil['tahun'] . ' AND MONTH(tanggal) = ' . (int)$hasil['bulan'] . ' GROUP BY (nip)');		
                  						
				} else {
				
          $nip_atasan = table_query('SELECT nip_atasan FROM t_pegawai_atasan WHERE nip = "' . $hasil['nip'] . '"');		
                    
          $data = table_query('SELECT nip FROM t_pegawai_atasan WHERE nip_atasan = "' . $nip_atasan[0]['nip_atasan'] . '"');		
			
				}
				
						
				if(empty($data) || $data === false){
					$data = "empty";
				}
				trf_give_response($data);
				
			} else {
			
				trf_give_response(false);
				
			}
			
		}
?>