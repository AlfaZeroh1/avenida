<title>WiseDigits ERP: Fleetschedules </title>
<?php 
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
<form class="forms" id="theform" action="addfleetschedules_proc.php" name="fleetschedules" method="POST" enctype="multipart/form-data">
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
		<td align="right">Asset : </td>
			<td><select name="assetid" class="selectbox">
<option value="">Select...</option>
<?php
	$assets=new Assets();
	$where=" where assets_assets.categoryid='1' ";
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($assets->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->assetid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Driver : </td>
			<td><select name="employeeid" class="selectbox">
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
		<td align="right">Project : </td>
			<td><select name="projectid" class="selectbox">
<option value="">Select...</option>
<?php
	$projects=new Projects();
	$where="  ";
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projects->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Customer : </td>
			<td><select name="customerid" class="selectbox">
<option value="">Select...</option>
<?php
	$customers=new Customers();
	$where="  ";
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($customers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->customerid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Source : </td>
		<td><input type="text" name="source" id="source" value="<?php echo $obj->source; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Destination : </td>
		<td><input type="text" name="destination" id="destination" value="<?php echo $obj->destination; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Departure Time : </td>
		<td><input type="text" name="departuretime" id="departuretime" class="date_input" size="12" readonly  value="<?php echo $obj->departuretime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected Arrival Time : </td>
		<td><input type="text" name="expectedarrivaltime" id="expectedarrivaltime" class="date_input" size="12" readonly  value="<?php echo $obj->expectedarrivaltime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Actual Arrival Time : </td>
		<td><input type="text" name="arrivaltime" id="arrivaltime" class="date_input" size="12" readonly  value="<?php echo $obj->arrivaltime; ?>"></td>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>