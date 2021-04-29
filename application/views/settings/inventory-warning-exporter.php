<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
		<table class="table" width="1500"  border="1">
			<thead>
			    <tr>
				    <th colspan="10" align="center"><h3>庫存預警商品</h3></th>
				</tr>
				
				<tr>
				    <th width="80" >商品編號</th>
					<th width="100" >商品名稱</th>
					<th width="80" >商品類別</th>
					<th width="80" >規格型號</th>
		            <th width="80" >單位</th>
					<th width="80" >倉庫</th>
					<th width="80" >最低庫存</th>
					<th width="80" >最高庫存</th>
					<th width="80" >結存數量</th>
					<th width="80" >超限數量</th>
					 
				</tr>
			</thead>
			<tbody>
			  <?php 
			  $i = 1;
			  foreach($list as $arr=>$row) {
			  ?>
				<tr target="id">
				    <td ><?php echo $row['invNumber']?></td>
					<td ><?php echo $row['invName']?></td>
					<td ><?php echo $row['categoryName']?></td> 
					<td ><?php echo $row['invSpec']?></td>
					<td ><?php echo $row['unitName']?></td>
					<td ><?php echo $row['locationName']?></td>
					<td ><?php echo $row['lowQty']?></td>
					<td ><?php echo $row['highQty']?></td>
					<td ><?php echo $row['qty']?></td>
					<td ><?php echo $row['qty1'] > 0 ? $row['qty1'] : $row['qty2']; ?></td>
				</tr>
				<?php $i++;}?>
 
 </tbody>
</table>	
