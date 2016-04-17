<?php

	class Agent extends CI_Model {
		function __construct(){
			parent::__construct();
		}

		function addround($round, $token) 
		{
			$data = array(
   				'Round' => $round ,
   				'Status' => 'Registered',
   				'Token' => $token 
			);

		$this->db->insert('rounds', $data); 
		}
		// Check to see if Agent is registered in current round
		function checkround($round)
		{
			$st="Round = '".$round."'";
			$this->db->where($st, NULL, FALSE);
			$query = $this->db->get('rounds')->result_array();
			if(!(sizeof($query) > 0)){
				return false;
			}
			elseif(($query[0]['Round'] == $round) AND ($query[0]['Status'] == 2 OR $query[0]['Status'] == 3)){
				return true;
			}
			else{
				return true;
			}
			
		}
		//Function used to reset Peanuts at every round.
		function resetPeanuts()
		{
			$st="1 = 1";
			$this->db->where($st, NULL, FALSE);  
			$player_array = $this->db->get('players')->result_array();
			var_dump($player_array);
			foreach ($player_array as $player ) {
				$where="Player = '".$player["Player"]."'";
				$data = array(
				'Avatar' => $player["Avatar"],
				'Player' => $player["Player"],
				'Password' => $player["Password"],
				'Status' => $player["Status"],
				'Peanuts' => 100
			);
			$this->db->where($where, NULL, FALSE);
			$this->db->update('players', $data);
			}
				
		}

	}
	?>