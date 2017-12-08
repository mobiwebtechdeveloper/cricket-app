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
                    <h3 class="text-success"><a class="text-danger" onclick="window.history.back();"><i class="fa fa-arrow-circle-o-left"></i>BACK</a> User Joined Contest => <?php echo ucwords($users->first_name).' ('.$users->email;?>)</h3> 
                    <table class="table table-bordered table-responsive" id="common_datatable_users_contest_joined">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contest Name</th>
                                <th>Total Winning Amount</th>
                                <th>Contest Size</th>
                                <th>Entry Fee</th>
                                <th>No. Of Winners</th>
                                <th>Multientry</th>
                                <th>Join Date</th>
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
                            <td><?php echo $rows->contest_name;?></td>
                            <td><?php echo $rows->total_winning_amount;?></td>
                            <td><?php echo $rows->contest_size;?></td>
                            <td><?php echo $rows->team_entry_fee;?></td>
                            <td><?php echo $rows->number_of_winners;?></td>
                            <td><?php echo ($rows->is_multientry == 1) ? "Yes" : "No";?></td>
                             <td><?php echo date('d-m-Y',strtotime($rows->joining_date));?></td>
                            <td><?php echo date('d-m-Y',strtotime($rows->create_date));?></td>
                            <td class="actions">
<!--                            <a href="<?php //echo base_url().'users/transactions/'.encoding($rows->id);?>" class="btn btn-warning btn-sm"><img width="18" src="<?php echo base_url().CRICKET_ICON;?>" /> Transactions</a>-->
                            </td>
                            </tr>
                            <?php endforeach; endif;?>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
                <div id="form-modal-box"></div>
        </div>
    </div>
</div>