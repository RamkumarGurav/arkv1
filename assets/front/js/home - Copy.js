
         jQuery("#testimonial").owlCarousel({
          autoplay: true,
          rewind: true, /* use rewind if you don't want loop */
          margin: 0,
          dots:true,
           /*
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          */
          responsiveClass: true,
          autoHeight: true,
          autoplayTimeout: 7000,
          smartSpeed: 800,
          nav: true,
           loop:true,
          responsive: {
            0: {
              items: 1
            },
         
            600: {
              items: 3
            },
         
            1024: {
              items: 2
            },
         
            1366: {
              items: 3
            }
          }
         });
     
     
         jQuery("#popular").owlCarousel({
          autoplay: true,
          rewind: true, /* use rewind if you don't want loop */
          margin: 20,
          dots:true,
         
           /*
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          */
          responsiveClass: true,
          autoHeight: true,
          autoplayTimeout: 7000,
          smartSpeed: 800,
          nav: true,
           loop:true,
          responsive: {
            0: {
              items: 2
            },
         
            600: {
              items: 2
            },
         
            1024: {
              items: 4
            },
         
            1366: {
              items: 4
            }
          }
         });
     
     
         jQuery("#featured").owlCarousel({
          autoplay: true,
          rewind: true, /* use rewind if you don't want loop */
          margin: 20,
          dots:true,
          
           /*
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          */
          responsiveClass: true,
          autoHeight: true,
          autoplayTimeout: 7000,
          smartSpeed: 800,
          nav: true,
           loop:true,
          responsive: {
            0: {
              items: 2
            },
         
            600: {
              items: 2
            },
         
            1024: {
              items: 4
            },
         
            1366: {
              items: 4
            }
          }
         });
    
    
         jQuery("#categories").owlCarousel({
          autoplay: true,
          rewind: true, /* use rewind if you don't want loop */
          margin: 20,
          dots:true,
          
           /*
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          */
          responsiveClass: true,
          autoHeight: true,
          autoplayTimeout: 7000,
          smartSpeed: 800,
          nav: true,
           loop:true,
          responsive: {
            0: {
              items: 2
            },
         
            600: {
              items: 2
            },
         
            1024: {
              items: 3
            },
         
            1366: {
              items: 4
            }
          }
         });
    
	 
         document.addEventListener("DOMContentLoaded", function(){
  window.addEventListener('scroll', function() {
	  if(document.getElementById('navbar_top'))
	  {
		  if (window.scrollY > 50) {
			document.getElementById('navbar_top').classList.add('fixed-top');
			// add padding top to show content behind navbar
			navbar_height = document.querySelector('.navbar').offsetHeight;
			document.body.style.paddingTop = navbar_height + 'px';
		  } else {
			document.getElementById('navbar_top').classList.remove('fixed-top');
			 // remove padding top from body
			document.body.style.paddingTop = '0';
		  } 
	  }
  });
}); 
         $(document).ready(function() {
  $(document).scroll(function() {
        if ($(document).scrollTop() >= 25) {
          $('.navbar-brand').addClass('js-scrolling');
          $('.dt-sc-header-top-bar').addClass('js-scrolling');
        } else {
          $('.navbar-brand').removeClass('js-scrolling');
          $('.dt-sc-header-top-bar').addClass('js-scrolling');
        }
  });
});

$("#cat-slider").owlCarousel({
  autoplay: true,
  loop: true, 
  margin: 20,
   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 4000,
  smartSpeed: 800,
  nav: false,
   // navText: ["<i class='fa fa-arrow-left'></i>", "<i class='fa fa-arrow-right'></i>"],
  responsive: {
    0: {
      items: 1
    },

    600: {
      items: 1
    },

    1024: {
      items: 3
    },

    1366: {
      items: 3
    }
  }
});

