<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : ""?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard');?>"><?php echo lang('home');?></a>
            </li>
            <li>
                <a href="<?php echo site_url('users');?>"><?php echo lang('user');?></a>
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
                      <?php $message = $this->session->flashdata('success');
                            if(!empty($message)):?><div class="alert alert-success">
                                <?php echo $message;?></div><?php endif; ?>
                       <?php $error = $this->session->flashdata('error');
                            if(!empty($error)):?><div class="alert alert-danger">
                                <?php echo $error;?></div><?php endif; ?>
                     <div id="message"></div>
                    <div class="col-lg-12" style="overflow-x: auto">
                        <h3 class="text-success"><a class="text-danger" onclick="window.history.back();"><i class="fa fa-arrow-circle-o-left"></i>BACK</a> User Teams => <?php echo ucwords($users->first_name).' ('.$users->email;?>)</h3>   
                    <table class="table table-bordered table-responsive" id="common_datatable_users_team">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Match</th>
                                <th>Create Date</th>
                                <th>Action</th>
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
                            <td><?php echo $rows->name;?></td>
                            <td><?php echo $rows->team;?></td>
                            <td><?php echo date('d-m-Y',strtotime($rows->create_date));?></td>
                            <td class="actions">
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="MyTeams('<?php echo $rows->id;?>','<?php echo $rows->series_id;?>')"><img width="18" src="<?php echo base_url().CRICKET_ICON;?>" /> Players</a>
                            </td>
                            </tr>
                            <?php endforeach; endif;?>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
                
        </div>
    </div>
</div>
    <div id="players_model_box"></div>