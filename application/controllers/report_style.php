<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_style extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('report_style_model'));
    }

    function index(){
            
        $this->data['title'] = 'Master Data - Report Style';
        $this->data['content'] = 'report_style/index';
//        $this->data['dataList'] = $this->report_style_model->getByCategory(array('bse_ctgr'=>'left'));
//        if ($this->session->userdata('user_group') == '00') {
//            $this->data['dataList'] = $this->report_style_model->getByCategory();
//        } else {
//            $this->data['dataList'] = $this->report_style_model->getData($this->_limit,'',array('bse_type'=>'frontend'),'where');
//        }
        
        $this->data['dataList'] = $this->report_style_model->getData($this->_limit,'',array(),'where','acc_num,ASC');
        $this->data['totaldata'] = sizeof($this->report_style_model->getAll());
        $this->data['pnumber'] = 1;
        
        $this->load->view('layout', $this->data);
    }
        
    function paging() {
        $whereSearch = array();
        $pnumber = ($this->input->post('pnum')) ? $this->input->post('pnum') : 0;
        $paging = strtolower($this->input->post('page'));
        $limit = $this->input->post('limit');
        $totaldata = $this->input->post('totaldata');
        $searhDesc = $this->input->post('search');
        $fields = $this->input->post('fields');
        $page = $limit;
        if ($paging && $paging != 'page') {
            if ($paging == 'first') {
                $limit = 0;
                $page = $this->_limit;
                $pnumber = 1;
            } else if ($paging == 'last') {
                $limit = $totaldata-10;
                $page = $this->_limit;
                $pnumber = ceil($totaldata/10);
            } else if ($paging == 'next') {
                $page += 10;
                $limit = $page;
                $pnumber = $pnumber+1;
            } else if ($paging == 'prev') {
                if ($limit > 0) {
                    $page -= 10;
                }
                $limit = $page;
                if ($pnumber > 1) {
                    $pnumber = $pnumber-1;
                }
            } else {
                $limit = $totaldata;
            }
        } else if ($paging == 'page') {
            if ($pnumber > 0){
                $limit = (($this->_limit*$pnumber) - $this->_limit);
            } else if ($pnumber == 0){
                $limit = 0;
            }
        }  
        
        if ($searhDesc) {
            $searchDetail = explode(",",$fields);
            foreach($searchDetail as $valDetail){
                $whereSearch[$valDetail] = $searhDesc;
            }
        }
        
        $totalData = $this->report_style_model->getData(0,$limit,$whereSearch,'or_like');
        $result = $this->report_style_model->getData($this->_limit,$limit,$whereSearch,'or_like');
        
        $newData = '';
        if ($result) {
            $newData .= $this->searchTemplate($result);
        }
        
        $jsonData['result'] = 'success';
        $jsonData['pnumber'] = $pnumber;
        $jsonData['limit'] = $limit;
        $jsonData['totaldata'] = sizeof($totalData);
        $jsonData['template'] = $newData;
        echo json_encode($jsonData,true);
    }
    
    function searchTemplate($data) {
        $template = '';
        foreach($data as $index => $value) {
            $template .= '<tr class="odd" role="row">
                                <td><input type="checkbox" class="delcheck" value="'.$value['id'].'" /></td>
                                <td><a href="#modal_form_bse" data-toggle="modal" data-id="'.$value['id'].'" data-id_bse="'.$value['id_bse'].'" data-id_bse_map="'.$value['id_bse_map'].'" data-name="'.$value['bse_name'].'" data-bse_level="'.$value['bse_level'].'" data-active="'.$value['active_status'].'">'.$value['id_bse'].'</a></td>
                                <td>'.$value['id_bse_map'].'</td>
                                <td>'.$value['bse_name'].'</td>
                                <td>'.$value['bse_level'].'</td>
                                <td>'.(($value['active_status'] == '1') ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Not Active</span>').'</td>
                            </tr>';

        }
        return $template;
    }
    
    /* add bse*/
    function add() {
        $dataTables = array();
        $bseParent = '';
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->report_style_model->getByCategory($where);
            $bseParent = $dataTables[0]['bse_parent'];
            $this->data['title'] = 'Menu - Edit';
        } else {
            $this->data['title'] = 'Menu - Add';
        }
        
        if ($this->session->userdata('user_group') == '00') {
            $bseList = array_merge($this->getAllMenuWeb(''));
        } else {
            $bseList = $this->getAllMenuWeb('left');
        }
        
        if ($this->session->userdata('user_group') == '00') {
//            $this->data['bseType'] = $this->bseType;
        } 
        $this->data['bseCtgr'] = $this->bseCtgr;
        $this->data['modul'] = $this->modules;
        $this->data['bseList'] = '<select class="select" id="bse_parent" name="bse_parent"><option value="">--PILIH SATU--</option>'.$this->bseSelect($bseList, $bseParent).'</select>';
        $this->data['content'] = 'bse/add';
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }
    
    
    
    function save() {
        if ($this->input->post('btncancel')) {
             redirect('report_style/index');
             return;
        }
        $postData = array();
        $new = true;
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
            
        }
        $postData = $this->input->post();
        if (!isset($postData['active_status'])) {
            $postData['active_status'] = '0';
        }
        
        if ($this->input->post('id')) {
            $postData['id'] = trim($this->input->post('id'));
        }
        
        if ($new) { // add
            $id = $this->report_style_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            
            $this->report_style_model->update($postData);
        }
        
        redirect('report_style/index');
    }
    
    /*deleting bses and also deleting ACL by bse id*/
    function delete() {
        $this->load->model(array('acl_model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach($data as $value) {
                $this->report_style_model->delete($this->report_style_model->_table,array('id'=>$value['id']));
                $this->acl_model->delete($this->acl_model->_table,array('acl_resource'=>'bse'.$value['id']));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }
    
    function bseSelect($data, $select = '', $margin=0) {
        if ($data) {
            $selectMenu = '';
            $selected = '';
            foreach($data as $index => $item) {
                if ($item['bse_parent'] == 0) {
                    $margin = 0;
                }
                if ($select == $item['id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                
                $selectMenu .= '<option value="'.$item['id'].'" '.$selected.' style="margin-left:'.$margin.'px;">'.$item['bse_name'].'</option>';
                if (isset($item['child'])) {
                    $margin += 10;
                    $selectMenu .= $this->bseSelect($item['child'], $select,  $margin);
                    $margin -= 10;
                } 
            }
        }
        
        return $selectMenu;
    }
}
?>