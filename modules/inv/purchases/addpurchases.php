<title>WiseDigits ERP: Purchases </title>
<?php 
include "../../../head.php";

?>
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

  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
		$("#code").val(ui.item.code);
		$("#tax").val(ui.item.tax);
		$("#costprice").val(ui.item.costprice);
		$("#tradeprice").val(ui.item.tradeprice);
		$("#discount").val(ui.item.discount);
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

 
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
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

function changeQuantity(id,value){
  if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var total = $("#total"+id).text().replace(",","");
	var totalafter = $("#totalafter"+id).text().replace(",","");
	var vatamount = $("#vatamount"+id).text().replace(",","");
	
	var ttotal = $("#ttotal"+id).text().replace(",","");
	var ttotalafter = $("#ttotalafter"+id).text().replace(",","");
	var tvatamount = $("#tvatamount"+id).text().replace(",","");
	
	total = parseFloat(total);
	totalafter = parseFloat(totalafter);
	vatamount = parseFloat(vatamount);
	
	ttotal = parseFloat(ttotal);
	ttotalafter = parseFloat(ttotalafter);
	tvatamount = parseFloat(tvatamount);
	
    	var str = xmlhttp.responseText;
    	str = str.split("|");
    	$("#vatamount"+id).html(str[0]);
    	$("#total"+id).html(str[1]);
    	$("#totalafter"+id).html(str[2]);
    	str[0] = parseFloat(str[0]);
    	str[1] = parseFloat(str[1]);
    	str[2] = parseFloat(str[2]);
    	$("#tvatamount").val(tvatamount-vatamount+str[0]);
    	$("#ttotal").val(ttotal-total+str[1]);
    	$("#ttotalafter").val(ttotalafter-totalafter+str[2]);
    }
  }
  <?php $rules= new Rules (); ?>
  var url="set.php?i="+id+"&val="+value;
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
  
}

