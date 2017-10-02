<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('url');
        $this->load->model(array('testimonial_model'));
    }

    function index() {

        $this->data['title'] = 'Kesan dan Pesan';
        $this->data['content'] = 'testimonial/index';
//        $data['users'] = $this->util_model->get_all_data('user');
        $this->data['testimonialData'] = $this->testimonial_model->getData($this->_limit,'',array(),'id,ASC');
        $this->data['totaldata'] = sizeof($this->testimonial_model->getAll());
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
        $totalData = $this->testimonial_model->getData(0, 'DESC',$limit, $whereSearch,'','or_like');
        $result = $this->testimonial_model->getData($this->_limit, 'DESC', $limit, $whereSearch,'','or_like');

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
                                <td><a href="#" onclick="javascript:add_data(\'' . base_url() . '\', \'' . $this->router->fetch_class() . '\', \'' . $value['id'] . '\');">' . $value['tstm_name'] . '</a></td>
                                <td>' . $value['tstm_content'] . '</td>
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
            $dataTables = $this->testimonial_model->getByCategory($where);
           
        }
        $this->data['title'] = 'Kesan dan Pesan - Add';
        $this->data['content'] = 'testimonial/add';
//        $this->data['token'] = $this->generate_random_password(10);

        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }
    
    public function save() {
        if ($this->input->post('btncancel')) {
            redirect('testimonial/index');
            return;
        }

        $new = true;
        $success = true;
        $message = 'Data berhasil tersimpan';
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
        }
        $postData = $this->input->post();
        
        if (isset($_FILES['tstm_image'])) {
//            $ext = pathinfo($_FILES['tstm_image']['name'], PATHINFO_EXTENSION); 
            $this->load->library('upload');
            $files = $_FILES;
            $tstmImageName = $_FILES['tstm_image']['name'];
            $_FILES['userfile']['name']= $files['tstm_image']['name'];
            $_FILES['userfile']['type']= $files['tstm_image']['type'];
            $_FILES['userfile']['tmp_name']= $files['tstm_image']['tmp_name'];
            $_FILES['userfile']['error']= $files['tstm_image']['error'];
            $_FILES['userfile']['size']= $files['tstm_image']['size'];
        
            if (!file_exists('./uploaded_file/testimonial')) {
                mkdir('./uploaded_file/testimonial', 0777, true);
            }
            $pathFile = 'uploaded_file/testimonial';
            $this->upload->initialize($this->set_upload_options($tstmImageName,$pathFile)); 
            $this->upload->data(); 
            if ( ! $this->upload->do_upload()){
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            }
            unset($postData['tstm_image']);
            $postData['tstm_file_path'] = $pathFile.'/'.$tstmImageName;
            $postData['tstm_file_name'] = $tstmImageName;
            
        }
        if ($new) { // add
            $id = $this->testimonial_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $postData['id'] = trim($this->input->post('id'));
            $this->testimonial_model->update($postData);
        }
        
        redirect('testimonial/index');
    }

    function set_upload_options($file_name,$pathFile){   
        //  upload an image and document options
        
        $config = array();
        $config['file_name'] = $file_name;
        $config['upload_path'] = './'.$pathFile;
        $config['allowed_types'] = '*';
        $config['max_size'] = '0'; // 0 = no file size limit
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = TRUE; 

        return $config;
    }

    function delete() {
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach ($data as $value) {
                $dataProgram = $this->testimonial_model->getByCategory(array('id' => $value['id']));
                $this->testimonial_model->delete($this->testimonial_model->_table, array('id' => $value['id']));
                $realpath = str_replace("\\", "/", realpath('images'));

                if (is_dir($realpath . '/' . $dataProgram[0]['id'])) {
                    foreach (glob($realpath . '/' . $dataProgram[0]['id'] . "/*.*") as $filename) {
                        if (is_file($filename)) {
                            unlink($filename);
                        }
                    }
                    rmdir($realpath . '/' . $dataProgram[0]['id']);
//                    unlink($realpath.'/thumbnail/'.$dataProgram Diklat[0]['diklat_name_en']);
                }
                if (is_dir($realpath . '/thumbnail/' . $dataProgram[0]['id'])) {
                    foreach (glob($realpath . '/thumbnail/' . $dataProgram[0]['id'] . "/*.*") as $filename) {
                        if (is_file($filename)) {
                            unlink($filename);
                        }
                    }
                    rmdir($realpath . '/thumbnail/' . $dataProgram[0]['id']);
                }
            }

            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }
    
    function export_csv(){
        $this->testimonial_model->export_csv();
    }
}
