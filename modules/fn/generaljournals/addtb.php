<title>WiseDigits: Generaljournals </title>
<?php 
include "../../../headerpop.php";

?>

<script type="text/javascript">
$().ready(function() {
 $("#accountname").autocomplete("../../../modules/server/server/search.php?main=fn&module=generaljournalaccounts&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#accountname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("accountname").value=data[0];
     document.getElementById("accountid").value=data[1];
   }
 });
});
</script>

<form action="" method="post">
<table align="left">
	
	<tr>
	  <td>Account: </td>
	  <td><input type="hidden" name="id" value="<?php echo $obj->id; ?>">
	      <input type="text" size="64" name="account" readonly value="<?php echo $obj->account; ?>"/></td>
	</tr>
	<tr>
	  <td>Debit: </td>
	  <td><input type="text" name="debit" readonly value="<?php echo $obj->debit; ?>"/></td>
	</tr>
	<tr>
	  <td>Credit: </td>
	  <td><input type="text" name="credit" readonly value="<?php echo $obj->credit; ?>"/></td>
	</tr>
	<tr>
	  <td>System Account: </td>
	  <td><input type="hidden" name="accountid" id="accountid" value="<?php echo $obj->accountid; ?>">
	      <input type="text" name="accountname"  id="accountname" value="<?php echo $obj->accountname; ?>"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	
</table>
</form>
</hr>
<?php
if(!empty($error)){
	showError($error);
}
?>