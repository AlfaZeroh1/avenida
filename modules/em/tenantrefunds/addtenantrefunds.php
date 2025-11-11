<title>WiseDigits: Tenantrefunds </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#tenantname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=tenants&field=concat(concat(firstname,' ',middlename),' ',lastname)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#tenantid").val(ui.item.id);
		$("#registeredon").val(ui.item.registeredon);
		$("#postaladdress").val(ui.item.postaladdress);
		$("#idno").val(ui.item.idno);
		$("#passportno").val(ui.item.passportno);
		$("#address").val(ui.item.address);
	}
  });

  $("#paymenttermname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=paymentterms&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#paymenttermid").val(ui.item.id);
	}
  });

});

function selectHouses()
{
	try{
	var id=document.getElementById("tenantid").value;
	var xmlhttp;
	var url="../tenantpayments/populate.php?id="+id;
	xmlhttp=GetXmlHttpObject();
	
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }

xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4)
	{
		document.getElementById("houseid").innerHTML=xmlhttp.responseText;
	}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
	}catch(e){alert(e);}
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

<form class="forms" action="addtenantrefunds_proc.php" name="tenantrefunds" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
			<tr>
				<td>Tenant:</td>
				<td><input type='text' name='tenantname' id='tenantname' value='<?php echo $obj->tenantname; ?>'>
					<input type="hidden" name='tenantid' id='tenantid' value='<?php echo $obj->tenantid; ?>'></td>
				<td>Reg Date:</td>
				<td><input type='text' name='registeredon' id='registeredon' readonly value='<?php echo $obj->registeredon; ?>' class='date_input' /></td>			<tr>
				<td>Postal Address:</td>
				<td><textarea name='postaladdress' id='postaladdress' readonly><?php echo $obj->postaladdress; ?></textarea></td>
				<td>National ID No:</td>
				<td><input type='text' name='idno' id='idno' readonly value='<?php echo $obj->idno; ?>'/></td>			<tr>
				<td>Passport No:</td>
				<td><input type='text' name='passportno' id='passportno' readonly value='<?php echo $obj->passportno; ?>'/></td>				<td>Address:</td>
				<td><textarea name='address' id='address' readonly><?php echo $obj->address; ?></textarea></td>
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">House  </th>
		<th align="right">Payment Term  </th>
		<th align="right">Amount  </th>
		<th align="right">Month  </th>
		<th align="right">Year  </th>
		<th align="right">Remarks  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="houseid" class="selectbox"  id="houseid">
<option value="">Select...</option>

</select>
		</td>
		<td><select name="paymenttermid"  class="selectbox" id="paymenttermid" onchange="selectHouses();" >
<option value="">Select...</option>
<?php
	$paymentterms=new Paymentterms();
	$where="  ";
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($paymentterms->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->paymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		
		<td><input type="text" name="amount" id="amount" value="<?php echo $obj->amount; ?>"></td>
		<td><select name="month" id="month" class="selectbox">
	        <option value="">Select...</option>
	        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
	        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
	        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
	        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
	        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
	        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
	        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
	        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
	        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
	        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
	        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
	        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select></td>
		<td><select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input class="btn" type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Refund No:<input type="text" name="documentno" id="documentno" readonly size="4"  value="<?php echo $obj->documentno; ?>">
		Refunded On:<input name="refundedon" id="refundedon" readonly class="date_input" readonly  value="<?php echo $obj->refundedon; ?>">
		Paid Through:				<select name='paymentmodeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$fields="sys_paymentmodes.id, sys_paymentmodes.name";
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
		Bank:				<select name='bankid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon";
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
		Cheque No:<input type="text" name="chequeno" id="chequeno"  size="14"  value="<?php echo $obj->chequeno; ?>">
		Received By:<input type="text" name="receivedby" id="receivedby"  size="12"  value="<?php echo $obj->receivedby; ?>">
			</td>
			</tr>
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">House  </th>
		<th align="left">Paymnet Term  </th>
		<th align="left">Amount  </th>
		<th align="left">Month  </th>
		<th align="left">Year  </th>
		<th align="left">Remarks  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shptenantrefunds']){
		$shptenantrefunds=$_SESSION['shptenantrefunds'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shptenantrefunds[$i]['amount'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shptenantrefunds[$i]['housename']; ?> </td>
			<td><?php echo $shptenantrefunds[$i]['paymenttermname']; ?> </td>
			<td><?php echo $shptenantrefunds[$i]['amount']; ?> </td>
			<td><?php echo $shptenantrefunds[$i]['month']; ?> </td>
			<td><?php echo $shptenantrefunds[$i]['year']; ?> </td>
			<td><?php echo $shptenantrefunds[$i]['remarks']; ?> </td>
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
<table style="margin-left:500px;">
	<tr>
		<td align="center">Total:</td><td><input type="text" readonly value="<?php echo $total; ?>"/></td>	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>