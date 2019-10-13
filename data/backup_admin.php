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
    
   
	function student_bulk_add($param1 = '')
	{
		if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
			
		if ($param1 == 'import_excel')
		{
			move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_import.xlsx');
			// Importing excel sheet for bulk student uploads

			include 'simplexlsx.class.php';
			
			$xlsx = new SimpleXLSX('uploads/student_import.xlsx');
			
			list($num_cols, $num_rows) = $xlsx->dimension();
			$f = 0;
			foreach( $xlsx->rows() as $r ) 
			{
				// Ignore the inital name row of excel file
				if ($f == 0)
				{
					$f++;
					continue;
				}
				for( $i=0; $i < $num_cols; $i++ )
				{
					if ($i == 0)	    $data['name']			=	$r[$i];
					else if ($i == 1)	$data['birthday']		=	$r[$i];
					else if ($i == 2)	$data['sex']		    =	$r[$i];
					else if ($i == 3)	$data['address']		=	$r[$i];
					else if ($i == 4)	$data['phone']			=	$r[$i];
					else if ($i == 5)	$data['email']			=	$r[$i];
					else if ($i == 6)	$data['password']		=	$r[$i];
					else if ($i == 7)	$data['roll']			=	$r[$i];
				}
				$data['class_id']	=	$this->input->post('class_id');
				
				$this->db->insert('student' , $data);
				//print_r($data);
			}
			redirect(base_url() . 'index.php?admin/student_information/' . $this->input->post('class_id'), 'refresh');
		}
		$page_data['page_name']  = 'student_bulk_add';
		$page_data['page_title'] = get_phrase('add_bulk_student');
		$this->load->view('backend/index', $page_data);
	}
	
	
    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['class_id']       = $this->input->post('class_id');
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            $this->db->insert('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/class_routine/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['class_id']       = $this->input->post('class_id');
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            
            $this->db->where('class_routine_id', $param2);
            $this->db->update('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/class_routine/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class_routine', array(
                'class_routine_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('class_routine_id', $param2);
            $this->db->delete('class_routine');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/class_routine/', 'refresh');
        }
        $page_data['page_name']  = 'class_routine';
        $page_data['page_title'] = get_phrase('manage_class_routine');
        $this->load->view('backend/index', $page_data);
    }
	
	
    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['amount_paid']        = $this->input->post('amount_paid');
            $data['due']                = $data['amount'] - $data['amount_paid'];
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();

            $data2['invoice_id']        =   $invoice_id;
            $data2['student_id']        =   $this->input->post('student_id');
            $data2['title']             =   $this->input->post('title');
            $data2['description']       =   $this->input->post('description');
            $data2['payment_type']      =  'income';
            $data2['method']            =   $this->input->post('method');
            $data2['amount']            =   $this->input->post('amount_paid');
            $data2['timestamp']         =   strtotime($this->input->post('date'));

            $this->db->insert('payment' , $data2);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/student_payment', 'refresh');
        }

        if ($param1 == 'create_mass_invoice') {
            if (!($this->input->post('student_id'))) {
                foreach ($this->input->post('student_id') as $id) {

                    $data['student_id']         = $id;
                    $data['title']              = $this->input->post('title');
                    $data['description']        = $this->input->post('description');
                    $data['amount']             = $this->input->post('amount');
                    $data['amount_paid']        = $this->input->post('amount_paid');
                    $data['due']                = $data['amount'] - $data['amount_paid'];
                    $data['status']             = $this->input->post('status');
                    $data['creation_timestamp'] = strtotime($this->input->post('date'));
                    
                    $this->db->insert('invoice', $data);
                    $invoice_id = $this->db->insert_id();

                    $data2['invoice_id']        =   $invoice_id;
                    $data2['student_id']        =   $id;
                    $data2['title']             =   $this->input->post('title');
                    $data2['description']       =   $this->input->post('description');
                    $data2['payment_type']      =  'income';
                    $data2['method']            =   $this->input->post('method');
                    $data2['amount']            =   $this->input->post('amount_paid');
                    $data2['timestamp']         =   strtotime($this->input->post('date'));

                    $this->db->insert('payment' , $data2);

                }
            }
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/student_payment', 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'take_payment') {
            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
            $data['description']  =   $this->input->post('description');
            $data['payment_type'] =   'income';
            $data['method']       =   $this->input->post('method');
            $data['amount']       =   $this->input->post('amount');
            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
            $this->db->insert('payment' , $data);

            $data2['amount_paid']   =   $this->input->post('amount');
            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');

            $this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice/payment');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**********ACCOUNTING********************/
    function income($param1 = '' , $param2 = '')
    {
       if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        $page_data['page_name']  = 'income';
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data); 
    }

    function student_payment($param1 = '' , $param2 = '' , $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        $page_data['page_name']  = 'student_payment';
        $page_data['page_title'] = get_phrase('create_student_payment');
        $this->load->view('backend/index', $page_data); 
    }

    function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data); 
    }

    function expense_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }

        $page_data['page_name']  = 'expense_category';
        $page_data['page_title'] = get_phrase('expense_category');
        $this->load->view('backend/index', $page_data);
    }

    /**********MANAGE LIBRARY / BOOKS********************/
    function book_library($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['price']       = $this->input->post('price');
            $data['author']      = $this->input->post('author');
            $data['class_id']    = $this->input->post('class_id');
            $data['status']      = $this->input->post('status');
            $this->db->insert('book', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['price']       = $this->input->post('price');
            $data['author']      = $this->input->post('author');
            $data['class_id']    = $this->input->post('class_id');
            $data['status']      = $this->input->post('status');
            
            $this->db->where('book_id', $param2);
            $this->db->update('book', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('book', array(
                'book_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('book_id', $param2);
            $this->db->delete('book');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        }
        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = get_phrase('manage_library_books');
        $this->load->view('backend/index', $page_data);
        
    }
    
    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);

            $check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('student')->result_array();
                $teachers = $this->db->get('teacher')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);

            $check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('student')->result_array();
                $teachers = $this->db->get('teacher')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $page_data['notices']    = $this->db->get('noticeboard')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
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
             

             
             $data['description'] = $this->input->post('currency');
             $this->db->where('type' , 'currency');
             $this->db->update('settings' , $data);
             
             
             $data['description'] = $this->input->post('customer_email');
             $this->db->where('type' , 'customer_email');
             $this->db->update('settings' , $data);
             
             
             
             $data['description'] = $this->input->post('language');
             $this->db->where('type' , 'language');
             $this->db->update('settings' , $data);
             
             $data['description'] = $this->input->post('text_align');
             $this->db->where('type' , 'text_align');
             $this->db->update('settings' , $data);
             
    
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated')); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'update_social') {
                
                 $data['description'] = $this->input->post('facebook');
             $this->db->where('type' , 'facebook');
             $this->db->update('settings' , $data);
             
             $data['description'] = $this->input->post('twitter');
             $this->db->where('type' , 'twitter');
             $this->db->update('settings' , $data);
             
             $data['description'] = $this->input->post('google');
             $this->db->where('type' , 'google');
             $this->db->update('settings' , $data);
            


            $this->session->set_flashdata('flash_message' , get_phrase('social_link_updated')); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh'); 
        }
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	/***** UPDATE PRODUCT *****/
	
	function update( $task = '', $purchase_code = '' ) {
        
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
            
        // Create update directory.
        $dir    = 'update';
        if ( !is_dir($dir) )
            mkdir($dir, 0777, true);
        
        $zipped_file_name   = $_FILES["file_name"]["name"];
        $path               = 'update/' . $zipped_file_name;
        
        move_uploaded_file($_FILES["file_name"]["tmp_name"], $path);
        
        // Unzip uploaded update file and remove zip file.
        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo('update');
            $zip->close();
            unlink($path);
        }
        
        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        $str                = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
        $json               = json_decode($str, true);
        

			
		// Run php modifications
		require './update/' . $unzipped_file_name . '/update_script.php';
        
        // Create new directories.
        if(!empty($json['directory'])) {
            foreach($json['directory'] as $directory) {
                if ( !is_dir( $directory['name']) )
                    mkdir( $directory['name'], 0777, true );
            }
        }
        
        // Create/Replace new files.
        if(!empty($json['files'])) {
            foreach($json['files'] as $file)
                copy($file['root_directory'], $file['update_directory']);
        }
        
        $this->session->set_flashdata('flash_message' , get_phrase('product_updated_successfully'));
        redirect(base_url() . 'index.php?admin/system_settings');
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
    

