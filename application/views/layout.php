<!DOCTYPE html>
<html lang="en" class="no-js"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Jaya | <?= $title ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <?php
        $this->load->view("util/formCss");
        $this->load->view("util/globalJs");
//        $this->load->view("util/formJs");
        ?>
        <link rel="shortcut icon" href="<?=base_url()?>assets/template/images/favicon.png" />
    </head> 
    <body>
        <div class="navbar navbar-inverse bg-indigo">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><img src="<?=base_url()?>assets/template/images/logo-jaya-property.png" alt=""></a>

                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?=base_url()?>assets/template/images/placeholder.jpg" alt="">
                            <span><?=$this->session->userdata('user_name')?></span>
                            <i class="caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                            <li><a href="<?=base_url()?>login/logout"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="navbar navbar-default" id="navbar-second">
            <ul class="nav navbar-nav no-border visible-xs-block">
                <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
            </ul>

            <div class="navbar-collapse collapse" id="navbar-second-toggle">
                <ul class="nav navbar-nav navbar-nav-material">
                    <li class="active"><a href="<?=base_url()?>"><i class="icon-display4 position-left"></i> Dashboard</a></li>
                    <?php echo $menus; ?>
<!--                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-make-group position-left"></i> Page kits <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu width-250">
                            <li class="dropdown-submenu">
                                <a href="#"><i class="icon-task"></i> Task manager</a>
                                <ul class="dropdown-menu width-200">
                                    <li class="dropdown-header highlight">Options</li>
                                    <li><a href="task_manager_grid.html">Task grid</a></li>
                                    <li><a href="task_manager_list.html">Task list</a></li>
                                    <li><a href="task_manager_detailed.html">Task detailed</a></li>
                                </ul>
                            </li>
                            <li><a href="task_manager_grid.html">Options</a></li>
                            <li><a href="task_manager_grid.html">Task grid</a></li>
                            <li><a href="task_manager_list.html">Task list</a></li>
                            <li><a href="task_manager_detailed.html">Task detailed</a></li>
                        </ul>
                    </li>-->
                    
                </ul>
            </div>
        </div>
        <!-- /second navbar -->
        
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Dashboard content -->
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Traffic sources -->
                            <div class="panel panel-flat">
                                <?php $this->load->view($content); ?>
                            </div>
                            <!-- /traffic sources -->

                        </div>
                    </div>
                    <!-- /dashboard content -->
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->

        <div class="footer">
            <div class="footer-inner">
                2017 - Jaya
                <!--- &copy;--> 
                <!--<span style="color: #FFF">indo</span><span style="color: #F00">net</span>-->
            </div>
            <div class="footer-tools">
                <span class="go-top">
                    <i class="icon-angle-up"></i>
                </span>
            </div>
        </div>
    </body>
</html>