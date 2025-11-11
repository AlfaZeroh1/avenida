<?php 
require_once("../../../DB.php");
class ProjectboqdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="con_projectboqdetails";

	function persist($obj){
		$sql="insert into con_projectboqdetails(id,projectboqid,materialcategoryid,materialsubcategoryid,estimationmanualid,unitofmeasureid,quantity,rate,total,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->projectboqid,$obj->materialcategoryid,$obj->materialsubcategoryid,$obj->estimationmanualid,$obj->unitofmeasureid,'$obj->quantity','$obj->rate','$obj->total','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update con_projectboqdetails set projectboqid=$obj->projectboqid,materialcategoryid=$obj->materialcategoryid,materialsubcategoryid=$obj->materialsubcategoryid,estimationmanualid=$obj->estimationmanualid,unitofmeasureid=$obj->unitofmeasureid,quantity='$obj->quantity',rate='$obj->rate',total='$obj->total',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from con_projectboqdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from con_projectboqdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

