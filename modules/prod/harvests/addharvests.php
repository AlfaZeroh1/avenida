<title>WiseDigits ERP: Harvests </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
	}
  });

});
</script>
 <script type="text/javascript" charset="utf-8">
 var tbl;
 var iterator=0;
 $(document).ready(function() {
 	tbl = $('#tbl').dataTable(); 	
 } );
 
 
  function placeCursorOnPageLoad()
{
	document.getElementById("barcode").focus();
		
}

$(document).ready(function () {
 $('#barcode').on('change',function(){ 
            //document.getElementById("barcode").value=str;
            
            var str=$(this).val();
	    var st = str.split("-");
	    
	    if(st.length<2){
	      alert("Scan the bar code first");
	      $("#barcode").val("");
	      $("#barcode").focus();
	    }else{	    
	      
	        document.getElementById("plantingdetailid").value=1;
		document.getElementById("employeeid").value=st[0];
		document.getElementById("employeename").value=st[0];
		document.getElementById("varietyid").value=st[2];
		document.getElementById("greenhouseid").value=st[1];
		document.getElementById("plantingdetailid").value=1;
// 		document.getElementById("sizeid").value=st[3];
		document.getElementById("quantity").value=st[4];
		//document.getElementById("harvestedon").value=st[5]+"-"+st[6]+"-"+st[7];
	      
	      //document.getElementById("barcode2").focus();
	    }
    });
 });
 
 

 function readBarcode(str){try{
  
  //str = str.substring(0,(str.length-1));
  document.getElementById("barcode").value=str;
  var st = str.split("-");
  
    document.getElementById("plantingdetailid").value=1;
  
  document.getElementById("employeeid").value=st[0];
  document.getElementById("employeename").value=st[0];
  document.getElementById("varietyid").value=st[2];
  document.getElementById("greenhouseid").value=st[1];
  document.getElementById("plantingdetailid").value=1;
//   document.getElementById("sizeid").value=st[3];
  document.getElementById("quantity").value=st[4];
  //document.getElementById("harvestedon").value=st[5]+"-"+st[6]+"-"+st[7];
  

  
 }catch(e){alert(e);}}

 function checkForm(form,event){
    try{
    var target = event.explicitOriginalTarget || event.relatedTarget ||
        document.activeElement || {};

    if(target.type=="text"){
    
      if(document.getElementById("barcode").value!="" ){
	//return true;
	$.post( "addharvests_proc.php", { action2: "Add",varietyid:$("#varietyid").val(),greenhouseid:$("#greenhouseid").val(),plantingdetailid:$("#plantingdetailid").val(), /*sizeid:$("#sizeid").val(), */quantity:$("#quantity").val(), harvestedon:$("#harvestedon").val(), iterator:$("#iterator").val() } );

  
	tbl.fnAddData( [
		iterator+1,
		$("#varietyid option:selected").text(),
		//$("#sizeid option:selected").text(),
		$("#plantingdetailid option:selected").text(),
		$("#greenhouseid option:selected").text(),
		$("#quantity").val(),		
		"",
		"" ] );
	
	iterator++;
	
	$("#barcode").val("");
	$("#barcode").focus();
	$("#iterator").val(iterator);
	return false;
      }
      else{
	return false;
      }
     }}catch(e){alert(e);}
 }
 
  function getGreenhouse(varietyid)
 { 
 try{
	var xmlhttp;
	var url="getgreenhouse.php?varietyid="+varietyid;//alert(url);
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
		         //alert(xmlhttp.responseText);
			document.getElementById("greenhouseid").innerHTML=xmlhttp.responseText;
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	}catch(e){alert(e);}
}
  
// womAdd('placeCursorOnPageLoad()');
//  function readBarcode(str){try{
//   var st = str.split("-");
//   st[7] = st[7].substring(0,2);

//  }catch(e){alert(e);}}
//  
womAdd('placeCursorOnPageLoad()');
womOn();
 </script>

<hr>
<div class="content">
<form  id="theform" action="addharvests_proc.php" name="harvests" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this, event);">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn btn-info" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Date Harvested:</label></td>
<td><input type="text" name="harvestedon" id="harvestedon" class="date_input" size="12" readonly  value="<?php echo $obj->harvestedon; ?>">			</td>
			</tr>
			<tr>
			<td>
		<label>Remarks:</label>			</td>
			<td>
<textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea>			</td>
			</tr>
			</td>
			</tr>
				<td><label>Employee:</label></td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
					<input type="hidden" name='status' id='status' value='<?php echo $obj->status; ?>'></td>
			</td>
			</tr>
			<tr>
			<td>Barcode:
			</td>
			<td>
			  <input type="text" name="barcode" id="barcode"/>
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Variety  </th>
		<th align="right">Green House  </th>
		<th align="right"><!--Sizes --> &nbsp;</th>
		<th align="right">Planting Detail  </th>
		<th align="right">Quantity  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		
			<td><select name="varietyid" id="varietyid" class="selectbox" onchange="getGreenhouse(this.value);">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.stems, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($varietys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
		
			
		
			<td>
			<select name="greenhouseid" class="selectbox"  id="greenhouseid" >
<option value="">Select...</option>
<?php if(!empty($obj->varietyid)){
        $greenhouses=new Greenhouses();
	$where=" where id in(select greenhouseid from  prod_greenhousevarietys where varietyid='$obj->varietyid') ";
	$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

        while($rw=mysql_fetch_object($greenhouses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->greenhouseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	}
	?>
</select>
</td>
<font color='red'>*</font>		<td><!--<select name="sizeid" id="sizeid"  class="selectbox">
<option value="">Select...</option>
<?php
	$sizes=new Sizes();
	$where="  ";
	$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($sizes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		--><input type="hidden" name='sizeid' id='sizeid' value='NULL'></td>
<font color='red'>*</font>		<td><select name="plantingdetailid" id="plantingdetailid" class="selectbox">
<option value="">Select...</option>
<?php
	$plantingdetails=new Plantingdetails();
	$where="  ";
	$fields="prod_plantingdetails.id, prod_plantingdetails.plantingid, prod_plantingdetails.varietyid, prod_plantingdetails.greenhouseid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($plantingdetails->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->plantingdetailid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" size="20" value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Variety  </th>
		<th align="left">Green House  </th>
		<th align="left">Sizes  </th>
		<th align="left">Planting Detail  </th>
		
		<th align="left">Quantity  </th>
		<th><input type="hidden" name="iterator" id="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpharvests']){
		$shpharvests=$_SESSION['shpharvests'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpharvests[$i]['varietyname']; ?> </td>
			<td><?php echo $shpharvests[$i]['greenhousename']; ?> </td>
			<td><?php echo $shpharvests[$i]['sizename']; ?> </td>
			<td><?php echo $shpharvests[$i]['plantingdetailname']; ?> </td>
			
			<td><?php echo $shpharvests[$i]['quantity']; ?> </td>
			<td><?php echo $shpharvests[$i]['total']; ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" width="100%">
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
</hr>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
if($saved=="Yes"){
	redirect("addharvests_proc.php?retrieve=&status=".$obj->status);
}

?>