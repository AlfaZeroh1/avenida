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
$rptwhere='';
if(!empty($acctype) or !empty($obj->acctype)){
  if(!empty($acctype)){
	$obj->acctype=$acctype;
	}
	$rptwhere='  fn_generaljournalaccounts.acctypeid='.$obj->acctype;
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
  $obj->fromtransactdate=date('Y-m-d',mktime(0,0,0,date("m")-5,date("d"),date("Y")));
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
<script type="text/javascript" charset="utf-8">
<?php 

$first=date('Y-m-d',mktime(0,0,0,date("m")-6,01,date("Y")));
$second=date('Y-m-d',mktime(0,0,0,date("m")-5,01,date("Y")));
$third=date('Y-m-d',mktime(0,0,0,date("m")-4,01,date("Y")));
$fourth=date('Y-m-d',mktime(0,0,0,date("m")-3,01,date("Y")));
$fifth=date('Y-m-d',mktime(0,0,0,date("m")-2,01,date("Y")));
$sixth=date('Y-m-d',mktime(0,0,0,date("m")-1,01,date("Y")));
$seventh=date('Y-m-d',mktime(0,0,0,date("m"),01,date("Y")));
$eigth=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));

$month1 = date("M",strtotime($first));
$month2 = date("M",strtotime($second));
$month3 = date("M",strtotime($third));
$month4 = date("M",strtotime($fourth));
$month5 = date("M",strtotime($fifth));
$month6 = date("M",strtotime($sixth));
$month7 = date("M",strtotime($seventh));

//$sql1 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$first' "; 
if(empty($obj->currencyid)){
$sql1 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$first' and fn_generaljournals.transactdate<'$second' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql2 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$second' and fn_generaljournals.transactdate<'$third' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql3 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$third' and fn_generaljournals.transactdate<'$fourth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql4 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$fourth' and fn_generaljournals.transactdate<'$fifth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql5 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$fifth' and fn_generaljournals.transactdate<'$sixth'and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql6 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$sixth' and fn_generaljournals.transactdate<'$seventh' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql7 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$seventh' and fn_generaljournals.transactdate<='$eigth'and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql8 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$eigth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql9 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end)-(case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)-(case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
}elseif($obj->currencyid==5){
$sql1 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$first' and fn_generaljournals.transactdate<'$second' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql2 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$second' and fn_generaljournals.transactdate<'$third'and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql3 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$third' and fn_generaljournals.transactdate<'$fourth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql4 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$fourth' and fn_generaljournals.transactdate<'$fifth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql5 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$fifth' and fn_generaljournals.transactdate<'$sixth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql6 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$sixth' and fn_generaljournals.transactdate<'$seventh' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql7 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$seventh' and fn_generaljournals.transactdate<='$eigth'and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql8 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$eigth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql9 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end)-(case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end) when lower(sys_acctypes.balance*rate)='cr' then (case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end)-(case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
}elseif($obj->currencyid==1){
$sql1 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$first' and fn_generaljournals.transactdate<'$second' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql2 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$second' and fn_generaljournals.transactdate<'$third'and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql3 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$third' and fn_generaljournals.transactdate<'$fourth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql4 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$fourth' and fn_generaljournals.transactdate<'$fifth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql5 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$fifth' and fn_generaljournals.transactdate<'$sixth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql6 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$sixth' and fn_generaljournals.transactdate<'$seventh'and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
$sql7 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>='$seventh' and fn_generaljournals.transactdate<='$eigth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql8 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$eigth' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00'";
$sql9 = "select case when lower(sys_acctypes.balance)='dr' then (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end)-(case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) when lower(sys_acctypes.balance)='cr' then (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end)-(case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
}

if($obj->show=="All" or $_GET['tb']==false)
	$join=" right outer join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid ".$jn;
else 
	$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid ".$jn;
