<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forgotpass extends CI_Controller { /**
     * Constructor
     */ 
    function __construct() {
		parent::__construct();
       // is_protected();
       $this->load->model('User_model');
 
		
    }
	
	/**
     * End of function
     */
	 
	 /**
     * index
     *
     * This function to render dashboard page initially
     * 
     * @access	public
     * @return  html
     */

    


  public function genrate_password($password)                     

  {

    $intermediateSalt = md5('$P$123', true);

     $salt = substr($intermediateSalt, 0,6);

     $password = hash("sha256", $password . $salt);

     return $password;

  }



       public function forgot_pass()
    {       
        $data['breadcum'] = array("users/" => 'Users');  

        $user_id = $this->uri->segment(3);               

        $data['user_id'] =  $user_id; 



        $this->db->select('*');

        $this->db->from('footshot_forgot_password');

        $where = "user_id='".$user_id."'";                      /*select user with same email*/

        $this->db->where($where);

        $query = $this->db->get();

        $result = $query->result(); 

        if($result)
        {

                $data['success']="";

                if($this->input->post('newPassword'))
                {
                    $forgot_pass = $this->input->post('newPassword');

                      $new_password = $this->genrate_password($forgot_pass);      /*Call Password genreate function to encode user password.*/



                            $dataOrder = array(

                               'password' => $new_password 

                               );



                              $this->db->where('user_id', $user_id);



                              $res = $this->db->update('foot_app_users', $dataOrder);     /*Update new password*/

                              $data['success']="Done";

                              $this->db->where('user_id', $user_id);
                            $this->db->delete('footshot_forgot_password');

                }

                $this->load->view('site_forgot_password', $data);
            }
            else
            {
                $this->load->view('site_forgot_password_failed', $data);
            }
    }

   
    /*End of function*/

 
		/*End of Function*/

}
/*End of class*/