<title>WiseDigits ERP: Transfers </title>
<?php 
include "../../../head.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
//  	        "sScrollY": 180,
 		"iDisplayLength": 1000,
 		"bJQueryUI": true,
 		"bSort":false,
 		//"sPaginationType": "full_numbers"
 	} );
 } );
 </script>
  <script type="text/javascript">
function Clickheretoprint()
{
	var msg;
	msg="Do you want to print ?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?doc=<?php echo $obj->documentno; ?>");
	}
}
</script>
 
  <script type="text/javascript">
$().ready(function() {
 $("#itemname").autocomplete({
	source: "../../../modules/server/server/search.php?main=inv&module=items&field=inv_items.name&where=inv_items.status='Active'", 
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		document.getElementById("itemid").value=ui.item.id;
		document.getElementById("stock").value=ui.item.quantity;
		document.getElementById("costprice").value=ui.item.costprice;
		document.getElementById("quantity").value=1;
		calculateTotal();
	}
 });
 
 });
</script>
<script type="text/javascript">

var iterator=0;

function getItem(){
  alert($("#itemid").val());
}
$().ready(function() {
 
 $("#serialno").autocomplete({
 
	source: function(request, response) {
            $.getJSON(
                "../../../modules/server/server/search.php?main=inv&module=itemdetails&field=inv_itemdetails.serialno&where=inv_itemdetails.status=1",
                { term:request.term, where:" inv_itemdetails.itemid="+$('#itemid').val()+" and inv_itemdetails.brancheid="+$("#brancheid").val() }, 
                response
            );
        },
	autoFocus:true,
 	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	}, 
      	
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		document.getElementById("serialno").value=ui.item.serialno;
		document.getElementById("itemdetailid").value=ui.item.id;
		document.getElementById("version").value=ui.item.version;
	}	
 });
 

 <?php
 $i=0;
 $shptransferss = $_SESSION['shptransfers'];
 while($i<count($_SESSION['shptransfers'])){
 ?>
 $("#serialno<?php echo $i; ?>").autocomplete({
	source: "../../../modules/server/server/search.php?main=inv&module=itemdetails&field=inv_itemdetails.serialno&where=inv_itemdetails.status=1 and inv_itemdetails.itemid = <?php echo $shptransferss[$i]['itemid'];?> and inv_itemdetails.brancheid="+$("#brancheid").val(),
 	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		
		document.getElementById("serialno<?php echo $i; ?>").value=ui.item.serialno;
		document.getElementById("itemdetailid<?php echo $i; ?>").value=ui.item.id;
		setSerialNo("<?php echo $i; ?>",ui.item.id,ui.item.serialno);
	}
 });
 <?php
 $i++;
 }
 ?>
 });
 
 function checkavailability(id,i,itid)
{  
        var xmlhttp;
	var url="checkavailability.php?id="+id+"&itid="+itid+"&i="+i;//alert(url);
	xmlhttp=new XMLHttpRequest();
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{ 
			var data = xmlhttp.responseText;//alert(data);
			var dsa=String(data);
			if(dsa==1)
			{
			alert("Already Selected!");
			$('#instalcode'+i).val("");
// 			document.getElementById("instalcode").value="";
			}else{
			  $('#crdcode'+i).text(data);
			}
		}
	};
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
 
 function enableQuantity(id){
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
    {
    
    }
  }
  <?php $rules= new Rules (); ?>
  var url="sets.php?id="+id+"&checked="+$("#id"+id).is(':checked');
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
  
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
function setCodes(id,code,val)
{
	//var id=document.getElementById("plotid").value;
	//var houseid=document.getElementById("houseid").value;
	var xmlhttp;
	var url="setcodes.php?id="+id+"&code="+code+"&value="+val+"&type=codes";
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
			document.getElementById("crdcode"+id).innerHTML=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function setSerialNo(id,itemdetailid,serialno)
{
	var xmlhttp;
	var url="setcodes.php?id="+id+"&itemdetailid="+itemdetailid+"&serialno="+serialno+"&type=serialno";
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
			var code = xmlhttp.responseText;
			var str = code.split("-");
			
			document.getElementById("version"+id).innerHTML=str[0];
			if(str[0]=="2"){
			  document.getElementById("instalcodes"+id).innerHTML=str[1];
			}
			else{alert(str[1]);
			  document.getElementById("instalcode"+id).value=str[1];
			}
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function setQuantityrec(id,rem,quantityrec,val)
{
	if(val>rem){
	alert("remaining quantity is "+rem);
	document.getElementById("q"+id).value="";
	$('#id'+id).prop( "checked", false );
	}else{	
	var xmlhttp;
	var url="setquantityrec.php?id="+id+"&quantityrec="+quantityrec+"&value="+val;alert(url);
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
			//document.getElementById("houseid").innerHTML=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
}

$(document).ready(function () {
 $('#barcode').on('change',function(){ 
           
            $("#barcode").prop("readonly",true);
            
            var str=$(this).val();
//             str = str.substring(0,(str.length-1));
	    var st = str.split("-");
	    var error="";
	    if(st.length<2){
// 	      $('#chatAudio')[0].play();
	      alert("Scan the correct Barcode!");
	      $("#barcode").val("");
	      $("#barcode").prop("readonly",false);
	      $("#barcode").focus();
	    }else{
	      $.get("../../post/barcodes/checkBarCodes.php?type=<?php echo $obj->status; ?>",{barcode:str},function(data){
		
		error=data;
		
		var err = error.split("|");
		if(parseFloat(err[0])==1){
		  $("#barcode").val("");
		  
		  alert(err[1]);  
		  
		  
		  $("#barcode").prop("readonly",false);
		  $("#barcode").focus();
		}else{
		  
		  document.getElementById("itemname").value=err[1];
		  document.getElementById("serialno").value=err[2];
		  document.getElementById("instalcode").value=err[3];
		  document.getElementById("quantity").value=1;
		  document.getElementById("itemid").value=err[4];
		  document.getElementById("itemdetailid").value=err[5];
		  document.getElementById("costprice").value=err[6];
		  document.getElementById("total").value=err[6];
		  
		  saveForm();
		  
		  $("#barcode").val("");
		  $("#barcode2").val("");
		  $("#barcode2").focus();
		  $("#iterator").val(iterator);
		  
		  return false;
		  
		}
		
	      });   
	      
	    }
    });
  });
  
  function saveForm(){
  
//     if(document.getElementById("barcode").value!=""  ){
      $.post( "addtransfers_proc.php", { action2: "Add", itemid:$("#itemid").val(), itemdetailid:$("#itemdetailid").val(), serialno:$("#serialno").val(), costprice:$("#costprice").val(), memo:$("#memo").val(), iterator:$("#iterator").val(), instalcode:$("#instalcode").val(), version:$("#version").val() } );
      
      $("#barcode").prop("readonly",false);
      
      var tbl;
      tbl = $('#tbl').dataTable();
	  
      tbl.fnAddData( [
	      iterator+1,
	      $("#itemname").val(),
	      $("#serialno").val(),		
	      $("#version").val(),
	      $("#quantity").val(),
	      $("#costprice").val(),
	      $("#memo").val(),
	      $("#instalcode").val(),
	      "",
	      $("#total").val(),
	      "<a href='edit.php?i="+iterator+"&action=del&edit=<?php echo $obj->edit; ?>'>Edit</a>",
	      "<a href='edit.php?i="+iterator+"&action=del&edit=<?php echo $obj->edit; ?>'>Del</a>"] );
      
      iterator++;
      
      $("#iterator").val(iterator);
//     }
    return false;
  }

function selectAll(str){try{
  <?php
    $shop = $_SESSION['shptransfers'];
    $i=0;
    while($i<count($shop)){
      ?>
      if(str.checked==1)
	document.getElementById("id<?php echo $i; ?>").checked=true;
      else
	document.getElementById("id<?php echo $i; ?>").checked=false;
      <?
      $i++;
    }
  ?>}catch(e){alert(e);}
}

function placeCursorOnPageLoad()
{
	$("#barcode").focus();
		
}

womAdd("placeCursorOnPageLoad()");
womOn();

function checkForm(form,event){
  var target = event.explicitOriginalTarget || event.relatedTarget ||
        document.activeElement || {};

  if(target.type=="text")
    return false;
  else
    return true;
}

 <?php include'js.php'; ?>
 </script>

<div class='content'>
<form  id="theform" action="addtransfers_proc.php" name="transfers" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this, event);">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Transfer No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Transfer No:</label></td>
<td><input type="text" name="documentno" readonly id="documentno" size="20"  value="<?php echo $obj->documentno; ?>"/>			</td>
			</tr>
			<tr>
				<td><label>Requisition No:</label></td>
<td><input type="text" name="requisitionno" readonly id="requisitionno" size="20"  value="<?php echo $obj->requisitionno; ?>"/>			</td>
			</tr>
			<tr>
				<td><label>From :</label></td>
<td>
<?php
if(empty($obj->action))
  $obj->brancheid=$_SESSION['brancheid'];
$branches=new Branches();
if($obj->receive==1)
     $where=" where id='15' ";
else{
      if($_SESSION['brancheid']==6)
         $where="  ";
      else
         $where=" where id='".$_SESSION['brancheid']."' ";
    }$where="  ";

$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<select name="brancheid" id="brancheid" class="selectbox">
<?php
	while($rw=mysql_fetch_object($branches->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>			</td>
			</tr>
			<tr>
				<td><label>To :</label></td>
<td><select name="tobrancheid" id="tobrancheid" class="selectbox">
<option value="">Select...</option>
<?php
	$branches2=new Branches();
	if($obj->receive==1)
	    $where=" where id='".$_SESSION['brancheid']."' ";
	else
	  $where="";
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches2->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($branches2->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tobrancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>			
    
			</tr>
			<tr>
			<td>
		Transfered On:</td>
		<td><input type="date" name="transferedon" id="transferedon"  class="date_input" size="12" readonly  value="<?php echo $obj->transferedon; ?>">
		<input type="hidden" name="dispatch" id="dispatch"   value="1">
		
		</td>
		</tr>
		<tr>
		<td>Remarks:</td><td><textarea name="remarks" ><?php echo $obj->remarks; ?></textarea>
			</td>
			</tr>
			
		
		</table>
	<!--	
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Product  </th>
		<th align="right">Quantity  </th>
		<th>Memo</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='32' name='itemname'  onchange="calculateTotal();" onblur="calculateTotal();"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"/>			
			</td>			                
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();" onblur="calculateTotal();"  size="8" value="<?php echo $obj->quantity; ?>">
		<input type="hidden" name="stock" id="stock" readonly onchange="calculateTotal();" onblur="calculateTotal();"  size="8" value="<?php echo $obj->stock; ?>"></td>
		
		<td><textarea name="memo" id="memo" ><?php echo $obj->memo; ?></textarea>
			</td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>-->
<table style="clear:both" class="table table-condensed table-striped table-bordered" id="tbl" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if($obj->receive==1){?>
		<th>
<!-- 		&nbsp;<input type="checkbox" onclick="selectAll(this);"/> -->
		</th>
		<?php } ?>
		<th align="left">Product  </th>
		<th align="left">Quantity  </th>
		
		<?php if($obj->receive==1){?>
		  <th align="left">Quantity Received</th>
		<?php
		}
		?>
		
		<th align="left">Memo  </th>
		<th align='left'>Total<input type="hidden" id="iterator" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<?php if($obj->receive!=1){?>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<?php }?>
		</tr>
	</thead>
	<tbody>
	<?php
	$ob = str_replace('&','',serialize($obj));
	$num=count($_SESSION['shptransfers']);
	if($num>0){
		$shptransfers=$_SESSION['shptransfers'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shptransfers[$i]['costprice'];
		?>
		<tr <?php if($shptransfers[$i]['status']==1){ ?> style="color:green;" <?php } ?> >
			<td><?php echo ($i+1); ?></td>
			<?php if($obj->receive==1){?>
			<td><input type="checkbox" id="id<?php echo $i; ?>" <?php if($shptransfers[$i]['status']==1){ ?> disabled <?php } ?> onChange="enableQuantity('<?php echo $i; ?>');" /></td>
			<?php } ?>
			<td><?php echo $shptransfers[$i]['itemname']; ?> </td>			
			
			<td><?php echo $shptransfers[$i]['quantity']; ?> </td>
			<?php if($obj->receive==1){?>
			<td><?php echo $shptransfers[$i]['quantityrec']; ?> </td>
			<?php } ?>
			<td><?php echo $shptransfers[$i]['memo']; ?></td>				
			<td align="right"><?php echo formatNumber($shptransfers[$i]['total']); ?> </td>
			<?php if($obj->receive!=1){?>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>&obj=<?php echo $ob; ?>'>Edit</a></td>
			<td><a href='edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>&obj=<?php echo $ob; ?>'>Del</a></td>
			<?php } ?>
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
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
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
	
	
	if($saved=="Yes")
{
	?>
<script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
    <?
    //$obj="";
	//$_SESSION['crshop']="";
  redirect("addtransfers_proc.php?retrieve=");
  }
  
}

