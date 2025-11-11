<title>WiseDigits: Employeecontracts </title>
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

<div class='main'>
<form  id="theform" action="addemployeecontracts_proc.php" name="employeecontracts" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Contract Type : </td>
			<td><select name="contracttypeid">
<option value="">Select...</option>
<?php
	$contracttypes=new Contracttypes();
	$where="  ";
	$fields="hrm_contracttypes.id, hrm_contracttypes.name, hrm_contracttypes.remarks, hrm_contracttypes.createdby, hrm_contracttypes.createdon, hrm_contracttypes.lasteditedby, hrm_contracttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$contracttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($contracttypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->contracttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Confirmation Date : </td>
		<td><input type="text" name="confirmationdate" id="confirmationdate" class="date_input" size="12" readonly  value="<?php echo $obj->confirmationdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Probation (Months) : </td>
		<td><input type="text" name="probation" id="probation" size="8"  value="<?php echo $obj->probation; ?>"></td>
	</tr>
	<tr>
		<td align="right">Contract Period (Months) : </td>
		<td><input type="text" name="contractperiod" id="contractperiod" size="8"  value="<?php echo $obj->contractperiod; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status'>
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='Suspended' <?php if($obj->status=='Suspended'){echo"selected";}?>>Suspended</option>
			<option value='Terminated' <?php if($obj->status=='Terminated'){echo"selected";}?>>Terminated</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
			<td><select name="employeeid">
<option value="">Select...</option>
<?php
	$employees=new Employees();
	$where="  ";
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.dob, hrm_employees.idno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($employees->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->employeeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>