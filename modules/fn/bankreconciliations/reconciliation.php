<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankreconciliations_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once '../banks/Banks_class.php';
require_once '../generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../generaljournals/Generaljournals_class.php';

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Bank Reconciliation";

include"../../../head.php";

$db = new DB();

$obj=(object)$_POST;
$title="";
$bool=false;
if($obj->action=="Submit")
{
	if(empty($obj->bank))
	{
		$error="must select Bank Involved";
	}
	else
	{
		$bankreconciliations = new Bankreconciliations();
		$fields="*";
		$where=" where bankid='$obj->bank'";
		$having="";
		$groupby="";
		$orderby=" order by recondate desc";
		$bankreconciliations->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		$open=$bankreconciliations->fetchObject;
		
		$obj->open=$open->balance;
		//add 1 to retrieved previous closing date
		$newdate = strtotime ( '+1 day' , strtotime ( $open->recondate ) ) ;
		$newdate = date ( 'Y-m-j' , $newdate );

		$obj->fromdate=$newdate;
		if($obj->todate<$obj->fromdate)
		{
			$error="Invalid Closing Date";
		}
		else
		{$bool=true;
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->bank' and acctypeid=8 ";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			
			$bn = $generaljournalaccounts->fetchObject;
			$title .=$bn->name;
			
			$wh = " where accountid='$bn->id' and (transactdate>='$obj->fromdate' or (transactdate<'$obj->fromdate' and (reconstatus='unchecked' or reconstatus='') or (transactdate<'$obj->fromdate' and reconstatus='checked' and recondate>='$obj->fromdate' and recondate<='$obj->todate')))";
			$title .=" From: ".$obj->fromdate;
			
			if(!empty($obj->todate))
			{
				$wh .= " and transactdate <= '$obj->todate'";
				$title .= " To: ".$obj->todate;
			}
			
			$_SESSION['reconwhere']="";
			$_SESSION['reconobj']="";
			$_SESSION['reconwhere']=$where;
			$_SESSION['reconobj']=$obj;
		}
	}
}

if($obj->action=="Reconcile Now")
{
	$bankreconciliations = new Bankreconciliations();
	if($obj->bankbal>0)
		$obj->debit=$obj->bankbal;
	else
		$obj->credit=(-1*$obj->bankbal);
		
	$obj->balance=$obj->bankbal;
	$obj->bankid=$obj->bank;
	$obj->recondate=$obj->todate;
	$bankreconciliations = $bankreconciliations->setObject($obj);
	if($bankreconciliations->add($bankreconciliations))
	{
	?>
	<script type="text/javascript" charset="utf-8">
		poptastic("printrecon.php?bankid=<?php echo $obj->bankid; ?>&todate=<?php echo $obj->todate; ?>",450,940);
	</script>
	<?php
	}
	else
		$error="Could not perform Reconciliation";
}
else
	$obj->balcheck=0;
?>
<script type="text/javascript" language="javascript">
 
$(document).ready(function() {
   	$('.check_row input:checkbox').click(function(){
		var curTrId = $(this).closest('tr').attr('id');
		var debitVal = $('#' +curTrId+ '.check_row').find('td.debit').html();
		var creditVal = $('#' +curTrId+ '.check_row').find('td.credit').html();
		debitVal = Number(debitVal.replace(/[^0-9\.-]+/g,""));
		creditVal = Number(creditVal.replace(/[^0-9\.-]+/g,""));
		
		var dbVal = parseFloat(debitVal);
		var crVal = parseFloat(creditVal);
		var viewBal = parseFloat($('input#bankbal').val());
		var balcheck = parseFloat($('input#balcheck').val());
		if(isNaN(balcheck))
			balcheck=0;
			
		var balance;
		if($(this).attr('checked') == 'checked'){	
			viewBal = viewBal+dbVal-crVal;
			balance=viewBal-balcheck;
			
			balance = Math.round(balance*Math.pow(10,2))/Math.pow(10,2);
			viewBal = Math.round(viewBal*Math.pow(10,2))/Math.pow(10,2);
			$('input#bankbal').val(viewBal);
			$('input#balance').val(balance);
			$('input#balanceval').val(balance);
			$('#' +curTrId+ '.check_row').css('background-color','#f0f000');
			//alert('is checked ' + viewBal);
		}	
		else{
		 	//var viewBal = parseFloat($('input#balCheck').val());
			viewBal = viewBal-dbVal+crVal;
			balance=viewBal-balcheck;
			balance = Math.round(balance*Math.pow(10,2))/Math.pow(10,2);
			viewBal = Math.round(viewBal*Math.pow(10,2))/Math.pow(10,2);
			$('input#bankbal').val(viewBal);
			$('input#balance').val(balance);
			$('input#balanceval').val(balance);
			$('#' +curTrId+ '.check_row').css('background-color','#fff');
			//alert('is not checked ' + viewBal);
	  }
	});
	
});
 </script>

