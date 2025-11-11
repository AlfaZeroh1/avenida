<?php 
require_once("SalesDBO.php");
class Sales
{				
	var $id;			
	var $documentno;			
	var $projectid;			
	var $customerid;			
	var $agentid;	
	var $exchangerate;
	var $currencyid;
	var $exchangerate2;
	var $employeeid;			
	var $remarks;			
	var $mode;			
	var $soldon;			
	var $expirydate;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $salesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->agentid))
			$obj->agentid='NULL';
		$this->agentid=$obj->agentid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->mode=str_replace("'","\'",$obj->mode);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
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

	//get mode
	function getMode(){
		return $this->mode;
	}
	//set mode
	function setMode($mode){
		$this->mode=$mode;
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
		$salesDBO = new SalesDBO();
			if($salesDBO->persist($obj)){		
				$saledetails = new Saledetails();
				$obj->saleid=$salesDBO->id;
				$saledetails->add($obj,$shop);
				
				

				$this->id=$salesDBO->id;
				$this->sql=$salesDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='sales'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		mysql_query("delete from pos_saledetails where saleid in(select id from pos_sales where documentno='$obj->documentno')");
		mysql_query("delete from pos_sales where documentno='$obj->documentno'");
		mysql_query("delete from fn_generaljournals where documentno='$obj->documentno' and transactionid='$transaction->id' and remarks like '%Local Sale%'");
		
		 
		
		if($this->add($obj,$shop)){
		  return true;	
		}
	}			
	function delete($obj,$where=""){			
		$salesDBO = new SalesDBO();
		if($salesDBO->delete($obj,$where=""))		
			$this->sql=$salesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$salesDBO = new SalesDBO();
		$this->table=$salesDBO->table;
		$salesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$salesDBO->sql;
		$this->result=$salesDBO->result;
		$this->fetchObject=$salesDBO->fetchObject;
		$this->affectedRows=$salesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}
		else if(empty($obj->soldon)){
			$error="Date of Sale Must be provided";
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
		else if(empty($obj->soldon)){
			$error="Date of Sale Must be provided";
			}
		
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
