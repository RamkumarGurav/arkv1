<!-- <div class="container mbnn">
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
                  </div> -->
<section class="sliderarea">

   <?php if (!empty($banners)) { ?>


      <div id="carousel" class="carousel slide carousel-fade homeslider  " data-bs-ride="carousel" data-bs-interval="1000"
         data-bs-wrap="true" data-pause="hover" autoplay="true">
         <div class="carousel-indicators">
            <?
            $img_count = 0;
            foreach ($banners as $b) {
               $img_count++;
               ?>
               <button type="button" data-bs-target="#carousel" data-bs-slide-to="<?= ($img_count - 1) ?>"
                  class="<? if ($img_count == 1) { ?>active<? } ?>" aria-current="true"
                  aria-label="Slide <?= $img_count ?>"></button>
            <? } ?>
         </div>

         <div class="ttloading-bg" style="display: none;"></div>
         <ul class="carousel-inner" role="listbox">
            <?
            $img_count = 0;
            foreach ($banners as $b) {
               $img_count++;
               ?>
               <li class="carousel-item <? if ($img_count == 1) { ?>active<? } ?>" role="option" aria-hidden="false"
                  data-bs-interval="3000">
                  <a href="<?php if (!empty($b->link) && $b->link != '#') {
                     echo $b->link;
                  } else {
                  }
                  ; ?>">
                     <figure>
                        <img src="<?= _uploaded_files_ ?>banner/<?= $b->image ?>" class="">

                        <figcaption class="caption">
                           <h2 class="display-1 text-uppercase">
                              <?= $b->title1 ?>
                           </h2>
                           <div class="caption-description">
                              <h3>
                                 <?= $b->title2 ?>
                              </h3>
                              <p>
                                 <?= $b->title3 ?>
                              </p>
                           </div>
                        </figcaption>
                     </figure>
                  </a>
               </li>
            <?php } ?>


         </ul>

         <div class="direction" aria-label="Carousel buttons">
            <a class="left carousel-control" href="#carousel" role="button" data-bs-slide="prev">
               <span class="icon-prev hidden-xs" aria-hidden="true"><i class="material-icons"></i></span>
               <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-bs-slide="next">
               <span class="icon-next" aria-hidden="true"><i class="material-icons"></i></span>
               <span class="sr-only">Next</span>
            </a>
         </div>
      </div>
   <?php } ?>

</section>
<section class="home-about">
   <div class="container">
      <div class="ha-inner">
         <div class="row">
            <div class="hai-l col-lg-6 col-12">
               <div class="hail-inner">
                  <div class="hail-main-title">
                     <h4>Healthy Foods</h4>
                     <h3>Together, let's sow the seeds of prosperity and harvest a brighter future for agriculture.</h3>
                  </div>
                  <div class="hail-content">
                     <p>At Annadatha Rythu Seva Kendram, we're more than just a business - we're your dedicated partner in agriculture. With a rich legacy spanning over three decades, we've been a trusted name in providing farmers with the finest quality pesticides, seeds, and fertilizers. Our commitment to nurturing your crops and helping your yields flourish has been unwavering since our inception.</p>
                  </div>
                  <div class="hail-btn">
                     <a href="#" class="ab-btn">Read More</a>
                  </div>
               </div>
            </div>
            <div class="hai-r col-lg-6 col-12">
               <div class="hair-inner">
                  <div class="row">
                     <div class="col-6 haic">
                        <img src="<?= IMAGE ?>ab-i1.png" alt="">
                        <h3>Expertise</h3>
                        <p>With three decades of experience, we possess the knowledge and insight to provide you with tailored solutions for your crops.</p>
                     </div>
                     <div class="col-6 haic">
                        <img src="<?= IMAGE ?>ab-i2.png" alt="">
                        <h3>Quality Assurance</h3>
                        <p>Our products undergo rigorous testing to ensure they meet the highest standards of quality and effectiveness.</p>
                     </div>
                     <div class="col-6 haic">
                        <img src="<?= IMAGE ?>ab-i2.png" alt="">
                        <h3>Convenience</h3>
                        <p>Through our user-friendly e-commerce platform, you can access the products you need from the comfort of your farm. </p>
                     </div>
                     <div class="col-6 haic">
                        <img src="<?= IMAGE ?>ab-i1.png" alt="">
                        <h3>Community</h3>
                        <p>Join a community of like-minded farmers who trust Annadatha Rythu Seva Kendram for their agricultural needs.</p>
                     </div>
                  </div>
               </div>

            </div>
         </div>
         <div class="hai-badge">
            <div class="haib-inner">
               <img src="<?= IMAGE ?>about-badge1.png" alt="">
            </div>
         </div>
      </div>
