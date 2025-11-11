<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Spraymethods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Spraymethods";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8716";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$spraymethods=new Spraymethods();
if(!empty($delid)){
	$spraymethods->id=$delid;
	$spraymethods->delete($spraymethods);
	redirect("spraymethods.php");
}
//Authorization.
$auth->roleid="8715";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addspraymethods_proc.php',600,430);" value="Add Spraymethods " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Spray Method </th>
			<th>REmarks </th>
<?php
//Authorization.
$auth->roleid="8717";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8718";//View
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
		$fields="prod_spraymethods.id, prod_spraymethods.name, prod_spraymethods.remarks, prod_spraymethods.ipaddress, prod_spraymethods.createdby, prod_spraymethods.createdon, prod_spraymethods.lasteditedby, prod_spraymethods.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$spraymethods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$spraymethods->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8717";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addspraymethods_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8718";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='spraymethods.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
