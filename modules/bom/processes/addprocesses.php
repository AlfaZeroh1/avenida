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
 } );
 </script>

<div class="panel-body">
<div class="tab-content">
<div id="tabs-1" class="tab-pane active">
<form class="forms" id="theform" action="addprocesses_proc.php" name="processes" method="POST" enctype="multipart/form-data">
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
		<td align="right">Estimation : </td>
			<td><select name="estimationid" class="selectbox">
<option value="">Select...</option>
<?php
	$estimations=new Estimations();
	$where="  ";
	$fields="bom_estimations.id, inv_items.name, bom_estimations.itemid, bom_estimations.prc, bom_estimations.createdby, bom_estimations.createdon, bom_estimations.lasteditedby, bom_estimations.lasteditedon, bom_estimations.ipaddress";
	$join=" left join inv_items on inv_items.id=bom_estimations.itemid ";
	$having="";
	$groupby="";
	$orderby="";
	$estimations->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($estimations->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->estimationid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Processed On : </td>
		<td><input type="text" name="processedon" id="processedon" class="date_input" size="12" readonly  value="<?php echo $obj->processedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"></td>
	</tr>
	<tr>
		<td align="right">Actual : </td>
		<td><input type="text" name="actual" id="actual" size="8"  value="<?php echo $obj->actual; ?>"></td>
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