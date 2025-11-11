<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
$pop=1;include "../../../head.php";

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
<form class="forms" id="theform" action="addsubmodules_proc.php" name="submodules" method="POST" enctype="multipart/form-data">
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
		<td align="right">Table Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Module : </td>
			<td><select name="moduleid" class="selectbox">
<option value="">Select...</option>
<?php
	$modules=new Modules();
	$where="  ";
	$fields="sys_modules.id, sys_modules.name, sys_modules.description, sys_modules.url, sys_modules.position, sys_modules.status, sys_modules.indx";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($modules->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->moduleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Index Page : </td>
		<td><input type="text" name="indx" id="indx" value="<?php echo $obj->indx; ?>"></td>
	</tr>
	<tr>
		<td align="right">URl : </td>
		<td><textarea name="url"><?php echo $obj->url; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Priority : </td>
		<td><input type="text" name="priority" id="priority" value="<?php echo $obj->priority; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><input type="text" name="status" id="status" value="<?php echo $obj->status; ?>"></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td><input type="radio" name="type" id="type" value="main" <?php if($obj->type=="main"){echo "checked";} ?>/>Main&nbsp;
		<input type="radio" name="type" id="type" value="setup" <?php if($obj->type=="setup"){echo "checked";} ?>/>Set Up&nbsp;
		<input type="radio" name="type" id="type" value="reports" <?php if($obj->type=="reports"){echo "checked";} ?>/>Reports</td>
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