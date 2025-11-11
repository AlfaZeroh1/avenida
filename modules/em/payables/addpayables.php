<title>WiseDigits: Payables </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#tenantname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=tenants&field=concat(code,' ',concat(concat(firstname,' ',middlename),' ',lastname))",
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

});
function getRent(){
	try{
	var paymenttermid=document.getElementById('paymenttermid').value;
	var houseid=document.getElementById('houseid').value;

	if(!paymenttermid)
		paymenttermid=0;
	if(!houseid)
		houseid=0;

	
	if(paymenttermid>0){
		if(houseid>0){
			if(paymenttermid==1){
				ajaxGetRent(houseid,paymenttermid);
			}
		}
	}
	}catch(e){alert(e);}
}

function ajaxGetRent(houseid,paymenttermid){
	var xmlhttp;
	var url="getRent.php?houseid="+houseid+"&paymenttermid="+paymenttermid;
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			document.getElementById("amount").value=xmlhttp.responseText;
			calculateTotal();
		}
		};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
function selectHouses()
{
	try{
	var houseid=1;//document.getElementById("houseid").value;
	var paymenttermid=1;//document.getElementById("paymenttermid").value;
	var xmlhttp;
	var url="populate.php?houseid="+houseid+"&paymenttermid="+paymenttermid;
	xmlhttp=GetXmlHttpObject();
	
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }

xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4)
	{
		document.getElementById("remarks").innerHTML=aaData['mgtfee'];
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
<?php include'js.php'; ?>

function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print invoice?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("printinvoice.php?doc=<?php echo $obj->documentno; ?>&tenant=<?php echo $obj->tenantid; ?>&invdate=<?php echo $obj->invoicedon; ?>",450,940);
	}
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

<form class="forms" action="addpayables_proc.php" name="payables" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<?php if(!empty($obj->retrieve)){?>
		<tr>
			<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Invoice No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action2" value="Filter"/></td>
		</tr>
		<?php }?>
			<tr>
				<td>Tenant:</td>
				<td><input type='text' size='20' name='tenantname' id='tenantname' value='<?php echo $obj->tenantname; ?>'>
					<input type="hidden" name='tenantid' id='tenantid' value='<?php echo $obj->tenantid; ?>'></td>
				<td>Reg Date:</td>
				<td><input type='text' name='registeredon' id='registeredon' size='24' readonly value='<?php echo $obj->registeredon; ?>' class='date_input' /></td>			<tr>
				<td>Postal Address:</td>
				<td><textarea name='postaladdress' id='postaladdress' readonly><?php echo $obj->postaladdress; ?></textarea></td>
				<td>National ID No:</td>
				<td><input type='text' name='idno' id='idno' size='24' readonly value='<?php echo $obj->idno; ?>'/></td>			
				<tr>
				<td>Passport No:</td>
				<td><input type='text' name='passportno' id='passportno' size='24' readonly value='<?php echo $obj->passportno; ?>'/></td>				
				<td>Address:</td>
				<td><textarea name='address' id='address' readonly><?php echo $obj->address; ?></textarea></td>
			</tr>
			
			<tr>
				<td>House: <select name="houseid" class="selectbox"  id="houseid" onchange="getRent();">
<option value="">Select...</option>
<?php 
$houses=new Houses();
$where=" where em_housetenants.tenantid='$obj->tenantid'  ";
$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_plots.name plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
$join=" left join em_plots on em_houses.plotid=em_plots.id left join em_housetenants on em_housetenants.houseid=em_houses.id ";
$having=" ";
$groupby="";
$orderby="";
$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rw=mysql_fetch_object($houses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->houseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->plotid);?>=><?php echo initialCap($rw->hseno); ?></option>
	<?php
	}
