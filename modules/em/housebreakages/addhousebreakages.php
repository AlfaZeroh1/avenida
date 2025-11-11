<title>WiseDigits: Housebreakages </title>
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

<form class="forms" action="addhousebreakages_proc.php" name="housebreakages" method="POST" enctype="multipart/form-data">
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
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
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
			<td><select class="selectbox" name="tenantid">
<option value="">Select...</option>
<?php
	$tenants=new Tenants();
	$where="  ";
	$fields="em_tenants.id, em_tenants.code, em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.nationalityid, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($tenants->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tenantid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Breakage : </td>
		<td><textarea name="breakage"><?php echo $obj->breakage; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Already Fixed? : </td>
		<td><select class="selectbox" name='fixed'>
			<option value='Yes' <?php if($obj->fixed=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->fixed=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Cost : </td>
		<td><input type="text" name="cost" id="cost" size="8"  value="<?php echo $obj->cost; ?>"></td>
	</tr>
	<tr>
		<td align="right">Paid By Tenant : </td>
		<td><select class="selectbox" name='paidbytenant'>
			<option value='Yes' <?php if($obj->paidbytenant=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->paidbytenant=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
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