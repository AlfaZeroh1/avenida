<title>WiseDigits ERP: Packinglistreturns </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
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
		$("#remarks").val(ui.item.remarks);
		$("#address").val(ui.item.address);
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

  $("#fleetname").autocomplete({
	source:"../../../modules/server/server/search.php?main=assets&module=fleets&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#fleetid").val(ui.item.id);
	}
  });

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
	source:"../../../modules/server/server/search.php?main=pos&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

});
<?php include'js.php'; ?>
</script>
 <script type="text/javascript" charset="utf-8">
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
 
 function readBarcode(str){
  
  //str = str.substring(0,(str.length-1));
  document.getElementById("barcode").value=str;
  var st = str.split("-");
  
  document.getElementById("itemid").value=parseInt(st[0]);
  document.getElementById("sizeid").value=parseInt(st[1]);
  document.getElementById("quantity").value=st[2];  
}

$(document).ready(function(){
  $("#boxno").on("change", function(){
    var str = $("#boxno").val();
    var st = str.split("-");
    
    document.getElementById("customerid").value=parseInt(st[0]);
    document.getElementById("boxno").value=st[1];
    
    document.getElementById("barcode").focus();
    
    $.get("get.php",{id:st[0]},function(data){
	$("#customername").val(data);      
      });
     });
});

function readBarcode2(str){
  
  //str = str.substring(0,(str.length-1));
  document.getElementById("boxno").value=str;
  var st = str.split("-");
  
  document.getElementById("customerid").value=parseInt(st[0]);
  document.getElementById("boxno").value=st[1];
  
  document.getElementById("barcode").focus();
}
 
 function placeCursorOnPageLoad()
{
      if(document.getElementById("boxno").value=="")
	document.getElementById("boxno").focus();
      else	
	document.getElementById("barcode").focus();
		
}

function checkForm(form,event){
  iterator=$("#iterator").val();
  var target = event.explicitOriginalTarget || event.relatedTarget ||
        document.activeElement || {};

	 if(target.type=="text" && target.name=="barcode"){
      $.post( "addpackinglistreturns_proc.php", { action2: "Add", sizeid:$("#sizeid").val(), itemid:$("#itemid").val(), quantity:$("#quantity").val(), iterator:$("#iterator").val(), status:$("#status").val() } );

	
	tbl.fnAddData( [
		iterator+1,
		$("#itemid option:selected").text(),
		$("#sizeid option:selected").text(),
		$("#quantity").val(),
		$("#boxno").val(),
		$("#memo").val(),
		"",
		"" ] );
	
	iterator++;
	$("#barcode").val("");
	$("#barcode").focus();
	$("#iterator").val(iterator);
	return false;
    }
    else if(target.type=="text" && target.name=="boxno"){
      return false;
    }
    else{
      return true;
    }
 }

womAdd('placeCursorOnPageLoad()');
womOn();
 </script>
  <script type="text/javascript">
function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print PACKING LIST?";
	var ans=confirm(msg);
	if(ans)
	{
 		<?php $_SESSION['obj']=$obj; ?>
		poptastic('print.php?&doc=<?php echo $obj->documentno; ?>&customerid=<?php echo $obj->customerid; ?>&packedon=<?php echo $obj->packedon; ?>',700,1020);
	}
}
 </script>
 
<div class='main'>
<form  id="theform" action="addpackinglistreturns_proc.php" name="packinglistreturns" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this,event);">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center">
		<input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>
		
		Packing No:<input type="text" size="4" name="invoiceno"/>
		Box No:<input type="text" size="4" name="box"/>
		&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><input type="hidden" name="returns" value="<?php echo $obj->returns; ?>"/><label>Customer:</label></td>
				<td><input type='text' size='30' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'></td>
				<td><label>TelNo.:</label></td>
				<td><input type='text' name='tel' id='tel' size='20' readonly value='<?php echo $obj->tel; ?>'/></td>			<tr>
				<td><label>Remarks:</label></td>
				<td><textarea name='remarks' id='remarks' readonly><?php echo $obj->remarks; ?></textarea></td>
				<td><label>Address:</label></td>
				<td><textarea name='address' id='address' ><?php echo $obj->address; ?></textarea></td>			</td>
			</tr>
			<tr>
				<td><label>Box No:</label></td>
<td><input type="text" name="boxno" id="boxno" size="20"  value="<?php echo $obj->boxno; ?>" />			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th>&nbsp;</th>
		<th align="right">Product  </th>
		<th align="right">Size  </th>
		<th align="right">Quantity  </th>
		<th align="right">Memo  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type="text" name="barcode" id="barcode" onChange="readBarcode(this.value);"/>
		</td>
		<td><select name="itemid" id="itemid"  class="selectbox">
<option value="">Select...</option>
<?php
	$items=new Items();
	$where="  ";
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
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
		</td>
		<td><select name="sizeid" id="sizeid"  class="selectbox">
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
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" size="16" value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		Document No:<input type="text" name="documentno" id="documentno" readonly size="16"  value="<?php echo $obj->documentno; ?>">
		Packing No:<input type="text" name="packingno" id="packingno" size="16"  value="<?php echo $obj->packingno; ?>">
		Order No:<input type="text" name="orderno" id="orderno"  size="16"  value="<?php echo $obj->orderno; ?>">
		Returned On:<input type="date" name="packedon" id="packedon" readonly class="date_input" size="16" readonly  value="<?php echo $obj->packedon; ?>">
		Vehicle:				<select name='fleetid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$fleets=new Fleets();
				$fields="assets_fleets.id, assets_fleets.assetid, assets_fleets.fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleets.fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleets.fleetfueltypeid, assets_fleets.fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, assets_fleets.employeeid, assets_fleets.departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($fleets->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
		Employee:				<select name='employeeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$employees=new Employees();
				$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($employees->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
			</td>
			</tr>
		</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Product  </th>
		<th align="left">Size  </th>
		<th align="left">Quantity  </th>
		<th align="left">Box No  </th>
		<th align="left">Memo  </th>
		<th><input type="hidden" id="iterator" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shppackinglistreturns']){
		$shppackinglistreturns=$_SESSION['shppackinglistreturns'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shppackinglistreturns[$i]['itemname']; ?> </td>
			<td><?php echo $shppackinglistreturns[$i]['sizename']; ?> </td>
			<td><?php echo $shppackinglistreturns[$i]['quantity']; ?> </td>
			<td><?php echo $shppackinglistreturns[$i]['boxno']; ?> </td>
			<td><?php echo $shppackinglistreturns[$i]['memo']; ?> </td>
			<td><?php echo $shppackinglistreturns[$i]['total']; ?> </td>
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
		<input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">
		<!--<input type="submit" name="action3" id="action3" value="<?php echo $obj->action3; ?>">-->
		<!--<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/>-->
</td>
	</tr>
	<?php }else{?>
	<tr>
	  
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">
		<input  class="btn btn-primary" type="submit" name="action" id="action" value="Raise Invoice">
		<input  class="btn btn-primary" type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
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
<script type="text/javascript">Clickheretoprint(true);</script>
<?php 
	redirect("addpackinglistreturns_proc.php?retrieve=&next=".$next."&packing=".$packing);

}
?>
