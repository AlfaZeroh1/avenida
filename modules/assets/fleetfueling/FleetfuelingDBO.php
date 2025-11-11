<?php 
require_once("../../../DB.php");
class FleetfuelingDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="assets_fleetfueling";

	function persist($obj){
		$sql="insert into assets_fleetfueling(id,fleetid,quantity,cost,fueledon,employeeid,documentno,startodometer,endodometer,destination,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->fleetid,'$obj->quantity','$obj->cost','$obj->fueledon',$obj->employeeid,'$obj->documentno','$obj->startodometer','$obj->endodometer','$obj->destination','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update assets_fleetfueling set fleetid=$obj->fleetid,quantity='$obj->quantity',cost='$obj->cost',fueledon='$obj->fueledon',employeeid=$obj->employeeid,documentno='$obj->documentno',startodometer='$obj->startodometer',endodometer='$obj->endodometer',destination='$obj->destination',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from assets_fleetfueling $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from assets_fleetfueling $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

