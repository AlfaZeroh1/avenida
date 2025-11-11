<?php 
require_once("../../../DB.php");
class DeductionchargesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_deductioncharges";

	function persist($obj){
		$sql="insert into hrm_deductioncharges(id,deductionid,amountfrom,amountto,charge,chargetype,remarks,formula,ipaddress)
						values('$obj->id','$obj->deductionid','$obj->amountfrom','$obj->amountto','$obj->charge','$obj->chargetype','$obj->remarks','$obj->formula','$obj->ipaddress')";		
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
		$sql="update hrm_deductioncharges set deductionid='$obj->deductionid',amountfrom='$obj->amountfrom',amountto='$obj->amountto',charge='$obj->charge',chargetype='$obj->chargetype',remarks='$obj->remarks',formula='$obj->formula',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_deductioncharges $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_deductioncharges $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

