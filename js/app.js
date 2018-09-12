


  var app = {
    isLoading: true,
    //daysOfWeek: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
		spinner: document.querySelector('.loader'),
		navmenu: document.querySelector('.main-menu'),
		container: document.querySelector('.main'),
		contentloaded: {
			slide1:	false,
			slide2:	false,
			slide3:	false,
			slide4:	false,
		}
  };

(function() {
  'use strict';
  /*****************************************************************************
   *
   * Event listeners for General UI elements
   *
   ****************************************************************************/

  document.getElementById('butRefresh').addEventListener('click', function() {
    // Refresh current content
		app.CleanHash = location.hash.substr(1);
		app.contentloaded[app.CleanHash]=false;
		app.selContentToLoad();
		// if (app.contentloaded[app.CleanHash]!=false){
		// 	app.contentloaded[app.CleanHash]=true;
		// 	app.initContent(app.CleanHash);
		// }
  });
  document.getElementById('butMenu').addEventListener('click', function() {
    app.toggleMenu();
    app.navigateMenu();
  });



	/*****************************************************************************
   *
   * functions for UI elements
   *
   ****************************************************************************/

	app.toggleMenu = function() {
		console.log('toggleMenu');
		jQuery('nav, main').toggleClass('menu-open');
	}
	app.navigateMenu = function() {
		app.Hash = location.hash;
		// console.log('navigateMenu'+ app.Hash);
		jQuery('#main-menu a').each(function(){
			jQuery(this).removeClass('current');
		});
		jQuery('#main-menu a[href="'+app.Hash+'"]').addClass('current');
	}

	/*****************************************************************************
   *
   * functions for fetching contents
   *
   ****************************************************************************/

	app.selContentToLoad = function() {
		app.CleanHash = location.hash.substr(1);
		if (!app.CleanHash) { app.CleanHash = 'slide1'; }
		app.inc = jQuery( '.swiper-slide[data-hash="'+app.CleanHash+'"]' ).attr('data-content');
		//console.log('gigi'+app.inc);

		if (app.contentloaded[app.CleanHash]==false) {
			app.isLoading = true;
			jQuery( '.swiper-wrapper').css('opacity','0');
			app.spinner.removeAttribute('hidden');
			jQuery( '.swiper-slide[data-hash="'+app.CleanHash+'"]' ).load( "_inc/"+app.inc+".php", function() {
				console.log( app.inc+" Loaded." );
				// init the gauge/content
				setTimeout(function(){
					app.initContent(app.CleanHash);
				},500);

			});
		}

	}


	app.initContent = function(whichSlide) {
		//console.log('init gauge '+whichSlide+' starting .....');
		// GAUGES:
		var in_Temp_opts = {
		  angle: -0.2, // The span of the gauge arc
		  lineWidth: 0.03, // The line thickness
		  radiusScale: 1, // Relative radius
		  pointer: {
		    length: 0, // // Relative to gauge radius
		    strokeWidth: 0, // The thickness
		    color: '#000000' // Fill color
		  },
			percentColors: [
				[0.0, "#4c75b7" ],
				[0.4, "#4c75b7" ],
				[0.5, "#a9d70b"],
				[0.6, "#a9d70b"],
				[1.0, "#ff0000"]
			],
		  limitMax: 'false',
		  strokeColor: '#444',
		  generateGradient: true,
		  highDpiSupport: true,
		};

		if (whichSlide == 'slide1') {

			var in_temp_target = document.getElementById('in_TEMPERATURE');
			var in_humi_target = document.getElementById('in_HUMIDITY');
			var in_temp_val = jQuery('#in_temp_val').text();
			var in_humi_val = jQuery('#in_humi_val').text();

			var in_Temp_gauge = new Gauge(in_temp_target).setOptions(in_Temp_opts); // create  gauge!
			var in_Humi_gauge = new Gauge(in_humi_target).setOptions(in_Temp_opts); // create  gauge!

			in_Temp_gauge.maxValue = 35; // set max gauge value
			in_Temp_gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
			in_Temp_gauge.animationSpeed = 20; // set animation speed (32 is default value)
			in_Temp_gauge.set(in_temp_val); // set actual value
			in_Humi_gauge.maxValue = 100; // set max gauge value
			in_Humi_gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
			in_Humi_gauge.animationSpeed = 20; // set animation speed (32 is default value)
			in_Humi_gauge.set(in_humi_val); // set actual value

		}	else if (whichSlide == 'slide2') {

			var out_temp_target = document.getElementById('out_TEMPERATURE');
			var out_press_target = document.getElementById('out_PRESSURE');
			// var out_humi_target = document.getElementById('out_HUMIDITY');
			var out_temp_val = jQuery('#out_temp_val').text();
			var out_press_val = jQuery('#out_press_val').text();
			// var out_humi_val = jQuery('#out_humi_val').text();

			var out_Temp_gauge = new Gauge(out_temp_target).setOptions(in_Temp_opts); // create  gauge!
			var out_Press_gauge = new Gauge(out_press_target).setOptions(in_Temp_opts); // create  gauge!
			// var out_Humi_gauge = new Gauge(out_humi_target).setOptions(in_Temp_opts); // create  gauge!

			out_Temp_gauge.maxValue = 50; // set max gauge value
			out_Temp_gauge.setMinValue(-20);  // Prefer setter over gauge.minValue = 0
			out_Temp_gauge.animationSpeed = 20; // set animation speed (32 is default value)
			out_Temp_gauge.set(out_temp_val); // set actual value
			out_Press_gauge.maxValue = 1050; // set max gauge value
			out_Press_gauge.setMinValue(950);  // Prefer setter over gauge.minValue = 0
			out_Press_gauge.animationSpeed = 20; // set animation speed (32 is default value)
			out_Press_gauge.set(out_press_val); // set actual value
			// out_Humi_gauge.maxValue = 100; // set max gauge value
			// out_Humi_gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
			// out_Humi_gauge.animationSpeed = 20; // set animation speed (32 is default value)
			// out_Humi_gauge.set(out_humi_val); // set actual value

		}

		app.contentloaded[whichSlide] = true;
		console.log(app.contentloaded);


		if (app.isLoading == true) {
			app.spinner.setAttribute('hidden', true);
			jQuery( '.swiper-wrapper' ).css('opacity','1')
			app.isLoading = false;
		}

	}




  app.appSwiper = new Swiper ('.swiper-Temperino', {
    direction: 'horizontal',
		speed: 400,
    spaceBetween: 50,
    loop: false,
		autoHeight : true,
		fadeEffect: {
    	crossFade: true
  	},
		pagination: {
	    el: '.swiper-pagination',
	    type: 'bullets',
	  },
		hashNavigation: {
	    replaceState: false,
			watchState: true,
	  },
		on: {
			init: function () {
	      /* do something */
				app.selContentToLoad();
	    },
			slideChangeTransitionEnd: function () {
				this.updateAutoHeight(1000);
				app.selContentToLoad();
	    	app.navigateMenu();
				if (jQuery('nav').hasClass('menu-open') == true) {
				 jQuery('nav, main').toggleClass('menu-open');
				}
	    },
		}
  });





  // TODO add service worker code here
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker
             .register('./service-worker.js')
             .then(function() { console.log('Service Worker Registered'); });
  }
})();
