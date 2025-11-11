<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
include "../../../head.php";

?>
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
		$("#costprice").val(ui.item.costprice);
		$("#stock").val(ui.item.stock);
	}
  });

 });
 
 function getTotal(qnt){
  var total = 0;
  var cost = $("#costprice").val();
  total = qnt*cost;
  $("#total").val(total);
 }
 
 function placeCursorOnPageLoad()
{
	$("#itemname").focus();
		
}
womAdd("placeCursorOnPageLoad()");
womOn();
 </script>

 <script type="text/javascript">
function init() {
	shortcut.add("F4", function() {
		document.cashsales.actiontxt.value="Save Sale";
		document.cashsales.action.visible=false;
		document.cashsales.submit();
	});
	shortcut.add("Ctrl+b", function() {
	
	var obj = document.activeElement;
	var tabindex = obj.tabIndex;
		for (i = 0; i < document.cashsales.elements.length; i++){
		if (document.cashsales.elements[i].tabIndex == tabindex-1) 
		{
			document.cashsales.elements[i].focus();
			if (document.cashsales.elements[i].type == "text")
				document.cashsales.elements[i].select();
			break;
		}}
	});
}
womAdd('init()');

</script>

<div class="content">
<form class="forms" id="theform" action="addstocktakes_proc.php" name="stocktakes" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
				<td align="right">Stock Take No. : </td>
				<td><input type='text' readonly size='20' tabindex='1' name='documentno' id='documentno' value='<?php echo $obj->documentno; ?>'></td>
	</tr>
	<tr>
		<td align="right">Opened On : </td>
		<td><input type="text" name="openedon" id="openedon" class="date_input" size="12" readonly  value="<?php echo $obj->openedon; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Closed On : </td>
		<td><input type="text" name="closedon" id="closedon" class="date_input" size="12" readonly  value="<?php echo $obj->closedon; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks" id="remarks"><?php echo $obj->total; ?></textarea>
<!-- 		<input type="hidden" name="status" id="status" value="<?php echo $obj->status; ?>"> -->
		</td>
	</tr>
	  <td align="right">Status : </td>
		<td><input type="radio" name="status" id="status" value="Active" <?php if($obj->status=="Active"){echo "checked";}?> /> Active &nbsp; <input type="radio" name="status" id="status" value="Closed" <?php if($obj->status=="Closed"){echo "checked";}?> /> Closed</td>
	<tr>
	  
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" tabindex='3' class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>