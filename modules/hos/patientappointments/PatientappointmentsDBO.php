<?php 
require_once("../../../DB.php");
class PatientappointmentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patientappointments";

	function persist($obj){
		$sql="insert into hos_patientappointments(id,patientid,appointmentdate,employeeid,departmentid,bookedon,remarks,status,payconsultancy,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->patientid','$obj->appointmentdate','$obj->employeeid','$obj->departmentid','$obj->bookedon','$obj->remarks','$obj->status','$obj->payconsultancy','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patientappointments set patientid='$obj->patientid',appointmentdate='$obj->appointmentdate',employeeid='$obj->employeeid',departmentid='$obj->departmentid',bookedon='$obj->bookedon',remarks='$obj->remarks',status='$obj->status',payconsultancy='$obj->payconsultancy',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patientappointments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientappointments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

