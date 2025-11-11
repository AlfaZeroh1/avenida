<title>WiseDigits: Plotpaymentdetails </title>
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

<form class="forms" action="addplotpaymentdetails_proc.php" name="plotpaymentdetails" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Plot : </td>
		<td><input type="text" name="plotid" id="plotid" value="<?php echo $obj->plotid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Bank : </td>
		<td><input type="text" name="bank" id="bank" size="45"  value="<?php echo $obj->bank; ?>"></td>
	</tr>
	<tr>
		<td align="right">Account No : </td>
		<td><input type="text" name="accntno" id="accntno" value="<?php echo $obj->accntno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Payment Date : </td>
		<td><input type="text" name="paidon" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Payment Mode : </td>
			<td><select class="selectbox" name="paymentmodeid">
<option value="">Select...</option>
<?php
	$paymentmodes=new Paymentmodes();
	$where="  ";
	$fields="sys_paymentmodes.id, sys_paymentmodes.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($paymentmodes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentmodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">VAT Reg No : </td>
		<td><input type="text" name="vatno" id="vatno" value="<?php echo $obj->vatno; ?>"></td>
	</tr>
	<tr>
		<td align="right">PIN : </td>
		<td><input type="text" name="pin" id="pin" value="<?php echo $obj->pin; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cheques To : </td>
		<td><input type="text" name="chequesto" id="chequesto" size="45"  value="<?php echo $obj->chequesto; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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