?>
</select></td>
			</tr>
			<?php if(empty($obj->retrieve)){?>
			<tr>
				<td colspan="4" align="center"><input class="btn" type="submit" name="action" value="Retrieve"/></td>
			</tr>
			<?php }?>
		</table>
		
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Payment Term</th>
		<th align="right">Quantity</th>
		<th align="right">Amount <font color='red'>*</font></th>
		<th align="right">VAT Class</th>
		<th align="right">Mgt Fee (<span style="color:red;">%</span>)</th>
		<th align="right">Mgt Fee VAT Class</th>
		<th align="right">Remarks</th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="paymenttermid"  class="selectbox" id="paymenttermid" onchange="getRent();" >
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
		<td><input size="4" type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="amount" id="amount" onchange="calculateTotal();" onblur="calculateTotal();" value="<?php echo $obj->amount; ?>"></td>
		<td><select name="vatclasseid" id="vatclasseid" class="selectbox" >
				<option value="">Select...</option>
				<?php
				$vatclasses=new Vatclasses();
				$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($vatclasses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->vatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
		</td>
		<td><input type="text" name="mgtfee" id="mgtfee" size="4" value="<?php echo $obj->mgtfee; ?>"></td>
		<td><select name="mgtfeevatclasseid" id="mgtfeevatclasseid" class="selectbox" >
				<option value="">Select...</option>
				<?php
				$vatclasses=new Vatclasses();
				$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($vatclasses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->mgtfeevatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
		</td>
		<td><textarea id="remarks" name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" class="btn" name="action2" value="Add"/></td>
	</tr>
	</table>
	
		<table align='center'>
			<tr>
			<td>
		Invoice No:<input type="text" name="documentno" id="documentno" readonly size="6"  value="<?php echo $obj->documentno; ?>">
		Invoiced On:<input type="text" name="invoicedon" id="invoicedon" class="date_input" size="14" readonly  value="<?php echo $obj->invoicedon; ?>">
		Month:<select name="month" id="month" class="selectbox">
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
      </select>
		Year:<select name="year" id="year" class="selectbox">
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
        </select>
			</td>
			</tr>
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Payment Term  </th>
		<th align="left">Quantity  </th>
		<th align="right">Amount  </th>		
		<th align="left">VAT Class  </th>
		<th align="left">VAT Amount  </th>
		<th align="left">Mgt Fee Perc  </th>
		<th align="left">Mgt Fee Amount  </th>
		<th align="left">Mgt Fee VAT Class  </th>
		<th align="left">Mgt Fee VAT Amount  </th>
		<th align="left">Remarks  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$ob = str_replace('&','',serialize($obj));
	if($_SESSION['shppayables']){
		$shppayables=$_SESSION['shppayables'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shppayables[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shppayables[$i]['paymenttermname']; ?> </td>
			<td><?php echo $shppayables[$i]['quantity']; ?> </td>
			<td><?php echo $shppayables[$i]['amount']; ?> </td>
			<td><?php echo $shppayables[$i]['vatclasseid']; ?> </td>
			<td><?php echo $shppayables[$i]['vatamount']; ?> </td>
			<td><?php echo $shppayables[$i]['mgtfee']; ?> </td>
			<td><?php echo $shppayables[$i]['mgtfeeamount']; ?> </td>
			<td><?php echo $shppayables[$i]['mgtfeevatclasseid']; ?> </td>
			<td><?php echo $shppayables[$i]['mgtfeevatamount']; ?> </td>
			<td><?php echo $shppayables[$i]['remarks']; ?> </td>
			<td><?php echo $shppayables[$i]['total']; ?> </td>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>&obj=<?php  echo $ob; ?>'><img src="../edit.png" alt="edit" title="edit" /></a></td>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>&obj=<?php  echo $ob; ?>'>Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" style="margin-left:500px;">
	<tr>
		<td align="center">Total:</td><td><input type="text" readonly value="<?php echo $total; ?>"/></td>	</tr>
		
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" class="btn" name="action" id="action" value="Print" onclick="Clickheretoprint();"></td>
        </tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 

if($saved=="Yes")
{
	?>
    <script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
    <?
    //$obj="";
	//$_SESSION['crshop']="";
    redirect("addpayables_proc.php");
  }
  
if(!empty($error)){
	showError($error);
}
?>