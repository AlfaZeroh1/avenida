<title>WiseDigits: Managementfees </title>
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

<form action="addmanagementfees_proc.php" name="managementfees" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Tenant/Landlord : </td>
		<td><input type="text" name="clientid" id="clientid" value="<?php echo $obj->clientid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Client Type : </td>
		<td><select name='clienttype'>
			<option value='Tenant' <?php if($obj->clienttype=='Tenant'){echo"selected";}?>>Tenant</option>
			<option value='Landlord' <?php if($obj->clienttype=='Landlord'){echo"selected";}?>>Landlord</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Payment Term : </td>
		<td><input type="text" name="paymenttermid" id="paymenttermid" value="<?php echo $obj->paymenttermid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Perc : </td>
		<td><input type="text" name="perc" id="perc" size="8"  value="<?php echo $obj->perc; ?>"></td>
	</tr>
	<tr>
		<td align="right">VAT Class : </td>
		<td><input type="text" name="vatclasseid" id="vatclasseid" value="<?php echo $obj->vatclasseid; ?>"></td>
	</tr>
	<tr>
		<td align="right">VAT Amount : </td>
		<td><input type="text" name="vatamount" id="vatamount" size="8"  value="<?php echo $obj->vatamount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Total : </td>
		<td><input type="text" name="total" id="total" size="8"  value="<?php echo $obj->total; ?>"></td>
	</tr>
	<tr>
		<td align="right">Month : </td>
		<td><input type="text" name="month" id="month" value="<?php echo $obj->month; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
	</tr>
	<tr>
		<td align="right">Charged On : </td>
		<td><input type="text" name="chargedon" id="chargedon" class="date_input" size="12" readonly  value="<?php echo $obj->chargedon; ?>"></td>
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
if(!empty($error)){
	showError($error);
}
?>