<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patienttreatments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
$auth->roleid="8864";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);

$page_title="Patienttreatments";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];

$patienttreatments=new Patienttreatments();
if(!empty($delid)){
	$patienttreatments->id=$delid;
	$patienttreatments->delete($patienttreatments);
	redirect("patienttreatments.php");
}

$obj = (object)$_POST;
$ob = (object)$_GET;

if(empty($obj->action)){
	$obj->treatedon=date("Y-m-d");
	$obj->totreatedon=date("Y-m-d");
}
if(!empty($ob->admission))
	$obj->admission=$ob->admission;
?>
<form action="" method="post">
<table align='center'>
	<tr align="center">
		<td>Treated On:&nbsp;From: <input type="text" size="12" readonly="readonly" class="date_input" name="treatedon" id="treatedon" value="<?php echo $obj->treatedon; ?>"/>
										&nbsp;To: <input type="text" size="12" readonly="readonly" class="date_input" name="totreatedon" id="totreatedon" value="<?php echo $obj->totreatedon; ?>"/>
										<input type="hidden" name="admission" value="<?php echo $obj->admission; ?>"/>
										<input type="submit" class="btn" value="Filter" name="action" id="action"/>
	</tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Patient Name</th>
			<th>Age</th>
			<th>Gender</th>
			<th>Department</th>
			<th>Client Name</th>
			<th>Observation</th>
			<th>Symptoms</th>
			<th>Diagnosis</th>
			<th>Other Diagnosis</th>
			<th>Treatedon</th>
			<th>Time Stamp</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_patienttreatments.id, hos_patientappointments.id patientappointmentid, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.symptoms,hos_patientclasses.name as patientclasseid, sys_genders.name as genderid,hos_patients.dob, hos_diagnosis.name as diagnosiid,hos_departments.name as departmentid, hos_patienttreatments.diagnosis, hos_patienttreatments.treatedon, hos_patientstatuss.name as patientstatusid, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
		$join=" left join hos_patients on hos_patienttreatments.patientid=hos_patients.id  left join hos_patientstatuss on hos_patienttreatments.patientstatusid=hos_patientstatuss.id left join hos_patientappointments on hos_patientappointments.id=hos_patienttreatments.patientappointmentid left join hos_patientclasses on hos_patientclasses.id=hos_patients.patientclasseid left join sys_genders on sys_genders.id=hos_patients.genderid left join hos_diagnosis on hos_diagnosis.id=hos_patienttreatments.diagnosiid left join hos_departments on hos_departments.id=hos_patientappointments.departmentid";
		$having="";
		$groupby="";
		$orderby="group by hos_patienttreatments.patientappointmentid";
		$where=" where treatedon>='$obj->treatedon'  and treatedon<='$obj->totreatedon' and departmentid=2 and admission='$obj->admission'";
		if($_SESSION['level']==10 or $_SESSION['level']==9){
		$where.=" and hos_patientappointments.departmentid in ( select hos_departmentdoctors.departmentid from hos_departmentdoctors left join auth_users on hos_departmentdoctors.employeeid=auth_users.employeeid where  auth_users.id='".$_SESSION['userid']."')  ";
		}
		$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $patienttreatments->sql;
		$res=$patienttreatments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->patientid); ?></td>
			<td><?php echo $row->dob; ?></td>
			<td><?php echo $row->genderid; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->patientclasseid; ?></td>
			<td><?php echo $row->observation; ?></td>
			<td><?php echo $row->symptoms; ?></td>
			<td><?php echo $row->diagnosiid; ?></td>
			<td><?php echo $row->diagnosis; ?></td>
			<td><?php echo formatDate($row->treatedon); ?></td>
			<td><?php echo $row->createdon; ?></td>
			<td><a href="../patienttreatments/addpatienttreatments_proc.php?treatmentid=<?php echo $row->id; ?>&tab=2">View</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
