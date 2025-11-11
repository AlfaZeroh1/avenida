<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/issuance/Issuance_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/hrm/departments/Departments_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/prod/blocks/Blocks_class.php");
require_once("../../../modules/prod/sections/Sections_class.php");
require_once("../../../modules/prod/greenhouses/Greenhouses_class.php");
require_once("../../../modules/assets/fleets/Fleets_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/inv/categorys/Categorys_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");


$acctype=$_GET['acctype'];
$filter=$_GET['filter'];
$balance = $_GET['balance'];



if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

//connect to db
$db=new DB();

$obj=(object)$_POST;

if(!empty($acctype))
{
$obj->acctype=$acctype;
}

if(empty($obj->action)){
  $obj->currencyid=5;
}

//Authorization.
$auth->roleid="8814";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
  //$obj->fromtransactdate=date('Y-m-d',mktime(0,0,0,date("m")-5,date("d"),date("Y")));
  $obj->fromtransactdate=$_SESSION['startdate'];
  $obj->totransactdate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}
if(!empty($obj->fromtransactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate>'$obj->fromtransactdate'";
	$track++;
}
if(!empty($obj->totransactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate=<'$obj->totransactdate'";
	$track++;
}

$rptwhere=" fn_generaljournalaccounts.acctypeid=$obj->acctype ";
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//Processing Groupings
$rptgroup='';
$track=0;

$obj->idn=1;
$obj->acc=1;
$obj->bal=1;


//processing columns to show
	if(!empty($obj->acc)  or empty($obj->action)){
		array_push($sColumns, 'acc');
		array_push($aColumns, "fn_generaljournalaccounts.name as acc");
		$rptjoin.=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id ";
		$k++;
		}

	if(!empty($obj->bal)  or empty($obj->action)){
		array_push($sColumns, 'bal');
		array_push($aColumns, "(case when '$obj->currencyid=5' then round(sum(debit*rate)-sum(credit*rate),2) when '$obj->currencyid=1' then round(sum(debit*eurorate)-sum(credit*eurorate),2) else round(sum(debit*eurorate)-sum(credit*eurorate),2) end) bal");
		$k++;
		}

$track=0;


//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="fn_generaljournals";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']=" group by fn_generaljournals.accountid ";?>
 
$(document).ready(function() {
// 	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	 
	 
	
				
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
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			var total=0;
			for(var i=0; i<aaData.length; i++){
			  for(var j=2; j<aaData[i].length; j++){
				if(j=="<?php echo $mnt;?>"){
				  total+=parseInt(aaData[i][j]);
				  $('th:eq('+j+')', nRow).html(total);
				}
				else{
				  $('th:eq('+j+')', nRow).html("");
				}
			  }
			}
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
<form action="generaljournals4.php" method="post">
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
			<th>Account</th>
			<th>Balance</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	
	<tfoot>
	<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
