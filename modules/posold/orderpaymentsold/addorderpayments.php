<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
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
 
function placeCursorOnPageLoad()
{
	$("#amountgiven").focus();
		
}

function getPaymentCategorys(id){
  var paymentcategory=document.getElementById("paymentcategory");
  var banks=document.getElementById("banks");
  var chequediv=document.getElementById("chequediv");
  var transactiondiv=document.getElementById("transactiondiv");
  var employeediv=document.getElementById("employeediv");
  var imprestdiv=document.getElementById("imprestdiv");
  
  if(id==1){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
    imprestdiv.style.display="block";
  }else if(id==2){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
    imprestdiv.style.display="none";
  }else if(id==5){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
    imprestdiv.style.display="none";
  }else if(id==11){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="block";
    imprestdiv.style.display="none";
  }else{
    paymentcategory.style.display="block";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="block";
    employeediv.style.display="none";
    imprestdiv.style.display="none";
    getPaymentCategoryDet(id);
  }
 }

womAdd('placeCursorOnPageLoad()');
womAdd('getPaymentCategorys("<?php echo $obj->paymentmodeid; ?>")');
womOn();
 
function getBalance(){
  var amountgiven = $("#amountgiven").val();
  var amount = $("#amount").val();
  
  var balance = amountgiven-amount;
  
  $("#balance").val(balance);
}

function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print BILL?";
// 	var ans=confirm(msg);
	if(true)
	{
		window.close();
		poptastic('print.php?&doc=<?php echo $obj->documentno; ?>&customerid=<?php echo $obj->customerid; ?>&packedon=<?php echo $obj->packedon; ?>',700,1020);
	}
}
 </script>

<div id="tabs-1">
<form class="forms" id="theform" action="addorderpayments_proc.php" name="orderpayments" method="POST" enctype="multipart/form-data">
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
		<td align="right">Receipt # : </td>
		<td><input type="text" readonly name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Order : </td>
		<td><input type="text" readonly name="orderid" id="orderid" value="<?php echo $obj->orderid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Paid On : </td>
		<td><input type="text" name="paidon" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Amount Given : </td>
		<td><input type="number" name="amountgiven"  onChange="getBalance();"  onKeyUp="getBalance();" id="amountgiven" size="8"  value="<?php echo $obj->amountgiven; ?>"></td>
	</tr>
	
	
	<tr>
		<td align="right">Amount Payable : </td>
		<td><input type="text" readonly name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
		
	<tr>
		<td align="right">Balance : </td>
		<td><input type="text" readonly name="balance" id="balance" size="8"  value="<?php echo $obj->balance; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Payment Mode:</td>
		<td><div id="paymentmode" style="float:left;">
				<select name='paymentmodeid' id='paymentmodeid' onchange="getPaymentCategorys(this.value);" class="selectbox">
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$fields="*";
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
			
			<div id="imprestdiv" style="float:left;">
				<select name='imprestaccountid' id='imprestaccountid' class="selectbox">
				
				<?php
				$paymentmodes=new Imprestaccounts();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where brancheid='".$_SESSION['brancheid']."' ";
				$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentmodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->imprestaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
			</div>
			
			<div id="paymentcategory" style="float:left;">
				<div id="title" style="float:left;"><?php echo $_SESSION['paymenttitle'];?></div>: <div style="float:left;"><select name='paymentcategoryid' id='paymentcategoryid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$paymentcategorys=new Paymentcategorys();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$paymentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentcategorys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentcategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></div>
			</div>
			<div id="banks" style="float:left;">
				Bank: <select name='bankid' id='bankid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$fields="*";
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
			<div id="employeediv" style="float:left;">
			  Employee: <input type='text' size='32' name='employeenames' id='employeenames' value='<?php echo $obj->employeenames; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
			</div>
			<div id="chequediv" style="float:left;">
			  <input type="text" name="chequeno" value="<?php echo $obj->chequeno; ?>"/>
			</div>
			<div id="transactiondiv" style="float:left;">
			  <input type="text" name="transactionno" value="<?php echo $obj->transactionno; ?>"/>
			</div></td>
	</tr>
	
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
// 	showError($error);
}

if($saved=="Yes"){
	?>
<script type="text/javascript">Clickheretoprint(true);
window.top.hidePopWin(true);
</script>
<?php
// 	redirect("addorders_proc.php?retrieve=");
}
?>