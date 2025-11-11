<title>WiseDigits: Auctioneers </title>
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

<form class="forms" action="addauctioneers_proc.php" name="auctioneers" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">First Name : </td>
		<td><input type="text" name="firstname" id="firstname" value="<?php echo $obj->firstname; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Middle Name : </td>
		<td><input type="text" name="middlename" id="middlename" value="<?php echo $obj->middlename; ?>"></td>
	</tr>
	<tr>
		<td align="right">Last Name : </td>
		<td><input type="text" name="lastname" id="lastname" value="<?php echo $obj->lastname; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Telephone : </td>
		<td><input type="text" name="tel" id="tel" value="<?php echo $obj->tel; ?>"></td>
	</tr>
	<tr>
		<td align="right">Email : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fax : </td>
		<td><input type="text" name="fax" id="fax" value="<?php echo $obj->fax; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mobile : </td>
		<td><input type="text" name="mobile" id="mobile" value="<?php echo $obj->mobile; ?>"></td>
	</tr>
	<tr>
		<td align="right">National ID No : </td>
		<td><input type="text" name="idno" id="idno" value="<?php echo $obj->idno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Passport No : </td>
		<td><input type="text" name="passportno" id="passportno" value="<?php echo $obj->passportno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Postal Address : </td>
		<td><textarea name="postaladdress"><?php echo $obj->postaladdress; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Physical Address : </td>
		<td><textarea name="address"><?php echo $obj->address; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select class="selectbox" name='status'>
			<option value='active' <?php if($obj->status=='active'){echo"selected";}?>>active</option>
			<option value='in-active' <?php if($obj->status=='in-active'){echo"selected";}?>>in-active</option>
		</select></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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