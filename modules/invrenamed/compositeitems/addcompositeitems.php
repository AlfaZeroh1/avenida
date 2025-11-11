<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
$pop=1;
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
 	
 	$("#itemname2").autocomplete({
	      source:"../../../modules/server/server/search.php?main=inv&module=items&field=inv_items.name",
	      focus: function(event, ui) {
		      event.preventDefault();
		      $(this).val(ui.item.label);
	      },
	      select: function(event, ui) {
		      event.preventDefault();
		      $(this).val(ui.item.label);
		      $("#itemid2").val(ui.item.id);
	      }
	});
 } );
 </script>

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addcompositeitems_proc.php" name="compositeitems" method="POST" enctype="multipart/form-data">
	<table width="100%" class="table titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Product : </td>
			<td><input type="hidden" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>">
			<input type="hidden" name="itemname" id="itemname" value="<?php echo $obj->itemname; ?>"><?php echo $obj->itemname; ?></td>
		</td>
	</tr>
	
	<tr>
		<td align="right">Product : </td>
			<td><input type="hidden" name="itemid2" id="itemid2" value="<?php echo $obj->itemid2; ?>"/>
			<input type="text" name="itemname2" id="itemname2" value="<?php echo $obj->itemname2; ?>"/></td>
		</td>
	</tr>
	
	<tr>
		<td align="right">Point:</td>
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
			<option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->brancheid){echo "selected";}?>><?php echo strtoupper($rw->name); ?></option>
		      <?php
		      }
		      ?>
		    </select>
		</td>
	</tr>
	
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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