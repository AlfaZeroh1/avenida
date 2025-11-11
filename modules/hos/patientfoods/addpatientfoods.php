<title>WiseDigits: Patientfoods </title>
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
<form class="forms" id="theform" action="addpatientfoods_proc.php" name="patientfoods" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Food : </td>
		<td><input type="text" name="foodid" id="foodid" value="<?php echo $obj->foodid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Patient : </td>
		<td><input type="text" name="patientid" id="patientid" value="<?php echo $obj->patientid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Price : </td>
		<td><input type="text" name="price" id="price" size="8"  value="<?php echo $obj->price; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="servedon" id="servedon" class="date_input" size="12" readonly  value="<?php echo $obj->servedon; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
			<td><select name="mealid">
<option value="">Select...</option>
<?php
	$meals=new Meals();
	$where="  ";
	$fields="hos_meals.id, hos_meals.name, hos_meals.remarks, hos_meals.createdby, hos_meals.createdon, hos_meals.lasteditedby, hos_meals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$meals->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($meals->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->mealid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
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