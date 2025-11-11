<title>WiseDigits ERP: Graded </title>
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
<?php //include'js.php'; ?>
</script>
 <script type="text/javascript" charset="utf-8">
 var tbl;
 var iterator=0;
 $(document).ready(function() {
 	tbl = $('#tbl').dataTable(); 	
 } );
 
 
 $(document).ready(function () {
 $('#barcode').on('change',function(){ 
            //document.getElementById("barcode").value=str;            
            
            var str=$(this).val();
//             str = str.substring(0,(str.length-1));
	    var st = str.split("-");
	    var error="";
	    if(st.length<3){
// 	      $('#chatAudio')[0].play();
	      alert("Scan the client bar code first");
	      $("#barcode").val("");
	      $("#barcode").focus();
	    }else{
	      $.get("../../post/barcodes/checkBarCodes.php?type=<?php echo $obj->status; ?>",{barcode:str},function(data){
		
		error=data;
		
		var err = error.split("|");
		if(parseFloat(err[0])==1){
		  $("#barcode").val("");
		  
		  alert(err[1]);
		  
		  $("#barcode").focus();
		}else{
		  document.getElementById("itemid").value=parseInt(st[0]);
		  document.getElementById("sizeid").value=st[1];
		  document.getElementById("quantity").value=st[2];
		  document.getElementById("greenhouseid").value=st[3];
		  if(st.length==5){
		    document.getElementById("downsize").value=st[4];
		  }
		  else{
		    document.getElementById("downsize").value='';
		  }
		  
		  saveForm();
		  
		  document.getElementById("barcode2").focus();
		  
		  
		}
		
	      });   
	      
	    }
    });
  });
  
$(document).ready(function(){
  $("#barcode2").on("change",function(){
//   var tm=document.getElementById("employeeid").value
    var str=$(this).val();
    
    var st = str.split("-");
    if(st.length>2){
//       $('#chatAudio')[0].play();
      alert("Scan the employee bar code correctly");
      $("#barcode2").val("");
      $("#barcode2").focus();
    } 
    else if(st.length!=2){
      alert("The bar code is OLD bar code Scan the New employee bar code!");
      $("#barcode2").val("");
      $("#barcode2").focus();
    }
    else{
    var tmp=document.getElementById("iterator").value;
    var t=parseInt(tmp);
    if(t>9)
    {
    alert("Items already 10. Please save");
    $("#barcode2").val("");
    $("#barcode2").focus();
    }
    else{
      $.get("get.php",{id:parseInt(st[0])},function(data){
	$("#employeename").val(data);  
      });
      document.getElementById("employeeid").value=parseInt(st[0]);
      $("#datecode").val(st[1]); 
      $("#barcode").focus();
    }
    }
  })
})
 function readBarcode(str){try{
  
//   str = str.substring(0,(str.length-1));
  document.getElementById("barcode").value=str;
  var st = str.split("-");
  
  if(st[2]>100){
    alert("Please Check your client barcode");
  }
  else{
    document.getElementById("itemid").value=parseInt(st[0]);
    document.getElementById("sizeid").value=st[1];
    document.getElementById("quantity").value=st[2];
    if(st[3]!=""){
      document.getElementById("downsize").value=st[3];
    }
    
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
 
 function saveForm(){
    
//     var target = event.explicitOriginalTarget || event.relatedTarget ||
//         document.activeElement || {};

//     if(target.type=="text"){
    
      if(document.getElementById("barcode").value!="" && document.getElementById("barcode2").value!="" ){
	//return true;
	var status=$("#status").val(); 
	if(status=="regradedout" || status=="checkedout" || status=="rebunchinout"){
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
	      
	      $.post( "addgraded_proc.php", { action2: "Add", sizeid:$("#sizeid").val(), greenhouseid:$("#greenhouseid").val(), itemid:$("#itemid").val(), quantity:$("#quantity").val(), employeeid:$("#employeeid").val(), employeename:$("#employeename").val(), iterator:$("#iterator").val(), status:$("#status").val(), downsize:$("#downsize").val(), barcode:$("#barcode").val(), barcode2:$("#barcode2").val(), datecode:$("#datecode").val() } );

	
	      tbl.fnAddData( [
		      iterator+1,
		      $("#sizeid option:selected").text(),
		      $("#itemid option:selected").text(),
		      $("#greenhouseid option:selected").text(),		
		      $("#quantity").val(),
		      $("#employeename").val(),
		      $("#datecode").val(),
		      $("#downsize").val(),
		      "",
		      "",
		      ""] );
	      
	      iterator++;
	      $("#barcode").val("");
	      $("#barcode2").val("");
	      $("#barcode2").focus();
	      $("#iterator").val(iterator);
	      return false;
	    }
	    
	  }); 
	}else{
	$.post( "addgraded_proc.php", { action2: "Add", sizeid:$("#sizeid").val(), greenhouseid:$("#greenhouseid").val(), itemid:$("#itemid").val(), quantity:$("#quantity").val(), employeeid:$("#employeeid").val(), employeename:$("#employeename").val(), iterator:$("#iterator").val(), status:$("#status").val(), downsize:$("#downsize").val(), barcode:$("#barcode").val(), barcode2:$("#barcode2").val(), datecode:$("#datecode").val() } );

	
	tbl.fnAddData( [
		iterator+1,
		$("#sizeid option:selected").text(),
		$("#itemid option:selected").text(),
		$("#greenhouseid option:selected").text(),		
		$("#quantity").val(),
		$("#employeename").val(),
		$("#datecode").val(),
		$("#downsize").val(),
		"",
		"",
		""] );
	
	iterator++;
	$("#barcode").val("");
	$("#barcode2").val("");
	$("#barcode2").focus();
	$("#iterator").val(iterator);
	return false;
       }
      }
      else{
	return false;
      }
      return false;
//      }
 }
 
 function placeCursorOnPageLoad()
{
	document.getElementById("barcode2").focus();/*
	document.getElementById("barcode").select();
	document.getElementById("barcode2").value="";*/
		
}

