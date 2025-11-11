<title>WiseDigits ERP: Harvestrejects </title>
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

// $(document).ready(function () {
//  $('#barcode').on('change',function(){ 
//             //document.getElementById("barcode").value=str;
//             
//             var str=$(this).val();
// 	    
// 	    var st = str.split("-");
// 	    
// 	    document.getElementById("itemid").value=parseInt(st[0]);
// 	    document.getElementById("sizeid").value=st[1];
// 	    document.getElementById("quantity").value=st[2];    
// 	      
// 	    $("#barcode").val("");
// 	    $("#barcode").focus();
// 	   
//     });
//     
// //     $("#barcode2").on("change",function(){
//     var str=$(this).val();
//     document.getElementById("rejecttypeid").value=parseInt(str);
//     
// });
// 
//  function checkForm(form,event){
//    
//     var target = event.explicitOriginalTarget || event.relatedTarget ||
//         document.activeElement || {};
// 
//     if(target.type=="text"){
// 	
// 	if(true){
// 	//return true;
// 	
// 	
// 	$.post( "addharvestrejects_proc.php", { action2: "Add", sizeid:$("#sizeid").val(), rejecttypeid:$("#rejecttypeid").val(), itemid:$("#itemid").val(), quantity:$("#quantity").val(), employeeid:$("#employeeid").val(), iterator:$("#iterator").val(), status:$("#status").val(), downsize:$("#downsize").val() } );
// 	
// 	tbl.fnAddData( [
// 		iterator+1,
// 		$("#sizeid option:selected").text(),
// 		$("#itemid option:selected").text(),
// 		$("#quantity").val(),
// 		$("#employeename").val(),
// 		$("#rejecttypeid option:selected").text(),
// 		"",
// 		"" ] );
// 	
// 	iterator++;
// 	$("#barcode").val("");
// // 	$("#barcode2").val("");
// 	$("#barcode").focus();
// 	$("#iterator").val(iterator);
//       
// 	return false;
//       }
//       else{
// 	return true;
//       }
//      }
//  }

$(document).ready(function () {
 $('#barcode').on('change',function(){ 
            
            var str=$(this).val();
	    var st = str.split("-");
	    var error="";
	    if(st.length<2){
	      alert("Scan the client bar code first");
	      $("#barcode").val("");
	      $("#barcode").focus();
	    }else{	     
	      $.get("../../post/barcodes/checkBarCodesss.php?type=<?php echo $obj->status; ?>",{barcode:str},function(data){
		error=data;
		
		var err = error.split("|");
		if(parseFloat(err[0])==1){
		  alert(err[1]);
		  $("#barcode").val("");
		  $("#barcode").focus();
		}else{
		  document.getElementById("itemid").value=parseInt(st[0]);
		  document.getElementById("sizeid").value=parseInt(st[1]);
		  document.getElementById("quantity").value=st[2];
		  $.get("getblock.php",{id:parseInt(st[3])},function(data){
		    document.getElementById("blockid").value=parseInt(data); 
		  });
		  
		  document.getElementById("barcode2").focus();
		}
		
	      });   
	      
	    }
    });
  });
  
$(document).ready(function(){ 
  $("#barcode2").on("change",function(){
    var str=$(this).val();
    
    var st = str.split("-");
    if(st.length>2){
      alert("Scan the employee bar code correctly");
      $("#barcode2").val("");
      $("#barcode2").focus();
    }
    else{
      $.get("get.php",{id:parseInt(st[0])},function(data){
	$("#employeename").val(data);  
      });
      document.getElementById("employeeid").value=parseInt(st[0]);
      $("#datecode").val(st[1]); 
    }
  })
})
 function readBarcode(str){try{
  
  //str = str.substring(0,(str.length-1));
  document.getElementById("barcode").value=str;
  var st = str.split("-");
  
  if(st[2]>100){
    alert("Please Check your client barcode");
  }
  else{
    document.getElementById("itemid").value=parseInt(st[0]);
    document.getElementById("sizeid").value=parseInt(st[1]);
    document.getElementById("quantity").value=st[2];
    
    document.getElementById("barcode2").focus();
  }  
  
 }catch(e){alert(e);}}
 
 function readBarcode2(str){try{
  
  //str = str.substring(0,(str.length-1));
  document.getElementById("barcode2").value=str;
  
  var st = str.split("-");
  
  getEmployee(parseInt(st[0]));
  
  document.getElementById("employeeid").value=parseInt(st[0]);
  
  
 }catch(e){alert(e);}}
 
 function checkForm(form,event){
    
    var target = event.explicitOriginalTarget || event.relatedTarget ||
        document.activeElement || {};

    if(target.type=="text"){
    
      if(document.getElementById("barcode").value!="" && document.getElementById("barcode2").value!="" ){
	//return true;
	   var vbarcode=$("#barcode").val();
	   var ebarcode=$("#barcode2").val();
	   $.get("checkDateCode.php?vbarcode="+vbarcode+"&ebarcode="+ebarcode,function(data){
	    error=data;
	    
	    var err = error.split("|");
	    if(parseFloat(err[0])==1){
	      alert(err[1]);
	      $("#barcode2").val("");
	      $("#barcode2").focus();
	    }else{
	      $.post( "addharvestrejects_proc.php", { action2: "Add", sizeid:$("#sizeid").val(), blockid:$("#blockid").val(), rejecttypeid:$("#rejecttypeid").val(), itemid:$("#itemid").val(), quantity:$("#quantity").val(), employeeid:$("#employeeid").val(), employeename:$("#employeename").val(), iterator:$("#iterator").val(), status:$("#status").val(), downsize:$("#downsize").val(), datecode:$("#datecode").val(), barcode:$("#barcode").val(), barcode2:$("#barcode2").val() } );
		
	      tbl.fnAddData( [
		      iterator+1,
		      $("#sizeid option:selected").text(),
		      $("#blockid option:selected").text(),
		      $("#itemid option:selected").text(),
		      $("#quantity").val(),
		      $("#employeename").val(),
		      $("#rejecttypeid option:selected").text(),
		      $("#datecode").val(),
		      $("#barcode").val()+"="+$("#barcode2").val(),
		      "",
		      "" ] );
	      
	      iterator++;
	      $("#barcode").val("");
	      $("#barcode2").val("");
	      $("#datecode").val("");
	      $("#barcode").focus();
	      $("#iterator").val(iterator);
	      return false;
	    }
	    
	  });  
      }
      else{
	return false;
      }
      return false;
     }
 }
 
 function placeCursorOnPageLoad()
{
	document.getElementById("barcode").focus();/*
	document.getElementById("barcode").select();
	document.getElementById("barcode2").value="";*/
		
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
function getEmployee(id)
{  
	try{
	var xmlhttp;
	var url="get.php?id="+id;
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }  
	/*** changed ***/
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{alert(xmlhttp.responseText);
			document.getElementById("employeename").value=xmlhttp.responseText;
		}
	};
	
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	}catch(e){alert(e);}
}
 
