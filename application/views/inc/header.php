<?
   $CI=&get_instance();
   if(empty($meta_title))
   {
    $meta_title = _project_name_;
   }

   if(empty($meta_description))
   {
    $meta_description = _project_name_;
   }

   if(empty($meta_keywords))
   {
    $meta_keywords = _project_name_;
   }

   if(empty($meta_others))
   {
    $meta_others = "";
   }


   ?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="Author" content="MARS WEB SOLUTION, contactus@marswebsolution.com, https://www.marswebsolution.com/">
      <meta name="Designer" content="MARS WEB SOLUTION" />
      <meta name="Developer" content="MARS WEB SOLUTION">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
      <meta name="Distribution" content="global">
      <meta name="robots" content="index,follow" />
      <meta name="GOOGLEBOT" content="index,follow" />
      <meta name="theme-color" content="#fbc91d" />
      <base href="<?=base_url()?>">
      <meta property="og:type" content="object" />
      <meta property="og:site_name" content="<?=_project_complete_name_?>" />
      <title><?=$meta_title?></title>
      <meta name="description" content="<?=$meta_description?>">
      <meta name="keywords" content="<?=$meta_keywords?>">
      <meta name="google-signin-scope" content="profile email">
      <meta name="google-signin-client_id" content="330446368143-adivlbaqh63du7mu7ledj52eof2e6ki1.apps.googleusercontent.com">
      <?=nl2br($meta_others)?>
      <link rel="canonical" href="https://www.annadatha.in/" />
      <link href="<?=IMAGE?>favicon.ico" rel="shortcut icon" type="x-image">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
      <!--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/> -->
      <link href="<?=CSS?>style.css" rel="stylesheet">
      <link href="<?=CSS?>responsive.css" rel="stylesheet">
      <?php /*?><script>const _switch_google_ecom_ = <?=_switch_google_ecom_?></script><?php */?>
      <?php if (!empty($direct_css)) { foreach ($direct_css as $dcss) { echo '<link rel="stylesheet" href="'.$dcss.'"  crossorigin="anonymous">'; } } ?>
      <?php if (!empty($css)) { foreach ($css as $css) { echo '<link rel="stylesheet" href="'.CSS.$css.'"  crossorigin="anonymous">'; } } ?>
      <?php if (!empty($cart_css)) { foreach ($cart_css as $cart_css) { echo '<link rel="stylesheet" href="'.CSS.$cart_css.'"  crossorigin="anonymous">'; } } ?>
      <?php if (!empty($wishlist_css)) { foreach ($wishlist_css as $wishlist_css) { echo '<link rel="stylesheet" href="'.CSS.$wishlist_css.'"  crossorigin="anonymous">'; } } ?>
      <?php if (!empty($cart_js)) { foreach ($cart_js as $cart_js) { echo '<link rel="stylesheet" href="'.CSS.$cart_js.'"  crossorigin="anonymous">'; } } ?>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@600&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@500&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@400&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <link rel="stylesheet" type="text/css" href="assets/front/css/jquery.fancybox.css" media="screen" />
      <link rel="stylesheet" type="text/css" href="assets/front/css/helpers/jquery.fancybox-buttons.css" />
      <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
      <script>
         const name_only = string => [...string].every(c => 'abcdefghijklmnopqrstuvwxyz-.ABCDEFGHIJKLMNOPQRSTUVWXYZ '.includes(c));
         const number_only = string => [...string].every(c => '0123456789'.includes(c));
      </script>
      <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BQXEGHW5CS"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BQXEGHW5CS');
