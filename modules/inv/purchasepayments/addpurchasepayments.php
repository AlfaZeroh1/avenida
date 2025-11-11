<title>WiseDigits ERP: Purchasepayments </title>
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
<form  id="theform" action="addpurchasepayments_proc.php" name="purchasepayments" method="POST" enctype="multipart/form-data">
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
		<td align="right">Supplier : </td>
		<td><input type="text" name="supplierid" id="supplierid" value="<?php echo $obj->supplierid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mode Of Payment : </td>
		<td><input type="text" name="paymentmodeid" id="paymentmodeid" value="<?php echo $obj->paymentmodeid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Bank : </td>
		<td><input type="text" name="bank" id="bank" value="<?php echo $obj->bank; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cheque No. : </td>
		<td><input type="text" name="chequeno" id="chequeno" value="<?php echo $obj->chequeno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Payment Date : </td>
		<td><input type="text" name="paymentdate" id="paymentdate" class="date_input" size="12" readonly  value="<?php echo $obj->paymentdate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Offset : </td>
		<td><input type="text" name="offsetid" id="offsetid" value="<?php echo $obj->offsetid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Document No. : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"><font color='red'>*</font></td>
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