function placeCursorOnPageLoad()
{
	document.getElementById("barcode").focus();
		
}

womAdd('placeCursorOnPageLoad()');
womOn();
</script>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	tbl = $('#tbl').dataTable( );
 } );
 </script>

<div class='content'>
<form  id="theform" action="addharvestrejects_proc.php" name="harvestrejects" method="POST" enctype="multipart/form-data" onSubmit="return checkForm(this,event);">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
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
		<td align="right">Employee BarCode : </td>
		<td><input type="text" name="barcode2" id="barcode2" autocomplete="off" value="<?php echo $obj->barcode2; ?>">&nbsp;<input type="text" readonly size="3" name="datecode" id="datecode" value="<?php echo $obj->datecode; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='Local Market' <?php if($obj->status=='Local Market'){echo"selected";}?>>Local Market</option>
			<option value='Discarded' <?php if($obj->status=='Discarded'){echo"selected";}?>>Discarded</option>
		</select></td>
	</tr>
	
	
	<tr>
		<td align="right">Date Graded : </td>
		<td><input type="text" name="gradedon" id="gradedon" class="date_input" size="12" readonly  value="<?php echo $obj->gradedon; ?>"><font color='red'>*</font></td>
		Document No:<input type="text" name="documentno" id="documentno"  readonly  size="6"  value="<?php echo $obj->documentno; ?>">
	</tr>
	<tr>
		<td align="right">Date Reported : </td>
		<td><input type="text" name="reportedon" id="reportedon" class="date_input" size="12" readonly  value="<?php echo $obj->reportedon; ?>"></td>
	</tr>
</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left">Reject Type</th>
		<th align="left">Product  </th>
		<th align="left">Size  </th>
		<th align="left">Green House  </th>
		<th align="left">Quantity  </th>
		<th align="left">Employee  </th>		<!--
		<th align="left">Reject Type</th>-->
		<th><input type="hidden" name="iterator" id="iterator" value="<?php echo $obj->iterator; ?>"/>Remarks</th>
		<th>&nbsp;</th>
		</tr>
	<tr>
			<td>
			<select name="rejecttypeid" id="rejecttypeid" class="selectbox">
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
			<td><select name="itemid" id="itemid" class="selectbox">
<option value="">Select...</option>
<?php
	$items=new Items();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($items->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->itemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
			<td><select name="sizeid" id="sizeid" class="selectbox">
<option value="">Select...</option>
<?php
	$sizes=new Sizes();
	$where="  ";
	$fields="*";
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
		
			</td>
			<td><select name="blockid" id="blockid" class="selectbox">
<option value="">Select...</option>
<?php
	$blocks=new Greenhouses();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($blocks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->greenhouseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
		
			<td><input type='text' size='40' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
			<!--<td><select name="rejecttypeid" id="rejecttypeid" class="selectbox">
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
</select><font color='red'>*</font>
		</td>-->
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
		
		<td ><input type="submit" name="action2" id="action2" value="Add"/></td>
	</tr>
	</table>
	
	<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Size  </th>
		<th align="left">Block  </th>
		<th align="left">Product  </th>
		<th align="left">Quantity  </th>
		<th align="left">Employee  </th>
		<th align="left">Reject Type</th>		
		<th align="left">Date Code</th>
		<th align="left">Barcode</th>
		<th>Remarks</th>
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
			<td><?php echo $shprejects[$i]['blockname']; ?> </td>
			<td><?php echo $shprejects[$i]['itemname']; ?> </td>
			<td><?php echo $shprejects[$i]['quantity']; ?> </td>
			<td><?php echo $shprejects[$i]['employeename']; ?> </td>
			<td><?php echo $shprejects[$i]['rejecttypename']; ?> </td>
			<td><?php echo $shprejects[$i]['datecode']; ?> </td>
			<td><?php echo $shprejects[$i]['barcode']; ?> </td>
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
	redirect("addharvestrejects_proc.php?retrieve=&status=".$obj->status."&reduce=".$obj->reduce);
}

?>