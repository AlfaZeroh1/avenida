<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Categorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7619";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$categorys=new Categorys();
if(!empty($delid)){
	$categorys->id=$delid;
	$categorys->delete($categorys);
	redirect("categorys.php");
}
//Authorization.
$auth->roleid="7618";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcategorys_proc.php',500,430);" value="Add Categorys " class="btn"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset Category </th>
			<th>Department</th>
			<th>Time Method </th>
			<th>No Of Depreciations </th>
			<th>Ending Date </th>
			<th>Period Length(Months) </th>
			<th>Computation Method </th>
			<th>Degressive Factor </th>
			<th>1st Depreciation Entry From Purchase Date </th>
<?php
//Authorization.
$auth->roleid="7620";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7621";//View
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
		$fields="assets_categorys.id, assets_categorys.name, assets_departments.name departmentid, assets_categorys.timemethod, assets_categorys.noofdepr, assets_categorys.endingdate, assets_categorys.periodlength, assets_categorys.computationmethod, assets_categorys.degressivefactor, assets_categorys.firstentry, assets_categorys.ipaddress, assets_categorys.createdby, assets_categorys.createdon, assets_categorys.lasteditedby, assets_categorys.lasteditedon";
		$join=" left join assets_departments on assets_departments.id=assets_categorys.departmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($ob->departmentid)){
		  $where=" where assets_categorys.departmentid='$ob->departmentid' ";
		}
		$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$categorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../assets/assets.php?categoryid=<?php echo $row->id; ?>"><?php echo initialCap($row->name); ?></a></td>
			<td><?php echo initialCap($row->departmentid); ?></td>
			<td><?php echo $row->timemethod; ?></td>
			<td><?php echo formatNumber($row->noofdepr); ?></td>
			<td><?php echo formatDate($row->endingdate); ?></td>
			<td><?php echo formatNumber($row->periodlength); ?></td>
			<td><?php echo $row->computationmethod; ?></td>
			<td><?php echo formatNumber($row->degressivefactor); ?></td>
			<td><?php echo $row->firstentry; ?></td>
<?php
//Authorization.
$auth->roleid="7620";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7621";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
  if($row->id==1){
    ?>
    <td>&nbsp;</td>
    <?php
  }else{
?>
			<td><a href='categorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php }} ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
