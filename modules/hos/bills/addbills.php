<?php 
$pop=1;
include "../../../head.php";

?>
<title>WiseDigits: Bills</title>
<form action="addbills_proc.php" name="bills" method="POST">
<table align="center">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">BillName: </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Amount: </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo formatNumber($obj->amount); ?>"></td>
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