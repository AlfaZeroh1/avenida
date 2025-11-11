<title>WiseDigits: Payments </title>
<?php 
include "../../../head.php";

?>
<script language="javascript1.1" type="text/javascript">
// hide divs

function loadPaymentModes(str)
{
	var bank = document.getElementById("bankdiv");
	var cheque = document.getElementById("chequediv");
	var imprest = document.getElementById("imprestdiv");
	
	if(str.value==null || str.value==1)
	{
		//do nothing
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		text.innerHTML="show";
		
	}
	else if(str.value==2 || str.value==3)
	{
		bank.style.display="block";
		cheque.style.display="block";
		imprest.style.display="none";
		text.innerHTML="show";
	}
// 	else if(str.value==7)
// 	{
// 		imprest.style.display="block";
// 		cheque.style.display="none";
// 		bank.style.display="none";
// 		text.innerHTML="show";
// 	}
	else
	{
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		text.innerHTML="show";
	}		
	
}

var s = "<?php echo $obj->paymentmodeid; ?>";

 </script>
  <script type="text/javascript" charset="utf-8">
$().ready(function() {
  $("#patientname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patients&field=concat(surname,' ',othernames)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientid").val(ui.item.id);
	}
  });

	 
  $("#insurancename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=insurances&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#insuranceid").val(ui.item.id);
	}
  });

	 
	});
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
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
	TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#table').dataTable( {
 		"sScrollY": 180,
 		"sDom": 'T<"H"lfr>t<"F"ip>',
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>
 
 
  <script type="text/javascript">

function loadPaymentModes(str)
{
	var bank = document.getElementById("bankdiv");
	var cheque = document.getElementById("chequediv");
	var imprest = document.getElementById("imprestdiv");
	var landi = document.getElementById("landlorddiv");
	
	if(str.value==null || str.value==1)
	{
		//do nothing
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		landi.style.display="none";
		
		
		document.getElementById("bankid").value="NULL";
		document.getElementById("imprestaccountid").value="NULL";
		text.innerHTML="show";
	}
	else if(str.value==2 || str.value==3)
	{
		bank.style.display="block";
		cheque.style.display="block";
		imprest.style.display="none";
		landi.style.display="none";
		document.getElementById("imprestaccountid").value="NULL";
		text.innerHTML="show";
	}
	else if(str.value==5)
	{
		landi.style.display="block";
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		
		document.getElementById("bankid").value="NULL";
		document.getElementById("imprestaccountid").value="NULL";
		text.innerHTML="show";
	}
	
	
	else if(str.value==7)
	{
		imprest.style.display="block";
		cheque.style.display="none";
		bank.style.display="none";
		landi.style.display="none";
		document.getElementById("bankid").value="NULL";
		text.innerHTML="show";
	}
	else
	{
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		landi.style.display="none";
		document.getElementById("bankid").value="NULL";
		document.getElementById("imprestaccountid").value="NULL";
		text.innerHTML="show";
	}		
	
}

this.value="<?php echo $obj->paymentmodeid; ?>";
womAdd('loadPaymentModes(this)');
womOn();

function clickHereToPrint(bool)
{ 
	var msg;
	if(bool)
	  msg="Do you want to print Receipt?";
	else
	  msg="Do you want to print Invoice?";
	var ans=confirm(msg);
	if(ans)
	{
		if(bool)
		  poptastic("print.php?documentno=<?php echo $obj->documentno;?>&status=<?php echo $obj->status; ?>&observation=<?php echo $obj->observation;?>&symptoms=<?php echo $obj->symptoms; ?>&hpi=<?php echo $obj->hpi;?>&obs=<?php echo $obj->obs;?>&findings=<?php echo $obj->findings;?>&history=<?php echo $obj->history;?>&diagnosis=<?php echo $obj->diagnosis;?>&laboratory=<?php echo $obj->laboratory;?>&other=<?php echo $obj->other;?>&prescription=<?php echo $obj->prescription;?>&payments=<?php echo $obj->payments;?>",700,1020);
		else{
		  <?php $_SESSION['obj']=$obj; ?>
		   poptastic('print1.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>&treatmentno=<?php echo $obj->treatmentno; ?>&documentno=<?php echo $obj->documentno; ?>',700,1020);
		}
	}
}
 </script>

 
<!--<script type="text/javascript">
 function clickHereToPrint(){
		poptastic("print.php?documentno=<?php echo $obj->documentno;?>&observation=<?php echo $obj->observation;?>&symptoms=<?php echo $obj->symptoms; ?>&hpi=<?php echo $obj->hpi;?>&obs=<?php echo $obj->obs;?>&findings=<?php echo $obj->findings;?>&history=<?php echo $obj->history;?>&diagnosis=<?php echo $obj->diagnosis;?>&laboratory=<?php echo $obj->laboratory;?>&other=<?php echo $obj->other;?>&prescription=<?php echo $obj->prescription;?>&payments=<?php echo $obj->payments;?>",700,1020);
 }
		</script-->
