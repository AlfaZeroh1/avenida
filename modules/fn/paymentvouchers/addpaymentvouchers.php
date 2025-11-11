<title>WiseDigits ERP: Paymentvouchers </title>
<?php 
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

<hr>
<div class="content">
<form class="forms" id="theform" action="addpaymentvouchers_proc.php" name="paymentvouchers" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
		      <tr>
				<td><label>Document No:</label></td>
<td><input type="text" readonly name="documentno" id="documentno" size="20"  value="<?php echo $obj->documentno; ?>">			</td>
			</tr>
			<tr>
				<td><label>Payment Voucher No:</label></td>
<td><input type="text" name="voucherno" id="voucherno" size="20"  value="<?php echo $obj->voucherno; ?>">			</td>
			</tr>
			<tr>
				<td><label>Voucher Date:</label></td>
<td><input type="text" name="voucherdate" id="voucherdate" class="date_input" size="12" readonly  value="<?php echo $obj->voucherdate; ?>">			</td>
			</tr>
			<tr>
				<td><label>Payee:</label></td>
<td><input type="text" name="payee" id="payee" size="20"  value="<?php echo $obj->payee; ?>">			</td>
			</tr>
			<tr>
				<td><label>Payment Mode:</label></td>
<td><select name="paymentmodeid" id="paymentmodeid" class="selectbox">
<option value="">Select...</option>
<?php
	$paymentmodes=new Paymentmodes();
	$where="  ";
	$fields="*";
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
</select></td>			</td>
			</tr>
			<tr>
				<td><label>Bank:</label></td>
<td><select name="bankid" id="bankid" class="selectbox">
<option value="">Select...</option>
<?php
	$banks=new Banks();
	$where="  ";
	$fields="*";
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
</select></td>			</td>
			</tr>
			<tr>
				<td><label>Cheque No:</label></td>
<td><input type="text" name="chequeno" id="chequeno" size="20"  value="<?php echo $obj->chequeno; ?>">			</td>
			</tr>
			<tr>
				<td><label>Cheque Date:</label></td>
<td><input type="text" name="chequedate" id="chequedate" class="date_input" size="12" readonly  value="<?php echo $obj->chequedate; ?>">			</td>
			</tr>
			<tr>
			<td>
		<label>Remarks:</label>			</td>
			<td>
<textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea>			</td>
			</tr>
			</td>
			</tr>			
			
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Cash Requisition  </th>
		<th align="right">Payment Requisition  </th>
		<th align="right">Amount  </th>
		<th align="right">Remarks  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="cashrequisitionid"  class="selectbox">
