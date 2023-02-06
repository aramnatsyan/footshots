<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\App;
use App\Models\Events;
use App\Models\Sports;
use App\Models\Lifestyle;
use App\Extra\NotiFunc;
use Validator;
use DB;
use Hash;
use Str;
use stdClass;


class EventController extends Controller
{
  use NotiFunc;
    
    public function language_list(){

       return response()->json(['error_code'=>'200', "message" => "List of languages","data"=>config('lang')]);
      
    }

    public function sports_lifestyle()
    {
    	$result['sports']=Sports::where('status', 'active')->get();
    	$result['lifestyle']=Lifestyle::where('status', 'active')->get();
       return response()->json(['error_code'=>'200', "message" => "List of sports and lifestyle","data"=>$result]);
      
    }
     
     // save events 
    public function save_event(Request $request){

      $event_name = $request->input('event_name');
      $event_time = $request->input('event_time');
      $price = $request->input('price');
      $latitute = $request->input('latitute');
      $longitute = $request->input('longitute');
      $user_id = $request->input('user_id');
      $event_description = $request->input('event_description');
      $sports = $request->input('sports');
      $lifestyle = $request->input('lifestyle');
      $event_level = $request->input('event_level');
      $event_type = $request->input('event_type');
      $event_category = $request->input('event_category');

      $save_event = new Events();
      $save_event->event_name = $event_name;
      $save_event->event_time = $event_time;
      $save_event->price = $price;
      $save_event->lat = $latitute ;
      $save_event->lng = $longitute;
      $save_event->user_id = $user_id;
      $save_event->event_description = $event_description;
      $save_event->sports = $sports;
      $save_event->lifestyle = $lifestyle;
      $save_event->event_level = $event_level;
      $save_event->event_type = $event_type;
      $save_event->event_category = $event_category;
      $save_event->save();

      $result['error_code'] = '200';
      $result['message'] = trans('msg.event_saved');
      // $result['message'] = "event save successfully";
      $result['data'] = $save_event;
      return response()->json($result);
    }

    public function event_detail(Request $request){
	  $event_id = $request->input('event_id');
      $get_events = Events::with('getUser:id,name,email,pic')->where('id',$event_id)->first();
                 
       return response()->json(["error_code" => "200", "message" => trans('msg.event_show_onmap'),'data' =>$get_events]);
    }

    // show_events_onmap
    public function show_events_onmap(Request $request){

      $lat1 = $request->input('latitute');
      $long1 = $request->input('longitute');
      // $login_token = $request->input('login_token');
      // $get_events = Events::with('getUser:id,name,email,pic')->simplePaginate();
                  // $allrecords=$get_events->items();
    
      $get_events= Events::with('getUser:id,name,email,pic','getSports', 'getLifestyle')->where('status', 'active')->get();
      $eventData = array();
       foreach($get_events as $value)
       {
          $lat2  = $value->lat;
            $long2 = $value->lng;
       			$unit ='K';

          $theta = $long1 - $long2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515; 
          $unit = strtoupper($unit);

          // Convert unit and return distance
          if ($unit == "K") {
              $miles * 1.609344.' KM';
          } else {
               $miles.' MI';
          }
       
          $value->miles_in_km=$miles;
       }
      
       return response()->json(["error_code" => "200", "message" => trans('msg.event_show_onmap'),'data' =>$get_events]);
    }
    
    public function filter_events(Request $request)
    {
      $event_time = $request->input('event_time');
      $price = $request->input('price');
      $gender = $request->input('gender');
      $first_age = $request->input('first_age');
      $second_age = $request->input('second_age');
      $team = $request->input('team');
      $level = $request->input('level');
      // $user_id = $request->input('user_id');
      
      // $sports = $request->input('sports');
      // $lifestyle = $request->input('lifestyle');
      // $get_events = Events::where('event_time', $event_time)
      // ->where('price', $price)
      // // ->where('gender', $gender)
      // // ->where('age', $age)
      // // ->where('team', $team)
      // // ->where('level', $level)
      // ->simplePaginate();
      // $allrecords=$get_events->items();
      $get_events = Events::join('users', 'users.id', 'events.user_id')
      ->where('events.price','like', '%'.$price.'%')
      // ->whereBetween('events.age', [$first_age, $second_age])
      // ->where('team', $event_time)
      // ->where('level', $level)
      ->simplePaginate();
      $allrecords=$get_events->items();
      // $result['error_code'] = '200';
      // $result['message'] = trans('msg.event_show_onmap');
      // // $result['message'] = "Events list";
      // $result['data'] = $get_events;
      // return response()->json($result);
       return response()->json(["error_code" => "200", "message" => trans('msg.event_show_onmap'),'next_page' =>$get_events->nextPageUrl() ,'data' =>$allrecords]);
    }

    public function filter_event(Request $request)
    {
      
      // $user_id = $request->input('user_id');
      
      $category = $request->input('category');
      $values = $request->input('values');
      if($category == 'sports')
      {
      	$get_events = Events::with('getUser:id,name,email,pic')->whereIn('sports', $values)
      	->simplePaginate();
      	
      }else
      {
      	$get_events = Events::with('getUser:id,name,email,pic')->whereIn('lifestyle', $values)
      	->simplePaginate();
      	
      }
      $allrecords=$get_events->items();
      return response()->json(["error_code" => "200", "message" => trans('msg.event_show_onmap'),'data' =>$allrecords]);
    }

  public function filter_events_copy(Request $request)
    {

      // $lat1 = $request->input('latitude');
      // $long1 = $request->input('longitude');


      $lat1 = 29.8811;
      $long1 = 77.0541;
      
      $get_events= Events::where('status', 'active')->get();
      $eventData = array();
       foreach($get_events as $value)
       {
          $lat2  = $value->lat;
            $long2 = $value->lng;
       			$unit ='K';

          $theta = $long1 - $long2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515; 
          $unit = strtoupper($unit);

          // Convert unit and return distance
          if ($unit == "K") {
              $miles * 1.609344.' KM';
          } else {
               $miles.' MI';
          }
       $eventData[$value->id]['event_name']=$value->event_name;
        $eventData[$value->id]['event_description']=$value->event_description;
        $eventData[$value->id]['sports']=$value->sports;
        $eventData[$value->id]['miles_in_km']=$miles;
       }
  
  
//   echo "<pre>";
//   print_r($eventData);
  
  
  
  $price = array();
foreach ($eventData as $key => $row)
{
    $price[$key]['KM'] = $row['miles_in_km'];
    $price[$key]['event_name'] = $row['event_name'];
}
array_multisort($price, SORT_ASC, $eventData);
  
 //  echo "<pre>";
   echo $ab = json_encode($price);
  die;
       
  //     $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL&key=AIzaSyCuW8XqIDMG5EPg57iNQk0ZjgVPZDWmzuw";
  //   $ch = curl_init();
  //   curl_setopt($ch, CURLOPT_URL, $url);
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //   curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
  //   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  //   $response = curl_exec($ch);
  //   curl_close($ch);
  //   $response_a = json_decode($response, true);
  // echo "<pre>";
  // print_r($response_a);
    //ho $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
  
     

  //         echo $miles;
  // die;

      
       //return response()->json(["error_code" => "200"]);
    }




// end class
}
