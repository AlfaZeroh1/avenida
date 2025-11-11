<title>WiseDigits: Supplierpayments </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=proc_suppliers.name&extra=sys_currencys.name&extratitle=currency&join=left join sys_currencys on sys_currencys.id=proc_suppliers.currencyid",
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
		$("#currencyid").val(ui.item.currencyid);
		$("#currencyname").val(ui.item.currencyname);
	}
  });

});

function GetXmlHttpObject()
{
  if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
  
  if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function GetXmlHttpObject()
{
  if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
  
  if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function getExchangeRate()
{	
	var xmlhttp;
	var id = $("#currencyid").val();
	var dat = $("#paidon").val();
	
	var url="../../sys/currencys/populate.php?id="+id+"&date="+dat;
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var data = xmlhttp.responseText;
			var dt = data.split("-");
			document.getElementById("exchangerate").value=dt[0];
			document.getElementById("exchangerate2").value=dt[1];
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}


// function getPaymentModes(id){
//   var paymentmode=document.getElementById("paymentmode");
//   
//   if(id==1){
//     paymentmode.style.display="block";
//   }else{
//     paymentmode.style.display="none";
//   }
//  }
 
  function getPaymentCategorys(id){try{
  var paymentcategory=document.getElementById("paymentcategory");
  var bankdiv=document.getElementById("bankdiv");
  var chequediv=document.getElementById("chequediv");
  var transactiondiv=document.getElementById("transactiondiv");
  var employeediv=document.getElementById("employeediv");}catch(e){alert(e);}
  
  if(id==1 || id==""){
    paymentcategory.style.display="none";
    bankdiv.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
  }else if(id==2){
    paymentcategory.style.display="none";
    bankdiv.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
  }else if(id==5){
    paymentcategory.style.display="none";
    bankdiv.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
  }else if(id==11){
    paymentcategory.style.display="none";
    bankdiv.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="block";
  }else{
    paymentcategory.style.display="block";
    bankdiv.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="block";
    employeediv.style.display="none";
//     getPaymentCategoryDet(id);
  }
 }

//  womAdd('switchItem("expense")');
 womAdd('getExchangeRate();');
 womAdd('getPaymentCategorys("<?php echo $obj->paymentmodeid; ?>")');
 womOn();


</script>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 200,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers",
 		"iDisplayLength":10,
 	} );
 } );
   function getTotal(){
  var distributed = $("#distributed").val();
  var bankcharge = $("#bankcharge").val();
  var undistributed = $("#undistributed").val();
  
  var total = parseFloat(distributed)+parseFloat(bankcharge)+parseFloat(undistributed);
  
  $("#amount").val(total);
  
 }

 function checkSelected(str,rate){
  var id = str.id;  
  var total = $("#distributed").val();
  var amount = $("#amnt"+id).val();
  
  if(str.checked){
    $("#amnt"+id).prop('readonly',false);
    total=parseFloat(total);
    amount=parseFloat(amount);
    total+=(amount);
    $("#distributed").val(total);
  }
  else{
    $("#amnt"+id).prop('readonly',true);
    total=parseFloat(total);
    amount=parseFloat(amount);
    total-=(amount);
    $("#distributed").val(total);
  }
  
  getTotal();
  setInvoices(id, str.checked,rate);
  
 }
 
 function checkAmount(id,amnt,balance,rate){
  var str = 'amnt'+id;
  var total = $("#distributed").val();
  amnt = $("#"+str).val();
  amount = $("#oamnt"+id).val();
  
  if(parseFloat(amnt)>parseFloat(balance)){
    alert("Cannot pay more than invoice amount");
    $('#'+str).val(amount);
  }else{
    total=parseFloat(total);
    total+=(amnt-amount);
    $("#distributed").val(total);
  }
  
  $("#oamnt"+id).val(amnt)
  
  getTotal();

  var st=$("#"+id).prop('checked');

  setInvoices(id, st, rate);
  
 }
 
 
 function setInvoices(id,checked,invrate)
  {	
	  var invoiceno = $("#inv"+id).val();
	  var amount = $("#amnt"+id).val();
	  var rate = $("#exchangerate").val();
	  var eurorate = $("#exchangerate2").val();
	  
	  var xmlhttp;
	  var url="../customerpayments/setInvoices.php?invoiceno="+invoiceno+"&amount="+amount+"&checked="+checked+"&rate="+rate+"&eurorate="+eurorate+"&invrate="+invrate+"&id="+id;
	  xmlhttp=GetXmlHttpObject();
	  
	  if (xmlhttp==null)
	  {
	    alert ("Browser does not support HTTP Request");
	    return;
	  }  
	  
	  xmlhttp.onreadystatechange=function() {
		  if (xmlhttp.readyState==4)
		  {
		  }
	  };
		  
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send(null);
  }
 </script>
 
 <script type="text/javascript">
