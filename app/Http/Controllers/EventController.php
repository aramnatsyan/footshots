<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Events;
use DB;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {  
    
        $view=$request->view;
        $name=$request->name;
        $from = $request->from;
        $to = $request->to;
        // $lists=User::whereRole('user');
        if ($from != '' OR $to != '')
	    {
            $response['event_list']=Events::whereDate('created_at','>=',$from)->whereDate('created_at','<=', $to)->paginate(15);
	    }elseif($name !='')
	    {
            $response['event_list']=Events::where('event_name', 'like', '%'.$name.'%')->paginate(15);
	    	
	    }
	    else{

		    $response['event_list']=Events::orderBy('id','asc')->paginate(15);
	    }
       
        // $event_list = Events::all();
        // $response['event_list'] = $event_list;

        if($request->input('view') == 'grid_view')
        {
            return view('events.events',$response);
        }
        elseif($request->input('view') == 'list_view')
        {
            return view('events.list',$response);
        }else{
             return view('events.list',$response);
       }
    }

    public function view($id){
        $details = Events::where('id',$id)->first();
        return view('events.view',compact('details'));
    }

    public function update(Request $request)
    {   
        $id=$request->input('id');
        $event_name=$request->input('event_name');
        $event_type=$request->input('event_type');
        $event_level=$request->input('event_level');
        $price=$request->input('price');
        
        $update=Events::where('id', $id)->first();
        $update->event_name=$event_name;
        $update->event_level=$event_level;
        $update->event_type=$event_type;
        $update->price=$price;
        $update->save();
        
        
        return back()->with('success','Successfully added');
        
    }

    public function status($id ,$status)
    {

        DB::enableQueryLog();
        $events=Events::find($id);
        if($status=='active')
        {
            
          $events->status='inactive';
        }
        else
        {
          $events->status='active';
        }
        $events->save();
       //return DB::getQueryLog();
        return redirect()->back()->with('success', 'User Status Changed Successfully.');
    }
}
