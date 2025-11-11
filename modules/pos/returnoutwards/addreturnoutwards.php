<title>WiseDigits ERP: Returnoutwards </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=pos&module=items&field=name",
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
		$("#costprice").val(ui.item.costprice);
		$("#tradeprice").val(ui.item.tradeprice);
	}
  });

  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierid").val(ui.item.id);
		$("#address").val(ui.item.address);
		$("#tel").val(ui.item.tel);
		$("#remarks").val(ui.item.remarks);
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
<form  id="theform" action="addreturnoutwards_proc.php" name="returnoutwards" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Supplier:</label></td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'></td>
				<td><label>:</label></td>
				<td><textarea name='address' id='address' readonly><?php echo $obj->address; ?></textarea></td>
			<tr>
				<td><label>Phone No.:</label></td>
				<td><input type='text' name='tel' id='tel' size='15' readonly value='<?php echo $obj->tel; ?>'/></td>				<td><label>:</label></td>
				<td><textarea name='remarks' id='remarks' readonly><?php echo $obj->remarks; ?></textarea></td>
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Item  </th>
		<th align="right">Code  </th>
		<th align="right">VAT  </th>
		<th align="right">Discount %  </th>
		<th align="right">Cost Price  </th>
		<th align="right">Trade Price  </th>
		<th align="right">Quantity  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname'  onchange="calculateTotal();" onblur="calculateTotal();"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>		<td>
		<input type='text' name='code' id='code'  size='4' readonly value='<?php echo $obj->code; ?>'/>
		</td>
		<td>
		<input type='text' name='tax' id='tax'  onchange="calculateTotal();" onblur="calculateTotal();"  size='4'  value='<?php echo $obj->tax; ?>'/>
		</td>
		<td>
		<input type='text' name='discount' id='discount'  onchange="calculateTotal();" onblur="calculateTotal();"  size='4'  value='<?php echo $obj->discount; ?>'/>
		</td>
		<td>
		<input type='text' name='costprice' id='costprice'  onchange="calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php echo $obj->costprice; ?>'/>
		</td>
		<td>
		<input type='text' name='tradeprice' id='tradeprice'  onchange="calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php echo $obj->tradeprice; ?>'/>
		</td>

		</td>
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->quantity; ?>"></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Credit Note No.:<input type="text" name="creditnoteno" id="creditnoteno"  size="5"  value="<?php echo $obj->creditnoteno; ?>">
		Returned On:<input type="date" name="returnedon" id="returnedon"  class="date_input" size="8" readonly  value="<?php echo $obj->returnedon; ?>">
		Memo:<textarea name="memo" ><?php echo $obj->memo; ?></textarea>
		Purchase Mode:<select name='mode'  class="selectbox">
			<option value='cash' <?php if($obj->mode=='cash'){echo"selected";}?>>cash</option>
			<option value='credit' <?php if($obj->mode=='credit'){echo"selected";}?>>credit</option>
		</select>

<input type="hidden" name="olddocumentno" id="olddocumentno" hidden size="0"  value="<?php echo $obj->olddocumentno; ?>">

<input type="hidden" name="oldmode" id="oldmode" hidden size="0"  value="<?php echo $obj->oldmode; ?>">

<input type="hidden" name="edit" id="edit" hidden size="0"  value="<?php echo $obj->edit; ?>">
		Receipt/Invoice No:<input type="text" name="documentno" id="documentno"  size="5"  value="<?php echo $obj->documentno; ?>">
			</td>
			</tr>
		</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Item  </th>
		<th align="right">Code  </th>
		<th align="right">VAT  </th>
		<th align="right">Discount %  </th>
		<th align="right">Cost Price  </th>
		<th align="right">Trade Price  </th>
		<th align="left">Quantity  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpreturnoutwards']){
		$shpreturnoutwards=$_SESSION['shpreturnoutwards'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpreturnoutwards[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpreturnoutwards[$i]['itemname']; ?> </td>
			<td><?php echo $shpreturnoutwards[$i]['code']; ?> </td>
			<td><?php echo $shpreturnoutwards[$i]['tax']; ?> </td>
			<td><?php echo $shpreturnoutwards[$i]['discount']; ?> </td>
			<td><?php echo $shpreturnoutwards[$i]['costprice']; ?> </td>
			<td><?php echo $shpreturnoutwards[$i]['tradeprice']; ?> </td>
			<td><?php echo $shpreturnoutwards[$i]['quantity']; ?> </td>
			<td><?php echo $shpreturnoutwards[$i]['total']; ?> </td>
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
		<td colspan="2" align="center"><input  class="btn btn-primary" type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
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
	redirect("addreturnoutwards_proc.php?retrieve=");
}

?>