<?php 
$pop=1;
include "../../../head.php";

?>
<title>WiseDigits: Stocktrack</title>
<form action="addstocktrack_proc.php" name="stocktrack" method="POST">
<table align="center">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Item: </td>
		<td><input type="text" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">IPAddress: </td>
		<td><input type="text" name="tid" id="tid" value="<?php echo $obj->tid; ?>"></td>
	</tr>
	<tr>
		<td align="right">BatchNo: </td>
		<td><input type="text" name="batchno" id="batchno" value="<?php echo $obj->batchno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Quantity: </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo formatNumber($obj->quantity); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="costprice" id="costprice" size="8"  value="<?php echo formatNumber($obj->costprice); ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="value" id="value" size="8"  value="<?php echo formatNumber($obj->value); ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="discount" id="discount" size="8"  value="<?php echo formatNumber($obj->discount); ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="tradeprice" id="tradeprice" size="8"  value="<?php echo formatNumber($obj->tradeprice); ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="retailprice" id="retailprice" size="8"  value="<?php echo formatNumber($obj->retailprice); ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="applicabletax" id="applicabletax" size="8"  value="<?php echo formatNumber($obj->applicabletax); ?>"></td>
	</tr>
	<tr>
		<td align="right">ExpiryDate: </td>
		<td><input type="text" name="expirydate" id="expirydate" class="date_input" size="12" readonly  value="<?php echo $obj->expirydate; ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="recorddate" id="recorddate" class="date_input" size="12" readonly  value="<?php echo $obj->recorddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">TakesValue1IfNotSold,2IfNotAllSold,And3IfAllSold: </td>
		<td><input type="text" name="status" id="status" value="<?php echo $obj->status; ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="remain" id="remain" size="8"  value="<?php echo formatNumber($obj->remain); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Transaction: </td>
		<td><input type="text" name="transaction" id="transaction" value="<?php echo $obj->transaction; ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="ipaddress" id="ipaddress" value="<?php echo $obj->ipaddress; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>