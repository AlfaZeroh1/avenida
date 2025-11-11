<?php 
require_once("InwarddetailsDBO.php");
class Inwarddetails
{				
	var $id;			
	var $inwardid;			
	var $itemid;			
	var $quantity;			
	var $costprice;			
	var $total;			
	var $memo;
	var $status;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $inwarddetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->inwardid))
			$obj->inwardid='NULL';
		$this->inwardid=$obj->inwardid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->total=str_replace("'","\'",$obj->total);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get inwardid
	function getInwardid(){
		return $this->inwardid;
	}
	//set inwardid
	function setInwardid($inwardid){
		$this->inwardid=$inwardid;
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
		$inwarddetailsDBO = new InwarddetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			if($shop[$i]['id']){
			  $obj->remarks=$shop[$i]['remarks'];
			  $obj->itemid=$shop[$i]['itemid'];
			  $obj->itemname=$shop[$i]['itemname'];
			  $obj->costprice=$shop[$i]['costprice'];
			  $obj->tradeprice=$shop[$i]['tradeprice'];
			  $obj->quantity=$shop[$i]['quantity'];
			  $obj->total=$shop[$i]['total'];
			  if($inwarddetailsDBO->persist($obj)){	
			  
				  $stocktrack = new Stocktrack();
				  $obj->recorddate=$obj->inwarddate;
				  $obj->transaction="GRN";
				  $stocktrack->addStock($obj);
				  
				  $this->id=$inwarddetailsDBO->id;
				  $this->sql=$inwarddetailsDBO->sql;
			  }
			}
			$i++;
		}			

		return true;	
	}			
	function edit($obj,$where=""){
		$inwarddetailsDBO = new InwarddetailsDBO();
		if($inwarddetailsDBO->update($obj,$where)){
			$this->sql=$inwarddetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$inwarddetailsDBO = new InwarddetailsDBO();
		if($inwarddetailsDBO->delete($obj,$where=""))		
			$this->sql=$inwarddetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$inwarddetailsDBO = new InwarddetailsDBO();
		$this->table=$inwarddetailsDBO->table;
		$inwarddetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$inwarddetailsDBO->sql;
		$this->result=$inwarddetailsDBO->result;
		$this->fetchObject=$inwarddetailsDBO->fetchObject;
		$this->affectedRows=$inwarddetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->inwardid)){
			$error="Inward should be provided";
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
