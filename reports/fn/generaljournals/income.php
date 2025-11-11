<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/fn/accounttypes/Accounttypes_class.php");
require_once("../../../modules/fn/subaccountypes/Subaccountypes_class.php");
require_once("../../../modules/fn/expensecategorys/Expensecategorys_class.php");
require_once("../../../modules/fn/expensetypes/Expensetypes_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");

$page_title = 'Income Statement';

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

include"../../../head.php";

$auth->roleid="8756";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);

$generaljournals = new Generaljournals();

$obj=(object)$_POST;



if(empty($obj->action))
{
	$obj->fromdate=date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),date("Y")));
	$obj->todate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
	$obj->currencyid=5;
}  
if($obj->fromdate<$_SESSION['startdate']){
	$obj->fromdate=$_SESSION['startdate'];
}
?>
<script type="text/javascript" charset="utf-8">
 
 $(document).ready(function() {
	TableTools.DEFAULTS.aButtons = [ "copy", "csv", "xls","pdf" ];
				
 	$('#tbl').dataTable( {
		"scrollX": true,
	      dom: 'lBfrtip',
		"buttons": [
		 'copy', 'csv', 'excel', 'print','colvis',{
		    extend: 'pdfHtml5',
		    orientation: 'landscape',
		    pageSize: 'LEGAL'
		}],"bJQueryUI": true,
		"aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 800,
 		"iDisplayLength":2000,
		"bJQueryUI": true,
// 		"bRetrieve":true		
 	} );
 } );
 </script>
<form action="income.php" method="post">
<table class="table">
<tr>
      <td>Transact Date:</td>
      <td><input name="fromdate" type="text" class="date_input" readonly="readonly" id="fromdate" value="<?php echo $obj->fromdate; ?>" size="12" /><td>   
      <td>Closing Date:</td>
      <td><input name="todate" type="text" class="date_input" readonly="readonly" id="todate" value="<?php echo $obj->todate; ?>" size="12" /></td>
      <td>Currency: </td>
      <td><select name="currencyid" class="selectbox">
	  <?php
	  $currencys = new Currencys();
	  $fields="* ";
	  $join=" ";
	  $having="";
	  $groupby="";
	  $orderby=" order by id desc ";
	  $where=" where id in(1,5) ";
	  $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($row=mysql_fetch_object($currencys->result)){
	    ?>
	    <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
	    <?php
	  }
	  ?>
	</select></td>
     <td><input type="submit" name="action" id="action" value="Submit" /></td></tr>
</table>
</form>
            <table style="clear:both;"  class="table" id="tbl" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
            <thead>
              <tr>
                <td class="gridTitle" colspan="4"><div align="center"><strong>
                  Profit & Loss <br/>From: <?php echo formatDate($obj->fromdate); ?> <br/> To <?php echo formatDate($obj->todate); ?></strong></div></td>
                </tr>
                <tr class="special-row1">
                <th align="left">DETAILS</th>
                	<th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                        </tr>
            </thead>
           <tbody>
             
              <?php
			  $sales = $generaljournals->getAccountInc(1,$obj,"25","",true);
			  $returnin = $generaljournals->getAccountInc(1,$obj,"27","",true);
			  $netsales=$sales-$returnin;
			  ?>
              
              <?php
			  $incomes=$generaljournals->getAccountInc(1,$obj,"1","",true);
			  $totalincome=$netsales+$incomes;
	      if($totalincome!=0){
	      ?>
		<tr class="s_total">
					<td ><strong>NET INCOME</strong></td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td style="text-decoration: overline;"><div align="right"><?php echo formatNumber($totalincome); ?></div></td>
				  </tr>
	      <?
	      }
			  $in="26";
			  $purchases=$generaljournals->getAccountInc(2,$obj,$in,"",true);
			  $returnout = $generaljournals->getAccountInc(2,$obj,"28","",true);
			  $purchases-=$returnout;
		if($purchases!=0){
				 ?>
                   <tr class="s_total">
                <td ><strong><?php echo $cogs->accountid; ?> Cost of Goods Sold</strong></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td ><div align="right">(<?php echo formatNumber($purchases);?>)</div></td>
              </tr>
              <?php
              }
			  $gross=$totalincome-$purchases;
			  ?>
                  <tr>
                  <td colspan="4">&nbsp;</td>
                  </tr>
				  <tr>
                    <td >Gross Profit</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                     <td style="text-decoration: overline underline;"><div align="right"><strong><?php echo formatNumber($gross);?></strong></div></td>
                  </tr>
				  <?php
				  
				  $expenses=$generaljournals->getAccountInc(2,$obj,"","26,37,39",true);
				  $netincome=$gross-$expenses;
				  ?>
				  <tr>
                    <td >Net Profit/Loss</td>
                     <td >&nbsp;</td>
                     <td>&nbsp;</td>
                    <td style="text-decoration: overline underline;"><div align="right"><strong><?php echo formatNumber($netincome);?></strong></div></td>
                     
                  </tr>
			
              </tbody>
              
            </table>
 
