<title>WiseDigits: Pricings </title>
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
<form  id="theform" action="addpricings_proc.php" name="pricings" method="POST" enctype="multipart/form-data">
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
		<td align="right">Category : </td>
		<td><input type="text" name="category" id="category" value="<?php echo $obj->category; ?>"></td>
	</tr>
	<tr>
		<td align="right">Item : </td>
		<td><input type="text" name="item" id="item" value="<?php echo $obj->item; ?>"></td>
	</tr>
	<tr>
		<td align="right">Unit Price : </td>
		<td><input type="text" name="price" id="price" size="8"  value="<?php echo $obj->price; ?>"></td>
	</tr>
	<tr>
		<td align="right">Available Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Market : </td>
		<td><input type="text" name="market" id="market" value="<?php echo $obj->market; ?>"></td>
	</tr>
	<tr>
		<td align="right">Location : </td>
		<td><input type="text" name="location" id="location" value="<?php echo $obj->location; ?>"></td>
	</tr>
	
	<?php
	$pricingcreatedelete=new Pricingcreatedelete();
	$where=" where status='Active' ";
	$fields="prices_pricingcreatedelete.fieldname";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$pricingcreatedelete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res = $pricingcreatedelete->result;
	while($row=mysql_fetch_object($res)){
	?>
	  <tr>
		<td align="right"><?php echo $row->fieldname; ?> : </td>
		<td><input type="text" name="<?php echo $row->fieldname; ?>" id="<?php echo $row->fieldname; ?>" value="<?php echo $_POST[$row->fieldname]; ?>"></td>
	</tr>
	<?php
	}
	?>
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