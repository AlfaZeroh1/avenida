<title>WiseDigits: Routedetails </title>
<?php 
$pop=1;
include "../../../head.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 
 function GetXmlHttpObject()
{
  if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
  
  if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

 function getAssignments(id, assignmentid)
{
	//var id=document.getElementById("plotid").value;
	//var houseid=document.getElementById("houseid").value;
	var xmlhttp;
	var url="populate.php?id="+id+"&assignmentid="+assignmentid;
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }  
	/*** changed ***/
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			document.getElementById("assignmentid").innerHTML=xmlhttp.responseText;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function checkProjects(st){
 document.getElementById("project").value="";
 var dv = document.getElementById('projectdiv');
  if(st=='Yes'){
    dv.style.display="block";
  }
  else if(st=='No'){
    dv.style.display="none";
  }
 }
 
womAdd('checkProjects("No")');

womAdd('placeCursorOnPageLoad()');
womOn();

getAssignments("<?php echo $obj->departmentid; ?>","<?php echo $obj->assignmentid; ?>");
 </script>

<div class='main'>
<form class="forms" id="theform" action="addroutedetails_proc.php" name="routedetails" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Route : </td>
			<td><input type="hidden" name="routeid" value="<?php echo $obj->routeid; ?>"/>
<?php
	$routes=new Routes();
	$where=" where id='$obj->routeid' ";
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$routes = $routes->fetchObject;
	echo $routes->name;
	?>
		</td>
	</tr>
	
	<tr>
		<td align="right">HR Level : </td>
			<td><?php echo $obj->levelid; ?><select name="levelid" class="selectbox">
<option value="">Select...</option>
<?php
	$levels=new Levels();
	$where="  ";
	$fields="hrm_levels.id, hrm_levels.name, hrm_levels.overallno, hrm_levels.deptno, hrm_levels.follows, hrm_levels.remarks, hrm_levels.ipaddress, hrm_levels.createdby, hrm_levels.createdon, hrm_levels.lasteditedby, hrm_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($levels->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->levelid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox" onchange="getAssignments(this.value,'');">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Assignment : </td>
			<td>
			<?php
			$assignments=new Assignments();
			$where="  ";
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			?>
			<select name="assignmentid" id="assignmentid" class="selectbox">
<option value="">Select...</option>
<?php
	

	while($rw=mysql_fetch_object($assignments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->assignmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
</tr>
<tr>
<td align="right">Project : </td>
<td><input type="radio" name="prj" id="prj" value="Yes" <?php if($obj->prj=='Yes'){echo "checked";}?> onclick="checkProjects('No');" />Current<br/>
      <input type="radio" name="prj" id="prj" value="No" <?php if($obj->prj=='No'){echo "checked";}?> onclick="checkProjects('Yes');"/>Specific&nbsp;
      <div id="projectdiv">
      <select name="project" id="project"  class="selectbox">
<option value="">Select...</option>
<?php
	$projects=new Projects();
	$where=" ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projects->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->project==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Query : </td>
		<td><textarea name="query"><?php echo $obj->query; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">System Task : </td>
			<td><select name="systemtaskid" class="selectbox">
<option value="">Select...</option>
<?php
	$systemtasks=new Systemtasks();
	$where="  ";
	$fields="wf_systemtasks.id, wf_systemtasks.name, wf_systemtasks.action, wf_systemtasks.remarks, wf_systemtasks.ipaddress, wf_systemtasks.createdby, wf_systemtasks.createdon, wf_systemtasks.lasteditedby, wf_systemtasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$systemtasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($systemtasks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->systemtaskid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Comes After : </td>
		<td><?php
		$routedetails = new Routedetails();
		$fields="wf_routedetails.id, hrm_assignments.name assignmentid, hrm_levels.name levelid, wf_systemtasks.name systemtaskid";
		$join="left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid left join hrm_levels on hrm_levels.id=wf_routedetails.levelid left join wf_systemtasks on wf_systemtasks.id=wf_routedetails.systemtaskid ";
		$orderby = " order by wf_routedetails.follows ";
		$having="";
		$groupby="";
		$where=" where wf_routedetails.routeid='$obj->routeid' and wf_routedetails.id not in('$obj->id') ";
		$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		?>
		<select name="follows" class="selectbox">
		<option value="">Select...</option>
		<?php		
		$i=0;
		while($rw=mysql_fetch_object($routedetails->result)){$i++;
		?>
			<option value="<?php echo $rw->id; ?>" <?php if($obj->follows==$rw->id){echo "selected";}?>><?php echo $i; ?>: &nbsp; <?php echo initialCap($rw->assignmentid);?><?php echo initialCap($rw->levelid);?><?php echo initialCap($rw->systemtaskid);?></option>
		<?php
		}
		?>
		</select>
		
		</td>
	</tr>
	<tr>
		<td align="right">Expected Stay : </td>
		<td><input type="text" name="expectedduration" id="expectedduration" size="8"  value="<?php echo $obj->expectedduration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration Type : </td>
		<td><select name='durationtype' class="selectbox">
			<option value='Hrs' <?php if($obj->durationtype=='Hrs'){echo"selected";}?>>Hrs</option>
			<option value='Days' <?php if($obj->durationtype=='Days'){echo"selected";}?>>Days</option>
			<option value='Weeks' <?php if($obj->durationtype=='Weeks'){echo"selected";}?>>Weeks</option>
			<option value='Months' <?php if($obj->durationtype=='Months'){echo"selected";}?>>Months</option>
		</select></td>
	</tr>
	<tr>
	  <td align="right">Approval Stage : </td>
	  <td><input type="radio" name="approval" id="approval" value="Yes" <?php if($obj->approval=='Yes'){echo "checked";}?> />Yes<br/>
		<input type="radio" name="approval" id="approval" value="No" <?php if($obj->approval=='No'){echo "checked";}?> />No&nbsp;
      </tr>
      <tr>
		<td align="right">Query after Task : </td>
		<td><textarea name="squery"><?php echo $obj->squery; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" class="btn btn-primary" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-cancel" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>