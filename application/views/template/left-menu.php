
   <link href="<?=CSS?>my-account.css" rel="stylesheet">

<div class=" col-md-3 col-12 mob-p0">
  <div class="user-dv">
  <div class="user-dv-main">
   <div class="user-div">
      <div class="user-sub row">
         <img class="user-icon" height="50px" width="50px" src="assets/front/images/profile-pic.svg">
         <div class="user-detail">
            <div class="user-content">Hello<?php if(!empty($profile->name)){ echo " ,";}?></div>
            <?php if(!empty($profile->name)){ ?><div class="user-name sess_user_name"><?=$profile->name;?></div><?php } ?>
         </div>
      </div>
   </div>  
   <div class="usr-toggle">
   <img class="usr-toggle-img" src="assets/front/images/chevron-right.png">
   </div>
   </div>
    <div class="usr-dv-sub">
    <div class="user-div mr-bt-16">
      <div class="user-second-sub row">
         <div class="pdb-12">
            <img class="second-sub-img" src="assets/front/images/arrow.png">
            <a class="second-sub-link" href="<?=base_url(__orderHistory__)?>">MY ORDERS<span class="second-sub-span"><svg width="16" height="27" viewBox="0 0 16 27" xmlns="http://www.w3.org/2000/svg" class="second-sub-span-img"><path d="M16 23.207L6.11 13.161 16 3.093 12.955 0 0 13.161l12.955 13.161z" fill="#878787" class=""></path></svg></span></a>
         </div>
      </div>
</div>
<div class="user-div ">
     <div class="user-second-sub row">
      <div class="pdb-12">
            <img class="second-sub-img" src="assets/front/images/prof.png">
            <a class="second-sub-link1" >ACCOUNT SETTINGS</a>
         </div>
     
     </div>
     <div>
     

      <div class="pdb-12">
      <a href="<?=base_url(__dashboard__)?>"><div class="drop-info  <?=($active_left_menu=='profile_information')?' drop-info-i drop-info-active':''?>">Profile Information</div></a>
      <a href="<?=base_url(__shippingAddress__)?>"><div class="drop-info <?=($active_left_menu=='manage_address')?'drop-info-i drop-info-active':''?>">Manage Addresses</div></a>
      <a href="<?=base_url(__profileGSTInformation__)?>"><div class="drop-info <?=($active_left_menu=='gst_information')?'drop-info-i drop-info-active':''?>">GST Information</div></a>
   </div>
     </div>
     <div class="bordr-btm"></div>
   </div>

   <div class="user-div mr-bt-16">
     <div class="user-second-sub row">
      <div class="pdb-12">
            <img class="second-sub-img" src="assets/front/images/card.png">

            <a class="second-sub-link1" >MY STUFF</a>
         </div>
     
     </div>
     <div>
      <div class="pdb-12">
           <a href="<?=base_url(__reviewRatings__)?>"><div class="drop-info <?=($active_left_menu=='manage_address')?'drop-info-i drop-info-active':''?>">My Reviews & Ratings</div></a>
    <!--   <a href="#"><div class="drop-info">My Reviews & Ratings</div></a> -->
      <a href="<?=__wishlist__?>"><div class="drop-info <?=($active_left_menu=='wishlist')?'drop-info-i drop-info-active':''?>">My Wishlist <?php if($this->session->userdata('application_sess_wishlist_count') > 0) { ?><span class="wishlist_counts sess_wishlist_count">(<?=$wishlist_count?>)</span><?php } ?></div></a>
   </div>
     </div>
     <div class="bordr-btm"></div>
   </div>
<div class="user-div mr-bt-16">
     <div class="user-second-sub row">
      <div class="pdb-12">
            <img class="second-sub-img" src="assets/front/images/log.png">

            <a href="<?=base_url(__logout__)?>" class="second-sub-link1" >Logout</a>
         </div>
     
     </div>
    
     <div class="bordr-btm"></div>
   </div>
    </div>
  </div>
               <!-- <div class="sticky-position ">
                  <div class="custome-link ng-star-inserted">
                     <div class="linkcol">
                        <div>
                           <a href="<?=base_url();?>dashboard" class="offers-link aClick_1"><i class="fa fa-tachometer"></i>My Dashboard</a>
                           <a href="<?=base_url();?>profile" class="offers-link aClick_1"><i class="fa fa-user-o"></i>My Profile</a>
                           <a href="<?=base_url();?>shipping-address" class="help-link aClick_1"><i class="fa fa-map-marker"></i>Manage Addresses</a> 
                           <a href="<?=base_url();?>order-history" class="help-link aClick_1"><i class="fa fa-shopping-bag"></i>My Orders</a>
                           <a href="<?=base_url(__changePassword__);?>" class="help-link aClick_1"><i class="fa fa-shopping-bag"></i>Change Password</a>
                        </div>
                        <a class="logout-link ng-star-inserted aClick_1" href="<?=base_url(__logout__);?>"><i class="fa fa-sign-out"></i>Logout </a>
                     </div>
                  </div>
               </div> -->
            </div>

