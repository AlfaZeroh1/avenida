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
require_once("../../../modules/auth/rules/Rules_class.php");

$page_title = 'Financial Statement';

include "../../../head.php";

$auth->roleid="8756";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);


$obj=(object)$_POST;
$ob = (object)$_GET;

if(empty($obj->action))
  $obj->currencyid=5;
  
$obj->fromdate=$_SESSION['startdate'];

if(empty($obj->action)){
  
  $obj->currencyid=5;
}

if(!empty($ob->grp)){
  $obj->grp=$ob->grp;
}

if(!empty($ob->sys)){
  $obj->sys=$ob->sys;
}

if(empty($obj->action))
{
	$obj->todate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}
?>
<script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
	 
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"sPaginationType": "full_numbers",		
 		"sScrollY": 800,
 		"iDisplayLength":2000,
		"bJQueryUI": true,
		"bSort":false,
		"sPaginationType": "full_numbers"
	} );
} );

</script>

<form action="" method="post">
<table>
  <tr>
    <td>
    <input type="text" size="8" class="date_input" readonly name="fromdate" value="<?php echo $obj->fromdate; ?>"/>&nbsp;
    As at: <input type="text" size="8" class="date_input" readonly name="todate" value="<?php echo $obj->todate; ?>"/>&nbsp; 
    <input type="radio" name="type" value="1" <?php if($obj->type==1){echo "checked";}; ?>/>Summarised&nbsp;<input type="radio" name="type" value="2" <?php if($obj->type==2){echo "checked";}; ?>/>Detailed&nbsp;
    Currency: <select name="currencyid" class="selectbox">
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
			      </select>
    <input type="submit" name="action" id="action" class="btn btn-primary" value="Filter"/>
    </td>
  </tr>
</table>
</form>

   <table width="50%" border="0" align="center" class="table" id="tbl">
            <thead> <tr>
                <th colspan="5"><div align="center">Balance Sheet as at <?php echo formatDate($obj->todate);?></div></th>
                </tr>
                  <tr>
			<th align="left">&nbsp;</th>
			<th align="left">&nbsp;</th>
			<th align="left">&nbsp;</th>
			<th align="left">&nbsp;</th>
                   	<th align="left">&nbsp;Ksh</th>
               </tr>
                </thead>
              <tbody>
              
              
                  
              
              
              <?php
              $assets=getAccount(4,$obj);
              
              ?>              
              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr> 
              <?php
              $liabilities=getAccount(3,$obj);
              ?>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>  
               
              <?php
              $equity=getAccount(5,$obj);
              ?>
              
               <tr>
                <td>Liabilitys + Capital</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" style="text-decoration: overline underline;"><?php echo formatNumber($liabilities+$equity);?></td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr> 
              
             
              </tbody>        
         </table>
