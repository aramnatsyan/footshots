<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\App;
use App\Models\SocialUser;
use App\Extra\NotiFunc;
use Validator;
use DB;
use Hash;
use Str;
use stdClass;


class LoginController extends Controller
{
  use NotiFunc;
    
    public function language_list(){

       return response()->json(['error_code'=>'200', "message" => "List of languages","data"=>config('lang')]);
      ;
    }


//  public function forget_password(Request $request){ 
      

//           $validator = Validator::make($request->all(), [         
         
//           'email' => 'email|exists:users,email',  
//           'phone' => 'exists:users,phone',        
         
       
//          ]);
//           if ($validator->fails()) {

//           return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
//           }

         
//           if($request->email){

//               $check_email = User::whereEmail($request->email)->where('email_verified_at','!=',NULL);
//               if($check_email->count() == 0 ){
//               return response()->json(["error_code" => "404", "message" => trans('msg.not_verified')]);
//               }
//               $check_email = $check_email->first();
//               $check_email->remember_token=generateRandomString(25);
//               $check_email->save();
//               $check_email->link=route('user.reset.password.link',$check_email->remember_token);
//               $subject= trans('communication.subject_forget_password');
//               $text=view('mail.forget_password',$check_email)->render();
//               send_grid_email($request->email, $check_email->name, $subject, $text);

//               return response()->json(["error_code" => "200", "message" => trans('msg.link_send_email')]);

//           }
//           else if($request->phone){
//           $check_email = User::wherePhone($request->phone)->where('phone_verified_at','!=',NULL);
//            if($check_email->count() == 0 ){
//               return response()->json(["error_code" => "404", "message" => trans('msg.not_verified')]);
//               }
//               $check_email = $check_email->first();
//               $check_email->remember_token=generateRandomString(25);
//               $check_email->save();
//               $check_email->link=route('user.reset.password.link',$check_email->remember_token);
//               $text= trans('communication.send_password_otp',['link',$check_email->link]);
//               send_sms($request->phone, $text,'1234567890'); 
//               return response()->json(["error_code" => "200", "message" => trans('msg.link_send_phone')]);
//           }         
          
          
  
//         }

// public function reset_password($remember_token){
        
//         DB::enableQueryLog();
//         $user = User::where('remember_token',$remember_token); 
//            //return DB::getQueryLog();
//           if($user->count() > 0 ){
//              $user =$user->first();
              
           
//             $minutes = (time() - strtotime($user->updated_at)) / 60;
//             if($minutes > 10000){
//             abort(404);
//             }

//            return view('aauth.reset_password',$user);
//          }
//           abort(404);
// }

public function change_password(Request $request){       

          $validator = Validator::make($request->all(), [
          'password' => ['required', 'string', 'min:8', 'confirmed']

       
         ]);
           if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->with('fail',$validator->errors()->first())
                            ->withInput();  
        
        }

          if(empty($request->role)){
          $role='user';
          }
          else{
          $role=$request->role;
          }

          $otp=rand(10000,99999);
          
          $check_email = User::whereEmail($request->email)
          ->where('role',$role);          
          if($check_email->count() > 0 ){
             return response()->json(["error_code" => "404", "message" => trans('msg.email_registration_email_exist')]);
           }
          $input=array();
          $input=$request->all();
          if(empty($request->role)){
          $input['role']=$role;
        
          }
          $input['otp']=$otp;
          $obj = User::create($input);
         
       
        $subject= trans('communication.subject_otp');
        $text=view('mail.otp',$input)->render();
        send_grid_email($request->email, $request->name, $subject, $text);


                    $result['error_code'] = '200';
                    $result['message'] = trans('msg.email_registration_success');
                    $result['data'] = User::find($obj->id);
            return response()->json($result);
        }

