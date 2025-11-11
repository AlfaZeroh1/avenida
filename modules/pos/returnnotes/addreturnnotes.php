<title>WiseDigits: Returnnotes </title>
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
<form class="forms" id="theform" action="addreturnnotes_proc.php" name="returnnotes" method="POST" enctype="multipart/form-data">
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
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Item  </th>
		<th align="right">Quantity  </th>
		<th align="right">Cost Price  </th>
		<th align="right">Tax  </th>
		<th align="right">Discount  </th>
		<th align="right">Total  </th>
		<th align="right">Remarks  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname'  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>
		</td>
		<td><input type="text" name="quantity" id="quantity" size="20" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="costprice" id="costprice" size="20" value="<?php echo $obj->costprice; ?>"></td>
		<td><input type="text" name="tax" id="tax" size="20" value="<?php echo $obj->tax; ?>"></td>
		<td><input type="text" name="discount" id="discount" size="20" value="<?php echo $obj->discount; ?>"></td>
		<td><input type="text" name="total" id="total" size="20" value="<?php echo $obj->total; ?>"></td>
		<td><textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Document No.:<input type="text" name="documentno" id="documentno"  size="20"  value="<?php echo $obj->documentno; ?>">
		Purchase Invoice/Receipt No:<input type="text" name="purchaseno" id="purchaseno"  size="20"  value="<?php echo $obj->purchaseno; ?>">
		Mode Of Payment:				<select name='purchasemodeid'>
				<option value="">Select...</option>
				<?php
				$purchasemodes=new Purchasemodes();
				$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($purchasemodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->purchasemodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
		Returned On:<input type="text" name="returnedon" id="returnedon"  size="20"  value="<?php echo $obj->returnedon; ?>">
		Memo:<input type="text" name="memo" id="memo"  size="20"  value="<?php echo $obj->memo; ?>">
			</td>
			</tr>
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Item  </th>
		<th align="left">Quantity  </th>
		<th align="left">Cost Price  </th>
		<th align="left">Tax  </th>
		<th align="left">Discount  </th>
		<th align="left">Total  </th>
		<th align="left">Remarks  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpreturnnotes']){
		$shpreturnnotes=$_SESSION['shpreturnnotes'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpreturnnotes[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpreturnnotes[$i]['itemname']; ?> </td>
			<td><?php echo $shpreturnnotes[$i]['quantity']; ?> </td>
			<td><?php echo $shpreturnnotes[$i]['costprice']; ?> </td>
			<td><?php echo $shpreturnnotes[$i]['tax']; ?> </td>
			<td><?php echo $shpreturnnotes[$i]['discount']; ?> </td>
			<td><?php echo $shpreturnnotes[$i]['total']; ?> </td>
			<td><?php echo $shpreturnnotes[$i]['remarks']; ?> </td>
			<td><?php echo $shpreturnnotes[$i]['total']; ?> </td>
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
if(!empty($error)){
	showError($error);
}
?>