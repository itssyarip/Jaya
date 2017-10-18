<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Admin extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('user_admin_model'));
    }

    
    function index(){
        
        $this->data['title'] = 'User';
        $this->data['content'] = 'user_admin/index';
//        $data['users'] = $this->util_model->get_all_data('user');
        
        if ($this->session->userdata('user_group') && $this->session->userdata('user_group') != '00') {
            $where['user_group not in("00")']='';
            $this->data['userData'] = $this->user_admin_model->getData($this->_limit,'',$where,'where');
        } else {
            
            $this->data['userData'] = $this->user_admin_model->getData($this->_limit);
        }
        
        $this->data['totaldata'] = sizeof($this->user_admin_model->getAll());
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
        
        $totalData = $this->user_admin_model->getData(0,$limit,$whereSearch,'or_like');
        $result = $this->user_admin_model->getData($this->_limit,$limit,$whereSearch,'or_like');
        
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
                                <td><a href="#" onclick="javascript:add_users(\''.base_url().'\', \''.$value['id'].'\');">'.$value['user_name'].'</a></td>
                                <td>'.(isset($value['user_real_name']) ? $value['user_real_name'] : '').'</td>
                            </tr>';

        }
        return $template;
    }
    
    function add() {
        $this->load->model(array('group_model'));
        $dataTables = array();
        $whereGroup = array();
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->user_admin_model->getByCategory($where);
        }
        
        
        $this->data['title'] = 'User - Add';
        $this->data['content'] = 'user_admin/add';
        
//        if($this->session->userdata('user_type') == ''){
//            $this->data['groupData'] = $this->group_model->getAll();
//        }else{
//            $this->data['groupData'] = $this->group_model->getByCategory(array('group_type'=>$this->session->userdata('user_type')));
//        }
        /*check the group type(dmsolidwood or calculator and check the group_level to show child group*/
        if($this->session->userdata('user_type') != ''){
            $whereGroup['group_type'] = $this->session->userdata('user_type');
        }
        
        $whereGroup['group_level >='] = $this->session->userdata('group_level');
        $this->data['groupData'] = $this->group_model->getByCategory($whereGroup);
        /*end check group*/
