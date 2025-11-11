<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inwards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){
	redirect ("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addinwards_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Inwards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8064";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$inwards=new Inwards();
if(!empty($delid)){
	$inwards->id=$delid;
	$inwards->delete($inwards);
	redirect("inwards.php");
}
//Authorization.
$auth->roleid="8063";//View
$auth->levelid=$_SESSION['level'];

?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier </th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields=" distinct proc_suppliers.name as supplierid, proc_inwards.supplierid supplier";
		$join=" left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id ";
		$having=" ";
		$groupby="";
		$where=" where proc_inwards.id in(select inwardid from proc_inwarddetails where status!=1 and inwardid in(select inward.id from proc_inwards inward where inward.supplierid=proc_suppliers.id)) ";
		$orderby=" order by proc_suppliers.name ";
		$inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$inwards->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="inwards.php?supplierid=<?php echo $row->supplier; ?>"><?php echo $row->supplierid; ?></a></td>
			<td>&nbsp;</td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
