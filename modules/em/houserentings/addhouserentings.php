<title>WiseDigits: Houserentings </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#tenantname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=tenants&field=concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#tenantid").val(ui.item.id);
	}
  });

});
</script>
<form class="forms" action="addhouserentings_proc.php" name="houserentings" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">House : </td>
			<td><select class="selectbox" name="houseid">
<option value="">Select...</option>
<?php
	$houses=new Houses();
	$where="  ";
	$fields="em_houses.id, concat(em_houses.hseno,' - ',em_houses.hsecode) name, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($houses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->houseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Tenant : </td>
			<td><input type='text' size='20' name='tenantname' id='tenantname' value='<?php echo $obj->tenantname; ?>'>
			<input type="hidden" name='tenantid' id='tenantid' value='<?php echo $obj->tenantid; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Rental Type : </td>
			<td><select class="selectbox" name="rentaltypeid">
<option value="">Select...</option>
<?php
	$rentaltypes=new Rentaltypes();
	$where="  ";
	$fields="em_rentaltypes.id, em_rentaltypes.name, em_rentaltypes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentaltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($rentaltypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->rentaltypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Date Occupied : </td>
		<td><input type="text" name="occupiedon" id="occupiedon" class="date_input" size="12" readonly  value="<?php echo $obj->occupiedon; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Vacated On : </td>
		<td><input type="text" name="vacatedon" id="vacatedon" class="date_input" size="12" readonly  value="<?php echo $obj->vacatedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Lease Starts : </td>
		<td><input type="text" name="leasestarts" id="leasestarts" class="date_input" size="12" readonly  value="<?php echo $obj->leasestarts; ?>"></td>
	</tr>
	<tr>
		<td align="right">Renew Every (Months) : </td>
		<td><input type="text" name="renewevery" id="renewevery" value="<?php echo $obj->renewevery; ?>"></td>
	</tr>
	<tr>
		<td align="right">Lease Ends : </td>
		<td><input type="text" name="leaseends" id="leaseends" class="date_input" size="12" readonly  value="<?php echo $obj->leaseends; ?>"></td>
	</tr>
	<tr>
		<td align="right">Increase Type : </td>
		<td><select class="selectbox" name='increasetype'>
			<option value='' <?php if($obj->increasetype==''){echo"selected";}?>></option>
			<option value='%' <?php if($obj->increasetype=='%'){echo"selected";}?>>%</option>
			<option value='Amount' <?php if($obj->increasetype=='Amount'){echo"selected";}?>>Amount</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Increase By : </td>
		<td><input type="text" name="increaseby" id="increaseby" size="8"  value="<?php echo $obj->increaseby; ?>"></td>
	</tr>
	<tr>
		<td align="right">Increase Every (Months) : </td>
		<td><input type="text" name="increaseevery" id="increaseevery" value="<?php echo $obj->increaseevery; ?>"></td>
	</tr>
	<tr>
		<td align="right">Rent Due Date (Every Month/quarter) : </td>
		<td><input type="text" name="rentduedate" id="rentduedate" value="<?php echo $obj->rentduedate; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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