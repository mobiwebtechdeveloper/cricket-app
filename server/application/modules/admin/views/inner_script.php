<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>dataTables.buttons.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.flash.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.flash.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>jszip.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>pdfmake.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>vfs_fonts.js"></script>  
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.html5.min.js"></script>  
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.print.min.js"></script>  
<link href="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.dataTables.min.css" rel="stylesheet">
<script>

    function generateReportDashboard(organization_id) {
        $.ajax({
            url: '<?php echo base_url() . 'admin/generateReportDashboard' ?>',
            type: 'POST',
            data: {'organization_id': organization_id},
            success: function (data) {
                $("#dashboardReport").html(data);
                $('.dataTables-dashboard-180').dataTable({
                    "scrollX": true,
                    "ordering": false,
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ],
                    "pageLength": 30
                });
                $("#dashboardReportTableAvg").html("");
                $("#dashboardReportStatementAverage").html("");
                $('#radarChart').remove();
                $('#graph-container').append('<canvas id="radarChart"></canvas>');
                $('#lineChart').remove();
                $('#graph-container-line').append('<canvas id="lineChart"></canvas>');
                $("#cateName").html("");
            }
        });
    }
    generateReportDashboard($("#organization_id").val());

    function chartRadarCaregory(userId, roleId) {

        $.ajax({
            url: '<?php echo base_url() . 'admin/categoryAssessmentReport' ?>',
            type: 'POST',
            data: {'userId': userId, 'roleId': roleId},
            dataType: 'json',
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (data) {
                if (data.status == 1) {
                    $(".chartdiv").show();
                    window.scrollTo(300, 400);
                    $(".loaders").fadeOut("slow");
                    var radarData = {
                        labels: data.label,
                        datasets: [
                            {
                                label: "Self",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(255,140,0)",
                                pointColor: "rgb(255,140,0)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: data.self
                            },
                            {
                                label: "Leader",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(65,105,225)",
                                pointColor: "rgb(65,105,225)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: data.leader
                            }
                        ]
                    };

                    var radarOptions = {
                        scaleShowLine: true,
                        angleShowLineOut: true,
                        scaleShowLabels: true,
                        scaleBeginAtZero: true,
                        angleLineColor: "rgba(0,0,0,.1)",
                        angleLineWidth: 1,
                        pointLabelFontFamily: "'Arial'",
                        pointLabelFontStyle: "normal",
                        pointLabelFontSize: 10,
                        pointLabelFontColor: "#666",
                        pointDot: true,
                        pointDotRadius: 3,
                        pointDotStrokeWidth: 1,
                        pointHitDetectionRadius: 20,
                        datasetStroke: true,
                        datasetStrokeWidth: 2,
                        datasetFill: true,
                        responsive: true,
                    }

                    var ctx = document.getElementById("radarChart").getContext("2d");
                    var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);
                } else {
                    toastr.error('Record Not Found');
                    $(".loaders").fadeOut("slow");
                }

            }
        });
        setTimeout(function () {
            chartTable(userId);
        }, 1000);
    }

    function chartTable(user_id) {
        $.ajax({
            url: '<?php echo base_url() . 'admin/categoryAssessmentReport' ?>',
            type: 'POST',
            data: {'userId': user_id},
            success: function (data) {
                $("#dashboardReportTableAvg").html(data);
                $('#lineChart').remove();
                $('#graph-container-line').append('<canvas id="lineChart"></canvas>');
                $("#cateName").html("");
                $("#dashboardReportStatementAverage").html("");
            }
        });
    }

    function caregoryStatementChart(catId, userId) {

        $.ajax({
            url: '<?php echo base_url() . 'admin/caregoryStatementChart' ?>',
            type: 'POST',
            data: {'userId': userId, 'catId': catId,'statement':0},
            dataType: 'json',
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (data) {
                if (data.status == 1) {
                    $(".loaders").fadeOut("slow");
                    $("#cateName").html(data.category_name);
                    $('#lineChart').remove();
                    $('#graph-container-line').append('<canvas id="lineChart"></canvas>');
                    var lineData = {
                        labels: data.labels,
                        datasets: [
                            {
                                label: "Self",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(255,140,0)",
                                pointColor: "rgb(255,140,0)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: data.self
                            },
                            {
                                label: "Leader",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(65,105,225)",
                                pointColor: "rgb(65,105,225)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: data.leader
                            }
                        ]
                    };

                    var lineOptions = {
                        scaleShowLine: true,
                        angleShowLineOut: true,
                        scaleShowLabels: true,
                        scaleBeginAtZero: true,
                        angleLineColor: "rgba(0,0,0,.1)",
                        angleLineWidth: 1,
                        pointLabelFontFamily: "'Arial'",
                        pointLabelFontStyle: "normal",
                        pointLabelFontSize: 10,
                        pointLabelFontColor: "#666",
                        pointDot: true,
                        pointDotRadius: 3,
                        pointDotStrokeWidth: 1,
                        pointHitDetectionRadius: 20,
                        datasetStroke: true,
                        datasetStrokeWidth: 2,
                        datasetFill: true,
                        responsive: true,
                    };


                    var ctx = document.getElementById("lineChart").getContext("2d");
                    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
                }
            }
        });
        setTimeout(function () {
            chartTableStatement(catId, userId);
        }, 1000);
    }
    
    function chartTableStatement(catId, userId) {
        $.ajax({
            url: '<?php echo base_url() . 'admin/caregoryStatementChart' ?>',
            type: 'POST',
            data: {'userId': userId, 'catId': catId,'statement':1},
            success: function (data) {
                $("#dashboardReportStatementAverage").html(data);
            }
        });
    }

</script>