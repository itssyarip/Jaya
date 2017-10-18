<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public $data = array();
    protected $_limit = 10;
    
    protected $menuCtgr = array(''=>'-- PILIH SATU --','header'=>'HEADER',
                                'left'=>'SUB MENU');
    protected $menuType = array(''=>'-- PILIH SATU --','backend'=>'BACKEND',
                                'util'=>'Utilitas');
    protected $_button = array('save'=>'Simpan',
                               'appr'=>'Setuju',
                               'expr'=>'Export',
                               'cancel'=>'Batal');
    protected $_estimate_group = array(''=>'-- PILIH SATU --',
                               'asset'=>'ASSET',
                               'kewajiban'=>'KEWAJIBAN',
                               'modal'=>'MODAL',
                               'beban'=>'BEBAN',
                               'pendapatan'=>'PENDAPATAN');
    protected $_estimate_type = array(''=>'-- PILIH SATU --',
                               'umum'=>'ASSET',
                               'buku_besar'=>'KEWAJIBAN',
                               'detail'=>'MODAL');
    protected $_dummy_parent = array(''=>'-- PILIH SATU --',
                               '1000'=>'1000',
                               '1100'=>'1100',
                               '1110'=>'1110',
                               '1111'=>'1111',
                               '1112'=>'1112');
        
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        
        $this->load->helper('form');
        $this->load->helper('url');
        $login_status = $this->check_login();
        $this->load->model(array('menu_model', 'acl_model'));
        $this->data['menus'] = $this->getMenus();
    }
    
    function getMenus() {
        $acl = $this->getAcl($this->session->userdata('user_group')); 
        if ($this->session->userdata('user_group')=='00') {
            $menus = $this->getAllHeaderMenu('header',array('backend','util'));
        } else {
            $menus = $this->getAllHeaderMenu('header',array('backend'),$this->session->userdata('modules'));
        }
        $menuList = $this->getMenuList($menus, $this->session->userdata('user_name'), $acl);
        
        return $menuList;
    }
    
    function getAcl($groups) {
        $groups = str_replace(',', "','", $groups);
        $groups = "'$groups'";
        $aclData = array();
        $acls = $this->acl_model->getAclsMenu($groups);
        if ($acls) {
            foreach($acls as $value){
                $aclData[] = $value['acl_resource'];
            }
            return $aclData;
        } else {
            return '';
        }

    }
    
    public function getMenuList($data, $user, $acl = null) {
        $result = '';
        if ($acl) {
            $checkAcl = false;
            if ($user and $acl) {
                $checkAcl = true;
            }

            
            foreach ($data as $item) {
                $resourceKey = 'menu'. $item['id'];
                if ($checkAcl) {
                    if (!in_array($resourceKey,$acl)) {
                        continue;
                    }
                }

                if (isset($item['child'])) {
                    $result .= '<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-make-group position-left"></i> '.$item['menu_name'].' <span class="caret"></span>
                                </a>';
                    $result .= $this->getMenuListChildren($item['child'], $user, $acl);
                } else {
                    
                    if ($item['menu_link'] != '') {
                        $result .= '<li><a href="'.base_url().$item['menu_link'].'">'.$item['menu_name'].'</a>';
                    } else {
                        $result .= '<li><a href="'.$item['menu_web_link'].'" target="_blank">'.$item['menu_name'].'</a>';
                    }
                }
                $result .= '</li>';
            }
        }
        return $result;
    }
    
    public function getMenuListChildren($data, $user, $acl = null) {
        $checkAcl = false;
        if ($user and $acl) {
            $checkAcl = true;
        }
        
        $result = '<ul class="dropdown-menu width-250">';
        foreach ($data as $index => $item) {
            
            $resourceKey = 'menu'. $item['id'];
            if ($checkAcl) {
                if (!in_array($resourceKey,$acl)) {
                    continue;
                }
            }
            if (isset($item['child'])) {
                $result .= '<li class="dropdown-submenu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-make-group position-left"></i> '.$item['menu_name'].' <span class="caret"></span>
                                </a>';
                $result .= $this->getMenuListChildren($item['child'], $user, $acl);
            } else {
                if ($item['menu_link'] != '') {
                    $result .= '<li><a href="'.base_url().$item['menu_link'].'">'.$item['menu_name'].'</a>';
                } 
//                else {
//                    $result .= '<li><a href="'.$item['menu_web_link'].'">'.$item['menu_name'].'</a>';
//                }
                
            }
            $result .= '</li>';
        }
        $result .= '</ul>';
        
        return $result;
    }
    
    function getAllHeaderMenu($ctgr,$type = 'backend,util',$module='') {
        if (is_array($type)) {
            $type = implode("','",$type);
            $type = "'".$type."'";
        }
        $result = $this->menu_model->getHeaderMenu(0,$ctgr,$type,$module);
        
        $temp = array();
        if (count($result)) {
            foreach($result as $row => $value) {
                //get child
                $temp[] = $value;
                $child = $this->menu_model->getHeaderMenu($value['id'],'',$type,$module);
                if (count($child)) {
                    foreach($child as $rowChild => $valueChild) {
                        $temp[$row]['child'][] = $valueChild;
                        
                        $childLevel = $this->menu_model->getHeaderMenu($valueChild['id'],'',$type,$module);
                        if ($childLevel) {
                            foreach($childLevel as $rowChildLevel => $valueChildLevel) {
                                $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
                            }
                        }
                    }
                }
            }
        }
        return $temp;
    }
    function getAllMenuWebori($ctgr,$type = 'backend',$module='') {
        if (is_array($type)) {
            $type = implode("','",$type);
            
        } 
        $type = "'".$type."'";
        $result = $this->menu_model->getLeftMenu(0,$ctgr,$type,$module);
        $temp = array();
        if (count($result)) {
            foreach($result as $row => $value) {
                //get child
                $temp[] = $value;
                $child = $this->menu_model->getLeftMenu($value['id'],'left',$type,$module);
                if (count($child)) {
                    foreach($child as $rowChild => $valueChild) {
                        $temp[$row]['child'][] = $valueChild;
                        
                        $childLevel = $this->menu_model->getLeftMenu($valueChild['id'],'left',$type,$module);
                        if ($childLevel) {
                            foreach($childLevel as $rowChildLevel => $valueChildLevel) {
                                $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
                            }
                        }
                    }
                }
            }
        }
        print_r($temp);exit;
        return $temp;
    }
    
    function getAllMenuWeb($ctgr,$type = 'backend',$module='',$order= '') {
        if (is_array($type)) {
            $type = implode("','",$type);
            
        } 
        $type = "'".$type."'";
        $result = $this->menu_model->getLeftMenu(0,$ctgr,$type,$module,$order);
        $temp = array();
        if (count($result)) {
            foreach($result as $row => $value) {
                //get child
                
                $temp[] = $value;
//                $temp[] = $this->getChildNew($value,$ctgr,$type,$module,$row);
                //check if there is a child
                $child = $this->menu_model->getLeftMenu($value['id'],'left',$type,$module,'menu_order ASC');
                if (count($child)) {
                    foreach($child as $rowChild => $valueChild) {
                        $temp[$row]['child'][] = $valueChild;
                        $childLevel = $this->menu_model->getLeftMenu($valueChild['id'],'left',$type,$module,'menu_order ASC');
                        if ($childLevel) {
                            foreach($childLevel as $rowChildLevel => $valueChildLevel) {
                                $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
                                $childLevel2 = $this->menu_model->getLeftMenu($valueChildLevel['id'],'left',$type,$module,'menu_order ASC');
                                if ($childLevel2) {
                                    foreach($childLevel2 as $rowChildLevel2 => $valueChildLevel2) {
                                        $temp[$row]['child'][$rowChild]['child'][$rowChildLevel]['child'][] = $valueChildLevel2;
                                    }
                                }
                            }
                        }
                    }
                }
                
                
                
                
                
//                $child = $this->menu_model->getLeftMenu($value['id'],'left',$type,$module);
//                if (count($child)) {
//                    $temp2 = $this->getChildNew($valueChild,'left',$type,$module,$row);
//                        array_push($temp2,$temp);
//                    foreach($child as $rowChild => $valueChild) {
//                        $temp[$row]['child'][] = $valueChild;
//                        //check if there is another child
//                        
////                        $childLevel = $this->menu_model->getLeftMenu($valueChild['id'],'left',$type,$module);
////                        if ($childLevel) {
////                            foreach($childLevel as $rowChildLevel => $valueChildLevel) {
////                                $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
////                            }
////                        }
//                    }
//                }
            }
        }
        return $temp;
    }
    
    function getChildNew($value,$ctgr,$type,$module,$row) {
        //check if got child
        $temp[] = $value;
        $child = $this->menu_model->getLeftMenu($value['id'],'left',$type,$module);
        if (count($child)) {
            foreach($child as $rowChild => $valueChild) {
                $temp[$row]['child'][] = $valueChild;
//                $child2[] = $this->getChildNew($valueChild,$ctgr,$type,$module,$rowChild);
//                $temp[] = array_push($child2,$temp);
//                $temp2[] = $valueChild;
//                $child2 = $this->menu_model->getLeftMenu($valueChild['id'],$ctgr,$type,$module);
//                if (count($child2)) {
//                    $tempChild = $this->getChildNew($temp2,$child2,$ctgr,$type,$module,$rowChild);
//                    print_r($tempChild);exit;
//                }
            }
       }
        return $temp;
    }
    function getChildMenu($id,$ctgr,$type) {
        $child = $this->menu_model->getLeftMenu($id,$ctgr,$type);
        if (count($child)) {
            foreach($child as $rowChild => $valueChild) {
                $temp[$row]['child'][] = $valueChild;

                $childLevel = $this->menu_model->getLeftMenu($valueChild['id'],$ctgr);
                if ($childLevel) {
                    foreach($childLevel as $rowChildLevel => $valueChildLevel) {
                        $temp[$row]['child'][$rowChild]['child'][] = $valueChildLevel;
                    }
                }
            }
        }
    }
    
    function check_login() {
        
        if ($this->session->userdata('login') == TRUE) {
            return TRUE;
        } else {
            redirect('/login/index');
        }
    }

    function prepareList($data, $key, $value, $allowNull = false) {
        $result = array();
        if ($allowNull) {
            $result[''] = '-- PILIH SATU --';
        }

        if ($data) {
            if (is_string($value)) {
                $value = array($value);
            }

            foreach ($data as $item) {

                if ($item instanceof stdClass) {
                    $item = (array) $item;
                }

                if (is_array($key)) {
                    $textKey = '';
                    $flag = false;
                    foreach ($key as $indexKey) {
                        if ($textKey) {
                            $textKey .= '-';
                        }
                        if (isset($indexKey)) {
                            $textKey .= $item[$indexKey];
                        }

                        if (isset($item[$indexKey])) {
                            $flag = true;
                        } else {
                            $flag = false;
                        }
                    }

                    if ($flag) {

                        $text = '';
                        foreach ($value as $val) {
                            if ($text) {
                                $text .= ' - ';
                            }

                            if (isset($item[$val])) {
                                $text .= $item[$val];
                            }
                        }
                        $result[$textKey] = $text;
                    }
                } else {
                    if (isset($item[$key])) {

                        $text = '';
                        foreach ($value as $val) {
                            if ($text) {
                                $text .= ' - ';
                            }

                            if (isset($item[$val])) {
                                $text .= $item[$val];
                            }
                        }
                        $result[$item[$key]] = $text;
                    }
                }
            }
        }

        return $result;
    }

}