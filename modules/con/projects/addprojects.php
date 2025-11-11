<title>WiseDigits: Projects </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
	}
  });

  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
	}
  });


  $("#projectquantitiesitemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectquantitiesitemid").val(ui.item.id);
	}
  });


  $("#projectusageitemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectusageitemid").val(ui.item.id);
	}
  });

	 
  $("#projectreviewsemployeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectreviewsemployeeid").val(ui.item.id);
	}
  });

  $("#projectsubcontractorssuppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name&where)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectsubcontractorssupplierid").val(ui.item.id);
	}
  });

});
</script>
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

 function getEquipment(){
  var xmlhttp;
	var equipmentid=document.getElementById("equipmentid").value;
	var type=document.getElementById("type").value;
	var url="../projectequipments/get.php?equipmentid="+equipmentid+"&type="+type;
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
			var dt = xmlhttp.responseText;
			//explode the string
			document.getElementById("rate").value=dt;
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
 }
 
 function getWorkSchedule(){
  var xmlhttp;
	var id=document.getElementById("projectworkscheduleid").value;
	var url="../projectworkschedules/get.php?id="+id;
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
			var dt = xmlhttp.responseText;
			//explode the string
			var data = dt.split("|");
			document.getElementById("projectweek").value=data[0];
			document.getElementById("week").value=data[1];
			document.getElementById("year").value=data[2];
		}
	};
	
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
 }
 </script>
<div class="container" style="margin-top:;">
<div class="tabbable">

	<ul class="nav nav-tabs">
		<li><a href="#pane1" data-toggle="tab">DETAILS</a></li>
		<li><a href="#pane4" data-toggle="tab">Bill of Quantities</a></li>
		<li><a href="#pane2" data-toggle="tab">Materials Schedule</a></li>
		<li><a href="#pane6" data-toggle="tab">Labour Schedule</a></li>
		<li><a href="#pane9" data-toggle="tab">Equipment Schedule</a></li>
		<li><a href="#pane10" data-toggle="tab">Sub Contractors</a></li>
		<li><a href="#pane5" data-toggle="tab">Project Usage</a></li>
		<li><a href="#pane3" data-toggle="tab">Project Reviews</a></li>
		<li><a href="#pane7" data-toggle="tab">Work Schedule</a></li>
		<li><a href="#pane8" data-toggle="tab">Project Documents</a></li>
	</ul>
	<div class="tab-content">
    <div id="pane1" class="tab-pane">
<form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/>
		<input type="hidden" name="tenderid" id="tenderid" value="<?php echo $obj->tenderid; ?>"/></td>
	</tr>
	<tr>
		<td align="right">Project Name : </td>
		<td><textarea name="name" cols='40'><?php echo $obj->name; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Project Type : </td>
			<td><select name="projecttypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$projecttypes=new Projecttypes();
	$where="  ";
	$fields="con_projecttypes.id, con_projecttypes.name, con_projecttypes.remarks, con_projecttypes.ipaddress, con_projecttypes.createdby, con_projecttypes.createdon, con_projecttypes.lasteditedby, con_projecttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projecttypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projecttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Customer : </td>
			<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
			<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Manager : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Region : </td>
			<td><select name="regionid" class="selectbox">
<option value="">Select...</option>
<?php
	$regions=new Regions();
	$where="  ";
	$fields="con_regions.id, con_regions.name, con_regions.remarks, con_regions.ipaddress, con_regions.createdby, con_regions.createdon, con_regions.lasteditedby, con_regions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($regions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->regionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Sub Region : </td>
			<td><select name="subregionid" class="selectbox">
