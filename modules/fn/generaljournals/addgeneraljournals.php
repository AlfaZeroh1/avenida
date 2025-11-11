<title>WiseDigits: Generaljournals </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
function getExchangeRate(id)
{
	var xmlhttp;
	var transactdate = $("#transactdate").val();
	var url="../../sys/currencys/populate.php?id="+id+"&date="+transactdate;
        xmlhttp=new XMLHttpRequest();	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var data = xmlhttp.responseText;
			var dt = data.split("-");
			document.getElementById("exchangerate").value=dt[0];
			document.getElementById("exchangerate2").value=dt[1];
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function Clickheretoprint(jvno)
{ 
	var msg;
	msg="Do you want to print JV?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?jvno=<?php echo $obj->jvno; ?>",450,940);
	}
}
</script>
<script type="text/javascript">
$().ready(function() {
 $("#accountname").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=generaljournalaccounts&field=concat(concat(fn_generaljournalaccounts.code,' ',fn_generaljournalaccounts.name),'=>',sys_acctypes.name)&join=left join sys_acctypes on fn_generaljournalaccounts.acctypeid=sys_acctypes.id left join fn_generaljournalaccounts gna on gna.id=fn_generaljournalaccounts.categoryid",
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
 
 function setCurrency(rate,id){
  $.post("setCurrency.php",{id:id,rate:rate},function(data){
//     alert(data);
  });
 }
 </script>

<hr>
<div class="content">
<form class="forms" id="theform" action="addgeneraljournals_proc.php" name="generaljournals" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(true){ ?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="8" name="rjvno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<table width="100%" class="titems gridd table" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Account  </th>
		<th align="right">Memo  </th>
		<th>Currency</th>
		<th>Rate</th>
		<th align="right">Debit  </th>
		<th align="right">Credit  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input type='text' size='30' name='accountname'  id='accountname' value='<?php echo $obj->accountname; ?>'>
			<input type="hidden" name='accountid' id='accountid' value='<?php echo $obj->accountid; ?>'>
		</td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
		<td><select name="currencyid" class="selectbox" onchange="getExchangeRate(this.value);">
				<option value="">Select...</option>
				<?php
				$currencys = new Currencys();
				$fields="*";
				$join=" ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select></td>
		<td><input type="text" name="exchangerate" id="exchangerate"  size="12"  value="<?php echo $obj->exchangerate; ?>">
		<input type="text" name="exchangerate2" id="exchangerate2" size="12"   value="<?php echo $obj->exchangerate2; ?>">
		<input type="hidden" name="reconstatus" id="reconstatus" size="12"   value="<?php echo $obj->reconstatus; ?>">
		<input type="hidden" name="recontime" id="recontime" size="12"   value="<?php echo $obj->recontime; ?>">
		<input type="hidden" name="recondate" id="recondate" size="12"   value="<?php echo $obj->recondate; ?>">
		<input type="hidden" name="transactionid" id="transactionid" size="12"   value="<?php echo $obj->transactionid; ?>">
		<input type="hidden" name="remarks" id="remarks" size="12"   value="<?php echo $obj->remarks; ?>">
		<input type="hidden" name="balance" id="balance" size="12"   value="<?php echo $obj->balance; ?>">
			</td>
		<td><input type="text" name="debit" id="debit" size="8" value="<?php echo $obj->debit; ?>"></td>
		<td><input type="text" name="credit" id="credit" size="8" value="<?php echo $obj->credit; ?>"></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
		<table align='center'>
			<tr>
			<td>JVNo No.:<input type="text" readonly name="jvno" id="jvno"  size="8"  value="<?php echo $obj->jvno; ?>"></td>
		<td>Doc No.:</td><td><input type="text" name="documentno" id="documentno"  size="8"  value="<?php echo $obj->documentno; ?>"></td>
		<td>Cheque No.:</td><td><input type="text" name="chequeno" id="chequeno"  size="8"  value="<?php echo $obj->chequeno; ?>"></td>
		<td>Transaction Date:</td>
		<td><input type="date" name="transactdate" id="transactdate" readonly class="date_input" size="12" readonly  value="<?php echo $obj->transactdate; ?>">
			</td>
			
			</tr>
		</table>
<table style="clear:both" class="table display" id="" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Account  </th>
		<th align="left">Account Type </th>
		<th align="left">Currency  </th>
		<th align="left">Rate  </th>
		<th align="left">Memo  </th>
		<th align="left">Debit  </th>
		<th align="left">Credit  </th>
		<th align="left">Debit (Kshs) </th>
		<th align="left">Credit (Kshs) </th>
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

		$id = $shpgeneraljournals[$i]['id'];
		
		$drtotals+=$shpgeneraljournals[$i]['debit'];
		$crtotals+=$shpgeneraljournals[$i]['credit'];
		$drtotalkshs+=$shpgeneraljournals[$i]['debitkshs'];
		$crtotalkshs+=$shpgeneraljournals[$i]['creditkshs'];
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpgeneraljournals[$i]['accountname']; ?> </td>
			<td><?php echo $shpgeneraljournals[$i]['accounttype']; ?> </td>
			<td><?php echo $shpgeneraljournals[$i]['currencyname']; ?> </td>
			<td><input type="text" value="<?php echo $shpgeneraljournals[$i]['rate']; ?>" onChange="setCurrency(this.value,'<?php echo $id; ?>');"> </td>
			<td><?php echo $shpgeneraljournals[$i]['memo']; ?> </td>
			<td align="right"><?php echo formatNumber($shpgeneraljournals[$i]['debit']); ?> </td>
			<td align="right"><?php echo formatNumber($shpgeneraljournals[$i]['credit']); ?> </td>
			<td align="right"><?php echo formatNumber($shpgeneraljournals[$i]['debitkshs']); ?> </td>
			<td align="right"><?php echo formatNumber($shpgeneraljournals[$i]['creditkshs']); ?> </td>
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
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th><?php echo formatNumber($drtotals);?></th>
		  <th><?php echo formatNumber($crtotals);?></th>
		  <th><input type="text" readonly="readonly" size="4" name="drtotals" value="<?php echo formatNumber($drtotalkshs); ?>"/></th>
		  <th><input type="text" readonly="readonly" size="4" name="crtotals" value="<?php echo formatNumber($crtotalkshs); ?>"/></th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		</tr>
		
		
	</tfoot>
</table>
<table align="center" width="98%">
	
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
</hr>
<?php
if(!empty($error)){
	showError($error);
}
?>
