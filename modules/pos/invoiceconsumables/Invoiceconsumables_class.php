<?php 
require_once("InvoiceconsumablesDBO.php");
class Invoiceconsumables
{				
	var $id;	
	var $invoiceid;
	var $itemid;			
	var $unitofmeasureid;			
	var $quantity;			
	var $price;			
	var $total;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $invoiceconsumablesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->invoiceid=str_replace("'","\'",$obj->invoiceid);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->price=str_replace("'","\'",$obj->price);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get unitofmeasureid
	function getUnitofmeasureid(){
		return $this->unitofmeasureid;
	}
	//set unitofmeasureid
	function setUnitofmeasureid($unitofmeasureid){
		$this->unitofmeasureid=$unitofmeasureid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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

	function add($obj,$shop){
		$invoiceconsumablesDBO = new InvoiceconsumablesDBO();
		$num=count($shop);
		if($num>0){
		  $i=0;
		  $total=0;
		  while($i<$num){
		  $obj->id="";
			  $obj->itemid=$shop[$i]['itemid'];
			  $obj->unitofmeasureid=$shop[$i]['unitofmeasureid'];
			  $obj->itemname=$shop[$i]['itemname'];
			  $obj->quantity=$shop[$i]['quantity'];
			  $obj->price=$shop[$i]['price'];
			  $obj->total=$shop[$i]['total'];
			  
			  $objs = $this->setObject($obj);
			  if($invoiceconsumablesDBO->persist($objs)){		
				  $this->id=$invoiceconsumablesDBO->id;
				  $this->sql=$invoiceconsumablesDBO->sql;
			  }
			  
			  $total+=$obj->total;
			  $i++;
		  }
		  
		  //make journal entry to debit client and sales account
				  //Make a journal entry

				  //retrieve account to debit
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$obj->customerid' and acctypeid='29'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //retrieve account to credit
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='1' and acctypeid='25'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

				  //Get transaction Identity
		  $transaction = new Transactions();
		  $fields="*";
		  $where=" where lower(replace(name,' ',''))='sales'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $transaction=$transaction->fetchObject;

		  $it=0;

		  $ob->transactdate=$obj->soldon;
		  $ob->rate=$obj->exchangerate2;
		  $ob->eurorate=$obj->exchangerate;
		  $ob->currencyid=$obj->currencyid;

				  //make debit entry
		  $generaljournal = new Generaljournals();
		  $ob->tid=$saledetails->id;
		  $ob->documentno="$obj->documentno";
		  $ob->remarks="$obj->code$obj->Invoiceno";
		  $ob->memo=$obj->customername;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->daccountid=$generaljournalaccounts2->id;
		  $ob->transactionid=$transaction->id;
		  $ob->mode="credit";
		  $ob->debit=$total;
		  $ob->credit=0;
		  $ob->debiteuro=$total;
		  $ob->crediteuro=0;
		  $ob->debitorig=$total;
		  $ob->creditorig=0;
		  $ob->class=$obj->projectid;
		  $ob->transactdate=$obj->soldon;
		  $generaljournal->setObject($ob);

		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		  $it++;


				  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->tid=$saledetails->id;
		  $ob->documentno=$obj->documentno;
		  $ob->remarks="$obj->code$obj->Invoiceno";
		  $ob->memo=$obj->customername;
		  $ob->daccountid=$generaljournalaccounts->id;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->transactionid=$transaction->id;
		  $ob->mode="credit";
		  $ob->debit=0;
		  $ob->class=$obj->projectid;
		  $ob->credit=$total;		
		  $ob->crediteuro=$total;
		  $ob->debiteuro=0;
		  $ob->creditorig=$total;
		  $ob->debitorig=0;
		  $ob->transactdate=$obj->soldon;
		  $generaljournal2->setObject($ob);
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");

		  $gn= new Generaljournals();
		  $gn->add($obj,$shpgeneraljournals);
		}
		return true;
	}			
	function edit($obj,$where=""){
		$invoiceconsumablesDBO = new InvoiceconsumablesDBO();
		if($invoiceconsumablesDBO->update($obj,$where)){
			$this->sql=$invoiceconsumablesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$invoiceconsumablesDBO = new InvoiceconsumablesDBO();
		if($invoiceconsumablesDBO->delete($obj,$where=""))		
			$this->sql=$invoiceconsumablesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$invoiceconsumablesDBO = new InvoiceconsumablesDBO();
		$this->table=$invoiceconsumablesDBO->table;
		$invoiceconsumablesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$invoiceconsumablesDBO->sql;
		$this->result=$invoiceconsumablesDBO->result;
		$this->fetchObject=$invoiceconsumablesDBO->fetchObject;
		$this->affectedRows=$invoiceconsumablesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Consumable should be provided";
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
