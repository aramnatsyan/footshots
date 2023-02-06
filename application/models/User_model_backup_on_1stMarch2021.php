<?php 

class User_model_bkp_on_1stMarch2021 extends CI_Model {



  public function __construct()

  {

        // Call the Model constructor

    parent::__construct();
       date_default_timezone_set('UTC');

    $this->db->query('SET time_zone="+00:00"');


    $this->load->model('Post_model');  

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

      $params['from']="no-reply@footshots.com.au";

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

      $where = "user_id='".$user_id."' and login_token='$login_token' and status='Active'";

      $this->db->where($where);

      $query = $this->db->get();


      $result = $query->result();

      

      if($result){ 
 

         $dataUsers = array(

         'last_activity' => date('Y-m-d H:i:s'),
         'badge' => 0
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

public function all_ajax_top_users_list($search='',$per_page=10,$start=0,$orderby='') 
  {  
 
    $where =" where user_type='user'";
 if($search!='')
        {
           $where = " and fullname LIKE '%$search%'";
        } 

    $query = $this->db->query("SELECT foot_app_users.*,(select count(*) from foot_posts where foot_posts.user_id=foot_app_users.user_id and post_status='active' and post_type='post') as total_post FROM foot_app_users $where  order by total_post desc limit $start,$per_page");


    $result = $query->result();

    $re = array();
    foreach ($result as  $value) {      
    
      $user_id = $value->user_id;

      $queryreport = $this->db->query("SELECT * FROM foot_posts where user_id='$user_id' and post_status='active' ");
    
     $activereportPost =  $queryreport->num_rows();

     $value->totalPost =$activereportPost; 


     $queryFootsFollowing = $this->db->query("SELECT * FROM foot_follow where from_id='$user_id'  and  follow_status='active'");
      
      $FootsFollowing =  $queryFootsFollowing->num_rows();

      $value->FootsFollowing =$FootsFollowing;

        $queryFootsFollower = $this->db->query("SELECT * FROM foot_follow where to_id='$user_id'  and  follow_status='active'");
        
        $FootsFollower =  $queryFootsFollower->num_rows();

      $value->FootsFollower =$FootsFollower;

       $earnedresult = $this->total_earned_points($value->user_id);            /*Call Model function to get blocked user list */
            $redeemresult = $this->total_redeem_points($value->user_id);  
           //$value->total_fonation_points = $earnedresult-$redeemresult;
           $value->total_fonation_points = $earnedresult;

    }
      $data['result'] = $result;

       $query = $this->db->query("SELECT foot_app_users.*,(select count(*) from foot_posts where foot_posts.user_id=foot_app_users.user_id and post_status='active' and post_type='post') as total_post FROM foot_app_users  $where ");


    $result = $query->num_rows();

      $data['count'] = $result;

    return $data;

  }


/*All Users for Admin*/

public function all_ajax_users_list($search='',$per_page=10,$start=0,$orderby='') 
    {
        $this->db->select('ch.*', false);
        $this->db->from('foot_app_users as ch');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        } 
        if($orderby=='')
        {
           $orderby = 'desc';
        } 
        $this->db->where('ch.user_type', 'user');
        $this->db->order_by('ch.user_id', $orderby);
        $this->db->limit($per_page,$start);
       $resultPosts =$this->db->get()->result();


          $re = array();
          foreach ($resultPosts as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_posts where user_id='$value->user_id' and post_status='active' and post_type='post' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_footshots = $total_report;

              $earnedresult = $this->total_earned_points($value->user_id);            /*Call Model function to get blocked user list */
            $redeemresult = $this->total_redeem_points($value->user_id);  
           $value->total_fonation_points = $earnedresult-$redeemresult;
           
            $re[] = $value;
        }

        $data['result'] =  $re;

        $this->db->select("COUNT(ch.user_id) AS count");

        $this->db->from('foot_app_users as ch');
         $this->db->where('ch.user_type', 'user');
      $this->db->order_by('ch.user_id', 'Desc');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        }
        $data['count']=$this->db->count_all_results();    
        return $data;
    }

  public function all_users_list( )
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');
    $this->db->where('user_type','user');

   
    $query = $this->db->get();


    $result = $query->result();

    return $result;

  }

   public function all_inactive_users_list( )
  { 
      $date = date('Y-m-d');
        $old_date = date('Y-m-d',strtotime($date . "-20 days"));

        $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');
     $this->db->where('user_type','user');
   
    $where = " DATE_FORMAT(last_activity,'%Y-%m-%d') <'$old_date' ";
   $this->db->where($where);
    $query = $this->db->get();


    $result = $query->result();

    return $result;

  }

public function all_inactive_ajax_users_list($search='',$per_page=10,$start=0) 
    {
       $date = date('Y-m-d');
        $old_date = date('Y-m-d',strtotime($date . "-20 days"));
        
        $this->db->select('ch.*', false);
        $this->db->from('foot_app_users as ch');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        } 
          $where = " DATE_FORMAT(last_activity,'%Y-%m-%d') < '$old_date' and user_type='user'";
   $this->db->where($where);
        $this->db->order_by('ch.user_id', 'Desc');
        $this->db->limit($per_page,$start);
       $resultPosts =$this->db->get()->result();
          $re = array();
          foreach ($resultPosts as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_posts where user_id='$value->user_id' and post_status='active'  and post_type='post'");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_footshots = $total_report;

             $earnedresult = $this->total_earned_points($value->user_id);            /*Call Model function to get blocked user list */
            $redeemresult = $this->total_redeem_points($value->user_id);  
          // $value->total_fonation_points = $earnedresult-$redeemresult;
           $value->total_fonation_points = $earnedresult;

            $re[] = $value;
        }

        $data['result'] =  $re;

        $this->db->select("COUNT(ch.user_id) AS count");

        $this->db->from('foot_app_users as ch');

