<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends MY_Controller {
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url'); 
        $this->load->model(array('help_model'));
    }

    function index(){ 
        $help_data = $this->help_model->getAll();
        $this->data['title'] = 'Help';
        $this->data['helpData'] = $help_data;
        $this->data['content'] = 'help/index'; 
        $this->load->view('layout', $this->data);
        
    }
    public function save(){
        $inputArray = $this->input->post();
        if(isset($inputArray['id'])){ 
            $updateHelp = $this->help_model->update($inputArray);
            redirect('help');
        }else{
            echo 'new help';
        }
    }
}
?>