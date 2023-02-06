<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adds extends CI_Controller { /**
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

    public function list_ads()
	{		 

		$data['breadcum'] = array("dashboard/" => 'Dashboard');		 
        $data['title'] = 'Investor Searcher || Sponsor';
        
          $this->db->select('foot_posts.*,foot_adds_links.*,foot_app_users.fullname');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  

          $this->db->join('foot_app_users',"foot_posts.user_id = foot_app_users.user_id");  
           
           $where = "  post_type='addv' and foot_posts.post_status='active' and foot_adds_links.status_of_add='pending' ";
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");
       
          $query = $this->db->get(); 
          $resultAdv = $query->result();

           $data['total_advs'] =$resultAdv;
          $result = $query->result();
        
          $content = array();
          foreach ($result as  $value) {
               $value->liveads = 5;
               $value->published = 15;
               $content[] = $value;
          } 

          $data['allsponose'] = $content;
          

        $this->load->view('site_all_adds', $data);
    }

    public function list_hide_ads()
  {    

    $data['breadcum'] = array("dashboard/" => 'Dashboard');    
        $data['title'] = 'Investor Searcher || Sponsor';
        
          $this->db->select('foot_posts.*,foot_adds_links.*,foot_app_users.fullname,hiduser.user_id as hide_user_id,hiduser.fullname as hide_username');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  

          $this->db->join('foot_hide_post',"foot_hide_post.post_id = foot_posts.post_id");  

          $this->db->join('foot_app_users',"foot_posts.user_id = foot_app_users.user_id");  
          $this->db->join('foot_app_users as hiduser',"foot_hide_post.user_id = hiduser.user_id");  
           
           $where = "  post_type='addv' and hide_type='hide' and post_status='active'   ";
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");
       
          $query = $this->db->get(); 
           
          $resultAdv = $query->result();

           $data['total_advs'] =$resultAdv;
          $result = $query->result();
        
          $content = array();
          foreach ($result as  $value) {
               $value->liveads = 5;
               $value->published = 15;
               $content[] = $value;
          } 

          $data['allsponose'] = $content;
          

        $this->load->view('site_hide_adds', $data);
    }   

    public function list_report_ads()
  {    

    $data['breadcum'] = array("dashboard/" => 'Dashboard');    
        $data['title'] = 'Investor Searcher || Sponsor';
        
          $this->db->select('foot_posts.*,foot_adds_links.*,foot_app_users.fullname,hiduser.user_id as hide_user_id,hiduser.fullname as hide_username');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  

          $this->db->join('foot_hide_post',"foot_hide_post.post_id = foot_posts.post_id");  

          $this->db->join('foot_app_users',"foot_posts.user_id = foot_app_users.user_id");  
          // $this->db->join('foot_app_users',"foot_posts.user_id = foot_app_users.user_id");  

          $this->db->join('foot_app_users as hiduser',"foot_hide_post.user_id = hiduser.user_id");  

           $where = "  post_type='addv' and hide_type='report' and post_status='active'  ";
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");
       
          $query = $this->db->get(); 
          $resultAdv = $query->result();

           $data['total_advs'] =$resultAdv;
          $result = $query->result();
        
          $content = array();
          foreach ($result as  $value) {
               $value->liveads = 5;
               $value->published = 15;
               $content[] = $value;
          } 

          $data['allsponose'] = $content;
          

        $this->load->view('site_report_adds', $data);
    }
	
	/*End of function*/

      public function create_add()
    {         
       $data['breadcum'] = array("createsponsor/" => 'Create Ad');    
        $data['title'] = 'Investor Searcher || Create Ad';

        $this->load->view('site_create_adds',$data);
    }
    public function save_add()
    {   

      $add_description=$this->input->post('add_description');
      $optionsRadios=$this->input->post('optionsRadios');
      $overlay_text=$this->input->post('overlay_text');
      $addv_url=$this->input->post('addv_url');
      $user_id=$this->input->post('user_id');

         $this->load->library('form_validation');
         $this->form_validation->set_rules('add_description', 'add_description', 'required'); 
         $this->form_validation->set_rules('optionsRadios', 'optionsRadios', 'required'); 
         $this->form_validation->set_rules('overlay_text', 'overlay_text', 'required'); 
         $this->form_validation->set_rules('addv_url', 'addv_url', 'required');  


      $media_type =  $optionsRadios;
      $user_id =  $user_id;

      $postimage =  "";
    

      $post_caption =  $add_description;

      $location_address =  "";

      $location_latitude =   "";

      $location_longitude =   "";
      

      $postal_code =  "";
 


      $country =   "";

      $state =  "";

      $city =   "";

      $fulladdress =   "";
      $is_private =  "0";

      $country_id="";
     $pic_height=  "";

         $pic_width="";
         $postimage="";
 

         if($media_type=='image')
         {

          if(isset($_FILES['imageFile']['name']))            /*check image is not there*/

            {                     

                  $allowed =  array('jpeg' ,'jpg');
                    $filename = $_FILES['imageFile']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!in_array($ext,$allowed) ) 
                    {

                        $datas['error'] = "1";
                       $datas['error_value'] = "Only jpeg file is allowed.";
                        
                         $this->load->view('site_create_adds',$datas); 
                         return false;  
                    }


              $ids = rand(1,100);

              $dir_path="postimageupload/".$user_id;

              @mkdir($dir_path);

              $img_name_array= $_FILES['imageFile']['name'];

                //$img_ext=end($img_name_array);

              $time = time().'.jpg';

              $selfie=$ids.'_'.$time;

              $upload_path=$dir_path.'/'.$selfie;
     
              $postimage = $upload_path;
              $thumbnail = $upload_path;
               // file_put_contents($upload_path, file_get_contents($_FILES['imageFile']['tmp_name']));        /*Save the file on the server */
                 if(move_uploaded_file($_FILES['imageFile']['tmp_name'],$upload_path))
                {
                  $value = 1;
                }
                 list($width,$height) =   getimagesize($upload_path); 
     
               $pic_height=  $height;

               $pic_width= $width;
     

            }
        }
        if($media_type=='video')
         {

          if(isset($_FILES['imageFile']['name']))                           

            {                                                                                     
                  $allowed =  array('mp4');
                    $filename = $_FILES['imageFile']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!in_array($ext,$allowed) ) 
                    {

                        $datas['error'] = "1";
                       $datas['error_value'] = "Only mp4 file is allowed.";
                        
                         $this->load->view('site_create_adds',$datas); 
                         return false;  
                    }

              $ids = rand(1,100);

              $dir_path="postimageupload/".$user_id;

              @mkdir($dir_path);

              $img_name_array= $_FILES['imageFile']['name'];
              $uploadfile = $_FILES['imageFile']['tmp_name'];

                //$img_ext=end($img_name_array);

              $time = time().'.mp4';

              $selfie=$ids.'_'.$time;

              $upload_path=$dir_path.'/'.$selfie;
     
              $postimage = $upload_path;

                if(move_uploaded_file($_FILES['imageFile']['tmp_name'],$upload_path))
                {
                  $value = 1;
               
                //file_put_contents($upload_path, file_get_contents($_FILES['imageFile']['tmp_name']));        /*Save the file on the server */
                  // exec('ffmpeg -i '.$uploadfile.' -f mp4 -s 320x240 '.$upload_path.'');
                   //exec('ffmpeg -i '.$upload_path.' -vcodec h264 -acodec aac ne_'.$upload_path);

                  
                    $thumbnail = $dir_path.'/'.time().'_thumbnail.jpg';
                    $output = $dir_path.'/'.time().'compress_output.mp4';

                   $bitrate = "1200k";

                   shell_exec("ffmpeg -i $upload_path -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
                   shell_exec("ffmpeg -i $upload_path -b:v $bitrate -bufsize $bitrate $output");
                   $postimage = $output;



                 }
     

            }
        }

      if($value==1)
      {
        $datas = array(                                                      /*An array of data to insert into table*/
                              

         'user_id' => $user_id,
         'post_caption' => $post_caption,
         'post_image_url' => $postimage,
         'pic_height' => $pic_height,
         'pic_width' => $pic_width,
         'address' => $location_address,
         'fulladdress' => $fulladdress,
         'postal_code' => $postal_code,
         'city' => $city,
         'state' => $state,
         'country' => $country_id,
         'lat' => $location_latitude,
         'lng' => $location_longitude,
         'is_private' => $is_private,
         'post_number' => 0,
         'post_status' => "active",
         'media_type' => $media_type,
         'post_type' => "addv",
         'date_of_creation' => date('Y-m-d H:i:s'),
     

         ); 
       
        $this->db->insert('foot_posts', $datas);  
        
        $post_id = $this->db->insert_id();

        $dataurl= array('url_post_id'=>$post_id,'title'=>$overlay_text,'adv_url'=>$addv_url,'status_of_add'=>"pending",'thumbnail_image'=>$thumbnail);

        $this->db->insert('foot_adds_links', $dataurl);  
       
                
                       /*return data of user to the controller which call this function  */ 
 
      }
      //echo "Upload Succesfully";
       $json = array();
      echo json_encode($json);

    }
        public function my_add()
    {      

       $data['breadcum'] = array("createsponsor/" => 'My Ads');    
        $data['title'] = 'Investor Searcher || My Ads';
        $sedatas=$this->session->all_userdata();
        $userid = $sedatas['userinfo']->app_user_id;

          $this->db->select('foot_posts.*,foot_adds_links.*');

          $this->db->from('foot_posts');

          $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  
          
          $where = "foot_posts.user_id='$userid' and post_type='addv' and post_status='active'";
       
          $this->db->where($where); 

          $this->db->order_by("foot_posts.post_id", "desc");

          $query = $this->db->get(); 
          $result = $query->result();
         

          $data['allsponose'] = $result;

        $this->load->view('site_my_adds',$data);
    } 

      public function approveadd()
    {
          $frequency_of_ads = $this->uri->segment(4); 

          if($frequency_of_ads=='daily')
          {
            $day=0;
          }
           else if($frequency_of_ads=='once_in_month')
          {
            $day=rand(1,28);
          }
          else if($frequency_of_ads=='once_in_week')
          {
            $weekday = array(); // Create Array
            $weekday['1'] = 'Sunday';
            $weekday['2'] = 'Monday';
            $weekday['3'] = 'Tuesday';
            $weekday['4'] = 'Wednesday';
            $weekday['5'] = 'Thursday';
            $weekday['6'] = 'Friday';
            $weekday['7'] = 'Saturday';

              $wwday=rand(1,7);
              $day = $weekday[$wwday];
          }
          

          $post_id = $this->uri->segment(3);
            

          $dataUsers = array(

         'status_of_add' => "approved", 
         'day' => $day, 
         'date_of_frequency' => $frequency_of_ads, 
         'date_of_approval' => date('Y-m-d H:i:s'),

         );
 

        $this->db->where('url_post_id', $post_id);

        $this->db->update('foot_adds_links', $dataUsers); 
        
        return true;
    } 
    public function rejectadd()
    {
          $frequency_of_ads = $this->uri->segment(4); 
          $post_id = $this->uri->segment(3);
            

          $dataUsers = array(

         'status_of_add' => "rejected", 

         );
 

        $this->db->where('url_post_id', $post_id);

        $this->db->update('foot_adds_links', $dataUsers); 
        
        return true;
    }

    public function my_add_detail()
    {      

       $data['breadcum'] = array("createsponsor/" => 'My Ads');    
        $data['title'] = 'Investor Searcher || My Ads';
        $sedatas=$this->session->all_userdata();
        $userid = $sedatas['userinfo']->app_user_id;
        $uri = $this->uri->segment(3);

        $this->db->select('foot_posts.*,foot_adds_links.*');

        $this->db->from('foot_posts');

        $this->db->join('foot_adds_links',"foot_adds_links.url_post_id = foot_posts.post_id");  
        
        $where = " foot_posts.post_id='$uri'";
     
        $this->db->where($where); 
 

        $query = $this->db->get(); 
        $result = $query->row();
         

          $data['value'] = $result;

        $this->load->view('site_detail_adds',$data);
    }

    public function my_userall_detail()
    {      

  

        $this->db->select('foot_app_users.*');

        $this->db->from('foot_app_users');
 
        
        $where = " user_type='user' and status='Active'";
     
        $this->db->where($where); 
 

        $query = $this->db->get(); 
        $result = $query->result();
         
      $user_data = array();
   
        foreach($result as $key => $val)
        {
          $user_data[$key]['id'] = $val->user_id;
          $user_data[$key]['name'] = '@'.$val->username;
          $user_data[$key]['avatar'] = "https://cdn.w3lessons.info/logo.png";
          $user_data[$key]['type'] = 'user';
        }

        header('Content-Type: application/json');
        echo json_encode($user_data);
    }
        
         


}
/*End of class*/