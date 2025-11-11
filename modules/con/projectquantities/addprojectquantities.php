<title>WiseDigits ERP: Projectquantities </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

});
<?php include'js.php'; ?>
</script>
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
<form  id="theform" action="addprojectquantities_proc.php" name="projectquantities" method="POST" enctype="multipart/form-data">
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
		<td align="right">Project : </td>
			<td><select name="projectid" class="selectbox">
<option value="">Select...</option>
<?php
	$projects=new Projects();
	$where="  ";
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projects->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Project BoQ Detail : </td>
			<td><select name="projectboqdetailid" class="selectbox">
<option value="">Select...</option>
<?php
	$projectboqdetails=new Projectboqdetails();
	$where="  ";
	$fields="con_projectboqdetails.id, con_projectboqdetails.projectboqid, con_projectboqdetails.materialcategoryid, con_projectboqdetails.materialsubcategoryid, con_projectboqdetails.estimationmanualid, con_projectboqdetails.unitofmeasureid, con_projectboqdetails.quantity, con_projectboqdetails.rate, con_projectboqdetails.total, con_projectboqdetails.remarks, con_projectboqdetails.ipaddress, con_projectboqdetails.createdby, con_projectboqdetails.createdon, con_projectboqdetails.lasteditedby, con_projectboqdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectboqdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projectboqdetails->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectboqdetailid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Item : </td>
			<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right"> : </td>
			<td><select name="labourid" class="selectbox">
<option value="">Select...</option>
<?php
	$labours=new Labours();
	$where="  ";
	$fields="con_labours.id, con_labours.name, con_labours.rate, con_labours.remarks, con_labours.ipaddress, con_labours.createdby, con_labours.createdon, con_labours.lasteditedby, con_labours.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$labours->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($labours->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->labourid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Category : </td>
			<td><select name="categoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$materialcategorys=new Materialcategorys();
	$where="  ";
	$fields="con_materialcategorys.id, con_materialcategorys.name, con_materialcategorys.remarks, con_materialcategorys.ipaddress, con_materialcategorys.createdby, con_materialcategorys.createdon, con_materialcategorys.lasteditedby, con_materialcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($materialcategorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Sub-category : </td>
			<td><select name="subcategoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$materialsubcategorys=new Materialsubcategorys();
	$where="  ";
	$fields="con_materialsubcategorys.id, con_materialsubcategorys.name, con_materialsubcategorys.categoryid, con_materialsubcategorys.remarks, con_materialsubcategorys.ipaddress, con_materialsubcategorys.createdby, con_materialsubcategorys.createdon, con_materialsubcategorys.lasteditedby, con_materialsubcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialsubcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($materialsubcategorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->subcategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Estimate Rate : </td>
		<td><input type="text" name="rate" id="rate" size="8"  value="<?php echo $obj->rate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Project Week : </td>
		<td><input type="text" name="projectweek" id="projectweek" value="<?php echo $obj->projectweek; ?>"></td>
	</tr>
	<tr>
		<td align="right">Calendar Week : </td>
		<td><input type="text" name="week" id="week" value="<?php echo $obj->week; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year Required : </td>
		<td><input type="text" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
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