           $where = " DATE_FORMAT(ch.last_activity,'%Y-%m-%d') <='$old_date'  and user_type='user'";
   $this->db->where($where);
  $this->db->order_by('ch.user_id', 'Desc');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        }
        $data['count']=$this->db->count_all_results();    
        return $data;
    }

  public function all_active_ajax_users_list($search='',$per_page=10,$start=0) 
    {
       $date = date('Y-m-d');
        $old_date = date('Y-m-d',strtotime($date . "-20 days"));

        $this->db->select('ch.*', false);
        $this->db->from('foot_app_users as ch');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        } 
          $where = " DATE_FORMAT(ch.last_activity,'%Y-%m-%d') >='$old_date'  and user_type='user'";
   $this->db->where($where);
        $this->db->order_by('ch.user_id', 'Desc');
        $this->db->limit($per_page,$start);
       $resultPosts =$this->db->get()->result();

   

          $re = array();
          foreach ($resultPosts as   $value) {
            
            $queryFoots = $this->db->query("SELECT * FROM foot_posts where user_id='$value->user_id' and post_status='active' and post_type='post' ");
           
            $total_report =  $queryFoots->num_rows();

            $value->total_footshots = $total_report;
              $earnedresult = $this->total_earned_points($value->user_id);            /*Call Model function to get blocked user list */
            $redeemresult = $this->total_redeem_points($value->user_id);  
           //$value->total_fonation_points = $earnedresult-$redeemresult;
           $value->total_fonation_points = $earnedresult;

            $re[] = $value;
        }

        $data['result'] =  $re;

        $this->db->select("COUNT(ch.user_id) AS count");

        $this->db->from('foot_app_users as ch');
           $where = " DATE_FORMAT(ch.last_activity,'%Y-%m-%d') >='$old_date'  and user_type='user'";
   $this->db->where($where);
      $this->db->order_by('ch.user_id', 'Desc');
        if($search!='')
        {
            $this->db->like('ch.fullname',$search);
        }
        $data['count']=$this->db->count_all_results();    
        return $data;
    }

   public function all_active_users_list( )
  { 
    $date = date('Y-m-d');
        $old_date = date('Y-m-d',strtotime($date . "-20 days"));

      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');

   
    $where = " DATE_FORMAT(last_activity,'%Y-%m-%d') >='$old_date'  and user_type='user'";
   $this->db->where($where);
    $query = $this->db->get();


    $result = $query->result();

    return $result;

  }


 public function all_top_users_list( )
  {  

      /*$this->db->select('*');                                           


    $this->db->from('foot_app_users');
  
    $query = $this->db->get();*/

    $query = $this->db->query("SELECT foot_app_users.*,(select count(*) from foot_posts where foot_posts.user_id=foot_app_users.user_id and post_status='active') as total_post FROM foot_app_users where    user_type='user' and post_type='post' order by total_post desc");


    $result = $query->result();

    $re = array();
    foreach ($result as  $value) {      
    
      $user_id = $value->user_id;

      $queryreport = $this->db->query("SELECT * FROM foot_posts where user_id='$user_id' and post_status='active' and post_type='post' ");
    
     $activereportPost =  $queryreport->num_rows();

     $value->totalPost =$activereportPost; 


     $queryFootsFollowing = $this->db->query("SELECT * FROM foot_follow where from_id='$user_id'  and  follow_status='active'");
      
      $FootsFollowing =  $queryFootsFollowing->num_rows();

      $value->FootsFollowing =$FootsFollowing;

        $queryFootsFollower = $this->db->query("SELECT * FROM foot_follow where to_id='$user_id'  and  follow_status='active'");
        
        $FootsFollower =  $queryFootsFollower->num_rows();

      $value->FootsFollower =$FootsFollower;

    }


    return $result;

  }

   public function total_users( )
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');
    $this->db->where('user_type','user');

   
    $query = $this->db->get();


    $result = $query->num_rows();

    return $result;

  }public function top_users( )
  { 
      //$this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $query = $this->db->query("SELECT foot_app_users.*,(select count(*) from foot_posts where foot_posts.user_id=foot_app_users.user_id and post_status='active') as total_post FROM foot_app_users $where  order by total_post desc limit $start,$per_page");

   
    $query = $this->db->get();


    $result = $query->num_rows();

    return $result;

  }

    public function total_active_users($old_date)
  { 

      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');

    $where = " DATE_FORMAT(last_activity,'%Y-%m-%d') >='$old_date' and user_type='user'";
   $this->db->where($where);

    $query = $this->db->get();


    $result = $query->num_rows();

    return $result;

  }

    public function total_inactive_users($old_date)
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');

    $where = " DATE_FORMAT(last_activity,'%Y-%m-%d') <'$old_date' and user_type='user'";
   $this->db->where($where);

    $query = $this->db->get();


    $result = $query->num_rows();

    return $result;

  }


 public function total_users_month_year($yearMonh)
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');

    $where = " DATE_FORMAT(date_of_creation,'%Y-%m') ='$yearMonh' and user_type='user' ";
   $this->db->where($where);
    $query = $this->db->get();

 
    $result = $query->num_rows();

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


   $queryFootsFollowing = $this->db->query("SELECT * FROM foot_follow where from_id='$user_id'  and  follow_status='active'");
    
    $FootsFollowing =  $queryFootsFollowing->num_rows();

$result->FootsFollowing =$FootsFollowing;

    $queryFootsFollower = $this->db->query("SELECT * FROM foot_follow where to_id='$user_id'  and  follow_status='active'");
    
    $FootsFollower =  $queryFootsFollower->num_rows();

$result->FootsFollower =$FootsFollower;
$result->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

    return $result;

  }


    public function single_username_detail($username)
  { 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/


    $this->db->from('foot_app_users');

    $this->db->where('username',$username);

    $query = $this->db->get();


    $result = $query->row();
    if(empty($result))
    {
      return array();
    }

    $user_id = $result->user_id;

    //$result = array_shift($result);

      $resultuserpost = $this->user_total_posts($user_id);
                  
      $result->total_post = $resultuserpost;

    $queryFoots = $this->db->query("SELECT * FROM foot_posts where user_id='$user_id'  and  post_status='delete'");
    
    $activePost =  $queryFoots->num_rows();

$result->activePost =$activePost;

 $queryreport = $this->db->query("SELECT * FROM foot_post_report where user_id='$user_id'  ");
    
    $activereportPost =  $queryreport->num_rows();

$result->reportPost =$activereportPost; 


   $queryFootsFollowing = $this->db->query("SELECT * FROM foot_follow where from_id='$user_id'  and  follow_status='active'");
    
    $FootsFollowing =  $queryFootsFollowing->num_rows();

$result->FootsFollowing =$FootsFollowing;

    $queryFootsFollower = $this->db->query("SELECT * FROM foot_follow where to_id='$user_id'  and  follow_status='active'");
    
    $FootsFollower =  $queryFootsFollower->num_rows();

$result->FootsFollower =$FootsFollower;
$result->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

    return $result;

  }





  /*Method to register a new user*/


   public function verify_username($data)
  {
 

    $username =  $data->username;
    $user_id =  $data->user_id;
 

 
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/ 

    $this->db->from('foot_app_users');
     $where = "username='".$username."' ";
    if($user_id!='')
    {

    $where .=" and user_id !='".$user_id."' ";
   }


    $this->db->where($where);



    $query = $this->db->count_all_results();



    if($query)

     {

       return  4;                                                        /*Return 2 if  email is already exist*/                         

     }
 
      
      return 1;
 
  
  }
  public function signup_new_user_new($data)
  { 



     


    $password = $data->password;
 


    $fullname =  $data->fullname;
    $username =  $data->username;
 


    $email =  $data->useremail;

 

    $device_type =  $data->device_type;



    $device_token =  $data->device_token;
    
      $profileimage =  $data->profileimage;
      $address =  $data->address;
      $city =  $data->city;
      $state =  $data->state;
      $country =  $data->country;
      $lat =  $data->lat;
      $lng =  $data->lng;
     
 

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
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/



    $this->db->from('foot_app_users');



    $where = "username='".$username."' ";



    $this->db->where($where);



    $query = $this->db->count_all_results();



    if($query)

     {

       return  4;                                                        /*Return 2 if  email is already exist*/                         

     }

  


    $data = array(                                                      /*An array of data to insert into table*/

     'useremail' => $email,

     'fullname' => $fullname,     
     
     'username' => $username,     

     'password' => $password,

     'profileimage' => $profileimage,
     
     'profilecover' => base_url().'upload/cover_image.png',
 
     'status' =>'Active',

     'date_of_creation'=> date('Y-m-d H:i:s'), 
     'last_activity'=> date('Y-m-d H:i:s'), 

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


         $datas = array(                                                      /*An array of data to insert into table*/
       
         'from_id' => $user_id,
         'to_id' => "108",
         'follow_status' => "active",
         'date_of_creation' => date('Y-m-d H:i:s'),
          'last_updated' => date('Y-m-d H:i:s')

         ); 
       
        $this->db->insert('foot_follow', $datas); 
 

        $dataslocation = array(      /*An array of data to insert into table*/
       
         'user_id' => $user_id,
         'lat' => $lat,
         'lng' => $lng,
         'address' =>$address,
         'city' => $city,
         'state' => $state,
         'country' => $country,
          'date_of_modify' => date('Y-m-d H:i:s')

         ); 
       
        $this->db->insert('foot_user_location', $dataslocation); 

      $results = array_shift($result);


      $text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    <!-- <![endif]-->

    <title>Footshots</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }
        
        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        span.preheader {
            display: none;
            font-size: 1px;
        }
        
        html {
            width: 100%;
        }
        
        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */
        
        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }
        
        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!-- [if gte mso 9]><style type=”text/css”>
        body {
        font-family: arial, sans-serif!important;
        }
        </style>
    <![endif]-->
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
                    
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 100px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>

                        <td align="center" class="section-img">
                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="'.base_url().'public/img/welcome.png" style="display: block; width: 590px;" width="590" border="0" alt="" /></a>




                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                            <div style="line-height: 35px">

                                We\'re Glad <span style="color: #5caad2;">You\'re Here</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="500" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="justify" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">


                                        <div style="line-height: 24px">

                                            Welcome to Footshots -- Footshots is an app that people are proud to post cool ideas on their feet and tag their products and feel good about themselves and at the same time you should be aware that it’s going to a good cause to help people in need on foot protection.
                                            <br><br>
                                            Regards,<br>
                                            Footshots Team
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="35" style="font-size: 25px; line-height: 35px;">&nbsp;</td>
                    </tr>
                    

                </table>

            </td>
        </tr>

    </table>
    <!-- end section -->
    
    <table border="0" width="370" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td height="30" width="" style="border-top: 1px solid #edecec;font-size: 60px; line-height: 30px;">&nbsp;</td>
        </tr>
    </table>

    <!-- contact section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr class="hide">
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

        

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590 bg_color">

                    <tr>
                        <td>
                            <table border="0" width="300" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <!-- logo -->
                                    <td align="left">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="80" border="0" style="display: block; width: 80px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="left" style="color: #888888; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 23px;" class="text_color">
                                        <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">

                                            Email us: <br/> <a href="mailto:info@footshots.com.au" style="color: #888888; font-size: 14px; font-family: \'Hind Siliguri\', Calibri, Sans-serif; font-weight: 400;">info@footshots.com.au</a>

                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <table border="0" width="2" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">
                                <tr>
                                    <td width="2" height="10" style="font-size: 10px; line-height: 10px;"></td>
                                </tr>
                            </table>

                            <table border="0" width="200" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <td class="hide" height="45" style="font-size: 45px; line-height: 45px;">&nbsp;</td>
                                </tr>



                                <tr>
                                    <td height="15" style="font-size: 15px; line-height: 15px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" align="right" cellpadding="0" cellspacing="0">
                                            <tr><!-- 
                                                <td>
                                                    <a href="https://www.facebook.com/mdbootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Qc3zTxn.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://twitter.com/MDBootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/RBRORq1.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://plus.google.com/u/0/b/107863090883699620484/107863090883699620484/posts" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Wji3af6.png" alt=""></a>
                                                </td>
                                             --></tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end section -->

    <!-- footer ====== -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">

        <tr>
            <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td>
                            

                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:70px;font-family: \'Work Sans\', Calibri, sans-serif;" class="container590">

                                <tr>
                                    <td align="center">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    &copy; 2019 Footshots Pty. Ltd.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end footer ====== -->

