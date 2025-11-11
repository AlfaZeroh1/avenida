<?php 
include "../../../head.php";
require_once("../patientappointments/Patientappointments_class.php");
require_once("../patienttreatments/Patienttreatments_class.php");
require_once("../patientlaboratorytests/Patientlaboratorytests_class.php");
require_once("../patientprescriptions/Patientprescriptions_class.php");
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once("../laboratorytests/Laboratorytests_class.php");
require_once '../patientvitalsigns/Patientvitalsigns_class.php';
require_once '../../hos/patientclasses/Patientclasses_class.php';
require_once '../../hos/admissions/Admissions_class.php';
require_once '../../hos/observations/Observations_class.php';
require_once("../../hos/laboratorytestdetails/Laboratorytestdetails_class.php");




$appointmentid=$_GET['appointmentid'];
$treatmentid=$_GET['treatmentid'];

$pid=$_GET["pid"];

//$ob = (object)$_POST;

if(!empty($treatmentid)){
	$_GET['id']=$treatmentid;
	$patienttreatments = new Patienttreatments();
	$fields=" * ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$treatmentid' ";
	$patienttreatments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$treat=$patienttreatments->fetchObject;
	$where="";
	$appointmentid=$treat->patientappointmentid;
}
	
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields=" * ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where fn_generaljournalaccounts.refid='$obj->patientid' and fn_generaljournalaccounts.acctypeid=31 ";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo mysql_error();
	$gna=$generaljournalaccounts->fetchObject;
		
	$generaljournalaccounts2 = new Generaljournalaccounts();
	$fields=" * ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where fn_generaljournalaccounts.refid=1 and fn_generaljournalaccounts.acctypeid=11 ";
	$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$gnas=$generaljournalaccounts2->fetchObject;
	
	if($obj->action=="Add Test"){
	
		
			$patientlaboratorytests=new Patientlaboratorytests();
			$patientlaboratorytests->createdby=$_SESSION['userid'];
			$patientlaboratorytests->createdon=date("Y-m-d H:i:s");
			$patientlaboratorytests->lasteditedby=$_SESSION['userid'];
			$patientlaboratorytests->lasteditedon=date("Y-m-d H:i:s");
			$patientlaboratorytests->treatmentid=$obj->treatmentid;
			$patientlaboratorytests->patientid=$obj->patientid;
			$patientlaboratorytests->laboratorytestid=$obj->laboratorytestid;
			$patientlaboratorytests->consult=1;
			//$patientlaboratorytests=setObject($obj);
			if($patientlaboratorytests->add($patientlaboratorytests)){
				$error=SUCCESS;
				//make journal entries
				
			}
			else{
				$error=FAILURE;
			}
			redirect("addpatienttreatments_proc.php?treatmentid=".$obj->treatmentid);
		
	}
	
	$patientapp=new Patientappointments();
	$fields="hos_patientappointments.id, hos_patientappointments.departmentid, hos_patientappointments.bookedon, concat(hos_patients.surname,' ', hos_patients.othernames) as name, hos_patients.patientno,hos_patients.dob,  hos_patientappointments.payconsultancy, hos_patientappointments.patientid as patientid, hos_patientappointments.appointmentdate, hos_patientappointments.remarks, hos_patientappointments.createdby, hos_patientappointments.createdon, hos_patientappointments.lasteditedby, hos_patientappointments.lasteditedon";
	$join=" left join hos_patients on hos_patientappointments.patientid=hos_patients.id ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hos_patientappointments.id='$appointmentid'";
	$patientapp->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	$ob=$patientapp->fetchObject;
	$obj->name=$ob->name;
	$obj->patientid=$ob->patientid;
	$obj->patientno=$ob->patientno;	
	$obj->payconsultancy=$ob->payconsultancy;
	$obj->departmentid=$ob->departmentid;
	$obj->bookedon=$ob->bookedon;

	$where="";
	$obs=$obj;
	$obj->patientappointmentid=$ob->id;
	$obj->patientstatusid=1;
	$obs->status=3;
	$obs=$ob;
	
	$patienttreatments = new Patienttreatments();
	$fields=" max(id) id";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patienttreatments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$treat=$patienttreatments->fetchObject;
	if(empty($treatmentid))
		$obj->treatmentid=$treat->id+1;
	else
		$obj->treatmentid=$treatmentid;
	
	
	$ob=$obj;
	$ob->id='';
	$obs->id=$appointmentid;
	$obj->treatedon=date("Y-m-d");
	$obj->payconsultancy;
	if(!empty($_GET['appointmentid'])){
		$obj->createdby=$_SESSION['userid'];
		$obj->createdon=date("Y-m-d H:i:s");
		$obj->lasteditedby=$_SESSION['userid'];
		$obj->lasteditedon=date("Y-m-d H:i:s");
		$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
		
		$patienttreatments = $patienttreatments->setObject($obj);
		$patienttreatments->add($patienttreatments);
		$obs->status=3;
		$patientapp->edit($obs);	
		
	}


$patientappointments=new Patientappointments();
?>

<title>WiseDigits: Patienttreatments</title>
<style type="text/css">
table{width:100%;}
</style>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	
 	$('#waitinglist').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"sScrollY": 150,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	} );
} );

