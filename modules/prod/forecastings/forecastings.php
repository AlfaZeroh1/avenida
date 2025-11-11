<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Forecastings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Forecastings";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8696";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$forecastings=new Forecastings();
if(!empty($delid)){
	$forecastings->id=$delid;
	$forecastings->delete($forecastings);
	redirect("forecastings.php");
}
//Authorization.
$auth->roleid="8695";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addforecastings_proc.php',600,430);" value="Add Forecastings " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product </th>
			<th> Week </th>
			<th>Year </th>
			<th>Quantity </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8697";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8698";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="prod_forecastings.id, prod_varietys.name as varietyid, prod_forecastings.week,prod_forecastings.year, prod_forecastings.quantity, prod_forecastings.remarks, prod_forecastings.ipaddress, prod_forecastings.createdby, prod_forecastings.createdon, prod_forecastings.lasteditedby, prod_forecastings.lasteditedon";
		$join=" left join prod_varietys on prod_forecastings.varietyid=prod_varietys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$forecastings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$forecastings->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo $row->week; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8697";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addforecastings_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8698";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='forecastings.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
