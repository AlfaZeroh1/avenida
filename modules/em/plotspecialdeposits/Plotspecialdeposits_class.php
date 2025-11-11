<?php 
require_once("PlotspecialdepositsDBO.php");
class Plotspecialdeposits
{				
	var $id;			
	var $plotid;			
	var $paymenttermid;			
	var $amount;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $plotspecialdepositsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->plotid=str_replace("'","\'",$obj->plotid);
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
	}

	//get paymenttermid
	function getPaymenttermid(){
		return $this->paymenttermid;
	}
	//set paymenttermid
	function setPaymenttermid($paymenttermid){
		$this->paymenttermid=$paymenttermid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$plotspecialdepositsDBO = new PlotspecialdepositsDBO();
		if($plotspecialdepositsDBO->persist($obj)){
			$this->id=$plotspecialdepositsDBO->id;
			$this->sql=$plotspecialdepositsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$plotspecialdepositsDBO = new PlotspecialdepositsDBO();
		if($plotspecialdepositsDBO->update($obj,$where)){
			$this->sql=$plotspecialdepositsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$plotspecialdepositsDBO = new PlotspecialdepositsDBO();
		if($plotspecialdepositsDBO->delete($obj,$where=""))		
			$this->sql=$plotspecialdepositsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plotspecialdepositsDBO = new PlotspecialdepositsDBO();
		$this->table=$plotspecialdepositsDBO->table;
		$plotspecialdepositsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plotspecialdepositsDBO->sql;
		$this->result=$plotspecialdepositsDBO->result;
		$this->fetchObject=$plotspecialdepositsDBO->fetchObject;
		$this->affectedRows=$plotspecialdepositsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
