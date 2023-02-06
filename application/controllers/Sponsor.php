<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsor extends CI_Controller { /**
     * Constructor
     */ 
    function __construct() {
		parent::__construct();
        is_protected();
        $this->load->model('User_model');
		$this->load->model('Post_model');
		
    }
	
	/**
     * End of function
     */
	 
	 /**
     * index
     *
     * This function to render dashboard page initially
     * 
     * @access	public
     * @return  html
     */
   public function generateRandomString($length)       

  {

    $characters = '0123456789';

    $charactersLength = strlen($characters);

    $randomString = '';

    for ($i = 0; $i < $length; $i++) {

      $randomString .= $characters[rand(0, $charactersLength - 1)];

    }

    return $randomString;

  }

    public function list_sponsors()
	{		 
    $sedatas=$this->session->all_userdata();
        if($sedatas['userinfo']->app_user_id!=0)
            { 
                 redirect(base_url('Sponsor/profile_sponsor/'.$sedatas['userinfo']->app_user_id));
            }

		$data['breadcum'] = array("dashboard/" => 'Dashboard');		 
        $data['title'] = 'Investor Searcher || Sponsor';
        
          $this->db->select('foot_app_users.*,foot_sponsor.first_name,foot_sponsor.last_name');

          $this->db->from('foot_app_users');

          $this->db->join('foot_sponsor',"foot_sponsor.user_id = foot_app_users.user_id");  
       
          $this->db->order_by("foot_app_users.user_id", "desc");

          $query = $this->db->get(); 
          $result = $query->result();
        
          $content = array();
          foreach ($result as  $value) {
            $user_id = $value->user_id;

            $queryLive = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_adds_links on  foot_adds_links.url_post_id = foot_posts.post_id   where post_status= 'active' and post_type= 'addv' and foot_adds_links.status_of_add='pending'    and  foot_posts.user_id='$user_id'");

               $resultLive = $queryLive->num_rows();

               $value->liveads = $resultLive;
                $queryPublish = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_adds_links on foot_adds_links.url_post_id = foot_posts.post_id   where post_status= 'active' and post_type= 'addv' and foot_adds_links.status_of_add='approved'    and  foot_posts.user_id='$user_id'");

               $resultPublish = $queryPublish->num_rows();

               $value->published = $resultPublish;
               $content[] = $value;
          } 

          $data['allsponose'] = $content;
          

        $this->load->view('site_list_sposor', $data);
    }
	
	/*End of function*/

      public function updatevadity()
    {         
        $user_id=$this->input->post('user_id');
        $account_validity=$this->input->post('account_validity');

        $data = array( 
              'validity'      => $account_validity 
          );

          $this->db->where('user_id', $user_id);

          $this->db->update('foot_sponsor', $data);

          redirect(base_url('Sponsor/profile_sponsor/'.$user_id));
    }
    public function updatetype()
    {         
       $user_id=$this->input->post('user_id');
       $optionsRadios=$this->input->post('optionsRadios');
       $org_quota=$this->input->post('org_quota');

         
        $data = array( 
              'adv_type'      => $optionsRadios, 
              'total_ads'      => $org_quota,
          );

          $this->db->where('user_id', $user_id);

          $this->db->update('foot_sponsor', $data);

          redirect(base_url('Sponsor/profile_sponsor/'.$user_id));

    }
    public function create_sponsor()
    {         
       $sedatas=$this->session->all_userdata();
        if($sedatas['userinfo']->app_user_id!=0)
            { 
                 redirect(base_url('Sponsor/profile_sponsor/'.$sedatas['userinfo']->app_user_id));
            }
            
       $data['breadcum'] = array("createsponsor/" => 'Create Sponsor');    
        $data['title'] = 'Investor Searcher || Create Sponsor';
          $data['error'] = "";
        $this->load->view('site_create_sposor',$data);
    }
       public function profile_sponsor()
    {          
         $data['breadcum'] = array("dashboard/" => 'Dashboard');    
        $data['title'] = 'Investor Searcher || Dashboard';
        $userid = $this->uri->segment(3);

            $this->db->select('foot_app_users.*,foot_sponsor.first_name,foot_sponsor.last_name,foot_sponsor.address,foot_sponsor.adv_type,foot_sponsor.validity,foot_sponsor.phone,foot_sponsor.total_ads');

          $this->db->from('foot_app_users');

          $this->db->join('foot_sponsor',"foot_sponsor.user_id = foot_app_users.user_id", 'left');  
       
          $this->db->order_by("foot_app_users.user_id", "desc");


        $where = "foot_app_users.user_id='$userid'";
     
        $this->db->where($where);   
          $query = $this->db->get(); 
          $result = $query->row(); 


          $this->db->select('foot_posts.*,foot_adds_links.*');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  
          
          $where = "foot_posts.user_id='$userid' and post_type='addv' and post_status='active' ";
       
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");

          $query = $this->db->get(); 
          $resultadsall = $query->result();

            $this->db->select('foot_posts.*,foot_adds_links.*');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  
          
          $where = "foot_posts.user_id='$userid' and post_type='addv' and post_status='active' and status_of_add='approved'";
       
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");

          $query = $this->db->get(); 
          $resultads = $query->result(); 


          $this->db->select('foot_posts.*,foot_adds_links.*');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  
          
          $where = "foot_posts.user_id='$userid' and post_type='addv' and post_status='active'  and status_of_add='pending'";
       
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");

          $query = $this->db->get(); 
          $resultadspending = $query->result();


          $data['allsponose'] = $result;
          $data['resultads'] = $resultads;
          $data['resultadsall'] = $resultadsall;
          $data['resultadspending'] = $resultadspending;


        $this->load->view('site_list_profile',$data);
    }
     function update_sponsor()
    {


         
            // $this->load->view('formsuccess'); 
            $sponsor_id=$this->input->post('sponsor_id');
            $first_name=$this->input->post('first_name');
            $last_name=$this->input->post('last_name');
             
            $org_address=$this->input->post('org_address');
            $org_phone=$this->input->post('org_phone');
            $password=$this->generateRandomString(6);

            $data = new stdClass();
              
              

            $data->{'profileimage'}="";
 
                
               


              if(isset($_FILES['org_profile']['name']) && $_FILES['org_profile']['name']!="" )                                            /*check image is not there*/

              {                                                                                     

                $ids = rand(1,100);

                $dir_path="upload/".$sponsor_id;

                @mkdir($dir_path);

                $img_name_array= $_FILES['org_profile']['name'];

                  //$img_ext=end($img_name_array);

                $time = time().'.jpg';

                $selfie=$ids.'_'.$time;

                $upload_path=$dir_path.'/'.$selfie;

                
                

                  file_put_contents($upload_path, file_get_contents($_FILES['org_profile']['tmp_name']));        /*Save the file on the server */

       

                $data->{'profileimage'} = base_url().$upload_path;
                 $data->{'user_id'} = $sponsor_id;
                  $this->User_model->update_image($data);    

              }

               $first_name=$this->input->post('first_name');
            $last_name=$this->input->post('last_name');    
            $org_address=$this->input->post('org_address');
            $org_phone=$this->input->post('org_phone');

               $dataSponsors = array(                                                      /*An array of data to insert into table*/
 

             'first_name' => $first_name,     
             
             'last_name' => $last_name,     

             'address' => $org_address, 
              'phone' => $org_phone

             ); 
               $this->db->where('user_id',$sponsor_id);
          $this->db->update('foot_sponsor', $dataSponsors);   
             

          

          $dataadmin = array(                                                      /*An array of data to insert into table*/

             'name' => $first_name.' '.$last_name,     
                         

             );
$this->db->where('app_user_id', $sponsor_id); 
          $this->db->update('foot_admin', $dataadmin);  
           
 
  
          
              set_flashdata('success','Sponsor updated Successfully');
              redirect(base_url('Sponsor/profile_sponsor/'.$sponsor_id));
            
              
           
 
    }
    function add_sponsor()
    {

         $this->load->helper(array('form'));
         $this->load->library('form_validation');
         $this->form_validation->set_rules('first_name', 'first_name', 'required'); 
         $this->form_validation->set_rules('last_name', 'last_name', 'required'); 
         $this->form_validation->set_rules('organisation_name', 'organisation_name', 'required'); 
         $this->form_validation->set_rules('account_validity', 'account_validity', 'required'); 
         $this->form_validation->set_rules('optionsRadios', 'optionsRadios', 'required'); 
         $this->form_validation->set_rules('org_quota', 'org_quota', 'required');   
         $this->form_validation->set_rules('org_email', 'org_email', 'required'); 
         if ($this->form_validation->run() == FALSE) { 
          $data['error'] = "1";

             $this->load->view('site_create_sposor',$data); 
         }else{ 
            // $this->load->view('formsuccess'); 
            $first_name=$this->input->post('first_name');
            $last_name=$this->input->post('last_name');
            $organisation_name = $this->input->post('organisation_name');
            $account_validity=$this->input->post('account_validity');
            $optionsRadios=$this->input->post('optionsRadios');
             $org_quota=$this->input->post('org_quota');
            $org_email=$this->input->post('org_email');
            $org_address=$this->input->post('org_address');
            $org_phone=$this->input->post('org_phone');
            $password=$this->generateRandomString(6);

            $data = new stdClass();
             
             $data->{'useremail'}= $org_email; 
             $data->{'device_type'}= "android";
             $data->{'device_token'}= ""; 
             $data->{'password'}= $password;
             $data->{'fullname'}= $organisation_name;
             $data->{'username'}= str_replace(" ", "_", $organisation_name);

              $data->{'profileimage'}="";

                $sponsorDetail  = $this->User_model->sponsor_signup_user($data);
              
               if ($sponsorDetail=='4' || $sponsorDetail=='2') 
               {
                  $this->form_validation->set_rules(
                    'org_email', 'Email', 'valid_email|required|is_unique[foot_app_users.useremail]',
                    array('is_unique' => 'This %s already exists.')
                );   
                   $datas['error'] = "1";
                   $datas['error_value'] = "Email id already exists.";
                   if ($sponsorDetail=='4')
                   {
                    $datas['error_value'] = "Organisation Name already exists.";
                  }

                     $this->load->view('site_create_sposor',$datas); 
                     return false;
              }
               


              if(isset($_FILES['org_profile']['name']))                                            /*check image is not there*/

              {                                                                                     

                $ids = rand(1,100);

                $dir_path="upload/".$sponsorDetail->user_id;

                @mkdir($dir_path);

                $img_name_array= $_FILES['org_profile']['name'];

                  //$img_ext=end($img_name_array);

                $time = time().'.jpg';

                $selfie=$ids.'_'.$time;

                $upload_path=$dir_path.'/'.$selfie;

                
                

                  file_put_contents($upload_path, file_get_contents($_FILES['org_profile']['tmp_name']));        /*Save the file on the server */

       

                $data->{'profileimage'} = base_url().$upload_path;
                 $data->{'user_id'} = $sponsorDetail->user_id;
                  $this->User_model->update_image($data);    

              }

               $first_name=$this->input->post('first_name');
            $last_name=$this->input->post('last_name');
            $organisation_name = $this->input->post('organisation_name');
            $account_validity=$this->input->post('account_validity');
            $optionsRadios=$this->input->post('optionsRadios');
               $org_quota1 =$this->input->post('org_quota');
              $org_email=$this->input->post('org_email');
            $org_address=$this->input->post('org_address');
            $org_phone=$this->input->post('org_phone');

               $dataSponsors = array(                                                      /*An array of data to insert into table*/

             'user_id' => $sponsorDetail->user_id,

             'first_name' => $first_name,     
             
             'last_name' => $last_name,     

             'address' => $org_address,

             'adv_type' => $optionsRadios,
             
             'total_ads' => $org_quota1,
             
             'validity' =>$account_validity,
          
             'date_of_creation'=> date('Y-m-d H:i:s'), 

              'phone' => $org_phone

             ); 

           

       

          $this->db->insert('foot_sponsor', $dataSponsors);   

          $dataadmin = array(                                                      /*An array of data to insert into table*/

             'app_user_id' => $sponsorDetail->user_id,

             'name' => $first_name.' '.$last_name,     
             
             'password' => md5($password),     

             'email' => $org_email,

             'status' => "1", 

             'created_date'=> date('Y-m-d H:i:s'), 

             'modified_date'=> date('Y-m-d H:i:s'), 

             'last_login'=> date('Y-m-d H:i:s'),

             'donationpoint'=> 0
 

             );

          $this->db->insert('foot_admin', $dataadmin);  

            $text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    <!-- <![endif]-->

    <title>Footshots</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }
        
        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        span.preheader {
            display: none;
            font-size: 1px;
        }
        
        html {
            width: 100%;
        }
        
        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */
        
        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }
        
        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!-- [if gte mso 9]><style type=”text/css”>
        body {
        font-family: arial, sans-serif!important;
        }
        </style>
    <![endif]-->
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
                    
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 100px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>

                        <td align="center" class="section-img">
                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="'.base_url().'public/img/welcome.png" style="display: block; width: 590px;" width="590" border="0" alt="" /></a>




                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                            <div style="line-height: 35px">

                                We\'re Glad <span style="color: #5caad2;">You\'re Here</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="500" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                     <td align="center" style="color: #343434; font-size: 24px; font-family: \'Roboto\', sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                                        <div style="line-height: 35px">

                                            You have successfully registered as <span style="color: #376bcc;">Sponsor</span>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="35" style="font-size: 25px; line-height: 35px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" width="500" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="justify" style="color: #888888; font-size: 16px; font-family: \'Roboto\', sans-serif; line-height: 24px;">


                                        <div style="line-height: 24px">

                                            Following are the login credentials of your account:
                                            <br>
                                            Username: '.$org_email.'<br>
                                            Password: '.$password.'<br><br>
                                            Regards,<br>
                                            Footshots Team
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    

                </table>

            </td>
        </tr>

    </table>
    <!-- end section -->
    
    <table border="0" width="370" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td height="30" width="" style="border-top: 1px solid #edecec;font-size: 60px; line-height: 30px;">&nbsp;</td>
        </tr>
    </table>

    <!-- contact section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr class="hide">
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

        

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590 bg_color">

                    <tr>
                        <td>
                            <table border="0" width="300" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <!-- logo -->
                                    <td align="left">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="80" border="0" style="display: block; width: 80px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="left" style="color: #888888; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 23px;" class="text_color">
                                        <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">

                                            Email us: <br/> <a href="mailto:info@footshots.com.au" style="color: #888888; font-size: 14px; font-family: \'Hind Siliguri\', Calibri, Sans-serif; font-weight: 400;">info@footshots.com.au</a>

                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <table border="0" width="2" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">
                                <tr>
                                    <td width="2" height="10" style="font-size: 10px; line-height: 10px;"></td>
                                </tr>
                            </table>

                            <table border="0" width="200" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <td class="hide" height="45" style="font-size: 45px; line-height: 45px;">&nbsp;</td>
                                </tr>



                                <tr>
                                    <td height="15" style="font-size: 15px; line-height: 15px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" align="right" cellpadding="0" cellspacing="0">
                                            <tr><!-- 
                                                <td>
                                                    <a href="https://www.facebook.com/mdbootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Qc3zTxn.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://twitter.com/MDBootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/RBRORq1.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://plus.google.com/u/0/b/107863090883699620484/107863090883699620484/posts" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Wji3af6.png" alt=""></a>
                                                </td>
                                             --></tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end section -->

    <!-- footer ====== -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">

        <tr>
            <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td>
                            

                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:70px;font-family: \'Work Sans\', Calibri, sans-serif;" class="container590">

                                <tr>
                                    <td align="center">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    &copy; 2019 Footshots Pty. Ltd.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end footer ====== -->

</body>

</html>';

      //$text = '<p>Dear '.$first_name.' '.$last_name.', Congratulation ! You have successfully signed up for Mexus App.</p>';



      $this->User_model->send_email_sendgrid_api($org_email,'me','Footshots: Registered successfully',$text);  /*Call a function to send welcome email.*/
 

          
              set_flashdata('success','Sponsor created Successfully');
              redirect(base_url('Sponsor/list_sponsors'));
            
              
              } 

    }


    /*End of function*/


	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
		/*End of Function*/



}
/*End of class*/