<script language="javascript" type="text/javascript">
function setStatus(str)
{
if(str.checked)
{
	var status="checked";
	var recondate = document.getElementById("todate").value;
}
else
{
	var status="unchecked";
	var recondate="0000-00-00";
}
	
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  var url="status.php?id="+str.value+"&status="+status+"&date="+recondate;
xmlhttp.open("GET",url,true);
xmlhttp.send();
}
</script>
<script type="text/javascript" language="javascript">
function loadBalance()
{
	var bn = document.recon.bankval.value;	
	var bl = document.recon.balcheck.value;
	var balance = bn-bl;
	balance = Math.round(balance*Math.pow(10,2))/Math.pow(10,2);
	document.recon.balance.value=balance;
	document.recon.balanceval.value=balance;
}
</script>
 

<script type="text/javascript" language="javascript">
function loadBalance()
{
	var bn = document.recon.bankval.value;	
	var bl = document.recon.balcheck.value;
	var balance = bn-bl;
	balance = Math.round(balance*Math.pow(10,2))/Math.pow(10,2);
	document.recon.balance.value=balance;
	document.recon.balanceval.value=balance;
}
</script>
<!-- InstanceEndEditable -->
<style media="all" type="text/css">
#navamenu
{
visibility:hidden;
}
</style>

</head>
<?php
if (get_magic_quotes_gpc()){
 $_GET = array_map('stripslashes', $_GET);
 $_POST = array_map('stripslashes', $_POST);
 $_COOKIE = array_map('stripslashes', $_COOKIE);
}
?>
<body>

          <form action="reconciliation.php" method="post" name="recon">
            <div ><strong>Bank Involved:</strong>                  
            <?php
            $banks = new Banks();
                $fields="*";
                $where="";
                $having="";
                $groupby="";
                $orderby="";
                $banks->retrieve($fields, $join, $where, $having, $groupby, $orderby);
            ?>
            <select name="bank" id="bank" class="selectbox">
                    <option value="">Select...</option>
                    <?php
                
                while($rw=mysql_fetch_object($banks->result))
                {
                ?>
                    <option value="<?php echo $rw->id; ?>"<?php if($obj->bank==$rw->id){echo"selected";}?>><?php echo $rw->name; ?>&nbsp;<?php echo $rw->bankbranch; ?>[<?php echo $rw->bankacc; ?>]</option>
                    <?
                }
                ?>
                                  </select>&nbsp;&nbsp;
                  <strong>Date From:
                  <input name="fromdate" type="text" id="fromdate" value="<?php echo $obj->fromdate; ?>" size="12" readonly="readonly" />
                   &nbsp;&nbsp;To:
                   <input class="date_input" readonly="readonly" name="todate" type="text" id="todate" value="<?php echo $obj->todate; ?>" size="18" />
              
                   &nbsp; <input type="submit" class="btn" name="action" id="action" value="Submit" />
               		&nbsp;&nbsp;&nbsp;                  </strong><?php showError($error); ?></div>
 <div>
 <table style="clear:both;"  class="table table-stripped display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
 
