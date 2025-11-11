<title>WiseDigits ERP: Invoices </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=inv_items.name&join=left join inv_unitofmeasures on inv_items.unitofmeasureid=inv_unitofmeasures.id&extra=inv_unitofmeasures.name&extratitle=unitofmeasure",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
		$("#unitofmeasureid").val(ui.item.unitofmeasureid);
		$("#unitofmeasurename").val(ui.item.unitofmeasurename);
		$("#price").val(ui.item.price);
	}
  });

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
		$("#tel").val(ui.item.tel);
		$("#code").val(ui.item.code);
		$("#address").val(ui.item.address);
		$("#remarks").val(ui.item.remarks);
	}
  });

 
  $("#customername2").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name&where=id in(select distinct customerid from crm_customers)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid2").val(ui.item.id);
	}
  });

 
 
});
function calculateTotals()
{

  var quantity=parseFloat(document.getElementById("quantity").value);
  var costprice=parseFloat(document.getElementById("price").value);
   
 // alert(quantity);
  var total=quantity*costprice;
  
  document.getElementById("total").value=total;
  
}
  
function Clickheretoprint(id)
{ 
	var msg;
	msg="Do you want to print invoice?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("printinvoice.php?id="+id+"&doc=<?php echo $obj->documentno; ?>&customerid=<?php echo $obj->customerid; ?>&invoicedon=<?php echo $obj->soldon; ?>&packingno=<?php echo $obj->packingno; ?>&parent=<?php echo $obj->parent; ?>",450,940);
	}
}

function calculateExportTotal(id,size,price){
    
    //$("#exporttotal"+id).html(exporttotal);
    <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
      ?>
      if(size=="<?php echo $shpinvoices[$i]['sizeid']; ?>"){
	var quantity="<?php echo $shpinvoices[$i]['quantity'];?>";
	var exporttotal = Math.round((quantity*price)*Math.pow(10,2))/Math.pow(10,2);
	$("#exportprice<?php echo $i; ?>").val(price);
	$("#exporttotal<?php echo $i; ?>").html(exporttotal);
      }
      
      <?php
      $i++;
    }
    ?>
  }
  
function checkItems(id,boxno){

  if($('#b'+id).is(':checked')) {  
    <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
//       if($shpinvoices)
      ?>//alert(boxno+"==<?php echo $shpinvoices[$i]['boxno']."==".$i; ?>");
      if(boxno=="<?php echo $shpinvoices[$i]['boxno']; ?>"){//alert(boxno);
	$('#b<?php echo $i; ?>').attr('checked',true);
	$('#<?php echo $shpinvoices[$i]['id']; ?>').attr('checked',true);
      }
      <?php
       $i++;
      }
     
      ?>
  }else{
  <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
//       if($shpinvoices)
      ?>//alert(boxno+"==<?php echo $shpinvoices[$i]['boxno']."==".$i; ?>");
      if(boxno=="<?php echo $shpinvoices[$i]['boxno']; ?>"){//alert(boxno);
	$('#b<?php echo $i; ?>').attr('checked',false);
	$('#<?php echo $shpinvoices[$i]['id']; ?>').attr('checked',false);
      }
      <?php
       $i++;
      }
     
      ?>
  }
  
  
}
function checkVariety(id,variety){

  if($('#c'+id).is(':checked')) {  
    <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
//       if($shpinvoices)
      ?>//alert(variety+"==<?php echo $shpinvoices[$i]['variety']."==".$i; ?>");
      if(variety=="<?php echo $shpinvoices[$i]['variety']; ?>"){//alert(boxno);
	$('#c<?php echo $i; ?>').attr('checked',true);
	$('#<?php echo $shpinvoices[$i]['id']; ?>').attr('checked',true);
      }
      <?php
       $i++;
      }
     
      ?>
  }else{
  <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
//       if($shpinvoices)
      ?>//alert(boxno+"==<?php echo $shpinvoices[$i]['variety']."==".$i; ?>");
      if(variety=="<?php echo $shpinvoices[$i]['variety']; ?>"){//alert(boxno);
	$('#c<?php echo $i; ?>').attr('checked',false);
	$('#<?php echo $shpinvoices[$i]['id']; ?>').attr('checked',false);
      }
      <?php
       $i++;
      }
     
      ?>
  }
  
  
}

