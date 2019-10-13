<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('user_agent');
$this->load->library('encryption');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {

        if ($this->session->userdata('admin_login') == 1)
            {
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
            
            }
        if ($this->session->userdata('customer_login') == 1)
            redirect(base_url() . '', 'refresh');


        $this->load->view('backend/login');
    }

    public function login_otp() {

        if ($this->session->userdata('admin_login') == 1)
            {
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
            
            }
        if ($this->session->userdata('customer_login') == 1)
            redirect(base_url() . '', 'refresh');


        $this->load->view('backend/login_otp');
    }


    public function verify_otp($mobile='') {

        if ($this->session->userdata('admin_login') == 1)
            {
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
            
            }
        if ($this->session->userdata('customer_login') == 1)
            redirect(base_url() . '', 'refresh');

          $data['mobile'] = $mobile;
        $this->load->view('backend/verify_otp',$data);
    }

    function otp_access()
    {
      $otp = $this->input->post('otp');
      $mobile = $this->input->post('mobile');
      $real_otp = $this->db->get_where('admin',array('otp' => $otp,'mobile' => $mobile))->row()->otp;
      //var_dump($mobile);die;
      if($real_otp == $otp)
      {
          $credential    =   array(  'otp' => $otp);
        $query = $this->db->get_where('admin' , $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
              $this->session->set_userdata('admin_login', '1');
              $this->session->set_userdata('admin_id', $row->admin_id);
              $this->session->set_userdata('name', $row->name);
              $this->session->set_userdata('login_type', 'admin');
              $this->session->set_userdata('email', $row->email);
               $otp_data=array('otp'=>'null');

 $this->db->where('admin_id', $row->admin_id);
 $query = $this->db->update('admin',$otp_data);
        $this->session->set_flashdata('flash_message' , 'Login Success.. Welcome to Casper Spy.');
            redirect(base_url() .'?admin/dashboard', 'refresh');
        
      }
    }
    else
    {
        $this->session->set_flashdata('error_message' , 'Invalid OTP');
      redirect(base_url() .'?login/verify_otp', 'refresh');
    }

  }

    function send_otp()
    {
      $mobile = $this->input->post('mobile');

$check = $this->db->get_where('admin',array('mobile' => $mobile))->num_rows();
if($check < 1)
{
  $this->session->set_flashdata('error_message' , 'Mobile number is not registered');
  redirect(base_url() .'?login/login_otp', 'refresh');
}

      $otp = rand(100000,999999);
  $otp_data=array('otp'=>$otp);


 $this->db->where('mobile', $mobile);
 $query = $this->db->update('admin',$otp_data);

$text = "Your Casper Spy OPT: $otp . Use this OTP to access CASPER SPY account";
               
              
//Your message to send, Add URL encoding here.
$message = urlencode($text);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://bulksms.sefion.com/submitsms.jsp?user=hamza&key=293a6dd1c1XX&mobile=+91$mobile&message=$message&senderid=NTFSMS&accusage=1",
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
  
} else {
  
}



  $this->session->set_flashdata('flash_message' , 'OTP sent');


              redirect(base_url() .'index.php?login/verify_otp/'.$mobile, 'refresh');    
    }

    function resend_otp($mobile = '')
    {
     

$check = $this->db->get_where('admin',array('mobile' => $mobile))->num_rows();
if($check < 1)
{
  $this->session->set_flashdata('error_message' , 'Mobile number is not registered');
  redirect(base_url() .'?login/login_otp', 'refresh');
}

      $otp = rand(100000,999999);
  $otp_data=array('otp'=>$otp);


 $this->db->where('mobile', $mobile);
 $query = $this->db->update('admin',$otp_data);

$text = "Your Casper Spy OPT: $otp . Use this OTP to access CASPER SPY account";
               
              
//Your message to send, Add URL encoding here.
$message = urlencode($text);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://bulksms.sefion.com/submitsms.jsp?user=hamza&key=293a6dd1c1XX&mobile=+91$mobile&message=$message&senderid=NTFSMS&accusage=1",
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
  
} else {
  
}



  $this->session->set_flashdata('flash_message' , 'OTP sent');


              redirect(base_url() .'index.php?login/verify_otp/'.$mobile, 'refresh');    
    }

    //Ajax login function 
   function ajax_login()
    {
        $response = array();
        
        //Recieving post input of email, password from ajax request
        $email      = $_POST["email"];
        $password   = $_POST["password"];
        $response['submitted_data'] = $_POST;       
        
        //Validating login
        $login_status = $this->validate_login( $email ,  $password );
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {

if ($this->agent->is_referral())
{
    $response['redirect_url'] = $this->agent->referrer();
}
else
{
            $response['redirect_url'] = 'index.php?admin/dashboard';
        }
        }
        
        //Replying ajax request with validation response
        echo json_encode($response);
    }
    
    //Validating login from ajax request
    function validate_login($email  =   '' , $password   =  '')
    {
         $credential    =   array(  'email' => $email);
         
         
         
         $password2 =  $this->encryption->decrypt($this->crud_model->getRow('admin','email',$email,'password'));
           
       
         if($password == $password2)
         {

         // Checking login credential for admin
        $query = $this->db->get_where('admin' , $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
              $this->session->set_userdata('admin_login', '1');
              $this->session->set_userdata('admin_id', $row->admin_id);
              $this->session->set_userdata('name', $row->name);
              $this->session->set_userdata('login_type', 'admin');
              $this->session->set_userdata('email', $row->email);
              return 'success';
        }
         }
     
        
         // Checking login credential for parent
       
       
        return 'invalid';
    }


    function first_login($email  =   '' , $password   =  '')
    {
         $credential    =   array(  'email' => $email , 'password' => $password );
         
       
         
         // Checking login credential for customer
       
         $query = $this->db->get_where('customer' , $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
              $this->session->set_userdata('customer_login', '1');
              $this->session->set_userdata('email', $row->email);
              $this->session->set_userdata('name', $row->firstname);
              $this->session->set_userdata('customer_id', $row->customer_id);
              $this->session->set_userdata('login_type', 'customer');
             redirect(base_url() . 'index.php?frontend/cart', 'refresh');
        }
        
         // Checking login credential for parent
       
        
        return 'invalid';
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    function ajax_forgot_password()
    {
       // $resp                   = array();
        //$resp['status']         = 'false';
        $email                  = $this->input->post('email');
        $reset_account_type     = 'admin';
        //resetting user password here
        $get_password           =   $this->crud_model->getRow('admin','email',$email,'password');
        $op = $this->encryption->decrypt($get_password);

     /*   // Checking credential for admin
        $query = $this->db->get_where('admin' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'admin';
            $this->db->where('email' , $email);
            $this->db->update('admin' , array('password' => $new_password));
            $resp['status']         = 'true';
        }
        // Checking credential for student
        $query = $this->db->get_where('customer' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'customer';
            $this->db->where('email' , $email);
            $this->db->update('customer' , array('password' => $new_password));
            $resp['status']         = 'true';
        } */
        
        // send new password to user email  
       $this->email->initialize($config);
$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");
//$customer_email = $this->crud_model->getRow('customer','customer_id',$param2,'email');
$support_email =    $this->crud_model->getRow('settings','type','support_email','description');
//$customer_firstname =  $this->crud_model->getRow('customer','email',$email,'firstname');
$htmlContent = '<h1>Laptop Doctor</h1>';
$htmlContent .= 'Hi there, <b>Admin</b>';

$this->email->from('no-reply@laptopdoctorbharuch.com', 'Laptop Doctor');
$this->email->to($email);
$this->email->subject('Password Request');
$this->email->message($htmlContent.'<br> You have requested your password.<br><b>Your Email: '.$email.'</b><br> <b>Your Password: '.$op.'</b>');

if($this->email->send())
{
    $this->session->set_flashdata('flash_message' , 'Password sent to your registered email..');

            redirect(base_url() . 'index.php?login', 'refresh');

}

    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }

}
