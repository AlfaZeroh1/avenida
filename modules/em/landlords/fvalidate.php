<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>form validate test</title>

<link type="text/css" media="all" href="error.css" />
<script src="/wisedigits/estate/js/jquery-1.9.1.js"></script>
<script src="/wisedigits/estate/js/ui/jquery-ui.js"></script>

<script src="functions.js"></script>
</head>

<body>
<div id="form">
<form class="forms" action="addlandlords_proc.php" id="lADD" method="POST" enctype="multipart/form-data">

	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">

	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">LL Code : </td>
		<td>
        
        <div class="input" id="llcode"><input type="text" name="llcode" id="llcode" value="<?php echo $obj->llcode; ?>" readonly="readonly"/><font color='red'>*</font></div></td>
	</tr>
	<tr>
		<td align="right">First Name : </td>
		<td>
        <div class="row">
   <div class="input" id="jina"><input type="text" class="detail" name="firstname" id="firstname" value="<?php echo $obj->firstname; ?>"><font color='red'>*</font></div>
   </div>
   </td>

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
		<td><input type="numbers" name="tel" id="tel" value="<?php echo $obj->tel; ?>"></td>
	</tr>
	<tr>
		<td align="right">Email : </td>
		<td><input type="email" name="email" id="email" value="<?php echo $obj->email; ?>" size="24"></td>
	</tr>
	<tr>
		<td align="right">Date Registered : </td>
		<td><input type="text" name="registeredon" id="registeredon" class="date_input" size="14" readonly  value="<?php echo $obj->registeredon; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Fax : </td>
		<td><input type="text" name="fax" id="fax" value="<?php echo $obj->fax; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mobile : </td>
		<td><input type="tel" name="mobile" id="mobile" value="<?php echo $obj->mobile; ?>"></td>
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
		<td align="right">Address : </td>
		<td><textarea name="address"><?php echo $obj->address; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Deduct Commission Directly : </td>
		<td><select name='deductcommission' class="selectbox">
			<option value='Yes' <?php if($obj->deductcommission=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->deductcommission=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='Inactive' <?php if($obj->status=='Inactive'){echo"selected";}?>>Inactive</option>
		</select>
        </td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="submit" value="save">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>

    </table>
    </form>
        </div>
</body>
</html>
