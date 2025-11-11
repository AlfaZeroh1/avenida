<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeereliefs/Employeereliefs_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeereliefs";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

//processing filters
$rptwhere='';
$track=0;
$fds='';
$fd='';
if(!empty($obj->id)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.id='$obj->id'";
	$track++;
}

if(!empty($obj->reliefid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.reliefid='$obj->reliefid'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->premium)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.premium='$obj->premium'";
	$track++;
}

if(!empty($obj->amount)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.amount='$obj->amount'";
	$track++;
}

if(!empty($obj->month)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.month='$obj->month'";
	$track++;
}

if(!empty($obj->year)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.year='$obj->year'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->createdon)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.createdon='$obj->createdon'";
	$track++;
}

if(!empty($obj->lasteditedby)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.lasteditedby='$obj->lasteditedby'";
	$track++;
}

if(!empty($obj->lasteditedon)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeereliefs.lasteditedon='$obj->lasteditedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#amouname").autocomplete({
	source:"../../../modules/server/server/search.php?main=&module=&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#amount").val(ui.item.id);
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
<form  action="employeereliefs.php" method="post" name="employeereliefs">
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Id</td>
				<td>
				<select name='id'>
				<option value="">Select...</option>
				<?php
				$=new ();
				$where="  ";
				$fields="";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->id==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Relief</td>
				<td><input type='text' id='reliefid' size='0' name='reliefid' value='<?php echo $obj->reliefid;?>'></td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' id='employeeid' size='0' name='employeeid' value='<?php echo $obj->employeeid;?>'></td>
			</tr>
			<tr>
				<td>Premium</td>
				<td>
				<select name='premium'>
				<option value="">Select...</option>
				<?php
				$=new ();
				$where="  ";
				$fields="";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->premium==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Amount</td>
				<td><input type='text' size='0' name='amouname' id='amouname' value='<?php echo $obj->amouname; ?>'>
					<input type="hidden" name='amount' id='amount' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Month</td>
				<td>
				<select name='month'>
				<option value="">Select...</option>
				<?php
				$=new ();
				$where="  ";
				$fields="";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->month==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Year</td>
				<td>
				<select name='year'>
				<option value="">Select...</option>
				<?php
				$=new ();
				$where="  ";
				$fields="";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->year==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Created By</td>
				<td><input type='text' id='createdby' size='0' name='createdby' value='<?php echo $obj->createdby;?>'></td>
			</tr>
			<tr>
				<td>Created On</td>
			</tr>
			<tr>
				<td>Last Edited By</td>
				<td><input type='text' id='lasteditedby' size='0' name='lasteditedby' value='<?php echo $obj->lasteditedby;?>'></td>
			</tr>
			<tr>
				<td>Last Edited On</td>
			</tr>
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
				<td><input type='checkbox' name='shid' value='1' <?php if(isset($_POST['shid']) ){echo"checked";}?>>&nbsp;Id</td>
				<td><input type='checkbox' name='shreliefid' value='1' <?php if(isset($_POST['shreliefid']) ){echo"checked";}?>>&nbsp;Relief</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shpercent' value='1' <?php if(isset($_POST['shpercent']) ){echo"checked";}?>>&nbsp;%</td>
			<tr>
				<td><input type='checkbox' name='shpremium' value='1' <?php if(isset($_POST['shpremium']) ){echo"checked";}?>>&nbsp;Premium</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount']) ){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shmonth' value='1' <?php if(isset($_POST['shmonth']) ){echo"checked";}?>>&nbsp;Month</td>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear']) ){echo"checked";}?>>&nbsp;Year</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shlasteditedby' value='1' <?php if(isset($_POST['shlasteditedby']) ){echo"checked";}?>>&nbsp;Last Edited By</td>
				<td><input type='checkbox' name='shlasteditedon' value='1' <?php if(isset($_POST['shlasteditedon']) ){echo"checked";}?>>&nbsp;Last Edited On</td>
			<tr>
				<td><input type='checkbox' name='shfirstname' value='1' <?php if(isset($_POST['shfirstname']) ){echo"checked";}?>>&nbsp;First Name</td>
				<td><input type='checkbox' name='shmarita' value='1' <?php if(isset($_POST['shmarita']) ){echo"checked";}?>>&nbsp;Marital Status</td>
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
			<?php if($obj->shid==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shreliefid==1 ){ ?>
				<th>Relief </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1 ){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shpercent==1 ){ ?>
				<th>% </th>
			<?php } ?>
			<?php if($obj->shpremium==1 ){ ?>
				<th>Premium </th>
			<?php } ?>
			<?php if($obj->shamount==1 ){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shmonth==1 ){ ?>
				<th>Month </th>
			<?php } ?>
			<?php if($obj->shyear==1 ){ ?>
				<th>Year </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shlasteditedby==1 ){ ?>
				<th>LastEditedBy </th>
			<?php } ?>
			<?php if($obj->shlasteditedon==1 ){ ?>
				<th>LastEditedOn </th>
			<?php } ?>
			<?php if($obj->shfirstname==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shmarita==1 ){ ?>
				<th> </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$employeereliefs=new Employeereliefs();
		$fields="hrm_employeereliefs.id, hrm_employeereliefs.reliefid, hrm_employeereliefs.employeeid, hrm_employeereliefs.percent, hrm_employeereliefs.premium, hrm_employeereliefs.amount, hrm_employeereliefs.month, hrm_employeereliefs.year, hrm_employeereliefs.createdby, hrm_employeereliefs.createdon, hrm_employeereliefs.lasteditedby, hrm_employeereliefs.lasteditedon".$fds.$fd;
		$join="";
		$having="";
		$where= " $rptwhere";
		$groupby= " $rptgroup";
		$orderby="";
		$employeereliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeereliefs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->shid==1 ){ ?>
				<td><?php echo $row->id; ?></td>
			<?php } ?>
			<?php if($obj->shreliefid==1 ){ ?>
				<td><?php echo $row->reliefid; ?></td>
			<?php } ?>
			<?php if($obj->shemployeeid==1 ){ ?>
				<td><?php echo $row->employeeid; ?></td>
			<?php } ?>
			<?php if($obj->shpercent==1 ){ ?>
				<td><?php echo $row->percent; ?></td>
			<?php } ?>
			<?php if($obj->shpremium==1 ){ ?>
				<td><?php echo $row->premium; ?></td>
			<?php } ?>
			<?php if($obj->shamount==1 ){ ?>
				<td><?php echo $row->amount; ?></td>
			<?php } ?>
			<?php if($obj->shmonth==1 ){ ?>
				<td><?php echo $row->month; ?></td>
			<?php } ?>
			<?php if($obj->shyear==1 ){ ?>
				<td><?php echo $row->year; ?></td>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<td><?php echo $row->createdby; ?></td>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<td><?php echo $row->createdon; ?></td>
			<?php } ?>
			<?php if($obj->shlasteditedby==1 ){ ?>
				<td><?php echo $row->lasteditedby; ?></td>
			<?php } ?>
			<?php if($obj->shlasteditedon==1 ){ ?>
				<td><?php echo $row->lasteditedon; ?></td>
			<?php } ?>
			<?php if($obj->shfirstname==1 ){ ?>
				<td><?php echo $row->firstname; ?></td>
			<?php } ?>
			<?php if($obj->shmarita==1 ){ ?>
				<td><?php echo $row->marita; ?></td>
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
