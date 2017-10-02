<?php
class Dashboard_model extends CI_Model{  

    function __construct(){
        parent::__construct();    
    }


    function get_id_form($id_user){
        $list_data = array();
        if($this->session->userdata('user_group') == '07'){
            $query1 = $this->db->query('SELECT * FROM t_dmsolidwood_form_user_approve');
            $arrayQuery1 = $query1->result_array();
            $query2 = $this->db->query('SELECT * FROM t_dmsolidwood_form_user_assistant');
            $arrayQuery2 = $query2->result_array();
        }else{
        $query1 = $this->db->query('SELECT * FROM t_dmsolidwood_form_user_approve WHERE FIND_IN_SET('.$id_user.',user_approve)');
        $arrayQuery1 = $query1->result_array();
        $query2 = $this->db->get_where("t_dmsolidwood_form_user_assistant", array('user_assistant' => $id_user));
        $arrayQuery2 = $query2->result_array();
        }
        array_push($list_data, $arrayQuery1);
        array_push($list_data, $arrayQuery2); 
        return $list_data;       
    }

    function get_data_by_assistant($id_user){
        $query = $this->db->get_where("t_dmsolidwood_form_user_assistant", array('user_assistant' => $id_user));        
        $result_array = $query->result_array(); 
        return $result_array;
        
    }

    function get_data_form($id_form, $status_id = 0, $process_id = '',  $category_id){
        $this->db->select("t_dmsolidwood_form.*, t_dmsolidwood_form.status as form_status, t_dmsolidwood_form.user_assistant as count_user_assistant, t_dmsolidwood_form_user_approve.*, t_dmsolidwood_form_user_assistant.*, a_user.user_name as user_name");
        $this->db->from("t_dmsolidwood_form");
        $this->db->join("t_dmsolidwood_form_user_approve", "t_dmsolidwood_form_user_approve.id_form=t_dmsolidwood_form.id", "LEFT");
        $this->db->join("t_dmsolidwood_form_user_assistant", "t_dmsolidwood_form_user_assistant.id_form=t_dmsolidwood_form.id", "LEFT");
        $this->db->join("a_user", "a_user.id=t_dmsolidwood_form_user_approve.user_approve", "LEFT");

        $this->db->where("t_dmsolidwood_form.id", $id_form);
        if($status_id != 0){
            if($status_id == 4){
                $status_id = 1;
                $this->db->where("t_dmsolidwood_form.status", 1);
                $where = "FIND_IN_SET('".$this->session->userdata('user_id')."', t_dmsolidwood_form.user_approve_id)";  
                $this->db->where( $where );
            }
            $this->db->where("t_dmsolidwood_form.status", $status_id);                
        }
        if($process_id != ''){
            $this->db->like('t_dmsolidwood_form.id_process', $process_id);
//            $this->db->or_like('t_dmsolidwood_form.subject_form', $process_id);  
//            $this->db->or_like('t_dmsolidwood_form.title_form', $process_id);  
//            $this->db->or_like('t_dmsolidwood_form.date_create', $process_id);  
        }        
        if($category_id != 0){
            $this->db->like('t_dmsolidwood_form.category_id', $category_id); 
        }
        $result_array = $this->db->get()->result_array(); 
        return $result_array;
    }
    function get_approve($id_form){
        $query = $this->db->get_where("t_dmsolidwood_form_user_approve", array('id_form' => $id_form));
        return $query->result_array();
    }

    function get_assistant($id_form){
        $query = $this->db->get_where("t_dmsolidwood_form_user_assistant", array('id_form' => $id_form));
        return $query->result_array();
    }

    function get_data_form_process($id_form){
        $this->db->select("t_dmsolidwood_form.*, t_dmsolidwood_form.status as form_status, t_dmsolidwood_form_user_approve.*, t_dmsolidwood_form_user_approve.id as form_user_approve_id, a_user.user_name as user_name");
        $this->db->from("t_dmsolidwood_form");
        $this->db->join("t_dmsolidwood_form_user_approve", "t_dmsolidwood_form_user_approve.id_form=t_dmsolidwood_form.id", "LEFT");
        $this->db->join("a_user", "a_user.id=t_dmsolidwood_form_user_approve.user_approve", "LEFT");

        $this->db->where("t_dmsolidwood_form.id", $id_form);
                
        $result_array = $this->db->get()->result_array(); 
        return $result_array;
    }
    function get_data_form_process_active($id_form){
        $query = $this->db->get_where("t_dmsolidwood_form_user_approve", array('id_form' => $id_form, 'status' => 1));
        return $query->result_array();      
    }


}