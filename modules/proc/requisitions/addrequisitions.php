<title>WiseDigits ERP: Requisitions </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
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


  $("#projectname").autocomplete({
	source:"../../../modules/server/server/search.php?main=con&module=projects&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectid").val(ui.item.id);
	}
  });

  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name&where=status='Active'&extra=sum(inv_branchstocks.quantity)&extratitle=quantity&join=left join inv_branchstocks on inv_branchstocks.itemid=inv_items.id&groupby=group by inv_items.id",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
		$("#costprice").val(ui.item.costprice);
		$("#unitofmeasureid").val(ui.item.unitofmeasureid);
		$("#available").val(ui.item.quantity/ui.item.package);
		
		$("#package").val(ui.item.package);
		
		var packages = parseFloat(ui.item.package);
		if(packages>1){
		  $("#wquantity").prop("readonly",false);
		}
		
		//get consumption
		$.post("getConsumption.php",{itemid:ui.item.id},function(data){
		
            $("#consumption").val(data);
		
		})
	}
  });


  $("#categoryname").autocomplete({
	source:"../../../modules/server/server/search.php?main=assets&module=categorys&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#categoryid").val(ui.item.id);
		$("#costprice").val(ui.item.costprice);
	}
  });

 
  $("#expensename").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=expenses&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#expenseid").val(ui.item.id);
	}
  });

 
});

function getPieces(){
  var wholes = parseFloat($("#wquantity").val());
  var packages = parseFloat($("#package").val());
  
  var pieces = wholes*packages;
  
  $("#quantity").val(pieces);
  calculateTotal();
}

function chechType(id){
  $("#itemid").val();
  $("#categoryid").val();
  $("#expenseid").val();
  $('#available').hide();
  
  var categorys=document.getElementById("categorydiv");
  var items=document.getElementById("itemdiv");
  var expenses=document.getElementById("expensediv");
  if(id==""){
    categorys.style.display="none";
    items.style.display="none";
    expenses.style.display="none";
  }else if(id==1){
    categorys.style.display="block";
    items.style.display="none";
    expenses.style.display="none";
  }else if(id==2){
    categorys.style.display="none";
    items.style.display="block";
    $('#available').show();
    expenses.style.display="none";
  }else if(id==3){
    categorys.style.display="none";
    items.style.display="none";
    expenses.style.display="block";
  }else{
    categorys.style.display="none";
    items.style.display="none";
    expenses.style.display="none";
  }
 }
 womAdd('chechType("<?php echo $obj->typeid; ?>")');
 womOn();
function changeValue(field,id,value){
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
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  <?php $rules= new Rules (); ?>
  var url="set.php?i="+id+"&val="+value+"&field="+field;
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
  
}

<?php include 'js.php'; ?>
</script>


<div class="content">
<form  id="theform" action="addrequisitions_proc.php" name="requisitions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="table" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<!--<tr>
				<td><label>Project:</label></td>
				<td><textarea name='projectname' id='projectname'><?php echo $obj->projectname; ?></textarea>
					<input type="hidden" name='projectid' id='projectid' value='<?php echo $obj->projectid; ?>'></td>
			</td>
			</tr>-->
			<?php if(!empty($obj->retrieve)){?>
			<tr>
		<td colspan="4" align="center">
		<input type="checkbox" name="status" value="1" <?php if($obj->status==1){echo "checked";}?>/>Approved
		<input type="submit" name="action" value="First" class="btn btn-info"/>
		<input type="submit" name="action" value="Next" class="btn btn-info"/>
		<input type="submit" name="action" value="Previous" class="btn btn-info"/>
		<input type="submit" name="action" value="Last" class="btn btn-info"/>
		</td>
	</tr>
	<?php }?>
			<tr>
			
				<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox">
			<option value="">Select...</option>
			<?php
				$departments=new Departments();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby=" order by name ";
				$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($departments->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
			</select>
					</td>
				<td><label>Requested By:</label></td>
		<td><input type="hidden" name="employeeid" id="employeeid" size="20"  value="<?php echo $obj->employeeid; ?>">	
		<input type="text" <?php if(!empty($obj->retrieve)){echo "readonly";}?> name="employeename" id="employeename" size="32"  value="<?php echo $obj->employeename; ?>">
		</td>
			</tr>		
			
		</table>
	<table style="clear:both" class="table" cellpadding="0" align="center" width="100%" cellspacing="0">
	<tr>
	        <th>&nbsp;</th>
	        <th >Inventory Item/Asset  </th>
		<th>UoM</th>
		<th >Qnt (W) </th>
		<th >Qnt (P) </th>
		<th>Consumption</th>
		<th >Cost price  </th>
		<th>Memo</th>
		<th >Required On  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
	        <td><select name="typeid" id="typeid" onchange="chechType(this.value);">
		    <option value="">Select...</option>
			  <option value="1" <?php if($obj->typeid==1){echo "selected";}?>>Assets Category</option>
			  <option value="2" <?php if($obj->typeid==2){echo "selected";}?>>Items</option>
			  <option value="3" <?php if($obj->typeid==3){echo "selected";}?>>Expense</option>
		    </select>
		</td>
		<td>
		<div id="itemdiv">
		<input type='text' size='32' name='itemname'  onchange="calculateTotal();;" onblur="calculateTotal();;"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>
		</div>
		<div id="categorydiv">
		   <input type='text' size='32' name='categoryname'  onchange="calculateTotal();;" onblur="calculateTotal();;"  id='categoryname' value='<?php echo $obj->categoryname; ?>'>
			<input type="hidden" name='categoryid' id='categoryid' value='<?php echo $obj->categoryid; ?>'>
		    </select>
		</div>
		
		<div id="expensediv">
		   <input type='text' size='32' name='expensename'  onchange="calculateTotal();;" onblur="calculateTotal();;"  id='expensename' value='<?php echo $obj->expensename; ?>'>
			<input type="hidden" name='expenseid' id='expenseid' value='<?php echo $obj->expenseid; ?>'>
		    </select>
		</div>
		
		</td>		
		<td>
		<select name="unitofmeasureid" id="unitofmeasureid" class="selectbox">
<option value="">Select...</option>
<?php
	$unitofmeasures=new Unitofmeasures();
	$where="  ";
	$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($unitofmeasures->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->unitofmeasureid==$rw->id){echo "selected";}?>><?php echo $rw->name;?></option>
	<?php
	}
	?>
