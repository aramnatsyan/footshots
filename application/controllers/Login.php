<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	/**
     *  Login Controller
     *
     * @package		Login
     * @category    Login
     * @author		Akhil
     * @website		http://emobx.com
     * @company     Enterprise Mobility Xperts
     * @since		Version 1.0
     */

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('login_mod');
    
			
    }

    /* End of constructor */
	
	/**
     *index
     *
     * This function dispaly login page
     * 
     * @access	public
     * @return	html data
    */


	public function index()
	{
		if(isPostBack()) 
        {
			$remember   =   $this->input->post('remember',true); 
			$email      =   $this->input->post('email',true); 
			$password   =   $this->input->post('password',true); 
			
			$rs_data    =   $this->login_mod->login_authorize();  
			if($rs_data['status']=="success"){
			 
			   $this->session->set_userdata("userinfo",$rs_data['result']);   
			   $this->session->set_userdata("isLogin",'yes'); 
 
			  
			   $password_enc = md5($password);
			   if($remember) // set remember username and password in cookie 
			   {
					setcookie('fs_email',$email,time()+(86400 * 30),"/");
					setcookie('fs_password',$password,time()+(86400 * 30),"/");
					setcookie('fs_remember',$remember,time()+(86400 * 30),"/");

			   }else{
					setcookie('fs_email','',time()+(86400 * 30),"/");
					setcookie('fs_password','',time()+(86400 * 30),"/");
					setcookie('fs_remember',$remember,time()+(86400 * 30),"/");
			   }
				$sedatas=$this->session->all_userdata();
				 
					if($sedatas['userinfo']->app_user_id==0)
					{
                    	redirect(base_url('dashboard'));
                    }
                    else if($sedatas['userinfo']->app_user_id!=0)
					{
						redirect(base_url('/Sponsor/profile_sponsor/'.$sedatas['userinfo']->app_user_id));
					}
			//redirect(base_url('dashboard'));
			}else{
				if($rs_data['error_msg'] != '')
				{
					 $this->session->set_flashdata("error", $rs_data['error_msg']);	
				}
				redirect(base_url('login'));
			}
                
         }else
		{
                if ($this->session->userdata('isLogin') == 'yes') 
				{       	
					$sedatas=$this->session->all_userdata();

					if($sedatas['userinfo']->app_user_id==0)
					{
                    	redirect(base_url('dashboard'));
                    }
                    else if($sedatas['userinfo']->app_user_id!=0)
					{
						redirect(base_url('/Sponsor/profile_sponsor/'.$sedatas['userinfo']->app_user_id));
					}


                }else{
               
                    $data['title'] = 'Login';
                    $this->load->view('login', $data);
                }
        } 
    }
	
}
