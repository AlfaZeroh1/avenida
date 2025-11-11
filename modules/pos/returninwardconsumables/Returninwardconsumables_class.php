<?php 
require_once("ReturninwardconsumablesDBO.php");
class Returninwardconsumables
{				
	var $id;	
	var $currencyid;
	var $exchangerate;
	var $exchangerate2;
	var $documentno;
	var $returnedon;
	var $returninwardid;
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
	var $returninwardconsumablesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->returninwardid=str_replace("'","\'",$obj->returninwardid);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->price=str_replace("'","\'",$obj->price);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->returnedon=str_replace("'","\'",$obj->returnedon);
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
		$returninwardconsumablesDBO = new ReturninwardconsumablesDBO();
		$num=count($shop);//print_r($shop);
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
			  $obj->total=($shop[$i]['quantity']*$shop[$i]['price']);
			  
			  $obs = $this->setObject($obj);
			  if($returninwardconsumablesDBO->persist($obs)){		
				  $this->id=$returninwardconsumablesDBO->id;
				  $this->sql=$returninwardconsumablesDBO->sql;
			  }
			  
			  $total+=$obj->total;
			  $i++;
		  }
		  
		  //make journal entry to debit client and sales account
				  //Make a journal entry
		  
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

		  $obj->transactdate=$obj->returnedon;
		  $obj->rate=$obj->exchangerate;
		  $obj->eurorate=$obj->exchangerate2;
		  $obj->currencyid=$obj->currencyid;

                  if($obj->types=="credit"){
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

				  //make debit entry
		  $generaljournal = new Generaljournals();
		  $ob->tid=$saledetails->id;
		  $ob->documentno="$obj->documentno";
		  $ob->remarks="Invoice $obj->creditnotenos";
		  $ob->memo=$saledetails->remarks;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->daccountid=$generaljournalaccounts->id;
		  $ob->transactionid=$transaction->id;
		  $ob->mode="credit";
		  $ob->debit=$total;
		  $ob->credit=0;
		  $ob->debiteuro=$total;
		  $ob->crediteuro=0;
		  $ob->debitorig=$total;
		  $ob->creditorig=0;
		  $ob->class=$obj->projectid;
		  $ob->transactdate=$obj->returnedon;
		  $generaljournal->setObject($ob);

		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		  $it++;


				  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->tid=$saledetails->id;
		  $ob->documentno=$obj->documentno;
		  $ob->remarks="Invoice $obj->creditnotenos to $obj->customername";
		  $ob->memo=$saledetails->remarks;
		  $ob->daccountid=$generaljournalaccounts2->id;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->transactionid=$transaction->id;
		  $ob->mode="credit";
		  $ob->debit=0;
		  $ob->class=$obj->projectid;
		  $ob->credit=$total;		
		  $ob->crediteuro=$total;
		  $ob->debiteuro=0;
		  $ob->creditorig=$total;
		  $ob->debitorig=0;
		  $ob->transactdate=$obj->returnedon;
		  $generaljournal2->setObject($ob);
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");
		  $it++;
             }else{
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

				  //make debit entry
		  $generaljournal = new Generaljournals();
		  $ob->tid=$saledetails->id;
		  $ob->documentno="$obj->documentno";
		  $ob->remarks="Invoice $obj->creditnotenos";
		  $ob->memo=$saledetails->remarks;
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
		  $ob->transactdate=$obj->returnedon;
		  $generaljournal->setObject($ob);

		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		  $it++;


				  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->tid=$saledetails->id;
		  $ob->documentno=$obj->documentno;
		  $ob->remarks="Invoice $obj->creditnotenos to $obj->customername";
		  $ob->memo=$saledetails->remarks;
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
		  $ob->transactdate=$obj->returnedon;
		  $generaljournal2->setObject($ob);
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");
		  $it++;
             
             }
		  $gn= new Generaljournals();print_r($shpgeneraljournals); 
		  $gn->add($obj,$shpgeneraljournals);
		}
		return true;
	}			
	function edit($obj,$where=""){
		$returninwardconsumablesDBO = new ReturninwardconsumablesDBO();
		if($returninwardconsumablesDBO->update($obj,$where)){
			$this->sql=$returninwardconsumablesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$returninwardconsumablesDBO = new ReturninwardconsumablesDBO();
		if($returninwardconsumablesDBO->delete($obj,$where=""))		
			$this->sql=$returninwardconsumablesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returninwardconsumablesDBO = new ReturninwardconsumablesDBO();
		$this->table=$returninwardconsumablesDBO->table;
		$returninwardconsumablesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returninwardconsumablesDBO->sql;
		$this->result=$returninwardconsumablesDBO->result;
		$this->fetchObject=$returninwardconsumablesDBO->fetchObject;
		$this->affectedRows=$returninwardconsumablesDBO->affectedRows;
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
