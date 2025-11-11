<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/patients/Patients_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/sys/genders/Genders_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Patients";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

//processing filters
$rptwhere='';
$track=0;
$fds='';
$fd='';
if(!empty($obj->patientno)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patients.patientno='$obj->patientno'";
	$track++;
}

if(!empty($obj->surname)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patients.surname='$obj->surname'";
	$track++;
}

if(!empty($obj->othernames)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patients.othernames='$obj->othernames'";
	$track++;
}

if(!empty($obj->genderid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patients.genderid='$obj->genderid'";
	$track++;
}

if(!empty($obj->dob)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hos_patients.dob='$obj->dob'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grpatientno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" patientno ";
	$obj->shpatientno=1;
	$track++;
}

if(!empty($obj->grgenderid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" genderid ";
	$obj->shgenderid=1;
	$track++;
}

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
<form  action="patients.php" method="post" name="patients">
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Patient No.</td>
				<td><input type='text' id='patientno' size='20' name='patientno' value='<?php echo $obj->patientno;?>'></td>
			</tr>
			<tr>
				<td>Surname</td>
				<td><input type='text' id='surname' size='20' name='surname' value='<?php echo $obj->surname;?>'></td>
			</tr>
			<tr>
				<td>Othernames</td>
				<td><input type='text' id='othernames' size='20' name='othernames' value='<?php echo $obj->othernames;?>'></td>
			</tr>
			<tr>
				<td>Gender</td>
				<td>
				<select name='genderid'>
				<option value="">Select...</option>
				<?php
				$genders=new Genders();
				$where="  ";
				$fields="sys_genders.id, sys_genders.name";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$genders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($genders->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->genderid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Date of Birth</td>
				<td><strong>From:</strong><input type='text' id='fromdob' size='from20' name='fromdob' value='<?php echo $obj->fromdob;?>'/>
								<br/><strong>To:</strong><input type='text' id='todob' size='to20' name='todob' value='<?php echo $obj->todob;?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grpatientno' value='1' <?php if(isset($_POST['grpatientno']) ){echo"checked";}?>>&nbsp;Patient No.</td>
				<td><input type='checkbox' name='grgenderid' value='1' <?php if(isset($_POST['grgenderid']) ){echo"checked";}?>>&nbsp;Gender</td>
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
				<td><input type='checkbox' name='shpatientno' value='1' <?php if(isset($_POST['shpatientno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient No.</td>
				<td><input type='checkbox' name='shsurname' value='1' <?php if(isset($_POST['shsurname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Surname</td>
			<tr>
				<td><input type='checkbox' name='shothernames' value='1' <?php if(isset($_POST['shothernames'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Surname</td>
				<td><input type='checkbox' name='shaddress' value='1' <?php if(isset($_POST['shaddress'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Address</td>
			<tr>
				<td><input type='checkbox' name='shmobile' value='1' <?php if(isset($_POST['shmobile']) ){echo"checked";}?>>&nbsp;Mobile</td>
				<td><input type='checkbox' name='shgenderid' value='1' <?php if(isset($_POST['shgenderid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Gender</td>
			<tr>
				<td><input type='checkbox' name='shdob' value='1' <?php if(isset($_POST['shdob'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Age</td>
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
			<?php if($obj->shpatientno==1  or empty($obj->action)){ ?>
				<th>Patient No </th>
			<?php } ?>
			<?php if($obj->shsurname==1  or empty($obj->action)){ ?>
				<th>Surname </th>
			<?php } ?>
			<?php if($obj->shothernames==1  or empty($obj->action)){ ?>
				<th>Other Names </th>
			<?php } ?>
			<?php if($obj->shaddress==1  or empty($obj->action)){ ?>
				<th>Address </th>
			<?php } ?>
			<?php if($obj->shmobile==1 ){ ?>
				<th>Mobile </th>
			<?php } ?>
			<?php if($obj->shgenderid==1  or empty($obj->action)){ ?>
				<th>Gender </th>
			<?php } ?>
			<?php if($obj->shdob==1  or empty($obj->action)){ ?>
				<th>Age </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$patients=new Patients();
		$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patientclasses.name as patientclasseid, hos_patients.bloodgroup, hos_patients.address, hos_patients.email, hos_patients.mobile, sys_genders.name as genderid, hos_patients.dob, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon, hos_civilstatuss.name as civilstatusid".$fds.$fd;
		$join=" left join hos_patientclasses on hos_patients.patientclasseid=hos_patientclasses.id  left join sys_genders on hos_patients.genderid=sys_genders.id  left join hos_civilstatuss on hos_patients.civilstatusid=hos_civilstatuss.id ";
		$having="";
		$where= " $rptwhere";
		$groupby= " $rptgroup";
		$orderby="";
		$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patients->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->shpatientno==1  or empty($obj->action)){ ?>
				<td><?php echo $row->patientno; ?></td>
			<?php } ?>
			<?php if($obj->shsurname==1  or empty($obj->action)){ ?>
				<td><?php echo $row->surname; ?></td>
			<?php } ?>
			<?php if($obj->shothernames==1  or empty($obj->action)){ ?>
				<td><?php echo $row->othernames; ?></td>
			<?php } ?>
			<?php if($obj->shaddress==1  or empty($obj->action)){ ?>
				<td><?php echo $row->address; ?></td>
			<?php } ?>
			<?php if($obj->shmobile==1 ){ ?>
				<td><?php echo $row->mobile; ?></td>
			<?php } ?>
			<?php if($obj->shgenderid==1  or empty($obj->action)){ ?>
				<td><?php echo $row->genderid; ?></td>
			<?php } ?>
			<?php if($obj->shdob==1  or empty($obj->action)){ ?>
				<td><?php echo $row->dob; ?></td>
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
