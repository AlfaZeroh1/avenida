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
<form class="forms" id="theform" action="addbranchstocks_proc.php" name="branchstocks" method="POST" enctype="multipart/form-data">
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
		<td align="right">Branch : </td>
			<td><select name="brancheid" class="selectbox">
			  <option value="">Select...</option>
			  <?php
				  $branches=new Branches();
				  $where="  ";
				  $fields="*";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				  while($rw=mysql_fetch_object($branches->result)){
				  ?>
					  <option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				  <?php
				  }
				  ?>
			  </select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Item : </td>
			<td><select name="itemid" class="selectbox">
			  <option value="">Select...</option>
			  <?php
				  $items=new Items();
				  $where=" ";
				  $fields="*";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				  while($rw=mysql_fetch_object($items->result)){
				  ?>
					  <option value="<?php echo $rw->id; ?>" <?php if($obj->itemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				  <?php
				  }
				  ?>
			  </select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
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