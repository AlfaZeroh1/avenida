<?php 
require_once("../../../DB.php");
class InwarddetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="proc_inwarddetails";

	function persist($obj){
		$sql="insert into proc_inwarddetails(id,inwardid,itemid,categoryid,quantity,costprice,discount,discountamount,vatclasseid,tax,total,memo,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('',$obj->inwardid,$obj->itemid,$obj->categoryid,'$obj->quantity','$obj->costprice','$obj->discount','$obj->discountamount','$obj->vatclasseid','$obj->tax','$obj->total','$obj->memo','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update proc_inwarddetails set inwardid=$obj->inwardid,itemid=$obj->itemid,categoryid=$obj->categoryid,quantity='$obj->quantity',costprice='$obj->costprice', discount='$obj->discount', discountamount='$obj->discountamount', vatclasseid='$obj->vatclasseid', tax='$obj->tax', total='$obj->total',memo='$obj->memo',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from proc_inwarddetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from proc_inwarddetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

