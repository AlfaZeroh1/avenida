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
	msg="Do you want to print returninward?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?id="+id+"&doc=<?php echo $obj->documentno; ?>&customerid=<?php echo $obj->customerid; ?>&returninwarddon=<?php echo $obj->soldon; ?>&packingno=<?php echo $obj->packingno; ?>&types=<?php echo $obj->types; ?>",450,940);
	}
}

function calculateExportTotal(id,size,price){
    
    //$("#exporttotal"+id).html(exporttotal);
    <?php
    $shpreturninwards=$_SESSION['shpreturninwards'];
    $i=0;
    while($i<count($shpreturninwards)){
      ?>
      if(size=="<?php echo $shpreturninwards[$i]['sizeid']; ?>"){
	var quantity="<?php echo $shpreturninwards[$i]['quantity'];?>";
	var exporttotal = Math.round((quantity*price)*Math.pow(10,2))/Math.pow(10,2);
	$("#exportprice<?php echo $i; ?>").val(price);
	$("#exporttotal<?php echo $i; ?>").html(exporttotal);
      }
      
      <?php
      $i++;
    }
    ?>
  }
  
  function calculateTotal(size,itemid,boxno,discount){
    
      <?php
    $shpreturninwards=$_SESSION['shpreturninwards'];
    $i=0;
    while($i<count($shpreturninwards)){
      ?>
      if(size=="<?php echo $shpreturninwards[$i]['sizeid']; ?>" && itemid=="<?php echo $shpreturninwards[$i]['itemid']; ?>" && boxno=="<?php echo $shpreturninwards[$i]['boxno']; ?>" ){
	var quantity="<?php echo $shpreturninwards[$i]['quantity'];?>";
	var price="<?php echo $shpreturninwards[$i]['price'];?>";
	var vat="<?php echo $shpreturninwards[$i]['vat'];?>";
	var total = Math.round(quantity*price*((100+vat)/100)*((100-discount)/100)*Math.pow(10,2))/Math.pow(10,2);
	
	$("#discount<?php echo $i; ?>").val(discount);
	$("#total<?php echo $i; ?>").html(total);
      }
      <?php
      $i++;
      }
      ?>
      
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
 	
 	$('#tbl2').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 
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
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  <?php $rules= new Rules (); ?>
  var url="set.php?i="+id+"&val="+value+"&field="+field;
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
  
}
 </script>

