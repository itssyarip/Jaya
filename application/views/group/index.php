<script type="text/javascript" src="<?=base_url()?>assets/application.js"></script>
<br/>
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><i class="icon-globe"></i><?php echo $title;?></div>
            </div>
            <div class="portlet-body">
                <div class="clearfix">
                    <div class="btn-group">
                        <a class="btn green" data-toggle="modal" href="#add_group">Add New <i class="icon-plus"></i></a>
                    </div>
                    <div class="btn-group">
                        <button class="btn green" onclick="javascript:delete_menu('<?=base_url()?>','group');">
                            Delete <i class="icon-plus"></i>
                        </button>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                        <tr>
                            <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                            <th>Nama Group</th>
                            <th>Kode Group</th>
                            <th>Tipe Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($dataList) {
                            $i=0;
                            foreach ($dataList as $index => $value) {
                                if($this->session->userdata['user_type'] == 'wf'){
                                    if($value['group_type'] == 'wf'){?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" class="delcheck" value="<?php echo $value['group_code']; ?>" /></td>
                                            <td><a href="#add_group" class="edit-group" data-toggle="modal" data-group_code="<?=$value['group_code']?>" data-group_name="<?=$value['group_name']?>" data-group_type="<?=$value['group_type']?>" data-group_level="<?=$value['group_level']?>"><?php echo $value['group_name']; ?></a></td>
                                            <td><?=$value['group_code']?></td>
                                            <td><?=$groupType[$value['group_type']]?></td>
                                        </tr>
                                    <?php }
                                }else{
                                ?>
                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" class="delcheck" value="<?php echo $value['group_code']; ?>" /></td>
                                        <td><a href="#add_group" class="edit-group" data-toggle="modal" data-group_code="<?=$value['group_code']?>" data-group_name="<?=$value['group_name']?>" data-group_type="<?=$value['group_type']?>" data-group_level="<?=$value['group_level']?>"><?php echo $value['group_name']; ?></a></td>
                                        <td><?=$value['group_code']?></td>
                                        <td><?=$groupType[$value['group_type']]?></td>
                                    </tr>
                                <?php } ?>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                        <input type="hidden" id="totalRow" name="totalRow" value="<?=$i?>"/>
                    </tbody>
                </table>
            </div>
            <div id="add_group" class="modal hide fade" tabindex="-1" data-width="760">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3>Add Group</h3>
                </div>
                <form action="<?=base_url()?>group/save" id="add_group_form" method="post">				
                        <div class="modal-body">
                                <div class="row-fluid" style="padding-top:20px;">
                                    <div class="span12">
                                        <span class="span12">&nbsp;</span>
                                        <div class="control-group span12">
                                                <label class="control-label span3">Nama Group</label>
                                                <div class="controls span9">
                                                    <input type="text" id="group_name" name="group_name" class="span8 m-wrap">
                                                </div>
                                        </div>
                                        <div class="control-group span12">
                                                <label class="control-label span3">Kode Group</label>
                                                <div class="controls span9">
                                                    <input type="text" id="group_code" name="group_code" class="span8 m-wrap xsmall">
                                                </div>
                                        </div>
                                        <div class="control-group span12">
                                                <label class="control-label span3">Tipe Group</label>
                                                <div class="controls span9">
                                                    <select id="group_type" name="group_type" tabindex="1" class="medium m-wrap">
                                                        <?php 
                                                        $selected='';
                                                        foreach($groupType as $index => $value) { ?>
                                                            <option value="<?=$index?>"><?=$value?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                        </div>
<!--                                        <div class="control-group span12">
                                                <label class="control-label span3">Level Group</label>
                                                <div class="controls span9">
                                                    <select id="group_level" name="group_level" tabindex="1" class="medium m-wrap">
                                                        <?php 
                                                        $selected='';
                                                        foreach($groupLevel as $indexLvl => $valueLvl) { ?>
                                                            <option value="<?=$indexLvl?>"><?=$valueLvl?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                        </div>-->
                                    </div>
                                </div>
                                    
                        </div>
                        <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn">Close</button>
                                <button type="submit" id="submit" class="btn blue">Save</button>
                        </div>
                </form>
        </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
$('.edit-group').click(function(){
	var table_id = $(this).data('group_code');
	var group_name = $(this).data('group_name');
//	var group_type = $(this).data('group_type');
//	var group_level = $(this).data('group_level');
        $(".modal-body #group_code").val(table_id);
        $(".modal-body #group_name").val(group_name);
//        $(".modal-body #group_type").val(group_type);
//        $(".modal-body #group_level").val(group_level);
});
</script>