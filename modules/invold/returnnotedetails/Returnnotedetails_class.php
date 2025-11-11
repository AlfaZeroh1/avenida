<?php 
require_once("ReturnnotedetailsDBO.php");
class Returnnotedetails
{				
	var $id;			
	var $returnnoteid;			
	var $itemid;			
	var $quantity;			
	var $costprice;			
	var $tax;			
	var $discount;			
	var $total;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $returnnotedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->returnnoteid))
			$obj->returnnoteid='NULL';
		$this->returnnoteid=$obj->returnnoteid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->discount=str_replace("'","\'",$obj->discount);
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

	//get returnnoteid
	function getReturnnoteid(){
		return $this->returnnoteid;
	}
	//set returnnoteid
	function setReturnnoteid($returnnoteid){
		$this->returnnoteid=$returnnoteid;
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

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
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
		$returnnotedetailsDBO = new ReturnnotedetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->remarks=$shop[$i]['remarks'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->costprice=$shop[$i]['costprice'];
			$obj->tax=$shop[$i]['tax'];
			$obj->discount=$shop[$i]['discount'];
			$obj->total=$shop[$i]['total'];
			if($returnnotedetailsDBO->persist($obj)){		
				$this->id=$returnnotedetailsDBO->id;
				$this->sql=$returnnotedetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$returnnotedetailsDBO = new ReturnnotedetailsDBO();
		if($returnnotedetailsDBO->update($obj,$where)){
			$this->sql=$returnnotedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$returnnotedetailsDBO = new ReturnnotedetailsDBO();
		if($returnnotedetailsDBO->delete($obj,$where=""))		
			$this->sql=$returnnotedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returnnotedetailsDBO = new ReturnnotedetailsDBO();
		$this->table=$returnnotedetailsDBO->table;
		$returnnotedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returnnotedetailsDBO->sql;
		$this->result=$returnnotedetailsDBO->result;
		$this->fetchObject=$returnnotedetailsDBO->fetchObject;
		$this->affectedRows=$returnnotedetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->returnnoteid)){
			$error="Return Note should be provided";
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
