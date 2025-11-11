<title>WiseDigits: Stocktrack </title>
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
<form class="forms" id="theform" action="addstocktrack_proc.php" name="stocktrack" method="POST" enctype="multipart/form-data">
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
		<td align="right">Item : </td>
		<td><input type="text" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Item Name : </td>
		<td><input type="text" name="tid" id="tid" value="<?php echo $obj->tid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Document No. : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Batch No. : </td>
		<td><input type="text" name="batchno" id="batchno" value="<?php echo $obj->batchno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Cost Price : </td>
		<td><input type="text" name="costprice" id="costprice" size="8"  value="<?php echo $obj->costprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Value : </td>
		<td><input type="text" name="value" id="value" size="8"  value="<?php echo $obj->value; ?>"></td>
	</tr>
	<tr>
		<td align="right">Discount : </td>
		<td><input type="text" name="discount" id="discount" size="8"  value="<?php echo $obj->discount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Trade Price : </td>
		<td><input type="text" name="tradeprice" id="tradeprice" size="8"  value="<?php echo $obj->tradeprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Retail Price : </td>
		<td><input type="text" name="retailprice" id="retailprice" size="8"  value="<?php echo $obj->retailprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Tax : </td>
		<td><input type="text" name="applicabletax" id="applicabletax" size="8"  value="<?php echo $obj->applicabletax; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="expirydate" id="expirydate" class="date_input" size="12" readonly  value="<?php echo $obj->expirydate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="recorddate" id="recorddate" class="date_input" size="12" readonly  value="<?php echo $obj->recorddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><input type="text" name="status" id="status" value="<?php echo $obj->status; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remain : </td>
		<td><input type="text" name="remain" id="remain" size="8"  value="<?php echo $obj->remain; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Transaction : </td>
		<td><input type="text" name="transaction" id="transaction" value="<?php echo $obj->transaction; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="ipaddress" id="ipaddress" value="<?php echo $obj->ipaddress; ?>"></td>
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