<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankreconciliations_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once '../banks/Banks_class.php';
require_once '../generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../generaljournals/Generaljournals_class.php';

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Bank Withdrawal";

include"../../../head.php";

$obj=(object)$_POST;

if(empty($obj->action))
	$obj->depositdate=date("Y-m-d");

if($obj->action=="Withdraw")
{
	if($obj->bankid=="Select...")
	{
		$error="must select bank";
	}
	elseif($obj->accid=="Select...")
	{
		$error="must select office control account";
	}
	elseif(empty($obj->amount))
	{
		$error="must provide amount to withdrawn";
	}
	elseif(empty($obj->depositdate))
	{
		$error="must give deposit date";
	}
	else
	{
		$gna1 =new Generaljournalaccounts();
		$fields="*";
		$where=" where id='$obj->accid' ";
		$having="";
		$groupby="";
		$orderby="";
		$gna1->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$gna1=$gna1->fetchObject;
		
		$gna2 =new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='8' ";
		$having="";
		$groupby="";
		$orderby="";
		$gna2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$gna2=$gna2->fetchObject;
		
		//make entries
		$generaljournal = new Generaljournals();
		$generaljournal->accountid=$gna2->id;
		$generaljournal->daccountid=$gna1->id;
		$generaljournal->remarks="Cash Withdrawal";
		$generaljournal->transactdate=$obj->depositdate;
		$generaljournal->debit=0;
		$generaljournal->credit=$obj->amount;
		$generaljournal->documentno=$obj->slipno;
		
		$it=0;
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class",'jvno'=>"$generaljournal->jvno");
		$it++;
		
		$generaljournal2 = new Generaljournals();
		$generaljournal2->accountid=$gna1->id;
		$generaljournal2->daccountid=$gna2->id;
		$generaljournal2->remarks="Cash Withdrawal";
		$generaljournal2->transactdate=$obj->depositdate;
		$generaljournal2->debit=$obj->amount;
		$generaljournal2->credit=0;
		$generaljournal2->documentno=$obj->slipno;
		
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class",'jvno'=>"$generaljournal2->jvno");
		
		$gn = new Generaljournals();
		if($gn->add($obj,$shpgeneraljournals))
		{			
			$error="Successfully recorded withdrawal";
			$obj="";
		}
		else
		{
			$error="could not record withdrawal";
		}
	}
}

?>
 <form action="withdrawals.php" method="post" class="forms">
            <table width="80%" border="0" align="center">
              <tr>
                <th colspan="2"><div align="center"><strong>Record a Deposit from Bank to Cash Box</strong></div></th>
                </tr>
              <tr>
                <td width="46%"><div align="right"><strong>Bank Involved</strong></div></td>
                <td width="54%"><select name="bankid" id="bankid" class="selectbox">
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
                    <option value="<?php echo $row->id; ?>"<?php if($obj->bankid==$row->id){echo"selected";}?>><?php echo $row->name; ?>&nbsp;<?php echo $row->bankbranch; ?>[<?php echo $row->bankacc; ?>]</option>
                    <?
                }
                ?>
                  </select>&nbsp;</td>
              </tr>
              <tr>
                <td width="46%"><div align="right"><strong>Office Control</strong></div></td>
                <td width="54%"><select name="accid" id="accid" class="selectbox">
            <option>Select...</option>
            <?php
                $banks = new Generaljournalaccounts();
                $fields="*";
                $where=" where acctypeid='24' ";
                $having="";
                $orderby="";
                $groupby="";
                $banks->retrieve($fields, $join, $where, $having, $groupby, $orderby);
                
                while($row=mysql_fetch_object($banks->result))
                {
                ?>
                    <option value="<?php echo $row->id; ?>"<?php if($obj->accid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
                    <?
                }
                ?>
                  </select>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right"><strong>Amount Withdrawn:</strong></div></td>
                <td><input name="amount" type="text" id="amount" value="<?php echo $obj->amount; ?>" /></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Date Withdrawn</strong></div></td>
                <td> <input name="depositdate" type="text" class="date_input" readonly="readonly" id="depositdate" value="<?php echo $obj->depositdate; ?>" size="12" />&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right"><strong>Withdrawal Slip No:</strong></div></td>
                <td><input name="slipno" type="text" id="slipno" value="<?php echo $obj->slipno; ?>" /></td>
              </tr>
              <tr>
                <td colspan="2"><div align="center"><?php showError($error); ?></div></td>
                </tr>
              <tr>
                <td colspan="2"><div align="center">
                  <input type="submit" name="action" id="action" value="Withdraw" />
                </div></td>
                </tr>
                <tr>
                <th colspan="2">&nbsp;</th>
                </tr>
            </table>
            </form>