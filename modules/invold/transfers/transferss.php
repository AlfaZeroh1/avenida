<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transfers_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
// redirect("addtransfers_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Transfers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7495";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$transfers=new Transfers();
if(!empty($delid)){
	$transfers->id=$delid;
	$transfers->delete($transfers);
	redirect("transfers.php");
}
//Authorization.
$auth->roleid="7494";//View
$auth->levelid=$_SESSION['level'];

if(empty($obj->action))
  $obj->brancheid=$_SESSION['brancheid'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addtransfers_proc.php'>New Transfers</a></div>
<?php }?>

  <script type="text/javascript">
$().ready(function() {
 $("#itemname").autocomplete({
	source: "../../../modules/server/server/search.php?main=inv&module=items&field=inv_items.name&where=inv_items.status='Active'",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
		$("#itemname").val(ui.item.name);
	}
 });
 });
</script>
<div class="content">

<form action="" method="post">
<table align="center">
<tr>
      <td><label>To Branch:</label></td>
      <td><select name="brancheid" id="brancheid" class="selectbox">
      <option value="">Select...</option>
      <?php
	      $branches2=new Branches();
	      if($_SESSION['brancheid']!=6)
		  $where=" where id='".$_SESSION['brancheid']."' ";
	      else{
		$where="";	      
		
	      }
	      $fields="*";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $branches2->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	      while($rw=mysql_fetch_object($branches2->result)){
	      ?>
		      <option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	      <?php
	      }
	      ?>
      </select></td>
      <td><label>Product:</label></td>
      <td>
      <input type='text' size='32' name='itemname'  id='itemname' value='<?php echo $obj->itemname; ?>'/>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->itemid; ?>'/>
      </td>
      
      <td><input type="submit" name="action" class="btn btn-primary" value="Filter"/>
      </td>			
    
			</tr>
</table>
</form>

<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Transfer No </th>
			<th>Item</th>
			<th>Quantity</th>
			<th>From</th>
			<th>To</th>
			<th>Remarks </th>
			<th>Transfered On </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="7496";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7497";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="inv_transfers.id,inv_transferdetails.transferid, sum(inv_transferdetails.quantity) as quantity, inv_transfers.documentno,group_concat(distinct inv_items.name) as item, sys_branches.name as brancheid, sys_branches2.name as tobrancheid, inv_transfers.remarks, inv_transfers.transferedon, inv_transfers.status, inv_transfers.ipaddress, inv_transfers.createdby, inv_transfers.createdon, inv_transfers.lasteditedby, inv_transfers.lasteditedon";
		$join=" left join sys_branches on inv_transfers.brancheid=sys_branches.id  left join sys_branches sys_branches2 on inv_transfers.tobrancheid=sys_branches2.id left join inv_transferdetails on inv_transfers.id=inv_transferdetails.transferid left join inv_items on inv_items.id=inv_transferdetails.itemid ";
		$having="";
		$groupby=" group by inv_transferdetails.transferid ";
		$orderby=" order by inv_transfers.id desc ";
		$where=" where inv_transfers.tobrancheid='".$obj->brancheid."' ";$where="";	
		if(!empty($obj->itemid))
		  $where.=" and inv_transferdetails.itemid='$obj->itemid' ";
		$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $transfers->sql;
		$res=$transfers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$sr=mysql_query("select count(*) cnt from inv_transferdetails where transferid='$row->id' and status=0");		
		$wr = mysql_fetch_object($sr);
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="addtransfers_proc.php?retrieve=1&documentno=<?php echo $row->documentno; ?>" target="_blank"><?php echo $row->documentno; ?></a></td>
			<td><?php echo $row->item; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->tobrancheid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatDate($row->transferedon); ?></td>
			<td><?php if($row->status==0){echo "($wr->cnt)Pending";}else{echo "Received";} ?></td>
<?php
//Authorization.
$auth->roleid="7496";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
if($row->status!=1)
{

?>
			<td><a href="addtransfers_proc.php?documentno=<?php echo $row->documentno; ?>&receive=1">
			<? if($wr->cnt>0){ ?>
			Receive
			<?php }else{?>
			<font color="red">Received</font>
			<?php } ?>
			</a></td>
<?php
}
}
//Authorization.
$auth->roleid="7497";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){

?>
<!-- 			<td><a href='transfers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
</div>
<?php
include"../../../foot.php";
?>