</select>
		</td>
		<td>
		<input type="hidden" name="package" id="package" value="<?php echo $obj->package; ?>"/>
		<input type="text" name="wquantity" id="wquantity" readonly onchange="getPieces();" onblur="getPieces();"  size="6" value="<?php echo $obj->wquantity; ?>"></td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();;" onblur="calculateTotal();;"  size="16" value="<?php echo $obj->quantity; ?>">
		<input type="text" style="display: none" readonly name='available' size='4' id='available' value="<?php echo $obj->available; ?>" />
		</td>
		<td><input type='text' name='consumption' id='consumption'  size='4' readonly value='<?php echo $obj->consumption; ?>'/></td>
		<td><input type='text' name='costprice' id='costprice'  size='4' readonly value='<?php echo $obj->costprice; ?>'/></td>
		<td><textarea name="memo" ><?php echo $obj->memo; ?></textarea></td>
		<td><input type="text" name="requiredon" id="requiredon" class="date_input" size="12" readonly  value="<?php echo $obj->requiredon; ?>"></td>
		<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
		<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center' class="table">
			<tr>
			<td>Requisition No:</td>
			<td><input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>"></td>
			<td>Requisition Date:</td>
			<td><input type="date" name="requisitiondate" id="requisitiondate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->requisitiondate; ?>"></td>
			<td>Approved On:</td>
			<td><input type="text" name="approvedon" id="approvedon" size="18" readonly  value="<?php echo $obj->approvedon; ?>"></td>
			<td>Description:</td>
			<td><textarea name="description" id="description"><?php echo $obj->description; ?></textarea></td>
		<?php if(!empty($obj->retrieve)){
		$purchaseorders=new Purchaseorders();
		$where=" where requisitionno='$obj->documentno' ";
		$fields=" documentno ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$documentno="";
		if($purchaseorders->affectedRows>0){
		  $num = $purchaseorders->affectedRows;
		  $i=0;
		  while($row=mysql_fetch_object($purchaseorders->result)){$i++;
		    $documentno.="<a href='../../proc/purchaseorders/addpurchaseorders_proc.php?documentno=".$row->documentno."&retrieve=1'>".$row->documentno."</a>";
		    if($i<$num)
		      $documentno.=", ";
		  }
		}
		else
		  $documentno="No LPO";
		?>
		      <td>LPO No: <font color="red"><?php echo $documentno; ?></font></td>
		<?php } ?>
			
			</tr>
		</table>
