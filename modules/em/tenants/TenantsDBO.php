<?php 
require_once("../../../DB.php");
class TenantsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_tenants";

	function persist($obj){
		$sql="insert into em_tenants(id,code,firstname,middlename,lastname,postaladdress,address,registeredon,nationalityid,tel,mobile,fax,idno,passportno,dlno,occupation,email,dob,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->code','$obj->firstname','$obj->middlename','$obj->lastname','$obj->postaladdress','$obj->address','$obj->registeredon','$obj->nationalityid','$obj->tel','$obj->mobile','$obj->fax','$obj->idno','$obj->passportno','$obj->dlno','$obj->occupation','$obj->email','$obj->dob','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_tenants set code='$obj->code',firstname='$obj->firstname',middlename='$obj->middlename',lastname='$obj->lastname',postaladdress='$obj->postaladdress',address='$obj->address',registeredon='$obj->registeredon',nationalityid='$obj->nationalityid',tel='$obj->tel',mobile='$obj->mobile',fax='$obj->fax',idno='$obj->idno',passportno='$obj->passportno',dlno='$obj->dlno',occupation='$obj->occupation',email='$obj->email',dob='$obj->dob',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_tenants $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_tenants $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);echo mysql_error();
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

