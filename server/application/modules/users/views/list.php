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
                <div class="ibox-title">
                    <div class="btn-group " href="#">
                        <a href="javascript:void(0)"  onclick="open_modal('users')" class="<?php echo THEME_BUTTON;?>">
                          <img width="18" src="<?php echo base_url().CRICKET_ICON;?>" />  <?php echo lang('add_user');?>
                        </a>
                    </div>
                </div>
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
                    <table class="table table-bordered table-responsive" id="common_datatable_users">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_no');?></th>
                                <th><?php echo lang('user_name');?></th>
                                <th><?php echo lang('user_email');?></th>
                                <th><?php echo lang('roles');?></th>
                                <th><?php echo "Current Password";?></th>
<!--                                <th><?php echo lang('profile_image');?></th>-->
                                 <th><?php echo lang('status');?></th>
<!--                                <th><?php //echo lang('user_createdate');?></th>-->
                                <th style="width: 12%"><?php echo lang('action');?></th>
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
                            <td><?php echo $rows->first_name.' '.$rows->last_name;?></td>
                            <td><?php echo $rows->email?></td>
                            <td><?php echo ucwords($rows->group_name);?></td>
                            <td><?php echo $rows->is_pass_token;?></td>
<!--                            <td><img width="100" src="<?php if(!empty($rows->profile_pic)){echo base_Url()?><?php echo $rows->profile_pic;}else{echo base_url().DEFAULT_NO_IMG_PATH;}?>" /></td>-->
                            
                            <td><?php if($rows->active == 1) echo '<p class="text-success">'.lang('active').'</p>'; else echo '<p  class="text-danger">'.lang('deactive').'</p>';?></td>
<!--                            <td><?php //echo date('d F Y',$rows->created_on);?></td>-->
                            <td class="actions">
                                <a href="javascript:void(0)" class="on-default edit-row" onclick="editFn('<?php echo USERS;?>','user_edit','<?php echo encoding($rows->id); ?>');"><img width="20" src="<?php echo base_url().EDIT_ICON;?>" /></a>
                            
                            <?php if($rows->id != 1){if($rows->active == 1) {?>
                            <a href="javascript:void(0)" class="on-default edit-row" onclick="statusFn('<?php echo USERS;?>','id','<?php echo encoding($rows->id);?>','<?php echo $rows->active;?>')" title="Inactive Now"><img width="20" src="<?php echo base_url().ACTIVE_ICON;?>" /></a>
                            <?php } else { ?>
                            <a href="javascript:void(0)" class="on-default edit-row text-danger" onclick="statusFn('<?php echo USERS;?>','id','<?php echo encoding($rows->id); ?>','<?php echo $rows->active;?>')" title="Active Now"><img width="20" src="<?php echo base_url().INACTIVE_ICON;?>" /></a>
                            <?php } ?>
                            <a href="javascript:void(0)" onclick="deleteFn('<?php echo USERS;?>','id','<?php echo encoding($rows->id); ?>','users','users/delUsers')" class="on-default edit-row text-danger"><img width="20" src="<?php echo base_url().DELETE_ICON;?>" /></a>
                            <hr>
                            <a href="<?php echo base_url().'users/contest/'.encoding($rows->id);?>" class="btn btn-info btn-sm"><img width="18" src="<?php echo base_url().CRICKET_ICON;?>" /> Contest</a>
                            <a href="<?php echo base_url().'users/joinContest/'.encoding($rows->id);?>" class="btn btn-primary btn-sm"><img width="18" src="<?php echo base_url().CRICKET_ICON;?>" /> Joined Contest</a>
                            <a href="<?php echo base_url().'users/teams/'.encoding($rows->id);?>" class="btn btn-success btn-sm"><img width="18" src="<?php echo base_url().CRICKET_ICON;?>" /> Match Teams</a>
                            <a href="<?php echo base_url().'users/transactions/'.encoding($rows->id);?>" class="btn btn-warning btn-sm"><img width="18" src="<?php echo base_url().CRICKET_ICON;?>" /> Transactions</a>
                            </td>
                            </tr>
                            <?php }endforeach; endif;?>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
                <div id="form-modal-box"></div>
        </div>
    </div>
</div>