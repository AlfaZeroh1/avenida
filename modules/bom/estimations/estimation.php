<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Estimations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11369";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

$delid=$_GET['delid'];
$estimations=new Estimations();
if(!empty($delid)){
	$estimations->id=$delid;
	$estimations->delete($estimations);
	redirect("estimations.php");
}
//Authorization.
$auth->roleid="11368";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addestimations_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>

<script type="text/javascript" charset="utf-8">
 function setQuantity(qnt,estimationid){
  
  $.post("setQuantity.php",{quantity:qnt,estimationid:estimationid});
  
 }
</script>

<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product</th>
			<th>Item </th>
			<th>Quantity</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$j=0;
		$shop = $_SESSION['estimations'];
		while($i<count($shop)){
		  		 
		  $fields="bom_estimations.id, bom_estimations.name, inv_items.name as itemid, bom_estimations.createdby,bom_estimations.prc, bom_estimations.createdon, bom_estimations.lasteditedby, bom_estimations.lasteditedon, bom_estimations.ipaddress, bom_estimationdetails.quantity, inv_items2.name item ";
		  $join=" left join inv_items on bom_estimations.itemid=inv_items.id left join bom_estimationdetails on bom_estimationdetails.estimationid=bom_estimations.id left join inv_items inv_items2 on inv_items2.id=bom_estimationdetails.itemid ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $estimations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $res=$estimations->result;
		  while($row=mysql_fetch_object($res)){
		  $j++;
		  
		  $quantity = $shop[$i]['quantity']*$row->quantity;
	  ?>
		  <tr>
			  <td><?php echo $j; ?></td>
			  <td><?php echo $row->itemid; ?></td>
			  <td><?php echo $row->item; ?></td>
			  <td><?php echo $quantity; ?></td>
		  </tr>
	  <?php 
		  }
		  $i++;
		}
	?>
	</tbody>
</table>

<?php
include"../../../foot.php";
?>
