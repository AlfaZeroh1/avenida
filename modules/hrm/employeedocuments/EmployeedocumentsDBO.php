<?php 
require_once("../../../DB.php");
class EmployeedocumentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeedocuments";

	function persist($obj){
		$sql="insert into hrm_employeedocuments(id,employeeid,documenttypeid,file,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->employeeid,$obj->documenttypeid,'$obj->file','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update hrm_employeedocuments set employeeid=$obj->employeeid,documenttypeid=$obj->documenttypeid,file='$obj->file',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeedocuments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeedocuments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

