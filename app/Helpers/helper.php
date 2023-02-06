<?php


function savePublicFile($media,$folder){
        if($media){
        $change_file_name= rand().time() . '.' .$media->getClientOriginalExtension();
        $destinationPath= public_path('/'.$folder);
        $media->move($destinationPath, $change_file_name);
        return $attach_url = '/'.$folder.'/'.$change_file_name;
        }
    }


function updatePublicFile($media,$folder,$oldfile){
        if($media){
        $change_file_name= rand().time() . '.' .$media->getClientOriginalExtension();
        $destinationPath= public_path('/'.$folder);
        $media->move($destinationPath, $change_file_name);
        @unlink(substr($oldfile,1));
        return $attach_url = '/'.$folder.'/'.$change_file_name;
        }
    }


function getUser($login_token,$locale='en'){ 
        $check_login = \App\Models\User::where('login_token', $login_token);
        if ($check_login->count() > 0) {
          return $check_login->first();
           //App::setLocale($locale);
        } else {
            return false;
        }

    }

function generateRandomString($length = 32) {



    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $randomString = '';

    for ($i = 0; $i < $length; $i++) {

        $randomString .= $characters[rand(0, strlen($characters) - 1)];

    }

    return $randomString;

}


function removeFiles($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK );

        foreach( $files as $file ){
        removeFiles( $file );
        }

        @rmdir( $target );

    } 
    elseif(is_file($target)) {
    unlink( $target );
    }
}
function send_grid_email($to, $to_names, $subject, $text,$attachment = null,$filename = null) {
//           echo $to.$to_names.$subject; die;
    $curl = curl_init();
    $params = array();
  
    $params['from'] = "emobxdev@gmail.com";
    $params['subject'] = $subject;
    $params['html'] = stripcslashes($text);
    $params['to'] = $to;
    $params['toname'] = $to_names;
$to_array = $to_final= $to_final_1= $content_array =  array();
$from_array = ['email'=>'emobxdev@gmail.com'];
//$from_array = ['email'=>'noreply@skitskot.com'];
$to_array[] = ['email'=>$to,'name'=>$to_names];
$to_final['to'] = $to_array;
$to_final_1[] = $to_final;
$content_array[] = [
"type"=>"text/html", "value"=>stripcslashes($text) ];
$result = [
    'personalizations'=>$to_final_1,
'from'=>$from_array,
'subject'=>$subject,
'content'=>$content_array

];
// pa($result); die;
    if(!empty($attachment)){
        $imagedata = file_get_contents($attachment);
        $params['files['.$filename.']'] = $imagedata;

    }

    $query = json_encode($result);

curl_setopt_array($curl, array(CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send", CURLOPT_RETURNTRANSFER => true,CURLOPT_ENCODING => "",CURLOPT_MAXREDIRS => 10,CURLOPT_TIMEOUT => 0,CURLOPT_FOLLOWLOCATION => true,CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,CURLOPT_CUSTOMREQUEST => "POST",CURLOPT_POSTFIELDS => $query, CURLOPT_HTTPHEADER => array("Content-Type: application/json","Authorization: Bearer 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" ) ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
//pa($response);
// pa($err);
    curl_close($curl);
     

  }

function get_shortname($name){
$words = explode(" ", $name);
$acronym = "";

foreach ($words as $w) {
  $acronym .= $w[0];
}
return $acronym;
}



function send_notification_android($devToken,$message,$action,$value)
{
    $data_array=array("to"=>$devToken,"data"=>array("message"=>$message,"action"=>$action,"value"=>$value));
    $data_array=json_encode($data_array);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data_array,
      CURLOPT_HTTPHEADER => array(
        // "authorization: Key= AIzaSyBEzkXeYdlRULEMuVDFyQ1JeG5eZ95oyOA",
        "authorization: Key= AAAAlxByIEY:APA91bFX8Q-tlJk6U59AetWF87QIuwgkhXhKgfliJf1dD6NPLkM2rJV5R5hF-LTLlEQrZaCJMySsj9DogI5cTnRPGN7oiEASg2a2rdLGXPjgM_S-lc7EnZwyE6qJ1tX4UB3Ni6HwmU_Q",
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
   return $response;
    if ($err) 
    {
       return false;
        //echo "cURL Error #:" . $err;
        //echo "failed";
    } 
    else 
    {
        return true;
        //echo "success";
    }
}

 function send_notification_iOS($registatoin_ids,$title,$message,$badge,$action,$value,$sound='default')
 {
  $notification["body"] =$message;
 ///$notification["title"] = $title;
 // $notification["type"] = 1;
  $notification["badge"] = $badge;

 if($action!=NULL)
    {
      $notification['action']=$action;
    }

    if($value!=NULL)
    {
      $notification['value']=$value;
    }
    if($sound!=NULL)
    {
      $notification['sound']=$sound;
    }
 
 
$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array(
'to' => $registatoin_ids,
'notification' => $notification
);
// Firebase API Key
$headers = array('Authorization:key=AAAAlxByIEY:APA91bFX8Q-tlJk6U59AetWF87QIuwgkhXhKgfliJf1dD6NPLkM2rJV5R5hF-LTLlEQrZaCJMySsj9DogI5cTnRPGN7oiEASg2a2rdLGXPjgM_S-lc7EnZwyE6qJ1tX4UB3Ni6HwmU_Q','Content-Type:application/json');
// Open connection
$ch = curl_init();
// Set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Disabling SSL Certificate support temporarly
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
return $result = curl_exec($ch);
if ($result === FALSE) {
die('Curl failed: ' . curl_error($ch));
}
curl_close($ch);

   
 }


 

function notification_text($type){
  
    switch ($type) {
     
        default: {
                $text = " react on your account.";
                break;
            }
        case "user_follow": {
               $text ="started following you";
                break;
            }
        case "comment": {
                $text = "commented your post.";
                break;
            }
        case "comment_like": {
                $text = "liked your comment.";
                break;
            }
        case "new_message": {
                $text = " messaged you.";
                break;
            }
          case "post_like": {
                $text = "liked your post.";
                break;
            }
       
      
    }
    return $text;
}




function send_sms($mobile,$msg,$templet){  
        return true;    
}


function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                    : DateTimeZone::listIdentifiers();

    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];

                $theta    = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) 
                + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
                // echo '<br />'.$timezone_id.' '.$distance; 

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                } 

            }
        }
        return  $time_zone;
    }
    return '';
}


function get_communication_media($input){
    $return=array();
   $user=\App\Models\User::whereEmail($input)->orWherePhone($input);
   if($user->count() > 0){
    $user=$user->first();
    if($user->email_verified_at){
     $return[]='email';
    }
    if($user->phone_verified_at){
     $return[]='phone';
    }
    $user->communication=$return;
   }
   return $user;

}





 

