<title>WiseDigits ERP: Inwards </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
 $("#itemname").autocomplete("../../../modules/server/server/search.php?main=inv&module=items&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#itemname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("itemname").value=data[0];
     document.getElementById("itemid").value=data[1];
     document.getElementById("costprice").value=data[9];
   }
 });
 $("#projectname").autocomplete("../../../modules/server/server/search.php?main=con&module=projects&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#projectname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("projectname").value=data[0];
     document.getElementById("projectid").value=data[1];
   }
 });
 $("#suppliername").autocomplete("../../../modules/server/server/search.php?main=proc&module=suppliers&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#suppliername").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("suppliername").value=data[0];
     document.getElementById("supplierid").value=data[1];
     document.getElementById("contact").value=data[7];
     document.getElementById("physicaladdress").value=data[8];
     document.getElementById("tel").value=data[9];
     document.getElementById("cellphone").value=data[12];
     document.getElementById("email").value=data[11];
   }
 });
});

function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print GRN?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?documentno=<?php echo $obj->documentno; ?>&supplierid=<?php echo $obj->supplierid; ?>&invoicedon=<?php echo $obj->soldon; ?>&packingno=<?php echo $obj->packingno; ?>",450,940);
	}
}
<?php include'js.php'; ?>
</script>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {

// 	TableTools.DEFAULTS.aButtons = [ "copy", "csv", "xls","pdf" ];
	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"bJQueryUI": true,
		"iDisplayLength":20,
		"sPaginationType": "full_numbers"
	} );
} );
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
	var total = $("#totals"+id).text().replace(",","");
	var ttotal = $("#ttotal").val();
	
	total = parseFloat(total);
	ttotal = parseFloat(ttotal);
	
    	var str = xmlhttp.responseText;
    	str = str.split("|");
    	$("#vatamount"+id).html(str[0]);
    	$("#totals"+id).html(str[1]);
    	str[1] = parseFloat(str[1]);
    	$("#ttotal").val(ttotal-total+str[1]);
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

function getVatClass(id,bl,price,quantity,total,vtamount)
{	try{
	var xmlhttp;
	var url="populate.php?id="+id+"&i="+bl;
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var totals = parseFloat($("#ttotal").val());
			var data=xmlhttp.responseText;
			var dt = data.split("|");
			$("#tax"+bl).text(dt[0]);
			$("#vatamount"+bl).text(dt[1]);
			$("#total"+bl).text(dt[2]);
			var ntotal = totals-parseFloat(total)+parseFloat(dt[2]);
			ntotal=Math.round(ntotal*Math.pow(10,2))/Math.pow(10,2);
			$("#ttotal").val(ntotal);
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);}catch(e){alert(e);}
}

