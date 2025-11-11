<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Assets";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7611";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$equip=$_GET['equip'];
$assets=new Assets();
if(!empty($delid)){
	$assets->id=$delid;
	$assets->delete($assets);
	redirect("assets.php");
}
//Authorization.
$auth->roleid="7610";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<a class="btn btn-info" href='addassets_proc.php'>New Assets</a>
<?php }?>
<div style="clear:both;"></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset Name </th>
			<th>Photo </th>
			<th>Invoice No </th>
			<th>Asset Category </th>
			<th>Gross Value </th>
			<th>Salvage Value </th>
			<th>Purchase Date </th>
			<th>Supplier </th>
			<th>LPO No </th>
			<th>Delivery Note No </th>
			<th>Remarks </th>
			<th>Memo </th>
			<th>Last Depr</th>
			<th>Depr</th>
<?php
//Authorization.
$auth->roleid="7612";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7613";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_categorys.id category, assets_categorys.type, assets_categorys.degressivefactor, assets_categorys.name as categoryid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, proc_suppliers.name as supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
		$join=" left join assets_categorys on assets_assets.categoryid=assets_categorys.id  left join proc_suppliers on assets_assets.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" ";
		if(!empty($ob->categoryid))
		  $where=" where assets_assets.categoryid='$ob->categoryid' ";
		$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$assets->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$rw="";
		
		//get last depreciation
		$ql="select * from assets_depreciations where assetid='$row->id' order by id desc";
		$rs=mysql_query($ql);
		if(mysql_affected_rows()>0){
		  $rw=mysql_fetch_object($rs);
		  $startDate = date("Y-m-d",mktime(0,0,0,$rw->month,1,$rw->year));
		}else{
		  $startDate = $row->purchasedon;
		}
		
		$endDate = date("Y-m-d");
		
// 		$numberOfMonths = abs((date('Y', $endDate) - date('Y', $startDate))*12 + (date('m', $endDate) - date('m', $startDate)))+1;
		
		$depreciation = "";
		$numberOfYears=0;
		$numberOfMonths=0;
		
		$d1 = new DateTime($startDate);
		$d2 = new DateTime($endDate);
		$d3 = $d1->diff($d2);
		$numberOfMonths = ($d3->y*12)+$d3->m;
		$numberOfYears = $d3->y;
		
		if($numberOfMonths>0){
		 if($row->type=="Monthly"){
		  $depr = $row->degressivefactor/12*($row->value/100);
		  $depreciation = $row->degressivefactor/12*($row->value/100)*$numberOfMonths;
		  $date = date("Y-m-d",strtotime('+1 months',strtotime($startDate)));
		 }
		 else{
		  $depr = $row->degressivefactor*($row->value/100);
		  $depreciation = $row->degressivefactor*($row->value/100)*$numberOfYears;
		  $date = date("Y-m-d",strtotime('+1 years',strtotime($startDate)));
		 }
		}
		
		$month = date("m",strtotime($date));
		$year = date("Y",strtotime($date));
		
		$depr = round($depr);
		$depreciation = round($depreciation);
		
		$query2="select * from fn_generaljournalaccounts where refid='$row->id' and acctypeid=7";
		$asset = mysql_fetch_object(mysql_query($query2));
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../../../reports/fn/generaljournals/generaljournalscategory.php?categoryid=<?php echo $asset->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->photo; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo formatNumber($row->value); ?></td>
			<td><?php echo formatNumber($row->salvagevalue); ?></td>
			<td><?php echo formatDate($row->purchasedon); ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->lpono; ?></td>
			<td><?php echo $row->deliveryno; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo getMonth($rw->month);?>&nbsp;<?php echo $rw->year; ?></td>
			<td align="right"><a onclick="showPopWin('../depreciations/adddepreciations_proc.php?assetid=<?php echo $row->id; ?>&noofmonths=1&amount=<?php echo $depr; ?>&perc=<?php echo $row->degressivefactor; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>',500,430);"><?php if(!empty($depreciation))echo formatNumber($depreciation);?></a></td>
<?php
//Authorization.
$auth->roleid="7612";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addassets_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7613";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='assets.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
