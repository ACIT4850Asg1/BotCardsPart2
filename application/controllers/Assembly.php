<?php
/*
    File: Assembly.php
    Authors: Adam, Matthew, Maxwell, Justin
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Assembly extends Application {
	
	public function index()
	{
            //Load all models, libraries, and helpers used
            $this->load->library('session');
		$this->load->model('Players');
		$this->load->model('Game');
            $this->load->model('MAssembly');
            $this->load->helper('form');
           

            //Create dropdown of all "Head" cards that are in a players inventory
            $Head_list = $this->MAssembly->get_player_Head($this->session->userdata('username'));
            //Populate a dropdown with created list
            $this->data['Head'] = form_dropdown('Piece', $Head_list, set_value('Piece'),'id = "top"');
            //Create dropdown of all "Body" cards that are in a players inventory
            $Body_list = $this->MAssembly->get_player_Body($this->session->userdata('username'));
            //Populate a dropdown with created list
            $this->data['Body'] = form_dropdown('Piece', $Body_list, set_value('Piece'),'id = "middle"');
            //Create dropdown of all "Leg" cards that are in a players inventory
            $Leg_list = $this->MAssembly->get_player_Leg($this->session->userdata('username'));
            //Populate a dropdown with created list
            $this->data['Leg'] = form_dropdown('Piece', $Leg_list, set_value('Piece'),'id = "bottom"');
            
		$this->data['assemble'] = "No bot selected"; //When page first loads no bot has been selected
            $this->data['user'] = $this->session->userdata('username'); //Print username in menubar
            $this->data['pagebody'] = 'assembly'; //Load the default view for page
            $this->render(); //Render page
	}
      public function assemble($num1, $num2, $num3)
      {
            //Load all models, libraries, and helpers used
            $this->load->library('session');
            $this->load->model('Players');
            $this->load->model('Game');
            $this->load->model('MAssembly');
            $this->load->helper('form');
           
            //Create dropdown of all "Head" cards that are in a players inventory
            $Head_list = $this->MAssembly->get_player_Head($this->session->userdata('username'));
            //Populate a dropdown with created list
            $this->data['Head'] = form_dropdown('Piece', $Head_list, set_value('Piece'),'id = "top"');
            //Create dropdown of all "Body" cards that are in a players inventory
            $Body_list = $this->MAssembly->get_player_Body($this->session->userdata('username'));
            //Populate a dropdown with created list
            $this->data['Body'] = form_dropdown('Piece', $Body_list, set_value('Piece'),'id = "middle"');
            //Create dropdown of all "Leg" cards that are in a players inventory
            $Leg_list = $this->MAssembly->get_player_Leg($this->session->userdata('username'));
            //Populate a dropdown with created list
            $this->data['Leg'] = form_dropdown('Piece', $Leg_list, set_value('Piece'),'id = "bottom"');

            //call function to pull the assembled pieces images and names from sources
            $assem = $this->MAssembly->get_complete($num1, $num2, $num3, $this->session->userdata('username'));

            //apply the template to each of the pieces
            foreach($assem as $assembled)
                  $assemblecells[] = $this->parser->parse('_collectioncell', (array) $assembled, true);
            //apply table parameters
            $this->load->library('table');
            $assemble_parms = array(
                  'table_open'            => '<table class="Assembled_table">',
                  'cell_start'            => '<td class="Assembled">',
                  'cell_alt_start'        => '<td class="Assembled">'
            );
            $this->table->set_template($assemble_parms);
            $assemble_rows = $this->table->make_columns($assemblecells, 1);

            //apply all data to desired variables and render page
            $this->data['assemble'] = $this->table->generate($assemble_rows); //Generates table that holds all three cards
            $this->data['user'] = $this->session->userdata('username');
            $this->data['pagebody'] = 'assembly';
            $this->render();
      } 

      function sellComplete()
      {
            $this->load->library('session');
            $this->load->model('Players');
            if(substr($this->input->post('top'), 0, 2) == substr($this->input->post('middle'), 0, 2) and substr($this->input->post('top'), 0, 2) == substr($this->input->post('bottom'), 0, 2)){
            $series = substr($this->input->post('top'), 0, 2);
            $top = $this->Players->getToken($this->input->post('top')); // find token from peice name
            $middle = $this->Players->getToken($this->input->post('middle'));
            $bottom = $this->Players->getToken($this->input->post('bottom'));
            echo "Start";
            echo $this->session->userdata('token');
            echo $top;
            echo $middle;
            echo $bottom;
            $fields_string = '';
            $url = 'botcards.jlparry.com/sell';
            $fields = array(
                  'team'=>urlencode('B07'),
                  'token'=>urlencode($this->session->userdata('token')),
                  'player'=>urlencode($this->session->userdata('username')),
                  'top'=>urlencode($top),
                  'middle'=>urlencode($bottom),
                  'bottom'=>urlencode($middle)
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
            $this->Players->addPeanuts($this->session->userdata('username'), $series);
            $this->Players->sellCard($top);
            $this->Players->sellCard($middle);
            $this->Players->sellCard($bottom);
            $this->index();
      }
      }   
}
