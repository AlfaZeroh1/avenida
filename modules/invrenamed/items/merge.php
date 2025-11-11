<title>WiseDigits ERP: Items </title>
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
<form  id="theform" action="additems_proc.php" name="items" method="POST" enctype="multipart/form-data">
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
		<td align="right">Code : </td>
		<td><input type="text" name="code" id="code" value="<?php echo $obj->code; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="inv_departments.id, inv_departments.name, inv_departments.code, inv_departments.remarks, inv_departments.createdby, inv_departments.createdon, inv_departments.lasteditedby, inv_departments.lasteditedon, inv_departments.ipaddress";
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
		<td align="right">Dept Category : </td>
			<td><select name="departmentcategoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$departmentcategorys=new Departmentcategorys();
	$where="  ";
	$fields="inv_departmentcategorys.id, inv_departmentcategorys.departmentid, inv_departmentcategorys.name, inv_departmentcategorys.remarks, inv_departmentcategorys.createdby, inv_departmentcategorys.createdon, inv_departmentcategorys.lasteditedby, inv_departmentcategorys.lasteditedon, inv_departmentcategorys.ipaddress";
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
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Categoryid : </td>
			<td><select name="categoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$categorys=new Categorys();
	$where="  ";
	$fields="inv_categorys.id, inv_categorys.name, inv_categorys.remarks, inv_categorys.createdby, inv_categorys.createdon, inv_categorys.lasteditedby, inv_categorys.lasteditedon, inv_categorys.ipaddress";
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
		<td align="right">Manufacturer : </td>
		<td><input type="text" name="manufacturer" id="manufacturer" size="45"  value="<?php echo $obj->manufacturer; ?>"></td>
	</tr>
	<tr>
		<td align="right">Strength : </td>
		<td><input type="text" name="strength" id="strength" value="<?php echo $obj->strength; ?>"></td>
	</tr>
	<tr>
		<td align="right">Cost Price : </td>
		<td><input type="text" name="costprice" id="costprice" size="8"  value="<?php echo $obj->costprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Trade Price : </td>
		<td><input type="text" name="tradeprice" id="tradeprice" size="8"  value="<?php echo $obj->tradeprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Retail Price : </td>
		<td><input type="text" name="retailprice" id="retailprice" size="8"  value="<?php echo $obj->retailprice; ?>"></td>
	</tr>
	<tr>
		<td align="right">Size : </td>
		<td><input type="text" name="size" id="size" size="8"  value="<?php echo $obj->size; ?>"></td>
	</tr>
	<tr>
		<td align="right">Unit Of Measure : </td>
			<td><select name="unitofmeasureid" class="selectbox">
<option value="">Select...</option>
<?php
	$unitofmeasures=new Unitofmeasures();
	$where="  ";
	$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($unitofmeasures->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->unitofmeasureid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">VAT Class : </td>
			<td><select name="vatclasseid" class="selectbox">
<option value="">Select...</option>
<?php
	$vatclasses=new Vatclasses();
	$where="  ";
	$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($vatclasses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->vatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<!--<tr>
		<td align="right">Journal Acc On Sale : </td>
			<td><select name="generaljournalaccountid" class="selectbox">
<option value="">Select...</option>
<?php
	$generaljournalaccounts=new Generaljournalaccounts();
	$where=" where fn_generaljournalaccounts.acctypeid=25 ";
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($generaljournalaccounts->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->generaljournalaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Cost Of Sale Journal Acc : </td>
			<td><select name="generaljournalaccountid2" class="selectbox">
<option value="">Select...</option>
<?php
	$generaljournalaccounts2=new Generaljournalaccounts();
	$where=" where fn_generaljournalaccounts.acctypeid=26 ";
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts2->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($generaljournalaccounts2->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->generaljournalaccountid2==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>-->
	<tr>
		<td align="right">Discount : </td>
		<td><input type="text" name="discount" id="discount" size="8"  value="<?php echo $obj->discount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Reorder Level : </td>
		<td><input type="text" name="reorderlevel" id="reorderlevel" size="8"  value="<?php echo $obj->reorderlevel; ?>"></td>
	</tr>
	<tr>
		<td align="right">Reorder Quantity : </td>
		<td><input type="text" name="reorderquantity" id="reorderquantity" size="8"  value="<?php echo $obj->reorderquantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Reducing Stock : </td>
		<td><select name='reducing' class="selectbox">
			<option value='Yes' <?php if($obj->reducing=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->reducing=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='Not Active' <?php if($obj->status=='Not Active'){echo"selected";}?>>Not Active</option>
		</select></td>
	</tr>
	<?php
//Authorization.
$auth->roleid="705";//View
$auth->levelid=$_SESSION['level'];

$auth1->roleid="704";//View
$auth1->levelid=$_SESSION['level'];

if(existsRule($auth) or existsRule($auth1)){
?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php
}
?>
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