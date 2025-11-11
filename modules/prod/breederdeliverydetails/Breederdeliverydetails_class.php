<?php 
require_once("BreederdeliverydetailsDBO.php");
class Breederdeliverydetails
{				
	var $id;			
	var $breederdeliveryid;			
	var $varietyid;			
	var $quantity;			
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $breederdeliverydetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->breederdeliveryid))
			$obj->breederdeliveryid='NULL';
		$this->breederdeliveryid=$obj->breederdeliveryid;
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
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

	//get breederdeliveryid
	function getBreederdeliveryid(){
		return $this->breederdeliveryid;
	}
	//set breederdeliveryid
	function setBreederdeliveryid($breederdeliveryid){
		$this->breederdeliveryid=$breederdeliveryid;
	}

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
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
		$breederdeliverydetailsDBO = new BreederdeliverydetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->varietyid=$shop[$i]['varietyid'];
			$obj->varietyname=$shop[$i]['varietyname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->memo=$shop[$i]['memo'];
			if($breederdeliverydetailsDBO->persist($obj)){		
				$this->id=$breederdeliverydetailsDBO->id;
				$this->sql=$breederdeliverydetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$breederdeliverydetailsDBO = new BreederdeliverydetailsDBO();
		if($breederdeliverydetailsDBO->update($obj,$where)){
			$this->sql=$breederdeliverydetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$breederdeliverydetailsDBO = new BreederdeliverydetailsDBO();
		if($breederdeliverydetailsDBO->delete($obj,$where=""))		
			$this->sql=$breederdeliverydetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$breederdeliverydetailsDBO = new BreederdeliverydetailsDBO();
		$this->table=$breederdeliverydetailsDBO->table;
		$breederdeliverydetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$breederdeliverydetailsDBO->sql;
		$this->result=$breederdeliverydetailsDBO->result;
		$this->fetchObject=$breederdeliverydetailsDBO->fetchObject;
		$this->affectedRows=$breederdeliverydetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->breederdeliveryid)){
			$error="Breeder Delivery should be provided";
		}
		else if(empty($obj->varietyid)){
			$error="Variety should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->breederdeliveryid)){
			$error="Breeder Delivery should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
