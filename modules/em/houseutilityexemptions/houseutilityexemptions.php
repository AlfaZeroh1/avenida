<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houseutilityexemptions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Houseutilityexemptions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4116";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$houseutilityexemptions=new Houseutilityexemptions();
if(!empty($delid)){
	$houseutilityexemptions->id=$delid;
	$houseutilityexemptions->delete($houseutilityexemptions);
	redirect("houseutilityexemptions.php");
}
//Authorization.
$auth->roleid="4115";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addhouseutilityexemptions_proc.php', 560, 250);"><span>ADD HSE UTILITIES EXEMPTIONS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Utility </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4117";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4118";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_houseutilityexemptions.id, em_houses.name as houseid, em_utilitys.name as utilityid, em_houseutilityexemptions.remarks";
		$join=" left join em_houses on em_houseutilityexemptions.houseid=em_houses.id  left join em_utilitys on em_houseutilityexemptions.utilityid=em_utilitys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$houseutilityexemptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$houseutilityexemptions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->utilityid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4117";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhouseutilityexemptions_proc.php?id=<?php echo $row->id; ?>', 560, 250);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4118";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='houseutilityexemptions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
