<?php 
require_once("PurchaseorderdetailsDBO.php");
class Purchaseorderdetails
{				
	var $id;			
	var $purchaseorderid;			
	var $itemid;	
	var $unitofmeasureid;
	var $quantity;			
	var $costprice;			
	var $tradeprice;	
	var $vatclasseid;
	var $tax;	
	var $taxamount;
	var $total;			
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $purchaseorderdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->purchaseorderid))
			$obj->purchaseorderid='NULL';
		$this->purchaseorderid=$obj->purchaseorderid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->vatclasseid=str_replace("'","\'",$obj->vatclasseid);
		$this->taxamount=str_replace("'","\'",$obj->taxmount);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get purchaseorderid
	function getPurchaseorderid(){
		return $this->purchaseorderid;
	}
	//set purchaseorderid
	function setPurchaseorderid($purchaseorderid){
		$this->purchaseorderid=$purchaseorderid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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
		$purchaseorderdetailsDBO = new PurchaseorderdetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->quantity=$shop[$i]['quantity'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->unitofmeasureid=$shop[$i]['unitofmeasureid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->code=$shop[$i]['code'];
			$obj->vatclasseid=$shop[$i]['vatclasseid'];
			$obj->tax=$shop[$i]['tax'];
			$obj->taxamount=$shop[$i]['taxamount'];
			$obj->costprice=$shop[$i]['costprice'];
			$obj->tradeprice=$shop[$i]['tradeprice'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->total=$shop[$i]['total'];
			if($purchaseorderdetailsDBO->persist($obj)){		
				
				if(!empty($obj->unitofmeasureid)){
				  //update inventory
				  $items=new Items();
				  $where=" where id='$obj->unitofmeasureid' ";
				  $fields="*";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				  if(empty($items->unitofmeasureid)){
				    $items=$items->fetchObject;
				    
				    $it = new Items();
				    $items->unitofmeasureid=$obj->unitofmeasureid;
				    $it = $it->setObject($items);
				    $it->edit($it);
				    
				  }
				}
				
				$this->id=$purchaseorderdetailsDBO->id;
				$this->sql=$purchaseorderdetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$purchaseorderdetailsDBO = new PurchaseorderdetailsDBO();
		if($purchaseorderdetailsDBO->update($obj,$where)){
			$this->sql=$purchaseorderdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$purchaseorderdetailsDBO = new PurchaseorderdetailsDBO();
		if($purchaseorderdetailsDBO->delete($obj,$where=""))		
			$this->sql=$purchaseorderdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$purchaseorderdetailsDBO = new PurchaseorderdetailsDBO();
		$this->table=$purchaseorderdetailsDBO->table;
		$purchaseorderdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$purchaseorderdetailsDBO->sql;
		$this->result=$purchaseorderdetailsDBO->result;
		$this->fetchObject=$purchaseorderdetailsDBO->fetchObject;
		$this->affectedRows=$purchaseorderdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->purchaseorderid)){
			$error="Purchase Order should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
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
