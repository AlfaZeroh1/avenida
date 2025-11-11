<?php 
require_once("../../../DB.php");
class PatientsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patients";

	function persist($obj){
		$sql="insert into hos_patients(id,patientno,surname,othernames,patientclasseid,bloodgroup,address,email,mobile,genderid,dob,createdby,createdon,lasteditedby,lasteditedon,civilstatusid)
						values('$obj->id','$obj->patientno','$obj->surname','$obj->othernames',$obj->patientclasseid,'$obj->bloodgroup','$obj->address','$obj->email','$obj->mobile',$obj->genderid,'$obj->dob','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon',$obj->civilstatusid)";		
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
		$sql="update hos_patients set patientno='$obj->patientno',surname='$obj->surname',othernames='$obj->othernames',patientclasseid=$obj->patientclasseid,bloodgroup='$obj->bloodgroup',address='$obj->address',email='$obj->email',mobile='$obj->mobile',genderid=$obj->genderid,dob='$obj->dob',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',civilstatusid=$obj->civilstatusid where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patients $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patients $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

