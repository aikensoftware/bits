<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
* Barcode Generator menggunakan Zend Framework library
*
* Ini adalah contoh membuat barcode di CI
* by Dimas Edubuntu Samid
* edudimas1@gmail.com | 0856-8400-407
*
**/
 
class Itemku extends CI_Controller
{
 
function __construct()
{
parent::__construct();
}
 
function index()
{
	$data['kode']='3519043107870002';
	$this->load->view('contoh_label',$data);
	//$this->bikin_barcode('3519043107870002');
	//$this->createLabel('sdfd');
}
 
function bikin_barcode($kode)
{
$this->load->library('zend');
$this->zend->load('Zend/Barcode');
 
Zend_Barcode::render('code128', 'image', array('text'=>$kode,'backgroundcolor'=>'#000000','forecolor'=>'#FFFFFF','barheight'=>20,'verticalPosition'=>'middle'), array());
}

	public function barcode($id=1)
	{
		$ss = $this->session->userdata('ista_logged');

		if(isset($ss['ista_adminid'])):

			$datax = array('url' => base_url(),
						   'title' => 'Ubah Profil',
						   '_templateView_' => $this->barcode_model->show_barcode('3519043107870002',$id),
						   '_sidebarMenu_' => $this->general_model->sidebarMenu(),
						   '_topNavigation_' => $this->general_model->topNavigation(),
						   '_menuFooter_' => $this->general_model->menuFooter(),
						   '_dashboard_' => $this->general_model->display_dashboard(),
						   'judul' => 'Edit Profil',
						   'names' => ucwords($ss['ista_adminame']),
						   'uname' => ucwords($ss['ista_adminuname'])
					 );
			
			$this->parser->parse('template', $datax);

		else:
			redirect('login', 'refresh');
		endif;
	}

//end of class
}