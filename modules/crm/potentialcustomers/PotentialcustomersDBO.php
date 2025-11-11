<?php 
require_once("../../../DB.php");
class PotentialcustomersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crm_potentialcustomers";

	function persist($obj){
		$sql="insert into crm_potentialcustomers(id,name,agentid,departmentid,categorydepartmentid,categoryid,employeeid,idno,pinno,address,tel,fax,email,contactname,contactphone,remarks,status,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->name',$obj->agentid,$obj->departmentid,$obj->categorydepartmentid,$obj->categoryid,$obj->employeeid,'$obj->idno','$obj->pinno','$obj->address','$obj->tel','$obj->fax','$obj->email','$obj->contactname','$obj->contactphone','$obj->remarks','$obj->status','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update crm_potentialcustomers set name='$obj->name',agentid=$obj->agentid,departmentid=$obj->departmentid,categorydepartmentid=$obj->categorydepartmentid,categoryid=$obj->categoryid,employeeid=$obj->employeeid,idno='$obj->idno',pinno='$obj->pinno',address='$obj->address',tel='$obj->tel',fax='$obj->fax',email='$obj->email',contactname='$obj->contactname',contactphone='$obj->contactphone',remarks='$obj->remarks',status='$obj->status',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crm_potentialcustomers $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crm_potentialcustomers $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

