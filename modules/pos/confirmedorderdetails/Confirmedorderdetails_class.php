<?php 
require_once("ConfirmedorderdetailsDBO.php");
class Confirmedorderdetails
{				
	var $id;			
	var $itemid;			
	var $quantity;	
	var $packrate;
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $confirmedorderid;			
	var $sizeid;			
	var $confirmedorderdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->packrate=str_replace("'","\'",$obj->packrate);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		if(empty($obj->confirmedorderid))
			$obj->confirmedorderid='NULL';
		$this->confirmedorderid=$obj->confirmedorderid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
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

	//get confirmedorderid
	function getConfirmedorderid(){
		return $this->confirmedorderid;
	}
	//set confirmedorderid
	function setConfirmedorderid($confirmedorderid){
		$this->confirmedorderid=$confirmedorderid;
	}

	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}

	function add($obj,$shop){
		$confirmedorderdetailsDBO = new ConfirmedorderdetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->itemid=$shop[$i]['itemid'];
			$obj->sizeid=$shop[$i]['sizeid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->packrate=$shop[$i]['packrate'];
			$obj->memo=$shop[$i]['memo'];
			if($confirmedorderdetailsDBO->persist($obj)){		
				$this->id=$confirmedorderdetailsDBO->id;
				$this->sql=$confirmedorderdetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$confirmedorderdetailsDBO = new ConfirmedorderdetailsDBO();
		if($confirmedorderdetailsDBO->update($obj,$where)){
			$this->sql=$confirmedorderdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$confirmedorderdetailsDBO = new ConfirmedorderdetailsDBO();
		if($confirmedorderdetailsDBO->delete($obj,$where=""))		
			$this->sql=$confirmedorderdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$confirmedorderdetailsDBO = new ConfirmedorderdetailsDBO();
		$this->table=$confirmedorderdetailsDBO->table;
		$confirmedorderdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$confirmedorderdetailsDBO->sql;
		$this->result=$confirmedorderdetailsDBO->result;
		$this->fetchObject=$confirmedorderdetailsDBO->fetchObject;
		$this->affectedRows=$confirmedorderdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->confirmedorderid)){
			$error="Confirmed Order should be provided";
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
