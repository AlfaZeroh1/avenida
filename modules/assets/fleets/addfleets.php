<title>WiseDigits ERP: Fleets </title>
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
 	
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
	}
  });

	
  $("#scheduleemployeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#scheduleemployeeid").val(ui.item.id);
	}
  });

	
  $("#fuelemployeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#fuelemployeeid").val(ui.item.id);
	}
  });

	
		$("#fleetservicesupplierid").val(ui.item.id);
	}
  });

  $("#fleetservicesuppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
 } );
 
 
 
 </script>

<div class="container" style="margin-top:;">
<div class="tabbable">

<ul class="nav nav-tabs">
		<li><a href="#pane1" data-toggle="tab">DETAILS</a></li>
		<li><a href="#pane2" data-toggle="tab">INSPECTIONS</a></li>
		<li><a href="#pane8" data-toggle="tab">INSURANCE</a></li>
		<li><a href="#pane3" data-toggle="tab">MAINTAINANCE</a></li>
		<li><a href="#pane4" data-toggle="tab">FUELING</a></li>
		<li><a href="#pane5" data-toggle="tab">SERVICE</a></li>
		<li><a href="#pane6" data-toggle="tab">SCHEDULES</a></li>
		<li><a href="#pane7" data-toggle="tab">BREAKDOWNS</a></li>
		<li><a href="#pane9" data-toggle="tab">CONSUMABLES</a></li>

	</ul>
	<div class="tab-content">
    <div id="pane1" class="tab-pane active">

<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
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
		<td align="right"> </td>
		<td><input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Model : </td>
			<td><select name="fleetmodelid" class="selectbox">
<option value="">Select...</option>
<?php
	$fleetmodels=new Fleetmodels();
	$where="  ";
	$fields="assets_fleetmodels.id, assets_fleetmodels.name, assets_fleetmodels.fleetmakeid, assets_fleetmodels.remarks, assets_fleetmodels.ipaddress, assets_fleetmodels.createdby, assets_fleetmodels.createdon, assets_fleetmodels.lasteditedby, assets_fleetmodels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetmodels->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleetmodels->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetmodelid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Year of Manufacture : </td>
		<td><select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-30;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
	</tr>
	<tr>
		<td align="right">Color : </td>
		<td><select name="fleetcolorid" class="selectbox">
<option value="">Select...</option>
<?php
	$fleetcolors=new Fleetcolors();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetcolors->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleetcolors->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetcolorid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
	</tr>
	<tr>
		<td align="right">Vehicle Identification Number : </td>
		<td><input type="text" name="vin" id="vin" value="<?php echo $obj->vin; ?>"></td>
	</tr>
	<tr>
		<td align="right">Vehicle Type : </td>
			<td><select name="fleettypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$fleettypes=new Fleettypes();
	$where="  ";
	$fields="assets_fleettypes.id, assets_fleettypes.name, assets_fleettypes.remarks, assets_fleettypes.ipaddress, assets_fleettypes.createdby, assets_fleettypes.createdon, assets_fleettypes.lasteditedby, assets_fleettypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleettypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleettypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleettypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Plate No : </td>
		<td><input type="text" name="plateno" id="plateno" value="<?php echo $obj->plateno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Engine : </td>
		<td><input type="text" name="engine" id="engine" value="<?php echo $obj->engine; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fuel Type : </td>
			<td><select name="fleetfueltypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$fleetfueltypes=new Fleetfueltypes();
	$where="  ";
	$fields="assets_fleetfueltypes.id, assets_fleetfueltypes.name, assets_fleetfueltypes.remarks, assets_fleetfueltypes.ipaddress, assets_fleetfueltypes.createdby, assets_fleetfueltypes.createdon, assets_fleetfueltypes.lasteditedby, assets_fleetfueltypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetfueltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleetfueltypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetfueltypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Odometer Type : </td>
			<td><select name="fleetodometertypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$fleetodometertypes=new Fleetodometertypes();
	$where="  ";
	$fields="assets_fleetodometertypes.id, assets_fleetodometertypes.name, assets_fleetodometertypes.remarks, assets_fleetodometertypes.ipaddress, assets_fleetodometertypes.createdby, assets_fleetodometertypes.createdon, assets_fleetodometertypes.lasteditedby, assets_fleetodometertypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetodometertypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleetodometertypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetodometertypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Service Mileage : </td>
		<td><input type="text" name="mileage" id="mileage" size="8"  value="<?php echo $obj->mileage; ?>"></td>
	</tr>
	<tr>
		<td align="right">Last Service Mileage : </td>
		<td><input type="text" name="lastservicemileage" id="lastservicemileage" size="8"  value="<?php echo $obj->lastservicemileage; ?>"></td>
	</tr>
	<tr>
		<td align="right">Allocated To : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value="<?php echo $obj->employeename; ?>">
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">HR Department : </td>
			<td><select name="departmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn btn-danger" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
	
	</div>
