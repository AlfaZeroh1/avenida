<?php 
require_once("../../../DB.php");
class ItemsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_items";

	function persist($obj){
		$sql="insert into inv_items(id,itemid,code,name,warmth,departmentid,departmentcategoryid,categoryid,manufacturer,strength,currencyid,costprice,tradeprice,retailprice,size,unitofmeasureid,vatclasseid,generaljournalaccountid,generaljournalaccountid2,discount,reorderlevel,reorderquantity,quantity,reducing,status,type,value,image,volume,package,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->itemid,'$obj->code','$obj->name','$obj->warmth',$obj->departmentid,$obj->departmentcategoryid,$obj->categoryid,'$obj->manufacturer','$obj->strength',$obj->currencyid,'$obj->costprice','$obj->tradeprice','$obj->retailprice','$obj->size',$obj->unitofmeasureid,$obj->vatclasseid,$obj->generaljournalaccountid,$obj->generaljournalaccountid2,'$obj->discount','$obj->reorderlevel','$obj->reorderquantity','$obj->quantity','$obj->reducing','$obj->status','$obj->type','$obj->value','$obj->image','$obj->volume','$obj->package','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";//echo $sql;	
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
		$sql="update inv_items set itemid=$obj->itemid, code='$obj->code',name='$obj->name', warmth='$obj->warmth',departmentid=$obj->departmentid,departmentcategoryid=$obj->departmentcategoryid,categoryid=$obj->categoryid,manufacturer='$obj->manufacturer',strength='$obj->strength', currencyid=$obj->currencyid,costprice='$obj->costprice',tradeprice='$obj->tradeprice',retailprice='$obj->retailprice',size='$obj->size',unitofmeasureid=$obj->unitofmeasureid,vatclasseid=$obj->vatclasseid,generaljournalaccountid=$obj->generaljournalaccountid,generaljournalaccountid2=$obj->generaljournalaccountid2,discount='$obj->discount',reorderlevel='$obj->reorderlevel',reorderquantity='$obj->reorderquantity',quantity='$obj->quantity',reducing='$obj->reducing',status='$obj->status',type='$obj->type', value='$obj->value', image='$obj->image',volume='$obj->volume',package='$obj->package',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql; //echo $sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_items $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_items $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

