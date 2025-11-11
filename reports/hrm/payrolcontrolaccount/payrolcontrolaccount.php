<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeepayments/Employeepayments_class.php");
require_once("../../../modules/hrm/employeepaidarrears/Employeepaidarrears_class.php");
require_once("../../../modules/hrm/employeepaidsurchages/Employeepaidsurchages_class.php");
require_once("../../../modules/hrm/employeepaidallowances/Employeepaidallowances_class.php");
require_once("../../../modules/hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/assignments/Assignments_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/hrm/employeebanks/Employeebanks_class.php");
require_once("../../../modules/hrm/configs/Configs_class.php");
require_once("../../../modules/hrm/bankbranches/Bankbranches_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Payroll Control Account";
//connect to db
$db=new DB();

$generaljournals = new Generaljournals();
$shpgeneraljournals=array();

$it=0;

$obj=(object)$_POST;

$obj->currencyid=5;
$obj->rate=1;
$obj->exchangerate=1;

if($obj->action=="Effect Journals"){
  //redirect("../../../modules/fn/generaljournals/addgeneraljournals_proc.php");
  $gn = new Generaljournals();
  $obj->documentno=$obj->month."".$obj->year;
  $obj->transactionid=34;
  $obj->transactdate=date("Y-m-d");
  $shpgeneraljournals = $_SESSION['shpgeneraljournals'];
  $gn->add($obj,$shpgeneraljournals);
}

if($obj->action=="Update Journals"){
  //redirect("../../../modules/fn/generaljournals/addgeneraljournals_proc.php");
  $gn = new Generaljournals();
  $obj->documentno=$obj->month."".$obj->year;
  $obj->transactionid=34;
  $obj->transactdate=date("Y-m-d");
  $shpgeneraljournals = $_SESSION['shpgeneraljournals'];
  $gn->edit($obj,"",$shpgeneraljournals);
}

//Authorization.
$auth->roleid="8771";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

?>
<title><?php echo $page_title; ?></title>

<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>

</div>
<form  action="payrolcontrolaccount.php" method="post" name="employeepayments" >

<table width="100%" border="0" align="center">
<tr>
				<td>Month</td>
				<td><select name="month" id="month" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select></td>
				<td>Year</td>
				<td><select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
        <?php
        $query="select * from fn_generaljournals where documentno='$obj->month$obj->year' and transactionid=34";
        $rs = mysql_query($query);
        $bool=false;
        if(mysql_affected_rows()>0){
	  $bool=true;
        ?>
        <td>
        <strong>
        <?php
	  $rw = mysql_fetch_object($rs);
	  echo "JV No: ".$rw->jvno;
	 ?>
	 </strong>
	 <input type="hidden" name="jvno" value="<?php echo $rw->jvno; ?>"/>
	 </td>
	<?php
        }
        ?>
		<td colspan="2" align='center'>
		<input type="submit" class="btn" name="action" id="action" value="Filter" />
		<?php if(count($_SESSION['shpgeneraljournals'])>0 and !$bool){?>
		<input type="submit" class="btn" name="action" id="action" value="Effect Journals" />
		<?php }else{ ?>
		<input type="submit" class="btn" name="action" id="action" value="Update Journals" />
		<?php } ?>
		</td>
	</tr>
</table>
</form>
<table style="clear:both;"  class="tgrid display" id="" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<tr>
	<td valign="top">
	<table>
	
	<?php  
	
	$it=0;	
	
	$drtotal=0;
	$crtotal=0;
	$employeepayments = new Employeepayments();
	$fields="sum(hrm_employeepayments.basic) basic, sum(hrm_employeepayments.netpay) netpay";
	$join=" ";
	$where=" where hrm_employeepayments.month='$obj->month' and hrm_employeepayments.year='$obj->year' and month!='' and year!='' and month!=0 and year!=0 ";
	$having="";
	$groupby=" ";
	$orderby="";
	$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$employeepayments = $employeepayments->fetchObject;
	
	$drtotal+=$employeepayments->basic;
	$crtotal+=0;
	?>
	<tr>
	    <td>Basic Pay</td>
	    <td align="right"><?php echo formatNumber(round($employeepayments->basic,0)); ?></td>
	  </tr>
	<?php
	//get allowances
	$employeepaidallowances = new Employeepaidallowances();
	$fields="hrm_allowances.name, sum(hrm_employeepaidallowances.amount) amount";
	$join=" left join hrm_allowances on hrm_allowances.id=hrm_employeepaidallowances.allowanceid ";
	$where=" where hrm_employeepaidallowances.month='$obj->month' and hrm_employeepaidallowances.year='$obj->year' and employeeid in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and month!='' and year!='' and month!=0 and year!=0 and hrm_allowances.noncashbenefit!='Yes'";
	$having="";
	$groupby=" group by hrm_allowances.name order by hrm_allowances.id ";
	$orderby="";
	$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaidallowances->sql;
	$allowances=0;
	while($row=mysql_fetch_object($employeepaidallowances->result)){
	$allowances+=$row->amount;
	
	?>
	  <tr>
	    <td width="70%"><?php echo $row->name; ?></td>
	    <td width="30%" align="right"><?php echo formatNumber(round($row->amount,0)); ?></td>
	  </tr>
	<?php
	}	
	$drtotal+=$allowances;
	?>
	<?php
	//get allowances
	$employeepaidarrears = new Employeepaidarrears();
	$fields="hrm_arrears.name, sum(hrm_employeepaidarrears.amount) amount";
	$join=" left join hrm_arrears on hrm_arrears.id=hrm_employeepaidarrears.arrearid ";
	$where=" where hrm_employeepaidarrears.month='$obj->month' and hrm_employeepaidarrears.year='$obj->year' and employeeid in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and month!='' and year!='' and month!=0 and year!=0 ";
	$having="";
	$groupby=" group by hrm_arrears.name order by hrm_arrears.id ";
	$orderby="";
	$employeepaidarrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaidarrears->sql;
	$arrears=0;
	while($row=mysql_fetch_object($employeepaidarrears->result)){
	$arrears+=$row->amount;
	?>
	  <tr>
	    <td width="70%"><?php echo $row->name; ?></td>
	    <td width="30%" align="right"><?php echo formatNumber(round($row->amount,0)); ?></td>
	  </tr>
	<?php
	}//echo $arrears+$allowances;
	$drtotal+=$arrears;
	
	
	//get deductions
	$employeepaidsurcharges = new Employeepaidsurchages();
	$fields="hrm_surchages.name, sum(hrm_employeepaidsurchages.amount) amount";
	$join=" left join hrm_surchages on hrm_surchages.id=hrm_employeepaidsurchages.empsurchageid ";
	$where=" where hrm_employeepaidsurchages.month='$obj->month' and hrm_employeepaidsurchages.year='$obj->year' and employeeid in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and month!='' and year!='' and month!=0 and year!=0 and (hrm_surchages.taxable='No' or hrm_surchages.taxable='' or hrm_surchages.taxable is null) ";
	$having="";
	$groupby=" group by hrm_surchages.name order by hrm_surchages.id ";
	$orderby="";
	$employeepaidsurcharges->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaidsurcharges->sql;
	$surchagess=0;
	while($row=mysql_fetch_object($employeepaidsurcharges->result)){
	$surchagess-=$row->amount;
	?>
	  <tr>
	    <td width="70%"><?php echo $row->name; ?></td>
	    <td width="30%" align="right">(<?php echo formatNumber(round($row->amount,0)); ?>)</td>
	  </tr>
	<?php
	}
	$drtotal+=$surchagess;
	$employeepaiddeductions = new Employeepaiddeductions();
	$fields="hrm_deductions.name, sum(hrm_employeepaiddeductions.employeramount) amount, hrm_deductions.expenseid";
	$join=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
	$where=" where hrm_employeepaiddeductions.month='$obj->month' and hrm_employeepaiddeductions.year='$obj->year' and employeeid in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and month!='' and year!='' and month!=0 and year!=0 and deductionid not in(4,5) and reducing='Yes' and hrm_deductions.epays='Yes' ";
	$having="";
	$groupby=" group by hrm_deductions.name order by hrm_deductions.id ";
	$orderby="";
	$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$deductionss=0;
	while($row=mysql_fetch_object($employeepaiddeductions->result)){
	$deductionss+=$row->amount;
	
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$row->expenseid' and acctypeid='4'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;
	
	$generaljournal = new Generaljournals();
	$generaljournal->documentno=$obj->month."".$obj->year;
	$generaljournal->accountid=$generaljournalaccounts->id;
	$generaljournal->remarks=$row->name." ".getMonth($obj->month)." ".$obj->year;
	$generaljournal->memo=$row->name." ".getMonth($obj->month)." ".$obj->year;
	$generaljournal->debit=$row->amount;
	$generaljournal->credit=0;
	$generaljournal->transactdate=date("Y-m-d");
	$generaljournal->currencyid=5;
	$generaljournal->rate=1;
	$generaljournal->transactionid=34;
	
	$generaljournal = $generaljournal->setObject($generaljournal);
	
	$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
	$it++;
	
	?>
	  <tr>
	    <td width="70%"><?php echo $row->name; ?></td>
	    <td width="30%" align="right"><?php echo formatNumber(round($row->amount,0)); ?></td>
	  </tr>
	<?php
	}
	$drtotal+=$deductionss;
	?>
	
	</table>
	</td>
	<td>
	<table>
	<?php
	//get deductions
	$employeepaiddeductions = new Employeepaiddeductions();
	$fields="hrm_deductions.name, sum(hrm_employeepaiddeductions.amount+hrm_employeepaiddeductions.employeramount) amount, hrm_deductions.liabilityid";
	$join=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
	$where=" where hrm_employeepaiddeductions.month='$obj->month' and hrm_employeepaiddeductions.year='$obj->year' and employeeid in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and month!='' and year!='' and month!=0 and year!=0 and deductionid not in(4,5) and hrm_employeepaiddeductions.reducing='Yes' ";
	$having="";
	$groupby=" group by hrm_deductions.name order by hrm_deductions.id ";
	$orderby="";
	$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaiddeductions->sql;
	$deductions=0;
	while($row=mysql_fetch_object($employeepaiddeductions->result)){
	$deductions+=$row->amount;
	
	  $generaljournalaccounts = new Generaljournalaccounts();
	  $fields="*";
	  $where=" where refid='$row->liabilityid' and acctypeid='35'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
	  
	  $generaljournal = new Generaljournals();
	  $generaljournal->documentno=$obj->month."".$obj->year;
	  $generaljournal->accountid=$generaljournalaccounts->id;
	  $generaljournal->remarks=$row->name." ".getMonth($obj->month)." ".$obj->year;
	  $generaljournal->memo=$row->name." ".getMonth($obj->month)." ".$obj->year;
	  $generaljournal->credit=$row->amount;
	  $generaljournal->debit=0;
	  $generaljournal->transactdate=date("Y-m-d");
	  $generaljournal->currencyid=5;
	  $generaljournal->rate=1;
	  $generaljournal->transactionid=34;
	  
	  $generaljournal = $generaljournal->setObject($generaljournal);
	  
	  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
	  $it++;
	?>
	  <tr>
	    <td width="70%"><?php echo $row->name; ?></td>
	    <td width="30%" align="right"><?php echo formatNumber(round($row->amount,0)); ?></td>
	  </tr>
	<?php
	}
	$crtotal+=$deductions;
	?>
	<?php
	//get deductions
	$employeepaiddeductions = new Employeepaiddeductions();
	$fields="hrm_loans.name, sum(hrm_employeepaiddeductions.amount) amount, hrm_loans.liabilityid";
	$join=" left join hrm_loans on hrm_loans.id=hrm_employeepaiddeductions.loanid ";
	$where=" where hrm_employeepaiddeductions.month='$obj->month' and hrm_employeepaiddeductions.year='$obj->year' and employeeid in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and month!='' and year!='' and month!=0 and year!=0 and deductionid in(4,5) and hrm_employeepaiddeductions.reducing='Yes' ";
	$having="";
	$groupby=" group by hrm_loans.name order by hrm_loans.id ";
	$orderby="";
	$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaiddeductions->sql;
	$loans=0;
	while($row=mysql_fetch_object($employeepaiddeductions->result)){
	$loans+=$row->amount;
	
	  $generaljournalaccounts = new Generaljournalaccounts();
	  $fields="*";
	  $where=" where refid='$row->liabilityid' and acctypeid='35'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
	  
	  $generaljournal = new Generaljournals();
	  $generaljournal->documentno=$obj->month."".$obj->year;
	  $generaljournal->accountid=$generaljournalaccounts->id;
	  $generaljournal->remarks=$row->name." ".getMonth($obj->month)." ".$obj->year;
	  $generaljournal->memo=$row->name." ".getMonth($obj->month)." ".$obj->year;
	  $generaljournal->credit=$row->amount;
	  $generaljournal->debit=0;
	  $generaljournal->transactdate=date("Y-m-d");
	  $generaljournal->currencyid=5;
	  $generaljournal->rate=1;
	  $generaljournal->transactionid=34;
	  
	  $generaljournal = $generaljournal->setObject($generaljournal);
	  
	  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
	  $it++;
	?>
	  <tr>
	    <td width="70%"><?php echo $row->name; ?></td>
	    <td width="30%" align="right"><?php echo formatNumber(round($row->amount,0)); ?></td>
	  </tr>
	<?php
	}
	$crtotal+=$loans;
	?>	
	<?php
	//get deductions
	$employeepaidsurcharges = new Employeepaidsurchages();
	$fields="hrm_surchages.name, sum(hrm_employeepaidsurchages.amount) amount, hrm_surchages.expenseid";
	$join=" left join hrm_surchages on hrm_surchages.id=hrm_employeepaidsurchages.empsurchageid ";
	$where=" where hrm_employeepaidsurchages.month='$obj->month' and hrm_employeepaidsurchages.year='$obj->year' and employeeid in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and month!='' and year!='' and month!=0 and year!=0 and hrm_surchages.taxable='Yes' ";
	$having="";
	$groupby=" group by hrm_surchages.name order by hrm_surchages.id ";
	$orderby="";
	$employeepaidsurcharges->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaidsurcharges->sql;
	$surchages=0;
	while($row=mysql_fetch_object($employeepaidsurcharges->result)){
	$surchages+=$row->amount;
	
	  $generaljournalaccounts = new Generaljournalaccounts();
	  $fields="*";
	  $where=" where refid='$row->expenseid' and acctypeid='4'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
	  
	  $generaljournal = new Generaljournals();
	  $generaljournal->documentno=$obj->month."".$obj->year;
	  $generaljournal->accountid=$generaljournalaccounts->id;
	  $generaljournal->remarks=$row->name." ".getMonth($obj->month)." ".$obj->year;
	  $generaljournal->memo=$row->name." ".getMonth($obj->month)." ".$obj->year;
	  $generaljournal->debit=0;
	  $generaljournal->credit=$row->amount;
	  $generaljournal->transactdate=date("Y-m-d");
	  $generaljournal->currencyid=5;
	  $generaljournal->rate=1;
	  $generaljournal->transactionid=34;
	  
	  $generaljournal = $generaljournal->setObject($generaljournal);
	  
	  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
	  $it++;
	
	?>
	  <tr>
	    <td width="70%"><?php echo $row->name; ?></td>
	    <td width="30%" align="right"><?php echo formatNumber(round($row->amount,0)); ?></td>
	  </tr>
	<?php
	}
	$crtotal+=$surchages;
	
	$configs = new Configs();
	$fields="hrm_configs.id, hrm_configs.name, hrm_configs.value";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id=4 ";
	$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$config = $configs->fetchObject;
	
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$config->value' and acctypeid='4'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;
	
	$generaljournal = new Generaljournals();
	$generaljournal->documentno=$obj->month."".$obj->year;
	$generaljournal->accountid=$generaljournalaccounts->id;
	$generaljournal->remarks="Payroll for ".getMonth($obj->month)." ".$obj->year;
	$generaljournal->memo="Payroll for ".getMonth($obj->month)." ".$obj->year;
	$generaljournal->debit=($employeepayments->basic+$allowances+$surchagess);
	$generaljournal->credit=0;
	$generaljournal->transactdate=date("Y-m-d");
	$generaljournal->currencyid=5;
	$generaljournal->rate=1;
	$generaljournal->transactionid=34;
	
	$generaljournal = $generaljournal->setObject($generaljournal);
	
	$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
	$it++;
	
	$configs = new Configs();
	$fields="hrm_configs.id, hrm_configs.name, hrm_configs.value";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id=3 ";
	$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$config = $configs->fetchObject;
	
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields="*";
	$where=" where refid='$config->value' and acctypeid='35'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;
	
	$generaljournal->documentno=$obj->month."".$obj->year;
	$generaljournal->accountid=$generaljournalaccounts->id;
	$generaljournal->remarks="Net Pay ".getMonth($obj->month)." ".$obj->year;
	$generaljournal->memo="Net Pay ".getMonth($obj->month)." ".$obj->year;
	$generaljournal->credit=($employeepayments->netpay);
	$generaljournal->debit=0;
	$generaljournal->transactdate=date("Y-m-d");
	$generaljournal->currencyid=5;
	$generaljournal->rate=1;
	$generaljournal->transactionid=34;
	
	$generaljournal = $generaljournal->setObject($generaljournal);
	
	$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
	$it++;
	
	$_SESSION['shpgeneraljournals']=$shpgeneraljournals;
	
// 	$employeepayments->netpay=$employeepayments->basic+$allowances+$arrears-($deductions+$loans+$surchages);
	$crtotal+=$employeepayments->netpay;
	?>
	<tr>
	    <td width="70%">Net Pay<?php echo ": ".$generaljournalaccounts->name; ?></td>
	    <td width="30%" align="right"><?php echo formatNumber(round($employeepayments->netpay,0)); ?></td>
	  </tr>
	</table>
	</td>
	</tr>
	<tr>
	<td>
	<table>
	  <tr>
	  <td width="70%">&nbsp;</td>
	  <td width="30%" align="right"><?php echo formatNumber(round($drtotal,0));?></td>
	  <tr>
	</table>
	</td>
	<td>
	<table>
	  <tr>
	  <td width="70%">&nbsp;</td>
	  <td width="30%" align="right"><?php echo formatNumber(round($crtotal,0));?></td>
	  <tr>
	  </td>
	</table>	
	</tr>
	</table>
</div>
</div>
</div>
</div>
</div>