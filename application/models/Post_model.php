<?php 

class Post_model extends CI_Model {



  public function __construct()

  {

        // Call the Model constructor

    parent::__construct();

      date_default_timezone_set('UTC');

    $this->db->query('SET time_zone="+00:00"');

     $this->load->model('User_model');  
     $this->load->model('Comment_model');  

  }

function decodeEmoticons($src) {
    $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
 


  function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result = $interval->format("%y YEARS AGO"); }
     else  if ($interval->d) { 

      if($interval->d>7 || $interval->days>7)
      {
         $result = $interval->days; 

         $weeks = floor($result / 7);
        //  $dayRemainder = $result % 7;
         $result = $weeks .' WEEKS AGO';

      }
      else
      {
         $result = $interval->format("%d DAYS AGO"); 
      }
  
    } 
    else  if ($interval->h) { $result = $interval->format("%h HOURS AGO"); }
    else  if ($interval->i) { $result = $interval->format("%i MINUTES AGO"); }
    else  if ($interval->s) { $result = $interval->format("JUST NOW"); }

    return $result;
}  
function new_format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result = $interval->format("%y YEARS AGO"); }
     else  if ($interval->d) { 

      if($interval->d>7 || $interval->days>7)
      {
         $result = $interval->days; 

         $weeks = floor($result / 7);
        //  $dayRemainder = $result % 7;
         $result = $weeks .' WEEKS AGO';

      }
      else
      {
         $result = $interval->format("%d DAYS AGO"); 
      }
  
    } 
    else  if ($interval->h) { $result = $interval->format("%h HOURS AGO"); }
    else  if ($interval->i) { $result = $interval->format("%i MINUTES AGO"); }
    else  if ($interval->s) { $result = $interval->format("JUST NOW"); }

    return $result;
}