<?php if(!empty($obj->id)){?>
	    <div id="pane2" class="tab-pane">

<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
		<td align="right"> </td>
			<td><input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"/>
			<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/></td>
		</tr>
		<tr>
		<td align="right">Inspection Item : </td>		
			<td><select name="inspectionitemid" class="selectbox">
<option value="">Select...</option>
<?php
	$inspectionitems=new Inspectionitems();
	$where=" where assets_inspectionitems.categoryid=1 ";
	$fields="assets_inspectionitems.id, assets_inspectionitems.name, assets_inspectionitems.categoryid, assets_inspectionitems.remarks, assets_inspectionitems.ipaddress, assets_inspectionitems.createdby, assets_inspectionitems.createdon, assets_inspectionitems.lasteditedby, assets_inspectionitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$inspectionitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($inspectionitems->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->inspectionitemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	<tr>
		<td align="right"> Value: </td>
		<td><input type="text" name="value" id="value" value="<?php echo $obj->value; ?>"></td>
		
		</tr>
		<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<tr>
		<td align="right">Inspection Date : </td>
		<td><input type="text" name="inspectedon" id="inspectedon" class="date_input" size="12" readonly  value="<?php echo $obj->inspectedon; ?>"></td></tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="<?php echo $obj->actioninspection;?>" name="actioninspection"/>&nbsp;<input type="button" class="btn btn-danger" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
	<table width="75%" class="table table-stripped table-codensed">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Inspection Item</th>
	    <th>Inspection Date</th>
	    <th>Value</th>
	    <th>Remarks</th>
	    <th>&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
	  <?php
	  $i=0;
	  $inspections = new Inspections();
	  $fields=" assets_inspections.value, assets_inspections.remarks, assets_inspections.inspectedon, assets_inspectionitems.name ";
	  $where=" where assets_fleets.id='$obj->id' ";
	  $join=" left join assets_inspectionitems on assets_inspectionitems.id=assets_inspections.inspectionitemid left join assets_assets on assets_assets.id=assets_inspections.assetid left join assets_fleets on assets_fleets.assetid=assets_assets.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $inspections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($row=mysql_fetch_object($inspections->result)){
	  $i++;
	    ?>
	      <tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row->name; ?></td>
		<td><?php echo formatDate($row->inspectedon); ?></td>
		<td><?php echo formatNumber($row->value); ?></td>
		<td><?php echo $row->remarks; ?></td>
		<td>&nbsp;</td>
	      </tr>
	   <?php 
	  }
	  ?>
	</tbody>
	</table>
	</div>
	    <div id="pane3" class="tab-pane">

<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
		<tr>
		<td align="right"> </td>
			<td><input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"/>
			<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/></td>
		</tr>
		<tr>
		<td align="right">Maintenance Date : </td>
		<td><input type="text" name="maintenanceon" id="maintenanceon" class="date_input" size="12" readonly  value="<?php echo $obj->maintenanceon; ?>"></td>
	<tr>
		<td align="right">Start Mileage : </td>
		<td><input type="text" name="startmileage" id="startmileage" size="8"  value="<?php echo $obj->startmileage; ?>"></td>
		</tr>
		<tr>
		<td align="right">End Mileage : </td>
		<td><input type="text" name="endmileage" id="endmileage" size="8"  value="<?php echo $obj->endmileage; ?>"></td>
	<tr>
		<td align="right">Supplier : </td>
			<td><select name="supplierid" class="selectbox">
