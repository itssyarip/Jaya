<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('category_model'));
    }

    function index(){
            
        $this->data['title'] = 'Master Data - Category';
        $this->data['content'] = 'category/index';
        $this->data['dataList'] = $this->category_model->getData($this->_limit);
        $this->data['totaldata'] = sizeof($this->category_model->getAll());
        $this->data['pnumber'] = 1;
        $this->load->view('layout', $this->data);
        
    }
        
    
    /* add menu*/
    function add() {
        $dataTables = array();
        $menuParent = '';
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->category_model->getByCategory($where);
            $menuParent = $dataTables[0]->menu_parent;
            $this->data['title'] = 'Category - Edit';
        } else {
            $this->data['title'] = 'Category - Add';
        }
        
        //get jenis jaminan
        $menuList = $this->getAllMenuWeb('left');
        
        $this->data['menuList'] = '<select id="menu_parent" name="menu_parent"><option value="">--PILIH SATU--</option>'.$this->menuSelect($menuList, $menuParent).'</select>';
        $this->data['content'] = 'menu/add';
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }
    
    
    
    function save() {
        $postData = array();
        $new = true;
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
            
        }
        $postData = $this->input->post();
        if ($new) { // add
            $id = $this->category_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $postData['id'] = trim($this->input->post('id'));
            $this->category_model->update($postData);
        }
        
        redirect('category/index');
    }
    /*deleting menus and also deleting ACL by menu id*/
    function delete() {
        $this->load->model(array('acl_model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach($data as $value) {
                $this->category_model->delete($this->category_model->_table,array('id'=>$value['id']));
                $this->acl_model->delete($this->acl_model->_table,array('acl_resource'=>'menu'.$value['id']));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }
    
    function menuSelect($data, $select = '', $margin=0) {
        if ($data) {
            $selectMenu = '';
            $selected = '';
            foreach($data as $index => $item) {
                if ($item['menu_parent'] == 0) {
                    $margin = 0;
                }
                if ($select == $item['id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                
                $selectMenu .= '<option value="'.$item['id'].'" '.$selected.' style="margin-left:'.$margin.'px;">'.$item['menu_name'].'</option>';
                if (isset($item['child'])) {
                    $margin += 10;
                    $selectMenu .= $this->menuSelect($item['child'], $select,  $margin);
                    $margin -= 10;
                } 
            }
        }
        
        return $selectMenu;
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
                $pnumber = round($totaldata/10);
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
        $totalData = $this->category_model->getData(0,$limit,$whereSearch,'or_like');
        $result = $this->category_model->getData($this->_limit,$limit,$whereSearch,'or_like');

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
            $template .= '<tr class="odd gradeX">
                                <td><input type="checkbox" class="delcheck" value="'.$value['id'].'" /></td>
                                <td><a href="#add_category" class="edit-category" data-toggle="modal" data-id="'.$value['id'].'" data-ctgr_name="'.$value['ctgr_name'].'">'.$value['ctgr_name'].'</a></td>
                            </tr>';

        }
        return $template;
    }
}
?>