<option value="">Select...</option>
<?php
	$subregions=new Subregions();
	$where="  ";
	$fields="con_subregions.id, con_subregions.name, con_subregions.regionid, con_subregions.remarks, con_subregions.ipaddress, con_subregions.createdby, con_subregions.createdon, con_subregions.lasteditedby, con_subregions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subregions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($subregions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->subregionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Contract No : </td>
		<td><input type="text" name="contractno" id="contractno" value="<?php echo $obj->contractno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Physical Address : </td>
		<td><textarea name="physicaladdress"><?php echo $obj->physicaladdress; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Scope Of Work : </td>
		<td><textarea name="scope"><?php echo $obj->scope; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Contract Sum : </td>
		<td><input type="text" name="value" id="value" size="8"  value="<?php echo $obj->value; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Awarded : </td>
		<td><input type="text" name="dateawarded" id="dateawarded" class="date_input"size="16" readonly  value="<?php echo $obj->dateawarded; ?>"></td>
	</tr>
	<tr>
		<td align="right">Acceptance Letter Date : </td>
		<td><input type="text" name="acceptanceletterdate" id="acceptanceletterdate" class="date_input"size="16" readonly  value="<?php echo $obj->acceptanceletterdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Acceptance Letter : </td>
		<td>
		Title: <input type="text" name="acceptanceletter" value="<?php echo $obj->acceptanceletter; ?>"/>&nbsp;
		<input type="file" name="acceptanceletterfile" id="acceptanceletterfile"></td>
	</tr>
	<tr>
		<td align="right">Contract Signed On : </td>
		<td><input type="text" name="contractsignedon" id="contractsignedon" class="date_input"size="16" readonly  value="<?php echo $obj->contractsignedon; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Contract : </td>
		<td>
		Title: <input type="text" name="contract" value="<?php echo $obj->contract; ?>"/>&nbsp;
		<input type="file" name="contractfile" id="contractfile"></td>
	</tr>
	
	<tr>
		<td align="right">Date Of Order To Commence : </td>
		<td><input type="text" name="orderdatetocommence" id="orderdatetocommence" class="date_input"size="16" readonly  value="<?php echo $obj->orderdatetocommence; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Order to Commence : </td>
		<td>
		Title: <input type="text" name="ordertocommence" value="<?php echo $obj->ordertocommence; ?>"/>&nbsp;
		<input type="file" name="ordertocommencefile" id="ordertocommencefile"></td>
	</tr>
	
	<tr>
		<td align="right">Commencement Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input"size="16" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected Completion Date : </td>
		<td><input type="text" name="expectedenddate" id="expectedenddate" class="date_input"size="16" readonly  value="<?php echo $obj->expectedenddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Actual Completion Date : </td>
		<td><input type="text" name="actualenddate" id="actualenddate" class="date_input"size="16" readonly  value="<?php echo $obj->actualenddate; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Completion Certificate : </td>
		<td>
		Title: <input type="text" name="completioncert" value="<?php echo $obj->completioncert; ?>"/>&nbsp;
		<input type="file" name="completioncertfile" id="completioncertfile"></td>
	</tr>
	
	<tr>
		<td align="right">Defects Liability Period : </td>
		<td><input type="text" size="4" name="liabilityperiod" id="liabilityperiod" value="<?php echo $obj->liabilityperiod; ?>"/>&nbsp;
		<select name='liabilityperiodtype' class="selectbox">
			<option value='Weeks' <?php if($obj->liabilityperiodtype=='Weeks'){echo"selected";}?>>Weeks</option>
			<option value='Months' <?php if($obj->liabilityperiodtype=='Months'){echo"selected";}?>>Months</option>
			<option value='Years' <?php if($obj->liabilityperiodtype=='Years'){echo"selected";}?>>Years</option>
		</select>
		</td>
	</tr>
	
	<tr>
		<td align="right">End of Defects Liability Period Certificate : </td>
		<td>
		Title: <input type="text" name="liabilitycert" value="<?php echo $obj->liabilitycert; ?>"/>&nbsp;
		<input type="file" name="liabilitycertfile" id="liabilitycertfile"></td>
	</tr>
	
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
			<td><select name="statusid" class="selectbox">
<option value="">Select...</option>
<?php
	$statuss=new Statuss();
	$where="  ";
	$fields="con_statuss.id, con_statuss.name, con_statuss.remarks, con_statuss.ipaddress, con_statuss.createdby, con_statuss.createdon, con_statuss.lasteditedby, con_statuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($statuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->statusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
	</form>
<div style="clear:both;"></div>
	</div>