<option value="">Select...</option>
<?php
	$suppliers=new Suppliers();
	$where="  ";
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($suppliers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->supplierid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td align="right">Purchase Mode : </td>
			<td><select name="purchasemodeid" class="selectbox">
<option value="">Select...</option>
<?php
	$purchasemodes=new Purchasemodes();
	$where="  ";
	$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($purchasemodes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->purchasemodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	<tr>
		<td align="right">Oil Added (Ltrs) : </td>
		<td><input type="text" name="oiladded" id="oiladded" size="8"  value="<?php echo $obj->oiladded; ?>"></td>
		<td align="right">Oil Cost : </td>
		<td><input type="text" name="oilcost" id="oilcost" size="8"  value="<?php echo $obj->oilcost; ?>"></td>
	<tr>
		<td align="right">Fuel Added (Ltrs) : </td>
		<td><input type="text" name="fueladded" id="fueladded" size="8"  value="<?php echo $obj->fueladded; ?>"></td>
		<td align="right">Fuel Cost : </td>
		<td><input type="text" name="fuelcost" id="fuelcost" size="8"  value="<?php echo $obj->fuelcost; ?>"></td>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="<?php echo $obj->actionfleetmaintenance;?>" name="actionfleetmaintenance"/>&nbsp;<input type="button" class="btn btn-danger" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
	<table width="75%" class="table table-stripped table-codensed">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Maintenance Date</th>
	    <th>Start Mileage</th>
	    <th>End Mileage</th>
	    <th>Remarks</th>
	    <th>&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
	  <?php
	  $i=0;
	  $fleetmaintenances = new Fleetmaintenances();
	  $fields=" assets_fleetmaintenances.startmileage, assets_fleetmaintenances.remarks, assets_fleetmaintenances.maintenanceon, assets_fleetmaintenances.endmileage ";
	  $where=" where assets_fleets.id='$obj->id' ";
	  $join=" left join assets_assets on assets_assets.id=assets_fleetmaintenances.assetid left join assets_fleets on assets_fleets.assetid=assets_assets.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $fleetmaintenances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($row=mysql_fetch_object($fleetmaintenances->result)){
	  $i++;
	    ?>
	      <tr>
		<td><?php echo $i; ?></td>
		<td><?php echo formatDate($row->maintenanceon); ?></td>
		<td><?php echo $row->startmileage; ?></td>
		<td><?php echo $row->endmileage; ?></td>
		<td><?php echo $row->remarks; ?></td>
		<td>&nbsp;</td>
	      </tr>
	   <?php 
	  }
	  ?>
	</tbody>
	</table>
	</div>	
	    <div id="pane4" class="tab-pane">

<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
		<td align="right"></td>
		<td>
		<input type="hidden" name="fleetid" id="fleetid" value="<?php echo $obj->fleetid; ?>">
		<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>">
		</td>
	</tr>
	<tr>
		</td>
		<td align="right">Quantity(Ltrs) : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	<tr>
		<td align="right">Cost : </td>
		<td><input type="text" name="cost" id="cost" size="8"  value="<?php echo $obj->cost; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date : </td>
		<td><input type="text" name="fueledon" id="fueledon" class="date_input" size="12" readonly  value="<?php echo $obj->fueledon; ?>"></td>
	<tr>
		<td align="right">Driver : </td>
			<td><input type='text' size='20' name='fuelemployeename' id='fuelemployeename' value="<?php echo $obj->fuelemployeename; ?>">
					<input type="hidden" name='fuelemployeeid' id='fuelemployeeid' value='<?php echo $obj->fuelemployeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Reference No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	<tr>
		<td align="right">Start Odometer Reading : </td>
		<td><input type="text" name="startodometer" id="startodometer" size="8"  value="<?php echo $obj->startodometer; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Odometer : </td>
		<td><input type="text" name="endodometer" id="endodometer" size="8"  value="<?php echo $obj->endodometer; ?>"></td>
	<tr>
		<td align="right">Destination : </td>
		<td><input type="text" name="destination" id="destination" value="<?php echo $obj->destination; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="<?php echo $obj->actionfleetfuelin;?>" name="actionfleetfuelin"/>&nbsp;<input type="button" class="btn btn-danger" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
	<table width="75%" class="table table-stripped table-codensed">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Fueling Date</th>
	    <th>Quantity</th>
	    <th>Destination</th>
	    <th>Remarks</th>
	    <th>&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
	  <?php
	  $i=0;
	  $fleetfueling = new Fleetfueling();
	  $fields=" assets_fleetfueling.destination, assets_fleetfueling.remarks, assets_fleetfueling.fueledon, assets_fleetfueling.quantity ";
	  $where=" where assets_fleetfueling.fleetid='$obj->fleetid' ";
	  $join="  ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $fleetfueling->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($row=mysql_fetch_object($fleetfueling->result)){
	  $i++;
	    ?>
	      <tr>
		<td><?php echo $i; ?></td>
		<td><?php echo formatDate($row->fueledon); ?></td>
		<td><?php echo $row->quantity; ?></td>
		<td><?php echo $row->destination; ?></td>
		<td><?php echo $row->remarks; ?></td>
		<td>&nbsp;</td>
	      </tr>
	   <?php 
	  }
	  ?>
	</tbody>
	</table>
	</div>
	    <div id="pane5" class="tab-pane">

