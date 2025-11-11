<?php 
require_once("../../../DB.php");
class EmployeecontractsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeecontracts";

	function persist($obj){
		$sql="insert into hrm_employeecontracts(id,contracttypeid,startdate,confirmationdate,probation,contractperiod,status,remarks,employeeid,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->contracttypeid','$obj->startdate','$obj->confirmationdate','$obj->probation','$obj->contractperiod','$obj->status','$obj->remarks','$obj->employeeid','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update hrm_employeecontracts set contracttypeid='$obj->contracttypeid',startdate='$obj->startdate',confirmationdate='$obj->confirmationdate',probation='$obj->probation',contractperiod='$obj->contractperiod',status='$obj->status',remarks='$obj->remarks',employeeid='$obj->employeeid',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeecontracts $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeecontracts $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

