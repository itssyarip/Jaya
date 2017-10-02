<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
    }
    
    function index(){
        $this->data['title'] = 'Dashboard';
        $this->data['content'] = 'index/index';
        $this->data['new_user'] = $this->session->userdata('is_new');
        $this->load->view('layout', $this->data);
    }
}
