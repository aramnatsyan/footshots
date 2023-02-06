<?php 

class Comment_model extends CI_Model {



  public function __construct()

  {

        // Call the Model constructor

    parent::__construct();

    date_default_timezone_set('UTC');

    $this->db->query('SET time_zone="+00:00"');

    $this->load->model('User_model');  
    $this->load->model('Post_model');  

  }

  function decodeEmoticons($src) {
    $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
 

  function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result = $interval->format("%y y"); }
    else  if ($interval->d) { 

      if($interval->d>7 || $interval->days>7)
      {
         $result = $interval->days; 

         $weeks = floor($result / 7);
        //  $dayRemainder = $result % 7;
         $result = $weeks .' w';

      }
      else
      {
         $result = $interval->format("%d d"); 
      }
  
    }
    else  if ($interval->h) { $result = $interval->format("%h h"); }
    else  if ($interval->i) { $result = $interval->format("%i m"); }
    else  if ($interval->s) { $result = $interval->format("%s s"); }

    return $result;
}


    /*Method to generate Random String*/



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

 public function add_comment($data)

  { 
 
 
    $user_id =  $data->user_id;
 
    $comment_text =  $data->comment_text;

    $comment_type =  $data->comment_type;

    $post_id =  $data->post_id;
    $nnpost_id =  $data->post_id;
 


    $datas = array(                                                      /*An array of data to insert into table*/
     
     'user_id' => $user_id,
     'post_id' => $post_id,
     'comment_text' => $comment_text,
     'comment_type' => $comment_type,
     'comment_status' => "active",
     'date_of_creation' => date('Y-m-d H:i:s'),
 

     ); 
   
    $this->db->insert('foot_comments', $datas); 

    $this->db->last_query(); 

     $post_id = $this->db->insert_id();
     $comment_id = $post_id;
     $new_comment_id = $post_id;
   

    if($post_id){ 

      /*point system or comment*/

              if($comment_type=='comment')
              { 
                 
                 
                 $countcommentpost = $this->db->query("SELECT * FROM foot_comments where post_id='$data->post_id' and comment_status='active' and comment_type='comment' ");

                    $totalcommentpost =  $countcommentpost->num_rows();
                  
                
                    $postdetail = $this->db->query("SELECT * FROM foot_posts where post_id='$data->post_id'  ");
                    $postdetailsnew =  $postdetail->row();

                 

                     $pointcommentpost = $this->db->query("SELECT * FROM foot_point_system where point_type='comment'  ");

                    $commentpostpoint =  $pointcommentpost->result();

                  
                   foreach ($commentpostpoint as   $pointsvalue) {
                     
                     

                    $total_value= $pointsvalue->total_value;
                        $total_points= $pointsvalue->total_points;
                      
                     if($totalcommentpost % $total_value == 0) 
                     {  
                            $datae = array(  

                                 'user_id' => $postdetailsnew->user_id,

                                 'post_id' => $data->post_id,     

                                 'total_points' => $total_points,
                                 'sys_id' =>   $pointsvalue->sys_id,                              
                                
                                 'point_for' =>   "comment",                              

                                 'date_of_point'=> date('Y-m-d H:i:s'), 

                                );
                           

                          $this->db->insert('foot_user_points', $datae);

                            $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where user_id='.$postdetailsnew->user_id;
                          $this->db->query($sql);


                            

                            $this->db->select('*');

                            $this->db->from('foot_app_users');

                            $where = "user_id='".$postdetailsnew->user_id."'";

                            $this->db->where($where);

                            $query = $this->db->get();

                            $resultpoint = $query->row();

                            $device_token =  $resultpoint->device_token;
                            $device_type =  $resultpoint->device_type;

                            $value['user_id'] = $user_id;
                            $value['other_user_id'] = $data->post_id;
                            $value['other_user_name'] = "Footshots";
                            $action = "donationdetail";
                            $message = $this->decodeEmoticons("You have earned ".$pointsvalue->total_points.' points');
                            $badge = $resultpoint->badge+1;

                             $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$resultpoint->user_id;

                          $this->db->query($sql);


                            $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$postdetailsnew->user_id' and read_status='0' and notification_status='active'");
                           $total_unread_notification =  $notificunser->num_rows();
                           $value['total_unread_notification'] =$total_unread_notification;

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

                     }




                      $countlikepostmy = $this->db->query("SELECT * FROM foot_comments where user_id='$user_id'  and comment_status='active' and comment_type='comment' ");
                    $totallikepostmy =  $countlikepostmy->num_rows();



                         if($totallikepostmy % $total_value == 0) 
                     { 

                           $datae = array(  

                                 'user_id' => $user_id,

                                 'post_id' => $data->post_id,     

                                 'total_points' => $total_points,

                                 'sys_id' =>   $pointsvalue->sys_id,                              
                                
                                 'point_for' =>   "comment",                              

                                 'date_of_point'=> date('Y-m-d H:i:s'), 

                                );

                                $this->db->insert('foot_user_points', $datae);

                          $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where user_id='.$user_id;

                          $this->db->query($sql);
                      }

                       

                   
                   }
            
           

      
       $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_id= '$post_id' and comment_type='$comment_type'";
     
        $this->db->where($where);
        $this->db->order_by("comment_id", "desc");
       


        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result(); 

        $value = array_shift($resultPosts);


         $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;



              $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

           $difference = $first_date->diff($second_date);

        $difference = $this->format_interval($difference);
          $value->date_dfference = "Just Now";

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;


             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             $value->total_reply = $comments;

                 $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;


             $NotificationUserDetail = $this->Post_model->timeline_user_detail($data->post_id);
 
           
              $myUserDetail = $this->User_model->single_users_detail($user_id);

             $device_type =  $NotificationUserDetail->device_type;
             $device_token =  $NotificationUserDetail->device_token;

            $message = $this->decodeEmoticons($myUserDetail->fullname." commented on your footshot.");

             


             $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$NotificationUserDetail->user_id' and read_status='0' and notification_status='active'");
             $total_unread_notification =  $notificunser->num_rows();
              $value->total_unread_notification =$total_unread_notification;

              $action = "post_comment_detail";
             $value->user_id = $user_id;
             $value->other_user_id = $data->post_id;
             $value->other_user_name = $NotificationUserDetail->fullname;
             $value->comment_id = intval($new_comment_id);
             
             $badge = $NotificationUserDetail->badge+1;
              $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;

                $this->db->query($sql);

             if($NotificationUserDetail->user_id!=$user_id)
             {
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

                     'user_id' => $NotificationUserDetail->user_id,

                     'from_id' => $user_id,     

                     'timeline_id' => $data->post_id,
                     
                     'comment_id' => $new_comment_id,

                     'notification_type' =>  "add_foot_comment",
                 
                     'read_status' =>'0',

                     'date_of_notification'=> date('Y-m-d H:i:s'), 

                    );


                    $this->db->insert('foot_notification', $data);  
                  }


                  preg_match_all('/(?<!\w)#\w+/',$comment_text,$matches);
 
           foreach ($matches[0] as   $values) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$values' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $values,     

                 'password' => "",

                 'profileimage' => "",
             
                 'status' =>'Active',

                 'user_type' =>'tag',

                 'date_of_creation'=> date('Y-m-d H:i:s'), 

                  'login_token' => "tags",

                  'device_type'=> '',

                  'device_token' => '' 

                 ); 

                $this->db->insert('foot_app_users', $datahash);                             /* insert data into table*/  
                $tag_id = $this->db->insert_id();                               /* Get insert id*/
              }

               $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$nnpost_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                   $datatag = array(                                                  

                   'post_id' =>$nnpost_id,

                   'tag_id' => $tag_id,      

                   'date_of_creation'=> date('Y-m-d H:i:s') 

                   ); 

                  $this->db->insert('foot_post_tag', $datatag);
              }


           }

            $value->comment_id = strval($value->comment_id);
  
      return  $value;                                                 /*return data of user to the controller which call this function  */     
        }
        else if($comment_type=='reply')
        {

                 
                 
                 $countcommentpost = $this->db->query("SELECT * FROM foot_comments where post_id='$data->post_id' and comment_status='active' and comment_type='comment' ");

                    $totalcommentpost =  $countcommentpost->num_rows();
                  
                
                    $postdetail = $this->db->query("SELECT * FROM foot_comments where comment_id='$data->post_id'  ");
                    $postdetailsnew =  $postdetail->row();

                  
           

      
             $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

              $this->db->from('foot_comments'); 
              $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


              $where = "comment_id= '$post_id' and comment_type='$comment_type'";
           
              $this->db->where($where);
              $this->db->order_by("comment_id", "desc");
             


              $query = $this->db->get();      

              $re = array();

              $resultPosts = $query->result(); 

              $value = array_shift($resultPosts);


               $comment_user_id = $value->user_id;
       
                  $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                        
                  $value->user_detail = $resultuser;



                    $current_date = date('Y-m-d H:i:s'); 

                $first_date = new DateTime($value->date_of_creation);
                $second_date = new DateTime($current_date);

                 $difference = $first_date->diff($second_date);

              $difference = $this->format_interval($difference);
                $value->date_dfference = "Just Now";

                   $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
                  $foots =  $queryFoots->num_rows();
                   $value->total_foots =$foots;


                   $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
                  $comments =  $queryComments->num_rows();


                   $value->total_reply = $comments;

                       $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
                 $footsYou =  $queryFootsyou->num_rows();


                 $value->you_like =$footsYou;

       
                $queryFootsyou = $this->db->query("SELECT foot_app_users.* FROM foot_comments join foot_app_users on foot_app_users.user_id=foot_comments.user_id where comment_id='$data->post_id' ");
               
                $NotificationUserDetail =  $queryFootsyou->row();

                      
                       
                          $myUserDetail = $this->User_model->single_users_detail($user_id);

                         $device_type =  $NotificationUserDetail->device_type;
                         $device_token =  $NotificationUserDetail->device_token;

                        $message = $this->decodeEmoticons($myUserDetail->fullname." replied on your footshot comment.");

                         $NotificationUserDetailcmg = $this->Comment_model->single_comment($data->post_id,$user_id);
                         


                         $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$NotificationUserDetail->user_id' and read_status='0' and notification_status='active'");
                         $total_unread_notification =  $notificunser->num_rows();
                          $value->total_unread_notification =$total_unread_notification;

                          $action = "post_reply_detail";
                         $value->user_id = $user_id;
                         $value->other_user_id = $data->post_id;
                         $value->other_user_name = $NotificationUserDetail->fullname;
                         $value->comment_id = intval($new_comment_id);
                        // $value->comment_detail = $NotificationUserDetailcmg;
                         
                         $badge = $NotificationUserDetail->badge+1;
                          $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;

                            $this->db->query($sql);

 
                         if($NotificationUserDetail->user_id!=$user_id)
                         {
                           if($device_token!="")
                           {
                             if($device_type=='ios')
                             {

                                send_message_ios($device_token,$message,$badge,$action,$value);

                             }
                             if($device_type=='android')
                             {
                              $value->comment_detail = $NotificationUserDetailcmg;
                                  send_notification_android($device_token,$message,$action,$value);
                             }
                           }
                           

                     $data = array(  

                     'user_id' => $NotificationUserDetail->user_id,

                     'from_id' => $user_id,     

                     'timeline_id' => $data->post_id,
                     
                     'comment_id' => $new_comment_id,

                     'notification_type' =>  "add_foot_reply",
                 
                     'read_status' =>'0',

                     'date_of_notification'=> date('Y-m-d H:i:s'), 

                    );


                    $this->db->insert('foot_notification', $data);  
                  }
                  $value->comment_detail = $NotificationUserDetailcmg;


                  preg_match_all('/(?<!\w)#\w+/',$comment_text,$matches);
 
           foreach ($matches[0] as   $values) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$values' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $values,     

                 'password' => "",

                 'profileimage' => "",
             
                 'status' =>'Active',

                 'user_type' =>'tag',

                 'date_of_creation'=> date('Y-m-d H:i:s'), 

                  'login_token' => "tags",

                  'device_type'=> '',

                  'device_token' => '' 

                 ); 

                $this->db->insert('foot_app_users', $datahash);                             /* insert data into table*/  
                $tag_id = $this->db->insert_id();                               /* Get insert id*/
              }

               $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$nnpost_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                   $datatag = array(                                                  

                   'post_id' =>$nnpost_id,

                   'tag_id' => $tag_id,      

                   'date_of_creation'=> date('Y-m-d H:i:s') 

                   ); 

                  $this->db->insert('foot_post_tag', $datatag);
              }


           }

            $value->comment_id = strval($value->comment_id);
  
      return  $value;                                                 /*return data of user to the controller which call this function  */     
        
        }


 
    }
    else
    {
      return 300;  
    }



  }

   public function add_new_comment($data)

  { 
 
 
    $user_id =  $data->user_id;
 
    $comment_text =  $data->comment_text;

    $comment_type =  $data->comment_type;

    $post_id =  $data->post_id;
    $nnpost_id =  $data->post_id;
 


    $datas = array(                                                      /*An array of data to insert into table*/
     
     'user_id' => $user_id,
     'post_id' => $post_id,
     'comment_text' => $comment_text,
     'comment_type' => $comment_type,
     'comment_status' => "active",
     'date_of_creation' => date('Y-m-d H:i:s'),
 

     ); 
   
    $this->db->insert('foot_comments', $datas); 

    $this->db->last_query(); 

     $post_id = $this->db->insert_id();
     $comment_id = $post_id;
     $new_comment_id = $post_id;
   

    if($post_id){ 

      /*point system or comment*/

              if($comment_type=='comment')
              { 
                 
                 
                 $countcommentpost = $this->db->query("SELECT * FROM foot_comments where post_id='$data->post_id' and comment_status='active' and comment_type='comment' ");

                    $totalcommentpost =  $countcommentpost->num_rows();
                  
                
                    $postdetail = $this->db->query("SELECT * FROM foot_posts where post_id='$data->post_id'  ");
                    $postdetailsnew =  $postdetail->row();

                 

                     $pointcommentpost = $this->db->query("SELECT * FROM foot_point_system where point_type='comment'  ");

                    $commentpostpoint =  $pointcommentpost->result();

                  
                   foreach ($commentpostpoint as   $pointsvalue) {
                     
                     

                    $total_value= $pointsvalue->total_value;
                        $total_points= $pointsvalue->total_points;
                      
                     if($totalcommentpost % $total_value == 0) 
                     {  
                            $datae = array(  

                                 'user_id' => $postdetailsnew->user_id,

                                 'post_id' => $data->post_id,     

                                 'total_points' => $total_points,
                                 'sys_id' =>   $pointsvalue->sys_id,                              
                                
                                 'point_for' =>   "comment",                              

                                 'date_of_point'=> date('Y-m-d H:i:s'), 

                                );
                           

                          $this->db->insert('foot_user_points', $datae);

                            $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where user_id='.$postdetailsnew->user_id;
                          $this->db->query($sql);


                            

                            $this->db->select('*');

                            $this->db->from('foot_app_users');

                            $where = "user_id='".$postdetailsnew->user_id."'";

                            $this->db->where($where);

                            $query = $this->db->get();

                            $resultpoint = $query->row();

                            $device_token =  $resultpoint->device_token;
                            $device_type =  $resultpoint->device_type;

                            $value['user_id'] = $user_id;
                            $value['other_user_id'] = $data->post_id;
                            $value['other_user_name'] = "Footshots";
                            $action = "donationdetail";
                            $message = $this->decodeEmoticons("You have earned ".$pointsvalue->total_points.' points');
                            $badge = $resultpoint->badge+1;

                             $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$resultpoint->user_id;

                          $this->db->query($sql);


                            $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$postdetailsnew->user_id' and read_status='0' and notification_status='active'");
                           $total_unread_notification =  $notificunser->num_rows();
                           $value['total_unread_notification'] =$total_unread_notification;

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

                     }




                      $countlikepostmy = $this->db->query("SELECT * FROM foot_comments where user_id='$user_id'  and comment_status='active' and comment_type='comment' ");
                    $totallikepostmy =  $countlikepostmy->num_rows();



                         if($totallikepostmy % $total_value == 0) 
                     { 

                           $datae = array(  

                                 'user_id' => $user_id,

                                 'post_id' => $data->post_id,     

                                 'total_points' => $total_points,

                                 'sys_id' =>   $pointsvalue->sys_id,                              
                                
                                 'point_for' =>   "comment",                              

                                 'date_of_point'=> date('Y-m-d H:i:s'), 

                                );

                                $this->db->insert('foot_user_points', $datae);

                          $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where user_id='.$user_id;

                          $this->db->query($sql);
                      }

                       

                   
                   }
            
           

      
       $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_id= '$post_id' and comment_type='$comment_type'";
     
        $this->db->where($where);
        $this->db->order_by("comment_id", "desc");
       


        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result(); 

        $value = array_shift($resultPosts);


         $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;



              $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

           $difference = $first_date->diff($second_date);

        $difference = $this->format_interval($difference);
          $value->date_dfference = "Just Now";

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;


             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             $value->total_reply = $comments;

                 $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;


             $NotificationUserDetail = $this->Post_model->timeline_user_detail($data->post_id);
 
           
              $myUserDetail = $this->User_model->single_users_detail($user_id);

             $device_type =  $NotificationUserDetail->device_type;
             $device_token =  $NotificationUserDetail->device_token;

            $message = $this->decodeEmoticons($myUserDetail->fullname." commented on your footshot.");

             


             $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$NotificationUserDetail->user_id' and read_status='0' and notification_status='active'");
             $total_unread_notification =  $notificunser->num_rows();
              $value->total_unread_notification =$total_unread_notification;

              $action = "post_comment_detail";
             $value->user_id = $user_id;
             $value->other_user_id = $data->post_id;
             $value->other_user_name = $NotificationUserDetail->fullname;
             $value->comment_id = intval($new_comment_id);
             
             $badge = $NotificationUserDetail->badge+1;
              $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;

                $this->db->query($sql);

             if($NotificationUserDetail->user_id!=$user_id)
             {
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



                     $datas = array(  

                     'user_id' => $NotificationUserDetail->user_id,

                     'from_id' => $user_id,     

                     'timeline_id' => $data->post_id,
                     
                     'comment_id' => $new_comment_id,

                     'notification_type' =>  "add_foot_comment",
                 
                     'read_status' =>'0',

                     'date_of_notification'=> date('Y-m-d H:i:s'), 

                    );


                    $this->db->insert('foot_notification', $datas);  
                  }


                  preg_match_all('/(?<!\w)#\w+/',$comment_text,$matches);
 
           foreach ($matches[0] as   $values) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$values' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $values,     

                 'password' => "",

                 'profileimage' => "",
             
                 'status' =>'Active',

                 'user_type' =>'tag',

                 'date_of_creation'=> date('Y-m-d H:i:s'), 

                  'login_token' => "tags",

                  'device_type'=> '',

                  'device_token' => '' 

                 ); 

                $this->db->insert('foot_app_users', $datahash);                             /* insert data into table*/  
                $tag_id = $this->db->insert_id();                               /* Get insert id*/
              }

               $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$nnpost_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                   $datatag = array(                                                  

                   'post_id' =>$nnpost_id,

                   'tag_id' => $tag_id,      

                   'date_of_creation'=> date('Y-m-d H:i:s') 

                   ); 

                  $this->db->insert('foot_post_tag', $datatag);
              }


           }

            $value->comment_id = strval($value->comment_id);


              preg_match_all('/(?<!\w)@\w+/',$comment_text,$matchesUser);
                
 
                 foreach ($matchesUser[0] as   $values) {


                  $values = str_replace("@", "", $values);
                  
                  $NotificationUserDetail = $this->User_model->single_username_detail($values);
                   if (!empty($NotificationUserDetail)) 
                   {
                  $tagUser_id = $NotificationUserDetail->user_id;
               
                  $myUserDetail = $this->User_model->single_users_detail($user_id);

                  $device_type =  $NotificationUserDetail->device_type;
                  $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshots comments.");

                   $action = "post_comment_detail";
                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
               

                 $badge = 1;

         
              $badge = $NotificationUserDetail->badge+1;

               $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                $this->db->query($sql);


                 if($NotificationUserDetail->user_id!=$user_id)
                 {    
                      $value->comment_id = intval($value->comment_id);
 
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



                             $datas = array(  

                             'user_id' => $tagUser_id,

                             'from_id' => $user_id,     

                            'timeline_id' => $data->post_id,
                       
                            'comment_id' => $new_comment_id,

                             'notification_type' =>  "comment_tag",
                         
                             'read_status' =>'0',

                             'date_of_notification'=> date('Y-m-d H:i:s'), 

                            );

                                $this->db->insert('foot_notification', $datas);   
                      }

                    }

                 }
  
      return  $value;                                                 /*return data of user to the controller which call this function  */     
        }
        else if($comment_type=='reply')
        {

                 
                 
                 $countcommentpost = $this->db->query("SELECT * FROM foot_comments where post_id='$data->post_id' and comment_status='active' and comment_type='comment' ");

                    $totalcommentpost =  $countcommentpost->num_rows();
                  
                
                    $postdetail = $this->db->query("SELECT * FROM foot_comments where comment_id='$data->post_id'  ");
                    $postdetailsnew =  $postdetail->row();

                  
           

      
             $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

              $this->db->from('foot_comments'); 
              $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


              $where = "comment_id= '$post_id' and comment_type='$comment_type'";
           
              $this->db->where($where);
              $this->db->order_by("comment_id", "desc");
             


              $query = $this->db->get();      

              $re = array();

              $resultPosts = $query->result(); 

              $value = array_shift($resultPosts);


               $comment_user_id = $value->user_id;
       
                  $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                        
                  $value->user_detail = $resultuser;



                    $current_date = date('Y-m-d H:i:s'); 

                $first_date = new DateTime($value->date_of_creation);
                $second_date = new DateTime($current_date);

                 $difference = $first_date->diff($second_date);

              $difference = $this->format_interval($difference);
                $value->date_dfference = "Just Now";

                   $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
                  $foots =  $queryFoots->num_rows();
                   $value->total_foots =$foots;


                   $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
                  $comments =  $queryComments->num_rows();


                   $value->total_reply = $comments;

                       $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
                 $footsYou =  $queryFootsyou->num_rows();


                 $value->you_like =$footsYou;

       
                $queryFootsyou = $this->db->query("SELECT foot_app_users.* FROM foot_comments join foot_app_users on foot_app_users.user_id=foot_comments.user_id where comment_id='$data->post_id' ");
               
                $NotificationUserDetail =  $queryFootsyou->row();

                      
                       
                          $myUserDetail = $this->User_model->single_users_detail($user_id);

                         $device_type =  $NotificationUserDetail->device_type;
                         $device_token =  $NotificationUserDetail->device_token;

                        $message = $this->decodeEmoticons($myUserDetail->fullname." replied on your footshot comment.");

                         $NotificationUserDetailcmg = $this->Comment_model->single_comment($data->post_id,$user_id);
                         


                         $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$NotificationUserDetail->user_id' and read_status='0' and notification_status='active'");
                         $total_unread_notification =  $notificunser->num_rows();
                          $value->total_unread_notification =$total_unread_notification;

                          $action = "post_reply_detail";
                         $value->user_id = $user_id;
                         $value->other_user_id = $data->post_id;
                         $value->other_user_name = $NotificationUserDetail->fullname;
                         $value->comment_id = intval($new_comment_id);
                        // $value->comment_detail = $NotificationUserDetailcmg;
                         
                         $badge = $NotificationUserDetail->badge+1;
                          $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;

                            $this->db->query($sql);

 
                         if($NotificationUserDetail->user_id!=$user_id)
                         {
                           if($device_token!="")
                           {
                             if($device_type=='ios')
                             {

                                send_message_ios($device_token,$message,$badge,$action,$value);

                             }
                             if($device_type=='android')
                             {
                              $value->comment_detail = $NotificationUserDetailcmg;
                                  send_notification_android($device_token,$message,$action,$value);
                             }
                           }
                           

                     $data = array(  

                     'user_id' => $NotificationUserDetail->user_id,

                     'from_id' => $user_id,     

                     'timeline_id' => $data->post_id,
                     
                     'comment_id' => $new_comment_id,

                     'notification_type' =>  "add_foot_reply",
                 
                     'read_status' =>'0',

                     'date_of_notification'=> date('Y-m-d H:i:s'), 

                    );


                    $this->db->insert('foot_notification', $data);  
                  }
                  $value->comment_detail = $NotificationUserDetailcmg;


                  preg_match_all('/(?<!\w)#\w+/',$comment_text,$matches);
 
           foreach ($matches[0] as   $values) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$values' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $values,     

                 'password' => "",

                 'profileimage' => "",
             
                 'status' =>'Active',

                 'user_type' =>'tag',

                 'date_of_creation'=> date('Y-m-d H:i:s'), 

                  'login_token' => "tags",

                  'device_type'=> '',

                  'device_token' => '' 

                 ); 

                $this->db->insert('foot_app_users', $datahash);                             /* insert data into table*/  
                $tag_id = $this->db->insert_id();                               /* Get insert id*/
              }

               $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$nnpost_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                   $datatag = array(                                                  

                   'post_id' =>$nnpost_id,

                   'tag_id' => $tag_id,      

                   'date_of_creation'=> date('Y-m-d H:i:s') 

                   ); 

                  $this->db->insert('foot_post_tag', $datatag);
              }


           }

            $value->comment_id = strval($value->comment_id);


              preg_match_all('/(?<!\w)@\w+/',$comment_text,$matchesUser);
                
 
                 foreach ($matchesUser[0] as   $values) {



                  $values = str_replace("@", "", $values);
                  
                  $NotificationUserDetail = $this->User_model->single_username_detail($values);
                   if (!empty($NotificationUserDetail)) 
                   {
                  
                  $tagUser_id = $NotificationUserDetail->user_id;
               
                  $myUserDetail = $this->User_model->single_users_detail($user_id);

                  $device_type =  $NotificationUserDetail->device_type;
                  $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshot reply.");

                   $action = "post_reply_detail";
                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
               

                 $badge = 1;

         
              $badge = $NotificationUserDetail->badge+1;

               $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                $this->db->query($sql);


                 if($NotificationUserDetail->user_id!=$data->user_id)
                 {    
              
                  
                      $value->comment_id= intval($value->comment_id);
                           if($device_token!="")
                           {
                             if($device_type=='ios')
                             {
                              $comment_detail=$value->comment_detail;
                              $value->comment_detail="";
                                  send_message_ios($device_token,$message,$badge,$action,$value);
                                  $value->comment_detail = $comment_detail;
                             }
                             if($device_type=='android')
                             {
                                   send_notification_android($device_token,$message,$action,$value);
                             }
                          }



                             $data = array(  

                             'user_id' => $tagUser_id,

                             'from_id' => $user_id,     

                            'timeline_id' => $data->post_id,
                       
                            'comment_id' => $new_comment_id,

                             'notification_type' =>  "reply_tag",
                         
                             'read_status' =>'0',

                             'date_of_notification'=> date('Y-m-d H:i:s'), 

                            );

                                $this->db->insert('foot_notification', $data);   
                      }
                           
                    }
                           
                 }
  
      return  $value;                                                 /*return data of user to the controller which call this function  */     
        
        }


 
    }
    else
    {
      return 300;  
    }



  }

  public function edit_comment($data)
  {
        $comment_id =  $data->comment_id;

        $comment_text =  $data->comment_text;
        
        $user_id =  $data->user_id;

        $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 

        $where = "comment_id='$comment_id'";
     
        $this->db->where($where);


        $query = $this->db->get();  

        $resultComments = $query->row(); 

        if($resultComments->user_id==$user_id)
        {
              $dataUsers = array(

                   'comment_text' => $comment_text,
            
                   );

             $this->db->where('comment_id', $comment_id);


              $this->db->update('foot_comments', $dataUsers);

               return 0; 

        }

         return 300; 

  }
  public function delete_comment($data)
  {
        $comment_id =  $data->comment_id;
        $user_id =  $data->user_id;

        $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 

        $where = "comment_id='$comment_id'";
     
        $this->db->where($where);


        $query = $this->db->get();  

        $resultComments = $query->row(); 

        if($resultComments->comment_type=='comment')
        {
                 $postdetail = $this->db->query("SELECT * FROM foot_posts where post_id='$resultComments->post_id'  ");
            $postdetailsnew =  $postdetail->row();

             $sql = 'update foot_app_users set total_points=total_points-1 where total_points > 0 and  user_id='.$postdetailsnew->user_id;
            $this->db->query($sql);

            $sql = 'update foot_app_users set total_points=total_points-1 where total_points > 0 and  user_id='.$user_id;
            $this->db->query($sql);

            
        }


        if($resultComments->user_id==$user_id)
        {
              $dataUsers = array(

                   'comment_status' => 'delete',
            
                   );

             $this->db->where('comment_id', $comment_id);


              $this->db->update('foot_comments', $dataUsers);


               return 0; 

        }
        else
        {
          $post_id = $resultComments->post_id;


            $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

            $this->db->from('foot_comments'); 

            $where = "post_id='$post_id' and user_id='$user_id'";
         
            $this->db->where($where);

            $query = $this->db->get();  

            $resultPosts = $query->row(); 


            if(!empty($resultPosts))
            {
                $dataUsers = array(

                   'comment_status' => 'delete',
            
                   );

               $this->db->where('comment_id', $comment_id);


              $this->db->update('foot_comments', $dataUsers); 

              return 0; 
            }

            return 300; 
        }

        return 300; 

  }

  public function comment_detail_list($comment_id)
  {
   


        $this->db->select('foot_app_users.*,foot_comments.post_id,foot_comments.comment_type,foot_comments.comment_text');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_status= 'active' and comment_id='$comment_id'";
     
        $this->db->where($where);


        $query = $this->db->get();  

        $resultPosts = $query->row();  



        return $resultPosts;

  }
   public function new_comment_list($data) //for reply  list
  {
         $start =  $data->post_value;
         $comment_type =  $data->comment_type;
         $post_id =  $data->post_id;
         $user_id =  $data->user_id;
         $reply_id =  $data->reply_id;
         $limit= 20;
          $re = array();
         if($reply_id!="")
         {
           $limit= 19;
           $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_status= 'active' and comment_type='$comment_type' and comment_id='$reply_id'";
     
        $this->db->where($where);
       

        $query = $this->db->get();      

        $re = array();

        $value = $query->row();  
 
            $post_id = $value->comment_id;
            
            $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;



          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
          $value->date_dfference = $difference;

          if($comment_type=='comment')
          {

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;


             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
            $comments =  $queryComments->num_rows();
            $value->total_reply = $comments;

            $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;
          }
          else
          {
            $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;

          //  $value->total_foots=0;
            $value->total_reply = 0;
              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;
        
          }
 
               $re[] = $value;
           
         }
           $post_id =  $data->post_id;
         

        $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_status= 'active' and comment_type='$comment_type' and post_id='$post_id'";
        if($reply_id!="")
        {
          $where.=" and comment_id!='$reply_id'";
        }
     
        $this->db->where($where);
        $this->db->order_by("comment_id", "desc");
         $this->db->limit($limit, $start);


        $query = $this->db->get();  

              


       

        $resultPosts = $query->result();  

           foreach ($resultPosts as   $value) {
            $post_id = $value->comment_id;
            
             $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;



              $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
          $value->date_dfference = $difference;

          if($comment_type=='comment')
          {

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;


             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
            $comments =  $queryComments->num_rows();
            $value->total_reply = $comments;

            $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;
          }
          else
          {
            $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;

          //  $value->total_foots=0;
            $value->total_reply = 0;
              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;
        
          }


             

                 

               $re[] = $value;
           }
         
        return $re;

  } 
   public function comment_list($data)
  {
         $start =  $data->post_value;
         $comment_type =  $data->comment_type;
         $post_id =  $data->post_id;
         $user_id =  $data->user_id;
         $limit= 20;

        $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_status= 'active' and comment_type='$comment_type' and post_id='$post_id'";
     
        $this->db->where($where);
        $this->db->order_by("comment_id", "desc");
         $this->db->limit($limit, $start);


        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result();  

           foreach ($resultPosts as   $value) {
            $post_id = $value->comment_id;
            
             $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;



              $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
          $value->date_dfference = $difference;

          if($comment_type=='comment')
          {

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;


             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
            $comments =  $queryComments->num_rows();
            $value->total_reply = $comments;

            $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;
          }
          else
          {
            $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;

          //  $value->total_foots=0;
            $value->total_reply = 0;
              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;
        
          }


             

                 

               $re[] = $value;
           }
         
        return $re;

  } public function singlecomment_detail($user_id,$comment_id)
  {
  
         $limit= 20;

        $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_status= 'active'   and post_id='$comment_id'";
     
        $this->db->where($where); 

        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result();  

           foreach ($resultPosts as   $value) {
            $post_id = $value->comment_id;
            
             $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;



              $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
          $value->date_dfference = $difference;

         

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;


             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
            $comments =  $queryComments->num_rows();
            $value->total_reply = $comments;

            $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;
               

               $re[] = $value;
           }
         
        return $re[0];

  } 

