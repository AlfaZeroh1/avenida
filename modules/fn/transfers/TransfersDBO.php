<?php 
require_once("../../../DB.php");
class TransfersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_transfers";

	function persist($obj){
		$sql="insert into fn_transfers(id,documentno,bankid,amount,amount1,currencyid,rate,eurorate,exchangerate,tobankid,tocurrencyid,toeurate,torate,diffksh,diffeuro,paymentmodeid,transactno,chequeno,transactdate,remarks,createdby,createdon,lasteditedon,lasteditedby,ipaddress)
						values('$obj->id','$obj->documentno',$obj->bankid,'$obj->amount','$obj->amount1','$obj->currencyid','$obj->rate','$obj->eurorate','$obj->exchangerate','$obj->tobankid',$obj->tocurrencyid,'$obj->toeurate','$obj->torate','$obj->diffksh','$obj->diffeuro',$obj->paymentmodeid,'$obj->transactno','$obj->chequeno','$obj->transactdate','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedon','$obj->lasteditedby','$obj->ipaddress')";		
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
		$sql="update fn_transfers set documentno='$obj->documentno',bankid=$obj->bankid,amount='$obj->amount',amount1='$obj->amount1',currencyid='$obj->currencyid',rate='$obj->rate',eurorate='$obj->eurorate',exchangerate='$obj->exchangerate',tobankid='$obj->tobankid',tocurrencyid=$obj->tocurrencyid,toeurate='$obj->toeurate',torate='$obj->torate',diffksh='$obj->diffksh',diffeuro='$obj->diffeuro',paymentmodeid=$obj->paymentmodeid,transactno='$obj->transactno',chequeno='$obj->chequeno',transactdate='$obj->transactdate',remarks='$obj->remarks',lasteditedon='$obj->lasteditedon',lasteditedby='$obj->lasteditedby',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from fn_transfers $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_transfers $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

