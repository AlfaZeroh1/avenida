<title>WiseDigits: Vacanthousereports </title>
<?php 
include "../../../head.php";

?>
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
$().ready(function() {

/****** mike additions ******/

  $("#plotname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=plots&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#plotid").val(ui.item.id);
	}
  });


/****** additions End ******/
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

  $("#paymenttermname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=paymentterms&field=concat(code,' ',name)",
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
/*** changed ***/
function selectHouses()
{
	
	var id=document.getElementById("plotid").value;
	var houseid=document.getElementById("houseid").value;
	var xmlhttp;
	var url="../houses/populate.php?id="+id+"&houseid="+houseid;
	xmlhttp=GetXmlHttpObject();
	
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }  
/*** changed ***/
xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4)
	{
		document.getElementById("houseid").innerHTML=xmlhttp.responseText;
	}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function selectTenantHouses()
{
	
	var id=document.getElementById("tenantid").value;
	var xmlhttp;
	var url="../houses/populate.php?tenantid="+id;
	xmlhttp=GetXmlHttpObject();
	
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
/*** changed ***/
xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4)
	{
		document.getElementById("houseid").innerHTML=xmlhttp.responseText;
	}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
	
function getTenant(houseid)
{
	var xmlhttp;
	var url="../tenants/populate.php?id="+houseid;
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
		var dt = data.split("|");
		document.getElementById("tenantid").value=dt[0];
		document.getElementById("tenantname").value=dt[1];
		document.getElementById("registeredon").value=dt[2];
		document.getElementById("idno").value=dt[3];
		getBalances();
	}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function getBalances()
{
	var tenantid=document.getElementById("tenantid").value;
	var houseid=document.getElementById("houseid").value;
	if(!tenantid)
		tenantid=0;
	if(!houseid)
		houseid=0;
	
	var xmlhttp;
	var url="populatebalances.php?houseid="+houseid+"&tenantid="+tenantid;
	xmlhttp=GetXmlHttpObject();
	
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }  
xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4)
	{
		document.getElementById("balances").innerHTML=xmlhttp.responseText;
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

function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print Voucher?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("printpayment.php?doc=<?php echo $obj->documentno; ?>&tenant=<?php echo $obj->tenantid; ?>&paidon=<?php echo $obj->paidon; ?>&copy=<?php echo $obj->retrieve; ?>",450,940);
	}
}

womAdd('selectHouses()');
womOn();
</script>
<!--- addditions end --->
 
 

 
<div class='main'>
<form class="forms" id="theform" action="addvacanthousereports_proc.php" name="vacanthousereports" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
	<td align="right">Property:</td><td><input type="text" name="plotname" id="plotname" <?php if(!empty($obj->retrieve)){?>readonly="readonly"<?php }?> value='<?php echo $obj->plotname; ?>' size="30"/>
<input type="hidden" name='plotid' id='plotid' value='<?php echo $obj->plotid; ?>'>
</td>
	</tr>
	<tr>
		<td align="right">House No:</td><td><?php if(empty($obj->retrieve) ){?><select name="houseid" class="selectbox"  id="houseid" onclick="getTenant(this.value);">
		<option value="">Select...</option>
		<?php if(!empty($obj->plotid) or !empty($obj->tenantid)){
		$houses=new Houses();
		if(!empty($obj->plotid) and empty($obj->tenantid))
			$where=" where em_houses.plotid='$obj->plotid'  ";
		if(empty($obj->plotid) and !empty($obj->tenantid))
			$where=" where em_housetenants.tenantid='$obj->tenantid'";
		else
			$where=" where em_houses.plotid='$obj->plotid'  ";

		$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_plots.name plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
		if(!empty($obj->plotid) and empty($obj->tenantid))
			$join=" left join em_plots on em_houses.plotid=em_plots.id  ";
		if(empty($obj->plotid) and !empty($obj->tenantid))
			$join=" left join em_plots on em_houses.plotid=em_plots.id left join em_housetenants on em_housetenants.houseid=em_houses.id ";
		else
			$join=" left join em_plots on em_houses.plotid=em_plots.id  ";

		$having=" ";
		$groupby="";
		$orderby="";
		$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			while($rw=mysql_fetch_object($houses->result)){
			?>
				<option value="<?php echo $rw->id; ?>" <?php if($obj->houseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->plotid);?>=><?php echo initialCap($rw->hseno); ?></option>
			<?php
			}
		 }?>
		</select>
		<?php }else{?>
<input type="hidden" name="houseid" value="<?php echo $obj->houseid; ?>"/>
<input type="text" readonly="readonly" name="hseno" value="<?php echo $obj->hseno; ?>"/>
<?php }?>
	</tr>
	<tr><td align="right">Tenant:</td><td><input type="text" name="tenantname" id="tenantname" <?php if(!empty($obj->retrieve)){?>readonly="readonly"<?php }?> size="30" value="<?php echo $obj->tenantname;?>"/>
													<input type="hidden" name="tenantid" id="tenantid" value="<?php echo trim($obj->tenantid); ?>"></td></tr>
	<tr>
		<td align="right">Vacated On : </td>
		<td><input type="text" name="vacatedon" id="vacatedon" class="date_input" size="12" readonly  value="<?php echo $obj->vacatedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea>
		<input type="hidden" name='status'  value="<?php echo $obj->status; ?>"/></td>
	</tr>
	<?php if($obj->status!="pending"){?>
	<tr>
		<td align="right">Remark Upon Approval/Decline : </td>
		<td><textarea name="remarks2"><?php echo $obj->remarks2; ?></textarea></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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