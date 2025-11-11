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

<div class="panel-body">
<div class="tab-content">
<div id="tabs-1" class="tab-pane active">
<form class="forms" id="theform" action="addteampayments_proc.php" name="teampayments" method="POST" enctype="multipart/form-data">
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
		<td align="right">Team Detail : </td>
		<td><input type="text" name="teamdetailid" id="teamdetailid" value="<?php echo $obj->teamdetailid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="cashier" id="cashier" value="<?php echo $obj->cashier; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="brancheid" id="brancheid" value="<?php echo $obj->brancheid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Payment Mode : </td>
		<td><input type="text" name="paymentmodeid" id="paymentmodeid" value="<?php echo $obj->paymentmodeid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Bank : </td>
		<td><input type="text" name="bankid" id="bankid" value="<?php echo $obj->bankid; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="imprestaccountid" id="imprestaccountid" value="<?php echo $obj->imprestaccountid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
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