<?php 
require_once("BillofquantitiesDBO.php");
class Billofquantities
{				
	var $id;			
	var $tenderid;			
	var $bqitem;			
	var $quantity;			
	var $unitofmeasureid;			
	var $bqrate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $billofquantitiesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->tenderid))
			$obj->tenderid='NULL';
		$this->tenderid=$obj->tenderid;
		$this->bqitem=str_replace("'","\'",$obj->bqitem);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		$this->bqrate=str_replace("'","\'",$obj->bqrate);
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

	//get tenderid
	function getTenderid(){
		return $this->tenderid;
	}
	//set tenderid
	function setTenderid($tenderid){
		$this->tenderid=$tenderid;
	}

	//get bqitem
	function getBqitem(){
		return $this->bqitem;
	}
	//set bqitem
	function setBqitem($bqitem){
		$this->bqitem=$bqitem;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get unitofmeasureid
	function getUnitofmeasureid(){
		return $this->unitofmeasureid;
	}
	//set unitofmeasureid
	function setUnitofmeasureid($unitofmeasureid){
		$this->unitofmeasureid=$unitofmeasureid;
	}

	//get bqrate
	function getBqrate(){
		return $this->bqrate;
	}
	//set bqrate
	function setBqrate($bqrate){
		$this->bqrate=$bqrate;
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
		$billofquantitiesDBO = new BillofquantitiesDBO();
		if($billofquantitiesDBO->persist($obj)){
			$this->id=$billofquantitiesDBO->id;
			$this->sql=$billofquantitiesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$billofquantitiesDBO = new BillofquantitiesDBO();
		if($billofquantitiesDBO->update($obj,$where)){
			$this->sql=$billofquantitiesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$billofquantitiesDBO = new BillofquantitiesDBO();
		if($billofquantitiesDBO->delete($obj,$where=""))		
			$this->sql=$billofquantitiesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$billofquantitiesDBO = new BillofquantitiesDBO();
		$this->table=$billofquantitiesDBO->table;
		$billofquantitiesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$billofquantitiesDBO->sql;
		$this->result=$billofquantitiesDBO->result;
		$this->fetchObject=$billofquantitiesDBO->fetchObject;
		$this->affectedRows=$billofquantitiesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->tenderid)){
			$error="Tender should be provided";
		}
		else if(empty($obj->bqitem)){
			$error="Bill of Quantity should be provided";
		}
		else if(empty($obj->unitofmeasureid)){
			$error="Unit of Measure should be provided";
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
