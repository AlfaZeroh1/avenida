<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Packinglists_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addpackinglists_proc.php?retrieve=".$_GET['retrieve']."&returns=".$_GET['returns']);

$page_title="Packinglists";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8672";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;

if($obj->action=="Print Lables" or $obj->action=="Print New Lables"){

  $pack = new Packinglists();
  $fields="boxno";
  $join="";
  $having="";
  $groupby="  ";
  $where=" where documentno='$ob->packingno'";
  $orderby="  ";
  $pack->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $bx="";
  while($pc = mysql_fetch_object($pack->result)){
    if($_POST[$pc->boxno])
      $bx.=$pc->boxno.",";
  }
  
  $bx = substr($bx,0,-1);
  if($obj->action=="Print Lables")
    redirect("boxsticker.php?&packingno=".$ob->packingno."&boxno=".$bx);
  else
    redirect("boxsticker.php?&packingno=".$ob->packingno."&new=1&boxno=".$bx);
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$packinglists=new Packinglists();
if(!empty($delid)){
	$packinglists->id=$delid;
	$packinglists->delete($packinglists);
	redirect("packinglists.php");
}
//Authorization.
$auth->roleid="8671";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addpackinglists_proc.php'>New Packinglists</a></div>
<?php }?>
<form action="" method="post">
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Box No </th>
			<th>Varietys </th>
			<th>Date Of Packing </th>
			<th>Bunches </th>
			<th>Stems </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8673";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8674";//View
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
		$fields="pos_packinglists.documentno, group_concat(distinct pos_items.name) items, pos_packinglists.orderno, pos_packinglists.boxno, crm_customers.name as customerid, pos_packinglists.packedon, count(pos_packinglistdetails.id) bunches, sum(pos_packinglistdetails.quantity) quantity, pos_packinglists.remarks, pos_packinglists.ipaddress, pos_packinglists.returns, pos_packinglists.createdby, pos_packinglists.createdon, pos_packinglists.lasteditedby, pos_packinglists.lasteditedon";
		$join=" left join pos_packinglistdetails on pos_packinglistdetails.packinglistid=pos_packinglists.id left join crm_customers on pos_packinglists.customerid=crm_customers.id  left join hrm_employees on pos_packinglists.employeeid=hrm_employees.id left join pos_items on pos_items.id=pos_packinglistdetails.itemid ";
		$having="";
		$groupby=" group by boxno ";
		$where=" where documentno='$ob->packingno'";
		$orderby=" order by boxno ";
		$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$packinglists->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" name="<?php echo $row->boxno; ?>"/></td>
			<td><?php echo $row->boxno; ?> <?php if($row->returns==1){echo "<font color='red'>(returned)</font>"; }?></td>
			<td><?php echo $row->items; ?></td>
			<td><?php echo formatDate($row->packedon); ?></td>
			<td><?php echo $row->bunches; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8673";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpackinglists_proc.php?packingno=<?php echo $row->documentno; ?>&boxno=<?php echo $row->boxno; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8674";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<td><a href='packinglists.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
			<!--<td><a href="javascript:;" onclick="poptastic('boxsticker.php?&packingno=<?php echo $row->documentno; ?>&boxno=<?php echo $row->boxno; ?>',700,1020);">Print Label</a></td>-->
			<td><a href="boxsticker.php?&packingno=<?php echo $row->documentno; ?>&boxno=<?php echo $row->boxno; ?>&orderno=<? echo $row->orderno; ?>">Print Label</a>&nbsp;<a href="boxsticker.php?&packingno=<?php echo $row->documentno; ?>&boxno=<?php echo $row->boxno; ?>&orderno=<? echo $row->orderno; ?>&new=1">Print New Label</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<input type="submit" class="btn btn-info" name="action" value="Print Lables"/>
<input type="submit" class="btn btn-info" name="action" value="Print New Lables"/>
</form>
<?php
include"../../../foot.php";
?>
