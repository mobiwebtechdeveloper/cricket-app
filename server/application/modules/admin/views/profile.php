<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin');?>"><?php echo lang('home');?></a>
            </li>
            <li class="active">
                <strong><?php echo lang('edit_profile');?></strong>
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
                        <?php $message = $this->session->flashdata('error');
                            if(!empty($message) && !is_array($message)):?><div class="alert alert-danger">
                                <?php echo $message;?></div><?php endif; ?>
                            <?php if(is_array($message) && !empty($message)):
                                foreach($message as $msg):?>
                                <div class="alert alert-danger">
                                <?php echo $msg;?></div>
                               <?php endforeach;
                            endif;
                                ?>
                 <?php $message = $this->session->flashdata('message');
                            if(!empty($message) && !is_array($message)):?><div class="alert alert-success">
                                <?php echo $message;?></div><?php endif; ?>
                <div class="ibox-content">
                 <div class="row">
                     <div class="col-lg-8">
                 <form name="userEdit" id="editProfile" action="<?php echo site_url('admin/updateProfile');  ?>" method="post" enctype="multipart/form-data">
                
                   <div class="form-group"><label class="col-lg-2 control-label"><?php echo lang('first_name');?></label>

                        <div class="col-lg-10"><input type="text" placeholder="<?php echo lang('first_name');?>" name="first_name" id="first_name" value="<?php echo $user->first_name; ?>" class="form-control"> 
<!--                                        <span class="help-block m-b-none">Example block-level help text here.</span>-->
                                <span class="help-block m-b-none"><?php echo form_error('first_name'); ?></span>
                        </div>
                   </div>
                     
                   <div class="form-group"><label class="col-lg-2 control-label"><?php echo lang('last_name');?></label>

                        <div class="col-lg-10"><input type="text" placeholder="<?php echo lang('last_name');?>" name="last_name" id="last_name" value="<?php echo $user->last_name; ?>" class="form-control"> 
<!--                                        <span class="help-block m-b-none">Example block-level help text here.</span>-->
                                <span class="help-block m-b-none"><?php echo form_error('last_name'); ?></span>
                        </div>
                    </div>
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="clearfix"></div>
                <hr class="col-lg-11" />
                <div class="col-lg-12 col-md-offset-10">
                    <button type="submit"  class="<?php echo THEME_BUTTON;?> btn-lg"><?php echo lang('update_btn');?></button>
                </div>
            </form>
                         </div>
                </div>
            </div>
        </div>
    </div>
</div>