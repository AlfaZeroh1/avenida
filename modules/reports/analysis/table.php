<?php
require_once '../config.php';
require_once '../connection.php';
$id=$_GET['id'];

$sql="select * from analysisfortables where id='$id'";
$gr=mysql_fetch_object(mysql_query($sql));
$sql=$gr->sqls;

$res=mysql_query($sql);
?>
<table align="center">
<?php 
while($row=mysql_fetch_object($res)){
	?>
	<tr>
		<td><?php echo $row->training_date; ?></td>
		<td><?php echo $row->amount; ?></td>
		<td><?php echo $row->training_topic; ?></td>
	</tr>
	<?php 
}
?>
</table>