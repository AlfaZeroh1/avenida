<title>WiseDigits ERP: Fleetmaintenances </title>
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
<form class="forms" id="theform" action="addfleetmaintenances_proc.php" name="fleetmaintenances" method="POST" enctype="multipart/form-data">
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
		<td align="right">Maintenance Date : </td>
		<td><input type="text" name="maintenanceon" id="maintenanceon" class="date_input" size="12" readonly  value="<?php echo $obj->maintenanceon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Mileage : </td>
		<td><input type="text" name="startmileage" id="startmileage" size="8"  value="<?php echo $obj->startmileage; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Mileage : </td>
		<td><input type="text" name="endmileage" id="endmileage" size="8"  value="<?php echo $obj->endmileage; ?>"></td>
	</tr>
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
	</tr>
	<tr>
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
	</tr>
	<tr>
		<td align="right">Oil Added (Ltrs) : </td>
		<td><input type="text" name="oiladded" id="oiladded" size="8"  value="<?php echo $obj->oiladded; ?>"></td>
	</tr>
	<tr>
		<td align="right">Oil Cost : </td>
		<td><input type="text" name="oilcost" id="oilcost" size="8"  value="<?php echo $obj->oilcost; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fuel Added (Ltrs) : </td>
		<td><input type="text" name="fueladded" id="fueladded" size="8"  value="<?php echo $obj->fueladded; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fuel Cost : </td>
		<td><input type="text" name="fuelcost" id="fuelcost" size="8"  value="<?php echo $obj->fuelcost; ?>"></td>
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