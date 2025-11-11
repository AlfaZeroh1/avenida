<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");

$acctype=$_GET['acctype'];
$filter=$_GET['filter'];
$balance = $_GET['balance'];

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$auth->roleid="8756";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);



$page_title="Generaljournals";
//connect to db   
$db=new DB();

$obj=(object)$_POST;

if(empty($obj->action)){
  $obj->currencyid=5;
}

$rptwhere='';
//$where=" where fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
if(!empty($acctype) or !empty($obj->acctype)){
  if(!empty($acctype)){
	$obj->acctype=$acctype;
	}
	$rptwhere='  fn_generaljournalaccounts.acctypeid='.$obj->acctype;
	if($obj->acctype==29){
	  $rptwhere.=" and fn_generaljournalaccounts.refid in(select id from crm_customers) ";
	}elseif($obj->acctype==30){
	  $rptwhere.=" and fn_generaljournalaccounts.refid in(select id from proc_suppliers) ";
	}
}
if(!empty($filter)){
	$obj->filter=$filter;
}
if(!empty($balance)){
	$obj->balance=$balance;
}
include "../../../head.php";

//processing filters
if(empty($obj->action)){
  //$obj->fromtransactdate=date('Y-m-d',mktime(0,0,0,date("m")-5,date("d"),date("Y")));
  $obj->fromtransactdate=$_SESSION['startdate'];
  $obj->totransactdate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}