<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
		<td align="right"> </td>
		<td><input type="hidden" name="fleetid" id="fleetid" value="<?php echo $obj->fleetid; ?>">
		<input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"/>
		<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/></td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea><font color='red'>*</font></td>
	<tr>
		<td align="right">Supplier : </td>
		<td>
		<input type="text" name="fleetservicesupplierid" id="fleetservicesupplierid" value="<?php echo $obj->fleetservicesupplierid; ?>">
		<input type="text" name="fleetservicesuppliername" id="fleetservicesuppliername" value="<?php echo $obj->fleetservicesuppliername; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cost : </td>
		<td><input type="text" name="fleetservicecost" id="fleetservicecost" size="8"  value="<?php echo $obj->fleetservicecost; ?>"></td>
	<tr>
		<td align="right">Odometer Reading : </td>
		<td><input type="text" name="odometer" id="odometer" size="8"  value="<?php echo $obj->odometer; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	
	</tr>
	<tr>
<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="<?php echo $obj->action;?>" name="actionfleetservice"/>&nbsp;<input type="button" class="btn btn-danger" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<tr>
	  <td colspan='2'>
	    <table class="table table-stripped">
	      <tr>
		<th>#</th>
		<th>Service Item</th>
		<th>Replaced</th>
		<th>Serial Number</th>
		<th>Remark</th>
	      </tr>
	      
	      
	      
	      
	      
	      <?php
		$fleetserviceitems = new Fleetserviceitems();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$fleetserviceitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$i=0;
		
			$obj->projectreviewdetailstatus="";
			$obj->projectreviewdetailremark="";
			$obj->projectreviewdetailid="";
			
			
		while($row=mysql_fetch_object($fleetserviceitems->result)){
		  $i++;
		
		?>
		  <tr>
		    <td><?php echo $i; ?></td>
		    <td><?php echo $row->name; ?></td>
		    <input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/></td>
		    <input type="hidden" name="fleetid" id="fleetid" value="<?php echo $obj->fleetid; ?>">
		    
		    
		    <td><select name='replaced' class="selectbox">
			  <option value='' <?php if($obj->replaced==''){echo"selected";}?>></option>
			  <option value='Yes' <?php if($obj->replaced=='Yes'){echo"selected";}?>>Yes</option>
			  <option value='No' <?php if($obj->replaced=='No'){echo"selected";}?>>No</option>
			</select>
			</td>
		    <td><input type="text" name="serialnumber" id="serialnumber" value="<?php echo $obj->serialnumber; ?>" /></td>
		    <td><textarea name='remarks'><?php echo $_POST['remarks'];?></textarea></td>
		    <td>
				<?php if($fleetservicedetails->affectedRows>0){?>
				<input type="submit" name="actionfleetservicedetail" value="Update Fleetservicedetail" class="btn-success"/>
				<?php }else{ ?>
				<input type="submit" name="actionfleetservicedetail" value="Save Fleetservicedetail" class="btn btn-primary"/>
				<?php } ?>
				</td>
		  </tr>
		<?php
		}
	      ?>
	    </table>
	  </td>
	</tr>
	
	</table>
	</form>
	</div>
	    <div id="pane6" class="tab-pane">

<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	<tr>
	<td colspan='2'>
	<table>
	<tr>
		<td align="right"></td>
		<td>
		<input type="hidden" name="fleetid" id="fleetid" value="<?php echo $obj->fleetid; ?>">
		<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>">
		</td>
	</tr>
	<tr>
		<td align="right">Driver : </td>
			<td><input type='text' size='20' name='scheduleemployeename' id='scheduleemployeename' value="<?php echo $obj->scheduleemployeename; ?>">
					<input type="hidden" name='scheduleemployeeid' id='scheduleemployeeid' value='<?php echo $obj->scheduleemployeeid; ?>'>
		</td>
	<tr>
		<td align="right">Project : </td>
			<td><select name="projectid" class="selectbox">
