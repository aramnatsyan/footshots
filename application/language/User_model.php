<?php 

class User_model extends CI_Model {



  public function __construct()

  {

        // Call the Model constructor

    parent::__construct();
    date_default_timezone_set('Asia/Kolkata');
    $this->db->query('SET time_zone="+05:30"');



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


  /*Method to generate password with salt using your password*/



  public function genrate_password($password)                     

  {

    $intermediateSalt = md5('$P$123', true);

     $salt = substr($intermediateSalt, 0,6);

     $password = hash("sha256", $password . $salt);

     return $password;

  }

  

  /*Method to send email to user using send grid api*/

  public function send_email_sendgrid_api($to,$to_names,$subject,$text)

  {



      $curl = curl_init();



      $params=array();

      $params['api_user']="harminderEMX";

      $params['api_key']="Harminder@123";

      $params['from']="no-reply@footshots.com";

      $params['subject']=$subject;

      $params['html']=$text;

      

      $params['to']=$to;

      $params['toname'] = $to_names;

      /*foreach ($to as $value) {

        $params['to[]']=$value;

      }

      foreach ($to_names as $names) {

        $params['toname']=$names;

      }

      */

      $query=http_build_query($params) ;

    curl_setopt_array($curl, array(

      CURLOPT_URL => "https://api.sendgrid.com/api/mail.send.json",

      CURLOPT_RETURNTRANSFER => true,

      CURLOPT_ENCODING => "",

      CURLOPT_MAXREDIRS => 10,

      CURLOPT_TIMEOUT => 30,

      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

      CURLOPT_CUSTOMREQUEST => "POST",

      CURLOPT_POSTFIELDS =>$query,

      CURLOPT_HTTPHEADER => array(

        "cache-control: no-cache",

         ),

    ));



    $response = curl_exec($curl);

    $err = curl_error($curl);



    curl_close($curl);



    return true;
   

  }


  /*Method to check the user exist or not with uid and login_token*/



  public function user_verify($data)

    {
 
      $user_id = $data->user_id;

      $login_token = $data->login_token;

      $this->db->select('*');

      $this->db->from('foot_app_users');

      $where = "user_id='".$user_id."' and login_token='$login_token'";

      $this->db->where($where);

      $query = $this->db->get();


      $result = $query->result();

      

      if($result){ 
 

         $dataUsers = array(

         'last_activity' => date('Y-m-d H:i:s')
         );

        $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $dataUsers); 


         return  $result;

      }

      else

      {

        return 700;

      }

       

  }


public function user_verify_token($data)
  {
 
    $user_id = $data->user_id;

    $login_token = $data->login_token;

    $this->db->select('*');

    $this->db->from('foot_app_users');

    $where = "user_id='".$user_id."' and login_token='$login_token'";

    $this->db->where($where);

    $query = $this->db->get();

    $result = $query->result();

    if($result){
 
       return $result;

    }

    else

    {

      return 700;

    }

     

  }



/*All Users for Admin*/

  public function all_users_list( )
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');

   
    $query = $this->db->get();


    $result = $query->result();

    return $result;

  }

    public function single_users_detail($user_id)
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');

    $this->db->where('user_id',$user_id);

    $query = $this->db->get();


    $result = $query->row();

    //$result = array_shift($result);

      $resultuserpost = $this->user_total_posts($user_id);
                  
      $result->total_post = $resultuserpost;

    $queryFoots = $this->db->query("SELECT * FROM foot_posts where user_id='$user_id'  and  post_status='delete'");
    
    $activePost =  $queryFoots->num_rows();

$result->activePost =$activePost;

 $queryreport = $this->db->query("SELECT * FROM foot_post_report where user_id='$user_id'  ");
    
    $activereportPost =  $queryreport->num_rows();

