<?php 
require_once("../../../DB.php");
class OrderdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_orderdetails";

	function persist($obj){
		$sql="insert into pos_orderdetails(id,brancheid2,itemid,sizeid,quantity,warmth,price,memo,ipaddress,createdby,createdon,lasteditedby,lasteditedon,orderid)
						values('$obj->id','$obj->brancheid2',$obj->itemid,$obj->sizeid,'$obj->quantity','$obj->warmth','$obj->price','$obj->memo','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon',$obj->orderid)";		
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
		$sql="update pos_orderdetails set brancheid2='$obj->brancheid2', itemid=$obj->itemid,sizeid=$obj->sizeid,quantity='$obj->quantity', warmth='$obj->warmth',price='$obj->price',memo='$obj->memo',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',orderid=$obj->orderid where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_orderdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_orderdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

