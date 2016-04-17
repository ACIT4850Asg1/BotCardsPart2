<?php
/*
Register
    File: Welcome.php
    Authors: Adam, Matthew, Maxwell, Justin

    Description: Welcome has functions related to loading the main homepage and 
    handling the user login and logout functions.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Application {

	

	
	public function index()
	{
            // Load all Libraries and Models used.

    $this->load->library('session');

            $this->data['user'] = $this->session->userdata('username'); // Apply the username to the user section of page.
            $this->data['pass'] = $this->session->userdata('password'); // Apply the password to the password section of page.
            $this->data['pagebody'] = 'register';  // Apply data to the body section of the page.
            $this->render(); // Render page.

	}
    public function submit()
    {
        $name = ($_POST['user']);
        $password =($_POST['pass']);
        VAR_DUMP($_FILES);
        $config['upload_path'] = 'assets/img';
        $config['allowed_types'] = '*'; //File type error if not set to all files (Due to mimme type I believe not 100% certain)
        $config['max_size'] = 2048000;
      
        //Use codeigniter upload function with modified config.
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload("uploadImage");
        $data_upload_files = $this->upload->data();
        $error = array('error' => $this->upload->display_errors());
        var_dump($error);
        var_dump($data_upload_files);
        $image = 'assets/img'.$data_upload_files['raw_name']; 


        $this->load->model('Player_Register');
        $data = array(
        'Avatar' => $image,
        'Player' => $name,
        'Password' => $password,
        'Status' => "Player",
        'Peanuts' => 200
        );
        $this->Player_Register->add($data); 

        
    }

      

}
