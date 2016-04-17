<?php

	class Player_Register extends CI_Model {
		function __construct(){
			parent::__construct();
		}
		// inserts new players into db
		function add($data) 
		{
			$this->db->insert('players', $data);
		}
		

	}