<?php if(!empty($obj->id)){?>

<div id="pane4" class="tab-pane">
 <table width="75%" class="table table-stripped table-codensed">
 <tr>
 	<th>#</th>
 	<th>BQ Description</th>
 	<th>Quantity</th>
 	<th>BQ Rate</th>
 	<th>Total</th>
 	<th>Remarks</th>
 	<th>&nbsp;</th>
 </tr>
 <?php
		$billofquantities=new Billofquantities();
		$i=0;
		$fields="tender_billofquantities.id, tender_tenders.name as tenderid, tender_billofquantities.bqitem, tender_billofquantities.quantity, tender_billofquantities.bqrate, tender_billofquantities.remarks, tender_billofquantities.ipaddress, tender_billofquantities.createdby, tender_billofquantities.createdon, tender_billofquantities.lasteditedby, tender_billofquantities.lasteditedon";
		$join=" left join tender_tenders on tender_billofquantities.tenderid=tender_tenders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where tender_billofquantities.tenderid='$obj->tenderid'";
		$billofquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$billofquantities->affectedRows;
		$res=$billofquantities->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->bqitem; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td align="right"><?php echo formatNumber($row->bqrate); ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><p><a href="javascript:;" onclick="showPopWin('../projectboqs/addprojectboqs_proc.php?projectid=<?php echo $obj->id; ?>&billofquantitieid=<?php echo $row->id; ?>',800,430);">Detail</a></td>
			</tr>
			<tr>
			<td colspan='6'>
			<table width='100%' style="margin-left:50px;">
		<?php
		
		//retrieve details of boq item
		$projectboqs = new Projectboqs();
		$fields="con_projectboqs.id, tender_billofquantities.bqitem as billofquantitieid, con_projectboqs.name, con_projectboqs.quantity, tender_unitofmeasures.name as unitofmeasureid, con_projectboqs.bqrate, con_projectboqs.total, con_projectboqs.remarks, con_projectboqs.ipaddress, con_projectboqs.createdby, con_projectboqs.createdon, con_projectboqs.lasteditedby, con_projectboqs.lasteditedon";
		$join=" left join tender_billofquantities on con_projectboqs.billofquantitieid=tender_billofquantities.id  left join tender_unitofmeasures on con_projectboqs.unitofmeasureid=tender_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projectboqs.billofquantitieid='$row->id' ";
		$projectboqs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$rs=$projectboqs->result;
		$j=0;
		while($rw=mysql_fetch_object($rs)){
		$j++;
	?>
		<tr>
			<td><?php echo $j; ?></td>
			<td><?php echo $rw->name; ?></td>
			<td><?php echo formatNumber($rw->quantity); ?></td>
			<td><?php echo $rw->unitofmeasureid; ?></td>
			<td align="right"><?php echo formatNumber($rw->bqrate); ?></td>
			<td align="right"><?php echo formatNumber($rw->total); ?></td>
			<td><?php echo $rw->remarks; ?></td>
			<td>
			<?php
			$projectboqdetails = new Projectboqdetails();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where con_projectboqdetails.projectboqid='$rw->id' ";
			$projectboqdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			if($projectboqdetails->affectedRows<=0){
			?>
			<a href="javascript:;" onclick="showPopWin('../projectboqdetails/addprojectboqdetails_proc.php?projectboqid=<?php echo $rw->id; ?>&projectid=<?php echo $obj->id; ?>',800,430);">Quantify</a>
			<?php
			}
			?>
			</td>
			<td>
			<?php
			$projectworkschedules = new Projectworkschedules();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where con_projectworkschedules.projectboqid='$rw->id' ";
			$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			if($projectworkschedules->affectedRows<=0){
			?>
			<a href="javascript:;" onclick="showPopWin('../projectworkschedules/addprojectworkschedules_proc.php?projectboqid=<?php echo $rw->id; ?>',800,630);">Schedule</a></td>
			<?php
			}
			?>
		</tr>
		<?
		}
		?>
		</td>
		</tr>
		</table>
		<?
		}
?>
 </table>
<div style="clear:both;"></div>
</div>

<div id="pane5" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
 	<table>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
		<tr>
				<td>&nbsp;</td>
				<td valign="bottom">Material :<input type='text' size='20' name='projectusageitemname' id='projectusageitemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='projectusageitemid' id='projectusageitemid' value='<?php echo $obj->field; ?>'></td>
				<td valign="bottom">Quantity : <input type="text" name="projectusagequantity" size="4" ></td>
				<td valign="bottom">Used On : <input type="text" name="projectusageusedon" size="12" readonly="readonly" class="date_input"></td>
				<td valign="bottom">Remarks : <textarea name="projectusageremarks"><?php echo $obj->projectusageremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Projectusag" name="action"></td>
			</tr>
<?php
		$projectusage=new Projectusage();
		$i=0;
		$fields="con_projectusage.id, con_projects.name as projectid, inv_items.name as itemid, con_projectusage.quantity, con_projectusage.usedon, con_projectusage.remarks, con_projectusage.ipaddress, con_projectusage.createdby, con_projectusage.createdon, con_projectusage.lasteditedby, con_projectusage.lasteditedon";
		$join=" left join con_projects on con_projectusage.projectid=con_projects.id  left join inv_items on con_projectusage.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projectusage.projectid='$obj->id'";
		$projectusage->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$projectusage->affectedRows;
		$res=$projectusage->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->itemid; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->usedon; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectusage=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
 </form>
