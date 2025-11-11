<title>WiseDigits ERP: Irrigationvalves </title>
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
<form  id="theform" action="addirrigationvalves_proc.php" name="irrigationvalves" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn btn-info" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Irrigation : </td>
			<td><select name="irrigationid" class="selectbox">
<option value="">Select...</option>
<?php
	$irrigations=new Irrigations();
	$where="  ";
	$fields="prod_irrigations.id, prod_irrigations.irrigationdate, prod_irrigations.remarks, prod_irrigations.ipaddress, prod_irrigations.createdby, prod_irrigations.createdon, prod_irrigations.lasteditedby, prod_irrigations.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigations->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($irrigations->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->irrigationid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Valve : </td>
			<td><select name="valveid" class="selectbox">
<option value="">Select...</option>
<?php
	$valves=new Valves();
	$where="  ";
	$fields="prod_valves.id, prod_valves.name, prod_valves.greenhouseid, prod_valves.remarks, prod_valves.ipaddress, prod_valves.createdby, prod_valves.createdon, prod_valves.lasteditedby, prod_valves.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$valves->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($valves->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->valveid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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