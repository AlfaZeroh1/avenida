<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Accounttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Accounttypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9457";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$accounttypes=new Accounttypes();
if(!empty($delid)){
	$accounttypes->id=$delid;
	$accounttypes->delete($accounttypes);
	redirect("accounttypes.php");
}
//Authorization.
$auth->roleid="9456";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" class="btn btn-info" onclick="showPopWin('addaccounttypes_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Account Type </th>
			<th>Remarks </th>
			<th>Debit/Credit </th>
<?php
//Authorization.
$auth->roleid="9458";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9459";//Add
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
		$fields="fn_accounttypes.id, fn_accounttypes.name, fn_accounttypes.remarks, fn_accounttypes.balance";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$accounttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$accounttypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../../sys/acctypes/acctypes.php?accounttypeid=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->balance; ?></td>
<?php
//Authorization.
$auth->roleid="9458";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addaccounttypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9459";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='accounttypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