//        $this->data['kategoriData'] = $this->kategori_model->getAll();
//        $this->data['userType'] = $this->_appType;
//        $this->data['lokasiData'] = $this->prepareList($this->lokasi_model->getAll(), 'id', array('lks_name'),true);
//        $this->data['divisiData'] = $this->prepareList($this->divisi_model->getAll(), 'id', array('dvs_name'),true);
//        $this->data['jabatanData'] = $this->prepareList($this->jabatan_model->getAll(), 'id', array('jbtn_name'),true);
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }
    
     public function save() {
        if ($this->input->post('btncancel')) {
             redirect('user_admin/index');
             return;
        }
        
        $postData = array();
        $new = true;
        $success =  true;
        $message = 'Data berhasil tersimpan';
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
        }
        $postData = $this->input->post();
        $postData['user_group'] = implode(',',$postData['user_group']);    
        if(isset($postData['user_ctgr_wf'])){
            $postData['user_ctgr_wf'] = implode(',',$postData['user_ctgr_wf']);
        }
        if ($postData['user_pass'] == '') {
           unset($postData['user_pass']);
        } else {
            $postData['user_pass'] = md5((string)$postData['user_pass']);
        }
        unset($postData['user_pass_retype']);
        if ($new) { // add
            $id = $this->user_admin_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $postData['id'] = trim($this->input->post('id'));
            $this->user_admin_model->update($postData);
        }
        
        if($this->session->userdata('user_type') == 'wf'){
            redirect('dmsolidwood_admin/manage_user');
        }else{
            redirect('user_admin/index');
        }
    }

    function delete() {
        $this->load->model(array('acl_model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach($data as $value) {
                $dataUser = $this->user_admin_model->check_user(array('id'=>$value['id']));
                if ($dataUser) {
                    $this->user_admin_model->delete($this->user_admin_model->_table,array('id'=>$value['id']));
                    /*if ($dataUser['user_group'] != '') {
                        $group = explode(',', $dataUser['user_group']);
                        foreach ($group as &$value){
                            $value = trim($value);
                            $this->acl_model->delete($this->acl_model->_table,array('acl_role'=>$value));
                        }
                    }*/
                }
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }
    
    public function change_password(){
       
        $oldPassword = '';
        $newPassword = $this->input->post('user_pass');
        $id_user = $this->session->userdata('user_id');
         
        $update_password = $this->user_admin_model->update_password($oldPassword, $newPassword, $id_user);
        
        //force to login
        $result['message'] = $update_password;
        
        header("Content-type: application/json"); 
        echo json_encode($result);
    }
    
    function upload(){
        $this->load->model(array('user_admin_model','lokasi_model','divisi_model','jabatan_model'));
        $fileName= $_FILES['csvdata']['tmp_name'];
        $fh = fopen($fileName, "r");
        $amount = 0;
        $messages = array();
        $start = true;
        
        while (($fields = fgetcsv($fh, 0))) {
            $new = true;
            
            //$fields = explode('|', $rows[$i]);
            if ($start) {
                $start = false;
                continue;
            }
            
            $amount++;
            $saveData = array();
            
            $saveData['id'] = null;
            $saveData['user_real_name'] = strtoupper(trim($fields[0]));
            //check lokasi_id
            $dataLokasi = $this->lokasi_model->getByCategory(array('lks_name'=>trim($fields[1])));
            $dataDivisi = $this->divisi_model->getByCategory(array('dvs_name'=>strtoupper(trim($fields[2]))));
            $dataJabatan = $this->jabatan_model->getByCategory(array('jbtn_name'=>strtoupper(trim($fields[3]))));
            if ($dataLokasi && sizeof($dataLokasi) > 0) {
                $saveData['user_lokasi_id'] = $dataLokasi[0]->id;
            }
            if ($dataDivisi && sizeof($dataDivisi) > 0) {
                $saveData['user_divisi_id'] = $dataDivisi[0]->id;
            }
            if ($dataJabatan && sizeof($dataJabatan) > 0) {
                $saveData['user_jbtn_id'] = $dataJabatan[0]->id;
            }
            
            $saveData['user_email'] = trim($fields[4]);
            $loginData = explode('@',$saveData['user_email']);
            if($loginData) {
                $saveData['user_name'] = $loginData[0];
            }
            
            $saveData['user_type'] = 'wf';
           
            if ($this->input->post('pass_default') != '') {
                $saveData['user_pass'] = md5($this->input->post('pass_default'));
            }
            
            if ($fields[5] != '') {
                
                $this->load->model(array('group_model'));
                $dataGroup = explode(',',$fields[5]);
                $group = '';
                
                foreach($dataGroup as $value) {
                    $groupCode = $this->group_model->getByCategory(array('group_name'=>strtoupper(trim($value))));
                    if ($groupCode) {
                        if ($group == '') {
                            $group = $groupCode[0]['group_code'];
                        } else {
                            $group .= ','.$groupCode[0]['group_code'];
                        }
                    }
                }
                $saveData['user_group'] = $group;
            } else {
                $saveData['user_group'] = '06';
            }
            $saveData['user_ctgr_wf'] = '1,2';
            $checkData = $this->user_admin_model->getByCategory(array('user_name'=>$saveData['user_name']));
            if ($checkData) { //update
                $saveData['id'] = $checkData[0]->id;
                $new = false;
            }
            try {
                if ($new) {                    
                    $this->user_admin_model->add($saveData);
                } else {
                    $this->user_admin_model->update($saveData);
                }
                
            } catch (Exception $e) {
                $messages[] = array('id' => $amount, 'description' => $e->getMessage());
            }
        }

        redirect('user_admin/index');
    }
}
