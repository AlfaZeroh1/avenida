<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subaccountypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Subaccountypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10101";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$subaccountypes=new Subaccountypes();
if(!empty($delid)){
	$subaccountypes->id=$delid;
	$subaccountypes->delete($subaccountypes);
	redirect("subaccountypes.php");
}
//Authorization.
$auth->roleid="10100";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addsubaccountypes_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Sub Account </th>
			<th>Account Type </th>
			<th>Priority </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10102";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10103";//View
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
		$fields="fn_subaccountypes.id, fn_subaccountypes.name, fn_accounttypes.name as accounttypeid, fn_subaccountypes.priority, fn_subaccountypes.remarks, fn_subaccountypes.ipaddress, fn_subaccountypes.createdby, fn_subaccountypes.createdon, fn_subaccountypes.lasteditedby, fn_subaccountypes.lasteditedon";
		$join=" left join fn_accounttypes on fn_subaccountypes.accounttypeid=fn_accounttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$subaccountypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$subaccountypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->accounttypeid; ?></td>
			<td><?php echo $row->priority; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10102";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsubaccountypes_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10103";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='subaccountypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
