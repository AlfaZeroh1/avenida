<title>WiseDigits ERP: Countrys </title>
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
<form  id="theform" action="addcountrys_proc.php" name="countrys" method="POST" enctype="multipart/form-data">
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
		<td align="right">Country : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"></td>
	</tr>
	<!--<tr>
		<td align="right">Continent : </td>
		<td><input type="text" name="continentid" id="continentid" value="<?php echo $obj->continentid; ?>"></td>
	</tr>-->
	<tr>
		<td align="right">Continent : </td>
			<td><select name="continentid" class="selectbox">
<option value="">Select...</option>
<?php
	$continents=new Continents();
	$where="  ";
	$fields="crm_continents.id, crm_continents.name, crm_continents.remarks, crm_continents.ipaddress, crm_continents.createdby, crm_continents.createdon, crm_continents.lasteditedby, crm_continents.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$continents->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($continents->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->continentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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