<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD
        <title>SIA PT Jaya</title>
=======
        <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>
>>>>>>> 1062852dd398d01bf9af2bbac9eae803c4f0d490

        <?php
        $this->load->view("util/globalJs");
        $this->load->view("util/formCss");
        ?>
        

	
    </head>
    <body class="login-container">

<<<<<<< HEAD
 
=======
        <!-- Main navbar -->
        <div class="navbar navbar-inverse bg-indigo">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><img src="<?= base_url() ?>assets/template/images/logo_light.png" alt=""></a>

                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">
                            <i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Go to website</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Contact admin</span>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-cog3"></i>
                            <span class="visible-xs-inline-block position-right"> Options</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->
>>>>>>> 1062852dd398d01bf9af2bbac9eae803c4f0d490


        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Simple login form -->
                    <form class="login-form" action="#" id="form_login">
                        <div class="panel panel-body login-form">
                            <div class="text-center">
<<<<<<< HEAD
                                <div class="icon-object border-slate-300 text-slate-300"><img style="width: 70px;" src="https://ecc.ft.ugm.ac.id/public/employer_logo/150289/large_1390964213jaya-properti.png"></div>
=======
                                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
>>>>>>> 1062852dd398d01bf9af2bbac9eae803c4f0d490
                                <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
                                <div class="alert alert-error" style="display:none;">
                                    <button class="close" data-dismiss="alert"></button>
                                    <span class="message"></span>
                                </div>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label>Module</label>
                                <select class="select" id="modules" name="modules" placeholder="modules">
                                    <?php foreach($modules as $index => $value) {?>
                                    <option value="<?=$index?>"><?=$value?></option>
                                    <?php }?>
                                </select>
                                <div class="form-control-feedback">
                                    <!--<i class="icon-lock2 text-muted"></i>-->
                                </div>
                            </div>
                            <div class="form-group">
<<<<<<< HEAD
                                <button type="submit" class="btn bg-danger btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
                            </div>

                            <div class="text-center">
                                <!-- <a href="login_password_recover.html">Forgot password?</a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="footer text-muted text-center">
            &copy; 2017. <a href="#">SIA - PT Jaya Real Property</a> by <a href="http://http://octatech.co.id/" target="_blank">octatech.co.id</a>
=======
                                <button type="submit" class="btn bg-pink-400 btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
                            </div>

                            <div class="text-center">
                                <a href="login_password_recover.html">Forgot password?</a>
                            </div>
                        </div>
                    </form>
                    <!-- /simple login form -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->


        <!-- Footer -->
        <div class="footer text-muted text-center">
            &copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
>>>>>>> 1062852dd398d01bf9af2bbac9eae803c4f0d490
        </div>
        <!-- /footer -->
        <script src="<?= base_url() ?>assets/jquery.validate.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/template/js/core/app.js"></script>
        <script src="<?= base_url() ?>assets/login-soft.js" type="text/javascript"></script>
        <script>
            var base_url = "<?php echo base_url(); ?>";
            jQuery(document).ready(function() {
                //App.init();
                Login.init();
            });
        </script>
    </body>
</html>
