<?php 
require_once("../../../DB.php");
class PurchasedetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_purchasedetails";

	function persist($obj){
		$sql="insert into inv_purchasedetails(id,purchaseid,itemid,assetid,quantity,inwardno,costprice,discount,discountamount,vatclasseid,tax,vatamount,bonus,total,memo,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->purchaseid','$obj->itemid','$obj->assetid','$obj->quantity','$obj->inwardno','$obj->costprice','$obj->discount','$obj->discountamount','$obj->vatclasseid','$obj->tax','$obj->vatamount','$obj->bonus','$obj->total','$obj->memo','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(empty($obj->effectjournals)){
		  if(mysql_query($sql,$this->connection)){		
			  $this->id=mysql_insert_id();
			  return true;	
		  }
		}else{
		  return true;
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update inv_purchasedetails set purchaseid='$obj->purchaseid',itemid='$obj->itemid',assetid='$obj->assetid',quantity='$obj->quantity',inwardno='$obj->inwardno',costprice='$obj->costprice',discount='$obj->discount',discountamount='$obj->discountamount',vatclasseid='$obj->vatclasseid',tax='$obj->tax',bonus='$obj->bonus',total='$obj->total',memo='$obj->memo',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
// 		if(empty($obj->effectjournals)){
		  if(mysql_query($sql,$this->connection)){	
			  return true;	
		  }
// 		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_purchasedetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_purchasedetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

