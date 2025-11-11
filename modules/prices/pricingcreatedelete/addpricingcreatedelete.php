<title>WiseDigits: Pricingcreatedelete </title>
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
<form  id="theform" action="addpricingcreatedelete_proc.php" name="pricingcreatedelete" method="POST" enctype="multipart/form-data">
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
		<td align="right">Field Name : </td>
		<td><input type="text" name="fieldname" id="fieldname" value="<?php echo $obj->fieldname; ?>"></td>
	</tr>
	<tr>
		<td align="right">Field Size : </td>
		<td><select name='fieldsize' class="selectbox">
			<option value='Numeric' <?php if($obj->fieldsize=='Numeric'){echo"selected";}?>>Numeric</option>
			<option value='Small Text' <?php if($obj->fieldsize=='Small Text'){echo"selected";}?>>Small Text</option>
			<option value='Medium Text' <?php if($obj->fieldsize=='Medium Text'){echo"selected";}?>>Medium Text</option>
			<option value='Large' <?php if($obj->fieldsize=='Large'){echo"selected";}?>>Large</option>
			<option value='Yes/No' <?php if($obj->fieldsize=='Yes/No'){echo"selected";}?>>Yes/No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Field Category : </td>
		<td><input type="text" name="category" id="category" value="<?php echo $obj->category; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='Dropped' <?php if($obj->status=='Dropped'){echo"selected";}?>>Dropped</option>
		</select></td>
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