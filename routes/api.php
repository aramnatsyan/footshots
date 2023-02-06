<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'locale'], function() {

	Route::get('/language_list', 'Api\LoginController@language_list');
	Route::post('/email_registration', 'Api\LoginController@email_registration');
	Route::post('/phone_registration', 'Api\LoginController@phone_registration');
	Route::post('/otp_verification_email', 'Api\LoginController@otp_verification_email');
	Route::post('/otp_verification_phone', 'Api\LoginController@otp_verification_phone');
	Route::post('/user_profile', 'Api\LoginController@user_profile');
	Route::post('/login', 'Api\LoginController@login');
	Route::post('/user_delete', 'Api\LoginController@user_delete');
	Route::post('/logout', 'Api\LoginController@logout');
	Route::post('/social_login', 'Api\LoginController@social_login');
	Route::post('/forget_password', 'Api\LoginController@forget_password');

	Route::get('/reset-password/{otp}', 'Api\LoginController@reset_password')->name('user.reset.password.link');

    Route::post('/change_password', 'Api\LoginController@change_password')->name('user.change_password');

	 Route::post('save_event','Api\EventController@save_event')->name('save_event');
    Route::post('show_events_onmap','Api\EventController@show_events_onmap')->name('show_events_onmap');
    Route::post('event_detail','Api\EventController@event_detail');
    Route::post('add_chat', 'Api\ChatController@add_chat')->name('add_chat');

      Route::get('sports_lifestyle','Api\EventController@sports_lifestyle');
      Route::post('filter_events','Api\EventController@filter_events');
      Route::post('filter_event','Api\EventController@filter_event');
     Route::post('filter_events_copy','Api\EventController@filter_events_copy');

     

      Route::post('get_chat', 'Api\ChatController@get_chat');
      Route::post('get_chat_users', 'Api\ChatController@get_chat_users');
      Route::post('get_recent_chat', 'Api\ChatController@get_recent_chat');
      Route::post('ping_chat_message_list', 'Api\ChatController@ping_chat_message_list');
      Route::post('get_notifications','Api\ChatController@get_notifications');
      Route::post('clear_notifications', 'Api\ChatController@clear_notifications');
      Route::post('get_unread_notifications', 'Api\ChatController@get_unread_notifications');



	Route::get('/api_text', function (Request $request) {
		if($request->key){
		return response()->json(["error_code" => "200", "message" => "List of text" ,"data"=>[$request->key => trans('apitext.'.$request->key)] ]);  
		}
		else{
			return response()->json(["error_code" => "200", "message" => "List of text", "data"=> trans('apitext')] );  
		} 
	});
});
