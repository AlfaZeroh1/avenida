<title>WiseDigits ERP: Assets </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierid").val(ui.item.id);
	}
  });

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

});
</script>
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

<div class="container" style="margin-top:;">
<div class="tabbable">

<ul class="nav nav-tabs">
		<li><a href="#pane1" data-toggle="tab">DETAILS</a></li>
		<li><a href="#pane2" data-toggle="tab">INSPECTIONS</a></li>
		<li><a href="#pane3" data-toggle="tab">INSURANCE</a></li>
		<li><a href="#pane4" data-toggle="tab">BREAKDOWNS</a></li>
		<li><a href="#pane5" data-toggle="tab">MAINTAINANCE SCHEDULES</a></li>
		<li><a href="#pane6" data-toggle="tab">MAINTAINANCES</a></li>
		<li><a href="#pane7" data-toggle="tab">CONSUMABLES</a></li>
	</ul>
	<div class="tab-content">
    <div id="pane1" class="tab-pane active">
<form class="forms" id="theform" action="addassets_proc.php" name="assets" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<input type="hidden" name="equip" id="equip" value="<?php echo $obj->equip; ?>"></td>
	</tr>
	<tr>
		<td align="right">Equipment : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Photo : </td>
		<td><input type="file" name="photo" id="photo" value="<?php echo $obj->photo; ?>"></td>
	</tr>
	<tr>
		<td align="right">Invoice No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Asset Category : </td>
			<td><select name="categoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$categorys=new Categorys();
	if(!empty($obj->equip))
	  $where=" where id not in(1) ";
	else
	  $where="  ";
	$fields="assets_categorys.id, assets_categorys.name, assets_categorys.timemethod, assets_categorys.noofdepr, assets_categorys.endingdate, assets_categorys.periodlength, assets_categorys.computationmethod, assets_categorys.degressivefactor, assets_categorys.firstentry, assets_categorys.ipaddress, assets_categorys.createdby, assets_categorys.createdon, assets_categorys.lasteditedby, assets_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($categorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
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
		<td align="right">Employee : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value="<?php echo $obj->employeename; ?>">
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Gross Value : </td>
		<td><input type="text" name="value" id="value" size="8"  value="<?php echo $obj->value; ?>"></td>
	</tr>
	<tr>
		<td align="right">Salvage Value : </td>
		<td><input type="text" name="salvagevalue" id="salvagevalue" size="8"  value="<?php echo $obj->salvagevalue; ?>"></td>
	</tr>
	<tr>
		<td align="right">Purchase Date : </td>
		<td><input type="text" name="purchasedon" id="purchasedon" class="date_input" size="12" readonly  value="<?php echo $obj->purchasedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Supplier : </td>
			<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
			<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">LPO No : </td>
		<td><input type="text" name="lpono" id="lpono" value="<?php echo $obj->lpono; ?>"></td>
	</tr>
	<tr>
		<td align="right">Delivery Note No : </td>
		<td><input type="text" name="deliveryno" id="deliveryno" value="<?php echo $obj->deliveryno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Memo : </td>
		<td><textarea name="memo"><?php echo $obj->memo; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn btn-danger" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
</div>

