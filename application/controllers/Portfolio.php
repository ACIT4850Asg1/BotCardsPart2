<?php
/*
    File: Portfolio.php
    Authors: Adam, Matthew, Maxwell, Justin
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends Application {

	public function index()
	{
            //Load all Libraries, Models, and Helpers used
            $this->load->library('session');
		        $this->load->model('Players');
		        $this->load->model('Game');
            $this->load->model('Transaction');
            $this->load->helper('form');

            //Load session data
            $user = $this->session->userdata('username');
            $pass = $this->session->userdata('password');
            //check if player is logged in or not (anything other than "None" should be logged on)
            if("None" !==($user) ){
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
                  $this->data['trade'] = $this->table->generate($tran_rows);



	           
                  $collection = $this->Transaction->get_player_collection($this->session->userdata('username'));

                  foreach($collection as $collections)
            	     $collection_cells[] = $this->parser->parse('_collectioncell', (array) $collections, true);
                  $collection_rows = $this->table->make_columns($collection_cells, 2);
                  $this->data['collection'] = $this->table->generate($collection_rows);
            }
                  $this->load->library('table');
                  $parms = array(
            		'table_open' 		=> '<table class="Player_table">',
            		'cell_start' 		=> '<td class="Player_info">',
            		'cell_alt_start' 	      => '<td class="Player_info">'
            	);
                  $this->table->set_template($parms);

                  

            

            }
            else{
                  $this->data['trade'] = "No player selected";
                  $this->data['collection'] = "No player selected";
            }
            $Player_list = $this->Transaction->get_dropdown_list();
            $this->data['dropdown'] = form_dropdown('Player', $Player_list, set_value('player'),'id = "player"');

			
            $this->data['user'] = $this->session->userdata('username');
            $this->data['pass'] = $this->session->userdata('password');
            $this->data['pagebody'] = 'portfolio';
            $this->render();

	}
      //Function used to show specific player
      public function show($name) 
      {
            $this->load->model('Players');
            $this->load->model('Game');
            $this->load->model('Transaction');
            $this->load->helper('form');


            $tran = $this->Transaction->get_player_trans($name);
            $size = sizeof($tran);
            if($size > 0){
            foreach($tran as $trans)
                  $trancells[] = $this->parser->parse('_trancell', (array) $trans, true);

            $this->load->library('table');
            $trans_parms = array(
                        'table_open'          => '<table border="1" cellpadding="10" cellspacing="5" class="Game_table">
                                                <col width="200">
                                                  <col width="90">
                                                  <col width="60">
                                                  <col width="50">',
                  
                  );
                  $this->table->set_template($trans_parms);
                  $this->table->set_heading('Transaction Date', 'Player Name', 'Series', 'Type');
            $tran_rows = $this->table->make_columns($trancells, 1);
            $this->data['trade'] = $this->table->generate($tran_rows);


      
            $collection = $this->Transaction->get_player_collection($name);

            foreach($collection as $collections)
                  $collection_cells[] = $this->parser->parse('_collectioncell', (array) $collections, true);

            $this->load->library('table');
            $parms = array(
                        'table_open'            => '<table class="Player_table">',
                        'cell_start'            => '<td class="Player_info">',
                        'cell_alt_start'  => '<td class="Player_info">'
                  );
            $this->table->set_template($parms);

            $collection_rows = $this->table->make_columns($collection_cells, 2);
            $this->data['collection'] = $this->table->generate($collection_rows);
            }

            $Player_list = $this->Transaction->get_dropdown_list();
            $this->data['dropdown'] = form_dropdown('Player', $Player_list, set_value('player'),'id = "player"');

                  
            
            $this->data['user'] = $this->session->userdata('username');
            $this->data['pass'] = $this->session->userdata('password');
            $this->data['pagebody'] = 'portfolio';
            $this->render();


      }
}
