<title>WiseDigits ERP: Paymentterms </title>
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
 	
  $("#generaljournalaccountname").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=generaljournalaccounts&field=concat(code,' ',name)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#generaljournalaccountid").val(ui.item.id);
	}
  });

 } );
 </script>

<div class='main'>
<form class="forms" id="theform" action="addpaymentterms_proc.php" name="paymentterms" method="POST" enctype="multipart/form-data">
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
		<td align="right">Payment Term : </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><select name='type' class="selectbox">
			<option value='' <?php if($obj->type==''){echo"selected";}?>></option>
			<option value='Special Deposit' <?php if($obj->type=='Special Deposit'){echo"selected";}?>>Special Deposit</option>
			<option value='Utility' <?php if($obj->type=='Utility'){echo"selected";}?>>Utility</option>
			<option value='Income' <?php if($obj->type=='Income'){echo"selected";}?>>Income</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Payable To Landlord : </td>
		<td><select name='payabletolandlord' class="selectbox">
			<option value='Yes' <?php if($obj->payabletolandlord=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->payabletolandlord=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Journal Account : </td>
			<td>
			<input type="text" name="generaljournalaccountname" id="generaljournalaccountname" size="32" value="<?php echo $obj->generaljournalaccountname; ?>"/>
			<input type="hidden" name="generaljournalaccountid" id="generaljournalaccountid" value="<?php echo $obj->generaljournalaccountid; ?>"/>

		</td>
	</tr>
	<tr>
		<td align="right">Charge Mgt Fee : </td>
		<td><select name='chargemgtfee' class="selectbox">
			<option value='No' <?php if($obj->chargemgtfee=='No'){echo"selected";}?>>No</option>
			<option value='Yes' <?php if($obj->chargemgtfee=='Yes'){echo"selected";}?>>Yes</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>