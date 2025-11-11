<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Specialemployees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Specialemployees";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1190";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$specialemployees=new Specialemployees();
if(!empty($delid)){
	$specialemployees->id=$delid;
	$specialemployees->delete($specialemployees);
	redirect("specialemployees.php");
}
//Authorization.
$auth->roleid="1189";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addspecialemployees_proc.php',510,280);"><span>ADD SPECIAL EMPLOYEES</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>PAYE </th>
			<th>NHIF </th>
			<th>NSSF </th>
<?php
//Authorization.
$auth->roleid="1191";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1192";//View
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
		$fields="hrm_specialemployees.id, hrm_specialemployees.employeeid, hrm_specialemployees.paye, hrm_specialemployees.nhif, hrm_specialemployees.nssf, hrm_specialemployees.createdby, hrm_specialemployees.createdon, hrm_specialemployees.lasteditedby, hrm_specialemployees.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$specialemployees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$specialemployees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatNumber($row->paye); ?></td>
			<td><?php echo $row->nhif; ?></td>
			<td><?php echo $row->nssf; ?></td>
<?php
//Authorization.
$auth->roleid="1191";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addspecialemployees_proc.php?id=<?php echo $row->id; ?>',510,280);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1192";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='specialemployees.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
