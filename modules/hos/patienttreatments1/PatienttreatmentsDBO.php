<?php 
require_once("../../../DB.php");
class PatienttreatmentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patienttreatments";

	function persist($obj){
		$sql="insert into hos_patienttreatments(id,patientid,patientappointmentid,symptoms,hpi,obs,findings,investigation,diagnosiid,diagnosis,treatment,prescription,labtests,admission,treatedon,patientstatusid,payconsultancy,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->patientid,'$obj->patientappointmentid','$obj->symptoms','$obj->hpi','$obj->obs','$obj->findings','$obj->investigation',$obj->diagnosiid,'$obj->diagnosis','$obj->treatment','$obj->prescription','$obj->labtests','$obj->admission','$obj->treatedon',$obj->patientstatusid,'$obj->payconsultancy','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patienttreatments set patientid=$obj->patientid,patientappointmentid='$obj->patientappointmentid',symptoms='$obj->symptoms',hpi='$obj->hpi',obs='$obj->obs',findings='$obj->findings',investigation='$obj->investigation',diagnosiid=$obj->diagnosiid,diagnosis='$obj->diagnosis',treatment='$obj->treatment',prescription='$obj->prescription',labtests='$obj->labtests',admission='$obj->admission',treatedon='$obj->treatedon',patientstatusid=$obj->patientstatusid,payconsultancy='$obj->payconsultancy',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patienttreatments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patienttreatments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

