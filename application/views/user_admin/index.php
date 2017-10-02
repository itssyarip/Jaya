<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
<br/>
<div class="panel-heading">
    <h5 class="panel-title"><?php echo $title; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
</div>
<div class="panel-body">
        <div class="btn-group">
            <a class="btn green" onclick="javascript:add_users('<?= base_url() ?>');">Add New <i class="icon-plus"></i></a>
        </div>
        <div class="btn-group">
            <button class="btn green" onclick="javascript:delete_menu('<?= base_url() ?>', 'user_admin');">
                Delete <i class="icon-plus"></i>
            </button>
        </div>
</div>
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
    <div class="datatable-header">
        <div id="DataTables_Table_0_filter" class="dataTables_filter">
            <label>Search: <input type="text" field="user_name,user_real_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('user_admin_list','<?=base_url()?>','<?php echo $this->router->fetch_class();?>',this);" class="m-wrap small"></label>
        </div>
    </div>
    <div class="datatable-scroll"> 
        <table class="table table-bordered table-xs" id="user_admin_list" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row" class="bg-blue">
                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                    <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending">Nama</th>
                    <th>Nama Asli</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($userData) {
                    foreach ($userData as $index => $value) {
                        ?>
                        <tr>
                            <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                            <td><a href="#" onclick="javascript:add_users('<?= base_url() ?>', '<?= $value['id'] ?>');"><?php echo $value['user_name']; ?></a></td>
                            <td><?php echo isset($value['user_real_name']) ? $value['user_real_name'] : ''; ?></td>
                        </tr>
                        <?php
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
                    <td><button onclick="updatelist('user_admin_list', '<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','first');" class="btn-first" type="button">&nbsp;</button></td>
                    <td><button onclick="updatelist('user_admin_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','prev');" class="btn-prev" type="button">&nbsp;</button></td>
                    <td><span class="ytb-sep"></span></td>
                    <td><span class="ytb-text">Page</span></td>
                    <td><input type="text" onkeyup="updatelist('user_admin_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','page', this.value);" size="3" value="<?php echo ($pnumber) ?$pnumber :1;?>" class="pnumber"></td>
                    <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata/10)?></span></td>
                    <td><span class="ytb-sep"></span></td>
                    <td><button onclick="updatelist('user_admin_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','next');" class="btn-next" type="button">&nbsp;</button></td>
                    <td><button onclick="updatelist('user_admin_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','last');" class="btn-last" type="button">&nbsp;</button></td>
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
        <!-- END EXAMPLE TABLE PORTLET-->
<div id="upload_user_admin" class="modal hide fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>Upload Data Lokasi</h3>
    </div>
    <form action="<?= base_url() ?>user_admin/upload"  method="post" enctype="multipart/form-data">				
        <div class="modal-body_upload">
            <div class="row-fluid">
                <div class="span12">
                    <span class="span12">&nbsp;</span>
                    <div class="control-group span12">
                        <label class="control-label span3">CSV file</label>									 
                        <div class="controls span9">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-append">
                                    <div class="uneditable-input">
                                        <i class="icon-file fileupload-exists"></i> 
                                        <span class="fileupload-preview"></span>
                                    </div>
                                    <span class="btn btn-file">
                                        <span class="fileupload-new">Select file</span>
                                        <span class="fileupload-exists">Change</span>
                                        <input type="file" class="default"  id="csvdata" name="csvdata" multiple='multiple'/>
                                    </span>
                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="control-group span12">
                        <label class="control-label span3">Password Default</label>									 
                        <div class="controls span9">
                            <input type="text" id="pass_default" name="pass_default"/>
                        </div> 
                    </div>
                </div> 
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn">Close</button>
            <button type="submit" class="btn blue">Upload</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        initPaging();
    });
    
</script>
<script type="text/javascript" src="<?=base_url()?>assets/template/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/template/js/plugins/forms/selects/select2.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/template/js/pages/datatables_basic.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/template/js/plugins/ui/ripple.min.js"></script>