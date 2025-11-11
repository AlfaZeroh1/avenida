<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Laboratorytests_class.php");
require_once("../laboratorytestdetails/Laboratorytestdetails_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Laboratorytests";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$laboratorytests=new Laboratorytests();
if(!empty($delid)){
	$laboratorytests->id=$delid;
	$laboratorytests->delete($laboratorytests);
	redirect("laboratorytests.php");
}
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addlaboratorytests_proc.php', 600, 310);">ADD LAB TESTS</a>
</div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Remarks</th>
			<th>Charge</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_laboratorytests.id, hos_laboratorytests.name, hos_laboratorytests.remarks, hos_laboratorytests.charge";
		$join="";
		$having="";
		$groupby="";
		$where="";
		$orderby=" order by hos_laboratorytests.name ";
		$laboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$laboratorytests->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../laboratorytestdetails/laboratorytestdetails.php?id=<?php echo $row->id?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->remarks; ?></td>
			<td align="right"><?php echo formatNumber($row->charge); ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addlaboratorytests_proc.php?id=<?php echo $row->id; ?>', 600, 310);"><img src="../edit.png" alt="edit" title="edit" /></a></td>
			<td><a href='laboratorytests.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
