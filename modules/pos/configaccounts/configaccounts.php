<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Configaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Configaccounts";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9303";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$configaccounts=new Configaccounts();
if(!empty($delid)){
	$configaccounts->id=$delid;
	$configaccounts->delete($configaccounts);
	redirect("configaccounts.php");
}
//Authorization.
$auth->roleid="9302";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addconfigaccounts_proc.php',600,430);" value="Add Configaccounts " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Bank Account Name </th>
			<th>Account No </th>
			<th>Currency </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9304";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9305";//Add
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
		$fields="pos_configaccounts.id, pos_configaccounts.name, pos_configaccounts.accno, sys_currencys.name as currencyid, pos_configaccounts.remarks, pos_configaccounts.ipaddress, pos_configaccounts.createdby, pos_configaccounts.createdon, pos_configaccounts.lasteditedby, pos_configaccounts.lasteditedon";
		$join=" left join sys_currencys on pos_configaccounts.currencyid=sys_currencys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$configaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$configaccounts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->accno; ?></td>
			<td><?php echo $row->currencyid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9304";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addconfigaccounts_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9305";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='configaccounts.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
