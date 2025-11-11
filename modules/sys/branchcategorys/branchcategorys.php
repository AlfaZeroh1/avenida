<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Branchcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../sys/branches/Branches_class.php");
require_once("../../inv/categorys/Categorys_class.php");

$page_title="Branchcategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11932";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$branchcategorys=new Branchcategorys();
if(!empty($delid)){
	$branchcategorys->id=$delid;
	$branchcategorys->delete($branchcategorys);
	redirect("branchcategorys.php");
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
	<?php $branchcategorys= new Branchcategorys(); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=sys_branchcategorys";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();

	tr.style.visibility="hidden";
	tr.style.display="none";
	}
	</script>

<table style="clear:both;"  class="table" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
	<?php
	$branches=new Branches();
	$fields=" * " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($branches->result)){
	?>
		<th><?php echo initialCap($rw->name); ?></th>
	<?php
	}
	?>
	</thead>
	<tbody>
	<?php
	$i=0;
	$categorys=new Categorys();
	$fields=" * " ;
	$where="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($categorys->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->name); ?></td>
	<?php
		$branches=new Branches();
		$fields=" * " ;
		$where="  " ;
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($rw1=mysql_fetch_object($branches->result)){
			$branchcategorys= new Branchcategorys();
			$fields=" * ";
			$where = " where categoryid=$rw->id and brancheid=$rw1->id "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$branchcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array("categoryid"=>$rw->id, "brancheid"=>$rw1->id);

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo $rw1->id; ?>" <?php if($branchcategorys->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo $rw1->id; ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" ></td>
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
