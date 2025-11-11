<?php 
require_once("../../../DB.php");
class ImpresttransactionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_impresttransactions";

	function persist($obj){
		$sql="insert into fn_impresttransactions(id,documentno,imprestaccountid,imprestid,memo,quantity,amount,incurredon,enteredon,remarks,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon,expenseid)
						values('$obj->id','$obj->documentno',$obj->imprestaccountid,$obj->imprestid,'$obj->memo','$obj->quantity','$obj->amount','$obj->incurredon','$obj->enteredon','$obj->remarks','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon',$obj->expenseid)";		
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
		$sql="update fn_impresttransactions set documentno='$obj->documentno',imprestaccountid=$obj->imprestaccountid,imprestid=$obj->imprestid,memo='$obj->memo',quantity='$obj->quantity',amount='$obj->amount',incurredon='$obj->incurredon',enteredon='$obj->enteredon',remarks='$obj->remarks',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',expenseid=$obj->expenseid where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from fn_impresttransactions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_impresttransactions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