function getWaitings()
{	
	var xmlhttp;
	var url="get.php?type=1&maxid="+$("#maxid").val();
	xmlhttp=new XMLHttpRequest();
	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var data = xmlhttp.responseText; // alert(data);
			var dt = data.split("-");
			$("#waiting").text(dt[0]);
			if(dt[0]>0){
			  $("#aap").text(dt[0]+" New Patient(s) in waiting list!");
			  if($("#maxid").val()<dt[1])
			    Notify("Waiting List",dt[2]+" added to waiting list!");
			  $("#aap").attr("class","show");
			  $("#maxid").val(dt[1]);
			}
			else{			  
			  $("#aap").attr("class","hide");
			}
		}
	};
      
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
} 

var t=setInterval(getWaitings,1000);

    // Determine the correct object to use
    var notification = window.Notification || window.mozNotification || window.webkitNotification;

    // The user needs to allow this
    if ('undefined' === typeof notification)
        alert('Web notification not supported');
    else
        notification.requestPermission(function(permission){});

    // A function handler
    function Notify(titleText, bodyText)
    {
        if ('undefined' === typeof notification)
            return false;       //Not supported....
        var noty = new notification(
            titleText, {
                body: bodyText,
                dir: 'auto', // or ltr, rtl
                lang: 'EN', //lang used within the notification.
                tag: 'notificationPopup', //An element ID to get/set the content
                icon: '' //The URL of an image to be used as an icon
            }
        );
        noty.onclick = function () {
            console.log('notification.Click');
        };
        noty.onerror = function () {
            console.log('notification.Error');
        };
        noty.onshow = function () {
            console.log('notification.Show');
        };
        noty.onclose = function () {
            console.log('notification.Close');
        };
        return true;
    }
    
    
</script>



<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
		
 	$('#treatmentlist').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"sScrollY": 150,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	} );
} );
</script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	
 	$('#prescriptions').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"sScrollY": 200,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	} );
} );
</script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
		
 	$('#payments').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"sScrollY": 200,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	} );
} );

$().ready(function() {
	function findValueCallback(event, data, formatted) {
		$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
	}
	function formatItem(row) {
		return row[0] + " (<strong>id: " + row[1] + "</strong>)";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
  $("#laboratorytestslaboratorytestname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=laboratorytests&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#laboratorytestslaboratorytestid").val(ui.item.id);
		$("#laboratorytestscharge").val(ui.item.laboratorytestscharge);
	}
  });

  $("#otherservicesotherservicename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=otherservices&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#otherservicesotherserviceid").val(ui.item.id);
		$("#otherservicescharge").val(ui.item.otherservicescharge);
	}
  });

	 
	 
  $("#patientdiagnosisname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=diagnosis&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientdiagnosisdiagnosiid").val(ui.item.id);
	}
  });

	 
	 
  $("#itemname").autocomplete({
	source:"../../server/server/search.php?main=inv&module=items&field=name&where=inv_items.departmentid=1",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemsitemid").val(ui.item.id);
		$("#costprice").val(ui.item.costprice);
		$("#tradeprice").val(ui.item.tradeprice);
		$("#itemsquantity").val(ui.item.itemsquantity);
		$("#available").val(ui.item.available);
		$("#itemsprice").val(ui.item.itemsprice);
	}
  });

});

function checkQuantity(){
  var available = parseFloat(document.getElementById("available").value);
  var quantity = parseFloat(document.getElementById("itemsquantity").value);
  
  
  
  if(available<quantity)
  {
	  alert("There are only "+available+" in stock of "+document.getElementById('itemname').value);	
	  document.getElementById("itemsquantity").value=0;
  }
}
</script>

<script type="text/javascript">
 function clickHereToPrint(){
		poptastic("printinvoice.php?documentno=<?php echo $obj->treatmentid;?>&observation=<?php echo $obj->observation;?>&symptoms=<?php echo $obj->symptoms; ?>&hpi=<?php echo $obj->hpi;?>&obs=<?php echo $obj->obs;?>&findings=<?php echo $obj->findings;?>&history=<?php echo $obj->history;?>&diagnosis=<?php echo $obj->diagnosis;?>&laboratory=<?php echo $obj->laboratory;?>&other=<?php echo $obj->other;?>&prescription=<?php echo $obj->prescription;?>&payments=<?php echo $obj->payments;?>",700,1020);
 }
 
//  setTimeout(function(){
//     document.getElementById('aap').className = 'waa';
// }, 1000);
		</script>
<style type="text/css">	
.input{
  min-width:100px;
}

p.show {
    opacity:1;
    transition:opacity 500ms;
    background:red;
    width:20%;
    font-weight:bold;
    font-size:14px;
}
p.hide {
    opacity:0;
}
</style>
<!-- <a class="button icon chat"  onclick="showPopWin('addpatientappointments_proc.php',600,430);">Add Patientappointments</a> -->
<!--<div style="float:left;" class="buttons">

<a class="button icon chat"  onclick="showPopWin('addpatientappointments_proc.php',600,430);">Add Patientappointments</a></div>-->
<div id="tabs">
<p id="aap">OHAI!</p>

