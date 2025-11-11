<title>WiseDigits: Tenants </title>
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
 		"sPaginationType": "full_numbers",
 		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "../../../server/server/processing.php"
 	} );
 } );
 </script>

<form class="forms" action="addtenants_proc.php" name="tenants" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Tenant Code : </td>
		<td><input type="text" name="code" id="code" value="<?php echo $obj->code; ?>" readonly="readonly"/><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">First Name : </td>
		<td><input type="text" name="firstname" id="firstname" value="<?php echo $obj->firstname; ?>" required="required"/><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Middle Name : </td>
		<td><input type="text" name="middlename" id="middlename" value="<?php echo $obj->middlename; ?>"></td>
	</tr>
	<tr>
		<td align="right">Last Name : </td>
		<td><input type="text" name="lastname" id="lastname" value="<?php echo $obj->lastname; ?>" required="required"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Postal Address : </td>
		<td><textarea name="postaladdress"><?php echo $obj->postaladdress; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Address : </td>
		<td><textarea name="address"><?php echo $obj->address; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Reg Date : </td>
		<td><input type="text" name="registeredon" id="registeredon" class="date_input" size="12" readonly  value="<?php echo $obj->registeredon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Nationality : </td>
			<td><select class="selectbox" name="nationalityid" >
<option value="">Select...</option>
<?php
	$nationalitys=new Nationalitys();
	$where="  ";
	$fields="sys_nationalitys.id, sys_nationalitys.name, sys_nationalitys.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nationalitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($nationalitys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->nationalityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Telephone : </td>
		<td><input type="text" name="tel" id="tel" value="<?php echo $obj->tel; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mobile : </td>
		<td><input type="text"  max="12"  name="mobile" id="mobile" value="<?php echo $obj->mobile; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fax : </td>
		<td><input type="text"  max="12"  name="fax" id="fax" value="<?php echo $obj->fax; ?>"></td>
	</tr>
	<tr>
		<td align="right">National ID No : </td>
		<td><input type="text"  max="12"  name="idno" id="idno" value="<?php echo $obj->idno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Passport No : </td>
		<td><input type="text"  max="12"  name="passportno" id="passportno" value="<?php echo $obj->passportno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Driving License No : </td>
		<td><input type="text" name="dlno" id="dlno" value="<?php echo $obj->dlno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Occupation :</td>
		<td><input type="text" name="occupation" id="occupation" value="<?php echo $obj->occupation; ?>"></td>
	</tr>
	<tr>
		<td align="right">Email :</td>
		<td> <input type="email" name="email" id="email" value="<?php echo $obj->email;?>"> </td>
	</tr>
	<tr>
		<td align="right">Birth Date :</td>
		<td><input type="text" name="dob" id="dob" class="date_input" size="12" readonly  value="<?php echo $obj->dob; ?>"></td>
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