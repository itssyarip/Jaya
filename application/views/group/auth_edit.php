<div class="panel-heading">
    <h5 class="panel-title"><?php echo $title; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
</div>
<div class="panel-body">
    <form class="form-horizontal" method="post" action="<?= base_url() ?>group/save_auth">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h6 class="panel-title">Menu Akses <a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                        <div class="datatable-header">
                            <!--                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                        <label>Search: <input type="text" field="menu_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('user_admin_list','<?= base_url() ?>','<?php echo $this->router->fetch_class(); ?>',this);" class="m-wrap small"></label>
                                                    </div>-->
                        </div>
                        <div class="datatable-scroll"> 
                            <table class="table table-bordered table-xs" id="" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th>Nama Menu</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($dataAcl['access']) {
                                        foreach ($dataAcl['access'] as $index => $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?= $value['menu_name'] ?></td>
                                                <td><?= $value['menu_check'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php foreach ($modules as $indexMdl => $value) {
            if ($indexMdl != '') {
                ?>
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h6 class="panel-title"><?= $value ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                                <div class="datatable-header">
                                    <!--                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                                <label>Search: <input type="text" field="menu_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('user_admin_list','<?= base_url() ?>','<?php echo $this->router->fetch_class(); ?>',this);" class="m-wrap small"></label>
                                                            </div>-->
                                </div>
                                <div class="datatable-scroll"> 
                                    <table class="table table-bordered table-xs" id="" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>Nama Menu</th>
                                                <th>Hak Akses</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($dataAcl[$indexMdl]) {
                                                foreach ($dataAcl[$indexMdl] as $index => $value) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $value['menu_name'] ?></td>
                                                        <td><?= $value['menu_check'] ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }
        ?>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h6 class="panel-title">Menu Akses Unit<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                        <div class="datatable-header">
                            <!--                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                        <label>Search: <input type="text" field="menu_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('user_admin_list','<?= base_url() ?>','<?php echo $this->router->fetch_class(); ?>',this);" class="m-wrap small"></label>
                                                    </div>-->
                        </div>
                        <div class="datatable-scroll"> 
                            <table class="table table-bordered table-xs" id="" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th>Nama Unit</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($acu) {
                                        foreach ($acu as $index => $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?= $value['id_bse'] ?></td>
                                                <td><?= $value['acu_check'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h6 class="panel-title">Menu Akses <a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                        <div class="datatable-header">
                            <!--                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                        <label>Search: <input type="text" field="menu_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('user_admin_list','<?= base_url() ?>','<?php echo $this->router->fetch_class(); ?>',this);" class="m-wrap small"></label>
                                                    </div>-->
                        </div>
                        <div class="datatable-scroll"> 
                            <table class="table table-bordered table-xs" id="" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th>Nama Menu</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($aclButton) {
                                        foreach ($aclButton as $index => $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?= $value['button'] ?></td>
                                                <td><?= $value['aclb_check'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <input type="hidden" id="group_code" name="group_code" value="<?php echo isset($groupCode) ? $groupCode : '' ?>"/>
            <button class="btn blue" type="submit" ><i class="icon-ok"></i> Save</button>
            <button class="btn" type="submit" id="btncancel" name="btncancel" value="Cancel">Cancel</button>
        </div>
    </form>
</div>