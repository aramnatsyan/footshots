<?php 



class Message_model extends CI_Model {







  public function __construct()



  {



        // Call the Model constructor



    parent::__construct();

    date_default_timezone_set('UTC');

    $this->db->query('SET time_zone="+00:00"');



    $this->load->model('User_model');  

    $this->load->model('Post_model');  



  }	



function decodeEmoticons($src) {
    $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
 

 function format_interval(DateInterval $interval) {

    $result = "";

    if ($interval->y) { $result = $interval->format("%y y"); }

    else  if ($interval->d) { 



      if($interval->d>7 || $interval->days>7)

      {

         $result = $interval->days; 



         $weeks = floor($result / 7);

        //  $dayRemainder = $result % 7;

         $result = $weeks .' w';



      }

      else

      {

         $result = $interval->format("%d d"); 

      }

  

    }

    else  if ($interval->h) { $result = $interval->format("%h h"); }

    else  if ($interval->i) { $result = $interval->format("%i m"); }

    else  if ($interval->s) { $result = $interval->format("%s s"); }



    return $result;

}





  function create_chat($user1,$user2)

  {

		 	
  	  	date_default_timezone_set('UTC');

	    		$this->db->query('SET time_zone="+00:00"');
			  	$this->db->select('*');
			  	$this->db->from('foot_chats');
			  	$where = "(user1='$user1' and user2='$user2') or (user2='$user1' and user1='$user2')";
			  	$this->db->where($where);
			  	$this->db->where($where);
			    $query = $this->db->get();
			    $result = $query->row();

		    if($result)
		    {
		    	 $chat_id= $result->chat_id;
		    }

		    else

		    {

		    	 		$data = array(                                                      /*An array of data to insert into table*/



					     'user1' => $user1,



					     'user2' => $user2,



					      'last_message' => "",     

					      'chat_name' => "",     

					     'chat_type' => "chat",     

					     

					     'date_of_creation' =>  date('Y-m-d H:i:s'), 



					     'last_update' =>  date('Y-m-d H:i:s'),     

 	

					     );

 

					    $this->db->insert('foot_chats', $data); 



					    $chat_id= $this->db->insert_id();

		    }



		    return $chat_id;

  }



function add_group_member($data)

  {

  	 	$chat_id = $data->chat_id;

  		$member_peoples = $data->member_peoples;



  		 foreach($member_peoples as $members_id) 

			{

				$memberdata = array(                                                      /*An array of data to insert into table*/



			     'chat_id' => $chat_id,



			     'user_id' => $members_id,



			     'member_type' => "member",    



			     'block_group' => "0",      



			     'date_of_creation' =>  date('Y-m-d H:i:s')  



			     );



			    $this->db->insert('foot_chat_member', $memberdata); 

			}



			return 0;

  }



  function edit_group_info($data)

  {

  	 	$chat_id = $data->chat_id;

  		$chat_name = $data->chat_name;

  		$user_id = $data->user_id;



  		$this->db->select('foot_chats.*');

		$this->db->from('foot_chats'); 

		$this->db->where('chat_id',$chat_id);

		$querygrp = $this->db->get(); 

	    $grpresult = $querygrp->row();

	    $re['group_info'] = $grpresult;

	    $chat_type = $grpresult->chat_type;

	     	if($chat_type=='group')

			    {



				  	$this->db->select('foot_chat_member.member_id');

					$this->db->from('foot_chat_member'); 

					$where = "chat_id ='$chat_id' and user_id='$user_id'";

					$this->db->where($where);

					$query = $this->db->get(); 

				    $resultmember = $query->row();

				   

				    if(empty($resultmember))

				    {

				    	  return 600;

				    }

			    }



  		 $data = array(                                                      /*An array of data to insert into table*/

 

		     'chat_name' => $chat_name,    

      

		     );

  		 $this->db->where("chat_id",$chat_id);



		  $this->db->update('foot_chats', $data);  

		  

		 return 0;

  }



  function create_group_chat($data)

  {

		 			
  	     date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  		$chat_name = $data->chat_name;

  		$user_id = $data->user_id;

  		$member_peoples = $data->member_peoples;

			$data = array(                                                      /*An array of data to insert into table*/



		     'user1' => $user_id,



		     'user2' => "",



		     'last_message' => "",    



		     'chat_name' => $chat_name,    



		     'chat_type' => "group",  



		     'date_of_creation' =>  date('Y-m-d H:i:s'), 



		     'last_update' =>  date('Y-m-d H:i:s'),     



		     );



		    $this->db->insert('foot_chats', $data); 



		    $chat_id= $this->db->insert_id();



		    $memberdata = array(                                                      /*An array of data to insert into table*/



		     'chat_id' => $chat_id,



		     'user_id' => $user_id,



		     'member_type' => "admin",    



		     'block_group' => "0",      



		     'date_of_creation' =>  date('Y-m-d H:i:s')  



		     );



		    $this->db->insert('foot_chat_member', $memberdata); 



		    foreach($member_peoples as $members_id) 

			{

				$memberdata = array(                                                      /*An array of data to insert into table*/



			     'chat_id' => $chat_id,



			     'user_id' => $members_id,



			     'member_type' => "member",    



			     'block_group' => "0",      



			     'date_of_creation' =>  date('Y-m-d H:i:s')  



			     );



			    $this->db->insert('foot_chat_member', $memberdata); 

			}

	

		return $chat_id;

  }

   function create_broadcast($data)

  {

		 			
  	     date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  		$chat_name = $data->chat_name;

  		$user_id = $data->user_id;

  		$member_peoples = $data->member_peoples;
  		$chat_name_user = array();

  		foreach($member_peoples as $members_id) 
			{
					      $this->db->select('fullname');   
					$this->db->from('foot_app_users');

					    $this->db->where('user_id',$members_id);

					    $query = $this->db->get();


					    $result = $query->row();

					    $chat_name_user[] = $result->fullname;

			}

			$chat_name = implode(', ', $chat_name_user);
			$data = array(                                                      /*An array of data to insert into table*/



		     'user1' => $user_id,



		     'user2' => "",



		     'last_message' => "",    



		     'chat_name' => $chat_name,    



		     'chat_type' => "broadcast",  



		     'date_of_creation' =>  date('Y-m-d H:i:s'), 



		     'last_update' =>  date('Y-m-d H:i:s'),     



		     );



		    $this->db->insert('foot_chats', $data); 



		    $chat_id= $this->db->insert_id();

   
		    foreach($member_peoples as $members_id) 

			{

				$memberdata = array(                                                      /*An array of data to insert into table*/



			     'chat_id' => $chat_id,



			     'user_id' => $members_id,



			     'member_type' => "member",    



			     'block_group' => "0",      



			     'date_of_creation' =>  date('Y-m-d H:i:s')  



			     );


			    $this->db->insert('foot_chat_member', $memberdata); 

			}

	

		return $chat_id;

  }



  function chat_list($data)
  {		
  	  	     date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  			$user_id = $data->user_id;



  			$post_value = $data->post_value;



		  	$this->db->select('*');

		  	$this->db->from('foot_chats');

		  	$where = "(user1='$user_id' or user2='$user_id') and chat_type='chat' and chat_status='active'  and chat_id not in (SELECT chat_id from foot_chat_delete where user_id='$user_id')";

		  	$this->db->where($where);

		  	$this->db->order_by("last_update",'desc');


		    $this->db->limit(15,$post_value);

		    $query = $this->db->get();



		    $result = $query->result();

		    $re = array();



		    foreach ($result as  $value) {
 

		    		$chat_id = $value->chat_id;

		    		$user2 =  $value->user2;
		    		$user1 =  $value->user1;
 

		    		if($user1==$user_id)	
		    		{

				    $value->user_detail = $this->User_model->user_personal_detail($user2,$user_id);

				 	}



				 	if($user2==$user_id)
		    		{

				    $value->user_detail = $this->User_model->user_personal_detail($user1,$user_id);

				 	}



				 $current_date = date('Y-m-d H:i:s'); 


		          $first_date = new DateTime($value->last_update);

		          $second_date = new DateTime($current_date);


		          $difference = $first_date->diff($second_date);

		          $difference = $this->format_interval($difference);

		          $value->last_update = $difference;

		          $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='".$user_id."' and chat_id='".$chat_id."' and read_status='0' and message_status='active'");
		         

            	  $value->total_unread_message =  $messageuser->num_rows();
 
				  $re[] = $value;
 

		    }	

		    return $re;

  }

  

  function remove_group_member($data)

  {

  		$member_id = $data->member_id;



  		$this->db->where('member_id', $member_id);

      $this->db->delete('foot_chat_member'); 



       return 0;

  }



    function leave_group($data)

  {

  		$chat_id = $data->chat_id;

  		$user_id = $data->user_id;

  		$where = "chat_id='$chat_id' and  user_id='$user_id'";

  		$this->db->where($where);

      $this->db->delete('foot_chat_member'); 



       return 0;

  }



  function delete_group($data)

  {

  		$chat_id = $data->chat_id;

  		$user_id = $data->user_id;

  		$database = array( 

	     'chat_status' => 'delete',   

	     );

  		$where = "chat_id='$chat_id'  ";

  		$this->db->where($where);       

		$this->db->update('foot_chats', $database);



       return 0;

  }

  function delete_broadcast($data)

  {

  		$chat_id = $data->chat_id;

  		$user_id = $data->user_id;

  		$database = array( 

	     'chat_status' => 'delete',   

	     );

  		$where = "chat_id='$chat_id'  ";

  		$this->db->where($where);       

		$this->db->update('foot_chats', $database);



       return 0;

  }



  function group_chat_info($data)

  {		

  	$user_id = $data->user_id;

  	$chat_id = $data->chat_id;



  		$this->db->select('foot_chats.*');

		$this->db->from('foot_chats'); 

		$this->db->where('chat_id',$chat_id);

		$querygrp = $this->db->get(); 

	    $grpresult = $querygrp->row();

	    $re['group_info'] = $grpresult;

	    $chat_type = $grpresult->chat_type;

	     	if($chat_type=='group')

			    {



				  	$this->db->select('foot_chat_member.member_id');

					$this->db->from('foot_chat_member'); 

					$where = "chat_id ='$chat_id' and user_id='$user_id'";

					$this->db->where($where);

					$query = $this->db->get(); 

				    $resultmember = $query->row();

				   

				    if(empty($resultmember))

				    {

				    	  return 600;

				    }

			    }



	  	$this->db->select('foot_chat_member.member_id,foot_chat_member.user_id,foot_app_users.fullname,foot_app_users.profileimage,foot_app_users.profileimage,foot_app_users.profilecover,foot_app_users.username');

		$this->db->from('foot_chat_member');

		$this->db->join('foot_app_users','foot_app_users.user_id = foot_chat_member.user_id');

		$this->db->where('chat_id',$chat_id);

		$query = $this->db->get(); 

	    $result = $query->result();

	    

	    foreach ($result as   $value)

	    {

	    		 $value->user_detail = $this->User_model->user_personal_detail($value->user_id,$user_id);

	    }



	    $re['members'] = $result;

	     return $re;



  }	



  function group_chat_list($data)

  {		

  	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  			$user_id = $data->user_id;



  			$post_value = $data->post_value;



		  	$this->db->select('*');

		  	$this->db->from('foot_chats');

		  	$where = " chat_status='active' and  chat_type='group' and foot_chats.chat_id in (select foot_chat_member.`chat_id` from `foot_chat_member`  where foot_chat_member.user_id='$user_id' )";

		  	$this->db->where($where);

		  	$this->db->order_by("last_update",'desc');

		    $this->db->limit(15,$post_value);

		    $query = $this->db->get();

 

		    $result = $query->result();

		    $re = array();



		    foreach ($result as  $value) {


		    			$chat_id=$value->chat_id;

		    			$user1 = $value->user1;

		    			$user2 =  $value->user2;
 
				 	    $current_date = date('Y-m-d H:i:s'); 
 

			          $first_date = new DateTime($value->last_update);

			          $second_date = new DateTime($current_date);



			          $difference = $first_date->diff($second_date);

			          $difference = $this->format_interval($difference);

			          $value->last_update = $difference;

			           $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='".$user_id."' and chat_id='".$chat_id."' and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
		         

            	      $value->total_unread_message =  $messageuser->num_rows();
 
				 	  $re[] = $value;
 
 
		    }	

		    return $re;

  }
  function broadcast_list($data)
  {		

  	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  			$user_id = $data->user_id;



  			$post_value = $data->post_value;



		  	$this->db->select('*');

		  	$this->db->from('foot_chats');

		  	$where = " chat_status='active' and chat_type='broadcast' and user1='$user_id' ";

		  	$this->db->where($where);

		  	$this->db->order_by("last_update",'desc');

		    $this->db->limit(15,$post_value);

		    $query = $this->db->get();

		    $result = $query->result();

		    $re = array();



		    foreach ($result as  $value) {


		    			$user1 = $value->user1;

		    			$user2 =  $value->user2;


				 	    $current_date = date('Y-m-d H:i:s'); 



		          $first_date = new DateTime($value->last_update);

		          $second_date = new DateTime($current_date);



		          $difference = $first_date->diff($second_date);

		          $difference = $this->format_interval($difference);

		          $value->last_update = $difference;
 
				 	$re[] = $value;
 
		    }	

		    return $re;

  }





   function delete_message($data)

  {

  	$message_id = $data->message_id;

  	$user_id = $data->user_id;



  				$this->db->select('*');

		  	$this->db->from('foot_chat_message');

		  	$where = "message_id='$message_id' ";

		  	$this->db->where($where);



		  	 $this->db->where($where);



		     $query = $this->db->get();





		    $result = $query->row();



		    if($result)

		    {

		    		$chat_id = $result->chat_id;

		    		$from_id = $result->from_id;



		    		if($from_id==$user_id)

		    		{	

		    			 $data = array( 



						     'message_status' => 'delete',    



						     );



						    $this->db->where('message_id', $message_id); 



						    $this->db->update('foot_chat_message', $data);
 


						    $this->db->select('*');

						   

						    $this->db->from('foot_chat_message');

						  

						    $where = "chat_id='$chat_id' and message_status='active'";

						 

						    $this->db->where($where);



						    $this->db->order_by("message_id",'desc');

						   

						     $query = $this->db->get(); 
				    		$result = $query->row();

				    	if($result)
 						
 						{


				    		if($result->message_type=='timeline')

				    		{

				    			$Notitext="Shared a post";

				    		}
				    		if($result->message_type=='image')

				    		{

				    			$Notitext="Shared an image";

				    		}

				    		else

				    		{

				    			$Notitext=$result->chat_message;

				    		}



					    	$data = array( 



						     'last_message' => $Notitext,

						     'last_message_id' => $result->message_id,



						     'last_update' =>  date('Y-m-d H:i:s'),     



						     );



						    $this->db->where('chat_id', $chat_id); 



						    $this->db->update('foot_chats', $data);

						   }
				    	else
				    	{
				    		$Notitext="";
				    		$data = array( 



						     'last_message' =>"",
 



						     'last_update' =>  date('Y-m-d H:i:s'),     



						     );



						    $this->db->where('chat_id', $chat_id); 



						    $this->db->update('foot_chats', $data);
				    	}




						   



						    return 0;

					}

					else

					{

							$data = array( 



						     'message_status' => 'sender',    



						     );



						    $this->db->where('message_id', $message_id); 



						    $this->db->update('foot_chat_message', $data);





						    $this->db->select('*');

						  	$this->db->from('foot_chats');

						  	$where = "chat_id='$chat_id' ";

						  	$this->db->where($where);



						  	 $this->db->where($where);



						     $query = $this->db->get();



						    $result = $query->row();



						    $last_message_id = $result->last_message_id;



						    if($last_message_id==$message_id)

						    {

						    	$this->db->select('*');

						   

							    $this->db->from('foot_chat_message');

							  

							    $where = "chat_id='$chat_id' and message_status='active'";

							 

							    $this->db->where($where);



							    $this->db->order_by("message_id",'desc');

							   

							     $query = $this->db->get();





					    		$result = $query->row();



					    		 



					    		if($result->message_type=='timeline')

					    		{

					    			$Notitext="Shared a post";

					    		}

					    		else

					    		{

					    			$Notitext=$result->chat_message;

					    		}



						    	$data = array( 



							     'last_message' => $Notitext,

							     'last_message_id' => $result->message_id,

							     'last_update' =>  date('Y-m-d H:i:s'),     



							     );



							    $this->db->where('chat_id', $chat_id); 



							    $this->db->update('foot_chats', $data);



						    }

						    return 0;



					}



		    }



		    return 300;

  }



  function delete_chat($data)

  {
  	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  	$from_id = $data->from_id;

  	$to_id = $data->to_id;

  	$user_id = $data->user_id;



  				$this->db->select('*');

		  	$this->db->from('foot_chats');

		  	$where = "(user1='$from_id' and user2='$to_id') or (user2='$from_id' and user1='$to_id')";

		  	$this->db->where($where);



		  	 $this->db->where($where);



		     $query = $this->db->get();





		    $result = $query->row();



		   	   



		    if($result)

		    {

		    		$chat_id = $result->chat_id;





				    $this->db->select('*');

				   

				    $this->db->from('foot_chat_delete');

				  

				    $where = "chat_id='$chat_id' and user_id='$user_id'";

				 

				    $this->db->where($where); 

				   

				     $query = $this->db->get(); 



		    		$result = $query->row();



		    		if($result)

		    		{

		    			$delete_id = $result->delete_id;



		    			 $data = array( 



					     'date_of_action' =>  date('Y-m-d H:i:s'),     



					     );



					    $this->db->where('delete_id', $delete_id); 



					    $this->db->update('foot_chat_delete', $data); 



					    $data = array( 



					     'date_of_action' =>  date('Y-m-d H:i:s'),     



					     );



					     $where = "chat_id='$chat_id' and user_id='$user_id'";



					    $this->db->where($where); 



					    $this->db->update('foot_chat_message_delete', $data); 



		    		}

		    		else

		    		{

		    			 $data = array(                                                      /*An array of data to insert into table*/



					     'chat_id' => $chat_id,

					     

					     'user_id' => $from_id,



					     'date_of_action' =>  date('Y-m-d H:i:s'),     



					     );



					    $this->db->insert('foot_chat_delete', $data);



					     $data = array(                                                      /*An array of data to insert into table*/



					     'chat_id' => $chat_id,

					     

					     'user_id' => $from_id,

					     

					     'date_of_action' =>  date('Y-m-d H:i:s'),     



					     );



					    $this->db->insert('foot_chat_message_delete', $data);



		    		}



			    	 



				    return 0;



		    }



		    return 300;

  }



  function send_broadcast_message($data)
  {

  	 		date_default_timezone_set('UTC');
    		$this->db->query('SET time_zone="+00:00"'); 

		  	$chat_id = $data->chat_id;	  

			  	$user_id = $data->user_id;

			  	$from_id = $data->from_id;

			  	$this->db->select('*');

			  	$this->db->from('foot_chats');

			  	$where = "(chat_id='$chat_id' )";

			  	$this->db->where($where);

  			    $query = $this->db->get(); 

			    $result = $query->row();

			    $chat_type = $result->chat_type;

			  	$message_type = $data->message_type;

			  	$message_text = $data->message_text;

			 if($message_type=='timeline')
			  	{
			  	  $timeline_id = $data->timeline_id;
			  	  $Notitext = "Shared a post";
			  	}
			  	 else if($message_type=='image')
			  	{
			  	  $timeline_id = "";
			  	  $Notitext = "Shared an image";
			  	}
			  	else
			  	{
		  		$timeline_id = "";	
		  		$Notitext = $message_text;
		  		preg_match_all('/(?<!\w)#\w+/',$message_text,$matches);
           foreach ($matches[0] as   $values) {
             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$values' ");
              $resultTage = $query->row();
	              if($resultTage)
	              {
	                $tag_id = $resultTage->user_id;
	              }else{
	                 $datahash = array(                                                      /*An array of data to insert into table*/
	                 'useremail' => '',
	                 'fullname' => $values,     
	                 'password' => "",
	                 'profileimage' => "",
	                 'status' =>'Active',
	                 'user_type' =>'tag',
	                 'date_of_creation'=> date('Y-m-d H:i:s'),
	                 'login_token' => "tags",
	                 'device_type'=> '',
	                 'device_token' => '' 
	                 ); 
	                $this->db->insert('foot_app_users', $datahash);                             /* insert data into table*/  
	                $tag_id = $this->db->insert_id();                               /* Get insert id*/

	              }                               

	           }

		  	}



		  	$datas = array(                                                      /*An array of data to insert into table*/
			     'chat_id' => $chat_id,
			     'from_id' => $from_id,
			     'to_id' =>0,
			     'timeline_id' => $timeline_id,
			     'chat_message' => $message_text,
			     'message_status' => "active",  
			     'read_status' => "0",  
			     'message_type' => $message_type,     
			     'date_of_message' =>  date('Y-m-d H:i:s'),    
		     );

		    $this->db->insert('foot_chat_message', $datas); 
		    $message_id = $this->db->insert_id();
		    if($message_id)
		    {	
		     			$this->db->select('*');
					    $this->db->from('foot_chat_message');
					    $where = "message_id='$message_id'";
					    $this->db->where($where);
					    $query = $this->db->get();
					    $resultQueryBroad = $query->row();
					    $resultQueryBroad->user_detail = $this->User_model->single_users_detail($user_id);

					      if($resultQueryBroad->message_type=='image')
					    {
					    	$resultQueryBroad->chat_message=base_url().$resultQueryBroad->chat_message;
					    }

					    $datachatBroad = array( 
						     'last_message' => $Notitext,
						     'last_message_id' => $chat_id,
						     'last_update' =>  date('Y-m-d H:i:s'),   
						     );
							 $this->db->where('chat_id', $chat_id); 
							 $this->db->update('foot_chats', $datachatBroad);
				  	$this->db->select('foot_app_users.*');
					$this->db->from('foot_chat_member'); 
					$this->db->join('foot_app_users','foot_app_users.user_id = foot_chat_member.user_id'); 
					$where = "chat_id ='$chat_id' ";
					$this->db->where($where);
					$query = $this->db->get();   
				    $resultmember = $query->result();
				    foreach ($resultmember as   $valueMember) 
				    {
				    	$chat_id_new = "";
				    		$to_id = $valueMember->user_id;
					    	$this->db->select('*');
						  	$this->db->from('foot_chats');
						  	$where = "(user1='$from_id' and user2='$to_id') or (user2='$from_id' and user1='$to_id')";
						  	$this->db->where($where); 
   					        $query = $this->db->get();
						    $result = $query->row(); 
						    if($result)
						    {
						    	  $chat_id_new = $result->chat_id;

						    }

						  	if(empty($chat_id_new))
						  	{
						  	 	    $chat_id_new = $this->create_chat($from_id,$to_id);
 
						  	}
				    		$datamessage = array(                          /*An array of data to insert into table*/
						     'chat_id'          => $chat_id_new,
						     'from_id'          => $from_id, 
						     'to_id'            =>$to_id,						  
						     'timeline_id'      => $timeline_id,
						     'chat_message'     => $message_text,
						     'message_status'   => "active",  
						     'read_status' => "0",
						     'message_type'     => $message_type,   
						     'date_of_message'  =>  date('Y-m-d H:i:s'),  
						     );
				    		//print_r($datamessage);
						    $this->db->insert('foot_chat_message', $datamessage); 

						    // echo $this->db->last_query();die();

						    $newmessageId  = $this->db->insert_id();
						    $datachat = array( 
								     'last_message' => $message_text,
								     'last_message_id' => $newmessageId,
								     'last_update' =>  date('Y-m-d H:i:s'),   
								     );

							 $this->db->where('chat_id', $chat_id_new); 
							 $this->db->update('foot_chats', $datachat); 
							 $this->db->select('*');					
						     $this->db->from('foot_chat_message');
						     $where = "message_id='$newmessageId'";				
						     $this->db->where($where);
						     $query = $this->db->get();
					    	 $result = $query->row();
					    	 $result->user_detail = $this->User_model->user_personal_detail($from_id,$to_id);
						  if($timeline_id!="")
						   {
						   		$result->timeline_detail =  $this->Post_model->timeline_detail_for($timeline_id,$user_id);
					       }
					           $NotificationUserDetail = $this->User_model->single_users_detail($to_id);
						   $device_type =  $NotificationUserDetail->device_type;
						   $device_token =  $NotificationUserDetail->device_token;
						   $message = $this->decodeEmoticons($result->user_detail['fullname'].": ".$Notitext);
						   $action = "chat_detail";
						   $value['user_id'] = $from_id;
						   $value['other_user_id'] = $to_id;
						   $value['new_message'] =$result;
						   $value['other_user_name'] = $result->user_detail['fullname'];
				           $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$to_id' and read_status='0' and notification_status='active'");

		                   $total_unread_notification =  $notificunser->num_rows();
		                   $value['total_unread_notification'] =$total_unread_notification;


		                   $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='$to_id' and read_status='0' and message_status='active'");

			            $total_unread_message =  $messageuser->num_rows();

			              $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='$to_id' and chat_id in (select chat_id from foot_chat_member where user_id='".$to_id."' ) and chat_id in (select chat_id from foot_chats where chat_status='active' and  chat_type='group') and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
			             

			              $total_group_unread_message =  $messageuser->num_rows();

			               $value['total_unread_message'] =$total_unread_message+$total_group_unread_message;

					       $badge = 1;

                         $badge = $NotificationUserDetail->badge+1;

                         $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                          $this->db->query($sql);



					   if($device_type=='ios')

					   {

					    	send_message_ios($device_token,$message,$badge,$action,$value);

					   }

					   if($device_type=='android')

					   {

					      	send_notification_android($device_token,$message,$action,$value);

					   }



					   	 date_default_timezone_set('UTC');

    					 $this->db->query('SET time_zone="+00:00"');



					       $data = array(  



	                         'user_id' => $NotificationUserDetail->user_id,



	                         'from_id' => $from_id,     



	                         'timeline_id' => $to_id,



	                         'notification_type' =>  "new_message",

	                     

	                         'read_status' =>'0',



	                         'date_of_notification'=> date('Y-m-d H:i:s'), 



	                        );
	 

	                  //      $this->db->insert('foot_notification', $data);
				    }

				 

				return $resultQueryBroad;

		   }



		   else

		   {

		   			return 300;

		   }
 
  
  }
  function send_message($data)

  {

  	 		date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');



  			$from_id = $data->from_id;

		  	

		  	$to_id = $data->to_id;



		  	$chat_id = $data->chat_id;

		  	

		  	if(!empty($to_id))

		  	{



			  	$this->db->select('*');

			  	$this->db->from('foot_chats');

			  	$where = "(user1='$from_id' and user2='$to_id') or (user2='$from_id' and user1='$to_id')";

			  	$this->db->where($where);

 



			     $query = $this->db->get();





			    $result = $query->row();



			    if($result)

			    {

			    	$chat_id = $result->chat_id;

			    }

		



			  	if(empty($chat_id))

			  	{

			  	 	$chat_id = $this->create_chat($from_id,$to_id);

			  	}

			 }



			  	$user_id = $data->user_id;

			  	$this->db->select('*');

			  	$this->db->from('foot_chats');

			  	$where = "(chat_id='$chat_id' )";

			  	$this->db->where($where);

  

			     $query = $this->db->get(); 

			    $result = $query->row();

			    $chat_type = $result->chat_type;
			    $chat_name = $result->chat_name;



			    if($chat_type=='group')

			    {



				  	$this->db->select('foot_chat_member.member_id');

					$this->db->from('foot_chat_member'); 

					$where = "chat_id ='$chat_id' and user_id='$user_id'";

					$this->db->where($where);

					$query = $this->db->get(); 

				    $resultmember = $query->row();

				   

				    if(empty($resultmember))

				    {

				    	  return 600;

				    }

			    }

			 

			  	

			  	$message_type = $data->message_type;



			  	$message_text = $data->message_text;



			  	if($message_type=='timeline')

			  	{

			  	  	$timeline_id = $data->timeline_id;



			  	  	$Notitext = "Shared a post";

			  	}
			  	else if($message_type=='image')

			  	{
 					$timeline_id = "";	

			  	  	$Notitext = "Shared an image";

			  	}

			  	else

			  	{

		  		$timeline_id = "";	



		  		$Notitext = $message_text;



		  		preg_match_all('/(?<!\w)#\w+/',$message_text,$matches);

 

           foreach ($matches[0] as   $values) {



             $query  = $this->db->query("SELECT * FROM foot_app_users WHERE fullname COLLATE latin1_general_cs = '$values' ");



              $resultTage = $query->row();



	              if($resultTage)

	              {

	                $tag_id = $resultTage->user_id;

	              }

	              else

	              {



	                 $datahash = array(                                                      /*An array of data to insert into table*/



	                 'useremail' => '',



	                 'fullname' => $values,     



	                 'password' => "",



	                 'profileimage' => "",

	             

	                 'status' =>'Active',



	                 'user_type' =>'tag',



	                 'date_of_creation'=> date('Y-m-d H:i:s'), 



	                  'login_token' => "tags",



	                  'device_type'=> '',



	                  'device_token' => '' 



	                 ); 



	                $this->db->insert('foot_app_users', $datahash);                             /* insert data into table*/  

	                $tag_id = $this->db->insert_id();                               /* Get insert id*/

	              }



	              

	                                            

	           }

		  	}



		  	$data = array(                                                      /*An array of data to insert into table*/



		     'chat_id' => $chat_id,

		     

		     'from_id' => $from_id,

		     

		     'to_id' => $to_id,

		     

		     'timeline_id' => $timeline_id,

		     

		     'chat_message' => $message_text,
		     'chat_message_copy' => $message_text,



		     'message_status' => "active",  

		     'read_status' => "0",

		     'message_type' => $message_type,    

		     

		     'date_of_message' =>  date('Y-m-d H:i:s'),     



		     );



		    $this->db->insert('foot_chat_message', $data); 



		    $message_id = $this->db->insert_id();



		    if($message_id)

		    {
		    	if($chat_type=='group')
		    	{
		    		date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');
    		
		    		$data = array( 



					     'last_message' => $Notitext,



					     'last_message_id' => $message_id,



					     'last_update' =>  date('Y-m-d H:i:s'),     



					     );



					    $this->db->where('chat_id', $chat_id); 



					    $this->db->update('foot_chats', $data); 



					    $this->db->where('chat_id', $chat_id); 


					    $this->db->select('foot_chats.*');

			              $this->db->from('foot_chats'); 

			              $this->db->where('chat_id',$chat_id);

			              $querygrp = $this->db->get(); 

			                $grpresult = $querygrp->row();



					  	$this->db->select('foot_app_users.*');

						$this->db->from('foot_chat_member'); 

						$this->db->join('foot_app_users','foot_app_users.user_id = foot_chat_member.user_id');

						$where = "chat_id ='$chat_id' and foot_app_users.user_id!='$user_id'";

						$this->db->where($where);

						$query = $this->db->get(); 

					    $resultmember = $query->result();

					    foreach ($resultmember as  $NotificationUserDetail) {	


					    	 $data = array(  



                         'user_id' => $NotificationUserDetail->user_id,



                         'from_id' => $user_id,     



                         'timeline_id' => $chat_id,



                         'notification_type' =>  "new_group_message",

                     

                         'read_status' =>'0',



                         'date_of_notification'=> date('Y-m-d H:i:s'), 



                        );

 



					    	# code...
					   	$to_id = $NotificationUserDetail->user_id;
					   	  //$this->db->insert('foot_notification', $data);  

                        
					    $this->db->select('*');

					   

					    $this->db->from('foot_chat_message');

					  

					    $where = "message_id='$message_id'";

					 

					    $this->db->where($where);

					

					    $query = $this->db->get();



					    $result = $query->row();



					    $result->user_detail = $this->User_model->user_personal_detail($from_id,$to_id);



					   if($timeline_id!="")

					   {

					   		$result->timeline_detail =  $this->Post_model->timeline_detail_for($timeline_id,$user_id);

					   }

						    /*  $result->user_detail = $this->User_model->user_personal_detail($from_id,$to_id);*/



						   $device_type =  $NotificationUserDetail->device_type;

						   $device_token =  $NotificationUserDetail->device_token;

						   $message = $this->decodeEmoticons("Group : ".$chat_name." :".$result->user_detail['fullname'].": ".$Notitext);

						   $action = "group_chat_detail";

						   $value['user_id'] = $from_id;

						   $value['other_user_id'] = $chat_id;

						   $value['new_message'] =$result;

						   $value['other_user_name'] = $grpresult->chat_name;



						         $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$to_id' and read_status='0' and notification_status='active'");

				                 $total_unread_notification =  $notificunser->num_rows();

				                 $value['total_unread_notification'] =$total_unread_notification;

				                 $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='$to_id' and read_status='0' and message_status='active'");

			            $total_unread_message =  $messageuser->num_rows();

			              $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='$to_id' and chat_id in (select chat_id from foot_chat_member where user_id='".$to_id."' ) and chat_id in (select chat_id from foot_chats where chat_status='active' and  chat_type='group') and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
			             

			              $total_group_unread_message =  $messageuser->num_rows();

			               $value['total_unread_message'] =$total_unread_message+$total_group_unread_message;





						   $badge = 1;

						   $badge = $NotificationUserDetail->badge+1;

                         $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                          $this->db->query($sql);



						   if($device_type=='ios')

						   {

						    	send_message_ios($device_token,$message,$badge,$action,$value);

						   }

						   if($device_type=='android')

						   {

						      	send_notification_android($device_token,$message,$action,$value);

						   }


					    }
		    	}
		    	if($chat_type=='chat')

		    	{

			    		$data = array( 



					     'last_message' => $Notitext,



					     'last_message_id' => $message_id,



					     'last_update' =>  date('Y-m-d H:i:s'),     



					     );



					    $this->db->where('chat_id', $chat_id); 



					    $this->db->update('foot_chats', $data); 



					    $this->db->where('chat_id', $chat_id); 



					    $this->db->delete('foot_chat_delete'); 







					    $this->db->select('*');

					   

					    $this->db->from('foot_chat_message');

					  

					    $where = "message_id='$message_id'";

					 

					    $this->db->where($where);

					

					    $query = $this->db->get();



					    $result = $query->row();



 						 
                          if($result->message_type=='image')
					    {
					    	$result->chat_message=base_url().$result->chat_message;
					    }
					    


					    $result->user_detail = $this->User_model->user_personal_detail($from_id,$to_id);



					   if($timeline_id!="")

					   {

					   		$result->timeline_detail =  $this->Post_model->timeline_detail_for($timeline_id,$user_id);

					   }

					     

					    $NotificationUserDetail = $this->User_model->single_users_detail($to_id);



					   $device_type =  $NotificationUserDetail->device_type;

					   $device_token =  $NotificationUserDetail->device_token;

					   $message = $this->decodeEmoticons($result->user_detail['fullname'].": ".$Notitext);

					   $action = "chat_detail";

					   $value['user_id'] = $from_id;

					   $value['other_user_id'] = $to_id;

					   $value['new_message'] =$result;

					   $value['other_user_name'] = $result->user_detail['fullname'];



					         $notificunser = $this->db->query("SELECT * FROM foot_notification where user_id='$to_id' and read_status='0' and notification_status='active'");

			                 $total_unread_notification =  $notificunser->num_rows();

			                 $value['total_unread_notification'] =$total_unread_notification;


			                 $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='$to_id' and read_status='0' and message_status='active'");

			            $total_unread_message =  $messageuser->num_rows();

			              $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='$to_id' and chat_id in (select chat_id from foot_chat_member where user_id='".$to_id."' ) and chat_id in (select chat_id from foot_chats where chat_status='active' and  chat_type='group') and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
			             

			              $total_group_unread_message =  $messageuser->num_rows();

			               $value['total_unread_message'] =$total_unread_message+$total_group_unread_message;





					   $badge = 1;

					    $badge = $NotificationUserDetail->badge+1;

                         $sql = 'update foot_app_users set badge='.$badge.' where user_id='.$NotificationUserDetail->user_id;
                          $this->db->query($sql);



					   if($device_type=='ios')

					   {

					    	send_message_ios($device_token,$message,$badge,$action,$value);

					   }

					   if($device_type=='android')

					   {

					      	send_notification_android($device_token,$message,$action,$value);

					   }



					   	   date_default_timezone_set('UTC');

    					 $this->db->query('SET time_zone="+00:00"');



				       $data = array(  



                         'user_id' => $NotificationUserDetail->user_id,



                         'from_id' => $from_id,     



                         'timeline_id' => $to_id,



                         'notification_type' =>  "new_message",

                     

                         'read_status' =>'0',



                         'date_of_notification'=> date('Y-m-d H:i:s'), 



                        );



                     



                       // $this->db->insert('foot_notification', $data);  

 						 return $result;

                      }



                       $this->db->select('*');

					   

					    $this->db->from('foot_chat_message');

					  

					    $where = "message_id='$message_id'";

					 

					    $this->db->where($where);

					

					    $query = $this->db->get();



					    $result = $query->row();

					    if($result->message_type=='image')
					    {
					    	$result->chat_message=base_url().$result->chat_message;
					    }
					    

					    $result->user_detail = $this->User_model->single_users_detail($user_id);



					    $data = array( 



					     'last_message' => $Notitext,



					     'last_message_id' => $message_id,



					     'last_update' =>  date('Y-m-d H:i:s'),     



					     );



					    $this->db->where('chat_id', $chat_id); 



					    $this->db->update('foot_chats', $data); 

					     /*
                          if($result->message_type=='image')
					    {
					    	$result->chat_message=base_url().$result->chat_message;
					    }*/

				    return $result;

		   }



		   else

		   {

		   			return 300;

		   }

		  	





  }


function new_message_list($data)

   {

   	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  		  	$chat_id = $data->chat_id;	 	

  		  	$user_id = $data->user_id;	 	

  		  	$other_user_id = $data->other_user_id;	 	

  		  	$post_value = $data->post_value;	



  			$this->db->select('foot_chats.*');

			$this->db->from('foot_chats'); 

			$this->db->where('chat_id',$chat_id);

			$querygrp = $this->db->get(); 

		    $grpresult = $querygrp->row();

		    // print_r($grpresult);die();

		    $re['group_info'] = $grpresult;

		    $chat_type = $grpresult->chat_type;

		     	if($chat_type=='group')

				    {



					  	$this->db->select('foot_chat_member.member_id');

						$this->db->from('foot_chat_member'); 

						$where = "chat_id ='$chat_id' and user_id='$user_id'";

						$this->db->where($where);

						$query = $this->db->get(); 

					    $resultmember = $query->row();

					   

					    if(empty($resultmember))

					    {

					    	  return 600;

					    }

				    }

		  	



		  	 $this->db->select('*');

		   

		    $this->db->from('foot_chat_message_delete');

		  

		    $where = "chat_id='$chat_id' and user_id='$user_id'";

		 

		    $this->db->where($where); 

		

		    $query = $this->db->get();



		    $olddeleteresult = $query->row();





		      	$where = ""; 



		    if($olddeleteresult)

		    {

		    	$nextime = $olddeleteresult->date_of_action;

		    	$where = 	" and date_of_message > '$nextime'";

		    }

 


		    $this->db->select('*');

		   

		    $this->db->from('foot_chat_message');

		  

		    $where = "chat_id='$chat_id' and message_status!='delete'   ".$where;



		    $where .= " and case when message_status='sender' then from_id='$user_id' else true end ";

		 

		    $this->db->where($where);

		    $this->db->order_by("message_id",'desc');

		    $this->db->limit(15,$post_value);

		

		    $query = $this->db->get();

		     


		    $result = $query->result();

		 



		    $re = array();



		    foreach ($result as   $value) {

		    	$message_id = $value->message_id;


		    	if($chat_type=='chat')
		    	{
			    		 $datachatupdate = array(                                                      /*An array of data to insert into table*/  

					     'read_status' => "1",    
	  
					     );

			    	  $where ="chat_id='".$chat_id."' and to_id='$user_id'";
			  		  $this->db->where($where); 
					  $this->db->update('foot_chat_message', $datachatupdate);  
		    	}
		    	if($chat_type=='group')
		    	{
			    		 
			    		 $this->db->select('foot_read_group_message.*');

						$this->db->from('foot_read_group_message');
						$where = "chat_id='".$chat_id."' and message_id='".$message_id."' and user_id='".$user_id."'" ;

						$this->db->where($where);

						$querygrp = $this->db->get(); 

					    $grpresultmeeage = $querygrp->row();

					    if(empty($grpresultmeeage))
					    {
			   			 	$dataGroupMessage = array(    
						     'chat_id' => $chat_id, 

						     'message_id' => $message_id, 

						      'user_id' => $user_id,        
	   
						     'date_of_creation' =>  date('Y-m-d H:i:s') 	

						     );	 

						    $this->db->insert('foot_read_group_message', $dataGroupMessage); 
						}
 
		    	}
		    		
		    		 

		    	$from_id = $value->from_id;



		    	$to_id = $value->to_id;



		    	$timeline_id = $value->timeline_id;

		    	

		    	$message_type = $value->message_type;



		    	if($from_id > 0 && $to_id>0)

		    	{



		    		if($from_id==$user_id)

		    		{



				     $value->user_detail = $this->User_model->user_personal_detail($to_id,$from_id);

				 	}



				 	if($to_id==$user_id)

		    		{



				     $value->user_detail = $this->User_model->user_personal_detail($from_id,$to_id);

				 	}

				 }

				 else

				 {

				 	 $value->user_detail = $this->User_model->user_personal_detail($from_id,$user_id);

				 }

			 		if($timeline_id!="0" && $message_type=='timeline')

				    {

				   		$value->timeline_detail =  $this->Post_model->timeline_detail_for($timeline_id,$user_id);

				    }
					if($message_type=='image')

				    {

				   		$value->message_text =  base_url().$value->message_text; 

				    }

				   



				    $re[] = $value;

 

		    }





		    return $re;

		  	





  
   }
    function message_list($data)

   {
   	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  		  	$chat_id = $data->chat_id;	 	

  		  	$user_id = $data->user_id;	 	

  		  	$other_user_id = $data->other_user_id;	 	

  		  	$post_value = $data->post_value;	



  			$this->db->select('foot_chats.*');

			$this->db->from('foot_chats'); 

			$this->db->where('chat_id',$chat_id);

			$querygrp = $this->db->get(); 

		    $grpresult = $querygrp->row();

		    // print_r($grpresult);die();

		    $re['group_info'] = $grpresult;

		    $chat_type = $grpresult->chat_type;

		     	if($chat_type=='group')

				    {
 

					  	$this->db->select('foot_chat_member.member_id');

						$this->db->from('foot_chat_member'); 

						$where = "chat_id ='$chat_id' and user_id='$user_id'";

						$this->db->where($where);

						$query = $this->db->get(); 

					    $resultmember = $query->row();

					   

					    if(empty($resultmember))

					    {

					    	  return 600;

					    }

				    }

		  	



		  	 $this->db->select('*');

		   

		    $this->db->from('foot_chat_message_delete');

		  

		    $where = "chat_id='$chat_id' and user_id='$user_id'";

		 

		    $this->db->where($where); 

		

		    $query = $this->db->get();



		    $olddeleteresult = $query->row();





		      	$where = ""; 



		    if($olddeleteresult)

		    {

		    	$nextime = $olddeleteresult->date_of_action;

		    	$where = 	" and date_of_message > '$nextime'";

		    }

 


		    $this->db->select('*');

		   

		    $this->db->from('foot_chat_message');

		  

		    $where = "chat_id='$chat_id' and message_status!='delete'   ".$where;



		    $where .= " and case when message_status='sender' then from_id='$user_id' else true end ";

		 

		    $this->db->where($where);

		    $this->db->order_by("message_id",'desc');

		    $this->db->limit(15,$post_value);

		

		    $query = $this->db->get(); 


		    $result = $query->result();

		  
		    $re = array();
 

		    foreach ($result as   $value) {
		    	$message_id = $value->message_id;


		    	if($chat_type=='chat')
		    	{
			    		 $datachatupdate = array(                                                      /*An array of data to insert into table*/  

					     'read_status' => "1",    
	  
					     );

			    	  $where ="chat_id='".$chat_id."' and to_id='$user_id'";
			  		  $this->db->where($where); 
					  $this->db->update('foot_chat_message', $datachatupdate);  
		    	}
		    	if($chat_type=='group')
		    	{
			    		 
			    		 $this->db->select('foot_read_group_message.*');

						$this->db->from('foot_read_group_message');
						$where = "chat_id='".$chat_id."' and message_id='".$message_id."' and user_id='".$user_id."'" ;

						$this->db->where($where);

						$querygrp = $this->db->get(); 

					    $grpresultmeeage = $querygrp->row();

					    if(empty($grpresultmeeage))
					    {
			   			 	$dataGroupMessage = array(    
						     'chat_id' => $chat_id, 

						     'message_id' => $message_id, 

						      'user_id' => $user_id,        
	   
						     'date_of_creation' =>  date('Y-m-d H:i:s') 	

						     );	 

						    $this->db->insert('foot_read_group_message', $dataGroupMessage); 
						}
 
		    	}
		    		 

		    	$from_id = $value->from_id;



		    	$to_id = $value->to_id;



		    	$timeline_id = $value->timeline_id;

		    	

		    	$message_type = $value->message_type;



		    	if($from_id > 0 && $to_id>0)

		    	{



		    		if($from_id==$user_id)

		    		{



				     $value->user_detail = $this->User_model->user_personal_detail($to_id,$from_id);

				 	}
				 	else
				 	{
				 		 $value->user_detail = $this->User_model->user_personal_detail($from_id,$to_id);
				 	}



				 	if($to_id==$user_id)

		    		{



				     $value->user_detail = $this->User_model->user_personal_detail($from_id,$to_id);

				 	}

				 }

				 else

				 {

				 	 $value->user_detail = $this->User_model->user_personal_detail($from_id,$user_id);

				 }

			 		if($timeline_id!="0" && $message_type=='timeline')

				    {

				   	 $value->timeline_detail =  $this->Post_model->timeline_detail_for($timeline_id,$user_id);

				    }

				    	if($message_type=='image')

				    {

				   		$value->chat_message =  base_url().$value->chat_message; 

				    }

				   



				    $re[] = $value;

 

		    }





		    return $re;

		  	





  }



   function search_chat_list($data)

  {		
  	  	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  			$user_id = $data->user_id;



  			$post_value = $data->post_value;

  			$search_text = $data->search_text;



		    $query = $this->db->query("SELECT foot_chats.* from foot_chats LEFT JOIN foot_app_users as fuser on fuser.user_id = foot_chats.user1 LEFT JOIN foot_app_users as suser on suser.user_id = foot_chats.user2 where  chat_type='chat' and  (foot_chats.user1='$user_id' or foot_chats.user2='$user_id') and (fuser.fullname LIKE '%$search_text%' or suser.fullname LIKE '%$search_text%' )  and chat_status='active' order by foot_chats.last_update desc LIMIT $post_value,15");



		    $result = $query->result();

		    $re = array();



		    foreach ($result as  $value) {


$chat_id = $value->chat_id;
		    			$user1 = $value->user1;

		    			$user2 =  $value->user2;





		    		if($user1==$user_id)	

		    		{



				     $value->user_detail = $this->User_model->user_personal_detail($user2,$user_id);

				 	}



				 	if($user2==$user_id)

		    		{



				     $value->user_detail = $this->User_model->user_personal_detail($user1,$user_id);

				 	}



				 	    $current_date = date('Y-m-d H:i:s'); 



		          $first_date = new DateTime($value->last_update);

		          $second_date = new DateTime($current_date);



		          $difference = $first_date->diff($second_date);

		          $difference = $this->format_interval($difference);

		          $value->last_update = $difference;



				    $messageuser = $this->db->query("SELECT * FROM foot_chat_message where to_id='".$user_id."' and chat_id='".$chat_id."' and read_status='0' and message_status='active'");
		         

            	  $value->total_unread_message =  $messageuser->num_rows();

				 	$re[] = $value;

				 	

				 	



		    }	

		    return $re;

  }



function search_group_chat_list($data)

  {		
  	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  			$user_id = $data->user_id;



  			$post_value = $data->post_value;



  			$search_text = $data->search_text;



		  	$this->db->select('*');

		  	$this->db->from('foot_chats');

		  	$where = " chat_status='active' and chat_type='group' and foot_chats.chat_name like '%$search_text%' and  foot_chats.chat_id in (select foot_chat_member.`chat_id` from `foot_chat_member`  where foot_chat_member.user_id='$user_id' )";

		  	$this->db->where($where);

		  	$this->db->order_by("last_update",'desc');

		    $this->db->limit(15,$post_value);

		    $query = $this->db->get();


		    



		    $result = $query->result();

		    $re = array();



		    foreach ($result as  $value) {



		    			$chat_id = $value->chat_id;
		    			$user1 = $value->user1;

		    			$user2 =  $value->user2;
 

				 	    $current_date = date('Y-m-d H:i:s');  

			          $first_date = new DateTime($value->last_update);

			          $second_date = new DateTime($current_date);



			          $difference = $first_date->diff($second_date);

			          $difference = $this->format_interval($difference);

			          $value->last_update = $difference;

	 				 $messageuser = $this->db->query("SELECT * FROM foot_chat_message where from_id!='".$user_id."' and chat_id='".$chat_id."' and message_status='active' and message_id NOT IN (SELECT message_id FROM foot_read_group_message)");
		         

            	   $value->total_unread_message =  $messageuser->num_rows();

				  

				 	$re[] = $value;

				 	

				 	



		    }	

		    return $re;

  }




function search_broadcast_list($data)

  {		
  	date_default_timezone_set('UTC');

    		$this->db->query('SET time_zone="+00:00"');

  			$user_id = $data->user_id;
 

  			$post_value = $data->post_value; 

  			$search_text = $data->search_text;
 

		  	$this->db->select('*');

		  	$this->db->from('foot_chats');

		  	$where = " chat_status='active' and chat_type='broadcast' and  foot_chats.user1='$user_id' and foot_chats.chat_name like '%$search_text%'";

		  	$this->db->where($where);

		  	$this->db->order_by("last_update",'desc');

		    $this->db->limit(15,$post_value);

		    $query = $this->db->get();
 



		    $result = $query->result();

		    $re = array();



		    foreach ($result as  $value) {



		    			$user1 = $value->user1;

		    			$user2 =  $value->user2;



 



				 	    $current_date = date('Y-m-d H:i:s'); 



		          $first_date = new DateTime($value->last_update);

		          $second_date = new DateTime($current_date);



		          $difference = $first_date->diff($second_date);

		          $difference = $this->format_interval($difference);

		          $value->last_update = $difference;



				  

				 	$re[] = $value;

				 	

				 	



		    }	

		    return $re;

  }











}