$result->reportPost =$activereportPost; 


    return $result;

  }





  /*Method to register a new user*/



   public function signup_user($data)
  { 

     


    $password = $data->password;
 


    $fullname =  $data->fullname;
 


    $email =  $data->useremail;

 

    $device_type =  $data->device_type;



    $device_token =  $data->device_token;
    
      $profileimage =  $data->profileimage;;

 

    $password = $this->genrate_password($password);                /*Call Password genreate function to encode user password.*/


    $token = $this->generateRandomString(64);                 /*Call a function to generate random string*/



    $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/



    $this->db->from('foot_app_users');



    $where = "useremail='".$email."' ";



    $this->db->where($where);



    $query = $this->db->count_all_results();



    if($query)

     {

       return  2;                                                        /*Return 2 if  email is already exist*/                         

     }

  


    $data = array(                                                      /*An array of data to insert into table*/

     'useremail' => $email,

     'fullname' => $fullname,     

     'password' => $password,

     'profileimage' => $profileimage,
 
     'status' =>'Active',

     'date_of_creation'=> date('Y-m-d H:i:s'), 

      'login_token' => $token,

      'device_type'=> $device_type,

      'device_token' => $device_token 

     );

 

    $this->db->insert('foot_app_users', $data);                             /* insert data into table*/



    $insert_id = $this->db->insert_id();                               /* Get insert id*/
    $user_id = $insert_id;                               /* Get insert id*/

 
            

    $this->db->select('*');                                      /*select recently registered user data */ 



    $this->db->from('foot_app_users'); 



    $where = "user_id= '".$insert_id."'";



    $this->db->where($where);



    $query = $this->db->get();



    $result = $query->result();

 

    if($result){ 

      $results = array_shift($result);


      $text = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"><tbody><tr>

<td align="center" valign="top">



              <table class="" width="629" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#081575">

                 <tbody>

                   <tr>

                     <td class="" style="min-width:629px;" width="629" align="left"><table class="" width="260" align="left" cellspacing="0" cellpadding="0" border="0">

                       <tbody>

                         <tr>

                          <td>

                           <table class="centerize" style="border-bottom-color:#67bffd; margin-left:0;" cellspacing="0" cellpadding="0" border="0">

                             <tbody>

                               <tr>

                                 <td class="" width="30"></td>

                                 <td style="line-height:1px;" align="center">

                                    <a href="#" target="_blank" style="text-decoration: none;">

                                       <img src="'.base_url().'logo.png" style="display: block;text-decoration: none;border: none; padding: 20px 0 0 !important;" alt="Logo Image" class="" vspace="0" hspace="0" align="top" border="0">

                                    </a>

                                 </td>

                                 <td class="esFrMb" width="30"></td>      

                               </tr>

                             </tbody>

                           </table>

                          </td>

                         </tr>

                       </tbody>

               </table>

               <table class="" width="348" align="right" cellspacing="0" cellpadding="0" border="0">

                  <tbody>

                    <tr>

                      <td colspan="2" style="font-size:0;line-height:0;" height="10">&nbsp;</td>

                    </tr>

                    <tr>

                      <td class="" style="color: #fff;font-size: 18px;text-align: right;line-height: 150%;font-weight: bold;letter-spacing: 2px;" width="318" valign="middle" height="80" align="right">

                       <a href="#" target="_blank" style="text-decoration: none;color: #425065;"></a>&nbsp;</td>

                      <td class="" width="30"></td>

                     </tr>

                    <tr>

                       <td colspan="2" style="font-size:0;line-height:0;" height="10">&nbsp;</td>

                     </tr>

                   </tbody>

               </table>

                     </td>

                   </tr>

                 </tbody>

              </table>                  

                 <tr>

          <td align="center" valign="top">

           <table border="0" cellpadding="0" cellspacing="0" width="629" bgcolor="#fff">

            <tbody>

              <tr>

                  <td colspan="2" style="font-size:0;line-height:0;" height="30">&nbsp;</td>

              </tr>

              <tr>

                <td style="padding: 0px 0px 0px 20px; font-size:19px; color:#231f20; font-family:Myriad Pro">Dear '.$fullname.',</td>

              </tr>

              <tr>

                  <td colspan="2" style="font-size:0;line-height:0;" height="40">&nbsp;</td>

              </tr>

              

              <tr>

                <td style="padding: 0px 0px 0px 20px; font-size:19px; color:#231f20; font-family:Myriad Pro">Congratulation ! You have successfully signed up for Footshots App.</td>

              </tr>

              <tr>

                  <td colspan="2" style="font-size:0;line-height:0;" height="40">&nbsp;</td>

              </tr>

              <tr>

                <td style="padding: 0px 0px 0px 20px; font-size:19px; color:#231f20; font-family:Myriad Pro" >Regards,</td>

              </tr>

              <tr>

                  <td colspan="2" style="font-size:0;line-height:0;" height="40">&nbsp;</td>

              </tr>

              <tr>

                <td style="padding: 0px 0px 0px 20px; font-size:19px; color:#231f20; font-family:Myriad Pro" >Footshots Team</td>

              </tr>

              <tr>

                  <td colspan="2" style="font-size:0;line-height:0;" height="50">&nbsp;</td>

              </tr>

              <tr>

                  <td colspan="2" style="font-size:0;line-height:0;" height="40">&nbsp;</td>

              </tr>

                       

              <tr>

                <td style="height:37px; float:left; margin: 0 auto;" bgcolor="#081575" width="600px"></td>

              </tr>

   </tbody>

 </table>

</td>

</tr>

 

 </td>

 </tr>

</table>';

      //$text = '<p>Dear '.$first_name.' '.$last_name.', Congratulation ! You have successfully signed up for Mexus App.</p>';



      $this->send_email_sendgrid_api($email,'me','Footshots: Sign Up successfully',$text);  /*Call a function to send welcome email.*/


       $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "from_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $result = $query->result();

        $result = array_shift($result);

        $results->total_you_following = $result->following;

         $this->db->select('count(*) as followers');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "to_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $result = $query->result();

        $result = array_shift($result);

        $results->total_your_followers = $result->followers;


      return $results;                                                 /*return data of user to the controller which call this function  */            



    }



  }





    /*Method to login a  user*/



   public function signin_user($data)

  {

 
    $useremail =  $data->useremail;



    $device_type =  $data->device_type;



    $device_token =  $data->device_token;



    $password = $data->password;



    $password = $this->genrate_password($password);                /*Call Password genreate function to encode user password.*/


 

    $this->db->select('user_id');                                          /*Select data from table if username and password will match.*/



    $this->db->from('foot_app_users');



    $where = " useremail ='".$useremail."' and password ='".$password."'";



    $this->db->where($where);



    $query = $this->db->get();



    $result = $query->result();

    

    if($result){

          $result  = array_shift($result);
          $user_id = $result->user_id;

         $token = $this->generateRandomString(64);                    /*Call a function to generate random string*/



         $dataUsers = array(

         'device_token' => $device_token,

         'device_type' => $device_type,

         'login_token' => $token



         );

        $this->db->where('user_id', $result->user_id);

        $this->db->update('foot_app_users', $dataUsers); 

 
        $this->db->select('*');                                          /*get the data from table if username and password will match .*/
 

        $this->db->from('foot_app_users');


        $where = " user_id ='".$result->user_id."' and status='Active'";



        $this->db->where($where);



        $query = $this->db->get();



        $results = $query->result();

       $results = array_shift($results);

         $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "from_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $result = $query->result();

        $result = array_shift($result);

        $results->total_you_following = $result->following;

         $this->db->select('count(*) as followers');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "to_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $result = $query->result();

        $result = array_shift($result);

        $results->total_your_followers = $result->followers;

 

        return $results;                                                 /*return the data if if username and password  match .*/
 

    }

    else

    {
 

       return 0;                                                       /*return the data if if username and password does not match .*/

       

    }







  }





