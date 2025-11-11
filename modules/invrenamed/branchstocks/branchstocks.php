<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Branchstocks_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Branchstocks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9494";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$branchstocks=new Branchstocks();
if(!empty($delid)){
	$branchstocks->id=$delid;
	$branchstocks->delete($branchstocks);
	redirect("branchstocks.php");
}
//Authorization.
$auth->roleid="9493";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addbranchstocks_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>
<form class="forms" id="theform" action="branchstocks.php" method="POST">
    <div>  
	<select name="brancheid" class="selectbox">
	    <option value="">Select...</option>
	    <?php
		    $branches=new Branches();
		    $where="  ";
		    $fields="*";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		    while($rw=mysql_fetch_object($branches->result)){
		    ?>
			    <option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		    <?php
		    }
		    ?>
	</select><font color='red'>*</font>
	<input class="btn btn-info" type="submit" name="action" value="Filter"/>
    </div>
</form>
<table style="clear:both;"  class="table table-codensed" id="example" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Branch </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="inv_branchstocks.id, sys_branches.name as brancheid, inv_items.name as itemname,inv_branchstocks.quantity ";
		$join=" left join sys_branches on inv_branchstocks.brancheid=sys_branches.id  left join inv_items on inv_branchstocks.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where inv_branchstocks.brancheid='".$obj->brancheid."' ";
		$branchstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$branchstocks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->itemname; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addbranchstocks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
