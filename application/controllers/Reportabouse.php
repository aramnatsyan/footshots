<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reportabouse extends CI_Controller { /**
     * Constructor
     */ 
    function __construct() {
		parent::__construct();
        is_protected();
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
       
        $result = $this->Post_model->ajax_report_abouse_list();

        $data['post_list'] =  $result;

         $data['pageno'] = $pageno;

          $data['posturl'] =  base_url().'reportabouse/all_ajax_abuse_list';

        $this->load->view('site_posts_report', $data);
    }


 
 public function all_ajax_abuse_list()
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
            $response=$this->Post_model->ajax_report_abouse_list($search,$per_page,$start);
            $data['result']=$response;
            $data['pperpage']=$start+1;
            $views= 'abuse_ajax_list_items';
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
	

    public function blockedpost()
    {       
        $data['breadcum'] = array("users/" => 'Users');      
       
        $result = $this->Post_model->blocked_post_detail();

        $data['post_list'] =  $result;

        $this->load->view('site_posts_report', $data);
    }


	/*End of function*/


       public function reportabousedetail()
    {       
        $data['breadcum'] = array("users/" => 'Users');  

        $user_id = $this->uri->segment(3);     
         
        $resultdetail = $this->Post_model->report_abouse_detail($user_id);
        $resultlist = $this->Post_model->report_abouse_user_list($user_id);
     

        $data['post_detail'] =  $resultdetail;
        $data['users_list'] =  $resultlist;

        $this->load->view('site_posts_report_detail', $data);
    }

    public function block_unblock_post()
    {
          $blockstatus = $this->uri->segment(3); 
          $post_id = $this->uri->segment(4);
            

          $dataUsers = array(

         'post_status' => $blockstatus, 

         );
 

        $this->db->where('post_id', $post_id);

        $this->db->update('foot_posts', $dataUsers); 

          if($blockstatus=='active') { echo "<a href=\"javascript:;\" onclick=\"block_unblock_post('$post_id','block')\" class=\"btn pull-right green  btn-default btn-sm\">Block Footshot</a>"; }   
          
          if($blockstatus=='block') { echo "<a href=\"javascript:;\" onclick=\"block_unblock_post('$post_id','active')\" class=\"btn pull-right red  btn-default btn-sm\">Active Footshot</a>"; } 
    }


  public function block_unblock_abuse_post()
    {
          $blockstatus = $this->uri->segment(3); 
          $post_id = $this->uri->segment(4);
            

          $dataUsers = array(

         'post_status' => $blockstatus, 

         );
 

        $this->db->where('post_id', $post_id);

        $this->db->update('foot_posts', $dataUsers); 

          if($blockstatus=='block') { echo "<a href=\"javascript:;\" onclick=\"block_unblock_post_abuse('$post_id','active')\" class=\"btn btn-xs btn-danger\">Blocked</a>"; }   
          
          if($blockstatus=='active') { echo "<a href=\"javascript:;\" onclick=\"block_unblock_post_abuse('$post_id','block')\" class=\"btn btn-xs btn-success\">Active</a>"; } 
    }


     
    
    /*End of function*/

 
		/*End of Function*/

}
/*End of class*/