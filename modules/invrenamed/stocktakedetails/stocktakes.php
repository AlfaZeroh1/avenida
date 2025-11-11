<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktakedetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../inv/categorys/Categorys_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$ob = (object)$_GET;
$obj = (object)$_POST;

if(empty($obj->action)){
  $obj->takenon=date("Y-m-d");
}

$page_title="Stocktakedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11153";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

if($obj->action=="Close"){
  $query="update inv_stocktakes set status='Closed', closedon=now() where brancheid='$obj->brancheid' and openedon='$obj->takenon'";echo $query;
  mysql_query($query);
}

$delid=$_GET['delid'];
$stocktakedetails=new Stocktakedetails();
if(!empty($delid)){
	$stocktakedetails->id=$delid;
	$stocktakedetails->delete($stocktakedetails);
	redirect("stocktakes.php");
}
//Authorization.
$auth->roleid="11152";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addstocktakedetails_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>

<script type="text/javascript">
  function getWholes(itemid,quantity,stock,packages){
    
     var qnt = quantity*packages;  
     
     $("#qnt"+itemid).val(qnt);
     
     stockTake(itemid,qnt,stock);
    
  }
  
  function stockTake(itemid,quantity,stock){
    
    var takenon = $("#takenon").val();
    var brancheid = $("#brancheid").val();
    
    quantity = parseFloat(quantity);
    stock = parseFloat(stock);
    
    if(stock<0){
      stock*=-1;
    }
    var variance = quantity-stock;
    $("#variance"+itemid).text(variance);
    
    $.post("stockTake.php",{itemid:itemid,quantity:quantity, takenon:takenon, stock:stock, brancheid:brancheid});
    
  }
</script>

<form action="stocktakes.php" method="post">
  <table class="table">
    <tr>
      <td align="right">LOCATION:</td>
      <td><select name="brancheid" id="brancheid">
      <option value="">Select...</option>
    <?php
	  $branches = new Branches();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where="" ;
	  $orderby=" order by name ";
	  $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  while($rw=mysql_fetch_object($branches->result)){
	  ?>
	    <option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->brancheid)echo "selected";?>><?php echo $rw->name; ?></option>
	  <?php
	  }
	  ?>
      </select></td>
      <td align="right">Category:</td>
      <td><select name="categoryid" id="categoryid" class="selectbox">
	  <option value="">Select...</option>
	  <?php
		  $categorys=new Categorys();
		  $where="  ";
		  $fields="inv_categorys.id, inv_categorys.name, inv_categorys.remarks, inv_categorys.createdby, inv_categorys.createdon, inv_categorys.lasteditedby, inv_categorys.lasteditedon, inv_categorys.ipaddress";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby=" order by name ";
		  $categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		  while($rw=mysql_fetch_object($categorys->result)){
		  ?>
			  <option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		  <?php
		  }
		  ?>
	  </select></td>
      <td align="right">Stock Take Date:</td>
      <td><input type="text" name="takenon" id="takenon" readonly class="date_input" value="<?php echo $obj->takenon; ?>"/></td>
      <td><input type="submit" name="action" class="btn btn-info" value="Filter"/>
	  <?php
	  $query="select * from inv_stocktakes where openedon='$obj->takenon' and brancheid='$obj->brancheid'";
	  $s = mysql_fetch_object(mysql_query($query));
// 	  if(!empty($s->status)){
	  
	  $class="info";
	  $value="";
	  if($s->status=="Active" or empty($s->status)){
	    $class="warning";
	    $value="Close";
	  }elseif($s->status=="Closed"){
	    $class="success";
	    $value="Open";
	  }
	  
	  ?>
	    <input type="submit" name="action" class="btn btn-<?php echo $class; ?>" value="<?php echo $value; ?>"/>
	  <?php
// 	  }
	  ?>
	  </td>
    </tr>
  </table>
</form>

<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item Name </th>
<!-- 			<th>Wholes</th> -->
			<th>Quantity </th>
			<th>Current Stock</th>
			<th>Variance</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		
		if(!empty($obj->action)){
		
		$items = new Items();
		$fields="inv_items.*, trim(name) name ";
		$join=" ";
		if(!empty($obj->brancheid)){
		  $join.=" left join sys_branchcategorys on sys_branchcategorys.categoryid=inv_items.categoryid ";
		}
		$having="";
		$groupby="";
		$orderby=" order by name ";
		$where=" where inv_items.status='Active'";
		if(!empty($obj->brancheid)){
		  if(empty($where))
		    $where=" where ";
		  else
		    $where.=" and ";
		  $where.=" sys_branchcategorys.brancheid='$obj->brancheid' ";
		}
		if(!empty($obj->categoryid)){
		  if(empty($where))
		    $where=" where ";
		  else
		    $where.=" and ";
		  $where.=" inv_items.categoryid='$obj->categoryid' ";
		}
		
// 		if(empty($where))
// 		  $where=" where ";
// 		else
// 		  $where.=" and ";
// 		$where.=" inv_items.id not in(select itemid from inv_compositeitems) ";
		
		$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo  $items->sql;
		$res=$items->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		//get stocktakedetails
		$query="select * from inv_stocktakedetails where itemid='$row->id' and takenon='$obj->takenon' and brancheid='$obj->brancheid'";
		$rw = mysql_fetch_object(mysql_query($query));
		
		if($obj->takenon<>date("Y-m-d") and !empty($rw->id)){
		  $query="select stock quantity from inv_stocktakedetails where itemid='$row->id' and brancheid='$obj->brancheid' and takenon<='$obj->takenon' order by id desc";
		}else{
		  $query="select * from inv_branchstocks where itemid='$row->id' and brancheid='$obj->brancheid'";
		}
		$rws = mysql_fetch_object(mysql_query($query));
		
		$row->quantity=$rws->quantity;
		
		if($row->quantity<0)
		  $row->quantity*=-1;
		  
		$variance=$rw->quantity-$row->quantity;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo strtoupper($row->name); ?></td>
			<td><input type="text" <?php if(empty($obj->brancheid))echo "readonly"; ?> id="qnt<?php echo $row->id; ?>" size="4" onChange="stockTake('<?php echo $row->id; ?>',this.value,'<?php echo $row->quantity; ?>');" value="<?php echo $rw->quantity; ?>"/></td>
			<td><?php echo $row->quantity; ?></td>
			<td><div id="variance<?php echo $row->id; ?>"><?php echo $variance; ?></div></td>
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