function setOwlCarousel(id , d_items=4)
{
	 jQuery("#"+id).owlCarousel({
          autoplay: true,
          rewind: true, /* use rewind if you don't want loop */
          margin: 20,
          dots:true,
          
           /*
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          */
          responsiveClass: true,
          autoHeight: true,
          autoplayTimeout: 7000,
          smartSpeed: 800,
          nav: true,
           loop:true,
          responsive: {
            0: {
              items: 2
            },
         
            600: {
              items: 2
            },
         
            1024: {
              items: 4
            },
         
            1366: {
              items: 4
            }
          }
         });
		 return true;
	 $("#"+id).owlCarousel({
  autoplay: true,
  loop: true, 
  margin: 20,
   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 4000,
  smartSpeed: 800,
  nav: false,
   // navText: ["<i class='fa fa-arrow-left'></i>", "<i class='fa fa-arrow-right'></i>"],
  responsive: {
    0: {
      items: 2
    },

    600: {
      items: 2
    },

    1024: {
      items: 4
    },

    1366: {
      items: 4
    }
  }
});
	$("#news-slider").owlCarousel({
  autoplay: true,
  loop: true, 
  margin: 20,
   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 4000,
  smartSpeed: 800,
  nav: false,
   // navText: ["<i class='fa fa-arrow-left'></i>", "<i class='fa fa-arrow-right'></i>"],
  responsive: {
    0: {
      items: 2
    },

    600: {
      items: 2
    },

    1024: {
      items: 4
    },

    1366: {
      items: 4
    }
  }
});

	return false;
	//console.log(id);
	var stage_padding = false;
	var device = checkDevice();
	if(device == 'isMobile')
	{
		stage_padding = 0;
	}
	
	/*$('.'+id).owlCarousel({
	  loop: false,
	  margin: 10,
	  nav: true,
	  navText: [
		"<i class='fa fa-chevron-left'></i>",
		"<i class='fa fa-chevron-right'></i>"
	  ],
	  autoplay: true,
	  autoplayHoverPause: true,
	  responsive: {
		0: {
		  items: 1
		},
		600: {
		  items: 2
		},
		1000: {
		  items: 6
		}
	  }
	})
	
	return false;*/
	$('.'+id).owlCarousel({
	  loop: true,
	  stagePadding: stage_padding,
	  margin: 0,
	  rewindNav: true,
	  nav: true,
	  navText: [
		"<i class='fa fa-chevron-left'></i>",
		"<i class='fa fa-chevron-right'></i>"
	  ],
	  autoplay: false,
	  autoplayHoverPause: true,
	  responsive: {
		0: {
		  items: 2
		},
		500: {
		  items: 2
		},
		640: {
		  items: 3
		},
		992: {
		  items: 2
		},
		1100: {
		  items: d_items
		}
	  }
	})
}

function setOwlCarouselClient(id)
{
	//console.log(id);
	var stage_padding = false;
	var device = checkDevice();
	if(device == 'isMobile')
	{
		stage_padding = 30;
	}
	$('.'+id).owlCarousel({
	  loop: false,
	  stagePadding: stage_padding,
	  margin: 0,
	  rewindNav: true,
	  nav: true,
	  navText: [
		"<i class='fa fa-chevron-left'></i>",
		"<i class='fa fa-chevron-right'></i>"
	  ],
	  autoplay: false,
	  autoplayHoverPause: true,
	  responsive: {
		0: {
		  items: 1
		},
		500: {
		  items: 1
		},
		640: {
		  items: 1
		},
		992: {
		  items: 1
		},
		1100: {
		  items: 1
		}
	  }
	})
}

