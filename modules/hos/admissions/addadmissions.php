<title>WiseDigits: Admissions </title>
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
 
//  added
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
 
 
function getBed(wardid)
{
	//var id=document.getElementById("plotid").value;
	//var houseid=document.getElementById("houseid").value;
	var xmlhttp;
	var url="../beds/populate.php?wardid="+wardid;//alert(url);
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
			document.getElementById("bedid").innerHTML=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

 </script>
 
 

<div class='main'>
	
<form class="forms" id="theform" action="addadmissions_proc.php" name="admissions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr align="center">
            <td colspan="2" align="center" >Current Patient: 
           
            
            <?php 
            $patients = new Patients();
            $fields="hos_patients.*";
            $join=" left join hos_patienttreatments on hos_patients.id=hos_patienttreatments.patientid ";
            $where=" where hos_patienttreatments.id='$obj->treatmentid' ";
            $having="";
            $groupby="";
            $orderby="";
            $patients->retrieve($fields, $join, $where, $having, $groupby, $orderby);
            $patients=$patients->fetchObject;
            ?>
            		<font color="red"><strong><?php echo initialCap($patients->surname); ?>&nbsp;<?php echo initialCap($patients->othernames); ?></strong></font>
            </td>
        </tr>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<input type="hidden" name="status" id="status" value="<?php echo $obj->status; ?>"></td>
	</tr>
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox">
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
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Ward : </td>
			<td><select name="wardid" class="selectbox" onchange="getBed(this.value);">
<option value="">Select...</option>
<?php
	$wards=new Wards();
	$where="  ";
	$fields="hos_wards.id, hos_wards.name, hos_wards.departmentid, hos_wards.remarks, hos_wards.firstroom, hos_wards.lastroom, hos_wards.roomprefix, hos_wards.status, hos_wards.createdby, hos_wards.createdon, hos_wards.lasteditedby, hos_wards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$wards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($wards->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->wardid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>


	<tr>
		<td align="right">Bed : </td>
			<td>
			
			<select name="bedid" id="bedid" class="selectbox">
<option value="">Select...</option>
</select><font color='red'>*</font>

<input type="hidden" name="treatmentid" value="<?php echo $obj->treatmentid; ?>"/>
				<input type="hidden" name="patientid" value="<?php echo $obj->patientid; ?>"/>
		</td>
	</tr>
	
	<tr>
		<td align="right">Date : </td>
		<td><input type="text" name="admissiondate" id="admissiondate" class="date_input" size="12" readonly  value="<?php echo $obj->admissiondate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
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
if(!empty($error)){
	showError($error);
}
?>