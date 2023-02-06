<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller { /**
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

    public function index()
	{		
        $date = date('Y-m-d');
        $tomorrow = date('Y-m-d',strtotime($date . "-20 days"));

		$data['breadcum'] = array("dashboard/" => 'Dashboard');		 
        $data['title'] = 'Investor Searcher || Dashboard';
        $data['total_users'] =  $this->User_model->total_users();
        $data['active_users'] =  $this->User_model->total_active_users($tomorrow);
        $data['inactive_users'] =  $this->User_model->total_inactive_users($tomorrow);
        $data['total_foots'] =   $this->Post_model->total_post(); 

         $this->db->select('foot_posts.*,foot_adds_links.*,foot_app_users.fullname');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  

          $this->db->join('foot_app_users',"foot_posts.user_id = foot_app_users.user_id");  
           
        $where = "  post_type='addv' and foot_posts.post_status='active' and status_of_add='pending'";
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");
        $this->db->limit(5, 0);
          $query = $this->db->get(); 
          $resultAdv = $query->result();

           $data['total_advs'] =$resultAdv;
        /*Charts Date*/
        $footsChart = array();
        $usersChart = array();

            for ($i = 1; $i <= 12; $i++)
            {   
                if($i<10)
                {
                    $i = '0'.$i;
                }
                
                $monthYear = date('Y').'-'.$i;
                 $usersChart[] = $this->User_model->total_users_month_year($monthYear);
                 $footsChart[] = $this->Post_model->total_post_month_year($monthYear);
                 
            }

        $data['total_users_chart'] =  implode(",",$usersChart);
        $data['total_foots_chart'] =  implode(",",$footsChart);


        $this->load->view('site_dashboard', $data);
    }
	
	/*End of function*/

      public function changepassword()
    {         

       $data['status'] = "";
       $data['msg'] = "";
        $u =   $this->session->get_userdata("user_id");

  $user_id = $u['userinfo']->id;
  
         if($_POST){  
       $change_password = md5($_POST['old_password']);       
       $this->db->select('*');
       $this->db->where('id',$user_id);
       $result = $this->db->get('foot_admin');
       //echo $this->db->last_query();die;

       
       if($result->num_rows() > 0)
       {   
        $result = $result->row();
        
        if($change_password==$result->password){
        $upd['password'] =  md5($_POST['new_password']);
        
        $this->db->where('id',$user_id);
        $this->db->update('foot_admin',$upd);
        
        $data['status']   =   'success';
        $data['result']   =  $result;    
        $data['msg']   =  'Your password changed!'; 
        } else {
        $data['status']   =  'danger';
        $data['msg']   =  'Current password is incorrect!'; 
        }
       }else{
        $data['status']   =  'danger';
        $data['msg']    =  'Something went wrong please try again!';
       }
      }


        $this->load->view('site_change_password',$data);
    }
    
    function change_password(){
          echo $this->session->get_userdata("user_id"); 
          die();
      if($_POST){  
       $change_password = md5($_POST['current_p']);       
       $this->db->select('*');
       $this->db->where('id',$user_id);
       $result = $this->db->get('users');
       //echo $this->db->last_query();die;
       
       if($result->num_rows() > 0)
       {   
        $result = $result->row();
        
        if($change_password==$result->password){
        $upd['password'] =  md5($_POST['new_password']);
        
        $this->db->where('id',$user_id);
        $this->db->update('users',$upd);
        
        $data['status']   =   'success';
        $data['result']   =  $result;    
        $data['msg']   =  'Your password changed!'; 
        } else {
        $data['status']   =  'error';
        $data['msg']   =  'Current password is incorrect!'; 
        }
       }else{
        $data['status']   =  'error1';
        $data['msg']    =  'Something went wrong please try again!';
       }
      }
      return $data;
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