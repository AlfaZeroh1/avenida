<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/itemdetails/Itemdetails_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Itemdetails";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

//processing filters
$rptwhere='';
$track=0;
$fds='';
//Processing Groupings
;$rptgroup='';
$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;">Open Popup To Filter</a></div>
<div id="boxB" class="sh" style="left: 10px; top: 63px; display: none; z-index: 500;">
<div id="box2"><div class="bar2" onmousedown="dragStart(event, 'boxB')"><span><strong>Choose Criteria</strong></span>
<a href="#" onclick="expandCollapse('boxB','over')">Close</a></div>
<form  action="itemdetails.php" method="post" name="itemdetails">
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
				<th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='shtransactdate' value='1' <?php if(isset($_POST['shtransactdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Date</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shtransaction' value='1' <?php if(isset($_POST['shtransaction'])  or empty($obj->action)){echo"checked";}?>>&nbsp;</td>
				<td><input type='checkbox' name='shremain' value='1' <?php if(isset($_POST['shremain'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Stock Remainder</td>
			<tr>
				<td><input type='checkbox' name='shvalue' value='1' <?php if(isset($_POST['shvalue'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remaining Value</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;TransactedBy</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<table style="clear:both;"  class="tgrid display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shtransaction==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shremain==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shvalue==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$itemdetails=new Itemdetails();
		$fields="pos_itemdetails.id, pos_items.name as itemid, pos_schemes.name as schemeid, pos_itemdetails.parcelno, pos_itemdetails.groundno, pos_itemdetails.status, pos_itemdetails.createdby, pos_itemdetails.createdon, pos_itemdetails.lasteditedby, pos_itemdetails.lasteditedon".$fds;
		$join=" left join pos_items on pos_itemdetails.itemid=pos_items.id  left join pos_schemes on pos_itemdetails.schemeid=pos_schemes.id ";
		$having="";
		$where= " $rptwhere";
		$groupby= " $rptgroup";
		$orderby="";
		$itemdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$itemdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<td><?php echo $row->transactdate; ?></td>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<td><?php echo $row->documentno; ?></td>
			<?php } ?>
			<?php if($obj->shtransaction==1  or empty($obj->action)){ ?>
				<td><?php echo $row->transaction; ?></td>
			<?php } ?>
			<?php if($obj->shremain==1  or empty($obj->action)){ ?>
				<td><?php echo $row->remain; ?></td>
			<?php } ?>
			<?php if($obj->shvalue==1  or empty($obj->action)){ ?>
				<td><?php echo $row->value; ?></td>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<td><?php echo $row->createdby; ?></td>
			<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</div>
</div>
</div>
</div>
</div>
