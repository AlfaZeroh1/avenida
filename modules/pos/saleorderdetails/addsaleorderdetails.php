<title>WiseDigits ERP: Saleorderdetails </title>
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
<form  id="theform" action="addsaleorderdetails_proc.php" name="saleorderdetails" method="POST" enctype="multipart/form-data">
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
		<td align="right">Sale Order : </td>
			<td><select name="saleorderid" class="selectbox">
<option value="">Select...</option>
<?php
	$saleorders=new Saleorders();
	$where="  ";
	$fields="pos_saleorders.id, pos_saleorders.documentno, pos_saleorders.customerid, pos_saleorders.agentid, pos_saleorders.employeeid, pos_saleorders.remarks, pos_saleorders.soldon, pos_saleorders.expirydate, pos_saleorders.memo, pos_saleorders.createdby, pos_saleorders.createdon, pos_saleorders.lasteditedby, pos_saleorders.lasteditedon, pos_saleorders.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$saleorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($saleorders->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->saleorderid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Item : </td>
		<td><input type="text" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"><font color='red'>*</font></td>
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
		<td align="right">Discount : </td>
		<td><input type="text" name="discount" id="discount" size="8"  value="<?php echo $obj->discount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Tax : </td>
		<td><input type="text" name="tax" id="tax" size="8"  value="<?php echo $obj->tax; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bonus : </td>
		<td><input type="text" name="bonus" id="bonus" size="8"  value="<?php echo $obj->bonus; ?>"></td>
	</tr>
	<tr>
		<td align="right">Profit : </td>
		<td><input type="text" name="profit" id="profit" size="8"  value="<?php echo $obj->profit; ?>"></td>
	</tr>
	<tr>
		<td align="right">Total : </td>
		<td><input type="text" name="total" id="total" size="8"  value="<?php echo $obj->total; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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