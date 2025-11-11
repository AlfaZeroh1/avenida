<?php 
require_once("../../../DB.php");
class TenantdepositsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_tenantdeposits";

	function persist($obj){
		$sql="insert into em_tenantdeposits(id,tenantid,houseid,houserentingid,tenantpaymentid,paymenttermid,amount,paidon,remarks,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->tenantid,$obj->houseid,'$obj->houserentingid','$obj->tenantpaymentid',$obj->paymenttermid,'$obj->amount','$obj->paidon','$obj->remarks','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_tenantdeposits set tenantid=$obj->tenantid,houseid=$obj->houseid,houserentingid='$obj->houserentingid',tenantpaymentid='$obj->tenantpaymentid',paymenttermid=$obj->paymenttermid,amount='$obj->amount',paidon='$obj->paidon',remarks='$obj->remarks',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_tenantdeposits $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_tenantdeposits $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

