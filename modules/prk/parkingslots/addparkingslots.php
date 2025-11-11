<title>WiseDigits: Parkingslots </title>
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
<form  id="theform" action="addparkingslots_proc.php" name="parkingslots" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="SlotID" id="SlotID" value="<?php echo $obj->SlotID; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="Street_Name" id="Street_Name" value="<?php echo $obj->Street_Name; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="X" id="X" size="8"  value="<?php echo $obj->X; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="Y" id="Y" size="8"  value="<?php echo $obj->Y; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="Agent_ID" id="Agent_ID" value="<?php echo $obj->Agent_ID; ?>"></td>
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