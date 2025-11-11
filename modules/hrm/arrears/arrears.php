<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Arrears_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Arrears";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9369";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$arrears=new Arrears();
if(!empty($delid)){
	$arrears->id=$delid;
	$arrears->delete($arrears);
	redirect("arrears.php");
}
//Authorization.
$auth->roleid="9368";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addarrears_proc.php',600,430);" value="Add Arrears " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Allowance </th>
			<th>Taxable </th>
			<th>Status </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="9370";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9371";//View
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
		$fields="hrm_arrears.id, hrm_arrears.name, hrm_arrears.taxable, hrm_arrears.status, hrm_arrears.remarks, hrm_arrears.createdby, hrm_arrears.createdon, hrm_arrears.lasteditedby, hrm_arrears.lasteditedon, hrm_arrears.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$arrears->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../employeearrears/employeearrears.php?arrearid=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->taxable; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../employeepaidarrears/employeepaidarrears.php?arrearid=<?php echo $row->id; ?>">Sttmt</a></td>
<?php
//Authorization.
$auth->roleid="9370";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addarrears_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9371";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='arrears.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
