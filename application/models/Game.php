<?php

	class Game extends CI_Model {
		function __construct(){
			parent::__construct();
		}

		function all() 
		{
			$this->db->order_by('Series', 'Description', 'Frequency', 'Value');
			$query = $this->db->get('Series');
			return $query->result_array();
		}

	}