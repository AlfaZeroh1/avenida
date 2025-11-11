<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankreconciliations_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once '../banks/Banks_class.php';
require_once '../generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../generaljournals/Generaljournals_class.php';
require_once '../../sys/paymentmodes/Paymentmodes_class.php';
require_once("../../../modules/sys/currencys/Currencys_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Bank Transfer";

include"../../../head.php";
?>
<script type="text/javascript">
function getExchangeRate(id)
{
	var xmlhttp;
	var url="../../sys/currencys/populate.php?id="+id;
        xmlhttp=new XMLHttpRequest();	
	if (xmlhttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}  
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4)
		{
			var data = xmlhttp.responseText;
			var dt = data.split("-");
			document.getElementById("exchangerate").value=dt[0];
			document.getElementById("exchangerate2").value=dt[1];
		}
	};
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}
</script>
<?php
$obj=(object)$_POST;


if(empty($obj->depositdate))
	$obj->depositdate=date("Y-m-d");

if($obj->action=="Transfer")
{
	if(empty($obj->bankid))
	{
		$error="Bank to Transfer from must be selected";
	}
	if(empty($obj->bank))
	{
		$error="Bank to Transfer To must be selected";
	}
	elseif(empty($obj->amount))
	{
		$error="must provide amount to deposit";
	}
	elseif(empty($obj->depositdate))
	{
		$error="must give deposit date";
	}
	elseif(empty($obj->currencyid))
	{
		$error="must give Currency";
	}
	elseif(empty($obj->exchangerate))
	{
		$error="must give Rate";
	}
	elseif(empty($obj->exchangerate2))
	{
		$error="must give Euro Rate";
	}
	else
	{
	        $obj->transactdate=$obj->depositdate;
		$gna1 =new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='8' ";
		$having="";
		$groupby="";
		$orderby="";
		$gna1->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$gna1=$gna1->fetchObject;
		
		$gna2 =new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bank' and acctypeid='8' ";
		$having="";
		$groupby="";
		$orderby="";
		$gna2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$gna2=$gna2->fetchObject;
		
		//make entries
		$generaljournal = new Generaljournals();
		$generaljournal->accountid=$gna1->id;
		$generaljournal->daccountid=$gna2->id;
		$generaljournal->remarks="Bank Transfer";
		$generaljournal->transactdate=$obj->depositdate;
		$generaljournal->debit=0;
		$generaljournal->credit=$obj->amount;
		$generaljournal->documentno=$obj->slipno;
		
		$it=0;
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class",'jvno'=>"$generaljournal->jvno");
		$it++;
		
		$generaljournal2 = new Generaljournals();
		$generaljournal2->accountid=$gna2->id;
		$generaljournal2->daccountid=$gna1->id;
		$generaljournal2->remarks="Bank Transfer";
		$generaljournal2->transactdate=$obj->depositdate;
		$generaljournal2->debit=$obj->amount;
		$generaljournal2->credit=0;
		$generaljournal2->documentno=$obj->slipno;
		
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class",'jvno'=>"$generaljournal2->jvno");
		
		$gn = new Generaljournals();//print_r($shpgeneraljournals);
		if($gn->add($obj,$shpgeneraljournals))
		{			
			$error="Successfully recorded transfer";
			$obj="";
		}
		else
		{
			$error="could not record transfer";
		}
	}
}

