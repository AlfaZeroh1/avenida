<title>WiseDigits ERP: Confirmedorders </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=crm_customers.name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
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
<script type="text/javascript">
function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print An Order?";
	var ans=confirm(msg);
	if(ans)
	{
 		<?php $_SESSION['obj']=$obj; ?>
		poptastic('print.php?&doc=<?php echo $obj->orderno; ?>&customerid=<?php echo $obj->customerid; ?>&packedon=<?php echo $obj->orderedon; ?>',700,1020);
	}
}
 </script>
 
<hr>
<div class="content">
<form  id="theform" action="addconfirmedorders_proc.php" name="confirmedorders" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Order No:</label></td>
<td><input type="text" name="orderno" id="orderno" readonly size="20"  value="<?php echo $obj->orderno; ?>">			</td>
			</tr>
			<tr>
				<td><label>Customer:</label></td>
				<td><input type='text' size='20' readonly name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="text" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'></td>
			</td>
			</tr>
			<tr>
			<td><label>Consignee:</label></td>
			<td><select name="customerconsigneeid" class="selectbox">
<option value="">Select...</option>
<?php
	$customerconsignees=new Customerconsignees();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customerconsignees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($customerconsignees->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->customerconsigneeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
			</tr>
			<tr>
				<td><label>Date Ordered:</label></td>
<td><input type="text" name="orderedon" id="orderedon" class="date_input" size="16" readonly  value="<?php echo $obj->orderedon; ?>">			</td>
			</tr>
			<td>
		<label>Remarks:</label>			</td>
			<td>
<textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea>			</td>
			</td>
			</tr>
		</table>
		<?php if(!empty($_GET['edit'])){?>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Product  </th>
		<th align="right">Length  </th>
		<th align="right">Quantity  </th>
		<th align="right">Pack Rate  </th>
		<th align="right">Memo  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type="hidden" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"/>
<?php
	$items=new Items();
	$where=" where id='$obj->itemid' ";
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$items = $items->fetchObject;
	?>
	<input type="text" readonly name="itemname" value="<?php echo $items->name; ?>"/>
<font color='red'>*</font>
		</td>
			
		<td><select name="sizeid"  class="selectbox">
<option value="">Select...</option>
<?php
	$sizes=new Sizes();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($sizes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
<font color='red'>*</font>
		</td>			<td><input type="text" name="quantity" id="quantity" size="12" value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
		<td><input type="text" name="packrate" id="packrate" size="12" value="<?php echo $obj->packrate; ?>"><font color='red'>*</font></td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
	<?php }?>
	<table align='center'>
			<tr>
			<td>
		Date Confirmed:<input type="date" name="confirmedon" id="confirmedon"  class="date_input" size="16" readonly  value="<?php echo $obj->confirmedon; ?>">
		Remarks:<textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
			</td>
			</tr>
		</table>
	
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Product  </th>
		<th align="left">Length  </th>
		<th align="left">Quantity  </th>
		<th align="left">Pack Rate  </th>
		<th align="left">Memo  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpconfirmedorders']){
		$shpconfirmedorders=$_SESSION['shpconfirmedorders'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpconfirmedorders[$i]['itemname']; ?> </td>
			<td><?php echo $shpconfirmedorders[$i]['sizename']; ?> </td>
			<td><?php echo $shpconfirmedorders[$i]['quantity']; ?> </td>
			<td><?php echo $shpconfirmedorders[$i]['packrate']; ?> </td>
			<td><?php echo $shpconfirmedorders[$i]['memo']; ?> </td>
			<td><?php echo $shpconfirmedorders[$i]['total']; ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=1">Edit</a></td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=1" onclick="return confirm('Are you sure you want to delete?')">Del</a></td>
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
	<?php //if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="button" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
</hr>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
if($saved=="Yes"){
	redirect("addconfirmedorders_proc.php?retrieve=");
}

?>