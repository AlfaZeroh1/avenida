<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Admissions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Admissions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4484";//View
$auth->levelid=$_SESSION['level'];

$status= $_GET['status'];

$ob = (object)$_GET;
$obj = (object)$_POST;

if(!empty($ob->status)){
  $obj = $ob;
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$admissions=new Admissions();
if(!empty($delid)){
	$admissions->id=$delid;
	$admissions->delete($admissions);
	redirect("admissions.php");
}
//Authorization.
$auth->roleid="4483";//View
$auth->levelid=$_SESSION['level'];
?>
<div align="center">
<form action="" method="post">
<select name="status" class="selectbox">
  <option value="">Awaiting Allocation</option>
  <option value="1">Admitted</option>
  <option value="2">Discharged</option>
</select>&nbsp;
<input type="submit" name="action" value="Filter" class="btn"/>
</form>
</div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Ward </th>
			<th> Patient Name</th>
			<th>Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4485";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
  if($row->status==0){
?>
<?php } if($row->status==1){?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
}
} ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_admissions.id, concat(hos_departments.name,': ',concat(hos_wards.name,': ',hos_beds.name)) as bedid, hos_admissions.treatmentid, concat(hos_patients.surname,' ', hos_patients.othernames) as patient, hos_patients.id patientid , hos_admissions.admissiondate, hos_admissions.remarks, hos_admissions.status, hos_admissions.createdby, hos_admissions.createdon, hos_admissions.lasteditedby, hos_admissions.lasteditedon";
		$join=" left join hos_beds on hos_admissions.bedid=hos_beds.id  left join hos_patients on hos_admissions.patientid=hos_patients.id left join hos_wards on hos_wards.id=hos_beds.wardid left join hos_departments on hos_departments.id=hos_wards.departmentid";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_admissions.status='$obj->status' ";
		$admissions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$admissions->result; echo mysql_error();
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->bedid); ?></td>
			<td><?php echo initialCap($row->patient); ?></td>
			<td><?php echo formatDate($row->admissiondate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
//echo $row->patientid;
$auth->roleid="4485";//View
$auth->levelid=$_SESSION['level'];


if(existsRule($auth)){
  if($row->status==0){
  ?>
			<td><a href="addadmissions_proc.php?id=<?php echo $row->id; ?>&status=1">Admit</a></td>
<?php
}
if($row->status==1){
  ?>
			<td><a href="addadmissions_proc.php?id=<?php echo $row->id; ?>&status=2">Discharge</a></td>
			<td><a href="../patientvitalsigns/addpatientvitalsigns_proc.php?patientid=<?php echo $row->patientid; ?>&treatmentid=<?php echo $row->treatmentid; ?>">Observations</a></td>
<?php
}
}
}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
