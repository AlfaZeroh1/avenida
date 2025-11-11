<title>WiseDigits ERP: Projectboqs </title>
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
<form  id="theform" action="addprojectboqs_proc.php" name="projectboqs" method="POST" enctype="multipart/form-data">
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
		<td align="right">Bill Of Quantity : </td>
			<td><select name="billofquantitieid" class="selectbox">
<option value="">Select...</option>
<?php
	$billofquantities=new Billofquantities();
	$where="  ";
	$fields="tender_billofquantities.id, tender_billofquantities.tenderid, tender_billofquantities.bqitem, tender_billofquantities.quantity, tender_billofquantities.unitofmeasureid, tender_billofquantities.bqrate, tender_billofquantities.remarks, tender_billofquantities.ipaddress, tender_billofquantities.createdby, tender_billofquantities.createdon, tender_billofquantities.lasteditedby, tender_billofquantities.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$billofquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($billofquantities->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->billofquantitieid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->bqitem);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">BoQ Detail : </td>
		<td><textarea name="name"><?php echo $obj->name; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Unit Of Measure : </td>
			<td><select name="unitofmeasureid" class="selectbox">
<option value="">Select...</option>
<?php
	$unitofmeasures=new Unitofmeasures();
	$where="  ";
	$fields="tender_unitofmeasures.id, tender_unitofmeasures.name, tender_unitofmeasures.remarks, tender_unitofmeasures.ipaddress, tender_unitofmeasures.createdby, tender_unitofmeasures.createdon, tender_unitofmeasures.lasteditedby, tender_unitofmeasures.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($unitofmeasures->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->unitofmeasureid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">BQ Rate : </td>
		<td><input type="text" name="bqrate" id="bqrate" size="8"  value="<?php echo $obj->bqrate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Total : </td>
		<td><input type="text" name="total" id="total" size="8"  value="<?php echo $obj->total; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>