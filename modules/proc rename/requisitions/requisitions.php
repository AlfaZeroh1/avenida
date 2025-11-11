<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Requisitions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/departments/Departments_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$ob = (object)$_GET;

$obj =(object)$_POST;

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
<!--<div style="float:left;" class="buttons"> <a href='addrequisitions_proc.php'>New Requisitions</a></div>-->
<?php }?>
<form action="" method="post">
<table>
  <tr>
  <td align="right">Department : </td>
  <?php 
  $departments=new Departments();
  $where="";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby=" order by name ";
  $departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $departments->sql;
  ?>
  <td><select name="departmentid" class="selectbox">
  <option value="">Select...</option>
  <?php
	  while($rw=mysql_fetch_object($departments->result)){
	  ?>
		  <option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	  <?php
	  }
	  ?>
  </select>
</td>			
</select>
<td align="right">Status : </td>
  <td><select name="status" class="selectbox">
  <option value="">All</option>
  <option value="1" <?php if($obj->status=='1'){echo "selected";}?>>Approved</option>
  <option value="2" <?php if($obj->status=='2'){echo "selected";}?>>Not Approved</option>
  </select>
</td>
<td><input type="submit" class="btn btn-primary" name="action" value="Filter"/></td>
  </tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requisition No </th>
			<th>Requested By </th>
			<th> Description </th>
			<th>Requisition Type </th>
<!-- 			<th>Project </th> -->
			<th>Requisition Date </th>
			<th>Remarks </th>
<!-- 			<th>Status </th> -->
<!-- 			<th>Browse File </th> -->
<?php
//Authorization.
$auth->roleid="8073";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8074";//View
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
		$fields="proc_requisitions.id, proc_requisitions.documentno,proc_requisitions.description, proc_requisitions.type, con_projects.name as projectid, proc_requisitions.requisitiondate, proc_requisitions.remarks, proc_requisitions.status, proc_requisitions.file, proc_requisitions.ipaddress, proc_requisitions.createdby, proc_requisitions.createdon, proc_requisitions.lasteditedby, proc_requisitions.lasteditedon,concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeeid";
		$join=" left join con_projects on proc_requisitions.projectid=con_projects.id left join hrm_employees on hrm_employees.id=proc_requisitions.employeeid ";
		$having="";
		$where="";
		if(!empty($obj->departmentid))
		{
		   if(!empty($where))
		      $where.=" and ";
		   else
		      $where.=" where ";
		      
		   $where.=" proc_requisitions.departmentid='$obj->departmentid' ";
		}
		
	       if(!empty($obj->status))
		{ 
		   if(!empty($where))
		      $where.=" and ";
		   else
		      $where.=" where ";
		      
		   if($obj->status=='2')
		     $obj->status=0;
		     
		   $where.=" proc_requisitions.status='$obj->status' ";
		}
		
		$groupby="";
		$orderby="";
		$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $requisitions->sql;//echo $obj->status.'here';
		$res=$requisitions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->type; ?></td>
<!-- 			<td><?php echo $row->projectid; ?></td> -->
			<td><?php echo formatDate($row->requisitiondate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<!-- 			<td><?php echo $row->status; ?></td> -->
<!-- 			<td><?php echo $row->file; ?></td> -->
<?php
//Authorization.
$auth->roleid="8073";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addrequisitions_proc.php?retrieve=1&documentno=<?php echo $row->documentno; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8074";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='requisitions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
