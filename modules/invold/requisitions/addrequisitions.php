<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
if($ob->procedure==1)
  include "../../../head.php";
else
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

  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=inv_items.name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
		$("#package").val(ui.item.package);
		
		var packages = parseFloat(ui.item.package);
		if(packages>1){
		  $("#wquantity").prop("readonly",false);
		}
		
		getReorderLevels(ui.item.id);
	}
  });

});

function setTotal(id,val)
{ 
try{	
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
	var url="savetoarray.php?i="+id+"&dquantity="+val;//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}catch(e){alert(e);}
		
}

function getReorderLevels(item)
{ 
try{	
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
	  var data = xmlhttp.responseText;
	  var dt = data.split("|");
	  $("#stock").val(dt[0]);
	  $("#reorderlevel").val(dt[1]);
	  $("#maxreorderlevel").val(dt[2]);
	  dt[0]=parseFloat(dt[0]);
	  dt[1]=parseFloat(dt[1]);
	  dt[2]=parseFloat(dt[2]);
	  if(dt[0]>=dt[1]){
	    $("#quantity").prop("readonly","readonly");
	    alert("Cannot reorder when you have in stock more than your Reorder Level");
	  }else{
	    $("#quantity").prop("readonly","");
	  }
	 }
	}
	var url="getReorderLevels.php?itemid="+item;//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}catch(e){alert(e);}
		
}

function getPieces(){
  var wholes = parseFloat($("#wquantity").val());
  var packages = parseFloat($("#package").val());
  
  var pieces = wholes*packages;
  
  $("#quantity").val(pieces);
}

function checkQuantity(){
  var quantity = $("#quantity").val();
  var maxreorderlevel = $("#maxreorderlevel").val();
  quantity = parseFloat(quantity);
  maxreorderlevel = parseFloat(maxreorderlevel);
  
  if(quantity>maxreorderlevel){
    $("#quantity").val("");
    alert("Cannot reorder more than maximum reorder quantity!");//alert(url);
  }
}
function setCheckBoxes(str){
  <?php
  $shop = $_SESSION['shprequisitions'];
  $i=0;
  while($i<count($shop)){
  ?>
    if(str.checked){
      $("[name='<?php echo $shop[$i]['id']; ?>']").prop('checked',true);
    }else{
      $("[name='<?php echo $shop[$i]['id']; ?>']").prop('checked',false);
    }
  <?
  $i++;
  }
  ?>
  
}

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



 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>
 

<div class="content">
   <?php
   
   echo "ACTION:".$obj->action;
   ?>

<form  id="theform" action="addrequisitions_proc.php" name="requisitions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center">
		<input type="hidden" name="approve" value="<?php echo $obj->approve; ?>"/>
		<input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Branch:</label></td>
				<td><select name="brancheid" id="brancheid" class="selectbox">
				      <option value="">Select...</option>
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
					<option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->brancheid || $rw->id==$_POST['brancheid'] ){echo "selected";}?>><?php echo strtoupper($rw->name); ?></option>
				      <?php
				      }
				      ?>
				    </select>
				</td>
			</tr>
			<tr>
			<td><label>Requested By:</label></td>
				<td><input type='text' size='20' name='employeename' readonly id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'></td>
			</td>
			</tr>
			
			<tr>
			<td>
		<label>Remarks:</label>			</td>
			<td>
<textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea>			</td>
			</tr>
				
			
		</table>
	<table width="100%" class="titems gridd table" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Item  </th>
		<!--<th>Current Stock</th>
		<th>Reorder Level</th>
		<th>Max Reorder Quantity</th>-->
		<th align="right">Qnt (W) </th>
		<th align="right">Qnt (P)  </th>
		<?php if($obj->approve==1){?>
		<th align="right">Approved Quantity  </th>
		<?php }?>
		<th align="right">Memo  </th><!--
		<th>Total</th>-->
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>
		</td>		
		<!--<td><input type="text" readonly name="stock" id="stock"  size="6" value="<?php echo $obj->stock; ?>"></td>
		<td><input type="text" readonly name="reorderlevel" id="reorderlevel"  size="6" value="<?php echo $obj->reorderlevel; ?>"></td>
		<td><input type="text" readonly name="maxreorderlevel" id="maxreorderlevel" size="6" value="<?php echo $obj->maxreorderlevel; ?>"></td>-->
		<td>
		 <input type="hidden" name="package" id="package" value="<?php echo $obj->package; ?>"/>
		 <input type="text" name="wquantity" id="wquantity" readonly onchange="getPieces();" onblur="getPieces();"  size="6" value="<?php echo $obj->wquantity; ?>">
		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="checkQuantity();calculateTotal();" onblur="checkQuantity();calculateTotal();"  size="6" value="<?php echo $obj->quantity; ?>"></td>
		<?php if($obj->approve==1){?>
		<td><input type="text" name="aquantity" id="aquantity" size="6" value="<?php echo $obj->aquantity; ?>"></td>
		<?php }?>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
