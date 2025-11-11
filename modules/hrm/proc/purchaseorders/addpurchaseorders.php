<?php
session_start();
?>
<title>WiseDigits ERP: Purchaseorders </title>
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
     document.getElementById("code").value=data[2];
     document.getElementById("tax").value=data[2];
     document.getElementById("costprice").value=data[9];
     document.getElementById("tradeprice").value=data[10];
     document.getElementById("unitofmeasureid").value=data[13];
   }
 });
 $("#categoryname").autocomplete("../../../modules/server/server/search.php?main=assets&module=categorys&field=name", {
 	width: 260,
 	selectFirst: false/*,
 	 extraParams: {
	  where: function() { return " inv_items.departmentid = "+$("#departmentid").val(); }
 	 }*/
 });
 $("#categoryname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("categoryname").value=data[0];
     document.getElementById("categoryid").value=data[1];
     document.getElementById("costprice").value=data[5];
   }
 });
 $("#suppliername").autocomplete("../../../modules/server/server/search.php?main=proc&module=suppliers&field=proc_suppliers.name&extra=sys_currencys.rate, sys_currencys.eurorate&join=left join sys_currencys on sys_currencys.id=proc_suppliers.currencyid&extratitle=rate,eurorate", {
 	width: 260,
 	selectFirst: false
 });
 $("#suppliername").result(function(event, data, formatted) {
   if (data)
   {
     //status(data[1]);
     document.getElementById("suppliername").value=data[0];
     document.getElementById("supplierid").value=data[1];
     document.getElementById("currencyid").value=data[5];
     document.getElementById("contact").value=data[8];
     document.getElementById("physicaladdress").value=data[9];
     document.getElementById("tel").value=data[10];
     document.getElementById("cellphone").value=data[13];
     document.getElementById("email").value=data[12];
     document.getElementById("rate").value=data[24];
     document.getElementById("eurorate").value=data[25];
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
 
 $("#expensename").autocomplete("../../../modules/server/server/search.php?main=fn&module=expenses&field=name", {
 	width: 260,
 	selectFirst: false/*,
 	 extraParams: {
	  where: function() { return " inv_items.departmentid = "+$("#departmentid").val(); }
 	 }*/
 });
 $("#expensename").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("expensename").value=data[0];
     document.getElementById("expenseid").value=data[1];
   }
 });
 
});

