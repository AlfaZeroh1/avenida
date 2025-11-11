<?php 
$pop=1;
include "../../../head.php";

?>
<title>WiseDigits: Laboratorytests</title>
<form action="addlaboratorytests_proc.php" class="forms" name="laboratorytests" method="POST">
<table align="center" width="100%">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">LaboratoryTest: </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Remarks: </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Charge: </td>
		<td><input type="text" name="charge" id="charge" size="8"  value="<?php echo formatNumber($obj->charge); ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>