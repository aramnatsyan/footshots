<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 

/**
     * is_adminprotected
     *
     * This function check superadminuser already login or not
     * 
     * @access	public
     * @return	boolean
     */
	 /* function is_protected() {
        $CI = &get_instance();
        
        if ($CI->session->userdata('isLogin') == 'yes') {
            if ($CI->session->userdata('userinfo')->user_type == 1 || $CI->session->userdata('userinfo')->user_type == 2) {
                redirect('/admin/dashboard');
            }else{
                return true;
            }
        } else {
            redirect('admin/auth');
        }
    } */
	if (!function_exists('is_protected')) {

    function is_protected() {
        $CI = &get_instance();
        
		//$usertype=$CI->session->userdata('userinfo')->user_type;
		$chlogin=$CI->session->userdata('isLogin');
		if ($chlogin != 'yes') {
            redirect(base_url());
        } else
		{
			//check_permission();
		}
    }

}
	
	
	if (!function_exists('get_language')) {
    function get_language() 
    {
        $lang = currentuserinfo() ? currentuserinfo()->language : 'english';
        return $lang;
    }
}



if (!function_exists('front_layout')) {

    function front_layout($data = null) {
        $CI = &get_instance();
        $CI->load->view('front_layout', $data);
    }

}

//==============Set Session Flash Message=============//
/**
 * Set Flash Data
 * 
 * Set Flash Data in Session Flashdata
 *
 * @access	public
 * @param   String - Message type value(info,success,warning,error)
 * @param   String - Text Message
 */ 
if(!function_exists('set_flashmsg')) 
{
    function set_flashmsg($type,$msg) 
    {
        $CI =& get_instance();
        $CI->session->set_flashdata("flash_msg_type",$type);
        $CI->session->set_flashdata("flash_msg_text",$msg);
    }
}


//=======function for checking quiz is attempted or not============
/*
	input parameter required :quiz id
	function will return true if quiz is attempted
*/
 
 
 
  

//==============Close Set Session Flash Message=============//

/**
* get_flashdata
*
* This function give custome flash message formate
* 
* @access	public
* @return	html data
*/
if (!function_exists('get_flashdata')){
    function get_flashdata()
    {
        $CI         =   &get_instance();
        $success    =   $CI->session->flashdata('success') ? $CI->session->flashdata('success') : '';
        $error      =   $CI->session->flashdata('error') ? $CI->session->flashdata('error') : '';
        $warning    =   $CI->session->flashdata('warning') ? $CI->session->flashdata('warning') : '';
        $msg        =   '';
        if($success){
            $msg    =   '<div class="alert alert-success ">
                            <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>
                            ' . $success . ' </div>';
        }elseif($error){
            $msg    =   '<div class="alert alert-danger ">
			<button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>
			<strong>Error!</strong> ' . $error . ' </div>';
        }elseif($warning){
            $msg    =   '<div class="alert alert-warning">
			<button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			' . $warning . '</div>';
        }
        return $msg;
    }
}
/*End of Function*/



if (!function_exists('ajax_layout')) {

    function ajax_layout($views, $data = array()) {
        $CI = & get_instance();
        $CI->load->view($views, $data);
    }

}


if (!function_exists('currentuserinfo')){
    function currentuserinfo() 
    {
        $CI     =   &get_instance();
        return $CI->session->userdata("userinfo");
    }
}

if (!function_exists('is_adminprotected')) {

    function is_adminprotected() {
		
        $CI = &get_instance();		
        if ($CI->session->userdata('isLogin') == 'yes') {
            if ($CI->session->userdata('userinfo')->user_type == 1 || $CI->session->userdata('userinfo')->user_type == 2) {            
            }else{
                redirect('admin/dashboard');
            }
        } else {
            redirect('admin/auth');
        }
    }

}
/* End of Function */
/**
     * is_userprotected
     *
     * This function check superadminuser already login or not
     * 
     * @access	public
     * @return	boolean
     */
if (!function_exists('is_userprotected')) {

    function is_userprotected() {
        $CI = &get_instance();
        if ($CI->session->userdata('isLogin') == 'yes') {
            return true;
        } else {			
			redirect('/auth');	
        }
    }

}
/* End of Function */


/**
     * validate_admin_login
     *
     * This function check user type and redirect according
     * 
     * @access	public
     * @return	boolean
     */
if (!function_exists('validate_admin_login')) {

    function validate_admin_login() {
        $CI = &get_instance();		
		if ($CI->session->userdata('isLogin') == 'yes') { 
					if($CI->session->userdata('user_type')==1){						
					} else if($CI->session->userdata('user_type')==3){					
						redirect('/admin/dashboard');		
					} else {							
						redirect('/account');
					}  			
		}
		
    }

}
/* End of Function */


