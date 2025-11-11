<?php 
require_once("InvoicedetailsDBO.php");
class Invoicedetails
{				
	var $id;			
	var $invoiceid;			
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
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $invoicedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->invoiceid))
			$obj->invoiceid='NULL';
		$this->invoiceid=$obj->invoiceid;
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
		$this->bonus=str_replace("'","\'",$obj->bonus);
		$this->profit=str_replace("'","\'",$obj->profit);
		$this->total=str_replace("'","\'",$obj->total);
		$this->boxno=str_replace("'","\'",$obj->boxno);
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

	//get invoiceid
	function getInvoiceid(){
		return $this->invoiceid;
	}
	//set invoiceid
	function setInvoiceid($invoiceid){
		$this->invoiceid=$invoiceid;
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

	function add($obj,$shop){
		$invoicedetailsDBO = new InvoicedetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
		$obj->transactdate=$obj->soldon;
		$obj->rate=$obj->exchangerate2;
		$obj->eurorate=$obj->exchangerate;
		$obj->currencyid=$obj->currencyid;
		
		while($i<$num){
			$discount = 'discount'.$i;
			$exportprice = 'exportprice'.$i;
			
			$obj->id=$shop[$i]['id'];
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
			$obj->total=$shop[$i]['total']*((100-$obj->discount)/100)*((100+$obj->vat)/100);
			$obj->exportprice=$obj->$exportprice;
			$obj->boxno=$shop[$i]['boxno'];
			
			$ob = $this->setObject($obj);
			if($invoicedetailsDBO->persist($ob)){		
				$this->id=$invoicedetailsDBO->id;
				$this->sql=$invoicedetailsDBO->sql;
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
		$where=" where acctypeid='25' and refid='$obj->saletypeid'";
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

				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="$obj->code$obj->invoiceno";//echo $ob->remarks;
		$ob->memo=$obj->customername;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$total;
		$ob->credit=0;
		$ob->debiteuro=$total*$obj->exchangerate;
		$ob->crediteuro=0;
		$ob->debitorig=$total;
		$ob->creditorig=0;
		$ob->class=$obj->projectid;
		$ob->transactdate=$obj->soldon;
		$ob->currencyid=$obj->currencyid;
		$generaljournal = $generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'balance'=>"$generaljournal->debit",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate" , 'currencyid'=>"$generaljournal->currencyid",'class'=>"$generaljournal->class");
		$it++;


				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="$obj->code$obj->invoiceno";
		$ob->memo=$obj->customername;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->class=$obj->projectid;
		$ob->credit=$total;		
		$ob->crediteuro=$total*$obj->exchangerate;
		$ob->debiteuro=0;
		$ob->creditorig=$total;
		$ob->debitorig=0;
		$ob->transactdate=$obj->soldon;
		$ob->currencyid=$obj->currencyid;
		$generaljournal2 = $generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate", 'currencyid'=>"$generaljournal2->currencyid",'class'=>"$generaljournal2->class");

		$gn= new Generaljournals();
		$gn->add($obj,$shpgeneraljournals);
		
		return true;	
	}			
	function edit($obj,$where=""){
		$invoicedetailsDBO = new InvoicedetailsDBO();
		if($invoicedetailsDBO->update($obj,$where)){
			$this->sql=$invoicedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$invoicedetailsDBO = new InvoicedetailsDBO();
		if($invoicedetailsDBO->delete($obj,$where=""))		
			$this->sql=$invoicedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$invoicedetailsDBO = new InvoicedetailsDBO();
		$this->table=$invoicedetailsDBO->table;
		$invoicedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$invoicedetailsDBO->sql;
		$this->result=$invoicedetailsDBO->result;
		$this->fetchObject=$invoicedetailsDBO->fetchObject;
		$this->affectedRows=$invoicedetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->invoiceid)){
			$error="Invoice should be provided";
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
