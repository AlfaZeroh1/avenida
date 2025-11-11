<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transferdetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../../modules/sys/branches/Branches_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Transferdetails";
//connect to db
$db=new DB();

$ob = (object)$_GET;
$obj = (object)$_POST;

if(!empty($ob->brancheid))
  $obj->brancheid=$ob->brancheid;

if(!empty($ob->did)){
  $query="update inv_itemdetails dt, inv_transferdetails td set dt.instalcode=td.instalcode where dt.id='$ob->did' and td.id='$ob->transferid'";
  mysql_query($query);
  $sql="update tmp set status=1 where id='$ob->did'";
  mysql_query($sql);
  
  redirect("tmp.php");
}

include"../../../head.php";
?>


<form method="post" action="">
<table align="center">
    <tr>
      <td align="right">Solar Center: </td>
      <td><select name="brancheid" class="selectbox">
      
      <option value="">ALL</option>
      
      <?php
	      $branches=new Branches();
	      $where="";
	      $fields="*";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby=" order by name ";
	      $branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	      while($rw=mysql_fetch_object($branches->result)){
	      ?>
		      <option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	      <?php
	      }
	      ?>
      </select></td>
      <td><input type="submit" class="btn btn-primary" name="action" value="Filter"/></td>
    </tr>
  </table>
</form>

<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Branch </th>
			<th>Serial No </th>
			<th>Current Instal Code </th>
			<th>Original Instal Code </th>
			<th>&nbsp; </th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$query=" select tmp.id, tmp.transferid, tmp.status, sys_branches.name brancheid, tmp.serialno, tmp.crdcode1, tmp.crdcode2 from tmps tmp left join sys_branches on tmp.brancheid=sys_branches.id ";
		if(!empty($obj->brancheid))
		  $query.=" where tmp.brancheid='$obj->brancheid'";
		$res = mysql_query($query);
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->serialno; ?></td>
			<td><?php echo $row->crdcode1; ?></td>
			<td><?php echo $row->crdcode2; ?></td>
			<td>
			<?php if(empty($row->status)){ ?>
			<a href="tmp.php?did=<?php echo $row->id; ?>&transferid=<?php echo $row->transferid; ?>&branheid=<?php echo $obj->brancheid; ?>">Confirm</a>
			<?php } ?>&nbsp;
			</td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
