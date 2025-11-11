<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
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
<form class="forms" id="theform" action="addleveldashboards_proc.php" name="leveldashboards" method="POST" enctype="multipart/form-data">
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
		<td align="right"> : </td>
			<td><select name="levelid" class="selectbox">
<option value="">Select...</option>
<?php
	$levels=new Levels();
	$where="  ";
	$fields="auth_levels.id, auth_levels.name, auth_levels.createdby, auth_levels.createdon, auth_levels.lasteditedby, auth_levels.lasteditedon, auth_levels.ipaddress";
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
		<td align="right">Dash Board Statistic : </td>
			<td><select name="dashboardid" class="selectbox">
<option value="">Select...</option>
<?php
	$dashboards=new Dashboards();
	$where="  ";
	$fields="sys_dashboards.id, sys_dashboards.name, sys_dashboards.type, sys_dashboards.query, sys_dashboards.status, sys_dashboards.remarks, sys_dashboards.ipaddress, sys_dashboards.createdby, sys_dashboards.createdon, sys_dashboards.lasteditedby, sys_dashboards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$dashboards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($dashboards->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->dashboardid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td>
			<input type="radio" name="status" id="status" value='active' <?php if($obj->status=='active'){echo"checked";}?>>Active 
			<input type="radio" name="status" id="status" value='inactive' <?php if($obj->status=='inactive'){echo"checked";}?>>Inactive 
		</td>
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