/*Method to get a new password on email*/



  public function forgot_password($data)

      {

        $useremail = $data->useremail;                            /*email for new password which is already entered*/



        $this->db->select('*');

        $this->db->from('foot_app_users');

        $where = "useremail='".$useremail."'";                      /*select user with same email*/

        $this->db->where($where);

        $query = $this->db->get();

        $result = $query->result();

        if($result)

        {
 

        $result= array_shift($result);



        $user_id = $result->user_id;

 



     

      $message ='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
     
     $message .= '<tr>';
     $message .= '<td colspan="2" style="vertical-align:top; font-size: 13px; padding:15px 5px 5px 5px; font-family: Helvetica,Arial,sans-serif;">Dear '.$result->fullname.',</td>';
     $message .= '</tr>';
     
     $message .= '<tr>';
     $message .= '<td colspan="2" style=" text-align: left; vertical-align:top; font-size: 13px; padding:15px 5px 25px 5px; font-family: Helvetica,Arial,sans-serif;">Please press the button below to Reset/Create your password. </td>';
     $message .= '</tr>';
     
     $message .= '<tr>';
     $message .= '<td colspan="2" style=" text-align: left; vertical-align:top; font-size: 13px; padding:15px 5px 25px 5px; font-family: Helvetica,Arial,sans-serif;">If you haven’t requested a password reset or are creating a password as you haven’t set up your account, please continue to by pressing the button below and following the steps. </td>';
     $message .= '</tr>';
     
     $message .= '<tr>';
     $message .= '<td colspan="2" style=" text-align: center;  vertical-align:top; font-size: 13px; padding:15px 5px 5px 5px; font-family: Helvetica,Arial,sans-serif;"><a style=" background: #049c3d; color: #fff; text-decoration: none; padding: 10px 10px; border-radius: 10px;" target="_blank" href="'.base_url().'Forgotpass/forgot_pass/'.$user_id.'">Forgot Password</a></td>';
     $message .= '</tr>';
     
     $message .= '</tr>';
     
     $message .= '</table>';


      $this->send_email_sendgrid_api($result->useremail,'me','Footshots: Forgot Password',$message); /*Call a function to send forgot password email.*/

$datas = array(                                                      /*An array of data to insert into table*/
         
         'user_id' => $user_id 
     

         ); 
       
        $this->db->insert('footshot_forgot_password', $datas); 
 

            return true;                    /*return if successfully*/
                  

         }

         return false;                      /*return if failure*/

      } 



   public function update_user($data)

  { 
 
 
    $user_id =  $data->user_id;



      $profileimage =  $data->profileimage;
 



    $fullname =  $data->fullname;

  
     

    $datas = array(                                                      /*An array of data to update into table*/
                          

     'fullname' => $fullname,
 

     ); 


     $this->db->where('user_id', $user_id);

    $this->db->update('foot_app_users', $datas);                             /* update data into table*/

    

    if($profileimage!="")

    {

        $datas = array(                                                      /*An array of data to update into table*/

         'profileimage' => $profileimage 

         );
 
         $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $datas); 

    }

            

    $this->db->select('*');                                      /*select recently updated user data */ 



    $this->db->from('foot_app_users'); 



    $where = "user_id= '".$user_id."'";

 
    $this->db->where($where);



    $query = $this->db->get();



    $result = $query->result();

 

    if($result){ 

  
      return $result;                                                 /*return data of user to the controller which call this function  */            

 
    }



  }

   public function update_image($data)

  { 
 
 
    $user_id =  $data->user_id;



      $profileimage =  $data->profileimage;
 


 

        $datas = array(                                                      /*An array of data to update into table*/

         'profileimage' => $profileimage 

         );
 
         $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $datas); 

     return true;



  }


  /*method to match the old password*/

  public function match_old_password($data)

  {

    $old_password = $data->old_password;

    $user_id = $data->user_id;

    $old_password = $this->genrate_password($old_password); 

     

    $this->db->select('*');                                      /*select recently updated user data */ 



    $this->db->from('foot_app_users'); 



    $where = "user_id= '".$user_id."' and password='$old_password'";



    $this->db->where($where);



    $query = $this->db->get();



    $result = $query->result();

 

    if($result){   

        return true;

    } 

    return false;

  }





  /*Method to change the old password*/

  public function change_password($data)

  {

         $user_id = $data->user_id;

         $new_password = $this->genrate_password($data->new_password);

         $datas = array(                                                      /*An array of data to update into table*/

         'password' => $new_password 

         );



         $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $datas); 

        if($this->db->affected_rows()>0)

        {

            return true;

        }

        else

        {

             return false;

        }

  } 


  /*Method to change the Privacy*/

  public function change_account_privacy($data)

  {

         $user_id = $data->user_id;

         
        $this->db->select('*');                                      /*select recently updated user data */ 



        $this->db->from('foot_app_users'); 



        $where = "user_id= '".$user_id."' ";

         $this->db->where($where);



        $query = $this->db->get();


        $result = $query->result();

        $result = array_shift($result);

        if($result->is_private=='1')
        {
          $is_private = "0";
        }
        else
        {
           $is_private = "1";
        }


         $datas = array(                                                      /*An array of data to update into table*/

         'is_private' => $is_private 

         );



         $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $datas); 

        if($this->db->affected_rows()>0)

        {

            return  $is_private;

        }

        else

        {

             return  $is_private;

        }

  }

  
  /*Method for Blocked User LIst*/

  public function blocked_User_list($data)
  {

              $start =  $data->post_value;  
         $user_id =  $data->user_id;
         $limit= 10;

        $this->db->select('foot_blocked_user.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_blocked_user'); 
       

        $where = "block_status= 'active' and foot_blocked_user.user_id='$user_id'";
     
        $this->db->where($where);
        $this->db->order_by("block_id", "desc");
         $this->db->limit($limit, $start);


        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result();  

 

         foreach ($resultPosts as   $value) {
            
              
                  $comment_user_id = $value->user_id;

                  $resultuser = $this->user_personal_detail($comment_user_id,$user_id);
                  
                  $value->user_detail = $resultuser;

            $re[] = $value;
       }

          
         
        return $re;

  }


  /*Method for Block a User*/

  public function block_User($data)
  {

       $user_id =  $data->user_id;


        $other_user_id =  $data->other_user_id; 

         $this->db->select('foot_blocked_user.*');
        $this->db->from('foot_blocked_user'); 
        $where = "user_id='$user_id' and other_user_id='$other_user_id' and block_status='active'";
        $this->db->where($where);    
        $query = $this->db->get();
        $restults = $query->result();
        $restultsfollow = array_shift($restults);

        if($restultsfollow)
        {
             $datas = array(                                                      /*An array of data to insert into table*/
                'block_status' => "delete"

             );    

            $where = "user_id = '$user_id' and other_user_id='$other_user_id' ";
             $this->db->where($where);

            $this->db->update('foot_blocked_user', $datas); 


                  $dataUsers = array(

                    'follow_status' => 'deactive',
                    'last_updated' => date('Y-m-d H:i:s') 
                 );

                  $where = "from_id='$user_id' and to_id='$other_user_id'";
                $this->db->where($where );

                $this->db->update('foot_follow', $dataUsers); 


                  $dataUsers = array(

                    'follow_status' => 'deactive',
                    'last_updated' => date('Y-m-d H:i:s') 
                 );

                  $where = "from_id='$other_user_id' and to_id='$user_id'";
                $this->db->where($where );

                $this->db->update('foot_follow', $dataUsers); 
                

              return 1;
        }
        else
        {



            $datas = array(                                                      /*An array of data to insert into table*/
             
             'user_id' => $user_id,
             'other_user_id' => $other_user_id, 
             'block_status' => "active",
             'date_of_creation' => date('Y-m-d H:i:s'),
         

             ); 
           
            $this->db->insert('foot_blocked_user', $datas); 

            $this->db->last_query(); 

               $block_id = $this->db->insert_id();

               return 0;

          }

 
  

  }


  /*Method for Blocked User LIst*/

  public function unblock_User($data)
  {

        $user_id =  $data->user_id;
     

       

        $other_user_id =  $data->other_user_id;
     


        $datas = array(                                                      /*An array of data to insert into table*/
              'block_status' => "delete"

         );    

        $where = "user_id = '$user_id' and other_user_id='$other_user_id' ";
         $this->db->where($where);

        $this->db->update('foot_blocked_user', $datas); 

         
 

        return 0;    

  }

  public function search_user_list($data)
  {
        $search_user_text = $data->search_text;

        $start = $data->post_value;

        $user_id = $data->user_id;

        $limit =10;

         $this->db->select('fullname,profileimage,total_post,status,user_id');                                    /*select recently updated user data */ 

        $this->db->from('foot_app_users'); 

        $where = "user_id!= '".$user_id."' and fullname LIKE '$search_user_text%' and status='Active'  and status='Active'";

         $this->db->where($where);

          $this->db->order_by("user_id", "desc");

         $this->db->limit($limit, $start);

        $query = $this->db->get();

        $result = $query->result();

        $users = array();

        foreach ($result as   $value) {        

                  $comment_user_id = $value->user_id;

                  $resultuser = $this->user_personal_detail($comment_user_id,$user_id);


                  $resultuserpost = $this->user_total_posts($comment_user_id);
                  
                  $value->total_post = $resultuserpost;

                  $value->user_detail = $resultuser;
            


          $users[] = $value;
        }

        return $users;
  }



   public function add_report_user($data)
  {  
 
      $user_id =  $data->user_id;   
 
      $other_user_id =  $data->other_user_id;   


      $datas = array(                                                      /*An array of data to insert into table*/
       
       'user_id' => $user_id,
       'other_user_id' => $other_user_id,
       'date_of_creation' => date('Y-m-d H:i:s')  

       ); 
     
      $this->db->insert('foot_user_report', $datas); 

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


  public function follow_unfollow_user($data)
  {  
 
      $user_id =  $data->user_id;   
 
      $other_user_id =  $data->other_user_id; 
      
 

 

        $this->db->select('foot_follow.*');
        $this->db->from('foot_follow'); 
        $where = "from_id='$user_id' and to_id='$other_user_id' and follow_status!='deactive'";
        $this->db->where($where);    
        $query = $this->db->get();
        $restults = $query->result();
        $restultsfollow = array_shift($restults);

    
    if(empty($restultsfollow)){ 

      $otherUser = $this->single_users_detail($other_user_id);

      if($otherUser)
      {
        $is_private = $otherUser->is_private;
 
        if($is_private=='1')
        {
          $follow_status='request';
        }
        else
        {
          $follow_status='active';
        }
      }


      $datas = array(                                                      /*An array of data to insert into table*/
       
       'from_id' => $user_id,
       'to_id' => $other_user_id,
       'follow_status' => $follow_status,
       'date_of_creation' => date('Y-m-d H:i:s'),
        'last_updated' => date('Y-m-d H:i:s')

       ); 
     
      $this->db->insert('foot_follow', $datas); 

      $this->db->last_query(); 

       $post_id = $this->db->insert_id();
      
    
        return 0;                                                 /*return data of user to the controller which call this function  */            

   
      }
      else
      {
          

                  $dataUsers = array(

                    'follow_status' => 'deactive',
                    'last_updated' => date('Y-m-d H:i:s') 
                 );

                  $where = "from_id='$user_id' and to_id='$other_user_id'";
                $this->db->where($where );

                $this->db->update('foot_follow', $dataUsers); 


                return 0;

           
      }



  }

   
  public function follow_request_action($data)
  {  
 
      $user_id =  $data->user_id;   
 
      $follow_id =  $data->follow_id; 

      $follow_status =  $data->follow_status;  //'active','request','deactive'
      
 

              $dataUsers = array(

                    'follow_status' => $follow_status,
                    'last_updated' => date('Y-m-d H:i:s') 
                 );

                  $where = "follow_id='$follow_id' ";
                $this->db->where($where );

                $this->db->update('foot_follow', $dataUsers); 


                return 0;



  }


  public function follow_request_list($data)
  {  
 
      $user_id =  $data->user_id;   


       $start = $data->post_value; 
        

        $limit =10;


      $this->db->select('foot_follow.*');

        $this->db->from('foot_follow'); 

        $where = "to_id='$user_id' and follow_status='request'";

        $this->db->where($where);    

          $this->db->order_by("follow_id", "desc");

         $this->db->limit($limit, $start);

        $query = $this->db->get();

        $resultPosts = $query->result();

         $re = array();
        foreach ($resultPosts as   $value) {


               $comment_user_id = $value->from_id; 
              $resultuser = $this->user_personal_detail($comment_user_id,$user_id);
              $value->user_detail = $resultuser; 
              $re[] = $value;
              }
          return $resultPosts;            
  }


  public function following_list($data)
  {  
 
      $user_id =  $data->user_id;   


        $start = $data->post_value; 
        $other_user_id = $data->other_user_id; 

        $limit =10;


      $this->db->select('foot_follow.*');

        $this->db->from('foot_follow'); 

        $where = "from_id='$other_user_id' and follow_status='active'";

        $this->db->where($where);    

          $this->db->order_by("follow_id", "desc");

         $this->db->limit($limit, $start);

        $query = $this->db->get();

        $resultPosts = $query->result();

         $re = array();
        foreach ($resultPosts as   $value) {


               $comment_user_id = $value->to_id;


              $resultuser = $this->user_personal_detail($comment_user_id,$user_id);
              $value->user_detail = $resultuser;

              $re[] = $value;
              }
          return $re;            
  }

  public function followers_list($data)
  {  
 
      $user_id =  $data->user_id;   
      $other_user_id =  $data->other_user_id;   


        $start = $data->post_value; 

        $limit =10;


      $this->db->select('foot_follow.*');

        $this->db->from('foot_follow'); 

        $where = "to_id='$other_user_id' and follow_status='active'";

        $this->db->where($where);    

          $this->db->order_by("follow_id", "desc");

         $this->db->limit($limit, $start);

        $query = $this->db->get();

        $resultPosts = $query->result();

         $re = array();
        foreach ($resultPosts as   $value) {


               $comment_user_id = $value->from_id;


              $resultuser = $this->user_personal_detail($comment_user_id,$user_id);


              $value->user_detail = $resultuser;

              $re[] = $value;
              }
          return $re;            
  }

   function user_total_posts($comment_user_id)
  {
 
              $this->db->select('*');                                    /*select recently updated user data */ 

              $this->db->from('foot_posts'); 

              $where = "user_id= '".$comment_user_id."'  and post_status='active'   ";

               $this->db->where($where);
          

              $queryuser = $this->db->get();

              

                $resultuser = $queryuser->num_rows();;
              

              return $resultuser;


  }


  function user_personal_detail($comment_user_id,$user_id)
  {
        $resultuser = array();
              $this->db->select('*');                                    /*select recently updated user data */ 

              $this->db->from('foot_app_users'); 

              $where = "user_id= '".$comment_user_id."'  and status='Active'  ";

               $this->db->where($where);
          

              $queryuser = $this->db->get();

              $resultuser = $queryuser->row();

              $comment_user_id = $resultuser->user_id;

                $resultuserpost = $this->user_total_posts($comment_user_id);

              $resultuser->total_post = $resultuserpost;

           //   $resultuser = array_shift($resultuser);
 
              $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "from_id= '".$comment_user_id."' and  follow_status='active' ";

              $this->db->where($where);

              $query = $this->db->get();
  
              $result = $query->row();

             // $result = array_shift($result);
              

             $resultuser->total_you_following = $result->following;
               
                

              $this->db->select('count(*) as followers');                                    /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "to_id= '".$comment_user_id."' and  follow_status='active' ";

              $this->db->where($where);
              
              $query = $this->db->get();

                $result = $query->row();

               

                $resultuser->total_your_followers = $result->followers;



              $this->db->select('foot_follow.*');
              $this->db->from('foot_follow'); 
              $where = "from_id='$user_id' and to_id='$comment_user_id' and follow_status!='deactive'";
              $this->db->where($where);    
              $query = $this->db->get();
              $restults = $query->row();
             // $restultsfollow = array_shift($restults);

              if($restults)
              {

                  $resultuser->is_following= $restults->follow_status;
                }
                else
                {
                  $resultuser->is_following = "";
                }

               $this->db->select('foot_follow.*');
              $this->db->from('foot_follow'); 
              $where = "from_id='$comment_user_id' and to_id='$user_id' and follow_status!='deactive'";
              $this->db->where($where);    
              $query = $this->db->get();
              $restults = $query->row();
       

             //$resultuser->is_followed = $restultsfollow->follow_status;


              if($restults)
              {

                  $resultuser->is_followed = $restults->follow_status;
                }
                else
                {
                  $resultuser->is_followed = "";
                }


                return $resultuser;
  }
 


  function user_like_personal_detail($comment_user_id,$user_id)
  {
     $resultuser = array();
              $this->db->select('*');                                    /*select recently updated user data */ 

              $this->db->from('foot_app_users'); 

              $where = "user_id= '".$comment_user_id."'  and status='Active'  and status='Active'";

               $this->db->where($where);
          

              $queryuser = $this->db->get();

              $resultuser = $queryuser->row();

           //   $resultuser = array_shift($resultuser);

              
            

              $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "from_id= '".$comment_user_id."' and  follow_status='active' ";

              $this->db->where($where);

              $query = $this->db->get();
  
              $result = $query->row();

             // $result = array_shift($result);
              

             $resultuser->total_you_following = $result->following;
               
                

              $this->db->select('count(*) as followers');                                    /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "to_id= '".$comment_user_id."' and  follow_status='active' ";

              $this->db->where($where);
              
              $query = $this->db->get();

                $result = $query->row();

               

                $resultuser->total_your_followers = $result->followers;



              $this->db->select('foot_follow.*');
              $this->db->from('foot_follow'); 
              $where = "from_id='$user_id' and to_id='$comment_user_id' and follow_status!='deactive'";
              $this->db->where($where);    
              $query = $this->db->get();
              $restults = $query->row();
             // $restultsfollow = array_shift($restults);

              if($restults)
              {

                  $resultuser->is_following= $restults->follow_status;
                }
                else
                {
                  $resultuser->is_following = "";
                }

               $this->db->select('foot_follow.*');
              $this->db->from('foot_follow'); 
              $where = "from_id='$comment_user_id' and to_id='$user_id' and follow_status!='deactive'";
              $this->db->where($where);    
              $query = $this->db->get();
              $restults = $query->row();
       

             //$resultuser->is_followed = $restultsfollow->follow_status;


              if($restults)
              {

                  $resultuser->is_followed = $restults->follow_status;
                }
                else
                {
                  $resultuser->is_followed = "";
                }


                return $resultuser;
  }


}