function checkItemss(id,itemname){

  if($('#i'+id).is(':checked')) {  
    <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
//       if($shpinvoices)
      ?>//alert(variety+"==<?php echo $shpinvoices[$i]['itemname']."==".$i; ?>");
      if(itemname=="<?php echo $shpinvoices[$i]['itemname']; ?>"){//alert(boxno);
	$('#i<?php echo $i; ?>').attr('checked',true);
	$('#<?php echo $shpinvoices[$i]['id']; ?>').attr('checked',true);
      }
      <?php
       $i++;
      }
     
      ?>
  }else{
  <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
//       if($shpinvoices)
      ?>//alert(boxno+"==<?php echo $shpinvoices[$i]['itemname']."==".$i; ?>");
      if(itemname=="<?php echo $shpinvoices[$i]['itemname']; ?>"){//alert(boxno);
	$('#i<?php echo $i; ?>').attr('checked',false);
	$('#<?php echo $shpinvoices[$i]['id']; ?>').attr('checked',false);
      }
      <?php
       $i++;
      }
     
      ?>
  }
  
  
}
  
  
  function calculateTotal(size,itemid,boxno,discount){
    
      <?php
    $shpinvoices=$_SESSION['shpinvoices'];
    $i=0;
    while($i<count($shpinvoices)){
      ?>
      if(size=="<?php echo $shpinvoices[$i]['sizeid']; ?>" && itemid=="<?php echo $shpinvoices[$i]['itemid']; ?>" && boxno=="<?php echo $shpinvoices[$i]['boxno']; ?>" ){
	var quantity="<?php echo $shpinvoices[$i]['quantity'];?>";
	var price="<?php echo $shpinvoices[$i]['price'];?>";
	var vat="<?php echo $shpinvoices[$i]['vat'];?>";
	var total = Math.round(quantity*price*((100+vat)/100)*((100-discount)/100)*Math.pow(10,2))/Math.pow(10,2);
	
	$("#discount<?php echo $i; ?>").val(discount);
	$("#total<?php echo $i; ?>").html(total);
      }
      <?php
      $i++;
      }
      ?>
      
  }
  
 function getExchangeRate()
   {	
        var id=$("#currencyid" ).val();
        var dat=$("#soldon").val();
	var xmlhttp;
	var url="../../sys/currencyrates/populate.php?id="+id+"&date="+dat;
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var data = xmlhttp.responseText; // alert(data);			
			var dsa=String(data);
			if(dsa==1)
			{
			alert("Date not yet set for the month");
			document.getElementById("exchangerate").value="";
			document.getElementById("exchangerate2").value="";
			}else{	
			var dt = data.split("-");
			document.getElementById("exchangerate").value=dt[0];
			document.getElementById("exchangerate2").value=dt[1];
			}
		}
	};
      
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
} 
  
function selectAll(str)
{
	if(str.checked)
	{//check all checkboxes under it
		
		<?php
		$invoicedetails = new Invoicedetails();
		$fields=" pos_invoicedetails.id ";
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_invoices.documentno='$obj->documentno' ";
		$invoicedetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($invoicedetails->result))
		{			
		?>
		if(document.getElementById("<?php echo $rw->id; ?>")){
// 			alert("Success <?php echo $rw->id; ?>");
			document.getElementById("<?php echo $rw->id; ?>").checked=true;
		}
		<?php		
		}
		?>
	}
	else
	{
		//uncheck all checkboxes under it
		<?php
		$invoicedetails = new Invoicedetails();
		$fields=" pos_invoicedetails.id ";
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_invoices.documentno='$obj->documentno' ";
		$invoicedetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($invoicedetails->result))
		{
		?>
		document.getElementById("<?php echo $rw->id; ?>").checked=false;
		<?php
		}
		?>
	}
}
</script>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		
		"sScrollY": 200,
		"bJQueryUI": true,
		"iDisplayLength":2000,
		"sPaginationType": "full_numbers",
		"aLengthMenu": [10, 25, 50, 100,200,500,1000,2000]
	} );
	
	$('#tbl2').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"sScrollY": 180,
		"bJQueryUI": true,
		"iDisplayLength":2000,
		"sPaginationType": "full_numbers"
	} );
 } );
 </script>

