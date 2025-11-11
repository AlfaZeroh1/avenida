<title>WiseDigits ERP: Payables </title>
<?php 
$pop=1;
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
 
 function setAmount(id)
{	try{
	var xmlhttp;
	var url="populate.php?id="+id;
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
		document.getElementById("amount").value=xmlhttp.responseText;
	}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);}catch(e){alert(e);}
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

<div class='main'>
<form class="forms" id="theform" action="addpayables_proc.php" name="payables" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	
	<tr style="visibility:hidden;">
		<td align="right">Receipt No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Patient : </td>
			<td><input type="hidden" name="patientid" value="<?php echo $obj->patientid; ?>"/>
<?php
	$patients=new Patients();
	$where=" where id='$obj->patientid'  ";
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.patientclasseid, hos_patients.bloodgroup, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon, hos_patients.civilstatusid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$patients = $patients->fetchObject;
	echo initialCap($patients->surname." ".$patients->othernames);
	?>
		</td>
	</tr>
	<tr>
		<td align="right">Bill Term : </td>
			<td><select name="transactionid" class="selectbox" onchange="setAmount(this.value);">
<option value="">Select...</option>
<?php
	$transactions=new Transactions();
	$where=" where moduleid=8 ";
	$fields="sys_transactions.id, sys_transactions.name, sys_transactions.moduleid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($transactions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->transactionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Treatment No : </td>
		<td><input type="text" name="treatmentno" id="treatmentno" value="<?php echo $obj->treatmentno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Department : </td>
		<td><input type="text" name="departmentid" id="departmentid" value="<?php echo $obj->departmentid; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Date Invoiced : </td>
		<td><input type="text" name="invoicedon" id="invoicedon" class="date_input" size="12" readonly  value="<?php echo $obj->invoicedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">: </td>
		<td><input type="hidden" name="consult" id="consult" value="<?php echo $obj->consult; ?>"></td>
	</tr>
	<tr>
		<td align="right"> </td>
		<td><input type="hidden" name='paid' value="<?php echo $obj->paid; ?>"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
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
?>