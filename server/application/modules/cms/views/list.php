<style>
    #message_div{
        background-color: #ffffff;
        border: 1px solid;
        box-shadow: 10px 10px 5px #888888;
        display: none;
        height: auto;
        left: 36%;
        position: fixed;
        top: 20%;
        width: 40%;
        z-index: 1;
    }
    #close_button{
        right:-15px;
        top:-15px;
        cursor: pointer;
        position: absolute;
    }
    #close_button img{
        width:30px;
        height:30px;
    }    
    #message_container{
        height: 450px;
        overflow-y: scroll;
        padding: 20px;
        text-align: justify;
        width: 99%;
    }
</style>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : "" ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo lang('home'); ?></a>
            </li>
            <li>
                <a href="<?php echo site_url('cms'); ?>"><?php echo lang('cms'); ?></a>
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
                        <a href="javascript:void(0)"  onclick="open_modal('cms')" class="<?php echo THEME_BUTTON; ?>">
                            <?php echo lang('cms'); ?>
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <?php $message = $this->session->flashdata('success');
                        if (!empty($message)):
                            ?><div class="alert alert-success">
                            <?php echo $message; ?></div><?php endif; ?>
                            <?php $error = $this->session->flashdata('error');
                            if (!empty($error)):
                                ?><div class="alert alert-danger">
    <?php echo $error; ?></div><?php endif; ?>
                        <div id="message"></div>
                        <div class="col-lg-12" style="overflow-x: auto">
                            <table class="table table-bordered table-responsive" id="common_datatable_cms">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('serial_no'); ?></th>
                                        <th><?php echo lang('page_id'); ?></th>
                                        <th><?php echo lang('description'); ?></th>
                                        <th><?php echo lang('image'); ?></th>
                                        <th><?php echo lang('action'); ?></th>
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
                                                <td><?php echo allModules($rows->page_id); ?></td>
                                                <td style="width:25%;"><?php
                                                    if (strlen($rows->description) > 400) {
                                                        $content = $rows->description;
                                                        echo mb_substr($rows->description, 0, 400, 'UTF-8') . '...<br>';
                                                        ?>
                                                        <a style="cursor:pointer" onclick="show_message('<?php echo base64_encode($content); ?>')"><?php echo lang('view'); ?></a>
                                                        <?php
                                                    } else if (strlen($rows->description) > 0) {
                                                        echo $rows->description;
                                                    }
                                                    ?></td>
                                                <td><img width="100" src="<?php if (!empty($rows->image)) {
                                                echo base_Url() ?>uploads/cms/<?php echo $rows->image;
                                            } else {
                                                echo base_url() . DEFAULT_NO_IMG_PATH;
                                            } ?>" /></td>

                                                <td class="actions">
                                                    <a href="javascript:void(0)" class="on-default edit-row" onclick="editFn('<?php echo CMS; ?>', 'cms_edit', '<?php echo encoding($rows->cms_id) ?>');"><img width="20" src="<?php echo base_url() . EDIT_ICON; ?>" /></a>
                                                    <a href="javascript:void(0)" onclick="deleteFn('<?php echo CMS; ?>', 'cms_id', '<?php echo encoding($rows->cms_id); ?>', 'cms')" class="on-default edit-row text-danger"><img width="20" src="<?php echo base_url() . DELETE_ICON; ?>" /></a>

                                                </td>
                                            </tr>
    <?php endforeach;
endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="form-modal-box"></div>
            </div>
        </div>
    </div>
    <div id="message_div">
        <span id="close_button"><img src="<?php echo base_url(); ?>backend_asset/images/close.png" onclick="close_message();"></span>
        <div id="message_container"></div>
    </div>