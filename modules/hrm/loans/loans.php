<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Loans_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Loans";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1174";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$loans=new Loans();
if(!empty($delid)){
	$loans->id=$delid;
	$loans->delete($loans);
	redirect("loans.php");
}
//Authorization.
$auth->roleid="1173";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addloans_proc.php',600,430);" value="Add Loans " type="button"/></div>

<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Method </th>
			<th>Type </th>
			<th>Income</th>
			<th>Liability</th>
			<th>Description </th>
<?php
//Authorization.
$auth->roleid="1175";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1176";//View
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
		$arr=array(1);
		$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.type, fn_incomes.name as incomeid, hrm_loans.description, hrm_loans.createdby,hrm_loans.liabilityid,fn_liabilitys.name as liabilityname, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon, hrm_loans.ipaddress";
		$join=" left join fn_incomes on hrm_loans.incomeid=fn_incomes.id left join fn_liabilitys on fn_liabilitys.id=hrm_loans.liabilityid ";
		$having="";
		$groupby="";
		$orderby="";
		$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$loans->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href='../../hrm/employeeloans/employeeloans.php?loanid=<?php echo $row->id; ?>'><?php echo $row->name; ?></a></td>
		        <td><?php echo $row->method; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->incomeid; ?></td>
			<td><?php echo $row->liabilityname; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="1175";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
if(!in_array($row->id,$arr)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addloans_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
			<td><a href='../../hrm/employeepaiddeductions/employeepaiddeductions.php?deductionid=4&loanid=<?php echo $row->id; ?>'>Stattmt</a></td>
<?php
}
else{
?>
<td>&nbsp;</td>
<td>&nbsp;</td>
<?php
}
}
//Authorization.
$auth->roleid="1176";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
if(!in_array($row->id,$arr)){
?>
			<td><a href='loans.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php
}
else{
?>
<td>&nbsp;</td>
<?php
}
} ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
