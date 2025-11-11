<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Diagnosis_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Diagnosis";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8460";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$diagnosis=new Diagnosis();
if(!empty($delid)){
	$diagnosis->id=$delid;
	$diagnosis->delete($diagnosis);
	redirect("diagnosis.php");
}
//Authorization.
$auth->roleid="8459";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddiagnosis_proc.php',600,430);" value="Add Diagnosis " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Disease </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8461";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8462";//Add
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
		$fields="hos_diagnosis.id, hos_diagnosis.name, hos_diagnosis.remarks, hos_diagnosis.ipaddress, hos_diagnosis.createdby, hos_diagnosis.createdon, hos_diagnosis.lasteditedby, hos_diagnosis.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$diagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$diagnosis->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8461";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddiagnosis_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8462";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='diagnosis.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
