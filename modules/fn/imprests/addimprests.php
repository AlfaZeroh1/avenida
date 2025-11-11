<title>WiseDigits: Imprests </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
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

 
  $("#employeenames").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeids").val(ui.item.id);
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

});

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
  var slipdiv=document.getElementById("slipdiv");
  var transactiondiv=document.getElementById("transactiondiv");
  var employeediv=document.getElementById("employeediv");
  var imprestdiv=document.getElementById("imprestdiv");
  
  if(id==1){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    slipdiv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
    imprestdiv.style.display="block";
  }else if(id==2){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="block";
    slipdiv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
    imprestdiv.style.display="none";
  }else if(id==5){
    paymentcategory.style.display="none";
    banks.style.display="block";
    chequediv.style.display="none";
    slipdiv.style.display="block";
    transactiondiv.style.display="none";
    employeediv.style.display="none";
    imprestdiv.style.display="none";
  }else if(id==11){
    paymentcategory.style.display="none";
    banks.style.display="none";
    chequediv.style.display="none";
    slipdiv.style.display="none";
    transactiondiv.style.display="none";
    employeediv.style.display="block";
    imprestdiv.style.display="none";
  }else{
    paymentcategory.style.display="block";
    banks.style.display="none";
    chequediv.style.display="none";
    slipdiv.style.display="none";
    transactiondiv.style.display="block";
    employeediv.style.display="none";
    imprestdiv.style.display="none";
    getPaymentCategoryDet(id);
  }
 }
 
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
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>

<hr>
<div class="content">
<form class="forms" id="theform" action="addimprests_proc.php" name="imprests" method="POST" enctype="multipart/form-data">
	<table width="100%" class="table titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/><input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
	<td>Payment Voucher No:</td>
	<td><input type="text" readonly name="paymentvoucherno" value="<?php echo $obj->paymentvoucherno; ?>"/>
	</tr>
	<!--<tr>
				<td><label>Project:</label></td>
				<td><textarea name='projectname' id='projectname'><?php echo $obj->projectname; ?></textarea>
					<input type="hidden" name='projectid' id='projectid' value='<?php echo $obj->projectid; ?>'></td>
			</td>-->
	<table width="100%" class="table titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Imprest Account  </th>
		<th align="right">Employee </th>
		<th align="right">Amount  </th>
		<th align="right">Remarks  </th>
		<th></th>
	</tr>
	<tr>
		<td><select name="imprestaccountid" >
<option value="">Select...</option>
<?php
	$imprestaccounts=new Imprestaccounts();
	$where="  ";
	$fields="fn_imprestaccounts.id, fn_imprestaccounts.name, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, fn_imprestaccounts.remarks, fn_imprestaccounts.ipaddress, fn_imprestaccounts.createdby, fn_imprestaccounts.createdon, fn_imprestaccounts.lasteditedby, fn_imprestaccounts.lasteditedon";
	$join=" left join hrm_employees on hrm_employees.id=fn_imprestaccounts.employeeid ";
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
		</td>
		<td><input type='text' size='32' name='employeename'  id='employeename' value='<?php echo $obj->employeename; ?>'>
		    <input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		    <input type="hidden" size="5" name="currencyid" id="currencyid" readonly value="<?php echo $obj->currencyid; ?>"/>
		    <input type="hidden" size="5" name="currencyname" id="currencyname" readonly value="<?php echo $obj->currencyname; ?>"/>
		    <input type="hidden" size="5" name="exchangerate" id="exchangerate" readonly value="<?php echo $obj->exchangerate; ?>"/>
		    <input type="hidden" size="5" name="exchangerate2" id="exchangerate2" readonly value="<?php echo $obj->exchangerate2; ?>"/>
		</td>
		<td><input type="text" name="amount" id="amount" size="6" value="<?php echo $obj->amount; ?>"></td>
		<td><textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center' class="table">
			<tr>
			<td>Imprest No:
			<td><input type="text" name="documentno" id="documentno" readonly size="4"  value="<?php echo $obj->documentno; ?>">
			<td>Memo:</td>
			<td><textarea name="memo" ><?php echo $obj->memo; ?></textarea>
			<td>Issued On:
			<td><input type="date" name="issuedon" id="issuedon" readonly class="date_input" size="12" readonly  value="<?php echo $obj->issuedon; ?>">
			<td><div id="paymentmode" style="float:left;">
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
			<div id="imprestdiv">
				Petty Cash Account:<select name='imprestaccountid' id='imprestaccountid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$imprestaccounts=new Imprestaccounts();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" ";
				$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($imprestaccounts->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->imprestaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
				</div>
			<div id="employeediv" style="float:left;">
			  Employee: <input type='text' size='32' name='employeenames' id='employeenames' value='<?php echo $obj->employeenames; ?>'>
					<input type="hidden" name='employeeids' id='employeeids' value='<?php echo $obj->employeeids; ?>'>
			</div>
			<div id="chequediv" style="float:left;">
			  <input type="text" name="chequeno" value="<?php echo $obj->chequeno; ?>"/>
			</div>
			<div id="slipdiv" style="float:left;">
			  <input type="text" name="chequeno" value="<?php echo $obj->chequeno; ?>"/>
			</div>
			<div id="transactiondiv" style="float:left;">
			  <input type="text" name="transactionno" value="<?php echo $obj->transactionno; ?>"/>
			</div>
			</td>
			</tr>
		</table>
<table style="clear:both" class="table display" id="" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Imprest/Employee  </th>
		<th align="left">Amount  </th>
		<th align="left">Remarks  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpimprests']){
		$shpimprests=$_SESSION['shpimprests'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpimprests[$i]['imprestaccountname']; ?> <?php echo $shpimprests[$i]['employeename']; ?> </td>
			<td><?php echo $shpimprests[$i]['amount']; ?> </td>
			<td><?php echo $shpimprests[$i]['remarks']; ?> </td>
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
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>"><input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
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
	redirect("addimprests_proc.php?retrieve=");
}

?>