<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Expensetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Expensetypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="748";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$expensetypes=new Expensetypes();
if(!empty($delid)){
	$expensetypes->id=$delid;
	$expensetypes->delete($expensetypes);
	redirect("expensetypes.php");
}
//Authorization.
$auth->roleid="747";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addexpensetypes_proc.php',600,430);" value="Add Expensetypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Priority </th>
			<th>Expense Type</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="749";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="750";//View
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
		$fields="fn_expensetypes.id, sys_acctypes.name acctype, fn_expensetypes.acctypeid,fn_expensetypes.priority, fn_expensetypes.name, fn_expensetypes.remarks, fn_expensetypes.ipaddress, fn_expensetypes.createdby, fn_expensetypes.createdon, fn_expensetypes.lasteditedby, fn_expensetypes.lasteditedon";
		$join=" left join sys_acctypes on sys_acctypes.id=fn_expensetypes.acctypeid ";
		$having="";
		$groupby="";
		$orderby=" order by fn_expensetypes.priority ";
		$expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$expensetypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../expensecategorys/expensecategorys.php?id=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->priority; ?></td>
			<td><?php echo $row->acctype; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="749";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addexpensetypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="750";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='expensetypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
