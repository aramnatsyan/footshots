<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Extra\NotiFunc;

use App\Models\ChatMessage;
use App\Models\Chat;
use App\Models\User;
use App\Models\Notification;
use Validator;
use DB;
use stdClass;

class ChatController extends Controller
{
   
    use NotiFunc; 

    public function add_chat(Request $request){
    

     $validator = Validator::make($request->all(), [
         
          'text_message' => 'required',
          'login_token' => 'required',
          'to_id' => 'required',
        
         ]);
          if ($validator->fails()) {

          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          } 
         $user=getUser($request->login_token);
            if($user){
      
       $objc=Chat::where(function($query) use ($user,$request){
              $query->where(function($qu) use ($user,$request){
                $qu->where('user1',$user->id)->where('user2',$request->to_id);
              })->orWhere(function($qu1) use ($user,$request){
                $qu1->where('user1',$request->to_id)->where('user2',$user->id);
              });
            });
          if($objc->count() > 0){
           $objc=$objc->first();
          }
          else{
            $objc= new Chat;
          }
            $objc->user1=$user->id;
            $objc->user2=$request->to_id;
            $objc->text_message=$request->text_message;
            $objc->save();


          $insert=array();
          $insert=$request->all();
          $insert['from_id']=$user->id;
          $insert['chat_id']=$objc->id;
          $obj=ChatMessage::Create($insert);

          return $lists=ChatMessage::with('getFrom','getFrom.getUserProfile','getTo','getTo.getUserProfile')->whereId($obj->id)->first();die;

           //---------------Start::send notification------------------------------
          $value = array();
          $value['chat_id'] = $lists->chat_id;
          $value['other_user_id'] = $user->id;
          $value['other_user_name'] =$user->firstname.' '.$user->lastname;
          $value['message_text'] =$request->text_message;
       
          $notidata=new stdClass();
          $notidata->from_user_id=$user->id;
          $notidata->from_user_id_name=$user->firstname.' '.$user->lastname;
          $notidata->to_user_id=$lists->getTo->id;
          $notidata->target_id=$lists->chat_id;
          $notidata->value=$value;
          if($notidata->from_user_id != $notidata->to_user_id){
           $this->saveAndSendNotification($notidata,'new_message');
          }
            //---------------End::send notification------------------------------


           return response()->json(["error_code" => "200", "message" => "Message successfully",'data'=>$lists]);
         
        }
        else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }

    }


       public function get_chat(Request $request){
    

     $validator = Validator::make($request->all(), [
         
          
         
          'login_token' => 'required',
         // 'to_id' => 'required',
         // 'form_id' => 'required',
        
          
          
         ]);
          if ($validator->fails()) {

          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          } 
         $user=getUser($request->login_token);
            if($user){
      
          $lists=ChatMessage::with('getFrom','getFrom.getUserProfile','getTo','getTo.getUserProfile');
          if($request->to_id){
            $lists->where(function($query) use ($user,$request){
              $query->where(function($qu) use ($user,$request){
                $qu->where('from_id',$user->id)->where('to_id',$request->to_id);
              })->orWhere(function($qu1) use ($user,$request){
                $qu1->where('to_id',$user->id)->where('from_id',$request->to_id);
              });
            });
          }

           $lists=$lists->orderBy('id','desc')->simplePaginate();
    
      
          $allrecords=$lists->items();
              if($allrecords){
                $msg_id=[];
                foreach($allrecords as $allrecords_val){
                  $msg_id[]=$allrecords_val->id;

                }
                ChatMessage::whereIn('id',$msg_id)->update(['read_at'=>date('Y-m-d H:i:s')]);
              }
           return response()->json(["error_code" => "200", "message" => "Chat list",'next_page' =>$lists->nextPageUrl() ,'data' =>$allrecords,'latest_time' => ($allrecords) ? $allrecords[0]->created_at :date('Y-m-d H:i:s') ]);
        }
        else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }

    }

    public function get_chat_users(Request $request){
    
     $validator = Validator::make($request->all(), [
         
          'login_token' => 'required',
       
                       
         ]);
          if ($validator->fails()) {
          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          } 
      $user=getUser($request->login_token);
      if($user){
    
          $follower=User::
          leftJoin('user_followers as uf','uf.following_id','users.id')
        ->leftJoin('user_profiles as up','up.user_id','users.id') 
        ->where('users.role','user')
        ->where('users.id','!=',$user->id)
        ->where('uf.deleted_at',NULL)
        ->where('up.deleted_at',NULL);

     // if($request->q){
     //   $follower=$follower->where(function($query) use ($request){
     //  $query->orWhere('users.name','LIKE','%'.$request->q.'%')
     //   ->orWhere('users.name','LIKE','%'.$request->q.'%')
     //   ->orWhere('users.username','LIKE','%'.$request->q.'%')
     //   ->orWhere('users.email','LIKE','%'.$request->q.'%');
     //   });
     // }
    
        // $follower=$follower->select('users.id','users.name','users.email','up.profile_file','up.file_type',DB::raw('count(uf.id) as follower_count'))->groupBy('users.id')->orderBy('uf.follower_id','desc')->simplePaginate();
       
          // $allrecords=$follower->items();
          $allrecords=$follower;
          return response()->json(["error_code" => "200", "message" => "list of followers",'data' =>$allrecords]);
        }
        else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }
    }


    public function get_recent_chat_old(Request $request){
    
     $validator = Validator::make($request->all(), [
         
          'login_token' => 'required',
       
                       
         ]);
          if ($validator->fails()) {
          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          } 
      $user=getUser($request->login_token);
      if($user){
    
          $follower=ChatMessage::where(function($qu) use ($user){
               return $qu->where('from_id',$user->id)->orWhere('to_id',$user->id);
              
              })->leftJoin('users as uf','uf.id','chat_messages.to_id')
          ->leftJoin('users as ut','ut.id','chat_messages.from_id')
          ->leftJoin('user_profiles as upf','upf.user_id','uf.id')
          ->leftJoin('user_profiles as upt','upt.user_id','ut.id');

          return $follower=$follower->select('text_message',
          DB::raw('(CASE WHEN from_id = '.$user->id.' THEN to_id ELSE from_id END) as userId'),
          DB::raw('(CASE WHEN from_id = '.$user->id.' THEN uf.username ELSE ut.username END) as username'),
          DB::raw('(CASE WHEN from_id = '.$user->id.' THEN uf.firstname ELSE ut.firstname END) as firstname'),
          DB::raw('(CASE WHEN from_id = '.$user->id.' THEN uf.lastname ELSE ut.lastname END) as lastname'),
          DB::raw('(CASE WHEN from_id = '.$user->id.' THEN uf.updated_at ELSE ut.updated_at END) as updated_at'),
          DB::raw('(CASE WHEN from_id = '.$user->id.' THEN upf.profile_file ELSE upt.profile_file END) as profile_file'),
          DB::raw('(CASE WHEN from_id = '.$user->id.' THEN upf.file_type ELSE upt.file_type END) as file_type'), DB::raw('max(chat_messages.id) as myid')
        )->groupBy('userId')->simplePaginate();


        foreach($follower as $key => $value) {
          $value->getlastmessage=ChatMessage::with('getTo')->whereFromId($value->id)->orderBy('id','desc')->first();
        }
    
    
      
      
          $allrecords=$follower->items();
          return response()->json(["error_code" => "200", "message" => "list of followers",'next_page' =>$follower->nextPageUrl() ,'data' =>$allrecords]);
        }
        else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }
    }

      public function get_recent_chat(Request $request){
    
     $validator = Validator::make($request->all(), [
         
          'login_token' => 'required',
       
                       
         ]);
          if ($validator->fails()) {
          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          } 
      $user=getUser($request->login_token);
      if($user){
    //DB::enableQueryLog();
      $follower=Chat::where(function($qu) use ($user){

               return $qu->where('user1',$user->id)->orWhere('user2',$user->id);
              
              })->select('id as chat_id','text_message','updated_at',DB::raw('(CASE WHEN user1 = '.$user->id.' THEN user2 ELSE user1 END) as userId'))->orderBy('updated_at','desc')->simplePaginate();
         // return DB::getQueryLog();

       $allrecords=$follower->items();
        foreach($allrecords as $key => $value) {


          $value->getUser=User::whereId($value->userId)->with('getUserProfile')->first();
          $value->unread_count=ChatMessage::whereChatId($value->chat_id)->whereToId($user->id)
          ->where('read_at',NULL)->count();
        }
        return response()->json(["error_code" => "200", "message" => "list of followers",'next_page' =>$follower->nextPageUrl() ,'data' =>$allrecords]);
        }
        else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }
    }

  public function ping_chat_message_list(Request $request)
  {  
    $validator = Validator::make($request->all(), [
         
          'login_token' => 'required',
          'latest_time' => 'required',
          'chat_id' => 'required',
       
                       
         ]);
          if ($validator->fails()) {
          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          } 
      $user=getUser($request->login_token);
      if($user){

    $user_id = $user->id;   

    
    $latest_time = $request->input('latest_time');

    

    $date_of_creation =  date('Y-m-d H:i:s');

    $chat_id = $request->input('chat_id');

    $chatmessages=ChatMessage::with('getFrom','getFrom.getUserProfile','getTo','getTo.getUserProfile')
    ->where('chat_id',$chat_id)
    ->where('created_at','>',$latest_time)
    ->where('from_id','!=',$user_id)
    ->simplePaginate();
      $allrecords=$chatmessages->items();

    return response() -> json(["error_code" => "200","message" => "Chat List.","chat_id"=>$chat_id,'data' =>$allrecords ,'next_page' =>$chatmessages->nextPageUrl(),"latest_time"=>$date_of_creation]);

     }
    else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }


  }
  
       
     public function get_unread_notifications(Request $request) {

        $user=getUser($request->login_token);
        if($user){
           $user_id = $user->id;
        


             $check_notification = Notification::where('to_user_id',$user_id)->where('status','active')->where('read_status','unread')->count();
             $check_message = ChatMessage::where('to_id',$user_id)->where('read_at',NULL)->count();
            $response =$result= array();    
            $result['message_count'] = $check_message;
            $result['notification_count'] = $check_notification;
            $message = 'Unread count';
            
          $response['message'] = $message;
            $response['error_code'] = '200';
          
            $response['data'] = $result;
            
            

        return response()->json($response);
         }
    else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }


       
    }   
    public function get_notifications(Request $request) {
        
         $user=getUser($request->login_token);
      if($user){
        $user_id = $user->id;   
         
                            
          $list = Notification::where('to_user_id',$user_id)->where('status','active')->with('getFromUser.getUserProfile')->orderBy('id','DESC')->simplePaginate(10);
                
           Notification::where('to_user_id',$user_id)->update(array('read_status'=>'read'));
           $allrecords=$list->items();

          return response()->json(["error_code" => "200", "message" => "List of all notifications", 
                                'next_page' =>$list->nextPageUrl() ,'data' =>$allrecords ]); 

           
         }
    else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }
       
    }  

    public function clear_notifications(Request $request) {
          $user=getUser($request->login_token);
      if($user){
        $user_id = $user->id;
        
       
         Notification::where('to_user_id',$user_id)->delete();
            

            $result = array();
            $result['error_code'] = 200;
            $result['success'] = true;
            
            $result['message'] = "Notification cleared successfully";

            return response()->json($result);
             }
    else{
        return response()->json(["error_code" => "700", "message" => "Your Session has expired. Please login again."]);
        }
        
    } 


      
    


}
