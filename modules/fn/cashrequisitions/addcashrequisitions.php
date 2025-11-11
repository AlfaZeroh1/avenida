<title>WiseDigits ERP: Cashrequisitions </title>
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

 $("#projectname").autocomplete( "../../../modules/server/server/search.php?main=con&module=projects&field=name&where=id in(select projectid from auth_userprojects where userid='<?php echo $_SESSION['userid'];?>')",{
 	width: 260,
 	selectFirst: false
 });
		$("#projectid").val(ui.item.id);
	}
  });

});
<?php include'js.php'; ?>
</script>
<script>

function calculatetotal(){
    var qty = document.getElementById("quantity").value;
    var amnt = document.getElementById("amount").value;

    var total = qty*amnt;
     
     document.getElementById("total").value = total;

}




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
<form class="forms" id="theform" action="addcashrequisitions_proc.php" name="cashrequisitions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	
		<tr>
		<td><label>
		Requisition No:</label></td>
		<td>
		<input type="text" name="documentno" id="documentno" readonly size="8"  value="<?php echo $obj->documentno; ?>">
		<input type="hidden" name="status" value="<?php echo $obj->status; ?>"/>
		</td>
		  </tr>
			<!--<tr>
				<td><label>Project:</label></td>
				<td><input type='text' size='20' name='projectname' id='projectname' readonly value='<?php echo $obj->projectname; ?>'>
					<input type="hidden" name='projectid' id='projectid' value='<?php echo $obj->projectid; ?>'></td>
			</td>
			</tr>-->
			<tr>
				<td><label>Requested By:</label></td>
<td><input type="hidden" name="employeeid" id="employeeid" size="20"  value="<?php echo $obj->employeeid; ?>">	
<input type="text" name="employeename" id="employeename" size="32"  value="<?php echo $obj->employeename; ?>">
</td>
			</tr>
			<td>
		<label>Req Description:</label>			</td>
			<td>
<textarea name="description" id="description"><?php echo $obj->description; ?></textarea>			</td>
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Expense  </th>
		<th align="right">Quantity  </th>
		<th align="right">Amount  </th>
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="expenseid"  class="selectbox">
<option value="">Select...</option>
<?php
	$expenses=new Expenses();
	$where="  ";
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($expenses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->expenseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="amount" id="amount" onchange="calculatetotal()" size="8" value="<?php echo $obj->amount; ?>"></td>
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left" >&nbsp;</th>
		<th align="left">Expense  </th>
		<th align="left">Quantity  </th>
		<th align="left">Amount  </th>
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpcashrequisitions']){
		$shpcashrequisitions=$_SESSION['shpcashrequisitions'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpcashrequisitions[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><input type="checkbox" name="<?php echo $shppurchaseorders[$i]['id']; ?>"/></td>
			<td><?php echo $shpcashrequisitions[$i]['expensename']; ?> </td>
			<td><?php echo $shpcashrequisitions[$i]['quantity']; ?> </td>
			<td><?php echo $shpcashrequisitions[$i]['amount']; ?> </td>
			<td><?php echo $shpcashrequisitions[$i]['total']; ?> </td>
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
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' name="ttotal" id="ttotal" readonly value="<?php echo $total; ?>"/></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
	        <td colspan="2" align="center"><input type="submit" name="action" class="btn btn-warning" value="Give Imprest"/><input type="submit" name="action" class="btn btn-warning" value="Enter Expense"/>
		<input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
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
	redirect("addcashrequisitions_proc.php?retrieve=");
}

?>