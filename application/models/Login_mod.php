<?php if (!defined('BASEPATH'))	exit('No direct script access allowed');
/**
 * Login_mod Model 
 *
 * @package		Login_mod
 * @subpackage	Models
 * @category	Login_mod 
 * @author		Akhil Kaliyar
 * @website		http://www.emobx.com
 * @company     Enterprise Mobility Xperts
 * @since		Version 1.0
 */
class Login_mod extends CI_Model {
	var $user_table = "foot_admin";		
	/**
     * Constructor
     */
    function __construct() {
        parent::__construct();
            
      date_default_timezone_set('UTC');

    $this->db->query('SET time_zone="+00:00"');
    }

    /* End of Constructor */

    /**
     *
     * This function login authenticate 
     * 
     * @access	public
     * @param   String   plain string
     * @return	String   encrypted string
     */
    function login_authorize() 	
	{			
		$this->form_validation->set_rules('email', "Email Address", 'trim|required|valid_email');		
		$this->form_validation->set_rules('password', 'Password', 'trim|required');		
		$email = $this->security->xss_clean($this->input->post('email', true));		
		$password = $this->security->xss_clean($this->input->post('password', true));		
		$data = array();		
		if ($this->form_validation->run() === false)		
		{           
        }		
		$this->db->where("email", $email);		
		$query = $this->db->get($this->user_table);		
		//echo $this->db->last_query();die;				
		if ($query->num_rows() > 0)		
		{ 
            $row = $query->row();            			
			 				
				$password = md5($password);        				
				if ($password == $row->password)				
				{					
					$user_info = $row;					
					unset($user_info->password);					
					if ($user_info->status == "inactive") 					
					{						
						$data['error_msg'] = "Your account has been inactive";						
						$data['status'] = 'error';						
						return $data;					
					}else 					
					{						
						$login_time = date("Y-m-d h:i:s");						
						$up['last_login'] = $login_time;						
						$this->db->where('id', $user_info->id);						
						$this->db->update($this->user_table, $up);	

						$this->session->set_userdata("userinfo",$user_info);   
				        $this->session->set_userdata("isLogin",'yes'); 
				       $this->session->set_userdata("user_id",$user_info->id); 


						$data['status'] = 'success';						
						$data['result'] = $user_info;						
					}                					
					return $data;				
				}
			   	
		}		
		$data['error_msg'] = "Invalid login credentials";		
		$data['status'] = 'error';		
		return $data;	
	}
}

/* End of class */
?>