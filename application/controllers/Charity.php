<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Charity extends CI_Controller { /**
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
       

    if(isset($_POST['donationpoint']) && isset($_POST['donationbutton']) )
      {

         $dataUsers = array(

         'donationpoint' => $_POST['donationpoint']
         );

        $this->db->where('id', "1");

        $this->db->update('foot_admin', $dataUsers); 

      }

    if(isset($_POST['user_id']) && isset($_POST['donationbuttonapprove']) )
      {
           $user_id = $_POST['user_id'];

         $request_id = $_POST['request_id'];

         $post_content = $_POST['post_content'];


         if(isset($_FILES['post_file']['name']) && !empty($_FILES['post_file']['name'])) 
        {
          $this->load->library('upload');
          $folderName = './postimageupload/'.$user_id;
          if(!is_dir($folderName)) 
          {
            mkdir($folderName,0777, true);
          }
          $icon_image         = time().$_FILES['post_file']['name'];
          $config['upload_path']    =   $folderName;
          $config['file_name']    =   $icon_image; 
          $config['allowed_types']  =   '*';
          $config['min_width']        =   45;
          $config['min_height']       =   45;
          $this->upload->initialize($config);
          $this->load->library('upload', $config);
          if ( ! $this->upload->do_upload('post_file'))
          {
            $res['error_msg']   = $this->upload->display_errors();
            $res['status'] = 'error';
            return $res;  
          }
          else
          {
            $savedata['image']        = $icon_image;
            $savedata['image_path']     =   'postimageupload/'.$user_id.'/'.$savedata['image'];
          }
        }

         $totalff = $this->db->query("select * from foot_posts where user_id='108'");

        $totalfootshots = $totalff->num_rows();

       /* $data = getimagesize('postimageupload/'.$user_id.$savedata['image']);
        $width = $data[0];
        $height = $data[1];*/

             $datas = array(                                                      /*An array of data to insert into table*/
                          

             'user_id' => "108",
             'post_caption' => $post_content,
             'post_image_url' => 'postimageupload/'.$user_id.'/'.$savedata['image'],
             'pic_height' => 200,
             'pic_width' => 200,
             'address' => "",
             'fulladdress' => "",
             'postal_code' => "",
             'city' => "",
             'state' => "",
             'country' => "",
             'lat' => "",
             'lng' => "",
             'is_private' =>"0",
             'post_number' => $totalfootshots+1,
             'post_status' => "active",
             'date_of_creation' => date('Y-m-d H:i:s'),
         

             ); 
           
            $this->db->insert('foot_posts', $datas); 


            $new_post_id = $this->db->insert_id();

                  $datasPeople = array(  

                 'user_id' => $user_id,
                 'x_point' => "100",
                 'y_point' => "100",
                 'post_id' => $new_post_id,
                 'tag_status' => "active",
                 'date_of_creation' => date('Y-m-d H:i:s')            

                 ); 
               
                $this->db->insert('foot_posts_people_tags', $datasPeople);

                 $dataUsers = array(

                 'redeem_request' => "1",
                 'timeline_id' => $new_post_id,
                 );

                $this->db->where('redeem_id', $request_id);

                $this->db->update('foot_user_redeem', $dataUsers); 

      }

		    $data['breadcum'] = array("chairty/" => 'Charity');		 
        $data['title'] = 'Investor Searcher || Charity';
        $data['pageno'] = $pageno;
          $result = $this->User_model->ajax_list_items();


          $data['tags_list'] =  $result;

        $redem =  $this->User_model->admin_total_points_donated();

        $data['posturl'] =  base_url().'charity/ajax_list_items';
        $data['total_points'] =   $this->User_model->admin_total_points();
        $data['total_points_donated'] =  $redem->total_redeem;
        $data['total_slippers'] = $redem->total_sliper;


         

        $this->load->view('site_chairty', $data);
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
            $response=$this->User_model->ajax_list_items($search,$per_page,$start);
            
            $data['result']=$response;
            $views= 'chairty_ajax_list_items';
            $count=$response['count'];
            $data['start'] = $start;
            $data['cur_page'] = $cur_page;
            $data['no_of_paginations'] = ceil($count / $per_page);
            $data['previous_btn'] = $previous_btn;
            $data['next_btn'] = $next_btn;
            $data['first_btn'] = $first_btn;
            $data['last_btn'] = $last_btn;
              $this->db->select('*');

          $this->db->from('foot_admin');

          $where = "id='1'";

          $this->db->where($where);

          $query = $this->db->get();

          $resultdoante = $query->row();

        $data['donationpoint'] =   $resultdoante->donationpoint;
            
   ajax_layout($views,$data);
        }
    }


 
}
/*End of class*/