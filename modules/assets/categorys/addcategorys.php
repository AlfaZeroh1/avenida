<title>WiseDigits: Categorys </title>
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
<form class="forms" id="theform" action="addcategorys_proc.php" name="categorys" method="POST" enctype="multipart/form-data">
	<table class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Asset Category : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>" <?php if($obj->id==1){echo"readonly";}?>><font color='red'>*</font></td>
	</tr>
	
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="*";
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
		<td align="right">Time Method : </td>
		<td><select name='timemethod'>
			<option value='No of Depreciations' <?php if($obj->timemethod=='No of Depreciations'){echo"selected";}?>>No of Depreciations</option>
			<option value='Ending Date' <?php if($obj->timemethod=='Ending Date'){echo"selected";}?>>Ending Date</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">No Of Depreciations : </td>
		<td><input type="text" name="noofdepr" id="noofdepr" size="8"  value="<?php echo $obj->noofdepr; ?>"></td>
	</tr>
	<tr>
		<td align="right">Ending Date : </td>
		<td><input type="text" name="endingdate" id="endingdate" class="date_input" size="12" readonly  value="<?php echo $obj->endingdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Period Length(Months) : </td>
		<td><input type="text" name="periodlength" id="periodlength" size="8"  value="<?php echo $obj->periodlength; ?>"></td>
	</tr>
	<tr>
		<td align="right">Computation Method : </td>
		<td><select name='computationmethod'>
			<option value='Linear' <?php if($obj->computationmethod=='Linear'){echo"selected";}?>>Linear</option>
			<option value='Degressive' <?php if($obj->computationmethod=='Degressive'){echo"selected";}?>>Degressive</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Degressive Factor : </td>
		<td><input type="text" name="degressivefactor" id="degressivefactor" size="8"  value="<?php echo $obj->degressivefactor; ?>"></td>
	</tr>
	<tr>
		<td align="right">1st Depreciation Entry From Purchase Date : </td>
		<td><input type="text" name="firstentry" id="firstentry" value="<?php echo $obj->firstentry; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Type : </td>
		<td><input type="radio" name="type" id="type" value="Monthly" <?php if($obj->type=='Monthly'){echo "checked";}?>>&nbsp;Monthly&nbsp;&nbsp;&nbsp;<input type="radio" name="type" id="type" value="No" <?php if($obj->type=='Annual'){echo "checked";}?>>&nbsp;Annually
		</td>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" class="btn btn-primary" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn btn-danger" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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