<div class="content">
<form action="addpayments_proc.php" name="payments" class="forms" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
			<?php if(!empty($obj->retrieve)){?>
			<tr>
			  <td>Receipt No:</td>
			  <td><input type="text" name="receiptno" value="<?php echo $obj->receiptno; ?>"/>
			  <input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>
			  <input type="submit" name="action2" value="Filter"/>
			</tr>
			<?php
			}
			else{
			?>
	
			<tr>
				<td><input type="hidden" name="status" value="<?php echo $obj->status; ?>"/>Treatment No:</td>
				<td>
				<select name="consult" class="selectbox">
				<option value='1' <?php if($obj->consult==1){echo"selected";}?>>Consulted with Doctor</option>
				<option value='0' <?php if($obj->consult==0){echo"selected";}?>>No Consulting</option>
				</select>
				<input type="text" size="4" name="treatmentid" value="<?php echo $obj->treatmentid; ?>"/>&nbsp;<input type="submit" name="action3" value="Retrieve"/></td>
			</tr>
			<tr>
				<td>Patient:</td>
				<td><input type='text' size='36' name='patientname' id='patientname' value='<?php echo $obj->patientname; ?>'>
					<input type="text" readonly name='patientid' id='patientid' value='<?php echo $obj->patientid; ?>'></td>
				<td>Patient No:</td>
				<td><input type='text' name='patientno' id='patientno' size='8' readonly value='<?php echo $obj->patientno; ?>'/></td>			
				</tr>
				<tr>
				<td>Address:</td>
				<td><textarea name='address' id='address' readonly><?php echo $obj->address; ?></textarea></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
			
<!--			<td>&nbsp;</td>-->
			<td>&nbsp;</td>
			
			<td><input type="button"  class="btn" style="color:red;" onclick="clickHereToPrint(false);" value="Print Invoice"/></td>
			
			
			</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="4" align="center"></td>
			</tr>
		</table>
		<?php //if($obj->action3=="Retrieve"){?>
		<table  class="" cellspacing="0" width="50%" id="">
			<thead>
			<tr>
				<th>#</th>
				<th>Transaction</th>
				<th>Remarks</th>
				<th>Date</th>
				<th>Amount</th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			$i=0;
			$balance=0;
			$payables = new Payables();
			$fields="hos_payables.id, hos_payables.documentno, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, sys_transactions.name as transactionid, hos_payables.treatmentno,hos_payables.departmentid, hos_payables.amount, hos_payables.remarks, hos_payables.invoicedon, hos_payables.consult, hos_payables.paid, hos_payables.createdby, hos_payables.createdon, hos_payables.lasteditedby, hos_payables.lasteditedon";
			$join=" left join hos_patients on hos_payables.patientid=hos_patients.id  left join sys_transactions on hos_payables.transactionid=sys_transactions.id ";
			$having="";
			$groupby="";
			$orderby="";
			//when after treatment and for treatment charges only
			
			$query="select * from hos_patienttreatments where patientappointmentid='$obj->treatmentid'";//echo $query;  
			$rs = mysql_query($query);
			if(mysql_affected_rows()>0){ 
			  //this means treatment has happened already
			  $rw = mysql_fetch_object($rs);
			  $where=" where ((hos_payables.treatmentno='$obj->treatmentid') or (hos_payables.treatmentno='$rw->patientappointmentid' ))";
			}
			else{
			  $where="where hos_payables.treatmentno='$obj->treatmentid' ";
			  $query="select * from hos_patienttreatments where patientappointmentid='$obj->treatmentid'";
			  mysql_query($query);
			  if(mysql_affected_rows()==0)
			    $where.="  ";
			}
			
			if(empty($where))
			  $where.=" where ";
			else
			  $where.=" and ";
			$where.=" hos_payables.consult = '$obj->consult' and patientid='$obj->patientid' ";
			$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $payables->sql;
			$res=$payables->result;
			if(!empty($obj->treatmentid)){
			  while($row=mysql_fetch_object($res)){$i++;
			  
			  $payments = new Payments();
			  $fields=" sum(amount) amount ";
			  $join="";
			  $where=" where payableid='$row->id' ";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $payments->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $payments->sql;
			  $payments=$payments->fetchObject;
			  
			  
			  if($row->paid=="No" or empty($row->paid))
			    $balance+=$row->amount-$payments->amount;
				  ?>
				  <tr <?php if($row->paid=="No" or empty($row->paid)){?>bgcolor="red"<?php }elseif(!empty($payments->amount) and (($row->amount-$payments->amount)>0)){?>bgcolor="orange"<?} else{?>bgcolor="green"<?php }?>>
					  <td style="border-bottom:1px solid white; " ><?php echo $i; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->transactionid; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->remarks; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->invoicedon; ?></td>
					  <td style="border-bottom:1px solid white; " align="right">&nbsp;<?php echo formatNumber($row->amount-$payments->amount); ?></td>
					  <td style="border-bottom:1px solid white;" >&nbsp;<?php if($row->paid=="No" or empty($row->paid) or ($payments->amount<$row->amount)){?><a href="?tid=<?php echo $row->id; ?>&treatmentid=<?php echo $obj->treatmentid; ?>&departmentid=<?php echo $row->departmentid; ?>&action3=Retrieve&iterator=<?php echo $obj->iterator; ?>&patientid=<?php echo $obj->patientid; ?>&consult=<?php echo $obj->consult;?>">Pay</a><?php }?></td>
				  </tr>
				  <?php 
			  }
			  }
			?>
			</tbody>
			<tfoot>
			<tr>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white; ">Balance:</th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white; " align="right" bgcolor="green"><?php echo formatNumber($balance); ?></th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
		      </tr>
		      </tfoot>
		</table>
		<?php //}?>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Bill Term  </th>
		<th align="right">Amount  </th>
		<th align="right">Remarks  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td>
		<input type="hidden" value="<?php echo $obj->tid; ?>" name="tid"/>
		<input type="hidden" value="<?php echo $obj->payableid; ?>" name="payableid"/>
		<input type="hidden" value="<?php echo $obj->departmentid; ?>" name="departmentid"/>
		<select name="transactionid" class="selectbox" >
<option value="">Select...</option>
<?php
	$transactions=new Transactions();
	$where=" where sys_transactions.moduleid=8 ";
	$fields="sys_transactions.id, sys_transactions.name, sys_transactions.moduleid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($transactions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->transactionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><input type="text" name="amount" id="amount" size="8" value="<?php echo $obj->amount; ?>"></td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input class="btn" type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
			<div id="paymentmodeid" style="float:left;">
		Receipt No:<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>">
		Payment Date:<input type="text" name="paidon" id="paidon" readonly class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>">
		Payee:<input type="text" name="payee" id="payee"  size="12"  value="<?php echo $obj->payee; ?>">
		Treatment No:<input type="text" name="treatmentno" id="treatmentno" size="8"  value="<?php echo $obj->treatmentno; ?>">
		</div>
		<div id="paymentmodediv" style="float:left;">
		Payment Mode:				<select class="selectbox" name='paymentmodeid' onchange="loadPaymentModes(this);">
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$fields="sys_paymentmodes.id, sys_paymentmodes.name";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentmodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentmodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
				</div>
				<div id="bankdiv"  style="float:left;">
		Bank:				<select class="selectbox" name='bankid'> 
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($banks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->bankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
				</div>
				<div id="chequediv"  style="float:left;">
		Cheque No:<input type="text" name="chequeno" id="chequeno" value="<?php echo $obj->chequeno; ?>">
		&nbsp;
		</div>
		<div id="imprestdiv"  style="float:left;">
		Imprest Accounts: <select name="imprestaccountid" class="selectbox">
		<option value="">Select....</option>
		<?php
		$imprestaccounts = new ImprestAccounts();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		while($rw=mysql_fetch_object($imprestaccounts->result)){
		?>
		  <option value="<?php echo $rw->id; ?>" <?php if($obj->imprestaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		<?php
		}
		?>
		</select>
		&nbsp;
		</div>
		<div id="landlorddiv" style="float:left;">
		
			Insurances: <select name="insuranceid" id="insuranceid" class="selectbox">
		<option value="">Select....</option>
		<?php
		$insurances = new Insurances();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		while($rw=mysql_fetch_object($insurances->result)){
		?>
		  <option value="<?php echo $rw->id; ?>" <?php if($obj->insuranceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		<?php
		}
		?>
		</select>
		&nbsp;
		</div>
			</td>
			
			</tr>
			
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Bill Term  </th>
		<th align="left">Amount  </th>
		<th align="left">Remarks  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shppayments']){
		$shppayments=$_SESSION['shppayments'];
		$i=0;
		$j=count($shppayments);
		$total=0;
		while($j>0){

		$total+=$shppayments[$i]['amount'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1)."==".$shppayments[$i]['payableid']; ?></td>
			<td><?php echo $shppayments[$i]['transactionname']; ?> </td>
			<td><?php echo $shppayments[$i]['amount']; ?> </td>
			<td><?php echo $shppayments[$i]['remarks']; ?> </td>
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
<table align="center" style="margin-left:40%;">
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" class="btn" name="action" id="action" value="Print" onclick="clickHereToPrint(true);"/></td>
        </tr>
	<?php }?>
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
if($saved=="Yes"){
?>
<script type="text/javascript">clickHereToPrint(true);</script>
<?php 
redirect("addpayments_proc.php");
}
?>