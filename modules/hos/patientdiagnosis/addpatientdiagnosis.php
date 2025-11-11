<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
$pop=1;
include "../../../head.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addpatientdiagnosis_proc.php" name="patientdiagnosis" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Service No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
			<td><select name="patientid" class="selectbox">
<option value="">Select...</option>
<?php
	$patients=new Patients();
	$where="  ";
	$fields="hos_patients.id, hos_patients.brancheid, hos_patients.customerid, hos_patients.departmentcategoryid, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.bloodgroup, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.tel, hos_patients.genderid, hos_patients.dob, hos_patients.civilstatusid, hos_patients.remarks, hos_patients.status, hos_patients.ipaddress, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
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
		<td align="right"> : </td>
			<td><select name="patienttreatmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$patienttreatmentss=new Patienttreatmentss();
	$where="  ";
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patienttreatmentss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($patienttreatmentss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->patienttreatmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right"> : </td>
			<td><select name="diagnosiid" class="selectbox">
<option value="">Select...</option>
<?php
	$diagnosis=new Diagnosis();
	$where="  ";
	$fields="hos_diagnosis.id, hos_diagnosis.name, hos_diagnosis.remarks, hos_diagnosis.ipaddress, hos_diagnosis.createdby, hos_diagnosis.createdon, hos_diagnosis.lasteditedby, hos_diagnosis.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$diagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($diagnosis->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->diagnosiid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>