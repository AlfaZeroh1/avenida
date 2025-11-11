<title>WiseDigits ERP: Projectsubcontractors </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#projectname").autocomplete({
	source:"../../../modules/server/server/search.php?main=con&module=projects&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectid").val(ui.item.id);
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
<form  id="theform" action="addprojectsubcontractors_proc.php" name="projectsubcontractors" method="POST" enctype="multipart/form-data">
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
		<td align="right">Sub Contractor : </td>
			<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
			<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Project : </td>
			<td><input type='text' size='20' name='projectname' id='projectname' value='<?php echo $obj->projectname; ?>'>
			<input type="hidden" name='projectid' id='projectid' value='<?php echo $obj->projectid; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Contract No : </td>
		<td><input type="text" name="contractno" id="contractno" value="<?php echo $obj->contractno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Physical Address : </td>
		<td><textarea name="physicaladdress"><?php echo $obj->physicaladdress; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Scope Of Work : </td>
		<td><textarea name="scope"><?php echo $obj->scope; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Contract Sum : </td>
		<td><input type="text" name="value" id="value" size="8"  value="<?php echo $obj->value; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Awarded : </td>
		<td><input type="text" name="dateawarded" id="dateawarded" class="date_input" size="12" readonly  value="<?php echo $obj->dateawarded; ?>"></td>
	</tr>
	<tr>
		<td align="right">Acceptance Letter Date : </td>
		<td><input type="text" name="acceptanceletterdate" id="acceptanceletterdate" class="date_input" size="12" readonly  value="<?php echo $obj->acceptanceletterdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Contract Signed On : </td>
		<td><input type="text" name="contractsignedon" id="contractsignedon" class="date_input" size="12" readonly  value="<?php echo $obj->contractsignedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Of Order To Commence : </td>
		<td><input type="text" name="orderdatetocommence" id="orderdatetocommence" class="date_input" size="12" readonly  value="<?php echo $obj->orderdatetocommence; ?>"></td>
	</tr>
	<tr>
		<td align="right">Commencement Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected Completion Date : </td>
		<td><input type="text" name="expectedenddate" id="expectedenddate" class="date_input" size="12" readonly  value="<?php echo $obj->expectedenddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Actual Completion Date : </td>
		<td><input type="text" name="actualenddate" id="actualenddate" class="date_input" size="12" readonly  value="<?php echo $obj->actualenddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Defects Liability Period Type : </td>
		<td><select name='liabilityperiodtype' class="selectbox">
			<option value='Weeks' <?php if($obj->liabilityperiodtype=='Weeks'){echo"selected";}?>>Weeks</option>
			<option value='Months' <?php if($obj->liabilityperiodtype=='Months'){echo"selected";}?>>Months</option>
			<option value='Years' <?php if($obj->liabilityperiodtype=='Years'){echo"selected";}?>>Years</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Defects Liability Period : </td>
		<td><input type="text" name="liabilityperiod" id="liabilityperiod" value="<?php echo $obj->liabilityperiod; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><input type="text" name="statusid" id="statusid" value="<?php echo $obj->statusid; ?>"><font color='red'>*</font></td>
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