</section>
<!-- <div id="greenfield-section-template--14390924181538__1641555178b50ebe4b"
   class="greenfield-section index-section home-specification-banner">
   <div class="dt-sc-section-wrapper    " style="
            background-size:auto;  background-repeat:no-repeat;">
      <div class="container">
         <div class="row specification-one">
            <div class="dt-sc-grid-banner-section dt-sc-specification-grid-banner style3 position-default ">
               <div class="dt-sc-main-grid dt-sc-column mbdnn">

                  <div class="dt-sc-grid-banner  overlay-style  ">
                     <div class="dt-sc-grid-banner-image with-overlay">
                        <img class="dt-sc-brand-image lazyautosizes ls-is-cached lazyloaded"
                           src="<?= IMAGE ?>home-banner3.jpg">
                     </div>

                  </div>

               </div>
               <div class="dt-sc-additional-grids four-items order-1 order-lg-2">
                  <div class="dt-sc-heading text-start">
                  </div>
                  <div class="comman-block-section dt-sc-column two-column">
                     <a href="<?= base_url() . 'all-products?order=5' ?>">
                        <div class="dt-sc-support-block default  ">
                           <div class="dt-sc-support-icon-image">
                              <img src="<?= IMAGE ?>best-seller.png" alt="">
                           </div>
                           <div class="dt-sc-support-content">
                              <h3 class="dt-sc-support-heading">Best Sellers</h3>
                              <p class="dt-sc-support-description"> Shop for top in line products</p>
                           </div>
                        </div>
                     </a>
                     <a href="gardening-tips">
                        <div class="dt-sc-support-block default  ">
                           <div class="dt-sc-support-icon-image">
                              <img src="<?= IMAGE ?>gardening.png" alt="">
                           </div>
                           <div class="dt-sc-support-content">
                              <h3 class="dt-sc-support-heading">Gardening Tips &amp; Techniques</h3>
                              <p class="dt-sc-support-description">Read our experts advice on gardening</p>
                           </div>
                        </div>
                     </a>
                     <a href="groundwater-targeting">
                        <div class="dt-sc-support-block default  ">
                           <div class="dt-sc-support-icon-image">
                              <img src="<?= IMAGE ?>ground-water.png" alt="">
                           </div>
                           <div class="dt-sc-support-content">
                              <h3 class="dt-sc-support-heading">Groundwater targeting</h3>
                              <p class="dt-sc-support-description"> AI integrated Groundwater Targeting and Source
                                 Sustainability</p>
                           </div>
                        </div>
                     </a>
                     <a href="make-your-own-mixes">
                        <div class="dt-sc-support-block default  ">
                           <div class="dt-sc-support-icon-image">
                              <img src="<?= IMAGE ?>base-ingredients.png" alt="">
                           </div>
                           <div class="dt-sc-support-content">
                              <h3 class="dt-sc-support-heading">Base Ingredients</h3>
                              <p class="dt-sc-support-description"> Mix ingredients as per your need</p>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="dt-sc-main-grid dt-sc-column dskpnn">

                  <div class="dt-sc-grid-banner  overlay-style  ">
                     <div class="dt-sc-grid-banner-image with-overlay">
                        <img class="dt-sc-brand-image lazyautosizes ls-is-cached lazyloaded"
                           src="<?= IMAGE ?>home-banner-2.png">
                     </div>

                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</div> -->