</script>

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1482707232575994');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1482707232575994&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<script type="text/javascript"> adroll_adv_id = "WC52EPXZH5EV7KPN44XEAG"; adroll_pix_id = "NUDTE5HPHBDBFE4ABVZ62W"; adroll_version = "2.0";  (function(w, d, e, o, a) { w.__adroll_loaded = true; w.adroll = w.adroll || []; w.adroll.f = [ 'setProperties', 'identify', 'track' ]; var roundtripUrl = "https://s.adroll.com/j/" + adroll_adv_id + "/roundtrip.js"; for (a = 0; a < w.adroll.f.length; a++) { w.adroll[w.adroll.f[a]] = w.adroll[w.adroll.f[a]] || (function(n) { return function() { w.adroll.push([ n, arguments ]) } })(w.adroll.f[a]) }  e = d.createElement('script'); o = d.getElementsByTagName('script')[0]; e.async = 1; e.src = roundtripUrl; o.parentNode.insertBefore(e, o); })(window, document); adroll.track("pageView"); </script>
   </head>
   <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GT-WKRH4HX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'GT-WKRH4HX');
</script>
<script>
   $(function(){
    $('.selectpicker').selectpicker();
});
</script>
   <body>
      <!-- <div style="display:none" class="siteUrl"><?=base_url()?></div> -->
      <input type="hidden" class="siteUrl" value="<?=base_url()?>">
      <!-- <div class="cv_sticky"><div class="cvText-desktop"><p>Free Delivery of all products</a></p></div></div> -->

      <div class="top-header ">
         <div class="container">
            <div class="row">
               <div class="col-lg-9">
               <ul class="contact-info slash">
                              <li class="contact-phone pb-1">
                                 <i class="fa fa-phone"></i>
                                 <a href="tel:<?=_project_contact_?>"><?=_project_contact_?>  <br> <a href="/ tel:<?=_project_contact2_?>"><?=_project_contact2_?></a></li>

                           </ul>
               </div>
               <div class="col-lg-2">
                 <div class="form-select"  aria-label="Default select example" id="google_translate_element"></div>
               <!-- <select class="form-select"  aria-label="Default select example">
  <option selected disabled>Select Your Language</option>
  <option value="1">English</option>
  <option value="2">Kannada</option>
  <option value="3">Telugu</option>
