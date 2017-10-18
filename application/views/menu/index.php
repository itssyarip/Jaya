<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
<!-- BEGIN PAGE CONTENT-->
<div class="panel-heading">
    <h5 class="panel-title"><?php echo $title; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
</div>
<div class="panel-body">
        
</div>
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
    <div class="datatable-header">
        <div class="dataTables_filter">
            <div class="btn-group">
                <a class="btn btn-primary" onclick="javascript:add_data('<?= base_url() ?>','<?php echo $this->router->fetch_class();?>');">Add New <i class="icon-plus"></i></a>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary" onclick="javascript:delete_menu('<?= base_url() ?>','<?php echo $this->router->fetch_class();?>');">
                    Delete <i class="icon-plus"></i>
                </button>
            </div>
        </div>
        <div id="DataTables_Table_0_filter" class="dataTables_filter" style="float:right;">
            <label>Search: <input type="text" field="menu_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('menu_list','<?=base_url()?>','<?php echo $this->router->fetch_class();?>',this);" class="m-wrap small"></label>
        </div>
    </div>
    <div class="datatable-scroll"> 
        <table class="table table-bordered table-xs" id="menu_list" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                    <th>Nama Menu</th>
                    <th>Menu Name</th>
                    <th>Aktif</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($dataList) {
                        $i = 0;
                        foreach ($dataList as $index => $value) {
                            ?>
                            <tr class="odd gradeX">
                                <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                <td><a href="#" onclick="javascript:add_menu('<?= base_url() ?>', '<?= $value['id'] ?>');"><?php echo $value['menu_name']; ?></a></td>
                                <td><?= ($value['menu_active'] == 'Y') ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Not Active</span>' ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                <input type="hidden" id="totalRow" name="totalRow" value="<?= $i ?>"/>
            </tbody>
        </table>
    </div>
    <div class="datatable-footer">
        <div style="width:20%;margin:0 auto;">
        <table class="footer-table">
            <tbody>
                <tr>
                    <td><button onclick="updatelist('menu_list', '<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','first');" class="btn-first" type="button">&nbsp;</button></td>
                    <td><button onclick="updatelist('menu_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','prev');" class="btn-prev" type="button">&nbsp;</button></td>
                    <td><span class="ytb-sep"></span></td>
                    <td><span class="ytb-text">Page</span></td>
                    <td><input type="text" onkeyup="updatelist('menu_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','page', this.value);" size="3" value="<?php echo ($pnumber) ?$pnumber :1;?>" class="pnumber"></td>
                    <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata/10)?></span></td>
                    <td><span class="ytb-sep"></span></td>
                    <td><button onclick="updatelist('menu_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','next');" class="btn-next" type="button">&nbsp;</button></td>
                    <td><button onclick="updatelist('menu_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','last');" class="btn-last" type="button">&nbsp;</button></td>
                    <td>
                        <input type="hidden" id="limit" name="limit" value="0"/>
                        <input type="hidden" id="totaldata" name="totaldata" value="<?php echo $totaldata;?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>
