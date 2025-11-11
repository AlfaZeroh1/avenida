<title>WiseDigits ERP: Purchasepayments </title>
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
<form  id="theform" action="addpurchasepayments_proc.php" name="purchasepayments" method="POST" enctype="multipart/form-data">
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
		<td align="right">Document No. : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Invoive No. : </td>
		<td><input type="text" name="invoiceno" id="invoiceno" value="<?php echo $obj->invoiceno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Supplier : </td>
			<td><select name="supplierid" class="selectbox">
<option value="">Select...</option>
<?php
	$suppliers=new Suppliers();
	$where="  ";
	$fields="pos_suppliers.id, pos_suppliers.code, pos_suppliers.name, pos_suppliers.contact, pos_suppliers.address, pos_suppliers.telephone, pos_suppliers.fax, pos_suppliers.email, pos_suppliers.mobile, pos_suppliers.status, pos_suppliers.createdby, pos_suppliers.createdon, pos_suppliers.lasteditedby, pos_suppliers.lasteditedon, pos_suppliers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($suppliers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->supplierid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Payment Mode : </td>
			<td><select name="paymentmodeid" class="selectbox">
<option value="">Select...</option>
<?php
	$paymentmodes=new Paymentmodes();
	$where="  ";
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
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
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Bank : </td>
			<td><select name="bankid" class="selectbox">
<option value="">Select...</option>
<?php
	$banks=new Banks();
	$where="  ";
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($banks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->bankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Cheque No. : </td>
		<td><input type="text" name="chequeno" id="chequeno" value="<?php echo $obj->chequeno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Paid On : </td>
		<td><input type="text" name="paidon" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Offset : </td>
		<td><input type="text" name="offsetid" id="offsetid" value="<?php echo $obj->offsetid; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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