/**
     * validate_user_login
     *
     * This function check user type and redirect according
     * 
     * @access	public
     * @return	boolean
     */
if (!function_exists('validate_user_login')) {

    function validate_user_login() {
        $CI = &get_instance();		
		if ($CI->session->userdata('isLogin') == 'yes') { 
					if($CI->session->userdata('user_type')==4){							
					} else if($CI->session->userdata('user_type')==3){					
						redirect('/admin/dashboard');		
					} else {							
						redirect('/admin/dashboard');
					}  			
		}
		
    }

}
/* End of Function */

/**
 * @Function _layout
 * @purpose load layout page 
 * @created  2 dec 2014
 */
if (!function_exists('_layout')) {

    function _layout($data = null) {
        $CI = &get_instance();
        $CI->load->view('layout', $data);
    }

}
/* End of Function */

/**
 * set_flashdata
 *
 * This function set falsh message value
 * 
 * @access	public
 * 
 */
if (!function_exists('set_flashdata')) {

    function set_flashdata($type, $msg) {
        $CI = &get_instance();
        $CI->session->set_flashdata($type, $msg);
    }

}
/* End of Function */

/**
 * get_flashdata
 *
 * This function give custome flash message formate
 * 
 * @access	public
 * @return	html data
 */
if (!function_exists('get_flashdata')) {

    function get_flashdata() {
        $CI = &get_instance();
        $success = $CI->session->flashdata('success') ? $CI->session->flashdata('success') : '';
        $error = $CI->session->flashdata('error') ? $CI->session->flashdata('error') : '';
        $warning = $CI->session->flashdata('warning') ? $CI->session->flashdata('warning') : '';
        $msg = '';
        if ($success) {
            $msg = '<div class="alert alert-success" >
                            <button class="close" data-dismiss="alert">X</button><i class="ace-icon fa fa-check green"></i>
                            ' . $success . ' </div>';
        } elseif ($error) {
            $msg = '<div class="alert alert-danger ">
			<button class="close" data-dismiss="alert">X</button><i class="ace-icon fa fa-check green"></i>
			<strong>Error!</strong> ' . $error . ' </div>';
        } elseif ($warning) {
            $msg = '<div class="alert alert-warning ">
			<button class="close" data-dismiss="alert">X</button>
			' . $warning . '</div>';
        }
        return $msg;
    }

}
/* End of Function */

/**
 * isPostBack
 *
 * This function check request send by POST or  not
 * 
 * @access	public
 * @return	html data
 */
if (!function_exists('isPostBack')) {

    function isPostBack() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            return true;
        else
            return false;
    }

}
/* End of Function */


/**
 * Current Date And Time
 *
 * This function get Current Date And Time
 *
 * @param	
 * @return
 */
if (!function_exists('current_date')) {

    function current_date() {
        $dateFormat = date("Y-m-d H:i:s", time());
        $timeNdate = $dateFormat;
        return $timeNdate;
    }

}
/* End of Function */



/**
 * Date format for view
 *
 * This function get date format for view exp: d/m/Y
 *
 * @param	
 * @return
 */
if (!function_exists('view_date_format')) {    
    function view_date_format($view_date) {
		if($view_date){
        $view_date = str_replace('-', '/',$view_date); 
        $dateFormat = date("d/m/Y", strtotime($view_date));                      
			return $dateFormat;
		} else {
			return false;
		}
        
    }

}
/* End of Function */

/**
 * Current User Info 
 * 
 * If user loged then returl current user info
 *
 * @access	public
 * @return	mixed	boolean or depends on what the array contains
 */
if (!function_exists('currentuserinfo')) {

    function currentuserinfo() {
        $CI = &get_instance();
        return $CI->session->userdata("userinfo");
    }

}
/* End of Function */



/**
 * uri_segment
 * this function give url segment value
 * @param int 
 * @return string
 */
if (!function_exists('uri_segment')) {

    function uri_segment($val) {
        $CI = &get_instance();
        return $CI->uri->segment($val);
    }

}
/* End of Function */

/**
 * pr
 * this function print data with <pre> tag
 * @access	public
 */
if (!function_exists('pr')) {

    function pr($data = null) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}
/* End of Function */



/**
 * is_ajax_post
 *
 * This function check request send by Ajax or not
 *
 * 	
 * @return boolean
 */
if (!function_exists('is_ajax_post')) {

    function is_ajax_post() {
        $CI = &get_instance();
        if (!$CI->input->is_ajax_request()) {
            show_error('No direct script access allowed');
            exit;
        }
    }

}
/* End of Function */