//
     /****MANAGE CUSTOMER*****/
    
    function customer_add()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
            
        $page_data['page_name']  = 'customer_add';
        $page_data['page_title'] = get_phrase('add_customer');
        $this->load->view('backend/index', $page_data);
    }
    
    function customer_information()
    {
        if($this->session->userdata('admin_login')!=1)redirect('login' , 'refresh');
        
        
                        
        
        $page_data['page_name']     =   'customer_information';
        $page_data['page_title']        =   get_phrase('customer_information');

        
        $this->load->view('backend/index', $page_data);
    }

    
    
    
    


    function customer($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {

            $data['customer_number']    = $this->input->post('customer_number');
            $data['full_name']        = $this->input->post('full_name');
            $data['full_name_guj']        = $this->input->post('full_name_guj');
            $data['date']    = $this->input->post('date');
            $data['gender']         = $this->input->post('gender');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            $data['password']    = $this->input->post('password');
            $data['status']     = $this->input->post('status');
            $data['membership']     = $this->input->post('membership');

            
                   



            
                $verify_data    =   array( 'customer_number'        => $data['customer_number']);
                $customer = $this->db->get_where('customer' , $verify_data)->result_array();
                 $ckeck = $this->db->affected_rows();
                
                if($ckeck>0)
                {
            $this->session->set_flashdata('flash_message' , get_phrase('Customer_already_exist!'));
                }
else
{

            $result = $this->db->insert('customer', $data);
             if ($result) {




            $this->session->set_flashdata('flash_message' , get_phrase('Customer_Added_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('flash_message' , get_phrase('Error!'));
            }
           
           $this->email_model->account_opening_email('customer', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            redirect(base_url() . 'index.php?admin/customer_add/', 'refresh');
        }
        if ($param2 == 'do_update') {

            $data['full_name']        = $this->input->post('full_name');
            $data['full_name_guj']        = $this->input->post('full_name_guj');
            $data['date']    = $this->input->post('date');
            $data['gender']         = $this->input->post('gender');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            $data['password']    = $this->input->post('password');
            
           

            $this->db->where('customer_number', $param3);
            $result = $this->db->update('customer', $data);
             if ($result) {
            $this->session->set_flashdata('flash_message' , get_phrase('Customer_updated_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('flash_message' , get_phrase('Customer_updation_Failed!'));
            }
            
          
            redirect(base_url() . 'index.php?admin/customer_information/'. $param1, 'refresh');
        } 
        
        if ($param1 == 'delete') {
            $this->db->where('customer_number', $param2);
            $this->db->delete('customer');

                        $this->session->set_flashdata('flash_message' , get_phrase('Customer_Removed!'));

            
            redirect(base_url() . 'index.php?admin/customer_information/', 'refresh');
        }
    }



//--// Add Packages


    function add_magazine()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
            
        $page_data['page_name']  = 'add_magazine';
        $page_data['page_title'] = get_phrase('add_magazine');
        $this->load->view('backend/index', $page_data);
    }

function magazine_information($year='')
    {
        if($this->session->userdata('admin_login')!=1)redirect('login' , 'refresh');
        
       $page_data['year']  =   $year;
        $page_data['page_name']     =   'magazine_information';
        $page_data['page_title']        =   get_phrase('magazine_information');

        
        $this->load->view('backend/index', $page_data);
    }

     
function magazine_selector()
    {
        redirect(base_url() . 'index.php?admin/magazine_information/'.$this->input->post('year'), 'refresh');
    }


     ///- Manage Magazine //

function magazine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            
            $data['year']        = $this->input->post('year');
            $data['month']    = $this->input->post('month');
            
            $data['size']     = $_FILES['magazinefile']['size'];
            $file_name  = $_FILES['magazinefile']['name'];
            $data['type']   = get_mime_by_extension($file_name);
            if($data['month'] == '01') { $month = 'January'; }
            if($data['month'] == '02') { $month = 'February'; }
            if($data['month'] == '03') { $month = 'March'; }
            if($data['month'] == '04') { $month = 'April'; }
            if($data['month'] == '05') { $month = 'May'; }
            if($data['month'] == '06') { $month = 'June'; }
            if($data['month'] == '07') { $month = 'July'; }
            if($data['month'] == '08') { $month = 'August'; }
            if($data['month'] == '09') { $month = 'September'; }
            if($data['month'] == '10') { $month = 'October'; }
            if($data['month'] == '11') { $month = 'November'; }
            if($data['month'] == '12') { $month = 'December'; }
            
            $data['magazine_name']        = $month.'-'.$data['year'];

            $data['magazine_id'] = 'BK'.$data['month'].$data['year'];

            if (!file_exists('uploads/magazine/' . $data['year'])) {
    mkdir('uploads/magazine/' . $data['year'], 0777, true);
}


            $this->crud_model->clear_cache();


                $verify_data    =   array( 'magazine_name'        => $data['magazine_name']);
                $get_package = $this->db->get_where('magazine' , $verify_data)->result_array();
                 $ckeck = $this->db->affected_rows();
              $aaa= $this->db->select('magazine_name'); 
              $ab = $this->db->from('magazine');
               $aa= $this->db->get()->result();
                $magazine_n= "Hasim Json test";
                   $json_e= json_encode($aaa);

                $fp = fopen('data/authors.json', 'w');
                fwrite($fp, json_encode($aa));
                fclose($fp);
                //$del_dash= $this->db->where('phrase', 'Dashboard');
                  //  $xx= $this->db->delete('language');

                if($ckeck>0)
                {
                   
            $this->session->set_flashdata('error_message' , get_phrase('magazine_already_exist!'));
                }
else
{


            move_uploaded_file($_FILES['coverfile']['tmp_name'], 'uploads/magazine/' .$data['year'].'/'.$data['magazine_name'] . '.jpg');

 move_uploaded_file($_FILES['magazinefile']['tmp_name'], 'uploads/magazine/' .$data['year'].'/'.$data['magazine_name'] . '.pdf');
 

            $result = $this->db->insert('magazine', $data);
             if ($result) {




            $this->session->set_flashdata('flash_message' , get_phrase('magazine_uploaded_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('flash_message' , get_phrase('Error_occured!'));
            }
           
          // $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            redirect(base_url() . 'index.php?admin/add_magazine/', 'refresh');
        }
        if ($param1 == 'do_update') {

            $data['year']        = $this->input->post('year');
            $data['month']    = $this->input->post('month');
            
            
            if($data['month'] == '01') { $month = 'January'; }
            if($data['month'] == '02') { $month = 'February'; }
            if($data['month'] == '03') { $month = 'March'; }
            if($data['month'] == '04') { $month = 'April'; }
            if($data['month'] == '05') { $month = 'May'; }
            if($data['month'] == '06') { $month = 'June'; }
            if($data['month'] == '07') { $month = 'July'; }
            if($data['month'] == '08') { $month = 'August'; }
            if($data['month'] == '09') { $month = 'September'; }
            if($data['month'] == '10') { $month = 'October'; }
            if($data['month'] == '11') { $month = 'November'; }
            if($data['month'] == '12') { $month = 'December'; }
            
            $data['magazine_name']        = $month.'-'.$data['year'];

            if (!file_exists('uploads/magazine/' . $data['year'])) {
    mkdir('uploads/magazine/' . $data['year'], 0777, true);
}


           

            $this->db->where('magazine_name', $param2);
            $result = $this->db->update('packages', $data);
             if ($result) {


            $this->session->set_flashdata('flash_message' , get_phrase('magazine_updated_successfully!'));
            
        
            }
            else
            {
            $this->session->set_flashdata('flash_message' , get_phrase('an_error_occured!'));
            }
            
          
            redirect(base_url() . 'index.php?admin/magazine_information/'. $param1, 'refresh');
        } 

         if ($param1 == 'year') {
            
            $data['year']        = $this->input->post('year');
           

            $result = $this->db->insert('year', $data);
             if ($result) {




            $this->session->set_flashdata('flash_message' , get_phrase('new_year_added!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('Error_occured!'));
            }
           
          // $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            
            redirect(base_url() . 'index.php?admin/dashboard/', 'refresh');
        }
        
        if ($param1 == 'delete') {

            $year= $param2;

            $this->db->where('magazine_name', $param2);
            $this->db->delete('magazine');
            $coverfile= 'uploads/magazine/'.$year.'/'.$param2.'.jpg';
            $magazinefile= 'uploads/magazine/'.$year.'/'.$param2.'.pdf';

            
            unlink($coverfile);
            unlink($magazinefile);
        
        }
$this->session->set_flashdata('flash_message' , get_phrase('magazine_deleted!'));
            

            redirect(base_url() . 'index.php?admin/magazine_information/'. $param1, 'refresh');
        
    }

//////////////////////


     function add_section()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
            
        $page_data['page_name']  = 'add_section';
        $page_data['page_title'] = get_phrase('add_section');
        $this->load->view('backend/index', $page_data);
    }
    
    function section_information()
    {
        if($this->session->userdata('admin_login')!=1)redirect('login' , 'refresh');
        
        
                        
        
        $page_data['page_name']     =   'section_information';
        $page_data['page_title']        =   get_phrase('section_information');

        
        $this->load->view('backend/index', $page_data);
    }

    
    
    
    


    function section($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {

           
            $data['name']        = $this->input->post('name');
            $data['name_guj']        = $this->input->post('name_guj');
       
           
            
                $verify_data    =   array( 'name'        => $data['name']);
                $section = $this->db->get_where('section' , $verify_data)->result_array();
                 $ckeck = $this->db->affected_rows();
                
                if($ckeck>0)
                {
            $this->session->set_flashdata('error_message' , get_phrase('section_already_exist!'));
                }
else
{

            $result = $this->db->insert('section', $data);
             if ($result) {




            $this->session->set_flashdata('flash_message' , get_phrase('section_added_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('Error!'));
            }
           
          // $this->email_model->account_opening_email('section', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            redirect(base_url() . 'index.php?admin/add_section/', 'refresh');
        }
        if ($param1 == 'do_update') {

            $data['name']        = $this->input->post('name');
            $data['name_guj']        = $this->input->post('name_guj');
           
            
           $this->db->where('name', $param2);
            $result= $this->db->update('section', $data);

            
             if ($result) {
            $this->session->set_flashdata('flash_message' , get_phrase('section_updated_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('section_updation_Failed!'));
            }
            
          
            redirect(base_url() . 'index.php?admin/section_information/'. $param1, 'refresh');
        } 
        
        if ($param1 == 'delete') {
            $this->db->where('name', $param2);
            $this->db->delete('section');

                        $this->session->set_flashdata('info_message' , get_phrase('section_removed!'));

            
            redirect(base_url() . 'index.php?admin/section_information/', 'refresh');
        }
    }


/////////////


 function add_book_language()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
            
        $page_data['page_name']  = 'add_book_language';
        $page_data['page_title'] = get_phrase('add_book_language');
        $this->load->view('backend/index', $page_data);
    }
    
    function book_language_information()
    {
        if($this->session->userdata('admin_login')!=1)redirect('login' , 'refresh');
        
        
                        
        
        $page_data['page_name']     =   'book_language_information';
        $page_data['page_title']        =   get_phrase('book_language_information');

        
        $this->load->view('backend/index', $page_data);
    }

    
    
    
    


    function book_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {

           
            $data['name']        = $this->input->post('name');
            $data['name_native']        = $this->input->post('name_native');
            $language_code= substr($data['name'], 0, 3);
            $data['language_code'] = strtolower($language_code);
            $line_data['line']= $this->input->post('line');
                $verify_data    =   array( 'language_code'        => $data['language_code']);
                $section = $this->db->get_where('book_language' , $verify_data)->result_array();
                 $ckeck = $this->db->affected_rows();
                
                if($ckeck>0)
                {
            $this->session->set_flashdata('error_message' , get_phrase('book_already_exist!'));
                }
else
{

            $language = "data['".strtolower($data['name'])."']";
            $lan_code = "'".strtolower($language_code)."'";
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('books', $fields);
     
     $myline = $line_data['line'];  
//$add_to_this_line=$add_to_this_line+1;
$filename = "application/controllers/Admin.php";
$add_to_this_line = $myline;
//$lines = file( $filename , FILE_IGNORE_NEW_LINES );
$lines[$add_to_this_line] = '$'.$data['name'].'=$this->input->post('.$lan_code.');';
file_put_contents( $filename , implode( "\n", $lines ) );

            $result = $this->db->insert('book_language', $data);
            $add_line = $this->db->insert('temp', $line_data);

             if ($result && $add_line) {




            $this->session->set_flashdata('flash_message' , get_phrase('book_language_added_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('Error!'));
            }
           
          // $this->email_model->account_opening_email('section', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            redirect(base_url() . 'index.php?admin/add_book_language/', 'refresh');
        }
        if ($param1 == 'do_update') {

            $data['name']        = $this->input->post('name');
            $data['name_native']        = $this->input->post('name_native');
            $data['language_code']= $result = substr($$data['name'], 0, 3);
           
            
           $this->db->where('language_code', $param2);
            $result= $this->db->update('book_language', $data);

            
             if ($result) {
            $this->session->set_flashdata('flash_message' , get_phrase('book_language_updated_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('updation_Failed!'));
            }
            
          
            redirect(base_url() . 'index.php?admin/book_language_information/'. $param1, 'refresh');
        } 
        
        if ($param1 == 'delete') {
            $this->db->where('language_code', $param2);
            $this->db->delete('book_language');

                        $this->session->set_flashdata('info_message' , get_phrase('book_language_removed!'));

            
            redirect(base_url() . 'index.php?admin/book_language_information/', 'refresh');
        }
    }


//Add Book


    function add_book()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
            
        $page_data['page_name']  = 'add_book';
        $page_data['page_title'] = get_phrase('add_book');
        $this->load->view('backend/index', $page_data);
    }

function book_information($section='')
    {
        if($this->session->userdata('admin_login')!=1)redirect('login' , 'refresh');
        
        $page_data['section'] =   $section;
      
        $page_data['page_name']     =   'book_information';
        $page_data['page_title']        =   get_phrase('book_information');

        
        $this->load->view('backend/index', $page_data);
    }


function book_selector()
    {
        $this->session->set_flashdata('info_message' , $this->input->post('section').' books listed');
        redirect(base_url() . 'index.php?admin/book_information/'.$this->input->post('section'), 'refresh');
    }

     
function searchBooks() {
    $postlist['bookSearch'] = $this->view_book_model->getSearchBook($this->input->post('search'));
    $this->load->view('searchbooks.php', $postlist);
}






     ///- Manage Book //

function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            
          
            $data['author']        = $this->input->post('author');
            $data['translator']    = $this->input->post('translator');
            $data['editor']    = $this->input->post('editor');
            $data['note']    = $this->input->post('note');
           
           
            $get_lan_list =    $this->db->get('book_language' )->result_array();
            $total_lan= count($get_lan_list);
         
            if ($_POST) {
        $lan_string = implode('', $_POST['lan']);

            }















//////////////////////////////////////////////////
$data['english']=$this->input->post('eng');
////////////space for new language////////////////////////////////
///////////////////////////////////////////
//////////////////////////////////////////
////////////////////////////////////////////
/////////////////////////////////////////////
  ////////////space for new language////////////////////////////////
///////////////////////////////////////////
///////////////////////////DO NOT CLEAR IT///////////////
////////////////////////////////////////////
/////////////////////////////////////////////
           ////////////space for new language////////////////////////////////
///////////////////////////////////////////
//////////////////////////////////////////
////////////////////////////////////////////
/////////////////////////////////////////////
           ////////////space for new language////////////////////////////////
///////////////////////////////////////////
//////////////////////////////////////////
////////////////////////////////////////////
/////////////////////////////////////////////
           ////////////space for new language////////////////////////////////
///////////////////////////////////////////
//////////////////////////////////////////
////////////////////////////////////////////
/////////////////////////////////////////////
                    
           
         



















            $data['language'] = $lan_string;
            $data['section']    = $this->input->post('section');
            $data['size']     = $_FILES['bookfile']['size'];
            $file_name  = $_FILES['bookfile']['name'];




            $data['type']   = get_mime_by_extension($file_name);
            $id_rm_ch   = preg_replace("/[^\w-]/", "", $file_name);
            
            $id_rm_undsr = str_replace("_", " ", $id_rm_ch);
            $id_rm_spc = str_replace(' ', '', $id_rm_undsr);
            $data['book_id'] = substr($id_rm_spc, 0, -3);
            
            $data['name']    = substr($id_rm_undsr, 0, -3);

          

            if (!file_exists('uploads/book/')) {
    mkdir('uploads/book/', 0777, true);
}


            $this->crud_model->clear_cache();


                $verify_data    =   array( 'book_id'        => $data['book_id']);
                $get_package = $this->db->get_where('books' , $verify_data)->result_array();
                 $ckeck = $this->db->affected_rows();
                
                if($ckeck>0)
                {
                $this->session->set_flashdata('error_message', get_phrase('book_already_exist!'));
            //$this->session->set_flashdata('flash_message' , get_phrase('book_already_exist!'));
                }
else
{


            move_uploaded_file($_FILES['coverfile']['tmp_name'], 'uploads/book/'.$data['book_id'] .'.jpg');

            move_uploaded_file($_FILES['bookfile']['tmp_name'], 'uploads/book/'.$data['book_id'] .'.pdf');
              $data['pages']= $this->crud_model->getNumPagesPdf('uploads/book/'.$data['book_id'] .'.pdf');

            $result = $this->db->insert('books', $data);
             if ($result) {




            $this->session->set_flashdata('flash_message' , get_phrase('book_uploaded_successfully!'));
            }
            else
            {
            $this->session->set_flashdata('flash_message' , get_phrase('Error_occured!'));
            }
           
          // $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            redirect(base_url() . 'index.php?admin/add_book/', 'refresh');
        }
        if ($param1 == 'do_update') {



            $data['author'] =   $this->input->post('author');
            $data['translator']    = $this->input->post('translator');
            $data['editor']    = $this->input->post('editor');
            $data['note']    = $this->input->post('note');
            $language   = $this->input->post('language');


           



            $data['section']    = $this->input->post('section');
            $data['size']     = $_FILES['bookfile']['size'];
            $file_name  = $_FILES['bookfile']['name'];

          



            $data['type']   = get_mime_by_extension($file_name);
            $id_rm_ch   = preg_replace("/[^\w-]/", "", $file_name);
            
            $id_rm_undsr = str_replace("_", " ", $id_rm_ch);
            $id_rm_spc = str_replace(' ', '', $id_rm_undsr);
            $data['book_id'] = substr($id_rm_spc, 0, -3);
            
            $data['name']    = $this->input->post('name');

            //$data['language']    = $gujarati.' '.$english." ".$hindi." ".$urdu." ".$other_language;

            if (!file_exists('uploads/book/')) {
    mkdir('uploads/book/', 0777, true);
}


            $this->crud_model->clear_cache();





            move_uploaded_file($_FILES['coverfile']['tmp_name'], 'uploads/book/'.$data['book_id'] .'.jpg');

            move_uploaded_file($_FILES['bookfile']['tmp_name'], 'uploads/book/'.$data['book_id'] .'.pdf');
              $data['pages']= $this->crud_model->getNumPagesPdf('uploads/book/'.$data['book_id'] .'.pdf');


            $this->db->where('book_id', $data['book_id']);
            $result= $this->db->update('books', $data);

           
             if ($result) {




            $this->session->set_flashdata('info_message' , get_phrase('book_updated!'));
            }
            else
            {
            $this->session->set_flashdata('error_message' , get_phrase('Error_occured!'));
            }
           
       
          
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        } 
        
        if ($param1 == 'delete') {

            $year= $param2;

            $this->db->where('book_id', $param2);
            $this->db->delete('books');
            $coverfile= 'uploads/book/'.$param2.'.jpg';
            $bookfile= 'uploads/book/'.$param2.'.pdf';

            
            unlink($coverfile);
            unlink($bookfile);
        
        }
$this->session->set_flashdata('info_message' , get_phrase($param2.' book_deleted!'));
            

            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        
    }


/***MANAGE inquiry**/
    function inquiry($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['inquiry_title']     = $this->input->post('inquiry_title');
            $data['inquiry']           = $this->input->post('inquiry');
            $data['create_timestamp'] = date('m/d/Y');
            $data['first_name']    = $this->input->post('first_name');
            $data['last_name']     = $this->input->post('last_name');
            $data['phone']           = $this->input->post('phone');
            $data['email']           = $this->input->post('email');

              $inquiry_i = substr($data['inquiry_title'], 0, 3);
                   $inquiry_d = $date = date("Ymdhisa");
                   $inquiry_id = $inquiry_i.$inquiry_d;

            $data['inquiry_id'] = $inquiry_id;

            $result=$this->db->insert('inquiry', $data);

            if ($result) {
            echo "<script type='text/javascript'>alert('We have received your Booking inquiry, We will contact you soon. Note Down your Inquiry ID: $inquiry_id')</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('An error has occured, Please contact on : +91-2642-244441')</script>";
            }
            
            
            redirect(base_url() . 'index.php?frontend/inquiry_success/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);
            $this->session->set_flashdata('flash_message', get_phrase('notice_updated'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('inquiry_id', $param2);
            $this->db->delete('inquiry');
            $this->session->set_flashdata('flash_message' , 'Inquiry Deleted!');

            redirect(base_url() . 'index.php?admin/inquiry/', 'refresh');
        }
        $page_data['page_name']  = 'inquiry';
        $page_data['page_title'] = get_phrase('view_inquiry');
        $page_data['inquiry']    = $this->db->get('inquiry')->result_array();
        $this->load->view('backend/index', $page_data);
    }
   

/////////////////////////////////













    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
			redirect(base_url() . 'index.php?login', 'refresh');
		
		if ($param1 == 'edit_phrase') {
			$page_data['edit_profile'] 	= $param2;	
		}
		if ($param1 == 'update_phrase') {
			$language	=	$param2;
			$total_phrase	=	$this->input->post('total_phrase');
			for($i = 1 ; $i < $total_phrase ; $i++)
			{
				//$data[$language]	=	$this->input->post('phrase').$i;
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
    
    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        
        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
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
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');
            
            $current_password = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
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