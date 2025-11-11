<?php 
require_once("../../../DB.php");
class GeneraljournalsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_generaljournals";

	function persist($obj){
		$sql="insert into fn_generaljournals(id,accountid,daccountid,tid,documentno,mode,transactionid,remarks,memo,transactdate,debit,credit,jvno,chequeno,did,reconstatus,balance,recondate,class,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->accountid,'$obj->daccountid','$obj->tid','$obj->documentno','$obj->mode','$obj->transactionid','$obj->remarks','$obj->memo','$obj->transactdate','$obj->debit','$obj->credit','$obj->jvno','$obj->chequeno','$obj->did','$obj->reconstatus','$obj->balance','$obj->recondate','$obj->class','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql; //echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update fn_generaljournals set accountid=$obj->accountid,daccountid='$obj->daccountid',tid='$obj->tid',documentno='$obj->documentno',mode='$obj->mode',transactionid='$obj->transactionid',remarks='$obj->remarks',memo='$obj->memo',transactdate='$obj->transactdate',debit='$obj->debit',credit='$obj->credit',jvno='$obj->jvno',chequeno='$obj->chequeno',did='$obj->did',reconstatus='$obj->reconstatus',balance='$obj->balance',recondate='$obj->recondate',class='$obj->class',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		
		$sql="delete from fn_generaljournals $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_generaljournals $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