<option value="">Select...</option>
<?php
	$cashrequisitions=new Cashrequisitions();
	$where=" where status='approved' ";
	$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))employeeid, fn_cashrequisitions.description, fn_cashrequisitiondetails.amount";
	$join=" left join hrm_employees on hrm_employees.id=fn_cashrequisitions.employeeid left join fn_cashrequisitiondetails on fn_cashrequisitiondetails.cashrequisitionid=fn_cashrequisitions.id ";
	$having="";
	$groupby="";
	$orderby="";
	$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($cashrequisitions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->cashrequisitionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->documentno);?> - <?php echo initialCap($rw->employeeid);?> - <?php echo formatNumber($rw->amount);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><select name="paymentrequisitionid"  class="selectbox">
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
		<td><input type="text" name="amount" id="amount" size="20" value="<?php echo $obj->amount; ?>"><font color='red'>*</font></td>
		<td><textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Cash Requisition  </th>
		<th align="left">Payment Requisition  </th>
		<th align="left">Amount  </th>
		<th align="left">Remarks  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shppaymentvouchers']){
		$shppaymentvouchers=$_SESSION['shppaymentvouchers'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shppaymentvouchers[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shppaymentvouchers[$i]['cashrequisitionname']; ?> </td>
			<td><?php echo $shppaymentvouchers[$i]['paymentrequisitionname']; ?> </td>
			<td><?php echo $shppaymentvouchers[$i]['amount']; ?> </td>
			<td><?php echo $shppaymentvouchers[$i]['remarks']; ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" width="100%">
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
	<tr>
		<th colspan='2'>Paymentvoucherdetails </th>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<table align='left'>
			<tr>
				<td>&nbsp;</td>
				<td valign="bottom">Cash Requisition : <select name='paymentvoucherdetailscashrequisitionid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$cashrequisitions=new Cashrequisitions();
				$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno, fn_cashrequisitions.projectid, fn_cashrequisitions.employeeid, fn_cashrequisitions.description, fn_cashrequisitions.amount, fn_cashrequisitions.status, fn_cashrequisitions.remarks, fn_cashrequisitions.ipaddress, fn_cashrequisitions.createdby, fn_cashrequisitions.createdon, fn_cashrequisitions.lasteditedby, fn_cashrequisitions.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($cashrequisitions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->cashrequisitionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Payment Requisition : <select name='paymentvoucherdetailspaymentrequisitionid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$paymentrequisitions=new Paymentrequisitions();
				$fields="fn_paymentrequisitions.id, fn_paymentrequisitions.documentno, fn_paymentrequisitions.supplierid, fn_paymentrequisitions.invoicenos, fn_paymentrequisitions.amount, fn_paymentrequisitions.requisitiondate, fn_paymentrequisitions.remarks, fn_paymentrequisitions.status, fn_paymentrequisitions.ipaddress, fn_paymentrequisitions.createdby, fn_paymentrequisitions.createdon, fn_paymentrequisitions.lasteditedby, fn_paymentrequisitions.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$paymentrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentrequisitions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentrequisitionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Requisition No : <input type="text" name="paymentvoucherdetailsdocumentno" size="8" ></td>
				<td valign="bottom">Amount : <input type="text" name="paymentvoucherdetailsamount" size="4" ></td>
				<td valign="bottom">Remarks : <textarea name="paymentvoucherdetailsremarks"><?php echo $obj->paymentvoucherdetailsremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Paymentvoucherdetail" name="action"></td>
			</tr>
<?php
		$paymentvoucherdetails=new Paymentvoucherdetails();
		$i=0;
		$fields="fn_paymentvoucherdetails.id, fn_paymentvouchers.name as paymentvoucherid, fn_cashrequisitions.name as cashrequisitionid, fn_paymentrequisitions.name as paymentrequisitionid, fn_paymentvoucherdetails.amount, fn_paymentvoucherdetails.remarks, fn_paymentvoucherdetails.ipaddress, fn_paymentvoucherdetails.createdby, fn_paymentvoucherdetails.createdon, fn_paymentvoucherdetails.lasteditedby, fn_paymentvoucherdetails.lasteditedon";
		$join=" left join fn_paymentvouchers on fn_paymentvoucherdetails.paymentvoucherid=fn_paymentvouchers.id  left join fn_cashrequisitions on fn_paymentvoucherdetails.cashrequisitionid=fn_cashrequisitions.id  left join fn_paymentrequisitions on fn_paymentvoucherdetails.paymentrequisitionid=fn_paymentrequisitions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_paymentvoucherdetails.paymentvoucherid='$obj->id'";
		$paymentvoucherdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$paymentvoucherdetails->affectedRows;
		$res=$paymentvoucherdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->cashrequisitionid; ?></td>
				<td><?php echo $row->paymentrequisitionid; ?></td>
				<td><?php echo $row->documentno; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addpaymentvouchers_proc.php?id=<?php echo $obj->id; ?>&paymentvoucherdetails=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</td>
	</tr>
	<tr>
	<td colspan='<?php echo ($num+2); ?>'><hr/></td>
	</tr>
<?php }?>
</table>
</form>
</hr>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
if($saved=="Yes"){
	redirect("addpaymentvouchers_proc.php?retrieve=");
}

?>