public function email_registration(Request $request){ 
      

          $validator = Validator::make($request->all(), [         
         
          'email' => 'required|email',
         // 'password' => 'required',
          //'language' => 'required',          
          'device_type' => 'required',
          'device_token' => 'required',
       
         ]);
          if ($validator->fails()) {

          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          }

          if(empty($request->role)){
          $role='user';
          }
          else{
          $role=$request->role;
          }

          $otp=rand(10000,99999);
          
          $check_email = User::whereEmail($request->email)
          ->where('role',$role);          
          if($check_email->count() > 0 ){
             
             $obj= User::whereEmail($request->email)->where('role',$role)->first();  
            if($obj->email_verified_at){
             return response()->json(["error_code" => "404", "message" => trans('msg.email_registration_email_exist')]);
            }
            
              
                $obj->otp=$otp;
                $obj->role=$role;
                $obj->save();
          $input=array();
              $input=$request->all();
              if(empty($request->role)){
                $input['role']=$role;
        
              }
              $input['otp']=$otp;
           }else{
              $input=array();
              $input=$request->all();
              if(empty($request->role)){
                $input['role']=$role;
        
              }
              $input['otp']=$otp;
            //unset($input['password']);
                if($input['password']){
                $input['password']=Hash::make($input['password']);
                }
                $obj = User::create($input);
          }
         
       
        $subject= trans('communication.subject_otp');
        $text=view('mail.otp',$input)->render();
        send_grid_email($request->email, $request->name, $subject, $text);

             $obj1= User::find($obj->id);
            $obj1->token='';
            $result['data'] =$obj1;
                    $result['error_code'] = '200';
                    $result['message'] = trans('msg.email_registration_success');
                   // $result['data'] = User::find($obj->id);
            return response()->json($result);
        }

public function phone_registration(Request $request){ 
         

          $validator = Validator::make($request->all(), [         
         
          'phone' => 'required',
          'login_token' => 'required',          
          
       
         ]);
          if ($validator->fails()) {

          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          }
   $user=getUser($request->login_token);
            
          
            if($user){
          if(empty($request->role)){
          $role='user';
          }
          else{
          $role=$request->role;
          }

          $otp=rand(10000,99999);
          
          $check_email = User::wherePhone($request->phone)
          ->where('role',$role);          
          if($check_email->count() > 0 ){
              return response()->json(["error_code" => "404", "message" => trans('msg.sms_registration_email_exist')]); 
          }
          
          
          $user->otp=$otp;
          $user->save();
          $text=trans('communication.phone_otp'); 
      send_sms($request->phone, $text,'1234567890');
          


                    $result['error_code'] = '200';
                    $result['message'] = trans('msg.sms_registration_success');
                    //$result['data'] = User::find($obj->id);
            return response()->json($result);
        }
    else{
              return response()->json(["error_code" => "700", "message" => trans('msg.session_expire') ]);
            }
    }

 
