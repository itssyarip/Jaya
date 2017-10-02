<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<?php                
    $this->load->view("util/formJs");
    $this->load->view("util/formCss");
?>
<br/>
<div class="row-fluid">
    <div class="span12">
        <div class="portlet box yellow">
            <div class="portlet-title">
                <div class="caption"><i class="icon-question-sign"></i>Edit Content</div>
            </div>
            <form action="<?=base_url()?>content/save" method="post" enctype="multipart/form-data">
            <div class="portlet-body">
                
                <div class="control-group">
                        <label class="control-label" style="float:left;width:120px;">Menu</label>
                        <div class="controls" style="display:inline-block;width:250px;">
                            <?=$menuList?>
                            <span class="help-inline"></span>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="float:left;width:120px;">Is Homepage</label>
                    <div class="controls" style="display:inline-block;width:250px;">
                        <input type="checkbox" id="is_homepage" name="is_homepage" <?php echo (isset($dataRow[0]['is_homepage']) && $dataRow[0]['is_homepage'] == 'Y') ? 'checked' : '' ?> value="Y" class="m-wrap medium">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="float:left;width:120px;">Order</label>
                    <div class="controls" style="display:inline-block;width:250px;">
                        <input type="text" id="order" name="order" value="<?php echo (isset($dataRow[0]['order']) && $dataRow[0]['order'] != '') ? $dataRow[0]['order'] : '0' ?>" class="m-wrap xsmall">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="float:left;width:120px;">Prakata : <img src="<?=base_url()?>assets/starhotel/images/en_flag.png" style="margin-top:8px;width:20px"/></label>
                    <div class="controls" style="display:inline-block;width:250px;">
                        <textarea class="m-wrap" id="content_prakata_en" name="content_prakata_en" rows="6"><?php echo isset($dataRow[0]['content_prakata_en']) ? $dataRow[0]['content_prakata_en']:''; ?></textarea>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="float:left;width:120px;">Prakata : <img src="<?=base_url()?>assets/starhotel/images/indonesia_flag.png" style="margin-top:8px;width:20px"/></label>
                    <div class="controls" style="display:inline-block;width:250px;">
                        <textarea class="m-wrap" id="content_prakata" name="content_prakata" rows="6"><?php echo isset($dataRow[0]['content_prakata']) ? $dataRow[0]['content_prakata']:''; ?></textarea>
                        <span class="help-inline"></span>
                    </div>
                </div>
<!--                <div class="control-group">
                    <label class="control-label" style="float:left;width:140px;">Attach File</label>									 
                    <div class="controls">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input">
                                    <i class="icon-file fileupload-exists"></i> 
                                    <span class="fileupload-preview"></span>
                                </div>
                                <span class="btn btn-file">
                                    <span class="fileupload-new">Pilih File</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file" class="default" id="content_file" name="content_file" multiple='multiple'/>
                                </span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>
                        </div>
                    </div> 
                </div>-->
                <?php //if (isset($dataRow[0]['content_file_name'])) {?>
<!--                <div class="control-group">
                    <label class="control-label" style="float:left;width:140px;">Latest Attachment</label>									 
                    <div class="controls">
                        <?php //echo $dataRow[0]['content_file_name'];?>
                        <br/>
                    </div> 
                </div>-->
                <?php //}?>
                <div class="accordion scrollable" id="accordion2">  
                    <div class="accordion-group"> 
                        <div class="accordion-inner">  
                            <div class="control-group">
                                
                                <label class="control-label">Edit Content : <img src="<?=base_url()?>assets/starhotel/images/en_flag.png" style="margin-top:8px;width:20px"/></label>
                                <div class="controls">
                                    <?php //echo $this->ckeditor->editor("content_data_en","value"); ?>
                                    <textarea class="span12 ckeditor m-wrap company_content" id="content_data_en" name="content_data_en" rows="6"><span class="test"><?php echo isset($dataRow[0]['content_data_en']) ? $dataRow[0]['content_data_en']:''; ?></span> </textarea>
                                </div>
                            </div> 
                        </div>  
                    </div> 
                </div>
                <div class="accordion scrollable" id="accordion2">  
                    <div class="accordion-group"> 
                        <div class="accordion-inner">  
                            <div class="control-group">
                                
                                <label class="control-label">Edit Content : <img src="<?=base_url()?>assets/starhotel/images/indonesia_flag.png" style="margin-top:8px;width:20px"/></label>
                                <div class="controls">
                                    <textarea class="span12 ckeditor m-wrap company_content2" id="content_data" name="content_data" rows="6"><span class="test"><?php echo isset($dataRow[0]['content_data']) ? $dataRow[0]['content_data']:''; ?></span> </textarea>
                                </div>
                            </div> 
                        </div>  
                    </div> 
                </div>
                <span>
                    <button type="button" class="btn green" onclick="javascript:add_content_file('<?= base_url() ?>','<?=$this->router->class?>','content_file_add')">Add File <i class="icon-plus"></i></button>
                </span>
                <table class="table table-striped table-bordered table-hover" id="content_file_add">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>File</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($childData)) {
                        echo ($childData);
                    }
                    ?>
                </tbody>
                </table>
                <div class="control-group">
                    <center>
                        <button type="submit" class="btn green save">Save</button>
                        <button class="btn" type="submit" id="btncancel" name="btncancel" value="Cancel">Cancel</button>
                    </center>

                </div>
                <input type="hidden" id="id" name="id" value="<?php echo isset($dataRow[0]['id']) ? $dataRow[0]['id'] : '' ?>"/>
                </form>
            </div>
        </div>  
    </div>
</div>
<script type="text/javascript" src="<?= base_url() ?>assets/metronic/plugins/ckeditor/ckeditor.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>assets/metronic/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/metronic/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />

<script type="text/javascript">
    $(document).ready(function() {
//        FormComponents.init();
    });
</script> 
