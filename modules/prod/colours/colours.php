<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Colours_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Colours";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8576";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$colours=new Colours();
if(!empty($delid)){
	$colours->id=$delid;
	$colours->delete($colours);
	redirect("colours.php");
}
//Authorization.
$auth->roleid="8575";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcolours_proc.php',600,430);" value="Add Colours " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Variety Colour </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8577";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8578";//View
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
		$fields="prod_colours.id, prod_colours.name, prod_colours.remarks, prod_colours.ipaddress, prod_colours.createdby, prod_colours.createdon, prod_colours.lasteditedby, prod_colours.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$colours->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$colours->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8577";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcolours_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8578";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='colours.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