<form action="addpatienttreatments_proc.php" class="forms" name="patientlaboratorytests" method="POST">
<input type="hidden" name="action3" value="<?php echo $obj->action3; ?>"/>
	<ul>
		<?php if($obj->action3!="Prescribe"){?>
		<li><a href="#tabs-1">Waiting List<font color="red"><div id="waiting" style="float:left;"></div></font></a></li>
		<li><a href="#tabs-2">Treatment List(<font color="red">0</font>)</a></li>
		<li><a href="#tabs-12">Laboratory List(<font color="red">0</font>)</a></li>
		<li><a href="#tabs-3">Treatment</a></li>
		<li><a href="#tabs-13">Patient Observation</a></li>
		<li><a href="#tabs-8">Patient History</a></li>
		<li><a href="#tabs-4">Patient Lab tests</a></li>
		<li><a href="#tabs-5">Other Services</a></li>
<!-- 		<li><a href="#tabs-14"> Diasnosis</a></li> -->
		<?php }?>
		<li><a href="#tabs-6">Prescriptions</a></li>
		<?php if($obj->action3!="Prescribe"){?>
		<li><a href="#tabs-7">Payments to be Done</a></li>
		<?php if($obj->admission=="Yes"){?>
		<li><a href="#tabs-9">Admission</a></li>
		<li><a href="#tabs-10">Observations</a></li>
		<li><a href="#tabs-11">Meals</a></li>
		<?php }?>
		<?php }?>
	</ul>
<?php if($obj->action3!="Prescribe"){?>
	<div id="tabs-1" style="min-height:420px;">
            <table>
                <tr>
                    <td align="right">Current Patient: </td>
                    <td><font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font></td>
                </tr>
            </table>
			<table style="clear:both;"  class="tgrid display" id="waitinglist" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#<input type="text" name="maxid" id="maxid"/></th>
			<th>Patient Name</th>
			<th>Appointment Date</th>
			<th>Remarks</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$date=date("Y-m-d");
		$i=0;
		$fields="hos_patientappointments.id, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patients.patientno, hos_patientappointments.appointmentdate, hos_patientappointments.remarks, hos_patientappointments.createdby, hos_patientappointments.createdon, hos_patientappointments.lasteditedby, hos_patientappointments.lasteditedon";
		$join=" left join hos_patients on hos_patientappointments.patientid=hos_patients.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($obj->patientstatusid))
			$where=" where hos_patientappointments.status=2  and  hos_patientappointments.appointmentdate='$date'  ";
		else
			$where=" where  hos_patientappointments.appointmentdate='$date'  ";
		$patientappointments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientappointments->result;
		$where="";
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->patientid); ?></td>
			<td><?php echo formatDate($row->appointmentdate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../patienttreatments/addpatienttreatments_proc.php?appointmentid=<?php echo $row->id; ?>#tabs-3">Treat</a></td>
			<td><a href="javascript:;" onclick="showPopWin('../patientappointments/addpatientappointments_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
			<td><a href="../patientappointments/patientappointments.php?delid=<?php echo $row->id; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>

	<?php 
	}
	?>	
            	</tbody>
</table>
    <div style="clear:both;"></div>
</div><!-- tab1End -->

<div id="tabs-2" style="min-height:420px;">
	<table>
        <tr>
            <td align="right">Current Patient: </td>
            <td><font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font></td>
        </tr>
    </table>
<table style="clear:both;"  class="tgrid display" id="treatmentlist" border="0" cellspacing="0" cellpadding="2" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Patient Name</th>
			<th>Symptoms</th>
			<th>Diagnosis</th>
			<th>Treatedon</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$patienttreatments = new Patienttreatments();
	$date=date("Y-m-d");
		$i=0;
		$fields="hos_patienttreatments.id, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.symptoms, hos_patienttreatments.diagnosis, hos_patienttreatments.treatedon, hos_patientstatuss.name as patientstatusid, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
		$join=" left join hos_patients on hos_patienttreatments.patientid=hos_patients.id  left join hos_patientstatuss on hos_patienttreatments.patientstatusid=hos_patientstatuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where treatedon='$date'  ";
		$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patienttreatments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->patientid); ?></td>
			<td><?php echo $row->symptoms; ?></td>
			<td><?php echo $row->diagnosis; ?></td>
			<td><?php echo formatDate($row->treatedon); ?></td>
			<td><a href="../patienttreatments/addpatienttreatments_proc.php?treatmentid=<?php echo $row->id; ?>#tabs-3">View</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
	<div style="clear:both;"></div>
</div><!-- tab2End -->



<div id="tabs-12" style="min-height:420px;">
	<table>
       
    </table>
<table style="clear:both;"  class="tgrid display" id="laboratorylist" border="0" cellspacing="0" cellpadding="2" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Patient Name</th>
			<th>laboratorytests</th>
			<th>Results</th>
			<th>Labresults</th>
			<th>Testedon</th>
			<th>&nbsp;</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$patientlaboratorytests = new Patientlaboratorytests();
	$date=date("Y-m-d");
		$i=0;
		$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, hos_patientlaboratorytests.results, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patientlaboratorytests.patienttreatmentid, hos_laboratorytests.name as laboratorytestid, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
		$join=" left join hos_patients on hos_patientlaboratorytests.patientid=hos_patients.id  left join hos_laboratorytests on hos_patientlaboratorytests.laboratorytestid=hos_laboratorytests.id";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where testedon='$date' ";
		$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $patientlaboratorytests->sql;
		$res=$patientlaboratorytests->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->patientid; ?></td>
			<td><?php echo $row->laboratorytestid; ?></td>
			<td><?php echo $row->results; ?></td>
			<td><?php echo $row->labresults; ?></td>
			<td><?php echo formatDate($row->testedon); ?></td>
			<td><a href="../patienttreatments/addpatienttreatments_proc.php?treatmentid=<?php echo $row->id; ?>#tabs-3">View</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
	<div style="clear:both;"></div>
</div><!-- tab12End -->

