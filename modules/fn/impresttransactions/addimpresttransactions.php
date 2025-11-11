<title>WiseDigits ERP: Impresttransactions </title>
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
<form class="forms" id="theform" action="addimpresttransactions_proc.php" name="impresttransactions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Imprest Account:</label></td>
<td><select name="imprestaccountid" id="imprestaccountid" class="selectbox">
<option value="">Select...</option>
<?php
	$imprestaccounts=new Imprestaccounts();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($imprestaccounts->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->imprestaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>			</td>
			</tr>
			<tr>
				<td><label>Imprest:</label></td>
<td><select name="imprestid" id="imprestid" class="selectbox">
<option value="">Select...</option>
<?php
	$imprests=new Imprests();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprests->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($imprests->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->imprestid==$rw->id){echo "selected";}?>><?php echo "Imprest #".$rw->documentno."PV No: ".$rw->paymentvoucherno." ChQ No: ".$rw->chequeno." Amount: ".$rw->amount; ?></option>
	<?php
	}
	?>
</select></td>			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Expense  </th>
		<th align="right">Quantity  </th>
		<th align="right">Amount  </th>
		<th align="right">Transaction Date  </th>
		<th align="right">Remarks  </th>
		<th>Total</th>
		<th>Browse File</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="expenseid"  onchange="calculateTotal();" onblur="calculateTotal();;"  class="selectbox">
<option value="">Select...</option>
<?php
	$expenses=new Expenses();
	$where="  ";
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($expenses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->expenseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="amount" id="amount" size="8" onchange="calculateTotal();" value="<?php echo $obj->amount; ?>"></td>
		<td><input type="text" name="incurredon" id="incurredon" class="date_input" size="12" readonly  value="<?php echo $obj->incurredon; ?>"></td>
		<td><textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="file" name="file"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Document No:<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>">
		Memo:<textarea name="memo" ><?php echo $obj->memo; ?></textarea>
		Entered On:<input type="date" name="enteredon" id="enteredon" readonly class="date_input" size="12" readonly  value="<?php echo $obj->enteredon; ?>">
			</td>
			</tr>
		</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Inventory Item  </th>
		<th align="left">Quantity  </th>
		<th align="left">Amount  </th>
		<th align="left">Transaction Date  </th>
		<th align="left">Remarks  </th>
		<th align='left'>Total</th>
		<th align='left'>File</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpimpresttransactions']){
		$shpimpresttransactions=$_SESSION['shpimpresttransactions'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpimpresttransactions[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpimpresttransactions[$i]['itemname']; ?> </td>
			<td><?php echo $shpimpresttransactions[$i]['quantity']; ?> </td>
			<td><?php echo $shpimpresttransactions[$i]['amount']; ?> </td>
			<td><?php echo $shpimpresttransactions[$i]['incurredon']; ?> </td>
			<td><?php echo $shpimpresttransactions[$i]['remarks']; ?> </td>
			<td><?php echo $shpimpresttransactions[$i]['total']; ?> </td>
			<td><?php echo $shpimpresttransactions[$i]['file']; ?> </td>
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
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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
	redirect("addimpresttransactions_proc.php?retrieve=");
}

?>