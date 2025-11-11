<title>WiseDigits ERP: Paymentvoucherdetails </title>
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
<form class="forms" id="theform" action="addpaymentvoucherdetails_proc.php" name="paymentvoucherdetails" method="POST" enctype="multipart/form-data">
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
		<td align="right">Payment Voucher : </td>
			<td><select name="paymentvoucherid" class="selectbox">
<option value="">Select...</option>
<?php
	$paymentvouchers=new Paymentvouchers();
	$where="  ";
	$fields="fn_paymentvouchers.id, fn_paymentvouchers.documentno, fn_paymentvouchers.voucherno, fn_paymentvouchers.voucherdate, fn_paymentvouchers.payee, fn_paymentvouchers.paymentmodeid, fn_paymentvouchers.bankid, fn_paymentvouchers.chequeno, fn_paymentvouchers.chequedate, fn_paymentvouchers.remarks, fn_paymentvouchers.status, fn_paymentvouchers.ipaddress, fn_paymentvouchers.createdby, fn_paymentvouchers.createdon, fn_paymentvouchers.lasteditedby, fn_paymentvouchers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentvouchers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($paymentvouchers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentvoucherid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Cash Requisition : </td>
			<td><select name="cashrequisitionid" class="selectbox">
<option value="">Select...</option>
<?php
	$cashrequisitions=new Cashrequisitions();
	$where="  ";
	$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno, fn_cashrequisitions.projectid, fn_cashrequisitions.employeeid, fn_cashrequisitions.description, fn_cashrequisitions.amount, fn_cashrequisitions.status, fn_cashrequisitions.remarks, fn_cashrequisitions.ipaddress, fn_cashrequisitions.createdby, fn_cashrequisitions.createdon, fn_cashrequisitions.lasteditedby, fn_cashrequisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($cashrequisitions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->cashrequisitionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Payment Requisition : </td>
			<td><select name="paymentrequisitionid" class="selectbox">
<option value="">Select...</option>
<?php
	$paymentrequisitions=new Paymentrequisitions();
	$where="  ";
	$fields="fn_paymentrequisitions.id, fn_paymentrequisitions.documentno, fn_paymentrequisitions.supplierid, fn_paymentrequisitions.invoicenos, fn_paymentrequisitions.amount, fn_paymentrequisitions.requisitiondate, fn_paymentrequisitions.remarks, fn_paymentrequisitions.status, fn_paymentrequisitions.ipaddress, fn_paymentrequisitions.createdby, fn_paymentrequisitions.createdon, fn_paymentrequisitions.lasteditedby, fn_paymentrequisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($paymentrequisitions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentrequisitionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"><font color='red'>*</font></td>
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