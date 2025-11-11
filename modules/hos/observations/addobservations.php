<?php 
$pop=1;
include "../../../head.php";

?>
<title>WiseDigits: Observations</title>
<form action="addobservations_proc.php" name="observations" method="POST">
<table align="center">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Patient: </td>
<td><select name="patientid">
<option value="">Select...</option>
<?php
	$patients=new Patients();
	$where="  ";
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob, hos_patients.age, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($patients->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->patientid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">PatientTreatment: </td>
<td><select name="patienttreatmentid">
<option value="">Select...</option>
<?php
	$patienttreatments=new Patienttreatments();
	$where="  ";
	$fields="hos_patienttreatments.id, hos_patienttreatments.patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.observation, hos_patienttreatments.symptoms, hos_patienttreatments.diagnosis, hos_patienttreatments.treatedon, hos_patienttreatments.patientstatusid, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($patienttreatments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->patienttreatmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Observation: </td>
		<td><textarea name="observation"><?php echo $obj->observation; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>