</body>

</html>';

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

        $results->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

        $memberdata = array(                                                      /*An array of data to insert into table*/ 

           'chat_id' => "528",



           'user_id' => $user_id,



           'member_type' => "member",    



           'block_group' => "0",      



           'date_of_creation' =>  date('Y-m-d H:i:s')  



           );


          $this->db->insert('foot_chat_member', $memberdata); 

          $results->location = $dataslocation;

      return $results;                                                 /*return data of user to the controller which call this function  */            



    }



  
  
  }
   public function signup_new_user($data)
  { 


     


    $password = $data->password;
 


    $fullname =  $data->fullname;
    $username =  $data->username;
 


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
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/



    $this->db->from('foot_app_users');



    $where = "username='".$username."' ";



    $this->db->where($where);



    $query = $this->db->count_all_results();



    if($query)

     {

       return  4;                                                        /*Return 2 if  email is already exist*/                         

     }

  


    $data = array(                                                      /*An array of data to insert into table*/

     'useremail' => $email,

     'fullname' => $fullname,     
     
     'username' => $username,     

     'password' => $password,

     'profileimage' => $profileimage,
     
     'profilecover' => base_url().'upload/cover_image.png',
 
     'status' =>'Active',

     'date_of_creation'=> date('Y-m-d H:i:s'), 
     'last_activity'=> date('Y-m-d H:i:s'), 

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


         $datas = array(                                                      /*An array of data to insert into table*/
       
         'from_id' => $user_id,
         'to_id' => "108",
         'follow_status' => "active",
         'date_of_creation' => date('Y-m-d H:i:s'),
          'last_updated' => date('Y-m-d H:i:s')

         ); 
       
        $this->db->insert('foot_follow', $datas); 

      $results = array_shift($result);


      $text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    <!-- <![endif]-->

    <title>Footshots</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }
        
        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        span.preheader {
            display: none;
            font-size: 1px;
        }
        
        html {
            width: 100%;
        }
        
        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */
        
        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }
        
        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!-- [if gte mso 9]><style type=”text/css”>
        body {
        font-family: arial, sans-serif!important;
        }
        </style>
    <![endif]-->
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
                    
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 100px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>

                        <td align="center" class="section-img">
                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="'.base_url().'public/img/welcome.png" style="display: block; width: 590px;" width="590" border="0" alt="" /></a>




                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                            <div style="line-height: 35px">

                                We\'re Glad <span style="color: #5caad2;">You\'re Here</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="500" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="justify" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">


                                        <div style="line-height: 24px">

                                            Welcome to Footshots -- Footshots is an app that people are proud to post cool ideas on their feet and tag their products and feel good about themselves and at the same time you should be aware that it’s going to a good cause to help people in need on foot protection.
                                            <br><br>
                                            Regards,<br>
                                            Footshots Team
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="35" style="font-size: 25px; line-height: 35px;">&nbsp;</td>
                    </tr>
                    

                </table>

            </td>
        </tr>

    </table>
    <!-- end section -->
    
    <table border="0" width="370" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td height="30" width="" style="border-top: 1px solid #edecec;font-size: 60px; line-height: 30px;">&nbsp;</td>
        </tr>
    </table>

    <!-- contact section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr class="hide">
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

        

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590 bg_color">

                    <tr>
                        <td>
                            <table border="0" width="300" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <!-- logo -->
                                    <td align="left">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="80" border="0" style="display: block; width: 80px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="left" style="color: #888888; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 23px;" class="text_color">
                                        <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">

                                            Email us: <br/> <a href="mailto:info@footshots.com.au" style="color: #888888; font-size: 14px; font-family: \'Hind Siliguri\', Calibri, Sans-serif; font-weight: 400;">info@footshots.com.au</a>

                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <table border="0" width="2" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">
                                <tr>
                                    <td width="2" height="10" style="font-size: 10px; line-height: 10px;"></td>
                                </tr>
                            </table>

                            <table border="0" width="200" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <td class="hide" height="45" style="font-size: 45px; line-height: 45px;">&nbsp;</td>
                                </tr>



                                <tr>
                                    <td height="15" style="font-size: 15px; line-height: 15px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" align="right" cellpadding="0" cellspacing="0">
                                            <tr><!-- 
                                                <td>
                                                    <a href="https://www.facebook.com/mdbootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Qc3zTxn.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://twitter.com/MDBootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/RBRORq1.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://plus.google.com/u/0/b/107863090883699620484/107863090883699620484/posts" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Wji3af6.png" alt=""></a>
                                                </td>
                                             --></tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end section -->

    <!-- footer ====== -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">

        <tr>
            <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td>
                            

                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:70px;font-family: \'Work Sans\', Calibri, sans-serif;" class="container590">

                                <tr>
                                    <td align="center">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    &copy; 2019 Footshots Pty. Ltd.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end footer ====== -->

</body>

