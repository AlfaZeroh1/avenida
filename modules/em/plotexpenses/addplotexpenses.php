<title>WiseDigits: Plotexpenses </title>
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
	else if(str.value==7)
	{
		imprest.style.display="block";
		cheque.style.display="none";
		bank.style.display="none";
		text.innerHTML="show";
	}
	else
	{
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		text.innerHTML="show";
	}		
	
}
function hideShow(id){
var s = document.getElementById(id).style;
s.visibility=s.visibility=='hidden'?'visible':'hidden'; 
}
function hide(id){
var s = document.getElementById(id).style;
s.visibility='hidden'; 
}
this.value="<?php echo $obj->paymentmodeid; ?>";
womAdd('loadPaymentModes(this)');
womOn();

</script>
<script type="text/javascript">
$().ready(function() {
  $("#plotname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=plots&field=concat(code,' ',name)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#plotid").val(ui.item.id);
	}
  });

});

function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print invoice?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?doc=<?php echo $obj->documentno; ?>&plotid=<?php echo $obj->plotid; ?>&paidon=<?php echo $obj->expensedate; ?>&copy=<?php echo $obj->retrieve; ?>",450,940);
	}
}

<?php include'js.php'; ?>
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

<form action="addplotexpenses_proc.php" name="plotexpenses" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
			<?php if(!empty($obj->retrieve)){?>
		<tr>
			<td colspan="2" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Voucher No:<input type="text" size="4" name="voucherno"/>&nbsp;<input type="submit" name="action2" value="Filter"/></td>
		</tr>
		<?php }?>
			<tr>
				<td>Plot:<input type='text' size='20' name='plotname' id='plotname' value='<?php echo $obj->plotname; ?>'>
					<input type="hidden" name='plotid' id='plotid' value='<?php echo $obj->plotid; ?>'></td>
				<td>
				  Payment Term: <select name="paymenttermid"  class="selectbox" id="paymenttermid" >
<option value="">Select...</option>
<?php
	$paymentterms=new Paymentterms();
	$where="  ";
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($paymentterms->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->paymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
				</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Expense  </th>
		<th align="right">Quantity  </th>
		<th align="right">Amount  </th>
		<th align="right">Remarks  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="expenseid" class="selectbox">
<option value="">Select...</option>
<?php
	$expenses=new Expenses();
	$where="  ";
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($expenses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->expenseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="amount" id="amount" onchange="calculateTotal();" size="4" value="<?php echo $obj->amount; ?>"></td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add" class="btn"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		<div style="float:left;">
		Document No:<input type="text" name="documentno" id="documentno"  size="6" readonly="readonly"  value="<?php echo $obj->documentno; ?>">
		Expense Date:<input type="text" name="expensedate" id="expensedate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->expensedate; ?>">
		Month:<select name="month" id="month" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select>
		Year:<select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select>
        </div>
        <div id="paymentmodeid" style="float:left;">
        Payment Mode:				<select name='paymentmodeid' class="selectbox" onchange="loadPaymentModes(this);">
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.remarks";
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
	<div id="bankdiv" style="float:left;">
		Bank:				<select name='bankid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
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
	<div id="chequediv" style="float:left;">
		Cheque No:<input type="text" name="chequeno" id="chequeno"  size="8"  value="<?php echo $obj->chequeno; ?>">&nbsp;
		&nbsp;
		</div>
	<div id="imprestdiv">
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
		</select>&nbsp;
      </div>
		PV No:<input type="text" name="pcvno" value="<?php echo $obj->pcvno; ?>"/>
			</td>
			</tr>
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Expense  </th>
		<th align="left">Quantity  </th>
		<th align="left">Amount  </th>
		<th align="left">Remarks  </th>
		<th align='left'>Total</th>
		<th><input type="text" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	//$ob = str_replace('&','',base64_encode(serialize($obj)));
	$ob = str_replace('&','',serialize($obj));
	if($_SESSION['shpplotexpenses']){
		$shpplotexpenses=$_SESSION['shpplotexpenses'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpplotexpenses[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpplotexpenses[$i]['expensename']; ?> </td>
			<td><?php echo $shpplotexpenses[$i]['quantity']; ?> </td>
			<td align="right"><?php echo formatNumber($shpplotexpenses[$i]['amount']); ?> </td>
			<td><?php echo $shpplotexpenses[$i]['remarks']; ?> </td>
			<td align="right"><?php echo formatNumber($shpplotexpenses[$i]['total']); ?> </td>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>&obj=<?php  echo $ob; ?>'>Edit</a></td>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>&obj=<?php  echo $ob; ?>'>Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center">
	<tr>
		<td colspan="2" align="center">Total:<input type="text" name="ttotal" size='12' readonly value="<?php echo $total; ?>"/></td>	</tr>
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
if($saved=="Yes")
{
	?>
    <script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
    <?
    
    redirect("addplotexpenses_proc.php");
  }
if(!empty($error)){
	showError($error);
}
?>