<title>WiseDigits: Patientotherservices </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#patientname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patients&field=concat(patientno,' ',concat(surname,' ',othernames))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientid").val(ui.item.id);
		$("#patientno").val(ui.item.patientno);
		$("#address").val(ui.item.address);
	}
  });

 
});

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
getOtherservices("<?php echo $obj->departmentid; ?>");
 function getOtherservices(id){
  var xmlhttp;	
	var url="get.php?departmentid="+id;
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
			document.getElementById("otherserviceid").innerHTML=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
 }
 
 function getOtherservicesamount(id){
  var xmlhttp;	
	var url="getamount.php?serviceid="+id;
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
			document.getElementById("charge").value=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
 }
</script>
<form action="addpatientotherservicess_proc.php" name="patientotherservices" method="POST" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="hidden" name="patienttreatmentid" id="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Service No: </td>
		<td><input type="text" name="documentno" size="4" readonly="readonly" id="documentno" value="<?php echo $obj->documentno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Patient: </td>
<td><input type="text" name="patientname" id="patientname" size='42' value="<?php echo $obj->patientname; ?>"/>
	<input type="hidden" name="patientid" id="patientid" value="<?php echo $obj->patientid; ?>"/><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">PatientNo: </td>
		<td><input type="text" name="patientno" id="patientno" value="<?php echo $obj->patientno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Address: </td>
		<td><textarea name="address" id="address"><?php echo $obj->address; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox" onchange="getOtherservices(this.value)">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Service : </td>
			<td><select name="otherserviceid" id="otherserviceid" class="selectbox" onchange="getOtherservicesamount(this.value)">
<option value="">Select...</option>

</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Charge : </td>
		<td><input type="text" name="charge" id="charge" size="8"  value="<?php echo $obj->charge; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->id)){?> 
	<tr>
		<td colspan="2" align="center">
		</td>
	</tr>
<?php }?>
</table>

<table style="width: 80%; margin:5px 20px;" >
			<tr>
				<th>#</th>
				<th>Service</th>
				<th>Charge</th>
				<th>&nbsp;</th>
			</tr>
			<?php
			if(!empty($obj->documentno) and !empty($obj->patientid)){
				$patientotherservices=new Patientotherservices();
				$i=0;
				$fields="hos_patientotherservices.id, hos_patientotherservices.patienttreatmentid, hos_otherservices.name as otherserviceid, hos_patientotherservices.charge, hos_patientotherservices.remarks, hos_patientotherservices.createdby, hos_patientotherservices.createdon, hos_patientotherservices.lasteditedby, hos_patientotherservices.lasteditedon";
				$join=" left join hos_otherservices on hos_patientotherservices.otherserviceid=hos_otherservices.id ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where hos_patientotherservices.documentno='$obj->documentno' ";
				$patientotherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
				$res=$patientotherservices->result;
				while($row=mysql_fetch_object($res)){
				$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->otherserviceid; ?></td>
				<td><?php echo $row->charge; ?></td>
				<td><a href="addpatientlaboratorytestss.php?id=<?php echo $obj->patienttreatmentid; ?>&delid=<?php echo $row->id; ?>">Delete</a></td>
			</tr>
			<?php 
			}
			}
			?>
		</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>