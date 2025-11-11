<title>WiseDigits: Employeeassignments </title>
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

<form action="addemployeeassignments_proc.php" name="employeeassignments"  method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
		<td><input type="text" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Assignment : </td>
		<td><input type="text" name="assignmentid" id="assignmentid" value="<?php echo $obj->assignmentid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Date Assigned : </td>
		<td><input type="text" name="fromdate" id="fromdate" class="date_input" size="12" readonly  value="<?php echo $obj->fromdate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Date Moved : </td>
		<td><input type="text" name="todate" id="todate" class="date_input" size="12" readonly  value="<?php echo $obj->todate; ?>"></td>
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