<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plots_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Property";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4136";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plots=new Plots();
if(!empty($delid)){
	$plots->id=$delid;
	$plots->delete($plots);
	redirect("plots.php");
}
//Authorization.
$auth->roleid="4135";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
 <a class="button icon chat" href='addplots_proc.php'>NEW PROPERTY</a></div>
<?php }?>

<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=array('em_plots.id','em_plots.code code','concat(concat(em_landlords.firstname," ",em_landlords.middlename)," ", em_landlords.lastname) landlord','em_regions.name region','em_plots.managefrom managefrom','em_types.name type','em_plots.name plot','em_plots.estate estate','em_plots.road road','em_plots.location location','em_plots.status','1','1');?>
 <?php $_SESSION['sColumns']=array('id','code','landlord','region','managefrom','type','plot','estate','road','location','status','1','1');?>
 <?php $_SESSION['join']=" left join em_landlords on em_plots.landlordid=em_landlords.id left join em_types on em_types.id=em_plots.typeid left join em_regions on em_regions.id=em_plots.regionid ";?>
 <?php $_SESSION['sTable']="em_plots";?>
 <?php $_SESSION['sOrder']=" ";?>
 <?php $_SESSION['sWhere']=""?>
 <?php $_SESSION['sGroup']=""?>
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
		"sAjaxSource": "../../server/server/processing.php?sTable=em_plots",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html("<a href='addplots_proc.php?id="+aaData[0]+"'>"+aaData[1]+"</a>");
			$('td:eq(2)', nRow).html(aaData[2]);
			$('td:eq(3)', nRow).html(aaData[3]);
			$('td:eq(4)', nRow).html(aaData[4]);
			$('td:eq(5)', nRow).html(aaData[5]);
			$('td:eq(6)', nRow).html("<a href='../../em/houses/houses.php?plotid="+aaData[0]+"'>"+aaData[6]+"</a>");
			$('td:eq(7)', nRow).html(aaData[7]);
			$('td:eq(8)', nRow).html(aaData[8]);
			$('td:eq(9)', nRow).html(aaData[9]);
			$('td:eq(10)', nRow).html(aaData[10]);
			$('td:eq(11)', nRow).html("<a href='addplots_proc.php?id="+aaData[0]+"'><img src='../view.png' alt='view' title='view' />");
			$('td:eq(12)', nRow).html("<a href='plots.php?delid="+aaData[0]+"' onclick='return confirm(&quot;Are you sure you want to delete?&quot;)'><img src='../trash.png' alt='delete' title='delete' /></a>");
			return nRow;
		}
 	} );
 } );
 </script>
 
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Property Code </th>
			<th>Landlord </th>
			<th>Region </th>
			<th>Manage From </th>
			<th>Type </th>
            <th>Name</th>
			<th>Estate </th>
			<th>Road </th>
			<th>Location </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="4137";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4138";//<img src="../view.png" alt="view" title="view" />
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