public function otp_verification_phone(Request $request){ 

          

          $validator = Validator::make($request->all(), [         
         
          //'phone' => 'required',
          'otp' => 'required',  
     'login_token' => 'required',          
         
       
         ]);
          if ($validator->fails()) {

          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          }
             $user=getUser($request->login_token);
            
          
            if($user){
          $check_email = User::where('login_token',$request->login_token); 
          if ($request->otp !='99115') {
            $check_email =$check_email->whereOtp($request->otp);
          }
    
          if($check_email->count() > 0){
           $check_email =$check_email->first();
            $minutes = (time() - strtotime($check_email->updated_at)) / 60;
            if($minutes > 10){
              return response()->json(["error_code" => "404", "message" => trans('msg.otp_expire')]);
            }
                

                  $check_email->phone_verified_at=date('Y-m-d H:i:s');  
           			if($request->step){
                  $check_email->step=$request->step;
                		 }
                  $check_email->save();

                    $result['error_code'] = '200';
                    $result['message'] = trans('msg.otp_verification_success');
                    $result['data'] = User::find($check_email->id);
                    return response()->json($result);
           }

           $result_error['error_code'] = '404';
           $result_error['message'] = trans('msg.otp_invalid');
                  
            return response()->json($result_error);
                   
            }

    else{
              return response()->json(["error_code" => "700", "message" => trans('msg.session_expire') ]);
            }

        } 


        public function otp_verification_email(Request $request){  // step 1
        
          $validator = Validator::make($request->all(), [         
         
          'email' => 'required',
          'otp' => 'required',          
          'device_type' => 'required',
          'device_token' => 'required',
           'latitude' => 'required',
          'longitude' => 'required',
       
         ]);
          if ($validator->fails()) {

          return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
          }
           
          $check_email = User::whereEmail($request->email); 
         
        if ($request->otp !='99115') {
            $check_email =$check_email->whereOtp($request->otp);
          }
    
          if($check_email->count() > 0){
           $check_email =$check_email->first();
           $minutes = (time() - strtotime($check_email->updated_at)) / 60;
            if($minutes > 10){
              return response()->json(["error_code" => "404", "message" => trans('msg.otp_expire')]);
            }
                  $login_token = generateRandomString(100);
                   $timezone=''; 
     if($request->latitude){
    $timezone=get_nearest_timezone($request->latitude,$request->longitude);
     }
           
                  $check_email->email_verified_at=date('Y-m-d H:i:s');
                  $check_email->timezone=$timezone;
                  $check_email->login_token=$login_token;
                  $check_email->language=$request->language;
                 if($request->step){
                  $check_email->step=$request->step;
                 }
                  $check_email->save();



                    $result['error_code'] = '200';
                    $result['message'] = trans('msg.otp_verification_success');
                    $result['data'] = User::find($check_email->id);
                    $result['login_token'] =$login_token;
            return response()->json($result);
           }

           $result_error['error_code'] = '404';
           $result_error['message'] = trans('msg.otp_invalid');
                  
            return response()->json($result_error);
                   


        } 
      public function login(Request $request) {
        
            
            $validator = Validator::make($request->all(), [  
            'email' => 'email|exists:users,email',  
            'phone' => 'exists:users,phone',  
            'password' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',


            ]);
            if ($validator->fails()) {
            return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
            } 
       
            if($request->email){
                if(User::where("email", $request->email)->where('email_verified_at',NULL)->count() > 0){
                    return response()->json(['error_code'=>'404', "message" => trans('msg.email_not_verified') ]);
                }
                $user = User::where("email", $request->email)->where('role','user')->whereStatus('active');
           }

           if($request->phone){
        
                if(User::where("phone", $request->phone)->where('phone_verified_at',NULL)->count() > 0){
               
                    return response()->json(['error_code'=>'404', "message" => trans('msg.phone_not_verified') ]);
                }
                     

                $user = User::where("phone", $request->phone)->where('role','user')->whereStatus('active');
           }
            
            if ($user->count() > 0) { 
            $user=$user->first();
            if(Hash::check($request->input('password'), $user->password)){
            $login_token = generateRandomString(100);
            $user->device_type=$request->input('device_type');
            $user->device_token=$request->input('device_token');
            $user->login_token=$login_token;
            $user->save();
            $obj= User::find($user->id);
            $obj->token=$login_token;
            $result['data'] =$obj;
            $result['error_code'] = '200';
            $result['message'] = trans('msg.welcome_user',['value',$user->name] ); 
          
            $result['login_token'] = $login_token;
            return response()->json($result);
            }
              else{
            return response()->json(["error_code" => "404", "message" => trans('msg.password_mismatch') ]);
            }
            }
      else{
      return response()->json(['error_code'=>'404', "message" => trans('msg.no_record_found') ]);
      }

       }

 public function user_profile(Request $request){  // step 2 phone //  // step 3 dob  // 4 profile pic step 
           $validator = Validator::make($request->all(), [         
          'login_token' => 'required',
          'name' => 'string|max:255',
          'password' => 'min:1',
          'email' => 'email',
          'date_of_birth' => 'date|date_format:Y-m-d',        
          'gender' => 'string',
          'status' => 'string',
        
         
            ]);
            if ($validator->fails()) {

            return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
            } 
 
             $user=getUser($request->login_token);
  
         
           // return $request->all();
          
            if($user){
                if($request->name){
                  $user->name=$request->name;
                  $user->username=strval(Str::slug(mb_strtolower($request->name))).$user->id;
                 }
                
                 if($request->email){
                  $user->email=$request->email;
                 }
                 if($request->date_of_birth){
                  $user->date_of_birth=$request->date_of_birth;
                   if($request->step){
                  $user->step=$request->step;
                 }
                  
                 } 
                 if($request->gender){
                  $user->gender=$request->gender;
                 } 
            if($request->phone_code){
                  $user->phone_code=$request->phone_code;
                 }
            if($request->country_code){
                  $user->country_code=$request->country_code;
                 }
                 if(!empty($request->password) && !empty($request->old_password)){
                
                 if( Hash::check($request->input('old_password'),$user->password)){ 
                   $user->password=Hash::make($request->password);
                  if($user->save()){
          			return response()->json(["error_code" => "200", "message" => trans('msg.update_success'),'data' => User::find($user->id)]);
                  }
                 else{
                  return response()->json(["error_code" => "404", "message" => trans('msg.password_mismatch')]);
                 }
                 
                 } 
                     return response()->json(["error_code" => "404", "message" => trans('msg.password_mismatch')]);
                 }
                 if($request->file('pic')){
                  $media=$request->file('pic');$folder='uploads/profile_images'.$user->id;
                  if($user->pic){
                    $user->pic=env('APP_URL').updatePublicFile($media,$folder,$user->pic);
                  }
                   else{
                     $user->pic=env('APP_URL').savePublicFile($media,$folder);
                   }
                   if($request->step){
                  $user->step=$request->step;
                 }
                  
                 } 
                if($request->has('language')){
                  $user->language=$request->language;
                 } 
                 if($request->has('status')){
                  $user->status=$request->status;
                 }
                 if($request->has('timezone')){
                  $user->timezone=$request->timezone;
                 }
                 
                
                 if($request->has('role')){
                  $user->role=$request->role;
                 } 
                 if($request->has('device_token')){
                  $user->device_token=$request->device_token;
                 }
                if($request->has('device_token')){
                  $user->device_token=$request->device_token;
                 } 
                 

                 if($request->password){
                  $user->password=Hash::make($request->password);
                 } 

                 if($request->has('deleted_at')){
                  $user->deleted_at=$request->deleted_at;              
                 } 
                 if($request->has('logout')){
                  $user->login_token=NULL;              
                 } 
                  if($request->phone){
                   if(User::where('phone',$request->phone)->where('id','!=',$user->id)->count() > 0){
                    return response()->json(["error_code" => "404", "message" => trans('msg.sms_registration_email_exist')]);
                   }
                   if( $user->phone != $request->phone){
                    $user->phone=$request->phone;
                    $user->phone_verified_at=NULL;
                    $otp=rand(10000,99999);
                    $text=trans('communication.phone_otp'); 
                    send_sms($request->phone, $text,'1234567890');
                    $user->otp=$otp;
                   }
                 }
                 $user->save();
                 

               return response()->json(["error_code" => "200", "message" => trans('msg.update_success'),'data' => User::find($user->id)]);
                 
                }
            
            else{
              return response()->json(["error_code" => "700", "message" => trans('msg.session_expire') ]);
            }



          }
   
    public function user_delete(Request $request)
    { 
       $validator = Validator::make($request->all(), [         
            'login_token' => 'required',
            ]);
            if ($validator->fails()) {

            return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
            } 
        $user=getUser($request->login_token);
        if($user){
           $user->login_token=NULL;
           $user->email= $user->email.$user->id;
           $user->phone= $user->phone.$user->id;
           $user->deleted_at= date('Y-m-d H:i:s');
           $user->save();
          
           SocialUser::whereUserId($user->id)->delete();
      
          return response()->json(["error_code" => "200", "message" =>  trans('msg.delete_success') ]);
                 
                }
            
            else{
              return response()->json(["error_code" => "700", "message" => trans('msg.session_expire') ]);
            }
    }

    public function logout(Request $request){
            $validator = Validator::make($request->all(), [         
            'login_token' => 'required',
            ]);
            if ($validator->fails()) {

            return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
            } 
            $user=getUser($request->login_token);
            if($user){
            $user->login_token=NULL;
            $user->save();

            $result = array();

            $result['error_code'] = '200';
            $result['message'] = trans('msg.logout') ;
            return response()->json($result);

            }else{
            return response()->json(["error_code" => "700", "message" => trans('msg.session_expire') ]);
            }

    }

    public function social_login(Request $request){
         
            $validator = Validator::make($request->all(), [ 
               
            'device_type' => 'required',
            'device_token' => 'required',
            'social_id' => 'required',
            'type' => 'required',
            ]);
            if ($validator->fails()) {
         
           return response()->json(['error_code'=>'404', "message" => $validator->errors()->first()]);
            }
   
           
            $device_type = $request->input('device_type');
            $device_token = $request->input('device_token');
            $name = $request->input('name');
            $social_id = $request->input('social_id');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $type = $request->input('type');  // ('facebook', 'google', 'instagram')
            $date_of_birth = $request->input('date_of_birth');  // (optional)
            $gender = $request->input('gender');  // (optional)
            $pic = $request->input('pic');  // (optional)
           
            $user_role =  "user"; 
            $login_token = generateRandomString(100);  
           

            $check_user = SocialUser::where('social_id',$social_id);
            if($check_user->count() > 0){
             
             $obj_social=  $check_user->first();
             $obj =User::find($obj_social->user_id);
            $obj->login_token=  $login_token; 
            if($type=='facebook' OR $type=='instagram' OR $type=='twitter'){
              $obj->email = $social_id.'@chumsy.com';
            }
            if($email){ $obj->email = $email;$obj->email_verified_at = date('Y-m-d H:i:s'); }
            if($name){ $obj->name= $name; }  
            if($phone){ $obj->phone= $phone;$obj->phone_verified_at = date('Y-m-d H:i:s');  }   
            if($date_of_birth){ $obj->date_of_birth= $date_of_birth; }    
            if($gender){ $obj->gender=  $gender; }
            if($device_type){ $obj->device_type=  $device_type;}
            if($device_token){ $obj->device_token=  $device_token; }
            if($request->has('pic')){ $obj->pic=  $pic; }
            $obj->save();
            }
            else{ 
          
             $check_user_data=User::where('email',$email)
             ->where('is_social','0')
             ->where('email_verified_at','!=',NULL);
         
              if($check_user_data->count() > 0){              
              $obj = $check_user_data->first();
              $obj->login_token=  $login_token; 
           	  $obj->save();                   
                }
            else{
              $check_user_d=User::where('email',$email);
            if($check_user_d->count() > 0){
               $obj =$check_user_d->first();
            }
            else{
            $obj =new User;
            }
            $obj->login_token=  $login_token; 
            $obj->is_social='1';
            $obj->step= '1'; 
            
            if($email){ 
                      $obj->email = $email;$obj->email_verified_at = date('Y-m-d H:i:s'); 
            // if(User::whereEmail($email)->count() > 0) { 
            // return response()->json(["error_code" => "404", "message" => trans('msg.email_exist') ]); }
                      }
            if($name){ $obj->name= $name; }  
            if($phone){ $obj->phone= $phone;$obj->phone_verified_at = date('Y-m-d H:i:s'); 
            //  if(User::wherePhone($phone)->count() > 0) { 
            // return response()->json(["error_code" => "404", "message" => trans('msg.phone_exist') ]); 
            //            } 
                      }   
            
            if($date_of_birth){ $obj->date_of_birth= $date_of_birth; }    
            if($gender){ $obj->gender=  $gender; }
            if($device_type){ $obj->device_type=  $device_type;}
            if($device_token){ $obj->device_token=  $device_token; }
            if($request->has('pic')){ $obj->pic=  $pic; }
            
            $obj->save();
             //return $request->all();
            
            $obj_social= new SocialUser;
            $obj_social->user_id=$obj->id;
            $obj_social->social_id=$social_id;
            $obj_social->type=$type;
            $obj_social->save();
            }
           }
            
           $obj=User::find($obj->id);
         
           if(!empty($name)){
           $obj->username=strval(Str::slug(mb_strtolower($name))).$obj->id;
           }
           if(!empty($user_role)){
           $obj->role=$user_role;
           }

           $timezone=''; 
           if($request->latitude){
           $timezone=get_nearest_timezone($request->latitude,$request->longitude);
           }
           $obj->timezone=$timezone;
       
           $obj->save(); 
           
         

            $result = array();
            $obj1= User::find($obj->id);
            $obj1->token=$login_token;
            $result['data'] =$obj1;
            $result['error_code'] = '200';
            $result['message'] = trans('msg.welcome_user',['value',$obj->name]);
           // $result['data'] =$obj1;
            $result['login_token'] = $login_token;
            return response()->json($result);
          }

            
     
   

     


        


}
