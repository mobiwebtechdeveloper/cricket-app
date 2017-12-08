<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin'); ?>"><?php echo lang('home');?></a>
            </li>
            <li class="active">
                <strong><?php echo lang('change_password');?></strong>
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
                </div>
                <div class="ibox-content">
                    <div class="row">

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
                        
                        <?php 
                            if(isset($error) && !empty($error) && !is_array($error)):?><div class="alert alert-danger">
                                <?php echo $error;?></div><?php endif; ?>
                            <?php if(is_array($error) && !empty($error)):
                                foreach($error as $msg):?>
                                <div class="alert alert-danger">
                                <?php echo $msg;?></div>
                               <?php endforeach;
                            endif;
                                ?>
                
                        
                        
                        <?php echo form_open("admin/change_password"); ?>

                       
                        <div class="row">
                            <div class="col-lg-4" >
                                <div class="form-group">
                                    <label class=" control-label"><?php echo lang('change_password_old_password_label', 'old_password'); ?> <i class="error">*</i></label>
                                    <div class="col-lg-12">
                                        <?php echo form_input($old_password); ?>
                                        <div class="has-error help-block error" id="<?php echo "er_old_password"; ?>" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"> 
                            <div class="col-lg-4" >
                                <div class="form-group">
                                    <label class=" control-label"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?> <i class="error">*</i></label>
                                    <div class="col-lg-12">
                                        <?php echo form_input($new_password); ?>
                                        <div class="has-error help-block error" id="<?php echo "er_" . $min_password_length; ?>" ></div>
                                    </div>
                                </div>
                            </div>  
                        </div>  


                        <div class="row">
                            <div class="col-lg-4" >
                                <div class="form-group">
                                    <label class=" control-label"><?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?> <i class="error">*</i></label>
                                    <div class="col-lg-12">
                                        <?php echo form_input($new_password_confirm); ?>
                                        <div class="has-error help-block error" id="<?php echo "er_new_password_confirm"; ?>" ></div>
                                    </div>
                                </div>
                            </div>     
                        </div>


                        <?php echo form_input($user_id); ?>

                        <div class="clearfix"></div>
                        <hr class="col-lg-11" />
                        <div class="col-lg-12">
                            <button type="submit"  class="<?php echo THEME_BUTTON;?> btn-lg"><?php echo lang('change_password');?></button>
                        </div>
 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <?php echo form_close(); ?>


                    </div>
                </div>
            </div>
        </div>
    </div>