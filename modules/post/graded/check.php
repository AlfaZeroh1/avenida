<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Graded_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
// redirect("addgraded_proc.php?status=".$_GET['status']."&retrieve=".$_GET['retrieve']);

$obj = (object)$_POST;

$page_title="Graded";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8620";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$graded=new Graded();
if(!empty($delid)){
	$graded->id=$delid;
	$graded->delete($graded);
	redirect("graded.php");
}
//Authorization.
$auth->roleid="8619";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <a href='addgraded_proc.php'>New Graded</a></div> -->
<?php }?>

<?php
if(!empty($obj->action)){
  $fields="'Grading' as type,'' documentno, pos_sizes.name as sizeid, '' as boxno, pos_items.name as itemid, post_graded.quantity, post_graded.gradedon, concat(hrm_employees.pfnum, ' ', concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) as employeeid, post_graded.barcode,  post_graded.status, post_graded.ipaddress, auth_users.username as createdby, post_graded.createdon, post_graded.lasteditedby, post_graded.lasteditedon";
  $join=" left join pos_sizes on post_graded.sizeid=pos_sizes.id  left join pos_items on post_graded.itemid=pos_items.id  left join hrm_employees on post_graded.employeeid=hrm_employees.id left join auth_users on auth_users.id=post_graded.createdby ";
  $having="";
  $groupby="";
  $orderby=" union select 'Packing' as type, p.documentno, pos_sizes.name as sizeid, p.boxno, pos_items.name as itemid, pd.quantity, p.packedon, '' as employeeid, pd.barcode, '' as status, pd.ipaddress, auth_users.username createdby, pd.createdon, pd.lasteditedby, pd.lasteditedon from pos_packinglistdetails pd left join pos_packinglists p on pd.packinglistid=p.id left join pos_sizes on pd.sizeid=pos_sizes.id  left join pos_items on pd.itemid=pos_items.id left join auth_users on auth_users.id=pd.createdby where pd.barcode like '$obj->barcode%'  order by createdon";
  $where=" where post_graded.barcode like '$obj->barcode%' ";
  $graded->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $res=$graded->result;
}
?>

<form action="" method="post">
  <table>
    <tr>
      <td>Barcode:<input type="text" name="barcode" id="barcode" value="<?php echo $obj->barcode; ?>"/>&nbsp;
      <input type="submit" name="action" class="btn btn-primary" value="Filter"/>
      <?php
      //get barcode status	\
      
      $barcode=explode("=",$obj->barcode);
      
      $query="select * from post_barcodes where barcode='".$barcode[0]."'";
      $result = mysql_query($query);
      $bar = mysql_fetch_object($result);
      
      $css="";
      $status="";
      if(($bar->status==0 or $bar->status==2) and $graded->affectedRows>0){
	$status="Scanned Out!";
	$css="btn-danger";
      }
      elseif($bar->status==0 and $graded->affectedRows==0){
	$status="Available!";
	$css="btn-ok";
      }
      if($bar->status==1 and $graded->affectedRows>0){
	$status="Scanned In!";
	$css="btn-warning";
      }
      ?>
      <?php if(!empty($obj->action)){?>
      <input type="button" name="action" class="btn <?php echo $css; ?>" value="<?php echo $status; ?>"/>
      <?php } ?>
    </tr>
  </table>
</form>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Type</th>
			<th>Packing No</th>
			<th>Box No</th>
			<th>Size </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Date </th>
			<th>BarCode </th>
			<th>Status </th>
			<th>Created On </th>
			<th>IP Address </th>
			<th>Created By</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		if(!empty($obj->action)){
		
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->boxno; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatDate($row->gradedon); ?></td>
			<td><?php echo $row->barcode; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->createdon; ?></td>
			<td><?php echo $row->ipaddress; ?></td>
			<td><?php echo $row->createdby; ?></td>
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