function chechType(id){
  var categorys=document.getElementById("categorydiv");
  var items=document.getElementById("itemdiv");
  var expenses=document.getElementById("expensediv");
  if(id==""){
    categorys.style.display="none";
    items.style.display="none";
    expenses.style.display="none";
  }else if(id==1){
    categorys.style.display="block";
    items.style.display="none";
    expenses.style.display="none";
  }else if(id==2){
    categorys.style.display="none";
    items.style.display="block";
    expenses.style.display="none";
  }else if(id==3){
    categorys.style.display="none";
    items.style.display="none";
    expenses.style.display="block";
  }else{
    categorys.style.display="none";
    items.style.display="none";
    expenses.style.display="none";
  }
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

function setCostprice(id,cost,i, tt)
{	
	var xmlhttp;
	var url="set.php?itemid="+id+"&costprice="+cost+"&i="+i;
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var total = $("#ttotal").val();
			var data = xmlhttp.responseText;
			$("#total"+i).text(data);
			var ntotal = parseFloat(total)-parseFloat(tt)+parseFloat(data);
			ntotal=Math.round(ntotal*Math.pow(10,2))/Math.pow(10,2);
			$("#ttotal").val(ntotal);
			
			calculateTotals(i);
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
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
		        var taxamount=tax*cost*quantity/100;
		 	calculateVATAmounts(cost,i,quantity,tax);
			calculateTotals(i);
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function setDiscounts(val,i)
{
	var xmlhttp;
	var url="setdiscounts.php?val="+val+"&i="+i;
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{      /* var taxamount=$("#taxamount"+i).val();*/
		       var quantity=parseFloat($("#quantity"+i).text());  
                       var cost=parseFloat($("#costprice"+i).val());
                       var vatclasseid=$("#vatclasseid"+i).val();//alert(vatclasseid);
                       var tax=$("#tax"+i).val();
		       setTax('',cost,i,'',vatclasseid,tax,quantity);
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function setUnitofmeasure(val,i)
{
	var xmlhttp;
	var url="setUnitofmeasure.php?val="+val+"&i="+i;
	xmlhttp=new XMLHttpRequest();
	
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

function setCostprices(id,cost,i, tt)
{	
	var xmlhttp;
	var url="sets.php?expenseid="+id+"&costprice="+cost+"&i="+i;
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var total = $("#ttotal").val();
			var data = xmlhttp.responseText;
			$("#total"+i).text(data);
			var ntotal = total-tt+data;
			ntotal=Math.round(ntotal*Math.pow(10,2))/Math.pow(10,2);
			$("#ttotal").val(ntotal);			
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
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
function status(id){
		var xmlhttp;
		var url="checkStatus.php?id="+id;
		xmlhttp=GetXmlHttpObject();
		
		if (xmlhttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		}  
		
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4)
			{
			var data = xmlhttp.responseText;//alert(data);
			var dsa=String(data);
			if(dsa==2)
			{
			      document.getElementById("suppliername").value=""
			      document.getElementById("supplierid").value="";
			      document.getElementById("currencyid").value="";
			      document.getElementById("contact").value="";
			      document.getElementById("physicaladdress").value="";
			      document.getElementById("tel").value="";
			      document.getElementById("cellphone").value="";
			      document.getElementById("email").value="";
			      document.getElementById("rate").value="";
			      document.getElementById("eurorate").value="";
			       alert('The Supplier is Inactive Please Contact Finance for His/Her Activation!');
			       }				
			}
		};
			
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);    
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
  <script type="text/javascript">
function Clickheretoprint()
{ 
	var msg;
	<?php
	if($obj->type=="cash"){
	?>
	msg="Do you want to print Cash PO?";
	<?php }else{ ?>
	msg="Do you want to print LPO?";
	<?php } ?>
	var ans=confirm(msg);
	if(ans)
	{
 		<?php $_SESSION['obj']=$obj; ?>
		poptastic('print.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>&supplierid=<?php echo $obj->supplierid; ?>&projectid=<?php echo $obj->projectid; ?>&documentno=<?php echo $obj->documentno; ?>&type=<?php echo $obj->type; ?>',700,1020);
	}
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

function calculateVATAmount(total){
  document.getElementById("taxamount").value=document.getElementById("tax").value*document.getElementById("costprice").value*document.getElementById("quantity").value/100;
}
function calculateVATAmounts(cost,i,quantity,tax){
  var taxamt=tax*cost*quantity/100;
  
  $("#taxamount"+i).val(taxamt);
}

function getVatClass(id)
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
			document.getElementById("tax").value=xmlhttp.responseText;
			var total = document.getElementById("total").value;
			var discount=document.getElementById("discount").value;
			total = parseFloat(total);
			if(isNaN(total))
			  total=0;
			  
			calculateVATAmount(total);
			calculateTotal();}catch(e){alert(e);}
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
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
 womAdd('chechType("<?php echo $obj->typeid; ?>")');
 womOn();
 </script>
<div class='container'>
<div class="content">
<form  id="theform" action="addpurchaseorders_proc.php" name="purchaseorders" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<?php if($obj->retrieve==1){ ?>
	<tr>
		<td colspan="4" align="center">
		
		<input type="submit" name="action" value="First" class="btn btn-info"/>
		<input type="submit" name="action" value="Next" class="btn btn-info"/>
		<input type="submit" name="action" value="Previous" class="btn btn-info"/>
		<input type="submit" name="action" value="Last" class="btn btn-info"/>
		</td>
	</tr>
	<?php } ?>
			<tr>
				<td><label>Supplier:</label></td>
				<td>
				<input type="hidden" name="createdby" id="createdby" value="<?php echo $obj->createdby; ?>"/>
				
				<input type="hidden" name="type" id="type" value="<?php echo $obj->type; ?>"/>
				
				<input type="hidden" name="createdon" id="createdon" value="<?php echo $obj->createdon; ?>"/>
				<input type='text' size='32' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'>
					<input type="hidden" name='inward' id='inward' value='<?php echo $obj->inward; ?>'></td>
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
			      </td>
			      <td>Requested By:</td>
			      <td><font color="red">
			      <?php
			      if($obj->type=="cash"){
				//get employee that requested
				$requisitions = new Requisitions();
				$fields=" proc_requisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename ";
				$join=" left join hrm_employees on hrm_employees.id=proc_requisitions.employeeid ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where proc_requisitions.documentno in($obj->requisitionno) ";
				$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				$requisitions = $requisitions->fetchObject;
				echo $requisitions->employeename;
			      }
			      ?></font>
			      </td>
			</tr>
			
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
	        <th align="right">Types</th>
		<th align="right">Item Description  </th>
		<th align="right">Code  </th>
		<th align="right">UoM  </th>
		<th>Memo</th>
		<th align="right">Quantity  </th>
		<th align="right">VAT  </th>
		<th align="right">Cost Price  </th>
		<th align="right">Trade Price  </th>
		<th align="right">Discount</th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
	        <td><select name="typeid" id="typeid" onchange="chechType(this.value);">
		    <option value="">Select...</option>
			  <option value="1" <?php if($obj->typeid==1){echo "selected";}?>>Assets</option>
			  <option value="2" <?php if($obj->typeid==2){echo "selected";}?>>Items</option>
		    </select>
		</td>
		<td><input type="hidden" name="i" value="<?php echo $obj->i; ?>"/>
		<input type="hidden" name="edit" value="<?php echo $obj->edit; ?>"/>		
		<div id="itemdiv">
		<input type='text' size='25' name='itemname'  onchange="calculateTotal();;" onblur="calculateTotal();;"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php  $_SESSION['itid']=$obj->itemid; echo $obj->itemid; ?>'>
		</div>
		<div id="categorydiv">
		   <input type='text' size='25' name='categoryname'  onchange="calculateTotal();;" onblur="calculateTotal();;"  id='categoryname' value='<?php echo $obj->categoryname; ?>'>
			<input type="hidden" name='categoryid' id='categoryid' value='<?php echo $obj->categoryid; ?>'>
		    </select>
		</div>
		<td>
		<input type='hidden' name='code' id='code'  size='4' readonly value='<?php echo $obj->code; ?>'/>
		</td>
		<td>
		<select name="unitofmeasureid" id="unitofmeasureid" class="selectbox">
<option value="">Select...</option>
<?php
	$unitofmeasures=new Unitofmeasures();
	$where="  ";
	$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($unitofmeasures->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->unitofmeasureid==$rw->id){echo "selected";}?>><?php echo $rw->name;?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><textarea name="memo"><?php echo $obj->memo; ?></textarea></td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateVATAmount();calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><select name="vatclasseid" class="selectbox" onchange="getVatClass(this.value);">
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
		<input type='text' name='tax' id='tax'  size='4' readonly value='<?php echo $obj->tax; ?>'/>
		<input type='text' name='taxamount' id='taxamount' readonly  size='4'  value='<?php echo $obj->taxamount; ?>' onchange="calculateTotal();"/></td>
		<td>
		<input type='text' name='costprice' id='costprice'  onchange="calculateVATAmount();calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php $_SESSION['cost']=$obj->costprice; echo $obj->costprice; ?>'/>
		</td>
		<td>
		<input type='text' name='tradeprice' id='tradeprice'  onchange="calculateVATAmount();calculateTotal();" onblur="calculateTotal();"  size='8'  value='<?php echo $obj->tradeprice; ?>'/>
		</td>
                <td>
		<input type='text' name='discount' id='discount'  onchange="calculateVATAmount();calculateTotal();" onblur="calculateTotal();"  size='3'  value='<?php echo $obj->discount; ?>'>
		<input type='text' name='discountamount' size='8'  id='discountamount' readonly value='<?php echo $obj->discountamount; ?>'/>
		</td>
		</td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" class="btn btn-primary" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Remarks:<textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>

<input type="hidden" name="olddocumentno" id="olddocumentno" hidden size="0"  value="<?php echo $obj->olddocumentno; ?>">

<input type="hidden" name="edit" id="edit" hidden size="0"  value="<?php echo $obj->edit; ?>">
		Document No.:<input type="text" name="documentno" id="documentno" readonly size="5"  value="<?php echo $obj->documentno; ?>">
		Order On:<input type="date" name="orderedon" id="orderedon"  class="date_input" size="8" readonly  value="<?php echo $obj->orderedon; ?>">
		Requisition No:<textarea name="requisitionno" ><?php echo $obj->requisitionno; ?></textarea>
			</td>
			</tr>
		</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="98%" cellspacing="0">
	<thead>
	<tr style="vertical-align:text-top; ">
		<th align="left" >#</th>
		<th>&nbsp;</th>
		<th align="left">Item  </th>
		<th align="right">Code  </th>
		<th>UoM</th>
		<th>Memo</th>
		<th align="right">VAT  </th>
		<th align="right">Cost Price  </th>
<!-- 		<th align="right">Trade Price  </th> -->
		<th align="right">Discount % </th>
		<th align="right">Discount amount </th>
		<th align="left">Quantity  </th>
		<?php if(!empty($obj->retrieve)){?>
		<th align="left">Received  </th>
		<th align="left">Not Received  </th>
		<?php }?>
		<th align='left'>Total</th>
		<?php //Authorization.
		  $auth->roleid="8069";//View
		  $auth->levelid=$_SESSION['level'];

		  if(existsRule($auth)){ ?>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<?php } 
		 //Authorization.
		  $auth->roleid="8070";//View
		  $auth->levelid=$_SESSION['level']; 
		  if(existsRule($auth)){ ?>
		<th>&nbsp;</th>
		<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shppurchaseorders']){
		$shppurchaseorders=$_SESSION['shppurchaseorders'];//print_r($shppurchaseorders);
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
                if(!empty($shppurchaseorders[$i]['itemid'])){
		$receiv=mysql_fetch_object(mysql_query("select sum(quantity) quantity from proc_inwards left join proc_inwarddetails on proc_inwards.id=proc_inwarddetails.inwardid where proc_inwarddetails.itemid='".$shppurchaseorders[$i]['itemid']."' and proc_inwards.lpono='$obj->invoiceno'"));
		}else{
		$receiv=mysql_fetch_object(mysql_query("select sum(quantity) quantity from proc_inwards left join proc_inwarddetails on proc_inwards.id=proc_inwarddetails.inwardid where proc_inwarddetails.categoryid='".$shppurchaseorders[$i]['categoryid']."' and proc_inwards.lpono='$obj->invoiceno'"));
		}
		
		$received=$receiv->quantity;
		$shppurchaseorders[$i]['received']=$received;
		
		$total+=$shppurchaseorders[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><input type="checkbox" name="<?php echo $shppurchaseorders[$i]['id']; ?>" <?php if($shppurchaseorders[$i]['received']>=$shppurchaseorders[$i]['quantity']){echo"disabled";}?>/></td>
			<td><?php if(!empty($shppurchaseorders[$i]['itemid']))echo $shppurchaseorders[$i]['itemname'];else echo $shppurchaseorders[$i]['categoryname'].$shppurchaseorders[$i]['expensename']; ?> </td>
			<td><?php echo $shppurchaseorders[$i]['code']; ?> </td>
			<td><select name="unitofmeasureid<?php echo $i; ?>" id='unitofmeasureid<?php echo $i; ?>' class="selectbox"         onchange="setUnitofmeasure(this.value,'<?php echo $i; ?>');">
			    <option value="">Select...</option>
			    <?php
			    $unitofmeasures = new Unitofmeasures();
			    $fields="*";
			    $where=" ";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $unitofmeasures->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			    while($row=mysql_fetch_object($unitofmeasures->result)){
			      ?>
			      <option value="<?php echo $row->id; ?>" <?php if($shppurchaseorders[$i]['unitofmeasureid']==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
			      <?php
			    }
			    ?>
			</select></td>
			<td><?php echo $shppurchaseorders[$i]['memo']; ?> </td>
			<td><?php
			  $auth->roleid="8069";//View
			  $auth->levelid=$_SESSION['level'];

			  if(existsRule($auth) and !empty($shppurchaseorders[$i]['itemid'])){
			?>
			<select name="vatclasseid<?php echo $i; ?>" id='vatclasseid<?php echo $i; ?>' class="selectbox" onchange="getVatClasss(this.value,'<?php echo $shppurchaseorders[$i]['itemid']?>','<?php echo $shppurchaseorders[$i]['costprice']?>','<?php echo $i; ?>','<?php echo $shppurchaseorders[$i]['total']?>','<?php echo $shppurchaseorders[$i]['quantity']?>');">
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
			      <option value="<?php echo $row->id; ?>" <?php if($shppurchaseorders[$i]['vatclasseid']==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
			      <?php
			    }
			    ?>
			</select>
			<input type='text' name='tax<?php echo $i; ?>' id='tax<?php echo $i; ?>' readonly size='4'  value='<?php echo $shppurchaseorders[$i]['tax']; ?>'/>
			<input type='text' name='taxamount<?php echo $i; ?>' id='taxamount<?php echo $i; ?>' readonly size='4'  value='<?php echo $shppurchaseorders[$i]['taxamount']; ?>'/>
			<?php }else{
			if(!empty($shppurchaseorders[$i]['expenseid'])){ ?>
			<select name="vatclasseid<?php echo $i; ?>" id='vatclasseid<?php echo $i; ?>' class="selectbox" onchange="getVatClasss(this.value,'<?php echo $shppurchaseorders[$i]['expenseid']?>','<?php echo $shppurchaseorders[$i]['costprice']?>','<?php echo $i; ?>','<?php echo $shppurchaseorders[$i]['total']?>','<?php echo $shppurchaseorders[$i]['quantity']?>');">
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
			      <option value="<?php echo $row->id; ?>" <?php if($shppurchaseorders[$i]['vatclasseid']==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
			      <?php
			    }
			    ?>
			</select>
			<input type='text' name='tax<?php echo $i; ?>' id='tax<?php echo $i; ?>' readonly size='4'  value='<?php echo $shppurchaseorders[$i]['tax']; ?>'/>
			<input type='text' name='taxamount<?php echo $i; ?>' id='taxamount<?php echo $i; ?>' readonly  size='4'  value='<?php echo $shppurchaseorders[$i]['taxamount']; ?>'/>			
			<?php
			}else{
			?>
			<?php echo $shppurchaseorders[$i]['tax']; ?>
			<?php
			}
			} ?> </td>
			<td><?php
			  $auth->roleid="8069";//View
			  $auth->levelid=$_SESSION['level'];

			  if(existsRule($auth) and !empty($shppurchaseorders[$i]['itemid'])){
			?>
			<input type="text" size="5" onchange="setCostprice('<?php echo $shppurchaseorders[$i]['itemid']?>',this.value,'<?php echo $i; ?>','<?php echo $shppurchaseorders[$i]['total']?>');" name="<?php echo $i; ?>" id="costprice<?php echo $i; ?>"  value="<?php echo ($shppurchaseorders[$i]['costprice']); ?>"/>
			<?php }else{
			if(!empty($shppurchaseorders[$i]['expenseid']) or !empty($shppurchaseorders[$i]['categoryid'])){ ?>
			<input type="text" size="5" onchange="setCostprices('<?php echo $shppurchaseorders[$i]['expenseid']?>',this.value,'<?php echo $i; ?>','<?php echo $shppurchaseorders[$i]['total']?>');" name="<?php echo $i; ?>" id="costprice<?php echo $i; ?>" value="<?php echo ($shppurchaseorders[$i]['costprice']); ?>"/>
			
			<?php
			}else{
			?>
			<?php echo $shppurchaseorders[$i]['costprice']; ?>
			<?php
			}
			} ?> </td>
<!-- 			<td><?php echo $shppurchaseorders[$i]['tradeprice']; ?> </td> -->
			<td><input type="text" size="5" onchange="calculateVATAmounts('<?php echo $shppurchaseorders[$i]['costprice']?>','<?php echo $i; ?>','<?php echo $shppurchaseorders[$i]['quantity']?>','<?php echo $shppurchaseorders[$i]['tax']?>');calculateTotals('<?php echo $i; ?>');setDiscounts(this.value,'<?php echo $i; ?>');" name="discount<?php echo $i; ?>" id="discount<?php echo $i; ?>"  value="<?php echo ($shppurchaseorders[$i]['discount']); ?>"/></td>
			<td align="right" id="discountamount<?php echo $i; ?>"><?php echo formatNumber($shppurchaseorders[$i]['discountamount']); ?> </td>
			<td align="right" id="quantity<?php echo $i; ?>"><?php echo $shppurchaseorders[$i]['quantity']; ?> </td>
			<?php if(!empty($obj->retrieve)){?>
			<td><?php echo $received; ?></td>
			<td>
			<?php if($shppurchaseorders[$i]['quantity']==$received){
			  echo ($shppurchaseorders[$i]['quantity']-$received);
			}else{?>
			<input type="text" size="5" name="<?php echo $i; ?>"  <?php if($shppurchaseorders[$i]['quantity']==$received){echo "readonly";}?> value="<?php echo ($shppurchaseorders[$i]['quantity']-$received); ?>"/>
			<?php
			}
			?>
			</td>
			<?php }?>
			<td align="right" id="total<?php echo $i; ?>"><?php echo formatNumber($shppurchaseorders[$i]['total']); ?> </td>
			<?php //Authorization.
			  $auth->roleid="8069";//View
			  $auth->levelid=$_SESSION['level'];

			  if(existsRule($auth)){ ?>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			<?php } 
			    //Authorization.
			      $auth->roleid="8070";//View
			      $auth->levelid=$_SESSION['level']; 
			      if(existsRule($auth)){ ?>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
			<?php } ?>
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
		<td colspan="2" align="center">Total:<input name="ttotal" id="ttotal" type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	<?php if(empty($obj->inward)){ ?>
	<?php
			//Authorization.
			$auth->roleid="8069";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }if(!empty($obj->retrieve)){?>
	
	
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/>
		<?php
			//Authorization.
			$auth->roleid="715";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth) and $obj->type=="cash"){
			?>
			<input type="submit" name="action" class="btn btn-warning" value="Raise Purchase"/>
			<input type="submit" name="action" class="btn btn-warning" value="Give Imprest"/>
			<?php
			}
			?>
		
		</td>
	</tr>
		
	<?php }}else{
	?>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="Raise GRN" /></td>
	</tr>
	<?php
	}?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
</div>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
if($saved=="Yes"){
?>
<script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
<?php
	//redirect("addpurchaseorders_proc.php?retrieve=");
}

?>