<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tenders";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7744";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tenders=new Tenders();
if(!empty($delid)){
	$tenders->id=$delid;
	$tenders->delete($tenders);
	redirect("tenders.php");
}
//Authorization.
$auth->roleid="7743";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addtenders_proc.php'>New Tenders</a></div>
<?php }?>
<table class="table table-bordered table-condensed table-hover table-striped" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Proposal No </th>
			<th>Tender Description </th>
			<th>Tender Type </th>
			<th>Date Received </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="7745";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7746";//View
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
		$fields="tender_tenders.id, tender_tenders.proposalno, tender_tenders.name, tender_tendertypes.name as tendertypeid, tender_tenders.datereceived, tender_tenders.actionplandate, tender_tenders.dateofreview, tender_tenders.dateofsubmission, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, tender_statuss.id status, tender_statuss.name as Statusid, tender_tenders.remarks, tender_tenders.ipaddress, tender_tenders.createdby, tender_tenders.createdon, tender_tenders.lasteditedby, tender_tenders.lasteditedon";
		$join=" left join tender_tendertypes on tender_tenders.tendertypeid=tender_tendertypes.id  left join hrm_employees on tender_tenders.employeeid=hrm_employees.id  left join tender_statuss on tender_tenders.Statusid=tender_statuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tenders->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->proposalno; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->tendertypeid; ?></td>
			<td><?php echo formatDate($row->datereceived); ?></td>
			<?php if($row->status==5){?>
			  <td><a href="../../con/projects/addprojects_proc.php?tender=<?php echo $row->id; ?>"><?php echo $row->Statusid; ?></a></td>
			<?php }else{?>
			<td><?php echo $row->Statusid; ?></td>
			<?php }?>
<?php
//Authorization.
$auth->roleid="7745";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addtenders_proc.php?id=<?php echo $row->id; ?>"><img src="../../../img/view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="7746";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tenders.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../../../img/trash.png" alt="delete" title="delete" /></a></td>
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
