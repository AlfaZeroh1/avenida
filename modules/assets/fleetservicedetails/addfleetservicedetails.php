<title>WiseDigits ERP: Fleetservicedetails </title>
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
<form class="forms" id="theform" action="addfleetservicedetails_proc.php" name="fleetservicedetails" method="POST" enctype="multipart/form-data">
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
		<td align="right">Fleet Service : </td>
			<td><select name="fleetserviceid" class="selectbox">
<option value="">Select...</option>
<?php
	$fleetservices=new Fleetservices();
	$where="  ";
	$fields="assets_fleetservices.id, assets_fleetservices.fleetid, assets_fleetservices.description, assets_fleetservices.supplierid, assets_fleetservices.cost, assets_fleetservices.odometer, assets_fleetservices.remarks, assets_fleetservices.ipaddress, assets_fleetservices.createdby, assets_fleetservices.createdon, assets_fleetservices.lasteditedby, assets_fleetservices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleetservices->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetserviceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Service Item : </td>
			<td><select name="fleetserviceitemid" class="selectbox">
<option value="">Select...</option>
<?php
	$fleetserviceitems=new Fleetserviceitems();
	$where="  ";
	$fields="assets_fleetserviceitems.id, assets_fleetserviceitems.name, assets_fleetserviceitems.remarks, assets_fleetserviceitems.ipaddress, assets_fleetserviceitems.createdby, assets_fleetserviceitems.createdon, assets_fleetserviceitems.lasteditedby, assets_fleetserviceitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetserviceitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleetserviceitems->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetserviceitemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Replaced : </td>
		<td><select name='replaced' class="selectbox">
			<option value='' <?php if($obj->replaced==''){echo"selected";}?>></option>
			<option value='Yes' <?php if($obj->replaced=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->replaced=='No'){echo"selected";}?>>No</option>
		</select></td>
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