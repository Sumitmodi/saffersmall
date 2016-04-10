<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : log.php
 * 
 *   Project : saffersmall
 */

/*
 *   <Saffersmall :: Online Ads and Marketing Directory.>
 *   Copyright (C) <2014>  <Sandeep Giri>

 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.

 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.

 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.

 *   This program comes with ABSOLUTELY NO WARRANTY.
 *   This is free software, and you are welcome to redistribute it only if you 
 *   get permissions from the author or the distributor of this code.
 * 
 *   However do not expect any help or support from the author.
 */

//echo '<pre>' ; print_r($log);
$browser = array();
$firefox = 0;
$crome = 0;
$internet_explorer = 0;
$win7 = 0;
$win8 = 0;

if (isset($log)) {
    for ($k = 0; $k < count($log); $k++) {
        if ($k + 1 < count($log)) {
            if ($log[$k]['browser'] != $log[$k + 1]['browser'])
                $browser[] = $log[$k]['browser'];
            $browser[] = $log[$k + 1]['browser'];
        }

        if ($log[$k]['browser'] == 'firefox')
            $firefox = $firefox + 1;

        if ($log[$k]['browser'] == 'chrome')
            $crome = $crome + 1;

        if ($log[$k]['os'] == 'Windows 7')
            $win7 = $win7 + 1;

        if ($log[$k]['os'] == 'Windows 8')
            $win8 = $win8 + 1;

//if($log[$k]['browser'])
    }
}
//echo $firefox; echo $crome;
//echo '<pre>'; print_r($browser);
?>

<script src="<?php echo base_url() ?>assets/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/amcharts/amcharts/serial.js" type="text/javascript"></script>

<script type="text/javascript">

    var chart;
    var j;
    var chartData = [
        {"browser": "firefox",
            "visits": <?php echo $firefox ?>,
            "color": "#FF0F00"
        },
        {
            "browser": "crome",
            "visits": <?php echo $crome ?>,
            "color": "#FF6600"
        },
        {
            "browser": "internet explorer",
            "visits": <?php echo $internet_explorer ?>,
            "color": "#FCD202"
        },
    ];


    AmCharts.ready(function() {
        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = chartData;
        chart.categoryField = "browser";
        // the following two lines makes chart 3D
        chart.depth3D = 20;
        chart.angle = 30;

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.labelRotation = 0;
        categoryAxis.dashLength = 5;
        categoryAxis.gridPosition = "start";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.title = "Visitors";
        valueAxis.dashLength = 5;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.valueField = "visits";
        graph.colorField = "color";
        graph.balloonText = "<span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>";
        graph.type = "column";
        graph.lineAlpha = 0;
        graph.fillAlphas = 1;
        chart.addGraph(graph);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chartCursor.categoryBalloonEnabled = false;
        chart.addChartCursor(chartCursor);

        chart.creditsPosition = "top-right";


        // WRITE
        chart.write("chartdiv");
    });

    var chartData1 = [
        {
            "Operating System": 'Windows 7',
            "Visits": <?php echo $win7 ?>,
            "color": "#FCD202"
        },
        {
            "Operating System": 'Windows 8',
            "Visits": <?php echo $win8 ?>,
            "color": "#FF9E01"
        },
    ];


    AmCharts.ready(function() {
        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = chartData1;
        chart.categoryField = "Operating System";
        // this single line makes the chart a bar chart,
        // try to set it to false - your bars will turn to columns
        chart.rotate = true;
        // the following two lines makes chart 3D
        chart.depth3D = 20;
        chart.angle = 30;

        // AXES
        // Category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.gridPosition = "start";
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.fillAlpha = 1;
        categoryAxis.gridAlpha = 0;
        categoryAxis.fillColor = "#FAFAFA";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisColor = "#DADADA";
        // valueAxis.title = "Income in millions, USD";
        valueAxis.gridAlpha = 0.1;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.title = "Visitors";
        graph.valueField = "Visits";
        graph.type = "column";
        graph.colorField = "color";
        graph.balloonText = "[[category]]:[[value]]";
        graph.lineAlpha = 0;
        graph.fillColors = "#bf1c25";
        graph.fillAlphas = 1;
        chart.addGraph(graph);

        chart.creditsPosition = "top-right";

        // WRITE
        chart.write("chartdiv1");
    });

</script>

<div class="right-top"></div>
<div class="right-header dashboard">
    <h2>
        <i class="fa fa-folder-open"></i>Your Recent Report Log
    </h2>
    <div class="down-arrow"></div>
</div>
<div class="control-user">
    <div id="responses"></div>
<?php if (!isset($log)) { ?>
        <center><h3>Your Report log is empty.</h3><center>
<?php } else { ?>
                <div class="table-responsive">        
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Ad. Id</th>
                                <th>IP Address</th>
                                <th>Operating System</th>
                                <th>Browser</th>
                                <th>Visited Date</th>
                            </tr>                
                        </thead>
                        <tbody>
    <?php foreach ($log as $k => $l) { ?>
                                <tr>
                                    <th><?php echo $k + 1; ?></th>
                                    <th><?php echo $l['ad_id']; ?></th>
                                    <th><?php echo $l['ip']; ?></th>
                                    <th><?php echo $l['os']; ?></th>
                                    <th><?php echo $l['browser']; ?></th>
                                    <th><?php echo formatTime($l['visit_time']); ?></th>
                                </tr>     
    <?php } ?>
                        </tbody>
                    </table>
                </div>

                <p><h3>Browser Report</h3></p>
                <div id="chartdiv" style="width: 100%; height: 400px;"></div>
                <p><h3>Operating System Report</h3></p>
                <div id="chartdiv1" style="width: 100%; height: 400px;"></div>
<?php } ?>
            </div> 

