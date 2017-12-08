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
    .select2-container, .select2-drop, .select2-search, .select2-search input {
    width: 290px !important;
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
                <a href="<?php echo site_url('contest');?>"><?php echo lang('contest');?></a>
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
                        <a href="<?php echo site_url('contest/add_contest')?>"  class="<?php echo THEME_BUTTON;?>">
                            <?php echo lang('contest');?>
                            <i class="fa fa-plus"></i>
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
                        <div class="col-sm-12" >
                            <div class="col-md-4">
                                <select id="match" name="match" class="select2 select-2">
                                    <option value="">Select Match</option>
                                    <?php if(!empty($match_details)){
                                        foreach($match_details as $row){
                                        $select = "" ;   if(isset($matchId)){if($matchId == $row->match_id){$select="selected";}}?>
                                        <option value="<?php echo $row->match_id;?>" <?php echo $select;?>><?php echo $row->localteam." Vs ".$row->visitorteam."  -  (".date('d-m-Y',strtotime($row->match_date)).")";?></option>
                                        <?php }
                                    }?>
                                </select>
                            </div>
                            <input type="hidden" id="matchIdFilter" value="<?php if(isset($matchId)){if(!empty($matchId)){echo $matchId;}}?>"/>
                            <div class="col-md-4">
                                <select id="contest_type" name="contest_type" class="select-2">
                                    <option value="">Select Contest Type</option>
                                    <option value="mega">Mega Contest</option>
                                    <option value="cancel">Cancel Contest</option>
                                    <option value="complete">Complete Contest</option>
                                    <option value="current">Current Contest</option>
                                    <option value="running">Running Contest</option>
                                </select>
                            </div>
                            <input type="button" class="<?php echo THEME_BUTTON;?>" value="Search" onclick="searchContest()">
                        </div>
                        <div class="col-sm-12" >
                            <br>
                            <div class="table-responsive">
                                <table id="contest" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Contest Name</th>
<!--                                            <th>Match Type</th>-->
                                            <th>Total Winning Amount</th>
                                            <th>Contest Size</th>
                                            <th>No. Of Winners</th>
                                            <th>Entry Fee</th>
                                            <th>Created Date</th>
                                            <th style="width:25%">Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="form-modal-box"></div>
            </div>
        </div>
    </div>
    <div id="message_div">
        <span id="close_button"><img src="<?php echo base_url();?>backend_asset/images/close.png" onclick="close_message();"></span>
        <div id="message_container"></div>
    </div>