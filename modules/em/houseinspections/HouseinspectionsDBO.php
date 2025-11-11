<?php 
require_once("../../../DB.php");
class HouseinspectionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_houseinspections";

	function persist($obj){
		$sql="insert into em_houseinspections(id,houseid,housestatusid,findings,recommendations,remarks,employeeid,doneon,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->houseid,$obj->housestatusid,'$obj->findings','$obj->recommendations','$obj->remarks',$obj->employeeid,'$obj->doneon','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_houseinspections set houseid=$obj->houseid,housestatusid=$obj->housestatusid,findings='$obj->findings',recommendations='$obj->recommendations',remarks='$obj->remarks',employeeid=$obj->employeeid,doneon='$obj->doneon',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_houseinspections $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_houseinspections $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

