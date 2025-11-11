<title>WiseDigits ERP: Serviceschedules </title>
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
<form class="forms" id="theform" action="addserviceschedules_proc.php" name="serviceschedules" method="POST" enctype="multipart/form-data">
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
	$where=" where assets_assets.categoryid not in(1)  ";
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
		<td align="right">Service Date : </td>
		<td><input type="text" name="servicedate" id="servicedate" class="date_input" size="12" readonly  value="<?php echo $obj->servicedate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Service Type : </td>
			<td><select name="servicetypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$servicetypes=new Servicetypes();
	$where="  ";
	$fields="assets_servicetypes.id, assets_servicetypes.name, assets_servicetypes.duration, assets_servicetypes.durationtype, assets_servicetypes.remarks, assets_servicetypes.ipaddress, assets_servicetypes.createdby, assets_servicetypes.createdon, assets_servicetypes.lasteditedby, assets_servicetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$servicetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($servicetypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->servicetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Recommendations : </td>
		<td><textarea name="recommendations"><?php echo $obj->recommendations; ?></textarea></td>
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