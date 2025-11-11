<?php 
require_once("ItemsDBO.php");
class Items
{				
	var $id;			
	var $code;			
	var $name;			
	var $manufacturer;			
	var $strength;			
	var $costprice;			
	var $discount;			
	var $tradeprice;			
	var $retailprice;			
	var $applicabletax;			
	var $reorderlevel;			
	var $quantity;			
	var $status;			
	var $expirydate;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $itemsDBO;
	var $fetchObject;
	var $result;
	var $table;
	var $affectedRows;

	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get manufacturer
	function getManufacturer(){
		return $this->manufacturer;
	}
	//set manufacturer
	function setManufacturer($manufacturer){
		$this->manufacturer=$manufacturer;
	}

	//get strength
	function getStrength(){
		return $this->strength;
	}
	//set strength
	function setStrength($strength){
		$this->strength=$strength;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get retailprice
	function getRetailprice(){
		return $this->retailprice;
	}
	//set retailprice
	function setRetailprice($retailprice){
		$this->retailprice=$retailprice;
	}

	//get applicabletax
	function getApplicabletax(){
		return $this->applicabletax;
	}
	//set applicabletax
	function setApplicabletax($applicabletax){
		$this->applicabletax=$applicabletax;
	}

	//get reorderlevel
	function getReorderlevel(){
		return $this->reorderlevel;
	}
	//set reorderlevel
	function setReorderlevel($reorderlevel){
		$this->reorderlevel=$reorderlevel;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get expirydate
	function getExpirydate(){
		return $this->expirydate;
	}
	//set expirydate
	function setExpirydate($expirydate){
		$this->expirydate=$expirydate;
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

	function add($obj){			
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->persist($obj))		
			return true;	
	}			
	function edit($obj){			
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itemsDBO = new ItemsDBO();
		$this->table=$itemsDBO->table;
		$itemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->result=$itemsDBO->result;
		$this->fetchObject=$itemsDBO->fetchObject;
		$this->affectedRows=$itemsDBO->affectedRows;
	}			
}				
?>
