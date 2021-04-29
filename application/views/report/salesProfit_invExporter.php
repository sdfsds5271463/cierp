<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
		<table width="1440px" class="list">
  			<tr><td class='H' align="center" colspan="17"><h3>銷售利潤表<h3></td></tr>
  			<tr><td colspan="<?php echo $profit==1 ?'12':'8'?>">日期：<?php echo $beginDate?>至<?php echo $endDate?></td></tr>
  		</table>
  		<table width="1440px" class="list" border="1">
  			<thead>
  				<tr>
  				<th>單據日期</th>
  				<th>客戶</th>
  				<th>銷售人員</th>
  				<th>單據編號</th>
  				<th>業務型別</th>
  				<th>數量</th>
  				<th>銷售收入</th>
  				<th>銷售成本</th>
  				<th>銷售毛利<br/>(銷售收入-銷售成本)</th>
				<th>毛利率</th>
  				<th>優惠金額</th>
  				<th>銷售凈利潤<br/>(銷售毛利-優惠金額)</th>
  				<th>凈利潤率</th>
  				<th>優惠後金額</th>
  				<th>應收金額</th>
				<th>已收款金額</th>
				<th>整單備註</th>
  				</tr>
  			</thead>
  			<tbody>
				 <?php 
				 $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = $sum10 = $sum11 = 0;
				 foreach ($list as $arr=>$row) {
        	        $totalAmount = (float)$row['totalAmount'];
        	        $amount = (float)$row['amount'];
        	        $v[$arr]['salesNo'] = $row['salesNo'];
        	        $v[$arr]['contactNo'] = $row['contactNo'];
        	        $v[$arr]['billDate'] = $row['billDate'];//單據日期
        	        $v[$arr]['salesName'] = $row['salesName'];//銷售人員
        	        $v[$arr]['contactName'] = $row['contactName'];//客戶
        	        $v[$arr]['billNo'] = $row['billNo'];//單據編號
        	        $v[$arr]['transTypeName'] = $row['transTypeName'];//業務型別
        	        $v[$arr]['totalQty'] = (float)$row['totalQty'];//數量
        	        $v[$arr]['disAmount'] = (float)$row['disAmount'];//優惠金額
        	        $v[$arr]['amount'] = (float)$row['amount'];//優惠後金額
        	        $v[$arr]['totalAmount'] = (float)$row['totalAmount'];//銷售收入
        	        //$v[$arr]['totalCost'] = (float)$row['totalCost'];//銷售成本
        	        $v[$arr]['ysAmount'] = (float)$row['amount'];//應收金額
        	        $v[$arr]['rpAmount'] = (float)$row['rpAmount'];//已收款金額
        	        $v[$arr]['description'] = $row['description'];//整單備註
        	        
        	        $details = $this->data_model->get_invoice_info(' a.iid ='.$row['id']);
        	        
        	        $sum = 0;
        	        foreach ($details as $key=>$detail) {
        	            $qty = $detail['qty']>0 ? -abs($detail['qty']):abs($detail['qty']);
        	            $unitcost = isset($info['inprice'][$detail['invId']][$detail['locationId']]) ? $info['inprice'][$detail['invId']][$detail['locationId']] : 0;   //單位成本
        	            $sum += $cost = $unitcost * $qty;
        	        }
        	        $v[$arr]['totalCost'] = round($sum,2);//銷售成本
        	        $v[$arr]['saleProfit'] = round($totalAmount - $sum,2);//銷售毛利=銷售收入-銷售成本
        	        $salepPofitRate = $totalAmount>0? ($v[$arr]['saleProfit']/$totalAmount)*100 :0;
        	        $v[$arr]['salepPofitRate'] = round($salepPofitRate,2).'%';//毛利率
        	        $v[$arr]['pureProfit'] = $v[$arr]['saleProfit'] - $v[$arr]['disAmount'];//銷售凈利潤=銷售毛利-優惠金額
        	        $pureProfitRate = $amount>0? ($v[$arr]['pureProfit']/$amount)*100 :0;
        	        $v[$arr]['pureProfitRate'] = round($pureProfitRate,2).'%';//凈利潤率
        	        	
        	        $sum1 += $v[$arr]['totalQty'];
        	        $sum2 += $v[$arr]['disAmount'];
        	        $sum3 += $v[$arr]['amount'];
        	        $sum4 += $v[$arr]['totalAmount'];
        	        $sum5 += $v[$arr]['ysAmount'];
        	        $sum6 += $v[$arr]['rpAmount'];
        	        $sum7 += $v[$arr]['totalCost'];
        	        $sum8 += $v[$arr]['saleProfit'];
        	        $sum9 += $salepPofitRate;
        	        $sum10 += $v[$arr]['pureProfit'];
        	        $sum11 += $pureProfitRate;
				 ?>
  			       <tr class="link" data-id="<?php echo $row['iid']?>" data-type="<?php echo $row['billType']?>">
  			       <td><?php echo $row['billDate']?></td>
  			       <td><?php echo $row['contactName']?></td>
  			       <td><?php echo $row['salesName']?></td>
  			       <td><?php echo $row['billNo']?></td>
  			       <td><?php echo $row['transTypeName']?></td>
				   <td class="R"><?php echo str_money($row['totalQty'],$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($row['totalAmount'],$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($sum,2)?></td>
				   <td class="R"><?php echo str_money($totalAmount - $sum,2)?></td>
				   <td class="R"><?php echo round($salepPofitRate,2)?>%</td>
  				   <td class="R"><?php echo str_money($row['disAmount'],2)?></td>
  				   <td class="R"><?php echo str_money($v[$arr]['saleProfit'] - $v[$arr]['disAmount'],2)?></td>
				   <td class="R"><?php echo round($pureProfitRate,2)?>%</td>
				   <td class="R"><?php echo str_money($v[$arr]['amount'],2)?></td>
				   <td class="R"><?php echo str_money($v[$arr]['ysAmount'],2)?></td>
				   <td class="R"><?php echo str_money($v[$arr]['rpAmount'],2)?></td>
				   <td><?php echo $row['description']?></td>
  			       </tr>
				 <?php 
				 }
				 ?>
  				<tr>
  				<td colspan="5" class="R B">合計：</td>
  				<td class="R B"><?php echo str_money($sum1,$this->systems['qtyPlaces'])?></td>
  				<td class="R B"><?php echo str_money($sum4,$this->systems['qtyPlaces'])?></td>
  				<td class="R B"><?php echo str_money($sum7,2)?></td>
  				<td class="R B"><?php echo str_money($sum8,2)?></td>
  				<td class="R B"><?php echo round($sum9,2)?>%</td>
  				<td class="R B"><?php echo str_money($sum2,2)?></td>
  				<td class="R B"><?php echo str_money($sum10,2)?></td>
  				<td class="R B"><?php echo round($sum11,2)?>%</td>
				<td class="R B"><?php echo str_money($sum3,2)?></td>
  				<td class="R B"><?php echo str_money($sum5,2)?></td>
  				<td class="R B"><?php echo str_money($sum6,2)?></td>
  				</tr>
  			</tbody>
  		</table>
 