$track=1;
if(!empty($obj->accountid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.accountid='$obj->accountid'";
	$track++;
}

if(!empty($obj->transactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate='$obj->transactdate'";
	$track++;
}
if(!empty($obj->shippingid)){
	if($track>0)
		$rptwhere.=" and";
	else
		$rptwhere.=" where";

	$rptwhere.=" motor_vehicles.shippingid='$obj->shippingid'";
	$jn=" left join motor_vehicles on motor_vehicles.id=fn_generaljournals.tid ";
	$track++;
}

$having="";
if($obj->prepaid=="prepaid"){
  if(!empty($having))
    $having.=" or ";
  else
    $having.=" having ";
  $having.=" balance<0 ";
}
if($obj->nill=="nill"){
  if(!empty($having))
    $having.=" or ";
  else
    $having.=" having ";
  $having.=" balance=0 ";
}

if($obj->accrued=="accrued"){
  if(!empty($having))
    $having.=" or ";
  else
    $having.=" having ";
  $having.=" balance>0 ";
}


//Processing Groupings
$rptgroup=' group by id';
$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
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
</script>

<style media="all" type="text/css">
.red {
/* background-color:#e36f6f !important; */
text-color:red;
color:red !important;
}
.bold {
/* background-color:#88b645 !important; */
color:black !important;
text-style:bold;
background-color:#e36f6f !important;
}
.gray {
/* background-color:#88b645 !important; */
color:black !important;
text-style:bold;
background-color:gray !important;
}
</style>

<?php 

$first=date('Y-m-d',mktime(0,0,0,date("m"),date("d")-60,date("Y")));
$second=date('Y-m-d',mktime(0,0,0,date("m"),date("d")-30,date("Y")));
$sql7=7;
if(empty($obj->currencyid)){

$sql7 = "(case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)  else (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end) ";

$sql70 = "(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)  when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) else 0 end) ";

$sql0 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<='$obj->fromtransactdate' and fn_generaljournals.transactdate!='0000-00-00'";

$sql01 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<='$obj->fromtransactdate' and fn_generaljournals.transactdate!='0000-00-00' and fn_generaljournals.transactionid=24"; 

$sql05 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' and fn_generaljournals.transactdate!='0000-00-00'"; 

$sql1 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<='$first' and fn_generaljournals.transactdate!='0000-00-00'"; 
$sql2 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$first' and fn_generaljournals.transactdate<='$second' and fn_generaljournals.transactdate!='0000-00-00'";
$sql3 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$second' and fn_generaljournals.transactdate!='0000-00-00'";
$sql4 = "select case when lower(sys_acctypes.balance)='dr' then ((case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end)-(case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)) when lower(sys_acctypes.balance)='cr' then ((case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)-(case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end)) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
$sqlt = "select case when lower(sys_acctypes.balance)='dr' then ((case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end)-(case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)) when lower(sys_acctypes.balance)='cr' then ((case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)-(case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end)) end from fn_generaljournals left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid where $rptwhere ";
}
elseif($obj->currencyid==5){

//get total payments including returns for deriving aging 
$case="";
if($obj->acctype==29)
  $case="fn_generaljournals.transactionid=21 or fn_generaljournals.transactionid=24 or fn_generaljournals.transactionid=20";

if($obj->acctype==30)
  $case="fn_generaljournals.transactionid=28 or fn_generaljournals.transactionid=24 or fn_generaljournals.transactionid=23";
  
$sql7 = "sum(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate<='$obj->totransactdate' and ($case) then (case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end)  when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate<='$obj->totransactdate' and ($case) then (case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end) end) ";

//get total of payments made after fromtransactdate to today
$case="";
if($obj->acctype==29)
  $case="fn_generaljournals.transactionid=21 or fn_generaljournals.transactionid=20 or fn_generaljournals.transactionid=0";

if($obj->acctype==30)
  $case="fn_generaljournals.transactionid=28 or fn_generaljournals.transactionid=23 or fn_generaljournals.transactionid=0";
  
$sql70 = "sum(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' and ($case ) then (case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end)  when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate'  and ($case) then (case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end) else 0 end) ";

//get account balances as at fromtransactdate
$sql0 = "sum(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate<'$obj->fromtransactdate' then (case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end) - (case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end) when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate<'$obj->fromtransactdate' then (case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end) - (case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end) else 0 end)";


//get total for returns of this account after transactdate
$sql01 = "sum(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' and fn_generaljournals.transactionid=24 then (case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end)  when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate'  and fn_generaljournals.transactionid=24 then (case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end) else 0 end) ";

//get balance for invoices raised after the fromtransactdate
$case="";
if($obj->acctype==29)
  $case="fn_generaljournals.transactionid=20 or fn_generaljournals.transactionid=0";
  
if($obj->acctype==30)
  $case="fn_generaljournals.transactionid=23 or fn_generaljournals.transactionid=0";
  
$sql05 = "sum(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate'  then (case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end) when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' then (case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end) else 0 end ) "; 

//get balance which is above 60 days
$sql1 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.debit*fn_generaljournals.rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.credit*fn_generaljournals.rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<'$first' and fn_generaljournals.transactdate!='0000-00-00' and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' "; 

//get balance whose age is between 30 and 60 days
$sql2 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.debit*fn_generaljournals.rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.credit*fn_generaljournals.rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$first' and fn_generaljournals.transactdate<'$second' and fn_generaljournals.transactdate!='0000-00-00' and fn_generaljournals.transactdate<='$obj->totransactdate' ";

//get balance whose age is in the last 30 days
$sql3 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.debit*fn_generaljournals.rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.credit*fn_generaljournals.rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$second' and fn_generaljournals.transactdate!='0000-00-00' and fn_generaljournals.transactdate<='$obj->totransactdate' ";

//get absolute account status
$sql4 = "sum(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate<='$obj->totransactdate' then ((case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end)-(case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end)) when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate<='$obj->totransactdate' then ((case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end)-(case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end)) else 0 end) ";

//get absolute account type totals for calculating %
$sqlt = "select case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate<='$obj->totransactdate' then ((case when sum(fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.debit*fn_generaljournals.rate) end)-(case when sum(fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.credit*fn_generaljournals.rate) end)) when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate<='$obj->totransactdate' then ((case when sum(fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.credit*fn_generaljournals.rate) end)-(case when sum(fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else sum(fn_generaljournals.debit*fn_generaljournals.rate) end)) end from fn_generaljournals left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid where $rptwhere ";

}elseif($obj->currencyid==1){
$sql7 = "(case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end)  else (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end) ";

$sql0 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<='$obj->fromtransactdate' and fn_generaljournals.transactdate!='0000-00-00'";

$sql01 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<='$obj->fromtransactdate' and fn_generaljournals.transactdate!='0000-00-00' and fn_generaljournals.transactionid=24"; 

$sql05 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' and fn_generaljournals.transactdate!='0000-00-00'"; 

$sql1 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<='$first' and fn_generaljournals.transactdate!='0000-00-00'"; 

$sql2 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) end end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$first' and fn_generaljournals.transactdate<='$second' and fn_generaljournals.transactdate!='0000-00-00'";

$sql3 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$second' and fn_generaljournals.transactdate!='0000-00-00'";

$sql4 = "select case when lower(sys_acctypes.balance)='dr' then ((case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) - (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end)) when lower(sys_acctypes.balance)='cr' then ((case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) - (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end)) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";

}

if($obj->show=="All" or $_GET['tb']==false)
	$join=" right outer join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid  ".$jn;
else 
	$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid  ".$jn;
?>
 <?php $_SESSION['aColumns']=array('fn_generaljournalaccounts.id as id', 'upper(fn_generaljournalaccounts.name) as accountid', 'upper(sys_currencys.name) as currencyid','('.$sql7.') paid','('.$sql1.') first', '('.$sql2.') second','('.$sql3.') third','('.$sql4.') balance', '('.$sql0.') opening', '('.$sql05.') invoiced','1','1', '('.$sql01.') returns','('.$sql70.') remmittance','('.$sqlt.') total');?>
 <?php $_SESSION['sColumns']=array('id', 'accountid','currencyid','paid', 'first', 'second','third','balance','opening','invoiced','1','1','returns','remmittance','total');?>
 <?php $_SESSION['join']=$join;?>
 <?php $_SESSION['sTable']="fn_generaljournals";?>
 <?php $_SESSION['sOrder']="  group by id $having order by trim(fn_generaljournalaccounts.name)  ";?>
 <?php $_SESSION['sWhere']=$rptwhere;?>
 <?php $_SESSION['sGroup']="";?>

<script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
  
 	$('#tbl').dataTable( {
		"scrollX": true,
	      dom: 'lBfrtip',
		"buttons": [
		 'copy', 'csv', 'excel', 'print',{
		    extend: 'pdfHtml5',
		    orientation: 'landscape',
		    pageSize: 'LEGAL'
		}],
		"aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":2000,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "processing.php?sTable=fn_generaljournals",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			//should only happen on initial load but not on searching the dataTable
// 			var balance = aaData[3];
// 			if(aaData[4]>0 && balance>0){
// 			  
// 			  if(aaData[4]<=balance){
// 			    balance=balance-aaData[4];
// 			    aaData[4]=0;
// 			  }
// 			  else{
// 			    aaData[4]-=balance;
// 			    if(aaData[4]<0){
// 			      balance = aaData[4];
// 			      aaData[4]=0;
// 			    }
// 			    else
// 			      balance = 0;
// 			  }
// 			  if(balance<0)
// 			    balance*=-1;
// 			}
// 			if(aaData[5]>0 && balance>0){
// 			  
// 			  if(aaData[5]<=balance){
// 			    balance-=aaData[5];
// 			    aaData[5]=0;
// 			  }
// 			  else{
// 			    aaData[5]-=balance;
// 			    if(aaData[5]<0){
// 			      balance = aaData[5];
// 			      aaData[5]=0;
// 			    }
// 			    else
// 			      balance = 0;
// 			  }
// 			  if(balance<0)
// 			    balance*=-1;
// 			}
// 			if(aaData[6]>0 && balance>0){
// 			  if(aaData[6]<=balance){
// 			    aaData[6]-=balance;
// 			  }
// 			  else{
// 			    aaData[6]-=balance;
// 			  }
// 			}else{
// 			  if(balance>0)
// 			    aaData[6]-=balance;
// 			}
			
 			var openingbal = parseFloat(aaData[8])+parseFloat(aaData[9])-parseFloat(aaData[12])-parseFloat(aaData[13]);
 			var perc =   1;
 			
 			
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html('<a href="account.php?id='+aaData[0]+'" target="_blank">'+aaData[1]+'</a>');
			$('td:eq(2)', nRow).html(aaData[2]).attr('align','right');
			$('td:eq(3)', nRow).html(aaData[8]).formatCurrency().attr('align','right');
			$('td:eq(4)', nRow).html(aaData[9]).formatCurrency().attr('align','right');
			$('td:eq(5)', nRow).html(aaData[12]).formatCurrency().attr('align','right').addClass("red");
			$('td:eq(6)', nRow).html(aaData[13]).formatCurrency().attr('align','right');			
			$('td:eq(7)', nRow).html(aaData[10]).formatCurrency().attr('align','right').addClass("bold");
			$('td:eq(8)', nRow).html(aaData[4]).formatCurrency().attr('align','right');
			$('td:eq(9)', nRow).html(aaData[5]).formatCurrency().attr('align','right');
			$('td:eq(10)', nRow).html(aaData[6]).formatCurrency().attr('align','right');
			$('td:eq(11)', nRow).html('<strong>'+(aaData[7])+'</strong>').formatCurrency().attr('align','right').addClass("bold");
			$('td:eq(12)', nRow).html(Math.round(aaData[11]*Math.pow(10,2))/Math.pow(10,2)+"%").attr('align','right');
			$('td:eq(13)', nRow).html("");
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			/*
			 * Calculate the total market share for all browsers in this table (ie inc. outside
			 * the pagination)
			 */
			 //try{alert(aaData[2][2]);}catch(e){alert(e);}
			var t3 = 0;
			var t4 = 0;
			var t5 = 0;
			var t6 = 0;
			var t7 = 0;
			var t8 = 0;
			var t9 = 0;
			var t10 = 0;
			var t11 = 0;
			var t12 = 0;

			for ( var i=0 ; i<aaData.length ; i++ )
			{				
				t3+=(aaData[i][8]*1);
				t4+=(aaData[i][9]*1);
				t5+=(aaData[i][12]*1);
				t6+=(aaData[i][3]*1);
				t7+=(aaData[i][10]*1);
				t8+=(aaData[i][4]*1);
				t9+=(aaData[i][5]*1);
				t10+=(aaData[i][6]*1);
				t11+=(aaData[i][7]*1);
				t12+=(aaData[i][11]*1);
				
			}
				
				t12 = Math.round(t12*Math.pow(10,2))/Math.pow(10,2);
			/* Modify the footer row to match what we want */
			$('td:eq(3)', nRow).html(t3).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(4)', nRow).html(t4).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(5)', nRow).html(t5).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(6)', nRow).html(t6).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(7)', nRow).html(t7).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(8)', nRow).html(t8).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(9)', nRow).html(t9).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(10)', nRow).html(t10).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(11)', nRow).html(t11).formatCurrency().attr('align','right').addClass("gray");
			$('td:eq(12)', nRow).html(t12+"%").formatCurrency().addClass("gray");
		}
 	} );
 } );
 </script>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<form action="generaljournals2.php" method="post">
