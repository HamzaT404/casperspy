<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Admin extends CI_Controller
{
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
            $this->load->helper('file');
            $this->load->helper('form');

            $this->load->library('encryption');

       /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    function insert_contact()
    {
       
        $data['firstname']= $_POST['name'];
        $data['mobile']=$_POST['phonenumber'];
//var_dump($data);die;
       $result=$this->db->insert('contacts',$data);

       if ($result) {
           echo 'data added successfully';
       }
       else
       {
        echo 'error';
       }
        

    }


    function sms($param1='',$param2='',$param3='')
    {
        echo $this->crud_model->get_sms_balance();
    }


    
    /*****SITE/SYSTEM SETTINGS*********/
    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        if ($param1 == 'do_update') {
             
             
             $data['description'] = $this->input->post('customer_title');
             $this->db->where('type' , 'customer_title');
             $this->db->update('settings' , $data);
             
             $data['description'] = $this->input->post('address');
             $this->db->where('type' , 'address');
             $this->db->update('settings' , $data);
             
             $data['description'] = $this->input->post('phone');
             $this->db->where('type' , 'phone');
             $this->db->update('settings' , $data);
             
             $data['description'] = $this->input->post('mobile');
             $this->db->where('type' , 'mobile');
             $this->db->update('settings' , $data);
             

             
            
             
             $data['description'] = $this->input->post('customer_email');
             $this->db->where('type' , 'customer_email');
             $this->db->update('settings' , $data);
             
             
             
            
             $data['description'] = $this->input->post('sms');
             $this->db->where('type' , 'sms');
             $this->db->update('settings' , $data);

             
    
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated')); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        
     
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    
    /*****SMS SETTINGS*********/
    function sms_settings($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($param1 == 'clickatell') {

            $data['description'] = $this->input->post('clickatell_user');
            $this->db->where('type' , 'clickatell_user');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_password');
            $this->db->where('type' , 'clickatell_password');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_api_id');
            $this->db->where('type' , 'clickatell_api_id');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        if ($param1 == 'twilio') {

            $data['description'] = $this->input->post('twilio_account_sid');
            $this->db->where('type' , 'twilio_account_sid');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_auth_token');
            $this->db->where('type' , 'twilio_auth_token');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_sender_phone_number');
            $this->db->where('type' , 'twilio_sender_phone_number');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        if ($param1 == 'active_service') {

            $data['description'] = $this->input->post('active_sms_service');
            $this->db->where('type' , 'active_sms_service');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        $page_data['page_name']  = 'sms_settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    

    

    function add_device()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
            
        $page_data['page_name']  = 'add_device';
        $page_data['page_title'] = get_phrase('add_device');

        $this->load->view('backend/index', $page_data);
    }
    
    function manage_devices()
    {
        if($this->session->userdata('admin_login')!=1)redirect('login' , 'refresh');
        
        
                        
        
        $page_data['page_name']     =   'manage_devices';
        $page_data['page_title']        =   get_phrase('manage_devices');

        
        $this->load->view('backend/index', $page_data);
    }

    
    
    
    


    function device($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {

           
            $data['device_name']        = $this->input->post('device_name');
            $data['color_id']        = $this->input->post('color_id');
            $brand_id = $this->input->post('brand_id');
            $data['brand_id']  = implode(', ', $brand_id);
               $category_id     = $this->input->post('category_id');
           $data['category_id'] = implode(', ', $category_id);
            $data['url_name']        = $this->input->post('url_name');

$pathToImages="sampatti/images/device/temp/";
$pathToThumbs="sampatti/images/device/";

if (!file_exists($pathToImages)) {
    mkdir($pathToImages, 0777, true);
}
if (!file_exists($pathToThumbs)) {
    mkdir($pathToThumbs, 0777, true);
}

  $verify_data    =   array( 'url_name'        => $data['url_name']);
                $get_package = $this->db->get_where('devices' , $verify_data)->result_array();
                 $ckeck = $this->db->affected_rows();
                
                if($ckeck>0)
                {
                $this->session->set_flashdata('error_message', get_phrase(lcfirst($data['url_name']).'_already_exist!'));
                }
                else{

            $result = $this->db->insert('devices', $data);
$device_url =$data['url_name'];
             if ($result) {


move_uploaded_file($_FILES['device_image']['tmp_name'], 'sampatti/images/device/'.$device_url .'.png');
//$thumbWidth=320;
//$tempPhoto= $pathToImages.$device_url.'.png';
//$this->crud_model->createThumbs( $pathToImages, $pathToThumbs, $thumbWidth );

//unlink($tempPhoto);


            $this->session->set_flashdata('flash_message' , get_phrase('device_added_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('Error!'));
            }
           
          // $this->email_model->account_opening_email('section', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            redirect(base_url() . 'index.php?admin/add_device/', 'refresh');
        }

        if ($param1 == 'color') {

           
            $data['color_name']        = $this->input->post('color_name');
         
         $pathToImages="sampatti/images/color/temp/";
$pathToThumbs="sampatti/images/color/";

            if (!file_exists($pathToImages)) {
    mkdir($pathToImages, 0777, true);
}
if (!file_exists($pathToThumbs)) {
    mkdir($pathToThumbs, 0777, true);
}

            $this->crud_model->clear_cache();


                $verify_data    =   array( 'color_name'        => $data['color_name']);
                $get_package = $this->db->get_where('color' , $verify_data)->result_array();
                 $ckeck = $this->db->affected_rows();
                
                if($ckeck>0)
                {
                $this->session->set_flashdata('error_message', get_phrase(lcfirst($data['color_name']).'_color_already_exist!'));
                }
   else
       {     
            $result = $this->db->insert('color', $data);
                        $color_id = $this->db->insert_id();

             if ($result) {
                move_uploaded_file($_FILES['color_image']['tmp_name'], 'sampatti/images/color/temp/'.$color_id .'.png');
            $color_id = $this->db->insert_id();
$pathToImages="sampatti/images/color/temp/";
$pathToThumbs="sampatti/images/color/";
$thumbWidth=100;
$tempPhoto= $pathToImages.$color_id.'.png';
$this->crud_model->createThumbs( $pathToImages, $pathToThumbs, $thumbWidth );

unlink($tempPhoto);

            $this->session->set_flashdata('flash_message' , get_phrase('color_added_successfully!'));
            }

            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('Error!'));
            }
           }
          // $this->email_model->account_opening_email('section', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            
            redirect(base_url() . 'index.php?admin/add_color/', 'refresh');
        }
        
        if ($param1 == 'do_update') {

            $data['category_name']        = $this->input->post('category_name');
            $data['parent_category']        = $this->input->post('parent_category');
           
            
           $this->db->where('category_name', $param2);
            $result= $this->db->update('category', $data);

            
             if ($result) {
            $this->session->set_flashdata('flash_message' , get_phrase('category_updated_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('category_updation_Failed!'));
            }
            
          
            redirect(base_url() . 'index.php?admin/manage_categories/'. $param1, 'refresh');
        } 
        
        if ($param1 == 'delete') {
            $this->db->where('category_name', $param2);
            $this->db->delete('category');

                        $this->session->set_flashdata('info_message' , get_phrase('category_removed!'));

            
            redirect(base_url() . 'index.php?admin/manage_categories/', 'refresh');
        }
    }

 





/***MANAGE inquiry**/
    function contacts($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

       
        $this->db->from('contacts');
        $this->db->order_by("firstname");
        $query = $this->db->get();
       
        
        
        $page_data['page_name']  = 'contacts';
        $page_data['page_title'] = 'View your device Contacts';
         $page_data['contacts_data']    = $query->result_array();

        $this->load->view('backend/index', $page_data);
    }
   
    function notes($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

       
        $this->db->from('notes');
        $this->db->order_by("time");
        $query = $this->db->get();
       
        
        
        $page_data['page_name']  = 'notes';
        $page_data['page_title'] = 'Notes';
         $page_data['note_data']    = $query->result_array();

        $this->load->view('backend/index', $page_data);
    }

     function location($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

       
        $this->db->from('location');
        $query = $this->db->get();
       
        
        
        $page_data['page_name']  = 'location';
        $page_data['page_title'] = 'Location';
         $page_data['location_data']    = $query->result_array();

        $this->load->view('backend/index', $page_data);
    }

     function album($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

       
        $this->db->from('album');
        $query = $this->db->get();
       
        
        
        $page_data['page_name']  = 'album';
        $page_data['page_title'] = 'Album';
         $page_data['album_data']    = $query->result_array();

        $this->load->view('backend/index', $page_data);
    }


      function photos($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $album_query="select * from album where album_id='$param1'";
      

       
      $query = $this->db->get_where('photos',array('album_id' => $param1));
       
        
        
        $page_data['page_name']  = 'photos';
        $page_data['page_title'] =  $this->db->query($album_query)->row()->album_name;
         $page_data['photo_data']    = $query->result_array();
         $page_data['no_of_photos']    = $query->num_rows();
         $page_data['album_folder']    = $this->db->query($album_query)->row()->album_folder;

        $this->load->view('backend/index', $page_data);
    }


/////////////////////////////////
     function call_log($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

       
        $this->db->from('call_log');
        $this->db->order_by("time");
        $query = $this->db->get();
       
        
        
        $page_data['page_name']  = 'call_log';
        $page_data['page_title'] = 'View  device Call Log';
         $page_data['call_log_data']    = $query->result_array();

        $this->load->view('backend/index', $page_data);
    }

      function msg($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

       
        $this->db->from('msg');
        $this->db->order_by("time");
        $query = $this->db->get();
       
        
        
        $page_data['page_name']  = 'msg';
        $page_data['page_title'] = 'View  device Message';
         $page_data['msg_data']    = $query->result_array();

        $this->load->view('backend/index', $page_data);
    }
   

   function audio($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

       
        $this->db->from('audio');
        $this->db->order_by("time");
        $query = $this->db->get();
       
        
        
        $page_data['page_name']  = 'audio';
        $page_data['page_title'] = 'Audio';
         $page_data['audio_data']    = $query->result_array();

        $this->load->view('backend/index', $page_data);
    }

    











    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile']  = $param2;  
        }
        if ($param1 == 'update_phrase') {
            $language   =   $param2;
            $total_phrase   =   $this->input->post('total_phrase');
            for($i = 1 ; $i < $total_phrase ; $i++)
            {
                //$data[$language]  =   $this->input->post('phrase').$i;
                $this->db->where('phrase_id' , $i);
                $this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
            }
            redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/'.$language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language        = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);
            
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        $page_data['page_name']        = 'manage_language';
        $page_data['page_title']       = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data); 
    }
  
    
   /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            
            $this->db->where('admin_id', $this->session->userdata('admin_id'));
            $this->db->update('admin', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_images/' . $this->session->userdata('admin_id') . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $password             = $this->input->post('password');
            $new_password        = $this->input->post('new_password');
            $confirm_new_password = $this->input->post('confirm_new_password');
            $data['new_password']  =  $this->encryption->encrypt($new_password);
            $c_password = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')))->row()->password;

            $current_password = $this->encryption->decrypt($c_password);
            
            if ($current_password == $password && $new_password == $confirm_new_password) {
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));

                //email
$this->email->initialize($config);
$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");
$admin_email = $this->crud_model->getRow('admin','admin_id',$this->session->userdata('admin_id'),'email');
$support_email =    $this->crud_model->getRow('settings','type','support_email','description');
$admin_firstname =  $this->crud_model->getRow('admin','admin_id',$this->session->userdata('admin_id'),'name');
$htmlContent = '<h1>Laptop Doctor - Bharuch</h1>';
$htmlContent .= 'Hi there, <b>'.$admin_firstname.'</b>';

$this->email->from('no-reply@laptopdoctorbharuch.com', 'Laptop Doctor');
$this->email->to($admin_email);
$this->email->subject('Password Changed');
$this->email->message($htmlContent.'<br> You have changed your password successfully..<br> <b>Your Password: '.$new_password.'</b>');

if($this->email->send()){
                    $this->session->set_flashdata('info_message', get_phrase('email_sent_to_your_registered_mail'));

}
else
{
                        $this->session->set_flashdata('error_message', get_phrase('email_not_sent'));
}
                //end mail
            } else {

                $this->session->set_flashdata('error_message', get_phrase('password_mismatch'));
            }
            
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }

        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('admin', array(
            'admin_id' => $this->session->userdata('admin_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
}