<option value="">Select...</option>
<?php
	$projects=new Projects();
	$where="  ";
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.exitclause, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
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
	<tr>
		<td align="right">Source : </td>
		<td><input type="text" name="source" id="source" value="<?php echo $obj->source; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Destination : </td>
		<td><input type="text" name="destination" id="destination" value="<?php echo $obj->destination; ?>"><font color='red'>*</font></td>
	<tr>
		<td align="right">Departure Time : </td>
		<td><input type="text" name="departuretime" id="departuretime" class="date_input" size="18" readonly  value="<?php echo $obj->departuretime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected Arrival Time : </td>
		<td><input type="text" name="expectedarrivaltime" id="expectedarrivaltime" class="date_input" size="18" readonly  value="<?php echo $obj->expectedarrivaltime; ?>"></td>
	<tr>
		<td align="right">Actual Arrival Time : </td>
		<td><input type="text" name="arrivaltime" id="arrivaltime" class="datetimepicker" size="18" readonly  value="<?php echo $obj->arrivaltime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks;te ?></textarea></td>
	
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="<?php echo $obj->actionfleetschedule;?>" name="actionfleetschedule"/>&nbsp;<input type="button" class="btn btn-danger" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
	<table width="75%" class="table table-stripped table-codensed">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Source - Destination</th>
	    <th>Departure Time</th>
	    <th>Expected Arrival Time</th>
	    <th>Arrival Time</th>
	    <th>&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
	  <?php
	  $i=0;
	  $fleetschedules = new Fleetschedules();
	  $fields=" assets_fleetschedules.id, assets_fleetschedules.destination, assets_fleetschedules.remarks, assets_fleetschedules.source, assets_fleetschedules.departuretime, assets_fleetschedules.expectedarrivaltime, assets_fleetschedules.arrivaltime ";
	  $where=" where assets_fleetschedules.assetid='$obj->assetid' ";
	  $join="  ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $fleetschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($row=mysql_fetch_object($fleetschedules->result)){
	  $i++;
	    ?>
	      <tr>
		<td><?php echo $i; ?></td>
		<td><a href="../fleetschedules/addfleetschedules_proc.php?id=<?php echo $row->id; ?>"><?php echo $row->source; ?> - <?php echo $row->destination; ?></a></td>
		<td><?php echo $row->departuretime; ?></td>
		<td><?php echo $row->expectedarrivaltime; ?></td>
		<td><?php echo $row->arrivaltime; ?></td>
		<td>&nbsp;</td>
	      </tr>
	   <?php 
	  }
	  ?>
	</tbody>
	</table>
	</div>
	    <div id="pane7" class="tab-pane">

<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	
	<table width="100%" align="center">
	<tr>
		<td align="right"> </td>
		<td>
		<input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"/>
		<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/></td>
	</tr>
	<tr>
		<td align="right">Breakdown Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea><font color='red'>*</font></td>
	<tr>
		<td align="right">Break Down Date : </td>
		<td><input type="text" name="brokedownon" id="brokedownon" class="date_input" size="12" readonly  value="<?php echo $obj->brokedownon; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Date Of Reactivation : </td>
		<td><input type="text" name="reactivatedon" id="reactivatedon" class="date_input" size="12" readonly  value="<?php echo $obj->reactivatedon; ?>"></td>
	<tr>
		<td align="right">Cost : </td>
		<td><input type="text" name="cost" id="cost" size="8"  value="<?php echo $obj->cost; ?>"></td>
	</tr>
	<tr>
		<td align="right">Ref. # : </td>
		<td><input type="text" name="refno" id="refno" value="<?php echo $obj->refno; ?>"></td>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<form class="forms" id="theform" action="addfleets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	</tr>
	<tr>
		<td colspan="2" align="center">
		<input type="submit" class="btn btn-primary" value="Add Breakdown" name="action">
		
		&nbsp;<input type="button" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
</form>
	</div>
	<div id="pane8" class="tab-pane">
<form class="forms" id="theform" action="addassets_proc.php" name="assets" method="POST" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	
	<tr>
		<td align="right"> </td>