<div style="clear:both;"></div>
</div>


 <div id="pane2" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table class="table table-codensed table-stripped">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Material</th>
	    <th>Category</th>
	    <th>Sub - Category</th>
	    <th>Quantity</th>
	    <th>Rate</th>
	    <th>Remarks</th>
	    <th>Required</th>
	    <th>&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
<?php
		$projectquantities=new Projectquantities();
		$i=0;
		$fields="con_projectquantities.id, con_projects.name as projectid, inv_items.name as itemid, con_labours.name as labourid, con_materialcategorys.name as categoryid, con_materialsubcategorys.name as subcategoryid, con_projectquantities.quantity, con_projectquantities.rate, con_projectquantities.remarks, con_projectquantities.projectweek, con_projectquantities.week, con_projectquantities.year, con_projectquantities.ipaddress, con_projectquantities.createdby, con_projectquantities.createdon, con_projectquantities.lasteditedby, con_projectquantities.lasteditedon";
		$join=" left join con_projects on con_projectquantities.projectid=con_projects.id  left join con_projectboqdetails on con_projectquantities.projectboqdetailid=con_projectboqdetails.id  left join inv_items on con_projectquantities.itemid=inv_items.id  left join con_labours on con_projectquantities.labourid=con_labours.id  left join con_materialcategorys on con_projectquantities.categoryid=con_materialcategorys.id  left join con_materialsubcategorys on con_projectquantities.subcategoryid=con_materialsubcategorys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projectquantities.projectid='$obj->id' and con_projectquantities.itemid>0";
		$projectquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$num=$projectquantities->affectedRows;
		$res=$projectquantities->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->itemid; ?></td>
				<td><?php echo $row->categoryid; ?></td>
				<td><?php echo $row->subcategoryid; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->rate; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->projectweek; ?>&nbsp;-&nbsp;<?php echo $row->week; ?><?php echo $row->year; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectquantities=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
	</tbody>
	</table>
	</form>
<div style="clear:both;"></div>
</div>

<div id="pane6" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table class="table table-codensed table-stripped">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Labour</th>
	    <th>Category</th>
	    <th>Sub - Category</th>
	    <th>Quantity</th>
	    <th>Rate</th>
	    <th>Remarks</th>
	    <th>Required</th>
	    <th>&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
<?php
		$projectquantities=new Projectquantities();
		$i=0;
		$fields="con_projectquantities.id, con_projects.name as projectid, inv_items.name as itemid, con_labours.name as labourid, con_materialcategorys.name as categoryid, con_materialsubcategorys.name as subcategoryid, con_projectquantities.quantity, con_projectquantities.rate, con_projectquantities.remarks, con_projectquantities.projectweek, con_projectquantities.week, con_projectquantities.year, con_projectquantities.ipaddress, con_projectquantities.createdby, con_projectquantities.createdon, con_projectquantities.lasteditedby, con_projectquantities.lasteditedon";
		$join=" left join con_projects on con_projectquantities.projectid=con_projects.id  left join con_projectboqdetails on con_projectquantities.projectboqdetailid=con_projectboqdetails.id  left join inv_items on con_projectquantities.itemid=inv_items.id  left join con_labours on con_projectquantities.labourid=con_labours.id  left join con_materialcategorys on con_projectquantities.categoryid=con_materialcategorys.id  left join con_materialsubcategorys on con_projectquantities.subcategoryid=con_materialsubcategorys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projectquantities.projectid='$obj->id' and con_projectquantities.labourid>0";
		$projectquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$num=$projectquantities->affectedRows;
		$res=$projectquantities->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->labourid; ?></td>
				<td><?php echo $row->categoryid; ?></td>
				<td><?php echo $row->subcategoryid; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->rate; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->projectweek; ?>&nbsp;-&nbsp;<?php echo $row->week; ?><?php echo $row->year; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectquantities=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
	</tbody>
	</table>
	</form>
<div style="clear:both;"></div>
</div>

 <div id="pane3" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
		<tr>
				<td>&nbsp;</td>
				<td valign="bottom">Review Done By :<input type='text' size='20' name='projectreviewsemployeename' id='projectreviewsemployeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='projectreviewsemployeeid' id='projectreviewsemployeeid' value='<?php echo $obj->field; ?>'></td>
				<td valign="bottom">Findings : <textarea name="projectreviewsfindings"><?php echo $obj->projectreviewsfindings; ?></textarea></td>
				<td valign="bottom">Recommendations : <textarea name="projectreviewsrecommendations"><?php echo $obj->projectreviewsrecommendations; ?></textarea></td>
				<td valign="bottom">Review Date : <input type="text" name="projectreviewsreviewedon" size="8" class="date_input"></td>
				<td valign="bottom">Remarks : <textarea name="projectreviewsremarks"><?php echo $obj->projectreviewsremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Projectreview" name="action"></td>
			</tr>
