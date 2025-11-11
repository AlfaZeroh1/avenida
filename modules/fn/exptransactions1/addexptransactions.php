<title>WiseDigits: Exptransactions </title>
<?php 
include "../../../head.php";
echo $obj->bankid;
?>
<script type="text/javascript">
$().ready(function() {
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=concat(code,' ',name)&where=inv_items.type='consumable'",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

});
</script>
<script language="javascript1.1" type="text/javascript">
// hide divs
  function chechType(id){
  var expenses=document.getElementById("expensediv");
  var consumables=document.getElementById("consumablesdiv");
  
  if(id==""){
    expenses.style.display="none";
    consumables.style.display="none";
  }else if(id==1){
    expenses.style.display="block";
    consumables.style.display="none";
  }else if(id==2){
    expenses.style.display="none";
    consumables.style.display="block";
  }else{
    expenses.style.display="none";
    consumables.style.display="none";
  }
 }
 
function loadP(str)
{	try{
	var pm = document.getElementById("paymentmodeid");
	pm.value="<?php echo $obj->paymentmodeid; ?>";
	if(str==null || str==1)
	{
		//do nothing
		pm.style.display="block";;
		//text.innerHTML="show";
	}
	else if(str==2)
	{
		pm.style.display="none";
		pm.value="";
		//text.innerHTML="show";
	}
	loadPaymentModes(pm.value);	
	}catch(e){alert(e);}
}
function hideShow(id){
var s = document.getElementById(id).style;
s.visibility=s.visibility=='hidden'?'visible':'hidden'; 
}
function hide(id){
var s = document.getElementById(id).style;
s.visibility='hidden'; 
}
var s;
s="<?php echo $obj->purchasemodeid; ?>";
womAdd('loadP(s)');
var ob;
ob="<?php echo $obj->paymentmodeid; ?>";
womAdd('loadPaymentModes(ob)');

womAdd('chechType("<?php echo $obj->typeid; ?>")');


