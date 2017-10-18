<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

    private static $instance;
    protected $_limit = 5;
    protected $month = array('1'=>'Januari',
                             '2'=>'Februari',
                             '3'=>'Maret',
                             '4'=>'April',
                             '5'=>'Mei',
                            '6'=>'Juni',
                            '7'=>'Juli',
                            '8'=>'Agustus',
                            '9'=>'September',
                            '10'=>'Oktober',
                            '11'=>'November',
                            '12'=>'Desember');
    
    protected $modules = array(''=>'-- PILIH SATU --',
                                   'lg'=>'Ledger',
                                   'tt'=>'Transaksi Penerimaan',
                                   'tk'=>'Transaksi Pengeluaran',
                                   'ra'=>'Rencana Anggaran');
    /**
     * Constructor
     */
    public function __construct() {
        self::$instance = & $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->$var = & load_class($class);
        }

        $this->load = & load_class('Loader', 'core');

        $this->load->initialize();
        $this->load->library('session');
        log_message('debug', "Controller Class Initialized");
    }

    public static function &get_instance() {
        return self::$instance;
    }

    public function encrypt_password($pw) {
        $salt = $this->config->item('secure_salt');
        return crypt($pw, $salt);
    }

    function getHeaderMenu($ctgr, $type = 'backend', $parent = '', $alias = '') {
        $this->load->model(array('menu_model'));
        $result = $this->menu_model->getLeftMenu($parent, $ctgr, $type,$alias);


        $temp = array();
        if (count($result)) {
            foreach ($result as $row => $value) {
//                if ($acl) {
//                    if (!isset($acl['menu' . $value['id']])) {
//                        unset($value);
//                    } else {
//                        $temp[] = $value;
//                        $child = $this->menu_model->getLeftMenu($value['id'], $ctgr, $type);
//                        if (count($child)) {
//                            foreach ($child as $rowChild => $valueChild) {
//                                $temp[$row]['child'][] = $valueChild;
//
//                                $childLevel = $this->menu_model->getLeftMenu($valueChild['id'], $ctgr, $type);
//                                if ($childLevel) {
//                                    foreach ($childLevel as $rowChildLevel => $valueChildLevel) {
//                                        $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                } else {
                    $temp[] = $value;
                    $child = $this->menu_model->getLeftMenu($value['id'], $ctgr, $type);
                    if (count($child)) {
                        foreach ($child as $rowChild => $valueChild) {
                            $temp[$row]['child'][] = $valueChild;

                            $childLevel = $this->menu_model->getLeftMenu($valueChild['id'], $ctgr, $type);
                            if ($childLevel) {
                                foreach ($childLevel as $rowChildLevel => $valueChildLevel) {
                                    $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
                                }
                            }
                        }
                    }
//                }
            }
        }
        return $temp;
    }

    function getAllMenuWeb($ctgr, $type = 'backend') {
        $this->load->model(array('menu_model'));
        $result = $this->menu_model->getLeftMenu('', $ctgr, $type);

        $temp = array();
        if (count($result)) {
            foreach ($result as $row => $value) {
                //get child
                $temp[] = $value;
                $child = $this->menu_model->getLeftMenu($value['id'], $ctgr, $type);
                if (count($child)) {
                    foreach ($child as $rowChild => $valueChild) {
                        $temp[$row]['child'][] = $valueChild;

                        $childLevel = $this->menu_model->getLeftMenu($valueChild['id'], $ctgr, $type);
                        if ($childLevel) {
                            foreach ($childLevel as $rowChildLevel => $valueChildLevel) {
                                $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
                            }
                        }
                    }
                }
            }
        }
        return $temp;
    }
    
    function getfolder($mainDir='',$subDir ='') {
        $realpath = str_replace("\\", "/", realpath('images'));
        if ($mainDir != '') {
            $id = $mainDir;
        } else {
            $id = $this->input->post('id');
        }
        $temp = '';
        if ($id != '') {
            //get all folder
           if(is_dir($realpath.'/gallery/'.$id)) {
            $dirScan = scandir($realpath.'/gallery/'.$id);
            $temp = $this->getsubFolder($id,$dirScan,$subDir);
            if ($temp == '') {
                $result['subfolder'] = array();
            } else {
                $result['subfolder'] = $temp;
            }
           }
            return $temp;
        }
    }
    
    function getsubFolder($mainDir,$dirScan,$subDir='') {
        $temp = '<ul class="dropdown-menu">'; 
        
        foreach($dirScan as $idx =>$value) {
            
            if ($value == '.' || $value == '..') continue;
           
            $temp .= '<li><a href="'.base_url().'gallery/detail/'.$mainDir.'/'.$value.'" tabindex="-1">'.$value.'</a></li>';
        }
        $temp .= '</ul>';
        return $temp;
    }
    
    function getParentMenu($menuAlias,$menuWebLink = '') {
        $temp = array();
        
        if ($menuWebLink != '') {
            $breadCrum = $this->menu_model->getByCategory(array('menu_web_link'=>$menuWebLink));
        } else {
            $breadCrum = $this->menu_model->getByCategory(array('menu_alias'=>$menuAlias));
            
        }

        if ($breadCrum) {
            if($breadCrum[0]['menu_parent'] > 0) {
                $parent = $this->menu_model->getByCategory(array('id'=>$breadCrum[0]['menu_parent']));
                $child = $this->menu_model->getParentMenu($breadCrum[0]['id']);
                if ($child) {
                    $temp[]= $breadCrum[0]['menu_name'.$this->session->userdata('lang')];
                } else {
                    $temp[]= $breadCrum[0]['menu_name'.$this->session->userdata('lang')];
                }
                if ($parent[0]['menu_parent'] > 0 ) {
                    $temp = array_merge($temp,$this->getParentMenu($parent[0]['menu_alias']));
                } 
                else if($parent[0]['menu_parent'] == 0){
                    $temp[]= $parent[0]['menu_name'.$this->session->userdata('lang')];
                } 
            } else {
            $temp[]= $breadCrum[0]['menu_name'.$this->session->userdata('lang')];
                
            }
        }
        return $temp;
    }

}

// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */