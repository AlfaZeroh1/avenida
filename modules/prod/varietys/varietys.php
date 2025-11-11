<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Varietys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Varietys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8616";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

if($obj->action=="Stock Take"){

	mysql_query("update prod_varietys set quantity=0");
	mysql_query("truncate prod_varietystocks");
}



$delid=$_GET['delid'];
$varietys=new Varietys();
if(!empty($delid)){
	$varietys->id=$delid;
	$varietys->delete($varietys);
	redirect("varietys.php");
}
//Authorization.
$auth->roleid="8615";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth) and empty($ob->precool)){
?>

<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addvarietys_proc.php',600,430);" value="Add Varietys " type="button"/></div>
<?php }?>
<script type="text/javascript" language="javascript">
function stocktake()
{
	var i;
	var ans;
	for(i=0;i<10;i++)
	{
		ans = confirm("Query "+(i+1)+": Are you sure you want to set all stock to zero?");
		//alert(ans);
		if(ans==false)
			break;
		if(i==9)
		{
			alert("An inventory Back up shall now be made ");
			//window.location="backup.php";
		}
	}
}
</script>
<form action="varietys.php" method="post">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" id="tblSample">
<tr>
<td width="100%" align="center"><input class="btn btn-info" onclick="stocktake();" type="submit" name="action" id="action" value="Stock Take" />
  <?php echo $error; ?></td>
</tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Variety </th>
			<th>Type </th>
			<th>Colour </th>
			<th>Expected Duration (Wks) </th>
			<th>Stems per Buckect</th>
			<?php if($ob->precool==1){ ?>
			<th>Quantity </th>
			<?php }?>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="8617";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<?php if(empty($ob->precool)){?>
			<th>&nbsp;</th>
			<?php }if($ob->precool==1){ ?>
			<th>&nbsp;</th>
			<?php } ?>
<?php
}
//Authorization.
$auth->roleid="8618";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth) and empty($ob->precool)){
?>

			
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="prod_varietys.id, prod_varietys.name, prod_types.name as typeid, prod_colours.name as colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.stems, prod_varietys.remarks,prod_varietys.type, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
		$join=" left join prod_types on prod_varietys.typeid=prod_types.id  left join prod_colours on prod_varietys.colourid=prod_colours.id ";
		$having="";
		$groupby="";
		$orderby="";
		$orderby=" where prod_varietys.type='flowers'";
		$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$varietys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->typeid; ?></td>
			<td><?php echo $row->colourid; ?></td>
			<td align="center"><?php echo $row->duration; ?></td>
			<td align="center"><?php echo $row->stems; ?></td>
			<?php if($ob->precool==1){ ?>
			<td align="center"><?php echo $row->quantity; ?></td>
			<?php }?>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8617";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<?php if(empty($ob->precool)){?>
			<td><a href="javascript:;" onclick="showPopWin('addvarietys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
			<?php }if($ob->precool==1){ ?>
			<td><a href="javascript:;" onclick="showPopWin('../varietystocks/varietystocks.php?id=<?php echo $row->id; ?>',1020,600);">Stock Card</a></td>
			<?php }?>
<?php
}
//Authorization.
$auth->roleid="8618";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth) and empty($ob->precool)){
?>
			<td><a href='varietys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
