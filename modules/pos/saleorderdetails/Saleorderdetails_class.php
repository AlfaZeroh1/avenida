<?php 
require_once("SaleorderdetailsDBO.php");
class Saleorderdetails
{				
	var $id;			
	var $saleorderid;			
	var $itemid;			
	var $quantity;			
	var $costprice;			
	var $tradeprice;			
	var $discount;			
	var $tax;			
	var $bonus;			
	var $profit;			
	var $total;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $saleorderdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->saleorderid))
			$obj->saleorderid='NULL';
		$this->saleorderid=$obj->saleorderid;
		$this->itemid=str_replace("'","\'",$obj->itemid);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->bonus=str_replace("'","\'",$obj->bonus);
		$this->profit=str_replace("'","\'",$obj->profit);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get saleorderid
	function getSaleorderid(){
		return $this->saleorderid;
	}
	//set saleorderid
	function setSaleorderid($saleorderid){
		$this->saleorderid=$saleorderid;
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

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get bonus
	function getBonus(){
		return $this->bonus;
	}
	//set bonus
	function setBonus($bonus){
		$this->bonus=$bonus;
	}

	//get profit
	function getProfit(){
		return $this->profit;
	}
	//set profit
	function setProfit($profit){
		$this->profit=$profit;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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
		$saleorderdetailsDBO = new SaleorderdetailsDBO();
			if($saleorderdetailsDBO->persist($obj)){		
				$this->id=$saleorderdetailsDBO->id;
				$this->sql=$saleorderdetailsDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where=""){
		$saleorderdetailsDBO = new SaleorderdetailsDBO();
		if($saleorderdetailsDBO->update($obj,$where)){
			$this->sql=$saleorderdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$saleorderdetailsDBO = new SaleorderdetailsDBO();
		if($saleorderdetailsDBO->delete($obj,$where=""))		
			$this->sql=$saleorderdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$saleorderdetailsDBO = new SaleorderdetailsDBO();
		$this->table=$saleorderdetailsDBO->table;
		$saleorderdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$saleorderdetailsDBO->sql;
		$this->result=$saleorderdetailsDBO->result;
		$this->fetchObject=$saleorderdetailsDBO->fetchObject;
		$this->affectedRows=$saleorderdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->saleorderid)){
			$error="Sale Order should be provided";
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
