<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hashtags extends CI_Controller { /**
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
		$data['breadcum'] = array("posts/" => 'Posts');		 
        $data['title'] = 'Investor Searcher || Posts';
        $data['pageno'] = $pageno;
         $result = $this->Post_model->ajax_hash_list_items();

         $data['tags_list'] =  $result;
 
         $data['posturl'] =  base_url().'hashtags/ajax_list_items';

        $this->load->view('site_hashtags', $data);
    }
	
	/*End of function*/



/*public function list_items($pageno=1)
    { 
     $response=$this->all_tags_list->all_tags_list();
        $data['result']=$response;
  $data['title'] = "Counties List";
        $data['pageno'] = $pageno;
  $data['page']= 'counties/counties_list';
  $data['breadcum'] = array("admin/dashboard/" => 'Dashboard', '' => 'Counties List');
  $this->load->view('layout', $data);
 }*/
 
 public function ajax_list_items()
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
            $response=$this->Post_model->ajax_hash_list_items($search,$per_page,$start);
            $data['result']=$response;
             $data['pperpage']=$start+1;
            $views= 'hashtags_ajax_list_items';
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


 
}
/*End of class*/