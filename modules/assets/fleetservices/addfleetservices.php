<title>WiseDigits: Fleetservices </title>
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
<form class="forms" id="theform" action="addfleetservices_proc.php" name="fleetservices" method="POST" enctype="multipart/form-data">
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
		<td align="right">Vehicle : </td>
		<td><input type="text" name="fleetid" id="fleetid" value="<?php echo $obj->fleetid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Supplier : </td>
		<td><input type="text" name="supplierid" id="supplierid" value="<?php echo $obj->supplierid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cost : </td>
		<td><input type="text" name="cost" id="cost" size="8"  value="<?php echo $obj->cost; ?>"></td>
	</tr>
	<tr>
		<td align="right">Odometer Reading : </td>
		<td><input type="text" name="odometer" id="odometer" size="8"  value="<?php echo $obj->odometer; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
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