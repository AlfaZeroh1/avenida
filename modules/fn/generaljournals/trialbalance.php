<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournals_class.php");
require_once("../generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");

include "../../../head.php";

$db = new DB();



?>
<table id="example">
<thead>
  <tr>
    <th>#</th>
    <th>Account</th>
    <th>Debit</th>
    <th>Credit</th>
    <th>System Account</th>
    <th>Balance</th>
    <th>&nbsp;</th>
  </tr>
</thead>
<tbody>
  <?php
  $query="select tb.*, fn_generaljournalaccounts.name gn, fn_generaljournalaccounts.acctypeid from tb left join fn_generaljournalaccounts on tb.accountid=fn_generaljournalaccounts.id";
  $res=mysql_query($query);
  $i=0;
  while($row=mysql_fetch_object($res)){$i++;
    
    //get account balance as at 30th June 2016
    $query="select sum(gn.debit*rate) debit, sum(gn.credit*rate) credit , sys_acctypes.balance from fn_generaljournals gn left join fn_generaljournalaccounts gna on gn.accountid=gna.id left join sys_acctypes on sys_acctypes.id=gna.acctypeid where transactdate<='2016-06-30' and accountid='$row->accountid'";
    $rw = mysql_fetch_object(mysql_query($query));
    $amount=0;
    if(strtolower($rw->balance)=="dr"){
      $amount = $rw->debit-$rw->credit;
    }else{
      $amount = $rw->credit-$rw->debit;
    }
    ?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $row->account; ?></td>
      <td><?php echo formatNumber($row->debit); ?></td>
      <td><?php echo formatNumber($row->credit); ?></td>
      <td><?php echo $row->gn; ?></td>
      <td><?php echo formatNumber($amount); ?></td>
      <td><a href="javascript:;" onClick="showPopWin('addtb_proc.php?id=<?php echo $row->id; ?>',700,400);">Edit</td>
    </tr>
    <?php
  }
  ?>
</tbody>
</table>