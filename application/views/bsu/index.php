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
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_form_bsu">Add <i class="icon-play3 position-right"></i></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary" onclick="javascript:delete_menu('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');">
                    Delete <i class="icon-plus"></i>
                </button>
            </div>
        </div>
        <div id="DataTables_Table_0_filter" class="dataTables_filter" style="float:right;">
            <label>Search: <input type="text" field="bu_name,bu_code" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('bsu_list', '<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>', this);" class="m-wrap small"></label>
        </div>
    </div>
    <div class="datatable-scroll"> 
        <table class="table table-bordered table-xs" id="bsu_list" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                    <th>Nama</th>
                    <th>Kode</th>
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
                            <td><a href="#modal_form_bsu"  data-toggle="modal" data-id="<?=$value['id']?>" data-bu_name="<?=$value['bu_name']?>" data-bu_code="<?=$value['bu_code']?>"><?php echo $value['bu_name']; ?></a></td>
                            <td><?= $value['bu_code'] ?></td>
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
                        <td><button onclick="updatelist('bsu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'first');" class="btn-first" type="button">&nbsp;</button></td>
                        <td><button onclick="updatelist('bsu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'prev');" class="btn-prev" type="button">&nbsp;</button></td>
                        <td><span class="ytb-sep"></span></td>
                        <td><span class="ytb-text">Page</span></td>
                        <td><input type="text" onkeyup="updatelist('bsu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'page', this.value);" size="3" value="<?php echo ($pnumber) ? $pnumber : 1; ?>" class="pnumber"></td>
                        <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata / 10) ?></span></td>
                        <td><span class="ytb-sep"></span></td>
                        <td><button onclick="updatelist('bsu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'next');" class="btn-next" type="button">&nbsp;</button></td>
                        <td><button onclick="updatelist('bsu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'last');" class="btn-last" type="button">&nbsp;</button></td>
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
<div id="modal_form_bsu" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Add Business Entity</h5>
            </div>

            <form action="<?=base_url()?>bsu/save" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Nama</label>
                                <input type="text" id="bu_name" name="bu_name" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kode</label>
                                <input type="text" id="bu_code" name="bu_code" placeholder="" class="form-control">
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#modal_form_bsu').on('show.bs.modal', function (e) {
        var table_id = $(e.relatedTarget).data('id');
	var bu_name = $(e.relatedTarget).data('bu_name');
	var bu_code = $(e.relatedTarget).data('bu_code');

        $(".modal-body #id").val(table_id);
        $(".modal-body #bu_name").val(bu_name);
        $(".modal-body #bu_code").val(bu_code);
    });
</script>
