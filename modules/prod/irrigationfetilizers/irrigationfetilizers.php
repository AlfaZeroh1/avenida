<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationfetilizers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Irrigationfetilizers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9099";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$irrigationfetilizers=new Irrigationfetilizers();
if(!empty($delid)){
	$irrigationfetilizers->id=$delid;
	$irrigationfetilizers->delete($irrigationfetilizers);
	redirect("irrigationfetilizers.php");
}
//Authorization.
$auth->roleid="9098";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addirrigationfetilizers_proc.php',600,430);" value="Add Irrigationfetilizers " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Irrigation </th>
			<th>Fertilizer </th>
			<th>Amount (Kgs) </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9100";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9101";//View
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
		$fields="prod_irrigationfetilizers.id, prod_irrigations.name as irrigationid, prod_fertilizers.name as fertilizerid, prod_irrigationfetilizers.amount, prod_irrigationfetilizers.remarks, prod_irrigationfetilizers.ipaddress, prod_irrigationfetilizers.createdby, prod_irrigationfetilizers.createdon, prod_irrigationfetilizers.lasteditedby, prod_irrigationfetilizers.lasteditedon";
		$join=" left join prod_irrigations on prod_irrigationfetilizers.irrigationid=prod_irrigations.id  left join prod_fertilizers on prod_irrigationfetilizers.fertilizerid=prod_fertilizers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$irrigationfetilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$irrigationfetilizers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->irrigationid; ?></td>
			<td><?php echo $row->fertilizerid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9100";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addirrigationfetilizers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9101";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='irrigationfetilizers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
