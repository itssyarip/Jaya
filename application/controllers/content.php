<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('url');
        $this->load->model(array('content_model', 'content_detail_model'));
    }

    function index() {
        $this->data['title'] = 'Master Data - Content';
        $this->data['content'] = 'content/index';
        $this->data['contentData'] = $this->content_model->getAllData();
        $this->data['totaldata'] = sizeof($this->content_model->getAll());
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
                $pnumber = round($totaldata / 10);
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
        $totalData = $this->content_model->getAllData(0, $limit, $whereSearch, 'or_like');
        $result = $this->content_model->getAllData($this->_limit, $limit, $whereSearch, 'or_like');

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
            $template .= '<tr class="odd gradeX">
                                <td><input type="checkbox" class="delcheck" value="' . $value['id'] . '" /></td>
                                <td><a href="#" onclick="javascript:add_data(\'' . base_url() . '\', \'' . $this->router->fetch_class() . '\', \'' . $value['id'] . '\');">' . $value['menu_name'] . '</a></td>
                            </tr>';
        }
        return $template;
    }

    function add() {

        $dataTables = array();
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->content_model->getByCategory($where);
            $this->data['title'] = 'Content - Edit';
            //get menu
            $this->data['menuList'] = $this->parentAction($dataTables[0]['menu_alias']);
            $detailData = $this->content_detail_model->getByCategory(array('cntn_id' => $this->uri->segment(3)));
            if ($detailData) {
                $htmlArea = '';
                foreach ($detailData as $index => $value) {
                    $htmlArea .= $this->add_content_file($value);
                }

                $this->data['childData'] = $htmlArea;
            }
        } else {
            $this->data['title'] = 'Content - Add';
            //get menu
            $this->data['menuList'] = $this->parentAction();
        }

        $this->data['content'] = 'content/add';
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }

    public function parentAction($id = 0) {
        $ctgr = 'header';
        $type = 'frontend';
        $result = $this->_printParentSelect($type, $ctgr, $id);


        return $result;
    }

    private function _printParentSelect($type, $ctgr, $val) {
        $this->load->model(array('menu_model'));
        $result = '<select style="height:30px; width:198px;" class="app_form_text upper_case" id="menu_alias" name="menu_alias" tabindex="1">';
        if ($ctgr && $type) {
//            $menus = $this->menu_model->getByCategory(array('menu_ctgr'=>$ctgr,'menu_type'=>$type));
            $menus = $this->getAllMenuWeb('header', 'frontend');

            if ($menus) {

                $result .= '<option value="0">---</option>';
                $result .= $this->_printChild($menus, 1, $val);
            } else {
                $result .= '<option value="0">---</option>';
            }
        }

        $result .= '</select>';
        return $result;
    }

    private function _printChild($data, $level = 1, $val = null) {
        $padding = $level * 10;
        $result = '';
        foreach ($data as $item) {
            $selected = '';

            if ($val == $item['menu_alias']) {
                $selected = ' selected="selected" ';
            }
            $result .= '<option style="margin-left: ' . $padding . 'px" value="' . $item['menu_alias'] . '" ' . $selected . '>' . $item['menu_name'] . '</option>';
            if (isset($item['child'])) {
                $result .= $this->_printChild($item['child'], $level + 1, $val);
            }
        }

        return $result;
    }

    function save() {
        if ($this->input->post('btncancel')) {
            redirect('content/index');
            return;
        }
        $postData = array();
        $new = true;
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
        }

        $postData = $this->input->post();

        if ($postData['menu_alias'] == '0') {
            redirect('content/add');
            return;
        }

        //check content
        $where = array();
        $where['menu_alias'] = $postData['menu_alias'];
        $postData['content_data'] = stripslashes($postData['content_data']);
        $postData['content_data_en'] = stripslashes($postData['content_data_en']);
        $checkData = $this->content_model->getByCategory($where);
        if ($checkData) {

            $new = false;
            $postData['id'] = $checkData[0]['id'];
        }

        $childId = '';
        $childTitle = '';
        $childTitleEn = '';

        if (isset($postData['cntn_id'])) {
            $childId = $postData['cntn_id'];
            unset($postData['cntn_id']);
        }

        if (isset($postData['cntn_detail_title'])) {
            $childTitle = $postData['cntn_detail_title'];
            unset($postData['cntn_detail_title']);
        }

        if (isset($postData['cntn_detail_title_en'])) {
            $childTitleEn = $postData['cntn_detail_title_en'];
            unset($postData['cntn_detail_title_en']);
        }

        if (!isset($postData['is_homepage'])) {
            $postData['is_homepage'] = 'N';
        }
        if ($new) { // add
            $id = $this->content_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $id = $postData['id'] = trim($this->input->post('id'));
            $this->content_model->update($postData);
        }

        if ($childTitle != '') {
            for ($i = 0; $i <= sizeof($childTitle) - 1; $i++) {
                $temp = array();
//            $tempFile = array();
                $temp['id'] = $childId[$i];
                $temp['cntn_detail_title_en'] = $childTitleEn[$i];
                $temp['cntn_detail_title'] = $childTitle[$i];
                $this->load->library('upload');
                $files = $_FILES;
                $ext = pathinfo($_FILES['cntn_detail_file']['name'][$i], PATHINFO_EXTENSION);
                if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx') {
                    if ($_FILES['cntn_detail_file']['size'][$i] > 0) {
                        $fileName = str_replace(" ", "_", $_FILES['cntn_detail_file']['name'][$i]);
                        $_FILES['userfile']['name'] = $files['cntn_detail_file']['name'][$i];
                        $_FILES['userfile']['type'] = $files['cntn_detail_file']['type'][$i];
                        $_FILES['userfile']['tmp_name'] = $files['cntn_detail_file']['tmp_name'][$i];
                        $_FILES['userfile']['error'] = $files['cntn_detail_file']['error'][$i];
                        $_FILES['userfile']['size'] = $files['cntn_detail_file']['size'][$i];

                        if (!file_exists('./uploaded_file/content')) {
                            mkdir('./uploaded_file/content', 0777, true);
                        }
                        $pathFile = 'uploaded_file/content';
                        $this->upload->initialize($this->set_upload_options($fileName, $pathFile));
                        $this->upload->data();
                        if (!$this->upload->do_upload()) {
                            $error = array('error' => $this->upload->display_errors());
                            print_r($error);
                        }
                        $temp['cntn_detail_file_path'] = $pathFile . '/' . $fileName;
                        $temp['cntn_detail_file_name'] = $fileName;
                    } else {
                        $temp['cntn_detail_file_path'] = '';
                        $temp['cntn_detail_file_name'] = '';
                    }
                }
//            $tempFile['ltgs_cntn_parent'] = $childTitle[$i];
//            else {
//                $tempFile['ltgs_child_parent'] = '';
//                $tempFile['cntn_detail_file_path'] = '';
//                $tempFile['cntn_detail_file_name'] = '';
//            }
//            $fileData[] = $tempFile;
//            $childData[]=$temp;
                if ($temp['id'] == '') {
                    $temp['cntn_id'] = $id;
                    $this->content_detail_model->add($temp);
                } else if ($temp['id'] != '') {
                    //match file in database
                    $dataFile = $this->content_detail_model->getByCategory(array('id' => $temp['id']));
                    if ($dataFile) {
                        foreach ($dataFile as $indexdb => $valueDb) {
                            if ($valueDb['cntn_detail_file_name'] != '' && $temp['cntn_detail_file_path'] == '') {
                                $temp['cntn_detail_file_path'] = $valueDb['cntn_detail_file_path'];
                                $temp['cntn_detail_file_name'] = $valueDb['cntn_detail_file_name'];
                            }
                        }
                    }
                    $this->content_detail_model->update($temp);
                }
            }
        }

        redirect('content/index');
    }

    function set_upload_options($file_name, $pathFile) {
        //  upload an image and document options

        $config = array();
        $config['file_name'] = $file_name;
        $config['upload_path'] = './' . $pathFile;
        $config['allowed_types'] = '*';
        $config['max_size'] = '0'; // 0 = no file size limit
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;

        return $config;
    }

    /* deleting menus and also deleting ACL by menu id */

    function delete() {
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach ($data as $value) {
                $this->content_model->delete($this->content_model->_table, array('id' => $value['id']));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }

    function delete_detail() {
        $idDetail = $this->input->post('iddetail');
        $result = array();
        $this->content_detail_model->delete($this->content_detail_model->_table, array('id' => $idDetail));
        $result['success'] = true;
        $result['message'] = 'Data Berhasil di hapus';
        $result['url'] = '';
        echo json_encode($result);
    }

    function add_content_file($valueData = array()) {
        $temp = '<tr class="odd gradeX">
                    <td><img src="' . base_url() . 'assets/starhotel/images/en_flag.png" style="margin-top:8px;width:20px"/><br/>
                        <textarea type="text" name="cntn_detail_title_en[]">' . (isset($valueData['cntn_detail_title_en']) ? $valueData['cntn_detail_title_en'] : '') . '</textarea>
                    <br/><img src="' . base_url() . 'assets/starhotel/images/indonesia_flag.png" style="margin-top:8px;width:20px"/>
                        <br/>
                        <textarea type="text" name="cntn_detail_title[]">' . (isset($valueData['cntn_detail_title']) ? $valueData['cntn_detail_title'] : '') . '</textarea>
                        <input type="hidden" id="cntn_id[]" name="cntn_id[]" value="' . (isset($valueData['id']) ? $valueData['id'] : '') . '"/></td></td>';
        $temp .='<td><div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input">
                                    <i class="icon-file fileupload-exists"></i> 
                                    <span class="fileupload-preview"></span>
                                </div>
                                <span class="btn btn-file">
                                    <span class="fileupload-new">Pilih File</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file" class="default" id="cntn_detail_file[]" name="cntn_detail_file[]"/>
                                </span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>';
        if (isset($valueData['cntn_detail_file_path'])) {
            $temp .='<div style="word-wrap: break-word;min-width:250px">
  <div style="width:250px"><a href="' . base_url() . $valueData['cntn_detail_file_path'] . '" target="_blank">' . $valueData['cntn_detail_file_name'] . '</a></div></div>
                </div>';
        }
        $temp .= '</td>';
        $temp .= '<td style="width:20px"><img src="' . base_url() . '/assets/wika/images/delete.gif" onclick="javascript:delcontentfile(this,\'' . base_url() . '\', \'' . $this->router->fetch_class() . '\',\'' . (isset($valueData['id']) ? $valueData['id'] : '') . '\')"/></td></tr>';
        $temp .= "<script type='text/javascript'>FormComponents.init();</script>";
        if ($valueData) {
            return $temp;
        } else {
            $data['htmldata'] = $temp;
            echo json_encode($data);
        }
    }

}

?>