/**
 * Function to check ajax request
 *
 * @access	public
 */
if (!function_exists('is_ajax_request')) {

    function is_ajax_request() {
        $CI = &get_instance();
        if (!$CI->input->is_ajax_request()) {
            show_error('No direct script access allowed');
            exit;
        }
    }

}
/* End of Function */






/**
 * _show404
 *
 * This function show error message
 *
 * 	
 * @return array 
 */
if (!function_exists('_show404')) {

    function _show404() {
        $CI = &get_instance();
        $data['title'] = 'Error';
        $data['subTitle'] = 'Wrong Page';
        $data['page'] = 'error';
        _layout($data);
    }

}
/* End of Function */





/**
 * custom_encryption
 *
 * This function encryt and decrypt value on the base action value
 * @param string
 * @param string
 * @param string
 * 	
 * @return string
 */
if (!function_exists('custom_encryption')) {

    function custom_encryption($string, $key, $action) {  //echo die($action);
        if ($action == 'encrypt')
            return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        elseif ($action == 'decrypt')
            return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }

}
/* End of Function */


/**
 * get_topics
 *
 * This function give  captcha image
 * 
 * @return html data
 * 	
 */
if (!function_exists('getcaptchacode')) {

    function getcaptchacode() {
        $CI = & get_instance();
        $CI->load->helper('captcha');
        $listAlpha = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $numAlpha = 5;
        $captcha = substr(str_shuffle($listAlpha), 0, $numAlpha);

        $path = config_item('base_url') . 'captcha/';
        //$fontpath = config_item('base_url').'bucket/frontend/assets/fonts/TitilliumWeb-BoldItalic.ttf';
        $fontpath = 'assets/fonts/verdana.ttf';
        $vals = array(
            'word' => $captcha,
            'img_path' => './captcha/',
            'img_url' => $path,
            //'font_path'	 => 'c:/windows/fonts/verdana.ttf',
            'font_path' => $fontpath,
            'img_width' => '159',
            'img_height' => '32',
            'border' => 0,
            'expiration' => 1800
        );
        $get_captcha = create_captcha($vals); //pr($get_captcha); die;
        $CI->session->set_userdata('codecaptcha', $get_captcha['word']);
        return $get_captcha;
    }

}
/* End of Function */

/**
 * obj_to_arr
 *
 * This function convert std object array into array 
 * 
 * @return array
 * 	
 */
if (!function_exists('obj_to_arr')) {

    function obj_to_arr($obj_arr) {
        $obj_arr = (array) $obj_arr;
        $chkey = array_keys($obj_arr);
        $chval = array_values($obj_arr);
        unset($obj_arr);
        $obj_arr = array_combine($chkey, $chval);
        return $obj_arr;
    }

}
/* End of Function */


/**
 * Id_encode
 *
 * This function to encode ID by a custom number
 * @param string
 * 	
 */
if (!function_exists('ID_encode')) {

    function ID_encode($id) {
        $encode_id = '';
        if ($id) {
            $encode_id = rand(1111, 9999) . (($id + 19)) . rand(1111, 9999);
        } else {
            $encode_id = '';
        }
        return $encode_id;
    }

}
/* End of function */

/**
 * Id_decode
 *
 * This function to decode ID by a custom number
 * @param string
 * 	
 */
if (!function_exists('ID_decode')) {

    function ID_decode($encoded_id) {
        $id = '';
        if ($encoded_id) {
            $id = substr($encoded_id, 4, strlen($encoded_id) - 8);
            $id = $id - 19;
        } else {
            $id = '';
        }
        return $id;
    }

}
/* End of function */



  





function get_datetime_by_defined_timezone($datetime,$timezone = NULL)
{
    if($timezone == '')
    {
        $timezone_dat = fieldByCondition("users",array('id'=>  currentuserinfo()->id),"timezone"); 
        if(!empty($timezone_dat)){$timezone = $timezone_dat->timezone;}else{$timezone   =   date_default_timezone_get();}
        $date = new DateTime($datetime, new DateTimeZone(date_default_timezone_get()));
    }else{
        $date = new DateTime($datetime, new DateTimeZone($timezone));
    }
    
    
    //$date->format('Y-m-d H:i:s') . "\n";
    $date->setTimezone(new DateTimeZone($timezone));
    return $date->format('Y-m-d H:i:s');

}

function convert_datetime_by_defined_timezone($datetime,$timezone_from,$timezone_to)
{
    $date = new DateTime($datetime, new DateTimeZone($timezone_from));
    //$date->format('Y-m-d H:i:s') . "\n";
    $date->setTimezone(new DateTimeZone($timezone_to));
    return $date->format('Y-m-d H:i:s');

}

