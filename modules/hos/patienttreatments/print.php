<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hos/patientlaboratorytests/Patientlaboratorytests_class.php");
require_once("../../hos/patienttreatments/Patienttreatments_class.php");
require_once("../../hos/patientotherservices/Patientotherservices_class.php");
require_once("../../hos/patientprescriptions/Patientprescriptions_class.php");
require_once("../../hos/patientvitalsigns/Patientvitalsigns_class.php");
require_once("../../hos/laboratorytestdetails/Laboratorytestdetails_class.php");
require_once("../../hos/patientlaboratorytestdetails/Patientlaboratorytestdetails_class.php");
require_once '../../sys/config/Config_class.php';

$obj = (object)$_GET;

$config = new Config();
$fields="*";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$arr = array();
while($rw=mysql_fetch_object($config->result)){
	$arr[$rw->name]=$rw->value;
}

$treatmentid=$_GET['treatmentid'];

$patienttreatments = new Patienttreatments();
$fields="hos_patienttreatments.id, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid,hos_patients.dob as dob,sys_genders.name as genderid,hos_patienttreatments.patientappointmentid, hos_patienttreatments.symptoms, hos_patienttreatments.hpi, hos_patienttreatments.obs, hos_patienttreatments.findings, hos_patienttreatments.investigation, hos_patienttreatments.diagnosis, hos_patienttreatments.admission, hos_patienttreatments.treatedon, hos_patientstatuss.name as patientstatusid, hos_patienttreatments.payconsultancy, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon, auth_users.username";
$join=" left join hos_patients on hos_patienttreatments.patientid=hos_patients.id  left join hos_patientstatuss on hos_patienttreatments.patientstatusid=hos_patientstatuss.id left join auth_users on auth_users.id=hos_patienttreatments.createdby left join sys_genders on sys_genders.id=hos_patients.genderid ";
$having="";
$groupby="";
$orderby="";
$where=" where hos_patienttreatments.id='$treatmentid' ";
$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$patient = $patienttreatments->fetchObject;

