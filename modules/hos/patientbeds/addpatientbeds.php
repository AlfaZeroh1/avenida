<title>WiseDigits: Patientbeds </title>
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

<div class='main'>
<form class="forms" id="theform" action="addpatientbeds_proc.php" name="patientbeds" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Bed : </td>
		<td><input type="text" name="bedid" id="bedid" value="<?php echo $obj->bedid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Patient : </td>
		<td><input type="text" name="patientid" id="patientid" value="<?php echo $obj->patientid; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="treatmentid" id="treatmentid" value="<?php echo $obj->treatmentid; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="allocatedon" id="allocatedon" class="date_input" size="12" readonly  value="<?php echo $obj->allocatedon; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="lefton" id="lefton" class="date_input" size="12" readonly  value="<?php echo $obj->lefton; ?>"></td>
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