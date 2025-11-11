<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlords_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Landlords";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4128";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$landlords=new Landlords();
if(!empty($delid)){
	$landlords= new Landlords();
	$fields="em_landlords.id, em_landlords.llcode, em_landlords.firstname, em_landlords.middlename, em_landlords.lastname, em_landlords.tel, em_landlords.email, em_landlords.registeredon, em_landlords.fax, em_landlords.mobile, em_landlords.idno, em_landlords.passportno, em_landlords.postaladdress, em_landlords.address, em_landlords.status";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$delid' ";
	$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$landlords=$landlords->fetchObject;
	$landlords->status="Inactive";
	
	$landlord= new Landlord();
	$landlord->edit($landlords);
	
	redirect("landlords.php");
}
//Authorization.
$auth->roleid="4127";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" href='addlandlords_proc.php'>NEW LANDLORDS</a>
</div>
<?php }?>

<script type="text/javascript" charset="utf-8">
<?php $_SESSION['aColumns']=array('em_landlords.id','em_landlords.llcode code','concat(concat(em_landlords.firstname," ",em_landlords.middlename)," ", em_landlords.lastname) names','em_landlords.tel tel','em_landlords.email email','em_landlords.registeredon registeredon','em_landlords.mobile mobile','em_landlords.idno','em_landlords.passportno','em_landlords.postaladdress postaladdress','em_landlords.address', 'em_landlords.status','1','1');?>
<?php $_SESSION['sColumns']=array('id','code','names','tel','email','registeredon','mobile','idno','passportno','postaladdress','address','status','1','1');?>
 <?php $_SESSION['sTable']="em_landlords";?>
<?php $_SESSION['join']=""; ?>
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
 		"sScrollY": 300,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../server/server/processing.php?sTable=em_landlords",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html("<a href='addlandlords_proc.php?id="+aaData[0]+"'>"+aaData[1]+"</a>");
			$('td:eq(2)', nRow).html(aaData[2]);
			$('td:eq(3)', nRow).html(aaData[3]);
			$('td:eq(4)', nRow).html(aaData[4]);
			$('td:eq(5)', nRow).html(aaData[5]);
			$('td:eq(6)', nRow).html(aaData[6]);
			$('td:eq(7)', nRow).html(aaData[7]);
			$('td:eq(8)', nRow).html(aaData[8]);
			$('td:eq(9)', nRow).html(aaData[9]);
			$('td:eq(10)', nRow).html(aaData[10]);
			$('td:eq(11)', nRow).html(aaData[11]);
			$('td:eq(12)', nRow).html("<a href='addlandlords_proc.php?id="+aaData[0]+"'><img src='../view.png' alt='view' title='view' />");
			$('td:eq(13)', nRow).html("<a href='landlords.php?delid="+aaData[0]+"' onclick='return confirm(&quot;Are you sure you want to de-activate?&quot;)'><img src='../trash.png' alt='delete' title='delete' /></a>");
			return nRow;
		}
 	} );
 } );
 </script>
 
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>LL Code </th>
			<th>Names </th>
			<th>Telephone </th>
			<th>Email </th>
			<th>Date Registered </th>
			<th>Mobile </th>
			<th>National ID No </th>
			<th>Passport No </th>
			<th>Postal Address </th>
			<th>Address </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="4129";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4130";//<img src="../view.png" alt="view" title="view" />
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
