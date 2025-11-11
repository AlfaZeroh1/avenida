<?php 
require_once("SaleordersDBO.php");
class Saleorders
{				
	var $id;			
	var $documentno;			
	var $customerid;			
	var $agentid;			
	var $employeeid;			
	var $remarks;			
	var $soldon;			
	var $expirydate;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $saleordersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->agentid))
			$obj->agentid='NULL';
		$this->agentid=$obj->agentid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->soldon=str_replace("'","\'",$obj->soldon);
		$this->expirydate=str_replace("'","\'",$obj->expirydate);
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

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
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

	//get expirydate
	function getExpirydate(){
		return $this->expirydate;
	}
	//set expirydate
	function setExpirydate($expirydate){
		$this->expirydate=$expirydate;
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

	function add($obj,$shop){
		$saleordersDBO = new SaleordersDBO();
			if($saleordersDBO->persist($obj)){		
				$this->id=$saleordersDBO->id;
				$this->sql=$saleordersDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$saleordersDBO = new SaleordersDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$saleordersDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->quantity=$shop['quantity'];
			$obj->itemid=$shop['itemid'];
			if($saleordersDBO->update($obj,$where)){
				$this->sql=$saleordersDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$saleordersDBO = new SaleordersDBO();
		if($saleordersDBO->delete($obj,$where=""))		
			$this->sql=$saleordersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$saleordersDBO = new SaleordersDBO();
		$this->table=$saleordersDBO->table;
		$saleordersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$saleordersDBO->sql;
		$this->result=$saleordersDBO->result;
		$this->fetchObject=$saleordersDBO->fetchObject;
		$this->affectedRows=$saleordersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}
		else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}
		else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
