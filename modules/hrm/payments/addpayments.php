<title>WiseDigits: Payments </title>
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

<form action="addpayments_proc.php" name="payments" method="POST"  enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>   
        </td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
		<td><input type="text" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mode Of Payment : </td>
		<td><input type="text" name="paymentmodeid" id="paymentmodeid" value="<?php echo $obj->paymentmodeid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Assignment : </td>
		<td><input type="text" name="assignmentid" id="assignmentid" value="<?php echo $obj->assignmentid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bank : </td>
		<td><input type="text" name="bank" id="bank" value="<?php echo $obj->bank; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bank Acc. : </td>
		<td><input type="text" name="bankacc" id="bankacc" value="<?php echo $obj->bankacc; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
	</tr>
	<tr>
		<td align="right">Month : </td>
		<td><input type="text" name="month" id="month" value="<?php echo $obj->month; ?>"></td>
	</tr>
	<tr>
		<td align="right">Gross : </td>
		<td><input type="text" name="gross" id="gross" size="8"  value="<?php echo $obj->gross; ?>"></td>
	</tr>
	<tr>
		<td align="right">PAYE : </td>
		<td><input type="text" name="paye" id="paye" size="8"  value="<?php echo $obj->paye; ?>"></td>
	</tr>
	<tr>
		<td align="right">Pay Date : </td>
		<td><input type="text" name="paydate" id="paydate" class="date_input" size="12" readonly  value="<?php echo $obj->paydate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Days : </td>
		<td><input type="text" name="days" id="days" value="<?php echo $obj->days; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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