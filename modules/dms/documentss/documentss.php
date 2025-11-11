<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documentss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Documentss";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8160";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$documentss=new Documentss();
if(!empty($delid)){
	$documentss->id=$delid;
	$documentss->delete($documentss);
	redirect("documentss.php");
}
//Authorization.
$auth->roleid="8159";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddocumentss_proc.php',600,430);" value="Add Documentss " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Route </th>
			<th>Document No </th>
			<th>Document Type </th>
			<th>DMS Department </th>
			<th>DMS Dept Category </th>
			<th>DMS Category </th>
			<th>HRM Department </th>
			<th>Upload Document </th>
			<th>Document Link </th>
			<th>Status </th>
			<th>Expiry Date </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8161";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8162";//View
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
		$fields="dms_documentss.id, wf_routes.name as routeid, dms_documentss.documentno, dms_documenttypes.name as documenttypeid, dms_departments.name as departmentid, dms_documentss.departmentcategoryid, dms_categorys.name as categoryid, hrm_departments.name as hrmdepartmentid, dms_documentss.document, dms_documentss.link, dms_documentss.status, dms_documentss.expirydate, dms_documentss.description, dms_documentss.remarks, dms_documentss.ipaddress, dms_documentss.createdby, dms_documentss.createdon, dms_documentss.lasteditedby, dms_documentss.lasteditedon";
		$join=" left join wf_routes on dms_documentss.routeid=wf_routes.id  left join dms_documenttypes on dms_documentss.documenttypeid=dms_documenttypes.id  left join dms_departments on dms_documentss.departmentid=dms_departments.id  left join dms_categorys on dms_documentss.categoryid=dms_categorys.id  left join hrm_departments on dms_documentss.hrmdepartmentid=hrm_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$documentss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$documentss->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->routeid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->departmentcategoryid; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->hrmdepartmentid; ?></td>
			<td><?php echo $row->document; ?></td>
			<td><?php echo $row->link; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo formatDate($row->expirydate); ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8161";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddocumentss_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8162";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='documentss.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
