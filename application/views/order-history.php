<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / My Orders</span></li>
	</ol>
</nav>
      <div class="mt-5">
      <div class="container">
         <div class="row ">
            <?php $this->load->view('template/left-menu', $this->data);?>
            <div class="col-md-9">
               <h4 class="form_headr1">Order history</h4>
               <div class="empty1 mb-5">
                  <div class="bagaininner">
                   <!--  <h3 class="pro_header3 col-md-12">My Order History</h3>  -->

                   <?
				   // echo "<pre>";print_r($orders);echo "</pre>";
				$order_status_arr = array();
				if(!empty($orders)){
					?>
                                     <div class="row ">



                                   <div class="edit_profle col-md-5 float-right">
            <div class="form-group order_histpory_filter flex-row align-items-center">
              <label for="sel1" class="col-md-5">Refine Order:</label>
              <select class="profil_form col-md-6" id="cus_orders_sel" onChange="On_cus_orders_sel()"><option value="1">Order placed</option><option value="2">In Process</option></select>
            </div>
                </div>
                </div>



				 <?
				$ocount=0;//echo "<pre>";print_r($orders);echo "</pre>";
			foreach($orders as $o){$ocount++;$order_status_arr[] = $o->order_status;  ?>

            <?
				$acctual_total = 0;
				foreach($o->details as $od)
				{
					$t_acctual_total = 0;
					$t_acctual_total = ($od->price * $od->prod_in_cart);
					$t_acctual_total = $t_acctual_total + $od->delivery_charges;

					$acctual_total += round($t_acctual_total , 2);
				}
				?>

                        <div class="ordersBox orderpro_<?=$o->order_status?> dispatched" data-order_status="<?=$o->order_status?>"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                 <?=$o->order_status_display_user?>
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span><?=date("D, d M y" , strtotime($o->added_on))?></div>
                                <div class="Amt">Order Amount : <?=$o->symbol?> <?=$o->total?></div>
                                <div class="totalQty"><span class="itmqty"><?=$o->total_prod?> Items &nbsp; <i class="fa fa-angle-down"></i></span></div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="<?=base_url().__orderDetails__.'/'.$o->orders_id?>" class="aClick_1"><?=$o->order_number?></a></span></li>
                                 <li>Order Placed : <span><?=date("D, d M y" , strtotime($o->added_on))?></span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span><?=$o->d_name?></span><br>
                                            <?=$o->d_address?>, <?=$o->d_city_name?>, <?=$o->d_zipcode?> <br><span>Ph: <?=$o->d_number?></span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success"><? if($o->is_cod==1){echo "COD";}else{echo "Success";} ?></span><br>
                                                                                    </p>
                                    </div>
                                    <!-- <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div> -->

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p><b>Order Summary</b></p>
                                            <? if($o->total_packing_charges>0){ ?><li><span>Packing Charges  </span><span> : <?=$o->symbol?> <?=$o->total_packing_charges?></span></li><? } ?>
                                            <li><span>Delivery Charges  </span><span> : <?=$o->symbol?> <?=$o->delivery_charges?></span></li>
                                            <? if($o->shipping_discount>0){ ?><li><span>Shipping Discount  </span><span> : - <?=$o->symbol?> <?=$o->shipping_discount?></span></li> <? } ?>
                                            <? if($o->cod_charges>0){ ?><li><span>COD Charges  </span><span> : - <?=$o->symbol?> <?=$o->cod_charges?></span></li> <? } ?>
                                            <li><span>Order Amount  </span><span> : <?=$o->symbol?> <?=$o->total?></span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <?=$o->symbol?> <?=($acctual_total - $o->total)?></span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="<?=base_url().__orderDetails__.'/'.$o->orders_id?>" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>

                <? } ?>
                  <? /* ?>



                        <div class="ordersBox orderpro_1 dispatched" data-order_status="1"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-check"></span> Order Placed
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Sat, 08 Oct 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 21669</div>
                                <div class="totalQty"><span class="itmqty">18 Items &nbsp; <i class="fa fa-angle-down"></i></span>
                               </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/27" class="aClick_1">#HFG/2022/10/08/27</a></span></li>
                                 <li>Order Placed : <span> Sat, 08 Oct 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 21669</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 15026</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/27" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_1 dispatched" data-order_status="1"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-check"></span> Order Placed
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Sun, 18 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>
                                </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/26" class="aClick_1">#HFG/2022/09/18/26</a></span></li>
                                 <li>Order Placed : <span> Sun, 18 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/26" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Fri, 16 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/25" class="aClick_1">#HFG/2022/09/16/25</a></span></li>
                                 <li>Order Placed : <span> Fri, 16 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/25" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/24" class="aClick_1">#HFG/2022/09/15/24</a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/24" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/23" class="aClick_1">#HFG/2022/09/15/23</a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/23" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/22" class="aClick_1">#HFG/2022/09/15/22</a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/22" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/21" class="aClick_1">#HFG/2022/09/15/21</a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/21" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_1 dispatched" data-order_status="1"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-check"></span> Order Placed
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/20" class="aClick_1"></a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/20" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_1 dispatched" data-order_status="1"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-check"></span> Order Placed
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/19" class="aClick_1"></a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/19" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/18" class="aClick_1">#HFG/2022/09/15/18</a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/18" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/17" class="aClick_1">#HFG/2022/09/15/17</a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/17" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>






                        <div class="ordersBox orderpro_2 dispatched" data-order_status="2"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-refresh"></span> In Process
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Thu, 15 Sep 22</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 20889</div>
                                <div class="totalQty"><span class="itmqty">15 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/16" class="aClick_1">#HFG/2022/09/15/16</a></span></li>
                                 <li>Order Placed : <span> Thu, 15 Sep 22</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 0</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 20889</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> 14086</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/16" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>














                        <div class="ordersBox orderpro_1 dispatched" data-order_status="1"> <!--class="cus_orders"-->
                           <div class="ordersmllbox">
                              <div class="icon"><span class="fa fa-truck"></span></div>
                                <div class="status">
                                <span class="fa fa-check"></span> Order Placed
                                </div>                                <div class="date"><span class="fa fa-clock-o"></span>Mon, 29 Nov 21</div>
                                <div class="Amt">Order Amount : <i class="fa fa-inr"></i> 510</div>
                                <div class="totalQty"><span class="itmqty">2 Items &nbsp; <i class="fa fa-angle-down"></i></span>

                              </div>
                            </div>
                            <div class="ordersBoxshow">
                              <ul class="ordersBoxshowtop">
                                                                  <li>Order ID : <span><a href="#order-details/1" class="aClick_1">#HFG/2021/11/29/1</a></span></li>
                                 <li>Order Placed : <span> Mon, 29 Nov 21</span></li>
                                </ul>
                                <div class="ordersBoxshowbody">
                                 <div class="ordersBoxbodyInner">
                                       <p><strong>Delivery Address</strong>
                                          <span>Anubhav</span><br>
                                            test1, Bengaluru, 560069 <br><span>Ph: 8950801168</span>
                                        </p>
                                    </div>
                                    <div class="ordersBoxbodyInner">
                                       <p><strong>Payment Information</strong>
                                          <span>Payment Status : </span> <span class="text-success">Success</span><br>
                                                                                    </p>
                                    </div>
                                    <div class="ordersBoxbodyInner sm-none">
                                       &nbsp;
                                    </div>

                                    <div class="ordersBoxbodyInner summary">
                                       <ul>
                                          <p>Order Summary</p>
                                            <li><span>Delivery Charges  </span><span> : <i class="fa fa-inr"></i> 90</span></li>
                                            <li><span>Order Amount  </span><span> : <i class="fa fa-inr"></i> 510</span></li>
                                            <li><span><small>Savings  </small></span><span class="text-success"> : <i class="fa fa-inr"></i> <i class="fa fa-inr"></i> -125</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ordersBoxfooter">
                                    <a href="#order-details/1" class="aClick_1">View More Details &gt;</a>
                                </div>
                            </div>
                        </div>

                  <? */ ?>

              <? } ?>


                         </div>
               </div>
            </div>
         </div>
      </div>
      <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div>
 <script>

        document.addEventListener("DOMContentLoaded", function(){
    //alert('loaded')
  $('.ordersBox .ordersmllbox').click(function(){
    $(this).siblings().toggleClass('in fadeInUp');
    //alert('okay');
    $(this).toggleClass('active');
  })
});
      </script>



<?
$order_status_arr = array_unique($order_status_arr);

$val = '';
foreach($order_status_arr as $osa){
	$status = '';
	if($osa==1){$status =  "Order Placed";}
	else if($osa==2){$status =  "In Process";}
	else if($osa==3){$status =  "Dispatched";}
	else if($osa==4){$status =  "Delivered";}
	else if($osa==5){$status =  "Not Deliver";}
	else if($osa==6){$status =  "Cancelled";}

	$val .= '<option value="'.$osa.'">'.$status.'</option>';
}
?>
<script>
window.addEventListener('load' , function(){
	$( " #cus_orders_sel"  ).html('<?=$val?>');
	On_cus_orders_sel()
})

function On_cus_orders_sel()
{
	var cus_orders_sel = $('#cus_orders_sel').val();
	var count = 0;
	$( ".cus_orders" ).each(function() {
		console.log(cus_orders_sel + ' ; ' + $( this ).data('order_status'));
		if(cus_orders_sel == $( this ).data('order_status') )
		{
			count++;
			$( this ).fadeIn();
			$( " .order_count" , this  ).html(count+'.');
		}
		else
		{
			$( this ).fadeOut();
		}
	});
}

</script>
