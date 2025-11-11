<title>WiseDigits: Employeeallowances </title>
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
<form  id="theform" action="addemployeeallowances_proc.php" name="employeeallowances" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Allowance : </td>
			<td><select name="allowanceid">
<option value="">Select...</option>
<?php
	$allowances=new Allowances();
	$where="  ";
	$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($allowances->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->allowanceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
			<td><select name="employeeid">
<option value="">Select...</option>
<?php
	$employees=new Employees();
	if(!empty($ob->employeeid)){
	$where=" where id = $ob->employeeid ";
	}
	$fields="hrm_employees.id, hrm_employees.pfnum, concat(hrm_employees.firstname,' ',hrm_employees.middlename,' ',hrm_employees.lastname)  name, hrm_employees.gender, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
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
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Allowance Type : </td>
			<td><select name="allowancetypeid">
<option value="">Select...</option>
<?php
	$allowancetypes=new Allowancetypes();
	$where="  ";
	$fields="hrm_allowancetypes.id, hrm_allowancetypes.name, hrm_allowancetypes.repeatafter, hrm_allowancetypes.remarks, hrm_allowancetypes.createdby, hrm_allowancetypes.createdon, hrm_allowancetypes.lasteditedby, hrm_allowancetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($allowancetypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->allowancetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Month From : </td>
		<td><input type="text" name="frommonth" id="frommonth" value="<?php echo $obj->frommonth; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year From : </td>
		<td><input type="text" name="fromyear" id="fromyear" value="<?php echo $obj->fromyear; ?>"></td>
	</tr>
	<tr>
		<td align="right">Month To : </td>
		<td><input type="text" name="tomonth" id="tomonth" value="<?php echo $obj->tomonth; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year To : </td>
		<td><input type="text" name="toyear" id="toyear" value="<?php echo $obj->toyear; ?>"></td>
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