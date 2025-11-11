<title>WiseDigits: Payments </title>
<?php 
include "../../../head.php";

?>

  <script type="text/javascript">
function Clickheretoprint()
{ 
	var msg;
	msg="Do You Want To Print?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic('print.php?customerid=<?php echo $obj->customerid; ?>&projectid=<?php echo $obj->projectid; ?>&doc=<?php echo $obj->documentno; ?>',700,1020);
	}
}
 </script>


<script type="text/javascript">
$().ready(function() {
  $("#patientclassename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patientclasses&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientclasseid").val(ui.item.id);
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

function getExchangeRate(id)
{	
	var xmlhttp;
	var url="../../sys/currencys/populate.php?id="+id;
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
//  womAdd('getPaymentModes("<?php echo $obj->purchasemodeid; ?>")');
 womAdd('getPaymentCategorys("<?php echo $obj->paymentmodeid; ?>")');
 womOn();


</script>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers",
 		"iDisplayLength":500,
 	} );
 } );

 function checkSelected(str,vals,amt,rate,id){
  var amnt = "amnt"+str.value;
  var tott = parseFloat($('#total').val());
  var total = parseFloat($('#amount').val());
  var amntt= parseFloat($('#'+amnt).val());
  //alert(vals);
  if($(str).is(':checked')){
  
    var totals=total+parseFloat($('#'+amnt).val());
    if(tott<=totals && tott>total)
    {
    //alert(tott+'jj'+total)
    var rem=tott-total;
    total+=tott-total;
    var am=(vals)-rem;
    var amt=Math.round(am*Math.pow(10,2))/Math.pow(10,2);
    total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
    $('#amount').val(total);
    $('#'+amnt).val(am);
    $('#'+amnt).attr('disabled','disabled');
    var vall=Math.round(rem);
    $.post( "add.php", { action: "Add", id:str.value, amount: vall, debit: vals } );
    }
    else if(tott>totals)
    {
   // alert();
    total+=parseFloat($('#'+amnt).val());
    var amn=parseFloat($('#'+amnt).val());
    var vall=Math.round(vals);
    total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
    $('#amount').val(total);
     $('#'+amnt).val('0');
    $('#'+amnt).attr('disabled','disabled');
    $.post( "add.php", { action: "Add", id:str.value, amount: vall, debit: vals } );
    }
    else{
    alert('Amount Already'+tott+'');
    $('#'+amnt).removeAttr('disabled');
   // alert(id);
    $('#'+id).prop( "checked", false );
    }
    
    
  }else{
  //alert(amntt);
    var vall=Math.round((vals)*Math.pow(10,2))/Math.pow(10,2);
    total-=Math.round(((vals)-amntt)*Math.pow(10,2))/Math.pow(10,2);
     //alert(total);
    total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
   
    $('#amount').val(total);
    $('#'+amnt).val(vall);
    $('#'+amnt).removeAttr('disabled');
    $.post( "add.php", { action: "Remove", id:str.value } );
  }
 }
 
 function checkAmount(id,amnt,amount){
  var str = 'amnt'+id;
  if(parseFloat(amnt)>parseFloat(amount)){
    alert("Cannot pay more than invoice amount");
    $('#'+str).val(amount);
  }
 }
 </script>

 