function getProducts(displayClass , classOffset , limit)
{
	//setOwlCarousel(displayClass);
	/*$searchSugg='';
	$cat_search='';
	$main_cat = '';
	$sub_cat = '';
	$super_sub_cat = '';
	$manufacturer_id = '';
	$offers = '';
	$searchSugg = '';*/
	var callFor = 'slider';
	// trending_now hot_selling_now best_sellers new_product
	var trending_now = 0;
	var d_items = 3;
	var hot_selling_now = 0;
	var best_sellers = 0;
	var new_product = 0;
	var is_related = 0;
	var product_id = '';
	var product_combination_id = '';
	
	if(displayClass == 'slider_related_products_now')
	{ 
		is_related = 1; 
		d_items = 5;
		var ids = $('.slider_related_products_now').data('val');
		var idsarr = ids.split(',');
		product_id = idsarr[0];
		product_combination_id = idsarr[1];
		var callFor = 'slider';
	}
	if(displayClass == 'slider_trending_now')
	{ trending_now = 1; }
	if(displayClass == 'slider_hot_selling_now')
	{ hot_selling_now = 1; }
	if(displayClass == 'slider_best_sellers')
	{ best_sellers = 1; }
	if(displayClass == 'slider_best_sellers_pd_page')
	{ best_sellers = 1;callFor = 'non_slider_pd'; }
	if(displayClass == 'slider_new_product')
	{ new_product = 1;var callFor = 'slider'; }
	//alert(displayClass);
	
	$.ajax({
		type: "POST",
		async: true,
		 headers: {
			'Content-Type':'application/x-www-form-urlencoded'
		},
		url:'Products/loadProductIndex',
		//dataType : "json",
	   data : {'callFor':callFor , 'classOffset':classOffset , 'limit':limit , 'trending_now':trending_now , 'hot_selling_now':hot_selling_now , 'best_sellers':best_sellers , 'new_product':new_product , 'is_related':is_related , 'order':'random' , 'product_id':product_id , 'product_combination_id':product_combination_id , 'in_stock':1},
	   success : function(result){
		$("."+displayClass).html(result);
    	if(displayClass == 'slider_best_sellers_pd_page')
    	{ }
    	else{
    	   // $('.'+displayClass).owlCarousel('destroy');
		   //console.log(displayClass+' test');
		//setOwlCarousel(displayClass);
		
		
		
		
		
		if(callFor == 'slider')
		{
	 		setOwlCarousel(displayClass , d_items);
		}
    	}
		
		if(displayClass == 'slider_related_products_now')
		{
			if(result=='NoMoreProducts')
			{
				$('.slider_related_products_now_main').hide();
			}
		}
		
		lazy_product_func();
		afterLoadProductD(classOffset);
		}
   });

}


function lazy_product_func()
{
	var lazyImages = [].slice.call(document.querySelectorAll("img.lazy_product"));

  if ("IntersectionObserver" in window) {
    let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          let lazyImage = entry.target;
          lazyImage.src = lazyImage.dataset.src;
		  var temp = lazyImage.dataset.page_count;
		  lazyImage.classList.remove("lazy_product");
		  if(temp==5)
		  {
			  //loadMoreProductFunc();
		  }
		  //console.log(temp);
          lazyImage.classList.remove("lazy_product");
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
}
lazy_product_func();

function afterLoadProductD(ids)
{
	//$('[data-toggle="tooltip"]').tooltip()
	$(".addToCartListBTN"+ids).click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});
	
	$(".addToWishlistListBTN"+ids).click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});
	
	$(".incToCartListBTN"+ids).click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		AddToCart(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});
}

/*if($("*").hasClass("footer_category"))
{
	get_footer_category();
}*/



if($("*").hasClass("slider_related_products_now"))
{
	getProducts('slider_related_products_now' , 'sr3' , 10);
}

if($("*").hasClass("slider_hot_selling_now"))
{
	getProducts('slider_hot_selling_now' , 'sr3' , 10);
}

if($("*").hasClass("slider_best_sellers"))
{
	getProducts('slider_best_sellers' , 'sr4' , 10);
}

if($("*").hasClass("slider_trending_now"))
{
	getProducts('slider_trending_now' , 'sr2' , 10);
}
if($("*").hasClass("slider_new_product"))
{
	getProducts('slider_new_product' , 'sr5' , 10);
	setOwlCarouselClient('slider_clients_say');
}


