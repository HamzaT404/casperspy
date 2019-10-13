// MAIN.JS
//--------------------------------------------------------------------------------------------------------------------------------
//This is main JS file that contains custom JS scipts and initialization used in this template*/
// -------------------------------------------------------------------------------------------------------------------------------
// Template Name: My Trip
// Author: Hitesh Jariwala.
// Version 1.0 - Initial Release
// Copyright: (C) 2016
// -------------------------------------------------------------------------------------------------------------------------------

/*global $:false */
/*global window: false */

(function() {
    "use strict";

    //Vieport height calculation
    var vH = $(window).height();
    $('.full-height').height(vH);

    //Vieport width calculation
    var vW = $(window).width();
    $('.full-width').width(vW);



    // Map Init
    $('.map-container').each(function () {

        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 11,
                // Zooming of map during scroll wheel movement is set to false
                scrollwheel: false,
                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(21.167416, 72.8140269), // New York

                // How you would like to style the map.
                // This is where you would paste any style found on Snazzy Maps.
                styles: [{
                    "featureType": "landscape",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 65
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "poi",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 51
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.highway",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 30
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "road.local",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 40
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "transit",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "administrative.province",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "labels",
                    "stylers": [{
                        "visibility": "on"
                    }, {
                        "lightness": -25
                    }, {
                        "saturation": -100
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{
                        "hue": "#ffff00"
                    }, {
                        "lightness": -25
                    }, {
                        "saturation": -97
                    }]
                }]
            };

            // Get the HTML DOM element that will contain your map
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map-container');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(51.507351, -0.127758),
                map: map,
                title: 'Sparklin!',
                icon: new google.maps.MarkerImage(
                    "images/map-pin.png",
                    new google.maps.Size(50, 50, "px", "px")
                )
            });
        }
    });



    $(document).ready(function(){


        // UMBG Init
        $('.background-video').each(function () {
            $(this).umbg({
                'mediaPlayerType': 'Vimeo', // YouTube, Vimeo, Dailymotion, Wistia, HTML5, Image, or Color.
                'mediaId': '84931739', // Use the video id . For HTML5 use the location and video filename.
                'audio': 0,//Mute/Unmute audio
                'displayControls': 0,//Enable/Disable player controlsClass
                'pageVisibilityPause': 1, //Pause/Play video  when minimizes the browser or moves to another window tab
                'mediaOverlayCss': 'umbg-overlay-dots4', //Add/Remove background overlay
                'mediaPoster':'images/home/home04/poster-image.jpg' //Background poster image on mobile
            });
        });



        //Shuffle Letters Init
        $('.shuffle-letter').each(function () {
            $(this).shuffleLetters({
                step: 8,			// How many times should the letters be changed
    			fps: 15
            });
        });



        //Adds Data Attribute Content
        $('.cd-intro-content').each(function () {
            var data_val = $(this).find('h2 span').html();
            $(this).find('h2').attr('data-content',data_val);
        });



        // Owl Carousel Init
        $(".animate-carousel	").each(function() {
            var animate_owl = $(this);
            $(this).owlCarousel({
                navText : [
                    "<i class='ion-ios-arrow-back'></i>",
                    "<i class='ion-ios-arrow-forward'></i>"
                ],
                callbacks: true,
                loop:true,
                margin: 0,
                autoHeight: true,
                smartSpeed: 1000,
                autoplayTimeout: $(this).data('autoplay-speed'),
                autoplay: $(this).data('autoplay'),
                dots: $(this).data('dots'),
                nav: $(this).data('nav'),
                animateIn: $(this).data('anim-in'),
                animateOut: $(this).data('anim-out'),
                items: $(this).data('items'),
                rtl: $(this).data('rtl'),
                responsive:{
                    0:{items:$(this).data('xsnumber')},
                    376:{items:$(this).data('smnumber')},
                    601:{items:$(this).data('mdnumber')},
                }
            });


            animate_owl.on('onTransitionStart',function(e){
                var content_block = $('.animate-carousel.owl-carousel .owl-item .item');
                content_block.find('.cd-intro').animate({
                    "opacity": 0
                }, 200);
            });

            animate_owl.on('onTransitionEnd',function(e){
                var content_block = $('.animate-carousel.owl-carousel .owl-item.active .item'),
                    heading = content_block.find('.cd-intro').clone();
                content_block.find('.cd-intro').remove();
                content_block.delay(200).append(heading);
                content_block.find('.cd-intro').css('opacity',1);
            });
        });



        //Owl Carousel Init /Index02 Home Style
        $('.content-animate-carousel').each(function () {
            var owl = $(this);

            // Progressbar Initialization After Slider Initialization
            owl.on('onInitBefore',function(e){
                $('#progressbar svg').remove();
                $('.progress-circle').each(function () {
                    var circle = new ProgressBar.Circle('#progressbar', {
                        color: $(this).data('color'),
                        trailColor: $(this).data('bg-color'),
                        strokeWidth: $(this).data('width'),
                        duration: 5000
                    });
                    circle.animate(1.0);
                });
            });

            owl.owlCarousel({
                smartSpeed:2000,
                dots:false,
                nav:true,
                navText : [
                    "<i class='ion-ios-arrow-back'></i>",
                    "<i class='ion-ios-arrow-forward'></i>"
                ],
                autoplay: true,
                autoplayTimeout: 5000,
                loop: true,
                autoHeight: true,
                items: 1,
                callbacks: true,
                info: getInfo
            });

            // Progressbar initialization on each owl item change
            owl.on('onChangeState',function(e){
                $('#progressbar svg').remove();
                $('.progress-circle').each(function () {
                    var circle = new ProgressBar.Circle('#progressbar', {
                        color: $(this).data('color'),
                        trailColor: $(this).data('bg-color'),
                        strokeWidth: $(this).data('width'),
                        duration: 7000
                    });
                    circle.animate(1.0);
                });
            });

            // Insert info into table
            function getInfo(i){
                var owlInfo = i,prop,value,name;
                for(prop in owlInfo){
                    if(owlInfo.hasOwnProperty(prop)){
                        value = owlInfo[prop];
                        name = prop;
                        if(prop == 'currentPosition')
                            value = value+1;
                            $('.'+name).text(value);
                    }
                }
            }
        });		
		

        // $('#baseImage').lavaLamp({
			// fx: 'easeInOutExpo',
			// speed: 700,
			// autoReturn: false,
			// homeLeft:140,setOnClick:true
		// });

        // Fit Video Init
        $(".resize-video").fitVids();

    });



    $(window).load(function() {

        function headerStyling() {

            var scroll = getCurrentScroll();
            if (scroll >= header_height) {
                $('.header-wrapper').addClass('header-animate');
            } else {
                $('.header-wrapper').removeClass('header-animate');
            }

            if (scroll >= 300) {
                $('.header-wrapper .logo-wrap').height(header_height - 20);
                $('.header-wrapper .header-content-block').height(header_height);
                $('.header-wrapper .menu-container ul.menu > li > a ').css({
                    'padding-top': '55px',
                    'padding-bottom': '30px'
                });
                setTimeout(function() {
                    menuStyle();
                }, 200);
            } else {
                $('.header-wrapper .logo-wrap').height(header_height);
                $('.header-wrapper .header-content-block').height(header_height);
                $('.header-wrapper .menu-container ul.menu > li > a ').css({
                    'padding-top': '55px',
                    'padding-bottom': '30px'
                });
                setTimeout(function() {
                    menuStyle();
                }, 200);
            }
        }



        // Hero Content Hide
        function hero_content_hide() {
            var hero_scroll = getCurrentScroll();

            if (hero_scroll >= 50) {
                $('.parallaxify-block .content-block').animate({'opacity': 0}, 500);
            } else {
                $('.parallaxify-block .content-block').animate({'opacity': 1}, 500);
            }
        }



        //Get Document Scroll Top Value
        function getCurrentScroll() {
            return window.pageYOffset || document.documentElement.scrollTop;
        }



        if (!device.tablet() && !device.mobile()) {

            // Header Styling On Desktops
            var header_height = $('.menu-container').height();
			
            $('.logo-wrap, .header-content-block').height(header_height);

            headerStyling();//Set Header Style On Page Load

            $(window).scroll(function() {
                hero_content_hide();//Hero Content Hide/Display on scroll
                headerStyling();//Change Header Style On Scroll

            });

        }else{

            //Header and Menu Styles On Touch Devices
            $('.header-wrapper').each(function () {
                var header = $(this);
                header.addClass('mobile-header');
                header.find('.menu-container').css('top', 60);
                header.find('.social-icons').css('display','none');
                header.find('.mobile-nav-container').css('display','block');

                //Mobile Nav
                header.find('.mobile-nav').on('click', function(){
                    $(this).toggleClass('open');
                    header.find('.menu-container').slideToggle('slow');
                });
                $('#master-wrap, .menu > li > a').on('click', function () {
                    if($('.mobile-nav').hasClass('open')){
                        $('.mobile-nav').trigger('click');
                    }
                    $('.menu-container li.has-dropdown').each(function () {
                        $(this).find('> ul').slideUp(500);
                        $(this).data('sub-menu-open', false);
                        $(this).removeClass('sub-menu-open');
                        $(this).find('span').removeClass('icon-rotate').removeClass('icon-active');
                    });
                });
            });
        }



        //Keep Logo Image Inside Header
        //if($('.logo-wrap img').height() > $('.logo-wrap').height()){
          //  $('.logo-wrap img').height($('.logo-wrap').height());
        //}


        //Innerpage Header Title Position Adjustment
        $('.inner-page-header .page-title').css('margin-top', $('.header-wrapper').height());



        // Menu Section
        menuStyle ();//Menu Style On Page Load

        function menuStyle() {
            var menuH = $('.menu').height();

            $('.menu-container').each(function() {
                if (!device.tablet() && !device.mobile()) {

                    //Drodown Menu Position Adjustment
                    $('.menu-container > ul.menu > li:not(.megamenu) > .dropdown').each(function() {
                        $(this).css('top', menuH);
                        var child1Width = 0;

                        if ($(this).find('.dropdown > li > .dropdown').width() !== null) {
                            child1Width = $(this).find('.dropdown').width();
                            var child2Width = $(this).find('.dropdown > li > .dropdown').width(),
                                child2offSetLeft = $(this).find('.dropdown > li > .dropdown').offset().left;

                            if (child2offSetLeft + child2Width > vW) {
                                $(this).find('.dropdown').css({
                                    'left': -child1Width + 'px'
                                });
                                $(this).find('.dropdown > li > .dropdown').css({
                                    'left': -child2Width + 'px'
                                });
                            }
                        } else if ($(this).find('.dropdown').width() !== null) {
                            var child1offSetLeft = $(this).find('.dropdown').offset().left;

                            if (child1offSetLeft + child1Width > vW) {
                                $(this).find('.dropdown').css({
                                    'left': -child1Width + 'px'
                                });
                            }
                        } else if ($(this).width() !== null) {
                            var offSetLeft = $(this).offset().left;

                            if ($(this).width() + offSetLeft > vW) {
                                $(this).css({
                                    'left': 'auto',
                                    'right': '0',
                                });
                                $(this).find('.dropdown').css({
                                    'left': -child1Width + 'px'
                                });
                            }
                        } else {

                        }
                    });

                    //set hover delay for mega menu item in case mouse is hovering on other menu items
                    (function hoverdelay() {
                        $('.menu li.has-dropdown').each(function() {
                            var $this = $(this),
                                menuTimeoutShow,
                                menuTimeoutHide;
                            $this.children('ul').css({
                                'visibility': 'hidden',
                                'opacity': 0
                            });
                            $this.on("mouseenter", function(e) {
                                if (e.type == "tap") e.stopPropagation();
                                clearTimeout(menuTimeoutShow);
                                clearTimeout(menuTimeoutHide);

                                menuTimeoutShow = setTimeout(function() {
                                    $this.addClass("hippo-menu-hovered");
                                    if ($this.hasClass("hippo-menu-hovered")) {
                                        $this.children('ul').stop().css("visibility", "visible").animate({
                                            "opacity": 1
                                        }, 200);
                                    }
                                }, 300);
                            });

                            $this.on("mouseleave", function(e) {
                                clearTimeout(menuTimeoutShow);
                                clearTimeout(menuTimeoutHide);
                                menuTimeoutHide = setTimeout(function() {
                                    $this.removeClass("hippo-menu-hovered");
                                    if (!$this.hasClass("hippo-menu-hovered")) {
                                        $this.children("ul").css({
                                            "opacity": 0,
                                            "visibility": "hidden"
                                        });
                                    }
                                }, 300);
                            });
                        });
                    })(); //end hippo menu hover function
                }
                else
                {
                    $('.menu-container li.has-dropdown > span').on('click', function() {
                        var this_menu_item = $(this).closest('li');

                        if (!this_menu_item.data('sub-menu-open')) {
                            if (this_menu_item.siblings('li').hasClass('sub-menu-open')) {
                                this_menu_item.siblings('li.sub-menu-open').find('ul').stop().slideUp(500);
                                this_menu_item.siblings('li.sub-menu-open').data('sub-menu-open', false);
                                this_menu_item.siblings('li.sub-menu-open').find('li').removeClass('sub-menu-open');
                                this_menu_item.find('span').toggleClass('icon-rotate').toggleClass('icon-active');
                                this_menu_item.siblings('li.sub-menu-open').find('li').data('sub-menu-open', false);
                                this_menu_item.siblings('li.sub-menu-open').find('span').toggleClass('icon-rotate').toggleClass('icon-active');
                                this_menu_item.siblings('li.sub-menu-open').removeClass('sub-menu-open');
                                this_menu_item.find('> .dropdown').first().stop().slideDown(500);
                                this_menu_item.addClass('sub-menu-open');
                                this_menu_item.data('sub-menu-open', true);
                            } else {
                                this_menu_item.find('> .dropdown').first().stop().slideDown(500);
                                this_menu_item.addClass('sub-menu-open');
                                this_menu_item.data('sub-menu-open', true);
                                this_menu_item.find('span').toggleClass('icon-rotate').toggleClass('icon-active');
                            }
                        } else {
                            this_menu_item.find('ul').stop().slideUp(500);
                            this_menu_item.find('li').data('sub-menu-open', false);
                            this_menu_item.removeClass('sub-menu-open');
                            this_menu_item.data('sub-menu-open', false);
                            this_menu_item.find('span').toggleClass('icon-rotate').toggleClass('icon-active');
                        }

                    });
                }
            });
        }



        // Nav Menu Item Highlight On Scroll
        setTimeout(function() {
            var page_stack = $.makeArray();
            var stack_top = 0;

            $('.main-home-menu .main-menu-item:first-child > a').parent().addClass('selectedLava');

            $('.nav-highlight').each(function() {
                var _this = $(this);
                _this.waypoint(function(direction) {
                //$('.menu li').removeClass('selectedLava1');
                //$('.main-menu-item a[href=#' + _this.attr('id') + ']').parent().addClass('selectedLava1');                
                    if (direction === 'down') {
                        $('.main-menu-item').removeClass('selectedLava');
                        $('.main-menu-item a[href=#' + _this.attr('id') + ']').parent().addClass('selectedLava');
                        stack_top = stack_top + 1;
                        page_stack[stack_top] = _this.attr('id');
                    } else {
                        stack_top = stack_top - 1;
                        $('.main-menu-item').removeClass('selectedLava');
                        $('.main-menu-item a[href=#' + page_stack[stack_top] + ']').parent().addClass('selectedLava');
                    }

                }, {
                    offset: 300
                });
            });
        }, 700);



        //Parallaxify Init
        $('.parallaxify-block').hover(
            function(){
                $.parallaxify({
					positionProperty: 'transform',
					responsive: true,
					motionType: 'natural',
					mouseMotionType: 'performance',
					motionAngleX: 70,
					motionAngleY: 70,
					alphaFilter: 0.5,
					adjustBasePosition: true,
					alphaPosition: 0.025,
				});
            },
            function(){
                $.parallaxify('destroy');
            }
        );



        //Parallaxify Block Content Animation On Window Load
        $('.parallaxify-block .content-block').css('display', 'block');



        //Section Postion On 'Scroll' Class Item Click
        $(".scroll").on('click', function() {
            var ScrollOffset = 100;
            $('.menu li').removeClass('selectedLava');
            $(this).parent().addClass('selectedLava');
            $("html, body").animate({
                scrollTop: $($(this).attr("href")).offset().top - ScrollOffset + "px"
            }, {
                duration: 1500,
                easing: "linear"
            });
            return false;
        });



        // Parallax Init
        if (!device.tablet() && !device.mobile()) {
            $('.parallax').each(function() {
                $(this).parallax("30%", 0.1); //Activating Parallax effect if non-mobile device is detected
            });
        } else {
            $('.parallax').addClass('no-parallax'); //Deactivate Parallax effect if mobile device is detected
        }



        // Slick Init
        if ($('.theme-carousel').length) {
            $('.theme-carousel').each(function() {
                var xsnumber = $(this).data('xsnumber');
                var smnumber = $(this).data('smnumber');
                var mdnumber = $(this).data('mdnumber');
                $(this).slick({
                    accessibility: false,
                    responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: mdnumber,
                        }
                    }, {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: smnumber,
                        }
                    }, {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: xsnumber,
                        }
                    }]
                });
            });
        }



        // Sync Carousel
        $('.sync-single').slick({
            prevArrow: "<div class='ion-ios-arrow-left prev'></div>",
            nextArrow: "<div class='ion-ios-arrow-forward next'></div>"
        });
        $('.sync-multi').each(function() {
            var xsnumber = $(this).data('xsnumber');
            var smnumber = $(this).data('smnumber');
            var mdnumber = $(this).data('mdnumber');
            $(this).slick({
                accessibility: false,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: mdnumber,
                    }
                }, {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: smnumber,
                    }
                }, {
                    breakpoint: 361,
                    settings: {
                        slidesToShow: xsnumber,
                    }
                }]
            });
        });



        // YT Player Init
        if (!device.tablet() && !device.mobile()) {
            // Playes video on non-mobile and non-tablet devices
            $(".video-bg.player").each(function() {
                $(this).mb_YTPlayer();
            });
        } else {

            // Get Video THumbnail Image And Add To Background Image
            $('.video-bg.player').each(function() {
                var videoSec = $(this);
                var videoSec_vLink = videoSec.data('property');
                var youtube_video_id = videoSec_vLink.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop();

                if (youtube_video_id.length == 11) {
                    videoSec.css('background-image', 'url(http://img.youtube.com/vi/' + youtube_video_id + '/hqdefault.jpg)');
                }
            });
        }



        // Shuffle Init
        setTimeout(function() {
            $('.gutter-grid, .no-gutter-grid').each(function() {
                var $grid = $(this),
                    sizer = '',
                    width = '',
                    colNo = $(this).data('col-no'),
                    gutter = $(this).data('gutter');

                //Sizer Value in Pixel
                if (gutter.indexOf('%') === -1) {
                    var gutterPixel = parseFloat(gutter, 10);
                    width = ($(this).width() - ((colNo - 1) * gutterPixel)) / colNo;
                    //Sizer in Pixel
                    $grid.find('.sizer').each(function() {
                        $(this).css({
                            'width': width + 'px',
                            'margin-left': gutterPixel + 'px'
                        });
                    });
                    //Sizer 2x in Pixel
                    $grid.find('.sizer-2x').each(function() {
                        $(this).css({
                            'width': ((width * 2) + gutterPixel) + 'px',
                            'margin-left': gutterPixel + 'px'
                        });
                    });
                    //Sizer 3x in Pixel
                    $grid.find('.sizer-3x').each(function() {
                        $(this).css({
                            'width': ((width * 3) + gutterPixel * 2) + 'px',
                            'margin-left': gutterPixel + 'px'
                        });
                    });
                }
                //Sizer Value in Percent
                else {
                    var gutterPercent = parseFloat(gutter, 10);
                    width = (100 - ((colNo - 1) * gutterPercent)) / colNo;
                    //Sizer in Percent
                    $grid.find('.sizer').each(function() {
                        $(this).css({
                            'width': width + '%',
                            'margin-left': gutterPercent + '%'
                        });
                    });
                    //Sizer in Percent
                    $grid.find('.sizer-2x').each(function() {
                        $(this).css({
                            'width': ((width * 2) + gutterPercent) + '%',
                            'margin-left': gutterPercent + '%'
                        });
                    });
                    //Sizer in Percent
                    $grid.find('.sizer-3x').each(function() {
                        $(this).css({
                            'width': ((width * 3) + gutterPercent * 2) + '%',
                            'margin-left': gutterPercent + '%'
                        });
                    });
                }

                // Set Margin Bottom
                var port_item_no = $(this).find('.shuf-item').length,
                    last_row_item_no = port_item_no % 5;

                if (last_row_item_no === 0) {
                    last_row_item_no = 5;
                }
                var margin_item_no = port_item_no - last_row_item_no;

                for (var i = last_row_item_no; i > 0; i--) {
                    $('.shuf-item:nth-child(' + port_item_no + ')').css('margin-bottom', 0);
                    port_item_no--;
                }

                sizer = $(this).find(".sizer");
                var margin = parseInt(sizer.css('margin-left'), 10);
                for (var j = margin_item_no; j > 0; j--) {
                    $('.shuf-item:nth-child(' + port_item_no + ')').css('margin-bottom', margin);
                    port_item_no--;
                }

                // Shuffle Initialization
                setTimeout(function() {
                    $grid.imagesLoaded(function() {
                        $grid.shuffle({
                            itemSelector: '.shuf-item', // the selector for the items in the grid
                            sizer: sizer,
                            speed: 750
                        });
                    });
                }, 200);

                // Shuffle Filter
                $(this).closest('.portfolio-container').find('.filter li a').on('click', function(e) {
                    e.preventDefault();
                    $('.filter li a').removeClass('active'); // set active class
                    $(this).addClass('active');
                    var groupName = $(this).attr('data-group'); // get group name from clicked item
                    $grid.shuffle('shuffle', groupName); // reshuffle grid
                });
            });

        }, 500);



        // Image LightBox Init
        $('.image-lightbox').each(function() {
            $(this).lightGallery({
                thumbnail: false,
                selector: ".image-selector"
            });
        });



        // Video LightBox Init
        $('.video-lightbox').each(function() {
            $(this).lightGallery({
                selector: ".video-selector",
                thumbnail: false,
                download: false,
                iframeMaxWidth: '50%',
                youtubePlayerParams: {
                    modestbranding: 1,
                    showinfo: 0,
                    rel: 0,
                    // controls: 0
                },
                vimeoPlayerParams: {
                    byline: 0,
                    portrait: 0,
                    color: 'A90707'
                }
            });
        });




        // Directional Hover Init
        $('.dh-container').each(function() {
            $(this).directionalHover({
                overlay: "dh-overlay", // CSS class for the overlay
                easing: "swing", // Linear or swing
                speed: 300 //Animation Speed
            });
        });




        setTimeout(function() {
            // CountTo Initialization on scroll
            $('.counter-item').each(function() {
                $(this).find('span.timer').each(function() {
                    $(this).html($(this).data('from'));
                });

                var entry = false;
                $(this).waypoint(function(direction) {
                    if (direction === 'down') {
                        if (entry === false) {
                            $('.timer').countTo({
                                speed: 5000
                            });
                            entry = true;
                        }
                    }
                }, {
                    offset: vH-200
                });
            });
        }, 2000);



        // Add Time Delay To Wow Item
        $('.wow-container').each(function() {
            var delay = 0.3;
            $(this).find('.delayed-animation').each(function() {
                $(this).attr('data-wow-delay', delay + 's');
                delay += 0.3;
            });
        });



        // Wow Animation Init
        var wow = new WOW({
            mobile: false
        });
        wow.init();




        // Add Foreground Image To Background
        $('.bg-image-carousel').each(function() {
            $(this).find('.item').each(function() {
                var bgImage = $(this).children('.bg-image').attr('src');
                $(this).css('background-image', 'url(' + bgImage + ')');
            });
        });



        // Image Content Align
        $('.image-content-align').each(function() {
            var ImgH = $(this).find('.image-height').height();
            var contentH = $(this).find('.content-height').height();

            if (contentH < ImgH) {
                $(this).find('.content-height').height(ImgH);
                $(this).find('.content-height > div').addClass('vertical-align');
            } else {
                $(this).find('.image-height').height(contentH);
                $(this).find('.image-height > div').addClass('vertical-align');
            }
        });



        // About Float Slider Height Setting
        $('.about-float-slider').each(function() {
            var block_height = $(this).find('.content-block').outerHeight();
            $(this).find('.background-block .item').height(block_height);
            $(this).find('.content-block').height(block_height-1);
        });




        // Interactive Video Block
        $('.interactive-video-block.video-bg.player').each(function() {
            var videoBlock = $(this);

            if (!device.tablet() && !device.mobile()) {

            videoBlock.on("YTPReady", function() {
                videoBlock.find('.play-button').fadeIn(500);
                videoBlock.find('.loader-image').fadeOut(500);
                videoBlock.find('.text-content').fadeIn(500);
            });

            videoBlock.find('.play-button').on('click', function() {
                videoBlock.YTPPlay();
                videoBlock.find('.pause-button, .volume-button-container').fadeIn(500);
                $(this).fadeOut(500);
                videoBlock.find('.text-content').fadeOut(500);

                videoBlock.attr('data-status', 'play');
            });

            videoBlock.find('.pause-button').on('click', function() {
                videoBlock.YTPPause();
                $(this).fadeOut(500);
                videoBlock.find('.volume-button-container').fadeOut(500);
                videoBlock.find('.play-button').fadeIn(500);
                videoBlock.find('.text-content').fadeIn(500);

                videoBlock.attr('data-status', 'pause');
            });

            videoBlock.find('.volume-off').on('click', function() {
                videoBlock.find('.volume-off').fadeOut(500);
                videoBlock.find('.volume-on').fadeIn(500);
                videoBlock.YTPUnmute();
            });

            videoBlock.find('.volume-on').on('click', function() {
                videoBlock.find('.volume-on').fadeOut(500);
                videoBlock.find('.volume-off').fadeIn(500);
                videoBlock.YTPMute();

            });

            }
            else {
                videoBlock.addClass('video-disabled');
            }
        });




        // Our Partners Height Setting
        $('.our-partners').each(function() {
            $(this).find('.partner-text').height($(this).find('.partners-carousel').height());
        });




        //Equal Height Setting
        $('.blog-content, .services-content').each(function () {
            var maxHeight = -1;
            $(this).find('.blog-item-container, .services-content-block').each(function (){
                maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
            });
            $(this).find('.blog-item-container, .services-content-block').each(function (){
                $(this).height(maxHeight);
            });
        });



        // Remove Place Holder On Focus
        $('input,textarea').focus(function() {
            $(this).data('placeholder', $(this).attr('placeholder'));
            $(this).attr('placeholder', '');
        });



        // Add Place Holder On Blur
        $('input,textarea').blur(function() {
            if ($(this).hasClass('error-msg')) {
                $(this).removeClass('error-msg');
            }
            $(this).attr('placeholder', $(this).data('placeholder'));
        });



        //To-top Position Adjustment On Scroll
        $('#master-wrap').waypoint(function(direction) {
            if (direction === 'down')
                $(".to-top").animate({
                    bottom: '40px',
                    opacity: '1'
                });
            else
                $(".to-top").animate({
                    bottom: '-40px',
                    opacity: '0'
                });
        }, {
            offset: -300
        });



        // Form Validation
        $("#contactform #submit").on('click', function() {
            //name
            var name = $("#contactform input#name").val();
            var name_base = 'Please Provide Name';

            //email (check if entered anything)
            var email = $("#contactform input#email").val();
            var email_base = 'Please Provide Valid E-mail';
            //email (check if entered anything)

            // comments
            var comments = $("#contactform textarea#message").val();
            var comments_base = 'Message must not be empty';

            function isValidEmailAddress(emailAddress) {
                var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
                return pattern.test(emailAddress);
            }

            if (name === "") {
                $("#contactform input#name").focus();
                $('#contactform input#name').attr('placeholder', name_base);
                $('#contactform input#name').addClass('error-msg');
                return false;
            } else if (email === "") {
                //$("#error").fadeIn().text("Email required");
                $("#contactform input#email").focus();
                $('#contactform input#email').attr('placeholder', email_base);
                $('#contactform input#email').addClass('error-msg');
                return false;
            } else if (email !== "") { // If something was entered
                if (!isValidEmailAddress(email)) {
                    $("#contactform input#email").focus();
                    $('#contactform input#email').val('');
                    $('#contactform input#email').attr('placeholder', email_base);
                    $('#contactform input#email').addClass('error-msg');
                    return false;
                }
            }
            if (comments === "") {
                $("#contactform textarea#message").focus();
                $('#contactform textarea#message').attr('placeholder', comments_base);
                $('#contactform textarea#message').addClass('error-msg');
                return false;
            } else {

                return true;
            }
        });

        // on success...
        function success() {
            $("#success").fadeIn();
            $("#contactForm").fadeOut();
        }



        // Contact Form Ajax Section
        $('#contactform').submit(function() {
            $('.md-content').hide();
            $('.launch_modal').trigger("click");

            $.ajax({
                type: $("#contactform").attr('method'),
                url: $("#contactform").attr('action'),
                data: $("#contactform").serialize(),
                success: function(data) {
                    if (data == 'success') {
                        $('#contactform').each(function() {
                            this.reset();
                        });

                        $('#contactform input#name').attr('placeholder', $('#contactform input#name').data('placeholder'));
                        $('#contactform input#name').removeClass('error-msg');

                        $('#contactform input#email').attr('placeholder', $('#contactform input#email').data('placeholder'));
                        $('#contactform input#email').removeClass('error-msg');

                        $('#contactform textarea#message').attr('placeholder', $('#contactform textarea#message').data('placeholder'));
                        $('#contactform textarea#message').removeClass('error-msg');

                        $('.md-content').show();
                        $('.md-close').on('click', function() {
                            $('.contact-form-wrap').fadeOut(1000);
                        });
                    } else {
                        $('.md-content').show();
                        $('.md-content h3').html('Something went wrong!');
                        $('.md-content p').html('Please try again.');
                    }
                }
            });
            return false;
        });



        // Map Container and Contact Block Height Setting
        $('.contact').each(function() {
            var address_sec_height = $(this).find('.address-block').outerHeight();
            $(this).find('.map-container').height(address_sec_height);
            $(this).find('.contact-block').height(address_sec_height * 2);
        });



        //Footer Links Block Height
        $('.footer-links').height($('.footer-right-col').height());



        // Open Pop-up New Window
        function MyPopUpWin(url, width, height) {
            var leftPosition, topPosition;
            //Allow for borders.
            leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
            //Allow for title and status bars.
            topPosition = (window.screen.height / 2) - ((height / 2) + 50);
            //Open the window.
            window.open(url, "Window2",
            "status=no,height=" + height + ",width=" + width + ",resizable=yes,left="+ leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY="+ topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
        }
        $('.open-popup-window').on('click', function() {
            var link_url = $(this).attr('href');
            MyPopUpWin(link_url , 650, 500);
            return false;
        });




        // Cursor FadeIn/FadeOut
        var timer;
        var fadeInBuffer = false;
        $('.mouse-controls-fade').mousemove(function() {
            if (!fadeInBuffer) {
                if (timer) {
                    clearTimeout(timer);
                    timer = 0;
                }
                $('.mouse-controls-fade .owl-controls, .mouse-controls-fade .progress-circle-container').fadeIn();
                $('.mouse-controls-fade').css({
                    cursor: ''
                });
            } else {
                fadeInBuffer = false;
            }

            timer = setTimeout(function() {
                $('.mouse-controls-fade .owl-controls, .mouse-controls-fade .progress-circle-container').fadeOut();
                $('.mouse-controls-fade').css({
                    cursor: 'none'
                });
                fadeInBuffer = true;
            }, 5000);
        });


        $('.body-bg-slider').each(function () {
            var vegas_item = [];
                $(this).find('.body-bg-image').each(function () {
                    vegas_item.push(this.src);
                });

            var item_length = vegas_item.length;
            var image_slides = [];
                for(var i=0; i<item_length; i++){
                    var valueToPush = { };
                    valueToPush.src = vegas_item[i];
                    image_slides.push(valueToPush);
                }

            var trans_style = $(this).find('.bg-image-wrap').data('transition');
                if(trans_style !== undefined)
                    {
                        trans_style.push("abc");
                    }

            var animation_style = $(this).find('.bg-image-wrap').data('animation');
                if(animation_style !== undefined)
                    {
                        animation_style.push("abc");
                    }

            $(this).vegas({
                delay: 8000,
                slides:image_slides,
                transitionDuration: 4000,
                transition: trans_style,
                animation: animation_style,
                animationDuration: 8000
            });
        });

    });

})();
