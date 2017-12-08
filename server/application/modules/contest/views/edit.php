

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
    .select2-wrapper {
        display: inline-block;
        position: relative;
    }
</style>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : ""?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin');?>"><?php echo lang('home');?></a>
            </li>
            <li>
                <a href="<?php echo site_url('contest');?>">Contest</a>
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
                        <form class="form-horizontal" role="form" id="addContest" method="post"  enctype="multipart/form-data" action="<?php echo base_url()?>contest/update_contest">
                            <div> 
                                <div class="loaders">
                                    <img src="<?php echo base_url().'assets/images/Preloader_3.gif';?>" class="loaders-img" class="img-responsive">
                                </div>
                                <div class="alert alert-danger" id="error-box" style="display: none"></div>
                                <div class="form-body">
                                    <div class="row">
                                    <input type="hidden" id="contest_id" name="contest_id" value="<?php echo $encoded_id;?>">
                                        <input type="hidden" name="admin_fee_percent" id="admin_fee_percent" value="<?php echo FEE_PERCENT;?>">

                                        <div class="col-md-12" >
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"><?php echo lang('select_matches');?></label>
                                                <div class="col-md-9">
                                                    <select id="matches" name="matches[]" class="validate[required]" multiple>
                                                        <?php
                                                        $matchIDs = isset($contestDetails['result'][0]->matches_id)?explode(',',$contestDetails['result'][0]->matches_id):'';
                                                        ?>
                                                        <?php if(!empty($match_details)){
                                                            foreach($match_details as $row){
                                                                $selected='';
                                                                if(in_array($row->match_id,$matchIDs))
                                                                    $selected='selected';?>
                                                                <option value="<?php echo $row->match_id;?>" <?php echo $selected;?>><?php echo $row->localteam." Vs ".$row->visitorteam."  -  (".date('d-m-Y',strtotime($row->match_date)).")";?></option>
                                                                <?php }
                                                            }?>
                                                        </select>
                                                        <span class="error"><?php echo form_error('matches[]'); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><?php echo lang('contest_name');?></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="contest_name" id="contest_name" placeholder="Your contest name" value="<?php if(set_value('contest_name')){ echo set_value('contest_name');}else{ echo isset($contestDetails['result'][0]->contest_name)?$contestDetails['result'][0]->contest_name:'';}?>"/>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><?php echo lang('total_winning_amount');?></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control validate[required,custom[positive_number]]" name="total_winning_amount" id="total_winning_amount" placeholder="min Rs.0" onkeyup="setTeamFees();resetWinners();" value="<?php if(set_value('total_winning_amount')){ echo set_value('total_winning_amount');}else{ echo isset($contestDetails['result'][0]->total_winning_amount)?$contestDetails['result'][0]->total_winning_amount:'';}?>"/>
                                                        <span class="error"><?php echo form_error('total_winning_amount'); ?></span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><?php echo lang('contest_size');?></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control validate[required,custom[positive_number]]" name="contest_sizes" id="contest_sizes" placeholder="min 2" value="<?php if(set_value('contest_sizes')){ echo set_value('contest_sizes');}else if(isset($contestDetails['result'][0]->contest_size)){ echo $contestDetails['result'][0]->contest_size;}else{echo 2;}?>" onkeyup="setTeamFees();resetWinners();">
                                                        <span class="error"><?php echo form_error('contest_sizes'); ?></span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><input type="checkbox" id="multi_entry" name="multi_entry" <?php  if(isset($contestDetails['result'][0]->is_multientry)&& ($contestDetails['result'][0]->is_multientry == 1)){ echo "checked";}?>></label>
                                                    <div class="col-md-9">
                                                        Join this contest with multiple teams
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><?php echo lang('match_type');?></label>
                                                    <div class="col-md-9">
                                                        <select id="match_type" name="match_type" class="form-control validate[required]">
                                                            <option value="">Select match type</option>
                                                            <option value="1" <?php if(isset($contestDetails['result'][0]->match_type)&& ($contestDetails['result'][0]->match_type == 1)){ echo "selected";}?>>Live</option>
                                                            <option value="0" <?php if(isset($contestDetails['result'][0]->match_type)&& ($contestDetails['result'][0]->match_type == 0)){ echo "selected";}?>>Practise</option>
                                                        </select>
                                                        <span class="error"><?php echo form_error('match_type'); ?></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <?php 
                                            $class="hide";
                                            if(isset($contestDetails['result'][0]->match_type)&& ($contestDetails['result'][0]->match_type == 1)){
                                                $class="";
                                            }
                                            ?>
                                            <div class="col-md-12 <?php echo $class;?> contest" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><input type="checkbox" id="mega_contest" name="mega_contest" <?php  if(isset($contestDetails['result'][0]->mega_contest)&& ($contestDetails['result'][0]->mega_contest == 1)){ echo "checked";}?>></label>
                                                    <div class="col-md-9">
                                                        Is Mega Contest
                                                    </div>
                                                </div>
                                            </div>
                                        
                                              <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><input type="checkbox" id="confirmed_contest" name="confirmed_contest" <?php  if(isset($contestDetails['result'][0]->confirm_contest)&& ($contestDetails['result'][0]->confirm_contest == 1)){ echo "checked";}?>></label>
                                                    <div class="col-md-9">
                                                        Confirmed Contest
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><input type="checkbox" id="customize_winnings" name="customize_winnings"  <?php if(isset($contestDetails['result'][0]->customize_winning)&& ($contestDetails['result'][0]->customize_winning == 1)){ echo "checked";}?>></label>
                                                    <div class="col-md-9">
                                                        Customize Winnings
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><?php echo lang('entry_fee');?></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control validate[custom[onlyDecimalandzero]]" name="entry_fee" id="entry_fee" placeholder="Rs.0" value="<?php if(set_value('entry_fee')){ echo set_value('entry_fee');}else{ echo isset($contestDetails['result'][0]->team_entry_fee)?$contestDetails['result'][0]->team_entry_fee:'';}?>"/>
                                                    </div>
                                                    <span class="help-block m-b-none col-md-offset-3">

                                                    </div>
                                                </div>

                                                <?php 
                                                $readonly="readonly";
                                                if(isset($contestDetails['result'][0]->number_of_winners)&& ($contestDetails['result'][0]->number_of_winners>0) && isset($contestDetails['result'][0]->customize_winning)&& ($contestDetails['result'][0]->customize_winning == 1)){
                                                    $readonly="";
                                                }
                                                ?>

                                                <div class="col-md-12" >
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><?php echo lang('no_of_winners');?></label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control form-control validate[custom[winners]]" name="no_of_winners" id="no_of_winners" placeholder="min 2" <?php echo $readonly;?> onkeyup="resetWinners()" value="<?php if(set_value('no_of_winners')){ echo set_value('no_of_winners');}else if(isset($contestDetails['result'][0]->customize_winning)&& ($contestDetails['result'][0]->customize_winning == 1)){ echo isset($contestDetails['result'][0]->number_of_winners)?$contestDetails['result'][0]->number_of_winners:'';}?>"/>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="button" id="set_btn" class="<?php echo THEME_BUTTON;?> set_btn" value="<?php echo lang('set');?>" disabled >
                                                        </div>
                                                    </div>

                                                </div>
                                                <h4 style="text-align:center;color:red;"><span id="max_value_exceed"></span></h4>
                                                <div class="field_wrapper col-md-offet-2">
                                                    <?php 
                                                    $count = isset($contestWinners['total_count'])?$contestWinners['total_count']:0;
                                                    $total_winning_amount = isset($contestDetails['result'][0]->total_winning_amount)?$contestDetails['result'][0]->total_winning_amount:0;
                                                    $select_count = $count*2;
                                                    $no_of_winners = isset($contestDetails['result'][0]->number_of_winners)?$contestDetails['result'][0]->number_of_winners:0;
                                                    $percentage = 0;
                                                    if(isset($contestWinners['result'])){
                                                        foreach($contestWinners['result'] as $row){
                                                            $percentage+=$row->percentage;
                                                        }
                                                    }
                                                    $contest_size = isset($contestDetails['result'][0]->contest_size)?$contestDetails['result'][0]->contest_size:0;
                                                    ?>
                                                    <input type="hidden" id="count_" value="<?php echo $count;?>">
                                                    <input type="hidden" id="total_winning_amount_" value="<?php echo $total_winning_amount;?>">
                                                    <input type="hidden" id="select_count" value="<?php echo $select_count;?>">
                                                    <input type="hidden" id="no_of_winners_" value="<?php echo $no_of_winners;?>">
                                                    <input type="hidden" id="percentage_" value="<?php echo $percentage;?>">
                                                    <input type="hidden" id="contest_size_" value="<?php echo $contest_size;?>">
                                                    <?php if(!empty($contestWinners['result'])){
                                                        $index = 0;
                                                        $select_count = 0;
                                                        foreach($contestWinners['result'] as $row){
                                                            $index++;
                                                            $select_count++;?>
                                                            <div class="col-md-12" id="div<?php echo $index;?>">
                                                                <div class="form-group">
                                                                    <div class="col-md-1">
                                                                        <label class="control-label">From</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <select class="form-control validate[required]" id="select_<?php echo $select_count;?>" name="select[<?php echo $index;?>][]">
                                                                            <option value="<?php echo $row->from_winner;?>"><?php echo $row->from_winner;?></option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label class="control-label">To</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <?php $select_count++; ?>
                                                                        <select class="form-control validate[required] second_select" id="select_<?php echo $select_count; ?>" data-pid="<?php echo $index; ?>" name="select[<?php echo $index; ?>][]">
                                                                            <?php for($i=$row->from_winner;$i<=$no_of_winners;$i++){
                                                                                $selected = '';
                                                                                if($i == $row->to_winner){
                                                                                    $selected = 'selected';
                                                                                }
                                                                                ?>
                                                                                <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?>
                                                                                </option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <label class="control-label">Percent</label>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <input type="text" name="select[<?php echo $index;?>][]" class="form-control input_select validate[required,custom[percentage]]" id="percent_<?php echo $index;?>" data-pid="<?php echo $index;?>" value="<?php echo $row->percentage;?>">
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <label class="control-label">Amount</label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <input type="text" readonly class="form-control" id="amount<?php echo $index;?>" name="select[<?php echo $index;?>][]" value="<?php echo $row->amount;?>">
                                                                        </div>
                                                                        <a href="javascript:void(0);" class="remove_button" title="Remove field" id="<?php echo $index;?>">
                                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                                        </a>&nbsp;
                                                                        <?php if($index == 1){?>
                                                                        <a href="javascript:void(0);" class="add_btn" title="Add field">
                                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                                        </a>
                                                                        <?php }?>
                                                                    </div>
                                                                </div>
                                                                <?php }
                                                            }?>

                                                        </div>
                                                        <div class="space-22"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="col-md-12" >
                                                    <button type="submit" id="submit" class="<?php echo THEME_BUTTON;?>" ><?php echo lang('submit_btn');?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="message_div">
                        <span id="close_button"><img src="<?php echo base_url();?>backend_asset/images/close.png" onclick="close_message();"></span>
                        <div id="message_container"></div>
                    </div>
