<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houses_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once '../housetenants/Housetenants_class.php';


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
	$plotid=$_GET['plotid'];
	$tenantid=$_GET['tenantid'];
	
	if(!empty($plotid))
		$where=" where plotid='$plotid'";
	
	if(!empty($tenantid)){
		$where=" where em_houses.id not in (select houseid from em_housetenants) ";
	}

$page_title="Houses";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4108";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$houses=new Houses();
if(!empty($delid)){
	$houses->id=$delid;
	$houses->delete($houses);
	redirect("houses.php");
}
//Authorization.
$auth->roleid="4107";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> 
<a class="button icon chat" href='addhouses_proc.php?plotid=<?php echo $plotid; ?>'>NEW UNIT</a></div>
<?php }?>

<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=array('em_houses.id', 'em_houses.hseno', 'em_houses.hsecode', 'em_plots.name as plotid',' concat(concat(em_tenants.firstname," ",em_tenants.middlename)," ", em_tenants.lastname) as tenantid', 'em_houses.amount',  'em_hsedescriptions.name as hsedescriptionid', 'em_housestatuss.name as housestatusid', 'em_rentalstatuss.name as rentalstatusid', '1','1');?>
 <?php $_SESSION['sColumns']=array('id','hseno','hsecode','plotid','tenantid','amount','hsedescriptionid','housestatusid','rentalstatusid','1','1');?>
 <?php $_SESSION['join']=" left join em_plots on em_houses.plotid=em_plots.id  left join em_hsedescriptions on em_houses.hsedescriptionid=em_hsedescriptions.id  left join em_housestatuss on em_houses.housestatusid=em_housestatuss.id  left join em_rentalstatuss on em_houses.rentalstatusid=em_rentalstatuss.id left join em_housetenants on em_housetenants.houseid=em_houses.id left join em_tenants on em_tenants.id=em_housetenants.tenantid ";?>
 <?php $_SESSION['sTable']="em_houses";?>
 <?php $_SESSION['sOrder']=" order by em_houses.hsecode";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 300,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../server/server/processing.php?sTable=em_houses",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html(aaData[1]);
			$('td:eq(2)', nRow).html(aaData[2]);
			$('td:eq(3)', nRow).html(aaData[4]);
			$('td:eq(4)', nRow).html(aaData[3]);
			$('td:eq(5)', nRow).html(aaData[5]);
			$('td:eq(6)', nRow).html(aaData[6]);
			$('td:eq(7)', nRow).html(aaData[7]);
			$('td:eq(8)', nRow).html(aaData[8]);
			$('td:eq(9)', nRow).html("<a href='addhouses_proc.php?id="+aaData[0]+"'><img src='../view.png' alt='view' title='view' /></a>");
			$('td:eq(10)', nRow).html("");
			return nRow;
		}
 	} );
 } );
 </script>
 
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Unit No </th>
			<th>Unit Code </th>
			<th>Tenant</th>
			<th>Property </th>
			<th>Rent </th>
			<th>Description </th>
			<th>Unit Status </th>
			<th>Rental Status </th>
<?php
//Authorization.
$auth->roleid="4109";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4110";//<img src="../view.png" alt="view" title="view" />
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