function get_default_timezone_of_user()
{
    $timezone_dat = fieldByCondition("users",array('id'=>  currentuserinfo()->id),"timezone"); 
    if(!empty($timezone_dat))
    {
        $timezone = $timezone_dat->timezone;
    }else{
        $timezone   =   date_default_timezone_get();
    }
    return $timezone;
}

/**
 * Function for restore data
 */
if (!function_exists('restoreData')) {

    function restoreData($arr) {
        $CI = &get_instance();
        $table = $arr->table;
        $col1 = $arr->col1;
        if($arr->col2){ 
        $col2 = $arr->col2;         
        }
        $whr[$col2] = $arr->id;
        $upd[$col1] = $arr->value;        
        $CI->db->update($table, $upd, $whr);
//        echo $CI->db->last_query(); die;
        if ($CI->db->affected_rows()) {
            $res['status'] = 'success';
            $res['message'] = null;
        } else {
            $res['status'] = 'error';
            $res['message'] = $CI->db->_error_message();
        }
        return $res;
    }

}

/* End of Function */

/**
 * export_data
 *
 * This function give data on given condition 
 *
 * 	
 * @return array or boolean
 */
if (!function_exists('export_data')) {

    function export_data($conArr,$field) {			
        $CI = &get_instance();
        $CI->db->select($field, false);
        $CI->db->from($conArr['table']);
		if(!empty($conArr['column1'])){
        $CI->db->where_in($conArr['column1'], $conArr['ids']);
        }
		$CI->db->order_by($conArr['column1'],'desc');
        $query = $CI->db->get();		
        if ($query->num_rows()>0) {
            return $query->result();
        } else {
        return false;
		}
    }

}
/* End of Function */


	
//=============================================Export=================================================	
if(! function_exists('array_to_exl'))
{
    function array_to_exl($header,$excellists, $download = "")
    {
		$num=0;
		$data=NULL;
		if($excellists!=null)
		{
			foreach ($excellists as $row)
			{
				$num++;
				$line = $num."\t";
				foreach($row as $value)
				{
					if(!isset($value) || trim($value) == "")
					{
						$value = "\t";
					}
					else
					{
						$value = str_replace('"' , '""' , $value);
						$value = '"' . $value . '"' . "\t";
					}
					$line .= $value;
				}
				$data .= trim($line). "\n";
			}
			$data = str_replace("\r" , "" , $data);
			if(trim($data) == "")
			{
				$data = "\n(0)Records Found!\n";
			}
		}
		if ($download != "")
		{
			header('Content-Type: application/msexcel');
			header('Content-Disposition: attachement; filename="' . $download . '"');
			header("Pragma: no-cache");
			header("Expires: 0");
			print "$header\n$data";
		}
	}
//=============================================End Export=================================================	
	
}
    /* End of Function */



if(! function_exists('generate_password')){
    function generate_password(){
        return random_string('numeric',6);
    }
}
/* End of Function */

if(! function_exists('generate_random_password')){
    function generate_random_password(){
        return rand(100000,999999);
    }
}
/* End of Function */



/*

/* End of Function */


/*
* function:: get image

* This function get image */
if(! function_exists('get_file')){
 function get_file($path=null,$filename=null){
    if(isset($path) && isset($filename)){
        $uploaded_path = base_url()."uploads/".$path;
        $filename =  $uploaded_path.'/'.$filename;

    } else {
        $filename = 'uploads/placeholder.png';
    }

     return $filename;
 }
}
/* End of Function */



/*
* function:: get image thumb

* This function get image */
if(! function_exists('get_image_thumb')){
    function get_image_thumb($filename=null,$type){

        /*type= _thumb, 40x40, 100x100, 200x200*/              
        if($type && $filename){
            $image_expl = explode('.',$filename);            
            $thumb_name = $image_expl[0]."_".$type.'.'.@$image_expl[1];
       
        } else {
            $thumb_name = '';
        }

        return $thumb_name;
    }
   }
   /* End of Function */

/*
* function:: get image thumb with ext a

* This function get image */
if(! function_exists('get_image_thumb_a')){
    function get_image_thumb_a($filename=null,$type){

        /*type= _thumb, 40x40, 100x100, 200x200*/              
        if($type && $filename){
            $image_expl = explode('.',$filename);            
            $thumb_name = $image_expl[0]."a_".$type.'.'.@$image_expl[1];
       
        } else {
            $thumb_name = '';
        }

        return $thumb_name;
    }
   }
   /* End of Function */

   
   function createUrlByTitleAndId($title,$id)
   {
       return RemoveSpecialChar($title)."-".ID_encode($id);
   }
   