<div class="content">
<form  id="theform" action="addreturninwards_proc.php" name="returninwards" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center">
		
		<input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>
		<input type="hidden" name="parent" value="<?php echo $obj->parent; ?>"/>
		<?php
		if(!empty($obj->parent)){
		?>
		Parent Customer: <input type='text' size='20' name='customername2' id='customername2' value='<?php echo $obj->customername2; ?>'>
					<input type="hidden" name='customerid2' id='customerid2' value='<?php echo $obj->customerid2; ?>'><br/>
		Invoice Date: <input type="text" name="returninwarddate" id="returninwarddate"  class="date_input" size="16" readonly  value="<?php echo $obj->returninwarddate; ?>">
		<?php }else{?>
		Document No:
		<select name="types" class="selectbox">
		  <option value="credit" <?php if($obj->types=="credit"){echo "selected";}?>>CREDIT NOTE</option>
		  <option value="debit" <?php if($obj->types=="debit"){echo "selected";}?>>DEBIT NOTE</option>
		</select>
		<input type="text" size="4" name="returninwardnos"/>&nbsp;
		<?php }?>
		<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Customer:</label></td>
				<td>
				<input type="text" name='type' id='type' value='<?php echo $obj->type; ?>'>
				<input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'></td>
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
				<option value="">Select...</option>
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
			  <td><select name="currencyid">
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
		Credit Note No:<input type="text" name="creditnotenos" id="creditnotenos" size="8"  value="<?php echo $obj->creditnotenos; ?>"/>
		<input type="text" name="creditnoteno" id="creditnoteno" size="8"  value="<?php echo $obj->creditnoteno; ?>"/>
		Document No:<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>"/>
		Invoice No:<input type="text" name="invoiceno" id="invoiceno" readonly size="8"  value="<?php echo $obj->invoiceno; ?>"/>
		Packing No:<input type="text" name="packingno" id="packingno" readonly  size="8"  value="<?php echo $obj->packingno; ?>">
		Remarks:<textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
		Returned On:<input type="text" name="returnedon" id="returnedon"  class="date_input" size="16" readonly  value="<?php echo $obj->returnedon; ?>">		
		Memo:<textarea name="memo" ><?php echo $obj->memo; ?></textarea>
		
			</td>
			</tr>
		</table>
		
		<h2>FLOWER ITEMS</h2>
		<hr/>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if(!empty($obj->retrieve)){?>
		    <th>&nbsp;</th>
		<?php } ?>
		<th align="left">Item  </th>
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
	</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpreturninwards']){
		$shpreturninwards=$_SESSION['shpreturninwards'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		$exporttotals=0;
		while($j>0){

		if(true){
		  if($obj->vatable=="Yes"){
		    $shpreturninwards[$i]['vat']=16;
		    $shpreturninwards[$i]['total']=$shpreturninwards[$i]['total']*(100+$shpreturninwards[$i]['vat'])/100;
		  }	
		  
		  $total+=$shpreturninwards[$i]['total'];
		  $exporttotals+=$shpreturninwards[$i]['exporttotal'];
		  ?>
		  <tr style="font-size:12px; vertical-align:text-top; ">
			  <td><?php echo ($i+1); ?></td>
			  <?php if(!empty($obj->retrieve)){?>
			  <td><input type="checkbox" name="<?php echo $shpreturninwards[$i]['id']; ?>"/></td>
			  <?php } ?>
			  <td><?php echo $shpreturninwards[$i]['itemname']; ?> </td>
			  <td><?php echo $shpreturninwards[$i]['sizename']; ?> </td>
			  <td><?php echo $shpreturninwards[$i]['mixedbox']; ?> </td>
			  <td><?php echo $shpreturninwards[$i]['itemnam']; ?> </td>
			  <td><input type="text" size="2" value="<?php echo $shpreturninwards[$i]['quantity']; ?>" onChange="changeValue('quantity','<?php echo $i; ?>',this.value);"/> </td>
			  <td><input type="text" size="2" value="<?php echo $shpreturninwards[$i]['price']; ?>" onChange="changeValue('price','<?php echo $i; ?>',this.value);"/> </td>
			  <td><?php echo $shpreturninwards[$i]['vat']; ?> </td>
			  <td><input type="text" size="2" name="exportprice<?php echo $i; ?>" id="exportprice<?php echo $i; ?>" value="<?php if(!empty($obj->returninwardno)){echo $shpreturninwards[$i]['exportprice'];}else{echo $_POST['exportprice'.$i];} ?>" onChange="calculateExportTotal('<?php echo $i; ?>','<?php echo $shpreturninwards[$i]['sizeid']; ?>',this.value);"/></td>
			  <td><input type="text" size="2" name="discount<?php echo $i; ?>" id="discount<?php echo $i; ?>" value="<?php if(!empty($obj->returninwardno)){echo $shpreturninwards[$i]['discount'];}else{echo $_POST['discount'.$i];} ?>" onChange="calculateTotal('<?php echo $shpreturninwards[$i]['sizeid']; ?>','<?php echo $shpreturninwards[$i]['itemid']; ?>','<?php echo $shpreturninwards[$i]['boxno']; ?>',this.value);"/></td>
			  <td><?php echo $shpreturninwards[$i]['bonus']; ?> </td>
			  <td id="total<?php echo $i; ?>"><?php echo $shpreturninwards[$i]['total']; ?> </td>			
			  <td id="exporttotal<?php echo $i; ?>"><?php echo $shpreturninwards[$i]['exporttotal']; ?> </td>
			  <td><?php echo $shpreturninwards[$i]['boxno']; ?> </td>
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
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" class="btn btn-info" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center">
		
		<input type="button" class="btn btn-info" name="action" id="action" value="Print" onclick="Clickheretoprint(1);"/></td>
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

	//redirect("addreturninwards_proc.php?retrieve=");
}

?>