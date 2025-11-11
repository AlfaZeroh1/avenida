<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientotherservices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientotherservices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1330";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$patientotherservices=new Patientotherservices();
if(!empty($delid)){
	$patientotherservices->id=$delid;
	$patientotherservices->delete($patientotherservices);
	redirect("patientotherservices.php");
}
//Authorization.
$auth->roleid="1329";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientotherservices_proc.php', 600, 430);" value="Add Patientotherservices " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Patienttreatmentid </th>
			<th>Hos_otherservices </th>
			<th>Charge </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="1331";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1332";//View
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
		$fields="hos_patientotherservices.id, hos_patientotherservices.patienttreatmentid, hos_otherservices.name as otherserviceid, hos_patientotherservices.charge, hos_patientotherservices.remarks, hos_patientotherservices.createdby, hos_patientotherservices.createdon, hos_patientotherservices.lasteditedby, hos_patientotherservices.lasteditedon";
		$join=" left join hos_otherservices on hos_patientotherservices.otherserviceid=hos_otherservices.id ";
		$having="";
		$groupby="";
		$orderby="";
		$patientotherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientotherservices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->patienttreatmentid; ?></td>
			<td><?php echo $row->otherserviceid; ?></td>
			<td><?php echo formatNumber($row->charge); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="1331";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientotherservices_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
<?php
}
//Authorization.
$auth->roleid="1332";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='patientotherservices.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
