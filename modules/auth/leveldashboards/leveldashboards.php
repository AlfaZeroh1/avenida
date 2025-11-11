<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leveldashboards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../levels/Levels_class.php");
require_once("../../sys/dashboards/Dashboards_class.php");

$page_title="Leveldashboards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11762";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

if(!empty($ob->ids)){
  $obj->ids=$ob->ids;
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$leveldashboards=new Leveldashboards();
if(!empty($delid)){
	$leveldashboards->id=$delid;
	$leveldashboards->delete($leveldashboards);
	redirect("leveldashboards.php");
}
?>
<script type="text/javascript">
	function addMatrix(str,xaxis,yaxis,field,value,arr)
	{
		if(str.checked)
		{
			var checked=1;
		}
		else
		{
			var checked=0;
		}
	if (str=="")
	{
	return;
	 }
	if (window.XMLHttpRequest)
	{
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	 }
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	 {
	 }
	}
	<?php $leveldashboards= new Leveldashboards(); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=auth_leveldashboards";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();

	tr.style.visibility="hidden";
	tr.style.display="none";
	}
	</script>

<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	<?php
	$levels=new Levels();
	$fields=" * " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id in($obj->ids)";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($levels->result)){
	?>
		<th><?php echo initialCap($rw->name); ?></th>
	<?php
	}
	?>
	</thead>
	<tbody>
	<?php
	$i=0;
	$dashboards=new Dashboards();
	$fields=" * " ;
	$where="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$dashboards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($dashboards->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->name); ?></td>
		<td><?php echo $rw->type; ?></td>
	<?php
		$levels=new Levels();
		$fields=" * " ;
		$where="  " ;
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id in($obj->ids)";
		$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($rw1=mysql_fetch_object($levels->result)){
			$leveldashboards= new Leveldashboards();
			$fields=" * ";
			$where = " where dashboardid=$rw->id and levelid=$rw1->id "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$leveldashboards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array("dashboardid"=>$rw->id, "levelid"=>$rw1->id);

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo $rw1->id; ?>" <?php if($leveldashboards->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo $rw1->id; ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" ></td>
			<?php
		}
		?>
	</tr>
		<?php
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
