<?php 
require_once("PricingsDBO.php");
class Pricings
{				
	var $id;			
	var $category;			
	var $item;			
	var $price;			
	var $quantity;			
	var $market;			
	var $location;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $pricingsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->category=str_replace("'","\'",$obj->category);
		$this->item=str_replace("'","\'",$obj->item);
		$this->price=str_replace("'","\'",$obj->price);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->market=str_replace("'","\'",$obj->market);
		$this->location=str_replace("'","\'",$obj->location);
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

	//get category
	function getCategory(){
		return $this->category;
	}
	//set category
	function setCategory($category){
		$this->category=$category;
	}

	//get item
	function getItem(){
		return $this->item;
	}
	//set item
	function setItem($item){
		$this->item=$item;
	}

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get market
	function getMarket(){
		return $this->market;
	}
	//set market
	function setMarket($market){
		$this->market=$market;
	}

	//get location
	function getLocation(){
		return $this->location;
	}
	//set location
	function setLocation($location){
		$this->location=$location;
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

	function add($obj){
	
	//add new fields
		$pricingcreatedelete=new Pricingcreatedelete();
		$where=" where status='Active' ";
		$fields="group_concat(prices_pricingcreatedelete.fieldname separator ',') fieldname";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$pricingcreatedelete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$pricingcreatedelete = $pricingcreatedelete->fetchObject;
    
		if(!empty($pricingcreatedelete->fieldname))
		  $obj->newfields=",".$pricingcreatedelete->fieldname;
		
		$pricingcreatedelete=new Pricingcreatedelete();
		$where=" where status='Active' ";
		//$fields="group_concat(concat('`$"."obj->',prices_pricingcreatedelete.fieldname),'`') fieldname";
		$fields=" fieldname ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$pricingcreatedelete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res = $pricingcreatedelete = $pricingcreatedelete->result;
		
		$obj->newvals="";
		while($row=mysql_fetch_object($res)){		  
		    $obj->newvals.=",'".$_POST['$pricingcreatedelete->fieldname']."'";
		 }
		
		$pricingsDBO = new PricingsDBO();
		if($pricingsDBO->persist($obj)){
			$this->id=$pricingsDBO->id;
			$this->sql=$pricingsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$pricingsDBO = new PricingsDBO();
		if($pricingsDBO->update($obj,$where)){
			$this->sql=$pricingsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$pricingsDBO = new PricingsDBO();
		if($pricingsDBO->delete($obj,$where=""))		
			$this->sql=$pricingsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$pricingsDBO = new PricingsDBO();
		$this->table=$pricingsDBO->table;
		$pricingsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$pricingsDBO->sql;
		$this->result=$pricingsDBO->result;
		$this->fetchObject=$pricingsDBO->fetchObject;
		$this->affectedRows=$pricingsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