public function single_comment($comment_id,$user_id)
  {   


        $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_comments'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


        $where = "comment_status= 'active' and comment_id='$comment_id'  ";
     
        $this->db->where($where);
      

        $query = $this->db->get();      

      

        $value = $query->row();  

        if($value)
        {
        
            $post_id = $value->comment_id;
            
             $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;



              $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
          $value->date_dfference = $difference;

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active'");
            $foots =  $queryFoots->num_rows();
             $value->total_foots =$foots;


             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='reply' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             $value->total_reply = $comments;

                 $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            
         
        return $value;
      }
      return array();

  } 

   public function notification_read($data)
  {
         $notification_id =  $data->notification_id;

            $dataUsers = array(

                   'read_status' => '1',
            
                   );

             $this->db->where('notification_id', $notification_id);


              $this->db->update('foot_notification', $dataUsers); 
              
            return 0;
         
  }


   public function mark_as_read_notification($data)
  {
         $user_id =  $data->user_id;

            $dataUsers = array(

                   'read_status' => '1',
            
                   );

             $this->db->where('user_id', $user_id);


              $this->db->update('foot_notification', $dataUsers); 
              
            return 0;
         
  }

  public function unread_notification_count($data)
  {
      $user_id =  $data->user_id;
      $this->db->select('foot_notification.*,foot_app_users.fullname');                                   /*select recently updated user data */ 

        $this->db->from('foot_notification'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_notification.from_id '); 

        $where = " foot_notification.user_id='$user_id' and notification_status='active' and foot_notification.read_status='0'";
     
        $this->db->where($where);          

         $query = $this->db->get();     
         $resultPosts = $query->num_rows(); 
         return $resultPosts; 
  }

   public function delete_notification($data)
  {
     $user_id =  $data->user_id;
     $notification_id =  $data->notification_id;

     $dataUsers = array(

           'notification_status' => 'remove',
    
           );

       $this->db->where('user_id', $user_id);

     if(!empty($notification_id))
     {
           $this->db->where('notification_id', $notification_id);
     }

              
        $this->db->update('foot_notification', $dataUsers);

         return 0; 
  }

  public function notification_list($data)
  {
         $start =  $data->post_value;
 
       
         $user_id =  $data->user_id;
         $limit= 25;

        $this->db->select('foot_notification.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

        $this->db->from('foot_notification'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_notification.from_id '); 

        $where = " foot_notification.user_id='$user_id' and notification_status='active'";
     
        $this->db->where($where);
        $this->db->order_by("notification_id", "desc");
         $this->db->limit($limit, $start);


        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result(); 

           foreach ($resultPosts as $value) {
             $comment_user_id = $value->from_id;
             $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);  
             $value->user_detail = $resultuser;

             // print_r($resultuser);die();
            //'follow_request','new_message','approve_request','add_follow','add_comment','add_foot','add_foot_comment','add_reply','add_like'
            $text ="";

            if($value->notification_type=='add_foot_comment')
            {
                $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 
                $this->db->from('foot_comments'); 
                $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


                $where = "comment_status= 'active' and comment_id='$value->comment_id'  ";
             
                $this->db->where($where);
              

                $commentquery = $this->db->get();      

              

                $commentvalue = $commentquery->row(); 

                if($commentvalue)
                {
                  // $text = $resultuser['fullname'].' commented: '.substr($commentvalue->comment_text,0,50);
                   $text = $resultuser['fullname'].' commented on your footshot.';
                }
                else
                {
                   $text = $resultuser['fullname'].' commented on your footshot.';
                }

             
            }
            else if($value->notification_type=='add_foot_reply')
            {
                $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 
                $this->db->from('foot_comments'); 
                $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


                $where = "comment_status= 'active' and comment_id='$value->comment_id'  ";
             
                $this->db->where($where);
              

                $commentquery = $this->db->get();      

              

                $commentvalue = $commentquery->row(); 

                if($commentvalue)
                {
                  // $text = $resultuser['fullname'].' commented: '.substr($commentvalue->comment_text,0,50);
                   $text = $resultuser['fullname'].' replied on your footshot comment.';
                }
                else
                {
                   $text = $resultuser['fullname'].' replied on your footshot comment.';
                }

             
            }else if($value->notification_type=='comment_tag')
            {
              $value->notification_type = "add_foot_comment";
                $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 
                $this->db->from('foot_comments'); 
                $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


                $where = "comment_status= 'active' and comment_id='$value->comment_id'  ";
             
                $this->db->where($where);
              

                $commentquery = $this->db->get();      

              

                $commentvalue = $commentquery->row(); 

                if($commentvalue)
                {
                  // $text = $resultuser['fullname'].' commented: '.substr($commentvalue->comment_text,0,50);
                   $text = $resultuser['fullname'].' tagged you in a footshot comment.';
                }
                else
                {
                   $text = $resultuser['fullname'].' tagged you in a footshot comment.';
                }

             
            }
            if($value->notification_type=='reply_tag')
            {
              $value->notification_type="add_foot_reply";
                $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 
                $this->db->from('foot_comments'); 
                $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


                $where = "comment_status= 'active' and comment_id='$value->comment_id'  ";
             
                $this->db->where($where);
              

                $commentquery = $this->db->get();      

              

                $commentvalue = $commentquery->row(); 

                if($commentvalue)
                {
                  // $text = $resultuser['fullname'].' commented: '.substr($commentvalue->comment_text,0,50);
                   $text = $resultuser['fullname'].' tagged you in a footshot reply.';
                }
                else
                {
                   $text = $resultuser['fullname'].' tagged you in a footshot reply.';
                }

             
            }
            else  if($value->notification_type=='add_like')
            {
              $text = $resultuser['fullname'].' liked your footshot.';
            }
             else  if($value->notification_type=='add_like_comment')
            {
              $value->notification_type = 'add_foot_comment';
              $text = $resultuser['fullname'].' liked your footshot comment.';
            }
            else  if($value->notification_type=='add_like_reply')
            {
              $value->notification_type = 'add_foot_reply';
              $text = $resultuser['fullname'].' liked your footshot comment reply.';
            }

            else if($value->notification_type=='follow_request')
            {
              $text = $resultuser['fullname'].' sent you a follow request.';
            }
           else  if($value->notification_type=='follow_request')
            {
              $text = $resultuser['fullname'].' sent you a follow request.';
            }

          

             else  if($value->notification_type=='add_follow')
            {
              $text = $resultuser['fullname'].' started following you.';
            }
              else  if($value->notification_type=='approve_request')
            {
                 $value->notification_type = 'add_follow';

              $text = $resultuser['fullname'].' accepted your follow request.';
            }

             else  if($value->notification_type=='post_tag')
            {
              $text = $resultuser['fullname'].' tagged you in a post';
            }

          elseif($value->notification_type=='new_message')
            {
              $text = $resultuser['fullname'].' sent you a message.';
            } 

            elseif($value->notification_type=='new_group_message')
            {

                $this->db->select('foot_chats.*');

              $this->db->from('foot_chats'); 

              $this->db->where('chat_id',$value->timeline_id);

              $querygrp = $this->db->get(); 

                $grpresult = $querygrp->row();

              $text = $resultuser['fullname'].' sent a message in group '.$grpresult->chat_name;
             $value->chat_name = $grpresult->chat_name;
            }
            elseif($value->notification_type=='post_month')
            {
               $value->notification_type = 'post_tag';
               
              $text = $resultuser['fullname'].' added your post as post of the month.';
            }


            $value->notif_text = $text;
              date_default_timezone_set('UTC');

          $this->db->query('SET time_zone="+00:00"');
             $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_notification);
          $second_date = new DateTime($current_date);

           $difference = $first_date->diff($second_date);



             $difference = $this->format_interval($difference);
             $value->date_dfference = $difference;
             $value->user_detail_image = $value->user_detail['profileimage'];

            $re[] = $value;
           }

 



                 
        return $re;

  } 

 
}