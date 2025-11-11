<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Chemicals_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Chemicals";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8708";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$chemicals=new Chemicals();
if(!empty($delid)){
	$chemicals->id=$delid;
	$chemicals->delete($chemicals);
	redirect("chemicals.php");
}
//Authorization.
$auth->roleid="8707";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addchemicals_proc.php',600,430);" value="Add Chemicals " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Chemical </th>
			<th>REmarks </th>
<?php
//Authorization.
$auth->roleid="8709";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8710";//View
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
		$fields="prod_chemicals.id, prod_chemicals.name, prod_chemicals.remarks, prod_chemicals.ipaddress, prod_chemicals.createdby, prod_chemicals.createdon, prod_chemicals.lasteditedby, prod_chemicals.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$chemicals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$chemicals->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8709";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addchemicals_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8710";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='chemicals.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
