<?php 
require_once("../../../DB.php");
class SalesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_sales";

	function persist($obj){
		$sql="insert into pos_sales(id,documentno,projectid,customerid,agentid,employeeid,remarks,mode,soldon,expirydate,memo,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->documentno',$obj->projectid,$obj->customerid,$obj->agentid,$obj->employeeid,'$obj->remarks','$obj->mode','$obj->soldon','$obj->expirydate','$obj->memo','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update pos_sales set documentno='$obj->documentno',projectid=$obj->projectid,customerid=$obj->customerid,agentid=$obj->agentid,employeeid=$obj->employeeid,remarks='$obj->remarks',mode='$obj->mode',soldon='$obj->soldon',expirydate='$obj->expirydate',memo='$obj->memo',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_sales $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_sales $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

