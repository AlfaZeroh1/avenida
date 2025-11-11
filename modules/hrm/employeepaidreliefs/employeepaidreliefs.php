<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidreliefs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeepaidreliefs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1150";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeepaidreliefs=new Employeepaidreliefs();
if(!empty($delid)){
	$employeepaidreliefs->id=$delid;
	$employeepaidreliefs->delete($employeepaidreliefs);
	redirect("employeepaidreliefs.php");
}
//Authorization.
$auth->roleid="1149";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addemployeepaidreliefs_proc.php',500,200);"><span>ADD EMPLOYEE PAID RELIEFS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Employee Relief </th>
<?php
//Authorization.
$auth->roleid="1151";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1152";//View
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
		$fields="hrm_employeepaidreliefs.id, hrm_employeepaidreliefs.employeeid, hrm_employeepaidreliefs.employeereliefid, hrm_employeepaidreliefs.createdby, hrm_employeepaidreliefs.createdon, hrm_employeepaidreliefs.lasteditedby, hrm_employeepaidreliefs.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employeepaidreliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeepaidreliefs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->employeereliefid; ?></td>
<?php
//Authorization.
$auth->roleid="1151";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeepaidreliefs_proc.php?id=<?php echo $row->id; ?>',500,200);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1152";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeepaidreliefs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
