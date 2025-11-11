<title>WiseDigits: Patientotherservices </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<form action="addpatientotherservices_proc.php" name="patientotherservices" class="forms" method="POST" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="patienttreatmentid" id="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Service : </td>
			<td><select name="otherserviceid">
<option value="">Select...</option>
<?php
	$otherservices=new Otherservices();
	$where="  ";
	$fields="hos_otherservices.id, hos_otherservices.name, hos_otherservices.charge, hos_otherservices.createdby, hos_otherservices.createdon, hos_otherservices.lasteditedby, hos_otherservices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$otherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($otherservices->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->otherserviceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Charge : </td>
		<td><input type="text" name="charge" id="charge" size="8"  value="<?php echo formatNumber($obj->charge); ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->id)){?> 
	<tr>
		<td colspan="2" align="center">
		</td>
	</tr>
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>