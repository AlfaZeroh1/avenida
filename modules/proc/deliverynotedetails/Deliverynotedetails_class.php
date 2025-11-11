<?php 
require_once("DeliverynotedetailsDBO.php");
class Deliverynotedetails
{				
	var $id;			
	var $deliverynoteid;			
	var $itemid;			
	var $quantity;			
	var $costprice;			
	var $total;			
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $deliverynotedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->deliverynoteid))
			$obj->deliverynoteid='NULL';
		$this->deliverynoteid=$obj->deliverynoteid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
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

	//get deliverynoteid
	function getDeliverynoteid(){
		return $this->deliverynoteid;
	}
	//set deliverynoteid
	function setDeliverynoteid($deliverynoteid){
		$this->deliverynoteid=$deliverynoteid;
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
		$deliverynotedetailsDBO = new DeliverynotedetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->remarks=$shop[$i]['remarks'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->costprice=$shop[$i]['costprice'];
			$obj->quantity=$shop[$i]['quantity'];
			if($deliverynotedetailsDBO->persist($obj)){
			
				$stocktrack = new Stocktrack();
				$stocktrack->addStock($obj);
				
				$this->id=$deliverynotedetailsDBO->id;
				$this->sql=$deliverynotedetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$deliverynotedetailsDBO = new DeliverynotedetailsDBO();
		if($deliverynotedetailsDBO->update($obj,$where)){
			$this->sql=$deliverynotedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$deliverynotedetailsDBO = new DeliverynotedetailsDBO();
		if($deliverynotedetailsDBO->delete($obj,$where=""))		
			$this->sql=$deliverynotedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$deliverynotedetailsDBO = new DeliverynotedetailsDBO();
		$this->table=$deliverynotedetailsDBO->table;
		$deliverynotedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$deliverynotedetailsDBO->sql;
		$this->result=$deliverynotedetailsDBO->result;
		$this->fetchObject=$deliverynotedetailsDBO->fetchObject;
		$this->affectedRows=$deliverynotedetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->deliverynoteid)){
			$error="Delivery Note should be provided";
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
