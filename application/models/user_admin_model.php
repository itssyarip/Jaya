<?php

class User_Admin_Model extends CI_Model {

    public $_table = 'a_user';

    function __construct() {
        parent::__construct();
    }

    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
    
    function getData($limit=10, $offset = 0, $where=array(),$condition='like') {
        return $this->getListData($limit, $offset, $where,$condition);
    }
    
     function getByCategory($where = array()) {
        return $this->db->get_where($this->_table, $where)->result();
    }
    
    function getByGroup($groupId) {
        $query1 = $this->db->query("SELECT * FROM ".$this->_table." WHERE FIND_IN_SET('$groupId',user_group)");
        $result = $query1->result_array();
//        $query2 =  $this->db->last_query();
//       echo 'halo = '.$query2;exit;
        return $result;
    }
    
    function check_user($data) {
        $query = $this->db->get_where($this->_table, $data);
        $result = $query->row_array();
        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return '';
        }
        
    }

    function add($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    function update($data) {
        $this->db->where(array('id'=>$data['id']));
        $this->db->update($this->_table, $data);
    }
    
    function get_data_user($user_id) {
        $this->db->select('a_user.user_name, a_user.user_email');
        $this->db->from('a_user');
        $this->db->where('a_user.id', $user_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    function update_password($oldPassword='', $newPassword, $id_user) {
        $flagPass = false;
        if ($oldPassword != ''){
            $query = $this->db->get_where('user', array('id' => $id_user));
            $result = $query->row_array();
            if ($result['password'] == md5($oldPassword)) {
                $flagPass = true;
            }
        } else {
            $flagPass = true;
        }
        
        if ($flagPass) {
            $this->db->where('id', $id_user);
            $this->db->update('a_user', array('user_pass' => md5($newPassword),'is_new'=>FALSE));
            $msg = 1;
        } else {
            $msg = 2;
        }
        
        return $msg;
    }

    function updateByProfile($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
    }
}