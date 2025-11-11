<title>WiseDigits ERP: Quotations </title>
<?php 
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
		$("#code").val(ui.item.code);
		$("#tax").val(ui.item.tax);
		$("#discount").val(ui.item.discount);
		$("#retailprice").val(ui.item.retailprice);
		$("#tradeprice").val(ui.item.tradeprice);
	}
  });

  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
		$("#address").val(ui.item.address);
		$("#mobile").val(ui.item.mobile);
		$("#remarks").val(ui.item.remarks);
	}
  });

  $("#agentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=agents&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#agentid").val(ui.item.id);
	}
  });

  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
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
<form  id="theform" action="addquotations_proc.php" name="quotations" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Customer:</label></td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'></td>
				<td><label>Address:</label></td>
				<td><textarea name='address' id='address' readonly><?php echo $obj->address; ?></textarea></td>
			<tr>
				<td><label>:</label></td>
				<td><input type='text' name='mobile' id='mobile' size='20' readonly value='<?php echo $obj->mobile; ?>'/></td>				<td><label>Remarks:</label></td>
				<td><textarea name='remarks' id='remarks' readonly><?php echo $obj->remarks; ?></textarea></td>
			</td>
			</tr>
			<tr>
				<td><label>Agent:</label></td>
				<td><input type='text' size='20' name='agentname' id='agentname' value='<?php echo $obj->agentname; ?>'>
					<input type="hidden" name='agentid' id='agentid' value='<?php echo $obj->agentid; ?>'></td>
			</td>
			</tr>
				<td><label>Sales Person:</label></td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'></td>
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Item  </th>
		<th align="right">Item Code  </th>
		<th align="right">VAT  </th>
		<th align="right">Discount %  </th>
		<th align="right">Retail Price  </th>
		<th align="right">Trade Price  </th>
		<th align="right">Quantity  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname'  onchange="calculateTotal();" onblur="calculateTotal();"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>		<td>
		<input type='text' name='code' id='code'  size='8' readonly value='<?php echo $obj->code; ?>'/>
		</td>
		<td>
		<input type='text' name='tax' id='tax'  onchange="calculateTotal();" onblur="calculateTotal();"  size='4'  value='<?php echo $obj->tax; ?>'/>
		</td>
		<td>
		<input type='text' name='discount' id='discount'  onchange="calculateTotal();" onblur="calculateTotal();"  size='4'  value='<?php echo $obj->discount; ?>'/>
		</td>
		<td>
		<input type='text' name='retailprice' id='retailprice'  onchange="calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php echo $obj->retailprice; ?>'/>
		</td>
		<td>
		<input type='text' name='tradeprice' id='tradeprice'  onchange="calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php echo $obj->tradeprice; ?>'/>
		</td>

		</td>
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();"  size="2" value="<?php echo $obj->quantity; ?>"></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Quoted On:<input type="date" name="quotedon" id="quotedon"  class="date_input" size="8" readonly  value="<?php echo $obj->quotedon; ?>">
		Memo:<textarea name="memo" ><?php echo $obj->memo; ?></textarea>

<input type="hidden" name="olddocumentno" id="olddocumentno"  size="0"  value="<?php echo $obj->olddocumentno; ?>">

<input type="hidden" name="edit" id="edit"  size="0"  value="<?php echo $obj->edit; ?>">
		Quote No:<input type="text" name="documentno" id="documentno" readonly size="6"  value="<?php echo $obj->documentno; ?>">
			</td>
			</tr>
		</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Item  </th>
		<th align="right">Item Code  </th>
		<th align="right">VAT  </th>
		<th align="right">Discount %  </th>
		<th align="right">Retail Price  </th>
		<th align="right">Trade Price  </th>
		<th align="left">Quantity  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpquotations']){
		$shpquotations=$_SESSION['shpquotations'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpquotations[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpquotations[$i]['itemname']; ?> </td>
			<td><?php echo $shpquotations[$i]['code']; ?> </td>
			<td><?php echo $shpquotations[$i]['tax']; ?> </td>
			<td><?php echo $shpquotations[$i]['discount']; ?> </td>
			<td><?php echo $shpquotations[$i]['retailprice']; ?> </td>
			<td><?php echo $shpquotations[$i]['tradeprice']; ?> </td>
			<td><?php echo $shpquotations[$i]['quantity']; ?> </td>
			<td><?php echo $shpquotations[$i]['total']; ?> </td>
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
<table align="center" width="100%">
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
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
	redirect("addquotations_proc.php?retrieve=");
}

?>