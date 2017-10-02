<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
<!-- BEGIN PAGE CONTENT-->
<div class="panel-heading">
    <h5 class="panel-title"><?php echo $title; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
</div>
<div class="panel-body">
    <div class="form-group col-md-5">
        <label class="control-label col-lg-2" style="padding-top:9px;">Unit</label>
        <div class="col-lg-10">
           <select class="select-search" field="unit" id="search_desc" name="search_desc">
                    <?php foreach($unitdata as $indexUnit => $valueUnit) {?>
                        <option value="<?=$indexUnit?>"><?=$valueUnit?></option>
                    <?php }?>
            </select>
        </div>
    </div>
    <div class="form-group col-md-5">
        <label class="control-label col-lg-4" style="padding-top:9px;">Jumlah baris perhalaman</label>
        <div class="col-lg-6">
            <input type="text" id="jml_baris" name="jml_baris" value="" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group col-md-2">
        <div class="btn-group">
            <button class="btn btn-primary" onclick="javascript:searchdata('bank_master_tp_list','<?=base_url()?>','<?php echo $this->router->fetch_class();?>',this);">
                Search <i class="icon-plus"></i>
            </button>
        </div>
    </div>
</div>
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
    <div class="datatable-header">
        <div class="dataTables_filter col-md-12">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_form_bse">Add</button>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary" onclick="javascript:delete_menu('<?= base_url() ?>','<?php echo $this->router->fetch_class();?>');">
                    Delete <i class="icon-plus"></i>
                </button>
            </div>
        </div>
        
<!--        <div id="DataTables_Table_0_filter" class="form_control">
            <label>Unit: </label>
            <div class="col-md-5"><select type="search" class="select-search" field="unit" id="search_desc" name="search_desc" onchange="javascript:searchdata('bank_master_tp_list','<?=base_url()?>','<?php echo $this->router->fetch_class();?>',this);">
                        <?php foreach($unitdata as $indexUnit => $valueUnit) {?>
                            <option value="<?=$indexUnit?>"><?=$valueUnit?></option>
                        <?php }?>
                </select>
            </div>
            
        </div>-->
    </div>
    <div class="datatable-scroll"> 
        <table class="table table-bordered table-xs" id="bank_master_tp_list" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                    <th>Unit</th>
                    <th>Kode Bank</th>
                    <th>Kode Penerimaan</th>
                    <th>No. Account</th>
                    <th>Nama Account</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    if ($dataList) {
                        foreach ($dataList as $index => $value) {
                            ?>
                            <tr class="odd gradeX">
                                <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                <td><a href="#modal_form_bse"  data-toggle="modal" data-id="<?=$value['id']?>" data-id_bank="<?=$value['id_bank']?>" data-unit="<?=$value['unit']?>" data-acc_bank="<?=$value['acc_bank']?>" data-kode_bank="<?=$value['kode_bank']?>" data-kode_penerimaan="<?=$value['kode_penerimaan']?>"><?php echo $value['bse_name']; ?></a></td>
                                <td><?php echo $value['kode_bank']; ?></td>
                                <td><?php echo $value['kode_penerimaan']; ?></td>
                                <td><?php echo $value['acc_bank']; ?></td>
                                <td><?php echo $value['acc_name']; ?></td>
                                
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
                    <td><button onclick="updatelist('bank_master_tp_list', '<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','first');" class="btn-first" type="button">&nbsp;</button></td>
                    <td><button onclick="updatelist('bank_master_tp_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','prev');" class="btn-prev" type="button">&nbsp;</button></td>
                    <td><span class="ytb-sep"></span></td>
                    <td><span class="ytb-text">Page</span></td>
                    <td><input type="text" onkeyup="updatelist('bank_master_tp_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','page', this.value);" size="3" value="<?php echo ($pnumber) ?$pnumber :1;?>" class="pnumber"></td>
                    <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata/10)?></span></td>
                    <td><span class="ytb-sep"></span></td>
                    <td><button onclick="updatelist('bank_master_tp_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','next');" class="btn-next" type="button">&nbsp;</button></td>
                    <td><button onclick="updatelist('bank_master_tp_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','last');" class="btn-last" type="button">&nbsp;</button></td>
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
<div id="modal_form_bse" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Add Bank</h5>
            </div>

            <form action="<?=base_url()?>bank_master_tp/save" method="post">
                <div class="modal-body">
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
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>No. Account</label>
                                <select class="select-search" field="unit" id="acc_bank" name="acc_bank" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kode Bank</label>
                                <input type="text" id="kode_bank" name="kode_bank" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kode Penerimaan</label>
                                <input type="text" id="kode_penerimaan" name="kode_penerimaan" placeholder="" class="form-control">
                                <input type="hidden" id="id" name="id" value="">
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
    $('#modal_form_bank_tp').on('show.bs.modal', function (e) {
        var table_id = $(e.relatedTarget).data('id');
	var id_bank = $(e.relatedTarget).data('id_bank');
	var unit = $(e.relatedTarget).data('unit');
	var acc_bank = $(e.relatedTarget).data('acc_bank');
	var kode_bank = $(e.relatedTarget).data('kode_bank');
	var kode_penerimaan = $(e.relatedTarget).data('kode_penerimaan');
       
        $(".modal-body #id").val(table_id);
        $(".modal-body #id_bank").val(id_bank);
        $(".modal-body #unit").val(unit);
        $(".modal-body #acc_bank").val(acc_bank);
        $(".modal-body #kode_bank").val(kode_bank);
        $(".modal-body #kode_penerimaan").val(kode_penerimaan);
    });
</script>