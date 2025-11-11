<?php 
$pop=1;
include "../../../head.php";

?>
<title>WiseDigits: Items</title>
<form action="additems_proc.php" name="items" method="POST">
<table align="center">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Code: </td>
		<td><input type="text" name="code" id="code" value="<?php echo $obj->code; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name: </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"></td>
	</tr>
	<tr>
		<td align="right">Manufacturer: </td>
		<td><input type="text" name="manufacturer" id="manufacturer" size="45"  value="<?php echo $obj->manufacturer; ?>"></td>
	</tr>
	<tr>
		<td align="right">Strength: </td>
		<td><input type="text" name="strength" id="strength" value="<?php echo $obj->strength; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="costprice" id="costprice" size="8"  value="<?php echo formatNumber($obj->costprice); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="discount" id="discount" size="8"  value="<?php echo formatNumber($obj->discount); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="tradeprice" id="tradeprice" size="8"  value="<?php echo formatNumber($obj->tradeprice); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="retailprice" id="retailprice" size="8"  value="<?php echo formatNumber($obj->retailprice); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="applicabletax" id="applicabletax" value="<?php echo $obj->applicabletax; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="reorderlevel" id="reorderlevel" size="8"  value="<?php echo formatNumber($obj->reorderlevel); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo formatNumber($obj->quantity); ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="text" name="status" id="status" value="<?php echo $obj->status; ?>"></td>
	</tr>
	<tr>
		<td align="right">ExpiryDate: </td>
		<td><input type="text" name="expirydate" id="expirydate" class="date_input" size="12" readonly  value="<?php echo $obj->expirydate; ?>"></td>
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