<div id="tabs-3" style="min-height:420px;">	
	<table align="center">
		<tr>
			<td colspan="2">
			<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
			<input type="hidden" name="patientstatusid" value="<?php echo $obj->patientstatusid; ?>"/>
			<input type="hidden" name="patientid" value="<?php echo $obj->patientid; ?>"/>
			<input type="hidden" name="patientappointmentid" id="patientappointmentid" value="<?php echo $obj->patientappointmentid; ?>"></td>
		</tr>
		<tr>
			<td align="right">Treatment No: </td>
	<td><font color='red'><?php echo $obj->treatmentid; ?></font>
		<input type="hidden" name="treatmentid" value="<?php echo $obj->treatmentid; ?>"/>
			</td>
		</tr>
		<tr>
			<td align="right">Current Patient: </td>
	<td><font color='red'><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?>
			</td>
		</tr>
		<tr>
			<td align="right">Patient No: </td>
	<td><font color='red'><?php echo $obj->patientno; ?></font>
			</td>
		</tr>
		
		<tr>
			<td align="right" valign="top">Vital Signs: </td>
			<td>
			<table style="clear:both;"  class="tgrid display" id="treatmentlist" border="0" cellspacing="0" cellpadding="2" align="center">
            <thead>
				<tr>
					<th>#</th>
					<th>Vital Sign</th>
					<th>Result </th>
					<th>Remarks </th>
				</tr>
             </thead>
             	<tbody>
				<?php
				$patientvitalsigns = new Patientvitalsigns();
				$i=0;
				$fields="hos_patientvitalsigns.id, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_vitalsigns.name as vitalsignid, hos_patientvitalsigns.results, hos_patientvitalsigns.remarks";
				$join=" left join hos_patients on hos_patientvitalsigns.patientid=hos_patients.id  left join hos_vitalsigns on hos_patientvitalsigns.vitalsignid=hos_vitalsigns.id ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where hos_patientvitalsigns.patientappointmentid='$obj->patientappointmentid' ";
				$patientvitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				$res=$patientvitalsigns->result;
				while($row=mysql_fetch_object($res)){
				$i++;
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row->vitalsignid; ?></td>
					<td><?php echo $row->results; ?></td>
					<td><?php echo $row->remarks; ?></td>
		<?php
			}
		?>
        </tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td align="right">Symptoms: </td>
			<td><textarea name="symptoms"><?php echo $obj->symptoms; ?></textarea></td>
		</tr>
		<tr>
		<td align="right">HPI : </td>
		<td><textarea name="hpi"><?php echo $obj->hpi; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">OBS/Gyne/PSMH/PSMHX : </td>
		<td><textarea name="obs"><?php echo $obj->obs; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Examination Findings : </td>
		<td><textarea name="findings"><?php echo $obj->findings; ?></textarea></td>
	</tr>	
	<tr>
		<td align="right">Investigation : </td>
		<td><textarea name="investigation"><?php echo $obj->investigation; ?></textarea></td>
	</tr>
	<tr>
			<td align="right" valign="top">Diagnosis: </td>
			<td><select name="diagnosiid" class="selectbox">
