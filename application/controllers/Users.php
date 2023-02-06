<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller { /**
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

    public function index($pageno=1)
	{		
		$data['breadcum'] = array("users/" => 'Users');		 
       
        $result = $this->User_model->all_ajax_users_list();

        $data['user_list'] =  $result;

            $data['pageno'] = $pageno;

          $data['posturl'] =  base_url().'users/all_ajax_users_list';

        $this->load->view('site_users', $data);
    }

    public function deleteuser()
    {       
            $user_id = $this->uri->segment(3); 
    
			// $where = array('id' => $user_id);
            $result = $this->User_model->delete_user($user_id);

            return array("content"=>"removed");

    }


 
 public function all_ajax_users_list()
    {
        $per_page = 10;
        $search='';
        if($this->input->is_ajax_request())
        {
            $page = $this->input->post('page');
            $per_page = $this->input->post('perpage');
            $search = $this->input->post('search');
            $orderby = $this->input->post('orderby');
            $search = isset($search) && !empty($search) ? $search : '';
            $search=trim($search);
            $cur_page = $page;
            $page -= 1;
            $start = $page * $per_page;
            if($per_page==1)
            {
                $per_page=100000;    
            }
            $previous_btn = true;
            $next_btn = true;
            $first_btn = false;
            $last_btn = false;
            $response=$this->User_model->all_ajax_users_list($search,$per_page,$start,$orderby);
            $data['result']=$response;
             $data['pperpage']=$start+1;
            $views= 'users_ajax_list_items';
            $count=$response['count'];
            $data['start'] = $start;
            $data['cur_page'] = $cur_page;
            $data['no_of_paginations'] = ceil($count / $per_page);
            $data['previous_btn'] = $previous_btn;
            $data['next_btn'] = $next_btn;
            $data['first_btn'] = $first_btn;
            $data['last_btn'] = $last_btn;


   ajax_layout($views,$data);
        }
    }


      public function inactiveusers($pageno=1)
    {       
        $data['breadcum'] = array("users/" => 'Users');      
       
        $result = $this->User_model->all_inactive_ajax_users_list();

        $data['user_list'] =  $result;

        $data['pageno'] = $pageno;

          $data['posturl'] =  base_url().'users/all_inactive_ajax_users_list';

        $this->load->view('site_users', $data);
    }

    public function all_inactive_ajax_users_list()
    {
        $per_page = 10;
        $search='';
        if($this->input->is_ajax_request())
        {
            $page = $this->input->post('page');
            $per_page = $this->input->post('perpage');
            $search = $this->input->post('search');
            $search = isset($search) && !empty($search) ? $search : '';
            $search=trim($search);
            $cur_page = $page;
            $page -= 1;
            $start = $page * $per_page;
            if($per_page==1)
            {
                $per_page=100000;    
            }
            $previous_btn = true;
            $next_btn = true;
            $first_btn = false;
            $last_btn = false;
            $response=$this->User_model->all_inactive_ajax_users_list($search,$per_page,$start);
            $data['result']=$response;
             $data['pperpage']=$start+1;
            $views= 'users_ajax_list_items';
            $count=$response['count'];
            $data['start'] = $start;
            $data['cur_page'] = $cur_page;
            $data['no_of_paginations'] = ceil($count / $per_page);
            $data['previous_btn'] = $previous_btn;
            $data['next_btn'] = $next_btn;
            $data['first_btn'] = $first_btn;
            $data['last_btn'] = $last_btn;


   ajax_layout($views,$data);
        }
    }

      public function activeusers($pageno=1)
    {       
        $data['breadcum'] = array("users/" => 'Users');      
       
        $result = $this->User_model->all_active_ajax_users_list();

        $data['user_list'] =  $result;

        
        $data['pageno'] = $pageno;

          $data['posturl'] =  base_url().'users/all_active_ajax_users_list';

        $this->load->view('site_users', $data);
    }


    public function all_active_ajax_users_list()
    {
        $per_page = 10;
        $search='';
        if($this->input->is_ajax_request())
        {
            $page = $this->input->post('page');
            $per_page = $this->input->post('perpage');
            $search = $this->input->post('search');
            $search = isset($search) && !empty($search) ? $search : '';
            $search=trim($search);
            $cur_page = $page;
            $page -= 1;
            $start = $page * $per_page;
            if($per_page==1)
            {
                $per_page=100000;    
            }
            $previous_btn = true;
            $next_btn = true;
            $first_btn = false;
            $last_btn = false;
            $response=$this->User_model->all_active_ajax_users_list($search,$per_page,$start);
            $data['result']=$response;
             $data['pperpage']=$start+1;
            $views= 'users_ajax_list_items';
            $count=$response['count'];
            $data['start'] = $start;
            $data['cur_page'] = $cur_page;
            $data['no_of_paginations'] = ceil($count / $per_page);
            $data['previous_btn'] = $previous_btn;
            $data['next_btn'] = $next_btn;
            $data['first_btn'] = $first_btn;
            $data['last_btn'] = $last_btn;


   ajax_layout($views,$data);
        }
    }

    public function topusers($pageno=1)
    {       
        $data['breadcum'] = array("users/" => 'Users');      
       
        $result = $this->User_model->all_ajax_top_users_list();

        $data['user_list'] =  $result;

          $data['pageno'] = $pageno;

          $data['posturl'] =  base_url().'users/all_ajax_top_users_list';

        $this->load->view('site_top_users', $data);
    }
	
	/*End of function*/

     

 
 public function all_ajax_top_users_list()
    {
        $per_page = 10;
        $search='';
        if($this->input->is_ajax_request())
        {
            $page = $this->input->post('page');
            $per_page = $this->input->post('perpage');
            $search = $this->input->post('search');
 
            $search = isset($search) && !empty($search) ? $search : '';
            $search=trim($search);
            $cur_page = $page;
            $page -= 1;
            $start = $page * $per_page;
            if($per_page==1)
            {
                $per_page=100000;    
            }
            $previous_btn = true;
            $next_btn = true;
            $first_btn = false;
            $last_btn = false;
            $response=$this->User_model->all_ajax_top_users_list($search,$per_page,$start);
            $data['result']=$response;
             $data['pperpage']=$start+1;
            $views= 'topusers_ajax_list_items';
            $count=$response['count'];
            $data['start'] = $start;
            $data['cur_page'] = $cur_page;
            $data['no_of_paginations'] = ceil($count / $per_page);
            $data['previous_btn'] = $previous_btn;
            $data['next_btn'] = $next_btn;
            $data['first_btn'] = $first_btn;
            $data['last_btn'] = $last_btn;


   ajax_layout($views,$data);
        }
    }


       public function userdetail()
    {       
        $data['breadcum'] = array("users/" => 'Users');  

        $user_id = $this->uri->segment(3);     
         
        $result = $this->User_model->single_users_detail($user_id);
        $resultPost = $this->Post_model->users_admin_post_list($user_id);
        $totalearning = $this->User_model->total_earned_points($user_id);

        $redeempoint = $this->User_model->total_redeem_points($user_id);

        if($totalearning)
        {
             $totalearnings = $totalearning;
        }
        else
        {
            $totalearnings =0;
        }


        if($redeempoint)
        {
            $totalreddemd = $redeempoint;
        }
        else
        {
            $totalreddemd =0;
        }

        
       
     

        $data['user_detail'] =  $result;
        $data['post_list'] =  $resultPost;
        $data['totalearning'] =   $totalearnings;
        $data['totaldonate'] =   $totalreddemd;
        $data['currentpoint'] =  $totalearnings-$totalreddemd;

        $this->load->view('site_users_detail', $data);
    }

    public function block_unblock()
    {
          $blockstatus = $this->uri->segment(3); 
          $user_id = $this->uri->segment(4);
            

          $dataUsers = array(

         'status' => $blockstatus, 

         );
 

        $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $dataUsers); 

          if($blockstatus=='Active') { echo "<button onclick=\"block_unblock('$user_id','Blocked');\" class=\"btn btn-xs btn-success\"> Active </button>"; }   
          
          if($blockstatus=='Blocked') {  echo "<button onclick=\"block_unblock('$user_id','Active');\" class=\"btn btn-xs btn-danger\"> Inactive </button>"; } 
    }
    
    /*End of function*/

 
		/*End of Function*/

}
/*End of class*/