<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Requisitions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../wf/routes/Routes_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addrequisitions_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Requisitions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7505";//View
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
$auth->roleid="7505";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a class="btn btn-primary" href='addrequisitions_proc.php'>New Requisitions</a></div>
<?php }?>
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requisition No </th>
			<th>Branch </th>
			<th>Product</th>
			<th>Requested By </th>
			<th>Requisition Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7505";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7505";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
	        $roles=new Roles();
	        $fields="*";
	        $where=" where name like '%add inv requisitions%' ";
	        $join="";
	        $having="";
		$groupby="";
		$orderby="";
	        $roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	        $roles=$roles->fetchObject;         
	        
	        $routes=new Routes();
	        $fields=" wf_routes.roleid,wf_routes.id,wf_routedetails.approval,wf_routedetails.assignmentid ";
	        $where=" where wf_routes.roleid='$roles->id' and wf_routedetails.approval='No' ";
	        $join=" left join wf_routedetails on wf_routes.id=wf_routedetails.routeid ";
	        $having="";
		$groupby="";
		$orderby="";
	        $routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	        $routes=$routes->fetchObject;
	        
	        $employees=new Employees();
	        $fields="*";
	        $where=" where hrm_employees.id='".$_SESSION['employeeid']."' or hrm_employees.id in (select id from hrm_employees where assignmentid=192) ";
	        $join="";
	        $having="";
		$groupby="";
		$orderby="";
	        $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $employees->sql;
	        $employees=$employees->fetchObject;    
	        
	          
		$i=0;
		$fields="inv_requisitions.id, inv_requisitions.documentno, sys_branches.name as brancheid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, group_concat(distinct inv_items.name) item,inv_requisitions.requisitiondate, inv_requisitions.remarks, inv_requisitions.status, inv_requisitions.ipaddress, inv_requisitions.createdby, inv_requisitions.createdon, inv_requisitions.lasteditedby, inv_requisitions.lasteditedon";
		$join=" left join sys_branches on inv_requisitions.brancheid=sys_branches.id  left join hrm_employees on inv_requisitions.employeeid=hrm_employees.id left join inv_items on inv_items.id=inv_requisitions.itemid ";
		$having="";
		$groupby=" group by documentno";
		$orderby=" order by id desc ";
		$where="";
// 		if($employees->assignmentid==$routes->assignmentid)		
		   //$where=" where inv_requisitions.status=2 ";
// 		else 
// 		   $where="  ";
		
		 
                
		  
		$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby); echo 
		$res=$requisitions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
// 		 $query="select count(*) as count from inv_transfers where requisitionno='$row->documentno'";
//                  $ress=mysql_query($query);
//                  while($rowitem=mysql_fetch_object($ress)){
//                    
//                  }
		    $color="";
		   if($row->status==1){
                        $color="red";
                    }
		
	?>
		<tr  style="color:<?php echo $color; ?>">
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->item; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->requisitiondate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7505";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td>
			<?php if($row->status==0){?>
			
			<?php }if($row->status==2){?>
			<a href="addrequisitions_proc.php?documentno=<?php echo $row->documentno; ?>&retrieve=1&dispatch=1&action=1">TRANSFERS</a>&nbsp;</br><a href="addrequisitions_proc.php?documentno=<?php echo $row->documentno; ?>&retrieve=1&dispatch=1&action=1">ISSUE</a>
			<?php }else{?>
			<a href="addrequisitions_proc.php?documentno=<?php echo $row->documentno; ?>&retrieve=1">View</a>
			<?php }?>
			</td>
<?php
}
//Authorization.
$auth->roleid="7505";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<!--<td><a href='requisitions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>-->
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
