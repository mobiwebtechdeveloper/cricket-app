$(document).ready(function () {
    
  toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        "positionClass": "toast-top-right",
        timeOut: 2000,
        "fadeIn": 300,
    };
    
    $(document).on('submit', "#addFormAjax", function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData, //only input
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (response, textStatus, jqXHR) {
                try {
                    var data = $.parseJSON(response);
                    if (data.status == 1)
                    {
//                        bootbox.alert({
//                            message: data.message,
//                            callback: function (
//
//
//                                    ) { /* your callback code */
//                            }
//                        });
                        //$("#commonModal").modal('show');
                        $("#commonModal").modal('hide');
                        toastr.success(data.message);
                        if(data.url != ""){
                        window.setTimeout(function () {
                            window.location.href = data.url;
                        }, 2000);
                       }
                        $(".loaders").fadeOut("slow");

                    } else {
                        toastr.error(data.message);
                        $('#error-box').show();
                        $("#error-box").html(data.message);
                        $(".loaders").fadeOut("slow");
                        setTimeout(function () {
                            $('#error-box').hide(800);
                        }, 1000);
                    }
                } catch (e) {
                    $('#error-box').show();
                    $("#error-box").html(data.message);
                    $(".loaders").fadeOut("slow");
                    setTimeout(function () {
                        $('#error-box').hide(800);
                    }, 1000);
                }
            }
        });

    });
    
    $(document).on('submit', "#editFormAjax", function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: formData, //only input
                processData: false,
                contentType: false,
                 beforeSend: function () {
                       $(".loaders").fadeIn( "slow");
                 },
                success: function (response, textStatus, jqXHR) {
                    try {
                        var data = $.parseJSON(response);
                        if (data.status == 1)
                        {
//                               bootbox.alert({
//                                message: data.message,
//                                callback: function (
//
//
//                                        ) { /* your callback code */
//                                }
//                            });
                            //$("#commonModal").modal('hide');
                            toastr.success(data.message);
                            
                            window.setTimeout(function () {
                                window.location.href = data.url;
                            }, 2000);
                            $(".loaders").fadeOut( "slow");
                           
                        }else {
                            toastr.error(data.message);
                            $('#error-box').show();
                            $("#error-box").html(data.message);
                            $(".loaders").fadeOut( "slow");
                            setTimeout(function () {
                            $('#error-box').hide(800);
                        }, 1000);
                        }
                    } catch (e) {
                        $('#error-box').show();
                        $("#error-box").html(data.message);
                        $(".loaders").fadeOut( "slow");
                        setTimeout(function () {
                            $('#error-box').hide(800);
                        }, 1000);
                    }
                }
            });

        });
    
     $(document).on('submit', "#editFormAjaxUser", function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: formData, //only input
                processData: false,
                contentType: false,
                 beforeSend: function () {
                       $(".loaders").fadeIn( "slow");
                 },
                success: function (response, textStatus, jqXHR) {
                    try {
                        var data = $.parseJSON(response);
                        if (data.status == 1)
                        {
                            toastr.success(data.message);
                             $("#commonModal").modal('hide');
                             $('.modal-backdrop').remove();
                                 $.ajax({
                                    url: data.url,
                                    type: 'POST',
                                    data: {'id': data.id},
                                    beforeSend: function () {
                                        $(".loaders").fadeIn("slow");
                                    },
                                    success: function (data, textStatus, jqXHR) {

                                        $('#form-modal-box').html(data);
                                        $("#commonModal").modal('show');
                                        addFormBoot();
                                        $(".loaders").fadeOut("slow");
                                    }
                                });
//                            window.setTimeout(function () {
//                               // window.location.href = data.url;
//                            }, 2000);
                            $(".loaders").fadeOut( "slow");
                           
                        }else {
                            toastr.error(data.message);
                            $('#error-box').show();
                            $("#error-box").html(data.message);
                            $(".loaders").fadeOut( "slow");
                            setTimeout(function () {
                            $('#error-box').hide(800);
                        }, 1000);
                        }
                    } catch (e) {
                        $('#error-box').show();
                        $("#error-box").html(data.message);
                        $(".loaders").fadeOut( "slow");
                        setTimeout(function () {
                            $('#error-box').hide(800);
                        }, 1000);
                    }
                }
            });

        });
    
    
    $('.summernote').summernote({
        height: 200, // set editor height

        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor

        focus: true                 // set focus to editable area after initializing summernote
    });

//    var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
//    var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 6129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];
//
//    var data1 = [
//        {label: "Data 1", data: d1, color: '#17a084'},
//        {label: "Data 2", data: d2, color: '#127e68'}
//    ];
//    $.plot($("#flot-chart1"), data1, {
//        xaxis: {
//            tickDecimals: 0
//        },
//        series: {
//            lines: {
//                show: true,
//                fill: true,
//                fillColor: {
//                    colors: [{
//                            opacity: 1
//                        }, {
//                            opacity: 1
//                        }]
//                },
//            },
//            points: {
//                width: 0.1,
//                show: false
//            },
//        },
//        grid: {
//            show: false,
//            borderWidth: 0
//        },
//        legend: {
//            show: false,
//        }
//    });

//    var lineData = {
//        labels: ["January", "February", "March", "April", "May", "June", "July"],
//        datasets: [
//            {
//                label: "Example dataset",
//                fillColor: "rgba(220,220,220,0.5)",
//                strokeColor: "rgba(220,220,220,1)",
//                pointColor: "rgba(220,220,220,1)",
//                pointStrokeColor: "#fff",
//                pointHighlightFill: "#fff",
//                pointHighlightStroke: "rgba(220,220,220,1)",
//                data: [65, 59, 40, 51, 36, 25, 40]
//            },
//            {
//                label: "Example dataset",
//                fillColor: "rgba(26,179,148,0.5)",
//                strokeColor: "rgba(26,179,148,0.7)",
//                pointColor: "rgba(26,179,148,1)",
//                pointStrokeColor: "#fff",
//                pointHighlightFill: "#fff",
//                pointHighlightStroke: "rgba(26,179,148,1)",
//                data: [48, 48, 60, 39, 56, 37, 30]
//            }
//        ]
//    };
//
//    var lineOptions = {
//        scaleShowGridLines: true,
//        scaleGridLineColor: "rgba(0,0,0,.05)",
//        scaleGridLineWidth: 1,
//        bezierCurve: true,
//        bezierCurveTension: 0.4,
//        pointDot: true,
//        pointDotRadius: 4,
//        pointDotStrokeWidth: 1,
//        pointHitDetectionRadius: 20,
//        datasetStroke: true,
//        datasetStrokeWidth: 2,
//        datasetFill: true,
//        responsive: true,
//    };
//
//
//    var ctx = document.getElementById("lineChart").getContext("2d");
//    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

});

//data table pagination searching and processing 
var initTable1 = function () {
    var table = $('#common_datatable');
    var oTable = table.dataTable({
        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "Showing Entries _START_ to _END_ of _TOTAL_ ",
            "infoEmpty": "No entries found",
            "infoFiltered": "(filtered1 from _MAX_ total entries)",
            "lengthMenu": "Show Entries _MENU_ ",
            "search": "Search:",
            "zeroRecords": "No matching records found"
        },
        "order": [
            [0, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 20, -1],
            [5, 10, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 10,
        dom: "<'row hide' <'col-md-4'l> <'col-md-4'T><'col-md-4'f>><'clear'><'row pull-right'<'col-md-4'f>>rtip",
        responsive: true,
        "bProcessing": true,
        "iDisplayLength": 50,
    });

    var tableWrapper = $('#common_datatable_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
}
initTable1();

