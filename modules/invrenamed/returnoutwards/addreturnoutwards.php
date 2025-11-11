<title>WiseDigits ERP: Returnoutwards </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
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
	}
  });

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

  $("#assetname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=assets&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#assetid").val(ui.item.id);
		$("#costprice").val(ui.item.costprice);
	}
  });

});

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
      var tax = parseFloat($("#tax"+id).text());
      var quantity = value;
      var total;
      var vtamount;
      var costprice = parseFloat($("#costprice"+id).text());
      
      calculateTotal(tax,id,quantity,costprice,total,vtamount);
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  <?php $rules= new Rules (); ?>
  var url="set.php?i="+id+"&val="+value+"&field="+field;alert(url);
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function setval(field,id,value){
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
    //
    }
  }
  <?php $rules= new Rules (); ?>
  var url="set.php?i="+id+"&val="+value+"&field="+field;alert(url);
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function setTotal(field,value){
  var tax = parseFloat(document.getElementById('tax').value);
  var quantity = parseFloat(document.getElementById('quantity').value);
  var costprice = parseFloat(document.getElementById('costprice').value);
  var discount = parseFloat(document.getElementById('discount').value);
  
  if(discount=='' || discount=='NaN' || isNaN(discount))
    discount=0;
    
  if(tax=='' || tax=='NaN' || isNaN(tax))
    tax=0;
  
  document.getElementById('total').value=quantity*(costprice*(100-discount)/100 * (100+tax)/100);
  document.getElementById('total').value=quantity*(costprice*(100-discount)/100 * (100+tax)/100);
}

 function getExchangeRate(id)
   {	
    
	var xmlhttp;
	var url="../../sys/currencys/populate.php?id="+id;//alert(url);
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
			var dt = data.split("-");
			document.getElementById("exchangerate").value=dt[0];
			document.getElementById("exchangerate2").value=dt[1];
		}
	};
      
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
} 

function chechType(id){
  var assets=document.getElementById("assetdiv");
  var items=document.getElementById("itemdiv");
  if(id==""){
    assets.style.display="none";
    items.style.display="none";
  }else if(id==1){
    assets.style.display="block";
    items.style.display="none";
  }else if(id==2){
    assets.style.display="none";
    items.style.display="block";
  }else{
    assets.style.display="none";
    items.style.display="none";
  }
 }
 womAdd('chechType("<?php echo $obj->typeid; ?>")');
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

<hr>
<div class="content">
<form  id="theform" action="addreturnoutwards_proc.php" name="returnoutwards" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
	  <td colspan='4' align="center">
	    <select name="types" class="selectbox">
		  <option value="credit" <?php if($obj->types=="credit"){echo "selected";}?>>CREDIT NOTE</option>
		  <option value="debit" <?php if($obj->types=="debit"){echo "selected";}?>>DEBIT NOTE</option>
		</select>
	  </td>
	</tr>
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
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
				<td><select name="currencyid" class="selectbox" onchange="getExchangeRate(this.value);">
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
			      <input type="text" size="5" name="exchangerate" id="exchangerate" value="<?php echo $obj->exchangerate; ?>"/>
			      <input type="text" size="5" name="exchangerate2" id="exchangerate2" value="<?php echo $obj->exchangerate2; ?>"/></td>
			</td>
			</tr>
			
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>    <th align="right">Type  </th>
		<th align="right">Item  </th>
		<th align="right">Quantity  </th>
		<th align="right">Cost Price  </th>
		<th align="right">Applicable Tax  </th>
		<th align="right">Discount  </th>
		<th align="right">Total  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
	       <td><select name="typeid" id="typeid" onchange="chechType(this.value);">
		    <option value="">Select...</option>
			  <option value="1" <?php if($obj->typeid==1){echo "selected";}?>>Assets</option>
			  <option value="2" <?php if($obj->typeid==2){echo "selected";}?>>Items</option>
		    </select>
		</td>
	        <td>
		<div id="itemdiv">
		<input type='text' size='32' name='itemname'  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>
		</div>
		<div id="assetdiv">
		   <input type='text' size='32' name='assetname' id='assetname' value='<?php echo $obj->assetname; ?>'>
			<input type="hidden" name='assetid' id='assetid' value='<?php echo $obj->assetid; ?>'>
		</div>
		</td>	
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" size="5" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="costprice" id="costprice" onChange="setTotal('costprice',this.value);" size="5" value="<?php echo $obj->costprice; ?>"></td>
		<td><input type="text" name="tax" id="tax" size="5" value="<?php echo $obj->tax; ?>"></td>
		<td><input type="text" name="discount" id="discount" size="5" value="<?php echo $obj->discount; ?>"></td>
		<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
		<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Document No.:<input type="text" name="documentno" id="documentno" readonly  size="5"  value="<?php echo $obj->documentno; ?>">
		Purchase Invoice/Receipt No:<input type="text" name="purchaseno" readonly id="purchaseno"  size="5"  value="<?php echo $obj->purchaseno; ?>">
		Mode Of Payment:				<select name='purchasemodeid' class="selectbox">
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
		Returned On:<input type="date" name="returnedon" id="returnedon"  size="20" class='date_input' value="<?php echo $obj->returnedon; ?>">
		Memo:<input type="text" name="memo" id="memo"  size="20"  value="<?php echo $obj->memo; ?>">
			</td>
			</tr>
		</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Item  </th>
		<th align="left">Quantity  </th>
		<th align="left">Cost Price  </th>
		<th align="left">Applicable Tax  </th>
		<th align="left">Discount  </th>
		<th align="left">Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if(!empty($_SESSION['shpreturnoutwards'])){
		$shpreturnoutwards=$_SESSION['shpreturnoutwards'];
		$i=0;
		$j=count($shpreturnoutwards);
		$total=0;
		while($j>0){

		$total+=$shpreturnoutwards[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php if(!empty($shpreturnoutwards[$i]['itemid']))echo $shpreturnoutwards[$i]['itemname'];else echo $shpreturnoutwards[$i]['assetname']; ?> </td>
			<td><input type="text" size="3" onChange="changeValue('quantity','<?php echo $i; ?>',this.value);" name="quantity<?php echo $i; ?>" id="quantity<?php echo $i; ?>" value="<?php echo $shpreturnoutwards[$i]['quantity']; ?>"/></td>
			<td id="costprice<?php echo $i; ?>"><?php echo $shpreturnoutwards[$i]['costprice']; ?> </td>
			<td id="tax<?php echo $i; ?>"><?php echo $shpreturnoutwards[$i]['tax']; ?> </td>
			<td id="discount<?php echo $i; ?>"><?php echo $shpreturnoutwards[$i]['discount']; ?> </td>
			<td id="total<?php echo $i; ?>"><?php echo $shpreturnoutwards[$i]['total']; ?> </td>
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
	  <tr>
	                <th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th align='right'>TOTAL: </th>
			<th id="ftotal" align='left'><?php echo $total; ?></th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
	</tr>
	</tfoot>
</table>
<table align="center" width="100%">	
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
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
	redirect("addreturnoutwards_proc.php?retrieve=");
}

?>