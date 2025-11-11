<title>WiseDigits ERP: Assetconsumables </title>
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
<form class="forms" id="theform" action="addassetconsumables_proc.php" name="assetconsumables" method="POST" enctype="multipart/form-data">
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
	$where="  ";
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.departmentid, assets_assets.employeeid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
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
		<td align="right">Consumable : </td>
			<td><select name="consumableid" class="selectbox">
<option value="">Select...</option>
<?php
	$consumables=new Consumables();
	$where="  ";
	$fields="assets_consumables.id, assets_consumables.name, assets_consumables.categoryid, assets_consumables.remarks, assets_consumables.ipaddress, assets_consumables.createdby, assets_consumables.createdon, assets_consumables.lasteditedby, assets_consumables.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$consumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($consumables->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->consumableid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Serial No : </td>
		<td><input type="text" name="serialno" id="serialno" value="<?php echo $obj->serialno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Date : </td>
		<td><input type="text" name="fittedon" id="fittedon" class="date_input" size="12" readonly  value="<?php echo $obj->fittedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Mileage : </td>
		<td><input type="text" name="startmileage" id="startmileage" size="8"  value="<?php echo $obj->startmileage; ?>"></td>
	</tr>
	<tr>
		<td align="right">Current Mileage : </td>
		<td><input type="text" name="currentmileage" id="currentmileage" size="8"  value="<?php echo $obj->currentmileage; ?>"></td>
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