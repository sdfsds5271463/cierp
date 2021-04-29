<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
		<table class="table" width="1500"  border="1">
			<thead>
			    <tr>
				    <th colspan="21" align="center"><h3>商品明細表</h3></th>
				</tr>
				
				<tr>
				    <th width="80" >商品編號</th>
					<th width="100" >商品名稱</th>
					<th width="100" >商品條碼</th>
					<th width="80" >商品規格</th>
					<th width="80" >商品類別</th>
					<th width="80" >首選倉庫</th>
					<th width="80" >目前庫存</th>
					<th width="80" >最低庫存</th>
					<th width="80" >最高庫存</th>
					<th width="80" >計量單位</th>
					<th width="100" >預計採購價</th>
					<th width="60" >零售價</th>
					<th width="60" >批發價</th>
					<th width="60" >會員價</th>
					<th width="120" >折扣率一（%）</th>
					<th width="120" >折扣率二（%）</th>
					<th width="120" >備註</th>
					<th width="80" >倉庫</th>
					<th width="70" align="center">初期數量</th>	
					<th width="70" align="center">單位成本</th>	
					<th width="70" align="center">初期總價</th>	
				</tr>
			</thead>
			<tbody>
			  <?php 
			  $i = 1;
			  foreach($list as $arr=>$row) {
			  ?>
				<tr target="id">
				    <td ><?php echo $row['number']?></td>
					<td ><?php echo $row['name']?></td>
					<td ><?php echo $row['barCode']?></td>
					<td ><?php echo $row['spec']?></td>
					<td ><?php echo $row['categoryName']?></td>
					<td ><?php echo $row['locationName']?></td>
					<td ><?php echo $row['totalqty']?></td>
					<td ><?php echo $row['lowQty']?></td>
					<td ><?php echo $row['highQty']?></td>
					<td ><?php echo $row['unitName']?></td>
					<td ><?php echo $row['purPrice']?></td>
					<td ><?php echo $row['salePrice']?></td>
					<td ><?php echo $row['wholesalePrice']?></td>
					<td ><?php echo $row['vipPrice']?></td>
					<td ><?php echo $row['discountRate1']?></td>
					<td ><?php echo $row['discountRate2']?></td>
					<td ><?php echo $row['remark']?></td>

                    <td ></td>
					<td ><?php echo $row['iniqty']?></td>
					<td ><?php echo $row['iniqty']>0 ? $row['iniamount']/$row['iniqty'] :''?></td>
					<td ><?php echo $row['iniamount']?></td>
				</tr>
				<?php 
				$propertys    = (array)json_decode($row['propertys'],true);
				foreach ($propertys as $arr1=>$row1) {
				?>
				<tr target="id">
				    <td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
                    <td ><?php echo $storage[$row1['locationId']]?></td>
					<td ><?php echo $row1['quantity']?></td>
					<td ><?php echo $row1['unitCost']?></td>
					<td ><?php echo $row1['amount']?></td>
				</tr>
				<?php }?>
				<?php $i++;}?>
 
 </tbody>
</table>	
