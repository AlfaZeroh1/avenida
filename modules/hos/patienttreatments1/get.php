<?php
require_once("../../../DB.php");
require_once("../../../lib.php");

$db = new DB();
$ob = (object)$_GET;

$today=date("Y-m-d");

$ql="select case when count(*) is null then 0 else count(*) end cnt, max(id) maxid from hos_patientappointments where status=0 and appointmentdate='$today' ";
$row=mysql_fetch_object(mysql_query($ql));

$query="select group_concat(concat(hos_patients.surname,' ',hos_patients.othernames)) names from hos_patientappointments left join hos_patients on hos_patients.id=hos_patientappointments.patientid and hos_patientappointments.id>'$ob->maxid'";
$rw=mysql_fetch_object(mysql_query($query));
echo $row->cnt."-".$row->maxid."-".$rw->names;
?>