<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teamdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../pos/teams/Teams_class.php");
require_once("../../pos/shifts/Shifts_class.php");
require_once("../../hrm/employees/Employees_class.php");

$page_title="Teamdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11920";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

$shpbranches = $_SESSION['shpbranches'];

$shifts=new Shifts();
$fields=" * " ;
$join="  ";
$having="";
$groupby="";
$orderby="";
$where=" where id='$ob->shiftid' ";
$shifts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$shifts = $shifts->fetchObject;

$i=0;
$ids="";
while($i<count($shpbranches)){
  
  $ids.=$shpbranches[$i].",";
  
  
  $query="select * from pos_teams where shiftid='$ob->shiftid' and brancheid='".$shpbranches[$i]."' and date(teamedon)='$ob->teamedon'";
  mysql_query($query);
  
  if(mysql_affected_rows()==0){
    //create new teams
    $teams=new Teams();
    $teams->shiftid=$ob->shiftid;
    $teams->brancheid=$shpbranches[$i];
    $teams->teamedon=$ob->teamedon;
    $teams->startedon=date("Y-m-d H:i:s");
    $teams->status=1;
    $teams->createdby=$_SESSION['userid'];
    $teams->createdon=date("Y-m-d H:i:s");
    $teams->lasteditedby=$_SESSION['userid'];
    $teams->lasteditedon=date("Y-m-d H:i:s");
    $teams->ipaddress=$_SERVER['REMOTE_ADDR'];
    
    $teams->add($teams);
  }
  
  $i++;
}

$ids = substr($ids,0,-1);

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$teamdetails=new Teamdetails();
if(!empty($delid)){
	$teamdetails->id=$delid;
	$teamdetails->delete($teamdetails);
	redirect("teamdetails.php");
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
	<?php $teamdetails= new Teamdetails(); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=pos_teamdetails";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();

	tr.style.visibility="hidden";
	tr.style.display="none";
	}
	</script>

	<div class="panel panel-danger" style="text-transform:uppercase;">
	  
	  <div class="panel-heading"><?php echo $shifts->name; ?></div>

	</div>
<table style="clear:both;"  class="table" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	<?php
	$teams=new Teams();
	$fields=" pos_teams.id, sys_branches.name " ;
	$join=" left join sys_branches on sys_branches.id=pos_teams.brancheid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where sys_branches.id in($ids) and pos_teams.shiftid='$ob->shiftid' and date(pos_teams.teamedon)='$ob->teamedon' ";
	$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($teams->result)){
	?>
		<th><?php echo initialCap($rw->name); ?></th>
	<?php
	}
	?>
	</thead>
	<tbody>
	<?php
	$i=0;
	$employees=new Employees();
	$fields=" concat(hrm_employees.firstname, ' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name, hrm_employees.id, hrm_assignments.name assignmentid " ;
	$where=" where pos_teamroles.id='$ob->teamroleid' and hrm_employees.statusid=1 ";
	$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid left join hrm_levels on hrm_levels.id=hrm_assignments.levelid left join pos_teamroles on pos_teamroles.levelid=hrm_levels.id ";
	$having="";
	$groupby="";
	$orderby="";
	
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($employees->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->assignmentid); ?></td>
		<td><?php echo initialCap($rw->name); ?></td>
	<?php
		$teams=new Teams();
		$fields=" pos_teams.id, sys_branches.name " ;
		$join=" left join sys_branches on sys_branches.id=pos_teams.brancheid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where sys_branches.id in($ids) and pos_teams.shiftid='$ob->shiftid' and date(pos_teams.teamedon)='$ob->teamedon' ";
		$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($rw1=mysql_fetch_object($teams->result)){
			
			$teamdetails= new Teamdetails();
			$fields=" * ";
			$where = " where employeeid=$rw->id and teamid=$rw1->id "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$teamdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array("employeeid"=>$rw->id, "teamid"=>$rw1->id, "teamroleid"=>$ob->teamroleid);

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo $rw1->id; ?>" <?php if($teamdetails->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo $rw1->id; ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" ></td>
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
