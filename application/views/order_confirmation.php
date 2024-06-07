<? //echo "<pre>";print_r($orders);echo "</pre>"; 
//$orders=$this->data['orders'][0];
?>
<style type="text/css">
body{
	overflow-x: hidden;
}
	table tr td,table tr td{
		text-align: center;
	}
	@media only screen and (max-width: 500px) {

	/* table,head,tbody,th,td,tr {
		display: block;
	}*/
	/*thead tr {
	display: none;
	}*/
	tr {
	 border: 1px solid #ccc; 
	}
	td {
	border: none;
	border-bottom: 1px solid #eee;
	position: relative;
	padding-left: 50%;
	white-space: normal;
	text-align:left;
	min-height: 30px;
	overflow: hidden;
	word-break:break-all;
	}
	td:before {
	position: absolute;
	top: 6px;
	left: 6px;
	width: 45%;
	padding-right: 10px;
	text-align:left;
	font-weight: bold;
	}
	td:before { content: attr(data-title); }
}
</style>
<div class="orders_page order_cnfrm">
	<div class="container">
		<div class="orders_detl">
			<img src="<?=__scriptFilePath__?>images/succes.gif" class="order_image">
			<h2 class="main_header"><?=$orders->name?>, Thank You For Your Order! </h2>
			<p class="main_paragf"><strong>We've received your order and will contact you as soon as your package is shipped.</strong></p>
            <p class="main_paragf">You can find your purchase information below.</p>
            <p class="main_paragf"><strong>Order ID : <?=$orders->order_number?></strong></p>
             <? if($orders->status==1 && false){?>
            <p class="main_paragf"><strong>Transaction ID : <?=$orders->txnid?></strong></p>
            <? }else{ ?>
            <p class="main_paragf"><strong>Transaction ID : <?=$orders->mihpayid?></strong></p>
            <? } ?>
           <p class="main_paragf">You will get order receipt to <a><?=$orders->email?></a> shortly.</p>
			<div class="orders_prod">
				
				<div class="orders_sctn">
                    <div class="orders_sctn">
                        <h4 class="about_sbhead">Payment Information</h4>
                    </div>
                    <div class="orders_sctn">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="orders_sctn">
                                    <p class="main_paragf"><strong>Transaction ID</strong></p>
                                    <p class="main_paragf"><?=$orders->mihpayid?></p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <p class="main_paragf"><strong>Payment Mode</strong></p>
                                <p class="main_paragf"><?=$orders->mode?></p>
                            </div>
                        </div>
                    </div>
                    <div class="orders_sctn">
					<h4 class="about_sbhead">Delivery Details</h4>
					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="orders_sctn">
								<p class="main_paragf"><strong>Delivery for</strong></p>
								<p class="main_paragf"><?=($orders->name != 'User')?$orders->name:$orders->d_name?><br> <?=$orders->number?></p>
							</div>
							<div class="orders_sctn">
								<p class="main_paragf"><strong>Address</strong></p>
								<p class="main_paragf"><?=$orders->d_address?>,<br><?=$orders->d_city_name?> - <?=$orders->d_zipcode?>,<br><?=$orders->d_state_name?>,<br>India.</p>
							</div>
						</div>
						<div class="col-md-5">
							<p class="main_paragf"><strong>Delivery Method</strong></p>
							<p class="main_paragf">Standard Delivery - Please below to see when your items will be delivered.</p>
						</div>
					</div>
				</div>
				<div class="orders_sctn">
					<h4 class="about_sbhead">Order Summary</h4>
					<?php /*?><p class="main_paragf">You have <? echo count($orders->product) ?> items in order</p><?php */?>
			
					<div class="table-responsive">
					<table class="table table-bordered">
					<thead>
					  <tr>
                      	<th>SlNo.</th>
						<?php /*?><th>Products</th><?php */?>
						<th>Name</th>
						<th>QTY</th>
						<th>Price</th>
					  </tr>
					</thead>
					<tbody>
                    <? $odCount=0;foreach($orders->details as $od){$odCount++; ?>
                    <span style="display:none" class=" product_id" ><?=$od->combi_ref_code?></span>
					  <tr>
                      	<td><?=$odCount?>.</td>
						<?php /*?><td><img src="images/products/demo-products-1.jpg" class="prodct_imge"></td><?php */?>
						<td><p class="main_paragf"><?=$od->product_name?><br><?=$od->combi?></p></td>
						<td><?=$od->prod_in_cart?></td>
						<td><p class="main_paragf"><?=$orders->symbol?> <?=$od->total?></p></td>
					  </tr>
                    <? } ?>
                    
					  <tr class="main_parice"><td colspan="4"><p class="main_paragf"><span class="min_widths">Subtotal</span><?=$orders->symbol?> <?=$orders->sub_total?></td></tr>
                      <tr class="main_parice"><td colspan="4"><p class="main_paragf"><span class="min_widths">GST</span><?=$orders->symbol?> <?=$orders->total_gst?></td></tr>
					  <tr class="main_parice"><td colspan="4"><p class="main_paragf"><span class="min_widths">Estimated shipping</span><?=$orders->symbol?> <?=$orders->delivery_charges?></td></tr>
					  <?php if(!empty($orders->discount)){?><tr class="main_parice"><td colspan="4"><p class="main_paragf"><span class="min_widths">Coupan Discount</span>-<?=$orders->discount?></td></tr><?php } ?>
					  <tr class="main_parice"><td colspan="4"><h4 class="about_sbhead"><span class="min_widths">Total</span> <?=$orders->symbol?> <?=$orders->total?></h4></td>
                      
					</tbody>
				  </table>
				</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
