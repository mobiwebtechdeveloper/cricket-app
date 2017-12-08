<style>
    .modal-footer .btn + .btn {
        margin-bottom: 5px !important;
        margin-left: 5px;
    }
</style>
<div id="commonModal1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Team Player List</h4>
            </div>
            <div class="modal-body"> 
                <div class="loaders">
                    <img src="<?php echo base_url() . 'assets/images/Preloader_3.gif'; ?>" class="loaders-img" class="img-responsive">
                </div>
                <div class="alert alert-danger" id="error-box" style="display: none"></div>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12" >
                            <table class="table table-bordered table-responsive" id="common_datatable_users_team">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Team</th>
                                        <th>Player Name</th>
                                        <th>Player Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($list) && !empty($list)):
                                        $rowCount = 0;
                                        foreach ($list as $rows):
                                            $rowCount++;
                                            ?>
                                            <tr>
                                                <td><?php echo $rowCount; ?></td>            
                                                <td><?php echo $rows->team; ?></td>
                                                <td><?php echo $rows->player_name; ?></td>
                                                <td><?php echo $rows->player_position; ?></td>
                                            </tr>
                                        <?php endforeach;
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="space-22"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang('close_btn'); ?></button>
            </div>
        </div> <!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


