<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript" charset="utf-8">
$().ready(function() {
  $("#itemname").autocomplete({
	source:"../../server/server/search.php?main=inv&module=items&field=name&where=inv_items.departmentid=1",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
		$("#price").val(ui.item.price);
	}
  });

	});
</script>
<title>WiseDigits: Patientprescriptions</title>
<form action="addpatientprescriptions_proc.php" name="patientprescriptions" method="POST">
<table align="center">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">ItemName: </td>
<td><input type="text" name="itemname" id="itemname" size="30" tabindex="1" <?php if(!empty($obj->id)){echo"readonly";}?> value="<?php echo $obj->itemname; ?>"/>
    <input type="hidden" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"/><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right"> </td>
<td><input type="hidden" name="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity: </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Price: </td>
		<td><input type="text" name="price" id="price" size="8"  value="<?php echo $obj->price; ?>"></td>
	</tr>
	<tr>
		<td align="right"></td>
		<td><input type="hidden" name="issued" id="issued" value="<?php echo $obj->issued; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>