<div id="greenfield-section-template--14390924181538__16419905833b4c61c9"
   class="greenfield-section index-section home-product-carousel pc-home">
   <div class="dt-sc-section-wrapper    " style="
            background-size:auto;  background-repeat:no-repeat;">
      <div class="container">

         <div class="row  product-page">
            <div class="dt-sc-heading  text-start">
               <div class="cont-form">
                  <h1 class="dt-sc-main-heading">Shop Categories</h1>
                  <!-- <div class="btn-display">
                     <a href="/collections/trending-collection" class="dt-sc-btn">View More</a>
                  </div> -->
               </div>
            </div>
            <div class=" main-block mt-3">
               <div data-section-id="blockCarousel" data-section-type="home-blockCarousel-section">
                  <div class=" dT_vDynamicPWrap-template--14390924181538__16419905833b4c61c9 dT_vProdWrap">
                     <div class="owl-slider">
                        <div class="owl-slider">
                           <div id="categories" class="owl-carousel dt-sc-testimonial-section default swiper-wrapper">
                              <?php
                              foreach ($index_category as $homepage_category_list) {
                                 ?>
                                 <div class="item">
                                    <div class="products">
                                       <div class="product-container">
                                          <a href="<?= $homepage_category_list->slug_url; ?>"
                                             class="grid-link product-group">
                                             <div class="image_group">
                                                <div class="ImageOverlayCa"></div>
                                                <img
                                                   src="<?= _uploaded_files_ ?>category/<?= $homepage_category_list->cover_image; ?>"
                                                   alt="" width="370" height="475" loading="lazy"
                                                   class="featured-image teaser lazyloaded">
                                             </div>
                                          </a>
                                          <div class="product_right_tag  "></div>

                                       </div>
                                       <div class="product-detail content-left">
                                          <h4 class="grid-link__title"><a
                                                href="<?= $homepage_category_list->slug_url; ?>"><?= $homepage_category_list->name ?></a>
                                          </h4>
                                          <div class="grid-link__meta">
                                             <a href="<?= $homepage_category_list->slug_url; ?>">View More</a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- <div id="greenfield-section-template--14390924181538__1642049210601396d2"
   class="greenfield-section index-section home-grid-banner">
   <div class="dt-sc-section-wrapper  dt-sc-overlay lazyloaded" style="
            background-position:center center; background-size:auto;  background-repeat:no-repeat;" data-bgset=""
      data-sizes="auto" data-parent-fit="cover" data-image-loading-animation="">
      <div class="container">
         <div class="row home-grid-page">
            <div class="dt-sc-grid-banner-section dt-sc-column   ">
               <div class="dt-sc-grid-banner  list-style  dt-sc-reverse-columns content-1642049210359db732-0">
                  <div class="dt-sc-grid-banner-image with-overlay">
                     <div class="img-display">
                        <img class="lazyautosizes ls-is-cached lazyloaded" src="<?= IMAGE ?>farmer.jpg"
                           data-src="<?= IMAGE ?>farmer.jpg"
                           data-widths="[180, 360, 470, 600, 770, 970, 1060, 1280, 1512, 1728, 2048]"
                           data-aspectratio="0.9007633587786259" data-sizes="auto" alt="Planting New Fresh Plants"
                           sizes="549px">
                        <noscript>
                           <img
                              src="//cdn.greenfield.com/s/files/1/0560/7145/4754/files/image-6_64f2f687-6230-478b-9ad0-6ceec05262f7_480x480@2x.png?v=1643457541"
                              alt="" class="dt-sc-noscript-image" />
                        </noscript>
                     </div>
                  </div>
                  <div class="dt-sc-grid-banner-content
                           center
                           ">
                     <div class="dt-sc-grid-banner-inner text-start">
                        <h1 class="dt-sc-main-title">Make Your Own Mixes</h1>
                        <p class="dt-sc-description">For those of you who would love to experiment with their gardening
                           inputs, we at Greenfield offer 100% Organic and Naturally occurring Soils and Minerals which
                           are pure, safe and easy to handle.
                           So give your imagination wings and let it soar high!
                        </p>
                        <div class="dt-sc-divider">
                           <ul>
                              <li>
                                 <i class="fa fa-check"></i>Easy Garden Grow
                              </li>
                              <li>
                                 <i class="fa fa-check"></i>
                                 Comfortable
                              </li>
                              <li>
                                 <i class="fa fa-check"></i>Inexpensive
                              </li>
                           </ul>
                        </div>
                        <a href="<?= base_url(); ?>make-your-own-mixes" class="dt-sc-btn">Order Now</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div> -->
<!-- <section class="had-banner">
   <div class="container">
      <div class="hadb-inner text-center">
      <h4>Healthy Foods</h4>
                     <h3>We’re Best Agriculture
                        & Organic Firms</h3>
                        <p>Give lady of they such they sure it. Me contained explained my education. Vulgar as hearts by
                        garret. Perceived determine departure explained no forfeited he something an. Contrasted
                        dissimilar get joy you instrument out reasonably. Again keeps at no meant stuff. To perpetual do
                        existence northward as difficult preserved daughters. Continued at up to zealously necessary
                        breakfast. Surrounded sir motionless she end literature. Gay direction neglected ..</p>
                        <a href="#" class="ab-btn">Read More</a>
      </div>
   </div>
</section> -->
<section class="home-offer">
  <a href="#"><img src="<?= IMAGE ?>d-banner.jpg" alt="discount-banner"></a>
</section>
<div id="greenfield-section-template--14390924181538__1642049865b7c92687"
   class="greenfield-section index-section home-product-carousel home-product-tab">
   <div class="dt-sc-section-wrapper    " style="
            background-size:auto;  background-repeat:no-repeat;">
      <div class="container">
         <div class="row  product-tab">
            <div class="dt-sc-heading  text-center" style="    margin-bottom: 0px !important;">
               <div class="cont-form">
                  <h1 class="dt-sc-main-heading">Most Popular Products</h1>
                  <!-- <div class="btn-display">
                     <a href="<?= base_url() . 'all-products?order=5' ?>" class="dt-sc-btn">View More</a>
                  </div> -->
               </div>
            </div>
            <div class=" mt-4">
               <!--   <div class="owl-slider"> -->
               <div>

                  <div class="slider_best_sellers owl-carousel dt-sc-testimonial-section default swiper-wrapper"
                     id="slider_best_sellers">
                     <!-- <div class="product-miniature col-lg-3 col-6">
                                 </div> -->

                  </div>
               </div>
               <!-- </div> -->
            </div>
         </div>
      </div>
   </div>
</div>

<div id="greenfield-section-template--14390924181538__1642049865b7c92687 bg1main "
   class="bg1main greenfield-section index-section home-product-carousel home-product-tab mt-4 home-fp">
   <div class="dt-sc-section-wrapper    " style="
            background-size:auto;  background-repeat:no-repeat;">
      <div class="container">
         <div class="row  product-tab">
            <div class="dt-sc-heading  text-center" style="    margin-bottom: 0px !important;">
               <div class="cont-form">
                  <h1 style="color:white;" class="dt-sc-main-heading">Featured Products</h1>
                  <!-- <div class="btn-display">
                     <a href="<?= base_url() . 'all-products?order=3' ?>" class="dt-sc-btn">View More</a>
                  </div> -->
               </div>
            </div>
            <div class="owl-slider mt-4">
               <div class="owl-slider">
                  <div class="slider_trending_now owl-carousel dt-sc-testimonial-section default swiper-wrapper"
                     id="slider_trending_now">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="greenfield-section-template--14390924181538__1642049865b7c92687 "
   class="greenfield-section index-section home-product-carousel home-product-tab mt-4 home-fp">
   <div class="dt-sc-section-wrapper    " style="
            background-size:auto;  background-repeat:no-repeat;">
      <div class="container">
         <div class="row  product-tab">
            <div class="dt-sc-heading  text-center" style="    margin-bottom: 0px !important;">
               <div class="cont-form">
                  <h1 class="dt-sc-main-heading">Recently Viewed Products</h1>
                  <!-- <div class="btn-display">
                     <a href="<?= base_url() . 'all-products?order=3' ?>" class="dt-sc-btn">View More</a>
                  </div> -->
               </div>
            </div>
            <div class="owl-slider mt-4">
               <div class="owl-slider">
                  <div class="recent_viewed_products owl-carousel dt-sc-testimonial-section default swiper-wrapper"
                     id="recent_viewed_products">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?
if(!empty($testimonial_videos)){
?>
<div id="greenfield-section-template--14390924181538__1642049865b7c92687 bg1main1 "
   class="greenfield-section index-section home-product-carousel home-product-tab mt-4 home-fp">
   <div class="dt-sc-section-wrapper    " style="
            background-size:auto;  background-repeat:no-repeat;">
      <div class="container">
         <div class="row  product-tab">
            <div class="dt-sc-heading  text-center" style="    margin-bottom: 0px !important;">
               <div class="cont-form">
                  <h1 class="dt-sc-main-heading">Testimonials</h1>
                  <!-- <div class="btn-display">
                     <a href="<?= base_url() . 'all-products?order=3' ?>" class="dt-sc-btn">View More</a>
                  </div> -->
               </div>
            </div>
            <div class="owl-slider mt-4">
               <div class="owl-slider">
                  <div class="owl-carousel dt-sc-testimonial-section default swiper-wrapper"
                     id="testimonial_videos">
                     <?php

          if(!empty($testimonial_videos)){
            $count =0;

            foreach ($testimonial_videos as $testimonial_video) {
              $count++;
              ?>
              <div class="item">
              <div class="testimonials-item">
                    <?=$testimonial_video->testimonial_video?>

                                    <h3><?=$testimonial_video->testimonial_name?></h3>
                                    <span><?=$testimonial_video->content?></span>
                                 </div>
                        </div>
              <?php
            }

          }
               ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?
}
?>
<?
if(!empty($working_methods)){
  ?>
  <div id="greenfield-section-template--14390924181538__164205117913d8ee1c"
     class="greenfield-section index-section home-support-block">
     <div class="dt-sc-section-wrapper    " style="
              background-size:auto;  background-repeat:no-repeat;">

        <div class="container mb-4">
           <div class="row home-support-block support-page">
              <div class="dt-sc-heading  text-center">
                 <div class="cont-form">
                    <h1 class="dt-sc-main-heading">Working Method</h1>
                    <div class="btn-display">
                    </div>
                 </div>
              </div>

              <!-- <div class="container"> -->
              <div class="row">
                <?php foreach ($working_methods as $working_method): ?>
                  <div class="col-lg-4 col-md-6 margin-30px-bottom xs-margin-20px-bottom">
                     <div class="services-block-three">
                        <a href="<?=  $working_method->working_method_link ?>">
                           <!-- <div class="padding-15px-bottom">

                                   </div> -->

                           <div class="col-md-12 p-4">
                              <div class="d-flex align-items-center">
                                 <div class="mr-4">
                                    <div
                                       class="p-4 rounded-circle text-white font-weight-bold d-flex align-items-center justify-content-center">
                                       <img src="<?= MAINSITE.'assets/uploads/working_method/'.$working_method->working_method_image ?>" alt="">
                                    </div>
                                 </div>
                                 <div class="">
                                    <h5 class="mb-2" style="font-weight: 600;"><?=  $working_method->content ?>
                                    </h5>
                                 </div>
                              </div>
                           </div>
                        </a>
                     </div>
                  </div>
                <?php endforeach; ?>


                 <!-- end -->
                 <!-- </div> -->
              </div>

           </div>
        </div>
     </div>
  </div>
  <?
}
?>
