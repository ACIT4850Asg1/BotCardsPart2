<?php

	class MAssembly extends CI_Model {
		function __construct(){
			parent::__construct();
		}

		

		//Gets top cards
		function get_player_Head($name) 
		{
			$this->db->order_by('Piece');
			$this->db->where('Player =', '"'.$name.'"', FALSE);
			$this->db->where('Piece LIKE', '"%-0"', FALSE);
			$result = $this->db->get('Collections');
			$return = array();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row) {
					$return[$row['Piece']] = $row['Piece'];
				}
			}

        return $return;
		}
		//Gets Middle cards
		function get_player_Body($name) 
		{
			$this->db->order_by('Piece');
			$this->db->where('Player =', '"'.$name.'"', FALSE);
			$this->db->where('Piece LIKE', '"%-1"', FALSE);
			$result = $this->db->get('Collections');
			$return = array();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row) {
					$return[$row['Piece']] = $row['Piece'];
				}
			}

        return $return;
		}

		//Gets bottom cards
		function get_player_Leg($name) 
		{
			$this->db->order_by('Piece');
			$this->db->where('Player =', '"'.$name.'"', FALSE);
			$this->db->where('Piece LIKE', '"%-2"', FALSE);
			$result = $this->db->get('Collections');
			$return = array();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row) {
					$return[$row['Piece']] = $row['Piece'];
				}
			}

        return $return;
		}

		//Gets complete cards
		function get_complete($num1, $num2, $num3, $name) 
		{
			$where_au = "(Player = '".$name."' AND (`Piece` = '".$num1."' OR `Piece` = '".$num2."' OR `Piece` = '".$num3."'))";
			$this->db->distinct();

			$this->db->select('Piece');
			
			$this->db->order_by("SUBSTRING(Piece, 5)");
			$this->db->where($where_au);
			$query = $this->db->get('Collections');
			return $query->result_array();
			
		}




	}