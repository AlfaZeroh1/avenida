<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Acctypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Acctypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="109";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$acctypes=new Acctypes();
if(!empty($delid)){
	$acctypes->id=$delid;
	$acctypes->delete($acctypes);
	redirect("acctypes.php");
}
//Authorization.
$auth->roleid="108";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addacctypes_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>CODE </th>
			<th>Name </th>
			<th>Account Type </th>
			<th>Sub Account </th>
			<th>Balance Type? </th>
			<th>Account Type </th>
			<th>Direct Posting </th>
<?php
//Authorization.
$auth->roleid="110";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="111";//View
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
		$fields="sys_acctypes.id, sys_acctypes.code, sys_acctypes.name, fn_accounttypes.name as accounttypeid, fn_subaccountypes.name as subaccountypeid, sys_acctypes.balance, sys_acctypes.accounttype, sys_acctypes.direct";
		$join=" left join fn_accounttypes on sys_acctypes.accounttypeid=fn_accounttypes.id  left join fn_subaccountypes on sys_acctypes.subaccountypeid=fn_subaccountypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$acctypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><a href="../../fn/generaljournalaccounts/generaljournalaccounts.php?acctypeid=<?php echo $row->id; ?>"><?php echo initialCap($row->name); ?></a></td>
			<td><?php echo $row->accounttypeid; ?></td>
			<td><?php echo $row->subaccountypeid; ?></td>
			<td><?php echo $row->balance; ?></td>
			<td><?php echo $row->accounttype; ?></td>
			<td><?php echo $row->direct; ?></td>
<?php
//Authorization.
$auth->roleid="110";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addacctypes_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="111";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='acctypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
