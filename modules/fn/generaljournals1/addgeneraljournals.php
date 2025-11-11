<title>WiseDigits: Generaljournals </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#accountname").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=generaljournalaccounts&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#accountid").val(ui.item.id);
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

<div class='main'>
<form class="forms" id="theform" action="addgeneraljournals_proc.php" name="generaljournals" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="8" name="rjvno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Account  </th>
		<th align="right">Memo  </th>
		<th align="right">Debit  </th>
		<th align="right">Credit  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='30' name='accountname'  id='accountname' value='<?php echo $obj->accountname; ?>'>
			<input type="hidden" name='accountid' id='accountid' value='<?php echo $obj->accountid; ?>'>
		</td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
		<td><input type="text" name="debit" id="debit" size="8" value="<?php echo $obj->debit; ?>"></td>
		<td><input type="text" name="credit" id="credit" size="8" value="<?php echo $obj->credit; ?>"></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>
		JVNo No.:<input type="text" readonly name="jvno" id="jvno"  size="8"  value="<?php echo $obj->jvno; ?>">
		Transaction Date:<input type="date" name="transactdate" id="transactdate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->transactdate; ?>">
		
			</td>
			</tr>
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Account  </th>
		<th align="left">Memo  </th>
		<th align="left">Debit  </th>
		<th align="left">Credit  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpgeneraljournals']){
		$shpgeneraljournals=$_SESSION['shpgeneraljournals'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){

		$drtotals+=$shpgeneraljournals[$i]['debit'];
		$crtotals+=$shpgeneraljournals[$i]['credit'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpgeneraljournals[$i]['accountname']; ?> </td>
			<td><?php echo $shpgeneraljournals[$i]['memo']; ?> </td>
			<td align="right"><?php echo formatNumber($shpgeneraljournals[$i]['debit']); ?> </td>
			<td align="right"><?php echo formatNumber($shpgeneraljournals[$i]['credit']); ?> </td>
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
	<tfoot>
		<tr>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th><input type="text" readonly="readonly" size="4" name="drtotals" value="<?php echo formatNumber($drtotals); ?>"/></th>
		  <th><input type="text" readonly="readonly" size="4" name="crtotals" value="<?php echo formatNumber($crtotals); ?>"/></th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		</tr>
		
	</tfoot>
</table>
<table align="center" width="100%">
	
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>