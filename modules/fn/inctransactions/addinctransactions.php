<title>WiseDigits: Exptransactions </title>
<?php 
include "../../../head.php";

?>
<script language="javascript" type="text/javascript">
// hide divs
function loadPaymentModes(str)
{	
      
	var bank = document.getElementById("bankdiv");
	var cheque = document.getElementById("chequediv");
	var imprest = document.getElementById("imprestdiv");
	//var landi = document.getElementById("landlorddiv");
	
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
</script>
<script language="javascript" type="text/javascript">
// hide divs
function loadP(str)
{	
      
	var pm = document.getElementById("paymentmodeid");
	
	if(str.value==null || str.value==1)
	{
		//do nothing
		pm.style.display="block";;
		text.innerHTML="show";
		
	}
	else if(str.value==2)
	{
		pm.style.display="none";
		text.innerHTML="show";
	}
		
	
}
function Clickheretoprint()
{ 
	var msg;
	var total=document.getElementById("ttotal").value;
	msg="Do you want to print Voucher?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?doc=<?php echo $obj->documentno; ?>&customerid=<?php echo $obj->customerid; ?>&paidon=<?php echo $obj->incomedate; ?>&plotid=<?php echo $obj->plotid; ?>&copy=<?php echo $obj->retrieve; ?>&total=<?php echo $obj->total; ?>",450,940);
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
this.value="<?php echo $obj->purchasemodeid; ?>";
womAdd('loadP(this)');
womOn();

</script>

<script type="text/javascript">
$().ready(function() {
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
		$("#address").val(ui.item.address);
		$("#tel").val(ui.item.tel);
		$("#remarks").val(ui.item.remarks);
	}
  });

  $("#projectname").autocomplete({
	source:"../../../modules/server/server/search.php?main=con&module=projects&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectid").val(ui.item.id);
	}
  });

});
<?php include'js.php'; ?>

function loadP(str)
{	
      
	var pm = document.getElementById("paymentmodeid");
	
	if(str.value==null || str.value==1)
	{
		//do nothing
		pm.style.display="block";;
		text.innerHTML="show";
		
	}
	else if(str.value==2)
	{
		pm.style.display="none";
		text.innerHTML="show";
	}
		
	
}
this.value="<?php echo $obj->purchasemodeid; ?>";
womAdd('loadP(this)');

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

this.value="<?php echo $obj->paymentmodeid; ?>";
womAdd('loadPaymentModes(this)');
womOn();

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

<hr>
<div class="content">
<form class="forms" id="theform" action="addinctransactions_proc.php" name="inctransactions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Voucher No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action2" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Customer:</label></td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'></td>
				<td><label>Address:</label></td>
				<td><textarea name='address' id='address' readonly><?php echo $obj->address; ?></textarea></td>
			<tr>
				<td><label>TelNo.:</label></td>
				<td><input type='text' name='tel' id='tel' size='20' readonly value='<?php echo $obj->tel; ?>'/></td>				<td><label>Remarks:</label></td>
				<td><textarea name='remarks' id='remarks' readonly><?php echo $obj->remarks; ?></textarea></td>
			</td>
			</tr>
			<tr>
				<td><label>Project:</label></td>
				<td><textarea name='projectname' id='projectname'><?php echo $obj->projectname; ?></textarea>
					<input type="hidden" name='projectid' id='projectid' value='<?php echo $obj->projectid; ?>'></td>
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Income  </th>
		<th align="right">Quantity  </th>
		<th align="right">Tax  </th>
		<th align="right">Discount  </th>
		<th align="right">Amount  </th>
		<th align="right">Memo  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="incomeid" class="selectbox">
<option value="">Select...</option>
<?php
	$incomes=new Incomes();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$incomes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($incomes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->incomeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="tax" id="tax" size="4" value="<?php echo $obj->tax; ?>"></td>
		<td><input type="text" name="discount" id="discount" size="6" value="<?php echo $obj->discount; ?>"></td>
		<td><input type="text" name="amount" id="amount" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->amount; ?>"></td>
		<td><textarea name="memo"><?php echo $obj->memo; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
			<div style="float:left;">
			
		Voucher No.:<input type="text" readonly name="documentno" id="documentno"  size="4"  value="<?php echo $obj->documentno; ?>">
		<input type="hidden" name="fleetscheduleid" id="fleetscheduleid"  size="4"  value="<?php echo $obj->fleetscheduleid; ?>">
		Income Date:<input type="text" name="incomedate" id="incomedate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->incomedate; ?>">
		</div>
		
		<div id="purchasemodeid" style="float:left;">
		Purchase Mode:				<select name='purchasemodeid' class="selectbox"  onchange="loadP(this);">
				  <option value="">Select...</option>
				<?php
				$purchasemodes=new Purchasemodes();
				$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($purchasemodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->purchasemodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
				</div>
				
				<div id="paymentmodeid"  style="float:left;">
				Payment Mode:				<select name='paymentmodeid' class="selectbox"  onchange="loadPaymentModes(this);">
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
		Bank:				<select name='bankid' id='bankid' class="selectbox">
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
		Cheque No:<input type="text" name="chequeno" id="chequeno"  size="12"  value="<?php echo $obj->chequeno; ?>">
		&nbsp;
		</div>
		<div id="imprestdiv" style="float:left;">
		Imprest Accounts: <select name="imprestaccountid" id="imprestaccountid"  class="selectbox">
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
		<div style="float:left;">
		<label>Remarks:</label><textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
		</div>
			</td>
			</tr>
		</table>
<table style="clear:both" class="table table-stripped table-bordered" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr>
		<th align="left" >#</th>
		<th align="left">Income  </th>
		<th align="left">Quantity  </th>
		<th align="left">Tax  </th>
		<th align="left">Discount  </th>
		<th align="left">Amount  </th>
		<th align="left">Memo  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$ob = str_replace('&','',serialize($obj));
	if($_SESSION['shpinctransactions']){
		$shpinctransactions=$_SESSION['shpinctransactions'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpinctransactions[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpinctransactions[$i]['incomename']; ?> </td>
			<td><?php echo $shpinctransactions[$i]['quantity']; ?> </td>
			<td><?php echo $shpinctransactions[$i]['tax']; ?> </td>
			<td><?php echo $shpinctransactions[$i]['discount']; ?> </td>
			<td><?php echo $shpinctransactions[$i]['amount']; ?> </td>
			<td><?php echo $shpinctransactions[$i]['memo']; ?> </td>
			<td><?php echo $shpinctransactions[$i]['total']; ?> </td>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>&obj=<?php echo $ob; ?>'>Edit</a></td>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>&obj=<?php echo $ob; ?>'>Del</a></td>
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
		<input type="hidden" id="ttotal" name="ttotal" value="<?php echo $total; ?>"/>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
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
	?>
    <script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
    <?
	redirect("addinctransactions_proc.php?retrieve=");
}

?>