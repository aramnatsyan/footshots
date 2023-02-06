<?php 

class Block_abuse_words_model extends CI_Model {



  public function __construct()

  {

        // Call the Model constructor

    parent::__construct();

    date_default_timezone_set('Asia/Kolkata');

    $this->db->query('SET time_zone="+05:30"');

     $this->load->model('User_model');  

  }




public function add_words(){

  $word = $this->input->post('abuse_word');

  print($word);die();
}


 
 
}