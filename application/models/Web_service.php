<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Web_service extends CI_Controller {

    function __construct()

      {

            // Construct the parent class

        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->db->query('SET time_zone="+05:30"');
        $this->load->model('User_model');                 /*Load model User model.*/
        $this->load->model('Post_model');                 /*Load model Post model.*/
        $this->load->model('Comment_model');                 /*Load model Comment model.*/
        $this->load->model('Like_model');                 /*Load model Like model.*/
        $this->load->model('Message_model');                 /*Load model Message model.*/

      }

      public function index()

      {



       $req=file_get_contents('php://input');


       if(empty($req))

       {

        $req=json_encode($_REQUEST);
         
 
       } 




       $data=json_decode($req);
 


       $method_name=$data->method;
      
       if(method_exists($this,$method_name))

       {

        echo json_encode($this->$method_name($data));

      }

      else

      {

        echo json_encode(array("message"=>"method doest not exist."));

      }

       

    }


       /*Method to check the user exist of not using uid and login token*/



     public function user_verify($data)

    {

       $result = $this->User_model->user_verify($data);



       if($result == 700){

          $message = array(

            'message' => 'Your session has been expired. Please login again.',

            'err_code'=>700

            );

        return ($message);

        } 



       return 0;                                                            /*Data return to the function in which this will be call.*/

    } 


   /*Method to register a new user.*/

   public function verifyusername($data)
    {

   
         $data->{'username'}= $_POST['username'];
         $data->{'user_id'}= $_POST['user_id'];
 

        



      $result = $this->User_model->verify_username($data);            



      if($result)

      {

         
               if($result == "4")                                                         /*Condition if email is already exist.*/

              {

                $message = array(

                  'err_code' => 300,

                  'message' => 'This username is already exist. Kindly use different username.'

                  );

              }

 

              else
              { 

              $message = array(

                  'err_code' => 0,

                  'message' => 'You can use this username.' 

                  );}      


          return $message;                                                          /*Data return to the app.*/

        }   



    
    }
    public function signup_new_user_new($data)
    {


  
         $data->{'useremail'}= $_POST['useremail']; 
         $data->{'device_type'}= $_POST['device_type'];
         $data->{'device_token'}= $_POST['device_token']; 
         $data->{'password'}= $_POST['password'];
         $data->{'fullname'}= $_POST['fullname'];
         $data->{'username'}= $_POST['username'];
              
         $latitude= $_POST['lat'];
         $longitude= $_POST['lng'];
         $data->{'lat'}= $latitude;
         $data->{'lng'}= $longitude;   

          $data->{'profileimage'}="";
          $data->{'address'}="";
           $data->{'city'}="";
           $data->{'state'}="";
           $data->{'country'}=""; 


          $geolocation = $latitude.','.$longitude;
          $request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false&key=AIzaSyC-GBF8a02jllqhFnh448-zievKxNgPmwc'; 
           $file_contents = file_get_contents($request);
           
          $json_decode = json_decode($file_contents);
          if(isset($json_decode->results[0])) {
              $response = array();
              foreach($json_decode->results[0]->address_components as $addressComponet) {
                  if(in_array('political', $addressComponet->types)) {
                          $response[] = $addressComponet->long_name; 
                  }
              }

              if(isset($response[0])){ $first  =  $response[0];  } else { $first  = 'null'; }
              if(isset($response[1])){ $second =  $response[1];  } else { $second = 'null'; } 
              if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
              if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
              if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }

              if( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null' ) {
                  $data->{'address'}=$first;
                 $data->{'city'}=$second;
                 $data->{'state'}=$fourth;
                  $data->{'country'}=$fifth;
              }
              else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null'  ) {
                   $data->{'address'}=$first;
                   $data->{'city'}=$second;
                   $data->{'state'}=$third;
                   $data->{'country'}=$fifth;

              }
              else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null' ) {
                  $data->{'address'}="";
                   $data->{'city'}=$first;
                   $data->{'state'}=$second;
                   $data->{'country'}=$third;
 
              }
              else if ( $first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                   $data->{'address'}="";
                   $data->{'city'}="";
                   $data->{'state'}=$first;
                   $data->{'country'}=$second;

              }
              else if ( $first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                    $data->{'address'}="";
                   $data->{'city'}="";
                   $data->{'state'}="";
                   $data->{'country'}=$first; 
              }
            }

           


      $result = $this->User_model->signup_new_user_new($data);            



      if($result)

      {

        if($result == "2")                                                         /*Condition if email is already exist.*/

              {

                $message = array(

                  'err_code' => 300,

                  'message' => 'This email id already exist. Kindly use different email id.'

                  );

              }
              else if($result == "4")                                                         /*Condition if email is already exist.*/

              {

                $message = array(

                  'err_code' => 300,

                  'message' => 'This username is already exist. Kindly use different username.'

                  );

              }

 

              else

              {                                                                      /*Condition if user register successfully.*/

                        if(isset($_FILES['user_pic']['name']))                                            /*check image is not there*/

                        {                                                                                     

                          $ids = rand(1,100);

                          $dir_path="upload/".$result->user_id;

                          @mkdir($dir_path);

                          $img_name_array= $_FILES['user_pic']['name'];

                            //$img_ext=end($img_name_array);

                          $time = time().'.jpg';

                          $selfie=$ids.'_'.$time;

                          $upload_path=$dir_path.'/'.$selfie;

                          
                          

                            file_put_contents($upload_path, file_get_contents($_FILES['user_pic']['tmp_name']));        /*Save the file on the server */

                 

                          $data->{'profileimage'} = base_url().$upload_path;
                           $data->{'user_id'} = $result->user_id;
                            $this->User_model->update_image($data);    

                             $result->profileimage = base_url().$upload_path;

                        }

                 $message = array(

                  'err_code' => 0,

                  'message' => 'You are successfully registered to FootShots.',

                  'result' => $result

                  );

              }      


          return $message;                                                          /*Data return to the app.*/

        }   
 
    
    }
   public function signup_new_user($data)
    {

  
         $data->{'useremail'}= $_POST['useremail']; 
         $data->{'device_type'}= $_POST['device_type'];
         $data->{'device_token'}= $_POST['device_token']; 
         $data->{'password'}= $_POST['password'];
         $data->{'fullname'}= $_POST['fullname'];
         $data->{'username'}= $_POST['username'];

          $data->{'profileimage'}="";

        



      $result = $this->User_model->signup_new_user($data);            



      if($result)

      {

        if($result == "2")                                                         /*Condition if email is already exist.*/

              {

                $message = array(

                  'err_code' => 300,

                  'message' => 'This email id already exist. Kindly use different email id.'

                  );

              }
              else if($result == "4")                                                         /*Condition if email is already exist.*/

              {

                $message = array(

                  'err_code' => 300,

                  'message' => 'This username is already exist. Kindly use different username.'

                  );

              }

 

              else

              {                                                                      /*Condition if user register successfully.*/

                        if(isset($_FILES['user_pic']['name']))                                            /*check image is not there*/

                        {                                                                                     

                          $ids = rand(1,100);

                          $dir_path="upload/".$result->user_id;

                          @mkdir($dir_path);

                          $img_name_array= $_FILES['user_pic']['name'];

                            //$img_ext=end($img_name_array);

                          $time = time().'.jpg';

                          $selfie=$ids.'_'.$time;

                          $upload_path=$dir_path.'/'.$selfie;

                          
                          

                            file_put_contents($upload_path, file_get_contents($_FILES['user_pic']['tmp_name']));        /*Save the file on the server */

                 

                          $data->{'profileimage'} = base_url().$upload_path;
                           $data->{'user_id'} = $result->user_id;
                            $this->User_model->update_image($data);    

                             $result->profileimage = base_url().$upload_path;

                        }

                 $message = array(

                  'err_code' => 0,

                  'message' => 'You are successfully registered to FootShots.',

                  'result' => $result

                  );

              }      


          return $message;                                                          /*Data return to the app.*/

        }   



    
    }

    public function signup_user($data)
    {
  
         $data->{'useremail'}= $_POST['useremail']; 
         $data->{'device_type'}= $_POST['device_type'];
         $data->{'device_token'}= $_POST['device_token']; 
         $data->{'password'}= $_POST['password'];
         $data->{'fullname'}= $_POST['fullname'];

          $data->{'profileimage'}="";

        



      $result = $this->User_model->signup_user($data);            



      if($result)

      {

   			if($result == "2")                                                         /*Condition if email is already exist.*/

              {

                $message = array(

                  'err_code' => 300,

                  'message' => 'This email id already exist. Kindly use different email id.'

                  );

              }

 

	            else

	            {                                                                      /*Condition if user register successfully.*/

                        if(isset($_FILES['user_pic']['name']))                                            /*check image is not there*/

                        {                                                                                     

                          $ids = rand(1,100);

                          $dir_path="upload/".$result->user_id;

                          @mkdir($dir_path);

                          $img_name_array= $_FILES['user_pic']['name'];

                            //$img_ext=end($img_name_array);

                          $time = time().'.jpg';

                          $selfie=$ids.'_'.$time;

                          $upload_path=$dir_path.'/'.$selfie;

                          
                          

                            file_put_contents($upload_path, file_get_contents($_FILES['user_pic']['tmp_name']));        /*Save the file on the server */

                 

                          $data->{'profileimage'} = base_url().$upload_path;
                           $data->{'user_id'} = $result->user_id;
                            $this->User_model->update_image($data);    

                             $result->profileimage = base_url().$upload_path;

                        }

	               $message = array(

	                'err_code' => 0,

	                'message' => 'You are successfully registered to FootShots.',

	                'result' => $result

	                );

	            }      


	        return $message;                                                          /*Data return to the app.*/

	      }   



    }





      /*Method to signin in the app */



      public function signin_user($data)
      {
         $data->{'useremail'}= $_POST['useremail']; 
         $data->{'device_type'}= $_POST['device_type'];
         $data->{'device_token'}= $_POST['device_token']; 
         $data->{'password'}= $_POST['password'];


        $result = $this->User_model->signin_user($data);         /*Call Model function to get the data of user which same credentials  */



        if(empty($result)):

            $message = array(

              'err_code' => 300,                              

              'message' => 'The username or password you have entered is incorrect.'

              );

          return ($message);

          endif;

          if($result->status!='Active'):

            $message = array(

              'err_code' => 300,                              

              'message' => 'This account has been blocked. Please contact administrator.'

              );

          return ($message);

          endif;

        

            $message = array(

              'err_code' => 0,

              'result' => $result,

              'message' => 'You have been logged in successfully.'

              );
           

          return ($message); 

     }






       public function forgot_password($data)

      {

            $data->{'useremail'}= $_POST['useremail']; 

        $result = $this->User_model->forgot_password($data);              /*Call Model function to get new password */
 

            if($result){

              $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'An email will be sent to your email id containing a link to reset password.'

                  );

              return ($message); 

            }else{                                                                /*Return if failure */

              $message = array(

                  'err_code' => 300,

                  'message' => 'This email id is not registered on Footshots. Please register first.'

                  );

              return ($message); 

            }
          

      }

      /*method to update profile of a user*/


        public function update_new_profile($data)
      {


           
        $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }



         $data=new stdClass();

        $data->{'user_id'}= $_POST['user_id'];

       

         $data->{'username'}= $_POST['username']; 
         $data->{'fullname'}= $_POST['fullname']; 
          $data->{'login_token'}= $_POST['login_token'];

           $data->{'profileimage'}="";

        if(isset($_FILES['user_pic']['name']))                                            /*check image is not there*/

        {                                                                                     

          if(!empty($_FILES['user_pic']))
          {
            $ids = rand(1,100);

            $dir_path="upload/".$_POST['user_id'];

            @mkdir($dir_path);

            $img_name_array= $_FILES['user_pic']['name'];

              //$img_ext=end($img_name_array);

            $time = time().'.jpg';

            $selfie=$ids.'_'.$time;

            $upload_path=$dir_path.'/'.$selfie;

            
            

              file_put_contents($upload_path, file_get_contents($_FILES['user_pic']['tmp_name']));        /*Save the file on the server */

   

            $data->{'profileimage'} = base_url().$upload_path;
          }

        }


       


      header('Content-Type: application/json');



         

           $resultusername = $this->User_model->verify_username($data);  
           
               if($resultusername == "4")                                                         /*Condition if email is already exist.*/

              {

                $message = array(

                  'err_code' => 300,

                  'message' => 'This username is already exist. Kindly use different username.'

                  );

              }

               $result = $this->User_model->update_new_user($data);            /*Call Model function to get health package list */

          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         

        if($result){ 
              $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'Your profile has been successfully updated.',

                  'result' => array_shift($result)

                   

                  ); 

          return ($message); 

        }else{ 
         

            $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }

       
      }
        public function update_location($data)
      {


           
        $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }



         $data=new stdClass();

        $data->{'user_id'}= $_POST['user_id']; 
          $data->{'login_token'}= $_POST['login_token'];


         $latitude= $_POST['lat'];
         $longitude= $_POST['lng'];
         $data->{'lat'}= $latitude;
         $data->{'lng'}= $longitude; 
         
        $geolocation = $latitude.','.$longitude;
          $request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false&key=AIzaSyC-GBF8a02jllqhFnh448-zievKxNgPmwc'; 
           $file_contents = file_get_contents($request);
           
          $json_decode = json_decode($file_contents);
          if(isset($json_decode->results[0])) {
              $response = array();
              foreach($json_decode->results[0]->address_components as $addressComponet) {
                  if(in_array('political', $addressComponet->types)) {
                          $response[] = $addressComponet->long_name; 
                  }
              }

              if(isset($response[0])){ $first  =  $response[0];  } else { $first  = 'null'; }
              if(isset($response[1])){ $second =  $response[1];  } else { $second = 'null'; } 
              if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
              if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
              if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }

              if( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null' ) {
                  $data->{'address'}=$first;
                 $data->{'city'}=$second;
                 $data->{'state'}=$fourth;
                  $data->{'country'}=$fifth;
              }
              else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null'  ) {
                   $data->{'address'}=$first;
                   $data->{'city'}=$second;
                   $data->{'state'}=$third;
                   $data->{'country'}=$fifth;

              }
              else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null' ) {
                  $data->{'address'}="";
                   $data->{'city'}=$first;
                   $data->{'state'}=$second;
                   $data->{'country'}=$third;
 
              }
              else if ( $first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                   $data->{'address'}="";
                   $data->{'city'}="";
                   $data->{'state'}=$first;
                   $data->{'country'}=$second;

              }
              else if ( $first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                    $data->{'address'}="";
                   $data->{'city'}="";
                   $data->{'state'}="";
                   $data->{'country'}=$first; 
              }
            }


       

          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
     
         
               $result = $this->User_model->update_location($data);            /*Call Model function to get health package list */

         

        if($result){ 
              $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'Your location has been successfully updated.',

                  'result' => $result

                   

                  ); 

          return ($message); 

        }else{ 
         

            $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }

       
      }
      public function update_profile($data)
      {

           
        $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }



         $data=new stdClass();

        $data->{'user_id'}= $_POST['user_id'];

       

         $data->{'fullname'}= $_POST['fullname']; 
          $data->{'login_token'}= $_POST['login_token'];

           $data->{'profileimage'}="";

        if(isset($_FILES['user_pic']['name']))                                            /*check image is not there*/

        {                                                                                     

          if(!empty($_FILES['user_pic']))
          {
            $ids = rand(1,100);

            $dir_path="upload/".$_POST['user_id'];

            @mkdir($dir_path);

            $img_name_array= $_FILES['user_pic']['name'];

              //$img_ext=end($img_name_array);

            $time = time().'.jpg';

            $selfie=$ids.'_'.$time;

            $upload_path=$dir_path.'/'.$selfie;

            
            

              file_put_contents($upload_path, file_get_contents($_FILES['user_pic']['tmp_name']));        /*Save the file on the server */

   

            $data->{'profileimage'} = base_url().$upload_path;
          }

        }


       


      header('Content-Type: application/json');



          $result = $this->User_model->update_user($data);            /*Call Model function to get health package list */

          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         

        if($result){ 
              $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'Your profile has been successfully updated.',

                  'result' => array_shift($result)

                   

                  ); 

          return ($message); 

        }else{ 
         

            $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }

      }
 public function update_cover($data)
      {

           
        $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }



         $data=new stdClass();

        $data->{'user_id'}= $_POST['user_id'];

        
          $data->{'login_token'}= $_POST['login_token'];

           $data->{'profilecover'}="";

        if(isset($_FILES['user_cover']['name']))                                            /*check image is not there*/

        {                                                                                     

          if(!empty($_FILES['user_cover']))
          {
            $ids = rand(1,100);

            $dir_path="upload/".$_POST['user_id'];

            @mkdir($dir_path);

            $img_name_array= $_FILES['user_cover']['name'];

              //$img_ext=end($img_name_array);

            $time = time().'.jpg';

            $selfie='cover_'.$ids.'_'.$time;

            $upload_path=$dir_path.'/'.$selfie;

            
            

              file_put_contents($upload_path, file_get_contents($_FILES['user_cover']['tmp_name']));        /*Save the file on the server */

   

            $data->{'profilecover'} = base_url().$upload_path;
            $profilecover = base_url().$upload_path;
          }

        }


       


      header('Content-Type: application/json');




          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
          $result = $this->User_model->update_cover($data);            /*Call Model function to get health package list */

        if($result){ 
              $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'Your cover image has been successfully updated.',

                  'result' => array_shift($result)

                   

                  ); 

          return ($message); 

        }else{ 
         

            $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }

      }

 public function update_message_pic($data)
      {

           
        $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }



         $data=new stdClass();

          $data->{'user_id'}= $_POST['user_id'];

        
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'chat_id'}= $_POST['chat_id'];

           $data->{'msgpic'}="";

        if(isset($_FILES['msgpic']['name']))                                            /*check image is not there*/

        {                                                                                     

          if(!empty($_FILES['msgpic']))
          {
            $ids = rand(1,100);

            $dir_path="message_photo/".$_POST['chat_id'];

            @mkdir($dir_path);

            $img_name_array= $_FILES['msgpic']['name'];

              //$img_ext=end($img_name_array);

            $time = time().'.jpg';

            $selfie='message_'.$_POST['chat_id'].'_'.$ids.'_'.$time;

            $upload_path=$dir_path.'/'.$selfie;

            
            

              file_put_contents($upload_path, file_get_contents($_FILES['msgpic']['tmp_name']));        /*Save the file on the server */

   

            $data->{'msgpic'} = base_url().$upload_path;
            $msgpic = base_url().$upload_path;
          }

        }


       


      header('Content-Type: application/json');




          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
                    /*Call Model function to get health package list */

        if($upload_path){ 
              $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'Image has been uploaded successfully.',

                  'result' =>  $upload_path

                   

                  ); 

          return ($message); 

        }else{ 
         

            $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }

      }




      public function change_password($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'old_password'}= $_POST['old_password'];
          $data->{'new_password'}= $_POST['new_password'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         

          $result = $this->User_model->match_old_password($data);


          if($result==false)

          {

             $message = array(

                'err_code' => 300,

                'message' => 'Old password does not match. Please try again.' 

                );

          return ($message); 

          }



          $result = $this->User_model->change_password($data);            /*Call Model function to get health package list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Password updated successfully.',

                'result' => $result 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }

       public function change_account_privacy($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->change_account_privacy($data);            /*Call Model function to change user privacy */

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Privacy updated successfully.',

                'result' => $result 

                 

                );

          return ($message); 

         

      }



       public function logout_user($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->logout_user($data);            /*Call Model function to change user privacy */

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User Logout successfully.' 

                 

                );

          return ($message); 

         

      }

       /*method to create post of a user*/


      public function check_text_image($data)
      {
          $data->{'user_id'}= $_POST['user_id'];
        $data->{'login_token'}= $_POST['login_token'];
      //  $data->{'post_caption'}= $_POST['post_caption']; 

          $cap = $_POST['post_caption'];


        $verify = $this->user_verify($data);
        
        if($verify != 0){

        return $verify;

         }
         $verify = $this->User_model->user_verify_token($data);
         $verify = array_shift($verify);


         $abuse_words =  $this->abuse_words($cap);

         if ($abuse_words == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
         }

          $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  
                  'message' => 'There is no abusive word..' 
                   

                  ); 

          return ($message); 

       
      }

      public function create_post($data)
      {


       
        $data->{'user_id'}= $_POST['user_id'];
        $data->{'login_token'}= $_POST['login_token'];
        $data->{'post_caption'}= $_POST['post_caption']; 
        $cap = $_POST['post_caption'];

       /*  $data->{'tag_peoples'}= $_POST['tag_peoples']; 

         $data->{'tag_products'}= $_POST['tag_products']; */


             $cap = $_POST['post_caption'];

         if (isset($_POST['tag_products'])) {
               $tag_prdct = $_POST['tag_products'];
          foreach ($tag_prdct as $product_tag) {

            $productAbuse =  $this->abuse_words($product_tag['product_name']);

            if ($productAbuse == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
            }
      }

 }




         if(isset($_POST['tag_peoples']))
         {
          $data->{'tag_peoples'}= $_POST['tag_peoples'];
         }
         else
         {

            $data->{'tag_peoples'}= array(); 
        }

           if(isset($_POST['tag_products']))
         {
            $data->{'tag_products'}= $_POST['tag_products'];
         }
         else
         {

            $data->{'tag_products'}=array();
          }


        

         $data->{'location_address'}= $_POST['location_address']; 

         $data->{'location_latitude'}= $_POST['location_latitude']; 

         $data->{'location_longitude'}= $_POST['location_longitude'];


          $data->{'country'}= $_POST['country']; 

         $data->{'state'}= $_POST['state']; 

         $data->{'city'}= $_POST['city']; 

         $data->{'fulladdress'}= $_POST['fulladdress']; 
         
         $data->{'postal_code'}= $_POST['postal_code']; 
         $data->{'is_private'}= $_POST['is_private']; 
          
         $verify = $this->user_verify($data);
        
        if($verify != 0){

        return $verify;

         }
         $verify = $this->User_model->user_verify_token($data);
         $verify = array_shift($verify);


         $abuse_words =  $this->abuse_words($cap);

         if ($abuse_words == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
         }


         $data->{'total_post'}=$verify->total_post+1;

         $data->{'post_pic'}="";

          $data->{'pic_height'}= ""; 

         $data->{'pic_width'}= ""; 
         $data->{'postimage'}= ""; 
        

        if(isset($_FILES['post_pic']['name']))                                            /*check image is not there*/

        {                                                                                     

          $ids = rand(1,100);

          $dir_path="postimageupload/".$_POST['user_id'];

          @mkdir($dir_path);

          $img_name_array= $_FILES['post_pic']['name'];

            //$img_ext=end($img_name_array);

          $time = time().'.jpg';

          $selfie=$ids.'_'.$time;

          $upload_path=$dir_path.'/'.$selfie;

          
          

            file_put_contents($upload_path, file_get_contents($_FILES['post_pic']['tmp_name']));        /*Save the file on the server */

          $data->{'pic_height'}= $_POST['pic_height']; 

         $data->{'pic_width'}= $_POST['pic_width']; 

          $data->{'postimage'} = $upload_path;

        }
        else
        {
           $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );

          return ($message); 
        }


       


      header('Content-Type: application/json');



          $result = $this->Post_model->add_post($data);            /*Call Model function to add a new post */

            
        if($result==0){ 
               $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }else{ 
         

           $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  
                  'message' => 'Your new footshot is posted successfully.',

                  'result'=>  $this->Post_model->timeline_detail_for($result,$_POST['user_id'])
                   

                  ); 

          return ($message); 

        }

      }   public function create_new_post($data)
      {


       
        $data->{'user_id'}= $_POST['user_id'];
        $data->{'login_token'}= $_POST['login_token'];
        $data->{'post_caption'}= $_POST['post_caption']; 
        $cap = $_POST['post_caption'];

       /*  $data->{'tag_peoples'}= $_POST['tag_peoples']; 

         $data->{'tag_products'}= $_POST['tag_products']; */


             $cap = $_POST['post_caption'];

         if (isset($_POST['tag_products'])) {
               $tag_prdct = $_POST['tag_products'];
          foreach ($tag_prdct as $product_tag) {

            $productAbuse =  $this->abuse_words($product_tag['product_name']);

            if ($productAbuse == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
            }
      }

 }




         if(isset($_POST['tag_peoples']))
         {
          $data->{'tag_peoples'}= $_POST['tag_peoples'];
         }
         else
         {

            $data->{'tag_peoples'}= array(); 
        }

           if(isset($_POST['tag_products']))
         {
            $data->{'tag_products'}= $_POST['tag_products'];
         }
         else
         {

            $data->{'tag_products'}=array();
          }


        

         $data->{'location_address'}= $_POST['location_address']; 

         $data->{'location_latitude'}= $_POST['location_latitude']; 

         $data->{'location_longitude'}= $_POST['location_longitude'];


          $data->{'country'}= $_POST['country']; 

         $data->{'state'}= $_POST['state']; 

         $data->{'city'}= $_POST['city']; 

         $data->{'fulladdress'}= $_POST['fulladdress']; 
         
         $data->{'postal_code'}= $_POST['postal_code']; 
         $data->{'is_private'}= $_POST['is_private']; 
          
         $verify = $this->user_verify($data);
        
        if($verify != 0){

        return $verify;

         }
         $verify = $this->User_model->user_verify_token($data);
         $verify = array_shift($verify);


         $abuse_words =  $this->abuse_words($cap);

         if ($abuse_words == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
         }


         $data->{'total_post'}=$verify->total_post+1;

         $data->{'post_pic'}="";

          $data->{'pic_height'}= ""; 

         $data->{'pic_width'}= ""; 
         $data->{'postimage'}= ""; 
        

        if(isset($_FILES['post_pic']['name']))                                            /*check image is not there*/

        {                                                                                     

          $ids = rand(1,100);

          $dir_path="postimageupload/".$_POST['user_id'];

          @mkdir($dir_path);

          $img_name_array= $_FILES['post_pic']['name'];

            //$img_ext=end($img_name_array);

          $time = time().'.jpg';

          $selfie=$ids.'_'.$time;

          $upload_path=$dir_path.'/'.$selfie;

          
          

            file_put_contents($upload_path, file_get_contents($_FILES['post_pic']['tmp_name']));        /*Save the file on the server */

          $data->{'pic_height'}= $_POST['pic_height']; 

         $data->{'pic_width'}= $_POST['pic_width']; 

          $data->{'postimage'} = $upload_path;

        }
        else
        {
           $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );

          return ($message); 
        }


       


      header('Content-Type: application/json');



          $result = $this->Post_model->add_new_post($data);            /*Call Model function to add a new post */

            
        if($result==0){ 
               $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }else{ 
         

           $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  
                  'message' => 'Your new footshot is posted successfully.',

                  'result'=>  $this->Post_model->timeline_detail_for($result,$_POST['user_id'])
                   

                  ); 

          return ($message); 

        }

      } 


      /*method to create post of a user*/



      public function edit_new_post($data)
      {


       
        $data->{'user_id'}= $_POST['user_id'];
        $data->{'login_token'}= $_POST['login_token'];
       

        $data->{'post_caption'}= $_POST['post_caption']; 

        $data->{'post_id'}= $_POST['post_id']; 

       /*  $data->{'tag_peoples'}= $_POST['tag_peoples']; 

         $data->{'tag_products'}= $_POST['tag_products']; */


         $abuse_words =  $this->abuse_words($_POST['post_caption']);

         if ($abuse_words == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
         } 






         if(isset($_POST['tag_peoples']))
         {
          $data->{'tag_peoples'}= $_POST['tag_peoples'];
         }
         else
         {

            $data->{'tag_peoples'}= array(); 
        }

           if(isset($_POST['tag_products']))
         {
            $data->{'tag_products'}= $_POST['tag_products'];
         }
         else
         {

            $data->{'tag_products'}=array();
          }


        

         $data->{'location_address'}= $_POST['location_address']; 

         $data->{'location_latitude'}= $_POST['location_latitude']; 

         $data->{'location_longitude'}= $_POST['location_longitude'];


          $data->{'country'}= $_POST['country']; 

         $data->{'state'}= $_POST['state']; 

         $data->{'city'}= $_POST['city']; 

         $data->{'fulladdress'}= $_POST['fulladdress']; 
         
         $data->{'postal_code'}= $_POST['postal_code']; 
         $data->{'is_private'}= $_POST['is_private']; 
          
         $verify = $this->user_verify($data);
        
        if($verify != 0){

        return $verify;

         }
         $verify = $this->User_model->user_verify_token($data);
         $verify = array_shift($verify);
         $data->{'total_post'}=$verify->total_post+1;

        
         

       


      header('Content-Type: application/json');



          $result = $this->Post_model->edit_new_post($data);            /*Call Model function to add a new post */

            
        if($result==0){ 
               $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }else{ 
         

           $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  
                  'message' => 'Your new footshot is updated successfully.',

                  'result'=>  $this->Post_model->timeline_detail_for($result,$_POST['user_id'])
                   

                  ); 

          return ($message); 

        }

      } 
      public function edit_post($data)
      {


       
        $data->{'user_id'}= $_POST['user_id'];
        $data->{'login_token'}= $_POST['login_token'];
       

        $data->{'post_caption'}= $_POST['post_caption']; 

        $data->{'post_id'}= $_POST['post_id']; 

       /*  $data->{'tag_peoples'}= $_POST['tag_peoples']; 

         $data->{'tag_products'}= $_POST['tag_products']; */


         $abuse_words =  $this->abuse_words($_POST['post_caption']);

         if ($abuse_words == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
         } 






         if(isset($_POST['tag_peoples']))
         {
          $data->{'tag_peoples'}= $_POST['tag_peoples'];
         }
         else
         {

            $data->{'tag_peoples'}= array(); 
        }

           if(isset($_POST['tag_products']))
         {
            $data->{'tag_products'}= $_POST['tag_products'];
         }
         else
         {

            $data->{'tag_products'}=array();
          }


        

         $data->{'location_address'}= $_POST['location_address']; 

         $data->{'location_latitude'}= $_POST['location_latitude']; 

         $data->{'location_longitude'}= $_POST['location_longitude'];


          $data->{'country'}= $_POST['country']; 

         $data->{'state'}= $_POST['state']; 

         $data->{'city'}= $_POST['city']; 

         $data->{'fulladdress'}= $_POST['fulladdress']; 
         
         $data->{'postal_code'}= $_POST['postal_code']; 
         $data->{'is_private'}= $_POST['is_private']; 
          
         $verify = $this->user_verify($data);
        
        if($verify != 0){

        return $verify;

         }
         $verify = $this->User_model->user_verify_token($data);
         $verify = array_shift($verify);
         $data->{'total_post'}=$verify->total_post+1;

        
         

       


      header('Content-Type: application/json');



          $result = $this->Post_model->edit_post($data);            /*Call Model function to add a new post */

            
        if($result==0){ 
               $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );

          return ($message); 

        }else{ 
         

           $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  
                  'message' => 'Your new footshot is updated successfully.',

                  'result'=>  $this->Post_model->timeline_detail_for($result,$_POST['user_id'])
                   

                  ); 

          return ($message); 

        }

      } 


          public function block_user($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'other_user_id'}= $_POST['other_user_id'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  

         if($_POST['user_id']==$_POST['other_user_id'])
         {
            $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
            return ($message); 
         }

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->block_User($data);            /*Call Model function to get blocked user list */

          
        if($result==0)
        {

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User Blocked successfully.',

                'result' => $result

                 

                );
        }
         if($result==1)
        {

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User Unblocked successfully.',

                'result' => $result

                 

                );
        }

          return ($message); 

         
      }
         public function unblock_user($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];

                $data->{'other_user_id'}= $_POST['other_user_id'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->unblock_User($data);            /*Call Model function to get blocked user list */

        if($result==0){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'This user has been unblocked successfully.',

                'result' => $result 

                 


                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'This user has been blocked successfully' 

                );
          return ($message); 

        }

}

        public function blocked_User_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->blocked_User_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Blocked user list loaded successfully.',

                'result' => $result ,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no users marked block by you.' 

                );
          return ($message); 

        }

      }

        public function post_detail($data)
      {
         $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
         
       
         $verify = $this->user_verify($data);

          if($verify != 0){

          return $verify;

           } 

            $user_id = $_POST['user_id'];
            $post_id = $_POST['post_id'];
            $comment_id = $_POST['comment_id'];


            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser); 

          $result = $this->Post_model->timeline_detail_for($post_id,$user_id,$comment_id);            /*Call Model function to get blocked user list */


        if($result){
 
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot detail loaded successfully.',

                'result' => $result

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no more footshots.' 

                );
          return ($message); 

        }
      }
      public function ne_post_detail($data)
      {
         $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
         
       
         $verify = $this->user_verify($data);

          if($verify != 0){

          return $verify;

           } 

            $user_id = $_POST['user_id'];
            $post_id = $_POST['post_id'];
            $comment_id = $_POST['comment_id'];


            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser); 

          $result = $this->Post_model->new_timeline_detail_for($post_id,$user_id,$comment_id);            /*Call Model function to get blocked user list */


        if($result){
 
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot detail loaded successfully.',

                'result' => $result

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no more footshots.' 

                );
          return ($message); 

        }
      }
      
      public function new_post_list($data)
      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'views_ads'}= $_POST['views_ads'];
       
         $verify = $this->user_verify($data);

          if($verify != 0){

          return $verify;

           }  


              $verifyUser = $this->User_model->user_verify_token($data);
            $verifyUser = array_shift($verifyUser);
           
   

            $result = $this->Post_model->random_new_post_list($data);            /*Call Model function to get blocked user list */

          if($result){

            $newarray = array();
            $addsID = array();
            $count =0;
            foreach ($result as   $value) {
               
                if(sizeof($newarray) % 5 == 0)
              {  
                if(sizeof($newarray)>0)
                {
                  $resultResult  = $this->Post_model->random_new_advs_list($data,$addsID); 
                  if($resultResult)
                  {$addsID[] = $resultResult->post_id;
                    $resultResult->url_detail   = $this->Post_model->advs_url_Detail($resultResult->post_id); 
                    $newarray[] = $resultResult;
                    $count++;  
                  }
                  $newarray[] = $value;
                }
                if(empty($newarray))
                {
                 $newarray[] = $value; 
                 $resultResult  = $this->Post_model->random_new_advs_list($data,$addsID); 
                  if($resultResult)
                  {$addsID[] = $resultResult->post_id;
                    $resultResult->url_detail   = $this->Post_model->advs_url_Detail($resultResult->post_id); 
                    $newarray[] = $resultResult;
                    $count++;  
                  }
                }
                 
                 
               }
               else
               {
                 $newarray[] = $value;
                
               }
            }

             $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='".$_POST['user_id']."' and read_status='0' and notification_status='active'");
                   $total_unread_notification =  $notificunser->num_rows();

             $resultTotal = $this->Post_model->total_post($data); 
             $caught_up_count = $this->Post_model->caught_up_count($data); 

               $earnedresult = $this->User_model->total_earned_points($_POST['user_id']);            /*Call Model function to get blocked user list */
            $redeemresult = $this->User_model->total_redeem_points($_POST['user_id']);            /*Call Model function to get blocked user list */
            $al = 20+$count;

             $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='".$_POST['user_id']."' and read_status='0' and message_status='active'");

            $total_unread_message =  $messageuser->num_rows();

            $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='".$_POST['user_id']."' and chat_id in (select chat_id from foot_chat_member where user_id='".$_POST['user_id']."' ) and chat_id in (select chat_id from foot_chats where chat_status='active' and  chat_type='group') and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
             

              $total_group_unread_message =  $messageuser->num_rows();
 
              
            
             $message = array(

                  'err_code' => 0,                                                 /*Return if successful */
                  'message' => 'Footshot list loaded successfully.', 
                  'result' => $newarray,
                  'total_posts' => $resultTotal,
                  'total_point' => $earnedresult-$redeemresult,
                 // 'total_point' =>505,
                  'total_unread_notification' =>$total_unread_notification,
                  'total_unread_message' =>$total_unread_message+$total_group_unread_message,
                  'caught_up_count' =>$caught_up_count['post_count'],
                  'last_post_id' =>$caught_up_count['post_id'],
                  "has_more"=>(count($newarray)==$al) 

                  );

            return ($message); 

          }else{                                                                /*Return if failure */

            $message = array(

                  'err_code' => 300,

                  'message' => 'There are no more footshots.' 

                  );
            return ($message); 

          }
      }

       public function post_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->random_post_list($data);            /*Call Model function to get blocked user list */

        if($result){


           $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='".$_POST['user_id']."' and read_status='0' and notification_status='active'");
                 $total_unread_notification =  $notificunser->num_rows();

           $resultTotal = $this->Post_model->total_post($data); 
           $caught_up_count = $this->Post_model->caught_up_count($data); 

             $earnedresult = $this->User_model->total_earned_points($_POST['user_id']);            /*Call Model function to get blocked user list */
          $redeemresult = $this->User_model->total_redeem_points($_POST['user_id']);            /*Call Model function to get blocked user list */

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot list loaded successfully.',

                'result' => $result,
                'total_posts' => $resultTotal,
                'total_point' => $earnedresult-$redeemresult,
               // 'total_point' =>505,
                'total_unread_notification' =>$total_unread_notification,
                'caught_up_count' =>$caught_up_count['post_count'],
                'last_post_id' =>$caught_up_count['post_id'],
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no more footshots.' 

                );
          return ($message); 

        }

      }


      public function saved_post_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->saved_post_list($data);            /*Call Model function to get blocked user list */

        if($result){

  
           

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot list loaded successfully.',

                'result' => $result,  
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no more footshots.' 

                );
          return ($message); 

        }

      }

       public function search_post_list($data) 
          {
          $data->{'user_id'}     = $_POST['user_id'];
          $data->{'login_token'} = $_POST['login_token'];
          $data->{'post_value'}  = $_POST['post_value'];
          $data->{'search_text'} = $_POST['search_text'];
          $verify = $this->user_verify($data);
       if($verify != 0){
        return $verify;
         }  
          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          $result = $this->Post_model->search_post_list($data);            /*Call Model function to get blocked user list */
       if($result){
          $resultTotal = $this->Post_model->total_post($data); 
          $message = array(
                'err_code' => 0,                                                 /*Return if successful */
                'message' => 'Footshot list loaded successfully.',
                'result' => $result ,
                'total_posts' => $resultTotal,
                "has_more"=>(count($result)==20)
                );
          return ($message); 
        }else{                                                                /*Return if failure */
          $message = array(
                'err_code' => 300,
                'message' => 'There are no more footshots.' 
                );
          return ($message); 
        }
      }

      public function search_product_post_list($data)
        {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'search_text'}= $_POST['search_text'];
          $verify = $this->user_verify($data);

        if($verify != 0){
        return $verify;
         }  
            $verifyUser = $this->User_model->user_verify_token($data);
            $verifyUser = array_shift($verifyUser);
            $result = $this->Post_model->search_product_post_list($data);            /*Call Model function to get blocked user list */

        if($result){
           $resultTotal = $this->Post_model->total_search_product_post_list($data); 
           $message = array(
                'err_code' => 0,                                                 /*Return if successful */
                'message' => 'Footshot list loaded successfully.',
                'result' => $result ,
                'total_posts' => $resultTotal,
                "has_more"=>(count($result)==20)
                );
          return ($message); 
        }else{                                                                /*Return if failure */
          $message = array(
                'err_code' => 300,
                'message' => 'There are no more footshots.' 
                );
          return ($message); 
        }
      }

