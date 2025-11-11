<?php 
require_once("../../../DB.php");
class EmployeeleaveapplicationsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeeleaveapplications";

	function persist($obj){
		$sql="insert into hrm_employeeleaveapplications(id,employeeid,employeeid1,leavetypeid,startdate,duration,enddate,appliedon,status,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress,type)
						values('$obj->id',$obj->employeeid,$obj->employeeid1,$obj->leavetypeid,'$obj->startdate','$obj->duration','$obj->enddate','$obj->appliedon','$obj->status','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress','$obj->type')";		
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
		$sql="update hrm_employeeleaveapplications set employeeid=$obj->employeeid,employeeid1=$obj->employeeid1,leavetypeid=$obj->leavetypeid,startdate='$obj->startdate',duration='$obj->duration',enddate='$obj->enddate',appliedon='$obj->appliedon',status='$obj->status',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress',type='$obj->type' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeeleaveapplications $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeeleaveapplications $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

