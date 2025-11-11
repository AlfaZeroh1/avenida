<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationsystems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Irrigationsystems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9218";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$irrigationsystems=new Irrigationsystems();
if(!empty($delid)){
	$irrigationsystems->id=$delid;
	$irrigationsystems->delete($irrigationsystems);
	redirect("irrigationsystems.php");
}
//Authorization.
$auth->roleid="9217";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addirrigationsystems_proc.php',600,430);" value="Add Irrigationsystems " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Irrigation System </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="9219";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9220";//Add
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
		$fields="prod_irrigationsystems.id, prod_irrigationsystems.name, prod_irrigationsystems.remarks, prod_irrigationsystems.ipaddress, prod_irrigationsystems.createdby, prod_irrigationsystems.createdon, prod_irrigationsystems.lasteditedby, prod_irrigationsystems.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$irrigationsystems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$irrigationsystems->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../systemblocks/systemblocks.php?systemid=<?php echo $row->id; ?>">Blocks</td>
<?php
//Authorization.
$auth->roleid="9219";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addirrigationsystems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9220";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='irrigationsystems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