<option value="">Select...</option>
<?php
	$diagnosis=new Diagnosis();
	$where="  ";
	$fields="hos_diagnosis.id, hos_diagnosis.name, hos_diagnosis.remarks, hos_diagnosis.ipaddress, hos_diagnosis.createdby, hos_diagnosis.createdon, hos_diagnosis.lasteditedby, hos_diagnosis.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by hos_diagnosis.name ";
	$diagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($diagnosis->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->diagnosiid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
	
</select></tr>
<tr>
<td align="right">Other Diagnosis: </td>
<td><br/><textarea name="diagnosis"><?php echo $obj->diagnosis; ?></textarea></td>
		</tr>
		<tr>
			<td align="right">Treatment: </td>
			<td><textarea name="treatment"><?php echo $obj->treatment; ?></textarea></td>
		</tr>
		<tr>
			<td align="right">Prescription: </td>
			<td><textarea name="prescription"><?php echo $obj->prescription; ?></textarea></td>
		</tr>
		<tr>
			<td align="right">Lab Tests: </td>
			<td><textarea name="labtests"><?php echo $obj->labtests; ?></textarea></td>
		</tr>
		<tr>
		<td align="right">Admit Patient : </td>
		<!--<td><select name='admission' class="selectbox">
			<option value='Yes' <?php if($obj->admission=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->admission=='No'){echo"selected";}?>>No</option>
		</select></td>-->

		<td>
		<input type="hidden" name="admission" value="<?php echo $obj->admission; ?>" />
		<?php if($obj->admission=="No"){?>
		<a href="?admit=1&treatmentid=<?php echo $obj->treatmentid; ?>&patientid=<?php echo $obj->patientid; ?>&status=1"><font color="red">Admit Patient</font></a>
		<?php }elseif($obj->admission=="Yes"){
		$admissions = new Admissions();
		$fields="*";
		$where=" where treatmentid='$obj->treatmentid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$admissions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$admissions = $admissions->fetchObject;
		
		if($admissions->status==0){
		?>
		<font color="green">Awaiting Bed Allocation</font>
		<?php }
		else if($admissions->status==1){
		?>
		<a href="?admit=1&treatmentid=<?php echo $obj->treatmentid; ?>&patientid=<?php echo $obj->patientid; ?>&status=2"><font color="green">Discharge Patient</font></a>
		<?php }else{?>
		<font color="">Discharged</font>
		<?php }}?>
		</td>
		
	</tr>
	<tr>
		<td align="right">TreatedOn: </td>
		<td><input type="text" name="treatedon" id="treatedon" class="date_input" size="12" readonly  value="<?php echo $obj->treatedon; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="Update">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	</table>
		<div style="clear:both;"></div>
</div><!-- tab3End -->
	
   
<div id="tabs-4" style="min-height:420px;">
<table align="center" width="50%">
	
	<tr>
		<td align="right">Current Patient: </td>
		<td><font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?></td>
	</tr>
			<tr>
				<td align="right"><input type="hidden" name="testno" value="<?php echo $obj->testno; ?>"/>Lab Test:</td><td><input type='text' size='0' name='laboratorytestslaboratorytestname' id='laboratorytestslaboratorytestname' value='<?php echo $obj->laboratorytestname; ?>'>
					<input type="hidden" name='laboratorytestslaboratorytestid' id='laboratorytestslaboratorytestid' value='<?php echo $obj->field; ?>'></td>
                </tr>
                <tr>
				<td align="right">Charge:</td><td><input type="text" name="laboratorytestscharge" id="laboratorytestscharge" size="8" ></td>
                 </tr>
                <tr>
				<td align="right">Results:</td><td><textarea name="laboratorytestslabresults"><?php echo $obj->laboratorytestslabresults; ?></textarea></td>
                      </tr>                
                <tr>
				<td colspan="2"  align="center"><input class="btn" type="submit" value="Add Laboratorytest" name="action"></td>
			</tr>
			</table>
			
			<table width="80%" class="tgrid display">
			<thead>
			<tr>
			  <th align="left" width='4%'>#</th>
			  <th align="left" width='15%'>Laboratory Test</th>
			  <th align="left">Results</th>
			  <th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
<?php
		$patientlaboratorytests=new Patientlaboratorytests();
		$i=0;
		$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, hos_patientlaboratorytests.patienttreatmentid, hos_laboratorytests.id lid, hos_laboratorytests.name as laboratorytestid, hos_patientlaboratorytests.charge, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
		$join=" left join hos_laboratorytests on hos_patientlaboratorytests.laboratorytestid=hos_laboratorytests.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_patientlaboratorytests.patienttreatmentid='$obj->treatmentid'";
		$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientlaboratorytests->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->laboratorytestid; ?></td>
				<td><?php echo $row->labresults; ?></td>
				<td><a href='addpatienttreatments_proc.php?id=<?php echo $obj->id; ?>&patientlaboratorytests=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
			
		<?php
		$obj->testno=$row->testno;
		
?><input type="hidden" name="testno" value="<?php echo $obj->testno; ?>"/>
		<?php
		
		$laboratorytestdetails=new Laboratorytestdetails();
		$fields="hos_laboratorytestdetails.id, hos_laboratorytests.name as laboratorytestid, hos_laboratorytestdetails.detail, hos_laboratorytestdetails.remarks, hos_laboratorytestdetails.ipaddress, hos_laboratorytestdetails.createdby, hos_laboratorytestdetails.createdon, hos_laboratorytestdetails.lasteditedby, hos_laboratorytestdetails.lasteditedon";
		$join=" left join hos_laboratorytests on hos_laboratorytestdetails.laboratorytestid=hos_laboratorytests.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_laboratorytestdetails.laboratorytestid='$row->lid' ";
		$laboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$rs=$laboratorytestdetails->result;
		if(mysql_affected_rows()>0){
		?>
		<tr>
		<td>&nbsp;</td>
		<td colspan='2'>
		<table>
		<?
		while($rw=mysql_fetch_object($rs)){
		
		  $patientlaboratorytestdetail = new Patientlaboratorytestdetails();
		  $fields="hos_patientlaboratorytestdetails.id, hos_laboratorytestdetails.id as laboratorytestdetailid, hos_patientlaboratorytestdetails.result, hos_patientlaboratorytestdetails.remarks, hos_patientlaboratorytestdetails.ipaddress, hos_patientlaboratorytestdetails.createdby, hos_patientlaboratorytestdetails.createdon, hos_patientlaboratorytestdetails.lasteditedby, hos_patientlaboratorytestdetails.lasteditedon";
		  $join=" left join hos_patientlaboratorytests on hos_patientlaboratorytestdetails.patientlaboratorytestid=hos_patientlaboratorytests.id  left join hos_laboratorytestdetails on hos_patientlaboratorytestdetails.laboratorytestdetailid=hos_laboratorytestdetails.id ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where hos_patientlaboratorytestdetails.patientlaboratorytestid='$row->id' and hos_patientlaboratorytestdetails.laboratorytestdetailid='$rw->id' ";
		  $patientlaboratorytestdetail->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $patientlaboratorytestdetail->sql;
		  $pat = $patientlaboratorytestdetail->fetchObject;
		  
		?>
		  <tr>
		    <td><?php echo $rw->detail; ?></td>
		    <td><?php echo $pat->result; ?></td>
		    <td><?php echo $rw->remarks; ?></td>
		  </tr>
		  <?
		}
		
		?>
		</table>
		</td>
		</tr>
		<?
		}
		}
		?>
		</tbody>
		</table>
		
	<div style="clear:both;"></div>

</div><!-- tab4End --> 





