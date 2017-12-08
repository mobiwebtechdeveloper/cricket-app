<link href="<?php echo base_url(); ?>backend_asset/css/validationEngine.jquery.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>backend_asset/js/jquery.validationEngine.js"></script>
<script src="<?php echo base_url(); ?>backend_asset/js/jquery.validationEngine-en.js"></script>
<link href="<?php echo base_url(); ?>backend_asset/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>backend_asset/js/select2.js"></script>

<script>
// $('#matches').on('change keyup click', function() {  // when the value changes
//     if($('#matches').val() == '' || $('#matches').val() == null)
//     {
//         $('#matches').addClass('validate[required]');
//         $('.select2-container-multi').addClass('validate[required]');
//     }else{
//         $('#matches').removeClass('validate[required]');
//         $('.select2-container-multi').removeClass('validate[required]');
//     }
// }); 
    getContestList();
    var base_url = '<?php echo base_url() ?>';

    /*contest list*/
    function getContestList(queryString = false){
        $("#contest").dataTable().fnDestroy();
        var query = '';
        if (queryString)
            query = queryString;
        else
            query = {};
        $('#contest').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": base_url + "contest/get_contest_list",
                "dataType": "json",
                "type": "POST",
                "data": query
            },
            "columns": [
                {"data": "s_no"},
                {"data": "contest_name"},
//                {"data": "match_type"},
                {"data": "total_winning_amount"},
                {"data": "contest_size"},
                {"data": "number_of_winners"},
                {"data": "team_entry_fee"},
                {"data": "create_date"},
                {"data": "status"},
                {"data": "action"},
            ],
            "order": [[6, "desc"]],
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 7, 8]
                }]

        });
    }

    function searchContest() {
        var match = $('#match').val();
        var contest_type = $('#contest_type').val();
        var queryString = {match: match, contest_type: contest_type};
        getContestList(queryString);
    }

    $('#addContest').validationEngine();
    $("#matches").select2({
        allowClear: true
    });
//for creating readonly field of no. of winners
    $('#customize_winnings').click(function () {
        $('.field_wrapper').html('');
        $("#no_of_winners").val('');
        $('#set_btn').attr('disabled', true);
        $("#no_of_winners").attr("placeholder", "min 2");
        $("#no_of_winners").attr("readonly", true);
        if (this.checked) {
            $('#set_btn').attr('disabled', false);
            $("#no_of_winners").attr("readonly", false);
        }
    });


