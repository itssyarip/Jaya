<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('acl_model','content_model','contact_model','news_model'));
    }

    function index(){ 
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);
        if ($segment_1 != '') {
            //$this->data['eventData'] = $eventData;
            $where = array();
            
            $this->data['menus'] = $this->getHeaderMenu('header','frontend');  
            $this->data['title'] = 'Wika Gedung - Search';  
            $this->data['menu_active'] = 'search';  
            $this->data['content'] = 'search/detail';
            $this->data['mainMenuLabel'] = strtoupper($segment_1);
            $this->data['contentLabel'] = '';
            //breadcrum
            $breadCrum = $this->getParentMenu('',$segment_1);
            
            $this->data['breadCrum'] = $breadCrum;
            $whereNews = array();
            if ($this->input->post('search')) {
                $where['content_data'.$this->session->userdata('lang')] = $this->input->post('search');
                $whereNews['news_content'.$this->session->userdata('lang')] = $this->input->post('search');
            }
            $contentData  = $this->content_model->getAllDataSearch('','',$where,'or_like','id');
            $this->data['contentData'] = $contentData;
            $newsData  = $this->news_model->getData('','',$whereNews,'or_like');
            $this->data['newsData'] = $newsData;
            
            
            if ($segment_2 == '') {
                //get top menu
                $topMenu = $this->getTopMenu($segment_1);
                $this->data['contentLabel'] = $topMenu[0]['menu_name'.$this->session->userdata('lang')];
            }
            $about = $this->content_model->getAllData(1, 0, array('cntn.menu_alias'=>'who_we_are.html'),'where');
            $kontak = $this->contact_model->getAll();
            if ($about) {
                $this->data['about'] = $about;
            }
            $this->data['kontak'] = $kontak;
            //get sustainability menus
            $sustainability = $this->getHeaderMenu('header','frontend','','sustainability.html'); 
            if ($sustainability) {
                $this->data['sustainability'] = $sustainability;
            }

            $aboutFooter = $this->getHeaderMenu('header','frontend','','about_us.html'); 
            if ($aboutFooter) {
                $this->data['aboutFooter'] = $aboutFooter;
            }
           if ($this->uri->segment(2) == 'paging') {
                $this->paging();
            } else  {
                if ($this->uri->segment(2) == 'page') {
                    $newsData  = $this->news_model->getData(5,'',array(),'DESC');
                    $where['news_alias'] = $this->uri->segment(3);
                    $detailData = $this->news_model->getByCategory($where);
                    if ($detailData) {
                        $this->data['content'] = 'news_admin/detail';
                        $this->data['newsList'] = $detailData;
                        $this->data['newsData'] = $newsData;
                        $this->data['totaldata'] = sizeof($this->news_model->getAll());
                        $this->data['pnumber'] = 1;
                    }
                } else {
//                    $this->data['newsList'] = $this->news_model->getData($this->_limit,0);
//                    $this->data['totaldata'] = sizeof($this->news_model->getAll());
//                    $this->data['pnumber'] = 1;
                }
        
                $this->load->view('layout_frontend_search', $this->data);
            }
        }
    }
    function getTopMenu($webLink= '',$menuId = '') {
        $this->load->model(array('menu_model'));
        if ($webLink != '') {
            $menu = $this->menu_model->getTopMenu(array('menu_web_link'=>$webLink));
        } else {
            $menu = $this->menu_model->getTopMenu(array('id'=>$menuId));
        }
        if ($menu) {
            if ($menu[0]['menu_parent'] > 0) {
                $menu  = $this->getTopMenu('',$menu[0]['menu_parent']);
                return $menu;
            } else{
                return $menu;
//                print_r($menu);
            }
        }
    }
    function paging() {
        $this->_limit = 5;
        $this->load->model(array('news_model'));
        $whereSearch = array();
        $pnumber = ($this->input->post('pnum')) ? $this->input->post('pnum') : 0;
        $paging = strtolower($this->input->post('page'));
        $limit = $this->input->post('limit');
        $totaldata = $this->input->post('totaldata');
        $searhDesc = $this->input->post('search');
        $page = $limit;
        if ($paging && $paging != '' && $pnumber == 0) {
            if ($paging == 'first') {
                $limit = 0;
                $page = $this->_limit;
                $pnumber = 1;
            } else if ($paging == 'last') {
                $limit = $totaldata-5;
                $page = $this->_limit;
                
            } else if ($paging == 'next') {
                $page += 5;
                $limit = $page;
            } else if ($paging == 'prev') {
                if ($limit > 0) {
                    $page -= 5;
                }
                $limit = $page;
            } else {
                $limit = $totaldata;
            }
        } else {
            if ($pnumber > 0){
                $limit = (($this->_limit*$pnumber) - $this->_limit);
            } else if ($pnumber == 0){
                $limit = 0;
            }
        } 
        
        if ($searhDesc) {
            
            $whereSearch["news_name"] = $searhDesc;
        }

        $totalData = $this->news_model->getData(0,$limit,$whereSearch);
        $result = $this->news_model->getData($this->_limit,$limit,$whereSearch);

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
//        $template = '<ul class="list-unstyled">';
        $template = '';
        foreach($data as $index => $value) {
            $template .='<div class="" style="padding-bottom: 0px" id="panel-11-0-2-<?=$i?>" data-index="<?=$i?>">
                <div class="page-box  page-box--inline">
                    <a class="page-box__picture" href="#/">
                        <img style="width:100px;height:80px" src="'.(isset($value['news_file_path']) ? base_url() .$value['news_file_path'] : '').'" class="attachment-pw-inline size-pw-inline wp-post-image" alt="8">
                    </a>
                    <div class="page-box__content" style="height:120px">
                        <h4 class="page-box__title">'.date("D F d", strtotime($value['news_date'])).'</h4>
                        <p class="page-box__text"><a href="'.base_url().'news/'.$value['news_alias'].'">'.$value['news_title'].'</a></p>
                    </div>
                </div>
            </div>';
        
//            $template .='<article> 
//                            <div class="row">
//                                <div class="col-sm-11 col-xs-10 meta">
//                                    <h2><a href="'.base_url().$this->router->fetch_class().'/page/'.$value['event_alias'].'">'.$value['event_name'].'</a></h2>
//                                    <span class="meta-author"><i class="fa fa-user"></i><a href="#">Starhotel</a></span> <span class="meta-category"><i class="fa fa-pencil"></i><a href="#">Hotel business</a></span> <span class="meta-comments"><i class="fa fa-comment"></i><a href="#">3 Comments</a></span>
//                                    <p class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sed turpis neque. In auctor, odio eget luctus lobortis, sapien erat blandit felis, eget volutpat augue felis in purus. Aliquam ultricies est id ultricies facilisis. Maecenas tempus... </p>
//                                    <a href="'.base_url().$this->router->fetch_class().'/page/'.$value['event_alias'].'" class="btn btn-primary pull-right">Read More</a> </div>
//                            </div>
//                        </article>';
        }
//        $template .='</ul>';
        return $template;
    }
    
    function detail() {
        $eventData  = $this->news_model->getNews(5,'DESC');
        $this->data['eventData'] = $eventData;
        $this->data['menus'] = $this->getAllMenuWeb('header','frontend'); 
        $this->data['title'] = 'Wika Gedung - News';  
        $this->data['menu_active'] = 'News';  
        $this->data['content'] = 'news_admin/list';
         if  ($this->uri->segment(3)) {
            $where['news_alias'] = $this->uri->segment(3);
            $detailData = $this->news_model->getByCategory($where);
            if ($detailData) {
                $this->data['content'] = 'news_admin/detail';
                $this->data['newsList'] = $detailData;
//                    $this->load->view('layout_frontend_research', $this->data);
            }
        }
        
        $this->load->view('layout_frontend_news', $this->data);
    }
}
?>