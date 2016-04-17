<?php

	class Players extends CI_Model {
		function __construct(){
			parent::__construct();
		}
		//returns array of all players
		function all() 
		{
			$this->db->order_by('Player', 'Peanuts');
			$query = $this->db->get('Players');
			return $query->result_array();
		}
		//returns array of specific player
		function getPlayer($player)
		{
			$st="Player = '".$player."'";
			$this->db->where($st, NULL, FALSE);  
			$player_array = $this->db->get('players')->result_array();
			return $player_array;

		}
		//check credentials
		function logon($user, $password)
		{
			$this->db->order_by('Player', 'Password');
			$st="Player='".$user."' AND Password = '".$password."'";
  			$this->db->where($st, NULL, FALSE);  
			$query = $this->db->get('Players');
			if(sizeof($query->result_array()) > 0){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		// function to deduct peanuts when cards are bought
		function buyCards($player)
		{
			$st="Player = '".$player."'";
			$this->db->where($st, NULL, FALSE);  
			$player_array = $this->db->get('players')->result_array();
			$data = array(
				'Player' => $player_array[0]["Player"],
				'Password' => $player_array[0]["Password"],
				'Status' => $player_array[0]["Status"],
				'Peanuts' => ($player_array[0]["Peanuts"] - 20)
			);
			$this->db->where($st, NULL, FALSE);
			$this->db->update('players', $data);

			$transaction = array(
				'Datetime' => date("Y.m.d-hh-mm-ss"),
				'Player' => $player,
				'Series' => "x",
				'Trans' => 'buy'
				);
			$this->db->insert('transactions', $transaction);

		}
		// add peanuts when cards are sold
		function addPeanuts($player, $series)
		{
			$value = 0;
			if($series == 11){
				$value = 20;
			}
			elseif($series == 13){
				$value = 50;
			}
			elseif($series == 26){
				$value = 200;
			}

			$st="Player = '".$player."'";
			$this->db->where($st, NULL, FALSE);  
			$player_array = $this->db->get('players')->result_array();
			//var_dump($player);
			$data = array(
				'Player' => $player_array[0]["Player"],
				'Password' => $player_array[0]["Password"],
				'Status' => $player_array[0]["Status"],
				'Peanuts' => ($player_array[0]["Peanuts"] + $value)
			);
			$this->db->where($st, NULL, FALSE);
			$this->db->update('players', $data);

			$transaction = array(
				'Datetime' => date("Y.m.d-hh-mm-ss"),
				'Player' => $player,
				'Series' => $series,
				'Trans' => 'sell'
				);
			$this->db->insert('transactions', $transaction);

		}

		//Add bought cards to collection
		function addCards($player, $token, $piece, $datetime)
		{

			$data = array(
				'Token' => $token,
				'Piece' => $piece,
				'Player' => $player,
				'Datetime' => $datetime
			);

			$this->db->insert('collections', $data);
			

		}
		// retrives card token used for selling cards
		function getToken($name)
		{
			$this->db->where('Piece', $name);
			$token_array = $this->db->get('collections')->result_array();
			return $token_array[0]['Token'];
		}
		//Removes sold card from db
		function sellCard($token)
		{
			$this->db->where('Token', $token);
			$this->db->delete('collections');
		}


	}