<div id="tabs-13" style="min-height:420px;">
<table align="center" width="50%">
	
	<tr>
		<td align="right">Current Patient: </td>
		<td><font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?></td>
	</tr>
			
               
			</table>
			
			<table width="80%" class="tgrid display">
			<thead>
			<tr>
			  <th>Vital Sign</th>
			  <th>Results</th>
			    <th>Remarks</th>
	</tr>
			</thead>
<?php
	$vitalsigns=new Vitalsigns();
	$where="  ";
	$fields="hos_vitalsigns.id, hos_vitalsigns.name, hos_vitalsigns.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($vitalsigns->result)){
	?>
			<tr>
			<td valign="bottom" align="right"><input type="hidden" name="vitalsign<?php echo $rw->id; ?>" value="<?php echo $_POST['vitalsign'.$rw->id];?>"/><?php echo $rw->name; ?></td>
			<td valign="bottom"><input type="text"  name="results<?php echo $rw->id; ?>" value="<?php echo $_POST['results'.$rw->id];  ?>"/></td>
			<td valign="bottom"><textarea name="remarks<?php echo $rw->id; ?>"><?php echo $_POST['remarks'.$rw->id];?></textarea></td>
		</tr>
		
		
		<tr>
		<td>&nbsp;</td>
		<td colspan='2'>
		<table>
		
		 
		</table>
		</td>
		</tr>
		<?
		
		}
		?>
		<tr>
		<td colspan="3" align="center"><input class="btn" type="submit" name="action" id="action" value="Add Patienvitasigns">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
		</tbody>
		</table>
		
	<div style="clear:both;"></div>

</div><!-- tab4End --> 
	
	
	
<div id="tabs-5" style="min-height:420px;">
		<table>
		<tr>
			<td align="right">Current Patient: </td>
			<td><font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?></td>
            		<td><input type="hidden" name="patienttreatmentid" id="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>"></td>
		</tr>

			<tr>
				<td align="right">Service :</td><td><input type='text' size='0' name='otherservicesotherservicename' id='otherservicesotherservicename' value='<?php echo $obj->otherservicename; ?>'>
					<input type="hidden" name='otherservicesotherserviceid' id='otherservicesotherserviceid' value='<?php echo $obj->field; ?>'></td>
                    		</tr>

			<tr>
				<td align="right">Charge :</td><td> <input type="text" name="otherservicescharge" id="otherservicescharge" size="8" ></td>
                		</tr>

			<tr>
				<td align="right">Remarks :</td><td> <textarea name="otherservicesremarks"><?php echo $obj->otherservicesremarks; ?></textarea></td>
                		</tr>

			<tr>
				<td colspan="3" align="center"><input class="btn" type="submit" value="Add Otherservice" name="action"></td>
			</tr>
			</table>
			<table width="80%" class="tgrid display">
			<thead>
			<tr>
			  <th align="left" width='4%'>#</th>
			  <th align="left" width='15%'>Other Service</th>
			  <th align="left">Remarks</th>
			  <th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
<?php
		$patientotherservices=new Patientotherservices();
		$i=0;
		$fields="hos_patientotherservices.id, hos_patientotherservices.patienttreatmentid, hos_otherservices.name as otherserviceid, hos_patientotherservices.charge, hos_patientotherservices.remarks, hos_patientotherservices.createdby, hos_patientotherservices.createdon, hos_patientotherservices.lasteditedby, hos_patientotherservices.lasteditedon";
		$join=" left join hos_otherservices on hos_patientotherservices.otherserviceid=hos_otherservices.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_patientotherservices.patienttreatmentid='$obj->treatmentid'";
		$patientotherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientotherservices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->otherserviceid; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addpatienttreatments_proc.php?id=<?php echo $obj->id; ?>&patientotherservices=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</tbody>
		</table>
	<div style="clear:both;"></div>
</div><!-- tab5End -->












<?php }?>
<div id="tabs-6" style="min-height:420px;">
	<table>
				<tr>
					<td colspan="9" align="center">Current Patient: 
					<font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?>
					<input type="hidden" name="treatmentid" id="treatmentid" value="<?php echo $obj->treatmentid; ?>"></td>
	</tr>
	
				<tr>
					<th>Item Description</th>
					<th>Dosage</th>
					<th>Cost Price</th>
					<th>Trade Price</th>					
					<th>Retail Price</th>
					<th>Available</th>
					<th>Quantity</th>
					<th>Frequency</th>
					<th>Duration(days)</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><input type="text" name="itemname" id="itemname" size="30" tabindex="1" <?php echo $obj->itemname; ?>/>
						<input type="hidden" name="itemsitemid" id="itemsitemid" value="<?php echo $obj->itemsitemid; ?>"/></td>
					<td><textarea name='presremarks' id='presremarks'><?php echo $obj->presremarks; ?></textarea></td>
					<td><input type="text" name="costprice" id="costprice" size="4" readonly="readonly" value="<?php echo $obj->costprice; ?>"/></td>	
					<td><input type="text" name="tradeprice" id="tradeprice" size="4" readonly="readonly" value="<?php echo $obj->tradeprice; ?>"/></td>
					<td><input type="text" name="itemsprice" id="itemsprice" size="4" tabindex="2" value="<?php echo $obj->itemsprice; ?>"/></td>
					<td><input type="text" name="available" id="available" size="4" readonly="readonly" value="<?php echo $obj->available; ?>"/></td>
					<td><input type="text" name="itemsquantity" id="itemsquantity" size="4" tabindex="3" onchange="checkQuantity();" value="<?php echo $obj->itemsquantity; ?>"/></td>
					<td><input type="text" name="frequency" id="frequency" size="4" value="<?php echo $obj->frequency; ?>"></td>
					<td><input type="text" name="duration" id="duration" size="4" value="<?php echo $obj->duration; ?>"></td>
					<td><input class="btn" type="submit" value="Add Item" name="action" tabindex="4"/></td>
					
				</tr>
				

