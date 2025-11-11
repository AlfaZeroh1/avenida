<title>WiseDigits: Wards </title>
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
<form class="forms" id="theform" action="addwards_proc.php" name="wards" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Room Number Of The First Room : </td>
		<td><input type="text" name="firstroom" id="firstroom" value="<?php echo $obj->firstroom; ?>"></td>
	</tr>
	<tr>
		<td align="right">Room Number Of The Last Room : </td>
		<td><input type="text" name="lastroom" id="lastroom" value="<?php echo $obj->lastroom; ?>"></td>
	</tr>
	<tr>
		<td align="right">Room Prefix : </td>
		<td><input type="text" name="roomprefix" id="roomprefix" value="<?php echo $obj->roomprefix; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status'>
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='In-active' <?php if($obj->status=='In-active'){echo"selected";}?>>In-active</option>
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