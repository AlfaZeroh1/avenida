<title>WiseDigits: Exptransactions </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
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
</script>
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

 z
 
 
  $("#employeenames").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname)&where=id in(select refid from fn_generaljournalaccounts where acctypeid=36)",
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
<script language="javascript1.1" type="text/javascript">

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
  var imprestdiv=document.getElementById("imprestdiv");
  
  if(id==1 || id==""){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    imprestdiv.style.display="none";
  }else if(id==2){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    imprestdiv.style.display="none";
  }else if(id==5){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="block";
    transactiondiv.style.display="none";
    imprestdiv.style.display="none";
  }else if(id==11){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="none";
    imprestdiv.style.display="block";
  }else{
    paymentcategory.style.display="block";
    banks.style.display="none";
    chequediv.style.display="none";
    transactiondiv.style.display="block";
    imprestdiv.style.display="none";
    getPaymentCategoryDet(id);
  }
 }
 
  function chechType(id){
  var assets=document.getElementById("assetdiv");
  var expenses=document.getElementById("expensediv");
  var liabilitys=document.getElementById("liabilitydiv");
  
  if(id==""){
    assets.style.display="none";
    expenses.style.display="none";
    liabilitys.style.display="none";
  }else if(id==1){
    assets.style.display="block";
    expenses.style.display="none";
    liabilitys.style.display="none";
  }else if(id==2){
    assets.style.display="none";
    expenses.style.display="block";
    liabilitys.style.display="none";
  }else if(id==3){
    assets.style.display="none";
    expenses.style.display="none";
    liabilitys.style.display="block";
  }else{
    assets.style.display="none";
    expenses.style.display="none";
    liabilitys.style.display="none";
  }
 }
 
 womAdd('chechType("<?php echo $obj->typeid; ?>")');
 womAdd('getPaymentModes("<?php echo $obj->purchasemodeid; ?>")');
 womAdd('getPaymentCategorys("<?php echo $obj->paymentmodeid; ?>")');
 womOn();

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
		{
			document.getElementById("tax").value=xmlhttp.responseText;
			document.getElementById("taxamount").value=document.getElementById("tax").value*document.getElementById("total").value/100;
			calculateTotal();
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
</script>

<div class="content">
<form class="forms" id="theform" action="addexptransactions_proc.php" name="exptransactions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
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
				<td><!--<select name="currencyid" class="selectbox" onchange="getExchangeRate(this.value);">
				<option value="">Select...</option>
				<?php
				$currencys = new Currencys();
				$fields="*";
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
			      </select>-->
			      <input type="hidden" size="5" name="currencyid" id="currencyid" readonly value="<?php echo $obj->currencyid; ?>"/>
			      <input type="text" size="5" name="currencyname" id="currencyname" readonly value="<?php echo $obj->currencyname; ?>"/>
			      <input type="text" size="5" name="exchangerate" id="exchangerate" readonly value="<?php echo $obj->exchangerate; ?>"/>
			      <input type="text" size="5" name="exchangerate2" id="exchangerate2" readonly value="<?php echo $obj->exchangerate2; ?>"/>			      
			      </td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
	        <th align="right">Type  </th>
		<th align="right"><?php if($obj->typeid==1){echo "Assets";}elseif($obj->typeid==2){echo "Expense";}elseif($obj->typeid==3){echo 'Liability';} ?></th>
		<th align="right">Quantity  </th>
		<th align="right">Amount  </th>
		<th align="right">Tax  </th>
		<th align="right">Discount  </th>
		<th align="right">Memo  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="typeid" id="typeid" onchange="chechType(this.value);">
		    <option value="">Select...</option>
			  <option value="1" <?php if($obj->typeid==1){echo "selected";}?>>Assets</option>
			  <option value="2" <?php if($obj->typeid==2){echo "selected";}?>>Expense</option>
			  <option value="3" <?php if($obj->typeid==3){echo "selected";}?>>Liability</option>
		    </select>
		</td>
		<td>
		<div id="expensediv">
		<select name="expenseid" >
		    <option value="">Select...</option>
		    <?php
			    $expenses=new Expenses();
			    $where="  ";
			    $fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			    while($rw=mysql_fetch_object($expenses->result)){
			    ?>
				    <option value="<?php echo $rw->id; ?>" <?php if($obj->expenseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
			    <?php
			    }
			    ?>
		    </select>
		</div>
		<div id="assetdiv">
		<select name="assetid" >
		    <option value="">Select...</option>
		    <?php
			    $assets=new Assets();
			    $where="  ";
			    $fields="inv_assets.*";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			    while($rw=mysql_fetch_object($assets->result)){
			    ?>
				    <option value="<?php echo $rw->id; ?>" <?php if($obj->assetid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
			    <?php
			    }
			    ?>
		    </select>
		</div>
		<div id="liabilitydiv">
		<select name="liabilityid" >
		    <option value="">Select...</option>
		    <?php
			    $liabilitys=new Liabilitys();
			    $where="  ";
			    $fields="fn_liabilitys.*";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $liabilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			    while($rw=mysql_fetch_object($liabilitys->result)){
			    ?>
				    <option value="<?php echo $rw->id; ?>" <?php if($obj->liabilityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
			    <?php
			    }
			    ?>
		    </select>		
		</div>
		</td>
		<td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="amount" id="amount" onchange="calculateTotal();" onblur="calculateTotal();"  size="4" value="<?php echo $obj->amount; ?>"></td>
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
		<input type='hidden' name='taxamount' id='taxamount' readonly size='4'  value='<?php echo $obj->taxamount; ?>' onchange="calculateTotal();"/></td>
		<td><input type="text" name="discount" id="discount" size="6" value="<?php echo $obj->discount; ?>"></td>
		
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
			<div style="float:left;">
		Document No.:<input type="text" readonly name="documentno" id="documentno"  size="4"  value="<?php echo $obj->documentno; ?>">
		Requisition No.:<input type="text" readonly name="requisitionno" id="requisitionno"  size="4"  value="<?php echo $obj->requisitionno; ?>">
		Receipt No.:<input type="text" name="receiptno" id="receiptno"  size="4"  value="<?php echo $obj->receiptno; ?>">
		Expense Date:<input type="text" name="expensedate" id="expensedate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->expensedate; ?>">
		Remarks:<textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
		
		Purchase Mode:<select name='purchasemodeid' id='purchasemodeid' class="selectbox" onchange="getPaymentModes(this.value);">
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
				</div>
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
				&nbsp;
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
			<div id="imprestdiv">
		<select name="imprestaccountid" >
		    <option value="">Select...</option>
		    <?php
			    $imprestaccounts=new Imprestaccounts();
			    $where="  ";
			    $fields="*";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			    while($rw=mysql_fetch_object($imprestaccounts->result)){
			    ?>
				    <option value="<?php echo $rw->id; ?>" <?php if($obj->imprestaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
			    <?php
			    }
			    ?>
		    </select>
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
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Expense  </th>
		<th align="left">Quantity  </th>
		<th align="left">Tax  </th>
		<th align="left">Discount  </th>
		<th align="left">Amount  </th>
		<th align="left">Memo  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpexptransactions']){
		$shpexptransactions=$_SESSION['shpexptransactions'];
		//print_r($_SESSION['shpexptransactions']);
		$i=0;
		$j=$obj->iterator;
		$total=0;
		$totaltax=0;
		while($j>0){

		$total+=$shpexptransactions[$i]['total'];
		$totaltax+=$shpexptransactions[$i]['taxamount'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo $shpexptransactions[$i]['id']; ?></td>
			<td><?php if(!empty($shpexptransactions[$i]['expenseid'])){echo $shpexptransactions[$i]['expensename'];}elseif(!empty($shpexptransactions[$i]['assetid'])){echo $shpexptransactions[$i]['assetname'];}elseif(!empty($shpexptransactions[$i]['liabilityid'])){echo $shpexptransactions[$i]['liabilityname'];} ?> </td>
			<td><?php echo $shpexptransactions[$i]['quantity']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['tax']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['discount']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['amount']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['memo']; ?> </td>
			<td><?php echo $shpexptransactions[$i]['total']; ?> </td>
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
<table align="center" width="100%">
	<tr>
		<td colspan="2" align="center">Total Taxable:<input type="text" size='12' readonly value="<?php echo ($total-$totaltax); ?>"/>&nbsp; Total Tax:<input type="text" size='12' readonly value="<?php echo $totaltax; ?>"/>&nbsp;Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr> 
	        <td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
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
	redirect("addexptransactions_proc.php?retrieve=");
}

?>
