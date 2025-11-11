<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Issuance_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
if(empty($_GET['issued']) and empty($_GET['journals']))
	redirect("addissuance_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Issuance";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4771";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$available=$_GET['inv_items.quantity'];
$issuance=new Issuance();
if(!empty($delid)){
	
	$issuances = new Issuance();
	$fields="*";
	$join="";
	$where=" where id='$delid'";
	$having="";
	$groupby="";
	$orderby="";
	$obj=$issuances->fetchObject;
	$obj->received='Yes';
	$obj->receivedon=date("Y-m-d");
	
	$shpissuance[0]=array('quantity'=>"$obj->quantity", 'remarks'=>"$obj->remarks", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'code'=>"$obj->code", 'total'=>"$obj->total",'received'=>"$obj->received",'receivedon'=>'$obj->receivedon');
	
	
	$issuance->edit($obj, "",$shpissuance);
	redirect("issuance.php?issued=1");
}
//Authorization.
$auth->roleid="4770";//View
$auth->levelid=$_SESSION['level'];

?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Department </th>
			<th>Member Of Staff </th>
			<th>Quantity </th>
			<th>Total</th>
			<th>Issued On </th>
			<th>Issue No </th>
			<th>Remarks </th>
			<th>Memo </th>
			<th>Received </th>
			<th>Received On </th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		if(!empty($_GET['issued'])){
		  $fields="inv_issuance.id, inv_items.name as itemid, hrm_departments.name as departmentid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, inv_issuancedetails.quantity, inv_issuance.issuedon, inv_issuance.documentno, inv_issuance.remarks, inv_issuance.memo, inv_issuance.received, inv_issuance.receivedon, inv_issuance.createdby, inv_issuance.createdon, inv_issuance.lasteditedby, inv_issuance.lasteditedon, inv_issuance.ipaddress";
		}
		if(!empty($_GET['journals'])){
		  $fields="inv_issuance.documentno, hrm_departments.name as departmentid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid,sum(total) total, inv_issuance.issuedon";
		}
		$join=" left join inv_issuancedetails on inv_issuancedetails.issuanceid=inv_issuance.id left join inv_items on inv_issuancedetails.itemid=inv_items.id  left join hrm_departments on inv_issuance.departmentid=hrm_departments.id  left join hrm_employees on inv_issuance.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		if(!empty($_GET['journals'])){
		  $groupby=" group by documentno ";
		}
		$orderby=" order by documentno desc ";
		$where="";
		if(!empty($_GET['issued']))
		  $where=" where inv_issuance.received in('','No')";
		if(!empty($_GET['journals']))
		  $where=" where inv_issuance.journals in('','No')";
		$issuance->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$issuance->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo formatDate($row->issuedon); ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->memo; ?></td>
			<td>
			<?php if(!empty($_GET['issued'])){?>
			<a href='issuance.php?delid=<?php echo $row->id; ?>&issued=1' onclick="return confirm('Are you sure you want to indicate as received?')">Receive</a>
			<?php }if(!empty($_GET['journals'])){ ?>
			<a href="addissuance_proc.php?retrieve=1&documentno=<?php echo $row->documentno; ?>">view</a>
			<?php } ?>
			</td>
			<td><?php echo formatDate($row->receivedon); ?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
