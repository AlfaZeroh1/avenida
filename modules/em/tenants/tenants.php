<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenants_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tenants";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4156";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tenants=new Tenants();
if(!empty($delid)){
	$tenants->id=$delid;
	$tenants->delete($tenants);
	redirect("tenants.php");
}
//Authorization.
$auth->roleid="4155";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addtenants_proc.php', 600, 600);"><span>ADD TENANTS</span></a>
</div>
<div style="float:left;" class="buttons"></div>
<?php }?>

 <script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=array('em_tenants.id','em_tenants.code code','concat(concat(em_tenants.firstname," ",em_tenants.middlename)," ", em_tenants.lastname) names','em_tenants.postaladdress postaladdress','em_tenants.registeredon registeredon','sys_nationalitys.name name','em_tenants.tel tel','em_tenants.mobile mobile','em_tenants.occupation occupation','em_tenants.email email','1','1');?>
 <?php $_SESSION['sColumns']=array('id','code','names','postaladdress','registeredon','name','tel','mobile','occupation','email','1','1');?>
 <?php $_SESSION['join']=" left join sys_nationalitys on em_tenants.nationalityid=sys_nationalitys.id ";?>
 <?php $_SESSION['sTable']="em_tenants";?>
 <?php $_SESSION['sOrder']=" ";?>
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
		"sAjaxSource": "../../server/server/processing.php?sTable=em_tenants",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html("<a href='../generaljournal/account.php?id="+aaData[0]+"'>"+aaData[1]+"</a>");
			$('td:eq(2)', nRow).html(aaData[2]);
			$('td:eq(3)', nRow).html(aaData[3]);
			$('td:eq(4)', nRow).html(aaData[4]);
			$('td:eq(5)', nRow).html(aaData[5]);
			$('td:eq(6)', nRow).html(aaData[6]);
			$('td:eq(7)', nRow).html(aaData[7]);
			$('td:eq(8)', nRow).html(aaData[8]);
			$('td:eq(9)', nRow).html(aaData[9]);
			$('td:eq(10)', nRow).html("<a href='javascript:;' onclick='showPopWin(&quot;addtenants_proc.php?id="+aaData[0]+"&quot;, 600, 600);'><img src='../view.png' alt='view' title='view' /></a>");
			$('td:eq(11)', nRow).html("<a href='javascript:;' onclick='showPopWin(&quot;vacant.php?tenantid="+aaData[0]+"&quot;, 600, 600);'>Allocate</a>");
			return nRow;
		}
 	} );
 } );
 </script>
 
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tenant Code </th>
			<th>Names</th>
			<th>Postal Address </th>
			<th>Reg Date </th>
			<th>Nationality </th>
			<th>Telephone </th>
			<th>Mobile </th>
			<th>Occupation </th>
			<th>Email </th>
<?php
//Authorization.
$auth->roleid="4157";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4158";//<img src="../view.png" alt="view" title="view" />
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
