<section id="bottom">
    <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
        <div class="row">
            <div class="col-xs-12  col-md-3">
                <div class="widget">
                    <?php if (isset($about)) {?>
                    <h3><?= $about[0]['menu_name' . $this->session->userdata('lang')] ?></h3>
                    <div class="textwidget" style="color:#ffffff; padding: 20px 0 40px 0;">
                        <?php
                        if ($about) {
                            $about[0]['content_prakata' . $this->session->userdata('lang')] = preg_replace("/<img[^>]+\>/i", "", $about[0]['content_prakata' . $this->session->userdata('lang')]);
                            $about[0]['content_prakata' . $this->session->userdata('lang')] = strip_tags($about[0]['content_prakata' . $this->session->userdata('lang')]);
                            //$about[0]['content_prakata'.$this->session->userdata('lang')] = preg_replace('/^[ \t]*[\r\n]+/m', '', $about[0]['content_prakata'.$this->session->userdata('lang')]);
                            ?>
                            <p style="text-align:justify">
                                <a href="<?= base_url() .str_replace('.html','',$about[0]['pmenu']).'/'. $about[0]['menu_alias'] ?>" style="color:#ffffff"><?php echo $about[0]['content_prakata' . $this->session->userdata('lang')]; ?></a>
                            </p>
                        <?php } ?>
                    </div>
                    <?php }?>
                </div>
            </div> <!--/.col-md-3-->

            <div class="col-md-3 col-sm-6">
                <div class="widget" >
                    <h3>OUR COMPANY</h3>
                    <ul style=" padding: 20px 0 40px 0;">
                        <?php 
                        if (isset($aboutFooter)) {
                            $view_menu = '';
                            foreach ($aboutFooter as $index => $value) {
                                if (!empty($value['child'])) {
                                    foreach ($value['child'] as $indexChild => $valueChild) {
                                        if ($valueChild['menu_web_link'] != '') {
                                            $view_menu .= '<li style="border-bottom:1px dotted #ba0b12">';
                                            $view_menu .= '<a  href="' . base_url() . $valueChild['menu_web_link'] . '">' . $valueChild['menu_name' . $this->session->userdata('lang')] . '</a>';
                                            $view_menu .= '</li>';
                                        } else {
                                            if (!empty($valueChild['child'])) {
                                                $view_menu .= '<li style="border-bottom:1px dotted #ba0b12"><a href="#">' . $valueChild['menu_name' . $this->session->userdata('lang')] . '</a>';
                                                $view_menu .= '<ul>';
                                                foreach ($valueChild['child'] as $keySubChild => $valueSubChild) {
                                                    $view_menu .= '<li style="border-bottom:1px dotted #ba0b12"><a tabindex="-1" href="' . base_url() . str_replace('.html', '', strtolower($value['menu_alias'])) . '/' . $valueSubChild['menu_alias'] . '">' . $valueSubChild['menu_name' . $this->session->userdata('lang')] . '</a></li>';
                                                }
                                                $view_menu .= '</ul>';
                                                $view_menu .= '</li>';
                                            } else {
                                                $view_menu .= '<li style="border-bottom:1px dotted #ba0b12"><a href="' . base_url() . str_replace('.html', '', strtolower($value['menu_alias'])) . '/' . $valueChild['menu_alias'] . '">' . $valueChild['menu_name' . $this->session->userdata('lang')] . '</a></li>';
                                            }
                                        }
                                        ?>
                                    <?php
                                    }
                                    echo $view_menu;
                                }
                                ?>

                            <?php
                            }
                        }
                        ?>

                    </ul>
                </div>    
            </div><!--/.col-md-3-->

            <div class="col-md-3 col-sm-6">
                <div class="widget">
                    <h3><?=$sustainability[0]['menu_name' . $this->session->userdata('lang')] ?></h3>
                    <ul style=" padding: 20px 0 40px 0;">
                        <?php
                        if (isset($sustainability)) {
                            $view_menu = '';
                            foreach ($sustainability as $index => $value) {
                                if (!empty($value['child'])) {
                                    foreach ($value['child'] as $indexChild => $valueChild) {
                                        if ($valueChild['menu_web_link'] != '') {
                                            $view_menu .= '<li style="border-bottom:1px dotted #ba0b12">';
                                            $view_menu .= '<a  href="' . base_url() . $valueChild['menu_web_link'] . '">' . $valueChild['menu_name' . $this->session->userdata('lang')] . '</a>';
                                            $view_menu .= '</li>';
                                        } else {
                                            if (!empty($valueChild['child'])) {
                                                $view_menu .= '<li style="border-bottom:1px dotted #ba0b12"><a href="#">' . $valueChild['menu_name' . $this->session->userdata('lang')] . '</a>';
                                                $view_menu .= '<ul>';
                                                foreach ($valueChild['child'] as $keySubChild => $valueSubChild) {
                                                    $view_menu .= '<li style="border-bottom:1px dotted #ba0b12"><a tabindex="-1" href="' . base_url() . str_replace('.html', '', strtolower($value['menu_alias'])) . '/' . $valueSubChild['menu_alias'] . '">' . $valueSubChild['menu_name' . $this->session->userdata('lang')] . '</a></li>';
                                                }
                                                $view_menu .= '</ul>';
                                                $view_menu .= '</li>';
                                            } else {
                                                $view_menu .= '<li style="border-bottom:1px dotted #ba0b12"><a href="' . base_url() . str_replace('.html', '', strtolower($value['menu_alias'])) . '/' . $valueChild['menu_alias'] . '">' . $valueChild['menu_name' . $this->session->userdata('lang')] . '</a></li>';
                                            }
                                        }
                                        ?>
                                    <?php
                                    }
                                    echo $view_menu;
                                }
                                ?>

                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>    
            </div><!--/.col-md-3-->

            <div class="col-md-3 col-sm-6">
                <div class="widget">
                    <h3><?= ($this->session->userdata('lang') == '') ? 'HUBUNGI KAMI' : 'CONTACT US' ?></h3>
                    <div class="textwidget" style="color:#ffffff; padding: 20px 0 40px 0;">
<!--                        <p style="margin-bottom: 0.5rem"><i class="fa fa-home pr-10"></i> Address: <?= $kontak[0]['building_location'] ?>,</p>
                        <p style="margin-bottom: 0.5rem"><i class="fa fa-globe pr-10"></i> <?= $kontak[0]['address'] ?></p>
                        <p style="margin-bottom: 0.5rem"><i class="fa fa-mobile pr-10"></i> Phone: <?= $kontak[0]['telp'] ?></p>
                        <p style="margin-bottom: 0.5rem"><i class="fa fa-phone pr-10"></i> Fax: <?= $kontak[0]['fax'] ?> </p>
                        <p style="margin-bottom: 0.5rem"><i class="fa fa-envelope pr-10"></i> Email :   <a href="<?= $kontak[0]['email'] ?>"><?= $kontak[0]['email'] ?></a></p>-->
                        <p>
                            Address : <?= $kontak[0]['address'] ?>, <br>
                            Phone   : <?= $kontak[0]['telp'] ?> <br>
                            Email   : <?= $kontak[0]['email'] ?>
                        </p>
                    </div>
                </div>    
            </div><!--/.col-md-3-->
        </div>
    </div>
</section><!--/#bottom-->
<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                &copy; 2017 Wika Pracetak Gedung. All Rights Reserved.
            </div>
            <div class="col-sm-6">
                <ul class="pull-right">
                    <li><a href="<?=base_url()?>">Home</a></li>
                    <li><a href="<?=base_url()?>about_us/who_we_are.html">Who We Are</a></li>
                    <li><a href="<?=base_url()?>news">News</a></li>
                    <li><a href="<?=base_url()?>contact_us">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer><!--/#footer-->
