<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cashrequisitions_class.php");
require_once("../../auth/rules/Rules_class.php");
// require_once("../../proc/purchaseorders/Purchaseorders_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$ob = (object)$_GET;

//Redirect to horizontal layout
// redirect("addrequisitions_proc.php?retrieve=".$ob->retrieve."&departmentid=".$ob->departmentid);

$page_title="Requisitions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8140";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$requisitions=new Cashrequisitions();
if(!empty($delid)){
	$requisitions->id=$delid;
	$requisitions->delete($requisitions);
	redirect("requisitions.php");
}
//Authorization.
$auth->roleid="8139";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <a href='addrequisitions_proc.php'>New Requisitions</a></div> -->
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requisition No </th>
			<th>Description </th>
			<th>Requisition Type </th>
			<th>Requisition Date </th>
			<th>Status </th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno,fn_cashrequisitions.description, fn_cashrequisitions.remarks,  status, fn_cashrequisitions.ipaddress, fn_cashrequisitions.createdby, fn_cashrequisitions.createdon, fn_cashrequisitions.lasteditedby, fn_cashrequisitions.lasteditedon";
		$join=" left join con_projects on fn_cashrequisitions.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby=" order by fn_cashrequisitions.createdon desc ";
		$where=" where fn_cashrequisitions.employeeid=(select employeeid from auth_users where id='".$_SESSION['userid']."') ";
		$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $requisitions->sql;
		$res=$requisitions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		if($row->status=="Approved"){
// 		  $purchaseorders=new Purchaseorders();
// 		  $where=" where requisitionno in ($row->documentno); ";
// 		  $fields="*";
// 		  $join="";
// 		  $having="";
// 		  $groupby="";
// 		  $orderby="";
// 		  $purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 		  //$purchaseorders = $purchaseorders->fetchObject;
// 		  if($purchaseorders->affectedRows>0){
// 		    $row->status="LPO Raised";
// 		  }
		}else{		
		  $tasks=new tasks();
		  $where=" where documentno = '$row->documentno' and documenttype='Cashrequisitions' and taskid=0 ";
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $tasks->sql;
		  $tasks = $tasks->fetchObject;
	      }
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo formatDate($row->createdon); ?></td>
			<?php
			if($row->status=="pending"){
			?>
			<td><a href="javascript:;" onclick="showPopWin('../../wf/routes/task.php?id=<?php echo $tasks->id; ?>&popup=true',600,430);"><?php echo $row->status; ?></a></td>
			<?php
			}else{?>
			<td><?php echo $row->status; ?></td>
			<?php
			}
			?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