function enableQuantity(id){
  //document.getElementById("quantity"+id).disable=false;
  if($("#id"+id).is(':checked')){
    $("#quantity"+id).prop('readonly', false);
  }
  else{
    $("#quantity"+id).prop('readonly', true);
  }
  
  if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {//alert(xmlhttp.responseText);
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  <?php $rules= new Rules (); ?>
  var url="sets.php?id="+id+"&checked="+$("#id"+id).is(':checked');
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
  
}

function calculateTotals(tax,bl,price,quantity,total,vtamount){
  var vatamount;
  var ntotal;
  var price = parseFloat($("#costprice"+bl).val());
  var tax = parseFloat($("#tax"+bl).val());
  var quantity = parseFloat($("#quantity"+bl).text());
  var tvatamount = parseFloat($("#tvatamount").text());
  var vtamount = parseFloat($("#vatamount"+bl).text());
  var ttotalafter = parseFloat($("#ttotalafter").text());
  var tttotal = $("#ttotal").text();
  var vttotal = parseFloat($("#ttotal"+bl).text());
 // alert(vttotal);
  var total = parseFloat($("#tttotal").text());

  if(tvatamount=='' || tvatamount=='NaN' || isNaN(tvatamount))
    tvatamount=0;
    
  if(tax=='' || tax=='NaN' || isNaN(tax))
    tax=0;
    
//   if(ttotalafter='' || ttotalafter=='NaN' || isNaN(ttotalafter))
//     ttotalafter=0;
    
  if(vtamount=='' || vtamount=="NaN" || isNaN(vtamount))
    vtamount=0;       
     
  vatamount = tax*quantity*price/100;
  checkArray("vatamount",bl,vatamount);
  tvatamount = parseFloat(tvatamount)-parseFloat(vtamount)+parseFloat(vatamount);
  $("#vatamount"+bl).html(vatamount);
  $("#tvatamount").text(tvatamount);
  
  ntotal = quantity*price;
  checkArray("total",bl,ntotal);
  $("#total"+bl).html(ntotal);
  ttotal=parseFloat(vatamount)+parseFloat(ntotal);
  checkArray("ttotal",bl,ttotal);
  
  $("#ttotal"+bl).html(ttotal);
  total = parseFloat(total)-parseFloat(vttotal)+parseFloat(ntotal);
  $("#tttotal").html(total);
//   alert(ttotalafter);
  ttotalafter = parseFloat(ttotalafter)-parseFloat(vttotal)+parseFloat(ttotal);
  
  $("#ttotalafter").html(ttotalafter);
}

function getVATAmount(str){
  var tax = parseFloat(document.getElementById('ttax').value);
  var total = parseFloat(document.getElementById('ttotal').value);
  if(str=="inc"){
    var ttaxamount = total - (total*100)/((100+tax))
    document.getElementById('ttaxamount').value=Math.round(ttaxamount*Math.pow(10,2))/Math.pow(10,2);//(total*100)/((100+tax));
  }
  else if(str=="exc"){
    var ttaxamount = total*(tax/100);
    document.getElementById('ttaxamount').value=Math.round(ttaxamount*Math.pow(10,2))/Math.pow(10,2);
  }
}


function getExchangeRate()
{	
	var xmlhttp;
	var id = $("#currencyid").val();
	var dat = $("#boughton").val();
	
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
			$("#currencyname").val(dt[2]);
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function getPaymentModes(id){
  var paymentmode=document.getElementById("paymentmode");
  
  if(id==1){
    paymentmode.style.display="block";
  }else{
    paymentmode.style.display="none";
  }
 }
 
 function getPaymentCategorys(id){
  var paymentcategory=document.getElementById("paymentcategory");
  var banks=document.getElementById("banks");
  var chequediv=document.getElementById("chequediv");
  var transactiondiv=document.getElementById("transactiondiv");
  var employeediv=document.getElementById("employeediv");
  
  if(id==1 || id==""){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
  }else if(id==2){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
  }else if(id==5){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
  }else if(id==11){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="block";
  }else{
    paymentcategory.style.display="block";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="block";
    employeediv.style.display="none";
    getPaymentCategoryDet(id);
  }
 }
 
 function checkArray(field,id,value){
  if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  <?php $rules= new Rules (); ?>
  var url="set.php?i="+id+"&val="+value+"&field="+field;//alert(url);
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
 }
 
 function changeValue(field,id,value){
  if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      var tax = parseFloat($("#tax"+id).val());
      var price = value;
      var total;
      var vtamount;
      var quantity = parseFloat($("#quantity"+id).text());
      
      calculateTotals(tax,id,price,quantity,total,vtamount);
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  <?php $rules= new Rules (); ?>
  var url="set.php?i="+id+"&val="+value+"&field="+field;
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

//  womAdd('switchItem("expense")');
 womAdd('getPaymentModes("<?php echo $obj->purchasemodeid; ?>")');
 womAdd('getPaymentCategorys("<?php echo $obj->paymentmodeid; ?>")');
 womOn();

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


<div class="content">
<form class="" id="theform" action="addpurchases_proc.php" name="purchases" method="POST" enctype="multipart/form-data">
	<table width="100%" class="table titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>
		<input type="text" name="jvno" value="<?php echo $obj->jvno; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/><input type="submit" name="action" value="Filter"/></td>
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
			<tr>
				<td><label>Exchange Rate:</label></td>
				<td><select name="currencyid" id="currencyid" class="selectbox" onchange="getExchangeRate();">
				<option value="">Select...</option>
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select>
			      <input type="hidden" size="5" name="exchangerate" id="exchangerate" value="<?php echo $obj->exchangerate; ?>"/>
			      <input type="hidden" size="5" name="exchangerate2" id="exchangerate2" value="<?php echo $obj->exchangerate2; ?>"/></td>
			</td>
			</tr>
			
			<!--<tr>
				<td><label>Account to Debit:</label></td>
				<td><select name="accountid" class="selectbox">
				<option value="">Select...</option>
				<?php
				$generaljournalaccounts = new Generaljournalaccounts();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where acctypeid=26 ";
				$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($generaljournalaccounts->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->accountid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select></td>
			</td>
			</tr>-->
			
			
		</table>
	<table width="100%" class="table titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Item  </th>
		<th align="right">Code  </th>
		<th align="right">VAT  </th>
		<th align="right">Cost Price  </th>
		<th align="right">Trade Price  </th>
		<th align="right">Discount  </th>
		<th align="right">Quantity  </th>
		<th>Total</th>
		<th></th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname'  onchange="calculateTotal();" onblur="calculateTotal();"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>		<td>
		<input type='text' name='code' id='code'  size='4' readonly value='<?php echo $obj->code; ?>'/>
		</td>
		<td><select name="vatclasseid" class="selectbox" onchange="getVatClass(this.value,1);calculateTotal();">
			<option value="">Select...</option>
			<?php
			$vatclasses = new Vatclasses();
			$fields="*";
			$where=" ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($row=mysql_fetch_object($vatclasses->result)){
			  ?>
			  <option value="<?php echo $row->id; ?>" <?php if($obj->vatclasseid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
			  <?php
			}
			?>
		    </select>
		<input type='hidden' name='tax' id='tax'  size='4'  value='<?php echo $obj->tax; ?>'/>
		<input type='hidden' name='inwarddetailid' id='inwarddetailid'  size='4'  value='<?php echo $obj->inwarddetailid; ?>'/>
		</td>
		<td>
		<input type='text' name='costprice' id='costprice'  onchange="calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php echo $obj->costprice; ?>'/>
		</td>
		<td>
		<input type='text' name='tradeprice' id='tradeprice'  onchange="calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php echo $obj->tradeprice; ?>'/>
		</td>
		<td>
		<input type='text' name='discount' id='discount'  onchange="calculateTotal();" onblur="calculateTotal();"  size='4'  value='<?php echo $obj->discount; ?>'/>
		</td>

		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->quantity; ?>"></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center' class="table">
			<tr>
			<td>GRN NO:</td>
			<td><input type="text" name="documentno" id="documentno" readonly size="5"  value="<?php echo $obj->documentno; ?>"></td>
			<td>Purchase Date:</td>
			<td><input type="date" onChange="getExchangeRate();" name="boughton" id="boughton"  class="date_input" size="8" readonly  value="<?php echo $obj->boughton; ?>"></td>
			<td>Remarks :<textarea name="memo" ><?php echo $obj->memo; ?></textarea>
			<input type="hidden" name="olddocumentno" id="olddocumentno" hidden size="0"  value="<?php echo $obj->olddocumentno; ?>">

			<input type="hidden" name="oldmode" id="oldmode" hidden size="0"  value="<?php echo $obj->oldmode; ?>">

			<input type="hidden" name="edit" id="edit" hidden size="0"  value="<?php echo $obj->edit; ?>"></td>
			<td>Invoiceno/Receipno:</td>
			<td><input type="text" name="receiptno" id="receiptno"  size="5"  value="<?php echo $obj->receiptno; ?>"></td>
			<td>L.P.O No:</td>
			<td><input type="text" name="lpono" id="lpono"  size="5"  value="<?php echo $obj->lpono; ?>"></td>
			<td>Purchase Mode:</td>
			<td><select name='purchasemodeid' id='purchasemodeid' class="selectbox" onchange="getPaymentModes(this.value);">
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
			</td>
			<td>
				<div id="paymentmode" style="float:left;">
				Payment Mode:<select name='paymentmodeid' id='paymentmodeid' onchange="getPaymentCategorys(this.value);" class="selectbox">
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
				<div id="title" style="float:left;"><?php echo $_SESSION['paymenttitle'];?></div>: <select name='paymentcategoryid' id='paymentcategoryid' class="selectbox">
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
			  Employee: <input type='text' size='32' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
			</div>
			<div id="chequediv" style="float:left;">
			  <input type="text" name="chequeno" value="<?php echo $obj->chequeno; ?>"/>
			</div>
			<div id="transactiondiv" style="float:left;">
			  <input type="text" name="transactionno" value="<?php echo $obj->transactionno; ?>"/>
			</div>
			</td>
			</tr>
		</table>
<table style="clear:both" class="table display"  cellpadding="0" align="center" width="100%" cellspacing="0">

	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<td></td>
		<th align="left">Item  </th>
		<th align="right">Code  </th>
		<th align="right">Cost Price  </th>
		<th align="right">Discount  </th>
		<th align="right">Discount Amount </th>
		<th align="left">Quantity  </th>
		<th align="left">Qty Receivable  </th>
		<th>Tax</th>
		<th align="right">VAT Amnt  </th>
		<th align='right'>Total (Exc)</th>
		<th align='right'>Total (Inc)</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shppurchases']){
		$shppurchases=$_SESSION['shppurchases'];//print_r($shppurchases);
		$i=0;
		$j=$obj->iterator;
		$total=0;
		$vatamount=0;
		$totala=0;
		while($j>0){

		$total+=$shppurchases[$i]['total'];
		if($shppurchases[$i]['ttotal']=='')
		{
		$shppurchases[$i]['ttotal']=$shppurchases[$i]['total'];
		}
		$ttotal+=$shppurchases[$i]['ttotal'];		
		$vatamount+=$shppurchases[$i]['vatamount'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><input type="checkbox" id="id<?php echo $i; ?>" onChange="enableQuantity('<?php echo $i; ?>');" /></td>
			<td><?php if(!empty($shppurchases[$i]['itemid']))echo $shppurchases[$i]['itemname'];else echo $shppurchases[$i]['assetname']; ?> </td>			
			<td><?php echo $shppurchases[$i]['code']; ?> </td>
			<td><?php echo $shppurchases[$i]['costprice']; ?></td>
			<td><?php echo $shppurchases[$i]['discount']; ?> </td>
			<td><?php echo $shppurchases[$i]['discountamount']; ?> </td>
			<td><?php echo $shppurchases[$i]['quantity']; ?> </td>
			<td><input type="text" readonly id="quantity<?php echo $i; ?>" size="4" value="<?php echo $shppurchases[$i]['quantity']; ?>" onChange="changeQuantity('<?php echo $i; ?>', this.value);"/> </td>
			<td><?php echo $shppurchases[$i]['vatclasseid']; ?><select name="vatclasseid<?php echo $i; ?>" class="selectbox" onchange="getVatClasss(this.value,'<?php echo $i; ?>','<?php echo $shppurchases[$i]['costprice']; ?>','<?php echo $shppurchases[$i]['quantity']; ?>','<?php echo $shppurchases[$i]['total']; ?>','<?php echo $shppurchases[$i]['vatamount']; ?>');">
			<option value="">Select...</option>
			<?php
			$vatclasses = new Vatclasses();
			$fields="*";
			$where=" ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($row=mysql_fetch_object($vatclasses->result)){
			  ?>
			  <option value="<?php echo $row->id; ?>" <?php if($shppurchases[$i]['vatclasseid']==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
			  <?php
			}
			?>
		    </select>
		    <input type="hidden" id="tax<?php echo $i; ?>"><?php echo $shppurchases[$i]['tax'];?></input>
		    </td>
		    <td align="right" id="vatamount<?php echo $i; ?>"><?php echo $shppurchases[$i]['vatamount']; ?> </td>
			<td align="right" id="total<?php echo $i; ?>"><?php echo formatNumber($shppurchases[$i]['total']); ?></td>
			<td align="right" id="totalafter<?php echo $i; ?>"><?php echo formatNumber($shppurchases[$i]['ttotal']); ?> </td>
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
	<tfoot>
	  <tr style="font-size:18px; vertical-align:text-top; ">
		<th></th>
		<th>  </th>
		<th>  </th>
		<th>  </th>
		<th></th>
		<th></th>
		<th></th>
		<th>  </th>
		<th>  </th>
		<th>  </th>
		<th id="tvatamount" align='right'><?php echo formatNumber($vatamount); ?></th>
		<th id="ttotal" align='right'><?php echo formatNumber($total); ?></th>
		<th id="ttotalafter" align='right'><?php echo formatNumber($ttotal); ?></th>
		<th></th>
		<th></th>
		</tr>
	</tfoot>
</table>
<table align="center" width="100%">
	
	<?php
	if($obj->purchasemodeid=="1"){
	$generaljournals = new Generaljournals();
	$fields="sum(debit)-sum(credit) amount";
	$where=" where accountid =(select id from fn_generaljournalaccounts where refid='$obj->employeeid' and acctypeid='36') ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournals=$generaljournals->fetchObject;
	?>
	
	<tr>
	  <td align="right">Account Balance:</td>
	  <td><input type="text" readonly size="10" value="<?php echo $generaljournals->amount; ?>"/>
	</tr>
	
	<tr>
	  <td align="right">Balance:</td>
	  <td><input type="text" name="balance" size="10" value="<?php echo $obj->balance; ?>"/>
	</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>"><input type="submit" name="action" id="action" class="btn btn-warning" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="Raise Debit Note"/>
		<input type="submit" class="btn btn-info" name="action" id="action" value="Raise Credit Note"/><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
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
	redirect("addpurchases_proc.php?retrieve=");
}

?>
