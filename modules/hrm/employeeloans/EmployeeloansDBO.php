<?php 
require_once("../../../DB.php");
class EmployeeloansDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeeloans";

	function persist($obj){
		$sql="insert into hrm_employeeloans(id,loanid,employeeid,principal,method,initialvalue,payable,duration,interesttype,interest,month,year,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->loanid,$obj->employeeid,'$obj->principal','$obj->method','$obj->initialvalue','$obj->payable','$obj->duration','$obj->interesttype','$obj->interest','$obj->month','$obj->year','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update hrm_employeeloans set loanid=$obj->loanid,employeeid=$obj->employeeid,principal='$obj->principal',method='$obj->method',initialvalue='$obj->initialvalue',payable='$obj->payable',duration='$obj->duration',interesttype='$obj->interesttype',interest='$obj->interest',month='$obj->month',year='$obj->year',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeeloans $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeeloans $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