</div>
</div>
</div>
</div>
</div>
<?php
include"../../../foot.php";
?>
<?php
function getAccount($id,$obj,$type=""){
		    $accounttypes = new Accounttypes();
		$fields="*";
		$where=" where id='$id' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$accounttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$tdraccounttypes=0;
		$tcraccounttypes=0;	
		
		$gn = new Generaljournals();
		
		while($accounttypess = mysql_fetch_object($accounttypes->result)){
		
		    ?>
		    <tr>
			    <td><?php echo $accounttypess->code; ?>&nbsp;<?php echo $accounttypess->name; ?></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		    </tr>
		    <?php
		    //get sub account types
		    $subaccountypes = new Subaccountypes();
		    $fields="*";
		    $where=" where fn_subaccountypes.accounttypeid='$accounttypess->id'";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $subaccountypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    $tdrsubaccountypes=0;
		    $tcrsubaccountypes=0;		    
		    $ttttotal=0;
		    while($subaccountypess = mysql_fetch_object($subaccountypes->result)){
		    
			?>
			<tr>
				
				<td>&nbsp;</td>
				<td><?php echo $subaccountypess->code; ?>&nbsp;<?php echo $subaccountypess->name; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			    <?php
			    //get account types
			    $acctypes = new Acctypes();
			    $fields="*";
			    $where=" where sys_acctypes.subaccountypeid='$subaccountypess->id'";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $tttotal=0;
			    
			    while($acctypess = mysql_fetch_object($acctypes->result)){
			    $rpwhere="";
			      if($acctypess->accounttype=="Cumulative"){
			      }else{
				
			      }
				$rpwhere.=" and fn_generaljournals.transactdate>='".$_SESSION['startdate']."' ";
				$rpwhere.=" and fn_generaljournals.transactdate<='$obj->todate' ";
				
				$rptwhere=$rpwhere;
								
				$generaljournalaccounts=new Generaljournalaccounts ();
				$fields=" fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance ";
				$where=" where fn_generaljournalaccounts.acctypeid='$acctypess->id' ";
// 				if($obj->grp){
				  if(empty($where))
				    $where.=" where ";
				  else
				    $where.=" and ";
				  $where.=" (fn_generaljournalaccounts.categoryid is null or fn_generaljournalaccounts.categoryid=0) ";
// 				}
				
				$groupby="  ";
				$having="";
				$orderby=" order by sys_acctypes.name, fn_generaljournalaccounts.name ";
				$join=" left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
				$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				
				$in = $gn->getCategoryAccounts($acctypess->id,"");
				
				$query="select case when sum(debit*rate) is null then 0 else sum(debit*rate) end debit from fn_generaljournals where accountid  in(select id from fn_generaljournalaccounts where acctypeid='$acctypess->id' or categoryid in($in)) $rptwhere";
				$db=mysql_fetch_object(mysql_query($query));
				
				$query="select case when sum(credit*rate) then 0 else sum(credit*rate) end credit from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where acctypeid='$acctypess->id' or categoryid in($in)) $rptwhere";
				$dbs=mysql_fetch_object(mysql_query($query));
				
				if (strtolower($row->balance)=='dr'){
					$debit=$db->debit-$dbs->credit;
					$credit=0;
				}
				else{
					$credit=$dbs->credit-$db->debit;
					$debit=0;
				}
				
				$mtotal=($debit+$credit);
				
				if($obj->type==2 and $generaljournalaccounts->affectedRows>0 and $mtotal<>0){
				?>
				<tr>
					
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><?php echo $acctypess->code; ?>&nbsp;<?php echo $acctypess->name; ?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php
				}
				$res=$generaljournalaccounts->result;
				$tdebit=0;
				$tcredit=0;
				
				$tdracctypes=0;
				$tcracctypes=0;				
				$ttotal=0;
				
				while($row=mysql_fetch_object($res)){
		    $total=0;
		    
// 		    $rptwhere=" and transactdate>='$obj->fromdate' and transactdate<='$obj->todate' ";
		    
		    $query="select case when sum(debit*rate) is null then 0 else sum(debit*rate) end debit from fn_generaljournals where accountid in($row->id) $rptwhere";
		    $db=mysql_fetch_object(mysql_query($query));
		    
		    $query="select case when sum(credit*rate) is null then 0 else sum(credit*rate) end credit from fn_generaljournals where accountid in($row->id) $rptwhere";
		    $dbs=mysql_fetch_object(mysql_query($query));
		    
		    if (strtolower($row->balance)=='dr'){
			    $debit=$db->debit-$dbs->credit;
			    $credit=0;
		    }
		    else{
			    $credit=$dbs->credit-$db->debit;
			    $debit=0;
		    }
		    
		    $mtotal=($debit+$credit);
		    $ttotal+=($debit+$credit);
		    $tttotal+=($debit+$credit);
		    $ttttotal+=($debit+$credit);
		    $in="";
		    $in = $gn->getCategoryAccounts("",$row->id);
		    
		    $generaljournal = new Generaljournalaccounts();
		    $fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when sum(fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.debit*fn_generaljournals.rate) end debit, case when sum(fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.credit*fn_generaljournals.rate) end credit";
		    $where=" where (fn_generaljournalaccounts.categoryid='$row->id' or fn_generaljournalaccounts.id in($in)) ".$rptwhere;
		    $join=" left join fn_generaljournals on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
		    $having="";
		    $groupby=" group by fn_generaljournalaccounts.id ";
		    $orderby="";
		    $generaljournal->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    $generaljournal = $generaljournal->fetchObject;
		    $bool=false;
		    if(($generaljournal->debit<>0 or $generaljournal->credit<>0 or $mtotal<>0) and $obj->type==2){
		    $bool=true;
		    ?>
		      <tr>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td><?php if($mtotal<>0){ ?><a href="account.php?id=<?php echo $row->id; ?>&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->name); ?></a><?php }else{ ?> <?php echo initialCap($row->name); } ?></td>					
			    <td align="right"><?php if($mtotal<>0)echo formatNumber($mtotal); ?></td>
		    </tr>
		    <?php
		    }
		    //get accounts that belong to the categoryid
		    $generaljournall = new Generaljournalaccounts();
		    $fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end debit, case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end credit";
		    $where=" where  fn_generaljournalaccounts.categoryid='$row->id' ";//.$rptwhere;
		    $join=" left join fn_generaljournals on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
		    $having="";
		    $groupby=" group by  fn_generaljournalaccounts.id ";
		    $orderby=" order by fn_generaljournalaccounts.name ";
		    $generaljournall->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    
		    $mstotal=0;$h=0;
		    while($generaljournal=mysql_fetch_object($generaljournall->result)){
		    
// 		    $genr = mysql_fetch_object(mysql_query("select case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end debit from fn_generaljournals where accountid='$generaljournal->id' $rptwhere"));
		    $mtotal=0;
		      if(strtolower($generaljournal->balance)=="dr")
			$total=($generaljournal->debit-$generaljournal->credit);
		      else
			$total=($generaljournal->credit-$generaljournal->debit);
			
		      $ttotal+=$total;
		      $tttotal+=$total;
		      $ttttotal+=$total;
		      $mtotal+=$total;
		      $mstotal+=$total;
		      
		      $in="";
		      $in = $gn->getCategoryAccounts("",$generaljournal->id);
		      
		      
		      $generaljournalls = new Generaljournals();
		      $fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end debit, case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end credit";
		      $where=" where  fn_generaljournalaccounts.id in($in) ".$rptwhere;
		      $join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
		      $having="";
		      $groupby=" group by  fn_generaljournalaccounts.id ";
		      $orderby=" order by fn_generaljournalaccounts.name ";
		      $generaljournalls->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($generaljournal->id==6357)echo $generaljournalls->sql;  
		      
		      while($generaljournals=mysql_fetch_object($generaljournalls->result)){
			if(strtolower($generaljournals->balance)=="dr")
			  $total=($generaljournals->debit-$generaljournals->credit);
			else
			  $total=($generaljournals->credit-$generaljournals->debit);
			  
			
			
			$ttotal+=$total;
			$tttotal+=$total;
			$ttttotal+=$total;
			$mtotal+=$total;
			$mstotal+=$total;			
			
		      }
		      
		      if(($total<>0 or $mtotal<>0) and $obj->type==2){$h++;
		      ?>
			      <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td><?php echo $h; ?>:&nbsp;<a href="account.php?id=<?php echo $generaljournal->id; ?>&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($generaljournal->name); ?></a></td>				
				      <td align="right"><?php echo formatNumber($mtotal); ?></td>
			      </tr>
		      <?php 
		      }
		      
		      //get children of already selected account
		      
		    }  
		    if($mstotal<>0){
		      ?>
			      <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td> Total <?php echo initialCap($row->name); ?></td>				
				      <td align="right" style="text-decoration: overline;"><?php echo formatNumber($mstotal); ?></td>
			      </tr>
		      <?php 
		      }
	    }
			if($obj->type==2 and $ttotal<>0){
			?>
			<tr>
				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Total <?php echo $acctypess->name; ?></td>
				<td>&nbsp;</td>
				<td align="right" <?php if($obj->type==2){?>style="text-decoration: overline;" <?php } ?>><?php echo formatNumber($ttotal); ?></td>
			</tr>
		    <?
		    }
		    $tdrsubaccountypes+=$tdracctypes;
		    $tcrsubaccountypes+=$tcracctypes;
		    }
		    
		    ?>
		    <tr>
				
				<td>&nbsp;</td>
				<td><?php if($obj->type==2){?>Total <?php echo $subaccountypess->name; } ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right" <?php if($obj->type==2){?>style="text-decoration: overline;"<?php } ?>><?php echo formatNumber($tttotal); ?></td>
			</tr>
		    <?

		    $tdraccounttypes+=$tdrsubaccountypes;
		    $tcraccounttypes+=$tcrsubaccountypes;
	      }
	      
	      if($id==5){
	      $gn = new Generaljournals();
	      $sales = $gn->getAccountInc(1,$obj,"25");
	      $returnin = $gn->getAccountInc(1,$obj,"27");
	      $incomes=$gn->getAccountInc(1,$obj,"1");
	      $in="26";
	      $purchases=$gn->getAccountInc(2,$obj,$in);
	      $returnout=$gn->getAccountInc(2,$obj,"28");
	      $expenses=$gn->getAccountInc(2,$obj,"","26,37,39");
              $earnings=($sales+$incomes-$returnin)-($purchases+$expenses-$returnout);
              ?>
              <tr>
		  <td>&nbsp;</td>
		  <td>Profit for the period</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="right" ><?php echo formatNumber($earnings);?></td>
		</tr>
		<?
		}
		$ttttotal+=$earnings;
		
// 	      if($obj->type==2){
	      ?>
		<tr>
			
			<td>Total <?php echo $accounttypess->name; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right" style="text-decoration: overline underline;"><?php echo formatNumber($ttttotal); ?></td>
		</tr>
		    <?
// 		    }
	  }
	  
	  
	      
		    return $ttttotal;		    
		    
}
?>