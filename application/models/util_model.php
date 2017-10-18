<?php
class Util_model extends CI_Model{	
	  function __construct(){
        parent::__construct();    
  	}

  	function get_all_data($tabel_name){
            $query = $this->db->get($tabel_name);  		
            return $query->result_array();
  	}

  	function get_where_data($tabel_name, $where){
            $query = $this->db->get_where($tabel_name, $where);
            $result = $query->result_array();
            return $result;
  	}
}