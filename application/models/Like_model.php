<?php 

class Like_model extends CI_Model {



  public function __construct()

  {

        // Call the Model constructor

    parent::__construct();
 
      date_default_timezone_set('UTC');

    $this->db->query('SET time_zone="+00:00"');
     $this->load->model('User_model');  
     $this->load->model('Post_model');  
     $this->load->model('Comment_model');  


  }



    /*Method to generate Random String*/


  function decodeEmoticons($src) {
    $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
 

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

 

   public function add_like($data)

  { 
 
 
    $user_id =  $data->user_id;
 

    $like_type =  $data->like_type;

    $post_id =  $data->post_id;
    $notipost_id =  $data->post_id;
  
     $this->db->select('foot_likes.*');
        $this->db->from('foot_likes'); 
        $where = "user_id='$user_id' and post_id='$post_id' and like_type='$like_type' and like_status='active'";
        $this->db->where($where);    
        $query = $this->db->get();
        $restults = $query->result();
        $restultslike = array_shift($restults);

        if($restultslike)
        {
             $datas = array(                                                      /*An array of data to insert into table*/
              'like_status' => "delete"

             );    

            $where = "post_id = '$post_id' and user_id='$user_id'  and like_type='$like_type' ";
             $this->db->where($where);

            $this->db->update('foot_likes', $datas); 

             if($like_type=='post')
            {

              $postdetail = $this->db->query("SELECT * FROM foot_posts where post_id='$data->post_id'  ");
              $postdetailsnew =  $postdetail->row();

               $sql = 'update foot_app_users set total_points=total_points-1 where total_points > 0 and user_id='.$postdetailsnew->user_id;
              $this->db->query($sql);  

              $sql = 'update foot_app_users set total_points=total_points-1 where total_points > 0 and  user_id='.$user_id;
              $this->db->query($sql);
            }

               return 0; 
        }
        else
        {
 
            $datas = array(                                                      /*An array of data to insert into table*/
             
             'user_id' => $user_id,
             'post_id' => $post_id,
             'like_type' => $like_type,
             'like_status' => "active",
             'date_of_creation' => date('Y-m-d H:i:s'),
         

             ); 
           
            $this->db->insert('foot_likes', $datas); 

            $this->db->last_query(); 

             $post_id = $this->db->insert_id();



            /*  if($like_type=='post')
              {
                  $NotificationUserDetail = $this->Post_model->timeline_user_detail($data->post_id);
              }
              else if($like_type=='comment')
              {

                 $NotificationUserDetail = $this->Comment_model->comment_detail_list($data->post_id);
                 
              }*/

              

               
              $myUserDetail = $this->User_model->single_users_detail($user_id);


            

              if($like_type=='post')
              {
                  
                    $countlikepost = $this->db->query("SELECT * FROM foot_likes where post_id='$data->post_id' and like_status='active'  ");
                    $totallikepost =  $countlikepost->num_rows();
               
                    $postdeetail = $this->db->query("SELECT * FROM foot_posts where post_id='$data->post_id'  ");
                    $postdeetailsnew =  $postdeetail->row();

                 

                     $pointlikepost = $this->db->query("SELECT * FROM foot_point_system where point_type='like'  ");

                    $likepostpoint =  $pointlikepost->result();
                    
                   foreach ($likepostpoint as   $pointsvalue) {

                    $total_value= $pointsvalue->total_value;
                    $total_points= $pointsvalue->total_points;
                      
                     if($totallikepost % $total_value == 0) 
                     {  
                            $datae = array(  

                                 'user_id' => $postdeetailsnew->user_id,

                                 'post_id' => $data->post_id,     

                                 'total_points' => $total_points,

                                 'sys_id' =>   $pointsvalue->sys_id,                              
                                
                                 'point_for' =>   "like",                              

                                 'date_of_point'=> date('Y-m-d H:i:s'), 

                                );

                          $this->db->insert('foot_user_points', $datae);
                           $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where     user_id='.$postdeetailsnew->user_id;
                          $this->db->query($sql);
                         

                      

                           $this->db->select('*');

                          $this->db->from('foot_app_users');

                          $where = "user_id='".$postdeetailsnew->user_id."'";

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
                            //$badge = 1;

                             $badge = $resultpoint->badge+1;

                             $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$resultpoint->user_id;

                          $this->db->query($sql);

                            $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$postdeetailsnew->user_id' and read_status='0' and notification_status='active'");
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


                      $countlikepostmy = $this->db->query("SELECT * FROM foot_likes where user_id='$user_id'  and like_status='active'  ");
                    $totallikepostmy =  $countlikepostmy->num_rows();

                         if($totallikepostmy % $total_value == 0) 
                     { 

                           $datae = array(  

                                 'user_id' => $user_id,

                                 'post_id' => $data->post_id,     

                                 'total_points' => $total_points,

                                 'sys_id' =>   $pointsvalue->sys_id,                              
                                
                                 'point_for' =>   "like",                              

                                 'date_of_point'=> date('Y-m-d H:i:s'), 

                                );
                               $this->db->insert('foot_user_points', $datae);
                               
                          $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where user_id='.$user_id;

                          $this->db->query($sql);
                      }

                   }


                  $NotificationUserDetail = $this->Post_model->timeline_user_detail($data->post_id);

                   $message = $this->decodeEmoticons($myUserDetail->fullname." liked your footshot.");

                   $notityy = 'add_like';
                   $action = "post_detail";


              }
               
          else if($like_type=='comment')
              {

                 $NotificationUserDetail = $this->Comment_model->comment_detail_list($data->post_id);

                  
                  if($NotificationUserDetail->comment_type=='reply')
                  {

                    $this->db->select('foot_comments.*');                                   /*select recently updated user data */ 

                      $this->db->from('foot_comments'); 
                      $this->db->join('foot_app_users','foot_app_users.user_id =foot_comments.user_id '); 


                      $where = "comment_id= '$data->post_id' ";
                   
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

                           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$data->post_id' and like_type='comment' and  like_status='active'");
                          $foots =  $queryFoots->num_rows();
                           $value->total_foots =$foots;


                           $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$data->post_id' and comment_type='reply' and  comment_status='active'");
                          $comments =  $queryComments->num_rows();


                           $value->total_reply = $comments;

                               $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$data->post_id' and like_type='comment' and  like_status='active' and  user_id='$user_id'");
                         $footsYou =  $queryFootsyou->num_rows();


                         $value->you_like =$footsYou;

                    $message = $this->decodeEmoticons($myUserDetail->fullname." liked your footshot comment reply.");

                    $notityy = "add_like_reply";

                    $data->post_id =   $NotificationUserDetail->post_id;

                    $action = "add_like_reply";
                     $NotificationUserDetailcmg = $this->Comment_model->single_comment($NotificationUserDetail->post_id,$user_id);
                     $value->reply_id = intval($notipost_id);

                     if($NotificationUserDetail->device_type=='android')
                     {

                            $value->comment_detail = $NotificationUserDetailcmg;
                      }    

                      $value->user_id = $user_id;
                      $value->other_user_id= $data->post_id;
                      $value->other_user_name = $myUserDetail->fullname;
                     //$value['comment_detail'] = $NotificationUserDetailcmg;
                       $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$user_id' and read_status='0' and notification_status='active'");
             $total_unread_notification =  $notificunser->num_rows();
             $value->total_unread_notification=$total_unread_notification;
                  }
                  else
                  {
               

                    $message = $this->decodeEmoticons($myUserDetail->fullname." liked your footshot comment.");

                    $notityy = "add_like_comment";

                    $data->post_id =   $NotificationUserDetail->post_id;

                    $action = "post_comment_detail";
                     $value['comment_id'] = intval($notipost_id);
                     $value['user_id'] = $user_id;
                    $value['other_user_id'] = $data->post_id;
                    $value['other_user_name'] = $myUserDetail->fullname;

                     $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$user_id' and read_status='0' and notification_status='active'");
                   $total_unread_notification =  $notificunser->num_rows();
                   $value['total_unread_notification'] =$total_unread_notification;
                 }
             
              }


                $device_type =  $NotificationUserDetail->device_type;
              $device_token =  $NotificationUserDetail->device_token; 
               $badge = 1;

               $badge = $NotificationUserDetail->badge+1;

                 $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;

              $this->db->query($sql);
               
              if($like_type=='post')
              {
                 $device_type =  $NotificationUserDetail->device_type;
              $device_token =  $NotificationUserDetail->device_token; 
              
 
              
              $value['user_id'] = $user_id;
              $value['other_user_id'] = $data->post_id;
              $value['other_user_name'] = $myUserDetail->fullname;
              $badge = 1;

               $badge = $NotificationUserDetail->badge+1;

                 $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;

              $this->db->query($sql);
              
              $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$user_id' and read_status='0' and notification_status='active'");
             $total_unread_notification =  $notificunser->num_rows();
             $value['total_unread_notification'] =$total_unread_notification;
              }
             
 
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
 

                     if($like_type=='comment')
                     {
                          $this->db->select('foot_comments.*');   
                        $this->db->from('foot_comments');                        

                        $where = "comment_id='".$notipost_id."'  ";
                     
                        $this->db->where($where);                      

                         $query = $this->db->get();      
 
                      $querypost = $query->row();  

                      $datas = array(  

                             'user_id' => $NotificationUserDetail->user_id,

                             'from_id' => $user_id,     

                             'timeline_id' => $querypost->post_id,
                             'comment_id' => $notipost_id,

                             'notification_type' =>  $notityy,
                         
                             'read_status' =>'0',

                             'date_of_notification'=> date('Y-m-d H:i:s'), 

                            );

                      $this->db->insert('foot_notification', $datas); 

                     }
                     else
                     {
                      $datas = array(  

                             'user_id' => $NotificationUserDetail->user_id,

                             'from_id' => $user_id,     

                             'timeline_id' => $notipost_id,

                             'notification_type' =>  $notityy,
                         
                             'read_status' =>'0',

                             'date_of_notification'=> date('Y-m-d H:i:s'), 

                            );

                      $this->db->insert('foot_notification', $datas); 

                     }

                       
                    }

               return 1; 

           }
  


  }


   public function remove_like($data)

  { 
 
 
    $user_id =  $data->user_id;
 

    $like_type =  $data->like_type;

    $post_id =  $data->post_id;
 


    $datas = array(                                                      /*An array of data to insert into table*/
          'like_status' => "delete"

     );    

    $where = "post_id = '$post_id' and like_type='$like_type' and   user_id='$user_id' ";
     $this->db->where($where);

    $this->db->update('foot_likes', $datas); 

     

    $post_id = $this->db->insert_id();

    return 0;        


  }


   public function like_list($data)
  {
         $start =  $data->post_value;
         $like_type =  $data->like_type;
         $post_id =  $data->post_id;
         $user_id =  $data->user_id;
         $limit= 20;

        $this->db->select('foot_likes.*,foot_app_users.fullname,foot_app_users.profileimage');                                   /*select recently updated user data */ 

        $this->db->from('foot_likes'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_likes.user_id '); 


        $where = "like_status= 'active' and like_type='$like_type' and post_id='$post_id'";
     
        $this->db->where($where);
        $this->db->order_by("like_id", "desc");
         $this->db->limit($limit, $start);


        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result();  

         foreach ($resultPosts as   $value) {
            
              $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

            $re[] = $value;
       }
         
        return $re;

  } 

 
}