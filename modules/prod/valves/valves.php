<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Valves_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Valves";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9234";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$valves=new Valves();
if(!empty($delid)){
	$valves->id=$delid;
	$valves->delete($valves);
	redirect("valves.php");
}
//Authorization.
$auth->roleid="9233";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addvalves_proc.php',600,430);" value="Add Valves " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Irrigation Valve </th>
			<th>Irrigation System </th>
			<th>Green House </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9235";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9236";//View
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
		$fields="prod_valves.id, prod_valves.name, prod_irrigationsystems.name as systemid, prod_greenhouses.name as greenhouseid, prod_valves.remarks, prod_valves.ipaddress, prod_valves.createdby, prod_valves.createdon, prod_valves.lasteditedby, prod_valves.lasteditedon";
		$join=" left join prod_irrigationsystems on prod_valves.systemid=prod_irrigationsystems.id  left join prod_greenhouses on prod_valves.greenhouseid=prod_greenhouses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$valves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$valves->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->systemid; ?></td>
			<td><?php echo $row->greenhouseid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9235";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addvalves_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9236";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='valves.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
