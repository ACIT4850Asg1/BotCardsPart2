<?php
/*
Register
    File: Welcome.php
    Authors: Adam, Matthew, Maxwell, Justin

    Description: Welcome has functions related to loading the main homepage and 
    handling the user login and logout functions.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Player_page extends Application {

	

	
	public function index()
	{
            // Load all Libraries and Models used.

            $this->load->library('session');
            $this->load->model('Players');
            $this->load->model('Transaction');

                //Get current players transactions
            $tran = $this->Transaction->get_player_trans($this->session->userdata('username'));
                //Determine number of cards to check if player has none
                $size = sizeof($tran);
            //Ensure that player does have transaction
            if($size > 0){
                //Apply template to each transaction
            foreach($tran as $trans)
                $trancells[] = $this->parser->parse('_trancell', (array) $trans, true);
                  //Set table properties
                 $this->load->library('table');
                 $trans_parms = array(
                        'table_open'          => '<table border="1" cellpadding="10" cellspacing="5" class="Game_table">
                                                  <col width="200">
                                                  <col width="90">
                                                  <col width="60">
                                                  <col width="50">',
                    
                );
                  $this->table->set_template($trans_parms);
                  $this->table->set_heading('Transaction Date', 'Player Name', 'Series', 'Type'); //Table headers
                  $tran_rows = $this->table->make_columns($trancells, 1);

                  //Generate table and apply to page
                  $this->data['transactions'] = $this->table->generate($tran_rows);
              }
              else{
                $this->data['transactions'] = "None";
              }
              $player = $this->Players->getPlayer($this->session->userdata('username'));

              $this->data['avatar'] = '<img src="/'.$player[0]['Avatar'].'"height="120" width="120"/>';


            $this->data['user'] = $this->session->userdata('username'); // Apply the username to the user section of page.
            $this->data['pass'] = $this->session->userdata('password'); // Apply the password to the password section of page.''
            $this->data['name'] = $this->session->userdata('username');
            $this->data['peanuts'] = $player[0]['Peanuts'];
            $this->data['pagebody'] = 'player';  // Apply data to the body section of the page.
            $this->render(); // Render page.

	}


      

}
