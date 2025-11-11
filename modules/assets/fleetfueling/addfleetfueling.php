<title>WiseDigits: Fleetfueling </title>
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
<form class="forms" id="theform" action="addfleetfueling_proc.php" name="fleetfueling" method="POST" enctype="multipart/form-data">
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
		<td align="right">Vehicle : </td>
			<td><select name="fleetid">
<option value="">Select...</option>
<?php
	//$fleets=new Fleets();
	$fields="assets_fleets.id, assets_assets.name assetid, assets_fleetmodels.name as fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleettypes.name as fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleetfueltypes.name as fleetfueltypeid, assets_fleetodometertypes.name as fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_departments.name as departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
		$join=" left join assets_assets on assets_assets.id=assets_fleets.assetid left join assets_fleetmodels on assets_fleets.fleetmodelid=assets_fleetmodels.id  left join assets_fleettypes on assets_fleets.fleettypeid=assets_fleettypes.id  left join assets_fleetfueltypes on assets_fleets.fleetfueltypeid=assets_fleetfueltypes.id  left join assets_fleetodometertypes on assets_fleets.fleetodometertypeid=assets_fleetodometertypes.id  left join hrm_employees on assets_fleets.employeeid=hrm_employees.id  left join hrm_departments on assets_fleets.departmentid=hrm_departments.id ";
	$where= "";
	$having="";
	$groupby="";
	$orderby="";
	$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();

	while($rw=mysql_fetch_object($fleets->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->assetid);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity(Ltrs) : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cost : </td>
		<td><input type="text" name="cost" id="cost" size="8"  value="<?php echo $obj->cost; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date : </td>
		<td><input type="text" name="fueledon" id="fueledon" class="date_input" size="12" value="<?php echo $obj->fueledon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Driver : </td>
			<td><select name="employeeid">
<option value="">Select...</option>
<?php
	$employees=new Employees();
	$where="  ";
	$fields="hrm_employees.id, hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) name, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
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
		<td align="right">Reference No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Odometer Reading : </td>
		<td><input type="text" name="startodometer" id="startodometer" size="8"  value="<?php echo $obj->startodometer; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Odometer : </td>
		<td><input type="text" name="endodometer" id="endodometer" size="8"  value="<?php echo $obj->endodometer; ?>"></td>
	</tr>
	<tr>
		<td align="right">Destination : </td>
		<td><input type="text" name="destination" id="destination" value="<?php echo $obj->destination; ?>"></td>
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