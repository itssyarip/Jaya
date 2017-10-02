<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model(array('menu_model'));
        
    }

    
}
