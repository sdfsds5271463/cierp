<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
		<table class="table" width="1500"  border="1">
		        <tr>
				    <td colspan="9" align="center"><H3>盤點表</H3></td>
				</tr>
				<tr>
				    <th width="120" align="center">倉庫</th>
					<th width="180" >商品類別</th>
					<th width="100" align="center">商品編號</th>
					<th width="100" align="center">商品名稱</th>
					<th width="100" align="center">屬性編號</th>	
					<th width="100" align="center">屬性名稱</th>	
					<th width="120" align="center">規格型號</th>
					<th width="100" align="center">系統庫存</th>	
					<th width="100" align="center">盤點庫存</th>	
				</tr>
			  <?php 
			  $i = 1;
			  foreach($list as $arr=>$row) { 
			  ?>
				<tr target="id">
					<td ><?php echo $locationId > 0 ? $row['locationName'] : '所有倉庫';?></td>
					<td ><?php echo $row['categoryName']?></td>
					<td ><?php echo $row['invNumber']?></td>
					<td ><?php echo $row['invName']?></td>
					<td ><?php echo ''?></td>
					<td ><?php echo ''?></td>
					<td ><?php echo $row['invSpec']?></td>
					<td ><?php echo $row['qty']?></td>
					<td > </td>
				</tr>
				<?php $i++;}?>
</table>	