function checkForm(form,event){
  var target = event.explicitOriginalTarget || event.relatedTarget ||
        document.activeElement || {};
console.log(target);
  if(target.type=="text")
    return false;
  else
    return true;
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
womAdd('placeCursorOnPageLoad()');
womOn();
 </script>

<hr>
<div class="content">
<form  id="theform" action="addgraded_proc.php" name="graded" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this, event);">

	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<?php if($obj->status=='checkedout'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">COLD STORE RETURNS</td></h1>
	</tr>
	<?php }
	
	else if($obj->status=='stocktake'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">COLD STORE STOCKTAKE</td></h1>
	</tr>
	<?php }
	else if($obj->status=='rebunchingin'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">REBUNCHING BACK TO COLD STORE</td></h1>
	</tr>
	<?php }
	else if($obj->status=='rebunchinout'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">REBUNCHING OUT FROM THE COLD STORE</td></h1>
	</tr>
	<?php }
	else if($obj->status=='regradedout'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">OUT FROM COLD STORE FOR REGRADING</td></h1>
	</tr>
	<?php }
	
	else if($obj->status=='stocktake'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">COLD STORE STOCKTAKE</td></h1>
	</tr>
	<?php }else if($obj->status=='regradedin'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">REGRADING BACK TO COLD STORE</td></h1>
	</tr>
	<?php }else if($obj->status=='checkedin'){ ?>
	<tr>
		<h1><td colspan="4" align="center" style="font-size:35px; color:red; ">NEWLY GRADED TO COLD STORE</td></h1>
	</tr>
	<?php } ?>
	
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn btn-info" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Date Graded:</label></td>
<td><input type="text" name="gradedon" id="gradedon" class="date_input" size="12" readonly  value="<?php echo $obj->gradedon; ?>">
<input type="hidden" name='status' id='status' value='<?php echo $obj->status; ?>'></td>
			</tr>
			<tr>
			<td>
		<label>Remarks:</label>			</td>
			<td>
<textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea>			</td>
			</tr>
			
			<tr>
			<td>Barcode:
			</td>
			<td>
			  &nbsp;
			  <input type="text" name="barcode2" id="barcode2" value="<?php echo $obj->barcode2; ?>"/>
			  &nbsp;
			  <input type="text" name="barcode" id="barcode" value="<?php echo $obj->barcode; ?>" />
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Size  </th>
		<th align="right">Green House  </th>
		<th align="right">Product  </th>
		<th align="right">Quantity  </th>
		<th align="right">Employee  </th>
		<th align="right">Date Code  </th>
		<th align="right">Unique ID  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
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
<td><select name="greenhouseid" id="greenhouseid" class="selectbox">
<option value="">Select...</option>
<?php
	$greenhouses=new Greenhouses();
	$where="  ";
	$fields="*";
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
	?>
</select>
		</td>
<font color='red'>*</font>		<td><select name="itemid" id="itemid" class="selectbox">
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
</select>
<font color='red'>*</font>
		</td>		
		<td><input type="text" name="quantity" id="quantity" size="20" value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
		
		<td><input type='text' size='20' name='employeename' readonly id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="text" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
		<td><input type='text' readonly size='3' name='datecode'  id='datecode' value='<?php echo $obj->datecode; ?>'></td>
		<td><input type="text" readonly name="downsize" id="downsize" size="2" value="<?php echo $obj->downsize; ?>"></td>
<font color='red'>*</font>	<td><input class="btn btn-info" type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Size  </th>
		<th align="left">Product  </th>
		<th align="left">Green House  </th>
		<th align="left">Quantity  </th>
		<th align="left">Employee  </th>
		<th align="left">Date Code  </th>
		<th align="left">Unique ID</th>
		<th><input type="hidden" name="iterator" id="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpgraded']){
		$shpgraded=$_SESSION['shpgraded'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpgraded[$i]['sizename']; ?> </td>
			<td><?php echo $shpgraded[$i]['itemname']; ?> </td>
			<td><?php echo $shpgraded[$i]['greenhouseid']; ?> </td>
			<td><?php echo $shpgraded[$i]['quantity']; ?> </td>
			<td><?php echo $shpgraded[$i]['employeename']; ?> </td>
			<td><?php echo $shpgraded[$i]['datecode']; ?> </td>
			<td><?php echo $shpgraded[$i]['downsize']; ?> </td>
			<td><?php echo $shpgraded[$i]['barcode']; ?> </td>
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
		<td colspan="2" align="center">
		<input class="btn btn-primary" type="submit" name="action" onclick = "this.style.visibility='hidden', loading.style.visibility='visible'" id="action" value="<?php echo $obj->action; ?>">&nbsp;
		<input class="btn btn-danger" type="button"  value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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
	redirect("addgraded_proc.php?retrieve=&status=".$obj->status);
}

?>