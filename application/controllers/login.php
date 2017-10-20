<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('user_admin_model', 'acl_model'));
    }

    function index()
    {
        if(isset($this->session->userdata['login'])){
            redirect('index/index');
        }else{
            $this->data['modules'] = $this->modules;
            $this->load->view('login',$this->data);
        }
    }
    function ldap_auth($username, $password) {
        $config_ldap_file_path = APPPATH.'config/ldap.config.php'; 
        $config_ldap_is_set = file_exists($config_ldap_file_path) && include_once($config_ldap_file_path);	
        
        if($config_ldap_is_set === true) {
          $userIsValidPassword = $this->isValidPasswordLdap($username, $password, $config_ldap);
          
        } else {
            $userIsValidPassword = false;
        }
        return $userIsValidPassword;
    }
    
    function isValidPasswordLdap($user, $password, $config) {
        $ldap = ldap_connect($config['host'],$config['port']);
        if (!$ldap) {       
                return false;
        }
        
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
                
        $bind_result = @ldap_bind($ldap,$config['binddn'],$config['bindpw']) or die("Could not bind to server");

        if ($bind_result) {
            $filter = '(&(uid='.$user.'))';
            $search = ldap_search($ldap,$config['basedn'], $filter);
            $info = ldap_get_entries($ldap,$search);
            if ($info) {
                $pwBind=@ldap_bind($ldap,$info[0]['dn'],$password);
                if (!$pwBind) {
                    return false;
                } else {
                    
                    return true;
                } 
            }
        } else {
            return false;
        }
    }
    
    function process_login(){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
//        $ldapAuth = $this->ldap_auth($username, $password);
//        
//        if ($ldapAuth) {
//            // we should check into ldap_table by username, if not exist then create a new one
//            echo 'LDAP SUCCESS';exit;
//        } else {
//            echo 'LDAP GAGAL';exit;
//        }
        $input = array('user_name' => $username, 'user_pass' => md5($password));
        $data = $this->user_admin_model->check_user($input);
        if($data){
            $this->load->model(array('group_model'));
            $data['success'] = true;
            //get the group level
            $groupLevel = '';
            $groupData = $this->group_model->getLevel($data['user_group']);
            if(sizeof($groupData) > 0) {
                $groupLevel = $groupData[0]['group_level'];
            }
            //get business unit access
            $this->load->model(array('access_unit_model'));
            $accessBSE = $this->access_unit_model->getAclData($data['user_group']);
            $bseACl = '';
            if ($accessBSE) {
                foreach($accessBSE as $index => $value) {
                    if ($bseACl == '') {
                        $bseACl = "'".$value['id_bse']."'";
                    } else {
                        $bseACl .= ','."'".$value['id_bse']."'";
                    }
                }
            }
            $input_session = array('user_id' => $data['id'],'user_name' => $data['user_name'],'user_real_name' => $data['user_real_name'], 'login' => TRUE, 'user_group' => $data['user_group'],
                                   'user_type' => $data['user_type'],'group_level'=>$groupLevel,'is_new'=>$data['is_new'], 
                                   'user_image'=>$data['user_image'],'modules'=>$this->input->post('modules'),'access_bse'=> $bseACl);
            $this->session->set_userdata($input_session);
        } else {
            $data['success'] = false;
        }
        
        header("Content-type: application/json");
        print json_encode($data);
    }

    
    function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }
}