</html>';

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

        $results->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

        $memberdata = array(                                                      /*An array of data to insert into table*/ 

           'chat_id' => "528",



           'user_id' => $user_id,



           'member_type' => "member",    



           'block_group' => "0",      



           'date_of_creation' =>  date('Y-m-d H:i:s')  



           );


          $this->db->insert('foot_chat_member', $memberdata); 


      return $results;                                                 /*return data of user to the controller which call this function  */            



    }



  
  } 

  public function sponsor_signup_user($data)
  { 
 

    $password = $data->password;
 


    $fullname =  $data->fullname;
    $username =  $data->username;
 


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
      $this->db->select('*');                                           /*Check into the table  email is already exist or not.*/



    $this->db->from('foot_app_users');



  //  $where = "username='".$username."' ";



    $this->db->where("username",$username);



    $query = $this->db->count_all_results();



    if($query)

     {

       return  4;                                                        /*Return 2 if  email is already exist*/                         

     }

  


    $data = array(                                                      /*An array of data to insert into table*/

     'useremail' => $email,

     'fullname' => $fullname,     
     
     'username' => $username,     

     'password' => $password,

     'profileimage' => $profileimage,
     
     'profilecover' => base_url().'upload/cover_image.png',
 
     'status' =>'Active',

     'date_of_creation'=> date('Y-m-d H:i:s'), 
     'last_activity'=> date('Y-m-d H:i:s'), 

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



    $result = $query->row();

 

    if($result){ 


         $datas = array(                                                      /*An array of data to insert into table*/
       
         'from_id' => $user_id,
         'to_id' => "108",
         'follow_status' => "active",
         'date_of_creation' => date('Y-m-d H:i:s'),
          'last_updated' => date('Y-m-d H:i:s')

         ); 
       
        $this->db->insert('foot_follow', $datas); 
 

      

        $memberdata = array(                                                      /*An array of data to insert into table*/ 

           'chat_id' => "528",



           'user_id' => $user_id,



           'member_type' => "member",    



           'block_group' => "0",      



           'date_of_creation' =>  date('Y-m-d H:i:s')  



           );


          $this->db->insert('foot_chat_member', $memberdata); 


      return $result;                                                 /*return data of user to the controller which call this function  */            



    }



  
  }
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
     
     'profilecover' => base_url().'upload/cover_image.png',
 
     'status' =>'Active',

     'date_of_creation'=> date('Y-m-d H:i:s'), 
     'last_activity'=> date('Y-m-d H:i:s'), 

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


         $datas = array(                                                      /*An array of data to insert into table*/
       
         'from_id' => $user_id,
         'to_id' => "108",
         'follow_status' => "active",
         'date_of_creation' => date('Y-m-d H:i:s'),
          'last_updated' => date('Y-m-d H:i:s')

         ); 
       
        $this->db->insert('foot_follow', $datas); 

      $results = array_shift($result);


      $text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    <!-- <![endif]-->

    <title>Footshots</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }
        
        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        span.preheader {
            display: none;
            font-size: 1px;
        }
        
        html {
            width: 100%;
        }
        
        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */
        
        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }
        
        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!-- [if gte mso 9]><style type=”text/css”>
        body {
        font-family: arial, sans-serif!important;
        }
        </style>
    <![endif]-->
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
                    
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 100px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>

                        <td align="center" class="section-img">
                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="'.base_url().'public/img/welcome.png" style="display: block; width: 590px;" width="590" border="0" alt="" /></a>




                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                            <div style="line-height: 35px">

                                We\'re Glad <span style="color: #5caad2;">You\'re Here</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="500" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="justify" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">


                                        <div style="line-height: 24px">

                                            Welcome to Footshots -- Footshots is an app that people are proud to post cool ideas on their feet and tag their products and feel good about themselves and at the same time you should be aware that it’s going to a good cause to help people in need on foot protection.
                                            <br><br>
                                            Regards,<br>
                                            Footshots Team
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="35" style="font-size: 25px; line-height: 35px;">&nbsp;</td>
                    </tr>
                    

                </table>

            </td>
        </tr>

    </table>
    <!-- end section -->
    
    <table border="0" width="370" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td height="30" width="" style="border-top: 1px solid #edecec;font-size: 60px; line-height: 30px;">&nbsp;</td>
        </tr>
    </table>

    <!-- contact section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr class="hide">
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

        

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590 bg_color">

                    <tr>
                        <td>
                            <table border="0" width="300" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <!-- logo -->
                                    <td align="left">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="80" border="0" style="display: block; width: 80px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="left" style="color: #888888; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 23px;" class="text_color">
                                        <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">

                                            Email us: <br/> <a href="mailto:info@footshots.com.au" style="color: #888888; font-size: 14px; font-family: \'Hind Siliguri\', Calibri, Sans-serif; font-weight: 400;">info@footshots.com.au</a>

                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <table border="0" width="2" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">
                                <tr>
                                    <td width="2" height="10" style="font-size: 10px; line-height: 10px;"></td>
                                </tr>
                            </table>

                            <table border="0" width="200" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <td class="hide" height="45" style="font-size: 45px; line-height: 45px;">&nbsp;</td>
                                </tr>



                                <tr>
                                    <td height="15" style="font-size: 15px; line-height: 15px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" align="right" cellpadding="0" cellspacing="0">
                                            <tr><!-- 
                                                <td>
                                                    <a href="https://www.facebook.com/mdbootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Qc3zTxn.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://twitter.com/MDBootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/RBRORq1.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://plus.google.com/u/0/b/107863090883699620484/107863090883699620484/posts" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Wji3af6.png" alt=""></a>
                                                </td>
                                             --></tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end section -->

    <!-- footer ====== -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">

        <tr>
            <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td>
                            

                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:70px;font-family: \'Work Sans\', Calibri, sans-serif;" class="container590">

                                <tr>
                                    <td align="center">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    &copy; 2019 Footshots Pty. Ltd.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end footer ====== -->

</body>

