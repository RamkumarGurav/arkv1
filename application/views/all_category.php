<div class="products-area ">
   <div class="container">
      <div class="row">
         <? if(!empty($categories)){ ?>
         <? foreach($categories as $c){ ?>
         <div class="col-lg-12">
            <h2 class="featured-items"><?=$c->name?></h2>
            <div id="Container" class="row justify-content-center">
            <? if(empty($c->cover_image)){$c->cover_image='default_image.jpg';} ?>
               <div class="col-sm-6 col-lg-3 mix armchair center-table" style="display: inline-block;" data-bound="">
                  <div class="products-item box-cat ">
                     <a href="<?=base_url().$c->slug_url?>">
                        <div class="top">
                           <img data-src="<?=_uploaded_files_?>category//<?=$c->cover_image?>" alt="<?=$c->name?>" title="<?=$c->name?>" class="lazy">
                           <div class="inner text-center">
                              <h4><?=$c->name?></h4>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
               <? if(!empty($c->sub_category)){ ?>
                  <? foreach($c->sub_category as $ic){ ?>
                  <? if(empty($ic->cover_image)){$ic->cover_image='default_image.jpg';} ?>
                  <div class="col-sm-6 col-lg-3 mix armchair center-table" style="display: inline-block;" data-bound="">
                     <div class="products-item box-cat ">
                        <a href="<?=base_url().$c->slug_url.'/'.$ic->slug_url?>">
                           <div class="top">
                              <img data-src="<?=_uploaded_files_?>/category/<?=$ic->cover_image?>" alt="<?=$ic->name?>" title="<?=$ic->name?>" class="lazy">
                              <div class="inner text-center">
                                 <h4><?=$ic->name?></h4>
                              </div>
                           </div>
                        </a>
                     </div>
                  </div>

                     <? if(!empty($ic->super_sub_category)){ ?>
                        <? foreach($ic->super_sub_category as $ssc){ ?>
                        <? if(empty($ssc->cover_image)){$ssc->cover_image='default_image.jpg';} ?>
                        <div class="col-sm-6 col-lg-3 mix armchair center-table" style="display: inline-block;" data-bound="">
                           <div class="products-item box-cat ">
                              <a href="<?=base_url().$c->slug_url.'/'.$ic->slug_url.'/'.$ssc->slug_url?>">
                                 <div class="top">
                                    <img data-src="<?=_uploaded_files_?>/category/<?=$ssc->cover_image?>" alt="<?=$ssc->name?>" title="<?=$ssc->name?>" class="lazy">
                                    <div class="inner text-center">
                                       <h4><?=$ssc->name?></h4>
                                    </div>
                                 </div>
                              </a>
                           </div>
                        </div>
                        <? } ?>
                     <? } ?>

                  <? } ?>
               <? } ?>
            </div>
            <!-- <div class="text-center">
               <a class="common-btn" href="<?=base_url(__allCategories__)?>">
               Load More 
               <img src="<?=__scriptFilePath__?>images/shape1.png" alt="Shape">
               <img src="<?=__scriptFilePath__?>images/shape2.png" alt="Shape">
               </a>
            </div> -->
         </div>
         <? } ?>
         <? } ?>
      </div>
   </div>
</div>



<script>

window.addEventListener("load", function(){
	var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

  if ("IntersectionObserver" in window) {
    let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          let lazyImage = entry.target;
          lazyImage.src = lazyImage.dataset.src;
          lazyImage.classList.remove("lazy");
          lazyImageObserver.unobserve(lazyImage);
        }
      });
    });

    lazyImages.forEach(function(lazyImage) {
      lazyImageObserver.observe(lazyImage);
    });
  } else {
    // Possibly fall back to a more compatible method here
  }
})

</script>