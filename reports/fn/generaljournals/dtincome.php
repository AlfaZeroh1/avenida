<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");

$page_title = 'Detailed Income Statement';

include "../../../head.php";

$generaljournals = new Generaljournals();

$obj=(object)$_POST;

$obj=(object)$_POST;
if(empty($obj->action))
{
	$obj->fromdate=date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),date("Y")));
	$obj->todate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}
?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
TableToolsInit.sSwfPath = "../../media/swf/ZeroClipboard.swf";
	 $('#tbl').dataTable( {
		"sScrollY": 500,
		"bJQueryUI": true,
		"iDisplayLength": 200,
		"bSort":false,
		"sPaginationType": "full_numbers"
	} );
} );

</script>
<form action="dtincome.php" method="post">
<table>
<tr><td>Transact 
        Date:
          <input name="fromdate" type="text" class="date_input" readonly="readonly" id="fromdate" value="<?php echo $obj->fromdate; ?>" size="12" />
    
    
    Closing 
        Date:
          <input name="todate" type="text" class="date_input" readonly="readonly" id="todate" value="<?php echo $obj->todate; ?>" size="12" />
          <input type="submit" name="action" id="action" value="Submit" /></td></tr>
</table>
</form>
            <table width="100%" border="0" align="center" class="table" id="tbl">
            <thead>
              <tr>
                <td class="gridTitle" colspan="4"><div align="center"><strong>
                  Profit & Loss <br/>From: <?php echo formatDate($obj->fromdate); ?> <br/> To <?php echo formatDate($obj->todate); ?></strong></div></td>
                </tr>
                <tr class="special-row1">
                <th align="left">Details</th>
                	<th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Figures</th>	
                        </tr>
            </thead>
           <tbody>
             <tr class="td-title">
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
              </tr>
              <?php 
              $result=$generaljournals->retrieveBalance($obj,25);
              while($sales=mysql_fetch_object($result)){
				$netsales+=$sales->credit;
		?>
              
              <tr>
                <td ><a href="account.php?id=66&class=B"><?php echo $sales->accname; ?></a></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td ><div align="right"><?php echo formatNumber($sales->credit);?></div></td>
              </tr>
              <?php
              }
			  
			  ?>
              <tr>
                <td >Net Sales</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td ><div align="right"><?php echo formatNumber($netsales);?></div></td>
              </tr>
              <?php 
              $result=$generaljournals->retrieveBalance($obj,26);
              $netpurchases=0;
              while($row=mysql_fetch_object($result)){
				$netpurchases+=$row->debit;
		?>
              
              <tr>
                <td ><?php echo $row->accname; ?> </td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td ><div align="right"><?php echo formatNumber($row->debit);?></div></td>
              </tr>
              <?php
              }
			  
			  ?>
              <?php
			  $returnout=$generaljournals->retrieveBalance($obj,28);
			  ?>
				  <tr>
					<td >&nbsp;&nbsp;&nbsp;<strong><?php echo $returnout->accountid; ?> Less Returns Outwards</strong></td>
					<td >&nbsp;</td>
					<td ><div align="right">(<?php echo formatNumber($returnout->credit); ?>)</div></td>
					<td >&nbsp;</td>
				  </tr>
                   <?php
			  $carriagein=$generaljournals->retrieveBalance($obj,"carriage inwards");
			  ?>
				  <tr>
                    <td >&nbsp;&nbsp;&nbsp;<strong><?php echo $carriagein->accountid; ?> Carriage Inwards</strong></td>
				    <td >&nbsp;</td>
				    <td ><div align="right"><?php echo formatNumber($carriagein->credit); ?></div></td>
				    <td >&nbsp;</td>
			      </tr>
				 <?php
				// $netpurchases=$purchases->credit-$returnout->credit+$carriagein->credit;
				 ?>
                <tr class="s_total">
					<td ><strong>Net Cost of Sales</strong></td>
					<td >&nbsp;</td>
					<td ><div align="right"><?php echo formatNumber($netpurchases); ?></div></td>
					<td >&nbsp;</td>
				  </tr>
                   <?php
			  $ostock=$generaljournals->retrieveBalance($obj,34,'opening');
			  ?>
                <tr class="s_total">
                  <td >Add Open Stock</td>
                  <td >&nbsp;</td>
                  <td ><div align="right"><?php echo formatNumber($ostock); ?></div></td>
                  <td >&nbsp;</td>
                </tr>  
                  <?php
				  $gafs=$netpurchases+$ostock;
				  ?>
                  <tr>
                  <td>Goods Available For Sale</td>
                  <td>&nbsp;</td>
                  <td><div align="right"><?php echo formatNumber($gafs);?></div></td>
                  <td>&nbsp;</td>
                  </tr>
                  <?php
				  $cstock=$generaljournals->retrieveBalance($obj,34,'closing');
				  ?>
                  <tr>
                    <td>Less Closing Stock</td>
                    <td>&nbsp;</td>
                    <td><div align="right">(<?php echo formatNumber($cstock); ?>)</div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php
				  $cogs=$gafs-$cstock;
				  ?>
                   <tr class="s_total">
                <td ><strong><?php echo $cogs->accountid; ?> Cost of Goods Sold</strong></td>
                <td >&nbsp;</td>
                <td ><div align="right"><?php echo formatNumber($cogs);?></div></td>
                <td >&nbsp;</td>
              </tr>
              <?php
			  $gross=$netsales-$cogs;
			  ?>
                  <tr class="s_total">
                    <td >Gross Profit</td>
                     <td >&nbsp;</td>
                    <td ><div align="right"><strong><?php echo formatNumber($gross);?></strong></div></td>
                     <td >&nbsp;</td>
                  </tr>
                  <tr>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td ><div align="right"><strong><?php echo formatNumber($netsales);?></strong></div></td>
                    <td ><div align="right"><strong><?php echo formatNumber($netsales);?></strong></div></td>
                  </tr>
                  <tr>
                  <td colspan="4">&nbsp;</td>
                  </tr>
				  <tr>
                    <td >Gross Profit</td>
                     <td >&nbsp;</td>
                    <td >&nbsp;</td>
                     <td ><div align="right"><strong><?php echo formatNumber($gross);?></strong></div></td>
                  </tr>
				  <?php
				  $incomes=0;
				  $res=$generaljournals->retrieveBalance($obj,1);
				  while($row=mysql_fetch_object($res))
				  {
				  if(!empty($row->credit)){
				  $incomes+=$row->credit;
				  ?>
				  <tr>
                    <td ><?php echo initialCap($row->name); ?></td>
                     <td >&nbsp;</td>
                    <td ><div align="right"><?php echo formatNumber($row->credit);?></div></td>
                     <td >&nbsp;</td>
                  </tr>
				  <?php
				  }
				  }
				  ?>
				  <tr>
                     <td ><a href="generaljournals.php?acctypeid=1&class=">Incomes<a/></td>
                     <td >&nbsp;</td>
                    <td >&nbsp;</td>
                     <td ><div align="right"><?php echo formatNumber($incomes);?></div></td>
                  </tr>
				  <tr>
                    <td >&nbsp;</td>
                     <td >&nbsp;</td>
                    <td >&nbsp;</td>
                     <td ><div align="right"><?php echo formatNumber($gross+$incomes);?></div></td>
                  </tr>
				  <tr>
                     <td ><a href="generaljournals.php?acctypeid=4&class=">Expenses</a></td>
                     <td >&nbsp;</td>
                    <td >&nbsp;</td>
                     <td >&nbsp;</td>
                  </tr>
				  <?php
				  $expenses=0;
				  $res=$generaljournals->retrieveBalance($obj,4);
				  while($row=mysql_fetch_object($res))
				  {
				  if(!empty($row->debit)){
				  $expenses+=$row->debit;
				  ?>
				  <tr>
                    <td ><?php echo initialCap($row->accname); ?></td>
                     <td ><div align="right"><?php echo formatNumber($row->debit);?></div></td>
                    <td >&nbsp;</td>
                     <td >&nbsp;</td>
                  </tr>
				  <?php
				  }
				  }
				  ?>
				  <tr>
                    <td >Total Expenses</td>
                     <td >&nbsp;</td>
                    <td ><div align="right">(<?php echo formatNumber($expenses);?>)</div></td>
                     <td >&nbsp;</td>
                  </tr>
				  <tr>
                    <td >Net Income</td>
                     <td >&nbsp;</td>
                    <td ><div align="right"><strong><?php echo formatNumber($gross+$incomes-$expenses);?></strong></div></td>
                     <td >&nbsp;</td>
                  </tr>
				  <tr>
                    <td >&nbsp;</td>
                     <td >&nbsp;</td>
                     <td ><div align="right"><strong><?php echo formatNumber($gross+$incomes);?></strong></div></td>
                    <td ><div align="right"><strong><?php echo formatNumber($gross+$incomes);?></strong></div></td>
                  </tr>
              </tbody>
              <tr>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
              </tr>
            </table>
          
  