//$patientobservations = new Patientobservations();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Laboratory</title>
<script type="text/javascript">
  function print_doc()
  {
		
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
			if(printers[i].indexOf('<?php echo $arr['smallprinter'];?>')>-1)
			{	
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies',1);
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginLeft','1');
		jsPrintSetup.setOption('marginRight','1');
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<style media="print" type="text/css">
.noprint{ display:none;}
</style>

</head>
<body onload="print_doc();">
<div align="center" id="print_content" style="width:98%; margin:0px auto;">
   <div>
   <div class="hfields" align="left">
 <div align="center" style="font-weight:bold;page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">

 <span style="display:block; padding:0px 0px 2px;"><?php echo $arr['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companyaddr'];?>,<br/><?php echo $arr['companytown']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px;">Tel: <?php echo $arr['companytel'];?></span> </div>
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999"> </span></div>
 <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 <hr/>
 Patient: <?php echo initialCap($patient->patientid); ?><br/>
 Age: <?php echo $patient->dob; ?><br/>
 Gender: <?php echo $patient->genderid; ?><br/>
 Date: <?php echo formatDate($patient->treatedon); ?><br />
 Treatment No: <?php echo $patient->id; ?><br />
 Doctor: <?php echo $patient->username; ?><br /><hr/></div>
 
   </div>
   <b><u>PRESCRIPTION</b></u>
   <table width="100%">
   	<tr>
   		<?php if(!empty($obj->observation)){?>
   		<th>Observation</th>
   		<?php }if(!empty($obj->symptoms)){?>
   		<th>Symptoms</th>
   		<?php }if(!empty($obj->hpi)){?>
   		<td>HPI</td>
   		<?php }if(!empty($obj->obs)){?>
   		<td>OBS/Gyne/PSMH</td>
   		<?php }if(!empty($obj->findings)){?>
   		<td>Examination Findings</td>
   		<?php }if(!empty($obj->diagnosis)){?>
   		<th>Diagnosis</th>
   		<?php }?>
   	</tr>
   	<tr style="border: 10px; border-color: blue;">
   		<?php if(!empty($obj->observation)){?>
   		<td><?php echo $patient->observation; ?></td>
   		<?php }if(!empty($obj->symptoms)){?>
   		<td><?php echo $patient->symptoms; ?></td>
   		<?php }if(!empty($obj->hpi)){?>
   		<td><?php echo $patient->hpi; ?></td>
   		<?php }if(!empty($obj->obs)){?>
   		<td><?php echo $patient->obs; ?></td>
   		<?php }if(!empty($obj->findings)){?>
   		<td><?php echo $patient->findings; ?></td>
   		<?php }if(!empty($obj->diagnosis)){?>
   		<td><?php echo $patient->diagnosis; ?></td>
   		<?php }?>
   	</tr>
   	<?php if(!empty($obj->laboratory)){?>
   <tr>
   	<td colspan="3">   
	   <table class="tgrid gridd" width="100%" cellspacing="0">
	   <thead> 
	   <tr class="phead" style="font-size:12px;">
			<th width="5%"  style="border-left:none;"></th>
	<th style="text-align:left;">Lab Test</th>
	<th ><div>Results</div></th>
	</tr></thead>
			<tbody class="" style="width:100%;  ">	  
	      <?php 
	      $patientlaboratorytests = new Patientlaboratorytests();
	      $i=0;
	      $where=" where hos_patientlaboratorytests.patienttreatmentid='$treatmentid' ";
	      $fields=" hos_patientlaboratorytests.id, hos_laboratorytests.name, hos_laboratorytests.id lid, hos_patientlaboratorytests.labresults ";
	      $join=" left join hos_laboratorytests on hos_laboratorytests.id=hos_patientlaboratorytests.laboratorytestid ";
	      $patientlaboratorytests->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      while($row=mysql_fetch_object($patientlaboratorytests->result)){$i++;
	      ?>			
			    <tr>
					<td valign='top'><?php echo $i; ?></td>
					<td valign='top'><?php echo $row->name; ?></td>
					<td valign='top'><?php echo $row->labresults; ?></td>
				</tr>
				<tr>
				   <td colspan='3'>	
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
				    ?>
				   </td>
				</tr>
					
				<tr>
					<td colspan='3'><hr/></td>
				</tr>
		<?php 
		}
		?>
	      </tbody>
	      
	  </table>
	  </td>
	  </tr>
	  <?php }if(!empty($obj->other)){?>
	  <tr>
	  	<td colspan="3">
	  	<table>
	  		<tr>
	  			<th>&nbsp;</th>
	  			<th>Service</th>
	  			<th>Remarks</th>
	  		</tr>
	  		<?php 
	  		$i=0;
	  		$patientotherservices = new Patientotherservices();
	  		$fields="hos_patientotherservices.id, hos_patientotherservices.patienttreatmentid, hos_otherservices.name as otherserviceid, hos_patientotherservices.charge, hos_patientotherservices.remarks, hos_patientotherservices.createdby, hos_patientotherservices.createdon, hos_patientotherservices.lasteditedby, hos_patientotherservices.lasteditedon";
	  		$join=" left join hos_otherservices on hos_patientotherservices.otherserviceid=hos_otherservices.id ";
	  		$having="";
	  		$groupby="";
	  		$orderby="";
	  		$where=" where patienttreatmentid='$treatmentid' ";
	  		$patientotherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  		while($row=mysql_fetch_object($patientotherservices->result)){$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->otherserviceid; ?></td>
				<td><?php echo $row->remarks; ?></td>
			</tr>
			<?php 
			}
	  		?>
	  	</table>
	  	</td>
	  </tr>
	  <?php }if(!empty($obj->prescription)){?>
	  <tr>
	  	<td colspan="3" width="100%">
	  	<table width="100%">
	  		<tr>
	  			<td>&nbsp;</td>
	  			<td>Item Name</td>
	  			<td>Dosage</td>
	  			<td>Freq</td>
	  			<td>Duration</td>
	  			
	  			
	  			
	  		</tr>
	  		<?php 
	  		$i=0;
	  		$patientprescriptions = new Patientprescriptions();
	  		$fields="hos_patientprescriptions.id, inv_items.name as itemid, hos_patienttreatments.id as patienttreatmentid, hos_patientprescriptions.quantity, hos_patientprescriptions.price,hos_patientprescriptions.frequency,hos_patientprescriptions.duration,hos_patientprescriptions.remarks,hos_patientprescriptions.price,  hos_patientprescriptions.issued, hos_patientprescriptions.createdby, hos_patientprescriptions.createdon, hos_patientprescriptions.lasteditedby, hos_patientprescriptions.lasteditedon";
	  		$join=" left join inv_items on hos_patientprescriptions.itemid=inv_items.id  left join hos_patienttreatments on hos_patientprescriptions.patienttreatmentid=hos_patienttreatments.id ";
	  		$having="";
	  		$groupby="";
	  		$orderby="";
	  		$where=" where hos_patientprescriptions.patienttreatmentid='$obj->treatmentid' ";
	  		$patientprescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $patientprescriptions->sql;
	  		while($row=mysql_fetch_object($patientprescriptions->result)){$i++;
	  		?>
	  		<tr>
	  			<td><?php echo $i; ?></td>
	  			<td><?php echo $row->itemid; ?></td>
	  			<td><?php echo $row->remarks; ?></td>
	  			<td><?php echo $row->frequency; ?></td>
	  			<td><?php echo $row->duration; ?></td>
	  		
	  			
	  		</tr>
	  		<?php 
	  		}
	  		?>
	  	</table>
	  	</td>
	  </tr>
	  <?php }?>
	  	<?php if(!empty($obj->laboratory)){?>
   <tr>
   <td colspan="3">
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
			$patientlaboratorytests->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo mysql_error();
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
			<td><?php echo $row->diagnosis; ?></td>
			<td>
			<table>
			<?php 
			$patientprescriptions = new Patientprescriptions();
			$fields="hos_patientprescriptions.quantity, $db->db.items.itemname";
			$join=" left join $db->db.items on hos_patientprescriptions.itemid=items.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hos_patientprescriptions.patienttreatmentid=$row->id ";
			$patientprescriptions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($patientprescriptions->result)){
			?>
			<tr>
				<td><?php echo $rw->itemname; ?></td>
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
   </td>
   </tr>
   <?php }?>
	  <tr>
           <td colspan="3" align="center" style="font: italic;"><font style="italic"><i><?php echo $arr['labtestfooter'];?></i></font></td>
         </tr>
         <tr>
           <td colspan="3" align="center"><i>Served By: <?php echo $_SESSION['username']; ?></td>
         </tr>
        </table>
</div>
</body>
</html>
