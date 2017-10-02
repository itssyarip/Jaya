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
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                        <tr>
                            <th>Nama Group</th>
                            <th>Kode Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($dataList) {
                            foreach ($dataList as $index => $value) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><a href="#" onclick="javascript:auth_edit('<?=base_url()?>','<?=$value['group_code']?>');"><?php echo $value['group_name']; ?></a></td>
                                    <td><?=$value['group_code']?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>