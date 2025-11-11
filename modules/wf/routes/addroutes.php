<title>WiseDigits ERP: Routes </title>
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
function selectRoles(id,roleid)
{
	//var id=document.getElementById("plotid").value;
	//var houseid=document.getElementById("houseid").value;
	var xmlhttp;
	var url="populate.php?id="+id+"&roleid="+roleid;
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
			document.getElementById("roleid").innerHTML=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
selectRoles("<?php echo $obj->moduleid; ?>","<?php echo $obj->roleid; ?>");
 </script>

<div class='main'>
<form  id="theform" action="addroutes_proc.php" name="routes" method="POST" enctype="multipart/form-data">
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
		<td align="right">Work Flow Title : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Module Associated : </td>
			<td><select name="moduleid" class="selectbox" onchange="selectRoles(this.value,"");">
<option value="">Select...</option>
<?php
	$modules=new Modules();
	$where=" where id in(2,3,4,5,6,7,20,21,22,23,24,25) ";
	$fields="sys_modules.id, sys_modules.name, sys_modules.description";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($modules->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->moduleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->description);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">System Role Associated : </td>
			<td>
			<?php
			$roles=new Roles();
			$where=" where name like '%add%' and auth_roles.moduleid in(2,3,4,5,6,7,20,21,22,23,24,25) ";
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby=" order by name ";
			$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			?>
			<select name="roleid" id="roleid" class="selectbox">
<option value="">Select...</option>
<?php
    while($rw=mysql_fetch_object($roles->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->roleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->description);?></option>
	<?php
	}
	?>
</select>
		</td>
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