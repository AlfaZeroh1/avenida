<title>WiseDigits ERP: Documentss </title>
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
<form  id="theform" action="adddocumentss_proc.php" name="documentss" method="POST" enctype="multipart/form-data">
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
			<td><select name="routeid" class="selectbox">
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
		<td align="right">DMS Department : </td>
			<td><select name="departmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="dms_departments.id, dms_departments.name, dms_departments.remarks, dms_departments.ipaddress, dms_departments.createdby, dms_departments.createdon, dms_departments.lasteditedby, dms_departments.lasteditedon";
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
		<td align="right">DMS Dept Category : </td>
		<td><select name="departmentcategoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$departmentcategorys=new Departmentcategorys();
	$where="  ";
	$fields="dms_departmentcategorys.id, dms_departmentcategorys.name, dms_departmentcategorys.departmentid, dms_departmentcategorys.remarks, dms_departmentcategorys.ipaddress, dms_departmentcategorys.createdby, dms_departmentcategorys.createdon, dms_departmentcategorys.lasteditedby, dms_departmentcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departmentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departmentcategorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentcategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
	</tr>
	<tr>
		<td align="right">DMS Category : </td>
			<td><select name="categoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$categorys=new Categorys();
	$where="  ";
	$fields="dms_categorys.id, dms_categorys.name, dms_categorys.remarks, dms_categorys.ipaddress, dms_categorys.createdby, dms_categorys.createdon, dms_categorys.lasteditedby, dms_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($categorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">HRM Department : </td>
			<td><select name="hrmdepartmentid" class="selectbox">
<option value="">Select...</option>
<?php
	
	$departments->result=mysql_query("select * from hrm_departments");

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->hrmdepartmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Upload Document : </td>
		<td><input type="file" name="document" id="document" value="<?php echo $obj->document; ?>"></td>
	</tr>
	<tr>
		<td align="right">Document Link : </td>
		<td><textarea name="link"><?php echo $obj->link; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='Pending' <?php if($obj->status=='Pending'){echo"selected";}?>>Pending</option>
			<option value='In Process' <?php if($obj->status=='In Process'){echo"selected";}?>>In Process</option>
			<option value='Rejected' <?php if($obj->status=='Rejected'){echo"selected";}?>>Rejected</option>
			<option value='Approved' <?php if($obj->status=='Approved'){echo"selected";}?>>Approved</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Expiry Date : </td>
		<td><input type="text" name="expirydate" id="expirydate" class="date_input" size="12" readonly  value="<?php echo $obj->expirydate; ?>"></td>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>