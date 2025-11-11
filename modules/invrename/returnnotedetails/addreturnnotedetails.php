<title>WiseDigits ERP: Returnnotedetails </title>
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
<form  id="theform" action="addreturnnotedetails_proc.php" name="returnnotedetails" method="POST" enctype="multipart/form-data">
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
		<td align="right">Return Note : </td>
			<td><select name="returnnoteid" class="selectbox">
<option value="">Select...</option>
<?php
	$returnnotes=new Returnnotes();
	$where="  ";
	$fields="inv_returnnotes.id, inv_returnnotes.supplierid, inv_returnnotes.documentno, inv_returnnotes.purchaseno, inv_returnnotes.purchasemodeid, inv_returnnotes.returnedon, inv_returnnotes.memo, inv_returnnotes.remarks, inv_returnnotes.createdby, inv_returnnotes.createdon, inv_returnnotes.lasteditedby, inv_returnnotes.lasteditedon, inv_returnnotes.ipaddress, inv_returnnotes.projectid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnnotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($returnnotes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->returnnoteid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Item : </td>
			<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cost Price : </td>
		<td><input type="text" name="costprice" id="costprice" size="8"  value="<?php echo $obj->costprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Applicable Tax : </td>
		<td><input type="text" name="tax" id="tax" size="8"  value="<?php echo $obj->tax; ?>"></td>
	</tr>
	<tr>
		<td align="right">Discount : </td>
		<td><input type="text" name="discount" id="discount" size="8"  value="<?php echo $obj->discount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Total : </td>
		<td><input type="text" name="total" id="total" size="8"  value="<?php echo $obj->total; ?>"></td>
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