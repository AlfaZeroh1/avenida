<?php 
require_once '../config1.php';
require_once '../connection.php';
$sql="select createdby,sum(total) amount from sales where soldon>='2012-01-01' and soldon<='2012-01-10' group by createdby";
$res=mysql_query($sql);
$num=mysql_affected_rows();

//$data=array();
$i=0;
while($row=mysql_fetch_array($res)){
	$i++;
	extract($row);
	$user=mysql_fetch_object(mysql_query("select * from users where id='$createdby'"));
	
	$data.="['".$user->username."',".$amount."]";
	if($i<$num)
		$data.=", ";
}
?>
<script type="text/javascript" src="../media/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Sales Pie Chart'
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage*100)/100 +' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage*100)/100 +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Sales Pie Chart',
                data: [<?php echo $data; ?>]
            }]
        });
    });
    
});
		</script>
<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

	</body>