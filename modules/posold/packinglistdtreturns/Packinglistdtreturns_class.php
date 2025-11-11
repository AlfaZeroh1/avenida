<?php 
require_once("PackinglistdtreturnsDBO.php");
class Packinglistdtreturns
{				
	var $id;			
	var $packinglistreturnid;			
	var $itemid;			
	var $quantity;			
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $packinglistdtreturnsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->packinglistreturnid))
			$obj->packinglistreturnid='NULL';
		$this->packinglistreturnid=$obj->packinglistreturnid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get packinglistreturnid
	function getPackinglistid(){
		return $this->packinglistreturnid;
	}
	//set packinglistreturnid
	function setPackinglistid($packinglistreturnid){
		$this->packinglistreturnid=$packinglistreturnid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}
	
	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj,$shop){
		$packinglistdtreturnsDBO = new PackinglistdtreturnsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->remarks=$shop[$i]['remarks'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->sizeid=$shop[$i]['sizeid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			if($obj->returns==1){
			  $obj->quantity*=-1;
			}
			$obj->memo=$shop[$i]['memo'];

			//this deletes the first element in the array
//                         if($i<$obj->iterator-1)
//                                 $shop=array_slice($shop,1);		

			if($packinglistdtreturnsDBO->persist($obj)){	
			
			if($obj->returns==1){
			  $obj->quantity*=-1;
			}
				$itemstocks = new Itemstocks();
			
			      if($obj->returns==1){
				$itemstocks->addStock($obj);
			      }else{
				$itemstocks->reduceStock($obj);
			      }
			  
				$this->id=$packinglistdtreturnsDBO->id;
				$this->sql=$packinglistdtreturnsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$packinglistdtreturnsDBO = new PackinglistdtreturnsDBO();
		if($packinglistdtreturnsDBO->update($obj,$where)){
			$this->sql=$packinglistdtreturnsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$packinglistdtreturnsDBO = new PackinglistdtreturnsDBO();
		if($packinglistdtreturnsDBO->delete($obj,$where=""))		
			$this->sql=$packinglistdtreturnsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$packinglistdtreturnsDBO = new PackinglistdtreturnsDBO();
		$this->table=$packinglistdtreturnsDBO->table;
		$packinglistdtreturnsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$packinglistdtreturnsDBO->sql;
		$this->result=$packinglistdtreturnsDBO->result;
		$this->fetchObject=$packinglistdtreturnsDBO->fetchObject;
		$this->affectedRows=$packinglistdtreturnsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->packinglistreturnid)){
			$error="Packing List should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
