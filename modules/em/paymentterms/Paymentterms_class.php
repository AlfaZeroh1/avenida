<?php 
require_once("PaymenttermsDBO.php");
class Paymentterms
{				
	var $id;			
	var $name;			
	var $type;			
	var $payabletolandlord;			
	var $generaljournalaccountid;			
	var $chargemgtfee;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $paymenttermsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->type=str_replace("'","\'",$obj->type);
		$this->payabletolandlord=str_replace("'","\'",$obj->payabletolandlord);
		if(empty($obj->generaljournalaccountid))
			$obj->generaljournalaccountid='NULL';
		$this->generaljournalaccountid=$obj->generaljournalaccountid;
		$this->chargemgtfee=str_replace("'","\'",$obj->chargemgtfee);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get payabletolandlord
	function getPayabletolandlord(){
		return $this->payabletolandlord;
	}
	//set payabletolandlord
	function setPayabletolandlord($payabletolandlord){
		$this->payabletolandlord=$payabletolandlord;
	}

	//get generaljournalaccountid
	function getGeneraljournalaccountid(){
		return $this->generaljournalaccountid;
	}
	//set generaljournalaccountid
	function setGeneraljournalaccountid($generaljournalaccountid){
		$this->generaljournalaccountid=$generaljournalaccountid;
	}

	//get chargemgtfee
	function getChargemgtfee(){
		return $this->chargemgtfee;
	}
	//set chargemgtfee
	function setChargemgtfee($chargemgtfee){
		$this->chargemgtfee=$chargemgtfee;
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
		$paymenttermsDBO = new PaymenttermsDBO();
		if($paymenttermsDBO->persist($obj)){
			$this->id=$paymenttermsDBO->id;
			$this->sql=$paymenttermsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$paymenttermsDBO = new PaymenttermsDBO();
		if($paymenttermsDBO->update($obj,$where)){
			$this->sql=$paymenttermsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$paymenttermsDBO = new PaymenttermsDBO();
		if($paymenttermsDBO->delete($obj,$where=""))		
			$this->sql=$paymenttermsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paymenttermsDBO = new PaymenttermsDBO();
		$this->table=$paymenttermsDBO->table;
		$paymenttermsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paymenttermsDBO->sql;
		$this->result=$paymenttermsDBO->result;
		$this->fetchObject=$paymenttermsDBO->fetchObject;
		$this->affectedRows=$paymenttermsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
