<?php
class Category_Model extends CI_Model{  
    public $_table = 'm_category';
    function __construct(){
        parent::__construct();    
    }
    
    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
    
    function getData($limit=10, $offset = 0, $where=array(),$condition='where') {
        return $this->getListData($limit, $offset, $where,$condition);
    }
    
    function getByCategory($where = array()) {
        return $this->db->get_where($this->_table, $where)->result();
    }
    
    function add($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    function update($data) {
        $this->db->where(array('id'=>$data['id']));
        $this->db->update($this->_table, $data);
    }    
}
?>