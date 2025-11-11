<title>WiseDigits ERP: Orders </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
var tbl;
var iterator=0;

 $(document).ready(function() {
      tbl = $('#tbl').dataTable( {
	      "sScrollY": 180,
	      "bJQueryUI": true,
	      "bSort":false,
	      "sPaginationType": "full_numbers"
      } );
 } );
 
$().ready(function() {
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
		$("#tel").val(ui.item.tel);
		$("#address").val(ui.item.address);
		$("#remarks").val(ui.item.remarks);
	}
  });

 
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
		$("#price").val(ui.item.price);
	}
  });

  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=name",
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

function saveForm(){     
     
      $.post( "addorders_proc.php", { action2: "Add", itemid:$("#itemid").val(), quantity:$("#quantity").val(), memo:$("#memo").val(), type:'1', iterator:$("#iterator").val()} );
      
      var total = $("#price").val() * $("#quantity").val();
      
      tbl.fnAddData( [
		iterator+1,
		$("#itemname").val(),		
		$("#quantity").val(),
		$("#price").val(),
		total,
		$("#memo").val(),
		""] );
	
	iterator++;
	$("#barcode").val("");
	$("#barcode2").val("");
	$("#barcode2").focus();
	$("#iterator").val(iterator);
	
	    
      document.getElementById("itemid").value="";
      document.getElementById("itemname").value="";
      document.getElementById("quantity").value="";
      document.getElementById("memo").value="";
      
      $("#itemname").focus();
      
      return true;

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
	function status(id){
		var xmlhttp;
		var url="checkStatus.php?id="+id;
		xmlhttp=GetXmlHttpObject();
		
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
			      if(dsa==2)
			      {
			       document.getElementById("customername").value="";
			       document.getElementById("customerid").value="";
			       document.getElementById("tel").value="";
			       document.getElementById("address").value="";
			       document.getElementById("remarks").value="";
			       alert('The Customer is Inactive Please Contact Finance for His/Her Activation!');
			       }				
			}
		};
			
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);    
		}
</script>

<hr>
<div class="content">
<form  id="theform" action="addorders_proc.php" name="orders" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample" onsubmit="return checkForm(this, event);">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>
		Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			
		</table>
	
	<div class="panel panel-success">
	  <div class="panel-body">
	  <?php
	  $branches = new Branches();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where="" ;
	  $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  while($rw=mysql_fetch_object($branches->result)){
	  ?>
	    <div style="float:left;" class="btn btn-primary"><?php echo strtoupper($rw->name); ?></div>
	  <?php
	  }
	  ?>
	  </div>
	</div>
	
	<div class="panel panel-info">
	  <div class="panel-body">
	  <?php
	  $categorys = new Categorys();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where="" ;
	  $categorys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  while($rw=mysql_fetch_object($categorys->result)){
	  ?>
	    <div style="float:left;" class="btn btn-primary"><?php echo strtoupper($rw->name); ?></div>
	  <?php
	  }
	  ?>
	  </div>
	</div>
		
	<table width="50%" class="table gridd" >
	
	<tr>
		<td align="right">Product:</td>
		<td><input type="text"  name="itemname" id="itemname" value="<?php echo $obj->itemname; ?>"/>
		      <input type="hidden" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"/>
		      <font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity: </td>
		<td><input type="text" name="quantity" id="quantity" size="16" value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
	</tr>
	
	<tr>
		<td align="right">Price: </td>
		<td><input type="text" name="price" id="price" size="16" readonly value="<?php echo $obj->price; ?>"><font color='red'>*</font></td>
	</tr>
	
	<tr>	
		<td align="right">Memo: </td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="button" onclick="saveForm();" class="btn btn-primary" name="action2" value="Add"/></td>
	</tr>
	</table>
	
		<table align='center'>
		<tr>
			<td style="color:red;"><?php echo $_SESSION['employeename'];?></td>
			<td>Order No:</td>
			<td><input type="text" name="orderno" id="orderno" readonly size="16"  value="<?php echo $obj->orderno; ?>"></td>
			<td>Date Ordered:</td>
			<td><input type="date" name="orderedon" id="orderedon"  class="date_input" size="16" readonly  value="<?php echo $obj->orderedon; ?>"></td>
			<td>Remarks:</td>
			<td><textarea name="remarks" ><?php echo $obj->remarks; ?></textarea></td>
		</tr>
		</table>
<table class="table" id="tbl" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if(!empty($obj->retrieve)){?>
		<th>&nbsp;</th>
		<?php }?>
		<th align="left">Product  </th>
		<th align="left">Qty</th>
		<th align="left">Price</th>
		<th align="left">Total</th>
		<th align="left">Memo <input type="hidden" id="iterator" name="iterator" value="<?php echo $obj->iterator; ?>"/> </th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	if($_SESSION['shporders']){
		$shporders=$_SESSION['shporders'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<?php if(!empty($obj->retrieve)){?>
			<td><input type="checkbox" name="<?php echo $shporders[$i]['id']; ?>"/></td>
			<?php }?>
			<td><?php echo $shporders[$i]['itemname']; ?> </td>
			<td><?php echo $shporders[$i]['quantity']; ?> </td>
			<td><?php echo $shporders[$i]['price']; ?> </td>
			<td><?php echo $shporders[$i]['total']; ?> </td>
			<td><?php echo $shporders[$i]['memo']; ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=1" onclick="return confirm('Are you sure you want to delete?')">Del</a></td>
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
	<?php //if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
		
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" value="Print" onclick="Clickheretoprint();"/>
		<input type="submit" name="action" id="action" value="Confirm Order" />
		<input type="submit" name="action" id="action" value="Copy Order" />
		
		</td>
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
	redirect("addorders_proc.php?retrieve=");
}

?>