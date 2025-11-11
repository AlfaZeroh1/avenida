<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
$pop=1;include "../../../head.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 	
 	$("#itemname").autocomplete({
	      source:"../../../modules/server/server/search.php?main=inv&module=items&field=name&where=status='Active'",
	      focus: function(event, ui) {
		      event.preventDefault();
		      $(this).val(ui.item.label);
	      },
	      select: function(event, ui) {
		      event.preventDefault();
		      $(this).val(ui.item.label);
		      $("#itemid").val(ui.item.id);
		      $("#costprice").val(ui.item.costprice);
	      }
	});
 } );
 </script>

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addestimationdetails_proc.php" name="estimationdetails" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<input type="hidden" name="estimationid" id="estimationid" value="<?php echo $obj->estimationid; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Item Name : </td>
			<td><input type='text' size='20' name='itemname'  onchange="calculateTotal();" onblur="calculateTotal();"  id='itemname' value='<?php echo $obj->itemname; ?>'>
		<input type="hidden" name='itemid' size='4' id='itemid' value='<?php echo $obj->itemid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right"> Types: </td>
		<td>
			<input type="radio" name="types" id="types" value='Perc' <?php if($obj->type=='Perc'){echo"checked";}?>>Perc 
			<input type="radio" name="types" id="types" value='quantity' <?php if($obj->type=='quantity'){echo"checked";}?>>Quantity 
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>