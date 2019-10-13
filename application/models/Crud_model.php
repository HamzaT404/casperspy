<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

   

function get_sms_balance()
{

            $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "bulksms.sefion.com/getbalance.jsp?user=laptopdr&key=24e3447bb2XX&accusage=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
}


 function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }


function get_row_data($table='', $field='') {
        
      return  $this->db->get_where($table, array('data_name'=>$field))->row()->value;

    }

    function get_data($table='', $field='') {
        
      return  $this->db->get($table)->row()->$field;

    }

function update_data($table='', $field='', $data="") {

    
         $this->db->update($table, array($field => $data));
        }

function update_where($table='', $field='',$name='',$data) {

    
   
        $this->db->where($field, $name);
        $this->db->update($table, array('value' => $data));
        }


function getRow($table="", $coloumn="", $data="", $reqData="")
{

     return $this->db->get_where($table , array($coloumn=>$data))->row()->$reqData;

}




}
