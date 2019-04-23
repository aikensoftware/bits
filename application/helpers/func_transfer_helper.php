<?php 
	// 192.168.6.232

	error_reporting(E_ERROR | E_PARSE);
	
	/*
		fungsi untuk kirim post menggunakan curl
	*/
	function trf_post_curl($url, $param){
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, count($param));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
		curl_setopt($curl, CURLOPT_USERAGENT, $agent);
		curl_setopt($curl, CURLOPT_VERBOSE, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 15);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($curl, CURLOPT_COOKIEFILE, "");
		curl_setopt($curl, CURLOPT_COOKIEJAR, "");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
		$curlData = curl_exec($curl);
		curl_close($curl);

		return $curlData;
	}
	
	/*
		fungsi untuk generate random string
	*/
	function trf_randomString($length=10, $char){
		if(!empty($char)){
			if($char == 'num')
				$charset = "123456789";
			elseif($char == 'alpha')
				$charset = "BCDFGHJKLMNPQRSTVWXYZbcdfghjkmnpqrstvwxyz";
			elseif($char == 'alpha_lower')
				$charset = "bcdfghjkmnpqrstvwxyz";
			elseif($char == 'alpha_upper')
				$charset = "BCDFGHJKLMNPQRSTVWXYZ";
			elseif($char == 'num_alpha_upper')
				$charset = "123456789BCDFGHJKLMNPQRSTVWXYZ";
			elseif($char == 'all')
				$charset = "123456789BCDFGHJKLMNPQRSTVWXYZbcdfghjkmnpqrstvwxyz";
			
			$charactersLength = strlen($charset);
			$trf_randomString = '';
			for ($i = 0; $i < $length; $i++) {
					$trf_randomString .= $charset[rand(0, $charactersLength - 1)];
			}
			return $trf_randomString;
		}
		else {
			return 'Anda belum memilih tipe charset.';
		}
	}

	/*
		fungsi untuk send request
	*/
	function trf_send_request($url, $private_key, $params, $action){ 
		$public_key = trf_randomString($length=32, 'all');
		$param = urlencode(base64_encode(json_encode($params)));
		$hash = md5($action.$param.$private_key.$public_key.date('Y-m-d'));

		$_post_param = array(
			'param' => $param,
			'hash' => $hash,
			'key' => $public_key,
			'action' => $action
		);
		
		$res = trf_post_curl($url, $_post_param);
		
		if(json_decode($res, true) == ""){
			return false;
		}
		else {
			return json_decode($res, true);
		}
	}

	/*
		fungsi untuk get request
	*/
	function trf_get_request($private_key){
		$hash = md5($_POST[action].$_POST[param].$private_key.$_POST[key].date('Y-m-d'));
		if($hash == $_POST[hash]){
			$param = json_decode(base64_decode(urldecode($_POST[param])), true);
			return $param;
		}
		else {
			return false;
		}
	}

	/*
		fungsi untuk cek request
	*/
	function trf_give_response($content){
		if($content === false){
			echo json_encode(array('result'=>'ERROR'));
		}
		else {
			echo json_encode($content);
		}
	}
