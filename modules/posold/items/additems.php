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
 
 function getPrice()
{
	var categoryid=document.getElementById("categoryid").value;
	
	var xmlhttp;
	var url="getprices.php?id="+categoryid;
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			document.getElementById("price").value=xmlhttp.responseText;
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
	$fields="pos_departments.id, pos_departments.name, pos_departments.remarks, pos_departments.ipaddress, pos_departments.createdby, pos_departments.createdon, pos_departments.lasteditedby, pos_departments.lasteditedon";
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
		<td align="right">Category : </td>
			<td><select name="categoryid" id="categoryid" class="selectbox" onchange="getPrice();">
<option value="">Select...</option>
<?php
	$categorys=new Categorys();
	$where="  ";
	$fields="pos_categorys.id, pos_categorys.name, pos_categorys.remarks, pos_categorys.ipaddress, pos_categorys.createdby, pos_categorys.createdon, pos_categorys.lasteditedby, pos_categorys.lasteditedon";
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
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
	  <td>Mixed Box</td>
	  <td><input type="radio" name="mixedbox" id="mixedbox" value="Yes" <?php if($obj->mixedbox=='Yes'){echo "checked";}?> />Yes<br/>
      <input type="radio" name="mixedbox" id="mixedbox" value="No" <?php if($obj->mixedbox=='No'){echo "checked";}?> />No</td>
	</tr>
	<tr>
		<td align="right">Price : </td>
		<td><input type="text" name="price" id="price" size="8"  value="<?php echo $obj->price; ?>"></td>
	</tr>
	<tr>
		<td align="right">Tax : </td>
		<td><input type="text" name="tax" id="tax" size="8"  value="<?php echo $obj->tax; ?>"></td>
	</tr>
	<tr>
		<td align="right">Stock : </td>
		<td><input type="text" name="stock" id="stock" size="8"  value="<?php echo $obj->stock; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
			<td><select name="itemstatusid" class="selectbox">
<option value="">Select...</option>
<?php
	$itemstatuss=new Itemstatuss();
	$where="  ";
	$fields="pos_itemstatuss.id, pos_itemstatuss.name, pos_itemstatuss.ipaddress, pos_itemstatuss.createdby, pos_itemstatuss.createdon, pos_itemstatuss.lasteditedby, pos_itemstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($itemstatuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->itemstatusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td><input type="type" name="type" id="type" size="8"  value="<?php echo $obj->type; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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