<title>WiseDigits: Employeepayments </title>
<?php 
include "../../../headerpop.php";

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

<form action="addemployeepayments_proc.php" name="employeepayments" method="POST"  enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
         <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
		<td><input type="text" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Assignment : </td>
		<td><input type="text" name="assignmentid" id="assignmentid" value="<?php echo $obj->assignmentid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="paymentmodeid" id="paymentmodeid" value="<?php echo $obj->paymentmodeid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Paying Bank : </td>
		<td><input type="text" name="bankid" id="bankid" value="<?php echo $obj->bankid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bank (if Paid Via Bank) : </td>
		<td><input type="text" name="employeebankid" id="employeebankid" value="<?php echo $obj->employeebankid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bank Branch : </td>
		<td><input type="text" name="bankbrancheid" id="bankbrancheid" value="<?php echo $obj->bankbrancheid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bank Account : </td>
		<td><input type="text" name="bankacc" id="bankacc" value="<?php echo $obj->bankacc; ?>"></td>
	</tr>
	<tr>
		<td align="right">Clearing Code : </td>
		<td><input type="text" name="clearingcode" id="clearingcode" value="<?php echo $obj->clearingcode; ?>"></td>
	</tr>
	<tr>
		<td align="right">Reference : </td>
		<td><input type="text" name="ref" id="ref" value="<?php echo $obj->ref; ?>"></td>
	</tr>
	<tr>
		<td align="right">Month : </td>
		<td><input type="text" name="month" id="month" value="<?php echo $obj->month; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" name="year" id="year" value="<?php echo $obj->year; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Basic : </td>
		<td><input type="text" name="basic" id="basic" size="8"  value="<?php echo $obj->basic; ?>"></td>
	</tr>
	<tr>
		<td align="right">Paid On : </td>
		<td><input type="text" name="paidon" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"><font color='red'>*</font></td>
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