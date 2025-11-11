<title>WiseDigits: Prepaidusers </title>
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
<form  id="theform" action="addprepaidusers_proc.php" name="prepaidusers" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="User_id" id="User_id" value="<?php echo $obj->User_id; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="User_pin" id="User_pin" value="<?php echo $obj->User_pin; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="Account_balance" id="Account_balance" value="<?php echo $obj->Account_balance; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="last_reload_card" id="last_reload_card" value="<?php echo $obj->last_reload_card; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="Status" id="Status" value="<?php echo $obj->Status; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="User_phone_number" id="User_phone_number" value="<?php echo $obj->User_phone_number; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="User_Pin_Retries" id="User_Pin_Retries" value="<?php echo $obj->User_Pin_Retries; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="User_Allowed_pin_Retries" id="User_Allowed_pin_Retries" value="<?php echo $obj->User_Allowed_pin_Retries; ?>"></td>
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