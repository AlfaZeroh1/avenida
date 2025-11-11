<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Requisitions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../proc/purchaseorders/Purchaseorders_class.php");


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
$auth->roleid="8072";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$requisitions=new Requisitions();
if(!empty($delid)){
	$requisitions->id=$delid;
	$requisitions->delete($requisitions);
	redirect("requisitions.php");
}
//Authorization.
$auth->roleid="8071";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <a href='addrequisitions_proc.php'>New Requisitions</a></div> -->
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requisition No </th>
			<th> Description </th>
			<th>Requisition Type </th>
			<th>Requisition Date </th>
			<th>Status </th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="proc_requisitions.id, proc_requisitions.documentno,proc_requisitions.description, proc_requisitions.type,proc_requisitions.requisitiondate, proc_requisitions.remarks, case when proc_requisitions.status=1 then 'Approved' else 'Not Approved' end status, proc_requisitions.file, proc_requisitions.ipaddress, proc_requisitions.createdby, proc_requisitions.createdon, proc_requisitions.lasteditedby, proc_requisitions.lasteditedon";
		$join=" left join con_projects on proc_requisitions.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby=" order by proc_requisitions.requisitiondate desc ";
		$where=" where proc_requisitions.employeeid=(select employeeid from auth_users where id='".$_SESSION['userid']."') ";
		$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$requisitions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		if($row->status=="Approved"){
		  $purchaseorders=new Purchaseorders();
		  $where=" where requisitionno in ($row->documentno); ";
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  //$purchaseorders = $purchaseorders->fetchObject;
		  if($purchaseorders->affectedRows>0){
		    $row->status="LPO Raised";
		  }
		}else{
		
		  $tasks=new tasks();
		  $where=" where documentno = '$row->documentno' and documenttype='Requisition' and taskid=0 ";
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
			<td><?php echo formatDate($row->requisitiondate); ?></td>
			<?php
			if($row->status=="Not Approved"){
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