//for finding the amount to be paid as an entry fees by every team
    function setTeamFees() {
        var no_of_winners = $('#no_of_winners').val();
        var contest_sizes = $('#contest_sizes').val();
        var total_winning_amount = $('#total_winning_amount').val();
        var admin_fee_percent = $('#admin_fee_percent').val();
        if (parseInt(no_of_winners) <= parseInt(contest_sizes)) {
            $('#set_btn').attr('disabled', false);
        } else {
            $('#set_btn').attr('disabled', true);
        }
        if (contest_sizes != '' && total_winning_amount != '') {
            var basic_amount = total_winning_amount / contest_sizes;
            var team_entry_fee = ((basic_amount * admin_fee_percent) / 100) + basic_amount;
            $('#entry_fee').val(team_entry_fee.toFixed(2));
        } else {
            $("#entry_fee").attr("placeholder", "Rs.0");
        }
    }

    $(document).ready(function () {
        var no_of_winners_ = $('#no_of_winners_').val();
        if (no_of_winners_ != 0 && typeof no_of_winners_ !== 'undefined') {//during edit
            var count = $('#count_').val();
            var total_winning_amt = $('#total_winning_amount_').val();
            var select_count = $('#select_count').val();
            var no_of_winners = $('#no_of_winners_').val();
            var percentage = $('#percentage_').val();
            var contest_sizes = $('#contest_size_').val();
        } else {//during add
            var count = 0;
            var total_winning_amt = 0;
            var select_count = 0;
            var no_of_winners = 0;
            var percentage = 0;
            var contest_sizes = 0;
            var max_value = 0;//for getting the last winner value selected
        }

        var wrapper = $('.field_wrapper');
        $('.set_btn').click(function () {
            total_winning_amt = $('#total_winning_amount').val();
            no_of_winners = $('#no_of_winners').val();
            contest_sizes = $('#contest_sizes').val();
            if (contest_sizes != '' && no_of_winners != '') {
                count = 1;
                select_count = 1;
                var fieldHTML = '<div class="col-md-12" id="div' + count + '"><div class="form-group"><div class="col-md-1"><label class="control-label">From</label></div><div class="col-md-2"><select class="form-control validate[required]" id="select_' + select_count + '" name="select[' + count + '][]"><option value="1">1</option></select></div><div class="col-md-1"><label class="control-label">To</label></div><div class="col-md-2">';
                select_count++;
                fieldHTML += '<select class="form-control validate[required] second_select" id="select_' + select_count + '" data-pid="' + count + '" name="select[' + count + '][]">';
                for (var i = 1; i <= no_of_winners; i++) {
                    fieldHTML += '<option value="' + i + '">' + i + '</option>';
                }
                fieldHTML += '</select></div><div class="col-md-1"><label class="control-label">Percent</label></div><div class="col-md-1"><input type="text" name="select[' + count + '][]" class="form-control input_select validate[required,custom[percentage]]" id="percent_' + count + '" data-pid="' + count + '"></div><div class="col-md-1"><label class="control-label">Amount</label></div><div class="col-md-2"><input type="text" readonly class="form-control" id="amount' + count + '" name="select[' + count + '][]"></div><a href="javascript:void(0);" class="remove_button" title="Remove field" id="' + count + '"><i class="fa fa-minus" aria-hidden="true"></i></a>&nbsp;<a href="javascript:void(0);" class="add_btn" title="Add field"><i class="fa fa-plus" aria-hidden="true"></i></a></div></div>';

                if (no_of_winners != '' && contest_sizes != '' && (parseInt(no_of_winners) <= parseInt(contest_sizes))) {
                    $('#set_btn').attr('disabled', true);
                    $(wrapper).append(fieldHTML);
                }
            }
        });

        $(wrapper).on('click', '.add_btn', function (e) {
            $('#max_value_exceed').html('');
            $('#addContest').submit();
            var last_field_percent = $('#percent_' + count).val();
            percentage = 0;
            for (var i = 1; i <= count; i++) {
                var last_percent = $('#percent_' + i).val();
                percentage = parseInt(percentage) + parseInt(last_percent);
            }
            if (contest_sizes != '' && no_of_winners != '' && percentage < 100) {
                max_value = $('#select_' + select_count).val();
            }
            if ((parseInt(max_value) == (parseInt(no_of_winners) - parseInt(1))) && percentage < 100) {
                count++;
                max_value++;
                select_count++;
                var fieldHTML_ = '<div class="col-md-12" id="div' + count + '"><div class="form-group"><div class="col-md-1"><label class="control-label">From</label></div><div class="col-md-2"><select class="form-control validate[required]" id="select_' + select_count + '" name="select[' + count + '][]"><option value="' + no_of_winners + '">' + no_of_winners + '</option></select></div><div class="col-md-1"><label class="control-label">To</label></div><div class="col-md-2">';
                select_count++;
                fieldHTML_ += '<select name="select[' + count + '][]" class="form-control validate[required] second_select" id="select_' + select_count + '"  data-pid="' + count + '"><option value="' + no_of_winners + '">' + no_of_winners + '</option>';
                fieldHTML_ += '</select></div><div class="col-md-1"><label class="control-label">Percent</label></div><div class="col-md-1"><input type="text" name="select[' + count + '][]" class="form-control validate[required,custom[percentage],max[' + last_field_percent + ']] input_select" data-pid="' + count + '" id="percent_' + count + '"></div><div class="col-md-1"><label class="control-label">Amount</label></div><div class="col-md-2"><input name="select[' + count + '][]" type="text" readonly class="form-control" id="amount' + count + '"></div><a href="javascript:void(0);" class="remove_button" title="Remove field" id="' + count + '"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div>';
                $(wrapper).append(fieldHTML_);
            } else if ((parseInt(max_value) < parseInt(no_of_winners)) && percentage < 100) {
                count++;
                max_value++;
                select_count++;
                var fieldHTML_ = '<div class="col-md-12" id="div' + count + '"><div class="form-group"><div class="col-md-1"><label class="control-label">From</label></div><div class="col-md-2"><select class="form-control validate[required]" name="select[' + count + '][]" id="select_' + select_count + '"><option value="' + max_value + '">' + max_value + '</option></select></div><div class="col-md-1"><label class="control-label">To</label></div><div class="col-md-2">';
                select_count++;
                fieldHTML_ += '<select name="select[' + count + '][]" class="form-control validate[required] second_select" id="select_' + select_count + '" data-pid="' + count + '">';
                for (var i = max_value; i <= no_of_winners; i++) {
                    fieldHTML_ += '<option valuCopyrighte="' + i + '">' + i + '</option>';
                }
                fieldHTML_ += '</select></div><div class="col-md-1"><label class="control-label">Percent</label></div><div class="col-md-1"><input name="select[' + count + '][]" type="text" class="form-control validate[required,custom[percentage],max[' + last_field_percent + ']] input_select" data-pid="' + count + '" id="percent_' + count + '"></div><div class="col-md-1"><label class="control-label">Amount</label></div><div class="col-md-2"><input name="select[' + count + '][]" type="text" readonly class="form-control" id="amount' + count + '"></div><a href="javascript:void(0);" class="remove_button" title="Remove field" id="' + count + '"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div>';
                $(wrapper).append(fieldHTML_);
            } else if (parseInt(max_value) == (parseInt(no_of_winners))) {
                $('#max_value_exceed').html('You can\'t add more winners');
            } else {
                $('#max_value_exceed').html('Percentage sum should be equal to 100 ! You can\'t add more');
            }
        });

        $(wrapper).on('click', '.remove_button', function (e) {
            $('#max_value_exceed').html('');
            var remove_id = $(this).attr("id");
            var overall_count = count;
            for (var i = remove_id; i <= overall_count; i++) {
                $('#div' + i).remove();
                select_count = parseInt(select_count) - parseInt(2);
                count--;
            }
            if (count == 0) {
                select_count = 0;
                $('#set_btn').attr('disabled', false);
            }
            e.preventDefault();
        });


        $(wrapper).on('change keyup', '.second_select,.input_select', function (e) {
            $('#max_value_exceed').html('');
            var overall_count = count;
            var remove_id = $(this).attr('data-pid');
            var percent_val = $('#percent_' + remove_id).val();
            var calculation = ((total_winning_amt * percent_val) / 100);
            
            var selectCount = overall_count*2;
            var FromRank = parseInt(selectCount) - Number(1);
            var toRank = selectCount;
            var fromRankVal = $("#select_"+FromRank).val();
            var toRankVal = $("#select_"+toRank).val();
            var totalRankVal = parseInt(toRankVal) - parseInt(fromRankVal);
            if(totalRankVal > 0){
               if(percent_val != ""){ 
                   totalRankVal = parseInt(totalRankVal) + Number(1);
                 var eachRankAmount = calculation.toFixed(2) / totalRankVal;
                 $('#amount' + remove_id).val(eachRankAmount.toFixed(2));
               }  
            }else{
                $('#amount' + remove_id).val(calculation.toFixed(2));
            }
           
           $('#addContest').submit();
            remove_id = parseInt(remove_id) + parseInt(1);
            for (var j = remove_id; j <= overall_count; j++) {
                $('#div' + j).remove();
                count--;
                select_count = parseInt(select_count) - parseInt(2);
            }
            
        });

        $("#submit").click(function (e) {
            var percent = 0;
            var last_percent_field = $('#select_' + (count * 2)).val();
            for (var i = 1; i <= count; i++) {
                var last_percent = $('#percent_' + i).val();
                percent = parseInt(percent) + parseInt(last_percent);
            }
            if (last_percent_field < no_of_winners) {
                $('#max_value_exceed').html('All winners should get prize');
                e.preventDefault();
            } else if (percent > 100) {
                $('#max_value_exceed').html('Percentage value exceeded');
                e.preventDefault();
            } else if (percent != '' && percent < 100) {
                $('#max_value_exceed').html('Percent sum should be equal to 100%');
                e.preventDefault();
            } else {
                $('#max_value_exceed').html('');
            }

            //code for matches select
            if ($('#matches').val() == '' || $('#matches').val() == null)
            {
                $('#matches').addClass('validate[required]');
                $('.select2-container-multi').addClass('validate[required]');
            } else {
                $('#matches').removeClass('validate[required]');
                $('.select2-container-multi').removeClass('validate[required]');
            }
        });

        $('#match_type').change(function () {
            var match_type = $(this).val();
            if (match_type == 1)
                $('.contest').removeClass('hide');
            else
                $('.contest').addClass('hide');
        });
    });

    function resetWinners() {
        $('#max_value_exceed').html('');
        $('.field_wrapper').html('');
        $('#set_btn').attr('disabled', false);
    }

    function changeContestStatus(contestID, option) {
        var option = option.value;
        var match = $('#match').val();
        var contest_type = $('#contest_type').val();
        $.ajax({
            url: base_url + "contest/change_contest_status",
            type: "post",
            dataType: 'json',
            data: {contest_id: contestID, option: option},
            success: function (result) {
                var queryString = {match: match, contest_type: contest_type};
                getContestList(queryString);
            }
        });
    }
          $(".select-2").select2({
        allowClear: true
    });
</script>

