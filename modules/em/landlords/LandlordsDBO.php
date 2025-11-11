<?php 
require_once("../../../DB.php");
class LandlordsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_landlords";

	function persist($obj){
		$sql="insert into em_landlords(id,llcode,firstname,middlename,lastname,tel,email,registeredon,fax,mobile,idno,passportno,postaladdress,address,deductcommission,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->llcode','$obj->firstname','$obj->middlename','$obj->lastname','$obj->tel','$obj->email','$obj->registeredon','$obj->fax','$obj->mobile','$obj->idno','$obj->passportno','$obj->postaladdress','$obj->address','$obj->deductcommission','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_landlords set llcode='$obj->llcode',firstname='$obj->firstname',middlename='$obj->middlename',lastname='$obj->lastname',tel='$obj->tel',email='$obj->email',registeredon='$obj->registeredon',fax='$obj->fax',mobile='$obj->mobile',idno='$obj->idno',passportno='$obj->passportno',postaladdress='$obj->postaladdress',address='$obj->address',deductcommission='$obj->deductcommission',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_landlords $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_landlords $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

