<?php 
require_once("CustomerpricesDBO.php");
class Customerprices
{				
	var $id;			
	var $customerid;			
	var $seasonid;			
	var $categoryid;			
	var $sizeid;			
	var $price;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $customerpricesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->seasonid))
			$obj->seasonid='NULL';
		$this->seasonid=$obj->seasonid;
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		$this->price=str_replace("'","\'",$obj->price);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get seasonid
	function getSeasonid(){
		return $this->seasonid;
	}
	//set seasonid
	function setSeasonid($seasonid){
		$this->seasonid=$seasonid;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$customerpricesDBO = new CustomerpricesDBO();
		if($customerpricesDBO->persist($obj)){
			$this->id=$customerpricesDBO->id;
			$this->sql=$customerpricesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$customerpricesDBO = new CustomerpricesDBO();
		if($customerpricesDBO->update($obj,$where)){
			$this->sql=$customerpricesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$customerpricesDBO = new CustomerpricesDBO();
		if($customerpricesDBO->delete($obj,$where=""))		
			$this->sql=$customerpricesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$customerpricesDBO = new CustomerpricesDBO();
		$this->table=$customerpricesDBO->table;
		$customerpricesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$customerpricesDBO->sql;
		$this->result=$customerpricesDBO->result;
		$this->fetchObject=$customerpricesDBO->fetchObject;
		$this->affectedRows=$customerpricesDBO->affectedRows;
	}	
	function getPrices($customerid,$itemid,$sizeid,$seasonid){
	  $customerprices = new Customerprices();
	  $fields="*";
	  $join=" ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where customerid='$customerid' and categoryid in (select categoryid from pos_items where id=$itemid) and sizeid='$sizeid' and seasonid='$seasonid'";
	  $customerprices->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $customerprices->sql;
	  $res=$customerprices->result;
	  return $customerprices->fetchObject;
	}
	function validate($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->seasonid)){
			$error="Season should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