<table>
  <tr>
    <td>From:</td> 
    <td><input type="text" size="12" readonly class="date_input" name="fromtransactdate" value="<?php echo $obj->fromtransactdate; ?>"/></td>
   <td>To:</td>
   <td><input type="text" size="12" readonly class="date_input" name="totransactdate" value="<?php echo $obj->totransactdate; ?>"/></td>
    <td>Currency:</td> 
    <td><select name="currencyid" class="selectbox">
				<option value="">Select...</option>  
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
			      <input type="hidden" name="grp" value="<?php echo $obj->grp; ?>"/>
			      <input type="hidden" name="acctype" value="<?php echo $obj->acctype; ?>"/></td>
			      <td><input type="checkbox" name="prepaid" value="prepaid" <?php if($obj->prepaid=="prepaid"){echo "checked";} ?>/>Pre Paid</td>
			      <td><input type="checkbox" name="nill" value="nill" <?php if($obj->nill=="nill"){echo "checked";} ?>/>Nill Balance</td>
			      <td><input type="checkbox" name="accrued" value="accrued" <?php if($obj->accrued=="accrued"){echo "checked";} ?>/>Accruing</td>
			      <td><input type="submit" name="action" class="btn" value="Filter"/> </td>
  </tr>
</table>
</form>
<div style="clear"></div>
<div>

<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Account </th>
			<th>Currency </th>
			<th>Opening Balance</th>
			<th>Invoices</th>
			<th>Credit Notes</th>
			<th>Payments </th>
			<th>Balances</th>
			<th>60 Days and Above</th>
			<th>30 - 60 Days</th>
			<th>30 Days</th>
			<th>Balance </th>
			<th>%</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	<tfoot>
	    <tr>
			<td>&nbsp;</td>
			<td>Total</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td>&nbsp;</td>
		</tr>
	</tfoot>
</table>

</div>
<!--/div>
</div-->

<!--</div>
</div>
</div>
</div>
</div>-->
