<?php 
require_once("ReturninwarddetailsDBO.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
class Returninwarddetails
{				
	var $id;			
	var $returninwardid;			
	var $itemid;
	var $sizeid;
	var $mixedbox;
	var $item;
	var $quantity;			
	var $price;			
	var $discount;			
	var $tax;			
	var $bonus;			
	var $profit;			
	var $total;
	var $boxno;
	var $types;
	var $ipaddress;
	var $vatable;
	var $vat;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $returninwarddetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->returninwardid))
			$obj->returninwardid='NULL';
		$this->returninwardid=$obj->returninwardid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		$this->mixedbox=$obj->mixedbox;
		$this->item=$obj->item;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->price=str_replace("'","\'",$obj->price);
		$this->exportprice=str_replace("'","\'",$obj->exportprice);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->vatable=str_replace("'","\'",$obj->vatable);
		$this->vat=str_replace("'","\'",$obj->vat);
		$this->bonus=str_replace("'","\'",$obj->bonus);
		$this->profit=str_replace("'","\'",$obj->profit);
		$this->total=str_replace("'","\'",$obj->total);
		$this->boxno=str_replace("'","\'",$obj->boxno);
		$this->types=str_replace("'","\'",$obj->types);
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

	//get returninwardid
	function getReturninwardid(){
		return $this->returninwardid;
	}
	//set returninwardid
	function setReturninwardid($returninwardid){
		$this->returninwardid=$returninwardid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}
	
	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
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
	
	//get exportprice
	function getExportprice(){
		return $this->exportprice;
	}
	//set exportprice
	function setExportprice($exportprice){
		$this->exportprice=$exportprice;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get bonus
	function getBonus(){
		return $this->bonus;
	}
	//set bonus
	function setBonus($bonus){
		$this->bonus=$bonus;
	}

	//get profit
	function getProfit(){
		return $this->profit;
	}
	//set profit
	function setProfit($profit){
		$this->profit=$profit;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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

	function add($obj,$shop){//print_r($shop);
		$returninwarddetailsDBO = new ReturninwarddetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$totalvat=0;
		
		$obj->transactdate=$obj->returnedon;
		$obj->rate=$obj->exchangerate;
		$obj->eurorate=$obj->exchangerate2;
		$obj->currencyid=$obj->currencyid;
		if($obj->vatable=="Yes"){
		     $obj->vat=16;
		}else{
		    $obj->vat=0;
		}

		while($i<$num){
			$discount = 'discount'.$i;
			$exportprice = 'exportprice'.$i;
			
			$obj->itemid=$shop[$i]['itemid'];
			$obj->sizeid=$shop[$i]['sizeid'];
			$obj->mixedbox=$shop[$i]['mixedbox'];
			$obj->item=$shop[$i]['item'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->price=$shop[$i]['price'];
			$obj->discount=$obj->$discount;
			$obj->bonus=$shop[$i]['bonus'];
			$obj->tax=$shop[$i]['vat'];			
			$obj->total=($shop[$i]['quantity']*$shop[$i]['price'])*((100-$obj->discount)/100)*((100+$obj->vat)/100);
			$obj->vatamount=($shop[$i]['quantity']*$shop[$i]['price'])*($obj->vat/100);
			$obj->exportprice=$obj->$exportprice;
			$obj->boxno=$shop[$i]['boxno'];
			
			$ob = $this->setObject($obj);
			if($returninwarddetailsDBO->persist($ob)){		
				$this->id=$returninwarddetailsDBO->id;
				$this->sql=$returninwarddetailsDBO->sql;
			}
			
			$total+=$obj->total;
			$totalvat+=$obj->vatamount;
			$i++;
		}
		
		//make journal entry to debit client and sales account
				//Make a journal entry
		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='returninwards'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;

		$it=0;
		
		if($obj->types=="credit"){
				//retrieve account to debit
		    $generaljournalaccounts2 = new Generaljournalaccounts();
		    $fields="*";
		    $where=" where refid='$obj->customerid' and acctypeid='29'";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		    $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		    

				    //retrieve account to credit
		    $generaljournalaccounts = new Generaljournalaccounts();
		    $fields="*";
		    $where=" where acctypeid='27' and refid='$obj->saletypeid'";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		    $generaljournalaccounts=$generaljournalaccounts->fetchObject;
		    
		    if($totalvat>0){
				  
				  $vatclasses = new Vatclasses();
				  $fields="*";
				  $where=" where id='2'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $vatclasses=$vatclasses->fetchObject;
				  
				  $generaljournalacc = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$vatclasses->liabilityid' and acctypeid=35 ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalacc->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalacc=$generaljournalacc->fetchObject;
				  
				  //make debit entry
				  $generaljournal = new Generaljournals();
				  $ob->tid=$returninwards->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks=" Invoice $obj->creditnotenos";
				  $ob->memo="";
				  $ob->accountid=$generaljournalacc->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->debit=$totalvat;
				  $ob->credit=0;
				  $ob->class=$obj->projectid;
				  $generaljournal = $generaljournal->setObject($ob);

				  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				  
				  $it++;
				}
								//Get transaction Identity		
		
				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Credit Note $obj->creditnotenos to $obj->customername";
		$ob->memo=$saledetails->remarks;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$total-$totalvat;
		$ob->credit=0;
		$ob->debiteuro=$total-$totalvat;
		$ob->crediteuro=0;
		$ob->debitorig=$total-$totalvat;
		$ob->creditorig=0;
		$ob->class=$obj->projectid;
		$generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;


				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Credit Note $obj->creditnotenos";
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
		$generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");
		
		$it++;
		    
		}elseif($obj->types=='debit'){
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
		    $where=" where acctypeid='27' and refid='$obj->saletypeid'";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		    $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		    
		    if($totalvat>0){
				  
				  $vatclasses = new Vatclasses();
				  $fields="*";
				  $where=" where id='2'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $vatclasses=$vatclasses->fetchObject;
				  
				  $generaljournalacc = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$vatclasses->liabilityid' and acctypeid=35 ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalacc->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalacc=$generaljournalacc->fetchObject;
				  
				  //make debit entry
				  $generaljournal = new Generaljournals();
				  $ob->tid=$returninwards->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks=" Invoice $obj->creditnotenos";
				  $ob->memo="";
				  $ob->accountid=$generaljournalacc->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->debit=0;
				  $ob->credit=$totalvat;
				  $ob->class=$obj->projectid;
				  $generaljournal = $generaljournal->setObject($ob);

				  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				  
				  $it++;
				}
								//Get transaction Identity		
		
				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Debit Note $obj->creditnotenos to $obj->customername";
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
		$generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;


				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Debit Note $obj->creditnotenos";
		$ob->memo=$saledetails->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->class=$obj->projectid;
		$ob->credit=$total-$totalvat;		
		$ob->crediteuro=$total-$totalvat;
		$ob->debiteuro=0;
		$ob->creditorig=$total-$totalvat;
		$ob->debitorig=0;
		$generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");
		
		$it++;
		}
		$gn= new Generaljournals();//print_r($shpgeneraljournals);
		$gn->add($obj,$shpgeneraljournals);
		
		return true;	
	}			
	function edit($obj,$where=""){
		$returninwarddetailsDBO = new ReturninwarddetailsDBO();
		if($returninwarddetailsDBO->update($obj,$where)){
			$this->sql=$returninwarddetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$returninwarddetailsDBO = new ReturninwarddetailsDBO();
		if($returninwarddetailsDBO->delete($obj,$where=""))		
			$this->sql=$returninwarddetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returninwarddetailsDBO = new ReturninwarddetailsDBO();
		$this->table=$returninwarddetailsDBO->table;
		$returninwarddetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returninwarddetailsDBO->sql;
		$this->result=$returninwarddetailsDBO->result;
		$this->fetchObject=$returninwarddetailsDBO->fetchObject;
		$this->affectedRows=$returninwarddetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->returninwardid)){
			$error="Returninward should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
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