</table>
						<table style="clear:both;"  class="tgrid display" id="prescriptions" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item</th>
			<th>Dosage</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Frequency</th>
			<th>Duration(days)</th>
			<th>Total</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$patientprescriptions = new Patientprescriptions();
		$i=0;
		$fields="hos_patientprescriptions.id, inv_items.name as itemid, hos_patientprescriptions.quantity, hos_patientprescriptions.price, hos_patientprescriptions.Totals, hos_patientprescriptions.issued,hos_patientprescriptions.duration, hos_patientprescriptions.createdby, hos_patientprescriptions.createdon, hos_patientprescriptions.lasteditedby, hos_patientprescriptions.lasteditedon, hos_patientprescriptions.frequency, hos_patientprescriptions.remarks ";
		$join=" left join inv_items on hos_patientprescriptions.itemid=inv_items.id  left join hos_patienttreatments on hos_patientprescriptions.patienttreatmentid=hos_patienttreatments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_patientprescriptions.patienttreatmentid='$obj->treatmentid'";
		$patientprescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientprescriptions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
	<?php   
					$totals=formatNumber($row->price*$row->quantity);
	?>
		
			<tr>	
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo $row->frequency; ?></td>
			<td><?php echo $row->duration; ?></td>
			<td align="right"><?php echo formatNumber($row->Totals);  ?></td>

			
			<td><?php if($row->issued==0){?><a href="addpatienttreatments_proc.php?itemid=<?php echo $row->id; ?>&treatmentid=<?php echo $obj->treatmentid; ?>#tabs-5&action3=<?php echo $obj->action3; ?>" >Issue</a><?php }?>&nbsp;</td>
			<td><a href='addpatienttreatments_proc.php?patientprescriptions=<?php echo $row->id; ?>&treatmentid=<?php echo $obj->treatmentid; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
	<div style="clear:both;"></div>
</div><!-- tab6End -->	
<?php //if($obj->action3!="Prescribe"){?>
<?php if($obj->admission=="Yes"){?>
<div id="tabs-9"  style="min-height:420px;">
<?php
$admissions = new Admissions();
$fields=" hos_departments.name departmentid, hos_wards.name wardid, hos_beds.name bedid, hos_admissions.admissiondate ";
$join=" left join hos_beds on hos_beds.id=hos_admissions.bedid left join hos_wards on hos_wards.id=hos_beds.wardid left join hos_departments on hos_departments.id=hos_wards.departmentid ";
$having="";
$groupby="";
$orderby="";
$where=" where hos_admissions.treatmentid='$obj->treatmentid' ";
$admissions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$admissions = $admissions->fetchObject;
?>
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	
	<tr>
		<td align="right">Department : </td>
			<td><?php echo initialCap($admissions->departmentid); ?></td>
	</tr>
	<tr>
		<td align="right">Ward : </td>
			<td><?php echo initialCap($admissions->wardid); ?></td>
	</tr>


	<tr>
		<td align="right">Bed : </td>
			<td><?php echo initialCap($admissions->bedid); ?></td>
	</tr>
	
	<tr>
		<td align="right">Date : </td>
		<td><?php echo formatDate($admissions->admissiondate); ?></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><?php echo $admissions->remarks; ?></td>
	</tr>
</table>
</div>
<?php } ?>
<?php if($obj->admission=="Yes"){ ?>
<div id="tabs-10"  style="min-height:420px;">
<?php
$patientvitalsigns = new Patientvitalsigns();
$fields=" hos_vitalsigns.name vitalsignid, hos_patientvitalsigns.results,hos_patientvitalsigns.remarks, hos_patientvitalsigns.observedon, hos_patientvitalsigns.observedtime ";
$join=" left join hos_vitalsigns on hos_vitalsigns.id=hos_patientvitalsigns.vitalsignid ";
$having="";
$groupby="";
$orderby="";
$where=" where hos_patientvitalsigns.patienttreatmentid='$obj->treatmentid' ";
$patientvitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);

?>
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	
	
	<tr>
		<th>Vital Sign </th>
		<th>Observed On</th>
		<th>Observation </th>
		<th>Remarks </th>
	</tr>
	<?php
	while($row=mysql_fetch_object($patientvitalsigns->result)){
	?>
	<tr>
		<td><?php echo $row->vitalsignid; ?></td>
		<td><?php echo formatDate($row->observedon); ?> <?php echo $row->observedtime; ?></td>
		<td><?php echo $row->results; ?></td>
		<td><?php echo $row->remarks; ?></td>
	</tr>
	<?php
	}
	?>
	
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</div>

<?php }?>

