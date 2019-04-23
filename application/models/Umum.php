<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Umum extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		// Other stuff
		$this->_prefix = $this->config->item('DX_table_prefix');
		$this->_table = $this->_prefix.$this->config->item('DX_roles_table');
	}
	
	public function ubah_ke_garis($date)
	{
		// dari 2017-12-32
		// ke 24/07/2015
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'/'.$exp[1].'/'.$exp[0];
		}
		return $date;
	}
	
	function kekata($x) {
		$x = abs($x);
		$angka = array("", "satu", "dua", "tiga", "empat", "lima",
		"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($x <12) {
			$temp = " ". $angka[$x];
		} else if ($x <20) {
			$temp = $this->kekata($x - 10). " belas";
		} else if ($x <100) {
			$temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
		} else if ($x <200) {
			$temp = " seratus" . $this->kekata($x - 100);
		} else if ($x <1000) {
			$temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
		} else if ($x <2000) {
			$temp = " seribu" . $this->kekata($x - 1000);
		} else if ($x <1000000) {
			$temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
		} else if ($x <1000000000) {
			$temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
		} else if ($x <1000000000000) {
			$temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
			$temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
		}     
			return $temp;
	}

	/*
		# cara menggunaka fungsi terbilang
		
        $nilai = 1250;
        
				echo $this->umum->terbilang($nilai, $style=1); echo '<br/>';
		//        SERIBU DUA RATUS LIMA PULUH
				
				echo $this->umum->terbilang($nilai, $style=2); echo '<br/>';
		//        seribu dua ratus lima puluh
				
				echo $this->umum->terbilang($nilai, $style=3); echo '<br/>';
		//        Seribu Dua Ratus Lima Puluh
				
				echo $this->umum->terbilang($nilai, $style=4); echo '<br/>';
		//        Seribu dua ratus lima puluh
	*/
	
	
	function terbilang($x, $style=4) {
		if($x<0) {
			$hasil = "minus ". trim($this->kekata($x));
		} else {
			$hasil = trim($this->kekata($x));
		}     
		switch ($style) {
			case 1:
				$hasil = strtoupper($hasil);
				break;
			case 2:
				$hasil = strtolower($hasil);
				break;
			case 3:
				$hasil = ucwords($hasil);
				break;
			default:
				$hasil = ucfirst($hasil);
				break;
		}     
		return $hasil;
	}
	
	function format_rupiah($angka){
		  $rupiah=number_format($angka,0,',','.');
		  return $rupiah;
	}
	
	public function dari_lengkap_ke_garis($date)
	{
		$pecah = explode(' ',$date);
		
		$exp = explode('-',$pecah[0]);
		if(count($exp) == 3) {
			$bln = $exp[1];
			if($bln == 1){ $bln ='Jan'; }
			elseif($bln == 2) { $bln ='Feb';}
			elseif($bln == 3) { $bln ='Mar';}
			elseif($bln == 4) { $bln ='Apr';}
			elseif($bln == 5) { $bln ='Mei';}
			elseif($bln == 6) { $bln ='Jun';}
			elseif($bln == 7) { $bln ='Jul';}
			elseif($bln == 8) { $bln ='Agu';}
			elseif($bln == 9) { $bln ='Sep';}
			elseif($bln == 10) { $bln ='Okt';}
			elseif($bln == 11) { $bln ='Nop';}
			elseif($bln == 12) { $bln ='Des';}
			
			$date = $exp[2].'/'.$exp[1].'/'.$exp[0];
		}
		return $date;
	}
	
	public function dari_lengkap($date)
	{
		$pecah = explode(' ',$date);
		
		$exp = explode('-',$pecah[0]);
		if(count($exp) == 3) {
			$bln = $exp[1];
			if($bln == 1){ $bln ='Jan'; }
			elseif($bln == 2) { $bln ='Feb';}
			elseif($bln == 3) { $bln ='Mar';}
			elseif($bln == 4) { $bln ='Apr';}
			elseif($bln == 5) { $bln ='Mei';}
			elseif($bln == 6) { $bln ='Jun';}
			elseif($bln == 7) { $bln ='Jul';}
			elseif($bln == 8) { $bln ='Agu';}
			elseif($bln == 9) { $bln ='Sep';}
			elseif($bln == 10) { $bln ='Okt';}
			elseif($bln == 11) { $bln ='Nop';}
			elseif($bln == 12) { $bln ='Des';}
			
			$date = $exp[2].'-'.$bln.'-'.$exp[0];
		}
		return $date;
	}
	
	function nama_bulan_pdk($nilai)
	{
		$bln = $nilai;
		if($bln == 1){ $bln ='Jan'; }
		elseif($bln == 2) { $bln ='Feb';}
		elseif($bln == 3) { $bln ='Mar';}
		elseif($bln == 4) { $bln ='Apr';}
		elseif($bln == 5) { $bln ='Mei';}
		elseif($bln == 6) { $bln ='Jun';}
		elseif($bln == 7) { $bln ='Jul';}
		elseif($bln == 8) { $bln ='Agu';}
		elseif($bln == 9) { $bln ='Sep';}
		elseif($bln == 10) { $bln ='Okt';}
		elseif($bln == 11) { $bln ='Nop';}
		elseif($bln == 12) { $bln ='Des';}
		
		return $bln;
	}
	
	function nama_bulan($nilai)
	{
		$bln = $nilai;
		if($bln == 1){ $bln ='Januari'; }
		elseif($bln == 2) { $bln ='Februari';}
		elseif($bln == 3) { $bln ='Maret';}
		elseif($bln == 4) { $bln ='April';}
		elseif($bln == 5) { $bln ='Mei';}
		elseif($bln == 6) { $bln ='Juni';}
		elseif($bln == 7) { $bln ='Juli';}
		elseif($bln == 8) { $bln ='Agustus';}
		elseif($bln == 9) { $bln ='September';}
		elseif($bln == 10) { $bln ='Oktober';}
		elseif($bln == 11) { $bln ='Nopember';}
		elseif($bln == 12) { $bln ='Desember';}
		
		return $bln;
	}
	
	public function dropdown($name,$table,$field,$pk,$class,$kondisi=null,$selected=null,$data=null,$tags=null)
	{
		$CI =& get_instance();
	   echo"<select name='".$name."' class='$class' $tags>";
			if($data!='')
			{
				foreach ($data as $data_value => $id)
				{
					echo "<option value='$id'>$data_value</option>";
				}
			}
			if(empty($kondisi))
			{
				$CI->db->order_by($field,'ASC');
				$record=$CI->db->get($table)->result();
			}
			else
			{
				$CI->db->order_by($field,'ASC');
				$record=$CI->db->get_where($table,$kondisi)->result();
			}
			foreach ($record as $r)
			{
				echo " <option value='".$r->$pk."' ";
				echo $r->$pk==$selected?'selected':'';
				echo ">".strtoupper($r->$field)."</option>";
			}
				echo"</select>";
	}

	public function generate_menu($parent=0,$level=1,$hasil,$cls,$aktif)
	{
	
		$where['id_parent']=$parent;
		$where['level']=$level;
		$this->db->order_by('urutan');
		$w = $this->db->get_where("tbl_menu",$where);
		if(($w->num_rows())>0)
		{
			$hasil .= "<ul class='".$cls."'>";
		}
		foreach($w->result() as $h)
		{
			$i= $h->tingkat;
					
			if($i==1){
				$sub_sub_menu = 'dropdown dropdown-submenu';
				$caret = '';
			}else{
				$sub_sub_menu = 'dropdown';
				$caret = "<span class='caret'></span>";
			}
			
			$where_sub['id_parent']= $h->id;
			$this->db->order_by('urutan');
			$w_sub = $this->db->get_where("tbl_menu",$where_sub);
			if(($w_sub->num_rows())>0)
			{
			
				$hasil .= "<li class='".$sub_sub_menu."'><a class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false' href='".base_url()."".$h->url."'>".$h->icon." ".$h->title." ".$caret."</a>";
			}
			else
			{
				$hasil .= "<li><a href='".base_url()."".$h->url."'> ".$h->icon." ".$h->title." </a>";
			}
				
			$hasil = $this->umum->generate_menu($h->id,$level,$hasil,'dropdown-menu',$aktif);
			$hasil .= "</li>";
		}
		if(($w->num_rows)>0)
		{
			$hasil .= "</ul>";
		}
		return $hasil;
	}
	
	
	public function acak($panjang) 
	{ 
		$karakter= 'ABCD1234567890abcdef*@!'; 
		$string = ''; 
		for ($i = 0; $i < $panjang; $i++) 
		{ 
			$pos = rand(0, strlen($karakter)-1); 
			$string .= $karakter{$pos}; 
		} 
		return $string; 
	} 
	
	public function acak_baru($panjang) 
	{ 
		$karakter= 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789abcdefghijklmnpqrstuvwxyz'; 
		$string = ''; 
		for ($i = 0; $i < $panjang; $i++) 
		{ 
			$pos = rand(0, strlen($karakter)-1); 
			$string .= $karakter{$pos}; 
		} 
		return $string; 
	} 
	
	
	public function acak_qrcode($panjang) 
	{ 
		
		$validasi = '';
		for($i=1; $i<= 3 ; $i++ )
		{
			$acak = $this->acak_baru($panjang);	
			$cek_sn = $this->db->query("select * from tag_validasi where kode_validasi = '$acak' ");
			if($cek_sn->num_rows > 0){
				$i = $i-1;
			}else{
				$i = 3;
				$validasi = $acak;
				$data = array(
								
								'tanggal'			=> date('Y-m-d H:i:s', time()),
								'kode_validasi'		=> $validasi,
								
							);
				$this->db->insert('tag_validasi', $data);
			}
		
		}
		
		return $validasi;
	} 
	
	function get_all()
	{
		$this->db->order_by('id', 'asc');
		return $this->db->get($this->_table);
	}
	
	function get_role_by_id($role_id)
	{
		$this->db->where('id', $role_id);
		return $this->db->get($this->_table);
	}
	
	function create_role($name, $parent_id = 0)
	{
		$data = array(
			'name' => $name,
			'parent_id' => $parent_id
		);
            
		$this->db->insert($this->_table, $data);
	}
	
	function delete_role($role_id)
	{
		$this->db->where('id', $role_id);
		$this->db->delete($this->_table);		
	}
}