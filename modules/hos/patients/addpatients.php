<?php 
$pop=1;
include "../../../head.php";

?>
<title>WiseDigits: Patients</title>
<form action="addpatients_proc.php" name="patients" class="forms" method="POST">
<table align="center" width="100%">
	<tr>
		<td colspan="2">
        <input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">PatientNo: </td>
		<td><input type="text" name="patientno" id="patientno" value="<?php echo $obj->patientno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Surname: </td>
		<td><input type="text" name="surname" id="surname" value="<?php echo $obj->surname; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">OtherNames: </td>
		<td><input type="text" name="othernames" id="othernames" value="<?php echo $obj->othernames; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Patient Class:</td>
		<td>
			<select name="patientclasseid" class="selectbox">
				<option value="">Select...</option>
				<?php 
				$patientclasses = new Patientclasses();
				$fields=" * ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$patientclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				while ($row=mysql_fetch_object($patientclasses->result)){
				?>
					<option value="<?php echo $row->id; ?>" <?php if($obj->patientclasseid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
				<?php 
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">Blood Group : </td>
		<td><select name='bloodgroup' class="selectbox">
		<option value="">Select...</option>
			<option value='A' <?php if($obj->bloodgroup=='A'){echo"selected";}?>>A</option>
			<option value='B' <?php if($obj->bloodgroup=='B'){echo"selected";}?>>B</option>
			<option value='AB' <?php if($obj->bloodgroup=='AB'){echo"selected";}?>>AB</option>
			<option value='O' <?php if($obj->bloodgroup=='O'){echo"selected";}?>>O</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Physical Address : </td>
		<td><textarea name="address"><?php echo $obj->address; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">NHIF : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mobile : </td>
		<td><input type="text" name="mobile" id="mobile" value="<?php echo $obj->mobile; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Gender : </td>
			<td><select name="genderid" class="selectbox">
<option value="">Select...</option>
<?php
	$genders=new Genders();
	$where="  ";
	$fields="sys_genders.id, sys_genders.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$genders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($genders->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->genderid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Age : </td>
		<td><input type="text" name="dob" id="dob" size="8"  value="<?php echo $obj->dob; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Civil Status : </td>
			<td><select name="civilstatusid" class="selectbox">
<option value="">Select...</option>
<?php
	$civilstatuss=new Civilstatuss();
	$where="  ";
	$fields="hos_civilstatuss.id, hos_civilstatuss.name, hos_civilstatuss.remarks, hos_civilstatuss.createdby, hos_civilstatuss.createdon, hos_civilstatuss.lasteditedby, hos_civilstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$civilstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($civilstatuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->civilstatusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
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