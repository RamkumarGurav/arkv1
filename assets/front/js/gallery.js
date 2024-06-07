
 jQuery("#gallery").owlCarousel({
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