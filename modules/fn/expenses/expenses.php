<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Expenses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Expenses";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="744";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$expenses=new Expenses();
if(!empty($delid)){
	$expenses->id=$delid;
	$expenses->delete($expenses);
	redirect("expenses.php");
}
//Authorization.
$auth->roleid="743";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addexpenses_proc.php',600,430);" value="Add Expenses " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Code </th>
			<th>Expense Type </th>
			<th>Expense Category </th>
			<th>Description </th>
<?php
//Authorization.
$auth->roleid="745";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="746";//View
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
		$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expensetypes.name as expensetypeid, fn_expensecategorys.name as expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
		$join=" left join fn_expensecategorys on fn_expenses.expensecategoryid=fn_expensecategorys.id left join fn_expensetypes on fn_expensecategorys.expensetypeid=fn_expensetypes.id ";
		$where="";
		if(!empty($ob->expensecategoryid)){
		  $where.=" where fn_expenses.expensecategoryid='$ob->expensecategoryid' ";
		}
		$having="";
		$groupby="";
		$orderby="";
		$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$expenses->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->expensetypeid; ?></td>
			<td><?php echo $row->expensecategoryid; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="745";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addexpenses_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="746";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='expenses.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
