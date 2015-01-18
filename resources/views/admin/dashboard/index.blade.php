@extends($layout)

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        <p>Below are charting integration examples using <a class="underlined" href="http://www.highcharts.com" target="_blank">HighCharts</a>.</p>
    </div>
    <!-- /.page-header -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-6 -->
        <div class="col-lg-6">
            <!-- /.container -->
            <div id="roleStatsContainer" style="width:100%; height:400px;"></div>
        </div>
        <!-- /.col-lg-6 -->
        <!-- .col-lg-6 -->
        <div class="col-lg-6">
            <!-- /.container -->
            <div id="postStatsContainer" style="width:100%; height:400px;"></div>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <hr/>
            <!-- /.container -->
            <div id="commentToVotesStats" style="width:100%; height:400px;"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
@stop

@section('footer_embedded_js')
    @parent
    <script>
        $(function () {
            $('#roleStatsContainer').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 1,//null,
                    plotShadow: false
                },
                title: {
                    text: 'Users By Role'
                },
                tooltip: {
                    pointFormat: "Value: {point.y:.2f}"
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Users By Role',
                    data: {!! $role_stats !!}
                }]
            });
        });

        $(function () {
            $('#postStatsContainer').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Today\'s Post By Type'
                },
                xAxis: {
                    categories: [
                        '{{ \Carbon\Carbon::today()->format("m/d/Y") }}'
                    ]
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Posts'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: {!! $posts_count !!} //[{"name":"ASK HNC","data":[123]},{"name":"Show HNC","data":[1234]}]
            });
        });

        $(function () {
            $('#commentToVotesStats').highcharts({
                chart: {
                    type: 'areaspline'
                },
                title: {
                    text: 'Average Comments and Votes By Day (This Week)'
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    verticalAlign: 'top',
                    x: 150,
                    y: 100,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
                xAxis: {
                    categories: {!! $day_names_for_last_seven_days !!},
                    plotBands: [{ // visualize the weekend
                        from: 4.5,
                        to: 6.5,
                        color: 'rgba(68, 170, 213, .2)'
                    }]
                },
                yAxis: {
                    title: {
                        text: 'Count'
                    }
                },
                tooltip: {
                    shared: true,
                    valueSuffix: ' units'
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    areaspline: {
                        fillOpacity: 0.5
                    }
                },
                series: [{
                    name: 'comments',
                    data: {!! $comment_count_for_last_seven_days !!}
                }, {
                    name: 'votes',
                    data: {!! $vote_count_for_last_seven_days !!}
                }]
            });
        });
    </script>
@stop