</html>';

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

        $results->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

        $memberdata = array(                                                      /*An array of data to insert into table*/ 

           'chat_id' => "528",



           'user_id' => $user_id,



           'member_type' => "member",    



           'block_group' => "0",      



           'date_of_creation' =>  date('Y-m-d H:i:s')  



           );


          $this->db->insert('foot_chat_member', $memberdata); 


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


        $where = " user_id ='".$result->user_id."' ";



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

        $results->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;


            $this->db->select('*');

            $this->db->from('foot_user_location');

            $where = "user_id='".$user_id."'";                      /*select user with same email*/

            $this->db->where($where);

            $query = $this->db->get();

            $resultlcoation = $query->row();

            if($resultlcoation)
            {
                $results->location=$resultlcoation;
            }
            else
            {
              $results->location = new stdClass;
            }
 

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

 



     

      $message ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    <!--<![endif]-->

    <title>Footshots</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }

        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        span.preheader {
            display: none;
            font-size: 1px;
        }

        html {
            width: 100%;
        }

        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */

        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }

        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!--[if gte mso 9]><style type=”text/css”>
        body {
        font-family: arial, sans-serif!important;
        }
        </style>
    <![endif]-->
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
                    Welcome to Footshots!
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 100px;" src="'.base_url().'public/img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->

    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->

                            <div style="line-height: 35px">

                                Welcome to <span style="color: #376bcc;">Footshots</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->

                                        <p style="line-height: 24px; margin-bottom:15px;">

                                            Dear '.$result->fullname.',

                                        </p>
                                        <p style="line-height: 24px;">
                                            Seems like you have forgot your password for Footshots. If this is true, click below to reset your password.
                                        </p>
                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0">

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->

                                                    <div style="line-height: 22px;">
                                                        <a href="'.base_url().'Forgotpass/forgot_pass/'.$user_id.'" style="text-decoration: underline;color:#376bcc">Reset Password</a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>

                                        </table>
                                        <p style="line-height:24px;margin-bottom:25px;">
                                            If you did not forgot your password, you can safely ignore this email.
                                        </p>
                                        <p style="line-height: 24px">
                                            Regards,<br>
                                            Footshots Team
                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>





                </table>

            </td>
        </tr>

        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>

    </table>

    <!-- end section -->


    <table border="0" width="370" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td height="30" width="" style="border-top: 1px solid #edecec;font-size: 60px; line-height: 30px;">&nbsp;</td>
        </tr>
    </table>

    <!-- contact section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr class="hide">
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

        

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590 bg_color">

                    <tr>
                        <td>
                            <table border="0" width="300" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <!-- logo -->
                                    <td align="left">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="80" border="0" style="display: block; width: 80px;" src="img/logo_tagline.png" alt="" /></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="left" style="color: #888888; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 23px;" class="text_color">
                                        <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">

                                            Email us: <br/> <a href="mailto:info@footshots.com.au" style="color: #888888; font-size: 14px; font-family: \'Hind Siliguri\', Calibri, Sans-serif; font-weight: 400;">info@footshots.com.au</a>
                                            

                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <table border="0" width="2" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">
                                <tr>
                                    <td width="2" height="10" style="font-size: 10px; line-height: 10px;"></td>
                                </tr>
                            </table>

                            <table border="0" width="200" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">

                                <tr>
                                    <td class="hide" height="45" style="font-size: 45px; line-height: 45px;">&nbsp;</td>
                                </tr>



                                <tr>
                                    <td height="15" style="font-size: 15px; line-height: 15px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" align="right" cellpadding="0" cellspacing="0">
                                            <!-- <tr>
                                                <td>
                                                    <a href="https://www.facebook.com/mdbootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Qc3zTxn.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://twitter.com/MDBootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/RBRORq1.png" alt=""></a>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td>
                                                    <a href="https://plus.google.com/u/0/b/107863090883699620484/107863090883699620484/posts" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Wji3af6.png" alt=""></a>
                                                </td>
                                            </tr> -->
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end section -->

    <!-- footer ====== -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">

        <tr>
            <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td>
                             


                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:70px;" class="container590">

                                <tr>
                                    <td align="center">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    &copy; 2019 Footshots Pty Ltd
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end footer ====== -->

</body>

</html>';


      $this->send_email_sendgrid_api($result->useremail,'me','Footshots: Forgot Password',$message); /*Call a function to send forgot password email.*/

