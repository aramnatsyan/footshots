<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller { /**
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

    public function index()
    {       
        $data['breadcum'] = array("posts/" => 'Posts');      
        $data['title'] = 'Investor Searcher || Posts';
         $result = $this->Post_model->all_posts_list();

         $data['post_list'] =  $result;
        $this->load->view('site_posts', $data);
    }

    public function monthsfoots()
	{		
		$data['breadcum'] = array("posts/" => 'Footshots of the month');		 
        $data['title'] = 'Posts';
         $result = $this->Post_model->month_posts_list();

         $data['post_list'] =  $result;
        $this->load->view('site_footshotsmonth', $data);
    }
	

    public function deletepost()
    {       
            $post_id = $this->uri->segment(3); 
            $result = $this->Post_model->delete_post($post_id);

            return array("content"=>"removed");

    }


    public function hastagposts()
    {       
        $data['breadcum'] = array("posts/" => 'Posts');      
        $data['title'] = ' Posts';
        $tag_id = $this->uri->segment(3); 
         $result = $this->User_model->single_users_detail($tag_id);
        $resultPost = $this->Post_model->all_hash_posts_list($tag_id);
        $totalearning = $this->User_model->total_earned_points($tag_id);

        $redeempoint = $this->User_model->total_redeem_points($tag_id);

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
        $this->load->view('site_hastag_post_detail', $data);
    }


    public function productposts()
    {       
        $data['breadcum'] = array("posts/" => 'Posts');      
        $data['title'] = ' Posts';
        $tag_id = $this->uri->segment(3); 
         $result = $this->User_model->single_users_detail($tag_id);
        $resultPost = $this->Post_model->all_product_posts_list($tag_id);
        $totalearning = $this->User_model->total_earned_points($tag_id);

        $redeempoint = $this->User_model->total_redeem_points($tag_id);

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
        $this->load->view('site_product_post_detail', $data);
    }
    
	/*End of function*/


 
}
/*End of class*/