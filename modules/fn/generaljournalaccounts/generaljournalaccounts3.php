<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournalaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");


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
include"../../../hd.php";

$delid=$_GET['delid'];
$generaljournalaccounts=new Generaljournalaccounts();
if(!empty($delid)){
	$generaljournalaccounts->id=$delid;
	$generaljournalaccounts->delete($generaljournalaccounts);
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
 <?php $_SESSION['aColumns']=array('fn_generaljournalaccounts.id', ' fn_generaljournalaccounts.code', ' fn_generaljournalaccounts.name', ' sys_acctypes.name as acctypeid','1','1');?>
 <?php $_SESSION['sColumns']=array('id','code','name','acctypeid','1','1');?>
 <?php $_SESSION['join']=" left join sys_acctypes on fn_generaljournalaccounts.acctypeid=sys_acctypes.id ";?>
 <?php $_SESSION['sTable']=" fn_generaljournalaccounts ";?> 
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="";?>
 <?php $_SESSION['sGroup']="";?>
 $(document).ready(function() {
	 
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 250,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../server/server/processing.php?sTable=fn_generaljournalaccounts",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html(aaData[1]);
			$('td:eq(2)', nRow).html("<a href='../generaljournal/account.php?id="+aaData[0]+"'>"+aaData[2]+"</a>");
			$('td:eq(3)', nRow).html(aaData[3]);
			$('td:eq(4)', nRow).html("<a href='javascript:;' onclick='showPopWin(&quot;addgeneraljournalaccounts_proc.php?id="+aaData[0]+"&quot;, 600, 600);'><img src='../view.png' alt='view' title='view' /></a>");
			$('td:eq(5)', nRow).html("");
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
