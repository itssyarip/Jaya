<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_Account extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('url');
        $this->load->model(array('master_account_model'));
    }

    function index() {
//        $this->load->dbforge();
//
//        $fields = array(
//            'blog_id' => array(
//                'type' => 'INT',
//                'constraint' => 5,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
//            ),
//            'blog_title' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '100',
//                'unique' => TRUE,
//            ),
//            'blog_author' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '100',
//                'default' => 'King of Town',
//            ),
//            'blog_description' => array(
//                'type' => 'TEXT',
//                'null' => TRUE,
//            ),
//        );
//        $this->dbforge->add_key('blog_id', TRUE);
//        $this->dbforge->add_field($fields);
//        $attributes = array('ENGINE' => 'InnoDB');
//        $this->dbforge->create_table('testing_kampret', TRUE, $attributes);
        $this->data['title'] = 'Master Data - Master Account';
        $this->data['content'] = 'master_account/index';

        $this->data['dataList'] = $this->master_account_model->getData($this->_limit, '', array(), 'where', 'acc_num,ASC');
        $this->data['totaldata'] = sizeof($this->master_account_model->getAll());
        $this->data['estimate_group'] = $this->_estimate_group;
        $this->data['estimate_type'] = $this->_estimate_type;
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
                $limit = $totaldata - 10;
                $page = $this->_limit;
                $pnumber = ceil($totaldata / 10);
            } else if ($paging == 'next') {
                $page += 10;
                $limit = $page;
                $pnumber = $pnumber + 1;
            } else if ($paging == 'prev') {
                if ($limit > 0) {
                    $page -= 10;
                }
                $limit = $page;
                if ($pnumber > 1) {
                    $pnumber = $pnumber - 1;
                }
            } else {
                $limit = $totaldata;
            }
        } else if ($paging == 'page') {
            if ($pnumber > 0) {
                $limit = (($this->_limit * $pnumber) - $this->_limit);
            } else if ($pnumber == 0) {
                $limit = 0;
            }
        }

        if ($searhDesc) {
            $searchDetail = explode(",", $fields);
            foreach ($searchDetail as $valDetail) {
                $whereSearch[$valDetail] = $searhDesc;
            }
        }

        $totalData = $this->master_account_model->getData(0, $limit, $whereSearch, 'or_like');
        $result = $this->master_account_model->getData($this->_limit, $limit, $whereSearch, 'or_like');

        $newData = '';
        if ($result) {
            $newData .= $this->searchTemplate($result);
        }

        $jsonData['result'] = 'success';
        $jsonData['pnumber'] = $pnumber;
        $jsonData['limit'] = $limit;
        $jsonData['totaldata'] = sizeof($totalData);
        $jsonData['template'] = $newData;
        echo json_encode($jsonData, true);
    }

    function searchTemplate($data) {
        $template = '';
        foreach ($data as $index => $value) {
            $template .= '<tr class="odd" role="row">
                                <td><input type="checkbox" class="delcheck" value="' . $value['id'] . '" /></td>
                                <td><a href="#modal_form_master_account" data-toggle="modal" data-id="' . $value['id'] . '" data-id_master_account="' . $value['id_master_account'] . '" data-id_master_account_map="' . $value['id_master_account_map'] . '" data-name="' . $value['master_account_name'] . '" data-master_account_level="' . $value['master_account_level'] . '" data-active="' . $value['active_status'] . '">' . $value['id_master_account'] . '</a></td>
                                <td>' . $value['id_master_account_map'] . '</td>
                                <td>' . $value['master_account_name'] . '</td>
                                <td>' . $value['master_account_level'] . '</td>
                                <td>' . (($value['active_status'] == '1') ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Not Active</span>') . '</td>
                            </tr>';
        }
        return $template;
    }

    /* add master_account */

    function add() {
        $dataTables = array();
        $master_accountParent = '';
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->master_account_model->getByCategory($where);
            $master_accountParent = $dataTables[0]['master_account_parent'];
            $this->data['title'] = 'Menu - Edit';
        } else {
            $this->data['title'] = 'Menu - Add';
        }

        if ($this->session->userdata('user_group') == '00') {
            $master_accountList = array_merge($this->getAllMenuWeb(''));
        } else {
            $master_accountList = $this->getAllMenuWeb('left');
        }

        if ($this->session->userdata('user_group') == '00') {
//            $this->data['master_accountType'] = $this->master_accountType;
        }
        $this->data['master_accountCtgr'] = $this->master_accountCtgr;
        $this->data['modul'] = $this->modules;
        $this->data['parent'] = $this->_dummy_parent;
        $this->load->model(array('bse_model'));
        $this->data['unitdata'] = $this->prepareList($this->bse_model->getAll(array("id_bse in (" . $this->session->userdata('access_bse') . ")" => '')), 'id_bse', array('id_bse', 'bse_name'), true);
        $this->data['master_accountList'] = '<select class="select" id="master_account_parent" name="master_account_parent"><option value="">--PILIH SATU--</option>' . $this->master_accountSelect($master_accountList, $master_accountParent) . '</select>';
        $this->data['content'] = 'master_account/add';

        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }

    function save() {
        if ($this->input->post('btncancel')) {
            redirect('master_account/index');
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
            $id = $this->master_account_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {

            $this->master_account_model->update($postData);
        }

        redirect('master_account/index');
    }

    /* deleting master_accounts and also deleting ACL by master_account id */

    function delete() {
        $this->load->model(array('acl_model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach ($data as $value) {
                $this->master_account_model->delete($this->master_account_model->_table, array('id' => $value['id']));
                $this->acl_model->delete($this->acl_model->_table, array('acl_resource' => 'master_account' . $value['id']));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }

    function master_accountSelect($data, $select = '', $margin = 0) {
        if ($data) {
            $selectMenu = '';
            $selected = '';
            foreach ($data as $index => $item) {
                if ($item['master_account_parent'] == 0) {
                    $margin = 0;
                }
                if ($select == $item['id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }

                $selectMenu .= '<option value="' . $item['id'] . '" ' . $selected . ' style="margin-left:' . $margin . 'px;">' . $item['master_account_name'] . '</option>';
                if (isset($item['child'])) {
                    $margin += 10;
                    $selectMenu .= $this->master_accountSelect($item['child'], $select, $margin);
                    $margin -= 10;
                }
            }
        }

        return $selectMenu;
    }

    function get_parent() {
        $parentId = $this->input->post('parentid');
        $dataParent = $this->master_account_model->getData('', '', array('acc_num' => $parentId));
        if ($dataParent) {
            $resultList = array();
            foreach ($dataParent as $index => $value) {
                $resultList[] = $value['acc_num'];
            }
        }
        echo json_encode($resultList);
        exit;
    }

}

?>