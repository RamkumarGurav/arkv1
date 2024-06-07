
      
      
        <nav  class="breadcrumb ">
  <ol>
      <li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Wishlist</span></li>
  </ol>
</nav>
<div class="container">
         <div class="row ">
            <?php $this->load->view('template/left-menu', $this->data);?>
            <div class="col-md-9">
               <h4 class="form_headr1">My Wishlist <?php if($this->session->userdata('application_sess_wishlist_count') > 0) { ?><span class="wishlist_counts sess_wishlist_count">(<?=$profileWishlistCount->counts?>)</span><?php } ?></h4>
               <div class="bagaininner2">
                        <div class="row m-0">
                          <div class="bagain-leftside col-lg-12 p-0 pr-lg-2"><!---->
                                 
                              
                        <? if(!empty($products_list)){ ?> 
                         <div class="prodlists wishlistPage"><!---->     
					<? 
					
					$this->load->view('template/wishlist' , $this->data); 
          ?>
                    </div>
					<? }else{ ?>
                    <div class=" col-md-12 wishlistPage wishlistPageEmpty">
					<img src="<?=__scriptFilePath__?>images/empty-wishlist.png">
					
                    <a href="<?=base_url()?>all-products" class="empty_notif_3">
                      <button class="proceed_ckt"><i class="fa fa-shopping-cart"></i> <span> Continue Shopping</span></button></a><br><br>
                    </div>
					<? } ?>	
                                  
                       
                        </div><!---->
                           
                          </div>
                          <div class="bagain-rightside col-lg-4"><!----><!---->
                            
                            
                          </div>
                        </div>
                      </div>
            </div>
         </div>
   
      <!-- <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div> -->
         