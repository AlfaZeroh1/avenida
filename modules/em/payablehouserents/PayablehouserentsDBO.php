<?php 
require_once("../../../DB.php");
class PayablehouserentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_payablehouserents";

	function persist($obj){
		$sql="insert into em_payablehouserents(id,documentno,houseid,tenantid,month,year,invoicedon,amount,remarks)
						values('$obj->id','$obj->documentno','$obj->houseid','$obj->tenantid','$obj->month','$obj->year','$obj->invoicedon','$obj->amount','$obj->remarks')";		
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
		$sql="update em_payablehouserents set documentno='$obj->documentno',houseid='$obj->houseid',tenantid='$obj->tenantid',month='$obj->month',year='$obj->year',invoicedon='$obj->invoicedon',amount='$obj->amount',remarks='$obj->remarks' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_payablehouserents $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_payablehouserents $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

