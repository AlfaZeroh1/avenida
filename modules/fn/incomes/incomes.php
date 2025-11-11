<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Incomes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Incomes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="764";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$incomes=new Incomes();
if(!empty($delid)){
	$incomes->id=$delid;
	$incomes->delete($incomes);
	redirect("incomes.php");
}
//Authorization.
$auth->roleid="763";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addincomes_proc.php',600,430);" value="Add Incomes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Code </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="765";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="766";//View
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
		$fields="fn_incomes.id, fn_incomes.name, fn_incomes.code, fn_incomes.remarks, fn_incomes.ipaddress, fn_incomes.createdby, fn_incomes.createdon, fn_incomes.lasteditedby, fn_incomes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$incomes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$incomes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="765";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addincomes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="766";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='incomes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