<?php
		$projectreviews=new Projectreviews();
		$i=0;
		$fields="con_projectreviews.id, con_projects.name as projectid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, con_projectreviews.findings, con_projectreviews.recommendations, con_projectreviews.reviewedon, con_projectreviews.remarks, con_projectreviews.ipaddress, con_projectreviews.createdby, con_projectreviews.createdon, con_projectreviews.lasteditedby, con_projectreviews.lasteditedon";
		$join=" left join con_projects on con_projectreviews.projectid=con_projects.id  left join hrm_employees on con_projectreviews.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projectreviews.projectid='$obj->id'";
		$projectreviews->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$projectreviews->affectedRows;
		$res=$projectreviews->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->employeeid; ?></td>
				<td><?php echo $row->findings; ?></td>
				<td><?php echo $row->recommendations; ?></td>
				<td><?php echo $row->reviewedon; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectreviews=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
	</form>
	<div style="clear:both;"></div>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>


</div>

<div id="pane7" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
		<td align="right">Task Name : </td>
		<td><input type="text" name="taskname" id="taskname" size="45"  value="<?php echo $obj->taskname; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Task Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea></td>
	</tr>
	<tr>
		<td align="right"> </td>
		<td><input type="hidden" name='projecttype' value="Project"/></td>
	</tr>
	<tr>
		<td align="right">Responsible Person : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Priority : </td>
		<td><input type="radio" name="priority" value="Low" <?php if($obj->priority=='Low'){echo"checked";}?>/> Low
		     <input type="radio" name="priority" value="Normal" <?php if($obj->priority=='Normal'){echo"checked";}?>/> Normal
		     <input type="radio" name="priority" value="High" <?php if($obj->priority=='High'){echo"checked";}?>/> High
		</td>
	</tr>
	<tr>
		<td align="right">Track Time Spent : </td>
		<td>
		  <input type="radio" name="tracktime" value="Yes" <?php if($obj->tracktime=='Yes'){echo"checked";}?>/> Yes
		  <input type="radio" name="tracktime" value="No" <?php if($obj->tracktime=='No'){echo"checked";}?>/> No
		</td>
	</tr>
	<tr>
		<td align="right">Required Duration : </td>
		<td><input type="text" name="reqduration" id="reqduration" value="<?php echo $obj->reqduration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Required Duration Type : </td>
		<td><select name='reqdurationtype' class="selectbox">
			<option value='minutes' <?php if($obj->reqdurationtype=='minutes'){echo"selected";}?>>minutes</option>
			<option value='hours' <?php if($obj->reqdurationtype=='hours'){echo"selected";}?>>hours</option>
			<option value='days' <?php if($obj->reqdurationtype=='days'){echo"selected";}?>>days</option>
			<option value='weeks' <?php if($obj->reqdurationtype=='weeks'){echo"selected";}?>>weeks</option>
			<option value='months' <?php if($obj->reqdurationtype=='months'){echo"selected";}?>>months</option>
			<option value='years' <?php if($obj->reqdurationtype=='years'){echo"selected";}?>>years</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Deadline : </td>
		<td><input type="text" name="deadline" id="deadline" class="date_input" size="12" readonly  value="<?php echo $obj->deadline; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Time : </td>
		<td><input type="text" name="starttime" id="starttime" value="<?php echo $obj->starttime; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Date : </td>
		<td><input type="text" name="enddate" id="enddate" class="date_input" size="12" readonly  value="<?php echo $obj->enddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Time : </td>
		<td><input type="text" name="endtime" id="endtime" value="<?php echo $obj->endtime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration : </td>
		<td><input type="text" name="duration" id="duration" value="<?php echo $obj->duration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration Type : </td>
		<td><select name='durationtype' class="selectbox">
			<option value='hours' <?php if($obj->durationtype=='hours'){echo"selected";}?>>hours</option>
			<option value='days' <?php if($obj->durationtype=='days'){echo"selected";}?>>days</option>
			<option value='weeks' <?php if($obj->durationtype=='weeks'){echo"selected";}?>>weeks</option>
			<option value='months' <?php if($obj->durationtype=='months'){echo"selected";}?>>months</option>
			<option value='years' <?php if($obj->durationtype=='years'){echo"selected";}?>>years</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remind : </td>
		<td><input type="text" name="remind" id="remind" class="date_input" size="12" readonly  value="<?php echo $obj->remind; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
			<td><select name="statusid" class="selectbox">
