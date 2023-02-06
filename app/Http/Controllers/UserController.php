<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Events;
use DB;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {  
        // return $request->all();
        $view=$request->view;
        $name=$request->name;
        $from = $request->from;
        $to = $request->to;
        $lists=User::whereRole('user');
        if ($from != '' OR $to != '')
	    {
            $response['lists']=$lists->whereDate('created_at','>=',$from)->whereDate('created_at','<=', $to)->paginate(15);
	    }elseif($name !='')
	    {
            $response['lists']=$lists->where('name', 'like', '%'.$name.'%')->paginate(15);
	    	
	    }
	    else{

		    $response['lists']=$lists->orderBy('id','asc')->paginate(15);
	    }
        
        

        
       
        foreach($response['lists'] as $list){

            $list->total_event = Events::where('user_id', $list->id)->count();
        }
        // return $response;die;

        if($request->input('view') == 'grid_view')
        {
            return view('users.users',$response);
        }
        elseif($request->input('view') == 'list_view')
        {
            return view('users.list',$response);
        }else{
            return view('users.list',$response);
        }
    }

    public function view(Request $request , $id)
    {   
        $response['details']=User::with('getEvents')->whereRole('user')->where('id',$id)->first();
        
        return view('users.view',$response);
        
    }

     public function update(Request $request)
    {   
        $id=$request->input('id');
        $name=$request->input('name');
        $username=$request->input('username');
        $email=$request->input('email');
        
        $update=User::where('id', $id)->first();
        $update->name=$name;
        $update->username=$username;
        $update->email=$email;
        $update->save();
        
        
        return back()->with('success','Successfully added');
        
    }

    public function status($id ,$status)
    {

        DB::enableQueryLog();
        $user=User::find($id);
        if($status=='active')
        {
            
          $user->status='inactive';
        }
        else
        {
          $user->status='active';
        }
        $user->save();
       //return DB::getQueryLog();
        return redirect()->back()->with('success', 'User Status Changed Successfully.');
    }
}
