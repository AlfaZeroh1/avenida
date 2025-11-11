<title>WiseDigits ERP: Sales </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">

$().ready(function() {
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
		$("#code").val(ui.item.code);
		$("#retailprice").val(ui.item.retailprice);
		$("#tradeprice").val(ui.item.tradeprice);
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

  $("#agentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=agents&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#agentid").val(ui.item.id);
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

<div class='content'>
<form  id="theform" action="addsales_proc.php" name="sales" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			
		</table>
	
	<table align='center'>
			<tr>
			<td><input type="hidden" name="currencyid" id="currencyid"  readonly  size="6"  value="<?php echo $obj->currencyid; ?>">
			<input type="hidden" name="exchangerate" id="exchangerate"  readonly  size="6"  value="<?php echo $obj->exchangerate; ?>">
			<input type="hidden" name="exchangerate2" id="exchangerate2"  readonly  size="6"  value="<?php echo $obj->exchangerate2; ?>">
		Document No:<input type="text" name="documentno" id="documentno"  readonly  size="6"  value="<?php echo $obj->documentno; ?>">
		Sold On:<input type="date" name="soldon" id="soldon"  class="date_input" size="8" readonly  value="<?php echo $obj->soldon; ?>">
		
		Mode:<select name='mode'  class="selectbox" readonly>
			<option value='cashretail' <?php if($obj->mode=='cashretail'){echo"selected";}?>>cashretail</option>
		</select>
			</td>
			</tr>
	</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Product  </th>
		<th align="left">Qty</th>
		<th align="left">Price</th>
		<th align="left">Total</th>
		<th align="left">Memo <input type="text" id="iterator" name="iterator" value="<?php echo $obj->iterator; ?>"/> </th>
	</tr>
</thead>
	<tbody>
	<?php
	if($_SESSION['shpsales']){
		$shpsales=$_SESSION['shpsales'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$total+=$shpsales[$i]['total'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpsales[$i]['itemname']; ?> </td>
			<td><?php echo $shpsales[$i]['quantity']; ?> </td>
			<td><?php echo $shpsales[$i]['retailprice']; ?> </td>
			<td><?php echo $shpsales[$i]['total']; ?> </td>
			<td><?php echo $shpsales[$i]['memo']; ?> </td>
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
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<!--<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>-->
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
	redirect("addsales_proc.php?mode=".$obj->mode."&retrieve=");
}

?>