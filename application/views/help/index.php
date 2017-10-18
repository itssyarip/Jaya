<br/>
<div class="row-fluid">
    <div class="span12">
        <div class="portlet box yellow">
            <div class="portlet-title">
                    <div class="caption"><i class="icon-question-sign"></i>Help</div>
            </div>
            <div class="portlet-body">
                <div class="accordion scrollable" id="accordion2"> 
                    <?php 
                    $arrayGroup = explode(',', $this->session->userdata('user_group'));
                    foreach ($helpData as $help => $value) {?>
                    <div class="accordion-group">
                        <?php 
                            if (in_array("00", $arrayGroup)){?>
                        <form action="<?=base_url()?>help/save" method="post">
                            <?php } ?>
                                <div class="accordion-heading">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_<?=$value['id'];?>">
                                        <?=$value['help_title'];?>
                                    </a>
                                </div>
                                <div id="collapse_2_<?=$value['id'];?>" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        <?php
                                            if (in_array("00", $arrayGroup)){?>
                                                <input type="hidden" name="id" value="<?=$value['id']?>">
                                                Title : <input type="text" name="help_title" value="<?=$value['help_title']?>">
                                                <div class="control-group">
                                                    <label class="control-label">Deskripsi : </label>
                                                        <div class="controls">
                                                            <textarea class="span12 ckeditor m-wrap" name="help_desc" rows="6"><?=$value['help_desc'];?></textarea>
                                                        </div>
                                                    <br>
                                                    <center>
                                                        <button type="submit" class="btn blue">Save</button>
                                                        <button type="button" class="btn">Cancel</button> 
                                                    </center>
                                                </div>
                                        <?php
                                            }else{
                                                echo $value['help_desc'];
                                            }
                                        ?>
                                    </div>
                                </div> 
                            <?php 
                            if (in_array("00", $arrayGroup)){?>
                            </form>
                            <?php }?>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>  
    </div>
</div>
<script type="text/javascript" src="<?=base_url()?>assets/metronic/plugins/ckeditor/ckeditor.js"></script> 