function Clickheretoprint(type)
{ 
	var msg;
	msg="Do You Want To Print?";
	var ans=confirm(msg);
	if(ans)
	{
		if(type==1)
			poptastic('print.php?supplierid=<?php echo $obj->supplierid; ?>&projectid=<?php echo $obj->projectid; ?>&doc=<?php echo $obj->documentno; ?>',700,1020);
		else
			poptastic('print1.php?supplierid=<?php echo $obj->supplierid; ?>&projectid=<?php echo $obj->projectid; ?>&doc=<?php echo $obj->documentno; ?>',700,1020);
	}
}
</script>
 
<div class="content">
<form class="forms" id="theform" action="addsupplierpayments_proc.php" name="supplierpayments" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Supplier:</label></td>
				<td><input type='text' size='32' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
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
			
			<tr>
			  <td><label>Payment Date :</label> </td>
			  <td><input type="text" name="paidon" onChange="getExchangeRate();" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"></td>
		  </tr>
		<tr>
			  <td><label>Currency:</label></td>
			  <td>
			  <?php
			  $currencys = new Currencys();
			  $fields="* ";
			  $join=" ";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $where=" where id='$obj->currencyid' ";
			  $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $currencys = $currencys->fetchObject;
			  ?>
			  <input type="hidden" size="5" readonly name="currencyid" id="currencyid" value="<?php echo $obj->currencyid; ?>"/>
			  <input type="text" readonly size="5" readonly name="currencyname" id="currencyname" value="<?php echo $currencys->name; ?>"/>
			  
					<input type="text" size="5"   name="exchangerate" id="exchangerate" value="<?php echo $obj->exchangerate; ?>"/>
					<input type="text" size="5"   name="exchangerate2" id="exchangerate2" value="<?php echo $obj->exchangerate2; ?>"/></td>
		  </tr>
		  
		  <tr>
				<!--<td><label>Amount:</label></td>
				<td><input type='text' readonly name='amountpaid' id='amountpaid' size='8' value='<?php echo $obj->amountpaid; ?>'/></td>-->
				<td><input type="checkbox" name="unpaid" id="unpaid" value="1"/>Show unpaid invoices</td>
			</tr>
	                <tr>
				<td colspan="4" align="center"><input type="submit" class="btn btn-info" name="action2" value="Retrieve"/></td>
			</tr>
		</table>
	<table class="table display" width="100%">	
	
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th>&nbsp;</th>
		<th>Document No</th>
		<th>Transact Date</th>
		<th>Transaction</th>
		<th>Remarks</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Paid/Crd Notes</th>
		<th>Balance</th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($obj->action2=="Retrieve"){
	  
	  unset($_SESSION['shpinvoices']);
	 
	 $obj->distributed=0;
	 $obj->bankcharge=0;
	 $obj->undistributed=0;	 
	 $obj->distributed=0;
	 
	 $shpinvoices = array();
	 
	 if($obj->amountpaid>0){
	 $amount = $obj->amountpaid;
	 //get invoices to pay from oldest to newest
	  $generaljournals = new Generaljournals();
	  $fields=" fn_generaljournals.id, fn_generaljournals.remarks,fn_generaljournals.transactdate, fn_generaljournals.documentno,fn_generaljournals.rate, fn_generaljournals.memo, fn_generaljournals.reconstatus, fn_generaljournals.balance, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.transactionid, sys_transactions.name transaction ";
	  $join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid ";
	  $where=" where fn_generaljournalaccounts.refid='$obj->supplierid' and fn_generaljournalaccounts.acctypeid=30 and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' and fn_generaljournals.balance>0 and fn_generaljournals.credit>0 ";
	  $having="";
	  $orderby=" order by fn_generaljournals.transactdate asc ";
	  $groupby="";
	  $generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  
	  
	  $it=0;
	  while($rw=mysql_fetch_object($generaljournals->result)){
	    if($amount<$rw->balance){
	      $rw->balance=$amount;
	    }
	    
	    $diff = ($row->rate-$obj->rate)*$row->balance;
	    
	    $shpinvoices[$it]=array('id'=>"$rw->id",'invoiceno'=>"$rw->documentno", 'amount'=>"$rw->balance",'diff'=>"$diff");
	    
	    $it++;
	    
	    $obj->distributed+=$rw->balance;
	    $amount-=$rw->balance;
	    
	    
	    if($amount<=0){
	      break;
	    }
	  }
	 }
	 
	 $_SESSION['shpinvoices']=$shpinvoices;
	
	  $generaljournals = new Generaljournals();
	  $fields=" fn_generaljournals.id, fn_generaljournals.remarks,fn_generaljournals.rate, fn_generaljournals.documentno, sys_transactions.name transaction, fn_generaljournals.memo, fn_generaljournals.reconstatus, fn_generaljournals.balance, fn_generaljournals.debit, fn_generaljournals.credit,fn_generaljournals.transactionid, fn_generaljournals.transactdate ";
	  $join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid ";
	  $where=" where fn_generaljournalaccounts.refid='$obj->supplierid' and fn_generaljournalaccounts.acctypeid=30 and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
	  $having="";
	  $orderby=" order by fn_generaljournals.transactdate desc ";
	  $groupby="";
	  $generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $crtotal=0;
	  $drtotal=0;
	  $balance=0;
	  $i=0;
	  $it=0;
	  	  
	  while($row=mysql_fetch_object($generaljournals->result)){$i++;
	  $crtotal+=$row->credit;
	  $drtotal+=$row->debit;
	  $color="";
	  
	 $color="";
	  
	  $crds="";
	  $pay="";
	  $balance=false;
	  
	  //get credit notes and paid already
	  if($row->transactionid==23){
	    
	    $query="select sum(debit) credit from fn_generaljournals where transactionid=25 and documentno in (select documentno from pos_returninwards where invoiceno='$row->documentno')";
	    $crds=mysql_fetch_object(mysql_query($query));
	    
	    //get payment
	    $pay = mysql_fetch_object(mysql_query("select sum(amount) amount from fn_supplierpaidinvoices where invoiceno='$row->documentno'"));
	  }
	  
	  if($row->balance<=0 and $row->credit>0)
	    $color="green";
	  
	  
	  $balances = $row->balance;
	  
	  //check if invoice exists in shpinvoices
	  if($row->balance>0 and $row->credit>0 and $obj->amountpaid>0){
	    $search = searchForId2($row->documentno,$shpinvoices);
	    if($search>=0){
	      $balance = true;
	      $balances = $shpinvoices[$search]['amount'];
	    }
	  }else{
	    
	  }
	  
	  
	  ?>
	  <?php if($obj->unpaid==1 and $row->balance<=0){}else{ ?>
	  <tr style="font-size:12px; vertical-align:text-top; color:<?php echo $color; ?>;">
		  <td><?php echo ($i); ?></td>
		  <td><?php if($row->credit>0 and $row->balance>0){ ?>
		  <input type="hidden" name="inv<?php echo $row->id; ?>" id="inv<?php echo $row->id; ?>" value="<?php echo $row->documentno; ?>"/>
		  <input type="checkbox" name="<?php echo $row->id; ?>" id="<?php echo $row->id; ?>"  onclick="checkSelected(this,'<?php echo $row->rate; ?>');" value="<?php echo $row->id; ?>" <?php if($balance){echo "enabled checked";}else{echo " unchecked";}?> />
		  <?php }else{echo "&nbsp;";}?></td>
		  <td><?php echo $row->documentno; ?> </td>
		  <td><?php echo formatDate($row->transactdate); ?> </td>
		  <td><?php echo $row->transaction; ?> </td>
		  <td><?php echo $row->remarks; ?>&nbsp;<?php echo $row->memo; ?></td>
		  <td align="right"><?php echo formatNumber($row->debit);?></td>
		  <td align="right"><?php echo formatNumber($row->credit);?></td>
		   <td align="right"><?php if(!empty($crds->credit+$pay->amount)){echo formatNumber($crds->credit+$pay->amount);}?></td>
		  <td align="right"><?php echo formatNumber($row->balance); ?></td>
		  <?php if($row->balance>0 and $row->credit>0){ ?>
		 <td align="right">
		  <input type="text" <?php if(!$balance)echo "readonly"; ?> style="padding: 0px 0px; line-height: 2px; height:15px;" size="10" name="amnt<?php echo $row->id; ?>" onChange="checkAmount('<?php echo $row->id; ?>',this.value,'<?php echo $balances; ?>','<?php echo $row->rate; ?>');" id="amnt<?php echo $row->id; ?>" value="<?php echo round($balances,2);?>"/>
		  <input type="hidden" <?php if(!$balance)echo "readonly"; ?> style="padding: 0px 0px; line-height: 2px; height:15px;" size="10" name="oamnt<?php echo $row->id; ?>" id="oamnt<?php echo $row->id; ?>" value="<?php echo round($balances,2);?>"/>
		  </td>
		  <?php }else{?>
		  <td>&nbsp;</td>
		  <?php }?>
	  </tr>
	  <?php } ?>
	  <?php
	  //$i++;  
	  
	 } 
	 $obj->undistributed = $obj->amountpaid-$obj->distributed;
	 
	 $obj->amount = $obj->undistributed+$obj->distributed;
	?>
	</tbody>
	
	<tfoot>
		<tr style="font-size:18px; vertical-align:text-top; ">
		  <th align="left" ></th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th>Balance</th>
		  <?php if($drtotal<$crtotal){?>
		  <th>&nbsp;</th>
		  <th align="right"><?php echo formatNumber($crtotal-$drtotal);?></th>
		  <?php }else{?>
		  <th align="right"><?php echo formatNumber($drtotal-$crtotal);?></th>
		  <th>&nbsp;</th>
		  <?php }?>
		</tr>
	</tfoot>
</table>
<?php
}
?>
<form class="forms" id="theform" action="addcustomerpayments_proc.php" name="customerpayments" method="POST" enctype="multipart/form-data">
	<table>
 <?php if(!empty($obj->retrieve)){?>
	<!--<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>-->
	<?php }?>
	<tr>
		<td colspan="2"><div id="ttselected"></div><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Voucher No : </td>
		<td><input type="text" readonly name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	
	<tr id="paymentmode">
				<td align="right">Payment Mode:</td>
				<td>
				<div style="float:left">
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
				<div id="paymentcategory" style="float:left;">
				<?php echo $_SESSION['paymenttitle'];?>:
				<select name='paymentcategoryid' id='paymentcategoryid' class="selectbox">
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
				</select>
			</div>
			<div id="bankdiv" style="float:left;">
				Bank:<select name='bankid' id='bankid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where currencyid='$obj->currencyid' ";
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
			  Employee:<input type='text' size='32' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
			</div>
			<div id="chequediv" style="float:left;">
			  Cheque No:<input type="text" name="chequeno" value="<?php echo $obj->chequeno; ?>"/>
			</div>
			<div id="transactiondiv" style="float:left;">
			  <input type="text" name="transactionno" value="<?php echo $obj->transactionno; ?>"/>
			</div>
			</td>
			</tr>
			
			<tr><td align="right">
		         Distributed:</td><td><input type="text" readonly name="distributed" id="distributed"  size="20"  value="<?php echo $obj->distributed; ?>">
			</td>
			</tr>
			
			<tr>
			  <td align="right">Bank Charge:</td>
			  <td><input type="text" onChange="getTotal();" name="bankcharge" id="bankcharge" value="<?php echo $obj->bankcharge; ?>"/></td>
			</tr>
			
			<tr>
			  <td align="right">Undistributed:</td>
			  <td><input type="text"  onChange="getTotal();" name="undistributed" id="undistributed" value="<?php echo round($obj->undistributed,2); ?>"/></td>
			</tr>
			
			<tr><td align="right">
		         Total(overpay+Rec):</td><td><input type="text" readonly name="amount" id="amount"  size="20"  value="<?php echo $obj->amount; ?>">
			</td>
			</tr>
			
			<tr>
				<td><label>Remarks:</label></td>
				<td><textarea name='remarks' id='remarks'><?php echo $obj->remarks; ?></textarea></td>
			</tr>
			
			<tr>
			  <td colspan='2' align="center">
			  
			  <?php if(!empty($obj->retrieve)){?>
			  <input type="button" class="btn btn-default" onClick="Clickheretoprint(1);" value="Print" />
			  <?php }else{ ?>
			  <input type="button" class="btn btn-default" onClick="Clickheretoprint(2);" value="Print Payment Voucher" />
			  <input class="btn btn-primary" type="submit" name="action" value="Save"/>&nbsp;
			  <?php } ?>
			  </td>
			</tr>
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
    redirect("addsupplierpayments_proc.php?retrieve=");
  }
?>
