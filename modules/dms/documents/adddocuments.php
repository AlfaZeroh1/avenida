<title>WiseDigits: Documents </title>
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
<form class="forms" id="theform" action="adddocuments_proc.php" name="documents" method="POST" enctype="multipart/form-data">
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
		<td align="right">Route : </td>
			<td><select name="routeid">
<option value="">Select...</option>
<?php
	$routes=new Routes();
	$where="  ";
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($routes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->routeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Document No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Document Type : </td>
			<td><select name="documenttypeid">
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
		<td align="right">DMS Department : </td>
		<td><input type="text" name="departmentid" id="departmentid" value="<?php echo $obj->departmentid; ?>"></td>
	</tr>
	<tr>
		<td align="right">DMS Dept Category : </td>
		<td><input type="text" name="departmentcategoryid" id="departmentcategoryid" value="<?php echo $obj->departmentcategoryid; ?>"></td>
	</tr>
	<tr>
		<td align="right">DMS Category : </td>
		<td><input type="text" name="categoryid" id="categoryid" value="<?php echo $obj->categoryid; ?>"></td>
	</tr>
	<tr>
		<td align="right">HRM Department : </td>
		<td><input type="text" name="hrmdepartmentid" id="hrmdepartmentid" value="<?php echo $obj->hrmdepartmentid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Upload Document : </td>
		<td><input type="text" name="document" id="document" value="<?php echo $obj->document; ?>"></td>
	</tr>
	<tr>
		<td align="right">Document Link : </td>
		<td><textarea name="link"><?php echo $obj->link; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status'>
			<option value='Pending' <?php if($obj->status=='Pending'){echo"selected";}?>>Pending</option>
			<option value='In Process' <?php if($obj->status=='In Process'){echo"selected";}?>>In Process</option>
			<option value='Rejected' <?php if($obj->status=='Rejected'){echo"selected";}?>>Rejected</option>
			<option value='Approved' <?php if($obj->status=='Approved'){echo"selected";}?>>Approved</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea></td>
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