<table style="clear:both" class="table display" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if(!empty($obj->retrieve)){?>
		<th>&nbsp;</th>
		<?php }?>
		<th align="left">Inventory Item </th>
		<th align="left">Opening Stock  </th>
		<th align="left">Purchases/Additions  </th>
		<th align="left">Transfers  </th>
		<th align="left">Total  </th>
		<th align="left">Balance  </th>
		<th align="left">Consumption  </th>
		<th align="left">Ordered  </th>
		<th align="right">APPROVED  </th>
		<th align="left">Unit Price  </th>
		<th align="left">Total </th>
		<!--<th>UoM</th>
		<?php if(!empty($obj->retrieve)){?>
		<th>Ordered</th>
		<th>LPO No</th>
		<th>Delivered</th>
		<?php }?>
		<th>Memo<input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>-->
		<th align="left">Required On  </th>
		<?php
		  //Authorization.
		  $auth->roleid="8369";//View
		  $auth->levelid=$_SESSION['level'];

		  if(existsRule($auth)){
		  ?>
		<th>&nbsp;</th>
		<?php
		}
		  //Authorization.
		  $auth->roleid="8370";//View
		  $auth->levelid=$_SESSION['level'];

		  if(existsRule($auth)){
		  ?>
		<th>&nbsp;</th>
		<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shprequisitions']){//print_r($_SESSION['shprequisitions']);
		$shprequisitions=$_SESSION['shprequisitions'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		$delivered=0;
		$query="select sum(quantity) quantity from proc_inwarddetails where inwardid in(select id from proc_inwards where lpono in(".$shprequisitions[$i]['lpono'].")) and itemid='".$shprequisitions[$i]['itemid']."'"; 
		$deliv=mysql_fetch_object(mysql_query($query));

		$total+=$shprequisitions[$i]['total'];
		$delivered=$deliv->quantity;
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<?php if(!empty($obj->retrieve)){?>
			<td><input type="checkbox" name="<?php echo $shprequisitions[$i]['id']; ?>" <?php if($shprequisitions[$i]['ordered']>=$shprequisitions[$i]['quantity']){ echo"disabled"; }?>/></td>
			<?php }?>
			<td><?php if(!empty($shprequisitions[$i]['itemid']))echo $shprequisitions[$i]['itemname'];else echo $shprequisitions[$i]['categoryname'].$shprequisitions[$i]['expensename']; ?> </td>
			<td><?php echo getQntPackage($shprequisitions[$i]['package'],$shprequisitions[$i]['opening']); ?> </td>
			<td><?php echo getQntPackage($shprequisitions[$i]['package'],$shprequisitions[$i]['additions']); ?> </td>
			<td><?php echo getQntPackage($shprequisitions[$i]['package'],$shprequisitions[$i]['transfers']); ?> </td>
			<td><?php echo getQntPackage($shprequisitions[$i]['package'],$shprequisitions[$i]['totals']); ?> </td>
			<td><?php echo getQntPackage($shprequisitions[$i]['package'],$shprequisitions[$i]['available']); ?> </td>
			<td><?php echo getQntPackage($shprequisitions[$i]['package'],$shprequisitions[$i]['consumption']); ?> </td>
			<td><?php echo getQntPackage($shprequisitions[$i]['package'],$shprequisitions[$i]['quantity']); ?> </td>
			<td><input type="text" size="3" onChange="changeValue('toorder','<?php echo $i; ?>',this.value);" name="quantity<?php echo $i; ?>" id="quantity<?php echo $i; ?>" value="<?php echo getQntPackage($shprequisitions[$i]['package'],($shprequisitions[$i]['quantity']-$shprequisitions[$i]['ordered'])); ?>"/> </td>
			<td><?php echo formatNumber($shprequisitions[$i]['costprice']); ?> </td>
			<td><?php echo formatNumber($shprequisitions[$i]['total']); ?> </td>
			<!--<td><?php echo $shprequisitions[$i]['unitofmeasurename']; ?> </td>
			<?php if(!empty($obj->retrieve)){?>
			<td><?php echo $shprequisitions[$i]['ordered']; ?> </td>
			<td><a href="../../proc/purchaseorders/addpurchaseorders_proc.php?retrieve=1&documentno=<?php echo $shprequisitions[$i]['lpono']; ?>"><?php echo $shprequisitions[$i]['lpono']; ?></a></td>
			<td><?php echo $delivered; ?> </td>
			<?php }?>
			<td><?php echo $shprequisitions[$i]['memo']; ?> </td>-->
			<td><?php echo $shprequisitions[$i]['requiredon']; ?> </td>
			<?php
			//Authorization.
			$auth->roleid="8369";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			<?php } ?>
			<?php
			//Authorization.
			$auth->roleid="8370";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
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
	
	<?php
	//Authorization.
			$auth->roleid="8369";//View
			$auth->levelid=$_SESSION['level'];

			
	if($obj->status!=1 or existsRule($auth)){
	?>
	<tr>
		<td colspan="2" align="center">
		<?php if(!empty($obj->retrieve) and $obj->status!=2){ ?>
		  <input class="btn btn-info" type="submit" name="action" id="action" value="Submit for Approval"/>
		<?php } ?>
		<input type="submit" class="btn btn-primary" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-warning" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php 
	}
	if(!empty($obj->retrieve)){?>
	<?php
		if($obj->status==1){
		?>
	<tr>
		<td colspan="2" align="center"><input type="button" class="btn btn-primary" name="action" id="action" value="Print" onclick="Clickheretoprint();"/>&nbsp;
		<?php
		  //Authorization.
		  $auth->roleid="8067";//View
		  $auth->levelid=$_SESSION['level'];
				  
		  if(existsRule($auth)){
		  ?>
		  <input class="btn btn-warning" type="submit" name="action" id="action" value="Cash Purchase" onclick="window.top.hidePopWin(true);"/>&nbsp;
		  <input type="submit" name="action" id="action" class="btn btn-ok" value="Raise LPO" />
		  <?php } ?>
		</td>
	</tr>
	<?php
		}
		?>
	<?php }?>
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
if($saved=="Yes"){
	redirect("addrequisitions_proc.php?retrieve=&departmentid=".$obj->departmentid);
}

?>
