<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
  		 
		<table width="1440px" class="list">
  			<tr><td class='H' align="center" colspan="<?php echo $profit==1 ?'13':'9'?>"><h3>銷售彙總表（按客戶）<h3></td></tr>
  			<tr><td colspan="<?php echo $profit==1 ?'13':'9'?>">日期：<?php echo $beginDate?>至<?php echo $endDate?></td></tr>
  		</table>
  		<table width="1440px" class="list" border="1">
  			<thead>
  				<tr>
				<th width="150">客戶</th>
  				<th>商品編號</th>
  				<th>商品名稱</th>
  				<th>規格型號</th>
  				<th>單位</th>
  				<th>倉庫</th>
  				<th>數量</th>
  				<th>單價</th>
  				<th>銷售收入</th>
				<?php if ($profit==1) {?>
				<th>單位成本</th>
  				<th>銷售成本</th>
  				<th>銷售毛利</th>
				<th>毛利率</th>
				<?php }?>
  				</tr>
  			</thead>
  			<tbody>
				 <?php 
				 $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = 0;
				 foreach($list as $arr=>$row){
				     $sum1 += $qty = $row['sumqty']>0 ? -abs($row['sumqty']) : abs($row['sumqty']);   
					 $sum3 += $amount = $row['sumamount'];                   
					 $unitPrice = $qty!=0 ? $amount/$qty : 0;               
					 if ($profit==1) {
						$sum4 += $unitcost = isset($info['inprice'][$row['invId']][$row['locationId']]) ? $info['inprice'][$row['invId']][$row['locationId']] : 0;
						$sum5 += $cost = $unitcost * $qty;               
						$sum6 += $saleProfit = $amount - $cost;           
						$sum7 += $salepPofitRate = ($saleProfit/$amount)*100;                  
					 }
					 
				 ?>
  			       <tr class="link" data-id="<?php echo $row['iid']?>" data-type="<?php echo $row['billType']?>">
				   <td><?php echo $row['contactName']?></td>
  			       <td><?php echo $row['invNumber']?></td>
  			       <td><?php echo $row['invName']?></td>
  			       <td><?php echo $row['invSpec']?></td>
  			       <td><?php echo $row['mainUnit']?></td>
  			       <td><?php echo $row['locationName']?></td>
  			       <td class="R"><?php echo str_money($qty,$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($unitPrice,$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($amount,2)?></td>
				   <?php if ($profit==1) {?>
				   <td class="R"><?php echo str_money($unitcost,2)?></td>
  				   <td class="R"><?php echo str_money($cost,2)?></td>
  				   <td class="R"><?php echo str_money($saleProfit,2)?></td>
				   <td class="R"><?php echo round($salepPofitRate,2)?>%</td>
				   <?php }?>
  			       </tr>
				 <?php 
				 
				 }
				 ?>
  				<tr>
  				<td colspan="6" class="R B">合計：</td>
  				<td class="R B"><?php echo str_money($sum1,$this->systems['qtyPlaces'])?></td>
  				<td class="R B"><?php echo $sum1>0 ? str_money($sum3/$sum1,$this->systems['qtyPlaces']) : 0?></td>
  				<td class="R B"><?php echo str_money($sum3,2)?></td>
				<?php if ($profit==1) {?>
				<td class="R B"><?php echo str_money($sum4,2)?></td>
  				<td class="R B"><?php echo str_money($sum5,2)?></td>
  				<td class="R B"><?php echo str_money($sum6,2)?></td>
				<td class="R B"><?php echo round($sum7,2)?>%</td>
				<?php }?>
  				</tr>
  			</tbody>
  		</table>
 