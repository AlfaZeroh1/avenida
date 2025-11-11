<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientstatuss_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientstatuss";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$patientstatuss=new Patientstatuss();
if(!empty($delid)){
	$patientstatuss->id=$delid;
	$patientstatuss->delete($patientstatuss);
	redirect("patientstatuss.php");
}
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientstatuss_proc.php', 600, 430);" value="Add Patientstatuss" type="button"/></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_patientstatuss.id, hos_patientstatuss.name";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$patientstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientstatuss->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addpatientstatuss_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
			<td><a href='patientstatuss.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
