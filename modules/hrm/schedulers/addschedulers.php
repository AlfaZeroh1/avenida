<title>WiseDigits: Schedulers </title>
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
 } );
 </script>

<form action="addschedulers_proc.php" name="schedulers" method="POST"  enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
		<td><input type="text" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Assignment : </td>
		<td><input type="text" name="assignmentid" id="assignmentid" value="<?php echo $obj->assignmentid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Schedule Date : </td>
		<td><input type="text" name="scheduledate" id="scheduledate" class="date_input" size="12" readonly  value="<?php echo $obj->scheduledate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Created By : </td>
		<td><input type="text" name="createby" id="createby" value="<?php echo $obj->createby; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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