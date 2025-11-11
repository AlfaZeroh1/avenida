<?php 
require_once("CurrencyratesDBO.php");
class Currencyrates
{				
	var $id;			
	var $currencyid;			
	var $fromcurrencydate;			
	var $tocurrencydate;			
	var $rate;			
	var $eurorate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $currencyratesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		$this->fromcurrencydate=str_replace("'","\'",$obj->fromcurrencydate);
		$this->tocurrencydate=str_replace("'","\'",$obj->tocurrencydate);
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->eurorate=str_replace("'","\'",$obj->eurorate);
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

	//get currencyid
	function getCurrencyid(){
		return $this->currencyid;
	}
	//set currencyid
	function setCurrencyid($currencyid){
		$this->currencyid=$currencyid;
	}

	//get fromcurrencydate
	function getFromcurrencydate(){
		return $this->fromcurrencydate;
	}
	//set fromcurrencydate
	function setFromcurrencydate($fromcurrencydate){
		$this->fromcurrencydate=$fromcurrencydate;
	}

	//get tocurrencydate
	function getTocurrencydate(){
		return $this->tocurrencydate;
	}
	//set tocurrencydate
	function setTocurrencydate($tocurrencydate){
		$this->tocurrencydate=$tocurrencydate;
	}

	//get rate
	function getRate(){
		return $this->rate;
	}
	//set rate
	function setRate($rate){
		$this->rate=$rate;
	}

	//get eurorate
	function getEurorate(){
		return $this->eurorate;
	}
	//set eurorate
	function setEurorate($eurorate){
		$this->eurorate=$eurorate;
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
		$currencyratesDBO = new CurrencyratesDBO();
		if($currencyratesDBO->persist($obj)){
		
			$currencys = new Currencys();
			$fields="*";
			$where=" where id='$obj->currencyid' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$currencys = $currencys->fetchObject;
			
			$currencys->rate=$obj->rate;
			$currencys->eurorate=$obj->eurorate;
			
			$curr = new Currencys();
			$curr = $curr->setObject($currencys);
			$curr->edit($curr);
			
			$this->id=$currencyratesDBO->id;
			$this->sql=$currencyratesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$currencyratesDBO = new CurrencyratesDBO();
		if($currencyratesDBO->update($obj,$where)){
		
			$currencyrates = new Currencyrates();
			$fields="*";
			$where="  ";
			$join="";
			$having="";
			$groupby="";
			$orderby=" order by id desc ";
			$currencyrates->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$currencyrates = $currencyrates->fetchObject;
		
			if($currencyrates->id==$currencyratesDBO->id){
			  $currencys = new Currencys();
			  $fields="*";
			  $where=" where id='$obj->currencyid' ";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby=" order by id desc ";
			  $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $currencys = $currencys->fetchObject;
			  
			  $currencys->rate=$obj->rate;
			  $currencys->eurorate=$obj->eurorate;
			  
			  $curr = new Currencys();
			  $curr = $curr->setObject($currencys);
			  $curr->edit($curr);
			}
			
			$this->sql=$currencyratesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$currencyratesDBO = new CurrencyratesDBO();
		if($currencyratesDBO->delete($obj,$where=""))		
			$this->sql=$currencyratesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$currencyratesDBO = new CurrencyratesDBO();
		$this->table=$currencyratesDBO->table;
		$currencyratesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$currencyratesDBO->sql;
		$this->result=$currencyratesDBO->result;
		$this->fetchObject=$currencyratesDBO->fetchObject;
		$this->affectedRows=$currencyratesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}
		else if(empty($obj->fromcurrencydate)){
			$error="Currency Date From should be provided";
		}
		else if(empty($obj->tocurrencydate)){
			$error="Currency Date To should be provided";
		}
		else if(empty($obj->rate)){
			$error="Kshs. Rate should be provided";
		}
		else if(empty($obj->eurorate)){
			$error="Euro Rate should be provided";
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
