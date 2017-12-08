<link href="<?php echo base_url(); ?>backend_asset/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>backend_asset/js/select2.js"></script>
<script>
    var base_url = '<?php echo base_url() ?>';
    var seriesId = $('#series_id').val();
    var localteam_id = $('#localteam_id').val();
    var visitorteam_id = $('#visitorteam_id').val();
    /*matches list*/
    function getMatchBySeries(series_id){
        $("#matches").dataTable().fnDestroy();
        $('#matches').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": base_url + "matches/get_matches_list",
                "dataType": "json",
                "type": "POST",
                "data": {series_id: series_id}
            },
            "columns": [
                {"data": "id"},
                {"data": "localteam"},
                {"data": "match_num"},
                {"data": "match_type"},
                {"data": "match_date"},
                {"data": "status"},
                {"data": "action"},
            ],
            "order": [[4, "asc"]],
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0,5,6]
                }]

        });
    }
    getMatchBySeries("");
    /*cricketers list*/
    $('#cricketers').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + "matches/get_cricketers_list",
            "dataType": "json",
            "type": "POST",
            "data": {match_id: seriesId, localteam_id:localteam_id, visitorteam_id:visitorteam_id}
        },
        "columns": [
            {"data": "s_no"},
            {"data": "team"},
            {"data": "player_name"},
            {"data": "play_role"},
            {"data": "test"},
            {"data": "odi"},
            {"data": "t20"},
        ],
        "order": [[1, "asc"]],
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0]
            }]

    });
    
      $(".select-2").select2({
        allowClear: true
    });
</script>