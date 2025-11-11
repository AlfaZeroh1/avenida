<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Levels_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Levels";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

if($obj->action=="Rules"){
  
  $ids="";
  $levels = new Levels();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($row=mysql_fetch_object($levels->result)){
    if(isset($_POST[$row->id]))
      $ids.=$row->id.",";
  }
  
  $ids=substr($ids,0,-1);
  
      redirect("../rules/rules.php?ids=".$ids);

  
}

if($obj->action=="Statistics"){
  
  $ids="";
  $levels = new Levels();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($row=mysql_fetch_object($levels->result)){
    if(isset($_POST[$row->id]))
      $ids.=$row->id.",";
  }
  
  $ids=substr($ids,0,-1);
  
      redirect("../leveldashboards/leveldashboards.php?ids=".$ids);

  
}

$delid=$_GET['delid'];
$levels=new Levels();
if(!empty($delid)){
	$levels->id=$delid;
	$levels->delete($levels);
	redirect("levels.php");
}
//Authorization.
$auth->roleid="1";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class ="content">
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addlevels_proc.php', 600, 430);"><span>ADD LEVELS</span></a>
</div>
<?php }?>

<form method="POST" action="">
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th><input type="button" name="Check_All" value="Check All" onClick="Check(document.myform.<?$row->id?>)"></th>
			<th>Name </th>
			<th>Can only access Active Shifts </th>
			<th>URL</th>
<?php
//Authorization.
$auth->roleid="3";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="*, case when shift=1 then 'Yes' else 'No' end shift";
		$join="";
		$having="";
		$where=" ";
		$groupby="";
		$orderby="";
		$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$levels->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" value="<? echo "$row->id"; ?>" name="<? echo "$row->id"; ?>" /></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->shift; ?></td>
			<td><?php echo $row->url; ?></td>
<?php
//Authorization.
$auth->roleid="3";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlevels_proc.php?id=<?php echo $row->id; ?>', 600, 430);"><img src="../edit.png" alt="edit" title="edit" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='levels.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
<input type="submit" value="Rules" class="btn btn-primary" name="action" id="action" />
<input type="submit" value="Statistics" class="btn btn-primary" name="action" id="action" />
<hr>
</form>
<?php
include"../../../foot.php";
?>