<option value="">Select...</option>
<?php
	$taskstatuss=new Taskstatuss();
	$where="  ";
	$fields="pm_taskstatuss.id, pm_taskstatuss.name, pm_taskstatuss.remarks, pm_taskstatuss.ipaddress, pm_taskstatuss.createdby, pm_taskstatuss.createdon, pm_taskstatuss.lasteditedby, pm_taskstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($taskstatuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->statusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
	  <td colspan="2" align="center"><input type="submit" name="action" class="btn-primary" value="Add Task"/></td>
	</tr>
		</table>
		<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>BoQ Item </th>
			<th>Person Responsible </th>
			<th>Project Week </th>
			<th>Calendar Week </th>
			<th>Year </th>
			<th>Remarks </th>
			<th>&nbsp;</th>

		</tr>
	</thead>
	<tbody>
	<?php
		$projectworkschedules = new Projectworkschedules();
		$i=0;
		$fields="con_projectworkschedules.id, con_projectboqs.name as projectboqid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, con_projectworkschedules.projectweek, con_projectworkschedules.week, con_projectworkschedules.year, con_projectworkschedules.priority, con_projectworkschedules.tracktime, con_projectworkschedules.reqduration, con_projectworkschedules.reqdurationtype, con_projectworkschedules.deadline, con_projectworkschedules.startdate, con_projectworkschedules.starttime, con_projectworkschedules.enddate, con_projectworkschedules.endtime, con_projectworkschedules.duration, con_projectworkschedules.durationtype, con_projectworkschedules.remind, con_projectworkschedules.remarks, con_projectworkschedules.ipaddress, con_projectworkschedules.createdby, con_projectworkschedules.createdon, con_projectworkschedules.lasteditedby, con_projectworkschedules.lasteditedon";
		$join=" left join con_projectboqs on con_projectworkschedules.projectboqid=con_projectboqs.id  left join hrm_employees on con_projectworkschedules.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectworkschedules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectboqid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->projectweek; ?></td>
			<td><?php echo $row->week; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('../projectequipments/addprojectequipments_proc.php?projectworkscheduleid=<?php echo $row->id; ?>',800,430);">Equipment</a></td>

		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
	</form>
	<div style="clear:both;"></div>
</div>

<div id="pane9" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
		<td align="right">Equipment : </td>
			<td><select name="equipmentid" id="equipmentid" class="selectbox" onchange="getEquipment();">
<option value="">Select...</option>
<?php
	$equipments=new Equipments();
	$where="  ";
	$fields="con_equipments.id, con_equipments.name, con_equipments.hirecost, con_equipments.purchasecost, con_equipments.remarks, con_equipments.ipaddress, con_equipments.createdby, con_equipments.createdon, con_equipments.lasteditedby, con_equipments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$equipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($equipments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->equipmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	
	<tr>
		<td align="right">Equipment Type : </td>
		<td><select name='type' id='type' class="selectbox" onchange="getEquipment();">
			<option value='Hired' <?php if($obj->type=='Hired'){echo"selected";}?>>Hired</option>
			<option value='Purchased' <?php if($obj->type=='Purchased'){echo"selected";}?>>Purchased</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Rate : </td>
		<td><input type="text" name="rate" id="rate" size="8"  value="<?php echo $obj->rate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Work Schedule : </td>
			<td><select name="projectworkscheduleid" id="projectworkscheduleid" class="selectbox" onChange="getWorkSchedule();">
