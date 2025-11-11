<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientclasses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientclasses";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4412";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$patientclasses=new Patientclasses();
if(!empty($delid)){
	$patientclasses->id=$delid;
	$patientclasses->delete($patientclasses);
	redirect("patientclasses.php");
}
//Authorization.
$auth->roleid="4411";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientclasses_proc.php',600,430);" value="Add Patientclasses " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Patient Class </th>
			<th>Consultation Fee </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4413";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4414";//Add
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
		$fields="hos_patientclasses.id, hos_patientclasses.name, hos_patientclasses.fee, hos_patientclasses.remarks, hos_patientclasses.createdby, hos_patientclasses.createdon, hos_patientclasses.lasteditedby, hos_patientclasses.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$patientclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientclasses->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td align="right"><?php echo formatNumber($row->fee); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4413";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientclasses_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4414";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='patientclasses.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
