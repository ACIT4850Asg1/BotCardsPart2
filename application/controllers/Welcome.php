<?php
/*
    File: Welcome.php
    Authors: Adam, Matthew, Maxwell, Justin

    Description: Welcome has functions related to loading the main homepage and 
    handling the user login and logout functions.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application {

	

	
	public function index()
	{

            

            // Attempt to load user name from session data
            $user[] = $this->session->userdata('username');
            // Test if the user had logged on.
            if( $user[0]=='assets' or $user[0]=='None' or !isset($user[0])){
            // If user not logged on set session data to None. 
            $this->session->set_userdata(array(
                            'username'      => "None",
                            'password'      => "None"
                    ));    
            }
           
            // Pull all game data.
		$game = $this->Game->all();
            // Use game data and _gamecell to creeate table rows for the data. 
		foreach($game as $series)
            	$game_cells[] = $this->parser->parse('_gamecell', (array) $series, true);

            // Assign table parameters
            $game_parms = array(
                        'table_open'          => '<table border="0" cellpadding="10" cellspacing="5" class="Game_table">
                                                  <col width="90">
                                                  <col width="130">'
                  );
            $this->table->set_template($game_parms);
            $this->table->set_heading('Series ', 'Description'); // Table headers
            $game_rows = $this->table->make_columns($game_cells, 1); // One use of the _gamecell template per row.
            $this->data['game'] = $this->table->generate($game_rows); // Apply the game table to the game section of page.
            


	
            // Pull all player information.
            $player = $this->Players->all();
            // Use player data and _cell template to display all player information.
            foreach($player as $players)
            	$cells[] = $this->parser->parse('_cell', (array) $players, true);
            // Assign table properties.
            $parms = array(
            		'table_open' 		=> '<table class="Player_table">',
            		'cell_start' 		=> '<td class="Player_info">',
            		'cell_alt_start' 	      => '<td class="Player_info">'
            	);
            $this->table->set_template($parms);
            $this->table->set_heading('Avatar', 'Player Name', 'Peanuts');
            $rows = $this->table->make_columns($cells, 1);


            $this->data['Round'] = $xml->round;
            $this->data['Status'] = $xml->current;
            $this->data['Duration'] = $xml->duration;
            $this->data['Next'] = $xml->upcoming;
            $this->data['EndTime'] = $xml->alarm;
            $this->data['Time'] = $xml->now;
            
            $this->data['players'] = $this->table->generate($rows); // Apply the Player table to the game section of page.
            $this->data['user'] = $this->session->userdata('username'); // Apply the username to the user section of page.
            $this->data['pass'] = $this->session->userdata('password'); // Apply the password to the password section of page.
            $this->data['pagebody'] = 'homepage';  // Apply data to the body section of the page.
            $this->render(); // Render page.

	}
      public function logon()
      {
            $name = $this->input->post('name');
            $password = $this->input->post('pass');
            // Load models used.
            $this->load->model('Players');
            $this->load->library('session');
            // Check that $name and $password match a pair held in database
            if($this->Players->logon($name, $password)){
                  // Ensure that $name is not set to assets as this is not allowed (weird error session data becoming assets)
                  if($name != 'assets'){
                  // Set session data
                  $this->session->set_userdata(array(
                                  'username'      => $name,
                                  'password'      => $password
                        ));
                  }

                  $this->data['user'] = $this->session->userdata('username'); // Apply the username to the user section of page.
                  $this->data['pass'] = $this->session->userdata('password'); // Apply the password to the password section of page.
            }
      else{
            
      }
      // Call index funtion to reload page and update to secondary template.
      $this->index();
      
      }
      public function logout()
      {
            // Load Libraries and models used.
            $this->load->library('session');
            $this->load->model('Players');
            $this->load->model('Game');
            // Set the user data to None
            $this->session->set_userdata(array(
                            'username'      => "None",
                            'password'      => "None"
                    ));
            //Call index funtion to reload page and update to secondary template.
            $this->index();
      }

      public function buy()
      {
          $this->load->library('session');
          $this->load->model('Players');
          $fields_string = '';
            $url = 'botcards.jlparry.com/buy';
            $fields = array(
                  'team'=>urlencode('B07'),
                  'token'=>urlencode($this->session->userdata('token')),
                  'player'=>urlencode($this->session->userdata('username'))
            );

            //url-ify the data for the POST
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string,'&');

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_HEADER, "Content-Type:application/xml");
            curl_setopt($ch,CURLOPT_POST,count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute post
            $result = curl_exec($ch);
            echo $result;
            curl_close($ch);
            $xml = new SimpleXMLElement($result);

            foreach ($xml->certificate as $element) {
            $this->Players->addCards( $element->player, $element->token, $element->piece, $element->datetime);
            $player = $element->player;
            }
            $this->Players->buyCards($player);
            $this->index();  


      }
      
      

}
