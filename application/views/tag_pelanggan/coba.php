<?php
			
			$this->load->library('ciqrcode');

			header("Content-Type: image/png");
			$params['data'] = 'This is a text to encode become QR Code';
			$this->ciqrcode->generate($params);
			
			
		?>