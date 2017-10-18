<?php

class Group_Model extends CI_Model {

    public $_table = 'a_group';

    function __construct() {
        parent::__construct();
    }

    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
        return $resultQuery;
    }
    
    function getDefaultGroup($where = array()) {
        $this->db->select('*');
        $this->db->from("$this->_table as a");
        if ($where) {
            foreach($where as $key => $value) {
                if ($value == '') {
                    $this->db->where($key);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        
        $query = $this->db->get();
//        echo $this->db->last_query();exit;
        return $query->result_array();
    }
    
    function getByCategory($where = array()) {
        return $this->db->get_where($this->_table, $where)->result_array();
    }
    
    function add($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    function update($data) {
        $this->db->where(array('group_code'=>$data['group_code']));
        $this->db->update($this->_table, $data);
    }
    
    function getLevel($group) {
        $query = $this->db->query('SELECT * FROM '.$this->_table.' WHERE group_code in('.$group.') order by group_code ASC limit 1');
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
        
    
}