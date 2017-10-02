<?php

class Menu_Model extends CI_Model {

    public $_table = 's_menu';

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
    function getMenu($menuAlias,$active = 'Y') {
//        $query = $this->db->query('SELECT * FROM '.$this->_table.' as menu  
//            where menu.menu_active="'.$active.'" and menu.menu_alias = "'.$menuAlias.'"');
//        $resultQuery = $query->result_array();
//          
//        return $resultQuery;
        $this->db->select("menu.*");
        $this->db->from("$this->_table as menu");
//        $this->db->join('t_content cntn', 'cntn.menu_alias=menu.menu_alias','LEFT');
        $this->db->where("menu.menu_active = ", 'Y');
        $this->db->where("menu.menu_alias = ", $menuAlias);
        
        // Execute SQL Query
        $query = $this->db->get();
        // Check the result
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            $ErrMsg = 'The searched item records requested cannot be retrieved because';
            return false;
        }
    }
    
    function getData($limit=10, $offset = 0, $where=array(),$condition='like') {
        return $this->getListData($limit, $offset, $where,$condition);
    }
    
    function getTopMenu($where = array()) {
        $this->db->select("menu.*");
        $this->db->from("$this->_table as menu");

        if ($where) {
            foreach($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        
        $query = $this->db->get();
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            $ErrMsg = 'The searched item records requested cannot be retrieved because';
            return false;
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
    
    function getHeaderMenu ($parent = 0, $ctgr = 'left', $type='backend,util', $module='') {
        $this->db->select("menu.id, menu.menu_name, menu.menu_name_en,menu.menu_link, menu.menu_web_link, menu.menu_parent, menu.menu_ctgr, menu.menu_order,menu.menu_alias,
            (select menu_alias from s_menu as pmenu where pmenu.id=menu.menu_parent) as palias");
        $this->db->from("$this->_table as menu");
//        $this->db->join('t_content cntn', 'cntn.menu_alias=menu.menu_alias','LEFT');
        
        $this->db->where("menu.menu_parent = ", $parent);
        $this->db->where("menu.menu_active = ", 'Y');
        $this->db->where("menu.menu_type in($type) ");
        
        if ($ctgr != '') {
            $this->db->where("menu.menu_ctgr = ", $ctgr);
        }
        if ($module != "") {
            $this->db->where("menu.menu_modul = ", $module);
        } 
        $this->db->order_by('menu.menu_order asc');

        // Execute SQL Query
        $query = $this->db->get();
//        if ($alias != "") {
//            echo $this->db->last_query();
//        }
        // Check the result
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            $ErrMsg = 'The searched item records requested cannot be retrieved because';
            return false;
        }
    }
    
    function getLeftMenu ($parent = 0, $ctgr = 'left', $type='backend', $module='',$order = '') {
                
        $this->db->cache_on();
        $this->db->select("menu.id, menu.menu_name, menu.menu_name_en,menu.menu_link, menu.menu_web_link, menu.menu_parent, menu.menu_ctgr, menu.menu_order,menu.menu_alias,
            menu.menu_modul,(select menu_alias from s_menu as pmenu where pmenu.id=menu.menu_parent) as palias");
        $this->db->from("$this->_table as menu");
//        $this->db->join('t_content cntn', 'cntn.menu_alias=menu.menu_alias','LEFT');
        
        $this->db->where("menu.menu_parent = ", $parent);
        $this->db->where("menu.menu_active = ", 'Y');
        $this->db->where("menu.menu_type in($type) ");
        
        if ($ctgr != '') {
            $this->db->where("menu.menu_ctgr = ", $ctgr);
        }
        if ($module != "") {
            $this->db->where("menu.menu_modul = ", $module);
        } else {
            if ($ctgr == 'header') {
                $this->db->where("menu.menu_modul = ", '');
            }
        }
        if ($order != '') {
            $this->db->order_by($order);
        } else {
            $this->db->order_by('menu.menu_modul asc');
        }

        // Execute SQL Query
        $query = $this->db->get();
//        if ($alias != "") {
//            echo $this->db->last_query();
//        }
        // Check the result
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            $ErrMsg = 'The searched item records requested cannot be retrieved because';
            return false;
        }
    }
    function getParentMenu ($parent=0) {
        $this->db->select("menu.id, menu.menu_name, menu.menu_name_en,menu.menu_link, menu.menu_web_link, menu.menu_parent, menu.menu_ctgr, menu.menu_order,menu.menu_alias,menu.menu_file_path,menu.menu_file_name");
        $this->db->from("$this->_table as menu");
        $this->db->where("menu.menu_parent = ", $parent);
        $this->db->where("menu.menu_active = ", 'Y');
        
        $query = $this->db->get();
        // Check the result
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            $ErrMsg = 'The searched item records requested cannot be retrieved because';
            return false;
        }
    }
    
    function get_data_user($user_id) {
        $this->db->select('user.username, user.status, user.email, user.address, user.telp');
        $this->db->from('user');
        $this->db->where('user.id', $user_id);
        $query = $this->db->get();

        return $query->row_array();
    }
    
//    function getChildMenu($menuAlias) {
//        $query = $this->db->query('SELECT *,(select menu_alias from s_menu where id=(select menu_parent from s_menu where menu_type="frontend" and menu_alias="'.$menuAlias.'")) as parent_menu FROM '.$this->_table.' as menu  
//            where menu.menu_active="Y" and menu.menu_type="frontend" and menu.menu_parent = (select menu_parent from s_menu where menu_alias="'.$menuAlias.'")
//            order by menu.menu_order asc');
//        $resultQuery = $query->result_array();
//          
//        return $resultQuery;
//        
//    }
    function getChildMenu($menuAlias) {
        $query = $this->db->query('SELECT *,(select menu_alias from s_menu where menu_type="frontend" and id=(select id from s_menu where menu_type="frontend" and menu_alias="'.$menuAlias.'")) as parent_alias,
            (select menu_name from s_menu where menu_type="frontend" and id=(select id from s_menu where menu_type="frontend" and menu_alias="'.$menuAlias.'")) as parent_menu_name,
            (select menu_name_en from s_menu where menu_type="frontend" and id=(select id from s_menu where menu_type="frontend" and menu_alias="'.$menuAlias.'")) as parent_menu_name_en,
            (select menu_web_link from s_menu where menu_type="frontend" and id=(select menu_parent from s_menu where menu_type="frontend" and menu_alias="'.$menuAlias.'")) as web_link FROM '.$this->_table.' as menu  
            where menu.menu_active="Y" and menu.menu_type="frontend" and menu.menu_parent = (select id from s_menu where menu_type="frontend" and menu_alias="'.$menuAlias.'")
            order by menu.menu_order asc');
        $resultQuery = $query->result_array();
          
        return $resultQuery;
        
    }
    
    function getSameMenu($where = array()) {
        $this->db->select("menu.*");
        $this->db->from("$this->_table as menu");

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
        if ($query) {
            $resultQuery = $query->result_array();
            return $resultQuery;
        } else {
            $ErrMsg = 'The searched item records requested cannot be retrieved because';
            return false;
        }
    }
}