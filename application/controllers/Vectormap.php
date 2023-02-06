<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vectormap extends CI_Controller { /**
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
		$data['breadcum'] = array("users/" => 'Users');	

       $result = $this->Post_model->vector_data();
       $resulttable = $this->Post_model->vector_table_data();

         $data['vectordata'] = $result;
         $data['vectortabledata'] = $resulttable;

        $this->load->view('site_vectormap', $data);
    }
	
	/*End of function*/


      
    
    /*End of function*/

 
		/*End of Function*/

}
/*End of class*/