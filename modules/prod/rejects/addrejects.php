<title>WiseDigits ERP: rejects </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
 var tbl;
 var iterator=0;
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

$(document).ready(function () {
 $('#barcode').on('change',function(){ 
            //document.getElementById("barcode").value=str;
            
            if(document.getElementById("rejecttypeid").value==""){
	      alert("Select Reject Type First");
            }
            else{
	      var str=$(this).val();
	      var st = str.split("-");
	      
	      if(st.length<2){
		alert("Scan the bar code first");
		$("#barcode").val("");
		$("#barcode").focus();
	      }else{	    
		
		  document.getElementById("employeeid").value=st[0];
		  getEmployee(st[0]);
// 		  document.getElementById("employeename").value=getEmployee(st[0]);
		  document.getElementById("varietyid").value=st[2];
		  document.getElementById("greenhouseid").value=st[1];
		  document.getElementById("sizeid").value=st[3];
		  document.getElementById("quantity").value=st[4];
		  //document.getElementById("harvestedon").value=st[5]+"-"+st[6]+"-"+st[7];
		
		//document.getElementById("barcode2").focus();
	      }
	    }
    });
});

function getEmployee(id){
  //document.getElementById("quantity"+id).disable=false;
  
  
  if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {//alert(xmlhttp.responseText);
    document.getElementById("employeename").value=xmlhttp.responseText;
    }
  }
  <?php $rules= new Rules (); ?>
  var url="../../post/graded/get.php?id="+id;//alert(url);
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
  
}
 
function placeCursorOnPageLoad()
{
	document.getElementById("barcode").focus();
		
}

function checkForm(form,event){
    try{
    var target = event.explicitOriginalTarget || event.relatedTarget ||
        document.activeElement || {};

    if(target.type=="text"){
    
      if(document.getElementById("barcode").value!="" ){
	//return true;
	$.post( "addrejects_proc.php", { action2: "Add",rejecttypeid:$("#rejecttypeid").val(),varietyid:$("#varietyid").val(),greenhouseid:$("#greenhouseid").val(),plantingdetailid:$("#plantingdetailid").val(), sizeid:$("#sizeid").val(), quantity:$("#quantity").val(), harvestedon:$("#harvestedon").val(), iterator:$("#iterator").val() } );

  
	tbl.fnAddData( [
		iterator+1,
		$("#varietyid option:selected").text(),
		$("#sizeid option:selected").text(),
		$("#greenhouseid option:selected").text(),
		$("#quantity").val(),		
		$("#employeename").val(),	
		$("#rejecttypeid option:selected").text(),
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

womAdd('placeCursorOnPageLoad()');
womOn();
</script>
<script type="text/javascript" charset="utf-8">
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
//getsaleid("<?php echo $obj->customerid; ?>");
</script>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	tbl = $('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		
		"sScrollY": 200,
		"bJQueryUI": true,
		"iDisplayLength":2000,
		"sPaginationType": "full_numbers",
		"aLengthMenu": [10, 25, 50, 100,200,500,1000,2000]
	} );
 } );
 </script>

<div class='content'>
<form  id="theform" action="addrejects_proc.php" name="rejects" method="POST" enctype="multipart/form-data" onSubmit="return checkForm(this,event);">
	<table width="100%" class="tvarietys gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<input type="hidden" name="reduce" id="reduce" value="<?php echo $obj->reduce; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Product BarCode : </td>
		<td><input type="text" name="barcode" id="barcode" value="<?php echo $obj->barcode; ?>"></td>
	</tr>
	
	
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='Local Market' <?php if($obj->status=='Local Market'){echo"selected";}?>>Local Market</option>
			<option value='Discarded' <?php if($obj->status=='Discarded'){echo"selected";}?>>Discarded</option>
		</select></td>
	</tr>
	
	
	<tr>
		<td align="right">Date Harvested : </td>
		<td><input type="text" name="harvestedon" id="harvestedon" class="date_input" size="12" readonly  value="<?php echo $obj->harvestedon; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Date Reported : </td>
		<td><input type="text" name="reportedon" id="reportedon" class="date_input" size="12" readonly  value="<?php echo $obj->reportedon; ?>"></td>
	</tr>
</table>
	<table width="100%" class="tvarietys gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left">Reject Type</th>
		<th align="left">Variety  </th>
		<th align="left">Green House  </th>
		<th align="left">Size  </th>
		<th align="left">Quantity  </th>
		<th align="left">Employee  </th>
		<th>Remarks</th>
		<th>&nbsp;</th>
		</tr>
	<tr>
		
			<td><select name="rejecttypeid" id="rejecttypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$rejecttypes=new Rejecttypes();
	$where="  ";
	$fields="prod_rejecttypes.id, prod_rejecttypes.name, prod_rejecttypes.remarks, prod_rejecttypes.ipaddress, prod_rejecttypes.createdby, prod_rejecttypes.createdon, prod_rejecttypes.lasteditedby, prod_rejecttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($rejecttypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->rejecttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
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
			<td><select name="sizeid" id="sizeid" class="selectbox">
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
		</td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
		
			<td><input type='text' size='40' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
			
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
		
		<td ><input type="submit" name="action2" id="action2" value="Add"/></td>
	</tr>
	</table>
	
	<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Size  </th>
		<th align="left">Variety </th>
		<th align="left">Green House </th>
		<th align="left">Quantity  </th>
		<th align="left">Employee  </th>
		<th align="left">Reject Type</th>
		<th><input type="text" name="iterator" id="iterator" value="<?php echo $obj->iterator; ?>"/>Remarks</th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shprejects']){
		$shprejects=$_SESSION['shprejects'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shprejects[$i]['sizename']; ?> </td>
			<td><?php echo $shprejects[$i]['varietyname']; ?> </td>
			<td><?php echo $shprejects[$i]['greenhouseid']; ?> </td>
			<td><?php echo $shprejects[$i]['quantity']; ?> </td>
			<td><?php echo $shprejects[$i]['employeename']; ?> </td>
			<td><?php echo $shprejects[$i]['rejecttypename']; ?> </td>
			<td><?php echo $shprejects[$i]['remarks']; ?> </td>
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
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="button"  value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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
	redirect("addrejects_proc.php?retrieve=&status=".$obj->status);
}

?>