<div class="content">
<form  id="theform" action="addinvoices_proc.php" name="invoices" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>
		<input type="hidden" name="parent" value="<?php echo $obj->parent; ?>"/>
		<?php
		if(!empty($obj->parent)){
		?>
		Parent Customer: <input type='text' size='20' name='customername2' id='customername2' value='<?php echo $obj->customername2; ?>'>
					<input type="hidden" name='customerid2' id='customerid2' value='<?php echo $obj->customerid2; ?>'><br/>
		Invoice Date: <input type="text" name="invoicedate" id="invoicedate"  class="date_input" size="16" readonly  value="<?php echo $obj->invoicedate; ?>">
		<?php }else{?>
		Document No:<input type="text" size="4" name="invoicenos"/>&nbsp;
		<?php }?>
		<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Customer:</label></td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'>
					<input type="hidden" name='code' id='code' value='<?php echo $obj->code; ?>'></td>
				<td><label>TelNo.:</label></td>
				<td><input type='text' name='tel' id='tel' size='16' readonly value='<?php echo $obj->tel; ?>'/></td>			
			<tr>
				<td><label>Address:</label></td>
				<td><textarea name='address' id='address' size='16' readonly><?php echo $obj->address; ?></textarea></td>				<td><label>Remarks:</label></td>
				<td><textarea name='remarks' id='remarks' readonly><?php echo $obj->remarks; ?></textarea></td>
			</td>
			</tr>
			<tr>
				<td><label>Agent:</label></td>
