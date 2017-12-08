<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : "" ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo lang('home'); ?></a>
            </li>
            <li>
                <a href="<?php echo site_url('matches'); ?>">Matches (Players)</a>
            </li>
        </ol>
    </div>

</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                            <div>
                                <h3 style="text-align: center;" class="text-success">
                                    <?php echo $match_name;?>
                                </h3>
                            </div>
                            <br/>
                        <div class="col-lg-12" style="overflow-x: auto">
                            <input type="hidden" id="series_id" name="series_id" value="<?php echo $series_id?>">
                            <input type="hidden" id="localteam_id" name="localteam_id" value="<?php echo $localteam_id?>">
                            <input type="hidden" id="visitorteam_id" name="visitorteam_id" value="<?php echo $visitorteam_id?>">
                            <div class="row">
                                <div class="table-responsive" id="order_div">
                                    <table id="cricketers" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Team</th>
                                                <th>Player Name</th>
                                                <th>Player Role</th>
                                                <th>Test</th>
                                                <th>ODI</th>
                                                <th>T20</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>