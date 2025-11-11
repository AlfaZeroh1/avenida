<title>WiseDigits ERP: Tschedulesexpenses </title>
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
<form  id="theform" action="addtschedulesexpenses_proc.php" name="tschedulesexpenses" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="id" id="id" value="<?php echo $obj->id; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Schedule Id : </td>
		<td><input type="text" name="tscheduleid" id="tscheduleid" value="<?php echo $obj->tscheduleid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expense Id : </td>
		<td><input type="text" name="expenseid" id="expenseid" value="<?php echo $obj->expenseid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Paid Thro : </td>
		<td><input type="text" name="paidthru" id="paidthru" value="<?php echo $obj->paidthru; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bank Id : </td>
		<td><input type="text" name="bankid" id="bankid" value="<?php echo $obj->bankid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cheque No. : </td>
		<td><input type="text" name="chequeno" id="chequeno" value="<?php echo $obj->chequeno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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