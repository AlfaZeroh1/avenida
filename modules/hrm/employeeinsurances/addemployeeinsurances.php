<title>WiseDigits: Employeeinsurances </title>
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
<form  id="theform" action="addemployeeinsurances_proc.php" name="employeeinsurances" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
		<td><input type="text" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Insurance : </td>
			<td><select name="insuranceid">
<option value="">Select...</option>
<?php
	$insurances=new Insurances();
	$where="  ";
	$fields="hrm_insurances.id, hrm_insurances.name, hrm_insurances.remarks, hrm_insurances.createdby, hrm_insurances.createdon, hrm_insurances.lasteditedby, hrm_insurances.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($insurances->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->insuranceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Premium Paid : </td>
		<td><input type="text" name="premium" id="premium" size="8"  value="<?php echo $obj->premium; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected End Date : </td>
		<td><input type="text" name="expectedenddate" id="expectedenddate" class="date_input" size="12" readonly  value="<?php echo $obj->expectedenddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
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