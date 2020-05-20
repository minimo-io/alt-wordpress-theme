// General functions
var alt_menu_close = function(){
  if (jQuery("body").hasClass("menu-open")) {
    jQuery("body").removeClass("menu-open");
    jQuery("#fullscreen-menu").hide(0, function() {
        jQuery(".hide-on-menu").css("display", "none");
        jQuery(".alt-header__left__menu-trigger").html( jQuery(".alt-header__left__menu-trigger").data("menu-text") );
    }).removeClass("animated fadeIn bounceOut extrafast");
  }
};

// Modal listeners
jQuery(document).ready(function(){
  jQuery('#alt-modal').on('show.bs.modal', function () {
    alt_menu_close();
    jQuery('#alt-modal.modal .modal-dialog').removeClass("flipOutX").addClass('modal-dialog flipInX animated faster');
  });
  jQuery('#alt-modal').on('hide.bs.modal', function () {
    jQuery('#alt-modal.modal .modal-dialog').addClass('modal-dialog flipOutX animated');
  });
  // when animation ends focus on search element
  // jQuery('#alt-modal.modal .modal-dialog').on("animationend", function(){
  //   jQuery("#search-field").focus().select();
  // });
});


(function($) {
  // menu escape function
  $(document).keyup(function(e) {
       if (e.keyCode == 27) { // escape key maps to keycode `27`
         if ($("body").hasClass("menu-open")) alt_menu_close();
      }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $(".alt-header__left__menu-trigger").click(function() {
      var buddy = $("body");
      var $fullscreen_menu = $("#fullscreen-menu");
      var $menu_trigger = $(this);

      if (buddy.hasClass("menu-open")) {
        alt_menu_close();
      } else {
        $fullscreen_menu.show(0, function() {
            $(".hide-on-menu").css("display", "none");
            $(".alt-header__left__menu-trigger").html($menu_trigger.data("menu-close"));
        }).addClass("animated pulse extrafast");

          buddy.addClass("menu-open");
      }
  });
  // MORE CATS BUTTON
  $(".menu-item-button-more").click(function() {
    $(".menu-nav-primary").addClass("alt-hide");
    $(".menu-nav-secondary").removeClass("alt-hide");
    return false;
  });
  // BACK CATS BUTTON
  $(".menu-item-button-back").click(function() {
    $(".menu-nav-primary").removeClass("alt-hide");
    $(".menu-nav-secondary").addClass("alt-hide");
    return false;
  });


  $('.back-to-the-future').click(function() {
      $("html, body").animate({
          scrollTop: 0
      }, 600);
      return false;
  });

  $(window).scroll(function() {
      var height = $(window).scrollTop();
      if (height > 200) {

          $('.back-to-the-future').fadeIn(100);
          $(".alt-header").addClass("fixed-top alt-fixed-top");
          $(".alt-header__logo").addClass("alt-header-sticky-logo");
      } else {
          $('.back-to-the-future').fadeOut(100, function() {

          });
          $(".alt-header").removeClass("fixed-top alt-fixed-top");
          $(".alt-header__logo").removeClass("alt-header-sticky-logo");
      }


  });

  $(".overlay").hover(function(){
    $(".carousel-featured span.carousel-title, .badge-featured").css("opacity", "1");
  }, function(){
    $(".carousel-featured span.carousel-title, .badge-featured").css("opacity", "0.5");
  });

  $("#btn-readmore").click(function(){

    var $up = $(".post-subtitle");
    var $this = $(this);
    var status = $this.data("status");
    var original_height = $this.data("original-height");
    var speed_duration = 200;
    //$up.addClass("read-more-full");
    //$up.removeClass("read-more");

    if (status == "off"){

      if (original_height == "") {
        $this.data("original-height", $up.height());
      }

      var total_height = 0;
      $(".post-subtitle p").each(function(){
          total_height += $(this).outerHeight(true);
      });

      $up.animate({
        height: total_height
      }, {
        duration: speed_duration
      }).addClass("read-more-full");

      $this.text($this.data("text-less")).data("status", "on");


    }else if (status == "on"){

      console.log("dont");
      $up.removeClass("read-more-full");
      $up.animate({
        height: original_height+"px"
      }, {
        duration: speed_duration
      });
      console.log($up.height());

      $this.text($this.data("text-more")).data("status", "off");

    }


    return false;
  });

  // // back button
  // if (! alt_has_history() ) {
  //   $(".breadcrumb-back-button").css("visibility", "hidden");
  // }

})( jQuery );





// load more stuff
jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
	$('.btn-loadmore').click(function(){

		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': alt_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : alt_loadmore_params.current_page
		};
    // console.log(alt_loadmore_params.max_page + " / " + alt_loadmore_params.current_page);
		$.ajax({ // you can also use $.post here
			url : alt_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.html('<i class="fas fa-sync fa-spin"></i>').attr("disabled", true); // change the button text, you can also add a preloader image
			},
			success : function( data ){
				if( data ) {
          // console.log(alt_loadmore_params.max_page + " / " + alt_loadmore_params.current_page);
					button.html( '<i class="fas fa-plus"></i>' ).attr("disabled", false);
          $(".card-list").append(data); // insert new posts
					alt_loadmore_params.current_page++;
          console.log(alt_loadmore_params.max_page + " / " + alt_loadmore_params.current_page);
					if ( alt_loadmore_params.current_page == alt_loadmore_params.max_page ){
						button.remove(); // if last page, remove the button
          }
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});
});
