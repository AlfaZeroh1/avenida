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
<form class="forms" id="theform" action="addteamroles_proc.php" name="teamroles" method="POST" enctype="multipart/form-data">
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
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td>
			<input type="radio" name="type" id="type" value='Supervisor' <?php if($obj->type=='Supervisor'){echo"checked";}?>>Supervisor 
			<input type="radio" name="type" id="type" value='Waiter' <?php if($obj->type=='Waiter'){echo"checked";}?>>Waiter 
		</td>
	</tr>
	
	<tr>
		<td align="right">HR Level : </td>
		<td>
		<select name="levelid" id="levelid" class="selectbox">
		  <option value="">Select...</option>
		  <?php
		  $levels = new Levels();
		  $fields="*";
		  $join="  ";
		  $having="";
		  $groupby="";
		  $orderby=" order by name ";
		  $where ="  ";
		  $levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  while($row=mysql_fetch_object($levels->result)){
		    ?>
		    <option value="<?php echo $row->id; ?>" <?php if($obj->levelid==$row->id){echo "selected";} ?>><?php echo $row->name; ?></option>
		    <?
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