<div class='content'>
<form class="forms" id="theform" action="addcustomerpayments_proc.php" name="customerpayments" method="POST" enctype="multipart/form-data">
	<table width="100%" class="table" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample" border='1'>
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<!--<tr>
				<td><label>Patient Name:</label></td>
				<td><input type='text' size='32' name='patientname' id='patientname' value='<?php echo $obj->patientname; ?>'>
					<input type="hidden" name='patientid' id='patientid' value='<?php echo $obj->patientid; ?>'></td>
				<td><label>Contact:</label></td>
				<td><input type='text' name='contact' id='contact' size='0' readonly value='<?php echo $obj->contact; ?>'/></td>			<tr>
			</tr>
			<tr>
				<td><label>Physical Address:</label></td>
				<td><textarea name='physicaladdress' id='physicaladdress' readonly><?php echo $obj->physicaladdress; ?></textarea></td>
				<td><label>Phone No.:</label></td>
				<td><input type='text' name='tel' id='tel' size='8' readonly value='<?php echo $obj->tel; ?>'/></td>			<tr>
			</tr>
			<tr>
				<td><label>Cell-Phone:</label></td>
				<td><input type='text' name='cellphone' id='cellphone' size='8' readonly value='<?php echo $obj->cellphone; ?>'/></td>				
				<td><label>E-mail:</label></td>
				<td><input type='text' name='email' id='email' size='0' readonly value='<?php echo $obj->email; ?>'/></td>			
			</tr>-->
			<tr>
				<td><label>Patient Class:</label></td>
				<td><input type='text' size='32' name='patientclassename' id='patientclassename' value='<?php echo $obj->patientclassename; ?>'>
					<input type="hidden" name='patientclasseid' id='patientclasseid' value='<?php echo $obj->patientclasseid; ?>'></td>
							<tr>
			</tr>
			<tr>
				<td><label>Amount:</label></td><td><input type='text' name='amount1' id='amount1' size='8' value='<?php echo $obj->amount1; ?>'/></td>
			</tr>
			
			<tr>
				<td><label>Remarks:</label></td>
				<td><textarea name='remarks' id='remarks'><?php echo $obj->remarks; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="4" align="center"><input type="submit" class="btn" name="action2" value="Retrieve"/></td>
			</tr>
			
			<!--<tr>
			        <td colspan="2" align="center"><label>Amount:</label>
				<td><input type='text' name='amount1' id='amount1' size='8'  value='<?php echo $obj->amount1; ?>'/></td>
				<td colspan="2" align="center"><input type="submit" class="btn" name="action2" value="Retrieve"/></td>
			</tr>-->
		</table>
	<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">	
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th>&nbsp;</th>
		<th>Document No</th>
		<th>Remarks</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
		</tr>
	</thead>
	<tbody>	
	
	<?php
	if($obj->action2=="Retrieve"){
	 // $obj->amount1=$obj->amount1;
	 
	  $transaction = new Transactions();
	  $fields="*";
	  $where=" where lower(replace(name,' ',''))='customerremittance'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $transaction->sql;
	  $transaction=$transaction->fetchObject;
	 
	
	  $generaljournals11 = new Generaljournals();
	  $fields=" sum(fn_generaljournals.balance) balance ";
	  $join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
	  $where=" where fn_generaljournalaccounts.refid='$obj->patientclasseid' and fn_generaljournalaccounts.acctypeid=31 and categoryid is null and transactionid='$transaction->id'";
	  $having="";
	  $orderby="";
	  $groupby="";
	  $generaljournals11->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals11->sql;
	  $generaljournals11=$generaljournals11->fetchObject;
	  $obj->total=$obj->amount1+($generaljournals11->balance);
	  
	  $generaljournals = new Generaljournals();
	  $fields=" fn_generaljournals.id, fn_generaljournals.remarks,fn_generaljournals.transactdate, fn_generaljournals.documentno, fn_generaljournals.memo, fn_generaljournals.reconstatus, fn_generaljournals.balance, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.transactionid ";
	  $join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid ";
	  $where=" where fn_generaljournalaccounts.refid='$obj->patientclasseid' and fn_generaljournalaccounts.acctypeid=31 and categoryid is null ";
	  $having="";
	  $orderby=" order by fn_generaljournals.documentno desc ";
	  $groupby="";
	  $generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals->sql;
	  $crtotal=0;
	  $drtotal=0;
	  $balance=0;
	  $total=0;
	  $tott=0;
	  $tot=0;
	  $tots=0;
	  $bal=0;
	  $i=0;
	  $it=0;
	  
	  
	  $shpgeneraljournals=array();
	  $shop=array();
	  
	  while($row=mysql_fetch_object($generaljournals->result)){
	  $i++;	
	  $it++;
	  $crtotal+=$row->credit;
	  $drtotal+=$row->debit;
	  $color="";
	  
	  if($row->balance>0 )
	  {
	  $bal=$row->balance;	  
	  $tots=$tot;
	  $tot+=$bal;	 
	  if($tot<$obj->total)
	  {
	  $bals=$bal;
	  $obj->amount+=round($bal,2);	  
	  //echo $bal;
	  $balance=0;
	  $shop[$row->id]=array('id'=>"$row->id",'balance'=>"0");
	  $shop2[$row->id]=0;
	  //$arr[$it]=array('id'=>"$row->id",'balance'=>"0");
	  }
	  else if($obj->total<$tot and $obj->total>$tots)
          {
         // echo 'hihihihihihi';
          $bals=$bal-($obj->total-$tots);
          
          $obj->amount+=round(($obj->total-$tots),2);
           //echo $obj->amount;
          $balance=round($bals,2);
	  $shop[$row->id]=array('id'=>"$row->id",'balance'=>"$bals");
	  $shop2[$row->id]=round($bals,2);
	  //$arr[$it]=array('id'=>"$row->id",'balance'=>"$bals");
	  }	  
	  else
          {
          $balance=$bal;
	  }
	  }
	  // echo $row->balanc$shpinvoices[$it]e.' / '.$row->rate.' = '.$bal.' and '.$tot;echo '<br/>';
	  if($row->balance==0 and $row->debit>0){
	    $color="#FF6666";
	  }
	  else if($row->balance<$row->debit and $row->balance>0){
	    $color="#339966";
	  }
	  else{
	    $color="";
	  }
	  //$balance=$row->debit-floatval($row->balance);
	  
	  $shpgeneraljournals[$it]=array('id'=>"$row->id",'debit'=>"$row->debit",'balance'=>"$row->balance");
	  
	  $it++;
	  
	  
	  ?>
	 
	  <tr style="font-size:12px; vertical-align:text-top; color:<?php echo $color; ?>;">
		  <td><input type="hidden" name="tot" id="tot" value="<?php echo ($obj->amount1);?>"/><?php echo ($i);//echo '='.$shop[$row->id]['id']; ?></td>
		  <td><?php if($row->debit>0 and $row->balance>0){ ?><input type="checkbox" <?php if(!empty($shop[$row->id]['id'])) {?> checked="checked" <?php } ?> name="<?php echo $row->id; ?>" id="<?php echo $row->id; ?>"  onclick="checkSelected(this,'<?php echo $row->balance; ?>','<?php echo $obj->amount1; ?>','<?php echo $row->rate; ?>','<?php echo $row->id; ?>');" value="<?php echo $row->id; ?>" <?php if($row->balance==0){echo "disabled";}?> /><?php }else{echo "&nbsp;";}?>
		  <td><?php echo $row->documentno; ?> </td>
		  <td><?php echo $row->remarks; ?>&nbsp;<?php echo $row->memo; ?></td>
		  <td align="right"><?php echo formatNumber($row->debit);?></td>
		  <td align="right"><?php echo formatNumber($row->credit);?></td>
		  <?php if($row->balance>0 and $row->debit>0){ ?>
		  <td align="right"><input type="text" readonly style="padding: 0px 0px; line-height: 2px; height:15px;" size="10" name="amnt<?php echo $row->id; ?>" onChange="checkAmount('<?php echo $row->id; ?>',this.value,'<?php echo $balance; ?>');" id="amnt<?php echo $row->id; ?>" value="<?php echo ($balance);?>"/></td>
		  <?php }else{?>
		  <td>&nbsp;</td>
		  <?php }?>
	  </tr>
	  <?php
	  //$i++;  
	  
	 } 
	 //print_r($shop2);
	 $_SESSION['shpgeneraljournal']=$shop2;
	}
	?>	
	</tbody>
	
	<tfoot>
		<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" ></th>
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
<form class="forms" id="theform" action="addcustomerpayments_proc.php" name="customerpayments" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><div id="ttselected"></div><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Voucher No : </td>
		<td><input type="text" readonly name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Payment Date : </td>
		<td><input type="text" name="paidon" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"></td>
	</tr>
	<tr id="paymentmode">
				<td align="right">Payment Mode:</td>
				<td><select name='paymentmodeid' id='paymentmodeid' onchange="getPaymentCategorys(this.value);" class="selectbox">
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
				</td>
				</tr>
				
				<tr id="paymentcategory">
				<td align="right"><div id="title"><?php echo $_SESSION['paymenttitle'];?></div>:</td>
				<td><select name='paymentcategoryid' id='paymentcategoryid' class="selectbox">
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
				</select></td>
			</tr>
			<tr id="bankdiv">
				<td align="right">Bank:</td>
				<td> <select name='bankid' id='bankid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="  ";
				$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($banks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->bankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
			</tr>
			<tr id="employeediv">
			  <td align="right">Employee:</td>
			  <td><input type='text' size='32' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
			</tr>
			<tr id="chequediv">
			  <td align="right">Cheque No:</td>
			  <td><input type="text" name="chequeno" value="<?php echo $obj->chequeno; ?>"/></td>
			</tr>
			<tr id="transactiondiv">
			  <td><input type="text" name="transactionno" value="<?php echo $obj->transactionno; ?>"/></td>
			</tr>
			<tr><td align="right">
		         Amount:</td><td><input type="text" readonly name="amount" id="amount"  size="20"  value="<?php echo $obj->amount; ?>">
			</td>
			</tr>
			<tr><td align="right">
		         Total(overpay+Rec):</td><td><input type="text" readonly name="total" id="total"  size="20"  value="<?php echo $obj->total; ?>">
			</td>
			</tr>
			</tr>
			<tr>
			  <td colspan='2' align="center"><input class="btn btn-primary" type="submit" name="action" value="Save"/></td>
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
//   redirect("addcustomerpayments_proc.php?retrieve=");
  }
?>