<div id="tabs-7" style="min-height:420px;"  style="min-height:420px;">
     <table>
		<tr>
		<td align="right">Current Patient: </td>
		<td><font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?></td>
	</tr>
    </table>
		<table style="clear:both;"  class="tgrid display" id="payments" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
		<thead>
			<tr>
				<th>#</th>
				<th>Transaction</th>
				<th>Date</th>
				<th>Amount</th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			$generaljournals = new Generaljournals();
			
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$join="";
			$where=" where fn_generaljournalaccounts.refid='$obj->patientid' and fn_generaljournalaccounts.acctypeid=31 ";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$gnas=$generaljournalaccounts->fetchObject;
			
			$i=0;
			$total=0;
			$fields="fn_generaljournals.debit,fn_generaljournals.credit,fn_generaljournals.documentno,fn_generaljournals.remarks, fn_generaljournals.transactdate, sys_transactions.name as transactionid";
			$join=" left join sys_transactions on fn_generaljournals.transactionid=sys_transactions.id ";
			$where=" where fn_generaljournals.documentno='$obj->treatmentid'  and fn_generaljournals.accountid='$gnas->id'";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$generaljournals->result;
			while($row=mysql_fetch_object($res)){$i++;
			$total+=$row->debit-$row->credit;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo formatDate($row->transactdate);?></td>
				<td align="right"><?php if($row->debit>=0){echo formatNumber($row->debit);}else{echo"(".formatNumber($row->credit).")";} ?></td>
				<td><a href=""></a></td>
			</tr>
			<?php 
			}
			?>
			
			</tbody>
			<tfoot>
				<tr>
					<th>&nbsp;</th>
					<th>Balance</th>
					<th>&nbsp;</th>
					<th align="right"><?php echo formatNumber($total);?></th>
					<th>&nbsp;</th>
				</tr>
			</tfoot>
		</table>
	<div style="clear:both;"></div>
</div><!-- tab7End -->

<div id="tabs-8" style="min-height:420px;">
            <table>
                <tr>
                    <td align="right">Current Patient: </td>
                    <td><font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?></td>
                </tr>
            </table>
			<table style="clear:both;"  class="tgrid display" id="waitinglist" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Treatment No</th>
			<th>Treated On</th>
			<th>Symptoms</th>
			<th>HPI</th>
			<th>OBS/Gyne/PSMH</th>
			<th>Examination Findings</th>
			<th>Laboratory Tests</th>
			<th>Diagnosis</th>
			<th>Prescription</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$patienttreatments=new Patienttreatments();
		$fields="hos_patienttreatments.id, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.symptoms, hos_patienttreatments.hpi, hos_patienttreatments.obs, hos_patienttreatments.findings, hos_patienttreatments.diagnosis, hos_patienttreatments.treatedon, hos_patientstatuss.name as patientstatusid, hos_patienttreatments.payconsultancy, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
		$join=" left join hos_patients on hos_patienttreatments.patientid=hos_patients.id  left join hos_patientstatuss on hos_patienttreatments.patientstatusid=hos_patientstatuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_patients.id='$obj->patientid'  and hos_patienttreatments.id not in($obj->treatmentid)";
		$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patienttreatments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->id; ?></td>
			<td><?php echo formatDate($row->treatedon); ?></td>
			<td><?php echo $row->symptoms; ?></td>
			<td><?php echo $row->hpi; ?></td>
			<td><?php echo $row->obs; ?></td>
			<td><?php echo $row->findings; ?></td>
			<td>
			<table>
			<?php 
			$patientlaboratorytests = new Patientlaboratorytests();
			$fields=" hos_laboratorytests.name, hos_patientlaboratorytests.labresults ";
			$join=" left join hos_laboratorytests on hos_laboratorytests.id=hos_patientlaboratorytests.laboratorytestid ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hos_patientlaboratorytests.patienttreatmentid=$row->id ";
			$patientlaboratorytests->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($patientlaboratorytests->result)){
			?>
			<tr>
				<td><?php echo $rw->name; ?></td>
				<td><?php echo $rw->labresults; ?></td>
			</tr>
			<?php 
			}
			?>
			</table>
			</td>
			<td>
			<table>
			<?php 
			$patientdiagnosis = new Patientdiagnosis();
			$fields=" hos_diagnosis.name as name";
			$join="  left join hos_diagnosis on hos_patientdiagnosis.diagnosiid=hos_diagnosis.id  ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hos_patientdiagnosis.patienttreatmentid=$row->id ";
			$patientdiagnosis->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($patientdiagnosis->result)){
			?>
			<tr>
				<td><?php echo $rw->name; ?></td>
				
			</tr>
			<?php 
			}
			?>
			</table>
			</td>
			<td>
			<table>
			<?php 
			$patientprescriptions = new Patientprescriptions();
			$fields="hos_patientprescriptions.quantity, inv_items.name";
			$join=" left join inv_items on hos_patientprescriptions.itemid=inv_items.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hos_patientprescriptions.patienttreatmentid=$row->id ";
			$patientprescriptions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($patientprescriptions->result)){
			?>
			<tr>
				<td><?php echo $rw->name; ?></td>
				<td><?php echo $rw->quantity; ?></td>
				<td><?php echo $rw->remarks; ?></td>
			</tr>
			<?php }?>
			</table>
			</td>
		</tr>

	<?php 
	}
	?>	
            	</tbody>
</table>
    <div style="clear:both;"></div>
</div>
<?php //}?>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>
</div>
<div align="center" style="margin:20px;">
	<input class="btn" onclick="showPopWin('preprint.php?treatmentid=<?php echo $obj->treatmentid; ?>', 400, 430);" value="Print" type="button"/>
	<input type="button" class="btn" onclick="showPopWin('printinvoice.php?documentno=<?php echo $obj->treatmentid; ?>&patientid=<?php echo $obj->patientid; ?>', 600, 530);" value="Print Invoice" />
	<!--<input name="" type="button" value="Print" onclick="javascript:child_open()" style="cursor:pointer;">-->
</div>