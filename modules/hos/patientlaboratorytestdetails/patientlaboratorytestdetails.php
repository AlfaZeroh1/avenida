<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientlaboratorytestdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientlaboratorytestdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8862";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$patientlaboratorytestdetails=new Patientlaboratorytestdetails();
if(!empty($delid)){
	$patientlaboratorytestdetails->id=$delid;
	$patientlaboratorytestdetails->delete($patientlaboratorytestdetails);
	redirect("patientlaboratorytestdetails.php");
}
//Authorization.
$auth->roleid="8861";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientlaboratorytestdetails_proc.php',600,430);" value="Add Patientlaboratorytestdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Patient Lab Test </th>
			<th>Laboratory Test Detail </th>
			<th>Result </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8863";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8864";//Add
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
		$fields="hos_patientlaboratorytestdetails.id, hos_patientlaboratorytests.name as patientlaboratorytestid, hos_laboratorytestdetails.name as laboratorytestdetailid, hos_patientlaboratorytestdetails.result, hos_patientlaboratorytestdetails.remarks, hos_patientlaboratorytestdetails.ipaddress, hos_patientlaboratorytestdetails.createdby, hos_patientlaboratorytestdetails.createdon, hos_patientlaboratorytestdetails.lasteditedby, hos_patientlaboratorytestdetails.lasteditedon";
		$join=" left join hos_patientlaboratorytests on hos_patientlaboratorytestdetails.patientlaboratorytestid=hos_patientlaboratorytests.id  left join hos_laboratorytestdetails on hos_patientlaboratorytestdetails.laboratorytestdetailid=hos_laboratorytestdetails.id ";
		$having="";
		$groupby="";
		$orderby="";
		$patientlaboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientlaboratorytestdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->patientlaboratorytestid; ?></td>
			<td><?php echo $row->laboratorytestdetailid; ?></td>
			<td><?php echo $row->result; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8863";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientlaboratorytestdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8864";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='patientlaboratorytestdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