<option value="">Select...</option>
<?php
	$projectworkschedules=new Projectworkschedules();
	$where="  ";
	$fields="con_projectworkschedules.id, con_projectworkschedules.projectboqid, con_projectworkschedules.employeeid, con_projectworkschedules.projectweek, con_projectworkschedules.week, con_projectworkschedules.year, con_projectworkschedules.priority, con_projectworkschedules.tracktime, con_projectworkschedules.reqduration, con_projectworkschedules.reqdurationtype, con_projectworkschedules.deadline, con_projectworkschedules.startdate, con_projectworkschedules.starttime, con_projectworkschedules.enddate, con_projectworkschedules.endtime, con_projectworkschedules.duration, con_projectworkschedules.durationtype, con_projectworkschedules.remind, con_projectworkschedules.remarks, con_projectworkschedules.ipaddress, con_projectworkschedules.createdby, con_projectworkschedules.createdon, con_projectworkschedules.lasteditedby, con_projectworkschedules.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projectworkschedules->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectworkscheduleid==$rw->id){echo "selected";}?>><?php echo "WK ".$rw->projectweek;?> of <?php echo "WK ".$rw->week;?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Project Week : </td>
		<td>WK<input type="text" readonly size="4" name="projectweek" id="projectweek" value="<?php echo $obj->projectweek; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Calendar Week : </td>
		<td>WK<input type="text" readonly size="4" name="week" id="week" value="<?php echo $obj->week; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Month : </td>
		<td><input type="text" name="month" id="month" value="<?php echo $obj->month; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" readonly size="8" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
	  <td colspan="2" align="center"><input type="submit" name="action" class="btn-primary" value="Add Equip Schedule"/></td>
	</tr>
		</table>
	</form>
	<div style="clear:both;"></div>
</div>

<div id="pane10" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table>
			<tr>
				<td ><input type="text" name="projectid" value="<?php echo $obj->projectid; ?>"/>Sub Contractor :</td><td><input type='text' size='32' name='projectsubcontractorssuppliername' id='projectsubcontractorssuppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='projectsubcontractorssupplierid' id='projectsubcontractorssupplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td >Liability Period :</td><td> <input type="text" name="projectsubcontractorsliabilityperiod" size="4" ></td>
			</tr>
			<tr>
				<td >Liability Period Type :</td><td><select name='liabilityperiodtype' class="selectbox">
					<option value='Weeks' <?php if($obj->liabilityperiodtype=='Weeks'){echo"selected";}?>>Weeks</option>
					<option value='Months' <?php if($obj->liabilityperiodtype=='Months'){echo"selected";}?>>Months</option>
					<option value='Years' <?php if($obj->liabilityperiodtype=='Years'){echo"selected";}?>>Years</option>
					</select>
			</tr>
			<tr>
				<td >Actual End Date :</td><td> <input type="text" name="projectsubcontractorsactualenddate" size="10" class="date_input"></td>
			</tr>
			<tr>
				<td >Expected End Date :</td><td> <input type="text" name="projectsubcontractorsexpectedenddate" size="10" class="date_input"></td>
			</tr>
			<tr>
				<td >Start Date :</td><td> <input type="text" name="projectsubcontractorsstartdate" size="10" class="date_input"></td>
			</tr>
			<tr>
				<td >Date Of Order To Commence : </td><td><input type="text" name="projectsubcontractorsorderdatetocommence" size="10" class="date_input"></td>
			</tr>
			<tr>
				<td >Contract Signed On : </td><td><input type="text" name="projectsubcontractorscontractsignedon" size="10" class="date_input"></td>
			</tr>
			<tr>
				<td >Acceptance Letter Date :</td><td> <input type="text" name="projectsubcontractorsacceptanceletterdate" size="10" class="date_input"></td>
			</tr>
			<tr>
				<td >Date Awarded :</td><td> <input type="text" name="projectsubcontractorsdateawarded" size="8" class="date_input"></td>
			</tr>
			<tr>
				<td >Contract Value :</td><td> <input type="text" name="projectsubcontractorsvalue" size="5" ></td>
			</tr>
			<tr>
				<td >Contract Scope :</td><td> <textarea name="projectsubcontractorsscope"><?php echo $obj->projectsubcontractorsscope; ?></textarea></td>
			</tr>
			<tr>
				<td >Physical Address :</td><td> <textarea name="projectsubcontractorsphysicaladdress"><?php echo $obj->projectsubcontractorsphysicaladdress; ?></textarea></td>
			</tr>
			<tr>
				<td >Contract No :</td><td> <input type="text" name="projectsubcontractorscontractno" size="12" ></td>
			</tr>
			<tr>
				<td >Remarks :</td><td> <textarea name="projectsubcontractorsremarks"><?php echo $obj->projectsubcontractorsremarks; ?></textarea></td>
			</tr>
			<tr>
				<td  colspan='2'><input type="submit" value="Add Projectsubcontractor" name="action"></td>
			</tr>
		</table>
		<table class="table table-codensed table-stripped">
			<tr>
				<th>&nbsp;</th>
				<th >Sub Contractor</th>
				<th >Liability Period</th>
				<th >Liability Period Type<th>
				<th >Actual End Date</th>
				<th >Expected End Date</th>
				<th >Start Date</th>
				<th >Date Of Order To Commence</th>
				<th >Contract Signed On</th>
				<th >Acceptance Letter Date</th>
				<th >Date Awarded</th>
				<th >Contract Value</th>
				<th >Contract Scope</th>
				<th >Physical Address</th>
				<th >Contract No</th>
				<th >Remarks</th>
				<th >&nbsp;</th>
			</tr>
