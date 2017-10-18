<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/core/libraries/jasny_bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/forms/inputs/autosize.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/forms/inputs/formatter.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/pages/form_controls_extended.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/forms/inputs/typeahead/handlebars.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/forms/inputs/passy.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/forms/inputs/maxlength.min.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>assets/template/js/pages/components_modals.js"></script>-->
<!-- BEGIN PAGE CONTENT-->
<div class="panel-heading">
    <h5 class="panel-title"><?php echo $title; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
</div>
<!--<div class="panel-body">
</div>-->
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
    <div class="datatable-header">
        <div class="dataTables_filter">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_form_account">Add <i class="icon-play3 position-right"></i></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary" onclick="javascript:delete_menu('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');">
                    Delete <i class="icon-plus"></i>
                </button>
            </div>
            
        </div>
        <div id="DataTables_Table_0_filter" class="dataTables_filter" style="float:right;">
            <label>Search: <input type="text" field="id_bse,bse_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('bse_list', '<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>', this);" class="m-wrap small"></label>
        </div>
    </div>
    <div class="datatable-scroll"> 
        <table class="table table-bordered table-xs" id="bse_list" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                    <th>No. Perkiraan</th>
                    <th>Nama Perkiraan</th>
                    <th>Tipe</th>
                    <th>No. Perkiraan Parent</th>
                    <th>Aktif Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($dataList) {
                    $i = 0;
                    foreach ($dataList as $index => $value) {
                        ?>
                        <tr class="odd" role="row">
                            <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                            <td><a href="#modal_form_account"  data-toggle="modal" data-id="<?=$value['id']?>" data-acc_num="<?=$value['acc_num']?>" data-acc_name="<?=$value['acc_name']?>" data-acc_group="<?=$value['acc_group']?>" data-acc_type="<?=$value['acc_type']?>" data-active="<?=$value['active_status']?>"><?php echo $value['acc_num']; ?></a></td>
                            <td><?= $value['acc_name'] ?></td>
                            <td><?= $value['acc_group'] ?></td>
                            <td><?= $value['acc_type'] ?></td>
                            <td><?= ($value['active_status'] == '1') ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Not Active</span>' ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="datatable-footer">
        <div style="width:20%;margin:0 auto;">
            <table class="footer-table">
                <tbody>
                    <tr>
                        <td><button onclick="updatelist('user_admin_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'first');" class="btn-first" type="button">&nbsp;</button></td>
                        <td><button onclick="updatelist('bse_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'prev');" class="btn-prev" type="button">&nbsp;</button></td>
                        <td><span class="ytb-sep"></span></td>
                        <td><span class="ytb-text">Page</span></td>
                        <td><input type="text" onkeyup="updatelist('bse_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'page', this.value);" size="3" value="<?php echo ($pnumber) ? $pnumber : 1; ?>" class="pnumber"></td>
                        <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata / 10) ?></span></td>
                        <td><span class="ytb-sep"></span></td>
                        <td><button onclick="updatelist('bse_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'next');" class="btn-next" type="button">&nbsp;</button></td>
                        <td><button onclick="updatelist('bse_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'last');" class="btn-last" type="button">&nbsp;</button></td>
                        <td>
                            <input type="hidden" id="limit" name="limit" value="0"/>
                            <input type="hidden" id="totaldata" name="totaldata" value="<?php echo $totaldata; ?>"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="modal_form_account" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Tambah Daftar Transaksi</h5>
            </div>

            <form class="tesmodal" action="<?=base_url()?>master_account/save" method="post">
                <div class="modal-body">
                    <div class="form-group">
<!--                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Unit</label>
                                    <select class="form-control select-search" field="parent" id="parent" name="unit">
                                        <?php foreach($parent as $indexUnit => $valueUnit) {?>
                                            <option value="<?=$indexUnit?>"><?=$valueUnit?></option>
                                        <?php }?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Unit</label>
                                    <select class="form-control select-search" field="unit" id="unit" name="unit" onchange="javascript:get_account('<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>',this)">
                                        <?php foreach($unitdata as $indexUnit => $valueUnit) {?>
                                            <option value="<?=$indexUnit?>"><?=$valueUnit?></option>
                                        <?php }?>
                                </select>
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-sm-12">
                                <label>No. Perkiraan</label>
                                <input type="text" id="acc_num" name="acc_num" data-mask="9999999999999999" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Nama Perkiraan</label>
                                <input type="text" id="acc_name" name="acc_name" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <label>No. Perkiraan Parent</label>
                                <input type="text" id="parent_id" name="parent_id" data-mask="9999999999999999" onkeyup="javascript:get_parent('<?= base_url() ?>', '<?= $this->router->class ?>', this);" placeholder="" class="form-control autocomplete-input-new">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kelompok Perkiraan</label>
                                <select id="acc_group" name="acc_group" placeholder="" class="form-control">
                                <?php foreach($estimate_group as $index => $value) {?>
                                    <option value="<?=$index?>"><?=$value?></option>
                                <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Tipe Perkiraan</label>
                                <select id="acc_type" name="acc_type" placeholder="" class="form-control">
                                <?php foreach($estimate_type as $index => $value) {?>
                                    <option value="<?=$index?>"><?=$value?></option>
                                <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Status Aktif</label>
                                <input type="checkbox" id="active_status" name="active_status" value="1">
                                <input type="hidden" id="id" name="id" value="1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit form</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#modal_form_account').on('show.bs.modal', function (e) {
        var table_id = $(e.relatedTarget).data('id');
	var acc_num = $(e.relatedTarget).data('acc_num');
	var acc_name = $(e.relatedTarget).data('acc_name');
	var parent_id = $(e.relatedTarget).data('parent_id');
	var acc_group = $(e.relatedTarget).data('acc_group');
	var acc_type = $(e.relatedTarget).data('acc_type');
	var active = $(e.relatedTarget).data('active');
       
        $(".modal-body #id").val(table_id);
        $(".modal-body #acc_num").val(acc_num);
        $(".modal-body #acc_name").val(acc_name);
        $(".modal-body #parent_id").val(parent_id);
        $(".modal-body #acc_group").val(acc_group);
        $(".modal-body #acc_type").val(acc_type);
        
        
        if (active  === 1) {
            $(".modal-body #active_status").attr('checked','checked');
        }
    });
</script>
