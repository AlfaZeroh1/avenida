<title>WiseDigits ERP: Suppliers </title>
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
<form  id="theform" action="addsuppliers_proc.php" name="suppliers" method="POST" enctype="multipart/form-data">
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
		<td align="right">Code : </td>
		<td><input type="text" name="code" id="code" value="<?php echo $obj->code; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Contact : </td>
		<td><input type="text" name="contact" id="contact" value="<?php echo $obj->contact; ?>"></td>
	</tr>
	<tr>
		<td align="right">Address : </td>
		<td><textarea name="address"><?php echo $obj->address; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Tel No. : </td>
		<td><input type="text" name="telephone" id="telephone" value="<?php echo $obj->telephone; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fax : </td>
		<td><input type="text" name="fax" id="fax" value="<?php echo $obj->fax; ?>"></td>
	</tr>
	<tr>
		<td align="right">E-mail : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mobile : </td>
		<td><input type="text" name="mobile" id="mobile" value="<?php echo $obj->mobile; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><input type="text" name="status" id="status" value="<?php echo $obj->status; ?>"><font color='red'>*</font></td>
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