<?php

class Bank_Master_Tp_Model extends CI_Model {

    public $_table = 'm_bank';

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
    
    function getBank($limit=10, $offset = 0, $where=array(),$condition='like',$order='id,ASC') {
        $this->db->select("bank.*,bse.bse_name,accn.acc_name");
        $this->db->from("$this->_table as bank");
        $this->db->join('m_account accn', 'accn.acc_num=bank.acc_bank','LEFT');
        $this->db->join('m_business_entities bse', 'bse.id_bse=bank.unit','LEFT');
        
        if ($order != '') {
            $order = explode(',',$order);
            if(sizeof($order) > 1) {
                $this->db->order_by($order[0],$order[1]);
            } else if(sizeof($order) == 1){
                $this->db->order_by('id',$order[0]);
            }

        }
            
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
            
        if ($where && sizeof($where) > 0) {
            foreach($where as $key => $value) {
                if ($value == '') {
                    $this->db->$condition($key);
                } else {
                    $this->db->$condition($key, $value);
                }
            }
        }

        // Execute SQL Query
        $query = $this->db->get();
        // Check the result
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            echo 'The searched item records requested cannot be retrieved because';
            return false;
        }
    }
    
    function getData($limit=10, $offset = 0, $where=array(),$condition='like') {
        return $this->getListData($limit, $offset, $where,$condition);
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