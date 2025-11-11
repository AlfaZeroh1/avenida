<?php 
require_once("../../../DB.php");
class CustomerissuesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crm_customerissues";

	function persist($obj){
		$sql="insert into crm_customerissues(id,documentno,customerid,issuetypeid,description,remarks,status,employeeid,startedon,finishedon,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->customerid','$obj->issuetypeid','$obj->description','$obj->remarks','$obj->status',$obj->employeeid,'$obj->startedon','$obj->finishedon','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update crm_customerissues set documentno='$obj->documentno',customerid='$obj->customerid',issuetypeid='$obj->issuetypeid',description='$obj->description',remarks='$obj->remarks',status='$obj->status',employeeid=$obj->employeeid,startedon='$obj->startedon',finishedon='$obj->finishedon',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crm_customerissues $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crm_customerissues $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

