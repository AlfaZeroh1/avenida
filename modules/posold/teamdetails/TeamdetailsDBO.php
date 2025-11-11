<?php 
require_once("../../../DB.php");
class TeamdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_teamdetails";

	function persist($obj){
		$sql="insert into pos_teamdetails(id,teamid,teamroleid,employeeid,remarks,ordered,paid,balance,submitted,short,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->teamid,$obj->teamroleid,$obj->employeeid,'$obj->remarks','$obj->ordered','$obj->paid','$obj->balance','$obj->submitted','$obj->short','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update pos_teamdetails set teamid=$obj->teamid,teamroleid=$obj->teamroleid,employeeid=$obj->employeeid,remarks='$obj->remarks',ordered='$obj->ordered',paid='$obj->paid',balance='$obj->balance',submitted='$obj->submitted',short='$obj->short',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_teamdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_teamdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

