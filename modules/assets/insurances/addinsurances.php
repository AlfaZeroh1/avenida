<title>WiseDigits: Insurances </title>
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
<form class="forms" id="theform" action="addinsurances_proc.php" name="insurances" method="POST" enctype="multipart/form-data">
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
		<td align="right">Asset : </td>
		<td><input type="text" name="assetid" id="assetid" value="<?php echo $obj->assetid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Insurer : </td>
		<td><input type="text" name="insurerid" id="insurerid" value="<?php echo $obj->insurerid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Insur. Company : </td>
		<td><input type="text" name="insurcompany" id="insurcompany" value="<?php echo $obj->insurcompany; ?>"></td>
	</tr>
	<tr>
		<td align="right">Ref. # : </td>
		<td><input type="text" name="refno" id="refno" value="<?php echo $obj->refno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Insurance Date : </td>
		<td><input type="text" name="insuredon" id="insuredon" class="date_input" size="12" readonly  value="<?php echo $obj->insuredon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Scanned Copy : </td>
		<td><input type="text" name="file" id="file" value="<?php echo $obj->file; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expiry Date : </td>
		<td><input type="text" name="expireson" id="expireson" class="date_input" size="12" readonly  value="<?php echo $obj->expireson; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" class="btn btn-primary" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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