<td><select name="agentid" id="agentid" class="selectbox">
<option value="">Select...</option>
<?php
	$agents=new Agents();
	$where="  ";
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($agents->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->agentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>			</td>
			</tr>
			<tr>
			  <td>VATable</td>
			  <td><input type="text" name='vatable' id='vatable' size="4" readonly value="<?php echo $obj->vatable; ?>"/>&nbsp;
			      <input type="hidden" name="vat" id="vat" value="<?php echo $obj->vat; ?>"/>
			      <lable>Sale Type:</lable>
			      <select name="saletypeid">
				<?php
				$saletypes = new Saletypes();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" ";
				$saletypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($saletypes->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->saletypeid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select>
			      </td>
			</tr>
			<tr>
			  <td>Exchange Rate</td>
			  <td><select name="currencyid" id="currencyid">
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
			     
			      <input type="text" name="exchangerate" size="6" id="exchangerate" value="<?php echo $obj->exchangerate; ?>"/>
			      <input type="text" name="exchangerate2" size="6" id="exchangerate2" value="<?php echo $obj->exchangerate2; ?>"/>
			     
			  </td>
			  <td>CONSIGNEE: </td>
			  <td><select name="customerconsigneeid" class="selectbox">
<option value="">Select...</option>
<?php
	$customerconsignees=new Customerconsignees();
	$where=" where customerid='$obj->customerid' ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$customerconsignees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($customerconsignees->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->customerconsigneeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
			</tr>
			<tr>
			  <td colspan='2' align="center"><font color="red"><?php echo $error; ?></font></td>
			</tr>
		</table>
		
	
		<table align='center'>
			<tr>
			<td>
		Document No:<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>"/>
		Invoice No:<input type="text" name="invoiceno" id="invoiceno" readonly size="8"  value="<?php echo $obj->invoiceno; ?>"/>
		Packing No:<input type="text" name="packingno" id="packingno"  size="8"  value="<?php echo $obj->packingno; ?>">
		Remarks:<textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
		Sold On:<input type="text" name="soldon" id="soldon"  class="date_input" size="16" readonly onchange="getExchangeRate();" value="<?php echo $obj->soldon; ?>">
		Actual Weight:<input type="text" name="actualweight" id="actualweight"  size="16"  value="<?php echo $obj->actualweight; ?>">
		Volume Weight:<input type="text" name="volumeweight" id="volumeweight"  size="16"  value="<?php echo $obj->volumeweight; ?>">
		AWB No:<input type="text" name="awbno" id="awbno"  size="16"  value="<?php echo $obj->awbno; ?>">
		Drop Off Point:<input type="text" name="dropoffpoint" id="dropoffpoint"  size="16"  value="<?php echo $obj->dropoffpoint; ?>">
		Shipped On:<input type="date" name="shippedon" id="shippedon"  class="date_input" size="16" readonly  value="<?php echo $obj->shippedon; ?>">
		Memo:<textarea name="memo" ><?php echo $obj->memo; ?></textarea>
		
			</td>
			</tr>
		</table>
		
		<h2>FLOWER ITEMS</h2>
		<hr/>
<?php ?>
<table style="clear:both" id="tbl" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if(!empty($obj->retrieve)){?>
		    <th><input type="checkbox" onclick="selectAll(this);"/>All</th>
		<?php } ?>
		<th align="left">Item  </th>
		<th align="left">Variety  </th>
		<th align="left">Length  </th>
		<th align="left">Mixed Box  </th>
		<th align="left">Mixed Box  </th>
		<th align="left">Quantity  </th>
		<th align="left">Price  </th>		
		<th align="left">VAT(%)</th>
		<th align="left">Export Price  </th>
		<th align="left">Discount  </th>
		<th align="left">Bonus  </th>
		<th align='left'>Total</th>
		<th align='left'>Export Total</th>
		<th align='left'>Box No<input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th align='left'>Variety<input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th align='left'>Product<input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpinvoices']){//print_r($_SESSION['shpinvoices']);
		$shpinvoices=$_SESSION['shpinvoices'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		$exporttotals=0;
		while($j>0){

		if(true){
		  if($obj->vatable=="Yes"){
		    $shpinvoices[$i]['vat']=16;
		    $shpinvoices[$i]['total']=($shpinvoices[$i]['total'])*(100+$shpinvoices[$i]['vat'])/100;
		  }	
		  
		  $total+=$shpinvoices[$i]['total'];
		  $exporttotals+=$shpinvoices[$i]['exporttotal'];
		  ?>
		  <tr style="font-size:12px; vertical-align:text-top; ">
			  <td><?php echo ($i+1); ?></td>
			  <?php if(!empty($obj->retrieve)){?>
			  <td><input type="checkbox" name="<?php echo $shpinvoices[$i]['id']; ?>" id="<?php echo $shpinvoices[$i]['id']; ?>"/></td>
			  <?php } ?>
			  <td><?php echo $shpinvoices[$i]['itemname']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['variety']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['sizename']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['mixedbox']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['itemnam']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['quantity']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['price']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['vat']; ?> </td>
			  <td><input type="text" size="2" name="exportprice<?php echo $i; ?>" id="exportprice<?php echo $i; ?>" value="<?php if(!empty($obj->invoiceno)){echo $shpinvoices[$i]['exportprice'];}else{echo $_POST['exportprice'.$i];} ?>" onChange="calculateExportTotal('<?php echo $i; ?>','<?php echo $shpinvoices[$i]['sizeid']; ?>',this.value);"/></td>
			  <td><input type="text" size="2" name="discount<?php echo $i; ?>" id="discount<?php echo $i; ?>" value="<?php if(!empty($obj->invoiceno)){echo $shpinvoices[$i]['discount'];}else{echo $_POST['discount'.$i];} ?>" onChange="calculateTotal('<?php echo $shpinvoices[$i]['sizeid']; ?>','<?php echo $shpinvoices[$i]['itemid']; ?>','<?php echo $shpinvoices[$i]['boxno']; ?>',this.value);"/></td>
			  <td><?php echo $shpinvoices[$i]['bonus']; ?> </td>
			  <td id="total<?php echo $i; ?>"><?php echo $shpinvoices[$i]['total']; ?> </td>			
			  <td id="exporttotal<?php echo $i; ?>"><?php echo $shpinvoices[$i]['exporttotal']; ?> </td>
			  <td><?php echo $shpinvoices[$i]['boxno']; ?><input type="checkbox" name="b<?php echo $i; ?>" id="b<?php echo $i; ?>" onchange="checkItems('<?php echo $i; ?>','<?php echo $shpinvoices[$i]['boxno']; ?>');"/></td>
			  <td><?php echo $shpinvoices[$i]['variety']; ?><input type="checkbox" name="c<?php echo $i; ?>" id="c<?php echo $i; ?>" onchange="checkVariety('<?php echo $i; ?>','<?php echo $shpinvoices[$i]['variety']; ?>');"/></td>
			  <td><?php echo $shpinvoices[$i]['itemname']; ?><input type="checkbox" name="i<?php echo $i; ?>" id="i<?php echo $i; ?>" onchange="checkItemss('<?php echo $i; ?>','<?php echo $shpinvoices[$i]['itemname']; ?>');"/></td>
			  <!--<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			  <td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>-->
		  </tr>
		  <?php
		  }
		  
		  $i++;
		  $j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" width="100%">
	<tr>
		<td align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
		<td align="center">Export Total:<input type="text" size='12' name="exporttotals" id="exporttotals" readonly value="<?php echo $exporttotals; ?>"/></td>
	</tr>
</table>

		<h2>NON - FLOWER ITEMS</h2>
		<hr/>
		<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Item  </th>
		<th align="right">UoM  </th>
		<th align="right">Quantity  </th>
		<th align="right">Price  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname'  id='itemname' value='<?php echo $obj->itemname; ?>'/>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'/>
			<input type="hidden" name='section' id='section' value='2'/><font color='red'>*</font>
		</td>

<td><input type="hidden" name="unitofmeasureid" id="unitofmeasureid" size="16" value="<?php echo $obj->unitofmeasureid; ?>"/>
    <input type="text" readonly name="unitofmeasurename" id="unitofmeasurename" size="16" value="<?php echo $obj->unitofmeasurename; ?>"/></td>
<td><input type="text" name="quantity" id="quantity" size="16" value="<?php echo $obj->quantity; ?>" onchange="calculateTotals();"></td>
		<td><input type="text" readonly name="price" id="price" size="16" value="<?php echo $obj->price; ?>"></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action4" value="Add"/></td>
	</tr>
	</table>
		<table style="clear:both" id="tbl" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Item  </th>
		<th align="left">Unit  </th>
		<th align="left">Quantity  </th>
		<th align="left">Rate  </th>
		<th align='left'>Amt <input type="hidden" name="iterators" value="<?php echo $obj->iterators; ?>"/></th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpconsumables']){
		$shpconsumables=$_SESSION['shpconsumables'];
		$i=0;
		$j=$obj->iterators;
		$total=0;
		$exporttotals=0;
		while($j>0){

		if(true){	
		
		  $total+=$shpconsumables[$i]['total'];
		  $exporttotals+=$shpconsumables[$i]['exporttotal'];
		  ?>
		  <tr style="font-size:12px; vertical-align:text-top; ">
			  <td><?php echo ($i+1); ?></td>			  
			  <td> <?php echo $shpconsumables[$i]['itemname']; ?> </td>
			  <td><?php echo $shpconsumables[$i]['unitofmeasurename']; ?> </td>
			  <td><?php echo $shpconsumables[$i]['quantity']; ?> </td>
			  <td><?php echo round($shpconsumables[$i]['price'],2); ?> </td>
			  <td><?php echo round($shpconsumables[$i]['total'],2); ?> </td>	
			  <td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			  <td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
		  </tr>
		  <?php		  
		  }
		  $i++;
		  $j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" width="100%">
	<tr>
		<td colspan="2" align="center">
		<?php if(empty($obj->retrieve)){?>
		<input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;
		<?php } ?>
		<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td><br><br>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	
	<tr>
		<td colspan="2" align="center">
		<input type="submit" class="btn btn-info" name="action" id="action" value="Raise Debit Note"/>&nbsp;
		<input type="submit" class="btn btn-info" name="action" id="action" value="Raise Credit Note"/>&nbsp;
		<input type="button" class="btn btn-info" name="action" id="action" value="Print Invoice" onclick="Clickheretoprint(1);"/>&nbsp;
		<input type="button" class="btn btn-info" name="action" id="action" value="Print Export Invoice" onclick="Clickheretoprint(2);"/></td>
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
    <script language="javascript1.1" type="text/javascript">Clickheretoprint(1);</script>
    <?

	redirect("addinvoices_proc.php?retrieve=");
}

?>