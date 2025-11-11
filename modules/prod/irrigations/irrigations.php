<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Irrigations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9103";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$irrigations=new Irrigations();
if(!empty($delid)){
	$irrigations->id=$delid;
	$irrigations->delete($irrigations);
	redirect("irrigations.php");
}
//Authorization.
$auth->roleid="9102";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addirrigations_proc.php',600,430);" value="Add Irrigations " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Irrigation System </th>
			<th>Irrigation Date </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="9104";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9105";//View
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
		$fields="prod_irrigations.id, prod_irrigationsystems.name as irrigationsystemid, prod_irrigationsystems.id systemid, prod_irrigations.irrigationdate, prod_irrigations.remarks, prod_irrigations.ipaddress, prod_irrigations.createdby, prod_irrigations.createdon, prod_irrigations.lasteditedby, prod_irrigations.lasteditedon";
		$join=" left join prod_irrigationsystems on prod_irrigations.irrigationsystemid=prod_irrigationsystems.id ";
		$having="";
		$groupby="";
		$orderby="";
		$irrigations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$irrigations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->irrigationsystemid; ?></td>
			<td><?php echo formatDate($row->irrigationdate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../irrigationmixtures/irrigationmixtures.php?irrigationid=<?php echo $row->id; ?>">Mixtures</td>
			<td><a href="../irrigationvalves/irrigationvalves.php?irrigationid=<?php echo $row->id; ?>&systemid=<?php echo $row->systemid; ?>">Valves</td>
<?php
//Authorization.
$auth->roleid="9104";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addirrigations_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9105";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='irrigations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
