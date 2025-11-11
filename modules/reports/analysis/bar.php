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
		<title>Bar Graph</title>

		<script type="text/javascript" src="../media/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
		$(function () {
		    var chart;
		    $(document).ready(function() {
		        chart = new Highcharts.Chart({
		            chart: {
		                renderTo: 'container',
		                type: 'bar',
		                inverted:true
		            },
		            title: {
		                text: ' <?php echo $gr->title; ?>'
		            },
		            xAxis: {
		                categories: <?php echo $x; ?>,
		                		title: {
		                    text: '<?php echo $gr->xtext; ?>'
		                }
		            },
		            yAxis: {
		                min: 0,
		                title: {
		                    text: '<?php echo $gr->ytext; ?>',
		                    align: 'middle'
		                },
		                allowDecimals:false,
		                gridLineWidth:0
	                
		            },
		            tooltip: {
		                formatter: function() {
		                    return ''+
		                        this.series.name +': '+ this.y +' ';
		                }
		            },
		            plotOptions: {
		                bar: {
		                    dataLabels: {
		                        enabled: true
		                    }
		                }
		            },
		            legend: {
		                layout: 'vertical',
		                align: 'right',
		                verticalAlign: 'top',
		                x: -100,
		                y: 100,
		                floating: true,
		                borderWidth: 1,
		                backgroundColor: '#FFFFFF',
		                shadow: true
		            },
		            credits: {
		                enabled: true
		            },
		            <?php echo $arr; ?>
		        });
		    });
		    
		});
		</script>
	</head>
	<body style="width: 100%; height: 100%;">
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 100%; margin: 0 auto"></div>

	</body>
</html>