<?php 
require_once("PurchasesDBO.php");
class Purchases
{				
	var $id;
	var $vatclasseid;
	var $documentno;
	var $receiptno;
	var $lpono;
	var $jvno;
	var $storeid;			
	var $supplierid;			
	var $batchno;	
	var $currencyid;
	var $exchangerate;
	var $exchangerate2;
	var $remarks;	
	var $suppliername;
	var $accountid;
	var $purchasemodeid;	
	var $paymentmodeid;
	var $paymentcategoryid;
	var $bankid;
	var $employeeid;
	var $chequeno;
	var $transactionno;
	var $boughton;
	var $memo;
	var $balance;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $projectid;			
	var $purchasesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->receiptno=str_replace("'","\'",$obj->receiptno);
		$this->lpono=str_replace("'","\'",$obj->lpono);
		$this->jvno=str_replace("'","\'",$obj->jvno);
		if(empty($obj->storeid))
			$obj->storeid='NULL';
		$this->storeid=$obj->storeid;
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->batchno=str_replace("'","\'",$obj->batchno);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->memo=str_replace("'","\'",$obj->memo);
		if(empty($obj->purchasemodeid))
			$obj->purchasemodeid='NULL';
		$this->purchasemodeid=$obj->purchasemodeid;
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		
		if(empty($obj->paymentcategoryid))
			$obj->paymentcategoryid='NULL';
		$this->paymentcategoryid=$obj->paymentcategoryid;
		
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->transactionno=str_replace("'","\'",$obj->transactionno);
		
		$this->boughton=str_replace("'","\'",$obj->boughton);
		$this->vatclasseid=str_replace("'","\'",$obj->vatclasseid);
		$this->accountid=str_replace("'","\'",$obj->accountid);
		$this->balance=str_replace("'","\'",$obj->balance);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->suppliername=str_replace("'","\'",$obj->suppliername);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
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

	//get lpono
	function getLpono(){
		return $this->lpono;
	}
	//set lpono
	function setLpono($lpono){
		$this->lpono=$lpono;
	}
	
	//get receiptno
	function getReceiptno(){
		return $this->receiptno;
	}
	//set receiptno
	function setReceiptno($receiptno){
		$this->receiptno=$receiptno;
	}

	//get storeid
	function getStoreid(){
		return $this->storeid;
	}
	//set storeid
	function setStoreid($storeid){
		$this->storeid=$storeid;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get batchno
	function getBatchno(){
		return $this->batchno;
	}
	//set batchno
	function setBatchno($batchno){
		$this->batchno=$batchno;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get purchasemodeid
	function getPurchasemodeid(){
		return $this->purchasemodeid;
	}
	//set purchasemodeid
	function setPurchasemodeid($purchasemodeid){
		$this->purchasemodeid=$purchasemodeid;
	}

	//get boughton
	function getBoughton(){
		return $this->boughton;
	}
	//set boughton
	function setBoughton($boughton){
		$this->boughton=$boughton;
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	function add($obj,$shop){
		$purchasesDBO = new PurchasesDBO();
			$ob = $this->setObject($obj);
			$ob->effectjournals=$obj->effectjournals;
			if($purchasesDBO->persist($ob)){	
				$purchasedetails = new Purchasedetails();
				$obj->purchaseid=$purchasesDBO->id;
				
				$purchasedetails->add($obj,$shop);

				$this->id=$purchasesDBO->id;
				$this->sql=$purchasesDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$purchasesDBO = new PurchasesDBO();

				//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='purchases'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$purchasedetails = new Purchasedetails();
		$where=" where purchaseid=(select id from inv_purchases where documentno='$obj->documentno') ";
		$purchasedetails->delete($obj,$where);
		
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$purchasesDBO->delete($obj,$where);		

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->documentno' and transactionid='$transaction->id' ";
		$gn->delete($obj,$where);

		if($this->add($obj,$shop))
		  return true;	
	}			
	function delete($obj,$where=""){			
		$purchasesDBO = new PurchasesDBO();
		if($purchasesDBO->delete($obj,$where=""))		
			$this->sql=$purchasesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$purchasesDBO = new PurchasesDBO();
		$this->table=$purchasesDBO->table;
		$purchasesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$purchasesDBO->sql;
		$this->result=$purchasesDBO->result;
		$this->fetchObject=$purchasesDBO->fetchObject;
		$this->affectedRows=$purchasesDBO->affectedRows;
	}			
	function validate($obj){
		
			//retrieve account to debit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->supplierid' and acctypeid='30'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts->sql;
		$its=$generaljournalaccounts->affectedRows;
		
		if(empty($obj->boughton)){
			$error="Purchase Date should be provided";
		}elseif(empty($obj->documentno)){
			$error="Invoice/Receipt No should be provided";
		}elseif(empty($obj->accountid)){
			$error="Account to debit should be provided";
		}elseif(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}elseif(empty($obj->receiptno)){
			$error="Invoice/Receipt No should be provided";
		}
		elseif(empty($obj->purchasemodeid)){
			$error="Purchase Mode should be provided";
		}elseif(($obj->purchasemodeid==1) and empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}elseif(($obj->purchasemodeid==1) and ($obj->paymentmodeid==2 or $obj->paymentmodeid==5) and empty($obj->bankid)){
			$error="Bank should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro rate should be provided";
		}elseif($its==0){
		$error="Supplier Account does not exist! Talk to Finance Department.";
		}
// 		else if($generaljournalaccounts2->affectedRows==0){
// 			$error="Revenue Account do not exist! Talk to Finance Department.";
// 		}
		
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
	        	//retrieve account to debit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->supplierid' and acctypeid='30'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts->sql;
		$its=$generaljournalaccounts->affectedRows; 
		
		if(empty($obj->boughton)){
			$error="Purchase Date should be provided";
		}elseif(empty($obj->documentno)){
			$error="Invoice/Receipt No should be provided";
		}elseif(empty($obj->receiptno)){
			$error="Invoice/Receipt No should be provided";
		}
		elseif(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		elseif(empty($obj->memo)){
			$error="Remarks should be provided";
		}elseif(empty($obj->purchasemodeid)){
			$error="Purchase Mode should be provided";
		}elseif(($obj->purchasemodeid==1) and empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}elseif(($obj->purchasemodeid==1) and ($obj->paymentmodeid==2 or $obj->paymentmodeid==5) and empty($obj->bankid)){
			$error="Bank should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro rate should be provided";
		}elseif($its==0){
		$error="Supplier Account does not exist! Talk to Finance Department.";
		}

// 		else if($generaljournalaccounts2->affectedRows==0){
// 			$error="Revenue Account do not exist! Talk to Finance Department.";
// 		}
		
		if(!empty($error))
			return $error;
		else
			return null;
}	
}
?>
