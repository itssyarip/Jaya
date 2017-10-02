<?php

class Master_Account_Model extends CI_Model {

    public $_table = 'm_account';

    function __construct() {
        parent::__construct();
    }
        
    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
    
    function getByCategory($where = array()) {
        return $this->db->get_where($this->_table, $where)->result_array();
//         echo $this->db->last_query();;exit;
    }
    
    function getData($limit=10, $offset = 0, $where=array(),$condition='like',$order='') {
        return $this->getListData($limit, $offset, $where,$condition,$order);
    }
    
    function add($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    function update($data) {
        $this->db->where(array('id'=>$data['id']));
        $this->db->update($this->_table, $data);
    }
    
    function getAccount($where = array(),$condition = 'where') {
        $this->db->select("acc.*");
        $this->db->from("$this->_table as acc");
        
        $this->db->order_by('acc_num','ASC');
            
        if ($where && sizeof($where) > 0) {
            foreach($where as $key => $value) {
                if ($value == '') {
                    $this->db->$condition($key);
                } else {
                    $this->db->$condition($key, $value,'after');
                }
            }
        }

        // Execute SQL Query
        $query = $this->db->get();
        // Check the result
        echo $this->db->last_query();exit;
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            echo 'The searched item records requested cannot be retrieved because';
            return false;
        }
    }
}