<title>WiseDigits: Paymentrequisitions </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
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
	}
  });

});
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
<form class="forms" id="theform" action="addpaymentrequisitions_proc.php" name="paymentrequisitions" method="POST" enctype="multipart/form-data">
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
		<td align="right">Requsition No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Supplier : </td>
			<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
			<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Invoice No(s) : </td>
		<td><textarea name="invoicenos"><?php echo $obj->invoicenos; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Requisition Date : </td>
		<td><input type="text" name="requisitiondate" id="requisitiondate" class="date_input" size="12" readonly  value="<?php echo $obj->requisitiondate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status'>
			<option value='pending' <?php if($obj->status=='pending'){echo"selected";}?>>pending</option>
			<option value='approved' <?php if($obj->status=='approved'){echo"selected";}?>>approved</option>
			<option value='rejected' <?php if($obj->status=='rejected'){echo"selected";}?>>rejected</option>
		</select></td>
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
if(!empty($error)){
	showError($error);
}
?>