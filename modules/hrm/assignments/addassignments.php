<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
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
 </script>

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addassignments_proc.php" name="assignments" method="POST" enctype="multipart/form-data">
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
		<td align="right">Code : </td>
		<td><input type="text" name="code" id="code" value="<?php echo $obj->code; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
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
		<td align="right">HR Level : </td>
			<td><select name="levelid" class="selectbox">
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
		<td align="right"> Leave Section: </td>
		<td><select name="leavesectionid" class="selectbox">
		  <option value="">Select...</option>
		  <?php
			  $leavesection=new Leavesections();
			  $where="";
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $leavesection->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			  while($rw=mysql_fetch_object($leavesection->result)){
			  ?>
				  <option value="<?php echo $rw->id; ?>" <?php if($obj->leavesectionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
			  <?php
			  }
			  ?>
		  </select>
		</td>
	</tr>
	<tr>
		<td align="right"> Section: </td>
		<td><select name="sectionid" class="selectbox">
		  <option value="">Select...</option>
		  <?php
			  $section=new Sections();
			  $where="";
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $section->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			  while($rw=mysql_fetch_object($section->result)){
			  ?>
				  <option value="<?php echo $rw->id; ?>" <?php if($obj->sectionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
			  <?php
			  }
			  ?>
		  </select>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>