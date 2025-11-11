<title>WiseDigits ERP: Inwards </title>
<?php 
include "../../../head.php";

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
     document.getElementById("costprice").value=data[9];
   }
 });
 $("#projectname").autocomplete("../../../modules/server/server/search.php?main=con&module=projects&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#projectname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("projectname").value=data[0];
     document.getElementById("projectid").value=data[1];
   }
 });
 $("#suppliername").autocomplete("../../../modules/server/server/search.php?main=proc&module=suppliers&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#suppliername").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("suppliername").value=data[0];
     document.getElementById("supplierid").value=data[1];
     document.getElementById("contact").value=data[7];
     document.getElementById("physicaladdress").value=data[8];
     document.getElementById("tel").value=data[9];
     document.getElementById("cellphone").value=data[12];
     document.getElementById("email").value=data[11];
   }
 });
});

function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print GRN?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?documentno=<?php echo $obj->documentno; ?>&supplierid=<?php echo $obj->supplierid; ?>&invoicedon=<?php echo $obj->soldon; ?>&packingno=<?php echo $obj->packingno; ?>",450,940);
	}
}
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


<div class="content">
<form  id="theform" action="addinwards_proc.php" name="inwards" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<!--<tr>
				<td><label>Project:</label></td>
				<td><input type='text' size='0' name='projectname' id='projectname' value='<?php echo $obj->projectname; ?>'>
					<input type="hidden" name='projectid' id='projectid' value='<?php echo $obj->projectid; ?>'></td>
			</td>-->
			</tr>
				<td><label>Supplier:</label></td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'></td>
			<tr>
				<td><label>Contact:</label></td>
				<td><input type='text' name='contact' id='contact' size='0' readonly value='<?php echo $obj->contact; ?>'/></td>				<td><label>Physical Address:</label></td>
				<td><textarea name='physicaladdress' id='physicaladdress' readonly><?php echo $obj->physicaladdress; ?></textarea></td>
			<tr>
				<td><label>Phone No.:</label></td>
				<td><input type='text' name='tel' id='tel' size='8' readonly value='<?php echo $obj->tel; ?>'/></td>				<td><label>Cell-Phone:</label></td>
				<td><input type='text' name='cellphone' id='cellphone' size='8' readonly value='<?php echo $obj->cellphone; ?>'/></td>			<tr>
				<td><label>E-mail:</label></td>
				<td><input type='text' name='email' id='email' size='0' readonly value='<?php echo $obj->email; ?>'/></td>			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Item  </th>
		<th align="right">Rate  </th>
		<th align="right">Quantity  </th>
		<th align="right">Memo  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname'  onchange="calculateTotal();;" onblur="calculateTotal();;"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>		<td>
		<input type='text' name='costprice' id='costprice'  size='4' readonly value='<?php echo $obj->costprice; ?>'/>
		</td>

		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();;" onblur="calculateTotal();;"  size="8" value="<?php echo $obj->quantity; ?>"></td>
		<td><textarea name="memo"><?php echo $obj->memo; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Inward Note No:<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>">
		Inward Date:<input type="date" name="inwarddate" id="inwarddate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->inwarddate; ?>">
		Remarks :<textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
		LPO No:<textarea name="deliverynoteno" ><?php echo $obj->deliverynoteno; ?></textarea>
			</td>
			</tr>
		</table>
		<div style="clear:both;">
<table style="clear:both" id="tbl" cellpadding="0" align="center" width="98%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Item  </th>
		<th align="right">Rate  </th>
		<th align="left">Quantity  </th>
		<th align="left">Memo  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpinwards']){
		$shpinwards=$_SESSION['shpinwards'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpinwards[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpinwards[$i]['itemname']; ?> </td>
			<td><?php echo $shpinwards[$i]['costprice']; ?> </td>
			<td><?php echo $shpinwards[$i]['quantity']; ?> </td>
			<td><?php echo $shpinwards[$i]['memo']; ?> </td>
			<td><?php echo $shpinwards[$i]['total']; ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" width="98%">
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
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
if($saved=="Yes"){
?>
    <script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
    <?
	redirect("addinwards_proc.php?retrieve=");
}

?>