<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : "" ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo lang('home'); ?></a>
            </li>
            <li>
                <a href="<?php echo site_url('configuration'); ?>">Point System</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                        <?php
                        $message = $this->session->flashdata('success');
                        if (!empty($message)):
                            ?><div class="alert alert-success">
                                <?php echo $message; ?></div><?php endif; ?>
                        <?php
                        $error = $this->session->flashdata('error');
                        if (!empty($error)):
                            ?><div class="alert alert-danger">
                                <?php echo $error; ?></div><?php endif; ?>
                        <div id="message"></div>
                        <div class="col-lg-12" style="overflow-x: auto">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5><?php Icon(); ?> Fantasy Points System</h5>
                                            <div class="ibox-tools">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                                <a class="close-link">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <form class="form-horizontal" role="form" id="addFormAjax" method="post" action="<?php echo base_url('configuration/configuration_add') ?>" enctype="multipart/form-data">
                                                <table class="table table-bordered table-responsive" id="common_datatable_users">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:50%;" class="text-danger">Type of Points (Main)</th>
                                                            <th>T20</th>
                                                            <th>ODI</th>
                                                            <th>Test</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $inputArr = fantasyPointInput();
                                                          if(!empty($inputArr)){
                                                              foreach($inputArr['main'] as $key=>$main){?>
                                                        <tr>
                                                            <td><?php echo $main;?></td> 
                                                            <td><input type="text" name="<?php echo $key?>_t20" class="form-control" placeholder="0" value="<?php echo getConfig($key."_t20"); ?>" oninput="this.value = this.value.replace(/[^0-9.-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
                                                            <td><input type="text" name="<?php echo $key?>_odi" class="form-control" placeholder="0" value="<?php echo getConfig($key."_odi"); ?>" oninput="this.value = this.value.replace(/[^0-9.-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
                                                            <td><input type="text" name="<?php echo $key?>_test" class="form-control" placeholder="0" value="<?php echo getConfig($key."_test"); ?>" oninput="this.value = this.value.replace(/[^0-9.-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
                                                        </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th style="width:50%;" class="text-danger">Type of Points (Bonus)</th>
                                                            <th>T20</th>
                                                            <th>ODI</th>
                                                            <th>Test</th>
                                                        </tr>
                                                        <?php foreach($inputArr['bonus'] as $key=>$main){?>
                                                        
                                                         <tr>
                                                            <td><?php echo $main;?></td> 
                                                            <td><input type="text" name="<?php echo $key?>_t20" class="form-control" placeholder="0" value="<?php echo getConfig($key."_t20"); ?>" oninput="this.value = this.value.replace(/[^0-9.-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
                                                            <td><input type="text" name="<?php echo $key?>_odi" class="form-control" placeholder="0" value="<?php echo getConfig($key."_odi"); ?>" oninput="this.value = this.value.replace(/[^0-9.-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
                                                            <td><input type="text" name="<?php echo $key?>_test" class="form-control" placeholder="0" value="<?php echo getConfig($key."_test"); ?>" oninput="this.value = this.value.replace(/[^0-9.-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
                                                        </tr>
                                                        
                                                        <?php }}?>
                                                        
                                                    </tbody>
                                                </table>
                                                <div class="hr-line-dashed"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-4 col-sm-offset-2">
                                                        <button class="btn btn-danger" type="submit"><?php echo lang('cancle_btn'); ?></button>
                                                        <button class="<?php echo THEME_BUTTON; ?>" type="submit" id="submit" ><?php echo lang('save_btn'); ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
