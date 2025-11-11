<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankreconciliations_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once '../banks/Banks_class.php';
require_once '../generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../generaljournals/Generaljournals_class.php';

$auth->role="11";//reconciliation
$auth->level=$_SESSION['level'];

//auth($auth);

// include "../../../head.php";

$obj=(object)$_GET;

$banks = new Banks();
$fields="*";
$where=" where id='$obj->bankid' ";
$having="";
$groupby="";
$orderby="";
$banks->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$bank = $banks->fetchObject;

$bankreconciliations = new Bankreconciliations();
$fields="*";
$where=" where bankid='$obj->bankid' and recondate<'$obj->todate' ";
$having="";
$groupby="";
$orderby=" order by recondate desc ";
$bankreconciliations->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$open = $bankreconciliations->fetchObject;

$openbal=$open->balance;

$obj->open=$openbal;

$generaljournalaccounts = new Generaljournalaccounts();
$fields="*";
$where=" where refid='$obj->bankid' and acctypeid=8 ";
$having="";
$groupby="";
$orderby=" ";
$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$acc = $generaljournalaccounts->fetchObject;

$obj->accountid=$acc->id;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

<script type="text/javascript">
  function print_doc()
  {
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
		//alert(printers[i]+"="+'<?php echo $_SESSION["smallprinter"];?>');
			if(printers[i].indexOf('<?php echo $_SESSION["smallprinter"];?>')>-1)
			{	//alert(i+": "+printers[i]);
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies',1);
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginTop','4.8');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','4');
		jsPrintSetup.setOption('marginRight','');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<!--    <link href="../../../css/bootstrap.css" rel="stylesheet"> -->
<!-- <link href="../../../css/bootstrap.min.css" rel="stylesheet"> -->
<style type="text/css" media="all">
body{font-family:'arial';font-size:10px;}
ul{list-style:none !important;}
.table-bordered {
border: 1px solid #ddd;
border-collapse: separate;
/*border-left: 1px;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;*/
}
hr {
display: block;
-webkit-margin-before: 0.2em;
-webkit-margin-after: 0.2em;
-webkit-margin-start: auto;
-webkit-margin-end: auto;
border-style: inset;
border-width: 1px;
}
</style>



</head>

<body onload="print_doc();">
            <table width="100%" border="0" align="center"  class="tgrid display" id="example">
            <thead>
              <tr>
                <td colspan="6"><div align="center"><strong><?php echo $_SESSION['COMPANY_NAME'];?><br />Reconciliation Summary<br /><?php echo $bank->name; ?>, Period Ending <?php echo formatDate($obj->todate); ?></strong></div></td>
                </tr>
                <tr class="special-row1"><th align="left">Details</th>
                	<th align="left">&nbsp;</th>
                	<th align="left">&nbsp;</th>
                	<th align="left">&nbsp;</th>
                	<th>&nbsp;</th>
			<th>&nbsp;</th>
                  </tr>
            </thead>
           
           <tbody>
             
              <tr>
                <td >&nbsp;&nbsp;&nbsp;<strong>Beginning Balance</strong></td>
                <td align="right"><?php echo formatNumber($obj->open); ?></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
             
				  <tr class="td-title">
					<td >&nbsp;&nbsp;&nbsp;<strong>Cleared Transactions</strong></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
				  <?php
				  
				  $generaljournals = new Generaljournals();
				  $fields="sum(credit) credit";
				  $where=" where accountid='$obj->accountid' and recondate='$obj->todate' and reconstatus='checked' and credit!=0 ";
				  $having="";
				  $groupby="";
				  $orderby=" ";
				  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournals = $generaljournals->fetchObject;
				  $crcleared = $generaljournals->credit;
				  
				  $crcleared=(-1*$crcleared);
				  
				  $generaljournals = new Generaljournals();
				  $fields="sum(debit) debit";
				  $where=" where accountid='$obj->accountid' and recondate='$obj->todate' and reconstatus='checked' and debit!=0 ";
				  $having="";
				  $groupby="";
				  $orderby=" ";
				  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournals = $generaljournals->fetchObject;
				  $drcleared = $generaljournals->debit;
				  
				  $ttcleared=$crcleared+$drcleared;
				  ?>
				  <tr>
					<td >&nbsp;&nbsp;&nbsp;&nbsp;Cheques and Payments</td>
					<td align="right"><?php echo formatNumber($crcleared); ?></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
				  
                <tr>
					<td >&nbsp;&nbsp;&nbsp;&nbsp;Deposits and Credits   </td>
					<td align="right" style="border-bottom: 1px solid #000;"><?php echo formatNumber($drcleared); ?></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
                
              <tr>
					<td ><strong>Total Cleared Transactions</strong></td>
					<td align="right" style="border-bottom: 1px solid #000;"><?php echo formatNumber($ttcleared); ?></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
		<tr class="sb_total">
					<td ><strong>Cleared Balance</strong></td>
					<td align="right" style="border-bottom: 1px solid #000;"><?php echo formatNumber($ttcleared+$obj->open); ?></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
                  
             
                   <tr class="td-title">
                <td ><strong>Uncleared Transactions</strong></td>
                <td style="border-top: 1px solid #000;">&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
              <?php
			 
			  $generaljournals = new Generaljournals();
			  $fields="sum(credit) credit";
			  $where=" where accountid='$obj->accountid' and transactdate<='$obj->todate'  and (reconstatus='unchecked' or reconstatus='') and credit!=0 ";
			  $having="";
			  $groupby="";
			  $orderby=" ";
			  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournals->sql;
			  $generaljournals = $generaljournals->fetchObject;
			  $cruncleared = $generaljournals->credit;
			  
			  $cruncleared=(-1*$cruncleared);
			  
			  $generaljournals = new Generaljournals();
			  $fields="sum(debit) debit";
			  $where=" where accountid='$obj->accountid' and transactdate<='$obj->todate'  and (reconstatus='unchecked' or reconstatus='') and debit!=0 ";
			  $having="";
			  $groupby="";
			  $orderby=" ";
			  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $generaljournals = $generaljournals->fetchObject;
			  $druncleared = $generaljournals->debit;
			  
			  $ttuncleared=$cruncleared+$druncleared;
			  ?>
                        <tr>
                            <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheques and Payments<strong></strong></td>
                            <td align="right"><?php echo formatNumber($cruncleared); ?></td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                        </tr>
              
                        <tr>
                            <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deposits and Credits </td>
                            <td align="right" style="border-bottom: 1px solid #000;"><?php echo formatNumber($druncleared); ?></td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                        </tr>
				  
				  <tr>
					<td >&nbsp;&nbsp;&nbsp;Total Uncleared Transactions</td>
					<td align="right" style="border-bottom: 1px solid #000;"><?php echo formatNumber($ttuncleared); ?></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
				  
		
				  
                    
                
              <tr class="sb_total">
					<td ><strong>Register Balance as at <?php echo $obj->todate; ?></strong></td>
					<td align="right" style="border-bottom: 1px solid #000;"><?php echo formatNumber($ttcleared+$ttuncleared+$obj->open); ?></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
		<tr class="sb_total">
					<td >&nbsp;</td>
					<td align="right" style="border-top: 1px solid #000;">&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
                  
                  <tr>
                <td colspan="6"><div align="center"><strong><?php echo $_SESSION['COMPANY_NAME'];?><br />
                Reconciliation Detail<br />
                <?php echo $bank->name; ?>, Period Ending <?php echo formatDate($obj->todate); ?></strong></div></td>
                </tr>
                    <tr>
                      <td >Type</td>
                      <td >Date</td>
                      <td >Cheque No</td>
                      <td >Payee</td>
                      <td >Amount</td>
                      <td >Balance</td>
                    </tr>
                    <?php
					$openbal=$obj->open;
					?>
                   <tr>
                <td >&nbsp;&nbsp;&nbsp;<strong>Beginning Balance</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td align="right"><?php echo formatNumber($openbal); ?></td>
                <td align="right"><?php echo formatNumber($openbal); ?></td>
                </tr>
              
                   <tr class="td-title">
                <td ><strong>Cleared Transactions</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
              <tr class="td-title">
                <td ><strong>Cheques and Payments</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
              <?php
			  $dttcrcleared=0;	
			  $generaljournals = new Generaljournals();
			  $fields=" * ";
			  $where=" where accountid='$obj->accountid' and recondate='$obj->todate' and reconstatus='checked' and credit!=0 ";
			  $having="";
			  $groupby="";
			  $orderby=" order by transactdate ";
			  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $rscrcleared = $generaljournals->result;
			  
			  while($row=mysql_fetch_object($rscrcleared))
			  {
			  if($row->credit>0 and !empty($row->documentno))	 
			  	$type="Cheque";
			  else if($row->credit>0 and empty($row->documentno))
				$type="JV";
			else
				$type="Deposit";
				
				 
				 
				 if(empty($row->description))
				 	$row->description=$row->memo;
				if($row->description=="opening balance")
					continue;
				$dttcrcleared+=(-1*$row->credit);
				?>
               
              <tr>
                <td ><strong><?php echo $type; ?></strong></td>
                <td ><?php echo formatDate($row->transactdate);?></td>
                <td ><?php echo $row->chequeno; ?></td>
                <td ><?php echo $row->description; ?></td>
                <td align="right"><?php echo formatNumber(-1*$row->credit); ?></td>
                <td align="right"><?php echo formatNumber($dttcrcleared);?></td>
                </tr>             
				  <?
					}
					?>                    
                <tr class=" exp_total sb_exp_total">
					<td ><strong>Total Cheques and Payments&nbsp;</strong></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td align="right" style="border-top: 1px solid #000;"><strong><?php echo formatNumber($dttcrcleared); ?></strong></td>
					<td >&nbsp;</td>
			    </tr>
     
     <tr class="td-title">
                <td ><strong>Deposits and Credits</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
              <?php
			  $ttdrcleared=0;	
			  
			  $generaljournals = new Generaljournals();
			  $fields=" * ";
			  $where=" where accountid='$obj->accountid' and recondate='$obj->todate' and reconstatus='checked' and debit!=0 ";
			  $having="";
			  $groupby="";
			  $orderby=" order by transactdate ";
			  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $rsdrcleared = $generaljournals->result;
			  
			  
			  while($row=mysql_fetch_object($rsdrcleared))
			  {
			  if($row->credit>0)	 
			  	$type="Cheque";
			else
				$type="Deposit";
			
				
				if(empty($row->description))
				 	$row->description=$row->memo;
					
				if($row->description=="opening balance")
					continue;
					
				$ttdrcleared+=$row->debit;
				?>
                
              <tr>
                <td ><strong><?php echo $type; ?></strong></td>
                <td ><?php echo formatDate($row->transactdate);?></td>
                <td ><?php echo $row->chequeno; ?></td>
                <td ><?php echo $row->description; ?></td>
                <td align="right"><?php echo formatNumber($row->debit); ?></td>
                <td align="right"><?php echo formatNumber($ttdrcleared);?></td>
                </tr>             
				  <?
					}
					?>                    
                <tr >
					<td ><strong>Total Deposits and Credits&nbsp;</strong></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td align="right" style="border-top: 1px solid #000;"><strong><?php echo formatNumber($ttdrcleared); ?></strong></td>
					<td >&nbsp;</td>
				  </tr>
                <tr class=" exp_total sb_exp_total">
                  <td >Total Cleared Transactions</td>
                  <td >&nbsp;</td>
                  <td >&nbsp;</td>
                  <td >&nbsp;</td>
                  <td align="right" style="border-top: 1px solid #000;"><strong><?php echo formatNumber($dttcrcleared+$ttdrcleared); ?></strong></td>
                  <td >&nbsp;</td>
                </tr>
                
                 <tr class=" exp_total sb_exp_total">
                  <td >Cleared Balance</td>
                  <td >&nbsp;</td>
                  <td >&nbsp;</td>
                  <td >&nbsp;</td>
                  <td align="right" style="border-top: 1px solid #000;border-bottom: 1px solid #000;"><strong><?php echo formatNumber($dttcrcleared+$ttdrcleared+$obj->open); ?></strong></td>
                  <td >&nbsp;</td>
                </tr>
                  
                   <tr class="td-title">
                <td ><strong>Uncleared Transactions</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td style="border-top: 1px solid #000;">&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
              <tr class="td-title">
                <td ><strong>Cheques and Payments</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
              <?php
			  $ttcruncleared=0;	
			  
			  $generaljournals = new Generaljournals();
			  $fields=" * ";
			  $where=" where accountid='$obj->accountid' and transactdate<='$obj->todate' and date_format(createdon,'%Y-%m-%d')>='$obj->todate' and (reconstatus='unchecked' or reconstatus='') and credit!=0 ";
			  $having="";
			  $groupby="";
			  $orderby=" order by transactdate ";
			  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournals->sql;
			  $rscruncleared = $generaljournals->result;
			  
			  while($row=mysql_fetch_object($rscruncleared))
			  {
			  if($row->credit>0)	 
			  	$type="Cheque";
			else
				$type="Deposit";
				
				$ttcruncleared+=(-1*$row->credit);
				
				if(empty($row->description))
				 	$row->description=$row->memo;
					
				if($row->description=="opening balance")
					continue;
				?>
                
              <tr>
                <td ><strong><?php echo $type; ?></strong></td>
                <td ><?php echo formatDate($row->transactdate);?></td>
                <td ><?php echo $row->chequeno; ?></td>
                <td ><?php echo $row->memo; ?></td>
                <td align="right"><?php echo formatNumber(-1*$row->credit); ?></td>
                <td align="right"><?php echo formatNumber($ttcruncleared);?></td>
                </tr>             
				  <?
					}
					?>                    
                <tr class=" exp_total sb_exp_total">
					<td ><strong>Total Cheques and Payments&nbsp;</strong></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td align="right" style="border-bottom: 1px solid #000;"><strong><?php echo formatNumber($ttcruncleared); ?></strong></td>
					<td >&nbsp;</td>
				  </tr>
     
     <tr class="td-title">
                <td ><strong>Deposits and Credits</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
              <?php
			  $ttdruncleared=0;
			  
			  $generaljournals = new Generaljournals();
			  $fields=" * ";
			  $where=" where accountid='$obj->accountid' and transactdate<='$obj->todate' and date_format(createdon,'%Y-%m-%d')>='$obj->todate' and (reconstatus='unchecked' or reconstatus='') and debit!=0 ";
			  $having="";
			  $groupby="";
			  $orderby=" order by transactdate ";
			  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $rsdruncleared = $generaljournals->result;
			  
			  while($row=mysql_fetch_object($rsdruncleared))
			  {
			  if($row->credit>0)	 
			  	$type="Cheque";
			else
				$type="Deposit";
				
					
				if(empty($row->description))
				 	$row->description=$row->memo;
					
				if($row->description=="opening balance")
					continue;
					
				$ttdruncleared+=($row->debit);
				?>
                
              <tr>
                <td ><strong><?php echo $type; ?></strong></td>
                <td ><?php echo formatDate($row->transactdate);?></td>
                <td ><?php echo $row->chequeno; ?></td>
                <td ><?php echo $row->memo; ?></td>
                <td align="right"><?php echo formatNumber($row->debit); ?></td>
                <td align="right"><?php echo formatNumber($ttdruncleared);?></td>
                </tr>             
				  <?
					}
					?>                    
                <tr class=" exp_total sb_exp_total">
					<td ><strong>Total Deposits and Credits&nbsp;</strong></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td align="right" style="border-bottom: 1px solid #000;"><strong><?php echo formatNumber($ttdruncleared); ?></strong></td>
					<td >&nbsp;</td>
				  </tr>      
				  
		<tr class="sb_total">
					<td ><strong>Register Balance as at <?php echo $obj->todate; ?></strong></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td align="right" style="border-bottom: 1px solid #000;"><?php echo formatNumber($ttcleared+$ttuncleared+$obj->open); ?></td>
					<td >&nbsp;</td>
				  </tr>
		<tr class="sb_total">
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td align="right" style="border-top: 1px solid #000;">&nbsp;</td>
					<td >&nbsp;</td>
				  </tr>
              </tbody>
            </table>
          
  </body>
