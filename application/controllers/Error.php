<?php 

class My404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
        $data['page_name'] = 'error_404'; // View name 
        $data['page_title'] = 'Page Does Not Exist- Error 404'; // View Title
        $this->load->view('frontend/index',$data);//loading in my template 
    } 
 
} 

?>