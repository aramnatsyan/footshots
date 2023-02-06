<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Events;

class HomeController extends Controller
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
    public function index()
    {  
        $lists_=User::whereRole('user');
        $lists=User::whereRole('user');
        $response['allusers_wd']=$lists_->withTrashed()->count();    
        $response['allusers']=$lists->count();    

        $lists=$lists->whereStatus('active');
        $response['activeusers']=$lists->count();
       
        $response['deletedusers']=$response['allusers_wd']-$response['allusers'] ;
        $response['blockedusers']=$response['allusers']-$response['activeusers'] ;

        $response['lists']=$lists->take('10')->orderBy('id','asc')->get();
        $response['event_lists']=Events::where('status', 'active')->take('10')->orderBy('id','asc')->get();
        $response['allevents']=Events::count();
        $response['active_events']=Events::where('status', 'active')->count();
        $response['block_events']=Events::where('status', 'inactive')->count();
        $response['delete_events']=Events::whereNotNull('deleted_at')->count();
        // return $response;
        return view('home',$response);
    }

    public function web_index()
    {  
        
        $lists_=User::whereRole('user');
        $lists=User::whereRole('user');
        // $response['allusers_wd']=$lists_->withTrashed()->count();    
        $response['allusers']=$lists->count();    
       $response['posts']=Posts::where('status','active')->count();    

        
        return view('welcome',$response);
    }
}
