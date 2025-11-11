<?php 
require_once("ReturninwardsDBO.php");
require_once("../../../modules/pos/returninwarddetails/ReturninwarddetailsDBO.php");
require_once("../../../modules/pos/returninwardconsumables/ReturninwardconsumablesDBO.php");
class Returninwards
{				
	var $id;			
	var $documentno;
	var $creditnoteno;
	var $creditnotenos;
	var $types;
	var $packingno;	
	var $invoiceno;
	var $customerid;			
	var $agentid;	
	var $currencyid;
	var $vatable;
	var $type;
	var $vat;
	var $exchangerate;
	var $exchangerate2;
	var $remarks;
	var $returnedon;	
	var $soldon;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $returninwardsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->creditnoteno=str_replace("'","\'",$obj->creditnoteno);
		$this->creditnotenos=str_replace("'","\'",$obj->creditnotenos);
		$this->invoiceno=str_replace("'","\'",$obj->invoiceno);
		$this->types=str_replace("'","\'",$obj->types);
		$this->packingno=str_replace("'","\'",$obj->packingno);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		$this->currencyid=$obj->currencyid;
		$this->vat=$obj->vat;
		$this->type=str_replace("'","\'",$obj->type);
		$this->vatable=$obj->vatable;
		$this->exchangerate=$obj->exchangerate;
		$this->exchangerate2=$obj->exchangerate2;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->returnedon=str_replace("'","\'",$obj->returnedon);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get packingno
	function getPackingno(){
		return $this->packingno;
	}
	//set packingno
	function setPackingno($packingno){
		$this->packingno=$packingno;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}
	
	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}



	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get soldon
	function getSoldon(){
		return $this->soldon;
	}
	//set soldon
	function setSoldon($soldon){
		$this->soldon=$soldon;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj,$shop,$shp){//print_r($shop);
		$returninwardsDBO = new ReturninwardsDBO();
			if($returninwardsDBO->persist($obj)){
			
				
				$returninwarddetails = new Returninwarddetails();
				$obj->returninwardid=$returninwardsDBO->id;
				$returninwarddetails->add($obj,$shop);
				
				$returninwardconsumables = new Returninwardconsumables();
				$obj->returninwardid=$returninwardsDBO->id;
				$returninwardconsumables->add($obj,$shp);
				
				$this->id=$returninwardsDBO->id;
				$this->sql=$returninwardsDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$shop,$shp){
	
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='returninwards'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		mysql_query("delete from pos_returninwarddetails where returninwardid in(select id from pos_returninwards where documentno='$obj->documentno')");
		
		$query="delete from pos_returninwardconsumables where returninwardid in(select id from pos_returninwards where documentno='$obj->documentno')";
		
		mysql_query($query);
		
		mysql_query("delete from pos_returninwards where documentno='$obj->documentno'");
		mysql_query("delete from fn_generaljournals where documentno='$obj->documentno' and transactionid='$transaction->id'");
		
		if($this->add($obj,$shop,$shp)){
		  return true;	
		}
		
	}			
	function delete($obj,$where=""){			
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='returninwards'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		mysql_query("delete from pos_returninwarddetails where returninwardid in(select id from pos_returninwards where documentno='$obj->documentno')");
		$query="delete from pos_returninwardconsumables where returninwardid in(select id from pos_returninwards where documentno='$obj->documentno')";
		
		mysql_query($query);
		
		mysql_query("delete from pos_returninwards where documentno='$obj->documentno'");		
		
		mysql_query("delete from fn_generaljournals where documentno='$obj->documentno' and transactionid='$transaction->id'");
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returninwardsDBO = new ReturninwardsDBO();
		$this->table=$returninwardsDBO->table;
		$returninwardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returninwardsDBO->sql;
		$this->result=$returninwardsDBO->result;
		$this->fetchObject=$returninwardsDBO->fetchObject;
		$this->affectedRows=$returninwardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}else if(empty($obj->saletypeid)){
			$error="Sale Type should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro Rate should be provided";
		}
		else if(empty($obj->type)){
			$error="Type should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}else if(empty($obj->saletypeid)){
			$error="Sale Type should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro Rate should be provided";
		}
		else if(empty($obj->type)){
			$error="Type should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