<!-- 	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td> -->
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			  <td>Requisition No:</td>
			  <td><input type="text" name="documentno" id="documentno" readonly size="6"  value="<?php echo $obj->documentno; ?>">
			  <td>Requisition Date:</td>
			  <td><input type="date" name="requisitiondate" id="requisitiondate"  size="12" readonly  value="<?php echo $obj->requisitiondate; ?>"></td>
			</tr>
		</table>
<table style="clear:both" class="table display" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if(!empty($obj->retrieve)){?>
		<th><input type="checkbox" name="all" value="1" onChange="setCheckBoxes(this);"/></th>
		<?php }?>
		
		<th align="left">Item  </th>
		<!--<th>Current Stock</th>
		<th>Reorder Level</th>
		<th>Max Reorder Qnt</th>-->
		<th align="left">Quantity  </th>
		<th align="left">Approved Quantity  </th>
		<?php if($obj->retrieve==1){?>
		<th align="left">Dispatch Quantity  </th>
		<?php } ?>
		<th align="left">Memo  </th>
<!-- 		<th align='left'>Total</th> -->
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	if(!empty(count($_SESSION['shprequisitions']))){
		$shprequisitions=$_SESSION['shprequisitions'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shprequisitions[$i]['quantity'];
		
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<?php if(!empty($obj->retrieve)){?>
			<td><input type="checkbox" name="<?php echo $shprequisitions[$i]['id']; ?>" id="<?php echo $shprequisitions[$i]['id']; ?>" <?php if($shprequisitions[$i]['quantityissued']>=$shprequisitions[$i]['quantity']){echo"disabled";}?>/></td>
			<?php }?>
			<td><?php echo $shprequisitions[$i]['itemname']; ?> </td>
			<!--<td><?php echo $shprequisitions[$i]['stock']; ?> </td>
			<td><?php echo $shprequisitions[$i]['reorderlevel']; ?> </td>
			<td><?php echo $shprequisitions[$i]['maxreorderlevel']; ?> </td>-->
			<td><?php echo $shprequisitions[$i]['quantity']; ?> </td>
			<?php if($obj->approve==1){?>
			<td><input type="text" size="4" value="<?php echo $shprequisitions[$i]['aquantity']; ?>"/></td>
			<?php }else{ ?>
			<td><?php echo $shprequisitions[$i]['aquantity']; ?> </td>
			<?php }?>
			
			<?php if($obj->retrieve==1){ ?>
			<td><input type="text" size="4" onchange="setTotal('<?php echo $i; ?>',this.value);" value="<?php echo $shprequisitions[$i]['dquantity']; ?>"/></td>
			<?php } ?>
			
			<?php if($obj->approve==1){?>
			<td><textarea name="memo" rows="1"><?php echo $shprequisitions[$i]['memo']; ?></textarea>
			<?php }else{ ?>
			<td><?php echo $shprequisitions[$i]['memo']; ?> </td>
			<?php }?>
<!-- 			<td><?php echo $shprequisitions[$i]['total']; ?> </td> -->
			<td></td>
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
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center">
		<?php
		if($obj->status==0 and empty($ob->approve)){
		?>
		<input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">
		&nbsp;<input type="submit" name="action" id="action" value="Cancel" class="btn btn-danger" onclick="window.top.hidePopWin(true);"/></td>
		<?php
		}
		?>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center">
		<?php
		  if($obj->status==0 and empty($ob->approve)){
		?>
		<input type="submit" class="btn btn-info" name="action" id="action" value="Submit for Approval" />
		<?php
		}
		?>
		<input type="button" class="btn btn-default" name="action" id="action" value="Print" onclick="Clickheretoprint();"/>
		<?php
		if($obj->status==2 and !empty($ob->action)){
		  ?>
		  <input type="submit" class="btn btn-info" name="action" id="action" value="TRANSFER" />
		  <input type="submit" class="btn btn-success" name="action" id="action" value="ISSUE" />
		  <?php
		}
		?>
		</td>
	</tr>
	</table>
	<?php }?>
	
	<?php if(!empty($obj->retrieve)){
	      $issuance=new Issuance();
	      $where=" where requisitionno='$obj->documentno' ";
	      $fields="*";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $issuance->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	      
	      $requisitions=new Requisitions();
	      $where=" where documentno='$obj->documentno' ";
	      $fields="*";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $requisitions->sql;
	      $requisitions=$requisitions->fetchObject;
	?>
	<tr>
		<td colspan="2" align="center"><?php if($requisitions->status==0){ ?><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>"><?php } ?>&nbsp;<input class="btn btn-warning" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><?php if($issuance->affectedRows==0 and $requisitions->status==0 and $requisitions->createdby==$_SESSION['userid']){ ?><input type="submit" class="btn btn-danger" name="action" id="action" value="Revoke" /><?php } if($requisitions->status==1){ ?><input type="submit" name="action" id="action" class="btn btn-primary" value="ISSUE" /><?php } ?><input class="btn btn-default" type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if (!empty($error)) {
    showError($error);


    if ($saved == "Yes") {
        ?>
<script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
<?
//$obj="";
//$_SESSION['crshop']="";
redirect("addrequisitions_proc.php?retrieve=");
}

}


?>