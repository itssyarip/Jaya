<?php
class Help_model extends CI_Model{  
    public $_table = 't_help';
    function __construct(){
        parent::__construct();    
    }
    
    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
    function update($inputArray){
        $this->db->where(array('id'=>$inputArray['id']));
        $this->db->update($this->_table, $inputArray);
    }
}
?>