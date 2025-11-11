<?php 
require_once("../../../DB.php");
class ReturnoutwarddetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_returnoutwarddetails";

	function persist($obj){
		$sql="insert into inv_returnoutwarddetails(id,returnoutwardid,itemid,assetid,quantity,costprice,tax,vatamount,discount,total,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->returnoutwardid,$obj->itemid,$obj->assetid,'$obj->quantity','$obj->costprice','$obj->tax','$obj->vatamount','$obj->discount','$obj->total','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;//echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update inv_returnoutwarddetails set returnoutwardid=$obj->returnoutwardid,itemid=$obj->itemid,assetid=$obj->assetid,quantity='$obj->quantity',costprice='$obj->costprice',tax='$obj->tax',vatamount=$obj->vatamount,discount='$obj->discount',total='$obj->total',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_returnoutwarddetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_returnoutwarddetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

