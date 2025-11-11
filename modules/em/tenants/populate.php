<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../housetenants/Housetenants_class.php';

//connect to db
$db=new DB();

$id = $_GET['id'];

$housetenants=new Housetenants();
$where="  where em_housetenants.houseid='$id'  ";
$fields="em_tenants.id, em_tenants.code, concat(concat(em_tenants.firstname,' ' ,em_tenants.middlename),' ', em_tenants.lastname) name, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob";
$join=" left join em_tenants on em_tenants.id=em_housetenants.tenantid";
$having=" ";
$groupby="";
$orderby="";
$housetenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$rw=$housetenants->fetchObject;

echo $rw->id."|".$rw->name."|".$rw->registeredon."|".$rw->idno."|".$rw->code;
?>