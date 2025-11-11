<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeclockings_class.php");
require_once("../employees/Employees_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../departments/Departments_class.php");
require_once("../levels/Levels_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeclockings";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4827";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

if(empty($obj->action)){
  $obj->today=date("Y-m-d");
  $obj->lastday=date("Y-m-d");
}

$delid=$_GET['delid'];
$employeeclockings=new Employeeclockings();
if(!empty($delid)){
	$employeeclockings->id=$delid;
	$employeeclockings->delete($employeeclockings);
	redirect("employeeclockings.php");
}
//Authorization.
$auth->roleid="4826";//View
$auth->levelid=$_SESSION['level'];
?>
<script type="text/javascript">



  function selectAll(str)
{
	if(str.checked)
	{//check all checkboxes under it
		
		<?php
		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.statusid=1 and hrm_employees.id not in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year')";
		$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($employees->result))
		{			
		?>
		if(document.getElementById("<?php echo $rw->id; ?>")){
			//alert("Success <?php echo $rw->id; ?>");
			document.getElementById("<?php echo $rw->id; ?>").checked=true;
		}
		<?php		
		}
		?>
	}
	else
	{
		//uncheck all checkboxes under it
		<?php
		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.statusid=1 and hrm_employees.id not in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year')";
		$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($employees->result))
		{
		?>
		document.getElementById("<?php echo $rw->id; ?>").checked=false;
		<?php
		}
		?>
	}
}
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
		var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=hrm_employeeclockings";//alert(url);
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}	
</script>
<?
if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeeclockings_proc.php',600,430);" value="Add Employeeclockings " type="button"/></div> -->
<?php }?>
<hr>
<form action="" method="post">
<table align='center'>
<tr>
<td colspan='2'></td>
</tr>
<tr>
<td>Dept
<select id="departmentid" name="departmentid">
<option value="">Select...</option>
<?
$departments = New Departments();
$where = "";
$fields ="*";
$join="";
$having="";
$groupby="";
$orderby="";
$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
while($rw=mysql_fetch_object($departments->result)){


?>
	<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
<?
}
?>
</select>

</td>
<td>Level
<select id="levelid" name="levelid">
<option value="">Select...</option>
<?
$levels = New Levels();
$where = "";
$fields ="*";
$join="";
$having="";
$groupby="";
$orderby="";
$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
while($rw=mysql_fetch_object($levels->result)){


?>
	<option value="<?php echo $rw->id; ?>" <?php if($obj->levelid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
<?
}
?>
</select>
</td>
<td><input type="text" class="date_input" readonly name="today" value="<?php echo $obj->today; ?>"/>&nbsp;<input type="text" class="date_input" readonly name="lastday" value="<?php echo $obj->lastday; ?>"/>&nbsp;
<input type="submit" name="action" class="btn" value="Filter"/>

</td>

</tr>
<table>

<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<?php
			$obj->todays=$obj->today;
			while($obj->todays<=$obj->lastday){
			
			?>
			<th><?php echo $obj->todays; ?></th>
			<?php 
			$currenttime = strtotime($obj->todays);
			$addtime     = $currenttime + (3600*24); //add seconds of one day
			$obj->todays      = date("Y-m-d", $addtime);//adjust the date
			}
			?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$employees = new Employees();
		$fields="hrm_employees.id as employeeid, hrm_employees.pfnum,hrm_employees.assignmentid, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names,hrm_assignments.levelid,hrm_assignments.departmentid,hrm_assignments.id";
		$join=" left join hrm_assignments on hrm_assignments.id = hrm_employees.assignmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.type=2 ";
		if(!empty($obj->departmentid))
		$where.=" and departmentid = $obj->departmentid";
		if (!empty($obj->levelid))
		$where.=" and levelid = $obj->levelid";
		
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employees->sql;
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->names; ?></td>
			<?php
			$obj->todays=$obj->today;
			while($obj->todays<=$obj->lastday){
			$employeeclockings = new Employeeclockings();
			$fields="*";
			$join=" ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where employeeid='$row->employeeid' and today='$obj->todays'";
			$employeeclockings->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $employeeclockings->sql."<br/>";
			$employeeclockings = $employeeclockings->fetchObject;
			
			
			$arr=array('employeeid'=>$row->employeeid, 'today'=>$obj->todays);

			  $sarr=rawurlencode(serialize($arr));
			?>
			<td><input type="text" name="" size='6' onchange="addMatrix(this,<?php echo $row->employeeid; ?>,'<?php echo $obj->todays; ?>','amount',this.value,'<?php echo $sarr; ?>');" value='<?php echo $employeeclockings->amount; ?>'></td>
			<?php 
				$currenttime = strtotime($obj->todays);
				$addtime     = $currenttime + (3600*24); //add seconds of one day
				$obj->todays      = date("Y-m-d", $addtime);//adjust the date
			}			
			?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
</form>
<?php
include"../../../foot.php";
?>
