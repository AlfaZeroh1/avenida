<title>WiseDigits ERP: Uproots </title>
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
<form  id="theform" action="adduproots_proc.php" name="uproots" method="POST" enctype="multipart/form-data">
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
		<td align="right">Planting Detail : </td>
			<td>
			<?php
			$plantingdetails=new Plantingdetails();
			$where="  ";
			$fields="prod_plantingdetails.id, prod_plantingdetails.plantingid, prod_varietys.name varietyid, prod_areas.name areaid, prod_blocks.name blockid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
			$join=" left join prod_varietys on prod_varietys.id=prod_plantingdetails.varietyid left join prod_areas on prod_areas.id=prod_plantingdetails.areaid left join prod_blocks on prod_blocks.id=prod_areas.blockid ";
			$having="";
			$groupby="";
			$orderby="";
			$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
			?>
			<select name="plantingdetailid" class="selectbox">
<option value="">Select...</option>
<?php
      while($rw=mysql_fetch_object($plantingdetails->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->plantingdetailid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->blockid." ".$rw->areaid." ".$rw->varietyid);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Area : </td>
			<td>
			<?php
			$areas=new Areas();
			$where="  ";
			$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
			?>
			<select name="areaid" class="selectbox">
<option value="">Select...</option>
<?php
	

	while($rw=mysql_fetch_object($areas->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->areaid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Variety : </td>
			<td><select name="varietyid" class="selectbox">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($varietys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Date Reported : </td>
		<td><input type="text" name="reportedon" id="reportedon" class="date_input" size="12" readonly  value="<?php echo $obj->reportedon; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Date Uprooted : </td>
		<td><input type="text" name="uprootedon" id="uprootedon" class="date_input" size="12" readonly  value="<?php echo $obj->uprootedon; ?>"><font color='red'>*</font></td>
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