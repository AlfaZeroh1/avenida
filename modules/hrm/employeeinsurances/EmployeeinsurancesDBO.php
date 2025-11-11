<?php 
require_once("../../../DB.php");
class EmployeeinsurancesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeeinsurances";

	function persist($obj){
		$sql="insert into hrm_employeeinsurances(id,employeeid,insuranceid,insurancetype,premium,relief,startdate,expectedenddate,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->employeeid',$obj->insuranceid,'$obj->insurancetype','$obj->premium','$obj->relief','$obj->startdate','$obj->expectedenddate','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update hrm_employeeinsurances set employeeid='$obj->employeeid',insuranceid=$obj->insuranceid,insurancetype='$obj->insurancetype',premium='$obj->premium',relief='$obj->relief',startdate='$obj->startdate',expectedenddate='$obj->expectedenddate',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeeinsurances $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeeinsurances $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

