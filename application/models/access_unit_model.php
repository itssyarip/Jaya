<?php
class Access_Unit_model extends CI_Model {  
    public $_table = 'a_access_unit';
    function __construct(){
        parent::__construct();    
    }
    
    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
    
    function getAclsMenu($groups = '') {
        $this->db->select("$this->_table.acl_resource");
        $this->db->from($this->_table);

        $this->db->where("$this->_table.acl_role in ($groups)");
        
        $result_array = $this->db->get()->result_array(); 
//       $query2 =  $this->db->last_query();
//       echo $query2;exit;
        return $result_array;
    }
    
    public function getAclDataByRole($role) {
        $this->db->select("$this->_table.id_bse");
        $this->db->from($this->_table);

        $this->db->where("$this->_table.acu_role = $role");
        
        $result = $this->db->get()->result_array(); 
        $acl = array();
        if (count($result)) {
            foreach ($result as $item) {
                $acl[$item['id_bse']] = true;
            }
        }
        return $acl;
    }
    
    public function getAclData($role) {
        $this->db->select("$this->_table.id_bse");
        $this->db->from($this->_table);

        $this->db->where("$this->_table.acu_role = $role");
        
        $result = $this->db->get()->result_array(); 
//        echo $this->db->last_query();exit;
        return $result;
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
    
    function saveAcl($role, $acu) {
        try {
            //$this->getAdapter()->beginTransaction();
            $this->db->delete($this->_table,array('acu_role'=>$role));
            foreach ($acu as $item) {
                $item['acu_role'] = $role;
                $this->db->insert($this->_table,$item);
            }
            //$this->getAdapter()->commit();
        } catch (Exception $e) {
            //$this->getAdapter()->rollBack();
            throw $e;
        }


    }
}
?>