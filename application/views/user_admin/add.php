<script type="text/javascript" src="<?=base_url()?>assets/application.js"></script>
<div class="panel-heading">
    <h5 class="panel-title"><?php echo $title; ?><a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
</div>
<div class="panel-body">
    <form class="form-horizontal" method="post" action="<?= base_url() ?>user_admin/save">
        <?php                        
                    $hide_superman = '';   
                    $hide_kategori = 'hide';
                    if(isset($this->session->userdata['user_group'])){
                        $user_group = explode(',', $this->session->userdata['user_group']);
                        if(in_array("00", $user_group)) { 
                           $hide_superman = '';            
                           $hide_kategori = 'hide';
                        }else{
                           $hide_superman = 'hide';
                           $input_user_type = '<input type="hidden" name="user_type" id="user_type" value="wf"/>';
                           if($this->session->userdata['user_type'] == 'wf'){
                               $hide_kategori = '';
                           }
                        }
                    }?>
        <div class="form-group">
            <label class="control-label col-lg-2">Nama</label>
            <div class="col-lg-10">
                <input type="text" id="user_name" name="user_name" value="<?php echo isset($dataRow[0]->user_name) ? $dataRow[0]->user_name : '' ?>" class="form-control" placeholder="nama user">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Nama Asli</label>
            <div class="col-lg-10">
                <input type="text" id="user_real_name" name="user_real_name" value="<?php echo isset($dataRow[0]->user_real_name) ? $dataRow[0]->user_real_name : '' ?>" class="form-control" placeholder="nama asli">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Password</label>
            <div class="col-lg-10">
                <input type="password" id="user_pass" name="user_pass" value="" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Retype Password</label>
            <div class="col-lg-10">
                <input type="password" id="user_pass_retype" name="user_pass_retype" value="" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Group</label>
            <div class="col-lg-10">
                <?php
                    if ($groupData) {
                            if (isset($dataRow[0]->user_group)) {
                                $dataRow[0]->user_group = explode(',',$dataRow[0]->user_group);
                            }
                        ?>
                        
                        <?php foreach($groupData as $value) {
                                $checked='';
                                if (isset($dataRow[0]->user_group)) {
                                    if (in_array($value['group_code'],$dataRow[0]->user_group)) {
                                        $checked='checked';
                                    } 
                                }?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="user_group[]" name="user_group[]" <?=$checked?> value="<?php echo $value['group_code'];?>">
                                <?php echo $value['group_name'];?>
                            </label>
                        </div>
                                <?php 
                        }?>
                        
                    <?php } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Email</label>
            <div class="col-lg-10">
                <input type="text" id="user_email" name="user_email" value="<?php echo isset($dataRow[0]->user_email) ? $dataRow[0]->user_email : '' ?>" class="form-control" placeholder="email">
            </div>
        </div>
        <div class="text-center">
            <input type="hidden" id="id" name="id" value="<?php echo isset($dataRow[0]->id) ? $dataRow[0]->id : '' ?>"/>
            <button class="btn btn-primary" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
            <button class="btn btn-primary" type="submit" id="btncancel" name="btncancel" value="Cancel">Cancel</button>
        </div>
    </form>
</div>