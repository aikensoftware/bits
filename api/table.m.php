<?php


    function table(){
      //
    }

    ///////////
    // table_get
    // Akan mengambil satu atau seluruh isi table berdasarkan filter WHERE
    // INPUT:
    // $table = nama table (string)
    // $where = filter WHERE, kosongkan jika tanpa filter atau array jika ada filter (array)
    // $first = true jika hanya mengambil 1 record saja, false jika semuanya (bool)
    //
    // OUTPUT:
    // array jika berhasil atau false jika gagal atau tidak ada data
    //
    // CONTOH:
    // Ambil seluruh data di table user dengan user_name = 'dodol'
    //  table_get('user', array('user_name'=>'dodol'));
    //
    // Ambil seluruh data di table user dengan user_name = 'dodol' dan kota = 'jakarta'
    //  table_get('user', array('user_name'=>'dodol', 'kota'=>'jakarta'));
    //
    // Ambil data pertama di table user dengan kota = 'jakarta'
    //  table_get('user', array('kota'=>'jakarta'), true);
    //
    function table_get($table, $where='', $first=false){

        global $DB;
        
        if (is_array($where)){
            if ($first){
                $rows = $DB->from($table)->where($where)->fetch_first(); 
            } else {
                $rows = $DB->from($table)->where($where)->fetch(); 
                //$rows = $DB->dryrun()->from($table)->where($where)->fetch(); 
            }
        } else {
            if ($first){
                $rows = $DB->from($table)->fetch_first(); 
            } else {
                $rows = $DB->from($table)->fetch(); 
            }
        }
         
        if($DB->affected_rows > 0){   
          return $rows;
        } else {
          return FALSE;
        }
    }



    ///////////
    // table_new
    // Akan mengisi satu data ke table berdasarkan filter WHERE
    // INPUT:
    // $table = nama table (string)
    // $data = data dalam bentuk associative array (array)
    // $unique = true jika hanya boleh ada 1 record saja (unik), false jika tidak harus unik (bool)
    // $fielddata = nama key di variabel $data yang akan dibandingkan jika unik diset true (string)
    // $field = nama field di tabel yang akan dibandingkan dengan $fielddata jika unik diset true (string)
    //
    // OUTPUT:
    // record id jika berhasil atau false jika gagal 
    //
    // CONTOH:
    // insert data ke tabel user dengan data user_name = 'dodol'
    //  table_new('user', array('user_name'=>'dodol'));
    //
    // insert data ke tabel user dengan data user_name = 'dodol' yang bersifat unik, bandingkan antara user_name di variabel data dengan user_referal di table
    //  table_new('user', array('user_name'=>'dodol'), true, 'user_name', 'user_referal');
    //
    function table_new($table, $data, $unique=false, $fielddata="", $field=""){
      
        global $DB;

        if (($unique) AND ($field <> '')){
      
            $rows = $DB->from($table)->where(array($field=>$data[$fielddata]))->fetch_first(); 
            if ($rows === false){
                return FALSE;
            }
      
        }  
        $id = $DB->insert($table, $data) ;

        return $id;
    }



    ///////////
    // table_update
    // Akan mengupdate satu data di table berdasarkan filter WHERE
    // INPUT:
    // $table = nama table (string)
    // $where = filter WHERE (array)
    // $data = data dalam bentuk associative array (array)
    //
    // OUTPUT:
    // -
    //
    // CONTOH:
    // update data ke tabel user dengan data user_name = 'dodol' untuk user_id = 9
    //  table_update('user', array('user_name'=>'dodol'), array('user_id'=>9));
    //
    function table_update($table, $data, $where=''){

        global $DB;
        
        $DB->where($where)->update($table, $data); 
    }



    ///////////
    // table_delete
    // Akan mendelete satu data di table berdasarkan filter WHERE
    // INPUT:
    // $table = nama table (string)
    // $where = filter WHERE (array)
    //
    // OUTPUT:
    // -
    //
    // CONTOH:
    // delete data di tabel user dengan user_id = 9
    //  table_update('user', array('user_id'=>9));
    //
    function table_delete($table, $where){

        global $DB;
        
        $DB->delete()->from($table)->where($where)->execute();

    }




    ///////////
    // table_query
    // Akan melakukan query
    // INPUT:
    // $query = perintah query
	//
    function table_query($query=''){

        global $DB;
        if ($query == ''){
			return false;
        }
        
        $rows = $DB->query($query)->fetch();  
        
        if($DB->affected_rows > 0){   
          return $rows;
        } else {
          return FALSE;
        }
    }
?>