<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Barcodes_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Barcodes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11236";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj=(object)$_POST;

$delid=$_GET['delid'];
$barcodes=new Barcodes();
if(!empty($delid)){
	$barcodes->id=$delid;
	$barcodes->delete($barcodes);
	redirect("barcodes.php");
}
//Authorization.
$auth->roleid="11235";//View
$auth->levelid=$_SESSION['level'];
?>
 <script type="text/javascript">
function Clickheretoprint()
{
  poptastic('print2.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>&downsize=<?php echo $obj->downsize; ?>',450,940);
}
</script>

<?php
if(existsRule($auth)){
?>
<!--<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addbarcodes_proc.php',600,430);" value="NEW" type="button"/></div>-->
<form method="post" action="">
<div style="align:center;" width="100%">
<table>
      <tr>
      <td>
      Bar code unique id:
      <input type="text" name="barcode" size="10" value="<?php echo $obj->barcode; ?>"/>
      </td>&nbsp;&nbsp;<td>
      <input class="btn btn=info" type="submit" name="action" value="Filter" class="btn"/>
    </td>
  </tr>
</table>
<div>
</form>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Green House </th>
			<th>Product</th>
			<th>Size</th>
			<th>Quantity</th>
			<th>Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="11237";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11238";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
	if(!empty($obj->barcode)){
		$i=0;
		$fields="post_barcodes.id, post_barcodes.barcode, prod_greenhouses.name as greenhouseid, post_barcodes.itemid, post_barcodes.status, post_barcodes.generatedon, post_barcodes.remarks, post_barcodes.ipaddress, post_barcodes.createdby, post_barcodes.createdon, post_barcodes.lasteditedby, post_barcodes.lasteditedon";
		$join=" left join prod_greenhouses on post_barcodes.greenhouseid=prod_greenhouses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where post_barcodes.barcode like '%-$obj->barcode%' ";
		$barcodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $barcodes->sql;
		$res=$barcodes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		$temp=explode("-",$row->barcode);
		
		$items = new Items();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='".$temp[0]."'";
		$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$items = $items->fetchObject;

		$sizes = new Sizes();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$where=" where id='".$temp[1]."'";
		$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$sizes = $sizes->fetchObject;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->greenhouseid; ?></td>
			<td><?php echo $items->name; ?></td>
			<td><?php echo $sizes->name; ?></td>
			<td><?php echo $temp[2]; ?></td>
			<td><?php echo formatDate($row->generatedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="11237";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><input class="btn btn=info" type="button" name="action2" value="Reprint" class="btn" onclick="Clickheretoprint();"/></td>
<?php
}
//Authorization.
$auth->roleid="11238";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><!--<a href='barcodes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a>--></td>
<?php } ?>
		</tr>
	<?php 
	}
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
