<title>WiseDigits ERP: Categorys </title>
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
 
function loadP(str)
{
	var expensecategorydiv = document.getElementById("expensecategorydiv");
	
	if(str==null || str==26)
	{
		//do nothing
		expensecategorydiv.style.display="none";
		text.innerHTML="show";
	}
	else if(str==4)
	{
		expensecategorydiv.style.display="block";
		text.innerHTML="show";
	}
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
function getExpenseCategorys(id, exp)
{
	//var id=document.getElementById("plotid").value;
	//var houseid=document.getElementById("houseid").value;
	var xmlhttp;
	var url="getExpenseCategorys.php?id="+id+"&expensecategoryid="+exp;
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
			document.getElementById("expensecategoryid").innerHTML=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

womAdd("getExpenseCategorys('<?php echo $obj->acctypeid; ?>','<?php echo $obj->expensecategoryid; ?>');");
// womAdd("loadP('<?php echo $obj->acctypeid; ?>')");
womOn();
 </script>

<div class='main'>
<form  id="theform" action="addcategorys_proc.php" name="categorys" method="POST" enctype="multipart/form-data">
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
		<td align="right">Category : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Account Type : </td>
		<td><div style="float:left;">
		  <select name="acctypeid" class="selectbox" onChange="getExpenseCategorys(this.value,'');">
		    <option value="">Select...</option>
		    <?php
		    $acctypes = new Acctypes();
		    $fields="*";
		    $where=" where id in(4,26) ";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    while($row=mysql_fetch_object($acctypes->result)){
		      ?>
			<option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->acctypeid){echo "selected";} ?>><?php echo $row->name; ?></option>
		      <?php
		    }
		    ?>
		  </select>&nbsp;
		 </div>
		 <div style="float:left" id="expensecategorydiv">
		 <select name="expensecategoryid" id="expensecategoryid" class="selectbox">
		    <option value="">Select...</option>
		    
		  </select>&nbsp;
		  <input type="hidden" name="refid" id="refid" value="<?php echo $obj->refid; ?>"/>
		 </div>
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