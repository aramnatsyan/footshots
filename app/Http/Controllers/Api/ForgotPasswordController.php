<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\SocialUser;
use stdClass;


class ForgotPasswordController extends Controller
{
   

   

    function forgot_password(Request $request)
    {
  
        $response = array('error_code'=>400,'message' => '','success'=>false, 'data' => (object)array() );

        // $credentials = request()->validate(['email' => 'required|email']);
        $email = $request->input('email');

        $alreadyuser= User::where('email', $email)->first();
  
    if(empty($alreadyuser)){
    $response['message'] = 'Email  does not belongs to any profile.';
     
        return response()->json($response);
    }
    
    
        if(!empty($alreadyuser))
        {
            $user_id = $alreadyuser->id;
  //---------------social login ceck-----------------------------------
            if($alreadyuser->is_social == '1' )
            {
              $response['message'] = 'You can not get password for social login.';
              return response()->json($response);
            }

            //--------------------------------------------------

            $user_password = generateRandomString(12);
            
            $appuser = User::find($user_id);
            $appuser->password = bcrypt($user_password);
        
            $appuser->save();

          $subject= env('APP_NAME')." Forgot Password";
             // addslashes($text)
          $a="/fablogin/index.php?type=get_user_login&email=".$appuser->email."&password=".$user_password;
              send_grid_email($request->email, $appuser->name, $subject, view('mail.forgetemail', [
                    'password' => $user_password,
                    'name' => $appuser->name,
                    'email' => $appuser->email,
                    'share_url'=>url($a),
                ]));

            $response['message'] = 'Please check your email to set a new password.';
            $response['error_code'] = 200;
            $response['success'] = true;
            $response['data'] = new stdClass();

            // return response()->json(["error_code" => "200",   "message" => "Please check your email to set a new password."]);
            return response()->json($response);
        }
        $response['message'] = 'This email id does not exist.';
        // return response() -> json(["error_code" => "400",   "message" => "This email id does not exist."]);
        return response()->json($response);
    }

  
}