/*
* function:: 

* This function get image */
if(! function_exists('RemoveSpecialChar')){
function RemoveSpecialChar($value){
    $result  = preg_replace('/[^a-zA-Z0-9_]/s','_',$value);
            
    return $result;
    }

}
/* End of Function */

if(! function_exists('getIdByUrl')){
    function getIdByUrl($url){
        $url_break = explode('-',$url);
        $Id         = ID_decode($url_break[1]);
        return $Id;
    }

}

   

 
	function array_to_csv($array, $download = "") 
	{
		if ($download != "") {	
			header('Content-Type: application/csv');
			header('Content-Disposition: attachement; filename="' . $download . '"');
		}		
		ob_start();
		$f = fopen('php://output', 'w') or show_error("Can't open php://output");
		$n = 0;		
		foreach ($array as $line) {
			$n++;
			if ( ! fputcsv($f, $line)) {
				show_error("Can't write line $n: $line");
			}
		}
		fclose($f) or show_error("Can't close php://output");
		$str = ob_get_contents();
		ob_end_clean();
		if ($download == "") {
			return $str;	
		} else {	
			echo $str;
		}		
	}
  
 
 /*end the function*/ 

 /*Android Push Notifications*/
 if(! function_exists('send_notification_android')){

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
            "authorization: Key=AIzaSyBLYlwLldoeJYDQY2h04HX9hYkQ_48LAbI",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));

       $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
           //return false;
            //echo "cURL Error #:" . $err;
            return "failed";
        } 
        else 
        {
           // return $response;
            return $response;
            //echo "success";
        }
    }
}
    
/*end the function*/   
  
 /*iOS Push Notifications*/

 if(! function_exists('send_message_ios')){
  
//         function send_message_ios_($device_token,$message,$badge,$action,$value)
//         {
            
            
          
//             $ctx = stream_context_create();
            
//             stream_context_set_option($ctx, 'ssl', 'local_cert', 'FootshotAdhoc-dis-cert.pem');//'fa_apns_dev.pem');
            
//             stream_context_set_option($ctx, 'ssl', 'passphrase', "");
            
//             $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
            
//             if (!$fp){  
//             //echo " failed ";
//             return ("Failed to connect: $err $errstr" . PHP_EOL);
//               return ;;
//             }
//             // $message = utf8_encode($message);
//             $body= array();   
//           $body['aps'] = array('alert' => $message, 'sound' => 'default','badge'=>$badge);
//             /*if($extra!=NULL){
//               //$body['loc-args']=$extra;
//               $body['aps'] = array('alert' => array('body'=> $message, 'extra' => $extra), 'sound' => 'default','badge'=>$badge);
//             }else{
              
//             }*/

            
//             if($action!=NULL)
//             {
//               $body['type']=$action;
//             }
//             if($value!=NULL)
//             {
//               $body['timeline_id']=$value;
//             }
//             // Encode the payload as JSON
            
//             $payload = json_encode($body);
            
//             // Build the binary notificatio
//               $payload;
//             $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;
            
//             // Send it to the server
            
//             $result = fwrite($fp, $msg, strlen($msg));
            
//             fclose($fp);
            
//             if (!$result)
//               return 'Message not delivered' . PHP_EOL;
//             else
//               return 'Message successfully delivered' . PHP_EOL;
          
//             // Close the connection to the server
            
            
//           } 
  function send_message_ios($registatoin_ids,$message,$badge,$action,$value,$sound='default')
 {
  $notification["body"] =$message;
 ///$notification["title"] = $title;
 // $notification["type"] = 1;
  $notification["badge"] = $badge;
  $body=array();
 if($action!=NULL)
    {
      $notification['action']=$action;
 		$body['type']=$action;
    }

    if($value!=NULL)
    {
      $notification['value']=$value;
    $body['timeline_id']=$value;
    }
    if($sound!=NULL)
    {
      $notification['sound']=$sound;
    }

  
 
$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array(
'to' => $registatoin_ids,
'notification' => $notification,
'data' => $body,
//'title' => $action,
);
// Firebase API Key
$headers = array('Authorization:key=AAAATMFtzh4:APA91bGsIxWDefEJMPHvXyiYe-GbxZc_LvsFLXsT7Zp2wzbN4DZuNj52MduQmCl_RdQtev7n4BjWZM7E-2dqwQzGnbA0fwghp_xaYXs2z7FkJQqkr1r53aY7mxU4cfzBRVh_ZM0KWoOJ','Content-Type:application/json');
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
}
/*end the function*/ 