?>
 <form action="banktransfers.php" method="post" class="forms">
            <table width="80%" border="0" align="center">
              <tr>
                <th colspan="2"><div align="center"><strong>Record a Deposit to Bank from Cash Box</strong></div></th>
                </tr>
                 <tr>
                <td><div align="right"><strong>From</strong></div></td>
                <td><select name="bankid" id="bankid" class="selectbox">
            <option>Select...</option>
            <?php
                $banks = new Banks();
                $fields="*";
                $where="";
                $having="";
                $orderby="";
                $groupby="";
                $banks->retrieve($fields, $join, $where, $having, $groupby, $orderby);
                
                while($row=mysql_fetch_object($banks->result))
                {
                ?>
                    <option value="<?php echo $row->id; ?>"<?php if($obj->bank==$row->id){echo"selected";}?>><?php echo $row->name; ?>&nbsp;<?php echo $row->bankbranch; ?>[<?php echo $row->bankacc; ?>]</option>
                    <?
                }
                ?>
                  </select>&nbsp;<select name="currencyid" class="selectbox" onchange="getExchangeRate(this.value);">
				<option value="">Select...</option>  
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby=" order by id desc ";
				$where=" ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select>
			      &nbsp;<input name="amount" type="text" id="amount" value="<?php echo $obj->amount; ?>" />
			      &nbsp;<input name="exchangerate" type="text" id="exchangerate" value="<?php echo $obj->exchangerate; ?>" size="12" />&nbsp;
			      <input name="exchangerate2" type="text" id="exchangerate2" value="<?php echo $obj->exchangerate2; ?>" size="12" /></td>
              </tr>
              
              <tr>
               <td><div align="right"><strong>Exchange Rate:</strong></div></td>
               <td><input name="exchangerate" type="text" id="exchangerate" value="<?php echo $obj->exchangerate; ?>" size="12" /></td>
              </tr>
              
               <tr>
                <td><div align="right"><strong>To</strong></div></td>
                <td><select name="bank" id="bank" class="selectbox">
            <option>Select...</option>
            <?php
                $banks = new Banks();
                $fields="*";
                $where="";
                $having="";
                $orderby="";
                $groupby="";
                $banks->retrieve($fields, $join, $where, $having, $groupby, $orderby);
                
                while($row=mysql_fetch_object($banks->result))
                {
                ?>
                    <option value="<?php echo $row->id; ?>"<?php if($obj->bank==$row->id){echo"selected";}?>><?php echo $row->name; ?>&nbsp;<?php echo $row->bankbranch; ?>[<?php echo $row->bankacc; ?>]</option>
                    <?
                }
                ?>
                  </select>&nbsp;
                  &nbsp;<select name="currencyid" class="selectbox" onchange="getExchangeRate(this.value);">
                  <option value="">Select...</option>  
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby=" order by id desc ";
				$where=" ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select>
			      &nbsp;<input name="amount" type="text" id="amount" value="<?php echo $obj->amount; ?>" />
			      &nbsp;<input name="exchangerate" type="text" id="exchangerate" value="<?php echo $obj->exchangerate; ?>" size="12" />&nbsp;
			      <input name="exchangerate2" type="text" id="exchangerate2" value="<?php echo $obj->exchangerate2; ?>" size="12" /></td>
              </tr>
              
              
              <tr>
		<td align="right">Exchange gain/loss:</td>
		<td>KShs.<input type="text" name="exchangediff" value="<?php echo $obj->exchangediff; ?>"/>
		Euro.<input type="text" name="exchangediff" value="<?php echo $obj->exchangediff; ?>"/></td>
              </tr>
              
               <tr>
                <td><div align="right"><strong>Transffered Thru::</strong></div></td>
                <td><select name="paymentmode" class="selectbox">
                			<?php 
                			$paymentmodes = new Paymentmodes();
                			$fields="*";
                			$having="";
                			$groupby="";
                			$orderby="";
                			$groupby="";
                			$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
                			while($row=mysql_fetch_object($paymentmodes->result)){
							?>
									<option value="<?php echo $row->name; ?>" <?php if($row->name==$obj->paymentmode){echo"selected";}?>><?php echo $row->name; ?></option>
							<?php 
							}
                			?>
                			</select><input name="chequeno" type="text" id="chequeno" value="<?php echo $obj->chequeno; ?>" /></td>
              </tr>
              
              <tr>
                <td><div align="right"><strong>Amount Transferred:</strong></div></td>
                <td></td>
              </tr>             
              <tr>
                <td><div align="right"><strong>Date Transferred</strong></div></td>
                <td> <input name="depositdate" type="text" class="date_input" readonly="readonly" id="depositdate" value="<?php echo $obj->depositdate; ?>" size="12" />&nbsp;</td>
              </tr>
              
              <tr>
                <td><div align="right"><strong>Remarks:</strong></div></td>
                <td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
              </tr>
              <tr>
                <td colspan="2"><div align="center"><?php showError($error); ?></div></td>
                </tr>
              <tr>
                <td colspan="2"><div align="center">
                  <input type="submit" name="action" id="action" value="Transfer" />
                </div></td>
                </tr>
                <tr>
                <th colspan="2">&nbsp;</th>
                </tr>
            </table>
            </form>