?>
 <?php $_SESSION['aColumns']=array('fn_generaljournalaccounts.id as id', 'upper(fn_generaljournalaccounts.name) as accountid', 'upper(sys_currencys.name) as currencyid', '('.$sql7.') "'.$month7.'"', '('.$sql6.') "'.$month6.'"','('.$sql5.') "'.$month5.'"','('.$sql4.') "'.$month4.'"','('.$sql3.') "'.$month3.'"','('.$sql2.') "'.$month2.'"','('.$sql1.') "'.$month1.'"','('.$sql8.') prepayment','('.$sql9.') balance');?>
 <?php $_SESSION['sColumns']=array('id', 'accountid','currencyid' ,''.$month7.'', ''.$month6.'', ''.$month5.'', ''.$month4.'', ''.$month3.'', ''.$month2.'', ''.$month1.'','prepayment','balance');?>
 <?php $_SESSION['join']=$join;?>
 <?php $_SESSION['sTable']="fn_generaljournals";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']=$rptwhere;?>
 <?php $_SESSION['sGroup']=$rptgroup;?>
 
 $(document).ready(function() {
 
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_generaljournals",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			console.log(aaData);
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html('<a href="account.php?id='+aaData[0]+'" target="_blank">'+aaData[1]+'</a>');	
			$('td:eq(2)', nRow).html(aaData[2]).attr('align','center');
			$('td:eq(3)', nRow).html(aaData[3]).formatCurrency().attr('align','center');
			$('td:eq(4)', nRow).html(aaData[4]).formatCurrency().attr('align','center');
			http://localhost/magana/reports/fn/generaljournals/generaljournals3.php?acctype=30&filter=true&balance=true$('td:eq(4)', nRow).html(aaData[4]).formatCurrency().attr('align','center');
			$('td:eq(5)', nRow).html(aaData[5]).formatCurrency().attr('align','center');
			$('td:eq(6)', nRow).html(aaData[6]).formatCurrency().attr('align','center');
			$('td:eq(7)', nRow).html(aaData[7]).formatCurrency().attr('align','center');
			$('td:eq(8)', nRow).html(aaData[8]).formatCurrency().attr('align','center');
			$('td:eq(9)', nRow).html(aaData[9]).formatCurrency().attr('align','center');
			$('td:eq(10)', nRow).html('<strong>'+(aaData[10])+'</strong>').formatCurrency().attr('align','center');
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			/*
			 * Calculate the total market share for all browsers in this table (ie inc. outside
			 * the pagination)
			 */
			 //try{alert(aaData[2][2]);}catch(e){alert(e);}
			var tfirst = 0;
			var tsecond = 0;
			var tthird = 0;
			var tfourth = 0;
			var tfifth = 0;
			var tsixth = 0;
			var tseventh = 0;
			var prepay = 0;
			var tt = 0;

			for ( var i=0 ; i<aaData.length ; i++ )
			{	
				prepay+=(aaData[i][10]*1);
				tfirst+=(aaData[i][9]*1);
				tsecond+=(aaData[i][8]*1);
				tthird+=(aaData[i][7]*1);
				tfourth+=(aaData[i][6]*1);
				tfifth+=(aaData[i][5]*1);
				tsixth+=(aaData[i][4]*1);
				tseventh+=(aaData[i][3]*1);
				
				tt = tfirst+tsecond+tthird+tfourth+tfifth+tsixth+tseventh+prepay;
			}
						
			/* Modify the footer row to match what we want */
			$('th:eq(3)', nRow).html(tfirst).formatCurrency().attr('align','right');
			$('th:eq(4)', nRow).html(tsecond).formatCurrency().attr('align','right');
			$('th:eq(5)', nRow).html(tthird).formatCurrency().attr('align','right');
			$('th:eq(6)', nRow).html(tfourth).formatCurrency().attr('align','right');
			$('th:eq(7)', nRow).html(tfifth).formatCurrency().attr('align','right');
			$('th:eq(8)', nRow).html(tsixth).formatCurrency().attr('align','right');
			$('th:eq(9)', nRow).html(tseventh).formatCurrency().attr('align','right');
			$('th:eq(10)', nRow).html(prepay).formatCurrency().attr('align','right');
			$('th:eq(11)', nRow).html(tt).formatCurrency().attr('align','right');
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
<form action="generaljournals3.php" method="post">
<table>
  <tr>
    <td>From: <input type="text" size="12" class="date_input" name="fromtransactdate" value="<?php echo $obj->fromtransactdate; ?>"/></td>
   <td>To: <input type="text" size="12" class="date_input" name="totransactdate" value="<?php echo $obj->totransactdate; ?>"/></td>&nbsp;
    <td>Currency: <select name="currencyid" class="selectbox">
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
			      </select>&nbsp;
			      <input type="hidden" name="grp" value="<?php echo $obj->grp; ?>"/>
			       <input type="hidden" name="acctype" value="<?php echo $obj->acctype; ?>"/>
			      <input type="submit" name="action" class="btn" value="Filter"/> </td>
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
			<th><?php echo $month7; ?></th>
			<th><?php echo $month6; ?></th>
			<th><?php echo $month5; ?></th>
			<th><?php echo $month4; ?></th>
			<th><?php echo $month3; ?></th>
			<th><?php echo $month2; ?></th>
			<th><?php echo $month1; ?></th>
			<th>Pre-payment</th>
			<th>Balance </th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	<tfoot>
	    <tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Total </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp; </th>
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
