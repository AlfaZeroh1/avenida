<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Categorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4750";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$categorys=new Categorys();
if(!empty($delid)){
	$categorys->id=$delid;
	$categorys->delete($categorys);
	redirect("categorys.php");
}
//Authorization.
$auth->roleid="4749";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcategorys_proc.php',600,430);" value="Add Categorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category </th>
			<th>Account Type</th>
			<th>Expense Account</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4751";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4752";//View
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
		$fields="inv_categorys.id, inv_categorys.name, inv_categorys.remarks, sys_acctypes.name acctypeid, inv_categorys.createdby, inv_categorys.createdon, inv_categorys.lasteditedby, inv_categorys.lasteditedon, inv_categorys.ipaddress, fn_expenses.name expenseid";
		$join=" left join sys_acctypes on sys_acctypes.id=inv_categorys.acctypeid left join fn_expenses on fn_expenses.id=inv_categorys.refid ";
		$having="";
		$groupby="";
		$orderby="";
		$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$categorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../items/items.php?categoryid=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->acctypeid; ?></td>
			<td><?php echo $row->expenseid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4751";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4752";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='categorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