<?php if(!empty($obj->id)){?>
<div id="pane3" class="tab-pane">
<form class="forms" id="theform" action="addassets_proc.php" name="assets" method="POST" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	
	<tr>
		<td align="right"> </td>
<input type='hidden' name='assetid' value='<?php echo $obj->assetid; ?>'/>
<input type='hidden' name='id' value='<?php echo $obj->id; ?>'/>
		</td>
	</tr>
	<tr>
		<td align="right">Insur<?php if(!empty($obj->id)){?>
<div id="pane3" class="tab-pane">er : </td>
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
	<tr>
		<td align="right">Insur. Company : </td>
		<td><input type="text" name="insurcompany" id="insurcompany" value="<?php echo $obj->insurcompany; ?>"></td>
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
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="<?php echo $obj->actioninsurance;?>" name="actioninsurance"/>&nbsp;<input type="button" class="btn btn-danger" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
	</div>
	<div id="pane2" class="tab-pane">

<form class="forms" id="theform" action="addassets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	<table width="100%" align="center">
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
	$where=" where assets_inspectionitems.categoryid!=1 ";
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
<?php } if(!empty($obj->id)){?>
<div id="pane4" class="tab-pane">

<form class="forms" id="theform" action="addassets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	
	<table width="100%" align="center">
	<tr>
		<td align="right"> </td>
		<td><input type="text" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"/>
		<input type="text" name="id" id="id" value="<?php echo $obj->id; ?>"/></td>
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
	<form class="forms" id="theform" action="addassets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
	</tr>
	<tr>
		<td colspan="2" align="center">
		<input type="submit" class="btn btn-primary" value="Add Breakdown" name="action">
		
		&nbsp;<input type="button" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
</form>
</div>

<?php } if(!empty($obj->id)){?>

<div id="pane5" class="tab-pane">
<form class="forms" id="theform" action="addassets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
<table align='center' width="100%">
			<tr>
			
				<td align="right">Maintainance Type : </td><td><input type="hidden" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"/>
			<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/><select name='maintenanceschedulesmaintenancetypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$maintenancetypes=new Maintenancetypes();
				$fields="assets_maintenancetypes.id, assets_maintenancetypes.name, assets_maintenancetypes.duration, assets_maintenancetypes.durationtype, assets_maintenancetypes.remarks, assets_maintenancetypes.ipaddress, assets_maintenancetypes.createdby, assets_maintenancetypes.createdon, assets_maintenancetypes.lasteditedby, assets_maintenancetypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$maintenancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($maintenancetypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->maintenancetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Next Inspection :</td><td> <input type="text" readonly class="date_input" name="maintenanceschedulesnextinspection" size="12" ></td></tr><tr>
				<td align="right">Remarks :</td><td> <textarea name="maintenanceschedulesremarks"><?php echo $obj->maintenanceschedulesremarks; ?></textarea></td></tr><tr>
				<td colspan="2" align="center"><input type="submit" class="btn btn-primary" value="Add Maintenanceschedule" name="action"></td>
			</tr>
	</table>
<table class="table table-stripped">
<?php
		$maintenanceschedules=new Maintenanceschedules();
		$i=0;
		$fields="assets_maintenanceschedules.id, assets_maintenancetypes.name as maintenancetypeid, assets_assets.name as assetid, assets_maintenanceschedules.nextinspection, assets_maintenanceschedules.remarks, assets_maintenanceschedules.ipaddress, assets_maintenanceschedules.createdby, assets_maintenanceschedules.createdon, assets_maintenanceschedules.lasteditedby, assets_maintenanceschedules.lasteditedon";
		$join=" left join assets_maintenancetypes on assets_maintenanceschedules.maintenancetypeid=assets_maintenancetypes.id  left join assets_assets on assets_maintenanceschedules.assetid=assets_assets.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where assets_maintenanceschedules.assetid='$obj->id'";
		$maintenanceschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$maintenanceschedules->affectedRows;
		$res=$maintenanceschedules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->maintenancetypeid; ?></td>
				<td><?php echo $row->assetid; ?></td>
				<td><?php echo $row->nextinspection; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addassets_proc.php?id=<?php echo $obj->id; ?>&maintenanceschedules=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
</form>
</div>
<?php } if(!empty($obj->id)){?>
<div id="pane7" class="tab-pane">
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

<?php } if(!empty($obj->id)){?>
<div id="pane6" class="tab-pane">
<form class="forms" id="theform" action="addassets_proc.php" name="fleets" method="POST" enctype="multipart/form-data">
<table align='center' width="100%">
			<tr>
				<td><?php echo $obj->assetid; ?></td>
				<td align="right">Maintainance Type :</td><td> <input type="text" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"/>
			<input type="text" name="id" id="id" value="<?php echo $obj->id; ?>"/><select name='maintenancesmaintenancetypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$maintenancetypes=new Maintenancetypes();
				$fields="assets_maintenancetypes.id, assets_maintenancetypes.name, assets_maintenancetypes.duration, assets_maintenancetypes.durationtype, assets_maintenancetypes.remarks, assets_maintenancetypes.ipaddress, assets_maintenancetypes.createdby, assets_maintenancetypes.createdon, assets_maintenancetypes.lasteditedby, assets_maintenancetypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$maintenancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($maintenancetypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->maintenancetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><!--<tr>
				<td align="right">Asset :</td><td> <input type="text" name="maintenancesassetid" size="20" ></td></tr><tr>-->
				<td align="right">Date Maintained : </td><td><input type="text" name="maintenancesmaintainedon" size="20" class="date_input"></td></tr><tr>
				<td align="right">Done By :</td><td> <textarea name="maintenancesdoneby"><?php echo $obj->maintenancesdoneby; ?></textarea></td></tr><tr>
				<td align="right">Remarks :</td><td> <textarea name="maintenancesremarks"><?php echo $obj->maintenancesremarks; ?></textarea></td></tr><tr>
				<td align="right"><input class="btn btn-primary" type="submit" value="Add Maintenance" name="action"></td>
			</tr>
</table>
<table class="table table-stripped">
<?php
		$maintenances=new Maintenances();
		$i=0;
		$fields="assets_maintenances.id, assets_maintenancetypes.name as maintenancetypeid, assets_assets.name as assetid, assets_maintenances.maintainedon, assets_maintenances.doneby, assets_maintenances.remarks, assets_maintenances.ipaddress, assets_maintenances.createdby, assets_maintenances.createdon, assets_maintenances.lasteditedby, assets_maintenances.lasteditedon";
		$join=" left join assets_maintenancetypes on assets_maintenances.maintenancetypeid=assets_maintenancetypes.id  left join assets_assets on assets_maintenances.assetid=assets_assets.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where assets_maintenances.assetid='$obj->id'";
		$maintenances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$maintenances->affectedRows;
		$res=$maintenances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->maintenancetypeid; ?></td>
				<td><?php echo $row->assetid; ?></td>
				<td><?php echo $row->maintainedon; ?></td>
				<td><?php echo $row->doneby; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addassets_proc.php?id=<?php echo $obj->id; ?>&maintenances=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>

</div>
<?php } } ?>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>