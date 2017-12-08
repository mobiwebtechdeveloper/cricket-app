<div class="wrapper wrapper-content">
    <h3>Welcome <?php echo getConfig('site_name'); ?></h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <div class="stat-percent font-bold text-success"> <i class="fa fa-trophy"></i></div>
                                <h5 ><a class="text-success" href="<?php echo base_url().'users';?>">Users</a></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">
                                    <?php $option = array('table' => 'users');
                                          echo commonCountHelper($option);
                                    ?>
                                </h1>
                                <small>Total Users</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <div class="stat-percent font-bold text-info"><i class="fa fa-trophy"></i></div>
                                <h5 ><a class="text-info" href="<?php echo base_url().'contest';?>">Created Contest</a></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> 
                                    <?php $option = array('table' => 'contest',
                                                          'where'  => array('user_id' => 0) 
                                            );
                                            echo commonCountHelper($option);
                                    ?></h1>

                                <small>Total Created Contest</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <div class="stat-percent font-bold text-navy"><i class="fa fa-trophy"></i></div>
                                <h5 ><a class="text-navy" href="<?php echo base_url().'contest';?>">Progress Contest</a></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">  
                                    <?php $option = array('table' => 'contest',
                                                          'where'  => array('user_id' => 0,'status' => 0) 
                                            );
                                            echo commonCountHelper($option);
                                    ?></h1>

                                <small>Total Contest in Progress</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <div class="stat-percent font-bold text-danger"><i class="fa fa-trophy"></i></div>
                                <h5 ><a class="text-danger" href="<?php echo base_url().'contest';?>">Cancelled Contest</a></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">
                                    <?php $option = array('table' => 'contest',
                                                          'where'  => array('user_id' => 0,'status' => 1) 
                                            );
                                            echo commonCountHelper($option);
                                    ?>
                                </h1>

                                <small>Total Cancelled Contest</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <div class="stat-percent font-bold text-success"><i class="fa fa-trophy"></i></div>
                                <h5><a class="text-success" href="<?php echo base_url().'contest';?>">Completed Contest</a></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">
                                    <?php $option = array('table' => 'contest',
                                                          'where'  => array('user_id' => 0,'status' => 2) 
                                            );
                                            echo commonCountHelper($option);
                                    ?></h1>

                                <small>Total Completed Contest</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>