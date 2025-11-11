<?php 
require_once("../../../DB.php");
class OrdersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_orders";

	function persist($obj){
		$sql="insert into pos_orders(id,orderno,shiftid,tableno,customerid,brancheid,brancheid2,consigneeid,orderedon,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->orderno','$obj->shiftid','$obj->tableno',$obj->customerid,$obj->brancheid,$obj->brancheid2,$obj->consigneeid,'$obj->orderedon','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pos_orders set orderno='$obj->orderno', shiftid='$obj->shiftid',brancheid=$obj->brancheid,brancheid2=$obj->brancheid2,tableno='$obj->tableno',customerid=$obj->customerid,consigneeid=$obj->consigneeid,orderedon='$obj->orderedon',remarks='$obj->remarks', status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_orders $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_orders $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

