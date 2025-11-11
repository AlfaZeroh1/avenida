<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
function getCurrency(id)
{
	var xmlhttp;
	var url="getBankCurrency.php?id="+id;//alert(url);
        xmlhttp=new XMLHttpRequest();	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var data = xmlhttp.responseText;//alert(data);
			var dt = data.split("-");
			document.getElementById("currencyid").selectedIndex=dt[0];
			document.getElementById("rate").value=dt[1];
			document.getElementById("eurorate").value=dt[2];
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
function getCurrency2(id)
{
	var xmlhttp;
	var url="getBankCurrency.php?id="+id;//alert(url);
        xmlhttp=new XMLHttpRequest();	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var data = xmlhttp.responseText;//alert(data);
			var dt = data.split("-");
			document.getElementById("tocurrencyid").selectedIndex=dt[0];
			document.getElementById("torate").value=dt[1];
			document.getElementById("toeurate").value=dt[2];
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
function getExchangeRate(id)
{
	var xmlhttp;
	var url="../../sys/currencys/populate.php?id="+id;
        xmlhttp=new XMLHttpRequest();	
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
			document.getElementById("rate").value=dt[0];
			document.getElementById("eurorate").value=dt[1];
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
function getExchangeRate2(id)
{
	var xmlhttp;
	var url="../../sys/currencys/populate.php?id="+id;
        xmlhttp=new XMLHttpRequest();	
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
			document.getElementById("torate").value=dt[0];
			document.getElementById("toeurate").value=dt[1];
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
function getAmount(id)
{
  var amt=document.getElementById('amount').value;
  var rate=document.getElementById('rate').value;
  var eurorate=document.getElementById('eurorate').value;
  var torate=document.getElementById('torate').value;
  var toeurate=document.getElementById('toeurate').value;
  
  var ans=parseFloat(amt)*parseFloat(id);
  
  var currencyid=document.getElementById('currencyid').value;
  
  if(currencyid!=5){
  
    var diffk=(parseFloat(amt)*parseFloat(rate))-(parseFloat(ans)*parseFloat(torate));
    
  }else{
  
    var diffk=(((parseFloat(amt)*parseFloat(eurorate))-(parseFloat(ans)*parseFloat(toeurate)))*parseFloat(torate));
    
  }
  
  var diffe=(parseFloat(amt)*parseFloat(eurorate))-(parseFloat(ans)*parseFloat(toeurate));
  ans=Math.round(ans*Math.pow(10,4))/Math.pow(10,4);
  diffk=Math.round(diffk*Math.pow(10,4))/Math.pow(10,4);
  diffe=Math.round(diffe*Math.pow(10,4))/Math.pow(10,4);
  document.getElementById("amount1").value=ans;
  document.getElementById("diffksh").value=diffk;
  document.getElementById("diffeuro").value=diffe;
}
	
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

<div id="tabs-1" style="min-height:700px;">
<form class="content" id="theform" action="addtransfers_proc.php" name="transfers" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2">
		<input type="hidden" name="jvno" id="jvno" value="<?php echo $obj->jvno; ?>">
		<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td colspan="2">Transfer No: <input type="text" name="documentno" id="documentno" readonly value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	<tr>
		<td colspan="2">Bank :&nbsp;<select name="bankid" class="selectbox" onchange="getCurrency(this.value);">
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
</select>&nbsp;Currency : &nbsp;<select name="currencyid" id="currencyid"  class="selectbox" onchange="getExchangeRate(this.value);" onblur="getExchangeRate(this.value);" >
<option value="">Select...</option>
<?php
	$currencys=new Currencys();
	$where="  ";
	$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.eurorate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($currencys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->currencyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;Rate : <input type="text" name="rate" id="rate" size="8"  value="<?php echo $obj->rate; ?>">&nbsp;Euro Rate : <input type="text" name="eurorate" id="eurorate" size="8"  value="<?php echo $obj->eurorate; ?>">
</td>
</tr>
	<tr>
		<td colspan="2">To Bank:<select name="tobankid" class="selectbox" onchange="getCurrency2(this.value);">
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
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tobankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
	&nbsp;To Currency :
		&nbsp;<select name="tocurrencyid" id="tocurrencyid" class="selectbox" onchange="getExchangeRate2(this.value);">
<option value="">Select...</option>
<?php
	$currencys=new Currencys();
	$where="  ";
	$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.eurorate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($currencys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tocurrencyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;Rate : &nbsp;<input type="text" name="torate" id="torate" size="8"  value="<?php echo $obj->torate; ?>">&nbsp;Euro Rate :&nbsp;<input type="text" name="toeurate" id="toeurate" size="8"  value="<?php echo $obj->toeurate; ?>"></td>
	</tr>
	<tr>
		<td align="left" colspan="2">Amount:<input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>">&nbsp;Exchange Rate :<input type="text" name="exchangerate" id="exchangerate" size="8" onchange="getAmount(this.value);"  value="<?php echo $obj->exchangerate; ?>">&nbsp;To Amount:<input type="text" readonly name="amount1" id="amount1" size="8" value="<?php echo $obj->amount1; ?>"></td>
	</tr>
	<tr>
		<td colspan="2">Difference Ksh :<input type="text" readonly name="diffksh" id="diffksh" size="8"  value="<?php echo $obj->diffksh; ?>"><!--Difference Euro :--><input type="hidden" readonly name="diffeuro" id="diffeuro" size="8"  value="<?php echo $obj->diffeuro; ?>"></td>
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
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Transaction No : </td>
		<td><textarea name="transactno"><?php echo $obj->transactno; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Cheque No : </td>
		<td><textarea name="chequeno"><?php echo $obj->chequeno; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Transfered On : </td>
		<td><input type="text" name="transactdate" id="transactdate" class="date_input" size="12" readonly  value="<?php echo $obj->transactdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>