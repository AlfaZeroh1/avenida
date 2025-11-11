<?php 
require_once("InwardsDBO.php");
// require_once("../inwarddetails/InwarddetailsDBO.php");
class Inwards
{				
	var $id;			
	var $documentno;			
	var $deliverynoteno;
	var $inwardno;
	var $lpono;
	var $projectid;			
	var $supplierid;
	var $currencyid;
	var $rate;
	var $eurorate;
	var $inwarddate;			
	var $remarks;			
	var $file;	
	var $status;
	var $journals;
	var $jvno;
	var $type;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $inwardsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->deliverynoteno=str_replace("'","\'",$obj->deliverynoteno);
		$this->inwardno=str_replace("'","\'",$obj->inwardno);
		$this->lpono=str_replace("'","\'",$obj->lpono);
		
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->eurorate=str_replace("'","\'",$obj->eurorate);
		
		$this->inwarddate=str_replace("'","\'",$obj->inwarddate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->journals=str_replace("'","\'",$obj->journals);
		$this->jvno=str_replace("'","\'",$obj->jvno);
		$this->type=str_replace("'","\'",$obj->type);
		$this->file=str_replace("'","\'",$obj->file);
		$this->status=$obj->status;
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get deliverynoteno
	function getDeliverynoteno(){
		return $this->deliverynoteno;
	}
	//set deliverynoteno
	function setDeliverynoteno($deliverynoteno){
		$this->deliverynoteno=$deliverynoteno;
	}

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get inwarddate
	function getInwarddate(){
		return $this->inwarddate;
	}
	//set inwarddate
	function setInwarddate($inwarddate){
		$this->inwarddate=$inwarddate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
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

	function add($obj,$shop,$bool){
		$inwardsDBO = new InwardsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$inwardsDBO = new InwardsDBO();
		$inwards=new Inwards();
			$ob = $inwards->setObject($obj);
			$ob->effectjournals=$obj->effectjournals;
			if($inwardsDBO->persist($ob)){		
				$inwarddetails = new Inwarddetails();
				$obj->inwardid=$inwardsDBO->id;
				$inwarddetails->add($obj,$shop,$bool);

				//add record to projectstocks and affect stocktrack
				
				
				
				//$this->id=$inwardsDBO->id;
				$this->sql=$inwardsDBO->sql;
				
				return true;
			}else{
			return false;
			}

			
	}			
	function edit($obj,$where="",$shop,$bool){
		$inwardsDBO = new InwardsDBO();

				//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='inward'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$inwarddetails = new Inwarddetails();
		$fields="*";
		$where=" where inwardid=(select id from proc_inwards where documentno='$obj->documentno') ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$inwarddetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $inwarddetails->sql;
		while($row=mysql_fetch_object($inwarddetails->result)){ 
			$stocktrack = new Stocktrack();
			$ob=$row;
			$ob->recorddate=$obj->inwarddate;
			$ob->documentno=$obj->documentno;
			$ob->transaction="GRN UPDATE";
			$stocktrack->reduceStock($ob);
		}	
		
		$inwarddetails = new Inwarddetails();
		$where=" where inwardid=(select id from proc_inwards where documentno='$obj->documentno') ";
		$inwarddetails->delete($obj,$where);
		
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$inwardsDBO->delete($obj,$where);		

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->documentno' and transactionid='$transaction->id' ";
		$gn->delete($obj,$where);
                
                $inwards=new Inwards();
		if($inwards->add($obj,$shop,$bool)){ 
		  return true;	
		  }
	}			
	function delete($obj,$where=""){			
		$inwardsDBO = new InwardsDBO();
		if($inwardsDBO->delete($obj,$where))		
			$this->sql=$inwardsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$inwardsDBO = new InwardsDBO();
		$this->table=$inwardsDBO->table;
		$inwardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby); 		
		$this->sql=$inwardsDBO->sql;
		$this->result=$inwardsDBO->result;
		$this->fetchObject=$inwardsDBO->fetchObject;
		$this->affectedRows=$inwardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Inward Note No should be provided";
		}else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->inwarddate)){
			$error="Inward Date should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->rate)){
			$error="Rate should be provided";
		}else if(empty($obj->eurorate)){
			$error="Euro Rate should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Inward Note No should be provided";
		}else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->inwarddate)){
			$error="Inward Date should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->rate)){
			$error="Rate should be provided";
		}else if(empty($obj->eurorate)){
			$error="Euro Rate should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
