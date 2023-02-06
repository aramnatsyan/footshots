<?php

namespace App\Extra;

use App\Models\User;
use App\Models\Notification;

trait NotiFunc
{
   
    



     public function saveAndSendNotification($notidata,$notification_type)
            { 
                      $add = new Notification();
                      $add->target_type = $notification_type;
                      $add->from_user_id = $notidata->from_user_id;
                      $add->to_user_id = $notidata->to_user_id;
                      $add->target_id = $notidata->target_id;
                      $add->save();
                
                      $comment = User::find($notidata->to_user_id);
                    
                      $action =$notification_type;
                      if(!empty($notidata->value)){
                        $value =$notidata->value;
                      }
                      else{
                         $value = $notidata->target_id;
                      }
                     
                       $msg = $notidata->from_user_id_name." ".notification_text($notification_type);
                      $title = "New Message";
                      $badge = "1";
                      $device_token = $comment->device_token;

                    if( $comment->device_type == 'ios' ) // ios
                    {
                          send_notification_iOS($device_token,$title,$msg,$badge,$action,$value);
                    }

                    if( $comment->device_type == 'android' ) // android
                    {
                          send_notification_android($device_token,$msg,$action,$value);
                    }
      
       
             }




       





}
   