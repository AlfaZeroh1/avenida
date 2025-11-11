<title>WiseDigits: Etransactions </title>
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
<form class="forms" id="theform" action="addetransactions_proc.php" name="etransactions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="Txnid" id="Txnid" value="<?php echo $obj->Txnid; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="id" id="id" value="<?php echo $obj->id; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="orig" id="orig" value="<?php echo $obj->orig; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="dest" id="dest" value="<?php echo $obj->dest; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="tstamp" id="tstamp" class="date_input" size="12" readonly  value="<?php echo $obj->tstamp; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="details" id="details" value="<?php echo $obj->details; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="username" id="username" value="<?php echo $obj->username; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="pass" id="pass" value="<?php echo $obj->pass; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="mpesa_code" id="mpesa_code" value="<?php echo $obj->mpesa_code; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="mpesa_acc" id="mpesa_acc" value="<?php echo $obj->mpesa_acc; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="mpesa_msisdn" id="mpesa_msisdn" value="<?php echo $obj->mpesa_msisdn; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="mpesa_trx_date" id="mpesa_trx_date" class="date_input" size="12" readonly  value="<?php echo $obj->mpesa_trx_date; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="mpesa_trx_time" id="mpesa_trx_time" value="<?php echo $obj->mpesa_trx_time; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="mpesa_amt" id="mpesa_amt" size="8"  value="<?php echo $obj->mpesa_amt; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="mpesa_sender" id="mpesa_sender" value="<?php echo $obj->mpesa_sender; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="updatecode" id="updatecode" value="<?php echo $obj->updatecode; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="UpdateDateTime" id="UpdateDateTime" class="date_input" size="12" readonly  value="<?php echo $obj->UpdateDateTime; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="dac_charge" id="dac_charge" size="8"  value="<?php echo $obj->dac_charge; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="council_amt" id="council_amt" size="8"  value="<?php echo $obj->council_amt; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="slot_id" id="slot_id" value="<?php echo $obj->slot_id; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="Vehicle_Reg" id="Vehicle_Reg" value="<?php echo $obj->Vehicle_Reg; ?>"><font color='red'>*</font></td>
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