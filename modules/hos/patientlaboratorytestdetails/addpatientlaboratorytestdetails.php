<title>WiseDigits ERP: Patientlaboratorytestdetails </title>
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
 </script>

<div class='main'>
<form class="forms" id="theform" action="addpatientlaboratorytestdetails_proc.php" name="patientlaboratorytestdetails" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Patient Lab Test : </td>
			<td><select name="patientlaboratorytestid" class="selectbox">
<option value="">Select...</option>
<?php
	$patientlaboratorytests=new Patientlaboratorytests();
	$where="  ";
	$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, hos_patientlaboratorytests.patientid, hos_patientlaboratorytests.patienttreatmentid, hos_patientlaboratorytests.laboratorytestid, hos_patientlaboratorytests.charge, hos_patientlaboratorytests.results, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($patientlaboratorytests->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->patientlaboratorytestid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Laboratory Test Detail : </td>
			<td><select name="laboratorytestdetailid" class="selectbox">
<option value="">Select...</option>
<?php
	$laboratorytestdetails=new Laboratorytestdetails();
	$where="  ";
	$fields="hos_laboratorytestdetails.id, hos_laboratorytestdetails.laboratorytestid, hos_laboratorytestdetails.detail, hos_laboratorytestdetails.remarks, hos_laboratorytestdetails.ipaddress, hos_laboratorytestdetails.createdby, hos_laboratorytestdetails.createdon, hos_laboratorytestdetails.lasteditedby, hos_laboratorytestdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$laboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($laboratorytestdetails->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->laboratorytestdetailid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Result : </td>
		<td><textarea name="result"><?php echo $obj->result; ?></textarea></td>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>