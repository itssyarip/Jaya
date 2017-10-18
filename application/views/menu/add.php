<script type="text/javascript" src="<?=base_url()?>assets/application.js"></script>
<div class="panel-heading">
    <h5 class="panel-title"><?php echo $title; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
</div>
<div class="panel-body">
    <form class="form-horizontal" method="post" action="<?= base_url() ?>menu/save">
        <div class="form-group">
            <label class="control-label col-lg-2">Nama Menu</label>
            <div class="col-lg-10">
                <input type="text" id="menu_name" name="menu_name" value="<?php echo isset($dataRow[0]['menu_name']) ? $dataRow[0]['menu_name'] : '' ?>" class="form-control" placeholder="nama menu">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Menu Link</label>
            <div class="col-lg-10">
                <input type="text" id="menu_link" name="menu_link" value="<?php echo isset($dataRow[0]['menu_link']) ? $dataRow[0]['menu_link'] : '' ?>" class="form-control" placeholder="menu link(nama controller)">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Modul</label>
            <div class="col-lg-10">
                <select id="menu_modul" name="menu_modul" tabindex="1" class="select">
                    <?php 
                    $selected='';              
                    foreach($modul as $index => $value) { 
                        if($dataRow != NULL){                  
                            if ($dataRow[0]['menu_modul']) {
                                if ($dataRow[0]['menu_modul'] == $index) {
                                    $selected = "selected=selected";
                                } else {
                                    $selected = '';
                                }
                            }
                        }
                    ?>
                        <option value="<?=$index?>" <?php echo $selected;?>><?=$value?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Position</label>
            <div class="col-lg-10">
                <select id="menu_ctgr" name="menu_ctgr" tabindex="1" class="select">
                    <?php 
                    $selected='';              
                    foreach($menuCtgr as $index => $value) { 
                        if($dataRow != NULL){                  
                            if ($dataRow[0]['menu_ctgr']) {
                                if ($dataRow[0]['menu_ctgr'] == $index) {
                                    $selected = "selected=selected";
                                } else {
                                    $selected = '';
                                }
                            }
                        }
                    ?>
                        <option value="<?=$index?>" <?php echo $selected;?>><?=$value?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Menu Parent</label>
            <div class="col-lg-10">
                <?=$menuList?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Menu Order</label>
            <div class="col-lg-10">
                <input type="text" id="menu_order" name="menu_order" value="<?php echo isset($dataRow[0]['menu_order']) ? $dataRow[0]['menu_order'] : '' ?>" class="form-control" placeholder="menu order">
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-lg-2">Aktif</label>
            <div class="col-lg-10">
                <input type="checkbox" id="menu_active" name="menu_active" <?php echo (isset($dataRow[0]['menu_active']) && $dataRow[0]['menu_active'] == 'Y') ? 'checked' : '' ?> value="Y" class="m-wrap medium">
            </div>
        </div>
        <div class="text-center">
            <input type="hidden" id="id" name="id" value="<?php echo isset($dataRow[0]['id']) ? $dataRow[0]['id'] : '' ?>"/>
            <button class="btn btn-primary" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
            <button class="btn btn-primary" type="submit" id="btncancel" name="btncancel" value="Cancel">Cancel</button>
        </div>
    </form>
</div>