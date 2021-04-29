<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 0; 
$arrears = count($list1)>0 ? $list1['amount'] : 0;
?>
<table width="1440px" class="list">
  			<tr><td class='H' colspan="<?php echo $showDetail == "true" ? 14 : 8?>" align="center"><h3>客戶對賬單<h3></td></tr>
  			<tr><td colspan="<?php echo $showDetail == "true" ? 14 : 8?>"><?php echo $customerName?></td></tr>
  			<tr><td colspan="<?php echo $showDetail == "true" ? 14 : 8?>">日期：<?php echo $beginDate;?>至<?php echo $endDate;?></td></tr>
  		</table>
  		<table width="1440px" class="list" border="1">
  			<thead>
  				<tr>
  				<th>單據日期</th>
  				<th>單據編號</th>
  				<th>業務類別</th>
				
		        <?php if ($showDetail == "true") {?>
  				<th>商品編號</th>
  				<th>商品名稱</th>
				<th>規格型號</th>
				<th>單位</th>
				<th>數量</th>
				<th>單價</th>
				<?php  }?>
  				<th>銷售金額</th>
  				<th>整單折扣額</th>
  				<th>應收金額</th>
  				<th>實際收款金額</th>
  				<th>應收款餘額</th>
  				</tr>
  			</thead>
  			<tbody>
  				<tr class="link" data-id="0" data-type="BAL">
  				   <td></td>
  				   <td>期初餘額</td>
  				   <td></td>
				   <?php if ($showDetail == "true") {?>
  			       <td class="R"></td>
  			       <td class="R"></td>
  			       <td class="R"></td>
  			       <td class="R"></td>
				   <td class="R"></td>
  			       <td class="R"></td>
				   <?php  }?>
  			       <td class="R"></td>
  			       <td class="R"></td>
				   <td class="R"></td>
  			       <td class="R"></td>
  			       <td class="R"><?php echo str_money($arrears,2)?></td>
  				</tr>

  			    <?php 
				 foreach($list2 as $arr=>$row){
				     $sum1 += $row['arrears']; 
					 $sum2 += $row['amount'];               //應收金額
					 $sum3 += $row['totalAmount'];          //銷售金額
					 $sum4 += $row['rpAmount'];             //實際收款金額
					 $sum5 += $row['disAmount'];            //折扣率
				 ?>
  				<tr>
  				   <td><?php echo $row['billDate']?></td>
  				   <td><?php echo $row['billNo']?></td>
  				   <td><?php echo $row['transTypeName']?></td>
				   <?php if ($showDetail == "true") {?>
				   <td class="R"></td>
				   <td class="R"></td>
				   <td class="R"></td>
				   <td class="R"></td>
				   <td class="R"></td>
				   <td class="R"></td>
				   <?php  }?>
  			       <td class="R"><?php echo str_money($row['totalAmount'],2)?></td>
  			       <td class="R"><?php echo str_money($row['disAmount'],2)?></td>
  			       <td class="R"><?php echo str_money($row['amount'],2)?></td>
  			       <td class="R"><?php echo str_money($row['rpAmount'],2)?></td>
  			       <td class="R"><?php echo str_money($arrears + $sum1,2)?></td>
  				</tr>
				
				<?php 
				if ($showDetail == "true") {
				    if ($row['billType']=='SALE') {
						$postData = unserialize($row['postData']);
						foreach ($postData['entries'] as $arr1=>$row1) {
				?>
				<tr>
  				   <td></td>
  				   <td></td>
  				   <td></td>
				   
				   <td class="R"><?php echo $row1['invNumber']?></td>
				   <td class="R"><?php echo $row1['invName']?></td>
				   <td class="R"><?php echo $row1['invSpec']?></td>
				   <td class="R"><?php echo $row1['mainUnit']?></td>
				   <td class="R"><?php echo str_money(abs($row1['qty']),$this->systems['qtyPlaces'])?></td>
				   <td class="R"><?php echo str_money($row1['price'],$this->systems['qtyPlaces'])?></td>
				  
  			       <td class="R"></td>
  			       <td class="R"></td>
  			       <td class="R"></td>
  			       <td class="R"></td>
  			       <td class="R"><?php echo str_money($arrears + $sum1,2)?></td>
  				</tr>
				
				<?php  }}}?>
				<?php  }?>
				
				 
  				<tr>
  				<td colspan="3" class="R B">合計：</td>
				<?php if ($showDetail == "true") {?>
				<td class="R"></td>
				<td class="R"></td>
				<td class="R"></td>
				<td class="R"></td>
				<td class="R"></td>
				<td class="R"></td>
				<?php  }?>   
  				<td class="R B"><?php echo str_money($sum3,2)?></td>
  				<td class="R B"><?php echo str_money($sum5,2)?></td>
  				<td class="R B"><?php echo str_money($sum2,2)?></td>
  				<td class="R B"><?php echo str_money($sum4,2)?></td>
  				<td class="R B"><?php echo str_money($arrears + $sum1,2)?></td>
  				</tr> 
  			</tbody>
  		</table>