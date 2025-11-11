<?php 
require_once("../../../DB.php");
class StocktakedetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_stocktakedetails";

	function persist($obj){
		$sql="insert into inv_stocktakedetails(id,brancheid,itemid, stocktakeid,takenon,quantity,stock,costprice,total,createdby,createdon,lasteditedon,lasteditedby,ipaddress)
						values('$obj->id','$obj->brancheid','$obj->itemid', '$obj->stocktakeid','$obj->takenon','$obj->quantity','$obj->stock','$obj->costprice','$obj->total','$obj->createdby','$obj->createdon','$obj->lasteditedon','$obj->lasteditedby','$obj->ipaddress')";		
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
		$sql="update inv_stocktakedetails set brancheid='$obj->brancheid', itemid='$obj->itemid', stocktakeid='$obj->stocktakeid',takenon='$obj->takenon',quantity='$obj->quantity', stock='$obj->stock',costprice='$obj->costprice',total='$obj->total',lasteditedon='$obj->lasteditedon',lasteditedby='$obj->lasteditedby',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;echo $sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_stocktakedetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_stocktakedetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

