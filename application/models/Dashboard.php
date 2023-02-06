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
		$data['breadcum'] = array("dashboard/" => 'Dashboard');		 
        $data['title'] = 'Investor Searcher || Dashboard';
        $data['total_users'] =  $this->User_model->total_users();
        $data['total_foots'] =   $this->Post_model->total_post(); 


        /*Charts Date*/
        $footsChart = array();
        $usersChart = array();

            for ($i = 1; $i <= 12; $i++)
            {
                    $monthYear = date('Y').'-'.$i;
                 $usersChart[] = $this->User_model->total_users_month_year($monthYear);
                 $footsChart[] = $this->Post_model->total_post_month_year($monthYear);
                 
            }

        $data['total_users'] =  $usersChart;
        $data['total_foots'] =   $footsChart;


        $this->load->view('site_dashboard', $data);
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