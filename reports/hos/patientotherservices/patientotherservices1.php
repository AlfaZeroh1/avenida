<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/patientotherservices/Patientotherservices_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Patientotherservices";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

//processing filters
$rptwhere='';
$track=0;
$fds='';
$fd='';
if(!empty($obj->otherserviceid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patientotherservices.otherserviceid='$obj->otherserviceid'";
	$track++;
}

if(!empty($obj->charge)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patientotherservices.charge='$obj->charge'";
	$track++;
}

if(!empty($obj->shremarks)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patientotherservices.shremarks='$obj->shremarks'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grotherserviceid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" otherserviceid ";
	$obj->shotherserviceid=1;
	$track++;
}

//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#otherservicename").autocomplete({
	source:"../../../modules/server/server/search.php?main=&module=&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#otherserviceid").val(ui.item.id);
	}
  });

});
</script>
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
<form  action="patientotherservices.php" method="post" name="patientotherservices">
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Service</td>
				<td><input type='text' size='6' name='otherservicename' id='otherservicename' value='<?php echo $obj->otherservicename; ?>'>
					<input type="hidden" name='otherserviceid' id='otherserviceid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Charge</td>
				<td><strong>From:</strong><input type='text' id='fromcharge' size='from6' name='fromcharge' value='<?php echo $obj->fromcharge;?>'/>
								<br/><strong>To:</strong><input type='text' id='tocharge' size='to6' name='tocharge' value='<?php echo $obj->tocharge;?>'></td>
			</tr>
			<tr>
				<td>Remarks</td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grotherserviceid' value='1' <?php if(isset($_POST['grotherserviceid']) ){echo"checked";}?>>&nbsp;Service</td>
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
				<td><input type='checkbox' name='shotherserviceid' value='1' <?php if(isset($_POST['shotherserviceid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Service</td>
				<td><input type='checkbox' name='shcharge' value='1' <?php if(isset($_POST['shcharge'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Charge</td>
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
			<?php if($obj->shotherserviceid==1  or empty($obj->action)){ ?>
				<th>Service </th>
			<?php } ?>
			<?php if($obj->shcharge==1  or empty($obj->action)){ ?>
				<th>Charge </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$patientotherservices=new Patientotherservices();
		$fields="hos_patientotherservices.id, hos_patientotherservices.patienttreatmentid, hos_otherservices.name as otherserviceid, hos_patientotherservices.charge, hos_patientotherservices.remarks, hos_patientotherservices.createdby, hos_patientotherservices.createdon, hos_patientotherservices.lasteditedby, hos_patientotherservices.lasteditedon".$fds.$fd;
		$join=" left join hos_otherservices on hos_patientotherservices.otherserviceid=hos_otherservices.id ";
		$having="";
		$where= " $rptwhere";
		$groupby= " $rptgroup";
		$orderby="";
		$patientotherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientotherservices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->shotherserviceid==1  or empty($obj->action)){ ?>
				<td><?php echo $row->otherserviceid; ?></td>
			<?php } ?>
			<?php if($obj->shcharge==1  or empty($obj->action)){ ?>
				<td><?php echo $row->charge; ?></td>
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
