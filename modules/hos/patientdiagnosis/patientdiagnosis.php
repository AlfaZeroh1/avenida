<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientdiagnosis_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientdiagnosis";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11473";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$patientdiagnosis=new Patientdiagnosis();
if(!empty($delid)){
	$patientdiagnosis->id=$delid;
	$patientdiagnosis->delete($patientdiagnosis);
	redirect("patientdiagnosis.php");
}
//Authorization.
$auth->roleid="11472";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addpatientdiagnosis_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Service No </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="11474";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11475";//Add
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
		$fields="hos_patientdiagnosis.id, hos_patientdiagnosis.documentno, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patienttreatmentss.name as patienttreatmentid, hos_diagnosis.name as diagnosiid, hos_patientdiagnosis.remarks, hos_patientdiagnosis.createdby, hos_patientdiagnosis.createdon, hos_patientdiagnosis.lasteditedby, hos_patientdiagnosis.lasteditedon";
		$join=" left join hos_patients on hos_patientdiagnosis.patientid=hos_patients.id  left join hos_patienttreatmentss on hos_patientdiagnosis.patienttreatmentid=hos_patienttreatmentss.id  left join hos_diagnosis on hos_patientdiagnosis.diagnosiid=hos_diagnosis.id ";
		$having="";
		$groupby="";
		$orderby="";
		$patientdiagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientdiagnosis->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->patientid; ?></td>
			<td><?php echo $row->patienttreatmentid; ?></td>
			<td><?php echo $row->diagnosiid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="11474";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientdiagnosis_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11475";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='patientdiagnosis.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
