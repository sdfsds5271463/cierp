<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1440px" class="list">
  			<tr>
			<td colspan="12" class='H' align="center"><h3>商品收發明細表<h3></td>
			</tr>
  			<tr>
			<td colspan="12">日期：<?php echo $beginDate;?>至<?php echo $endDate;?></td>
			</tr>
  		</table>
  		<table width="1440px" class="list" border="1">
  			<thead>
  				<tr>
					<th>商品編號</th>
					<th>商品名稱</th>
					<th>規格型號</th>
					<th>單位</th>
					<th>日期</th>
					<th>單據號</th>
					<th>業務型別</th>
					<th>往來單位</th>
					<th>倉庫</th>
					<th>入庫</th>
					<th>出庫</th>
					<th>結存</th>
  				</tr>
  			</thead>
  			<tbody>
			<?php 
			$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = 0;
			foreach($list1 as $arr=>$row){
			?>
  				<tr class="link" data-id="0" data-type="BAL">
  				   <td><?php echo $row['invNumber']?></td>
  				   <td><?php echo $row['invName']?></td>
  				   <td></td>
  			       <td class="R"></td>
  			       <td class="R"></td>
				   <td class="R"></td>
				   <td class="R">期初餘額</td>

				   <td class="R"></td>
				   <td class="R"></td>
  			       <td class="R"></td>
				   <td class="R"></td>
  			       <td class="R"><?php echo str_money($row['qty'],$this->systems['qtyPlaces'])?></td>
  				</tr>
  			    <?php foreach($list2 as $arr1=>$row1) {
				if ($row['id']==$row1['invId']) {
					$inqty         = $row1['qty']>0 ? abs($row1['qty']) : '';  //入庫
					$outqty        = $row1['qty']<0 ? abs($row1['qty']) : '';  //出庫
					$sum1   += $inqty;                         //入庫數量累加
					$sum2   += $outqty;                        //出庫數量累加
					$totalqtys   = $row['qty']  + $sum1 - $sum2; //結存
				?>
  				<tr>
				   <td><?php echo $row1['invNumber']?></td>
				   <td><?php echo $row1['invName']?></td>
				   <td><?php echo $row1['invSpec']?></td>
				   <td><?php echo $row1['mainUnit']?></td>
				   <td><?php echo $row1['billDate']?></td>
				   <td><?php echo $row1['billNo']?></td>
  				   <td><?php echo $row1['transTypeName']?></td>
				   <td><?php echo $row1['contactName']?></td>
  			       <td class="R"><?php echo $row1['locationName']?></td>
  			       <td class="R"><?php echo str_money($inqty,$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($outqty,$this->systems['qtyPlaces'])?></td>
  			       <td class="R"><?php echo str_money($totalqtys,$this->systems['qtyPlaces'])?></td>
 
  				</tr>
				<?php  }}
				$sum3   += $sum1;                  //合計入庫數量
				$sum4   += $sum2;                  //合計出庫數量
				$sum5   += $totalqtys;              //合計出庫數量	
				$totalqtys   = $sum1 = $sum2 =  0;  //初始化
				?>
				<?php  }?>
  				<tr>
				
  				<td colspan="3" class="R B">合計：</td>
  				<td class="R B"></td>
  				<td class="R B"></td>
				<td class="R B"></td>
  				<td class="R B"></td>
				<td class="R B"></td>
				<td class="R B"></td>
  				<td class="R B"><?php echo str_money($sum3,$this->systems['qtyPlaces'])?></td>
  				<td class="R B"><?php echo str_money($sum4,$this->systems['qtyPlaces'])?></td>
  				<td class="R B"><?php echo str_money($sum5,$this->systems['qtyPlaces'])?></td>
  				</tr> 
  			</tbody>
  		</table>