/*  function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result = $interval->format("%y y"); }
    else  if ($interval->d) { 

      if($interval->d>7)
      {
         $result = $interval->d; 

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

*/


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


   public function add_share($data)
  { 
  
    $user_id =  $data->user_id;
 

    $post_id =  $data->post_id;  
     
       $datas = array(                                                      /*An array of data to insert into table*/
       
       'user_id' => $user_id,
       'post_id' => $post_id,
       'date_of_share' => date('Y-m-d H:i:s')  

       ); 
     
      $this->db->insert('foot_shared', $datas); 

      $this->db->last_query(); 

       $post_id = $this->db->insert_id(); 

         return 0;     
   

  }

  public function caught_up_count($data)
  { 
  
    $user_id =  $data->user_id;

      $startDate = date('Y-m-d H:i');  
      $stWartDate = time();  
     $endDate  = date("Y-m-d H:i", strtotime('-24 HOURS', $stWartDate));
 
   
      $postList = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active' and ( foot_app_users.user_id = '$user_id' or foot_posts.user_id in (select to_id from  foot_follow  where foot_follow.from_id='$user_id' and foot_follow.follow_status='active' ) )  and  foot_posts.date_of_creation between '$endDate' and '$startDate'   group by post_id  order by post_id desc  ");

        $total_unread_notification =  $postList->result();
        $last_post_id = "0";

        foreach ($total_unread_notification as  $value) {
           
              $last_post_id =$value->post_id;

        }

        $countPost['post_id'] =$last_post_id;
        $countPost['post_count'] =$postList->num_rows();
         return     $countPost;  
   

  }
   
   public function remove_post($data)
   {
        $user_id =  $data->user_id;
        $post_id =  $data->post_id;
        if($post_id == '' || $post_id == '0')
        {
           return 1;
        }else{
               $dataUsers = array(

                 'post_status' => 'delete',
          
                 );

             $this->db->where('post_id', $post_id);

              $this->db->update('foot_posts', $dataUsers); 

                 $dataUsers = array(

                   'post_status' => 'delete',
            
                   );

             $this->db->where('post_id', $post_id);

            $this->db->update('foot_posts', $dataUsers); 



                 $dataUsers = array(

                   'notification_status' => 'remove',
            
                   );

             $this->db->where('timeline_id', $post_id);

            $this->db->update('foot_notification', $dataUsers); 

             $dataUsers = array(

                   'message_type' => 'text',
                   'chat_message' => 'This Footshot is not available.',
            
                   );

             $this->db->where('timeline_id', $post_id);

            $this->db->update('foot_chat_message', $dataUsers); 
   
            
   
           



             $this->db->where('post_id', $post_id);

            $this->db->delete('foot_post_tag'); 

            $this->db->where('post_id', $post_id);

            $this->db->delete('foot_post_product'); 


            

                  return 0;   
        }
   }

   public function add_post($data)
  { 

 
 
    $user_id =  $data->user_id;

    $postimage =  $data->postimage;
    $pic_height =  $data->pic_height;
    $pic_width =  $data->pic_width;

    $post_caption =  $data->post_caption;

    $location_address =  $data->location_address;

    $location_latitude =  $data->location_latitude;

    $location_longitude =  $data->location_longitude;
    

    $postal_code =  $data->postal_code;

    $total_post =  $data->total_post;

    $tag_peoples =  $data->tag_peoples;

    $tag_products =  $data->tag_products;


    $tag_products =  $data->tag_products;


    $country =  $data->country;

    $state =  $data->state;

    $city =  $data->city;

    $fulladdress =  $data->fulladdress;
    $is_private =  $data->is_private;

      $country_id="";

                $this->db->select('*');                                   /*select recently updated user data */ 

                $this->db->from('foot_country'); 


                $where = "country_name= '".$country."'";
             
                $this->db->where($where);

                $query = $this->db->get();

                $resultCountry = $query->result();    

                if($resultCountry)
                {
                  $contry = array_shift($resultCountry);

                  $country_id = $contry->id;
                }
                 



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
     'post_number' => $total_post,
     'post_status' => "active",
     'date_of_creation' => date('Y-m-d H:i:s'),
 

     ); 
   
    $this->db->insert('foot_posts', $datas);  

    

     $post_id = $this->db->insert_id();
     $notiPOSTID = $post_id;

    foreach ($tag_peoples as $peoplesvalue) 
            {
      
              $tagUser_id = $peoplesvalue['user_id'];

              if($tagUser_id)
              {
              $x_point = $peoplesvalue['x_point'];
              $y_point = $peoplesvalue['y_point'];
                 $datasPeople = array(  

                 'user_id' => $tagUser_id,
                 'x_point' => $x_point,
                 'y_point' => $y_point,
                 'post_id' => $post_id,
                 'tag_status' => "active",
                 'date_of_creation' => date('Y-m-d H:i:s')            

                 ); 
               
                $this->db->insert('foot_posts_people_tags', $datasPeople); 


              $NotificationUserDetail = $this->User_model->single_users_detail($tagUser_id);
 
           
              $myUserDetail = $this->User_model->single_users_detail($user_id);

              $device_type =  $NotificationUserDetail->device_type;
              $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshot.");

                 $action = "post_detail";
                 $value['user_id'] = $user_id;
                 $value['other_user_id'] = "$post_id";
                 $value['other_user_name'] = $myUserDetail->fullname;

                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
                 $value['total_unread_notification'] =$total_unread_notification;

                 $badge = 1;


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

                         'user_id' => $tagUser_id,

                         'from_id' => $user_id,     

                         'timeline_id' => $post_id,

                         'notification_type' =>  "post_tag",
                     
                         'read_status' =>'0',

                         'date_of_notification'=> date('Y-m-d H:i:s'), 

                        );

                            $this->db->insert('foot_notification', $data);   
                  }
                }
                  
             }
      foreach ($tag_products as $valueProducts) 
              {
                  $produCtName = $valueProducts['product_name'];
                 $x_point = $valueProducts['x_point'];

              $y_point = $valueProducts['y_point'];
              
                    $this->db->select('*');                                   /*select recently updated user data */ 

                      $this->db->from('foot_products'); 


                      $where = "product_name= '".$produCtName."'";
                   
                      $this->db->where($where);

                      $query = $this->db->get();

                      $resultProducts = $query->result();    

                      if($resultProducts)
                      {
                        $produ = array_shift($resultProducts);

                        $product_id = $produ->product_id;
                      }
                      else
                      {

                         $datasProducts = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_name' => $produCtName,          
                         'last_update' => date('Y-m-d H:i:s')           

                         ); 
                       
                        $this->db->insert('foot_products', $datasProducts);

                         $product_id = $this->db->insert_id();
                      }



                         $datasProductsid = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_id' => $product_id,         
                         'x_point' => $x_point,         
                         'y_point' => $y_point,         
                         'post_id' => $post_id,         
                         'product_status' => 'active',         
                         'date_of_creation' =>date('Y-m-d H:i:s')          

                         ); 
                       
                        $this->db->insert('foot_post_product', $datasProductsid);
                     

                    }              
     
 

            if($post_id){ 

              $dataUsers = array(

                 'total_post' => $total_post,
          
                 );

           $this->db->where('user_id', $user_id);

            $this->db->update('foot_app_users', $dataUsers); 


             preg_match_all('/(?<!\w)#\w+/',$post_caption,$matches);
 
           foreach ($matches[0] as   $value) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$value' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $value,     

                 'password' => "",

                 'profileimage' => $postimage,
             
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

              $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$post_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                $datatag = array(                                                      /*An array of data to insert into table*/

                 'post_id' => $post_id,

                 'tag_id' => $tag_id,      
                 'hashstatus' => 'active',      

                 'date_of_creation'=> date('Y-m-d H:i:s') 

                 ); 

                $this->db->insert('foot_post_tag', $datatag);
              }

               

               
                                            
           }
   

             $pointlikepost = $this->db->query("SELECT * FROM foot_point_system where point_type='post'  ");

                    $likepostpoint =  $pointlikepost->row();

                    $total_points = $likepostpoint->total_points;

               $datae = array(  

                       'user_id' => $user_id,

                       'post_id' => $post_id,     

                       'total_points' => $total_points,

                       'sys_id' =>   $likepostpoint->sys_id,                              
                      
                       'point_for' =>   "post",                              

                       'date_of_point'=> date('Y-m-d H:i:s'), 

                      );

                $this->db->insert('foot_user_points', $datae);

                 $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where     user_id='.$user_id;
                $this->db->query($sql);



                 
  
      return $post_id;                                                 /*return data of user to the controller which call this function  */            

 
    }
    else
    {
      return 0;  
    }
 
  
  }
   public function add_new_post($data)
  { 

 
 
    $user_id =  $data->user_id;

    $postimage =  $data->postimage;
    $pic_height =  $data->pic_height;
    $pic_width =  $data->pic_width;

    $post_caption =  $data->post_caption;

    $location_address =  $data->location_address;

    $location_latitude =  $data->location_latitude;

    $location_longitude =  $data->location_longitude;
    

    $postal_code =  $data->postal_code;

    $total_post =  $data->total_post;

    $tag_peoples =  $data->tag_peoples;

    $tag_products =  $data->tag_products;


    $tag_products =  $data->tag_products;


    $country =  $data->country;

    $state =  $data->state;

    $city =  $data->city;

    $fulladdress =  $data->fulladdress;
    $is_private =  $data->is_private;

      $country_id="";

                $this->db->select('*');                                   /*select recently updated user data */ 

                $this->db->from('foot_country'); 


                $where = "country_name= '".$country."'";
             
                $this->db->where($where);

                $query = $this->db->get();

                $resultCountry = $query->result();    

                if($resultCountry)
                {
                  $contry = array_shift($resultCountry);

                  $country_id = $contry->id;
                }
                 



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
     'post_number' => $total_post,
     'post_status' => "active",
     'date_of_creation' => date('Y-m-d H:i:s'),
 

     ); 
   
    $this->db->insert('foot_posts', $datas);  

    

     $post_id = $this->db->insert_id();
     $notiPOSTID = $post_id;

    foreach ($tag_peoples as $peoplesvalue) 
            {
      
              $tagUser_id = $peoplesvalue['user_id'];

              if($tagUser_id)
              {
              $x_point = $peoplesvalue['x_point'];
              $y_point = $peoplesvalue['y_point'];
                 $datasPeople = array(  

                 'user_id' => $tagUser_id,
                 'x_point' => $x_point,
                 'y_point' => $y_point,
                 'post_id' => $post_id,
                 'tag_status' => "active",
                 'date_of_creation' => date('Y-m-d H:i:s')            

                 ); 
               
                $this->db->insert('foot_posts_people_tags', $datasPeople); 


              $NotificationUserDetail = $this->User_model->single_users_detail($tagUser_id);
 
           
              $myUserDetail = $this->User_model->single_users_detail($user_id);

              $device_type =  $NotificationUserDetail->device_type;
              $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshot.");

                 $action = "post_detail";
                 $value['user_id'] = $user_id;
                 $value['other_user_id'] = "$post_id";
                 $value['other_user_name'] = $myUserDetail->fullname;

                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
                 $value['total_unread_notification'] =$total_unread_notification;

                 $badge = 1;


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

                         'user_id' => $tagUser_id,

                         'from_id' => $user_id,     

                         'timeline_id' => $post_id,

                         'notification_type' =>  "post_tag",
                     
                         'read_status' =>'0',

                         'date_of_notification'=> date('Y-m-d H:i:s'), 

                        );

                            $this->db->insert('foot_notification', $data);   
                  }
                }
                  
             }
      foreach ($tag_products as $valueProducts) 
              {
                  $produCtName = $valueProducts['product_name'];
                 $x_point = $valueProducts['x_point'];

              $y_point = $valueProducts['y_point'];
              
                    $this->db->select('*');                                   /*select recently updated user data */ 

                      $this->db->from('foot_products'); 


                      $where = "product_name= '".$produCtName."'";
                   
                      $this->db->where($where);

                      $query = $this->db->get();

                      $resultProducts = $query->result();    

                      if($resultProducts)
                      {
                        $produ = array_shift($resultProducts);

                        $product_id = $produ->product_id;
                      }
                      else
                      {

                         $datasProducts = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_name' => $produCtName,          
                         'last_update' => date('Y-m-d H:i:s')           

                         ); 
                       
                        $this->db->insert('foot_products', $datasProducts);

                         $product_id = $this->db->insert_id();
                      }



                         $datasProductsid = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_id' => $product_id,         
                         'x_point' => $x_point,         
                         'y_point' => $y_point,         
                         'post_id' => $post_id,         
                         'product_status' => 'active',         
                         'date_of_creation' =>date('Y-m-d H:i:s')          

                         ); 
                       
                        $this->db->insert('foot_post_product', $datasProductsid);
                     

                    }              
     
 

            if($post_id){ 

              $dataUsers = array(

                 'total_post' => $total_post,
          
                 );

           $this->db->where('user_id', $user_id);

            $this->db->update('foot_app_users', $dataUsers); 


             preg_match_all('/(?<!\w)#\w+/',$post_caption,$matches);
 
           foreach ($matches[0] as   $value) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$value' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $value,     

                 'password' => "",

                 'profileimage' => $postimage,
             
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

              $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$post_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                $datatag = array(                                                      /*An array of data to insert into table*/

                 'post_id' => $post_id,

                 'tag_id' => $tag_id,      
                 'hashstatus' => 'active',      

                 'date_of_creation'=> date('Y-m-d H:i:s') 

                 ); 

                $this->db->insert('foot_post_tag', $datatag);
              }

               

               
                                            
           }
   

             $pointlikepost = $this->db->query("SELECT * FROM foot_point_system where point_type='post'  ");

                    $likepostpoint =  $pointlikepost->row();

                    $total_points = $likepostpoint->total_points;

               $datae = array(  

                       'user_id' => $user_id,

                       'post_id' => $post_id,     

                       'total_points' => $total_points,

                       'sys_id' =>   $likepostpoint->sys_id,                              
                      
                       'point_for' =>   "post",                              

                       'date_of_point'=> date('Y-m-d H:i:s'), 

                      );

                $this->db->insert('foot_user_points', $datae);

                 $sql = 'update foot_app_users set total_points=total_points+'.$total_points.' where     user_id='.$user_id;
                $this->db->query($sql);



                 preg_match_all('/(?<!\w)@\w+/',$post_caption,$matchesUser);
                
 
                 foreach ($matchesUser[0] as   $value) {


                  $value = str_replace("@", "", $value);
                  
                  $NotificationUserDetail = $this->User_model->single_username_detail($value);
                  if (!empty($NotificationUserDetail)) {

                    # code...
                  
                  
                  $tagUser_id = $NotificationUserDetail->user_id;


                   $datastags = array(                                                      /*An array of data to insert into table*/ 

                     'user_id' => $user_id,
                     'post_id' => $post_id,
                     'creation_date' => date('Y-m-d H:i:s')
                 

                     ); 
                   
                    $this->db->insert('foot_post_at_tagging', $datastags);  

             
               
                  $myUserDetail = $this->User_model->single_users_detail($user_id);

                  $device_type =  $NotificationUserDetail->device_type;
                  $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshot.");

                 $action = "post_detail";
                 $values['user_id'] = $user_id;
                 $values['other_user_id'] = "$post_id";
                 $values['other_user_name'] = $myUserDetail->fullname;

                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
                 $values['total_unread_notification'] =$total_unread_notification;

                 $badge = 1;

         
              $badge = $NotificationUserDetail->badge+1;

               $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                $this->db->query($sql);


                 if($NotificationUserDetail->user_id!=$user_id)
                 {  
 
                           if($device_token!="")
                           {
                             if($device_type=='ios')
                             {
                                send_message_ios($device_token,$message,$badge,$action,$values);
                             }
                             if($device_type=='android')
                             {
                                  send_notification_android($device_token,$message,$action,$values);
                             }
                          }



                             $data = array(  

                             'user_id' => $tagUser_id,

                             'from_id' => $user_id,     

                             'timeline_id' => $post_id,

                             'notification_type' =>  "post_tag",
                         
                             'read_status' =>'0',

                             'date_of_notification'=> date('Y-m-d H:i:s'), 

                            );

                                $this->db->insert('foot_notification', $data);   
                      }

                      }
                                    
                 }
  
      return $post_id;                                                 /*return data of user to the controller which call this function  */            

 
    }
    else
    {
      return 0;  
    }
 
  
  }
   public function edit_new_post($data)

  { 
 
 
    $user_id =  $data->user_id;
 
    $post_caption =  $data->post_caption;

    $location_address =  $data->location_address;

    $location_latitude =  $data->location_latitude;

    $location_longitude =  $data->location_longitude;
    

    $postal_code =  $data->postal_code;

    $total_post =  $data->total_post;

    $tag_peoples =  $data->tag_peoples;

    $tag_products =  $data->tag_products;


    $tag_products =  $data->tag_products;


    $country =  $data->country;

    $state =  $data->state;

    $city =  $data->city;

    $fulladdress =  $data->fulladdress;
    $is_private =  $data->is_private;
    $post_id =  $data->post_id;

      $country_id="";

                $this->db->select('*');                                   /*select recently updated user data */ 

                $this->db->from('foot_country'); 


                $where = "country_name= '".$country."'";
             
                $this->db->where($where);

                $query = $this->db->get();

                $resultCountry = $query->result();    

                if($resultCountry)
                {
                  $contry = array_shift($resultCountry);

                  $country_id = $contry->id;
                }

    $dataspeople = array(  
        'tag_status'=>'remove'
      );
     $this->db->where('post_id', $post_id);
     
    $this->db->update('foot_posts_people_tags', $dataspeople);              



    $datas = array(                                                      /*An array of data to insert into table*/
                          

     'user_id' => $user_id,
     'post_caption' => $post_caption,
     'address' => $location_address,
     'fulladdress' => $fulladdress,
     'postal_code' => $postal_code,
     'city' => $city,
     'state' => $state,
     'country' => $country_id,
     'lat' => $location_latitude,
     'lng' => $location_longitude,
     'is_private' => $is_private, 
  
     ); 
    $this->db->where('post_id', $post_id);
    $this->db->update('foot_posts', $datas); 

 
    

     $post_id = $post_id;

     $notiPOSTID = $post_id;



    foreach ($tag_peoples as $peoplesvalue) 
            {
              $x_point = $peoplesvalue['x_point'];
              $y_point = $peoplesvalue['y_point'];
      
              $tagUser_id = $peoplesvalue['user_id'];

              $tagpeopleexistnser = $this->db->query("SELECT * FROM foot_posts_people_tags where post_id='$post_id' and user_id='$tagUser_id'");
                 $tagpeopleexistnserdata =  $tagpeopleexistnser->row();

              if($tagpeopleexistnserdata)
              {
                $setdataspeople = array(  
                    'tag_status'=>'active',
                    'x_point'=>$x_point,
                    'y_point'=>$y_point
                  );
                 $this->db->where('tag_id', $tagpeopleexistnserdata->tag_id);
                $this->db->update('foot_posts_people_tags', $setdataspeople); 
              }

             else 
              {
              $x_point = $peoplesvalue['x_point'];
              $y_point = $peoplesvalue['y_point'];
                 $datasPeople = array(  

                 'user_id' => $tagUser_id,
                 'x_point' => $x_point,
                 'y_point' => $y_point,
                 'post_id' => $post_id,
                 'tag_status' => 'active',
                 'date_of_creation' => date('Y-m-d H:i:s')            

                 ); 
               
                $this->db->insert('foot_posts_people_tags', $datasPeople); 


              $NotificationUserDetail = $this->User_model->single_users_detail($tagUser_id);
 
           
              $myUserDetail = $this->User_model->single_users_detail($user_id);

              $device_type =  $NotificationUserDetail->device_type;
              $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshot.");

                 $action = "post_detail";
                 $value['user_id'] = $user_id;
                 $value['other_user_id'] = "$post_id";
                 $value['other_user_name'] = $myUserDetail->fullname;

                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
                 $value['total_unread_notification'] =$total_unread_notification;

                 $badge = 1;

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

                         'user_id' => $tagUser_id,

                         'from_id' => $user_id,     

                         'timeline_id' => $post_id,

                         'notification_type' =>  "post_tag",
                     
                         'read_status' =>'0',

                         'date_of_notification'=> date('Y-m-d H:i:s'), 

                        );

                            $this->db->insert('foot_notification', $data);   
                  }
                }
                  
             }

             $dataspeople = array(  
        'product_status'=>'remove'
      );
     $this->db->where('post_id', $post_id);
    $this->db->update('foot_post_product', $dataspeople); 

      foreach ($tag_products as $valueProducts) 
              {
                  $produCtName = $valueProducts['product_name'];
                 $x_point = $valueProducts['x_point'];

              $y_point = $valueProducts['y_point'];
              
                    $this->db->select('*');                                   /*select recently updated user data */ 

                      $this->db->from('foot_products'); 


                      $where = "product_name= '".$produCtName."'";
                   
                      $this->db->where($where);

                      $query = $this->db->get();

                      $resultProducts = $query->result();    

                      if($resultProducts)
                      {
                        $produ = array_shift($resultProducts);

                        $product_id = $produ->product_id;
                      }
                      else
                      {

                         $datasProducts = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_name' => $produCtName,          
                         'last_update' => date('Y-m-d H:i:s')           

                         ); 
                       
                        $this->db->insert('foot_products', $datasProducts);

                         $product_id = $this->db->insert_id();
                      }



                         $datasProductsid = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_id' => $product_id,         
                         'x_point' => $x_point,         
                         'y_point' => $y_point,         
                         'post_id' => $post_id,         
                         'product_status' => 'active',         
                         'date_of_creation' =>date('Y-m-d H:i:s')          

                         ); 
                       
                        $this->db->insert('foot_post_product', $datasProductsid);
                     

                    }              
     
 

            if($post_id){ 

              $dataUsers = array(

                 'total_post' => $total_post,
          
                 );

           $this->db->where('user_id', $user_id);

            $this->db->update('foot_app_users', $dataUsers); 


             $datashashtags = array(  
                'hashstatus'=>'remove'
              );
             $this->db->where('post_id', $post_id);
            $this->db->update('foot_post_tag', $datashashtags);


             preg_match_all('/(?<!\w)#\w+/',$post_caption,$matches);
 
           foreach ($matches[0] as   $value) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$value' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $value,     

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

              $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$post_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                $datatag = array(                                                      /*An array of data to insert into table*/

                 'post_id' => $post_id,

                 'tag_id' => $tag_id,      
                 'hashstatus' => 'active',      

                 'date_of_creation'=> date('Y-m-d H:i:s') 

                 ); 

                $this->db->insert('foot_post_tag', $datatag);
              }

               
                                            
           }
        
        preg_match_all('/(?<!\w)@\w+/',$post_caption,$matchesUser);
                
 
                 foreach ($matchesUser[0] as   $value) {


                  $value = str_replace("@", "", $value);
                  
                  $NotificationUserDetail = $this->User_model->single_username_detail($value);
                  if (!empty($NotificationUserDetail)) 
                  {
 
                    # code...

                      $notificunser = $this->db->query("SELECT * FROM foot_post_at_tagging where user_id='$user_id' and post_id='$post_id'  ");
                 $total_tags =  $notificunser->num_rows();
                 if($total_tags==0)
                 {
                  
                  
                  $tagUser_id = $NotificationUserDetail->user_id;


                   $datastags = array(                                                      /*An array of data to insert into table*/ 

                     'user_id' => $user_id,
                     'post_id' => $post_id,
                     'creation_date' => date('Y-m-d H:i:s')
                 

                     ); 
                   
                    $this->db->insert('foot_post_at_tagging', $datastags);  

             
               
                  $myUserDetail = $this->User_model->single_users_detail($user_id);

                  $device_type =  $NotificationUserDetail->device_type;
                  $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshot.");

                 $action = "post_detail";
                 $values['user_id'] = $user_id;
                 $values['other_user_id'] = "$post_id";
                 $values['other_user_name'] = $myUserDetail->fullname;

                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
                 $values['total_unread_notification'] =$total_unread_notification;

                 $badge = 1;

         
              $badge = $NotificationUserDetail->badge+1;

               $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                $this->db->query($sql);


                 if($NotificationUserDetail->user_id!=$user_id)
                 {  
 
                           if($device_token!="")
                           {
                             if($device_type=='ios')
                             {
                                send_message_ios($device_token,$message,$badge,$action,$values);
                             }
                             if($device_type=='android')
                             {
                                  send_notification_android($device_token,$message,$action,$values);
                             }
                          }



                             $data = array(  

                             'user_id' => $tagUser_id,

                             'from_id' => $user_id,     

                             'timeline_id' => $post_id,

                             'notification_type' =>  "post_tag",
                         
                             'read_status' =>'0',

                             'date_of_notification'=> date('Y-m-d H:i:s'), 

                            );

                                $this->db->insert('foot_notification', $data);   
                      }
                    }
                  }
                  }

  
      return $post_id;                                                 /*return data of user to the controller which call this function  */            

 
    }
    else
    {
      return 0;  
    }



  }public function edit_post($data)

  { 
 
 
    $user_id =  $data->user_id;
 
    $post_caption =  $data->post_caption;

    $location_address =  $data->location_address;

    $location_latitude =  $data->location_latitude;

    $location_longitude =  $data->location_longitude;
    

    $postal_code =  $data->postal_code;

    $total_post =  $data->total_post;

    $tag_peoples =  $data->tag_peoples;

    $tag_products =  $data->tag_products;


    $tag_products =  $data->tag_products;


    $country =  $data->country;

    $state =  $data->state;

    $city =  $data->city;

    $fulladdress =  $data->fulladdress;
    $is_private =  $data->is_private;
    $post_id =  $data->post_id;

      $country_id="";

                $this->db->select('*');                                   /*select recently updated user data */ 

                $this->db->from('foot_country'); 


                $where = "country_name= '".$country."'";
             
                $this->db->where($where);

                $query = $this->db->get();

                $resultCountry = $query->result();    

                if($resultCountry)
                {
                  $contry = array_shift($resultCountry);

                  $country_id = $contry->id;
                }

    $dataspeople = array(  
        'tag_status'=>'remove'
      );
     $this->db->where('post_id', $post_id);
     
    $this->db->update('foot_posts_people_tags', $dataspeople);              



    $datas = array(                                                      /*An array of data to insert into table*/
                          

     'user_id' => $user_id,
     'post_caption' => $post_caption,
     'address' => $location_address,
     'fulladdress' => $fulladdress,
     'postal_code' => $postal_code,
     'city' => $city,
     'state' => $state,
     'country' => $country_id,
     'lat' => $location_latitude,
     'lng' => $location_longitude,
     'is_private' => $is_private, 
  
     ); 
    $this->db->where('post_id', $post_id);
    $this->db->update('foot_posts', $datas); 

 
    

     $post_id = $post_id;

     $notiPOSTID = $post_id;



    foreach ($tag_peoples as $peoplesvalue) 
            {
      
              $tagUser_id = $peoplesvalue['user_id'];

              $tagpeopleexistnser = $this->db->query("SELECT * FROM foot_posts_people_tags where post_id='$post_id' and user_id='$tagUser_id'");
                 $tagpeopleexistnserdata =  $tagpeopleexistnser->row();

              if($tagpeopleexistnserdata)
              {
                $setdataspeople = array(  
                    'tag_status'=>'active'
                  );
                 $this->db->where('tag_id', $tagpeopleexistnserdata->tag_id);
                $this->db->update('foot_posts_people_tags', $setdataspeople); 
              }

             else 
              {
              $x_point = $peoplesvalue['x_point'];
              $y_point = $peoplesvalue['y_point'];
                 $datasPeople = array(  

                 'user_id' => $tagUser_id,
                 'x_point' => $x_point,
                 'y_point' => $y_point,
                 'post_id' => $post_id,
                 'tag_status' => 'active',
                 'date_of_creation' => date('Y-m-d H:i:s')            

                 ); 
               
                $this->db->insert('foot_posts_people_tags', $datasPeople); 


              $NotificationUserDetail = $this->User_model->single_users_detail($tagUser_id);
 
           
              $myUserDetail = $this->User_model->single_users_detail($user_id);

              $device_type =  $NotificationUserDetail->device_type;
              $device_token =  $NotificationUserDetail->device_token;

                $message = $this->decodeEmoticons($myUserDetail->fullname." tagged you in a footshot.");

                 $action = "post_detail";
                 $value['user_id'] = $user_id;
                 $value['other_user_id'] = "$post_id";
                 $value['other_user_name'] = $myUserDetail->fullname;

                 $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$tagUser_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
                 $value['total_unread_notification'] =$total_unread_notification;

                 $badge = 1;

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

                         'user_id' => $tagUser_id,

                         'from_id' => $user_id,     

                         'timeline_id' => $post_id,

                         'notification_type' =>  "post_tag",
                     
                         'read_status' =>'0',

                         'date_of_notification'=> date('Y-m-d H:i:s'), 

                        );

                            $this->db->insert('foot_notification', $data);   
                  }
                }
                  
             }

             $dataspeople = array(  
        'product_status'=>'remove'
      );
     $this->db->where('post_id', $post_id);
    $this->db->update('foot_post_product', $dataspeople); 

      foreach ($tag_products as $valueProducts) 
              {
                  $produCtName = $valueProducts['product_name'];
                 $x_point = $valueProducts['x_point'];

              $y_point = $valueProducts['y_point'];
              
                    $this->db->select('*');                                   /*select recently updated user data */ 

                      $this->db->from('foot_products'); 


                      $where = "product_name= '".$produCtName."'";
                   
                      $this->db->where($where);

                      $query = $this->db->get();

                      $resultProducts = $query->result();    

                      if($resultProducts)
                      {
                        $produ = array_shift($resultProducts);

                        $product_id = $produ->product_id;
                      }
                      else
                      {

                         $datasProducts = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_name' => $produCtName,          
                         'last_update' => date('Y-m-d H:i:s')           

                         ); 
                       
                        $this->db->insert('foot_products', $datasProducts);

                         $product_id = $this->db->insert_id();
                      }



                         $datasProductsid = array(                                                      /*An array of data to insert into table*/
                                  

                         'product_id' => $product_id,         
                         'x_point' => $x_point,         
                         'y_point' => $y_point,         
                         'post_id' => $post_id,         
                         'product_status' => 'active',         
                         'date_of_creation' =>date('Y-m-d H:i:s')          

                         ); 
                       
                        $this->db->insert('foot_post_product', $datasProductsid);
                     

                    }              
     
 

            if($post_id){ 

              $dataUsers = array(

                 'total_post' => $total_post,
          
                 );

           $this->db->where('user_id', $user_id);

            $this->db->update('foot_app_users', $dataUsers); 


             $datashashtags = array(  
                'hashstatus'=>'remove'
              );
             $this->db->where('post_id', $post_id);
            $this->db->update('foot_post_tag', $datashashtags);


             preg_match_all('/(?<!\w)#\w+/',$post_caption,$matches);
 
           foreach ($matches[0] as   $value) {

             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$value' ");

              $resultTage = $query->row();

              if($resultTage)
              {
                $tag_id = $resultTage->user_id;
              }
              else
              {

                 $datahash = array(                                                      /*An array of data to insert into table*/

                 'useremail' => '',

                 'fullname' => $value,     

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

              $query  = $this->db->query("SELECT * FROM foot_post_tag WHERE post_id = '$post_id' and tag_id='$tag_id' ");

              $resultTages = $query->row();

              if(empty($resultTages))
              {
                $datatag = array(                                                      /*An array of data to insert into table*/

                 'post_id' => $post_id,

                 'tag_id' => $tag_id,      
                 'hashstatus' => 'active',      

                 'date_of_creation'=> date('Y-m-d H:i:s') 

                 ); 

                $this->db->insert('foot_post_tag', $datatag);
              }

               
                                            
           }
   

  
      return $post_id;                                                 /*return data of user to the controller which call this function  */            

 
    }
    else
    {
      return 0;  
    }



  }
   public function total_post( )
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_posts');

    $this->db->where('post_status','active');
    $query = $this->db->get();


    $result = $query->num_rows();

    return $result;

  }
   public function total_post_month_year($yearMonh)
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_posts');

    $where = " DATE_FORMAT(date_of_creation,'%Y-%m') ='$yearMonh' and post_status='active'";
   $this->db->where($where);

   // $this->db->where('post_status','active');
    $query = $this->db->get();


  
    $result = $query->num_rows();

    return $result;

  }


   public function all_posts_list()
  {
      $this->db->select('*');
     
      $this->db->from('foot_posts'); 
     
      $query = $this->db->get();
     
     $resultPosts = $query->result(); 
 

     return $resultPosts;
  }

  public function month_posts_list()
  {
      $this->db->select('foot_posts.*,foot_of_month.date_of_post');
     
      $this->db->from('foot_posts'); 

      $this->db->join('foot_of_month','foot_of_month.post_id = foot_posts.post_id '); 
     
      $query = $this->db->get();
     
     $resultPosts = $query->result();
 

     return $resultPosts;
  }
 public function all_tags_list()
  {
      $this->db->select('*');
     
      $this->db->from('foot_products'); 
     
      $query = $this->db->get();
     
     $resultPosts = $query->result(); 

     $re= array();
      foreach ($resultPosts as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_post_product where product_id='$value->product_id' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_tags = $total_report;

            $re[] = $value;
        }

 

     return $re;
  }


   public function random_post_list($data)
  {
         $start =  $data->post_value;
         $user_id =  $data->user_id;
         $limit= 20;

      /*  $this->db->select('foot_posts.*');                               
        $this->db->from('foot_posts'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 
        $where = "post_status= 'active'";
     
        $this->db->where($where);
        $this->db->order_by("post_id", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get();*/

       // echo "SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id join foot_follow ON foot_follow.to_id = foot_app_users.user_id  where post_status= 'active' and  foot_follow.from_id = '$user_id'  order by post_id desc limit $start,$limit";

        //$query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id join foot_follow ON foot_follow.to_id = foot_app_users.user_id  where post_status= 'active' and ( foot_follow.from_id = '$user_id' or foot_app_users.user_id = '$user_id' ) and foot_follow.follow_status='active'  group by post_id  order by post_id desc limit $start,$limit");

        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active' and ( foot_app_users.user_id = '$user_id' or foot_posts.user_id in (select to_id from  foot_follow  where foot_follow.from_id='$user_id' and foot_follow.follow_status='active' ) )  group by post_id  order by post_id desc limit $start,$limit");



        $resultPosts = $query->result();  
        $re = array();
        foreach ($resultPosts as   $value) {

        
          $post_id = $value->post_id;
          
            $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }

           
          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
               $value->footshot_of_month =0;
                
             $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }

              
             

          }



           
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;


           $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;



           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;



           $re[] = $value;
           
        }
        return $re;

  }

   public function advs_url_Detail($post_id)
  {
         $this->db->select('foot_adds_links.title,foot_adds_links.adv_url');

          $this->db->from('foot_adds_links'); 

          $where = " url_post_id='$post_id' ";
       
          $this->db->where($where);  

          $query = $this->db->get(); 
          


          $result = $query->row();

          return $result;
  }
  public function random_new_post_list($data)
  {
         $start =  $data->post_value;
         $user_id =  $data->user_id;
         $limit= 20;

    $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "from_id= '".$user_id."' and  follow_status='active' ";

              $this->db->where($where);

              $query = $this->db->get();
  
              $result = $query->result_array();
          if($result[0]['following'] == 1 || $result[0]['following'] == 0)
          {
            $this->db->select('*');               /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "from_id= '".$user_id."' and  follow_status='active' ";

              $this->db->where($where);

              $query = $this->db->get();
  
              $result1 = $query->result_array();
              if($result1)
              {
              		if($result1[0]['to_id'] == '108')
                    {
                		$query = $this->db->query("SELECT foot_posts.* FROM foot_posts where post_status= 'active' and post_type= 'post' order by post_id desc limit $start,$limit");
                		$resultPosts = $query->result(); 
              		}
              		else{
                    	$query = $this->db->query("SELECT foot_posts.* FROM foot_posts where post_status= 'active' and post_type= 'post' order by post_id desc limit $start,$limit");
                    	$resultPosts = $query->result(); 
                  	}
              }
 			 else{
                $query = $this->db->query("SELECT foot_posts.* FROM foot_posts where post_status= 'active' and post_type= 'post' order by post_id desc limit $start,$limit");
                $resultPosts = $query->result();
              }
               
          }else
          {
            $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active' and ( foot_app_users.user_id = '$user_id' or foot_posts.user_id in (select to_id from  foot_follow  where foot_follow.from_id='$user_id' and foot_follow.follow_status='active' ) )  group by post_id  order by post_id desc limit $start,$limit");
            $resultPosts = $query->result();  
          }
        $re = array();
        // $resultPosts = $query->result();  
        foreach ($resultPosts as   $value) {

        
          $post_id = $value->post_id;
          
            $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;
      $value->url_detail = new stdClass();
      $value->url_detail->title="";
      $value->url_detail->adv_url="";


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }

           
          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
               $value->footshot_of_month =0;
                
             $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }

              
             

          }



           
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;


           $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;



           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;



           $re[] = $value;
           

           
        }
        return $re;

  }

  public function random_new_advs_list($data,$addsID)
  {
         $start =  $data->post_value;
         $user_id =  $data->user_id;
         $views_ads =  $data->views_ads;
         $whr = "";
         $adv ="";

         if(!empty($addsID))
         {
          $adv = implode(",", $addsID);
        }

         if(!empty($views_ads))
         {
          if(!empty($addsID))
           {
             $views_ads.=",".$adv;
            }

          $whr = ' post_id NOT IN ('.$views_ads.') and ';
         }
         else
         {
          if(!empty($addsID))
           { 
            $whr = ' post_id NOT IN ('.$adv.') and ';
            }
         }
          

         $limit= 20;

         $currentday = date("l");
         $currentdate = date("j");
   

       // $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'addv' and foot_app_users.status='Active' and foot_posts.post_id not in (select foot_hide_post.post_id from foot_hide_post where user_id='$user_id')  and foot_posts.post_id in (select foot_adds_links.url_post_id from foot_adds_links where status_of_add='approved')   group by post_id  order by rand()");

        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id join foot_adds_links on foot_adds_links.url_post_id =foot_posts.post_id   WHERE $whr post_status= 'active' AND status_of_add='approved' and post_type= 'addv' and foot_app_users.status='Active' and foot_posts.post_id and case when date_of_frequency='daily' then TRUE when date_of_frequency='once_in_month' then (select count(*) from foot_adds_links WHERE `day`='$currentdate' and foot_adds_links.url_post_id=foot_posts.post_id) > 0  when date_of_frequency='once_in_week' then (select count(*) from foot_adds_links WHERE `day`='$currentday' and foot_adds_links.url_post_id=foot_posts.post_id) > 0 else false end  group by post_id  order by date_of_approval desc");


 
        $value = $query->row();  
        $re = array();
        
        if(empty($value))
        {
          return array();
        }
        
          $post_id = $value->post_id;
          
            $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }

           
          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
               $value->footshot_of_month =0;
                
             $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }

              
             

          }



           
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;


           $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;



           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;



           
        return $value;

  }

  public function search_product_post_list($data)
  {
         $start =  $data->post_value;
         
         $user_id =  $data->user_id;
         
         $search_text =  $data->search_text;

         $limit= 20;

         $re = array();

          $query  = $this->db->query("SELECT * FROM foot_products WHERE product_name COLLATE latin1_general_cs = '$search_text' ");

          $resultProduct = $query->row();  

          if(empty($resultProduct))
          {     
                return $re;
          }
         $product_id = $resultProduct->product_id;


        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post'  and foot_posts.post_id IN (select post_id from foot_post_product where foot_post_product.product_id='$product_id') and foot_app_users.status='Active'   and  (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and user_id=foot_app_users.user_id and block_status='active') or (other_user_id=foot_app_users.user_id and user_id='".$user_id."' and block_status='active')  )  ='0' and case WHEN foot_posts.user_id= '".$user_id."' THEN  true   WHEN foot_posts.is_private = '1' then (select count(*) from foot_follow where from_id='$user_id' and to_id=foot_app_users.user_id and follow_status='active') > 0  else true end group by post_id  order by post_id desc limit $start,$limit");

 
        $resultPosts = $query->result();  
        
        foreach ($resultPosts as   $value) {

        
          $post_id = $value->post_id;
          
          $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }

          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }
           
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

            $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  }
   public function total_search_product_post_list($data)
  {
         $start =  $data->post_value;
         
         $user_id =  $data->user_id;
         
         $search_text =  $data->search_text;

         $limit= 20;

         $re = array();

          $query  = $this->db->query("SELECT * FROM foot_products WHERE product_name COLLATE latin1_general_cs = '$search_text' ");

          $resultProduct = $query->row();  

          if(empty($resultProduct))
          {     
                return 0;
          }
         $product_id = $resultProduct->product_id;


        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active'  and foot_posts.post_id IN (select post_id from foot_post_product where foot_post_product.product_id='$product_id')    and  (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and user_id=foot_app_users.user_id and block_status='active') or (other_user_id=foot_app_users.user_id and user_id='".$user_id."' and block_status='active')  )  ='0' and case WHEN foot_posts.user_id= '".$user_id."' THEN  true  WHEN foot_posts.is_private = '1' then (select count(*) from foot_follow where from_id='$user_id' and to_id=foot_app_users.user_id and follow_status='active') > 0  else true end group by post_id  order by post_id desc   ");



        $resultPosts = $query->num_rows();  
        return $resultPosts;

  }




  public function search_tag_post_list($data)
  {
         $start =  $data->post_value;
         
         $user_id =  $data->user_id;
         
         $search_text =  $data->search_text;

         $limit= 20;

         $re = array();

          $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$search_text' ");

          $resultProduct = $query->row();  

          if(empty($resultProduct))
          {     
                return $re;
          }
         $product_id = $resultProduct->user_id;


        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active' and foot_posts.post_id IN (select post_id from foot_post_tag where foot_post_tag.tag_id='$product_id')    and  (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and user_id=foot_app_users.user_id and block_status='active') or (other_user_id=foot_app_users.user_id and user_id='".$user_id."' and block_status='active')  )  ='0' and case WHEN foot_posts.user_id= '".$user_id."' THEN  true   WHEN foot_posts.is_private = '1' then (select count(*) from foot_follow where from_id='$user_id' and to_id=foot_app_users.user_id and follow_status='active') > 0  else true end group by post_id  order by post_id desc limit $start,$limit");

 
        $resultPosts = $query->result();  
        
        foreach ($resultPosts as   $value) {

        
          $post_id = $value->post_id;
          
          $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }

          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }

          }
           
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

            $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  }



  public function  saved_post_list($data)
  {
         $start =  $data->post_value;
         
         $user_id =  $data->user_id; 
         $limit= 20;

         


        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post'  and foot_app_users.status='Active' and foot_posts.post_id IN (select post_id from foot_save where foot_save.user_id='$user_id' and save_status='active')    and  (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and user_id=foot_app_users.user_id and block_status='active') or (other_user_id=foot_app_users.user_id and user_id='".$user_id."' and block_status='active')  )  ='0' and case WHEN foot_posts.user_id= '".$user_id."' THEN  true   WHEN foot_posts.is_private = '1' then (select count(*) from foot_follow where from_id='$user_id' and to_id=foot_app_users.user_id and follow_status='active') > 0  else true end group by post_id  order by post_id desc limit $start,$limit");

 
        $resultPosts = $query->result();  
        
        foreach ($resultPosts as   $value) {

        
          $post_id = $value->post_id;
          
          $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }
           
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }

          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

            $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  }
   public function total_search_tag_post_list($data)
  {
         $start =  $data->post_value;
         
         $user_id =  $data->user_id;
         
         $search_text =  $data->search_text;

         $limit= 20;

         $re = array();

          $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$search_text' ");

          $resultProduct = $query->row();  

          if(empty($resultProduct))
          {     
                return $re;
          }
         $product_id = $resultProduct->user_id;


        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active' and foot_posts.post_id IN (select post_id from foot_post_tag where foot_post_tag.tag_id='$product_id')    and  (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and user_id=foot_app_users.user_id and block_status='active') or (other_user_id=foot_app_users.user_id and user_id='".$user_id."' and block_status='active')  )  ='0' and case WHEN foot_posts.user_id= '".$user_id."' THEN  true  WHEN foot_posts.is_private = '1' then (select count(*) from foot_follow where from_id='$user_id' and to_id=foot_app_users.user_id and follow_status='active') > 0  else true end group by post_id  order by post_id desc   ");



        $resultPosts = $query->num_rows();  
        return $resultPosts;

  }

  public function my_post($data)
  {
      $user_id =  $data->user_id;
      $post_id =  $data->post_id;

      $this->db->select('foot_posts.*');                                

        $this->db->from('foot_posts'); 
    


        $where = "post_id= '$post_id' and user_id='$user_id' ";
     
        $this->db->where($where); 


        $query = $this->db->get();
           
        $resultPosts = $query->row(); 

        if($resultPosts)
        {
          return 1;
        }
        else
        {
          return 0;
        }
  }

   public function search_post_list($data)
  {
         $start =  $data->post_value;
         $user_id =  $data->user_id;
         $search_text =  $data->search_text;
         $limit= 20;

   /*     $this->db->select('foot_posts.*');                                

        $this->db->from('foot_posts'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 


        $where = "post_status= 'active' and (foot_app_users.fullname LIKE'%$search_text%'  or post_caption LIKE'%$search_text%'    or  address LIKE'%$search_text%')";
     
        $this->db->where($where);
        $this->db->order_by("post_id", "desc");
         $this->db->limit($limit, $start);


        $query = $this->db->get();*/

       // $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id join foot_follow ON foot_follow.to_id = foot_app_users.user_id  where post_status= 'active' and  foot_follow.from_id = '$user_id' and foot_follow.follow_status='active'  and (foot_app_users.fullname LIKE'%$search_text%'  or post_caption LIKE'%$search_text%'    or  address LIKE'%$search_text%') order by post_id desc limit $start,$limit"); 
      

       //$query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id    where post_status= 'active'     and (foot_app_users.fullname LIKE'%$search_text%'  or post_caption LIKE'%$search_text%'    or  address LIKE'%$search_text%')    order by post_id desc limit $start,$limit");
 

        $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active'    and (foot_app_users.fullname LIKE'%$search_text%'  or post_caption LIKE'%$search_text%'    or  address LIKE'%$search_text%') and  (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and user_id=foot_app_users.user_id and block_status='active') or (other_user_id=foot_app_users.user_id and user_id='".$user_id."' and block_status='active')  )  ='0' and case when foot_posts.is_private = '1' then (select count(*) from foot_follow where from_id='$user_id' and to_id=foot_app_users.user_id and follow_status='active') > 0  else true end group by post_id  order by post_id desc limit $start,$limit");



        $resultPosts = $query->result();  
        $re = array();
        foreach ($resultPosts as   $value) {

        
          $post_id = $value->post_id;
          
          $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }
           
           $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }

         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

            $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  }

   public function all_hash_posts_list($tag_id)
  {

       

        $this->db->select('foot_posts.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_posts');  
        $this->db->join('foot_post_tag','foot_post_tag.post_id =foot_posts.post_id '); 

          $where = "tag_id= '$tag_id' and post_status= 'active'  ";

      
     
        $this->db->where($where);
        $this->db->order_by("post_id", "desc");
        

        $query = $this->db->get();

        $resultPosts = $query->result();  
        $re = array();
        foreach ($resultPosts as   $value) {

          
          $post_id = $value->post_id;
          $value->post_image_url = base_url().$value->post_image_url;
            $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;

           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();

          $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          } 

          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }

             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


              $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
 

           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  
  }
  public function all_product_posts_list($product_id)
  {

       

        $this->db->select('foot_posts.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_posts');  
        $this->db->join('foot_post_product','foot_post_product.post_id =foot_posts.post_id '); 

 $where = "product_id= '$product_id' and post_status= 'active'  ";

      
     
        $this->db->where($where);
        $this->db->order_by("post_id", "desc");
        

        $query = $this->db->get();

        $resultPosts = $query->result();  
        $re = array();
        foreach ($resultPosts as   $value) {

          
          $post_id = $value->post_id;
          $value->post_image_url = base_url().$value->post_image_url;
            $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;

           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();

          $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          } 

          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }

             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


              $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
 

           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  
  }
  public function users_admin_post_list($user_id)
  {
       

        $this->db->select('foot_posts.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_posts');  

        $where = "post_status= 'active' and foot_posts.user_id='$user_id' and post_type= 'post' ";
     
        $this->db->where($where);
        $this->db->order_by("post_id", "desc");
        

        $query = $this->db->get();

        $resultPosts = $query->result();  
        $re = array();
        foreach ($resultPosts as   $value) {

          
          $post_id = $value->post_id;
          $value->post_image_url = base_url().$value->post_image_url;
            $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;

           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();

          $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          } 

          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }

             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


              $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
 

           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  } 

  public function users_post_list($data)
  {
         $start =  $data->post_value;
         $user_id =  $data->user_id;
         $other_user_id =  $data->other_user_id;

         $limit= 30;

         if($user_id==$other_user_id)
         {
            $this->db->select('foot_posts.*');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 


            $where = "post_status= 'active' and foot_posts.user_id='$other_user_id' and post_type= 'post' ";
         
            $this->db->where($where);
            $this->db->order_by("post_id", "desc");
             $this->db->limit($limit, $start);


            $query = $this->db->get();
        }
        else
        {

           $userDetail = $this->User_model->single_users_detail($other_user_id);

           if($userDetail->is_private=='1')
           {

              $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and    foot_posts.user_id='$other_user_id'  and foot_app_users.user_id IN (SELECT to_id from  foot_follow where foot_follow.to_id = '$other_user_id'  and  foot_follow.from_id = '$user_id' and foot_follow.follow_status='active' ) order by post_id desc limit $start,$limit");
            }
            else
            {
               $query = $this->db->query("SELECT foot_posts.* FROM foot_posts join foot_app_users on foot_app_users.user_id =foot_posts.user_id   where post_status= 'active' and post_type= 'post' and  foot_posts.user_id='$other_user_id'  order by post_id desc limit $start,$limit");
            }
        }



        $resultPosts = $query->result();  
        $re = array();
        foreach ($resultPosts as   $value) {

           $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$other_user_id);
                  
            $value->user_detail = $resultuser;

          
          $post_id = $value->post_id;
          $value->post_image_url = base_url().$value->post_image_url;
            $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
           $value->date_dfference = $difference;

           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

             $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();

          $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          } 

          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }

          }

             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


              $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }

               $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

            $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
         // $re[]=$userDetail;
        return $re;

  } 

  public function users_tag_post_list($data)
  {
         $start =  $data->post_value;
         $user_id =  $data->user_id;
          $other_user_id =  $data->other_user_id;
         $limit= 20;
/*
        $this->db->select('foot_posts.*,foot_app_users.fullname,foot_app_users.profileimage');                                    

        $this->db->from('foot_posts_people_tags'); 
        $this->db->join('foot_posts','foot_posts_people_tags.post_id =foot_posts.post_id '); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 


        $where = "and post_type= 'post'  and foot_posts_people_tags.user_id='$other_user_id'";
     
        $this->db->where($where);
        $this->db->order_by("post_id", "desc");
         $this->db->limit($limit, $start);


        $query = $this->db->get();*/


        $query = $this->db->query("SELECT foot_posts.*,foot_app_users.fullname,foot_app_users.profileimage FROM foot_posts_people_tags join foot_posts on foot_posts_people_tags.post_id =foot_posts.post_id  join foot_app_users on foot_app_users.user_id =foot_posts.user_id join foot_follow ON foot_follow.to_id = foot_app_users.user_id  where post_status= 'active' and post_type= 'post' and foot_app_users.status='Active' and  foot_follow.from_id = '$user_id' and foot_follow.follow_status='active' and foot_posts_people_tags.user_id='$other_user_id' order by post_id desc limit $start,$limit");


        $resultPosts = $query->result();  
        $re = array();
        foreach ($resultPosts as   $value) {

           $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$other_user_id);
                  
            $value->user_detail = $resultuser;

          $post_id = $value->post_id;
          $value->post_image_url = base_url().$value->post_image_url;
            $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
      $value->date_dfference = $difference;

           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.fullname,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= $post_id and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id and product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

         $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;
           
            $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();

          $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }
           
  
          $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }

             $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


              $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }

               $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

            $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

           $re[] = $value;
           
        }
        return $re;

  }

  public function new_timeline_detail_for($timeline_id,$user_id,$comment_id=0)
  {

      $this->db->select('foot_posts.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_posts'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 


        $where = "post_status= 'active' and post_id='$timeline_id'";
     
        $this->db->where($where);      

        $query = $this->db->get();

        $value = $query->row();  
  
        
          $post_id = $value->post_id;
          
            $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);
           
          $difference = $first_date->diff($second_date);
  
          $difference = $this->new_format_interval($difference);
         
          $value->date_dfference = $difference;
            $value->url_detail = new stdClass();
          $value->url_detail->title="";
          $value->url_detail->adv_url="";


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= '$post_id' and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();
            
           $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id  and foot_post_product.product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

          $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }
           
           $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }

          
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

           if($comment_id!=0)
           {
          
             $value->comment_detail = $this->Comment_model->single_comment($comment_id,$user_id);
           }

           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;
           
           return $value;

  
  }
  public function timeline_detail_for($timeline_id,$user_id,$comment_id=0)
  {
      $this->db->select('foot_posts.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_posts'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 
        // $this->db->join('foot_country','foot_country.id =foot_posts.country '); 


        $where = "post_status= 'active' and post_id='$timeline_id'";
     
        $this->db->where($where);      

        $query = $this->db->get();
        $result=$query->result();
        if($result)
        {
        $value = $query->row();  
  
        
          $post_id = $value->post_id;
          
            $comment_user_id = $value->user_id;
 
            $resultuser = $this->User_model->user_personal_detail($comment_user_id,$user_id);
                  
            $value->user_detail = $resultuser;

          $value->post_image_url = base_url().$value->post_image_url;
          $current_date = date('Y-m-d H:i:s'); 

          $first_date = new DateTime($value->date_of_creation);
          $second_date = new DateTime($current_date);

          $difference = $first_date->diff($second_date);
          $difference = $this->format_interval($difference);
          $value->date_dfference = $difference;


           $this->db->select('foot_posts_people_tags.*,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');                                   /*select recently updated user data */ 

            $this->db->from('foot_posts_people_tags'); 
            $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts_people_tags.user_id '); 


            $where = "post_id= '$post_id' and tag_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();
            
           $tagsPeople = $query->result(); 

           $value->tags_people = $tagsPeople;


           $this->db->select('foot_post_product.*,foot_products.product_name');                                   /*select recently updated user data */ 

            $this->db->from('foot_post_product'); 
            $this->db->join('foot_products','foot_products.product_id =foot_post_product.product_id '); 


            $where = "post_id= $post_id  and foot_post_product.product_status='active'";
         
            $this->db->where($where);
            $query = $this->db->get();

          $tagsPeople = $query->result(); 

           $value->tags_product = $tagsPeople;

           $queryFoots = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active'");
           $foots =  $queryFoots->num_rows();


           $value->total_foots = $foots;
          if(empty($foots))
          {
            $value->total_foots =0;
          }
           
           $queryFootsmonth = $this->db->query("SELECT * FROM foot_of_month where new_post_id='$post_id'  ");
           $footsmonth =  $queryFootsmonth->num_rows();


           $value->footshot_of_month = $footsmonth;
          if(empty($footsmonth))
          {
            $value->footshot_of_month =0;
            $queryFootsmonthpoint = $this->db->query("SELECT * FROM foot_user_redeem where timeline_id='$post_id'  ");
             $footsmonthpoint =  $queryFootsmonthpoint->num_rows();
             if($footsmonthpoint>0)
             { 
                 $value->footshot_of_month =2;
             }
          }

          
         $queryComments = $this->db->query("SELECT * FROM foot_comments where post_id='$post_id' and comment_type='comment' and  comment_status='active'");
            $comments =  $queryComments->num_rows();


             

            $value->total_comments = $comments;
          if(empty($comments))
          {
            $value->total_comments=0;
          }
           


              $queryFootsyou = $this->db->query("SELECT * FROM foot_likes where post_id='$post_id' and like_type='post' and  like_status='active' and  user_id='$user_id'");
           $footsYou =  $queryFootsyou->num_rows();


           $value->you_like =$footsYou;

            $queryFootssave = $this->db->query("SELECT * FROM foot_save where post_id='$post_id'   and  save_status='active' and  user_id='$user_id'");
           $footssaveYou =  $queryFootssave->num_rows();


           $value->you_save =$footssaveYou;

           if($comment_id!=0)
           {
          
             $value->comment_detail = $this->Comment_model->single_comment($comment_id,$user_id);
           }

           $value->share_url =base_url()."shared/index.php?post_type=post&post_id=".$post_id;

            $value->url_detail = new stdClass();
            $value->url_detail->title="";
            $value->url_detail->adv_url="";
           
           return $value;
        }
  }


  public function timeline_user_detail($timeline_id)
  {
      $this->db->select('foot_app_users.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_posts'); 
        $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 


        $where = "post_status= 'active' and post_id='$timeline_id'";
     
        $this->db->where($where);      

        $query = $this->db->get();
        
        $value = $query->row();  
        
  
        return $value;

  }

   public function report_abouse($data)
  {  
 
      $user_id =  $data->user_id;   
 
      $post_id =  $data->post_id;   


       $this->db->select('foot_post_report.*');
      $this->db->from('foot_post_report'); 
      $where  ="post_id = '$post_id'";
       $this->db->where($where);
      $query = $this->db->get();
      $restults = $query->row();

      if($restults)
      {
        $report_id = $restults->report_id;

          $datas = array(                                                      /*An array of data to insert into table*/
             
             'date_of_creation' => date('Y-m-d H:i:s')  

             ); 
             $where  ="post_id = '$post_id'";
            $this->db->where($where);
            $this->db->update('foot_post_report', $datas);
      }
      else
      {
              $datas = array(                                                      /*An array of data to insert into table*/
             
             'user_id' => $user_id,
             'post_id' => $post_id,
             'date_of_creation' => date('Y-m-d H:i:s')  

             ); 
           
            $this->db->insert('foot_post_report', $datas); 

            $this->db->last_query(); 

             $report_id = $this->db->insert_id();


      }


      $datas = array(                                                      /*An array of data to insert into table*/
       
       'report_id' => $report_id,
       'user_id' => $user_id,
       'post_id' => $post_id,
       'date_of_creation' => date('Y-m-d H:i:s')  

       ); 
     
      $this->db->insert('foot_post_report_list', $datas); 

      $this->db->last_query(); 

       $post_id = $this->db->insert_id();

     

      if($post_id){ 

         
    
        return 0;                                                 /*return data of user to the controller which call this function  */            

   
      }
      else
      {
        return 300;  
      }



  }

  public function report_abouse_list()
  {       
    
        $this->db->select('foot_posts.*,foot_post_report.date_of_creation as date_of_repo,foot_app_users.fullname');
        $this->db->from('foot_post_report');
        $this->db->join('foot_posts','foot_posts.post_id = foot_post_report.post_id');     
        $this->db->join('foot_app_users','foot_app_users.user_id = foot_posts.user_id');     
        $this->db->order_by('foot_post_report.date_of_creation','desc');
        $query = $this->db->get();
        $restults = $query->result();
        $re = array();

        foreach ($restults as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_post_report_list where post_id='$value->post_id' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_report = $total_report;

            $re[] = $value;
        }

        return $re;
  }

    public function report_abouse_detail($post_id)
  {       
    
        $this->db->select('foot_posts.*');
        $this->db->from('foot_posts'); 
         $this->db->where('foot_posts.post_id',$post_id);    
        $query = $this->db->get();
        $restults = $query->result();
        $restults = array_shift($restults);

        return $restults;
  }

   public function blocked_post_detail()
  {       
    
        $this->db->select('foot_posts.*');
        $this->db->from('foot_posts'); 
        $where ="foot_posts.post_status='block'";
          $this->db->where($where); 
        $query = $this->db->get();
        $restults = $query->result();
        $re = array();

        foreach ($restults as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_post_report_list where post_id='$value->post_id' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_report = $total_report;

            $re[] = $value;
        }

        return $re;
  }


    public function report_abouse_user_list($post_id)
  {       
    
        $this->db->select('foot_app_users.fullname,foot_app_users.profileimage,foot_post_report_list.*');
        $this->db->from('foot_post_report_list');
         $this->db->join('foot_app_users','foot_app_users.user_id =foot_post_report_list.user_id ');  
         $this->db->where('foot_post_report_list.post_id',$post_id);   
        $this->db->order_by('foot_post_report_list.list_id','desc');
        $query = $this->db->get();
        $restults = $query->result();
        

        return $restults;
  }
   


  public function search_blank_product_list($data)
  {
               

        $query = $this->db->query("select foot_products.*,(SELECT count(*) as total_product_use FROM foot_post_product where foot_post_product.product_id=foot_products.product_id) as productCount from foot_products order by productCount desc limit 0,9");

        $result = $query->result();

        $newResult = array();

        foreach ($result as   $value) {
 
        $value->productCount = number_format($value->productCount). " footshots";

          $newResult[] = $value;
        }
        return $result;
  }


  public function search_blank_tag_list($data)
  {
               

        $query = $this->db->query("select foot_app_users.fullname,foot_app_users.user_id,(SELECT count(*) as total_tag_use FROM foot_post_tag where foot_post_tag.tag_id=foot_app_users.user_id) as productCount from foot_app_users where user_type='tag' order by productCount desc limit 0,9");

        $result = $query->result();

        $newResult = array();

        foreach ($result as   $value) {
 
        $value->productCount = number_format($value->productCount). " footshots";

          $newResult[] = $value;
        }
        return $result;
  }

  public function search_tag_list($data)
  {
        $search_user_text = $data->search_text;

       /* $start = $data->post_value; */

        $limit =20;

         $this->db->select('foot_app_users.fullname,foot_app_users.user_id'); 

           $this->db->from('foot_app_users'); 

         $where = " fullname LIKE '$search_user_text%' and user_type='tag'";

         $this->db->where($where);

          $this->db->order_by("user_id", "desc");

         /*$this->db->limit($limit, $start);*/

        $query = $this->db->get();

        $result = $query->result();

        $newResult = array();

        foreach ($result as   $value) {



         $this->db->select('*'); 

           $this->db->from('foot_post_tag'); 

         $where = " tag_id = '$value->user_id'";

         $this->db->where($where);
  

        $query = $this->db->get();

        $resultCount = $query->num_rows();
        $value->productCount = number_format($resultCount). " footshots";

          $newResult[] = $value;
        }
        return $result;
  }

  public function search_product_list($data)
  {
        $search_user_text = $data->search_text;

        $start = $data->post_value; 

        $limit =20;

         $this->db->select('foot_products.*'); 

           $this->db->from('foot_products'); 

         $where = " product_name LIKE '$search_user_text%'";

         $this->db->where($where);

          $this->db->order_by("product_id", "desc");

         $this->db->limit($limit, $start);

        $query = $this->db->get();

        $result = $query->result();

        $newResult = array();

        foreach ($result as   $value) {



         $this->db->select('*'); 

           $this->db->from('foot_post_product'); 

         $where = " product_id = '$value->product_id' and product_status='active'";

         $this->db->where($where);
  

        $query = $this->db->get();

        $resultCount = $query->num_rows();
        $value->productCount = number_format($resultCount). " footshots";

          $newResult[] = $value;
        }
        return $result;
  }

  public function vector_data()
  {
      
      $query = $this->db->query("SELECT foot_country.* FROM `foot_country` where id IN (select country from foot_posts where post_status='active' AND country!='') ");

      $countries = $query->result();
      $totalData = "";
    
        foreach($countries as $countiresList)
        { 
          $datamap = array();
              $this->db->select('*');              
              $where = "post_status='active' and country='".$countiresList->id."'";
              $this->db->where($where);
              $query = $this->db->get('foot_posts');
              $num = $query->num_rows();
             
              $countiresList->numrows=$num;
              

              $countiresList->short_name=strtolower($countiresList->short_name);

              $datamap[$countiresList->short_name] = $num;
                

              if(!empty($totalData))
              {
                $totalData .= ",";
              }
              $totalData.= $countiresList->short_name .":".$num;


        }
        return  $totalData;

  }
   public function vector_table_data()
  {
      
      $query = $this->db->query("SELECT foot_country.* FROM `foot_country` where id IN (select country from foot_posts where post_status='active' )");

      $countries = $query->result();
      $totalData = array();
    
        foreach($countries as $countiresList)
        { 
          $datamap = array();
              $this->db->select('*');              
              $where = "post_status='active' and country='".$countiresList->id."'";
              $this->db->where($where);
              $query = $this->db->get('foot_posts');
              $num = $query->num_rows();
             
              $countiresList->numrows=$num;
              
              $totalData [] = $countiresList;
              $countiresList->short_name=strtolower($countiresList->short_name);

               


        }
        return  $totalData;

  }


   public function ajax_list_items($search='',$per_page=10,$start=0) 
    {
        $this->db->select('ch.*', false);
        $this->db->from('foot_products as ch');
        if($search!='')
        {
            $this->db->like('ch.product_name',$search);
        } 
        $this->db->order_by('ch.last_update', 'Desc');
        $this->db->limit($per_page,$start);
       $resultPosts =$this->db->get()->result();
          $re = array();
          foreach ($resultPosts as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_post_product where product_id='$value->product_id' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_tags = $total_report;

            $re[] = $value;
        }

        $data['result'] =  $re;

        $this->db->select("COUNT(ch.product_id) AS count");

        $this->db->from('foot_products as ch');
  $this->db->order_by('ch.last_update', 'Desc');
        if($search!='')
        {
            $this->db->like('ch.product_name',$search);
        }
        $data['count']=$this->db->count_all_results();    
        return $data;
    }



   public function ajax_hash_list_items($search='',$per_page=10,$start=0) 
    {
        $this->db->select('ch.*', false);
        $this->db->from('foot_app_users as ch');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        } 
          $this->db->where('user_type','tag');
        $this->db->order_by('ch.date_of_creation', 'Desc');
        $this->db->limit($per_page,$start);
       $resultPosts =$this->db->get()->result();
          $re = array();
          foreach ($resultPosts as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_post_tag where tag_id='$value->user_id' and hashstatus='active' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_tags = $total_report;

            $re[] = $value;
        }

        $data['result'] =  $re;

        $this->db->select("COUNT(ch.user_id) AS count");

        $this->db->from('foot_app_users as ch');
          $this->db->where('user_type','tag');
  $this->db->order_by('ch.date_of_creation', 'Desc');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        }
        $data['count']=$this->db->count_all_results();    
        return $data;
    }




  /*$this->db->select('foot_posts.*,foot_post_report.date_of_creation as date_of_repo,foot_app_users.fullname');
        $this->db->from('foot_post_report');
        $this->db->join('foot_posts','foot_posts.post_id = foot_post_report.post_id');     
        $this->db->join('foot_app_users','foot_app_users.user_id = foot_posts.user_id');     
        $this->db->order_by('foot_post_report.date_of_creation','desc');
        $query = $this->db->get();
        $restults = $query->result();
        $re = array();

        foreach ($restults as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_post_report_list where post_id='$value->post_id' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_report = $total_report;

            $re[] = $value;
        }*/
       public function ajax_report_abouse_list($search='',$per_page=10,$start=0) 
    {
        $this->db->select('foot_posts.*,ch.date_of_creation as date_of_repo,foot_app_users.fullname', false);
        $this->db->from('foot_post_report as ch');
            $this->db->join('foot_posts','foot_posts.post_id = ch.post_id');     
        $this->db->join('foot_app_users','foot_app_users.user_id = foot_posts.user_id');   
        if($search!='')
        {
            $this->db->like('foot_posts.post_caption',$search);
        } 
        $this->db->order_by('ch.date_of_creation', 'Desc');
        $this->db->limit($per_page,$start);
       $resultPosts =$this->db->get()->result();
          $re = array();
          foreach ($resultPosts as   $value) {
            
           $queryFoots = $this->db->query("SELECT * FROM foot_post_report_list where post_id='$value->post_id' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_report = $total_report;

            $re[] = $value;
        }

        $data['result'] =  $re;

        $this->db->select("COUNT(ch.report_id) AS count");

        $this->db->from('foot_post_report as ch');
          $this->db->join('foot_posts','foot_posts.post_id = ch.post_id');     
        $this->db->join('foot_app_users','foot_app_users.user_id = foot_posts.user_id'); 
  $this->db->order_by('ch.date_of_creation', 'Desc');
        if($search!='')
        {
            $this->db->like('foot_posts.post_caption',$search);
        }
        $data['count']=$this->db->count_all_results();    
        return $data;
    }
  


   public function delete_post($post_id)
  { 
    

     $datas = array(                   /*An array of data to insert into table*/
          'post_status' => "delete"

         );    

        $where = "post_id = '$post_id'  ";
         $this->db->where($where);

        $this->db->update('foot_posts', $datas); 

           return 0; 
  } 

  public function hide_post($data)
  { 
    
    $post_id = $data->post_id;
    $user_id = $data->user_id;
      $datas = array(                                                      /*An array of data to insert into table*/
       
       'user_id' => $user_id,
       'post_id' => $post_id,  
       'hide_type' => "hide", 

       ); 
     
      $this->db->insert('foot_hide_post', $datas); 

      return true;
  }
  public function report_post($data)
  { 
    
    $post_id = $data->post_id;
    $user_id = $data->user_id;
      $datas = array(                                                      /*An array of data to insert into table*/
       
       'user_id' => $user_id,
       'post_id' => $post_id,  
       'hide_type' => "report",  
   

       ); 
     
      $this->db->insert('foot_hide_post', $datas); 

      return true;
  }

  public function add_save($data)

  { 
 
 
    $user_id =  $data->user_id;
  

    $post_id =  $data->post_id;
  
    $this->db->select('foot_save.*');
    $this->db->from('foot_save'); 
    $where = "user_id='$user_id' and post_id='$post_id'  and save_status='active'";
    $this->db->where($where);    
    $query = $this->db->get();
    $restults = $query->result();
    $restultslike = array_shift($restults);

    if($restultslike)
    {
         $datas = array(                                                      /*An array of data to insert into table*/
          'save_status' => "delete"

         );    

        $where = "post_id = '$post_id' and user_id='$user_id'   ";
         $this->db->where($where);

        $this->db->update('foot_save', $datas); 

           return 0; 
    }
    else
    {

      $datas = array(                                                      /*An array of data to insert into table*/
       
       'user_id' => $user_id,
       'post_id' => $post_id, 
       'save_status' => "active",
       'date_of_creation' => date('Y-m-d H:i:s'),
   

       ); 
     
      $this->db->insert('foot_save', $datas); 

      $this->db->last_query(); 

      $post_id = $this->db->insert_id();

         return 1; 

     }
   
  }

}