$datas = array(                                                      /*An array of data to insert into table*/
         
         'user_id' => $user_id 
     

         ); 
       
        $this->db->insert('footshot_forgot_password', $datas); 
 

            return true;                    /*return if successfully*/
                  

         }

         return false;                      /*return if failure*/

      } 

  public function update_new_user($data)
  {

 
 
    $user_id =  $data->user_id;
 
      $profileimage =  $data->profileimage;
   
    $fullname =  $data->fullname;
    $username =  $data->username;

  
     

    $datas = array(                                                      /*An array of data to update into table*/
                          

     'fullname' => $fullname,
     'username' => $username,
 

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

       $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "from_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $results = $query->result();

        $results = array_shift($results);

        $result[0]->total_you_following = $results->following;

         $this->db->select('count(*) as followers');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "to_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $results = $query->result();

        $results = array_shift($results);

        $result[0]->total_your_followers = $results->followers; 
  $result[0]->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

      return $result;                                                 /*return data of user to the controller which call this function  */            

 
    }



  
  }

   public function update_location($data)
  {
      $address =  $data->address;
      $city =  $data->city;
      $state =  $data->state;
      $country =  $data->country;
      $lat =  $data->lat;
      $lng =  $data->lng;
      $user_id =  $data->user_id;

      $this->db->select('*');

            $this->db->from('foot_user_location');

            $where = "user_id='".$user_id."'";                      /*select user with same email*/

            $this->db->where($where);

            $query = $this->db->get();

            $resultlcoation = $query->row();

            if($resultlcoation)
            {
     
                $dataslocation = array( 
                 'user_id' => $user_id,
                 'lat' => $lat,
                 'lng' => $lng,
                 'address' =>$address,
                 'city' => $city,
                 'state' => $state,
                 'country' => $country,
                  'date_of_modify' => date('Y-m-d H:i:s')

                 ); 
                
           

               $this->db->where('user_id', $user_id);

              $this->db->update('foot_user_location', $dataslocation);   
            } 
            else
            {
                $dataslocation = array(      /*An array of data to insert into table*/       
                 'user_id' => $user_id,
                 'lat' => $lat,
                 'lng' => $lng,
                 'address' =>$address,
                 'city' => $city,
                 'state' => $state,
                 'country' => $country,
                  'date_of_modify' => date('Y-m-d H:i:s')

                 ); 
               
                $this->db->insert('foot_user_location', $dataslocation); 
            }

       return $dataslocation; 
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
       $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "from_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $results = $query->result();

        $results = array_shift($results);

        $result[0]->total_you_following = $results->following;

         $this->db->select('count(*) as followers');                                    /*select recently updated user data */ 

        $this->db->from('foot_follow'); 

        $where = "to_id= '".$user_id."' and  follow_status='active' ";

         $this->db->where($where);
          $query = $this->db->get();

        $results = $query->result();

        $results = array_shift($results);

        $result[0]->total_your_followers = $results->followers; 

  $result[0]->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

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
   public function update_cover($data)

  { 
 
 
    $user_id =  $data->user_id;



      $profilecover =  $data->profilecover;
 
 

        $datas = array(                                                      /*An array of data to update into table*/

         'profilecover' => $profilecover 

         );
 
         $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $datas); 



    $this->db->select('*');                                      /*select recently updated user data */ 



    $this->db->from('foot_app_users'); 



    $where = "user_id= '".$user_id."'";

 
    $this->db->where($where);



    $query = $this->db->get();



    $result = $query->result();

 

    if($result){ 

      $result[0]->profile_url =base_url()."userprofile/index.php?user_id=".$user_id;

          return $result;                                                 /*return data of user to the controller which call this function  */            

     
        }

     



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



  public function logout_user($data)

  {

         $user_id = $data->user_id;

         
        $this->db->select('*');                                      /*select recently updated user data */ 



        $this->db->from('foot_app_users'); 



        $where = "user_id= '".$user_id."' ";

         $this->db->where($where);



        $query = $this->db->get();


        $result = $query->result();

        $result = array_shift($result);
 

         $datas = array(                                                      /*An array of data to update into table*/

         'device_token' => '', 
         'login_token' => '', 

         );



         $this->db->where('user_id', $user_id);

        $this->db->update('foot_app_users', $datas); 

         return 0;
  }
  
  /*Method for Blocked User LIst*/

  public function blocked_User_list($data)
  {

          
         $user_id =  $data->user_id;
         $limit= 20;

        $this->db->select('foot_blocked_user.*');                                   /*select recently updated user data */ 

        $this->db->from('foot_blocked_user');        

        $where = "block_status= 'active' and foot_blocked_user.user_id='$user_id'";
     
        $this->db->where($where);
        $this->db->order_by("block_id", "desc");
         


        $query = $this->db->get();      

        $re = array();

        $resultPosts = $query->result();  

 

         foreach ($resultPosts as   $value) {
            
              
                  $comment_user_id = $value->other_user_id;

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

  public function search_username_list($data)
  {

        $search_user_text = $data->search_text;
 

        $user_id = $data->user_id;
 

        /* $this->db->select('fullname,profileimage,total_post,status,user_id');                                   

        $this->db->from('foot_app_users'); 

        $where = "user_id!= '".$user_id."' and fullname LIKE '$search_user_text%' and status='Active'  and status='Active'";

         $this->db->where($where);

          $this->db->order_by("user_id", "desc");

         $this->db->limit($limit, $start);

        $query = $this->db->get();*/

       /*  $query = $this->db->query("SELECT fullname,profileimage,total_post,status,user_id FROM foot_app_users  where user_id!= '".$user_id."' and user_type='user' and fullname LIKE '$search_user_text%' and status='Active' and (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and foot_blocked_user.user_id=foot_app_users.user_id and block_status='active')  or (other_user_id=foot_app_users.user_id and foot_blocked_user.user_id='".$user_id."' and block_status='active')  )  ='0'  order by user_id desc limit $start,$limit");*/ //removed the condition as discussed with App Team (iOS)
         //$query = $this->db->query("SELECT fullname,profilecover,profileimage,total_post,status,user_id FROM foot_app_users  where   user_type='user' and username LIKE '%$search_user_text%' and status='Active' and  user_id in (select to_id from foot_follow where from_id='$user_id' )  order by username asc ");
          $query = $this->db->query("SELECT fullname,profilecover,profileimage,total_post,status,user_id,username FROM foot_app_users  where  user_id!='".$user_id."' and user_type='user' and username LIKE '$search_user_text%' and status='Active' and (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and foot_blocked_user.user_id=foot_app_users.user_id and block_status='active')  or (other_user_id=foot_app_users.user_id and foot_blocked_user.user_id='".$user_id."' and block_status='active')  )  ='0'  order by username asc  ");


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
  public function search_user_list($data)
  {
        $search_user_text = $data->search_text;

        $start = $data->post_value;

        $user_id = $data->user_id;

        $limit =20;

        /* $this->db->select('fullname,profileimage,total_post,status,user_id');                                   

        $this->db->from('foot_app_users'); 

        $where = "user_id!= '".$user_id."' and fullname LIKE '$search_user_text%' and status='Active'  and status='Active'";

         $this->db->where($where);

          $this->db->order_by("user_id", "desc");

         $this->db->limit($limit, $start);

        $query = $this->db->get();*/

       /*  $query = $this->db->query("SELECT fullname,profileimage,total_post,status,user_id FROM foot_app_users  where user_id!= '".$user_id."' and user_type='user' and fullname LIKE '$search_user_text%' and status='Active' and (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and foot_blocked_user.user_id=foot_app_users.user_id and block_status='active')  or (other_user_id=foot_app_users.user_id and foot_blocked_user.user_id='".$user_id."' and block_status='active')  )  ='0'  order by user_id desc limit $start,$limit");*/ //removed the condition as discussed with App Team (iOS)
         $query = $this->db->query("SELECT fullname,profilecover,profileimage,total_post,status,user_id,username FROM foot_app_users  where   user_type='user' and fullname LIKE '%$search_user_text%' and status='Active' and (select count(*) from foot_blocked_user where (other_user_id='".$user_id."' and foot_blocked_user.user_id=foot_app_users.user_id and block_status='active')  or (other_user_id=foot_app_users.user_id and foot_blocked_user.user_id='".$user_id."' and block_status='active')  )  ='0'  order by fullname asc limit $start,$limit");

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


        $NotificationUserDetail = $this->User_model->single_users_detail($other_user_id);
        $myUserDetail = $this->User_model->single_users_detail($user_id);

             $device_type =  $NotificationUserDetail->device_type;
             $device_token =  $NotificationUserDetail->device_token;

             if($follow_status=='request')
             {
              $message = $this->decodeEmoticons($myUserDetail->fullname." has requested to follow you.");

              $notif =  "follow_request";
              $action = "follow_request";
             }
             else
             {
               $message =$this->decodeEmoticons($myUserDetail->fullname." started following you.");
                $notif =  "add_follow";
                 $action = "profile_detail";

                   $data = array(  

                     'user_id' => $other_user_id,

                     'from_id' => $user_id,     

                     'timeline_id' => "0",

                     'notification_type' =>  $notif,
                 
                     'read_status' =>'0',

                     'date_of_notification'=> date('Y-m-d H:i:s'), 

                    );

                 

                    $this->db->insert('foot_notification', $data); 
             }

            
             $value['user_id'] = $other_user_id;
             $value['other_user_id'] = $user_id;
              $value['other_user_name'] = $myUserDetail->fullname;

              $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$other_user_id' and read_status='0' and notification_status='active'");
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



                            
                  }

      
    
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


                return 1;

           
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

                  if($follow_status=='active')
                  {


                        $this->db->select('foot_follow.*');

                         $this->db->from('foot_follow'); 

                            $where = "follow_id='$follow_id' ";

                         $this->db->where($where);                               

                          $query = $this->db->get();

                              $resultPosts = $query->row();

                              $other_user_id = $resultPosts->from_id;

                         $NotificationUserDetail = $this->User_model->single_users_detail($other_user_id);
                         $myUserDetail = $this->User_model->single_users_detail($user_id);

                        $device_type =  $NotificationUserDetail->device_type;
                        $device_token =  $NotificationUserDetail->device_token;

                         
                              $message = $this->decodeEmoticons($myUserDetail->fullname." accepted your follow request.");
                         
                         
                   if($NotificationUserDetail->user_id!=$user_id)
                   {
                                $action = "profile_detail";
                                $value['user_id'] = $other_user_id;
                                $value['other_user_id'] = $user_id;
                                  $value['other_user_name'] = $myUserDetail->fullname;

                                           $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$other_user_id' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();
                 $value['total_unread_notification'] =$total_unread_notification;


                                  $badge = 1;

                                   $badge = $NotificationUserDetail->badge+1;

                           $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                            $this->db->query($sql);

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

                                $data = array(                                                      /*An array of data to insert into table*/

                             'user_id' => $other_user_id,

                             'from_id' => $user_id,     

                             'timeline_id' => "0",

                             'notification_type' => "approve_request",
                         
                             'read_status' =>'0',

                             'date_of_notification'=> date('Y-m-d H:i:s'), 

                            );

                         

                            $this->db->insert('foot_notification', $data);                             /* insert data into table*/      
                            
                            /* insert data into table*/      
                        }
                          return 0;
                  }
                    return 1;
              



  }


  public function follow_request_count($data)
  {

 
      $user_id =  $data->user_id;   


        


      $this->db->select('foot_follow.*');

        $this->db->from('foot_follow'); 

        $where = "to_id='$user_id' and follow_status='request'";

        $this->db->where($where);    

          $this->db->order_by("follow_id", "desc");

       

        $query = $this->db->get();

        $resultPosts = $query->num_rows();

        return $resultPosts;

         
  }

  public function follow_request_list($data)
  {  
 
      $user_id =  $data->user_id;   


       $start = $data->post_value; 
        

        $limit =20;


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



  public function follow_sent_request_list($data)
  {  
 
      $user_id =  $data->user_id;   


       $start = $data->post_value; 
        

        $limit =20;


      $this->db->select('foot_follow.*');

        $this->db->from('foot_follow'); 

        $where = "from_id='$user_id' and follow_status='request'";

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
          return $resultPosts;            
  }


  public function following_list($data)
  {  
 
      $user_id =  $data->user_id;   


        $start = $data->post_value; 
        $other_user_id = $data->other_user_id; 

        $limit =20;


        $this->db->select('foot_follow.*');

        $this->db->from('foot_follow');

        $this->db->join('foot_app_users',"foot_app_users.user_id = foot_follow.to_id"); 

        $where = "from_id='$other_user_id' and follow_status='active'";

        $this->db->where($where);    

          $this->db->order_by("foot_app_users.fullname", "asc");

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

        $limit =20;


      $this->db->select('foot_follow.*');

        $this->db->from('foot_follow'); 
        $this->db->join('foot_app_users',"foot_app_users.user_id = foot_follow.from_id"); 

        $where = "to_id='$other_user_id' and follow_status='active'";

        $this->db->where($where);    

          $this->db->order_by("foot_app_users.fullname", "asc");

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
              
              $resultuser = strval($queryuser->num_rows());



              // print_r($resultuser);die();
              

              return $resultuser;


  }

  function redeem_point_list($data)
  {   
    $user_id = $data->user_id;


 
              $this->db->select('*');                                    /*select recently updated user data */ 

              $this->db->from('foot_user_redeem'); 

              $where = "user_id= '".$user_id."' ";

               $this->db->where($where); 

              $queryuser = $this->db->get();
              
           $resultuser = $queryuser->result();
              

              return $resultuser; 


  }

   function total_earned_points($user_id)
  {
 
              $this->db->select('total_points');                                    /*select recently updated user data */ 

              $this->db->from('foot_app_users'); 

              $where = "user_id= '".$user_id."'     ";

               $this->db->where($where);
          

              $queryuser = $this->db->get();
              
              
           $resultuser = $queryuser->row();
              
           
              return $resultuser->total_points; 


  }
  
  function send_email_redeem_points()
  {
  

    $this->db->select('foot_app_users.*');

    $this->db->from('foot_user_redeem');
    $this->db->join('foot_app_users',"foot_app_users.user_id = foot_user_redeem.user_id");  
    $this->db->group_by('foot_app_users.user_id');
    $where = "foot_app_users.user_id!='31'";
    $this->db->where($where); 
    $query = $this->db->get(); 
    $result = $query->result();
    foreach ($result as   $value) {
      # code...
    
    $email = $value->useremail;
    $fullname = $value->fullname;


            $text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!-- <![endif]-->

    <title>Footshots</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }
        
        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        span.preheader {
            display: none;
            font-size: 1px;
        }
        
        html {
            width: 100%;
        }
        
        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */
        
        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }
        
        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!-- [if gte mso 9]><style type=”text/css”>
        body {
        font-family: \'Roboto\', sans-serif;!important;
        }
        </style>
    <![endif]-->
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:\'Roboto\', sans-serif;maxheight:0px;max-width:0px;opacity:0;">
                    Pre-header for the newsletter template
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 60px;" src="http://www.footshots.com.au/images/logo.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <p style="font-size:14px;font-family: Calibri, Candara, Segoe, \'Segoe UI\', Optima, Arial, sans-serif;color: #444;font-weight: 600;">
                                            Share the story of your feet.
                                            <br>
                                            Capture the moment, wherever your feet take you.
                                            <br>
                                            Share the moments about your feet for they tell unlimited stories.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>

                        <td align="center" class="section-img">
                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="http://www.footshots.com.au/images/intro-bg.png" style="display: block; width: 590px;" width="590" border="0" alt="" /></a>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: \'Roboto\', sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                            <div style="line-height: 35px">

                                Thank you for <span style="color: #376bcc;">donating points!</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="530" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="justify" style="color: #444; font-size: 16px; font-family: Calibri, Candara, Segoe, \'Segoe UI\', Optima, Arial, sans-serif; line-height: 24px;">
                                        <div style="line-height: 24px">
                                            <strong>
                                                Hi '.$fullname.',   
                                              <br><br>Congratulations!                                            
                                              <br><br>YOU have made a change in this world!                                      
                                              <br><br>Since you have redeemed your points, another person has been provided with much needed, comfortable footwear. With an estimated 300 million people in the world without footwear, our goal is to provide footwear to those who need it most, locally and abroad.                                           
                                         <br><br>Thank you for being a part of our vision. Please keep sharing your journey with us at Footshots. Continue to follow Footshots to see the difference YOU have made.<br><br>The Footshots team will soon donate a pair of footwear to someone in need on your behalf and you will be notified.</strong>
                                            <br><br>
                                        </div>
                                        <div style="line-height: 25px;font-size: 16px;">
                                         <br><br>
                                            <strong>Sincerely,</strong><br>
                                            <span style="line-height: 16px;">
                                                <strong>The Footshots Family<br>
                                                Footshots Pty Ltd<br></strong>
                                                <a href="http://www.footshots.com.au/">www.footshots.com.au</a>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="35" style="font-size: 25px; line-height: 35px;">&nbsp;</td>
                    </tr>
                    

                </table>

            </td>
        </tr>

    </table>
    <!-- end section -->
    
    <table border="0" width="370" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td height="30" width="" style="border-top: 1px solid #edecec;font-size: 60px; line-height: 30px;">&nbsp;</td>
        </tr>
    </table>

   

    <!-- footer ====== -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">

        <tr>
            <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td>


                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:0px;" class="container590">

                                <tr>
                                    <td align="center">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="font-family: \'Roboto\', sans-serif;">
                                                    &copy; 2020 Footshots
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end footer ====== -->

</body>

</html>';

     
  //echo "user- ".$email."-".$fullname."<br>";

    //$this->send_email_sendgrid_api($email,'me','Footshots: Thank you for donating points!',$text);  

      } 

           return 0; 


  
  }

  function redeem_points($data)
  {
 
             $user_id = $data->user_id;
             $total_points = $data->total_points;
             $total_sliper = $data->total_points/500;

            $datae = array(                                                      /*An array of data to insert into table*/

             'user_id' => $user_id,

             'total_points' => $total_points,     

             'total_sliper' => $total_sliper,

             'redeem_request' => "0",
          
             'date_of_redeem'=> date('Y-m-d H:i:s') 

             );

  
          $this->db->insert('foot_user_redeem', $datae); 

                                                  /*Check into the table  email is already exist or not.*/


       $this->db->select('*');

    $this->db->from('foot_app_users');

    $where = "user_id='".$user_id."' ";

    $this->db->where($where);

    $query = $this->db->get();

    $result = $query->row();
    $email = $result->useremail;
    $fullname = $result->fullname;


            $text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!-- <![endif]-->

    <title>Footshots</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }
        
        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        span.preheader {
            display: none;
            font-size: 1px;
        }
        
        html {
            width: 100%;
        }
        
        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */
        
        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }
        
        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!-- [if gte mso 9]><style type=”text/css”>
        body {
        font-family: \'Roboto\', sans-serif;!important;
        }
        </style>
    <![endif]-->
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:\'Roboto\', sans-serif;maxheight:0px;max-width:0px;opacity:0;">
                    Pre-header for the newsletter template
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 60px;" src="http://www.footshots.com.au/images/logo.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td align="center">

                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <p style="font-size:14px;font-family: Calibri, Candara, Segoe, \'Segoe UI\', Optima, Arial, sans-serif;color: #444;font-weight: 600;">
                                            Share the story of your feet.
                                            <br>
                                            Capture the moment, wherever your feet take you.
                                            <br>
                                            Share the moments about your feet for they tell unlimited stories.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>

                        <td align="center" class="section-img">
                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="http://www.footshots.com.au/images/intro-bg.png" style="display: block; width: 590px;" width="590" border="0" alt="" /></a>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: \'Roboto\', sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                            <div style="line-height: 35px">

                                Thank you for <span style="color: #376bcc;">donating points!</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="530" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="justify" style="color: #444; font-size: 16px; font-family: Calibri, Candara, Segoe, \'Segoe UI\', Optima, Arial, sans-serif; line-height: 24px;">
                                        <div style="line-height: 24px">
                                            <strong>
                                                Hi '.$fullname.',   
                                              <br><br>Congratulations!                                            
                                              <br><br>YOU have made a change in this world!                                      
                                              <br><br>Since you have redeemed your points, another person has been provided with much needed, comfortable footwear. With an estimated 300 million people in the world without footwear, our goal is to provide footwear to those who need it most, locally and abroad.                                           
                                         <br><br>Thank you for being a part of our vision. Please keep sharing your journey with us at Footshots. Continue to follow Footshots to see the difference YOU have made.<br><br>The Footshots team will soon donate a pair of footwear to someone in need on your behalf and you will be notified.</strong>
                                            <br><br>
                                        </div>
                                        <div style="line-height: 25px;font-size: 16px;">
                                         <br><br>
                                            <strong>Sincerely,</strong><br>
                                            <span style="line-height: 16px;">
                                                <strong>The Footshots Family<br>
                                                Footshots Pty Ltd<br></strong>
                                                <a href="http://www.footshots.com.au/">www.footshots.com.au</a>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="35" style="font-size: 25px; line-height: 35px;">&nbsp;</td>
                    </tr>
                    

                </table>

            </td>
        </tr>

    </table>
    <!-- end section -->
    
    <table border="0" width="370" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td height="30" width="" style="border-top: 1px solid #edecec;font-size: 60px; line-height: 30px;">&nbsp;</td>
        </tr>
    </table>

   

    <!-- footer ====== -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">

        <tr>
            <td height="15" style="font-size: 25px; line-height: 15px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center">

                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td>


                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:0px;" class="container590">

                                <tr>
                                    <td align="center">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="font-family: \'Roboto\', sans-serif;">
                                                    &copy; 2020 Footshots
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
        </tr>

    </table>
    <!-- end footer ====== -->

</body>

</html>';

      //$text = '<p>Dear '.$first_name.' '.$last_name.', Congratulation ! You have successfully signed up for Mexus App.</p>';
   


      $this->send_email_sendgrid_api($email,'me','Footshots: Thank you for donating points!',$text);  /*Call a function to send welcome email.*/

           return 0; 


  }



   function total_redeem_points($user_id)
  {
 
              $this->db->select('sum(total_points) as total_redeem');                                    /*select recently updated user data */ 

              $this->db->from('foot_user_redeem'); 

              $where = "user_id= '".$user_id."'     ";

               $this->db->where($where);
          

              $queryuser = $this->db->get();
              
           $resultuser = $queryuser->row();
              

              return $resultuser->total_redeem; 


  }

     function admin_total_points( )
  {
 
              $this->db->select('sum(total_points) as total_points');                                    /*select recently updated user data */ 

              $this->db->from('foot_user_points'); 
  
          

              $queryuser = $this->db->get();
              
           $resultuser = $queryuser->row();
              

              return $resultuser->total_points; 


  }


     function admin_total_points_donated( )
  {
 
              $this->db->select('sum(total_points) as total_redeem, sum(total_sliper) as total_sliper');                                    /*select recently updated user data */ 

              $this->db->from('foot_user_redeem'); 
    
              $queryuser = $this->db->get();
              
              $resultuser = $queryuser->row(); 

              return $resultuser; 


  }


  function user_personal_detail($comment_user_id,$user_id)
  {
              $resultuser = array();
              $this->db->select('*');                                    /*select recently updated user data */ 

              $this->db->from('foot_app_users'); 

              $where = "user_id= '".$comment_user_id."'    ";

               $this->db->where($where);
          

              $queryuser = $this->db->get();

               $resultusers = $queryuser->result_array();
               if(empty($resultusers))
               {
               // echo $comment_user_id;
              // die();
               }
               $resultuser = $resultusers[0];

             // $comment_user_id = $resultuser->user_id;

              $resultuserpost = $this->user_total_posts($comment_user_id);

              if($resultuserpost)
              {



              $resultuser['total_post'] = strval($resultuserpost);
              }
              else
              {
                 $resultuser['total_post'] = "0";
              }

           //   $resultuser = array_shift($resultuser);
 
              $this->db->select('count(*) as following');                                    /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "from_id= '".$comment_user_id."' and  follow_status='active' ";

              $this->db->where($where);

              $query = $this->db->get();
  
              $result = $query->result_array();

              // print_r($result[0]['following']);die();

             // $result = array_shift($result);
              

             $resultuser['total_you_following'] = $result[0]['following'];
               
                

              $this->db->select('count(*) as followers');                                    /*select recently updated user data */ 

              $this->db->from('foot_follow'); 

              $where = "to_id= '".$comment_user_id."' and  follow_status='active' ";

              $this->db->where($where);
              
              $query = $this->db->get();

              $result = $query->result_array();
              // print_r($result[0]['followers']);die();

              $resultuser['total_your_followers'] = $result[0]['followers'];

              $this->db->select('foot_follow.*');
              $this->db->from('foot_follow'); 
              $where = "from_id='$user_id' and to_id='$comment_user_id' and follow_status!='deactive'";
              $this->db->where($where);    
              $query = $this->db->get();
              $restults = $query->result_array();
              // print_r($results['follow_status']);die;
             // $restultsfollow = array_shift($restults);

              if($restults)
              {

                  $resultuser['is_following']= $restults[0]['follow_status'];
                }
                else
                {
                  $resultuser['is_following'] = "";
                }

               $this->db->select('foot_follow.*');
              $this->db->from('foot_follow'); 
              $where = "from_id='$comment_user_id' and to_id='$user_id' and follow_status!='deactive'";
              $this->db->where($where);    
              $query = $this->db->get();
              $restults = $query->result_array();
       

             //$resultuser->is_followed = $restultsfollow->follow_status;


              if($restults)
              {

                  $resultuser['is_followed'] = $restults[0]['follow_status'];
                }
                else
                {
                  $resultuser['is_followed'] = "";
                }


                /* $this->db->select('foot_follow.*');
                $this->db->from('foot_follow'); 
                $where = "from_id='$comment_user_id' and to_id='$user_id' and follow_status!='deactive'";
                $this->db->where($where);    
                $query = $this->db->get();*/

               
                 $query = $this->db->query("select * from foot_blocked_user where   other_user_id='".$comment_user_id."' and user_id='".$user_id."' and block_status='active'");

                $restults = $query->result_array();
       
  
                if($restults)
                {

                  $resultuser['is_blocked'] = "1";
                }
                else
                {
                  $resultuser['is_blocked'] = "0";
                }
// print_r($resultuser);die();

                $resultuser['profile_url'] =base_url()."userprofile/index.php?user_id=".$user_id;

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

                 $resultuser['profile_url'] =base_url()."userprofile/index.php?user_id=".$user_id;

                return $resultuser;
  } 



   public function ajax_list_items($search='',$per_page=10,$start=0) 
    {
        $this->db->select('ch.*,foot_app_users.fullname', false);
        $this->db->from('foot_user_redeem as ch');
        $this->db->join('foot_app_users',"foot_app_users.user_id = ch.user_id");
        if($search!='')
        {
            $this->db->like('foot_app_users.fullname',$search);
        } 
        $this->db->order_by('ch.redeem_id', 'Desc');
        $this->db->limit($per_page,$start);
       $resultPosts =$this->db->get()->result();
          $re = array();

          foreach ($resultPosts as   $value) {
            
            if($value->timeline_id>0)
            { 
                $this->db->select('foot_posts.*');                                   /*select recently updated user data */ 

                $this->db->from('foot_posts'); 
                $this->db->join('foot_app_users','foot_app_users.user_id =foot_posts.user_id '); 


                $where = "post_status= 'active' and post_type='post' and post_id='$value->timeline_id'";
             
                $this->db->where($where);      

                $query = $this->db->get();

                $timeline_detail = $query->row();  
                if($timeline_detail)
                {
          
                $value->timelineiamge =  $timeline_detail->post_image_url;
               }
               else
               {
                    $value->timelineiamge = "";
               }
            } 
           

            $re[] = $value;
        }

        $data['result'] =  $re;

        $this->db->select("COUNT(ch.redeem_id) AS count");

       $this->db->from('foot_user_redeem as ch');
        $this->db->join('foot_app_users',"foot_app_users.user_id = ch.user_id");
        if($search!='')
        {
            $this->db->like('foot_app_users.fullname',$search);
        }
      $this->db->order_by('ch.redeem_id', 'Desc');         
        $data['count']=$this->db->count_all_results();    
         
        return $data;
    }


}