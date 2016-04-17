<?php

	class Transaction extends CI_Model {
		function __construct(){
			parent::__construct();
		}
		//Retrive specific player transaction
		function get_player_trans($name) 
		{
			$this->db->order_by('DateTime');
			$this->db->where('Player =', '"'.$name.'"', FALSE);
			$query = $this->db->get('Transactions');
			return $query->result_array();
		}

		//Retrive specific player collection
		function get_player_collection($name) 
		{
			$this->db->order_by('Piece');
			$this->db->where('Player =', '"'.$name.'"', FALSE);
			$query = $this->db->get('Collections');
			return $query->result_array();
		}

		//Create dropdown of all players
		function get_dropdown_list()
		{
			$this->db->from('Players');
			$this->db->order_by('Player');
			$result = $this->db->get();
			$return = array();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row) {
					$return[$row['Player']] = $row['Player'];
				}
			}

        return $return;

		}
		//delete all transactions
		function delete_trans()
		{
		$this->db->where('1=1');
		$this->db->delete('transactions');
		}
		//Delete all Collections
		function delete_collection()
		{
		$this->db->where('1=1');
		$this->db->delete('collections');
		}
	
	}