public function users_post_list($data)
      {
          $data->{'user_id'}       = $_POST['user_id'];
          $data->{'login_token'}   = $_POST['login_token'];
          $data->{'post_value'}    = $_POST['post_value'];
          $data->{'other_user_id'} = $_POST['other_user_id'];
          $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->users_post_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot list loaded successfully.',

                'result' => $result ,
                "has_more"=>(count($result)==30)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

         
             $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot list loaded successfully.',

                'result' => array(),
                "has_more"=>(count($result)==20)

                 

                );

         /* $message = array(

                'err_code' => 300,

                'message' => 'There are no more footshots.' 

                );*/
          return ($message); 

        }

      }

       public function users_tag_post_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
              $data->{'other_user_id'}= $_POST['other_user_id'];
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->users_tag_post_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot list loaded successfully.',

                'result' => $result ,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */
            
             $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot list loaded successfully.',

                'result' => array() ,
                "has_more"=>(count($result)==20)

                 

                );


          /*$message = array(

                'err_code' => 300,

                'message' => 'There are no more footshots.' 

                );*/

          return ($message); 

        }

      }


       public function search_tag_post_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'search_text'}= $_POST['search_text'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->search_tag_post_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $resultTotal = $this->Post_model->total_search_tag_post_list($data); 

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot list loaded successfully.',

                'result' => $result ,
                'total_posts' => $resultTotal,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no more footshots.' 

                );
          return ($message); 

        }

      }

       
        

       public function search_username_list($data)
      {
          $data->{'user_id'}     = $_POST['user_id'];
          $data->{'login_token'} = $_POST['login_token']; 
          $data->{'search_text'} = $_POST['search_text'];
          $verify                = $this->user_verify($data);

       if($verify != 0){
             return $verify;
         }  
            $verifyUser = $this->User_model->user_verify_token($data);
            $verifyUser = array_shift($verifyUser);
            $result = $this->User_model->search_username_list($data);            /*Call Model function to get blocked user list */
        if($result){
            $message = array(
                'err_code' => 0,                                                 /*Return if successful */
                'message'  => 'Users list loaded successfully.',
                'result'   => $result ,
                "has_more" => (count($result)==20)
                );
          return ($message); 
        }else{                                                                /*Return if failure */
          $result = array();
          $message = array(
                 'err_code' => 0,                                                 /*Return if successful */
                'message'  => 'Users list loaded successfully.',
                'result'   => $result ,
                "has_more" => (count($result)==20)
                );
          return ($message); 
        }
      }

       public function search_user_list($data)
      {
          $data->{'user_id'}     = $_POST['user_id'];
          $data->{'login_token'} = $_POST['login_token'];
          $data->{'post_value'}  = $_POST['post_value'];
          $data->{'search_text'} = $_POST['search_text'];
          $verify                = $this->user_verify($data);

       if($verify != 0){
             return $verify;
         }  
            $verifyUser = $this->User_model->user_verify_token($data);
            $verifyUser = array_shift($verifyUser);
            $result = $this->User_model->search_user_list($data);            /*Call Model function to get blocked user list */
        if($result){
            $message = array(
                'err_code' => 0,                                                 /*Return if successful */
                'message'  => 'Users list loaded successfully.',
                'result'   => $result ,
                "has_more" => (count($result)==20)
                );
          return ($message); 
        }else{                                                                /*Return if failure */
          $result = array();
          $message = array(
                 'err_code' => 0,                                                 /*Return if successful */
                'message'  => 'Users list loaded successfully.',
                'result'   => $result ,
                "has_more" => (count($result)==20)
                );
          return ($message); 
        }
      }
       public function add_comment($data)
      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'comment_text'}= $_POST['comment_text'];
          $data->{'comment_type'}= $_POST['comment_type'];

          $cap = $_POST['comment_text'];
      
         $verify = $this->user_verify($data);
      if($verify != 0){
        return $verify;
         }  
          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

          $abuse_words =  $this->abuse_words($cap);

         if ($abuse_words == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
         }
         
 

          $result = $this->Comment_model->add_comment($data);            /*Call Model function to get blocked user list */
 
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Comment added successfully.',
                'detail' => $result 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }
       public function add_new_comment($data)
      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'comment_text'}= $_POST['comment_text'];
          $data->{'comment_type'}= $_POST['comment_type'];

          $cap = $_POST['comment_text'];
      
         $verify = $this->user_verify($data);
      if($verify != 0){
        return $verify;
         }  
          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

          $abuse_words =  $this->abuse_words($cap);

         if ($abuse_words == true) {

              $message = array(
                    'err_code' => 300,
                    'message' => 'You are using some in-appropriate or abusive word. Please check and remove it.'
                    );

              return ($message); 
                 
         }
         
 

          $result = $this->Comment_model->add_new_comment($data);            /*Call Model function to get blocked user list */
 
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Comment added successfully.',
                'detail' => $result 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }


       public function delete_comment($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'comment_id'}= $_POST['comment_id'];
          $data->{'login_token'}= $_POST['login_token'];
           
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Comment_model->delete_comment($data);            /*Call Model function to get blocked user list */
  
   
        if($result=="0"){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Comment deleted successfully.',
                'detail' => $result 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }


       public function hide_post($data)

      {
          $data->{'user_id'}= $_POST['user_id']; 
          $data->{'login_token'}= $_POST['login_token'];
           
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->hide_post($data);            /*Call Model function to get blocked user list */
  
    
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Post Hidden successfully.',
                'detail' => $result 

                 

                );

          return ($message); 

         

      }
      public function report_post($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
           
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->report_post($data);            /*Call Model function to get blocked user list */
   

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Report posted successfully.'  

                 

                );

          return ($message); 

         

      }



       public function edit_comment($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'comment_id'}= $_POST['comment_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'comment_text'}= $_POST['comment_text'];
          
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Comment_model->edit_comment($data);            /*Call Model function to get blocked user list */
 
        if($result=="0"){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Comment edited successfully.',
                'detail' => $result 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }

      public function new_comment_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'reply_id'}= $_POST['reply_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'comment_type'}= $_POST['comment_type'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Comment_model->new_comment_list($data);            /*Call Model function to get blocked user list */
          $resultsmy = $this->Post_model->my_post($data);            /*Call Model function to get blocked user list */
   $commetnDetail = $this->Comment_model->single_comment($_POST['post_id'],$_POST['user_id']); 
        
       // if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Comment List successfully.',

                'comment_detail' => $commetnDetail,
                'result' => $result ,
                'is_my_post' => $resultsmy ,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

    /*    }else{       

          $message = array(

                'err_code' => 300,

                'message' => 'All the comments are loaded.' 

                );
          return ($message); 

        }*/

      }

      public function comment_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'comment_type'}= $_POST['comment_type'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Comment_model->comment_list($data);            /*Call Model function to get blocked user list */
          $resultsmy = $this->Post_model->my_post($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Comment List successfully.',

                'result' => $result ,
                'is_my_post' => $resultsmy ,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'All the comments are loaded.' 

                );
          return ($message); 

        }

      }

      public function notification_read($data)

      {
          $data->{'user_id'}= $_POST['user_id'];   
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'notification_id'}= $_POST['notification_id'];

       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  


          $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Comment_model->notification_read($data);            /*Call Model function to get blocked user list */
           

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Notifications read successfully.'
                 

                );

          return ($message); 

        

      }
       public function delete_notification($data)
      {

          $data->{'user_id'}     = $_POST['user_id'];   
          $data->{'login_token'} = $_POST['login_token'];
          $data->{'notification_id'}  = $_POST['notification_id'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          

          $result = $this->Comment_model->delete_notification($data);            /*Call Model function to get blocked user list */        
  
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Notification deleted successfully.' 

                 

                );

          return ($message); 

       

      

      }
      public function notification_list($data)

      {
          $data->{'user_id'}     = $_POST['user_id'];   
          $data->{'login_token'} = $_POST['login_token'];
          $data->{'post_value'}  = $_POST['post_value'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Comment_model->notification_list($data);            /*Call Model function to get blocked user list */
          $unreadresult = $this->Comment_model->unread_notification_count($data);            /*Call Model function to get blocked user list */
          $resultCount = $this->User_model->follow_request_count($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Notifications List successfully.',

                'result' => $result ,
                'request' => $resultCount ,
                'unreadcount' => $unreadresult ,
                "has_more"=>(count($result)==25)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No More Notifications' 

                );
          return ($message); 

        }

      }


       public function mark_as_read_notification($data)

      {
          $data->{'user_id'}= $_POST['user_id'];   
          $data->{'login_token'}= $_POST['login_token'];
           

       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Comment_model->mark_as_read_notification($data);            /*Call Model function to get blocked user list */
          
        
        $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'All Notifications set as read successfully.'

                 

                );

          return ($message); 

      }

      public function like_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'like_type'}= $_POST['like_type'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Like_model->like_list($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Liked users list loaded successfully.',

                'result' => $result ,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no like on this post.' 

                );
          return ($message); 

        }

      }


       public function add_share($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
        
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->add_share($data);            /*Call Model function to get blocked user list */
 
        

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Post Shared successfully.' 

                );

          return ($message); 

        

      }


      public function add_save($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
      
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->add_save($data);            /*Call Model function to get blocked user list */
 
          
          if($result==1)
            {
                $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'Post saved successfully.', 

                  'result' => $result 

                );
            }

            else if($result==0)
            {
              $message = array(

                  'err_code' => 0,                                                 /*Return if successful */

                  'message' => 'Post removed from save list.', 

                  'result' => $result 

                );
            }

          return ($message); 

        

      }

       public function add_like($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'like_type'}= $_POST['like_type'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Like_model->add_like($data);            /*Call Model function to get blocked user list */
 
        

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Post liked successfully.', 

                 'result' => $result 

                );

          return ($message); 

        

      }
      public function remove_like($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'like_type'}= $_POST['like_type'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Like_model->remove_like($data);            /*Call Model function to get blocked user list */
 
        if($result==0){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Like removed successfully.' 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }


      public function add_report($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'post_id'}= $_POST['post_id']; 
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->Post_model->report_abouse($data);            /*Call Model function to get blocked user list */
 
        if($result==0){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Post reported successfully.' 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }

      public function add_report_user($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'other_user_id'}= $_POST['other_user_id']; 
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->add_report_user($data);            /*Call Model function to get blocked user list */
 
        if($result==0){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Report Added successfully.' 

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }


       public function folllow_unfollow($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
     
          $data->{'other_user_id'}= $_POST['other_user_id']; 
         
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->follow_unfollow_user($data);            /*Call Model function to get blocked user list */
 
        if($result==0){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User followed successfully.' 

                 

                );

          return ($message); 

        }

        if($result==1){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User Unfollowed successfully.' 

                 

                );

          return ($message); 

        }
        else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }


       public function follow_request_action($data)

      {
          $data->{'user_id'}= $_POST['user_id'];

          $data->{'login_token'}= $_POST['login_token'];
     
          $data->{'follow_id'}= $_POST['follow_id']; 
         
          $data->{'follow_status'}= $_POST['follow_status']; 
          

       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->follow_request_action($data);            /*Call Model function to get blocked user list */
 
        if($result==0){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User request accepted successfully.'  
                 

                );

          return ($message); 

        }
        else if($result==1){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User request rejected successfully.'  
                 

                );

          return ($message); 

        }
        else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.'

                );
          return ($message); 

        }

      }

      
         public function follow_request_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
        
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->follow_request_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,    
                'message' => 'User Request List loaded successfully.', 
                'result' => $result,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No more follow request'  

                );
          return ($message); 

        }

      }

      public function follow_sent_request_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
        
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   

            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->follow_sent_request_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,    
                'message' => 'Follow Request List loaded successfully.', 
                'result' => $result,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No more follow request'  

                );
          return ($message); 

        }

      }

       public function following_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'other_user_id'}= $_POST['other_user_id'];
        
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->following_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User List successfully.',

                'result' => $result,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No More List' 

                );
          return ($message); 

        }

      }

       public function delete_post($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_id'}= $_POST['post_id'];
        
        
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);        
 

          $result = $this->Post_model->remove_post($data);            /*Call Model function to get blocked user list */

        if($result==0){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Footshot removed successfully.'
                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is some issue occurred. Please try again.' 

                );
          return ($message); 

        }

      }

       public function followers_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'other_user_id'}= $_POST['other_user_id'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
 

          $result = $this->User_model->followers_list($data);            /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'User List successfully.',

                'result' => $result,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No More List' 

                );
          return ($message); 

        }

      }




         public function search_product_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          $data->{'post_value'}= $_POST['post_value'];
          $data->{'search_text'}= $_POST['search_text'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
         if(empty($_POST['search_text']))
         {
           $result = $this->Post_model->search_blank_product_list($data);     
         }
         else
         {  
            $result = $this->Post_model->search_product_list($data);     
         }
 

               /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Products loaded successfully.',

                'result' => $result ,
                "has_more"=>(count($result)==20)

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No More Product' 

                );
          return ($message); 

        }

      }


       public function search_tag_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
          $data->{'login_token'}= $_POST['login_token'];
          
          $data->{'search_text'}= $_POST['search_text'];
       
         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
         if(empty($_POST['search_text']))
         {
           $result = $this->Post_model->search_blank_tag_list($data);     
         }
         else
         {  
            $result = $this->Post_model->search_tag_list($data);     
         }
 

               /*Call Model function to get blocked user list */

        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Tags loaded successfully.',

                'result' => $result  

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No More Tags' 

                );
          return ($message); 

        }

      }

        public function username_profile($data)
      {

          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];
         
         $data->{'other_username'}= $_POST['other_username'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   


            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
            $other_username = $_POST['other_username'];
            $user_id = $_POST['user_id'];

          $usernameresult = $this->User_model->single_username_detail($other_username);            /*Call Model function to get blocked user list */
          if(empty($usernameresult))
          {
             $message = array(

                'err_code' => 300,

                'message' => 'No detail' 

                );
          return ($message); 
          }
          $result = $this->User_model->user_personal_detail($usernameresult->user_id,$user_id);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'user Detail successfully.',

                'result' => $result  

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No detail' 

                );
          return ($message); 

        }

      
      }


      public function user_profile($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];
         
         $data->{'other_user_id'}= $_POST['other_user_id'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }   


            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
         
            $other_user_id = $_POST['other_user_id'];
            $user_id = $_POST['user_id'];

          $result = $this->User_model->user_personal_detail($other_user_id,$user_id);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'user Detail successfully.',

                'result' => $result  

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No detail' 

                );
          return ($message); 

        }

      }

      public function create_group_chat($data)
      {
         $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];         
     
         $data->{'chat_name'}= $_POST['chat_name'];
        
          $data->{'member_peoples'}= $_POST['member_peoples'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  

           $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->create_group_chat($data);            /*Call Model function to get blocked user list */      
         

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group Chat Created successfully.', 
                'result' => $result

                 

                );

          return ($message); 
  
      }

       public function create_broadcast($data)
      {
         $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];         
     
         $data->{'chat_name'}= "Broadcast";
        
          $data->{'member_peoples'}= $_POST['member_peoples'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  

           $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->create_broadcast($data);            /*Call Model function to get blocked user list */      
         

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Broadcast Created successfully.', 
                'result' => $result

                 

                );

          return ($message); 
  
      }

      public function edit_group_info($data)
      {
         $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];         
     
         $data->{'chat_id'}= $_POST['chat_id'];
        
          $data->{'chat_name'}= $_POST['chat_name'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  

           $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->edit_group_info($data);            /*Call Model function to get blocked user list */      
          
           if($result=="600")
        {
            $message = array(

                'err_code' => 600,                                                 /*Return if successful */

                'message' => 'You are no longer with this group.'                  

                );

          return ($message); 
        }

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group name edited successfully.' 

                 

                );

          return ($message); 

        


      }

      public function add_group_member($data)
      {
         $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];         
     
         $data->{'chat_id'}= $_POST['chat_id'];
        
          $data->{'member_peoples'}= $_POST['member_peoples'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  


           $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->add_group_member($data);            /*Call Model function to get blocked user list */      
         
           if($result=="600")
        {
            $message = array(

                'err_code' => 600,                                                 /*Return if successful */

                'message' => 'You are no longer with this group.'                  

                );

          return ($message); 
        }

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group members added successfully.' 

                 

                );

          return ($message); 

        


      }


      public function create_chat($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];
         
         $data->{'other_user_id'}= $_POST['other_user_id'];

         $data->{'user1'}= $_POST['user_id'];
         $data->{'user2'}= $_POST['other_user_id'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->create_chat($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Chat Created successfully.',

                'result' => $result  

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'No detail' 

                );
          return ($message); 

        }

      }

        public function delete_message($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];

           $data->{'message_id'}= $_POST['message_id'];

          $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



           $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->delete_message($data);            /*Call Model function to get blocked user list */
 
        
            if($result==0){

               $message = array(

                    'err_code' => 0,                                                 /*Return if successful */

                    'message' => 'Message deleted successfully.'

                     

                    );

              return ($message); 

            }else{                                                                /*Return if failure */

              $message = array(

                    'err_code' => 300,

                    'message' => 'Try Again' 

                    );
              return ($message); 

            }



      }


        public function delete_chat($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];

           $data->{'from_id'}= $_POST['from_id'];
           $data->{'to_id'}= $_POST['to_id'];

          $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



           $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->delete_chat($data);            /*Call Model function to get blocked user list */
 
        
            if($result==0){

               $message = array(

                    'err_code' => 0,                                                 /*Return if successful */

                    'message' => 'Chat deleted successfully.'

                     

                    );

              return ($message); 

            }else{                                                                /*Return if failure */

              $message = array(

                    'err_code' => 300,

                    'message' => 'Try Again' 

                    );
              return ($message); 

            }



      }

      public function send_message($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];
         
         $data->{'from_id'}= $_POST['from_id'];
         $data->{'to_id'}= $_POST['to_id'];
     $data->{'chat_id'}= $_POST['chat_id'];

         $data->{'message_type'}= $_POST['message_type']; //'text','image','timeline'
         $data->{'message_text'}= $_POST['message_text'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->send_message($data);            /*Call Model function to get blocked user list */
        
        if($result=="600")
        {
            $message = array(

                'err_code' => 600,                                                 /*Return if successful */

                'message' => 'You are no longer with this group.'                  

                );

          return ($message); 
        }
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Message sent successfully.',

                'result' => $result  

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'Try Again' 

                );
          return ($message); 

        }

      }
 public function send_broadcast_message($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];
         
         $data->{'from_id'}= $_POST['user_id'];
   
         $data->{'chat_id'}= $_POST['chat_id'];

         $data->{'message_type'}= $_POST['message_type']; //'text','image','timeline'
         $data->{'message_text'}= $_POST['message_text'];
         $data->{'timeline_id'}= $_POST['timeline_id'];

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);
          
          $result = $this->Message_model->send_broadcast_message($data);            /*Call Model function to get blocked user list */
        
        if($result=="600")
        {
            $message = array(

                'err_code' => 600,                                                 /*Return if successful */

                'message' => 'You are no longer with this group.'                  

                );

          return ($message); 
        }
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Message sent successfully.',

                'result' => $result  

                 

                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'Try Again' 

                );
          return ($message); 

        }

      }
       public function new_message_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];
         
         $data->{'other_user_id'}= $_POST['other_user_id'];

         $data->{'post_value'}= $_POST['post_value'];

         $chat_id= $_POST['chat_id'];
        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

            if(empty($_POST['chat_id']))
            {
              $chat_id =     $this->Message_model->create_chat($_POST['user_id'],$_POST['other_user_id']);
            }
             $data->{'chat_id'}= $chat_id;
            

          $result = $this->Message_model->new_message_list($data);            /*Call Model function to get blocked user list */

          $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='".$_POST['user_id']."' and read_status='0' and message_status='active'");

          $total_unread_message =  $messageuser->num_rows();


              $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='".$_POST['user_id']."' and chat_id in (select chat_id from foot_chat_member where user_id='".$_POST['user_id']."' ) and chat_id in (select chat_id from foot_chats where chat_status='active' and  chat_type='group') and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
             

              $total_group_unread_message =  $messageuser->num_rows();
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Message List successfully.',

                'result' => $result,

                'total_unread_message' => $total_unread_message+$total_group_unread_message,

                'chat_id' => $chat_id,

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is no Message',

                'chat_id' => $chat_id, 

                );
          return ($message); 

        }

      }
       public function message_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token'];
         
         $data->{'other_user_id'}= $_POST['other_user_id'];

         $data->{'post_value'}= $_POST['post_value'];

         $chat_id= $_POST['chat_id'];
        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

            if(empty($_POST['chat_id']))
            {
              $chat_id =     $this->Message_model->create_chat($_POST['user_id'],$_POST['other_user_id']);
            }
             $data->{'chat_id'}= $chat_id;
            

          $result = $this->Message_model->message_list($data);            /*Call Model function to get blocked user list */


           $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='".$_POST['user_id']."' and read_status='0' and message_status='active'");

            $total_unread_message =  $messageuser->num_rows();

              $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='".$_POST['user_id']."' and chat_id in (select chat_id from foot_chat_member where user_id='".$_POST['user_id']."' ) and chat_id in (select chat_id from foot_chats where chat_status='active' and  chat_type='group') and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
             

              $total_group_unread_message =  $messageuser->num_rows();
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Message List successfully.',

                'result' => $result,

                'total_unread_message' => $total_unread_message+$total_group_unread_message,

                'chat_id' => $chat_id,

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There is no Message',
                
                'total_unread_message' => $total_unread_message+$total_group_unread_message,

                'chat_id' => $chat_id, 

                );
          return ($message); 

        }

      }

      public function chat_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

         $data->{'post_value'}= $_POST['post_value'];

        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->chat_list($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Chats list loaded successfully.',

                'result' => $result, 

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no previous chat. Press + in order to create new one.' 

                );
          return ($message); 

        }

      }
      public function search_chat_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

         $data->{'post_value'}= $_POST['post_value'];

         $data->{'search_text'}= $_POST['search_text'];

        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->search_chat_list($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Chats list loaded successfully.',

                'result' => $result, 

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no search related with text.' 

                );
          return ($message); 

        }

      }

       public function group_chat_list($data)
      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

         $data->{'post_value'}= $_POST['post_value'];

        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->group_chat_list($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group list loaded successfully.',

                'result' => $result, 

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no previous chat. Press + in order to create new one.' 

                );
          return ($message); 

        }

      }

       public function broadcast_list($data)
      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

         $data->{'post_value'}= $_POST['post_value'];

        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->broadcast_list($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Broadcast loaded successfully.',

                'result' => $result, 

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no previous broadcast. Press + in order to create new one.' 

                );
          return ($message); 

        }

      }
      public function search_group_chat_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

         $data->{'post_value'}= $_POST['post_value'];

         $data->{'search_text'}= $_POST['search_text'];

        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->search_group_chat_list($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group list loaded successfully.',

                'result' => $result, 

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no group related with this text.' 

                );
          return ($message); 

        }

      }

      public function search_broadcast_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

         $data->{'post_value'}= $_POST['post_value'];

         $data->{'search_text'}= $_POST['search_text'];

        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->search_broadcast_list($data);            /*Call Model function to get blocked user list */
 
        
        if($result){

           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group list loaded successfully.',

                'result' => $result, 

                "has_more"=>(count($result)==15)  

                  
                );

          return ($message); 

        }else{                                                                /*Return if failure */

          $message = array(

                'err_code' => 300,

                'message' => 'There are no group related with this text.' 

                );
          return ($message); 

        }

      }
      public function group_chat_info($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 
 

        

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->group_chat_info($data);            /*Call Model function to get blocked user list */
            
             if($result=="600")
        {
            $message = array(

                'err_code' => 600,                                                 /*Return if successful */

                'message' => 'You are no longer with this group.'                  

                );

          return ($message); 
        }
         
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group Info loaded successfully.',

                'result' => $result 

                  
                );

          return ($message); 

        
      }


      public function remove_group_member($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

          $data->{'member_id'}= $_POST['member_id']; 
 
 

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->remove_group_member($data);            /*Call Model function to get blocked user list */
 
         
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group member removed successfully.'  

                  
                );

          return ($message); 

        
      }

 public function leave_group($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

          $data->{'chat_id'}= $_POST['chat_id']; 
 
 

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->leave_group($data);            /*Call Model function to get blocked user list */
 
         
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group left successfully.'  

                  
                );

          return ($message); 

        
      }

      public function delete_group($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

          $data->{'chat_id'}= $_POST['chat_id']; 
 
 

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->delete_group($data);            /*Call Model function to get blocked user list */
 
         
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Group deleted successfully.'  

                  
                );

          return ($message); 

        
      }

      public function delete_broadcast($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

          $data->{'chat_id'}= $_POST['chat_id']; 
 
 

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->Message_model->delete_broadcast($data);            /*Call Model function to get blocked user list */
 
         
           $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'Broadcast deleted successfully.'  

                  
                );

          return ($message); 

        
      }

      public function total_point_list($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

         

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

             

          $result = $this->User_model->redeem_point_list($data);            /*Call Model function to get blocked user list */
          $earnedresult = $this->User_model->total_earned_points($_POST['user_id']);            /*Call Model function to get blocked user list */
          $redeemresult = $this->User_model->total_redeem_points($_POST['user_id']);            /*Call Model function to get blocked user list */
          $minimum_point_ro_redeem = 50;            /*Call Model function to get blocked user list */

          $this->db->select('*');

          $this->db->from('foot_admin');

          $where = "id='1'";

          $this->db->where($where);

          $query = $this->db->get();

          $resultdoante = $query->row();

       $minimum_point_ro_redeem =   intval($resultdoante->donationpoint);

//   $minimum_point_ro_redeem = 500; 
          $msg = 'Donation points list loaded successfully.';
        
        if(empty($earnedresult))
        {
          $earnedresult = "0";
          $msg = 'You have not donate any point.';

        }
        
        $available_points = $earnedresult-$redeemresult;

        if($available_points<0)
        {
          $available_points=0;
        }

         $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => $msg,
                
                 'donation_message' => "We are working on it. Soon you will be able to donate the points.", 

                'result' => $result, 

                'minimum_point_to_redeem' => $minimum_point_ro_redeem, 

                //'redeem_text' => "Earning ".$minimum_point_ro_redeem." points will let you donate 1 footwear to our footshots foundation. Points will be earned on the basis of the popularity (likes & comments) of your footshots.", 
                'redeem_text' => "For every ".$minimum_point_ro_redeem." points you earn, Footshots will donate one pair of footwear on your behalf. Points are earned based on the number of likes and comments your photo gains. So, get posting!", 
 

                "available_points"=>$available_points,

                "total_points"=>$earnedresult 
                  
                );

          return ($message);

         

      }

       public function send_email_redeem_points()
      {
        $result = $this->User_model->send_email_redeem_points();            /*Call Model function to get blocked user list */
               
  
 
         $message = array(

                'err_code' => 0,                                                 /*Return if successful */

               
                'donation_message' => "Thank you for donating points!Footshots team will soon donate a pair of footwear to someone in need on your behalf and you will be notified."
                // 'donation_message' => "Thank you for donating points! Footshots team will donate a footwear on your behalf to the one in need. We will shortly update you with progress of it." Message change as discusswith with bhubnesh on 27-01-2020
                  
 
                );

          return ($message);
      }

      public function redeem_points($data)

      {
          $data->{'user_id'}= $_POST['user_id'];
         
          $data->{'login_token'}= $_POST['login_token']; 

          $data->{'total_points'}= $_POST['total_points']; 

         

         $verify = $this->user_verify($data);

        if($verify != 0){

        return $verify;

         }  



            $verifyUser = $this->User_model->user_verify_token($data);
          $verifyUser = array_shift($verifyUser);

           
          $result = $this->User_model->redeem_points($data);            /*Call Model function to get blocked user list */
               
  
 
         $message = array(

                'err_code' => 0,                                                 /*Return if successful */

                'message' => 'You have donated '.$_POST['total_points'].' points to footshots successfully.',
                'donation_message' => "Thank you for donating points! Footshots team will soon donate a pair of footwear to someone in need on your behalf and you will be notified."
                // 'donation_message' => "Thank you for donating points! Footshots team will donate a footwear on your behalf to the one in need. We will shortly update you with progress of it." Message change as discusswith with bhubnesh on 27-01-2020
                  
 
                );

          return ($message);


      }
             public function abuse_words($content)
            { 
                $val = $content;
             
                $string = explode(" " ,$val);
                $string =  str_replace("'", "", $string);
                $string = implode("','" , $string); 
                $string =  str_replace('#', '', $string);
                  $res     = $this->db->query("SELECT * FROM foot_abuse_words where word in('$string') ");
                  $result  = $res->result();
                  if ($result)
                    {
                        return true;
                    }
                  else
                    {
                        return false;
                    }
            }
}