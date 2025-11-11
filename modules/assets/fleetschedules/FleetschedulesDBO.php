<?php 
require_once("../../../DB.php");
class FleetschedulesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="assets_fleetschedules";

	function persist($obj){
		$sql="insert into assets_fleetschedules(id,assetid,employeeid,projectid,customerid,source,destination,departuretime,expectedarrivaltime,arrivaltime,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->assetid,$obj->employeeid,$obj->projectid,$obj->customerid,'$obj->source','$obj->destination','$obj->departuretime','$obj->expectedarrivaltime','$obj->arrivaltime','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update assets_fleetschedules set assetid=$obj->assetid,employeeid=$obj->employeeid,projectid=$obj->projectid,customerid=$obj->customerid,source='$obj->source',destination='$obj->destination',departuretime='$obj->departuretime',expectedarrivaltime='$obj->expectedarrivaltime',arrivaltime='$obj->arrivaltime',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from assets_fleetschedules $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from assets_fleetschedules $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

