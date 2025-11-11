<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournalaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Generaljournalaccounts";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="756";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$generaljournalaccounts=new Generaljournalaccounts();
if(!empty($delid)){
                $generaljournals=new Generaljournals();
		$fields="*";
		$join="";
		$where=" where accountid='$delid' " ;
		$having="";
		$groupby="";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals->sql;
		$affected=$generaljournals->affectedRows;//echo $affected;
		//echo 'here';
		if($affected==0)
		{
	    	$generaljournalaccounts->id=$delid;
		$generaljournalaccounts->delete($generaljournalaccounts);
		redirect("generaljournalaccounts.php");
		}
		else
		{
		$error='account already has transactions';
// 		redirect("generaljournalaccounts.php");
		}
}
if(!empty($error)){
	showError($error);
	redirect("generaljournalaccounts.php");
}

//Authorization.
$auth->roleid="755";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addgeneraljournalaccounts_proc.php',600,430);" value="Add Generaljournalaccounts " type="button"/></div>
<?php }?>

<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=array('fn_generaljournalaccounts.id', ' fn_generaljournalaccounts.code', ' fn_generaljournalaccounts.name', ' sys_currencys.name as currencyid', ' sys_acctypes.name as acctypeid','fn_generaljournalaccounts.refid','1','1');?>
 <?php $_SESSION['sColumns']=array('id','code','name','currencyid','acctypeid','refid','1','1');?>
 <?php $_SESSION['join']=" left join sys_acctypes on fn_generaljournalaccounts.acctypeid=sys_acctypes.id left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid ";?>
 <?php $_SESSION['sTable']=" fn_generaljournalaccounts ";?> 
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="";?>
 <?php $_SESSION['sGroup']="";?>
 $(document).ready(function() {
	 //TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#tbl').dataTable( {
 		
		"sAjaxSource": "../../server/server/processing.php?sTable=fn_generaljournalaccounts",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html(aaData[1]);
			$('td:eq(2)', nRow).html("<a href='../../../reports/fn/generaljournals/account.php?id="+aaData[0]+"'>"+aaData[2]+"</a>");
			$('td:eq(3)', nRow).html(aaData[5]);
			$('td:eq(4)', nRow).html(aaData[3]);
			$('td:eq(5)', nRow).html(aaData[4]);
			$('td:eq(6)', nRow).html("<a href='javascript:;' onclick='showPopWin(&quot;addgeneraljournalaccounts_proc.php?id="+aaData[0]+"&quot;, 600, 600);'><img src='../view.png' alt='view' title='view' /></a>");
			$('td:eq(7)', nRow).html("<a href='generaljournalaccounts.php?delid="+aaData[0]+"'>delete</a>");
			return nRow;
		}
 	} );
 } );
 </script>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code </th>
			<th>Name </th>
			<th>Reference </th>
			<th>Currency </th>
			<th>Account Type </th>
<?php
//Authorization.
$auth->roleid="757";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="758";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