function getVatClasss(id,ids,cost,i, tt,quantity)
{	
	var xmlhttp;
	var url="../../inv/purchases/populate.php?id="+id;
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{try{
		        var taxs=xmlhttp.responseText;
			$("#tax"+i).val(xmlhttp.responseText);
			tt = parseFloat(tt);
			if(isNaN(tt))
			  tt=0;
			 
			setTax(ids,cost,i, tt,id,taxs,quantity);
// 			
			}catch(e){alert(e);}
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function calculateVATAmounts(cost,i,quantity,tax){
  var discount=parseFloat($("#discount"+i).val());
  var taxamt=tax*(cost*quantity-(discount*cost*quantity/100))/100;//alert(taxamt);
  
  $("#vatamount"+i).text(taxamt);
}

function setTax(id,cost,i,tt,vatclasseid,tax,quantity)
{
	var xmlhttp;
	var discount=parseFloat($("#discount"+i).val());
	var url="settax.php?itemid="+id+"&vatclasseid="+vatclasseid+"&i="+i+"&tax="+tax+"&discount="+discount;
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{      /* var taxamount=$("#taxamount"+i).val();*/
		        var vatamount=tax*cost*quantity/100;
		 	calculateVATAmounts(cost,i,quantity,tax);
			calculateTotals(i);
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function setDiscounts(val,i, field)
{
	var xmlhttp;
	var url="setdiscounts.php?val="+val+"&i="+i+"&field="+field;
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{      /* var taxamount=$("#taxamount"+i).val();*/
		      if(field=="discount"){
		       var quantity=parseFloat($("#quantity"+i).text());  
                       var cost=parseFloat($("#costprice"+i).val());
                       var vatclasseid=$("#vatclasseid"+i).val();//alert(vatclasseid);
                       var tax=$("#tax"+i).val();
		       setTax('',cost,i,'',vatclasseid,tax,quantity);
		      }
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
</script>


<div class="content">
<form  id="theform" action="addinwards_proc.php" name="inwards" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<!--<tr>
				<td><label>Project:</label></td>
				<td><input type='text' size='0' name='projectname' id='projectname' value='<?php echo $obj->projectname; ?>'>
					<input type="hidden" name='projectid' id='projectid' value='<?php echo $obj->projectid; ?>'></td>
			</td>-->
			</tr>
				<td><label>Supplier:</label></td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
				<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'></td>
			<tr>
				<td><label>Contact:</label></td>
				<td><input type='text' name='contact' id='contact' size='0' readonly value='<?php echo $obj->contact; ?>'/></td>				<td><label>Physical Address:</label></td>
				<td><textarea name='physicaladdress' id='physicaladdress' readonly><?php echo $obj->physicaladdress; ?></textarea></td>
			<tr>
				<td><label>Phone No.:</label></td>
				<td><input type='text' name='tel' id='tel' size='8' readonly value='<?php echo $obj->tel; ?>'/></td>		<td><label>Cell-Phone:</label></td>
				<td><input type='text' name='cellphone' id='cellphone' size='8' readonly value='<?php echo $obj->cellphone; ?>'/></td>			<tr>
				<td><label>E-mail:</label></td>
				<td><input type='text' name='email' id='email' size='0' readonly value='<?php echo $obj->email; ?>'/></td>			</td>
			</tr>
			<tr>
			  <td>Exchange Rate</td>
			  <td><select name="currencyid" id="currencyid" class="selectbox" onchange="getExchangeRate(this.value);">
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
			      <input type="text" size='6' readonly name="rate" id="rate" value="<?php echo $obj->rate; ?>"/>
			      <input type="text" size='6' readonly name="eurorate" id="eurorate" value="<?php echo $obj->eurorate; ?>"/>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th>Item  </th>
		<th>Rate  </th>
		<th>Quantity  </th>
		<th>VAT</th>
		<th>Memo  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><?php if(empty($obj->assetid)) { ?>
		<input type='text' size='20' name='itemname'  onchange="calculateTotal();" onblur="calculateTotal();"  id='itemname' value='<?php echo $obj->itemname; ?>'>
		<input type="hidden" name='itemid' size='4' id='itemid' value='<?php echo $obj->itemid; ?>'>
		<?php }else{ ?>
		<input type='text' size='20' name='assetname'  onchange="calculateTotal();" onblur="calculateTotal();"  id='assetname' value='<?php echo $obj->assetname; ?>'>
		<input type="hidden" name='assetid' size='4' id='assetid' value='<?php echo $obj->assetid; ?>'>
		<?php } ?>
		</td>
		<td>
		<input type='text' name='costprice' id='costprice'  size='4' readonly value='<?php echo $obj->costprice; ?>'/>
		<input type='hidden' name='id' id='id'  size='4' readonly value='<?php echo $obj->id; ?>'/>
		</td>

		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();;" onblur="calculateTotal();;"  size="8" value="<?php echo $obj->quantity; ?>"></td>
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
		<input type='hidden' name='tax' id='tax'  size='4'  value='<?php echo $obj->tax; ?>'/></td>
		<td><textarea name="memo"><?php echo $obj->memo; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Inward Note No:<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>">
		Inward Date:<input type="date" name="inwarddate" id="inwarddate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->inwarddate; ?>">
		Remarks :<textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
		LPO No:<textarea name="lpono" ><?php echo $obj->lpono; ?></textarea>
		Del No: <input type="text" size="8" name="deliverynoteno" value="<?php echo $obj->deliverynoteno; ?>"/>
			</td>
			</tr>
		</table>
		<div style="clear:both;">
<table style="clear:both" id="tbl" cellpadding="0" align="center" width="98%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th>&nbsp;</th>
		<th align="left">Item  </th>
		<th align="left">Category  </th>
		<th align="right">Rate  </th>
		<th align="right">Quantity  </th>
		<th align="left">Qnt Received  </th>
		<th align="left">Qnt Receivable  </th>
		<th align="left">Discount  </th>
		<th align="left">Discount Amount </th>
		<th>Tax</th>
		<th align="left">VAT </th>
		<th align="left">Memo  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpinwards']){
		$shpinwards=$_SESSION['shpinwards'];//print_r($shpinwards);
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpinwards[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><input type="checkbox" id="id<?php echo $i; ?>" onChange="enableQuantity('<?php echo $i; ?>');" <?php if(!$shpinwards[$i]['checked'] and empty($obj->retrieve)){echo"disabled";}?>/></td>
			<td><?php if(!empty($shpinwards[$i]['itemid']))echo $shpinwards[$i]['itemname'];else echo $shpinwards[$i]['assetname']; ?> </td>
			<td><?php echo $shpinwards[$i]['categoryname']; ?> </td>
			<td align="right" id="costprice<?php echo $i; ?>"><?php echo $shpinwards[$i]['costprice']; ?> </td>
			<td><?php echo $shpinwards[$i]['quantitys']; ?> </td>
			<td><?php echo $shpinwards[$i]['quantitys']-$shpinwards[$i]['quantity']; ?> </td>
			<td><input type="text" id="quantity<?php echo $i; ?>" size="4" value="<?php echo $shpinwards[$i]['quantity']; ?>" readonly onChange="changeQuantity('<?php echo $i; ?>', this.value);"/> </td>
			<td><input type="text" size="5" onchange="calculateVATAmounts('<?php echo $shpinwards[$i]['costprice']?>','<?php echo $i; ?>','<?php echo $shpinwards[$i]['quantity']?>','<?php echo $shpinwards[$i]['tax']?>');calculateTotals('<?php echo $i; ?>');setDiscounts(this.value,'<?php echo $i; ?>','discount');" name="discount<?php echo $i; ?>" id="discount<?php echo $i; ?>"  value="<?php echo ($shpinwards[$i]['discount']); ?>"/></td>
			<td align="right" id="discountamount<?php echo $i; ?>"><?php echo formatNumber($shpinwards[$i]['discountamount']); ?> </td>
			<td><select name="vatclasseid<?php echo $i; ?>" id="vatclasseid<?php echo $i; ?>" class="selectbox" onchange="getVatClasss(this.value,'<?php echo $shpinwards[$i]['expenseid']?>','<?php echo $shpinwards[$i]['costprice']?>','<?php echo $i; ?>','<?php echo $shpinwards[$i]['total']?>','<?php echo $shpinwards[$i]['quantity']?>');">
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
			  <option value="<?php echo $row->id; ?>" <?php if($obj->vatclasseid==$row->id){echo"selected";}?>><?php echo $row->name; ?>&nbsp;<?php echo $row->perc; ?>%</option>
			  <?php
			}
			?>
		    </select>
		    <input type="hidden" id="tax<?php echo $i; ?>"><?php echo $shpinwards[$i]['tax'];?></input>
		    </td>
		    <td align="right" id="vatamount<?php echo $i; ?>"><?php echo $shpinwards[$i]['vatamount']; ?> </td>
			<td>
			<?php if(!empty($shpinwards[$i]['assetid'])){?>
			<input type="text" size="8" onchange="setDiscounts(this.value,'<?php echo $i; ?>','memo');" name="memo<?php echo $i; ?>" id="memo<?php echo $i; ?>"  value="<?php echo ($shpinwards[$i]['memo']); ?>"/>
			<?php }else{ ?>
			<?php echo $shpinwards[$i]['memo']; ?>
			<?php } ?>
			 </td>
			<td align="right" id="total<?php echo $i; ?>"><?php echo formatNumber($shpinwards[$i]['total']); ?> </td>
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
<table align="center" width="98%">
	<tr>
		<td colspan="2" align="center">Total:<input id="ttotal" type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" class="btn btn-primary" name="action" id="action" value="Print" onclick="Clickheretoprint();"/>
		<?php 
		//Authorization.
		$auth->roleid="759";//View
		$auth->levelid=$_SESSION['level'];
		if($obj->journals!='Yes' and existsRule($auth)){ ?>
		<input type="submit" class="btn btn-primary" name="action" id="action" value="Effect Journals"/>
		<?php } ?>
		</td>
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
 	redirect("addinwards_proc.php?retrieve=");
}

?>