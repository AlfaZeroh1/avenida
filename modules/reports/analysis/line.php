<?php 
require_once '../config.php';
require_once '../connection.php';
$id=$_GET['id'];
include 'process1.php';

//drawLineGraph();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Line Graph</title>

		<script type="text/javascript" src="../../../media/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '<?php echo $gr->title; ?>',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: C',
                x: -20
            },
            xAxis: {
                categories: <?php echo $x; ?>,
                		title: {
                    text: '<?php echo $gr->xtext; ?>'
                }
            },
            yAxis: {
                title: {
                    text: '<?php echo $gr->ytext; ?>'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            <?php echo $arr; ?>
        });
    });
    
});
		</script>
	</head>
	<body>
<script src="../../../js/highcharts.js"></script>
<script src="../../../js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 100%; margin: 0 auto"></div>

	</body>
</html>