<?php 
require_once("ReturnoutwardsDBO.php");
class Returnoutwards
{				
	var $id;			
	var $supplierid;			
	var $documentno;			
	var $creditnoteno;			
	var $mode;			
	var $itemid;			
	var $quantity;			
	var $costprice;			
	var $tradeprice;			
	var $tax;			
	var $discount;			
	var $total;			
	var $returnedon;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $returnoutwardsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->creditnoteno=str_replace("'","\'",$obj->creditnoteno);
		$this->mode=str_replace("'","\'",$obj->mode);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get creditnoteno
	function getCreditnoteno(){
		return $this->creditnoteno;
	}
	//set creditnoteno
	function setCreditnoteno($creditnoteno){
		$this->creditnoteno=$creditnoteno;
	}

	//get mode
	function getMode(){
		return $this->mode;
	}
	//set mode
	function setMode($mode){
		$this->mode=$mode;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get returnedon
	function getReturnedon(){
		return $this->returnedon;
	}
	//set returnedon
	function setReturnedon($returnedon){
		$this->returnedon=$returnedon;
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
		$returnoutwardsDBO = new ReturnoutwardsDBO();
			if($returnoutwardsDBO->persist($obj)){		
				$this->id=$returnoutwardsDBO->id;
				$this->sql=$returnoutwardsDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$returnoutwardsDBO = new ReturnoutwardsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$returnoutwardsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			$total+=$obj->total;

			$obj->itemid=$shop['itemid'];
			$obj->itemname=$shop['itemname'];
			$obj->code=$shop['code'];
			$obj->tax=$shop['tax'];
			$obj->discount=$shop['discount'];
			$obj->costprice=$shop['costprice'];
			$obj->tradeprice=$shop['tradeprice'];
			$obj->quantity=$shop['quantity'];
			if($returnoutwardsDBO->update($obj,$where)){
				$this->sql=$returnoutwardsDBO->sql;
			}
		}

				//Make a journal entry

				//retrieve account to debit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->supplierid' and acctypeid='30'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

				//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='1' and acctypeid='28'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

				//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='returnoutwards'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;

		$ob->transactdate=$obj->returnedon;

				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$returnoutwards->id;
		$ob->documentno="$obj->creditnoteno";
		$ob->remarks="Returns on Credit note No: $obj->creditnoteno ($obj->documentno)";
		$ob->memo=$returnoutwards->remarks;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$total;
		$ob->credit=0;
		$generaljournal->setObject($ob);
		$generaljournal->add($generaljournal);

				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$returnoutwards->id;
		$ob->documentno=$obj->creditnoteno;
		$ob->remarks="Credit note No: $obj->creditnoteno ($obj->documentno) to $obj->suppliername";
		$ob->memo=$returnoutwards->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->credit=$total;
		$ob->did=$generaljournal->id;
		$generaljournal2->setObject($ob);
		$generaljournal2->add($generaljournal2);

		$generaljournal->did=$generaljournal2->id;
		$generaljournal->edit($generaljournal);

		return true;	
	}			
	function delete($obj,$where=""){			
		$returnoutwardsDBO = new ReturnoutwardsDBO();
		if($returnoutwardsDBO->delete($obj,$where=""))		
			$this->sql=$returnoutwardsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returnoutwardsDBO = new ReturnoutwardsDBO();
		$this->table=$returnoutwardsDBO->table;
		$returnoutwardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returnoutwardsDBO->sql;
		$this->result=$returnoutwardsDBO->result;
		$this->fetchObject=$returnoutwardsDBO->fetchObject;
		$this->affectedRows=$returnoutwardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Receipt/Invoice No should be provided";
		}
		else if(empty($obj->mode)){
			$error="Purchase Mode should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->returnedon)){
			$error="Returned On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Receipt/Invoice No should be provided";
		}
		else if(empty($obj->mode)){
			$error="Purchase Mode should be provided";
		}
		else if(empty($obj->returnedon)){
			$error="Returned On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
