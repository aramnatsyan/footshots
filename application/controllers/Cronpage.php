<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cronpage extends CI_Controller { /**
     * Constructor
     */ 
    function __construct() {
		parent::__construct();
        //is_protected();
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

        $currentdate = date("Y-m-d");
        $currentmonth = date("Y-m");
        $last_month =   date("Y-m",strtotime("- 1 month",strtotime($currentdate)));
        $last_monthtoshow =   date("M, Y",strtotime("- 1 month",strtotime($currentdate)));

          $querymonth = $this->db->query("SELECT foot_of_month.* from foot_of_month where DATE_FORMAT(date_of_post,'%Y-%m')='$currentmonth'");

        
        $resultmonth = $querymonth->row();

        if(empty($resultmonth))
        {


        $query = $this->db->query("SELECT foot_posts.*,(SELECT COUNT(*) FROM  foot_likes where foot_likes.post_id=foot_posts.post_id and like_status='active' and like_type='post') as total_like FROM foot_posts where post_status='active' and DATE_FORMAT(date_of_creation,'%Y-%m')='$last_month' and user_id in (SELECT user_id FROM foot_app_users WHERE  fullname not LIKE '%Arduca%') AND user_id!=108  order by total_like desc, foot_posts.post_id desc limit 0,1");

        
        $result = $query->row();

        $post_id = $result->post_id;
        $user_id = $result->user_id;

        $totalff = $this->db->query("select * from foot_posts where user_id='108'");

        $totalfootshots = $totalff->num_rows();

        $userdetail = $this->db->query("select * from foot_app_users where user_id='".$user_id."'");

        $usersingledetail = $userdetail->row();

    $datas = array(                                                   /*An array of data to insert into table*/
                          

     'user_id' => "108",
  /*   'post_caption' => "Footshot of the month ".$last_monthtoshow." with ".$result->total_like." foot likes.\n".$result->post_caption,*/
     //'post_caption'=> 'Congratulations '.$usersingledetail->fullname.'!!! Your post has been selected for Footshot of the month '.$last_monthtoshow.' with '.$result->total_like.' foot likes.', Removed as discussed with Roy sir on 03oct 2009
     'post_caption'=> 'Congratulations '.$usersingledetail->fullname.'!!! Your post has been selected for Footshot of the month '.$last_monthtoshow.'.',
     'post_image_url' => $result->post_image_url,
     'pic_height' => $result->pic_height,
     'pic_width' => $result->pic_width,
     'address' => $result->address,
     'fulladdress' => $result->fulladdress,
     'postal_code' => $result->postal_code,
     'city' => $result->city,
     'state' => $result->state,
     'country' => $result->country,
     'lat' => $result->lat,
     'lng' => $result->lng,
     'is_private' => "0",
     'post_number' => $totalfootshots+1,
     'post_status' => "active",
    'date_of_creation' => date('Y-m-d H:i:s',strtotime("- 1 month",strtotime(date('Y-m-d H:i:s'))))
    
     //'date_of_creation' => date('Y-m-d H:i:s'), // as discussed with bhubnesh need to remove this. Now it'll show last month like if created on Feb 1 then it'll show Jan 2020 at both places i.e blue line and description. Dated; 02-01-2020
 

     ); 
   
    $this->db->insert('foot_posts', $datas);  

    $new_post_id = $this->db->insert_id();

     $datas = array(                                                  /*An array of data to insert into table*/
                          

     'user_id' => $result->user_id,
     'post_id' => $result->post_id,
     'new_post_id' => $new_post_id,
     'date_of_post' => date('Y-m-d H:i:s')   

     ); 
   
    $this->db->insert('foot_of_month', $datas);


         $query = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$post_id'");

         $hasresultresult = $query->result();

         foreach ($hasresultresult as $key => $value) {
            
                $datatag = array(                                                      /*An array of data to insert into table*/

                 'post_id' => $new_post_id,

                 'tag_id' => $value->tag_id,  

                 'hashstatus' => 'active',      

                 'date_of_creation'=> date('Y-m-d H:i:s') 

                 ); 

                $this->db->insert('foot_post_tag', $datatag);
            
         }  

          $query = $this->db->query("SELECT * FROM foot_likes WHERE post_id = '$post_id' AND like_type='post' AND like_status='active'");

         $liketresult = $query->result();


          foreach ($liketresult as $valueslike) {           
                $datataglike = array(
                 'post_id' => $new_post_id,
                 'user_id' => $valueslike->user_id,  
                 'like_status' => 'active',      
                 'like_type' => 'post',      
                 'date_of_creation'=> date('Y-m-d H:i:s') 
                 ); 
                $this->db->insert('foot_likes', $datataglike);            
         }   

              $NotificationUserDetail = $this->User_model->single_users_detail($user_id);

              $device_type =  $NotificationUserDetail->device_type;
              $device_token =  $NotificationUserDetail->device_token;
                $message =  "Your footshot has been selected as a footshot of the month."; 
                 $action = "post_detail";
                 $value['user_id'] = "108";
                 $value['other_user_id'] = $new_post_id;
                 $value['other_user_name'] = "Foothshots";

                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$user_id' and read_status='0' and notification_status='active'");

                 $total_unread_notification =  $notificunser->num_rows();

                 $value['total_unread_notification'] =$total_unread_notification;

                 $badge = 1;

             
                       if($device_token!="")
                       {
                         if($device_type=='ios')
                         {
                            send_message_ios($device_token,$message,$badge,$action,$value);
                         }
                         if($device_type=='android')
                         {
                              send_notification_android($device_token,$message,$action,$value);
                         }
                      }



                         $data = array(  

                         'user_id' => $user_id,

                         'from_id' => "108",     

                         'timeline_id' => $new_post_id,

                         'notification_type' =>  "post_month",
                     
                         'read_status' =>'0',

                         'date_of_notification'=> date('Y-m-d H:i:s'), 

                        );

                        $this->db->insert('foot_notification', $data);   

                         
                          
                         $datasPeople = array(  

                         'user_id' => $user_id,
                         'x_point' => "100",
                         'y_point' => "100",
                         'post_id' => $new_post_id,
                         'tag_status' => "active",
                         'date_of_creation' => date('Y-m-d H:i:s')            

                         ); 
                       
                        $this->db->insert('foot_posts_people_tags', $datasPeople);
        }          
                  
    }
}
?>