<input type='hidden' name='assetid' value='<?php echo $obj->assetid; ?>'/>
<input type='hidden' name='id' value='<?php echo $obj->id; ?>'/>
		</td>
	</tr>
	<tr>
		<td align="right">Insurer : </td>
			<td><select name="insurerid" class="selectbox">
<option value="">Select...</option>
<?php
	$insurers=new Insurers();
	$where="  ";
	$fields="assets_insurers.id, assets_insurers.name, assets_insurers.physicaladdress, assets_insurers.contactperson, assets_insurers.contacttel, assets_insurers.remarks, assets_insurers.ipaddress, assets_insurers.createdby, assets_insurers.createdon, assets_insurers.lasteditedby, assets_insurers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$insurers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($insurers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->insurerid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Ref. # : </td>
		<td><input type="text" name="refno" id="refno" value="<?php echo $obj->refno; ?>"></td>
	<tr>
		<td align="right">Insurance Date : </td>
		<td><input type="text" name="insuredon" id="insuredon" class="date_input" size="12" readonly  value="<?php echo $obj->insuredon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Scanned Copy : </td>
		<td><input type="file" name="file" id="file" value="<?php echo $obj->file; ?>"></td>
	<tr>
		<td align="right">Expiry Date : </td>
		<td><input type="text" name="expireson" id="expireson" class="date_input" size="12" readonly  value="<?php echo $obj->expireson; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</table>
	</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input name="actioninsurance" type="submit" class="btn btn-primary" value="<?php echo $obj->actioninsurance;?>" name="actioninsurance"/>&nbsp;<input name="actioninsurance" type="button" class="btn btn-danger" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
	</div>
	
<?php } if(!empty($obj->id)){?>
<div id="pane9" class="tab-pane">
<form class="forms" id="theform" action="addassets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
<table align='center' width="100%">
			<tr>
				<td>&nbsp;</td>
				<td valign="bottom"><input type="hidden" name="assetid" value="<?php echo $obj->assetid; ?>"/></td>
				<td valign="bottom">Consumable Name : <select name='assetconsumablesconsumableid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$consumables=new Consumables();
				$fields="assets_consumables.id, assets_consumables.name, assets_consumables.categoryid, assets_consumables.remarks, assets_consumables.ipaddress, assets_consumables.createdby, assets_consumables.createdon, assets_consumables.lasteditedby, assets_consumables.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$consumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($consumables->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->consumableid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Serial No : <input type="text" name="assetconsumablesserialno" size="6" ></td>
				<td valign="bottom">Fitted On : <input type="text" name="assetconsumablesfittedon" size="12" class="date_input"></td>
				<td valign="bottom">Start Mileage : <input type="text" name="assetconsumablesstartmileage" size="12" ></td>
				<td valign="bottom">Current Mileage : <input type="text" name="assetconsumablescurrentmileage" size="12" ></td>
				<td valign="bottom">Remarks : <textarea name="assetconsumablesremarks"><?php echo $obj->assetconsumablesremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Assetconsumable" name="action"></td>
			</tr>
<?php
		$assetconsumables=new Assetconsumables();
		$i=0;
		$fields="assets_assetconsumables.id, assets_assets.name as assetid, assets_consumables.name as consumableid, assets_assetconsumables.serialno, assets_assetconsumables.fittedon, assets_assetconsumables.startmileage, assets_assetconsumables.currentmileage, assets_assetconsumables.remarks, assets_assetconsumables.ipaddress, assets_assetconsumables.createdby, assets_assetconsumables.createdon, assets_assetconsumables.lasteditedby, assets_assetconsumables.lasteditedon";
		$join=" left join assets_assets on assets_assetconsumables.assetid=assets_assets.id  left join assets_consumables on assets_assetconsumables.consumableid=assets_consumables.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where assets_assetconsumables.assetid='$obj->id'";
		$assetconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$assetconsumables->affectedRows;
		$res=$assetconsumables->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->assetid; ?></td>
				<td><?php echo $row->consumableid; ?></td>
				<td><?php echo $row->serialno; ?></td>
				<td><?php echo $row->fittedon; ?></td>
				<td><?php echo $row->startmileage; ?></td>
				<td><?php echo $row->currentmileage; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addassets_proc.php?id=<?php echo $obj->id; ?>&assetconsumables=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>

</div>
<? } ?>
</div>
</div>
<?php 

include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>