<?php 
require_once("../../../DB.php");
class PaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_payments";

	function persist($obj){
		$sql="insert into hos_payments(id,documentno,patientid,transactionid,tid,treatmentno,paymentmodeid,bankid,payee,amount,payableid,remarks,paidon,consult,createdby,createdon,lasteditedby,lasteditedon,departmentid)
						values('$obj->id','$obj->documentno',$obj->patientid,$obj->transactionid,'$obj->tid','$obj->treatmentno',$obj->paymentmodeid,$obj->bankid,'$obj->payee','$obj->amount','$obj->payableid','$obj->remarks','$obj->paidon','$obj->consult','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon',$obj->departmentid)";//echo $sql;	
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
		$sql="update hos_payments set documentno='$obj->documentno',patientid=$obj->patientid,transactionid=$obj->transactionid,tid='$obj->tid',treatmentno='$obj->treatmentno',paymentmodeid=$obj->paymentmodeid,bankid=$obj->bankid,payee='$obj->payee',amount='$obj->amount',remarks='$obj->remarks',paidon='$obj->paidon',consult='$obj->consult',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',departmentid=$obj->departmentid where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_payments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_payments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