<!--   <table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" > -->
 <thead>
 <tr>
    <td colspan="9" bgcolor="#BCCBDE"><strong>Bank Reconciliation Report</strong>( <?php echo $title; ?>)</td>
    </tr> 
  <tr>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th><div align="center"><strong>Date</strong></div></th>
    <th><div align="center"><strong>Description</strong></div></th>
    <th><div align="center"><strong>Memo</strong></div></th>
    <th><div align="center"><strong>Cheque No</strong></div></th>
    <th><div align="center"><strong>Jv No</strong></div></th>
    <th><div align="center"><strong>Debit</strong></div></th>
    <th><div align="center"><strong>Credit</strong></div></th>
    <th>&nbsp;</th>
    </tr>
  </thead>
    <tbody>
    <?php 
	$i=0; 
	if($open->balance>0)
		$drtotal+=$open->balance;
	else
		$crtotal+=(-1*$open->balance);	
	$bl=$open->balance;
	
	?>
    <tr id = "<?php echo 'trRow'.$i; ?>">
      <td>&nbsp;</td>
      <td><?php echo ($i+1); ?></td>
      <td><?php echo $obj->fromdate; ?></td>
      <td>Balance as at previous Reconciliation</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   <?php
    if($open->balance>0)
    {
    ?>
      <td width="12%"  class="lines debit"><?php echo round($open->balance,2); ?></td>
      <td align="right" width="10%" class="lines">&nbsp;</td>
    <?php
    }
    else
    {
    ?>
      <td align="right" width="2%" class="lines">&nbsp;</td>
      <td width="4%" class="lines credit"><?php echo round((-1*$open->balance),2); ?></td>    
    <?php
    }
    ?>
      <td align="right" width="2%" class="lines">&nbsp;</td>
  </tr>
  
    <?php
	
	if(empty($obj->action) or !$bool)
	{
	?>
	
	<!--<tr>
	<td colspan="7">Select Bank and details above to draw statement</td>
	</tr>-->
	
	<?
	}
	else
	{
		//retrieve records
		$generaljournals = new Generaljournals();
		$fields="*";
		$where=$wh;
		$having="";
		$groupby="";
		$orderby="";
		$generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	
	if(mysql_affected_rows()>0)
    {
	//$i=0;
	while($row=mysql_fetch_object($generaljournals->result))
	{$i++;
	
	$bal+=$row->debit-$row->credit;
	if($row->memo=="opening balance")
		continue;
		
    if($row->debit>0)
    	$drtotal+=$row->debit;
	elseif($row->credit>0)
		$crtotal+=$row->credit;
	
	if($row->reconstatus=="checked")
	{
		$bl+=$row->debit-$row->credit;
	}
	if($row->credit>0 or $row->debit>0)
	
	{	
	?>
  <tr id = "<?php echo 'trRow'.$i; ?>" class="check_row" style="background-color:<?php if($row->reconstatus=='checked'){echo'#f0f000';}else{echo'#fff';}?>">
    <td><input name="<?php echo $row->id; ?>" type="checkbox" value="<?php echo $row->id; ?>" onchange="setStatus(this)" <?php if($row->reconstatus=='checked'){echo"checked";}?> /></td>
    <td><?php echo ($i+1); ?></td>
    <td><?php echo $row->transactdate; ?></td>
    <td><?php echo $row->remarks; ?></td>
    <td><?php echo $row->memo; ?></td>
    <td><?php echo $row->chequeno; ?></td>
    <td><?php echo $row->jvno; ?></td>
    <td><?php echo formatNumber(round($row->debit,2)); ?></td>
    <td><?php echo formatNumber(round($row->credit,2)); ?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  
  }
  
  ?>
 </tbody>
 <tfoot>
 <tr>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines"><strong>Bank A/C Balance:</strong></td>
    <?php
	if(($drtotal-$crtotal)>0)
	{$bal=$drtotal-$crtotal;
	?>
    <td class="lines" id="chkBal">&nbsp;</td>
    <td class="lines"><?php echo formatNumber($drtotal-$crtotal); ?></td>
    <?php
	$crtotal+=$bal;
	}
	else
	{$bal=$crtotal-$drtotal;
	?>
    <td class="lines">&nbsp;</td>
    <td class="lines"><?php echo formatNumber($crtotal-$drtotal); ?></td>
    <?php
	$drtotal+=$bal;
	
	}
	$bal+=($open->debit-$open->credit);
	
	?>
     <td align="right" width="2%" class="lines">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="4">&nbsp;</td>
  <td colspan="3"><hr></td>
  </tr>
  <tr>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>    
	<td class="lines">&nbsp;</td>
    <td class="lines"><strong><?php echo formatNumber($drtotal); ?></strong></td>
    <td class="lines"><strong><?php echo formatNumber($crtotal); ?></strong></td>
    <td align="right" width="2%" class="lines">&nbsp;</td>
  </tr>

  <tr>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines"><strong>Bank Balance:</strong></td>
    <td class="lines">
      <input name="bankbal" type="text" id="bankbal" size="17" value="<?php echo round($bl,2); ?>" readonly="readonly"/>
      <input name="bankval" type="hidden" id="bankval" size="17" value="<?php echo $bl; ?>"/>    </td>
    <td class="lines">&nbsp;</td>
    </tr>
  <tr>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines"><strong>Statement Balance:</strong></td>
    <td class="lines">
      <input name="balcheck" type="text" id="balcheck" value="<?php echo round($obj->balcheck,2); ?>" size="17" onchange="loadBalance();" onkeyup="loadBalance();"/>    </td>
    <td class="lines">&nbsp;</td>
    </tr>
     <tr>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines">&nbsp;</td>
    <td class="lines"><strong>Balance:</strong></td>
    <td class="lines">
    <input name="balanceval" type="text" id="balanceval" value="" size="17" readonly="readonly"/>
      <input name="balance" type="hidden" id="balance" value="" size="17" readonly="readonly"/>    </td>
    <td class="lines">&nbsp;</td>
    </tr>
    <tr>
       <td class="lines">&nbsp; </td>
       <td class="lines">&nbsp;</td>
       <td class="lines">&nbsp;</td>
       <td class="lines">Upload Bank Statement:</td>
       <td colspan="2" class="lines"><input type="file" name="file" id="file" /></td>
       </tr>
     <tr>
       <td class="lines">&nbsp;</td>
       <td class="lines">&nbsp;</td>
       <td class="lines">&nbsp;</td>
       <td class="lines">&nbsp;</td>
       <td colspan="2" class="lines"><input type="submit" name="action" id="action" value="Reconcile Now" /></td>
       </tr>
  </tfoot>
</table>
</form>
			<table width="100%" border="0" align="center">
			<?php
            
			}
			else
			{
			?>
            <tr>
            <td colspan="7">No Transactions found</td>
            </tr>
            <?
			}
			}
			
            ?>
            </table>
            </div>
  <?php
include"../../../foot.php";
?>
