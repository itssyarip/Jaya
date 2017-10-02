<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>assets/template/js/pages/components_modals.js"></script>-->
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
                <div class="btn-group">
                    <button class="btn btn-primary" onclick="javascript:add_data('<?= base_url() ?>','<?php echo $this->router->fetch_class();?>');">Add New <i class="icon-plus"></i></button>
                </div>
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
                    <th>Kode</th>
                    <th>Kode Mapping</th>
                    <th>Unit</th>
                    <th>Tingkat</th>
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
                            <td><a href="#modal_form_bse"  data-toggle="modal" data-id="<?=$value['id']?>" data-id_bse="<?=$value['id_bse']?>" data-id_bse_map="<?=$value['id_bse_map']?>" data-name="<?=$value['bse_name']?>" data-bse_level="<?=$value['bse_level']?>" data-active="<?=$value['active_status']?>"><?php echo $value['id_bse']; ?></a></td>
                            <td><?= $value['id_bse_map'] ?></td>
                            <td><?= $value['bse_name'] ?></td>
                            <td><?= $value['bse_level'] ?></td>
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
<div id="modal_form_bse" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Add Business Entity</h5>
            </div>

            <form action="<?=base_url()?>bse/save" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kode BSE</label>
                                <input type="text" id="id_bse" name="id_bse" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kode BSE Mapping</label>
                                <input type="text" id="id_bse_map" name="id_bse_map" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Keterangan (Badan Usaha/Unit)</label>
                                <input type="text" id="bse_name" name="bse_name" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Level</label>
                                <input type="text" id="bse_level" name="bse_level" placeholder="" class="form-control">
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
    $('#modal_form_bse').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id_bse');
        var table_id = $(e.relatedTarget).data('id');
	var id_bse = $(e.relatedTarget).data('id_bse');
	var id_bse_map = $(e.relatedTarget).data('id_bse_map');
	var bse_name = $(e.relatedTarget).data('name');
	var bse_level = $(e.relatedTarget).data('bse_level');
	var active = $(e.relatedTarget).data('active');
       
        $(".modal-body #id").val(table_id);
        $(".modal-body #id_bse").val(id_bse);
        $(".modal-body #id_bse_map").val(id_bse_map);
        $(".modal-body #bse_name").val(bse_name);
        $(".modal-body #bse_level").val(bse_level);
        
        
        if (active  === 1) {
            $(".modal-body #active_status").attr('checked','checked');
        }
    });
</script>
