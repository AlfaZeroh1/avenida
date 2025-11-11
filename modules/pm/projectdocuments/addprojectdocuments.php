<title>WiseDigits ERP: Projectdocuments </title>
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
<form  id="theform" action="addprojectdocuments_proc.php" name="projectdocuments" method="POST" enctype="multipart/form-data">
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
		<td align="right">Project : </td>
			<td><select name="projectid" class="selectbox">
<option value="">Select...</option>
<?php
	$projects=new Projects();
	$where="  ";
	$fields="pm_projects.id, pm_projects.customerid, pm_projects.name, pm_projects.description, pm_projects.startdate, pm_projects.expectedcompletion, pm_projects.actualcompletion, pm_projects.remarks, pm_projects.ipaddress, pm_projects.createdby, pm_projects.createdon, pm_projects.lasteditedby, pm_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projects->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Document Type : </td>
			<td><select name="documenttypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$documenttypes=new Documenttypes();
	$where="  ";
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($documenttypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->documenttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Browse File : </td>
		<td><input type="text" name="file" id="file" value="<?php echo $obj->file; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Uploaded : </td>
		<td><input type="text" name="uploadedon" id="uploadedon" class="date_input" size="12" readonly  value="<?php echo $obj->uploadedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td><select name='type' class="selectbox">
			<option value='in' <?php if($obj->type=='in'){echo"selected";}?>>in</option>
			<option value='out' <?php if($obj->type=='out'){echo"selected";}?>>out</option>
		</select></td>
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