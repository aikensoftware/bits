<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
  
class Export extends CI_Controller {
 
  /**
   * @desc : load list modal and helpers
   */
      function __Construct(){
        parent::__Construct();
        $this->load->model('general_model'); 
        $this->load->helper(array('form', 'url'));
        $this->load->helper('download');
        $this->load->library('PHPReport');
             
        }
 
  /**
   *  @desc : This function is used to get data from database 
   *  And export data into excel sheet
   *  @param : void
   *  @return : void
   */
    public function index(){
      // get data from databse
    $post = $this->input->post();
    
    //$data = $this->general_model->get_report($post['fakultas'], $post['prodi'],  $post['orderby']);
    $data = $this->general_model->get_data4export($post['fakultas'], $post['prodi'],  $post['orderby']);
//    if ($post['format']=='pdf'){

/*        $this->load->library('pdfgenerator');
        $dsp=$this->general_model->display_penilaian();
        $html = $this->load->view('tempdf', $dsp, true);
        $filename = 'report_'.time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
*/
  
//  }else{
      $template = 'peserta.xlsx';
      $templateDir = __DIR__ . "/";
 
      $config = array(
        'template' => $template,
        'templateDir' => $templateDir
        
      );
 
 
      //load template
      $R = new PHPReport($config);
 
      $R->load(array(
              'id' => 'ws',
              'repeat' => TRUE,
              'data' => $data  
          )
      );
       
      // define output directoy 
      $output_file_dir = "/";
        
      $output_file_excel = $output_file_dir  . "Laporan.xlsx";
      //download excel sheet with data in /tmp folder
      
      $result = $R->render('excel', $output_file_excel);
      
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header("Content-Disposition: attachment; filename=".$output_file_excel);
      header('Expires: 0');
      header('Pragma: no-cache');     
      readfile($output_file_excel);

  //  }
  }

}