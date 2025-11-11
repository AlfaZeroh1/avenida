<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../auth/levels/Levels_class.php");
require_once("../../auth/roles/Roles_class.php");
require_once("../../sys/modules/Modules_class.php");

$page_title="Rules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;

if(!empty($ob->ids)){
  $obj->ids=$ob->ids;
}
$wh="";
if($obj->action=="Filter"){
  $wh=" and auth_roles.moduleid='$obj->moduleid' ";
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$rules=new Rules();
if(!empty($delid)){
	$rules->id=$delid;
	$rules->delete($rules);
	redirect("rules.php");
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
	document.getElementById("txtHint").innerHTML="";
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
	 document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	 }
	}
	<?php $rules= new Rules (); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=auth_rules";//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
	</script>

	<div style="clear:both;"></div>
<form action="" method="post">
<table>
  <tr>
    <td>Modules</td>
    <td><select name="moduleid">
	 <option value="">Select...</option>
      <?php
      $modules = new Modules();
      $where=" where id in(2,3,4,5,6,7,11,14,25,30,31,26,20)";
      $fields="*";
      $join="";
      $having="";
      $groupby="";
      $orderby="";
      $modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      while($row=mysql_fetch_object($modules->result)){
	?>
	<option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->moduleid){echo "selected";}?>><?php echo $row->name; ?></option>
	<?php
      }
      ?>
    </select>&nbsp;<input type="submit" class="btn" name="action" value="Filter"/>
    </td>
   </tr>
</table>
</form>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
	<?php
	$levels=new Levels ();
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
	$roles=new Roles ();
	$fields=" * " ;
	$where=" where auth_roles.moduleid in(2,3,4,5,6,7,11,14,25,30,31,26,20) $wh ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($roles->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->name); ?></td>
	<?php
		$levels=new Levels ();
		$fields=" * " ;
		$where=" where id in($obj->ids) " ;
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($rw1=mysql_fetch_object($levels->result)){
			$rules= new Rules ();
			$fields=" * ";
			$where = " where roleid=$rw->id and levelid=$rw1->id "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$rules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array('roleid'=>$rw->id, 'levelid'=>$rw1->id);

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo $rw1->id; ?>" <?php if($rules->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo $rw1->id; ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" <?php if($rw->id==1 and $rw1->id==1){echo"disabled";}?>></td>
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
