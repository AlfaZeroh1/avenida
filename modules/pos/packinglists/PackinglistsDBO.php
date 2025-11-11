<?php 
require_once("../../../DB.php");
class PackinglistsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_packinglists";

	function persist($obj){
		$sql="insert into pos_packinglists(id,documentno,orderno,boxno,mixedbox,item,customerid,consigneeid,packedon,fleetid,employeeid,remarks,memo,returns,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->orderno','$obj->boxno','$obj->mixedbox','$obj->item',$obj->customerid,'$obj->consigneeid','$obj->packedon',$obj->fleetid,$obj->employeeid,'$obj->remarks','$obj->memo','$obj->returns','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')"; 		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where="", $bool=false){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		if(!$bool)
                    $sql="update pos_packinglists set documentno='$obj->documentno',orderno='$obj->orderno',boxno='$obj->boxno',mixedbox='$obj->mixedbox',item='$obj->item',customerid=$obj->customerid,consigneeid='$obj->consigneeid',packedon='$obj->packedon',fleetid=$obj->fleetid,employeeid=$obj->employeeid,remarks='$obj->remarks', memo='$obj->memo',returns='$obj->returns',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
                else
                    $sql="update pos_packinglists set  memo='$obj->memo',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
                    
                  
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){	  	
			return true;	
		}//echo mysql_error();
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_packinglists $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_packinglists $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