</select> -->
               </div>
            </div>

         </div>
      </div>

      <header id="header " class="deskdnn sticky-top ">
         <section class="dt-sc-header-top-bar ">
            <div class="container">
               <div class="row align-items-center align-justify-center">
                  <div class="col-lg-2 col-3">
                     <!-- <div class="header-note">
                        <div class="site-branding"> -->
                           <div class="headerlogo">
                              <h1 class="site-title"><a class="navbar-brand home-link" href="<?=base_url()?>"><span class="themestek-sc-logo themestek-sc-logo-type-image"><img src="<?=IMAGE?>logo.jpg" alt="<?=_project_complete_name_?>" title="<?=_project_complete_name_?>"></span></a></h1>
                           </div>
                        <!-- </div>
                     </div> -->
                  </div>
                  <div class="col-lg-3">
                     <div class="cv_sticky">
                        <div class="cvText-desktop">
                           <p style="display: flex;">
                              <? if(!empty($runningLines)){ ?>
                              <? foreach($runningLines as $rl){ ?>
                              <? if(!empty($rl->running_line_link)){echo '<a href="">';} ?>
                              <marquee><?=$rl->running_line_title?></marquee>
                              <? if(!empty($rl->running_line_link)){echo '</a>';} ?>
                              <? } ?>
                              <? } ?>
                           </p>
                        </div>
                     </div>
                     <? if($check_screen == 'isdesktop'){ ?>
                     <div class="searchbar">
                        <form  name="searchSuggForm" id="autocomplete" method="get" action="" autocomplete="off">
                           <a class="nav-link-ser " id="navbarDropdownMenuLink1">
                           <input id="searchSugg" tabindex="0"   type="text" name="searchSugg" class="input-text algolia-search-input aa-input searchSugg"   placeholder="Search...." role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="">
                           <button class="search_btn1" type="submit"></button>
                           <span data-clear-input style="cursor: pointer; display:none" class="search_close_btn"><i class="fa fa-close"> </i></span>
                           </a>
                        </form>
                     </div>
                     <div class=" dropdown-menu  getSuggestionDropdown" style="float:left;width:1000px;overflow-y: auto;height: 450px;display:none">
                     </div>
                     <? } ?>
                  </div>
                  <div class="col-lg-5 col-3">
                     <nav class="navbar navbar-expand-lg navbar-light">
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"> <i class="fa fa-bars"></i></span>
               </button>
               <div class="collapse navbar-collapse flex-lg-column" id="navbarRightAlignExample">
                  <ul class="nav navbar-nav menu mr-auto ">
                     <!-- main -->
                     <li class="nav-item  " ><a  href="<?=MAINSITE?>">Home</a></li>
                     <? if(!empty($menu)){ ?>
                     <? foreach($menu as $m){ ?>
                     <li class="nav-item <? if(!empty($m->sub_category)){ ?> dropdown submenu1<? } ?>" style="position: relative !important;">
                        <a class="nav-link  <? if(!empty($m->sub_category)){ ?>dropdown-toggle  <? } ?>" href="<?=$m->slug_url?>" id="navbarDropdownMenuLink" role="button" <? if(!empty($m->sub_category)){ ?>  <? } ?><? if(!empty($m->sub_category)){ ?> <? } ?>>  <?=$m->name?>  <? if(!empty($m->sub_category)){ ?><i class="fa fa-angle-down" aria-hidden="true"></i><?php } ?>
                        </a>
                        <? if(!empty($m->sub_category)){ ?>
                        <ul class="dropdown-menu submenu2" aria-labelledby="navbarDropdownMenuLink">
                           <? foreach($m->sub_category as $sc){ ?>
                           <li class="dropdown-item <? if(!empty($sc->super_sub_category)){ ?>dropdown <? } ?>">
                              <a class="dropdown-item" href="<?=$m->slug_url?>/<?=$sc->slug_url?>"> <?=$sc->name?> <? if(!empty($sc->super_sub_category)){ ?>&raquo; <? } ?></a>
                              <? if(!empty($sc->super_sub_category)){ ?>
                              <ul class="submenu dropdown-menu">
                                 <? foreach($sc->super_sub_category as $ssc){ ?>
                                 <li><a class="dropdown-item" href="<?=$m->slug_url?>/<?=$sc->slug_url?>/<?=$ssc->slug_url?>"><?=$ssc->name?></a></li>
                                 <? } ?>
                              </ul>
                              <? } ?>
                           </li>
                           <? } ?>
                        </ul>
                        <? } ?>
                     </li>
                     <? } ?>
                     <? } ?>

                  </ul>
               </div>
            </nav>
                  </div>
                  <div class="col-lg-2 col-3">
                     <ul class="cart_sectin">
                        <li class="dropdown11">
                           <span class="dropbtn">
                              <? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ ?><a href="<?=base_url(__dashboard__)?>"><i class="fa fa-user"></i></a><?php } else { ?><a href="<?=base_url(__login__)?>"><i class="fa fa-user"></i></a><?php } ?>
                              <div class="dropdown-content">
                                 <ul class="profile-dropdown">
                                    <?php if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){} else { ?>
                                    <li><a  href="<?=base_url(__signup__);?>"><img src="assets/front/images/prof.png" style="width: 15px">  New Customer? Sign Up</a></li>
                                    <?php } ?>
                                    <li><a  href="<? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ echo base_url(__dashboard__); } else {echo base_url(__login__);}?>"><img src="assets/front/images/prof.png" style="width: 15px">  My Profile</a></li>
                                    <li><a  href="<? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ echo base_url(__orderHistory__); } else {echo base_url(__login__);}?>"><img src="assets/front/images/card.png" style="width: 15px"> Orders</a></li>
                                    <li><a  href="<? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ echo base_url(__wishlist__); } else {echo base_url(__login__);}?>"><img src="assets/front/images/wishlist.png" style="width: 20px" > Wishlist</a></li>
                                    <? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ ?>
                                    <li ><a href="<?=base_url(__logout__)?>" ><img src="assets/front/images/log.png" style="width: 20px">  Logout</a></li>
                                    <?php } ?>
                                 </ul>
                              </div>
                           </span>
                        </li>
                        <li><a style="cursor: pointer;" <? if(empty($is_cart_btn)){ ?>onClick="cartopenNav()"<? } ?>><i class="fa fa-shopping-cart"></i><span class="cart_counts sess_cart_count"><?=$this->session->userdata('application_sess_cart_count');?></span></a></li>
                        <li><a href="<?=__wishlist__?>" title="Wishlist" ><i class="fa fa-heart-o img-responsive"></i><span class="wishlist_counts sess_wishlist_count"><?=$this->session->userdata('application_sess_wishlist_count');?></span></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </section>

      </header>
      <header id="header" class="mbnn sticky-top">
         <section class="logo_left sticky-header-active" id="sticky-header-active">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg-6 col-5">
                     <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="site-branding">
                           <div class="headerlogo ">
                              <h1 class="site-title">
                                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                 <span class="navbar-toggler-icon"><i class="fa fa-bars"></i></span>
                                 </button>
                                 <a class="navbar-brand home-link" href="<?=base_url()?>">
                                 <span class="themestek-sc-logo themestek-sc-logo-type-image">
                                 <img src="<?=IMAGE?>logo.jpg">
                                 </span>
                                 </a>
                              </h1>
                           </div>
                        </div>
                        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                           <ul class="nav navbar-nav menu mr-auto">

                              <? if(!empty($menu)){ ?>
                                 <li class="nav-item  " ><a style="color:white;" href="<?=MAINSITE?>">Home</a></li>
                              <? foreach($menu as $m){ ?>
                              <li class="nav-item <? if(!empty($m->sub_category)){ ?> dropdown submenu1<? } ?>" style="position: relative !important;">
                                <a class="nav-link1  " href="<?=$m->slug_url?>" >  <?=$m->name?>  <? if(!empty($m->sub_category)){ ?>  </a><a class=" <? if(!empty($m->sub_category)){ ?>dropdown-toggle  <? } ?>" id="navbarDropdownMenuLink" role="button" <? if(!empty($m->sub_category)){ ?> data-bs-toggle="dropdown" aria-expanded="false" <? } ?><? if(!empty($m->sub_category)){ ?> <? } ?>><i class="fa fa-angle-down" aria-hidden="true"></i><?php } ?></a>
                                 <? if(!empty($m->sub_category)){ ?>
                                 <ul class="dropdown-menu submenu2" aria-labelledby="navbarDropdownMenuLink">
                                    <? foreach($m->sub_category as $sc){ ?>
                                    <li class="dropdown-item <? if(!empty($sc->super_sub_category)){ ?>dropdown <? } ?>">
                                       <a class="dropdown-item" href="<?=$m->slug_url?>/<?=$sc->slug_url?>"> <?=$sc->name?> <? if(!empty($sc->super_sub_category)){ ?>&raquo; <? } ?></a>
                                       <? if(!empty($sc->super_sub_category)){ ?>
                                       <ul class="submenu dropdown-menu">
                                          <? foreach($sc->super_sub_category as $ssc){ ?>
                                          <li><a class="dropdown-item" href="<?=$m->slug_url?>/<?=$sc->slug_url?>/<?=$ssc->slug_url?>"><?=$ssc->name?></a></li>
                                          <? } ?>
                                       </ul>
                                       <? } ?>
                                    </li>
                                    <? } ?>
                                 </ul>
                                 <? } ?>
                              </li>
                              <? } ?>
                              <? } ?>
                           </ul>
                        </div>
                     </nav>
                  </div>
                  <div class="col-lg-6 col-7">
                     <ul class="cart_sectin">
                        <li class="dropdown11">
                           <span class="dropbtn">
                              <? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ ?>
                              <a href="<?=base_url(__dashboard__)?>"><i class="fa fa-user"></i></a><?php } else { ?>
                              <a href="" data-bs-toggle="collapse" data-bs-target="#user12"><i class="fa fa-user"></i></a>
                              <!-- <a href="<?=base_url(__login__)?>"><i class="fa fa-user"></i></a> -->
                              <?php } ?>
                           </span>
                        </li>
                        <li onClick="cartopenNav()"><a ><i class="fa fa-shopping-cart"></i> <span class="cart_counts sess_cart_count"><?=$this->session->userdata('application_sess_cart_count');?></span></a></li>
                        <!--   <li><a href="<?=__cart__?>"><i class="fa fa-shopping-cart"></i> Cart<span class="cart_counts sess_cart_count"><?=$this->session->userdata('application_sess_cart_count');?></span></a></li> -->
                        <li><a href="<?=__wishlist__?>" title="Wishlist" ><i class="fa fa-heart-o img-responsive"></i><span class="wishlist_counts sess_wishlist_count"><?=$this->session->userdata('application_sess_wishlist_count');?></span></a></li>
                        <div class="collapse navbar-collapse offset" id="user12">
                           <div class="collapse navbar-collapse offset" id="user12">
                              <ul class="profile-dropdown nav navbar-nav">
                                 <?php if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){} else { ?>
                                 <li class="dropdown-item"><a  href="<?=base_url(__signup__);?>"><img src="assets/front/images/prof.png" style="width: 15px">  New Customer? Sign Up</a></li>
                                 <?php } ?>
                                 <li><a  href="<? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ echo base_url(__dashboard__); } else {echo base_url(__login__);}?>"><img src="assets/front/images/prof.png" style="width: 15px">  My Profile</a></li>
                                 <li><a  href="<? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ echo base_url(__orderHistory__); } else {echo base_url(__login__);}?>"><img src="assets/front/images/card.png" style="width: 15px"> Orders</a></li>
                                 <li><a  href="<? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ echo base_url(__wishlist__); } else {echo base_url(__login__);}?>"><img src="assets/front/images/wishlist.png" style="width: 20px" > Wishlist</a></li>
                                 <? if(!empty($temp_name) && !empty($temp_id) && $login_type != 'guest'){ ?>
                                 <li ><a href="<?=base_url(__logout__)?>" ><img src="assets/front/images/log.png" style="width: 20px">  Logout</a></li>
                                 <?php } ?>
                              </ul>
                           </div>
                        </div>
                     </ul>
                  </div>
               </div>
            </div>
         </section>
         <? if($check_screen != 'isdesktop'){ ?>
         <div class="searchbar mt-2 mb-2">
            <form  name="searchSuggForm" id="autocomplete" method="get" action="" autocomplete="off">
               <a class="nav-link-ser " id="navbarDropdownMenuLink1">
               <input id="searchSugg" tabindex="0"   type="text" name="searchSugg" class="input-text algolia-search-input aa-input searchSugg"   placeholder="Search...." role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="">
               <button class="search_btn1" type="submit"></button>
               <span data-clear-input style="cursor: pointer; display:none" class="search_close_btn"><i class="fa fa-close"> </i></span>
               </a>
            </form>
         </div>
         <div class=" dropdown-menu  getSuggestionDropdown" style="float:left;width:1000px;overflow-y: auto;height: 450px;display:none">
         </div>
         <? } ?>
      </header>

      <div id="overlay" class=""></div>
      <div id="cart-mySidenav" class="cart-sidenav">
         <a href="javascript:void(0)" class="closebtn aClick_1" onClick="cartcloseNav()">×</a>
         <div class="cartfloating-form contact_form visiable" >
            <div class="cartleftFilterHead"><span class="contact_opener" onClick="cartcloseNav()"></span>&nbsp; Cart </div>
         </div>
         <div class="float_cart">
         <?php /*?><div class="row align-items-center justify-content-center">
            <div class="col-lg-4 col-4">
               <img src="assets/uploads/product/medium/product_4_4.png">
            </div>
            <div class="col-lg-8 col-8">
               <div class="CartItem__Info">
                  <h2 class="CartItem__Title Heading">
                     <a href="/products/geometric-pineapple-accent-pink?variant=42441099313308">Geometric Pineapple Accent - Pink</a>
                  </h2>
                  <div class="CartItem__Meta Heading Text--subdued">
                     <div class="CartItem__PriceList"><span class="CartItem__Price Price" data-money-convertible="">Rs. 2,995</span></div>
                  </div>
                  <div class="button_wrap align-items-center mt-3" style="float: left !important;">
                     <div class="row align-items-center justify-content-center" >
                        <div class="col-lg-8 col-8">
                           <span class="QtyincreDecre list_detail">
                           <button class=" btn-default btn-number incToCartListBTN" data-val="13,4,13,1"><span class="glyphicon glyphicon-minus"></span></button>
                           <span class="cart_quntity cart_increment_13" style="padding: 20px;">2</span>
                           <button class=" btn-default btn-number incToCartListBTN" data-val="13,4,13,2"><span class="glyphicon glyphicon-plus"></span></button>
                           </span>
                        </div>
                        <div class="col-lg-4 col-4">
                           <a href="#" class="cart-remove" >Remove</a>
                        </div>
                     </div>
                  </div>
               </div>


            </div>
         </div>
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-4 col-4">
               <img src="assets/uploads/product/medium/product_4_4.png">
            </div>
            <div class="col-lg-8 col-8">
               <div class="CartItem__Info">
                  <h2 class="CartItem__Title Heading">
                     <a href="/products/geometric-pineapple-accent-pink?variant=42441099313308">Geometric Pineapple Accent - Pink</a>
                  </h2>
                  <div class="CartItem__Meta Heading Text--subdued">
                     <div class="CartItem__PriceList"><span class="CartItem__Price Price" data-money-convertible="">Rs. 2,995</span></div>
                  </div>
                  <div class="button_wrap align-items-center mt-3" style="float: left !important;">
                     <div class="row align-items-center justify-content-center" >
                        <div class="col-lg-8 col-8">
                           <span class="QtyincreDecre list_detail">
                           <button class=" btn-default btn-number incToCartListBTN" data-val="13,4,13,1"><span class="glyphicon glyphicon-minus"></span></button>
                           <span class="cart_quntity cart_increment_13" style="padding: 20px;">2</span>
                           <button class=" btn-default btn-number incToCartListBTN" data-val="13,4,13,2"><span class="glyphicon glyphicon-plus"></span></button>
                           </span>
                        </div>
                        <div class="col-lg-4 col-4">
                           <a href="#" class="cart-remove" >Remove</a>
                        </div>
                     </div>
                  </div>
               </div>


            </div>
         </div>


         <div class="cart-footer">
          <div  class="ccc">
          <p >Prices Include GST &amp; Free Shipping</p>
          <a href="#smile-home"> Sign Up For MQ Rewards To Redeem For Special Offers Discounts</a>
        </div>


          <a class="mt-3 ccc" onClick="noteopenNav()">Add A Note To Your Order</a>
          <div id="mySidenote" class="addnote">
            <div style="     padding: 0px 30px 0px 30px;
">

<span class="Cart__NoteButton">Add A Note To Your Order</span>
<div class="Form__Item ">
              <textarea ></textarea>
            </div>

            <button type="button" class="notesave" data-action="toggle-cart-note" onClick="notecloseNav()">Save</button>
</div>
</div>
<div  class="ccc">
          <button type="submit" name="checkout" class="cart_buton3 btn-chechout1 ccc" >
         <span>Checkout - Rs. 14,565</span>
        </button>
      </div>
         </div><?php */?>
         </div>

      </div>
      <!--  <div id="overlay" class=""></div>
         <div id="side-menu" class="main-side-nav">
                 <a id="close-menu" class="menuCloseButton" onclick="closeSideNav()"><span id="side-menu-close-text">
                     Close Menu</span><span class="menu-Close "></span></a>
                 <ul class="mainMenu nav">
                     <li class="active"><a href="">Home</a></li>
                     <li><a href="">Help</a></li>
                     <li><a href="">Contact us</a></li>
                 </ul>
             </div> -->
