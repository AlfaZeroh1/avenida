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
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
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
	}
  });

});
<?php include'js.php'; ?>
</script>
 <script type="text/javascript" charset="utf-8">
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
<form  id="theform" action="addrequisitions_proc.php" name="requisitions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
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
			<tr>
		<td colspan="2" align="center">
		<input type="submit" name="action" value="First" class="btn btn-info"/>
		<input type="submit" name="action" value="Next" class="btn btn-info"/>
		<input type="submit" name="action" value="Previous" class="btn btn-info"/>
		<input type="submit" name="action" value="Last" class="btn btn-info"/>
		</td>
	</tr>
			<tr>
				<td align="right">Department:</td>
				<td align="left"><input type="hidden" name="departmentid" id="departmentid" value="<?php echo $obj->departmentid; ?>"/><strong>
				<?php
				 $departments=new Departments();
					$where=" where id='$obj->departmentid' ";
					$fields="inv_departments.id, inv_departments.name, inv_departments.code, inv_departments.remarks, inv_departments.createdby, inv_departments.createdon, inv_departments.lasteditedby, inv_departments.lasteditedon, inv_departments.ipaddress";
					$join="";
					$having="";
					$groupby="";
					$orderby="";
					$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$departments = $departments->fetchObject;
					echo $departments->name;
				?></strong>
				
				</td>
				<td><label>Requested By:</label></td>
		<td><input type="hidden" name="employeeid" id="employeeid" size="20"  value="<?php echo $obj->employeeid; ?>">	
		<input type="text" <?php if(!empty($obj->retrieve)){echo "readonly";}?> name="employeename" id="employeename" size="32"  value="<?php echo $obj->employeename; ?>">
		</td>
			</tr>		
			
		</table>
	<table style="clear:both" id="tbl" cellpadding="0" align="center" width="100%" cellspacing="0">
	<tr>
	        <th >Inventory Item  </th>
		<th>UoM</th>
		<th >Quantity  </th>
		<th>Memo</th>
		<th >Required On  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='32' name='itemname'  onchange="calculateTotal();;" onblur="calculateTotal();;"  id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>		
			<input type='hidden' name='costprice' id='costprice'  size='4' readonly value='<?php echo $obj->costprice; ?>'/>
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
		</td>
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();;" onblur="calculateTotal();;"  size="16" value="<?php echo $obj->quantity; ?>"></td>
		<td><textarea name="memo" ><?php echo $obj->memo; ?></textarea></td>
		<td><input type="text" name="requiredon" id="requiredon" class="date_input" size="12" readonly  value="<?php echo $obj->requiredon; ?>"><font color='red'>*</font></td>
	<td><input type="hidden" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Requisition No:<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>">
		Requisition Date:<input type="date" name="requisitiondate" id="requisitiondate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->requisitiondate; ?>">
		Description:<textarea name="description" id="description"><?php echo $obj->description; ?></textarea>
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
		LPO No: <font color="red"><?php echo $documentno; ?></font>
		<?php } ?>
			</td>
			</tr>
		</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if(!empty($obj->retrieve)){?>
		<th>&nbsp;</th>
		<?php }?>
		<th align="left">Inventory Item  </th>
		<th align="left">Quantity  </th>
		<th>UoM</th>
		<?php if(!empty($obj->retrieve)){?>
		<th>Ordered</th>
		<th>LPO No</th>
		<th>Delivered</th>
		<?php }?>
		<th>Memo</th>
		<th align="left">Required On  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shprequisitions']){
		$shprequisitions=$_SESSION['shprequisitions'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shprequisitions[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<?php if(!empty($obj->retrieve)){?>
			<td><input type="checkbox" name="<?php echo $shprequisitions[$i]['id']; ?>" <?php if($shprequisitions[$i]['ordered']>=$shprequisitions[$i]['quantity']){echo"disabled";}?>/></td>
			<?php }?>
			<td><?php echo $shprequisitions[$i]['itemname']; ?> </td>
			<td><?php echo $shprequisitions[$i]['quantity']; ?> </td>
			<td><?php echo $shprequisitions[$i]['unitofmeasurename']; ?> </td>
			<?php if(!empty($obj->retrieve)){?>
			<td><?php echo $shprequisitions[$i]['ordered']; ?> </td>
			<td><a href="../../proc/purchaseorders/addpurchaseorders_proc.php?retrieve=1&documentno=<?php echo $shprequisitions[$i]['lpono']; ?>"><?php echo $shprequisitions[$i]['lpono']; ?></a></td>
			<td><?php echo $shprequisitions[$i]['delivered']; ?> </td>
			<?php }?>
			<td><?php echo $shprequisitions[$i]['memo']; ?> </td>
			<td><?php echo $shprequisitions[$i]['requiredon']; ?> </td>
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
	<!--<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo $total; ?>"/></td>
	</tr>-->
	
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/>
		<input type="submit" name="action" id="action" value="Raise LPO" /></td>
	</tr>
	
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
	redirect("addrequisitions_proc.php?retrieve=");
}

?>