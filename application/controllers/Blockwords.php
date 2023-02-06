<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blockwords extends CI_Controller { /**
     * Constructor
     */ 
    function __construct() {
		parent::__construct();
        is_protected();
        $this->load->model('User_model');
		$this->load->model('Post_model');
		
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

    public function index()
	{		
        
        if(isset($_POST["submit"]))
        {
          $file = $_FILES['file']['tmp_name'];
          $handle = fopen($file, "r");
          $c = 0;//
          while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
          {
            $fname = $filesop[0];
            
            if($c<>0)
            {          //SKIP THE FIRST ROW
              $arr=array(
                 'word'=>$fname,
                 'date_of_creation' =>date('Y-m-d H:i:s'),
                 'date_of_updation' =>date('Y-m-d H:i:s')
                 );
                $saved = $this->db->insert('foot_abuse_words',$arr);;
            }
            $c = $c + 1;
          }
           
            
        }

       $this->db->select('*');
       $this->db->from('foot_abuse_words');
       $data=$this->db->get();
       $res = $data->result();
       $result['result']= $res;


       // $result['page_title']= 'Blocked words list';

       $this->load->view('block_words' , $result);
    }

     public function upload_words()
  {   //print_r($_REQUEST);
           $this->load->view('upload_block_words'); 
            // $this->load->view('formsuccess'); 
               if(isset($_REQUEST["submit"]))
            {
             $file = $_FILES['file']['tmp_name'];
                    $handle = fopen($file, "r");
                    $c = 0;//
                    while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
                    {

                      $fname = $filesop[0];
                      
                      if($c<>0)
                      {        //SKIP THE FIRST ROW
                        $arr=array(
                           'word'=>$fname,
                           'date_of_creation' =>date('Y-m-d H:i:s'),
                           'date_of_updation' =>date('Y-m-d H:i:s')
                           );
                          $saved = $this->db->insert('foot_abuse_words',$arr);;
                      }
                      $c = $c + 1;
                }
              }

         

            
              
             
  }
        public function add_words()
  {   
         $this->load->helper(array('form'));
         $this->load->library('form_validation');
         $this->form_validation->set_rules('abuse_word', 'abuse_word', 'required'); 
         if ($this->form_validation->run() == FALSE) { 
             $this->load->view('add_block_words'); 
         }else{ 
            // $this->load->view('formsuccess'); 
            $word=$this->input->post('abuse_word');

            $blocklist = explode(",",$word);

            foreach ($blocklist as  $value) {
                 $arr=array(
                 'word'=>$value,
                 'date_of_creation' =>date('Y-m-d H:i:s'),
                 'date_of_updation' =>date('Y-m-d H:i:s')
                 );
                $saved = $this->db->insert('foot_abuse_words',$arr);
            }

         

            if ($saved) {
              set_flashdata('success','Added Successfully');
              redirect(base_url('Blockwords'));
            }
              
              } 
     
  }
      
      public function delete($id=NULL){

        $w_id = $id;
        $this->db-> where('id', $w_id);
        $data = $this->db->delete('foot_abuse_words');
        if ($data) {
          
          // $this->session->set_flashdata('msg', 'Deleted successfully');
          // redirect('controller_name/addRoom');
          set_flashdata('success','Deleted Successfully');
              redirect(base_url('Blockwords'));

        }

      }
      public function edit($id=NULL){

       $w_id = $id;
       $this->db->select('*');
       $this->db->from('foot_abuse_words');
       $this->db->where('id', $w_id);
       $data=$this->db->get();
       $res = $data->result();
       $result['result']= $res;
       // $result['page_title']= 'Blocked words list';

       $this->load->view('edit_abuse_words' , $result);

      }

      public function update($id=NULL){

         $u_word   = $this->input->post('abuse_word');
         $u_date = date('Y-m-d H:i:s');
         $w_id = $id;
             $this->db->set('word', $u_word);
             $this->db->set('date_of_updation', $u_date);
             $this->db->where('id', $w_id);
         $upd = $this->db->update('foot_abuse_words');
     if ($upd) {
              set_flashdata('success','Updated Successfully');
              redirect(base_url('Blockwords'));

            }
              
       } 
 }

/*End of class*/