<?php
		$projectsubcontractors=new Projectsubcontractors();
		$i=0;
		$fields="con_projectsubcontractors.id, proc_suppliers.name as supplierid, con_projects.name as projectid, con_projectsubcontractors.contractno, con_projectsubcontractors.physicaladdress, con_projectsubcontractors.scope, con_projectsubcontractors.value, con_projectsubcontractors.dateawarded, con_projectsubcontractors.acceptanceletterdate, con_projectsubcontractors.contractsignedon, con_projectsubcontractors.orderdatetocommence, con_projectsubcontractors.startdate, con_projectsubcontractors.expectedenddate, con_projectsubcontractors.actualenddate, con_projectsubcontractors.liabilityperiodtype, con_projectsubcontractors.liabilityperiod, con_projectsubcontractors.remarks, con_projectsubcontractors.statusid, con_projectsubcontractors.ipaddress, con_projectsubcontractors.createdby, con_projectsubcontractors.createdon, con_projectsubcontractors.lasteditedby, con_projectsubcontractors.lasteditedon";
		$join=" left join proc_suppliers on con_projectsubcontractors.supplierid=proc_suppliers.id  left join con_projects on con_projectsubcontractors.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projectsubcontractors.projectid='$obj->id'";
		$projectsubcontractors->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$projectsubcontractors->affectedRows;
		$res=$projectsubcontractors->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->supplierid; ?></td>
				<td><?php echo $row->liabilityperiod; ?></td>
				<td><?php echo $row->liabilityperiodtype; ?></td>
				<td><?php echo $row->actualenddate; ?></td>
				<td><?php echo $row->expectedenddate; ?></td>
				<td><?php echo $row->startdate; ?></td>
				<td><?php echo $row->orderdatetocommence; ?></td>
				<td><?php echo $row->contractsignedon; ?></td>
				<td><?php echo $row->acceptanceletterdate; ?></td>
				<td><?php echo $row->dateawarded; ?></td>
				<td><?php echo $row->value; ?></td>
				<td><?php echo $row->scope; ?></td>
				<td><?php echo $row->physicaladdress; ?></td>
				<td><?php echo $row->contractno; ?></td>
				<td><?php echo $row->projectid; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectsubcontractors=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
	</form>
	<div style="clear:both;"></div>
</div>

<div id="pane8" class="tab-pane">
 <form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table align='left'>
			<tr>
				<td>&nbsp;</td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/>
					<input type="hidden" name='projectdocumentsprojectid' id='projectdocumentsprojectid' value='<?php echo $obj->field; ?>'></td>
				<td valign="bottom">Document Type : <select name='projectdocumentsdocumenttypeid' classs="selectbox">
				<option value="">Select...</option>
				<?php
				$documenttypes=new Documenttypes();
				$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($documenttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->documenttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">File : <input type="file" name="projectdocumentsfile" size="20" ></td>
				<td valign="bottom">Remarks : <textarea name="projectdocumentsremarks"><?php echo $obj->projectdocumentsremarks; ?></textarea></td>
				<td valign="bottom">Document Date : <input type="text" name="projectdocumentsdocumentdate" size="12" class="date_input"></td>
				<td valign="bottom"><input type="submit" value="Add Projectdocument" name="action"></td>
			</tr>
<?php
		$projectdocuments=new Projectdocuments();
		$i=0;
		$fields="con_projectdocuments.id, con_projects.name as projectid, dms_documenttypes.name as documenttypeid, con_projectdocuments.file, con_projectdocuments.remarks, con_projectdocuments.documentdate, con_projectdocuments.ipaddress, con_projectdocuments.createdby, con_projectdocuments.createdon, con_projectdocuments.lasteditedby, con_projectdocuments.lasteditedon";
		$join=" left join con_projects on con_projectdocuments.projectid=con_projects.id  left join dms_documenttypes on con_projectdocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projectdocuments.projectid='$obj->id'";
		$projectdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$projectdocuments->affectedRows;
		$res=$projectdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->projectid; ?></td>
				<td><?php echo $row->documenttypeid; ?></td>
				<td><?php echo $row->file; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->documentdate; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectdocuments=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
	</form>
	<div style="clear:both;"></div>
</div>

</div>
<?php 
if(!empty($error)){
	showError($error);
}
?>