</script>
<script language="javascript1.1" type="text/javascript">
// hide divs
function loadPaymentModes(str)
{	
     
	var bank = document.getElementById("bankdiv");
	var cheque = document.getElementById("chequediv");
	var imprest = document.getElementById("imprestdiv");
	
	if(str==1)
	{
		//do nothing
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		//text.innerHTML="show";
		
	}
	else if(str==2 || str==3)
	{
		bank.style.display="block";
		cheque.style.display="block";
		imprest.style.display="none";
		//text.innerHTML="show";
	}
	else if(str==7)
	{
		imprest.style.display="block";
		cheque.style.display="none";
		bank.style.display="none";
		//text.innerHTML="show";
	}
	else
	{
		bank.style.display="none";
		cheque.style.display="none";
		imprest.style.display="none";
		//text.innerHTML="show";
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

womOn();

</script>
<script type="text/javascript">
$().ready(function() {
  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierid").val(ui.item.id);
		$("#contact").val(ui.item.contact);
		$("#physicaladdress").val(ui.item.physicaladdress);
		$("#tel").val(ui.item.tel);
		$("#cellphone").val(ui.item.cellphone);
		$("#email").val(ui.item.email);
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

<div class='main'>
<form class="forms" id="theform" action="addexptransactions_proc.php" name="exptransactions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Voucher No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action2" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Supplier:</label></td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'></td>
				<td><label>Contact:</label></td>
				<td><input type='text' name='contact' id='contact' size='0' readonly value='<?php echo $obj->contact; ?>'/></td>			<tr>
				<td><label>Physical Address:</label></td>
				<td><textarea name='physicaladdress' id='physicaladdress' readonly><?php echo $obj->physicaladdress; ?></textarea></td>
				<td><label>Phone No.:</label></td>
				<td><input type='text' name='tel' id='tel' size='8' readonly value='<?php echo $obj->tel; ?>'/></td>			<tr>
				<td><label>Cell-Phone:</label></td>
				<td><input type='text' name='cellphone' id='cellphone' size='8' readonly value='<?php echo $obj->cellphone; ?>'/></td>				<td><label>E-mail:</label></td>
				<td><input type='text' name='email' id='email' size='0' readonly value='<?php echo $obj->email; ?>'/></td>			</td>
			</tr>
			
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
	        <th align="right">Type  </th>
		<th align="right"><?php if($obj->typeid==1){echo "Expenses";}elseif($obj->typeid==2){echo "Consumables";} ?></th>
		<th align="right">Quantity  </th>
		<th align="right">Tax  </th>
		<th align="right">Discount  </th>
		<th align="right">Amount  </th>
		<th align="right">Memo  </th>
		<th>Month</th>
		<th>Year</th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
	<td><select name="typeid"  id="typeid" class="selectbox" onchange="chechType(this.value);">
		  <option value="">Select...</option>
		  <option value="1">Expense</option>
		  <option value="2">Consumables</option>
		  </select>
		</td>
		<td>
		<div id="expensediv">
		  <select name="expenseid" class="selectbox">
		  <option value="">Select...</option>
		  <?php
			  $expenses=new Expenses();
			  $where="  ";
			  $fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
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
		</div>
		<div id="consumablesdiv">
		  <input type="text" name="itemname" id="itemname" size="30" value="<?php echo $obj->itemname; ?>"/>
		  <input type="hidden" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"/>
		</div>
		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="tax" id="tax" size="4" value="<?php echo $obj->tax; ?>"></td>
		<td><input type="text" name="discount" id="discount" size="6" value="<?php echo $obj->discount; ?>"></td>
		<td><input type="text" name="amount" id="amount" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->amount; ?>"></td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
		<td><select name="month" id="month" class="selectbox">
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
      </select></td>
      <td>
      <select name="year" id="year" class="selectbox">
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
      </td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
			<div style="float:left;">
			Voucher No.:<input type="text" name="voucherno" id="voucherno"  size="4" readonly  value="<?php echo $obj->voucherno; ?>"/>
		Receipt/Invoice No.:<input type="text" name="documentno" id="documentno"  size="4"  value="<?php echo $obj->documentno; ?>">
		Expense Date:<input type="text" name="expensedate" id="expensedate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->expensedate; ?>">
		</div>
		<div id="purchasemodeid" style="float:left;">
		Purchase Mode:				<select name='purchasemodeid' id='purchasemodeid' class="selectbox"  onchange="loadP(this.value);">
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
				Payment Mode:				<select name='paymentmodeid' id='paymentmodeid' class="selectbox"  onchange="loadPaymentModes(this.value);">
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
		Cheque No:<input type="text" name="chequeno" id="chequeno"  size="12"  value="<?php echo $obj->chequeno; ?>">
		&nbsp;
		</div>
		<div id="imprestdiv" style="float:left;">
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
		<div style="float:left;">
		<label>Remarks:</label><textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
		</div>
			</td>
			</tr>
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Expense  </th>
		<th align="left">Property  </th>
		<th align="left">Payment Term  </th>
		<th align="left">Quantity  </th>
		<th align="left">Tax  </th>
		<th align="left">Discount  </th>
		<th align="left">Amount  </th>
		<th align="left">Memo  </th>
		<th align="left">Month  </th>
		<th align="left">Year  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$ob = str_replace('&','',serialize($obj));
	if($_SESSION['shpexptransactions']){
		$shpexptransactions=$_SESSION['shpexptransactions'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpexptransactions[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php if(!empty($shpexptransactions[$i]['expenseid'])) echo $shpexptransactions[$i]['expensename']; else echo $shpexptransactions[$i]['itemname']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['plotname']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['paymenttermname']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['quantity']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['tax']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['discount']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['amount']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['memo']; ?> </td>
			<td><?php echo getMonth($shpexptransactions[$i]['month']); ?> </td>
			<td><?php echo $shpexptransactions[$i]['year']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['total']; ?> </td>
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
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
if($saved=="Yes"){
	?>
    <script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
    <?
    //$obj="";
	//$_SESSION['crshop']="";
    redirect("addexptransactions_proc.php");
  }

?>