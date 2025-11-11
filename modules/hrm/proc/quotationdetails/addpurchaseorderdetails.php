<title>WiseDigits ERP: Purchaseorderdetails </title>
<?php 
include "../../../headerpop.php";

?>
<script type="text/javascript">
$().ready(function() {
 $("#itemname").autocomplete("../../../modules/server/server/search.php?main=inv&module=items&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#itemname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("itemname").value=data[0];
     document.getElementById("itemid").value=data[1];
     document.getElementById("code").value=data[2];
     document.getElementById("tax").value=data[];
     document.getElementById("costprice").value=data[9];
     document.getElementById("tradeprice").value=data[10];
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
<form  id="theform" action="addpurchaseorderdetails_proc.php" name="purchaseorderdetails" method="POST" enctype="multipart/form-data">
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
		<td align="right">Purchase Order : </td>
			<td><select name="purchaseorderid" class="selectbox">
<option value="">Select...</option>
<?php
	$purchaseorders=new Purchaseorders();
	$where="  ";
	$fields="proc_purchaseorders.id, proc_purchaseorders.projectid, proc_purchaseorders.documentno, proc_purchaseorders.requisitionno, proc_purchaseorders.supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($purchaseorders->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->purchaseorderid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
		<td align="right">Trade Price : </td>
		<td><input type="text" name="tradeprice" id="tradeprice" size="8"  value="<?php echo $obj->tradeprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Applicable Tax : </td>
		<td><input type="text" name="tax" id="tax" size="8"  value="<?php echo $obj->tax; ?>"></td>
	</tr>
	<tr>
		<td align="right">Total : </td>
		<td><input type="text" name="total" id="total" size="8"  value="<?php echo $obj->total; ?>"></td>
	</tr>
	<tr>
		<td align="right">Memo : </td>
		<td><textarea name="memo"><?php echo $obj->memo; ?></textarea></td>
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