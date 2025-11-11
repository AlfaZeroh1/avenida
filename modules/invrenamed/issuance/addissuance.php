<title>WiseDigits: Issuance </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
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
		$("#code").val(ui.item.code);
		$("#available").val(ui.item.available);
		$("#costprice").val(ui.item.costprice);
	}
  });

  $("#departmentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=departments&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#departmentid").val(ui.item.id);
	}
  });

  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))&join=left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid",
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

function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?documentno=<?php echo $obj->documentno; ?>&departmentid=<?php echo $obj->departmentid; ?>&employeeid=<?php echo $obj->employeeid; ?>",450,940);
	}
}
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

<hr>
<div class="content">
<form  id="theform" action="addissuance_proc.php" name="issuance" method="POST" enctype="multipart/form-data">
	<table width="100%" class="table titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="text" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Department:</label></td>
<td><select name="departmentid" id="departmentid" class="selectbox" >
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>			</td>
			</tr>
			<tr>
				<td><label>Member of Staff:</label></td>
				<td><input type='text' size='65' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'></td>
			</tr>
		</table>
	<table width="100%" class="table titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Product  </th>
		<th align="right">Product Code  </th>
		<th align="right">Quantity  </th>
		<th align="right">Available  </th>
		<th align="right">Rate  </th>
		<th align="right">Purpose  </th>
		<!--<th align="right">Block  </th>
		<th align="right">Section  </th>
		<th align="right">Green House  </th>
		<th align="right">Vehicle  </th>-->
		<th>Total</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='20' name='itemname'  id='itemname' onchange="calculateTotal();;" onblur="calculateTotal();;" value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'>		<td>
		<input type='text' name='code' id='code'  size='8' readonly value='<?php echo $obj->code; ?>'/>
		</td>

		</td>
		<td><input type="text" name="quantity" id="quantity" onchange="calculateTotal();;" onblur="calculateTotal();;" size="5" value="<?php echo $obj->quantity; ?>"><input type="hidden" name="quantitys" id="quantitys" size="5" value="<?php echo $obj->quantity; ?>"></td>
		<td><input type="text" name="available" readonly id="available" size="4" value="<?php echo $obj->available; ?>"></td>
		<td><input type="text" name="costprice" id="costprice" onchange="calculateTotal();;" onblur="calculateTotal();;"  size="5" value="<?php echo $obj->costprice; ?>"></td>
		<td><textarea name="purpose" id="purpose"><?php echo $obj->purpose; ?></textarea></td>
		<!--<td><select name="blockid"  class="selectbox">
<option value="">Select...</option>
<?php
	$blocks=new Blocks();
	$where="  ";
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($blocks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->blockid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><select name="sectionid"  class="selectbox">
<option value="">Select...</option>
<?php
	$sections=new Sections();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($sections->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->sectionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td><select name="greenhouseid"  class="selectbox">
<option value="">Select...</option>
<?php
	$greenhouses=new Greenhouses();
	$where="  ";
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
	?>
</select>
		</td>
	<td><select name="fleetid"  class="selectbox">
<option value="">Select...</option>
<?php
	$fleets=new Fleets();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($fleets->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->greenhouseid==$rw->id){echo "selected";}?>><?php echo strtoupper($rw->assetid);?></option>
	<?php
	}
	?>
</select>
		</td>-->
	<td><input type="text" name="total" id="total" size='8' readonly value="<?php echo $obj->total; ?>"/></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
		<?php 		
		$currencys=new Currencys();
		$where=" where id='5' ";
		$fields="id,rate,eurorate";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $currencys->sql;
		$currencys=$currencys->fetchObject;
		$obj->currencyid=$currencys->id;
		$obj->rate=$currencys->rate;
		$obj->eurorate=$currencys->eurorate;
		?>
			<tr>
			<td>Issued On:</td>
			<td><input type="date" name="issuedon" id="issuedon"  class="date_input" size="12" readonly  value="<?php echo $obj->issuedon; ?>"><input type="hidden" name="currencyid" id="currencyid" value="<?php echo $obj->currencyid; ?>"><input type="hidden" name="rate" id="rate" value="<?php echo $obj->rate; ?>"><input type="hidden" name="eurorate" id="eurorate" value="<?php echo $obj->eurorate; ?>"></td>
			<td>Issue No:</td>
			<td><input type="text" name="documentno" id="documentno" readonly size="5"  value="<?php echo $obj->documentno; ?>"></td>
			<td>Requisition No:</td>
			<td><input type="text" name="requisitionno" id="requisitionno" readonly size="5"  value="<?php echo $obj->requisitionno; ?>"></td>
			<td>Memo:</td>
			<td><textarea name="memo" ><?php echo $obj->memo; ?></textarea></td>
			</tr>
		</table>
<table style="clear:both" class="table tgrid display" id="" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Product  </th>
		<th align="right">Category  </th>
		<th align="left">Quantity  </th>
		<th align="left">Rate  </th>
		<th align="left">Purpose  </th>
		<!--<th align="left">Block  </th>
		<th align="left">Section  </th>
		<th align="left">Green House  </th>-->
		<th align='left'>Total</th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	// print_r($_SESSION['shpissuance']);
		$shpissuance=$_SESSION['shpissuance'];
		$i=0;
		$j=count($_SESSION['shpissuance']);
		$total=0;
		while($j>0){
		$total+=$shpissuance[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpissuance[$i]['code']." ".$shpissuance[$i]['itemname']; ?> </td>
			<td><?php echo $shpissuance[$i]['categoryname']; ?> </td>
			<td><?php echo $shpissuance[$i]['quantity']; ?> </td>
			<td><?php echo formatNumber($shpissuance[$i]['costprice']); ?> </td>			
			<td><?php echo $shpissuance[$i]['purpose']; ?> </td>
			<!--<td><?php echo $shpissuance[$i]['blockname']; ?> </td>
			<td><?php echo $shpissuance[$i]['sectionname']; ?> </td>
			<td><?php echo $shpissuance[$i]['greenhousename']; ?> </td>-->
			<td align="right"><?php echo formatNumber($shpissuance[$i]['total']); ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	?>
	</tbody>
</table>
<table align="center" width="100%">
	<tr>
		<td colspan="2" align="center">Total:<input type="text" size='12' readonly value="<?php echo formatNumber($total); ?>"/></td>
	</tr>
	<?php if(empty($obj->retrieve)){ ?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="2" align="center">
		<?php 
		//Authorization.
		$auth->roleid="4772";//edit
		$auth->levelid=$_SESSION['level'];
		if(existsRule($auth)){ ?>
		<input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;
		<?php } ?>
		<input type="button" name="action" class="btn btn-primary" id="action" value="Print" onclick="Clickheretoprint();"/>
		<?php 
		//Authorization.
		$auth->roleid="759";//View
		$auth->levelid=$_SESSION['level'];
		if($obj->journals!='Yes' and existsRule($auth)){ ?>
		<input type="submit" class="btn btn-primary" name="action" id="action" value="Effect Journals"/>
		<?php } ?>
		</td>
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
?>
    <script language="javascript1.1" type="text/javascript">Clickheretoprint();</script>
    <?
	redirect("addissuance_proc.php?retrieve=");
}

?>