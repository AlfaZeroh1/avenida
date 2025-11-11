<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teams_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../pos/teamroles/Teamroles_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}



$page_title="Teams";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11928";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$ob = (object)$_GET;
$obj = (object)$_POST;

if($obj->action=="Build Team"){
  
  //check that an active shift with a different date do not existsRule
  $shop = $_SESSION['shpbranches'];
  $i=0;
  $error="";
  while($i<count($shop)){
    $query="select b.name, t.teamedon, pos_shifts.name shiftid from pos_teams t left join sys_branches b on t.brancheid=b.id left join pos_shifts on pos_shifts.id=t.shiftid where t.brancheid='".$shop[$i]."' and t.teamedon!='$obj->teamedon' and t.status=0 and t.shiftid!='$obj->shiftid' order by t.id desc ";//echo "$query</br>";
    $res = mysql_query($query);
    if(mysql_affected_rows()>0){
      
      $rw = mysql_fetch_object($res);
      $error.=$rw->name." ($rw->shiftid): ".$rw->teamedon." is still open!";
      
    }
    $i++;
  }
  
  if(empty($error))
    redirect("../teamdetails/teamdetails.php?shiftid=".$obj->shiftid."&teamedon=".$obj->teamedon."&teamroleid=".$obj->teamroleid);
  else
    showError($error);
}

if(empty($obj->action)){
  unset($_SESSION['shpbranches']);
  $obj->teamedon=date("Y-m-d");
}

if(!empty($ob->shiftid))
  $obj->shiftid=$ob->shiftid;

$delid=$_GET['delid'];
$teams=new Teams();
if(!empty($delid)){
	$teams->id=$delid;
	$teams->delete($teams);
	redirect("teams.php");
}
//Authorization.
$auth->roleid="11927";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addteams_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>

<script type="text/javascript">
function setBranch(id){
  var checked=0;
  checked=$("#"+id).is(':checked');
  $.post("setbranch.php",{id:id, checked:checked});
}
</script>

<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Location </th>
			<th>Shift </th>
			<th>Startedon </th>
			<th>Ended On </th>
			<th>Teamed On </th>
			<th>Remarks </th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$branches = new Branches();
		$fields="*";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where type='Center' ";
		$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$branches->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		//check if a team is consituted already
		$query="select * from pos_teams where brancheid='$row->id' and shiftid='$ob->shiftid' and status=0 ";
		$rw = mysql_fetch_object(mysql_query($query));
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" name="<?php echo $row->id; ?>" id="<?php echo $row->id; ?>" onChange="setBranch('<?php echo $row->id; ?>');"/></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->shiftid; ?></td>
			<td><?php echo ($rw->startedon); ?></td>
			<td><?php echo ($rw->endedon); ?></td>
			<td><?php echo formatDate($rw->teamedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

<!-- <a href="../teamdetails/teamdetails.php?shiftid=<?php echo $ob->shiftid; ?>" class="btn btn-info">Build Team</a> -->
<form method="post" action="">
  <table>
  <tr>
    <td>Team Roles</td>
    <td><select name="teamroleid" required id="teamroleid">
	  <option value="">ALL</option>
	  <?php
	  $teamroles = new Teamroles();
	  $fields="*";
	  $join=" ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" ";
	  $teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($row=mysql_fetch_object($teamroles->result)){
	  ?>
	    <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->teamroleid)echo "selected"; ?>><?php echo $row->name; ?></option>
	  <?
	  }
	  ?>
	</select></td>
    <td>Teamed On:</td>
    <td>
      <input type="hidden" name="shiftid" value="<?php echo $obj->shiftid; ?>"/>
      <input type="text" name="teamedon" required readonly id="teamedon" value="<?php echo $obj->teamedon; ?>" class="date_input"/></td>
    <td><input type="submit" name="action" class="btn btn-info" value="Build Team"/></td>
  </tr>
  
  </table>
</form>
<?php
include"../../../foot.php";
?>
