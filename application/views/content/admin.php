<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<br/>
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><i class="icon-globe"></i><?php echo $title; ?></div>
            </div>
            <div class="portlet-body">
                <div class="clearfix">
                    <div class="btn-group">
                        <a class="btn green" onclick="javascript:add_content('<?= base_url() ?>');">Add New <i class="icon-plus"></i></a>
                    </div>
                    <div class="btn-group">
                        <button class="btn green" onclick="javascript:delete_menu('<?= base_url() ?>', 'content','admin');">
                            Delete <i class="icon-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="">
                        <div class="dataTables_filter">
                            <label>Search: <input type="text" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('content_list','<?=base_url()?>','<?php echo $this->router->fetch_class();?>',this);" class="m-wrap small"></label>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-full-width" id="content_list">
                    <thead>
                        <tr>
                            <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                            <th>Menu Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($contentData) {
                            foreach ($contentData as $index => $value) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                    <td><a href="#" onclick="javascript:add_content('<?= base_url() ?>', '<?= $value['id'] ?>');"><?php echo $value['menu_name']; ?></a></td>
                                    <!--<td><?php echo isset($value['alias']) ? $value['alias'] : ''; ?></td>-->
                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
                <div style="width:100%">
                    <div style="width:20%;margin:0 auto;">
                    <table class="footer-table">
                        <tbody>
                            <tr>
                                <td><button onclick="updatelist('content_list', '<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','first');" class="btn-first" type="button">&nbsp;</button></td>
                                <td><button onclick="updatelist('content_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','prev');" class="btn-prev" type="button">&nbsp;</button></td>
                                <td><span class="ytb-sep"></span></td>
                                <td><span class="ytb-text">Page</span></td>
                                <td><input type="text" onkeyup="updatelist('content_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','page', this.value);" size="3" value="<?php echo ($pnumber) ?$pnumber :1;?>" class="pnumber"></td>
                                <td><span class="ytb-text" id="totaldata_view">of <?php echo round($totaldata/10)?></span></td>
                                <td><span class="ytb-sep"></span></td>
                                <td><button onclick="updatelist('content_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','next');" class="btn-next" type="button">&nbsp;</button></td>
                                <td><button onclick="updatelist('content_list','<?php echo base_url();?>','<?php echo $this->router->fetch_class();?>','last');" class="btn-last" type="button">&nbsp;</button></td>
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
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<link rel="stylesheet" href="<?= base_url() ?>assets/metronic/plugins/data-tables/DT_bootstrap.css" />
<script>
    $(document).ready(function() {
        initPaging();
    });
    
</script>